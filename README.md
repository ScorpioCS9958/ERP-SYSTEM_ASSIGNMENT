# ERP-SYSTEM_ASSIGNMENT
ERP System Assignment 
# -ERP-System-Assignment
This project is a simple ERP system that generates various reports based on invoice, customer and item data.

# Setup Instructions

1. Prerequisites

     PHP 
     MySQL
     Web server (e.g., Apache)

2. Database Setup

    Create a new MySQL database for the project.
    Run the SQL commands provided in the Assumptions section to create the necessary tables.

3. Project Files

    Clone or download this repository to your local web server's document root.
    url https://github.com/IT21191442/-ERP-System-Assignment.git
  
5. Database Connection

    Open db_connection.php
    Update the database connection details:
      - $servername = "localhost";
      - $username = "your_username";
      - $password = "your_password";
      - $dbname = "your_database_name";

6. Web Server Configuration

    Ensure your web server(Apache) is configured to serve PHP files.

7. Accessing the Project

    Open a web browser and navigate to http://localhost/ERPSystem/

# Usage

The reports page allows you to generate three types of reports:
        Invoice Report
        Invoice Item Report
        Item Report
    
For Invoice and Invoice Item reports, you can select a date range to filter the results.
The Item Report shows a summary of all items and their total quantities.
