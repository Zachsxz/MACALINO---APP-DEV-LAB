-- =====================================================================
--  ALLI IN TIMEPIECES  -  Database Schema
--  Plain MySQL / MySQLi project (no ORM / no framework)
-- =====================================================================

CREATE DATABASE IF NOT EXISTS alli_timepieces
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE alli_timepieces;

-- ---------------------------------------------------------------------
-- 1. ADMINS / SELLER-SIDE USERS
-- ---------------------------------------------------------------------
CREATE TABLE admins (
  admin_id      INT AUTO_INCREMENT PRIMARY KEY,
  username      VARCHAR(50)  NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  full_name     VARCHAR(100) NOT NULL,
  role          ENUM('superadmin','admin') NOT NULL DEFAULT 'admin',
  status        ENUM('active','disabled') NOT NULL DEFAULT 'active',
  created_at    DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at    DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- NOTE: The initial superadmin account is created by running setup_admin.php
-- ONCE in your browser after importing this schema (see README.md).
-- That script generates a real PHP password_hash() for the seed password,
-- which cannot be safely hand-written into a .sql file.

-- ---------------------------------------------------------------------
-- 2. PRODUCT CATEGORIES  &  PRODUCTS (STOCKS)
-- ---------------------------------------------------------------------
CREATE TABLE categories (
  category_id   INT AUTO_INCREMENT PRIMARY KEY,
  name          VARCHAR(80) NOT NULL UNIQUE,
  description   VARCHAR(255) NULL
);

INSERT INTO categories (name, description) VALUES
('Dress Watches',        'Slim, formal timepieces for business and evening wear'),
('Chronographs',         'Multi-function sports and racing inspired watches'),
('Divers Watches',       'Water-resistant, rugged tool watches'),
('Skeleton & Mechanical','Open-heart and automatic movement showcases'),
('Smart Hybrid',         'Classic looks with modern hybrid smart features');

CREATE TABLE products (
  product_id    INT AUTO_INCREMENT PRIMARY KEY,
  category_id   INT NOT NULL,
  name          VARCHAR(120) NOT NULL,
  brand         VARCHAR(80)  NOT NULL,
  description   TEXT NULL,
  price         DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  stock_qty     INT NOT NULL DEFAULT 0,
  image_url     VARCHAR(255) NULL,
  status        ENUM('active','archived') NOT NULL DEFAULT 'active',
  created_at    DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at    DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (category_id) REFERENCES categories(category_id)
);

INSERT INTO products (category_id, name, brand, description, price, stock_qty, image_url) VALUES
(1, 'Alli Meridian Classic',   'Alli In House', 'A slim 38mm dress watch with a sunburst navy dial and genuine leather strap.', 12999.00, 15, 'assets/img/products/meridian-classic.svg'),
(1, 'Alli Heritage Rose',     'Alli In House', 'Rose-gold plated case, champagne dial, sapphire crystal.', 15999.00, 10, 'assets/img/products/heritage-rose.svg'),
(2, 'Alli Velocity Chrono',   'Alli In House', 'Tri-register chronograph with tachymeter bezel, stainless steel bracelet.', 18999.00, 8, 'assets/img/products/velocity-chrono.svg'),
(2, 'Alli Apex Racer',        'Alli In House', 'Motorsport inspired chronograph with perforated leather strap.', 17499.00, 6, 'assets/img/products/apex-racer.svg'),
(3, 'Alli Abyssal 300',       'Alli In House', '300m water resistant diver with unidirectional bezel and lume markers.', 21999.00, 12, 'assets/img/products/abyssal-300.svg'),
(4, 'Alli Skeleton Automatic','Alli In House', 'Open-heart automatic movement, visible gears, exhibition case back.', 25999.00, 5, 'assets/img/products/skeleton-auto.svg'),
(5, 'Alli Hybrid Connect',    'Alli In House', 'Classic analog face with hidden hybrid smart notifications.', 13999.00, 20, 'assets/img/products/hybrid-connect.svg');

-- ---------------------------------------------------------------------
-- 3. CUSTOMERS (BUYER-SIDE ACCOUNTS)
-- ---------------------------------------------------------------------
CREATE TABLE customers (
  customer_id     INT AUTO_INCREMENT PRIMARY KEY,
  full_name       VARCHAR(150) NOT NULL,
  email           VARCHAR(150) NOT NULL UNIQUE,
  password_hash   VARCHAR(255) NOT NULL,
  address         VARCHAR(255) NOT NULL,
  contact_number  VARCHAR(30)  NOT NULL,
  is_confirmed    TINYINT(1) NOT NULL DEFAULT 0,
  confirm_token   VARCHAR(64) NULL,
  created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- ---------------------------------------------------------------------
-- 4. CART
-- ---------------------------------------------------------------------
CREATE TABLE cart_items (
  cart_id       INT AUTO_INCREMENT PRIMARY KEY,
  customer_id   INT NOT NULL,
  product_id    INT NOT NULL,
  quantity      INT NOT NULL DEFAULT 1,
  added_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (customer_id) REFERENCES customers(customer_id) ON DELETE CASCADE,
  FOREIGN KEY (product_id)  REFERENCES products(product_id)  ON DELETE CASCADE,
  UNIQUE KEY uniq_cart_item (customer_id, product_id)
);

-- ---------------------------------------------------------------------
-- 5. ORDERS  (created at checkout / payment step)
-- ---------------------------------------------------------------------
CREATE TABLE orders (
  order_id        INT AUTO_INCREMENT PRIMARY KEY,
  customer_id     INT NOT NULL,
  order_date      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  shipping_address VARCHAR(255) NOT NULL,
  contact_number  VARCHAR(30) NOT NULL,
  payment_method  ENUM('cod','bank_transfer','credit_card') NOT NULL,
  total_amount    DECIMAL(10,2) NOT NULL,
  status          ENUM('pending','paid','processing','completed','cancelled') NOT NULL DEFAULT 'pending',
  FOREIGN KEY (customer_id) REFERENCES customers(customer_id)
);

CREATE TABLE order_items (
  order_item_id INT AUTO_INCREMENT PRIMARY KEY,
  order_id      INT NOT NULL,
  product_id    INT NOT NULL,
  product_name  VARCHAR(120) NOT NULL,
  quantity      INT NOT NULL,
  unit_price    DECIMAL(10,2) NOT NULL,
  FOREIGN KEY (order_id)   REFERENCES orders(order_id) ON DELETE CASCADE,
  FOREIGN KEY (product_id) REFERENCES products(product_id)
);

-- ---------------------------------------------------------------------
-- 6. AUDIT LOG  (tracks activity of whoever is logged in - admin side)
-- ---------------------------------------------------------------------
CREATE TABLE audit_log (
  log_id       INT AUTO_INCREMENT PRIMARY KEY,
  user_type    ENUM('admin','customer') NOT NULL,
  user_id      INT NOT NULL,
  username     VARCHAR(150) NOT NULL,
  action       VARCHAR(100) NOT NULL,
  details      VARCHAR(500) NULL,
  ip_address   VARCHAR(45)  NULL,
  created_at   DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);
