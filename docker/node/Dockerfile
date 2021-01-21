FROM node:alpine

ARG API_PORT

ENV API_PORT=${API_PORT}

WORKDIR /app

COPY ./frontend/package*.json ./

RUN npm install 

COPY ./frontend .

EXPOSE 8080

CMD [ "npm", "run", "serve" ]