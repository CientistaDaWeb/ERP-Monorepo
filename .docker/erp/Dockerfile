# develop stage
FROM node:14.3.0 as develop-stage
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
EXPOSE 80 443
CMD ["nginx", "-g", "daemon off;"]
