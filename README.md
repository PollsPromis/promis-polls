#  Поднятие базы данных в Docker
```bash
docker run --name mysql -e MYSQL_ROOT_PASSWORD=admin -p 3306:3306 -d mysql
```

# Запуск миграции
В консоли с проектом запускаем команду
```bash
php artisan migrate
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
