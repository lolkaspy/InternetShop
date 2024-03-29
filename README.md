### Инструкция
#### Способ №1 (Docker)
1. Скопируйте проект ```git clone https://github.com/lolkaspy/InternetShop.git```
2. Скопируйте файл ```.env.example``` в каталог проекта. Переименуйте его в ```.env```. В файл ```.env``` впишите следующие строки (либо измените значения):
```
    DB_CONNECTION=mysql
    DB_HOST=mysql
    DB_PORT=3306
    DB_DATABASE=shoppingDB
    DB_USERNAME=user
    DB_PASSWORD=password
```
3. Выполните следующие команды: ```docker compose up```
4. ```docker compose run composer install```
5. ```docker compose run npm install```
6. Затем настройте права для каталога storage в проекте: ```sudo chmod -R ugo+rw storage```
7. Введите последовательно ```docker compose run artisan key:generate``` и ```docker compose run artisan config:cache```
8. Введите ```docker compose run npm run build```, чтобы заработали стили в проекте
9. Введите ```docker compose run artisan migrate --seed```
10. Перейдите по адресу 127.0.0.1:8080
#### Способ №2 (Обычный)
1. Скопируйте проект ```git clone https://github.com/lolkaspy/InternetShop.git```
2. В терминале проекта напишите: ```composer install```
3. Скопируйте файл ```.env.example``` в каталог проекта. Переименуйте его в ```.env```. В файл ```.env``` впишите следующие строки (либо измените значения):
```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1  
    DB_PORT=3306
    DB_DATABASE=shoppingDB
    DB_USERNAME=root
    DB_PASSWORD=
```
4. Введите ```npm install```
5. Введите ```npm run build``` для отображения CSS-стилей
6. Введите последовательно ```php artisan key:generate``` и ```php artisan config:cache``` 
7. В терминале проекта напишите команду: ```php artisan migrate --seed```
8. Следом напишите команду ```php artisan serve```
9. Откройте сайт по появившемуся адресу

### Некоторые уточнения
1. Для "предобработки" заказов добавлена сущность **"Корзина"**.

2. В ```UserSeeder``` добавляется также пользователь с ролью **"Администратор"** (id = 1).

```
email: admin@a
пароль: admin
```

3. Для просмотра всех роутов: ```php artisan route:list``` или ```docker compose run artisan route:list```

4. Все необходимые зависимости для CSS и JS находятся в ```package.json```.

5. Версия PHP - **8.1.2**

6. Версия Laravel - **10.48.4**

7. Версия Ubuntu - **22.04.4 LTS**
