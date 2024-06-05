## Instructions

Built in Laravel, you need PHP 8 to run it
- Create a database in you local environment named class_booking_api
- Create a local virtual host to test with postman, in my case "http://local.class-booking-api.com/api"
- In the root directory, place .env file (I attached it in the zipped folder in email as "env file.txt")
- Once you pulled the project, run these commands:
- composer install
- php artisan migrate:fresh
- php artisan db:seed

That’s it, now, you can interact with the API via Postman
The seeders created 1 user for you

1. gino@test.com

User password provided in zipped folder in the email I sent (in env file)

In order to test in Postman, please consume the request "Login User", with the credentials I provided, this will return a token, since every time we book a class or delete a class booking, we should do that on behalf of a user.
Just for testing purposes I'm allowing the same user to book the same class more than once.

Consume API:
I created and exported ALL the endpoints to use with Postman for you, please check the
attached zipped folder in the email “Class Booking API.postman_collection” and also “Class Booking API.postman_environment”
