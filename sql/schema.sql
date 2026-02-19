-- ==============================
-- Saarr’s Modesty Webshop
-- Database schema (MBO-4 proof)
-- ==============================

CREATE DATABASE IF NOT EXISTS saarr_modesty
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE saarr_modesty;

-- ==============================
-- CATEGORIES
-- ==============================
CREATE TABLE categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  slug VARCHAR(80) NOT NULL UNIQUE,
  name_nl VARCHAR(120) NOT NULL,
  name_en VARCHAR(120) NOT NULL
) ENGINE=InnoDB;

-- ==============================
-- PRODUCTS
-- ==============================
CREATE TABLE products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  category_id INT NOT NULL,
  sku VARCHAR(50) NOT NULL UNIQUE,

  name_nl VARCHAR(200) NOT NULL,
  name_en VARCHAR(200) NOT NULL,
  description_nl TEXT,
  description_en TEXT,

  price DECIMAL(10,2) NOT NULL,
  is_active TINYINT(1) NOT NULL DEFAULT 1,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

  CONSTRAINT fk_products_category
    FOREIGN KEY (category_id) REFERENCES categories(id)
    ON DELETE RESTRICT,

  CONSTRAINT chk_price CHECK (price >= 0)
) ENGINE=InnoDB;

-- ==============================
-- PRODUCT IMAGES
-- ==============================
CREATE TABLE product_images (
  id INT AUTO_INCREMENT PRIMARY KEY,
  product_id INT NOT NULL,
  image_path VARCHAR(255) NOT NULL,
  alt_nl VARCHAR(200),
  alt_en VARCHAR(200),
  sort_order INT DEFAULT 0,

  CONSTRAINT fk_images_product
    FOREIGN KEY (product_id) REFERENCES products(id)
    ON DELETE CASCADE
) ENGINE=InnoDB;

-- ==============================
-- VARIANTS (maat + kleur + voorraad)
-- ==============================
CREATE TABLE variants (
  id INT AUTO_INCREMENT PRIMARY KEY,
  product_id INT NOT NULL,
  size VARCHAR(20) NOT NULL,
  color VARCHAR(40) NOT NULL,
  stock INT NOT NULL DEFAULT 0,
  sku_variant VARCHAR(80) NOT NULL UNIQUE,
  is_active TINYINT(1) NOT NULL DEFAULT 1,

  CONSTRAINT fk_variants_product
    FOREIGN KEY (product_id) REFERENCES products(id)
    ON DELETE RESTRICT,

  CONSTRAINT uq_variant UNIQUE (product_id, size, color),
  CONSTRAINT chk_stock CHECK (stock >= 0)
) ENGINE=InnoDB;

-- ==============================
-- USERS
-- ==============================
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(190) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  role ENUM('user','admin') NOT NULL DEFAULT 'user',
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ==============================
-- ORDERS
-- ==============================
CREATE TABLE orders (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NULL,
  order_number VARCHAR(30) NOT NULL UNIQUE,
  status ENUM('Pending','Paid_demo','Cancelled') NOT NULL DEFAULT 'Pending',
  language ENUM('nl','en') NOT NULL DEFAULT 'nl',

  customer_name VARCHAR(120) NOT NULL,
  email VARCHAR(190) NOT NULL,
  address VARCHAR(190) NOT NULL,
  postal_code VARCHAR(20) NOT NULL,
  city VARCHAR(80) NOT NULL,
  country VARCHAR(80) NOT NULL,

  subtotal DECIMAL(10,2) NOT NULL,
  total DECIMAL(10,2) NOT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

  CONSTRAINT fk_orders_user
    FOREIGN KEY (user_id) REFERENCES users(id)
    ON DELETE SET NULL,

  CONSTRAINT chk_subtotal CHECK (subtotal >= 0),
  CONSTRAINT chk_total CHECK (total >= 0)
) ENGINE=InnoDB;

-- ==============================
-- ORDER ITEMS
-- ==============================
CREATE TABLE order_items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  order_id INT NOT NULL,
  variant_id INT NOT NULL,

  product_snapshot VARCHAR(255) NOT NULL,
  variant_snapshot VARCHAR(255) NOT NULL,
  unit_price DECIMAL(10,2) NOT NULL,
  quantity INT NOT NULL,
  line_total DECIMAL(10,2) NOT NULL,

  CONSTRAINT fk_items_order
    FOREIGN KEY (order_id) REFERENCES orders(id)
    ON DELETE CASCADE,

  CONSTRAINT fk_items_variant
    FOREIGN KEY (variant_id) REFERENCES variants(id)
    ON DELETE RESTRICT,

  CONSTRAINT chk_quantity CHECK (quantity > 0)
) ENGINE=InnoDB;
