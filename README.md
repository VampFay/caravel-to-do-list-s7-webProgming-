# Fay Tasks — Laravel To-Do Application

A modern, responsive To-Do application and productivity dashboard built with **Laravel 13** and **Tailwind CSS**.

---

## ✨ Features

- **Productivity Dashboard**:
  - 2-column responsive layout with dedicated sidebar and workspace stage.
  - Quick-filter views: **All Tasks**, **Due Today**, **Active**, **Important** (high-priority), and **Completed**.
  - Dynamic category tags: `#Development`, `#Design`, `#Personal`, `#Engineering`.
- **Intuitive Task Creation**:
  - Fast inline entry with `Enter` key.
  - Direct selectors for **Priority** (`High`, `Medium`, `Low`), **Due Date**, and **Category Tags**.
  - Expandable context notes / description.
- **Interactive Task Management**:
  - One-click completion toggle with smooth status updates.
  - In-place editing modal to update title, priority, due date, category, and notes.
  - Delete task action with confirmation.
- **Smart Filtering, Sorting & Search**:
  - Real-time search across task titles, notes, and tags.
  - Sorting options: *Recent*, *Due Date*, *Priority*, *Oldest*.
  - Live task count badges on every filter.
- **Productivity & Bulk Actions**:
  - Real-time completion percentage with progress bar.
  - One-click *Mark all as done*.
  - One-click *Clear completed*.
- **Zero-Configuration SQLite Database**:
  - Pre-configured with SQLite — no external database server installation required.

---

## 🚀 Getting Started

### 1. Prerequisites
- **PHP 8.2+** with `sqlite3` and `mbstring` extensions.
- **Composer**

### 2. Setup
```bash
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate:fresh --seed
```

### 3. Run Development Server
```bash
php artisan serve
```
Visit **http://127.0.0.1:8000** in your browser.

---

## 🧪 Automated Testing

Run the full automated test suite (20 tests, 50 assertions):

```bash
php artisan test
```

---

## 📂 Project Structure

- **Controller**: `app/Http/Controllers/TodoController.php`
- **Model**: `app/Models/Todo.php`
- **View**: `resources/views/todos/index.blade.php`
- **Routes**: `routes/web.php`
- **Database Migration**: `database/migrations/2026_11_03_000000_create_todos_table.php`
- **Database Seeder**: `database/seeders/DatabaseSeeder.php`
- **Feature Tests**: `tests/Feature/TodoTest.php`
