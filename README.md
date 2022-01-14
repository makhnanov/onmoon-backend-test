# Задание:
```text
ТЗ: Необходимо реализовать сервис, выдающий текущий курс валюты и историю изменения курса через HTTP REST API,
с доступом только для авторизованных пользователей.
Фреймворк Laravel, СУБД Mysql.
требование:
1. История курсов валют должна быть на каждый день, без пропусков.
2. Объяснить, что нужно добавить или изменить, чтобы сервис мог выдержать 1500 запросов в секунду.

Проект должен разворачиваться в докере (docker-compose)

выгрузка из цб
```

## Пошаговое выполнение:
[Создание репозитория](https://github.com/makhnanov/onmoon-backend-test/)
```shell
mkdir /var/www/onmoon-backend-test && cd /var/www/onmoon-backend-test
git init
touch README.md
git add README.md
git commit -m "first commit"
git branch -M main
git remote add origin git@github.com:makhnanov/onmoon-backend-test.git
git push -u origin main
git clone https://github.com/Laradock/laradock.git
rm -rf laradock/.git
cd laradock
docker compose up nginx mysql phpmyadmin redis workspace
docker compose exec workspace bash
composer create-project laravel/laravel temp
mv temp/* ./
mv temp/.* ./
rm -rf temp/
chmod -R 777 /var/www/storage/
# Добавил JWT пакет по статье 1
# Создал миграцию для таблицы с кодами валют
# Создал консольный контроллер для заполнения таблицы с кодами
# Создал консольный контроллер для создания и заполнения таблиц с курсами
# Создал CbrfController с методом rate для получения текущего курса или истории
```

[Статья 1 про JWT](https://pacificsky.ru/frameworks/laravel/195-laravel-jwt-avtorizacija-cherez-access-token.html)

Результат сохранения в базу
```shell
root@f6f235d82c97:/var/www# php artisan save:rates
R01010 Австралийский доллар 10791 1 / 61 OK
R01015 Австрийский шиллинг 3468 2 / 61 OK
R01020A Азербайджанский манат 5859 3 / 61 OK
R01035 Фунт стерлингов Соединенного королевства 10791 4 / 61 OK
R01040F Ангольская новая кванза 703 5 / 61 OK
R01060 Армянский драм 9986 6 / 61 OK
R01090B Белорусский рубль 2025 7 / 61 OK
R01095 Бельгийский франк 3468 8 / 61 OK
R01100 Болгарский лев 10760 9 / 61 Have 1 different codes. OK
R01115 Бразильский реал 8722 10 / 61 OK
R01135 Венгерский форинт 10760 11 / 61 OK
R01200 Гонконгский доллар 8691 12 / 61 OK
R01205 Греческая драхма 3468 13 / 61 OK
R01215 Датская крона 10791 14 / 61 OK
R01235 Доллар США 10791 15 / 61 OK
R01239 Евро 8416 16 / 61 OK
R01270 Индийская рупия 10487 17 / 61 OK
R01305 Ирландский фунт 3468 18 / 61 OK
R01310 Исландская крона 6394 19 / 61 OK
R01315 Испанская песета 3468 20 / 61 OK
R01325 Итальянская лира 3468 21 / 61 OK
R01335 Казахстанский тенге 10273 22 / 61 OK
R01350 Канадский доллар 10791 23 / 61 OK
R01370 Киргизский сом 10266 24 / 61 OK
R01375 Китайский юань 10791 25 / 61 OK
R01390 Кувейтский динар 4324 26 / 61 OK
R01405 Латвийский лат 7614 27 / 61 Have 35 different codes. OK
R01420 Ливанский фунт 4324 28 / 61 OK
R01435 Литовский лит 7890 29 / 61 Have 15 different codes. OK
R01436 Литовский талон 52 30 / 61 OK
R01500 Молдавский лей 10266 31 / 61 OK
R01510 Немецкая марка 3468 32 / 61 OK
R01510A Немецкая марка Has not got data!
R01523 Нидерландский гульден 3468 34 / 61 OK
R01535 Норвежская крона 10791 35 / 61 OK
R01565 Польский злотый 10760 36 / 61 OK
R01570 Португальский эскудо 3468 37 / 61 OK
R01585 Румынский лей 8722 38 / 61 Have 3025 different codes. OK
R01585F Румынский лей 6043 39 / 61 OK
R01589 СДР (специальные права заимствования) 10760 40 / 61 OK
R01625 Сингапурский доллар 10791 41 / 61 OK
R01665A Суринамский доллар 2132 42 / 61 OK
R01670 Таджикский сомони 8873 43 / 61 Have 37 different codes. OK
R01670B Таджикский рубл 1097 44 / 61 OK
R01700J Турецкая лира 6224 45 / 61 OK
R01710 Туркменский манат 9026 46 / 61 Have 2982 different codes. OK
R01710A Новый туркменский манат 4733 47 / 61 OK
R01717 Узбекский сум 10056 48 / 61 OK
R01720 Украинская гривна 10537 49 / 61 Have 392 different codes. OK
R01720A Украинский карбованец 1269 50 / 61 OK
R01740 Финляндская марка 3468 51 / 61 OK
R01750 Французский франк 3468 52 / 61 OK
R01760 Чешская крона 10211 53 / 61 OK
R01770 Шведская крона 10791 54 / 61 OK
R01775 Швейцарский франк 10791 55 / 61 OK
R01790 ЭКЮ 2375 56 / 61 OK
R01795 Эстонская крона 6518 57 / 61 OK
R01805 Югославский новый динар 3288 58 / 61 OK
R01810 Южноафриканский рэнд 8722 59 / 61 OK
R01815 Вон Республики Корея 8722 60 / 61 OK
R01820 Японская иена 10791 61 / 61 OK
```
Проверка того что все значения в базе заполнены.
```sql
SELECT min(date), max(date), count(date) FROM `R01010`;
```

```text
Result: 1992-07-01 2022-01-15 10791
```

[Verify](https://planetcalc.ru/274/?date1=1992-07-07%2000%3A00%3A00&date2=2022-01-22%2000%3A00%3A00)

Регистрация: http://localhost/api/auth/registration \
Параметры: email, password 

Авторизация: http://localhost/api/auth/login \
Параметры: email, password 

Проверка получения приватных данных: http://localhost/api/auth/me \
Заголовок для авторизации: \
Authorization: Bearer token.from.login

Получение курса по коду: http://localhost/api/cbrf/rate \
Заголовок для авторизации: \
Authorization: Bearer token.from.login
Параметры: code, from, to

Использованные API центробанка:
[Коды](https://www.cbr.ru/scripts/XML_val.asp?d=0)
[Курсы](https://www.cbr.ru/scripts/XML_dynamic.asp?date_req1=02/03/2001&date_req2=14/03/2001&VAL_NM_RQ=R01235)

## Нагрузка
Чтобы сервис мог выдержать много запросов в секунду необходимо:
- валидацию кода валюты производить через код, а не через базу.
- использовать кеширование для выдаваемых данных
- Проверку авторизации я бы попробовал перенести с PHP backend на Nginx в соответствии со [статьей](https://habr.com/ru/post/277677/).

## Самокритика
Возможно под задачей выдавать курс без пропусков подразумевалось создание сложного SQL запроса, но я подумал что это точно не решит проблему производительности и сразу сохранял все значения по порядку.
Понимаю что это тоже можно было сделать оптимальней, но это первое решение что пришло в голову.
В Laravel я не силен, и понимаю что валидация должна делаться не внутри и "вручную", а специальными валидаторами.
Не обработал ошибки в красивом json ответе.
Также я не успел убрать всё лишнее, так как торопился закончить в пятницу как обещал.

## Тайминг
На изучение вопроса про авторизацию через nginx, понимание того что быстро это я не сделаю, а также чтение документации по Laravel я потратил 3 - 5 часов.
На написание бизнес логики 5 часов.

## Postman Collection
В файле onmoon.postman_collection.json

## Как воспроизвести у себя на компьютере
```shell
docker stop $(docker ps -aq)
git clone https://github.com/makhnanov/onmoon-backend-test.git /var/www/onmoon-backend-test
cd /var/www/onmoon-backend-test
make run-up
sudo chmod -R 777 /var/www/onmoon-backend-test
make run-composer-install
make run-migrate
make run-fill-codes
make run-fill-rates
# Далее можно протестировать в Postman
```

### Laravel README.md
<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 1500 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[Many](https://www.many.co.uk)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- **[DevSquad](https://devsquad.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[OP.GG](https://op.gg)**
- **[CMS Max](https://www.cmsmax.com/)**
- **[WebReinvent](https://webreinvent.com/?utm_source=laravel&utm_medium=github&utm_campaign=patreon-sponsors)**
- **[Lendio](https://lendio.com)**
- **[Romega Software](https://romegasoftware.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
