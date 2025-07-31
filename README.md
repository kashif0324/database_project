# TemuApp Database

This project contains the MySQL database schema and sample data for **TemuApp**, an e-commerce application designed to manage users, products, orders, reviews, and more.

---

## 📌 Features

- **User Management:** Handles user registration with email, password, and phone numbers.  
- **Product Catalog:** Stores product information, categories, stock, and pricing.  
- **Order Handling:** Allows users to place orders, track status (Delivered, Processing, Shipped, Cancelled).  
- **Order Items:** Supports multiple products per order with quantities and subtotals.  
- **Reviews:** Users can rate and leave comments on purchased products.  

---

## 🛠️ Database Structure

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

## 🚀 Installation

1. Open **phpMyAdmin** or MySQL client.  
2. Create a new database:  
   ```sql
   CREATE DATABASE temuapp_db;
