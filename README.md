# Simple Shop

This project was made as an recruitment task for [indaHash](https://indahash.com/).

It's a simple API that allows you to Add, Update or Delete a product.
All endpoints are documented with Swagger.

The app is meant to sent an email to "fake@example.com" every time you add a product, however the method that sends the email is commented because while this app has everything ready, it lacks proper Gmail configuration.
It was done in such way because the recruitment task allowed me to do everything apart from configuration.

## Installation
### 1. Create `.env` file based on `.env.example`:
```shell script
cp .env.example .env
```

### 2. Run containers:
```shell script
docker-compose up -d
```

### 3. Enter the container:
```shell script
docker exec -it simple-shop_laravel.test_1 /bin/bash
```

### 4. Fetch dependencies:
```shell script
composer install
```

### 5. Generate application key:
```shell script
 php artisan key:generate
```

### 6. Run migrations:
```shell script
 php artisan migrate
```

### 7. Generate API docs:
```shell script
 php artisan l5-swagger:generate
```

### 8. All done! You can access API docs here:

http://localhost/api/documentation


## Author:
- [Mikołaj Gawroński](https://github.com/mikolajgawronski)
