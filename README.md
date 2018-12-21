### User management system (API)

InterNations coding challenge for Backend Developer position.

##### Requirements

- PHP 7.2.0+
- Ctype PHP Extension
- iconv PHP Extension
- JSON PHP Extension
- OpenSSL PHP Extension
- PDO PHP Extension

##### Installation Instructions

1. Run `composer install`
2. Change `DATBASE_URL` to match with your database username, password and database name.
3. Run `bin/console doctrine:migrations:migrate`
4. Run `bin/console doctrine:fixtures:load  --append`
5. Run `mkdir config/jwt`
6. Run `openssl genrsa -out config/jwt/private.pem 4096`
7. Run `openssl rsa -pubout -in config/jwt/private.pem -out config/jwt/public.pem`

##### API Documentation
Admin Username: `admin`
Admin Password: `secret123`

[Postman Documentation](https://documenter.getpostman.com/view/188228/RzfniRMK)
