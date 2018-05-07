# rarus-bonus-server-php-sdk [![Build Status](https://travis-ci.org/rarus/bonus-server-php-sdk.svg?branch=master)](https://travis-ci.org/rarus/bonus-server-php-sdk)
# Архитектура
* Библиотека предоставляет сущности бонусного сервера в виде объектов.
* Обмен данными по сети осуществляется через транспорты, для каждой сущности он свой.
* С клиентским кодом библиотека взаимодействует с помощью DTO-объектов
* Транспорт получает и возвращает DTO-объекты или их коллекции.


## Структура сущности
```
\Entity
    \DTO
        Entity.php - DTO-объект сущности
        EntityCollection - типизированая коллекция объектов сущности, наследуется от \SplObjectStorage
        Fabric.php - фабрика сущности 
    \Transport
        Transport.php — класс транспорта сущности
        Fabric.php - фабрика транспорта сущности
    \Formatters
        Entity.php - класс, отвечающий за представление сущности в нужном виде, по умолчанию - массив
```
## Иерархия исключений
```
\Exception
    \BonusServerException - корневой тип исключения
        \ApiClientException - ошибки, связанные с логикой работы предметной области
            \NetworkException - ошибки, связанные с передачей данных по сети и работой сервера
        \UnknownException - ошибки, которые не удалось классифицировать и корректно обработать  
```
