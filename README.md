# Multi-Payment Gateway Integrations With Tailwind UI

-----------------------------------------------------------------

# Steps to run in local machine

 - Clone the project
 - _cd_ into project root directory
 - Run command _composer install_ to install dependencies
 - Copy .env.example to .env
 - Replace Stripe secret keys
 - Replace Flutterwave secret keys 
 - run _php artisan key:generate_
 - Run _php artisan migrate_ to create all the table. Make sure database is already created before running this command.
 - To compile assets, run command `npm run build`.
 - Once above steps are done Run _php artisan serve_

