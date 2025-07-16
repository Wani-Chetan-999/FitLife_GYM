
# 🏋️ Fit Life Gym – Gym Management System

**Fit Life Gym** is a full-featured web-based Gym Management System designed to streamline operations for gym owners, trainers, and members. It includes modules for user authentication, membership tracking, workout scheduling, attendance logging, and payment management.

---

## 🌐 Live Demo
> _Optional: Add GitHub Pages/Netlify/hosted link if available_

---

## ⚙️ Tech Stack

- **Frontend:** HTML, CSS, JavaScript, Bootstrap
- **Backend:** PHP
- **Database:** MySQL
- **Tools:** XAMPP / WAMP for local server, phpMyAdmin

---

## 🧩 Core Modules / Menu List

### 👤 Member Features
- Signup/Login
- View/Edit profile
- Membership status
- Assigned trainer and workout plan
- Attendance log
- Payment history

### 🛠️ Admin Features
- Login Dashboard
- Add/Edit/Delete Members
- Assign trainers and plans
- View attendance reports
- Manage payments and invoices
- Add/edit workout plans and class schedules
- Send announcements to members

---

## 🔗 Database Connection

The database is created in **phpMyAdmin** (MySQL).

### 📁 `db.php` Example:
```php
<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "fit_life_gym";
$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
````



## 🖼️ Sample Screenshots

| 📸 Dashboard (Admin)                      | 📸 Member View                            |
| ----------------------------------------- | ----------------------------------------- |
| ![Admin](screenshots/admin_dashboard.png) | ![Member](screenshots/member_profile.png) |

> *Add your screenshots in a `screenshots/` folder and link them here.*

---

## 🚀 How to Run

1. Clone or download this repository
2. Install [XAMPP](https://www.apachefriends.org/index.html)
3. Move project folder to: `C:/xampp/htdocs/`
4. Start Apache and MySQL from XAMPP
5. Open [phpMyAdmin](http://localhost/phpmyadmin) → Import `fit_life_gym.sql`
6. Visit: [http://localhost/fit\_life\_gym](http://localhost/fit_life_gym)
7. Login:

   * Admin: `admin@gmail.com` / `admin123`
   * Member: Create via signup

---

## 📁 Folder Structure

```
fit_life_gym/
├── db.php
├── index.php
├── login.php
├── signup.php
├── admin/
│   ├── dashboard.php
│   ├── members.php
│   ├── payments.php
│   └── ...
├── member/
│   ├── profile.php
│   ├── attendance.php
│   └── ...
├── css/
├── js/
├── screenshots/
└── fit_life_gym.sql
```

---

## 🧠 Future Enhancements (Ideas)

* Send SMS/email reminders
* Payment gateway integration (Razorpay/Stripe)
* PDF Invoice generation
* Android/iOS companion app

---

## 🙋‍♂️ Author

**Chetan Wani**
📧 [chetanwani.dev@gmail.com](mailto:chetanwani.dev@gmail.com)
🌐 [linkedin.com/in/chetanwani](https://linkedin.com/in/chetanwani)
💻 [GitHub – ChetanWani](https://github.com/chetanwani) 

---

## 📜 License

This project is licensed under the MIT License – see the `LICENSE` file for details.
