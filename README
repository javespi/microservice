### Async microservice in PHP

#### Build microservice

$ docker build -t microservice .

#### Run dependencies

$ docker network create fellowship
$ docker run -p 15672:15672 -d --network fellowship --hostname amqp --name aragorn rabbitmq:management
$ docker run -p 3306:3306 -d --network fellowship -e MYSQL_ROOT_PASSWORD=root --name gandalf mysql:5

#### Run microservice

$ docker run -p 8200:8200 --network fellowship -it microservice:latest
