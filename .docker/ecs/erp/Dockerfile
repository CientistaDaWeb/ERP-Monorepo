# develop stage
FROM node:12.18.3 as develop-stage
WORKDIR /app
COPY ./erp/package*.json /
RUN yarn global add @quasar/cli

# build stage
FROM develop-stage as build-stage
RUN yarn
RUN quasar build

# production stage
FROM nginx:1.17.5-alpine as production-stage
COPY --from=build-stage /app/dist/spa /usr/share/nginx/html
RUN adduser -S www-data -u 1000
RUN chown www-data:www-data /usr/share/nginx/html

EXPOSE 80
CMD ["nginx", "-g", "daemon off;"]