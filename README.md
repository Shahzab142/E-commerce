# Khyber Pro - E-Commerce Platform

A modern, high-performance E-Commerce & Operations Management platform built with **Laravel 12**, **Livewire 3 / Volt**, and **Bootstrap 5**.

---

## 🌟 Key Features

- **Multi-Role Portal:**
  - **Admin:** Dashboard analytics, low stock alerts, product & category CRUD, user & employee management, soft-delete recycle bin, activity logs, excel reports.
  - **Employee:** Product reservations (2-hour countdown timer), reservation-to-order creation with payment receipt proof, order status updates, Excel report generation.
  - **Customer / User:** Product catalog, search with auto-suggest, product comparison, cart, wishlist, coupon codes, multi-payment checkout (Stripe, Cash on Delivery, Jazzcash, Easypaisa, PayPal), order tracking, reviews with photos.
- **Excel Reporting:** Custom date-range Excel report generator for orders, plus 1-click exports for categories, products, orders, and users.
- **Multi-Database Support:** Fully compatible with MySQL, PostgreSQL, and SQLite.

---

## 🔐 Default Demo Accounts (Automated Seeders)

| Role | Email | Password |
|---|---|---|
| **Admin** | `admin@khyberpro.com` | `password123` |
| **Employee** | `employee@khyberpro.com` | `password123` |
| **Customer** | `user@khyberpro.com` | `password123` |

---

## 🚀 Deployment on Render

This repository includes a production-ready `Dockerfile` and `render.yaml` blueprint.

### Option A: 1-Click Blueprint (Recommended)
1. In the [Render Dashboard](https://dashboard.render.com/), click **New +** -> **Blueprint**.
2. Connect your GitHub repository (`Shahzab142/E-commerce`).
3. Render will automatically read `render.yaml`, provision a free PostgreSQL database, build the Docker container, run migrations, and launch your application!

### Option B: Web Service
1. Click **New +** -> **Web Service**.
2. Connect your repository.
3. Select **Docker** environment.
4. Set the environment variables:
   - `APP_ENV`: `production`
   - `APP_KEY`: Generate using `php artisan key:generate --show`
   - `DB_CONNECTION`: `pgsql` (or `mysql`)
   - `DATABASE_URL`: Connection string from your database.
5. Deploy!
