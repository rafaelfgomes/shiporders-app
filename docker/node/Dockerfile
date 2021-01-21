FROM node:alpine

ARG API_PORT

ENV API_PORT=${API_PORT}

WORKDIR /app

COPY ./frontend .

EXPOSE 8080

CMD [ "sh", "-c", "npm install && chmod -R 777 node_modules && npm run serve" ]