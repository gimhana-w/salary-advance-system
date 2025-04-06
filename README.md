# Salary Advance System

A Laravel-based web application for managing employee salary advance requests.

## Features

- Employee Management
  - Create, read, update, and delete employee records
  - Track employee details including ID, NIC, department, position, and salary
  - Manage employee status (active/inactive)

- Salary Advance Requests
  - Employees can submit salary advance requests
  - Admins can approve or reject requests
  - Track request history and status

- Admin Dashboard
  - Overview of pending and approved requests
  - Employee management interface
  - Reports and statistics

- Employee Dashboard
  - View and submit salary advance requests
  - Track request history
  - Manage profile information

## Requirements

- PHP >= 8.1
- Composer
- MySQL/MariaDB
- Node.js & NPM (for frontend assets)

## Installation

1. Clone the repository:
```bash
git clone [repository-url]
cd salary-advance-system
```

2. Install PHP dependencies:
```bash
composer install
```

3. Install NPM dependencies:
```bash
npm install
```

4. Create environment file:
```bash
cp .env.example .env
```

5. Generate application key:
```bash
php artisan key:generate
```

6. Configure your database in `.env` file:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

7. Run migrations and seeders:
```bash
php artisan migrate --seed
```

8. Start the development server:
```bash
php artisan serve
```

9. In a separate terminal, compile assets:
```bash
npm run dev
```

## Default Admin Account

- Email: admin@example.com
- Password: password

## License

This project is licensed under the MIT License.
