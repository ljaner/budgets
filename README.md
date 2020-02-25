budgets-ddd
====

The project is made with Symfony 5.0.4

## Setup the Project

Please make sure to have docker and docker-compose installed on your local machine before proceeding

Please run the following commands

```bash
docker-compose up -d
```

```bash
docker exec -it -u dev budgets_php composer install --no-interaction
```
```bash
docker exec -it -u dev budgets_php npm install
```
```bash
docker exec -it -u dev budgets_php php bin/console doc:mig:mig
```
```bash
docker exec -it -u dev budgets_php yarn encore dev --watch &
```
## Commands

To execute commands please run the desired command followed by it's argument. 
Example:

```bash
docker exec -it -u dev budgets_php php bin/console ca:cl
```


## Testing

To test unit tests

```bash
docker exec -it -u dev budgets_php ./vendor/bin/simple-phpunit
```