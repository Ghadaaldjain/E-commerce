# README



A simple php e-commerce website, part of the course:

PHP for Begginners: How to Build an E-Commerce Store. 


Functionality Included:

Products:\
Display all products \
Details for each product\
Display products in a specific category


Cart/Session:\
Add product to cart\
Remove product from cart\
Dispalay cart \
Increase/decrease product quantity in cart\
View final invoice(total price) in cart


Payment(Paypal API for Payment Processing):\
Users can pay using PayPal (sandbox)\
Redirect back to website once payment is done  \
View payment details in admin site


Admin site:\
Add/update/delete categories\
Add/update/delete products\
Display/delete orders\
Display/delete reports\
Authorize other admins \
No dashboard 


General:\
Costomers can send email through contact us page

UI was designed and built by course instructore


Databse Instructions:

1- Setup :

Databse name: ecom_db\
Databse username: root\
Databse host: localhost


2- Create tables:

CREATE TABLE categories (
cat_id INT(11) AUTO_INCREMENT PRIMARY KEY,
cat_title VARCHAR(255) NOT NULL
);

CREATE TABLE products (
product_id INT(11) AUTO_INCREMENT PRIMARY KEY,
product_category_id int(11) FOREGIN KEY REFERENCES categories(cat_id),
product_title VARCHAR(255),
product_price float,
product_quantity int(11),
product_description text,
product_image varchar(255),
short_desc text,
);


CREATE TABLE orders (
order_id INT(11) AUTO_INCREMENT PRIMARY KEY,
order_amount float,
order_ts VARCHAR(255),
order_status VARCHAR(255),
order_currency VARCHAR(255)
);


CREATE TABLE reports (
report_id INT(11)  AUTO_INCREMENT PRIMARY KEY,
product_id int(11) FOREGIN KEY REFERENCES products(product_id),
order_id int(11) FOREGIN KEY REFERENCES orders(order_id),
product_price float,
product_title varchar(255),
product_quantity int(11)
);


CREATE TABLE users (
user_id INT(11)  AUTO_INCREMENT PRIMARY KEY,
username VARCHAR(255),
email varchar(255),
password varchar(255),
user_photo varchar(255)
);


3- Create admin:

INSERT INTO users (username, email, password)
VALUES ('admin', 'test@test.com', '1234');


Categories and products can be added from the admin site; by using admin as a username and 1234 as a password to login.


