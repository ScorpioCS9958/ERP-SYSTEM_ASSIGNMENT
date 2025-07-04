# ERP-SYSTEM_ASSIGNMENT
ERP System Assignment 
Setup Instructions
Prerequisites

PHP MySQL Web server (e.g., Apache)

Database Setup

Create a new MySQL database for the project. Run the SQL commands provided in the Assumptions section to create the necessary tables.

Project Files

Clone or download this repository to your local web server's document root. url https://github.com/IT21191442/-ERP-System-Assignment.git

Database Connection

Open db_connection.php Update the database connection details:

$servername = "localhost";
$username = "your_username";
$password = "your_password";
$dbname = "your_database_name";
Web Server Configuration

Ensure your web server(Apache) is configured to serve PHP files.

Accessing the Project

Open a web browser and navigate to http://localhost/ERPSystem/

Usage
The reports page allows you to generate three types of reports: Invoice Report Invoice Item Report Item Report

For Invoice and Invoice Item reports, you can select a date range to filter the results. The Item Report shows a summary of all items and their total quantities.
