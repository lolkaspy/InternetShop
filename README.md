### Инструкция
1. Скопируйте проект **git clone https://github.com/lolkaspy/InternetShop.git**
2. В терминале проекта напишите: **composer install**
3. В файл .env впишите следующие строки (либо измените значения):

    DB_CONNECTION=mysql
       
    DB_HOST=127.0.0.1
      
    DB_PORT=3306
       
    DB_DATABASE=shoppingDB
       
    DB_USERNAME=root
      
    DB_PASSWORD=
4. Введите **npm run build** для отображения CSS-стилей
5. В терминале проекта напишите команду: **php artisan migrate --seed**
6. Следом напишите команду **php artisan serve**
7. Откройте сайт по появившемуся адресу

### Некоторые уточнения
Для "предобработки" заказов добавлена сущность "Корзина".

В UserSeeder добавляется также пользователь с ролью "Администратор" (id = 1).

Для просмотра всех роутов: **php artisan route:list**
