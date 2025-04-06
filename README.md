# Employee Salary Advance Request System

A web application for managing employee salary advance requests built with Laravel.

## Features

- Employee Portal for submitting salary advance requests
- Admin Dashboard for request management
- SMS notifications via SendX.lk gateway
- Secure authentication and data encryption
- Responsive design for desktop and mobile
- Audit trail for tracking actions

## Requirements

- PHP >= 8.1
- Composer
- MySQL
- Node.js & NPM
- SendX.lk API account

## Installation

1. Clone the repository
2. Install PHP dependencies:
```bash
composer install
```

3. Install NPM dependencies:
```bash
npm install
```

4. Copy .env.example to .env and configure:
```bash
cp .env.example .env
```

5. Generate application key:
```bash
php artisan key:generate
```

6. Configure database settings in .env

7. Run migrations:
```bash
php artisan migrate
```

8. Configure SendX.lk SMS gateway credentials in .env:
```
SENDX_API_KEY=your_api_key
SENDX_SENDER_ID=your_sender_id
```

9. Start the development server:
```bash
php artisan serve
```

## Technology Stack

- Backend: Laravel (PHP Framework)
- Frontend: Blade templating, HTML, CSS, JavaScript
- Database: MySQL
- SMS Gateway: SendX.lk
- Hosting: Hosinger server

## Development Timeline

- Phase 1: Planning & Design (2-3 days)
- Phase 2: Development (5-7 days)
- Phase 3: Testing & Deployment (2-3 days)
- Phase 4: Support & Maintenance (Ongoing)

## License

[MIT License](LICENSE.md)
