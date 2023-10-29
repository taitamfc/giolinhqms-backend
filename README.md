# Sau khi clone về
### Tạo file env, sau đó cấu hình CSDL
cp .env.example .env
### Cài đặt thư viện
composer install
### Chạy database và seed
php artisan migrate --seed
### Tạo key cho dự án
php artisan key:generate
### Tạo thư mục
php artisan storage:link
### Chạy ứng dụng
php artisan ser