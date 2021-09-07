# Simple Shop

This project was made as an recruitment task for [indaHash](https://indahash.com/).

It's a simple API that allows you to Add, Update or Delete a product.
All endpoints are documented with Swagger.

The app is meant to sent an email to "fake@example.com" every time you add a product, however the method that sends the email is commented because while this app has everything ready, it lacks proper Gmail configuration.
It was done in such way because the recruitment task allowed me to do everything apart from configuration.

The project was made using the Laravel Framework.

### Generate API docs:
```shell script
 php artisan l5-swagger:generate
```

### You can access API docs here:

http://localhost/api/documentation


## Author:
- [Mikołaj Gawroński](https://github.com/mikolajgawronski)
