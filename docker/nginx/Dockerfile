FROM debian:jessie

MAINTAINER Alaeddine Messadi <alaeddine.messadi@icloud.com>

RUN apt-get update && apt-get install -y \
    nginx

ADD nginx.conf /etc/nginx
ADD symfony.conf /etc/nginx/sites-available/

RUN ln -s /etc/nginx/sites-available/symfony.conf /etc/nginx/sites-enabled/symfony \
&& rm /etc/nginx/sites-enabled/default

RUN mkdir -p /var/log/nginx/ \
&& touch /var/log/nginx/symfony_error.log \
&& touch /var/log/nginx/symfony_access.log
RUN echo "upstream php-upstream { server php:9000; }" > /etc/nginx/conf.d/upstream.conf

CMD ["nginx"]

EXPOSE 80
EXPOSE 443
