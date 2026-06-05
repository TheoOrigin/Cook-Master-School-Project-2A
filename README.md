# Cook-Master

An all-in-one web platform and API client for managing kitchen operations, bookings, courses, and recipes. Cook-Master combines a PHP MVC web backend with a C-based API client built using GTK+ and libcurl.

## Authors
- TheoOrigin
- School Project Team (2A)

---

## Repository Structure

The project is structured into three main components:

1. **[Web](file:///C:/Users/theob/Desktop/Project/Cook-Master-School-Project-2A/Web)**: A PHP MVC web application.
   - Includes custom routing, controllers, database models, view templates, and a security helper layer.
   - Implements authentication, role management (Admin, Provider, HR), courses, recipes, location booking, and shopping cart logic.
   
2. **[Api](file:///C:/Users/theob/Desktop/Project/Cook-Master-School-Project-2A/Api)**: A REST API server built in PHP.
   - Handles client authentication, user routes, and outputs standard JSON responses.
   
3. **[Curl](file:///C:/Users/theob/Desktop/Project/Cook-Master-School-Project-2A/Curl)**: A native C GUI application built with GTK+ 3 and libcurl.
   - Interacts with the API, allowing users to view items, request logs/history, and adjust settings.

---

## Getting Started

### Web Application Setup
1. Configure your web server (Apache/Nginx) to point to the `Web` directory.
2. Install PHP dependencies using Composer:
   ```sh
   cd Web
   composer install
   ```
3. Import the database schema and update connection parameters in `Web/app/Database.php`.

### API Client Setup (C / GTK+ / libcurl)
To build and run the GTK desktop API client, make sure you have `gcc`, `libgtk-3-dev`, and `libcurl4-openssl-dev` installed:
```sh
cd Curl
make
./cook_master_client
```
*(Refer to the C source files under `Curl/src` for detailed implementation logic)*