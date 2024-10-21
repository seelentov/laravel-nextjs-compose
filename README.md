## Dockerized Laravel & Next.js Application

<p>This repository contains a Docker image that provides a ready-to-use solution for running your Laravel and Next.js applications in a unified environment.</p>

### Key Features:

• **Laravel:** Includes all necessary components for running your Laravel application:
    * PHP
    * Composer
    * Laravel
    * Laravel Schedule
• **Next.js:** (Optional) Includes the Next.js framework for frontend development.
• **Database:** Supports both PostgreSQL and MySQL.
• **RabbitMQ:** For implementing asynchronous tasks.
• **Horizon:** Provides a simple interface for managing and monitoring queues.
• **Telescope:** A tool for debugging and analyzing your Laravel application.
• **Filament:** A powerful administrative panel for managing your application.
• **Nginx:** As a web server for reverse proxying requests to the Laravel and Next.js applications.
• **Makefile:** Provides a set of convenient commands for interacting with the Docker image.

### Advantages:

• **Ease of deployment:** Easily install and run your application in any environment.
• **User-friendliness:** All dependencies are automatically installed and configured.
• **Performance:** Optimized for maximum performance.
• **Security:** Provides isolation of your application from other systems.

### Installation Instructions:

1. Clone the repository:

```
git clone <repository>
```


2. Configure the .env file:
    * Specify the username, password, and host for your database.
    * Set the name of your application.
    * Specify the necessary settings for the services.
    * Uncomment the needed and comment out the unnecessary parts in docker-compose.yml.

3. Run the Docker image:
```
make init
```

4. Access the application:
    * Access the Next.js application: http://localhost
    * Access the Telescope application: http://localhost/logging/telescope
    * Access the Horizon application: http://localhost/logging/horizon
    * Access the Filament application: http://localhost/admin
    * Access the Laravel application through routing settings in routes/api.php (All requests to /api* go to Laravel)

The Makefile has comments describing the operation of each function.

### Additional Features:

• The ability to disable Next.js and use Laravel for the frontend.
• Hot reloading support for faster development.

*The TODO file contains a list of tasks that are planned to be implemented in the future, stay tuned for updates.*
