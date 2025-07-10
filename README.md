# Advanced Web Programming Homework2

This project is a Laravel-based web application developed for the Advanced Web Programming course. It demonstrates database backup, XML parsing and display, as well as secure file upload and encryption functionalities.

## Project Overview

The project consists of three main tasks:

---

## Task 1: Database Backup and ZIP

- **Description:**  
  A custom Artisan command that backs up the entire SQLite database, exports all tables and their data as SQL `INSERT` statements into a `.txt` file, and then compresses this file into a ZIP archive.
- **How to Use:**  
  Run the following command in your terminal:
  ```bash
  php artisan app:backup-database database
  ```
  This will create backup files in `storage/app/` such as `backup_database_YYYYMMDD_HHMMSS.txt` and `backup_database_YYYYMMDD_HHMMSS.zip`.

---

## Task 2: XML Parsing and Profile Display

- **Description:**  
  Reads an XML file (`storage/app/LV2.xml`) containing 100 people’s information (id, first name, last name, email, gender, picture, resume). The data is parsed and displayed as user profiles on a modern web page.
- **How to Use:**  
  Visit the following URL in your browser:
  ```
  http://localhost:8000/profiles
  ```
  You will see a list of all people with their picture, name, email, and resume.

---

## Task 3: Secure File Upload, Encryption, and Download

- **Description:**  
  Allows users to upload PDF, JPEG, or PNG files. Each uploaded file is encrypted using AES-256-CBC (via OpenSSL), and only the encrypted version is stored on the server. Users can view a list of encrypted files and download them; files are decrypted on-the-fly before download.
- **How to Use:**
  - **Upload a file:**  
    Go to `http://localhost:8000/encrypted/upload` and use the form to upload and encrypt a file.
  - **List and download files:**  
    Go to `http://localhost:8000/encrypted/list` to see all encrypted files. Click "Download and Decrypt" to download the original file.

---

## Additional Features

- All user interface texts are in English.
- Modern, responsive, and user-friendly design for all pages.
- Secure handling of sensitive data and files.

---

## Requirements

- PHP 8.x
- Composer
- Laravel 10.x
- SQLite (default) or any other supported database
- OpenSSL PHP extension enabled

---

## Setup

1. Clone the repository.
2. Run `composer install`.
3. Copy `.env.example` to `.env` and configure your database if needed.
4. Run `php artisan migrate` to create tables.
5. Place your `LV2.xml` file in `storage/app/`.
6. Start the server with `php artisan serve`.

---

## Author

Prepared for the Advanced Web Programming course.

