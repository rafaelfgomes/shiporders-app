FROM node:alpine

WORKDIR /app

RUN npm install

COPY . .

EXPOSE 8080

CMD [ "npm", "run", "serve" ]