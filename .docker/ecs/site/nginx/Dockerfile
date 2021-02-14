FROM nginx:1.19.0-alpine
COPY ./site/ /var/www/html/
COPY ./.docker/ecs/site/nginx/conf.d/ /etc/nginx/conf.d/
COPY ./.docker/ecs/site/nginx/ssl/ /etc/nginx/ssl/
RUN adduser -S www-data -u 1000
RUN chown www-data:www-data /var/www/html -R