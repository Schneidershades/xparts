
## About Xparts Backend API

# Deployment Instructions

- clone the project by running https://github.com/Fixit45/xparts-backend-api.git on your command line.
- copy the .env by typing cp .env.example .env
- php artisan key:generate
- Fill in all the required credentials on the .env file
- run composer install
- run php artisan migrate:fresh --seed to migrate and all so seed the migrations. Press the enter key where required
- run php artisan serve

# List of external services used (e.g email, queue processor,etc)

We are using job queues for emails. we use php artisan queue:worker to execute the job queues 


# List of external APIs used and how to connect to them

# Information on architecture and design

# Code structure
The structure carries the regular Laravel design with a few folders added which are as follows:
- Traits
- Repositories

# Where to find tests & how to test the code

[Localhost URL](http://localhost:8000/api/docs)
[Staging URL](https://staging.xparts.ng/api/docs)
[Live URL](https://staging.xparts.ng/api/docs)


# Information on how to deploy to production (and any other environments if applicable)
- Use the URL server IP
- cd api.xparts.ng or staging.xparts.ng and git pull to update the repository on the server

    
# cloud service provider
Digital Ocean

# login credentials

[CAR MD](http://api.carmd.com/v3.0/decode) this is an external service for checking of vins (A substitute service for VIN decoder)
Credentials
[CAR MD](https://api.carmd.com/member/dashboard)
Email: software@fixit45.com
Password: company@2020

[VIN Decoder](https://vindecodervehicle.com/) This is the main service that helps us decode users VIN
Credentials
$id = 'azfixit45com';
$key = 'k2c7jap3bq8cv2xjqz5c9s1zl5vm';

[Paystack](https://api.paystack.co/) This service is used for payment gateways in the application. This is responsible for both deposits and withdrawals when needed.
Credentials:
The credentials can be accessed in the Paystack dashboard

[Firebase](https://firebase.google.com/) This is used for push notifications
Credentials:
Email: software@fixit45.com
Password: company@2020

[Laravel Forge](https://forge.laravel.com/) This is used for auto deployment
Credentials:
Email: software@fixit45.com
Password: company@2020


# steps involved in the deployment
- Use the URL server IP
- cd api.xparts.ng or staging.xparts.ng and git pull to update the repository on the server

# tasks manually, automated

It can be automated using Laravel forge when the subscription is active


# url to the project

[Staging URL](https://staging.xparts.ng/api/docs)
[Live URL](https://staging.xparts.ng/api/docs)


