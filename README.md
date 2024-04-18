#  Поднятие базы данных в Docker
```bash
docker run --name mysql -e MYSQL_ROOT_PASSWORD=admin -p 3306:3306 -d mysql
```

# Запуск миграции
1. Подключаем npm и composer install
```bash
npm install
composer install
```
2. Подключаем нашу базу данных в PhpStorm
```
login = root
password = admin
```
3. В консоли с проектом запускаем команду
```bash
php artisan migrate
```

# Подготовка проекта
```bash
php artisan key:generate
composer dump-autoload
```

# Запуск сервера
В консоли с проектом запускаем команду
```bash
php artisan serve
```

# Запуск frontend
В другой консоли с проектом запускаем команду
```bash
npm run dev
```
