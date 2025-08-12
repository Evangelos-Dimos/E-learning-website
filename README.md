# E-learning website Project

This project consists of two parts: a **static website (Part A)** and a **dynamic website with database management (Part B)**. The goal is to create a comprehensive e-learning environment for a course.

## 🌐 Part A: Static Website (HTML/CSS)
The static website is a collection of HTML files that create the foundation for an educational environment. It uses `style.css` for formatting. The main pages include:

* **Homepage (`index.html`)**: Welcomes the user and describes the content of the website.
* **Announcements (`announcement.html`)**: Displays published announcements with dates and links.
* **Contact (`communication.html`)**: Contains a contact form and hyperlinks for sending emails.
* **Course Documents (`documents.html`)**: Presents course documents (e.g., HTML/CSS overview) with download links.
* **Assignments (`homework.html`)**: Outlines two course assignments with their objectives, descriptions, and deadlines.

## ⚙️ Part B: Dynamic Website (PHP/MySQL)
The second part extends the static website by adding user and content management functionalities using **PHP** and **MySQL**.

### 🔑 Login Credentials
* **Tutors**:
    * **Login**: dimvlax@gmail.com | **Password**: 12345v
    * **Login**: billchatzi@gmail.com | **Password**: 12345c
* **Students**:
    * **Login**: nikmulo@csd.auth.gr | **Password**: 12345m
    * **Login**: gianlado@csd.auth.gr | **Password**: 12345l

### 💻 Key Functionalities
* **Login/Logout (`index.php`, `logout.php`)**: A user authentication system using PHP sessions.
* **Content Management**: Tutors can add, edit, and delete announcements, documents, and assignments.
* **Communication (`communication.php`)**: Users can send emails to tutors via a form. The **PHPMailer** library is used for this functionality.
* **User Management (`users.php`)**: Tutors have access to a user management table for adding, editing, and deleting users.
* **Common Functions (`functions.php`)**: Includes helper functions for database connection, date validation, file uploads, etc.
* **Universal Deletion (`delete.php`)**: A single script handles deletions from all database tables.

### 🗄️ Database Structure
The `student4038` database contains the following tables:
* `announcements`: Stores course announcements.
* `homework`: Contains information about assignments (objectives, deadlines, files).
* `documents`: Stores course-related documents and materials.
* `users`: Manages system users with different roles (Tutor, Student).

## 💻 Technologies Used
[![HTML5](https://img.shields.io/badge/html5-%23E34F26.svg?style=for-the-badge&logo=html5&logoColor=white)](https://en.wikipedia.org/wiki/HTML5)
[![CSS3](https://img.shields.io/badge/css3-%231572B6.svg?style=for-the-badge&logo=css3&logoColor=white)](https://en.wikipedia.org/wiki/CSS3)
[![PHP](https://img.shields.io/badge/php-%23777bb4.svg?style=for-the-badge&logo=php&logoColor=white)](https://en.wikipedia.org/wiki/PHP)
[![MySQL](https://img.shields.io/badge/mysql-%2300f.svg?style=for-the-badge&logo=mysql&logoColor=white)](https://en.wikipedia.org/wiki/MySQL)
