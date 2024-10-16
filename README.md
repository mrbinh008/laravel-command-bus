# Laravel Command Bus Pattern

This project demonstrates the implementation of the Command Bus pattern in a Laravel application.

## Requirements

- PHP
- Composer
- Node.js
- Yarn

## Installation

1. Clone the repository:
    ```sh
    git clone https://github.com/mrbinh008/laravel-command-bus.git
    cd laravel-command-bus
    ```

2. Install PHP dependencies:
    ```sh
    composer install
    ```

3. Install JavaScript dependencies:
    ```sh
    yarn install
    ```

4. Copy the `.env.example` file to `.env` and modify the environment variables as needed:
    ```sh
    cp .env.example .env
    ```

5. Generate an application key:
    ```sh
    php artisan key:generate
    ```

6. Run the database migrations:
    ```sh
    php artisan migrate
    ```

## Usage

To start the development server, run: