FROM httpd:2.4.48

# Copy apache vhost file to proxy php requests to php-fpm container
COPY apache.conf /usr/local/apache2/conf/lavoixduvote.apache.conf

RUN echo "Include /usr/local/apache2/conf/lavoixduvote.apache.conf" \
    >> /usr/local/apache2/conf/httpd.conf
