# 📚 Library Management System

A **Library Management System** built with **Laravel**, providing both:  

1. **Admin Panel (Filament-based)** – for administrators to manage users, books, and book borrow/return flows.  
2. **User API** – for members to borrow and return books, with fine and ban management.  

---

## ⚙️ What is Library Management System?

A system to **digitally manage a library’s operations**, including:  
- Managing **books** and their availability.  
- Managing **users** (Admins and Members).  
- Tracking **borrowing & returning** of books.  
- Applying **fines** for late returns.  
- **Suspending/Banning** users who violate rules.  

---

## 👤 User Types

### 🔑 Admin
- Can **ban, unban, suspend** members.  
- Can **upload books** (individually or in bulk).  
- Manages everything via a **Filament Admin Panel**.  

### 📖 Member
- Can **borrow books**.  
- Must **return within due date**.  
- If not returned on time → **fine** is applied.  
- Fine must be **paid before returning**.  
- Failure to return within **30 days** results in **ban**.  

---

# 🚀 Base Project Installation

### 1. Install Laravel
```bash
composer create-project laravel/laravel library-management
cd library-management
```

## 2. Database Setup
1. Update `.env` with your **DB credentials**.  
2. Run migrations:  
```bash
php artisan migrate
```

## 3. Seed Users (Admin + Member examples)
```bash
php artisan db:seed
```

## 3. Implement Telescope
```bash
composer require laravel/telescope
```
```bash
php artisan telescope:install
```
You may access the Telescope dashboard via the /telescope route.

---

## 🛠️ Filament's Admin Panel (Completed)

### 1. Install Filament

```bash
composer require filament/filament:"^4.0"
```
```bash
php artisan filament:install --panels
```

### 2. Create Admin Panel
```bash
php artisan make:filament-panel Admin
```

### 3. Create Resources
```bash
php artisan make:filament-resource User --generate --soft-deletes
php artisan make:filament-resource Book --generate --soft-deletes
php artisan make:filament-resource BookUser --generate --soft-deletes
```

### 4. Bulk Book Upload with Queues
- Job created:
```bash
php artisan make:job ProcessBooks
```
- Worker must be running:
```bash
php artisan queue:work --queue=books
```

### 5. Schedulers
- User are banned, and books are marked as overdue dynamically via schedulers
- Schedulers must be running:
```bash
php artisan schedule:work
```

### 5. Mails
- Configured to send after **book upload** via BookCreated/SendBookEmail (event/listener)

- Worker must be running:
```bash
php artisan queue:work
```
---

## 📡 User API (In Progress)
### 1. Install API routes
```bash
php artisan install:api
```
