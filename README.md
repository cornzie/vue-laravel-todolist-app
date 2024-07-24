This project includes a Vue.js frontend and a Laravel backend. Follow these instructions to set up and run both applications locally.

# 1. Clone the Repository

First, clone the repository from GitHub:

```
git clone https://github.com/cornzie/vue-laravel-todolist-app.git
```

# 2. Navigate to the Project Directory

Change into the project directory:

```
cd vue-laravel-todolist-app
```

# 3. Set Up the Vue.js Frontend

The Vue.js application is located in the todo directory. Follow these steps to set it up:

- Navigate to the Vue.js Directory:

```
cd todo
```

- Install Dependencies:

Use npm to install the required dependencies:

```
npm install
```
- Run the Vue.js Application:
Start the Vue.js development server:

```
npm run dev
```

By default, the Vue.js app will be available at http://localhost:5174/. You can follow the vite provided link if necessary

# 4. Set Up the Laravel Backend

The Laravel backend is located in the todo-api directory. Follow these steps to set it up:

- Navigate to the Laravel Directory:

```
cd ../todo-api
```

- Install Dependencies:

Use Composer to install the required PHP dependencies:

```
composer install
```

- Set Up the Environment File:

Copy the example environment file and configure it:

```
cp .env.example .env
```

Edit the .env file to configure your database and other environment settings. For example:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=todo_db
DB_USERNAME=root
DB_PASSWORD=
```

- Generate Application Key:

Generate the application key:

```
php artisan key:generate
```

- Run Migrations:

Run database migrations to set up the database schema:

```
php artisan migrate
```

- Seed the Database (Optional):

You can populate the database with initial data:

```
php artisan db:seed
```

- Run the Laravel Application:

Start the Laravel development server:

```
php artisan serve
```

By default, the Laravel API will be available at http://localhost:8000. You can adjust the configuration if necessary.

# 5. Testing the Setup

With both the Vue.js frontend and the Laravel backend running, you can:

Open the Vue.js Application:

Navigate to http://localhost:3000 in your web browser to view the Vue.js application.

