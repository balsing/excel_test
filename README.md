Проект создан, чтобы сравнить библиотеки для чтения Excel файла по скорости работы, потреблению памяти и возможностям
---

Прежде всего савнивается возможность правильно получить данные из таблицы и сохранить их в csv формат для дальнейшей
работы.

**В сравнениии учавствуют:**

1. [PhpSpreadsheet](https://github.com/PHPOffice/PhpSpreadsheet) (PHP)
2. [spout](https://github.com/box/spout) (PHP)
3. [simplexlsx](https://github.com/shuchkin/simplexlsx) (PHP)
4. [Excelize](https://github.com/qax-os/excelize) (Goland)
5. ToDo: [openpyxl](https://openpyxl.readthedocs.io/en/stable/) (Python)

Ключевым моментом было сравнить скорость чтения и потребление памяти

**На чём проверялось:**

- demo1.xlsx - обычный маленький файл, 24 столбец, 5 строк
- demo2.xlsx - большой файл 13 столбцов, 10001 строка
- demo3.xlsx - "маленький файл" с сюрпризом: 20 столбцов, 49 строк с данными и 950000 пустых строк

*Данные не прикладываю, т.к. в них содержится персональная информация*

**Методика:**

1. Скорость.

    Подготавливаем площадку, запускаем с командой time и смотрим время выполнения скрипта.
Конечный результат не проверялся досконально, только что он есть и что-то там внутри сохранено, похожее на ожидаемое.
2. Потребление памяти.
    
    Потребление памяти по разному определяось в PHP и go скрипте.
   1. В PHP мы смотрели на `memory_get_usage()` и `memory_get_peak_usage()`
   1. В GO мы смотрели на `Alloc` и `Sys` [подробнее здесь](https://golang.org/pkg/runtime/#MemStats)

Запускался скрипт, командой, которая продублирована в таблице и смотрелись данные. 
Запускался 2-5 раз и что-то примерно среднее вносилось в таблицу. "Вылет по памяти" включает в себя как невозможность выделить очередной чанк памяти в PHP, так и смерть скрипта от системы (kill signal 9)

**Небольшое уточнение:**

Бинарник на go мы запускали в той же среде, что и PHP, просто закинув туда файл. 
Если поднимать как отдельный сервис, то это нужно добавлять веб-сервис и т.д. 
С другой стороны, мы можем в любой проект закинуть этот бинарник, он будет отрабатывать своё и выдавать результат.

**Выводы:**    

1. Программа на go работала в среднем быстрее всех и, что важно, не падала по памяти.
2. Библиотека [simplexlsx](https://github.com/shuchkin/simplexlsx) стала самой быстрой, но требует пул памяти
3. [spout](https://github.com/box/spout) полную показала неприхотливость к памяти, но ценой этого - время выполнения
4. [PhpSpreadsheet](https://github.com/PHPOffice/PhpSpreadsheet) показала средние результаты по скорости. 
Но по опыту, смею предположить, что у неё одна из лучших совместимостей по форматам.


**Результаты:**

[PHP 7.4 - ограничение в 64Mb](./docs/result-64mb.md)

[PHP 7.4 - ограничение в 128Mb](./docs/result-128mb.md)

[PHP 7.4 - ограничение в 256Mb](./docs/result-256mb.md)


Билд файла на goland:

```CGO_ENABLED=0 GOOS=linux go build -a -installsuffix cgo -o ../build/excelize```
