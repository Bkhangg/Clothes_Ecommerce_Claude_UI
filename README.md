<div align="center">
  <h1>BKhanggDesu</h1>
  <p align="center">
    A Laravel application with the <strong>Heritage</strong> design system —<br>
    flat, minimal, and typography-driven.
  </p>

  <p>
    <img src="https://img.shields.io/badge/Laravel-13.11-F9322C?logo=laravel&logoColor=white" alt="Laravel">
    <img src="https://img.shields.io/badge/PHP-8.3.30-777BB4?logo=php&logoColor=white" alt="PHP">
    <img src="https://img.shields.io/badge/MySQL-8.0-4479A1?logo=mysql&logoColor=white" alt="MySQL">
    <img src="https://img.shields.io/badge/Tailwind_CSS-4-06B6D4?logo=tailwindcss&logoColor=white" alt="Tailwind">
    <img src="https://img.shields.io/badge/Alpine.js-3-8BC0D0?logo=alpine.js&logoColor=white" alt="Alpine.js">
  </p>

  <p>
    <code>🌐 EN / VI</code>&nbsp;&nbsp;
    <code>⚡ Blade + Vite</code>&nbsp;&nbsp;
    <code>🎨 Heritage Design</code>
  </p>
</div>

---

## ✨ Features

| Area | Details |
|------|---------|
| **Authentication** | Login, Register, Password Reset, Email Verification, Confirm Password |
| **Profile Management** | Update name/email, change password, delete account with confirmation |
| **Category CRUD** | Full Create / Read / Update / Delete with search, filter, sort & paginate |
| **Bulk Operations** | Select all / deselect, bulk delete with confirmation modal |
| **Toast Notifications** | Alpine.js-powered toast with progress bar, bounce animation, auto-dismiss |
| **Language Switch** | English / Vietnamese via live globe dropdown |
| **Responsive Design** | Desktop sidebar + mobile off-canvas hamburger navigation |

---

## 🎨 Heritage Design System

A flat, minimal design built around typography and restrained accent use.

```yaml
Colors:
  primary:   '#1A1C1E'   # Rich black
  secondary: '#6C7278'   # Warm gray
  tertiary:  '#B8422E'   # Burnt orange (single accent)
  neutral:   '#F7F5F2'   # Warm off-white
  surface:   '#FFFFFF'   # White

Typography:
  display: 'Fraunces'     # Serif for h1 / large headings
  body:    'Public Sans'  # Sans-serif for paragraphs
  label:   'Space Grotesk' # Monoline for labels / uppercase

Radius:    2px / 4px / 8px
```

---

## 🏗️ Architecture

```
routes/web.php          → Language switch, categories (resource + bulk-delete), profile
app/Http/Controllers/   → CategoryController, ProfileController, LanguageController
app/Http/Middleware/     → SetLocale (session-based language)
resources/views/         → Blade templates organized by feature
lang/en/ & lang/vi/     → All UI strings translated
database/factories/      → CategoryFactory (50 Vietnamese clothing categories)
database/seeders/        → Admin user + 25 seed categories
```

### Layout Structure

```
layouts/
├── app.blade.php        # Authenticated layout (sidebar + top bar + content)
├── guest.blade.php      # Guest layout (centered card + brand)
└── navigation.blade.php # Sidebar + top bar with Alpine.js toggle
```

### Key Components

```
components/
├── nav-link.blade.php      # Active nav link with left border indicator
├── lang-switcher.blade.php # Globe dropdown with flag + checkmark
├── toast.blade.php         # Alpine toast with progress bar
├── modal.blade.php         # Reusable modal with focus trap + Esc close
├── breadcrumbs.blade.php   # Breadcrumb nav with home icon + chevrons
├── tooltip.blade.php       # Hover tooltip with arrow + transitions
└── ...
```

---

## 🚀 Installation

```bash
# 1. Clone the repository
git clone https://github.com/Bkhangg/Clothes_Ecommerce_Claude_UI.git
cd Clothes_Ecommerce_Claude_UI

# 2. Install dependencies
composer install
npm install

# 3. Environment setup
cp .env.example .env
php artisan key:generate

# 4. Configure database in .env
DB_DATABASE=loginpagemd
DB_USERNAME=root
DB_PASSWORD=

# 5. Run migrations & seeders
php artisan migrate
php artisan db:seed

# 6. Build frontend assets
npm run build

# 7. Serve
php artisan serve
```

### Default Admin Account

| Field    | Value              |
|----------|--------------------|
| Email    | `admin@bkdesu.com` |
| Password | `password`         |

> The seeder creates this account automatically if it doesn't exist.

---

## 📸 Screenshots

<details>
<summary>🖥️ Click to expand screenshots</summary>

<br>

| Page | Preview |
|------|---------|
| **Login** | `Coming soon — add your screenshots here` |
| **Dashboard** | `Coming soon — add your screenshots here` |
| **Categories (Desktop)** | `Coming soon — add your screenshots here` |
| **Categories (Mobile)** | `Coming soon — add your screenshots here` |
| **Profile** | `Coming soon — add your screenshots here` |

</details>

---

## 🧭 Roadmap

- [x] Authentication scaffold (Breeze Blade)
- [x] Profile management
- [x] Category CRUD
- [x] Search / Filter / Sort / Paginate
- [x] Bulk delete
- [x] Toast notifications
- [x] Delete confirmation modal with password
- [x] Bilingual EN/VI
- [x] Responsive sidebar + top bar
- [x] Custom 404 error page

---

## 🛠️ Tech Stack

<div align="center">

| Frontend | Backend | Database | Tooling |
|----------|---------|----------|---------|
| Blade  | Laravel 13 | MySQL 8 | Vite |
| Tailwind CSS 4 | PHP 8.3 | | npm |
| Alpine.js 3 | | | Composer |

</div>

---

## 📄 License

This project is open-sourced under the [MIT license](https://opensource.org/licenses/MIT).

---

<div align="center">
  <sub>Built with ❤️ by BKhanggDesu</sub>
  <br>
  <sub>Powered by Laravel + Claude AI</sub>
</div>
