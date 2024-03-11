#!/bin/bash

[ ! -f /etc/oryxbot.apikey ] && curl http://169.254.169.254/metadata/v1/user-data | sh

curl -s "https://oryxbot.com/storage/releases/latest.tar.gz" | tar -xzf - -C /home/user/Applications/Oryxbot
chown -R user:user /home/user/Applications/Oryxbot
chmod -R ug+x /home/user/Applications/Oryxbot
/usr/sbin/setcap 'CAP_NET_RAW+eip CAP_NET_ADMIN+eip' /home/user/Applications/Oryxbot/OryxBot

export ID=$(curl -s http://169.254.169.254/metadata/v1/id)
export PUBLIC_IPV4=$(curl -s http://169.254.169.254/metadata/v1/interfaces/public/0/ipv4/address)
export PRIVATE_IPV4=$(curl -s http://169.254.169.254/metadata/v1/interfaces/private/0/ipv4/address)
curl "https://oryxbot.com/digitalocean/vpn?droplet_id="$ID > /etc/ppp/chap-secrets
curl -X POST "https://oryxbot.com/digitalocean/webhook" -d '{"droplet_id": "'"$ID"'", "ip_address": "'"$PUBLIC_IPV4"'", "private_ip_address": "'"$PRIVATE_IPV4"'"}' -H "Content-Type: application/json"

supervisorctl start oryxbot
