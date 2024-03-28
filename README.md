### Инструкция
1. Скопируйте проект **git clone https://github.com/lolkaspy/InternetShop.git**
2. В терминале проекта напишите: **composer install**
3. Скопируйте файл **.env.example** в каталог проекта. Переименуйте его в **.env**. В файл **.env** впишите следующие строки (либо измените значения):

    DB_CONNECTION=mysql
       
    DB_HOST=127.0.0.1
      
    DB_PORT=3306
       
    DB_DATABASE=shoppingDB
       
    DB_USERNAME=root
      
    DB_PASSWORD=
4. Введите **npm install**
5. Введите **npm run build** для отображения CSS-стилей
6. Введите последовательно **php artisan key:generate** и **php artisan config:cache**   
7. В терминале проекта напишите команду: **php artisan migrate --seed**
8. Следом напишите команду **php artisan serve**
9. Откройте сайт по появившемуся адресу

### Некоторые уточнения
1. Для "предобработки" заказов добавлена сущность "Корзина".

2. В UserSeeder добавляется также пользователь с ролью "Администратор" (id = 1).

3. Для просмотра всех роутов: **php artisan route:list**

4. Все необходимые зависимости для CSS и JS находятся в **package.json**.

5. Версия PHP - **8.1.2**

6. Версия Laravel - **10.48.2**

7. Версия Ubuntu - **22.04.4 LTS**
