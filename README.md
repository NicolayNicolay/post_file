# Отправка и прием файлов с различными проверками
Реализация скриптов осуществлялась без сторонних библиотек, средствами php. Используется пространство имен
Для отсеивания сторонних запросов будем использовать пару публичный-приватный ключ. Данный метод кодировки данных является наиболее безопасным. В рамках тестового проекта кодируется Low security token закодированный через пару публичный-приватный ключ, при рабочих вариантах стоит кодировать данные. 
Для проверки целостности файла было принято решение использовать функцию хэширования файла - hash_file(), с кодировкой - sha256, crypt для кпритографии и hash_equals() на стороне сравнения при принятия данных.  
# В рамках задачи использовалась версия PHP - 8.1
# Аналоги вышеупомянутой функции в рамках данной задачи:
Каждый метод использования Хэша взаимозаменяем
1) sha1_file - https://www.php.net/manual/ru/function.sha1-file.php
2) md5_file - https://www.php.net/manual/ru/function.md5-file.php
3) crc32 - https://www.php.net/manual/ru/function.crc32.php (имеет место быть при размере файла менее 2ГБ)
