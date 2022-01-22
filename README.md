
## About Xparts Backend API

# Deployment Instructions

- clone the project by running https://github.com/Fixit45/xparts-backend-api.git on your command line.
- copy the .env by typing cp .env.example .env
- php artisan key:generate
- Fill in all the required credentials on the .env file
- run composer install
- run php artisan migrate:fresh --seed to migrate and all so seed the migrations. Press the enter key where required
- run php artisan serve

## Access 

[Localhost URL](http://localhost:8000/api/docs)
[Staging URL](https://staging.xparts.ng/api/docs)
[Live URL](https://staging.xparts.ng/api/docs)

