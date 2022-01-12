PHP 7.4 - ограничение в 128Mb

| Библиотека   | Файл       | Время выполнения | Потребляемая память | Скрипт запуска                                                                                                               |
|--------------|------------|----------------|---------------------|------------------------------------------------------------------------------------------------------------------------------|
| PhpSpreadsheet    | demo1.xlsx | 0.25s          | 10Mb/10Mb           | `docker-compose exec php-7-128m time php -d memory_limit=128M -f ./php/phpspreadsheet/cli.php /var/www/app/files/demo1.xlsx` |
| PhpSpreadsheet    | demo2.xlsx | Вылет по памяти | Вылет по памяти     | `docker-compose exec php-7-128m time php -d memory_limit=128M -f ./php/phpspreadsheet/cli.php /var/www/app/files/demo2.xlsx` |
| PhpSpreadsheet    | demo3.xlsx | Вылет по памяти | Вылет по памяти     | `docker-compose exec php-7-128m time php -d memory_limit=128M -f ./php/phpspreadsheet/cli.php /var/www/app/files/demo3.xlsx` |
| spout    | demo1.xlsx | -              | -                   | `docker-compose exec php-7-128m time php -d memory_limit=128M -f ./php/spout/cli.php /var/www/app/files/demo1.xlsx`          |
| spout    | demo2.xlsx | 1m 29.21s      | 4Mb/4Mb             | `docker-compose exec php-7-128m time php -d memory_limit=128M -f ./php/spout/cli.php /var/www/app/files/demo2.xlsx`          |
| spout    | demo3.xlsx | -              | -                   | `docker-compose exec php-7-128m time php -d memory_limit=128M -f ./php/spout/cli.php /var/www/app/files/demo3.xlsx`          |
| simplexlsx    | demo1.xlsx |                | -                   | `docker-compose exec php-7-128m time php -d memory_limit=128M -f ./php/simplexlsx/cli.php /var/www/app/files/demo1.xlsx`     |
| simplexlsx    | demo2.xlsx | 17s            | 22Mb/31Mb           | `docker-compose exec php-7-128m time php -d memory_limit=128M -f ./php/simplexlsx/cli.php /var/www/app/files/demo2.xlsx`     |
| simplexlsx    | demo3.xlsx | Вылет по памяти | Вылет по памяти     | `docker-compose exec php-7-128m time php -d memory_limit=128M -f ./php/simplexlsx/cli.php /var/www/app/files/demo3.xlsx`     |
| Excelize    | demo1.xlsx | -              | - (Alloc/Sys)       | `docker-compose exec php-7-128m time ./go/excelize --memory --file=./files/demo1.xlsx`                                      |
| Excelize    | demo2.xlsx | 3.68s          | 34Mb/77Mb           | `docker-compose exec php-7-128m time ./go/excelize --memory --file=./files/demo2.xlsx`                                      |
| Excelize    | demo3.xlsx | 19.75s         | 30Mb/109Mb          | `docker-compose exec php-7-128m time ./go/excelize --memory --file=./files/demo3.xlsx`                                      |