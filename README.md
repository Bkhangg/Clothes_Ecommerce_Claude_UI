<div align="center">
  <h1>BKhanggDesu — Clothes E-commerce Claude UI</h1>
  <p align="center">
    Ứng dụng web Laravel quản lý sản phẩm thời trang.<br>
    Xây dựng với <strong>Heritage</strong> design system — phong cách flat, tối giản, đề cao typography.<br>
    Hỗ trợ song ngữ Anh — Việt.
  </p>

  <p align="center">
    Admin panel cho website bán quần áo thương mại điện tử,<br>
    bao gồm xác thực người dùng, quản lý danh mục, thương hiệu, sản phẩm và hệ thống UI chỉn chu.
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

## ✨ Tính năng

| Khu vực | Chi tiết |
|---------|----------|
| **Xác thực** | Đăng nhập, Đăng ký, Quên mật khẩu, Xác thực email, Xác nhận mật khẩu |
| **Quản lý hồ sơ** | Cập nhật tên/email, đổi mật khẩu, xóa tài khoản |
| **Danh mục** | CRUD đầy đủ với tìm kiếm, lọc, sắp xếp, phân trang |
| **Thương hiệu** | Quản lý thương hiệu sản phẩm |
| **Sản phẩm** | CRUD đầy đủ, tìm kiếm, lọc theo danh mục/thương hiệu/trạng thái, sắp xếp theo giá/tên/ngày |
| **Ảnh sản phẩm** | Ảnh chính + gallery nhiều ảnh phụ, xem lightbox với điều hướng |
| **CKEditor** | Soạn thảo mô tả sản phẩm với heading, in đậm, in nghiêng, liên kết, bảng, danh sách |
| **Select tìm kiếm** | Tìm kiếm danh mục/thương hiệu trong dropdown khi tạo/sửa sản phẩm |
| **Quản lý nhân viên** | CRUD nhân viên với role (admin/employee), bật/tắt qua feature flag `EMPLOYEE_MANAGEMENT` |
| **Phân quyền (Gate)** | Nhân viên bị giới hạn quyền theo role, admin toàn quyền |
| **Xóa hàng loạt** | Chọn tất cả / bỏ chọn, xóa hàng loạt với modal xác nhận |
| **Xác thực mật khẩu khi xóa** | Nhập mật khẩu 1 lần mỗi phiên, các lần sau chỉ xác nhận |
| **Toast thông báo** | Thông báo toast bằng Alpine.js với thanh tiến trình, hiệu ứng, tự động ẩn |
| **Chuyển ngôn ngữ** | Tiếng Anh / Tiếng Việt qua dropdown |
| **Responsive** | Sidebar desktop + hamburger mobile |
| **Định dạng tiền tệ** | VND với dấu chấm phân cách (VD: 2.750.000 ₫), helper `Currency::format()` |

---

## 🎨 Heritage Design System

Phong cách flat, tối giản, xoay quanh typography và điểm nhấn màu sắc hạn chế.

```yaml
Màu sắc:
  primary:   '#1A1C1E'   # Đen đậm
  secondary: '#6C7278'   # Xám ấm
  tertiary:  '#B8422E'   # Cam đỏ (điểm nhấn duy nhất)
  neutral:   '#F7F5F2'   # Trắng kem ấm
  surface:   '#FFFFFF'   # Trắng

Typography:
  display: 'Fraunces'     # Serif cho h1 / heading lớn
  body:    'Public Sans'  # Sans-serif cho đoạn văn
  label:   'Space Grotesk' # Monoline cho nhãn / chữ hoa

Bo góc:  2px / 4px / 8px
```

---

## 🏗️ Kiến trúc

```
routes/web.php             → Chuyển ngôn ngữ, danh mục, thương hiệu, sản phẩm, nhân viên, hồ sơ
app/Http/Controllers/      → CategoryController, BrandController, ProductController, EmployeeController, ProfileController, LanguageController
app/Http/Requests/         → StoreProductRequest, UpdateProductRequest
app/Http/Middleware/       → SetLocale (ngôn ngữ theo phiên), EnsureEmployeeEnabled (feature flag)
app/Providers/             → AppServiceProvider (Gates: manage-products, manage-categories, manage-employees)
app/Models/                → Category, Brand, Product, ProductImage, User (role + is_active)
app/Helpers/               → Currency.php (định dạng VND/USD)
resources/views/           → Blade template tổ chức theo tính năng
lang/en/ & lang/vi/       → Toàn bộ chuỗi UI + thông báo validation
database/factories/        → CategoryFactory, BrandFactory, ProductFactory
database/seeders/          → Admin user + 25 danh mục + 15 thương hiệu + 20 sản phẩm
```

### Cấu trúc Layout

```
layouts/
├── app.blade.php        # Layout đã xác thực (sidebar + thanh trên + nội dung)
├── guest.blade.php      # Layout khách (thẻ trung tâm + thương hiệu)
└── navigation.blade.php # Sidebar + thanh trên với Alpine.js
```

