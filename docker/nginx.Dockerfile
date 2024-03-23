FROM nginx:1.25.4-alpine

WORKDIR /app/public

COPY ./docker/nginx.conf /etc/nginx/nginx.conf
COPY ./public/ /app/public/
