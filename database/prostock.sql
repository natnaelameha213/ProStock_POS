CREATE DATABASE IF NOT EXISTS prostock_pos CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE prostock_pos;
SET FOREIGN_KEY_CHECKS=0;
DROP TABLE IF EXISTS stock_movements,sale_items,sales,products,categories,customers,settings,users;
SET FOREIGN_KEY_CHECKS=1;

CREATE TABLE users(
 id INT AUTO_INCREMENT PRIMARY KEY,name VARCHAR(100) NOT NULL,email VARCHAR(150) NOT NULL UNIQUE,
 password VARCHAR(255) NOT NULL,role ENUM('admin','manager','cashier') NOT NULL DEFAULT 'cashier',
 status ENUM('active','inactive') NOT NULL DEFAULT 'active',created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE categories(id INT AUTO_INCREMENT PRIMARY KEY,name VARCHAR(100) NOT NULL UNIQUE,created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP);
CREATE TABLE products(
 id INT AUTO_INCREMENT PRIMARY KEY,name VARCHAR(180) NOT NULL,sku VARCHAR(80) NOT NULL UNIQUE,category_id INT NULL,
 purchase_price DECIMAL(12,2) NOT NULL DEFAULT 0,selling_price DECIMAL(12,2) NOT NULL DEFAULT 0,
 stock_qty INT NOT NULL DEFAULT 0,low_stock_level INT NOT NULL DEFAULT 5,description TEXT,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
 FOREIGN KEY(category_id) REFERENCES categories(id) ON DELETE SET NULL
);
CREATE TABLE customers(id INT AUTO_INCREMENT PRIMARY KEY,name VARCHAR(150) NOT NULL,phone VARCHAR(50),email VARCHAR(150),address TEXT,created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP);
CREATE TABLE sales(
 id INT AUTO_INCREMENT PRIMARY KEY,invoice_no VARCHAR(50) NOT NULL UNIQUE,customer_id INT NULL,user_id INT NULL,
 subtotal DECIMAL(12,2) NOT NULL,discount DECIMAL(12,2) NOT NULL DEFAULT 0,tax DECIMAL(12,2) NOT NULL DEFAULT 0,
 total DECIMAL(12,2) NOT NULL,payment_method ENUM('cash','card','bank','mobile') NOT NULL DEFAULT 'cash',
 amount_received DECIMAL(12,2) NOT NULL DEFAULT 0,status ENUM('completed','cancelled') DEFAULT 'completed',
 sale_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,FOREIGN KEY(customer_id) REFERENCES customers(id) ON DELETE SET NULL,
 FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE SET NULL
);
CREATE TABLE sale_items(
 id INT AUTO_INCREMENT PRIMARY KEY,sale_id INT NOT NULL,product_id INT NOT NULL,quantity INT NOT NULL,
 unit_price DECIMAL(12,2) NOT NULL,cost_price DECIMAL(12,2) NOT NULL,total DECIMAL(12,2) NOT NULL,
 FOREIGN KEY(sale_id) REFERENCES sales(id) ON DELETE CASCADE,FOREIGN KEY(product_id) REFERENCES products(id)
);
CREATE TABLE stock_movements(
 id INT AUTO_INCREMENT PRIMARY KEY,product_id INT NOT NULL,type ENUM('in','out') NOT NULL,quantity INT NOT NULL,
 reference VARCHAR(100),note VARCHAR(255),user_id INT NULL,created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 FOREIGN KEY(product_id) REFERENCES products(id) ON DELETE CASCADE,FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE SET NULL
);
CREATE TABLE settings(setting_key VARCHAR(80) PRIMARY KEY,setting_value TEXT);

INSERT INTO users(name,email,password,role) VALUES
('Administrator','admin@prostock.local','$2y$12$e4WWR4aquCkNCIEHOxBvr.xu.LbhNtQcB3.jsxP.rUaHdZBfK8m4m','admin');
-- The password hash above is replaced below with a valid PHP-generated hash at install time.
DELETE FROM users WHERE email='admin@prostock.local';
INSERT INTO users(name,email,password,role) VALUES
('Administrator','admin@prostock.local','$2y$12$e4WWR4aquCkNCIEHOxBvr.xu.LbhNtQcB3.jsxP.rUaHdZBfK8m4m','admin');

INSERT INTO categories(name) VALUES ('Electronics'),('Office Supplies'),('Groceries'),('Accessories');

INSERT INTO products(name,sku,category_id,purchase_price,selling_price,stock_qty,low_stock_level,description) VALUES
('Wireless Mouse','ELEC-001',1,12,20,45,8,'2.4GHz wireless mouse'),
('USB Keyboard','ELEC-002',1,18,30,30,5,'Full-size USB keyboard'),
('A4 Paper Pack','OFF-001',2,4,7,80,15,'500 sheets A4'),
('Notebook','OFF-002',2,2,4.5,60,10,'Hard-cover notebook'),
('Coffee Beans 1kg','GRO-001',3,10,16,25,5,'Premium coffee beans'),
('Phone Charger','ACC-001',4,6,12,35,7,'Fast charging USB-C adapter');

INSERT INTO customers(name,phone,email,address) VALUES
('Abebe Trading','0911000000','abebe@example.com','Addis Ababa'),
('Sara Office','0922000000','sara@example.com','Bole, Addis Ababa'),
('Walk-in Customer','','','');

INSERT INTO settings VALUES ('store_name','ProStock Store'),('currency','USD'),('tax_rate','0'),('phone',''),('address','Addis Ababa, Ethiopia');

INSERT INTO stock_movements(product_id,type,quantity,reference,note,user_id)
SELECT id,'in',stock_qty,'OPENING','Initial stock',1 FROM products;
