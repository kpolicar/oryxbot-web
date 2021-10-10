#!/bin/bash

export ID=$(curl -s http://169.254.169.254/metadata/v1/id)
export PUBLIC_IPV4=$(curl -s http://169.254.169.254/metadata/v1/interfaces/public/0/ipv4/address)
export PRIVATE_IPV4=$(curl -s http://169.254.169.254/metadata/v1/interfaces/private/0/ipv4/address)

curl -X POST ":webhookUrl"
  -d '{"droplet_id": "$ID", "ip_address": "$PUBLIC_IPV4", "private_ip_address": "$PRIVATE_IPV4"}'
  -H "Content-Type: application/json"
