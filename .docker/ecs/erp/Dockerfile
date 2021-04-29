# develop stage
FROM node:12.18.3 as build-stage

WORKDIR /app
COPY ./erp /app
RUN ls -lha /app

RUN yarn global add @quasar/cli
RUN yarn install
RUN quasar build

# production stage
FROM nginx:1.17.5-alpine

WORKDIR /app/
COPY --from=build-stage /app/public /var/www/html/public
COPY ./.docker/ecs/erp/nginx/conf.d/ /etc/nginx/conf.d
RUN adduser -S www-data -u 1000
RUN chown www-data:www-data /var/www/html

EXPOSE 80
CMD ["nginx", "-g", "daemon off;"]
