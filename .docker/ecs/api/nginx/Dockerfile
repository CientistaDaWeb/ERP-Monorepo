FROM nginx:1.19.0-alpine
COPY ./api/ /var/www/html/
COPY ./.docker/ecs/api/nginx/conf.d/ /etc/nginx/conf.d/
COPY ./.docker/ecs/api/nginx/ssl/ /etc/nginx/ssl/
RUN adduser -S www-data -u 1000
RUN chown www-data:www-data /var/www/html -R