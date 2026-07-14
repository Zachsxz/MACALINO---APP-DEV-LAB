# Alli In Timepieces

A two-part e-commerce web app (Seller/Admin + Buyer) for a fictional luxury
watch brand, built for a final-project requirement.

**Stack:** Core PHP (no framework) + MySQL (MySQLi) + Bootstrap 5 (CSS framework only).
No payment API is integrated — checkout/payment is simulated for the class project.

## 1. Requirements
- PHP 7.4+ (works with PHP 8.x)
- MySQL / MariaDB
- A web server (Apache/Nginx) or free hosting such as InfinityFree / AwardSpace

## 2. Local setup (XAMPP / similar)
1. Copy the whole `alli-in-timepieces` folder into `htdocs/`.
2. Create the database by importing `sql/schema.sql` in phpMyAdmin
   (this creates the `alli_timepieces` database, tables, categories, and sample products).
3. Edit `config/db.php` with your DB host/user/password/name.
4. Visit `http://localhost/alli-in-timepieces/setup_admin.php` **once** in your
   browser. This creates the seed Super Admin account:
   - Username: `superadmin`
   - Password: `Admin@123`
   Then delete or rename `setup_admin.php`.
5. Visit `index.php` to see the storefront, or `admin/login.php` for the seller side.

## 3. Hosting on InfinityFree (or AwardSpace)
1. Create a MySQL database in your hosting control panel and import `sql/schema.sql`
   via phpMyAdmin (adjust the `CREATE DATABASE` line if your host auto-creates one
   with a prefixed name, e.g. `epiz_123456_alli`).
2. Upload all project files via FTP (FileZilla) or the host's File Manager into
   `htdocs/` (InfinityFree) or your site's web root.
3. Update `config/db.php` with the DB host/user/pass/name given by your host.
4. Run `setup_admin.php` once via your live URL, then delete it.
5. For real email delivery on registration, configure your host's SMTP settings
   (InfinityFree provides an SMTP relay in some plans) or a `mail()`-compatible
   sendmail setup. If email doesn't send, the registration screen still shows
   the confirmation link on-screen so testing/grading is not blocked.

## 4. Folder structure
```
config/db.php          - database connection
includes/              - shared header/footer/functions (buyer side)
assets/css/style.css   - brand styling (Bootstrap + custom overrides)
assets/img/            - logo + product placeholder SVGs
index.php, about.php   - public pages
register.php, confirm.php, login.php, logout.php  - buyer accounts
store.php, cart.php, checkout.php, payment.php, order_success.php - shopping flow
admin/                 - seller/admin side
  login.php, logout.php, index.php (dashboard)
  users.php             - add/modify admin accounts (Super Admin only)
  products.php          - add/modify stock & prices
  reports_inventory.php - remaining inventory report
  reports_audit.php     - audit log of the logged-in admin's activity
sql/schema.sql          - full database schema + seed categories/products
setup_admin.php         - one-time script to create the seed Super Admin
sample_accounts.txt     - test accounts for grading
```

## 5. Notes for grading / defense
- Every page's footer includes the required educational-purpose disclaimer
  and the group name/logo.
- The Audit Log (admin/reports_audit.php) defaults to showing only the
  currently logged-in admin's activity, with a "View All" toggle for Super Admins.
- All form inputs use core PHP validation (`filter_var`, `preg_match`,
  required-field checks) and `mysqli_real_escape_string` / prepared-style
  escaping — no external validation libraries were used.
- Passwords are hashed with PHP's built-in `password_hash()` / `password_verify()`.
