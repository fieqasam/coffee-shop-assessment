# Coffee Shop API Assessment

## Getting Started

These instructions will guide you through setting up and running the project on your local machine after unzipping the files.

## pre-requisites

Make sure you have the following software installed on your computer:

- PHP 8.0 or higher
- Composer
- MySQL

## Installation Steps
1. Open your terminal and navigate to the project folder: After unzipping, open your terminal and navigate to the project folder:
   <pre> cd path/to/coffee-shop-qune-app  </pre>
2. Laravel Setup:
   <pre> composer install  </pre>
   <pre> composer require laravel/sanctum  </pre>
3. Create a copy of environment file:
    <pre> cp .env.example .env  </pre>
4. Environment Configuration
   <pre>
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=coffee_shop
    DB_USERNAME=your_username
    DB_PASSWORD=your_password
   </pre>
5. Run Migration and Seeders
   <pre>
    php artisan migrate
    php artisan db:seed
    php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
   </pre>
6. Start the Server
   <pre>php artisan serve</pre>
   
## API Flow 
1. Register new user -> Get token
   <pre>POST /api/register</pre>
2. Login existing user -> Get token
   <pre>POST /api/login</pre>
3. Use token in <pre>Authorization: Bearer {token}</pre> header for all requests:
   <pre>
       POST /api/orders/add-order
       GET /api/orders/list-order
       GET /api/orders/sales/drink-type
       GET /api/orders/sales/size
   </pre>

## Sample API Endpoints
All tge API endpoints now require authentication. You need to register/login first to get an access token.

1. Register User
   <pre>
    POST /api/register
    Content-Type: application/json
    Accept: application/json
    
    {
        "name": "John Doe",
        "email": "john@example.com",
        "password": "password123",
    }
   </pre>
   Response
   <pre>
       {
            "message": "User registered successfully",
            "user": {
                "name": "John Doe",
                "email": "john@example.com",
                "updated_at": "2025-08-10T03:34:28.000000Z",
                "created_at": "2025-08-10T03:34:28.000000Z",
                "id": 2
            },
            "token": "3|7kNHY.......",
            "token_type": "Bearer"
        }
   </pre>
2. Login
   <pre>
    POST /api/login
    Content-Type: application/json
    
    {
        "email": "john@example.com",
        "password": "password123"
    }
   </pre>
   Response
   <pre>
    {
        "user": {
            "id": 2,
            "name": "John Doe",
            "email": "john@example.com",
            "created_at": "2025-08-10T03:34:28.000000Z",
            "updated_at": "2025-08-10T03:34:28.000000Z"
        },
        "token": "4|WcyxJ...",
        "token_type": "Bearer"
    }
   </pre>
3. Add Orders
   <pre>
    POST /api/orders
    Authorization: Bearer {your_token}
    Content-Type: application/json
    
    {
        "drink_name": "Cappuccino",
        "size": "venti", 
        "quantity": 2,
        "temperature": "cold"
    }
   </pre>
   Response
   <pre>
    {
        "message": "Order created successfully",
        "data": {
            "id": 5,
            "user_id": 1,
            "drink_name": "Cappuccino",
            "size": "venti",
            "quantity": 2,
            "unit_price": "4.15",
            "total_price": "8.30",
            "temperature": "cold",
            "order_time": "2025-08-10 03:41:02",
            "drink": {
                "id": 3,
                "type": "coffee"
            }
        }
    }
   </pre>


  
