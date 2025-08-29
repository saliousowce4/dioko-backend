# Technical Test Project - DIOKO Payment Management

Web and mobile application developed in Flutter with a Laravel backend, allowing management of regular payments (electricity, internet, water, rent, various services). The project was completed following precise specifications, with emphasis on clean architecture (Clean Architecture), code quality, and polished user experience.

---

## 🔥 Deployment Links

- **Web Application:** [https://dioko-app-hd6b.onrender.com/#/login](https://dioko-app-hd6b.onrender.com/#/login)
- **Backend API:** `https://dioko-backend-a7ti.onrender.com/api/`
- **APK Download (Android):** [Download APK](https://drive.google.com/file/d/1gPx7-OQgjPy_QvrIsDeOYKzs_3pQz5Se/view?usp=sharing)
- **Web Demo Videos:** [Watch demo](https://drive.google.com/file/d/1evEs1j-j8B2ZkNtIPHxNXtrLzo2dd0Wl/view?usp=drive_link)
- **Mobile Demo Videos:** [Watch demo](https://drive.google.com/file/d/12FvTBFqwTXRJ-wO6YqxU6bHJ0Q_S9fhE/view?usp=drive_link)

### Test Accounts
To quickly test the application:
- **Email:** `Zsaliou@gmail.com`
- **Password:** `password123`

---

## ✨ Technical Stack

### Frontend
- **Framework:** Flutter 3.16+
- **Architecture:** Clean Architecture + Feature-first
- **State Management:** Riverpod 2.4+
- **Navigation:** GoRouter 12+
- **Local Database:** Floor (SQLite)
- **HTTP Client:** Dio 5+
- **File Management:** file_picker, image_picker
- **Testing:** flutter_test, mockito

### Backend
- **Framework:** Laravel 10
- **Database:** PostgreSQL
- **Authentication:** JWT
- **File Storage:** Laravel Storage
- **Testing:** PHPUnit

### Deployment
- **Web App:** Render.com (Static Site)
- **Backend API:** Render.com (Web Service with Docker)
- **Database:** PostgreSQL on Render

---

## ✅ Implemented Features

### 1. Authentication and User Management ✅
- [x] Login page with email/password
- [x] Registration page with data validation
- [x] JWT token management on backend
- [x] User session persistence
- [x] Secure logout
- [x] Field validation

### 2. Web and Mobile Dashboard ✅
- [x] Real-time available balance display
- [x] Regular payments list
- [x] Responsive adaptive design
- [x] Real-time data refresh

### 3. Payment System ✅
- [x] Payment creation form with:
    - Payment description
    - Amount with validation
    - Supporting documents upload (PDF/Images)
    - Predefined categories (Electricity, Internet, Water, etc.)
- [x] Payment API
- [x] Balance validation before payment
- [x] Automatic balance update
- [x] Payment statuses (Pending, Validated, Failed)
- [x] Payment error handling

### 4. History and Filters ✅
- [x] Dedicated complete history page
- [x] Period filters:
    - By day
    - By month
    - By year
- [x] Search by description
- [x] Sort by date/amount


## 🚀 Local Installation and Launch

### Prerequisites
- PHP >= 8.2 with extensions (mbstring, pdo, openssl, etc.)
- Composer 2.x
- Flutter SDK >= 3.16
- Node.js >= 18 (for web build)
- PostgreSQL or MySQL
- Git

### 1. Backend (Laravel API)

```bash
# Clone backend repository
git clone https://github.com/saliousowce4/dioko-backend.git
cd dioko-backend

# Install dependencies
composer install

# Configure environment
cp .env.example .env
# Edit .env with your database parameters

# Generate application key
php artisan key:generate

# Generate JWT secret
php artisan jwt:secret

# Run migrations
php artisan migrate

# Start development server
php artisan serve

```

### 2. Frontend (Flutter App)

```bash
# Clone frontend repository
git https://github.com/saliousowce4/dioko_app.git
cd dioko_app

# Install dependencies
flutter pub get

# Configure local API URL
# Edit lib/core/network/dio_client.dart
# static const String baseUrl = 'http://localhost:8000/api';

# Launch web app
flutter run -d chrome

# Or launch mobile app on emulator/device
flutter run
```

### 3. Environment Configuration

#### Backend (.env)
```env
APP_NAME="DIOKO"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=dioko_payments
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password

JWT_SECRET=your_jwt_secret_key
JWT_TTL=1440

FILESYSTEM_DISK=local
```

#### Frontend (lib/core/network/dio_client.dart)

---

## 🧪 Testing

### Backend (PHPUnit)
```bash
cd dioko-backend

# Run all tests
php artisan test


# Specific tests
php artisan make:test AuthTest
php artisan make:test PaymentTest
```

### Frontend (Flutter Test)
```bash
cd dioko_app

# Run all tests
flutter test

```

---

## 📱 Build and Deployment

### Web Production Build
```bash
flutter clean && \
flutter pub get && \
flutter build web --release --base-href="/" && \
ls -la build/web/ | grep -E "(sqflite|sqlite)" && \
git add . && \
git commit -m "Fixing Web file Platform" && \
git push origin main
# Files are generated in build/web/
```

### Android APK Build
```bash
flutter build apk --release
# APK is generated in build/app/outputs/flutter-apk/app-release.apk
```

### Backend Deployment (Render)
1. Connect GitHub repository to Render
2. Configure environment variables
3. Automatic deployment via Git push

### Frontend Deployment (Render)
1. Local build: `flutter build web --release`
2. Upload `build/web/` folder to Render Static Site
3. Configure routing for SPA

---

## 🔧 Project Architecture

### Frontend Structure (Flutter)
```
lib/
├── core/                    # Configuration and utilities
│   ├── constants/          # App constants
│   ├── network/            # HTTP Client (Dio)
│   ├── database/           # Local database
│   └── utils/              # Utility functions
├── features/               # Features (Clean Architecture)
│   ├── auth/               # Authentication
│   │   ├── data/           # Data sources
│   │   ├── domain/         # Business logic
│   │   └── presentation/   # UI and presentation logic
│   ├── dashboard/          # Dashboard
│   ├── payments/           # Payment management
│   └── history/            # History
└── shared/                 # Shared components
```

### Backend Structure (Laravel)
```
dioko-backend/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   └── Api/
│   │   │       ├── AuthController.php       # Handles registration, login and logout.
│   │   │       ├── DashboardController.php  # Provides aggregated data for dashboard.
│   │   │       └── PaymentController.php    # Manages payment creation and reading.
│   │   └── Middleware/
│   │       └── ...                       # Default middlewares (CORS, etc.)
│   ├── Models/
│   │   ├── User.php                      # Eloquent model for 'users' table.
│   │   └── Payment.php                   # Eloquent model for 'payments' table.
│   └── Providers/
│       └── ...
├── config/
│   ├── app.php                         # Main application configuration.
│   ├── cors.php                        # Cross-Origin (CORS) permissions configuration.
│   └── database.php                    # Database connections configuration.
├── database/
│   ├── migrations/                     # Contains table schemas (users, payments, etc.).
│   └── factories/                      # Used for tests to generate fake data.
├── routes/
│   └── api.php                         # Defines all API endpoints (ex: /api/register, /api/payments).
├── storage/
│   └── app/
│       └── public/
│           └── attachments/            # Folder where uploaded supporting documents are stored.
├── tests/
│   ├── Feature/                        # Contains integration tests that simulate API calls.
│   │   ├── AuthTest.php
│   │   └── PaymentTest.php
│   └── Unit/                           # Contains unit tests.
├── .env.example                      # Example file for environment variables.
├── composer.json                     # Manages PHP dependencies.
├── Dockerfile                        # Instructions to build production image on Render.
├── start.sh                          # Startup script that runs migrations and server.
└── artisan                           # Laravel's command line tool.
```

---

## 🔐 Security

### Implemented Measures
- [x] JWT authentication
- [x] Strict input data validation
- [x] Secure password hashing (bcrypt)
- [x] Uploaded file type validation
- [x] User data sanitization
- [x] SQL injection protection (Eloquent ORM)

---

## 📊 Performance

### Optimizations
- Page lazy loading
- Image caching
- Build optimization (--release)