### Component chính

```
components/
├── searchable-select.blade.php # Select có ô tìm kiếm (Alpine.js)
├── nav-link.blade.php         # Link điều hướng active có border trái
├── lang-switcher.blade.php    # Dropdown chuyển ngôn ngữ
├── toast.blade.php            # Thông báo toast Alpine với thanh tiến trình
├── modal.blade.php            # Modal dùng lại với focus trap + Esc
├── breadcrumbs.blade.php      # Breadcrumb với icon home + chevron
├── tooltip.blade.php          # Tooltip hover với mũi tên + hiệu ứng
└── ...
```

### Cấu trúc Products

```
products/
├── index.blade.php          # Danh sách: bảng (desktop) + thẻ (mobile), thao tác hàng loạt, lightbox gallery
├── create.blade.php         # Form thêm: các khu vực, upload gallery, CKEditor
├── edit.blade.php           # Form sửa: gallery hiện có + upload mới, CKEditor
└── partials/
    └── empty-state.blade.php # Trạng thái rỗng

### Cấu trúc Employees

```
employees/
├── index.blade.php          # Danh sách: bảng (desktop) + thẻ (mobile), thao tác hàng loạt
├── create.blade.php         # Form thêm nhân viên
├── edit.blade.php           # Form sửa nhân viên (kèm active/inactive)
└── partials/
    └── empty-state.blade.php # Trạng thái rỗng
```
```

---

## 🚀 Cài đặt

```bash
# 1. Clone repository
git clone https://github.com/Bkhangg/Clothes_Ecommerce_Claude_UI.git
cd Clothes_Ecommerce_Claude_UI

# 2. Cài dependencies
composer install
npm install

# 3. Cấu hình môi trường
cp .env.example .env
php artisan key:generate

# 4. Cấu hình database trong .env
DB_DATABASE=loginpagemd
DB_USERNAME=root
DB_PASSWORD=

# Bật/tắt quản lý nhân viên
EMPLOYEE_MANAGEMENT=false

# 5. Chạy migration & seeder
php artisan migrate
php artisan db:seed

# 6. Tạo storage link
php artisan storage:link

# 7. Build frontend
npm run build

# 8. Chạy server
php artisan serve
```

### Tài khoản Admin mặc định

| Trường   | Giá trị             |
|----------|---------------------|
| Email    | `admin@bkdesu.com`  |
| Mật khẩu | `password`          |

> Seeder tự động tạo tài khoản này nếu chưa tồn tại.

---

## 📸 Ảnh chụp màn hình

<details>
<summary>🖥️ Bấm để xem ảnh chụp</summary>

<br>

| Trang | Xem trước |
|-------|-----------|
| **Đăng nhập** | `Sắp có` |
| **Dashboard** | `Sắp có` |
| **Danh mục (Desktop)** | `Sắp có` |
| **Danh mục (Mobile)** | `Sắp có` |
| **Sản phẩm (Desktop)** | `Sắp có` |
| **Sản phẩm (Mobile)** | `Sắp có` |
| **Thêm sản phẩm** | `Sắp có` |
| **Hồ sơ** | `Sắp có` |

</details>

---

## 🧭 Lộ trình

- [x] Xác thực (Breeze Blade)
- [x] Quản lý hồ sơ
- [x] CRUD danh mục
- [x] CRUD thương hiệu
- [x] CRUD sản phẩm
- [x] Quản lý nhân viên (feature flag, role admin/employee, Gate phân quyền)
- [x] Gallery ảnh phụ (nhiều ảnh)
- [x] CKEditor cho mô tả sản phẩm
- [x] Select tìm kiếm cho danh mục/thương hiệu
- [x] Lightbox gallery với điều hướng
- [x] Định dạng VND với preview real-time
- [x] Tìm kiếm / Lọc / Sắp xếp / Phân trang
- [x] Xóa hàng loạt
- [x] Xác thực mật khẩu khi xóa (1 lần/phiên)
- [x] Toast thông báo
- [x] Song ngữ EN/VI
- [x] Responsive sidebar + thanh trên
- [x] Trang lỗi 404 tùy chỉnh

---

## 🛠️ Công nghệ

<div align="center">

| Giao diện | Backend | Cơ sở dữ liệu | Công cụ |
|-----------|---------|---------------|---------|
| Blade  | Laravel 13 | MySQL 8 | Vite |
| Tailwind CSS 4 | PHP 8.3 | | npm |
| Alpine.js 3 | | | Composer |
| CKEditor 5 | | | |

</div>

---

## 📄 Giấy phép

Dự án được cấp phép dưới [MIT license](https://opensource.org/licenses/MIT).

---

<div align="center">
  <sub>Xây dựng với ❤️ bởi BKhanggDesu</sub>
  <br>
  <sub>Powered by Laravel + Claude AI</sub>
</div>
