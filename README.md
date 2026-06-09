# PLAYAQ - Certified Handyman Services & Booking Platform

PLAYAQ is a premium, secure, and modern Laravel MVC-based web application designed to connect clients in the Klang Valley with highly-rated local professionals for plumbing, painting, and appliance services.

---

## Project Objectives

- Build a searchable platform for verified home maintenance professionals.
- Provide a transparent booking and payment system.
- Improve service quality through ratings and reviews.
- Offer professionals a dashboard to manage services and earnings.
- Connect customers and providers through direct communication.

---

## 👥 Group Members
* **Member 1:** Anis Daniyah binti Mohd Faizal (2419018)
* **Member 2:** Anis Asna binti Amin (2415028)
* **Member 3:** Hana Imani binti Jalaludin (2413760)
* **Member 4:** Haifa Adani binti Hanafiah (2415106)
* **Member 5:** Balqees Hana binti Fairuzam (2419962)

---

## 📁 Project Deliverables
You can inspect our final project documents directly in this repository:
* 📄 **[Project Proposal](./docs/Proposal.pdf)** 
* 📄 **[Final Project Report](./docs/Report.pdf)** 

---

## 🌟 Core Features
1. **Interactive "Book Now" Wizard:** A 4-step client service matcher that takes description details, handles image uploads with live previewing, and dynamically matches clients with active handymen.
2. **Integrated Real-Time Chat:** A direct messaging thread allowing clients and handymen to coordinate schedules and details directly.
3. **Flexible Payment Gateway:** Secure 30% deposit holds supporting Credit Cards, Touch 'n Go / GrabPay eWallets, PayPal, and FPX Online Banking, with dynamic input validation.
4. **Client & Pro Dashboards:** Custom user panels. Handymen can accept jobs, review uploaded issue photos, and request instant earnings withdrawals. Clients can manage bookings, pay final balances, and submit ratings/reviews.
5. **Robust Database Migrations:** Fully structured relational tables (SQLite & MySQL compatible) with seeded test data.

---

## 🛠️ Technology Stack
* **Framework:** Laravel 11 (MVC architecture)
* **Frontend:** Blade Templating Engine, Tailwind CSS, Alpine.js, Lucide Icons
* **Database:** SQLite (Default / zero-config) or MySQL
* **Package Management:** Composer & NPM

---

## 🔑 Default Login Credentials
All accounts use the password: `password`

| Role | Name / Specialty | Email | Password |
| :--- | :--- | :--- | :--- |
| **Customer** | John Doe | `customer@playaq.com` | `password` |
| **Handyman** | Kim Saiful (Plumbing) | `saiful@playaq.com` | `password` |
| **Handyman** | Nikuku Minaj (Painting) | `nikuku@playaq.com` | `password` |
| **Handyman** | David Beckham (Appliance Repair) | `david@playaq.com` | `password` |
| **Handyman** | Jennifer Tan (Appliance Installation) | `jennifer@playaq.com` | `password` |

---

## 🚀 How to Setup and Run Locally
### Step 1: Clone the Repo into a Test Folder
Navigate to a different directory (e.g., your Desktop or Downloads) and run the following command to clone the repository into a new folder named `playaq-test`:
```bash
git clone https://github.com/balqeeshana/playaq-project-webapp.git playaq-test
```

### Step 2: Go into the Test Folder & Install Dependencies
Move into the cloned directory and install the required PHP dependencies using Composer:
```bash
cd playaq-test
composer install
```

### Step 3: Create the .env File
Since the .env file is excluded from Git, create a new one using the template provided in the project:

```powershell
Copy-Item .env.example .env
```

### Step 4: Setup Database (SQLite)
Open the newly created .env file in your editor and verify/set the database connection line to:
```ini
DB_CONNECTION=sqlite
```
Create the empty SQLite database file inside the database directory:
```powershell
New-Item -Path database\database.sqlite -ItemType File -Force
```

### Step 5: Generate Key & Migrate Database
Generate the application encryption key and run migrations to build and seed all default database tables:
```bash
php artisan key:generate
php artisan migrate:fresh --seed
```

### Step 6: Serve the Website
Start the local development server:
```bash
php artisan serve
```
Open http://127.0.0.1:8000 in your web browser to test the application.
