# TaskFlow - Task Manager

## Overview
TaskFlow is a simple full-stack task management application that allows users to create, view, complete, and delete tasks.

## Features
- Create tasks with a title and optional description.
- View all saved tasks.
- Mark tasks as completed or incomplete.
- Delete tasks.
- Display total, completed, and remaining task counts.
- Responsive user interface.
- Persistent storage using MySQL.

## Technologies
- HTML5
- CSS3
- JavaScript (Fetch API)
- PHP
- MySQL
- XAMPP

## Project Structure
task-manager/
├── index.html
├── api.php
├── db.php
└── README.md

## Database Setup
1. Start Apache and MySQL in XAMPP.
2. Open phpMyAdmin.
3. Create a database named task_manager.
4. Create a table named tasks using the SQL setup provided for this project.

## Run Locally
1. Place the project folder inside htdocs.
2. Configure the database connection in db.php if needed.
3. Open http://localhost/task-manager/index.html in your browser.

## API
- GET api.php - Retrieve all tasks.
- POST api.php with action create - Create a task.
- POST api.php with action toggle - Toggle task completion.
- POST api.php with action delete - Delete a task.

## Notes
This project uses a PHP backend and a MySQL database. It is intended for local development with XAMPP.