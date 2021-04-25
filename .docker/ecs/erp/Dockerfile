# develop stage
FROM node:12.18.3 as develop-stage

RUN mkdir /app/
WORKDIR /app/
COPY ./erp/package*.json /app/
RUN ls -lha /app/

RUN yarn global add @quasar/cli

# build stage
FROM develop-stage as build-stage
RUN ls -lha /

RUN yarn install
RUN npm install @quasar/cli
RUN npx quasar build

# production stage
FROM nginx:1.17.5-alpine as production-stage
RUN mkdir /app/
WORKDIR /app/
COPY ./erp/package*.json /app/
RUN ls -lha /app/
COPY --from=build-stage /app/dist/spa /var/www/html
RUN adduser -S www-data -u 1000
RUN chown www-data:www-data /var/www/html

EXPOSE 80
CMD ["nginx", "-g", "daemon off;"]