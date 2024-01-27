# test-project-SPA-comments

copy .env.example and renamed on .env

cd src 
composer install 
npm install 

docker-compose up -d 

php artisan key:generate 

php artisan migrate
php artisan db:seed
exit

npm run dev
