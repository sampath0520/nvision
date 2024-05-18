Stage 01

1. Create a PHP REST API endpoint to process “New Order” with an authentication.
******** For the authentication I have used laraval passport
Login creadentials
Email: admin@nvision.com
Password: Nvision2024#

API - {{baseUrl}}/api/login
Method - POST
Body - 
{
    "email": "admin@archnix.com",
    "password": "Nvision2024#"
}
Response - User details and bearer token



i. API body should contain at least two parameters. 
(Customer Name, Order Value)
********
Authentication - bearer token
API - {{BaseURL}}/api/order
Method - POST
Body -
{
    "customer_name":"sampath",
    "order_value":"100"
}



ii. PHP code should follow the MVC design pattern. (You are free to use the Laravel 
framework)
********Used MVC pattern and for the validaions I have used Requests folder and additionaly Services folder also created



iii. After invoking the API, the data should be stored in the MYSQL database.
********Table - Orders (Need to run migrations)


iv. API response should include Order ID, Process ID & Status parameters. “Ordre ID” is a 
Unique identification for an order. “Process ID” needs to be randomly pickup id from the 
ID pool between 1-10. 
********
Ordre ID - Auto Increament
Process ID - Used Random function 1- 10


2. After completing the order, details need to submit to the below 3
rd party API endpoint.
Type = REST
Method = POST/JSON
API Endpoint URL = https://wibip.free.beeceptor.com/order
Parameters =>
{
 "Order_ID": "0001",
 "Customer_Name": "Jhone",
"Order_Value": 250.00,
"Order_Date": "2023-02-15 10:12:42",
"Order_Status": "Processing",
"Process_ID": "4"
}
********

Implemented in apps/jobs/ProcessOrder.php file
implemented Que handleing also


Stage 02
3. Based on the high demand for API requests, suggest a method to queue the API requests into 
the server. (Ex: new orders should wait until the configured number of parallel requests are 
reached)
******
To handle a high demand for API requests and ensure that new orders wait until the configured number of parallel requests are reached, we can use Laravel's built-in queue system. This system allows us to process jobs (in this case, API requests) asynchronously and limit the number of concurrent jobs being processed.

Queue Configuration: Setting up Laravel's queue system using the database driver.
Job Creation: Creating a job that handles the API request to the third-party endpoint.
Job Dispatching: Dispatching the job when a new order is created.
Worker Management: Running a queue worker to process the jobs, with options to limit concurrency and manage resources.

This approach ensures that API requests are queued and processed efficiently, preventing the server from being overwhelmed by high demand and allowing for better scalability and reliability.



4. Create a simple web form with 3 input parameters. After submitting the form, values should be 
stored in browser-based “Indexed DB”. Create a simple data table to view the above 
information from “Indexed DB”. 

****
Create the web route pointing index.php in resources/views/index.blade.php
Route::get('/', function () {
    return view('index');
});

adn create the javascript file to create the indexdb functions located in public/js/script.js
