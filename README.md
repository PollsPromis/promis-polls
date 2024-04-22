#  Поднятие базы данных в Docker
```bash
docker run --name postgres -e POSTGRES_PASSWORD=postgres -p 5432:5432 -d postgres
```

# Запуск миграции
1. Подключаем npm и composer install
```bash
npm install
composer install
```
2. Подключаем нашу базу данных в PhpStorm
```
login = postgres
password = postgres
```

2.1.
Заходим в файл php.ini и вставляем туда такие настройки
```
extension=pdo_pgsql
extension=pgsql
```
3. В консоли с проектом запускаем команду
```bash
php artisan migrate
```
3.1. Добавить seed
```bash
php artisan db:seed
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
