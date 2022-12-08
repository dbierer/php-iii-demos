FROM alpine:latest
RUN \
    echo "Installing basic utils ..." && \
    apk add bash
RUN \
    echo "Installing PHP + PHP-FPM ..." && \
    apk add php81 && \
    ln -s /usr/bin/php81 /usr/bin/php && \
    apk add php81-fpm
RUN \
    echo "Installing nginx ..." && \
    apk add nginx && \
    mv /etc/nginx/http.d/default.conf /etc/nginx/http.d/default.conf.old && \
    mkdir /var/www/html && \
    chown -R nginx /var/www
COPY default.conf /etc/nginx/http.d/default.conf
COPY index.php /var/www/html/index.php
COPY startup.sh /usr/sbin/startup.sh
RUN chmod +x /usr/sbin/*.sh
ENTRYPOINT /usr/sbin/startup.sh
