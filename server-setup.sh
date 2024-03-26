export DEBIAN_FRONTEND=noninteractive;
export API_TOKEN=$(cat /etc/oryxbot.apikey)
sed -i "/#\$nrconf{restart} = 'i';/s/.*/\$nrconf{restart} = 'a';/" /etc/needrestart/needrestart.conf

useradd -m oryxbot
chown oryxbot:oryxbot /etc/oryxbot.apikey

# Update server details
{
    export ID=$(curl -s http://169.254.169.254/metadata/v1/id)
    export PUBLIC_IPV4=$(curl -s http://169.254.169.254/metadata/v1/interfaces/public/0/ipv4/address)
    export PRIVATE_IPV4=$(curl -s http://169.254.169.254/metadata/v1/interfaces/private/0/ipv4/address)

    curl "{{ app_url }}/api/v1/digitalocean/vpn?droplet_id=406370707" \
         -connect-timeout 5 \
         -H "Accept: application/json" \
         -H "Authorization: Bearer $API_TOKEN" > /etc/ppp/chap-secrets

    curl -X POST "{{ app_url }}/api/v1/digitalocean/webhook" \
         -connect-timeout 5 \
         -H "Accept: application/json" \
         -H "Authorization: Bearer $API_TOKEN" \
         -d '{"droplet_id": "'"$ID"'", "ip_address": "'"$PUBLIC_IPV4"'", "private_ip_address": "'"$PRIVATE_IPV4"'"}' -H "Content-Type: application/json"
} &


# Install java
nohup sh -c " \
wget https://download.java.net/openjdk/jdk7u75/ri/openjdk-7u75-b13-linux-x64-18_dec_2014.tar.gz -O /tmp/openjdk-7u75-b13-linux-x64-18_dec_2014.tar.gz && \
tar -xzf /tmp/openjdk-7u75-b13-linux-x64-18_dec_2014.tar.gz -C /etc && \
rm /tmp/openjdk-7u75-b13-linux-x64-18_dec_2014.tar.gz" &

#.NET 5.0 (https://docs.microsoft.com/en-us/dotnet/core/install/linux-ubuntu#2004-)
wget https://packages.microsoft.com/config/ubuntu/20.04/packages-microsoft-prod.deb -O /tmp/packages-microsoft-prod.deb
dpkg -i /tmp/packages-microsoft-prod.deb
rm /tmp/packages-microsoft-prod.deb

wget http://archive.ubuntu.com/ubuntu/pool/main/o/openssl/libssl1.1_1.1.1f-1ubuntu2_amd64.deb -O /tmp/libssl1.1_1.1.1f-1ubuntu2_amd64.deb
dpkg -i /tmp/libssl1.1_1.1.1f-1ubuntu2_amd64.deb
rm /tmp/libssl1.1_1.1.1f-1ubuntu2_amd64.deb

apt-get update -yq;

apt-get install -yq apt-transport-https
apt-get install -yq dotnet-runtime-5.0



# PPTP VPN Server (https://www.linuxbabe.com/linux-server/setup-your-own-pptp-vpn-server-on-debian-ubuntu-centos, https://www.digitalocean.com/community/tutorials/how-to-setup-your-own-vpn-with-pptp)

apt-get install pptpd -yq

echo -e "$VPN_USERNAME\t*\t$VPN_PASSWORD\t\t*" > /etc/ppp/chap-secrets
echo -e "localip 10.0.0.1\nremoteip 10.0.0.100-200\nconnections 1" >> /etc/pptpd.conf
echo -e "ms-dns 8.8.8.8\nms-dns 8.8.4.4" >> /etc/ppp/pptpd-options
echo "net.ipv4.ip_forward=1" >> /etc/sysctl.conf
sysctl -p

apt-get install -yq iptables-persistent
iptables -t nat -A POSTROUTING -o eth0 -j MASQUERADE && iptables-save > /etc/iptables/rules.v4
systemctl start pptpd
systemctl enable pptpd

# Needed (https://github.com/dotnet/dotnet-docker/issues/618)
apt-get install -yq --allow-unauthenticated \
        libc6-dev \
        libgdiplus \
        libx11-dev \
     && rm -rf /var/lib/apt/lists/*

apt-get update -yq;
apt-get install -yq xdotool
apt-get install -yq supervisor

# Prepare directory
mkdir -p /home/oryxbot/apps/Oryxbot
chown oryxbot:oryxbot -R /home/oryxbot/

# Always run oryxbot
echo -e "[program:oryxbot]\ncommand=dotnet /home/oryxbot/apps/Oryxbot/OryxBot.dll\nnumprocs=1\nautostart=false\nautorestart=true\nuser=root\nstdout_logfile=/home/oryxbot/apps/Oryxbot/output.log\nstdout_logfile_maxbytes=1MB\nstdout_logfile_backups=10\nstdout_capture_maxbytes=1MB\nstderr_logfile=/home/oryxbot/apps/Oryxbot/error.log\nstderr_logfile_maxbytes=1MB\nstderr_logfile_backups=10\nstderr_capture_maxbytes=1MB" > /etc/supervisor/conf.d/oryxbot.conf
service supervisor restart

bash -c "$(curl -L https://setup.vector.dev)"
apt-get install vector
base64 -d <<< "{{ vector_config_base64 }}" > /etc/vector/vector.yaml
systemctl enable vector.service

echo "Finished Setup Process"
