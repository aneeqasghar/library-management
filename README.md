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

## 📡 User API
### 1. Install API routes
```bash
php artisan install:api
```
This command generates `routes/api.php`, and ensures that Laravel is aware of the API routes by configuring `bootstrap/app.php` to load `routes/api.php` under the `api` middleware, with the `/api` prefix. Run new migrations:
```bash
php artisan migrate
```

### 2. Setup Postman
- Connect to the server
- Import the API collections given in `postman` directory

### 3. Authentication
Authentication is handled via Laravel Sanctum tokens.
- Login → generates a token for the user.
- Logout → invalidates the current token.
- All protected routes require a token in the Authorization header:
```bash
Authorization: Bearer {{token}}
```

### 4. Protected Routes
The following resources require authentication via Sanctum token:
- Logout
- User resource `/api/v1/user`
- Book-User resources `/api/v1/book-users`
- Borrow / Return resources of books `/api/v1/books/{book}/borrow`, `/api/v1/books/{book}/return`

### 5. API Capabilities

#### 👤 User
- ✅ Can view his profile details
- ✅ Can edit his profile
- ✅ Can delete his profile
- ❌ Cannot login if banned or suspended

#### 📚 Books
- ✅ Can view all books
- ✅ Can view book details
- ✅ Can borrow and return books
- ❌ Cannot borrow books if the user has a fine

#### 📖 Book-Users
- ✅ Can view all his borrow records
- ✅ Can view details of a specific borrow record
