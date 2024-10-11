# Forum Application

A simple forum application built using PHP, MySQL, and Tailwind CSS for discussions on various topics, with features like pagination, topic categories, and replies.

## Features

- List of topics with pagination
- Categories for each topic
- Topic details with the number of replies
- User avatars and post details
- Responsive design using Tailwind CSS

## Technologies Used

- **Backend**: PHP, MySQL
- **Frontend**: HTML, Tailwind CSS, FontAwesome
- **Database**: MySQL
- **JavaScript**: None required, but jQuery or similar can be added for interactivity

## Installation

### Prerequisites

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Composer (optional if using any external libraries)
- A web server like Apache or Nginx

### Steps

1. Clone the repository:
    ```bash
    git clone https://github.com/your-username/forum-app.git
    ```

2. Navigate to the project directory:
    ```bash
    cd forum-app
    ```

3. Configure your database in the `config/config.php` file:
    ```php
    $conn = new PDO('mysql:host=localhost;dbname=your_database_name', 'username', 'password');
    ```

4. Import the `forum.sql` file into your MySQL database:
    ```bash
    mysql -u username -p your_database_name < forum.sql
    ```

5. (Optional) Install any required PHP libraries using Composer:
    ```bash
    composer install
    ```

6. Start your local server (e.g., using PHP's built-in server):
    ```bash
    php -S localhost:8000
    ```

7. Open your browser and visit:
    ```
    http://localhost:8000
    ```

## Project Structure

```bash
.
├── config/             # Database configuration
├── includes/           # Header, footer, navbar includes
├── topics/             # Topic detail pages
├── img/                # User avatars
├── css/                # Custom styles (if any)
├── forum.sql           # Database schema for forum topics and replies
├── index.php           # Main entry point for the forum
└── README.md           # Project documentation
