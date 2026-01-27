<p align="center">
  <img src="docs/logooo.png" width="200" alt="KosKu Logo" />
</p>

<h1 align="center">KosKu</h1>
<h3 align="center">Platform Pencarian Kos Modern Indonesia</h3>

<p align="center">
  <em>Platform pencarian kos modern, cepat, dan user-friendly yang terinspirasi dari layanan seperti Mamikos.</em><br />
  Dibangun dengan <strong>Laravel 10</strong>, <strong>Filament v3</strong>, dan <strong>TailwindCSS</strong> untuk memberikan pengalaman terbaik bagi pencari kos dan pemilik kos.
</p>

<p align="center">
  <a href="https://github.com/kelvianov/Laravel-NeedKos/actions">
    <img src="https://img.shields.io/github/actions/workflow/status/kelvianov/Laravel-NeedKos/ci.yml?branch=main&style=for-the-badge" alt="Build Status" />
  </a>
  <a href="https://github.com/kelvianov/Laravel-NeedKos/blob/main/LICENSE">
    <img src="https://img.shields.io/github/license/kelvianov/Laravel-NeedKos?style=for-the-badge" alt="License" />
  </a>
  <a href="https://github.com/kelvianov/Laravel-NeedKos/issues">
    <img src="https://img.shields.io/github/issues/kelvianov/Laravel-NeedKos?style=for-the-badge" alt="Issues" />
  </a>
  <a href="https://github.com/kelvianov/Laravel-NeedKos/stargazers">
    <img src="https://img.shields.io/github/stars/kelvianov/Laravel-NeedKos?style=for-the-badge" alt="Stars" />
  </a>
</p>

---

## 📋 Table of Contents

