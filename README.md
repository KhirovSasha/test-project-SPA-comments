# test-project-SPA-comments

copy .env.example and renamed on .env

cd src 
composer install 
npm install 

docker-compose up -d 

docker exec -it project_app bash
php artisan key:generate 

php artisan migrate
php artisan db:seed
exit

npm run dev
