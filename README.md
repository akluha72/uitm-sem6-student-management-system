# Student Management System (PHP + MySQL)

A database-driven Student Management System for **ICT600 Web Technology & Application**,
built using only **PHP** and **MySQL**.

## Key design note
**All SQL queries live in a single file:** [`includes/queries.php`](includes/queries.php).
No SQL is written anywhere else in the project — every page calls a function from that file.

## Setup (Laragon)

1. Place the project in `C:\laragon\www\uitm-web-application-development` (already done).
2. Start Laragon (Apache + MySQL).
3. Import the database. Either:
   - In a terminal: `mysql -u root < database.sql`, **or**
   - Open phpMyAdmin / HeidiSQL and import `database.sql`.
4. Visit: <http://localhost/uitm-web-application-development/> (or the Laragon pretty URL).

The DB connection (host `127.0.0.1`, user `root`, no password) is in
[`config/database.php`](config/database.php) — adjust if your MySQL credentials differ.

## Demo accounts

| Username | Password   | Role    | Access                         |
|----------|------------|---------|--------------------------------|
| admin    | admin123   | admin   | Add, Edit, Delete, View, Search |
| student  | student123 | student | View & Search only             |

When a **student** logs in, the Add / Edit / Delete buttons are hidden (view-only).
An **admin** sees and can use all actions.

## Pages

| File | Purpose |
|------|---------|
| `index.php` | Home page (dashboard + menu) |
| `about.php` | About page |
| `login.php` / `logout.php` | Authentication + session |
| `add_student.php` | Add a student (admin) |
| `view_student.php` | List all students |
| `view_detail.php` | Full detail for one student (the **View** button) |
| `edit_student.php` | Edit a student (admin) |
| `delete_student.php` | Delete with confirmation (admin) |
| `search_student.php` | Search by Student ID or Name |

## Folder structure

```
config/database.php        DB connection
includes/queries.php       ALL SQL queries (single file)
includes/auth.php          session + role helpers + photo upload
includes/header.php        shared header & nav
includes/footer.php        shared footer
includes/student_form.php  shared add/edit form
assets/css/style.css       responsive styles
uploads/                   uploaded student photos
database.sql               schema + seed data
```

## Features implemented
- CRUD (Create, Read, Update, Delete) on student records
- Search by Student ID or Name + per-row **View** detail page
- Login authentication & session management
- Role-based access (admin vs student)
- Student photo upload
- Responsive design (mobile menu, scrollable tables)
- SQL-injection-safe prepared statements throughout
