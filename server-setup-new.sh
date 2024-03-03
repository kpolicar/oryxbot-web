sudo useradd -m oryxbot


#.NET 5.0 (https://docs.microsoft.com/en-us/dotnet/core/install/linux-ubuntu#2004-)
wget https://packages.microsoft.com/config/ubuntu/20.04/packages-microsoft-prod.deb -O /tmp/packages-microsoft-prod.deb
sudo dpkg -i /tmp/packages-microsoft-prod.deb
rm /tmp/packages-microsoft-prod.deb

wget http://archive.ubuntu.com/ubuntu/pool/main/o/openssl/libssl1.1_1.1.1f-1ubuntu2_amd64.deb
sudo dpkg -i libssl1.1_1.1.1f-1ubuntu2_amd64.deb


sudo apt-get update; \
  sudo apt-get upgrade -y; \
  sudo apt-get install -y apt-transport-https && \
  sudo apt-get update && \
  sudo apt-get install -y dotnet-runtime-5.0



# PPTP VPN Server (https://www.linuxbabe.com/linux-server/setup-your-own-pptp-vpn-server-on-debian-ubuntu-centos, https://www.digitalocean.com/community/tutorials/how-to-setup-your-own-vpn-with-pptp)

apt-get install pptpd -y

(export USERNAME=admin PASSWORD=password && echo -e "$USERNAME\t*\t$PASSWORD\t\t*") > /etc/ppp/chap-secrets
echo -e "localip 10.0.0.1\nremoteip 10.0.0.100-200\nconnections 1" >> /etc/pptpd.conf
echo -e "ms-dns 8.8.8.8\nms-dns 8.8.4.4" >> /etc/ppp/pptpd-options
echo "net.ipv4.ip_forward=1" >> /etc/sysctl.conf
sysctl -p

apt-get install iptables-persistent -y
iptables -t nat -A POSTROUTING -o eth0 -j MASQUERADE && iptables-save > /etc/iptables/rules.v4
systemctl start pptpd
systemctl enable pptpd

#Give net capture right to script file
sudo /usr/sbin/setcap 'CAP_NET_RAW+eip CAP_NET_ADMIN+eip' ./OryxBot

# Needed (https://github.com/dotnet/dotnet-docker/issues/618)
apt-get update \
    && apt-get install -y --allow-unauthenticated \
        libc6-dev \
        libgdiplus \
        libx11-dev \
     && rm -rf /var/lib/apt/lists/*

# Install java
sudo apt install default-jre -y

apt-get install -y xdotool
apt install supervisor

#https://www.unixtutorial.org/disable-sleep-on-ubuntu-server/
systemctl mask sleep.target suspend.target hibernate.target hybrid-sleep.target

echo -e "[program:oryxbot]\ncommand=dotnet /home/oryxbot/apps/Oryxbot/OryxBot.dll\nnumprocs=1\nautostart=false\nautorestart=true\nuser=oryxbot\nstdout_logfile=/home/oryxbot/apps/Oryxbot/output.log\nstdout_logfile_maxbytes=1MB\nstdout_logfile_backups=10\nstdout_capture_maxbytes=1MB\nstderr_logfile=/home/oryxbot/apps/Oryxbot/error.log\nstderr_logfile_maxbytes=1MB\nstderr_logfile_backups=10\nstderr_capture_maxbytes=1MB" > /etc/supervisor/conf.d/oryxbot.conf
