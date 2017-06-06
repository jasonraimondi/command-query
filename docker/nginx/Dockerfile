FROM nginx:latest

RUN mkdir -p /var/log/nginx \
    && mkdir -p /etc/nginx \
    && rm -rf /etc/nginx/conf.d/* \
    && rm -rf /var/www/html

COPY ./nginx.conf /etc/nginx/nginx.conf
ADD ./conf.d/ /etc/nginx/conf.d

EXPOSE 80 81 82 443

WORKDIR /var/www

CMD ["nginx"]
