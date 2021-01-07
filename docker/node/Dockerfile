FROM node:alpine

WORKDIR /app

COPY package*.json ./

RUN npm install

COPY . .

RUN if [ $NODE_ENV = "production" ] ; then appRun="build" else appRun="dev" fi
#RUN npm run build

EXPOSE 8084

CMD [ "npm", "run", "$appRun" ]