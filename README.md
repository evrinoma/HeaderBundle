# Configuration

# CQRS model

Actions в контроллере разбиты на две группы создание, редактирование, удаление данных

        1. putAction(PUT), postAction(POST), deleteAction(DELETE), registryAction(POST)

получение данных

        2. criteriaAction(GET)

каждый метод работает со своим менеджером

        1. CommandManagerInterface
        2. QueryManagerInterface

При переопределении штатного класса сущности, дополнение данными осуществляется декорированием, с помощью MediatorInterface

группы сериализации

    1. API_GET_HEADER, API_CRITERIA_HEADER - получение заголовков
    2. API_POST_HEADER - создание заголовков
    3. API_PUT_HEADER -  редактирование заголовков

# Статусы:

    получение:
        заголовок(ки) найдены HTTP_OK 200
    ошибки:
        если заголовок не найден HeaderNotFoundException возвращает HTTP_NOT_FOUND 404
        если заголовок не прошел валидацию HeaderInvalidException возвращает HTTP_UNPROCESSABLE_ENTITY 422
        все остальные ошибки возвращаются как HTTP_BAD_REQUEST 400

# Constraint

## Description
Формат ответа от сервера содержит статус код и имеет следующий стандартный формат
```text
    [
        TypeModel::TYPE => string,
        PayloadModel::PAYLOAD => array,
        MessageModel::MESSAGE => string,
    ];
```
где
TYPE - типа ответа

    ERROR - ошибка
    NOTICE - уведомление
    INFO - информация
    DEBUG - отладка

MESSAGE - от кого пришло сообщение
PAYLOAD - массив данных

## Notice

показать проблемы кода

```bash
vendor/bin/php-cs-fixer fix --config=.php-cs-fixer.dist.php --verbose --diff --dry-run
```

применить исправления

```bash
vendor/bin/php-cs-fixer fix --config=.php-cs-fixer.dist.php
```

# Тесты:

    COMPOSER_NO_DEV=0 composer install

### run all tests

    /usr/bin/php vendor/phpunit/phpunit/phpunit --bootstrap src/Tests/bootstrap.php --configuration phpunit.xml.dist src/Tests --teamcity

### run personal test for example testPost

    /usr/bin/php vendor/phpunit/phpunit/phpunit --bootstrap src/Tests/bootstrap.php --configuration phpunit.xml.dist src/Tests/Functional/Controller/ApiControllerTest.php --filter "/::testPost( .*)?$/" 

## Thanks

## Done

## License
    PROPRIETARY
