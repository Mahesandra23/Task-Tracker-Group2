# ✅ Task Tracker

It is a web-based **To-Do List / Task Tracker** app designed to help users manage their tasks effectively and securely.

---

#### 👥 Created by Group 2

---

## 🎯 Project Objectives

- Implement web programming fundamentals (HTML, PHP, MySQL)
- Build a functional, secure To-Do List app
- Help users organize tasks with progress tracking and status filtering
- Protect the app from **SQL Injection** and **XSS vulnerabilities**

---

## 🛠️ Technologies Used

- **HTML, CSS, JavaScript** – For layout and client-side interactivity
- **PHP Native** – Backend logic and server-side handling
- **MySQL** – Data storage (task data, user credentials)
- **Bootstrap** – UI styling *(optional)*
- **SweetAlert / AOS** – For alerts or visual enhancements *(optional)*

---

## 📌 Core Features

### 🔐 Authentication (Register & Login)
- Register with: full name, email/username, password
- Login required to access the task system
- Password stored securely (encrypted if implemented)
- Protection from SQL Injection

### 📝 Task Management
- **Add Task** with:
  - Title
  - Description
  - Due Date
- **List Tasks** with ability to:
  - Edit
  - Delete (with confirmation)
  - Mark as "Done"
- **Progress Dropdown** with task status:
  - Not yet started
  - In progress
  - Waiting on
  - Done

### 📋 Task Ordering & Feedback
- Tasks marked as "Done" will automatically move to the bottom
- Confirmation shown after marking as done or deleting a task
- Editing a task will update the task data in real-time

---

## 📦 How to Run This Project

> 📝 Make sure your local server is running (XAMPP, Laragon, etc.)

1. Clone or download this repository
2. Import the database file (`task_tracker.sql`) into MySQL
3. Put the project folder into your `htdocs` directory
4. Open your browser and go to:  
   `http://localhost/task-tracker-uts`
5. Start from `index.php` or `login.php`
