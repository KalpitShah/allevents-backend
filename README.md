# Event Listing App - Backend PHP Project

## Description

This is the backend for the Event Listing App. It is a RESTful API developed using PHP, providing various endpoints for managing users and events. It interacts with a MySQL database for data storage and retrieval.

## Prerequisites

To replicate this project, you'll need the following installed on your machine:

1. PHP 7.3 or higher
2. MySQL
3. Apache server or any server that can serve PHP (like Nginx)

## Project Setup

Follow the steps below to replicate this project:

### Step 1: Clone the repository

Clone the repository to your local machine by running the following command in your terminal:

```bash
git clone https://github.com/KalpitShah/allevents-backend.git
```

### Step 2: Set up the database

Create a new MySQL database for the project. Import the provided SQL file into your newly created database to set up the required tables and seed some data.

Note: Please note that you will need to modify the database connection credentials in the config/Database.php file to match the credentials for your MySQL server.

### Step 3: Start the server

Start your Apache (or other) server. If you're using a local development environment like XAMPP or WAMP, ensure that your server is running and configured to serve your project.

Navigate to the project's URL in your web browser. If everything is set up correctly, you should be able to see the API endpoints.
