# MediCare Plus — Hospital Management System

> **Your Health, Our Priority**

A full-featured Hospital Management System built with **PHP**, **MySQL**, and **Bootstrap 4**. MediCare Plus streamlines the workflow between patients, doctors, and administrators — from appointment booking and prescription management to emergency ambulance booking and PDF report generation.

---

## Features

- Patient self-registration and appointment booking
- Doctor dashboard to view and manage appointments
- Admin panel to oversee patients, doctors, appointments, and feedback
- **Ambulance booking** — public emergency form (no login required), with admin status tracking
- In-app chatbot for basic patient guidance
- PDF prescription generation using TCPDF
- Search functionality for patients, doctors, appointments, and messages
- Appointment cancellation by both patients and doctors
- Doctor management (add/remove) by admin
- Contact/feedback form with admin view
- Multi-theme and color scheme support (10 background themes, 10 color schemes)
- Payment status management for appointments

---

## Tech Stack

| Layer | Technology |
|---|---|
| Frontend | HTML5, CSS3, Bootstrap 4, JavaScript |
| Backend | PHP 7+ |
| Database | MySQL |
| PDF Generation | TCPDF |
| Rich Text | CKEditor |
| Local Server | XAMPP (Apache + MySQL) |

---

## Prerequisites

Before running this project, make sure you have the following installed:

1. **XAMPP** (includes Apache and MySQL) — [Download here](https://www.apachefriends.org/)
2. A code editor such as **VS Code** or **Sublime Text**
3. Any modern web browser (Chrome, Firefox, Edge)

---

## Getting Started

Follow these steps to set up the project on your local machine:

### 1. Clone the Repository

```bash
git clone https://github.com/prakhar9936/Medicare-plus.git
```

### 2. Move Files to XAMPP

Copy the project folder into the `htdocs` directory of your XAMPP installation:

- **Windows:** `C:\xampp\htdocs\`
- **Linux/macOS:** `/opt/lampp/htdocs/`

### 3. Start XAMPP Services

Open the XAMPP Control Panel and start both **Apache** and **MySQL**.

### 4. Set Up the Database

1. Open your browser and go to `http://localhost/phpmyadmin`
2. Create a new database named: `myhmsdb`
3. Select the database, go to the **Import** tab
4. Import the main file: `myhmsdb.sql` (found in the project root)
5. Click **Go**

#### Enable Ambulance Booking (Additional Step)

The ambulance feature requires an extra table. After importing the main SQL:

1. In phpMyAdmin, select `myhmsdb`
2. Go to the **SQL** tab
3. Paste and run the contents of `ambulance_migration.sql`

### 5. Launch the Application

Open your browser and navigate to:

```
http://localhost/Medicare-plus/
```

---

## Default Admin Credentials

```
Username: admin
Password: admin123
```

> ⚠️ **Change these credentials immediately** in a production environment.

---

## Project Structure

```
Medicare-plus/
├── index.php                  # Home page (Patient/Doctor/Admin login & Patient Registration)
├── index1.php                 # Secondary login entry
├── admin-panel.php            # Admin dashboard
├── admin-panel1.php           # Extended admin panel
├── doctor-panel.php           # Doctor dashboard
├── func.php                   # Core logic & database handlers
├── func1.php / func2.php      # Additional function files
├── func3.php                  # Admin authentication & payment functions
├── newfunc.php                # Specialization & doctor display helpers
├── ambulance.php              # Public ambulance booking form
├── ambulance_func.php         # Ambulance booking & status update handler
├── ambulance_migration.sql    # SQL to create the ambulancetb table
├── chatbot.php                # Chatbot interface
├── prescribe.php              # Prescription management
├── contact.php                # Contact / feedback form
├── search.php                 # General search
├── appsearch.php              # Appointment search
├── patientsearch.php          # Patient search
├── doctorsearch.php           # Doctor search
├── messearch.php              # Message/feedback search
├── header.php                 # Shared navigation header
├── logout.php / logout1.php   # Session logout handlers
├── error.php / error1.php / error2.php  # Error pages
├── myhmsdb.sql                # Main database schema and seed data
├── assets/                    # JS, CSS, images
├── bodybg/                    # 10 background theme CSS files
├── color/                     # 10 color scheme CSS files
├── TCPDF/                     # PDF generation library
├── vendor/                    # CKEditor and other vendors
├── services.html              # Static services page
├── contact.html / contact.css # Static contact page
└── README.md
```

---

## Modules

### Patient Module
- Register a new account
- Log in and access personal dashboard
- Book appointments with available doctors (filtered by specialization)
- View appointment history and status
- Cancel upcoming appointments

### Doctor Module
- Log in to personal dashboard
- View all assigned patient appointments
- Search patients by contact number
- Cancel appointments

### Admin Module
- View and manage all registered patients
- View and manage all registered doctors (add / remove)
- View all appointment records
- Manage appointment payment status
- Read user feedback and queries submitted via the Contact page
- View and update ambulance booking requests (Pending → Dispatched → Completed / Cancelled)

### Ambulance Module *(New)*
- Public-facing emergency booking form — **no login required**
- Fields: Caller name, contact number, pickup address, drop location, emergency type, patient condition
- Admin can track and update booking status: `Pending`, `Dispatched`, `Completed`, `Cancelled`
- Requires running `ambulance_migration.sql` to create the `ambulancetb` table

---

## Themes & Customization

MediCare Plus supports visual customization out of the box:

- **10 background themes** — located in `/bodybg/` (bg1.css – bg10.css)
- **10 color schemes** — located in `/color/` (default, blue, green, red, orange, yellow, lime, pink, amethyst, sand)

---

## Planned Improvements

- [ ] Doctor appointment approval/rejection with patient notification
- [ ] Prevent duplicate registration with the same email address
- [ ] Implement password hashing (bcrypt)
- [ ] Add pagination across all list views
- [ ] Fix billing receipt duplication for repeated doctor visits
- [ ] Expand prescription form with more clinical fields
- [ ] Add payment details (date, amount, method) to billing section
- [ ] Admin export to Excel for patient/doctor/appointment data
- [ ] Real-time ambulance tracking / ETA notification

---

## Known Issues

- Passwords are currently stored in plain text — **do not use real credentials** in development.
- Bill payment receipt may show duplicate records if a patient visits the same doctor more than once.
- The ambulance feature requires a separate SQL migration (`ambulance_migration.sql`) — it is not included in the main `myhmsdb.sql` import.

---

## License

This project is open-source and available under the [MIT License](LICENSE).

---

## Author

Developed by **Prakhar Agrawal**
