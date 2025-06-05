# 📚 Library Management System

## Overview

**Library Management System** is a simple yet effective web-based application that allows users to manage a collection of books. Users can **add**, **edit**, **delete**, and **view** books along with their details such as **title**, **author**, and **published year**.

This project is built with **Vanilla PHP** and uses **Medoo** as a lightweight database framework to simplify MySQL/SQLite operations. It's ideal for learning CRUD concepts, form handling, and data validation.

## 🎯 Features

- Add new books with title, author, and year.
- Edit existing book entries.
- Delete books from the list.
- View all books in a clean table format.
- Validate inputs to prevent duplicates or empty fields.
- Friendly error messages.

## ⚙️ Technologies Used

- **PHP (Vanilla)** – Core backend language.
- **Medoo** – Lightweight PHP database framework.
- **MySQL / SQLite** – Relational database system.
- **HTML & CSS** – For UI structure and styling.

## 🚀 Installation

To run this project locally:

Clone the repository:
   ```bash
   git clone https://github.com/AmirRiahi2008/library-management-system
   cd library-management-system
```
Enter This Query To Create Libary Database. 
```
CREATE TABLE books (
  id INTEGER PRIMARY KEY AUTO_INCREMENT,
  title VARCHAR(255),
  author VARCHAR(255),
  published_year INT
);
