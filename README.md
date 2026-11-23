# MUKOH TIRES — Complete Laravel Application & Admin Panel

[![Laravel](https://img.shields.io/badge/Laravel-13.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.3-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![Three.js](https://img.shields.io/badge/Three.js-r182-black?style=for-the-badge&logo=three.js&logoColor=white)](https://threejs.org)
[![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://mysql.com)
[![Vite](https://img.shields.io/badge/Vite-6.x-646CFF?style=for-the-badge&logo=vite&logoColor=white)](https://vitejs.dev)

A modern, production-ready automotive tire retailer and service platform recreated as a complete Laravel application, faithfully reproducing the visual identity, dark automotive aesthetics, interactive mechanics, and smooth user experience of the reference website.

- **Reference Website**: [https://mukoh-demowebsite.netlify.app/](https://mukoh-demowebsite.netlify.app/)
- **GitHub Repository**: [https://github.com/Haider-875/mukoh](https://github.com/Haider-875/mukoh)
- **Author**: [Haider-875](https://github.com/Haider-875)

---

## ⚡ Key Highlights & Features

### 1. High-Fidelity Design Recreation
- **Dark Automotive Aesthetic**: Exact color palette (`#090909`, `#121215`, `#18181b`, `#ef3b2d` crimson accent, `#f4f4f5` text).
- **Typography & Proportions**: Monospace data tags, bold racing-inspired headlines, high-contrast badges, and precision-spaced responsive grids.
- **Complete Page Suite**:
  1. `Home` (`/`) — Hero 3D interactive stage, category cards, dynamic featured tires, services breakdown, difference matrix, animated statistics, and driver reviews.
  2. `Tires` (`/tires`) — Dynamic catalog with condition filters (Brand New vs. Certified Used), category tabs, size filtering, search, and dynamic counts.
  3. `Services` (`/services`) — Installation, dynamic balancing, laser alignment, puncture repair, TPMS programming, and full inspection checklists.
  4. `About` (`/about`) — Engineering standards, facility overview, company pillars, and driver milestones.
  5. `Contact & Booking` (`/contact`) — Interactive vehicle appointment scheduler with year/make/model and tire size inputs, phone/email contact stack, and Google Maps embed.
  6. `Privacy Policy` (`/privacy` & `/privacy-policy`) — Comprehensive automotive data security policies.
  7. `Terms of Service` (`/terms` & `/terms-of-service`) — Commercial installation and warranty conditions.

### 2. Next-Generation Three.js 3D Tire Experience
- **Solves the Pixelated Canvas Issue**: Replaces the blurry 240-frame pre-rendered WebP playback with a real-time, vector-sharp **Three.js PBR 3D model**.
- **High-Resolution Procedural Textures**: 4096x1024 normal and bump maps with sharp longitudinal rain grooves, lateral siping, rubber micro-grain, and embossed sidewall markings (`MUKOH 245/45 R19 98Y TUBELESS HIGH TRACTION A`).
- **Photorealistic Materials**:
  - Carbon-black rubber with accurate roughness and Fresnel falloff.
  - Machined aluminum 5-split spoke alloy rim with metallic specular highlights.
  - Ventilated brake rotor with cooling holes and center hub.
  - High-gloss crimson Brembo-style brake caliper with "MUKOH" emblem.
- **Cinematic Lighting & Interactivity**:
  - 3-point studio lighting with key, fill, and a dramatic crimson rim back-light.
  - Smooth mouse/touch drag tilt with inertia damping.
  - Scroll-triggered rotation tied smoothly to page scroll progress.
  - Adaptive resolution with retina DPR scaling and automatic fallback.

### 3. Synthesized Web Audio API Sound Effects
- **Zero-Latency Audio Engine**: Pure synthesized Web Audio API audio (no heavy external audio files to buffer or fail).
- **Subtle Interaction Sounds**:
  - Tactile high-frequency click on buttons and quick quotes.
  - Soft blip on navigation links and category tabs.
  - Metallic pop on tire card interactions.
  - Rich major-triad chord chime (`C5 - E5 - G5 - C6`) on form submissions.
- **Audio Controls**: Floating sound toggle button in header and drawer with `localStorage` state persistence and autoplay compliance.

### 4. Celebratory Form Submission Experience
- **Async AJAX Processing**: Submissions process seamlessly without page reload across all forms (Contact, Appointment Booking, Quick Quote Modal, Tire Inquiries).
- **Celebratory Modal**:
  - Prominent **"SUBMITTED!"** headline.
  - Animated SVG green checkmark circle with draw-in animation.
  - Confetti burst powered by `canvas-confetti`.
  - Harmonious celebratory audio chime.
  - Unique transaction reference tracking number (`#REF-XXXX`).
  - Double-submission prevention and field-level validation feedback.

### 5. Comprehensive Laravel Admin Panel (`/admin`)
- **Secure Authentication**: Protected by dedicated `AdminMiddleware`, secure session management, and bcrypt password hashing.
- **Dashboard Analytics**: Real-time counters for inquiries, pending appointments, quote volume, catalog inventory, and monthly submission trends.
- **Product Catalog Management**: Full CRUD to add, edit, toggle visibility, and delete tire products with image upload, custom pricing, feature bullet lists, and badges.
- **Service Management**: Full CRUD to configure automotive services, starting prices, feature checklists, and action buttons.
- **Inquiry & Appointment Triage**:
  - Filter by submission status (`pending`, `contacted`, `completed`, `cancelled`).
  - Search by sender, email, phone, or vehicle.
  - Mark read/unread and update internal staff notes.
  - One-click **CSV export** for CRM integration.
- **Testimonial Management**: Add, update, and toggle customer reviews and star ratings.
- **Website Content Editor**: Tabbed control panel for Hero text, contact numbers, address, hours, stats counters, sound defaults, and SEO metadata.
- **Admin Security**: Dedicated profile name/email updates and password change forms.

---

## 🛠 Technology Stack

| Layer | Technologies |
|---|---|
| **Backend Framework** | Laravel 13.x (PHP 8.3+) |
| **Database** | MySQL 8.0+ (InnoDB, UTF8mb4) |
| **Templating** | Laravel Blade with modular components & layouts |
| **Frontend Styling** | Custom CSS3 + Bootstrap 5.3 utilities |
| **3D Rendering** | Three.js (r182) with WebGLRenderer & PBR Shaders |
| **Sound Engine** | Web Audio API (Synthesized AudioContext) |
| **Animations** | GSAP 3.x + Canvas-Confetti + CSS Hardware-Accelerated Transforms |
| **Build System** | Vite 6.x |
| **Testing** | PHPUnit / Pest with 10 comprehensive feature test suites |

---

## 📦 Installation & Setup Guide

### 1. Prerequisites
- **PHP**: `^8.2` or `^8.3` (with `pdo`, `pdo_mysql`, `mbstring`, `openssl`, `curl`, `gd`, `fileinfo` extensions enabled)
- **Composer**: `2.x+`
- **Node.js**: `18.x+` or `20.x+` & `npm`
- **MySQL Server**: `8.0+` or MariaDB

### 2. Clone the Repository
```bash
git clone https://github.com/Haider-875/mukoh.git
cd mukoh
```

### 3. Install Dependencies
```bash
composer install
npm install
```

### 4. Environment Configuration
Copy `.env.example` to `.env`:
```bash
cp .env.example .env
```
Generate the application key:
```bash
php artisan key:generate
```

Configure your MySQL database settings in `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mukoh_tires
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 5. Run Migrations & Seed Database
```bash
php artisan migrate:fresh --seed
```
This populates:
- Default administrator account.
- 4 tire categories (`Passenger Car`, `SUV & Crossover`, `High Performance`, `All-Terrain & Off-Road`).
- 15 realistic tire products with specifications, warranties, and pricing.
- 6 automotive services with starting rates and feature checklists.
- 6 customer testimonials with star ratings.
- 40 default website configuration settings.
- 7 core CMS pages.

### 6. Link Storage & Build Assets
```bash
php artisan storage:link
npm run build
```

### 7. Run the Application
Start the Laravel local server:
```bash
php artisan serve
```
Visit the application in your browser:
- **Public Website**: [http://127.0.0.1:8000](http://127.0.0.1:8000)
- **Admin Panel**: [http://127.0.0.1:8000/admin](http://127.0.0.1:8000/admin)

---

## 🔐 Default Admin Credentials

| Field | Value |
|---|---|
| **Admin URL** | `/admin` or `/login` |
| **Email** | `admin@mukohtires.com` |
| **Password** | `admin123` |
| **Role** | Super Administrator |

*(Note: Remember to update your email and password immediately via `/admin/settings` after initial deployment).*

---

## 🧪 Automated Testing

Run the automated test suite verifying public routes, celebratory form responses, admin authentication, CRUD pipelines, and CSV exports:
```bash
php artisan test
```
All 10 tests and 67 assertions run cleanly against an in-memory SQLite database.

---

## 📂 Project Architecture

```
mukoh/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/               # Admin dashboard, products, services, inquiries, appointments, content
│   │   │   ├── HomeController.php
│   │   │   ├── TireController.php
│   │   │   ├── ServiceController.php
│   │   │   ├── ContactController.php
│   │   │   ├── InquiryController.php
│   │   │   └── PageController.php
│   │   └── Middleware/
│   │       └── AdminMiddleware.php  # Protects /admin routes
│   └── Models/                      # Product, Service, Inquiry, Appointment, Category, WebsiteSetting, etc.
├── database/
│   ├── migrations/                  # Schema migrations with foreign keys, indexes, and timestamps
│   └── seeders/DatabaseSeeder.php   # Initial demo data & admin seeder
├── public/
│   ├── css/                         # Preserved reference stylesheets & custom additions
│   ├── images/                      # SVG icons & branding assets
│   └── robots.txt                   # Search crawler directives + Sitemap link
├── resources/
│   ├── js/
│   │   ├── app.js                   # Application bootstrap
│   │   ├── three-tire.js            # Real-time Three.js 3D PBR tire engine
│   │   ├── sound-effects.js         # Web Audio API sound generator
│   │   └── form-handler.js          # AJAX form binder & celebratory modal
│   └── views/
│       ├── layouts/                 # Public master Blade layout with header, footer, modals
│       ├── admin/                   # Complete admin panel views (dashboard, products, services, inquiries)
│       └── *.blade.php              # Home, Tires, Services, About, Contact, Privacy, Terms
├── routes/
│   └── web.php                      # Public routes, form endpoints, and admin resources
└── tests/
    └── Feature/MukohWebsiteTest.php # Comprehensive test suite
```

---

## 📄 License & Attribution
Developed for **MUKOH Tires LLC**. All rights reserved.
Recreated from the visual specification at [https://mukoh-demowebsite.netlify.app/](https://mukoh-demowebsite.netlify.app/).
