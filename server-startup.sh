#!/bin/bash

export API_TOKEN=$(cat /etc/oryxbot.apikey)

supervisorctl stop oryxbot

# Install Oryxbot
mkdir -p /home/oryxbot/apps/Oryxbot
curl -s "{{ app_url }}/storage/releases/latest" \
     -H "Authorization: Bearer $API_TOKEN" | tar -xf -C /home/oryxbot/apps/Oryxbot
chmod -R ug+x /home/user/Applications/Oryxbot/OryxBot

# Install VPC client
mkdir -p /home/oryxbot/apps
curl -s "{{ app_url }}/storage/vpc-releases/latest" \
     -H "Authorization: Bearer $API_TOKEN" -o /home/oryxbot/apps/VncClient.jar

# Oryxbot folder permissions
chown oryxbot:oryxbot -R /home/oryxbot/

# Give net capture right to script file
setcap 'CAP_NET_RAW+eip CAP_NET_ADMIN+eip' /home/oryxbot/apps/Oryxbot/OryxBot
setcap 'CAP_NET_RAW+eip CAP_NET_ADMIN+eip' /home/oryxbot/apps/Oryxbot/OryxBot.dll

supervisorctl start oryxbot

# Update server details
export ID=$(curl -s http://169.254.169.254/metadata/v1/id)
export PUBLIC_IPV4=$(curl -s http://169.254.169.254/metadata/v1/interfaces/public/0/ipv4/address)
export PRIVATE_IPV4=$(curl -s http://169.254.169.254/metadata/v1/interfaces/private/0/ipv4/address)

curl "http://oryxbot.test/api/v1/digitalocean/vpn?droplet_id=406370707" \
     -H "Accept: application/json" \
     -H "Authorization: Bearer $API_TOKEN" > /etc/ppp/chap-secrets

curl -X POST "http://oryxbot.test/api/v1/digitalocean/webhook" \
     -H "Accept: application/json" \
     -H "Authorization: Bearer $API_TOKEN" \
     -d '{"droplet_id": "'"$ID"'", "ip_address": "'"$PUBLIC_IPV4"'", "private_ip_address": "'"$PRIVATE_IPV4"'"}' -H "Content-Type: application/json"
