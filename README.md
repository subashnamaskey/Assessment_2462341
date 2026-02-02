# FREYA Nepal

FREYA Nepal is a simple web application built using PHP and MySQL that allows users to browse products and place orders, while giving admins full control over product management.

The project focuses on clean structure, clear separation between admin and user actions, and practical use of core web development concepts.

---

## Project overview

This project simulates a small product catalog and ordering system.  
Users can view and search products, filter them by category or price, and place orders.  
Admins can log in securely to add, update, or delete products.

The goal of this project is to understand how a real-world PHP application works, from database design to frontend interaction.

---

## Features

### User side
- View all available products
- Filter products by category
- Filter products by price range
- Search products by name or category
- Live search suggestions using AJAX
- Place orders without page reload
- Receive a confirmation message after placing an order

### Admin side
- Admin registration and login
- Add new products
- Edit existing products
- Delete products with confirmation
- Admin users cannot place orders
- Session-based access control

---

## Technologies used

- PHP (PDO)
- MySQL
- HTML
- CSS
- JavaScript
- AJAX for search and ordering
- Sessions for authentication

---

## Folder structure
assets/
	css/
		style.css
	js/
		search.js

config/
	db.php

includes/
	header.php
	footer.php
	functions.php

public/
	index.php
	add.php
	edit.php
	delete.php
	search.php
	login.php
	logout.php
	admin_register.php

---

## Database design

### products table
Stores all product information.

- id
- product_name
- category
- price
- created_at

### orders table
Stores order information along with product details at the time of order.

- id
- product_id
- product_name
- category
- price
- created_at

### users table
Used for admin authentication.

- id
- username
- password
- role

---

## How ordering works

When a user places an order:
1. The product ID is sent using AJAX
2. Product details are fetched from the products table
3. A snapshot of the product data is saved in the orders table
4. A success message is shown without reloading the page

This ensures order history remains accurate even if product details change later.

---

## Security considerations

- Passwords are hashed using `password_hash`
- Prepared statements are used to prevent SQL injection
- CSRF tokens protect admin actions
- Sessions control admin access
- Admin actions are separated from user actions

---

## How to run the project locally

1. Clone or download the project
2. Move the project to your local server directory (htdocs for XAMPP)
3. Create a MySQL database named `FreyaNepal`
4. Update database credentials in `config/db.php` if required
5. Start Apache and MySQL
6. Open the project in your browser
7. Register an admin account and log in to manage products

---

## Design decisions

- Orders store product details instead of relying only on product ID
- Modals are created once to avoid UI issues
- Admin and user views are clearly separated
- Simple and readable code structure is prioritized

---

## Purpose of the project

This project was built as a learning exercise to practice:
- PHP CRUD operations
- MySQL database design
- Session-based authentication
- AJAX interactions
- Clean frontend and backend integration

---

## Author

FREYA Nepal  
Built as part of a practical learning project.

