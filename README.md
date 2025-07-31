# TemuApp Database

This project contains the MySQL database schema and sample data for **TemuApp**, an e-commerce application designed to manage users, products, orders, reviews, and more.

---

## 🎯 Project Objective

The main objective of this project is to design and implement a relational database that supports an e-commerce platform. The database manages user accounts, product catalogs, orders, order items, reviews, and customer phone numbers while ensuring data consistency through primary and foreign keys.

---

## 📌 Features

- **User Management:** Handles user registration with email, password, and phone numbers.  
- **Product Catalog:** Stores product information, categories, stock, and pricing.  
- **Order Handling:** Allows users to place orders, track status (Delivered, Processing, Shipped, Cancelled).  
- **Order Items:** Supports multiple products per order with quantities and subtotals.  
- **Reviews:** Users can rate and leave comments on purchased products.  

---

## 🛠️ Technologies Used

- **Database:** MySQL / MariaDB  
- **Tool:** phpMyAdmin for database management  
- **SQL Version:** 5.2.1 (compatible with MySQL 8.x and MariaDB 10.x)  
- **Server:** XAMPP / LAMP / WAMP for local hosting  

---

## 🗄️ Database Structure

The database consists of the following tables:

- **user** – Stores user details and login information  
- **phone** – Manages multiple phone numbers for users  
- **product** – Catalog of products available for purchase  
- **order** – Tracks orders placed by users  
- **orderitem** – Items associated with each order  
- **review** – User reviews and ratings for products  

### 🔑 Relationships

- One user → Many orders  
- One order → Many order items  
- One user → Many reviews  
- One product → Many reviews  
- One user → Many phone numbers  

---

## 📂 File

- `temuapp_db.sql` → Full database schema and sample data  

---

## 🚀 How to Run the Project

1. **Set up your local server:**  
   - Install [XAMPP](https://www.apachefriends.org/) or [WAMP](https://www.wampserver.com/).  
   - Start Apache and MySQL modules.  

2. **Create a new database:**  
   ```sql
   CREATE DATABASE temuapp_db;