- [Overview](#-overview)
- [Key Features](#-key-features)
- [Technology Stack](#-technology-stack)
- [System Requirements](#-system-requirements)
- [Installation Guide](#-installation-guide)
- [Configuration](#-configuration)
- [Usage](#-usage)
- [API Documentation](#-api-documentation)
- [Contributing](#-contributing)
- [Testing](#-testing)
- [Deployment](#-deployment)
- [License](#-license)
- [Support](#-support)

---

## 🎯 Overview

**KosKu** adalah platform pencarian kos komprehensif yang menghubungkan pemilik properti dengan pencari kos. Aplikasi ini menyediakan pengalaman yang seamless untuk pengguna dalam mencari, mengelola, dan menyewa kos dengan fitur filtering lanjutan, pencarian real-time, dan tools manajemen profesional.

### 🌟 Highlights Project

- **Arsitektur Modern**: Dibangun dengan Laravel 10 dengan kode yang bersih dan mudah dipelihara
- **UI Profesional**: Desain responsif dengan TailwindCSS dan styling kustom yang elegan
- **Panel Admin**: Interface manajemen yang powerful menggunakan Filament v3 dengan dashboard analytics
- **Sistem Role-based**: Sistem autentikasi yang aman untuk Admin, Owner, dan Tenant
- **Fitur Real-time**: Pencarian dan filtering yang interaktif dengan optimistic UI
- **Sistem Saved**: Fitur menyimpan kos favorit dengan horizontal carousel responsive
- **Password Reset**: Sistem reset password dengan email verification yang fully integrated
- **Image Optimization**: Loading gambar yang instant tanpa delay dengan preload strategies

---

## 📸 Features Showcase

### 🏠 Homepage & Search
- **Hero Section**: Modern landing page dengan search yang powerful
- **Real-time Search**: Autocomplete untuk kota dan area di seluruh Indonesia
- **Property Cards**: Layout yang responsif dengan lazy loading images
- **Filter Options**: Filter berdasarkan lokasi, harga, gender, dan fasilitas

### 💾 Saved Properties
- **Horizontal Carousel**: 3 cards desktop, 2 tablet, 1 mobile
- **Optimistic UI**: Instant feedback tanpa loading delays
- **Smooth Animations**: Fade-out animations saat remove property
- **Statistics Display**: Jumlah properti tersimpan dan kota berbeda

### 🔐 Authentication System
- **Integrated Login**: Form login dengan forgot password di satu halaman
- **Email Reset**: Template email kustom dengan KosKu branding
- **Dynamic Buttons**: "Kirim Link Reset" → "Kirim Ulang Email" behavior
- **Role Management**: Admin, Owner, dan Tenant dengan permissions berbeda

### 🎛️ Admin Dashboard
- **Filament v3**: Modern admin interface dengan dark mode
- **Custom Widgets**: Analytics dan statistik real-time
- **Resource Management**: CRUD operations untuk users dan properties
- **Policy-based Authorization**: Secure access control

### 📱 Mobile Experience
- **Responsive Design**: Perfect di semua device sizes
- **Touch Optimized**: Gesture support untuk carousel navigation
- **Fast Loading**: Image optimization dan preload strategies
- **Clean UI**: Notification system yang disabled untuk UX yang bersih

---

## ✨ Key Features

### 🔍 **Sistem Pencarian & Filter Lanjutan**
- Pencarian properti real-time dengan berbagai opsi filter dan autocomplete
- Filter berdasarkan lokasi (pusat kota, dekat kampus), harga, gender, dan fasilitas
- Pencarian cerdas dengan suggestions untuk kota dan area di seluruh Indonesia
- Filter berdasarkan rentang harga dengan slider interaktif

### 🏠 **Manajemen Properti Komprehensif**
- Listing properti detail dengan galeri foto multiple upload
- Deskripsi lengkap fasilitas dengan icon-based display
- Informasi kontak dan rules kos yang detail
- Upload multiple images dengan preview dan lazy loading
- Google Maps integration untuk lokasi yang akurat

### 👥 **Sistem Autentikasi Multi-Role**
- **Admin**: Kontrol penuh sistem dan manajemen pengguna melalui Filament Dashboard
- **Owner**: Listing properti, manajemen kos, dan analytics dengan widgets
- **Tenant**: Pencarian properti, fitur saved kos, dan profile management
- Email verification dengan custom templates dan branding KosKu
- Password reset terintegrasi di halaman login tanpa redirect

### 💾 **Fitur Saved Kos yang Modern**
- Horizontal carousel untuk kos tersimpan (3 cards desktop, 2 tablet, 1 mobile)
- Optimistic UI untuk instant feedback tanpa loading
- Responsive design dengan smooth transitions dan animations
- Fast loading tanpa delay dengan image optimization
- Remove saved dengan animasi fade-out yang smooth

### 🎛️ **Dashboard Admin Profesional**
- Dibangun dengan Filament v3 untuk performa optimal dan interface modern
- Manajemen user dan role assignment dengan policy-based authorization
- Resource management untuk kos dan users dengan advanced filtering
- Custom widgets untuk analytics dan statistik real-time
- Interface yang intuitif dengan dark mode support

### 🔐 **Sistem Reset Password Terintegrasi**
- Form reset password yang terintegrasi di halaman login dengan AJAX
- Email verification dengan template kustom KosKu yang branded
- SMTP configuration dengan Mailtrap support untuk testing
- UI yang seamless tanpa redirect - semua di satu halaman login
- Button behavior yang dinamis: "Kirim Link Reset" → "Kirim Ulang Email"

### 🎨 **Interface Pengguna Modern**
- Desain responsif untuk semua tipe device dengan mobile-first approach
- Animasi smooth dan micro-interactions untuk UX yang premium
- Design system yang konsisten dengan KosKu branding
- Fast loading dengan optimized images dan preload strategies
- Notification system yang disabled untuk clean user experience

### 📱 **Design Mobile-First & Performance**
- Interface yang dioptimasi untuk touch dengan gesture support
- Layout responsif yang perfect di semua ukuran layar (desktop, tablet, mobile)
- Performance yang cepat di mobile device dengan image optimization
- Cross-platform compatibility dan fast loading time
- Carousel navigation yang smooth di semua device

---

## 🛠️ Technology Stack

<table>
<tr>
<td><strong>Backend</strong></td>
<td><strong>Frontend</strong></td>
<td><strong>Database</strong></td>
<td><strong>Tools & Services</strong></td>
</tr>
<tr>
<td>

- Laravel 10.x
- PHP 8.1+
- Filament v3
- Laravel Sanctum
- Laravel Queue

</td>
<td>

- TailwindCSS 3.x
- Blade Templates
- Alpine.js
- Vanilla JavaScript
- CSS3 Animations

</td>
<td>

- MySQL 8.0+
- Redis (Caching)
- Laravel Migrations
- Database Seeders

</td>
<td>

- Composer
- NPM/Yarn
- Git
- Laravel Mix/Vite

</td>
</tr>
</table>

---

## 💻 System Requirements

### Minimum Requirements
- **PHP**: 8.1 or higher
- **Composer**: 2.0+
- **Node.js**: 16.x or higher
- **MySQL**: 8.0+ or MariaDB 10.3+
- **Web Server**: Apache 2.4+ or Nginx 1.18+

### Recommended Requirements
- **PHP**: 8.2+
- **Memory**: 512MB+ RAM
- **Storage**: 1GB+ free space
- **Redis**: For caching and sessions

### Development Environment
- **Laravel Valet** (macOS)
- **Laravel Homestead** (Cross-platform)
- **Docker** with Laravel Sail
- **XAMPP/WAMP** (Windows)

---

## 🚀 Installation Guide

### Quick Start

```bash
# Clone the repository
git clone https://github.com/kelvianov/Laravel-NeedKos.git
cd Laravel-NeedKos

# Install PHP dependencies
composer install

# Install and build frontend assets
npm install
npm run build

# Setup environment configuration
cp .env.example .env
php artisan key:generate

# Configure your database in .env file
# DB_DATABASE=kosku_db
# DB_USERNAME=your_username
# DB_PASSWORD=your_password

# Run database migrations and seeders
php artisan migrate --seed

# Create storage link for images
php artisan storage:link

# Create admin user for Filament
php artisan make:filament-user

# Start the development server
php artisan serve
```

### Detailed Installation Steps

<details>
<summary>Click to expand detailed installation steps</summary>

#### 1. Prerequisites Installation

```bash
# Install PHP (Ubuntu/Debian)
sudo apt update
sudo apt install php8.1 php8.1-cli php8.1-common php8.1-mysql php8.1-xml php8.1-curl

# Install Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

# Install Node.js
curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash -
sudo apt-get install -y nodejs
```

#### 2. Project Setup

```bash
# Clone and navigate
git clone https://github.com/kelvianov/Laravel-NeedKos.git
cd Laravel-NeedKos

# Set proper permissions (Linux/macOS)
chmod -R 775 storage bootstrap/cache
```

#### 3. Environment Configuration

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Create storage link
php artisan storage:link
```

#### 4. Database Setup

```sql
-- Create database
CREATE DATABASE needkos_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

```bash
# Run migrations and seeders
php artisan migrate:fresh --seed

# Create admin user (optional)
php artisan make:filament-user
```

</details>

---

## ⚙️ Configuration

### Environment Variables

Create your `.env` file based on `.env.example` and configure the following:

```env
# Application
APP_NAME="KosKu"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=kosku_db
DB_USERNAME=root
DB_PASSWORD=

# Cache & Sessions
CACHE_DRIVER=file
SESSION_DRIVER=file

# Mail Configuration (for password reset)
MAIL_MAILER=smtp
MAIL_HOST=live.smtp.mailtrap.io
MAIL_PORT=587
MAIL_USERNAME=your-mailtrap-username
MAIL_PASSWORD=your-mailtrap-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@kosku.com"
MAIL_FROM_NAME="KosKu"

# File Storage
FILESYSTEM_DISK=public
```

### Additional Configuration

```bash
# Optimize application for production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Clear caches during development
php artisan optimize:clear
```

---

## 📖 Usage

### For Property Owners

1. **Registration**: Create an owner account
2. **Property Listing**: Add property details, photos, and facilities
3. **Management**: Track bookings and manage tenants
4. **Analytics**: View property performance metrics

### For Tenants

1. **Search**: Use filters to find suitable properties
2. **Compare**: Save and compare multiple properties
3. **Book**: Submit booking requests directly
4. **Reviews**: Rate and review properties

### For Administrators

1. **Dashboard**: Monitor overall platform activity
2. **User Management**: Manage users and roles
3. **Content Moderation**: Approve/reject property listings
4. **Analytics**: Generate comprehensive reports

---

## 📚 API Documentation

### Authentication Endpoints

```http
POST /api/register
POST /api/login
POST /api/logout
GET  /api/user
```

### Property Endpoints

```http
GET    /api/properties
POST   /api/properties
GET    /api/properties/{id}
PUT    /api/properties/{id}
DELETE /api/properties/{id}
```

### Search Endpoints

```http
GET /api/search?location={location}&price_min={min}&price_max={max}
GET /api/filters
```

For complete API documentation, visit `/api/documentation` after installation.

---

## 🤝 Contributing

We welcome contributions from the community! Please read our [Contributing Guidelines](CONTRIBUTING.md) for details.

### Development Workflow

```bash
# Fork the repository
# Create a feature branch
git checkout -b feature/amazing-feature

# Make your changes
# Commit your changes
git commit -m 'Add some amazing feature'

# Push to the branch
git push origin feature/amazing-feature

# Open a Pull Request
```

### Code Standards

- Follow PSR-12 coding standards
- Write comprehensive tests
- Document your code
- Follow conventional commit messages

---

## 🧪 Testing

```bash
# Run all tests
php artisan test

# Run specific test suite
php artisan test --testsuite=Feature

# Run with coverage
php artisan test --coverage

# Run tests in parallel
php artisan test --parallel
```

---

## 🚢 Deployment

### Production Deployment

```bash
# Optimize for production
composer install --no-dev --optimize-autoloader
npm run build
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Set proper permissions
chmod -R 755 storage bootstrap/cache
```

### Using Docker

```bash
# Build and run with Docker
docker-compose up -d

# Run migrations in container
docker-compose exec app php artisan migrate --seed
```

### Server Requirements

- **Web Server**: Apache/Nginx with proper rewrites
- **PHP**: 8.1+ with required extensions
- **SSL Certificate**: Required for production
- **Backup Strategy**: Regular database and file backups

---

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

---

## 🆘 Support

### Getting Help

- 📧 **Email**: support@kosku.com
- 💬 **Discord**: [Join our community](https://discord.gg/kosku)
- 📚 **Documentation**: [docs.kosku.com](https://docs.kosku.com)
- 🐛 **Bug Reports**: [GitHub Issues](https://github.com/kelvianov/Laravel-NeedKos/issues)

### Frequently Asked Questions

<details>
<summary>How do I reset my admin password?</summary>

```bash
php artisan make:filament-user
```
</details>

<details>
<summary>How do I configure email settings?</summary>

Update your `.env` file with proper MAIL_* configuration and test with:
```bash
php artisan tinker
Mail::raw('Test email', function($msg) { $msg->to('test@example.com')->subject('Test'); });
```
</details>

---

## 🙏 Acknowledgments

- **Laravel Team** - For the amazing framework
- **Filament Team** - For the powerful admin panel
- **TailwindCSS Team** - For the utility-first CSS framework
- **Open Source Community** - For continuous inspiration and support

---

<div align="center">

**Built with ❤️ by [Kelvianov](https://github.com/kelvianov)**

[⭐ Star this repository](https://github.com/kelvianov/Laravel-NeedKos/stargazers) | [🐛 Report Bug](https://github.com/kelvianov/Laravel-NeedKos/issues) | [💡 Request Feature](https://github.com/kelvianov/Laravel-NeedKos/issues)

</div>

<<<<<<< HEAD
<div align="center">

**Built with ❤️ by [Kelvianov](https://github.com/kelvianov)**

[⭐ Star this repository](https://github.com/kelvianov/Laravel-NeedKos/stargazers) | [🐛 Report Bug](https://github.com/kelvianov/Laravel-NeedKos/issues) | [💡 Request Feature](https://github.com/kelvianov/Laravel-NeedKos/issues)

</div>
=======

>>>>>>> 52246edcd34ba8265a0d6a5052e9b969dfa54492
