# ProStock POS

> Inventory and point-of-sale system

**Live demo:** https://prostok-pos.freedev.app

## Screenshots

![Login](docs/screenshots/login.png)
![Dashboard](docs/screenshots/dashboard.png)
![Pos](docs/screenshots/pos.png)

## Features

- Admin / Manager / Cashier roles
- Dashboard KPIs and sales chart
- Products, categories and customers
- Inventory stock in/out with low-stock alerts
- POS cart and checkout, sales history, printable invoices
- Sales and profit reports, store settings
- CSRF protection on every form, PDO prepared statements

## Tech stack

PHP 8 · MySQL (PDO) · Bootstrap 5 · Chart.js

## Demo login (local install)

| Role | Email / user | Password |
|---|---|---|
| Admin | `admin@prostock.local` | `Admin123!` |

These are the default credentials of the seed data. The live demo's admin password is private.

## Run locally (XAMPP)

1. Copy this folder to `C:\xampp\htdocs\ProStock_POS`
2. Start **Apache** and **MySQL** in XAMPP
3. Open phpMyAdmin → **Import** → `database/prostock.sql`
4. Check the database settings in `config/database.php` (default: host `localhost`, user `root`, empty password)
5. Open `http://localhost/ProStock_POS/`

### Deploying to shared hosting

Create an empty database in your hosting panel, delete the `CREATE DATABASE` / `USE` / `DROP DATABASE` lines at the top of `database/prostock.sql`, import it, then put the host's database name, user and password in `config/database.php`.

## Notes

Portfolio / demo project. Before real production use add HTTPS, rate limiting, audit logs, backups and environment-based configuration.

## Author

Built by [natnaelameha213](https://github.com/natnaelameha213).
