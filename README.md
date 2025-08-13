Subscription Platform API : This is a simple subscription platform built with Laravel that allows users to subscribe to websites and receive email notifications when new posts are published.

Features
- RESTful API endpoints for managing posts, and subscriptions
- Background email processing using queues
- Command to send new posts to subscribers
- Prevention of duplicate email notifications
- Scalable design to handle thousands of subscribers

Installation
1. Prerequisites
   - PHP 7.4 or higher
   - Composer
   - MySQL
2. Steps
   - Clone the repository: git clone https://github.com/dindarestika/SubscriptionAPI.git
   - Install dependencies: composer install
   - Create and configure the environment file: cp .env.example .env
   - Generate application key: php artisan key:generate
   - Run migrations: php artisan migrate
   - Seed sample data: php artisan make:seeder WebsiteSeeder
   - Start the development server: php artisan serve
3. Import the Postman collection:
   - File → Import → Upload file subscription-platform.postman_collection.json

API Endpoints
1. Posts
   POST /api/websites/{website}/posts - Create a new post for a website
2. Subscriptions
   POST /api/websites/{website}/subscribe - Subscribe a user to a website


Scheduled Command & Test
1. php artisan posts:dispatch-notifications
2. php artisan queue:work

Mail Configuration
- Configure your mail settings in the .env file. For local development, you can use Mailtrap or similar services.

