# 🏛️ Barangay Complaint Analysis, Intervention, and Recommendation System

## 📋 Project Overview

A Laravel-based web system designed to simplify the process of filing, validating, and resolving citizen complaints at the barangay level. The system promotes transparency, accountability, and efficiency through verified citizen access, complaint tracking, and automated notifications.

## ✅ Implementation Status

### ✔️ Completed Features

1. **Database Structure** ✅
   - Users table with role-based fields (citizen, secretary, captain)
   - Complaint categories with Republic Act references
   - Complaints table with full tracking
   - Media library integration for evidence uploads
   - Notifications table for system alerts

2. **Authentication & Authorization** ✅
   - Laravel Breeze authentication
   - Role-based middleware (RoleMiddleware, VerifiedCitizenMiddleware)
   - Custom registration with National ID validation
   - Account verification workflow

3. **QR Code Generation** ✅
   - QR code service using Endroid/QR-Code
   - Automatic generation upon citizen verification
   - Stored in public storage
   - Contains citizen verification data

4. **Controllers** ✅
   - CitizenController - Citizen dashboard and QR code display
   - SecretaryController - User verification and complaint validation
   - CaptainController - Complaint resolution and reporting
   - ComplaintController - Full CRUD for complaints with media

5. **Seeders** ✅
   - AdminUserSeeder (Captain & Secretary accounts)
   - ComplaintCategorySeeder (11 pre-defined categories)

6. **Packages Installed** ✅
   - Laravel Breeze (Authentication)
   - Spatie Media Library (File uploads)
   - Endroid QR Code (QR generation)
   - DomPDF (PDF reports)

## 🚀 Getting Started

### Default Admin Accounts

**Barangay Captain:**
- Email: `captain@barangay.local`
- Password: `password`

**Barangay Secretary:**
- Email: `secretary@barangay.local`
- Password: `password`

### Testing the System

1. **Citizen Registration:**
   - Go to `/register`
   - Fill in all fields including National ID
   - Account will be pending verification

2. **Secretary Verification:**
   - Login as secretary
   - Navigate to pending users
   - Approve citizen accounts (QR code auto-generated)

3. **File a Complaint:**
   - Login as verified citizen
   - Go to Complaints → Create New
   - Select category, add description, upload evidence
   - Submit complaint

4. **Secretary Validation:**
   - Login as secretary
   - Review pending complaints
   - Validate or reject with notes
   - Forward to Captain

5. **Captain Resolution:**
   - Login as captain
   - View validated complaints
   - Provide resolution and recommendations
   - Mark as resolved

6. **Generate Reports:**
   - Login as captain
   - Navigate to Reports
   - Export PDF reports

## 📁 Project Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Auth/RegisteredUserController.php (Custom registration)
│   │   ├── CitizenController.php
│   │   ├── SecretaryController.php
│   │   ├── CaptainController.php
│   │   └── ComplaintController.php
│   └── Middleware/
│       ├── RoleMiddleware.php
│       └── VerifiedCitizenMiddleware.php
├── Models/
│   ├── User.php (Extended with roles)
│   ├── Complaint.php (With media library)
│   └── ComplaintCategory.php
├── Services/
│   └── QRCodeService.php
└── Notifications/
    └── AccountVerified.php

database/
├── migrations/
│   ├── *_add_role_fields_to_users_table.php
│   ├── *_create_complaint_categories_table.php
│   ├── *_create_complaints_table.php
│   ├── *_create_media_table.php
│   └── *_create_notifications_table.php
└── seeders/
    ├── AdminUserSeeder.php
    └── ComplaintCategorySeeder.php

resources/views/
├── auth/
│   └── register.blade.php (Custom with citizen fields)
├── verification-pending.blade.php
├── citizen/ (To be completed)
├── secretary/ (To be completed)
├── captain/ (To be completed)
└── complaints/ (To be completed)
```

## 🎨 Frontend - Next Steps

The views need to be created with modern, clean UI using Tailwind CSS (already installed with Breeze). Here's what needs to be built:

### Required Views:

1. **Welcome Page** (`welcome.blade.php`)
   - Modern landing page
   - Features showcase
   - How it works section

2. **Citizen Views** (`resources/views/citizen/`)
   - `dashboard.blade.php` - Stats and recent complaints
   - `complaints.blade.php` - List all complaints
   - `qr-code.blade.php` - Display QR code

3. **Secretary Views** (`resources/views/secretary/`)
   - `dashboard.blade.php` - Pending verifications & complaints
   - `pending-users.blade.php` - User verification list
   - `pending-complaints.blade.php` - Complaint validation list

4. **Captain Views** (`resources/views/captain/`)
   - `dashboard.blade.php` - Overview & stats
   - `complaints.blade.php` - All complaints with filters
   - `complaint-show.blade.php` - Detailed complaint view
   - `reports.blade.php` - Analytics dashboard
   - `reports-pdf.blade.php` - PDF template

5. **Complaint Views** (`resources/views/complaints/`)
   - `index.blade.php` - Complaint list
   - `create.blade.php` - File new complaint
   - `edit.blade.php` - Edit pending complaint
   - `show.blade.php` - View complaint details

## 🔧 Key Features Implementation

### ✅ Implemented:
- ✅ Role-based authentication (citizen, secretary, captain)
- ✅ National ID verification system
- ✅ QR code generation for verified citizens
- ✅ Complaint filing with media (photos/videos)
- ✅ Complaint validation workflow
- ✅ Complaint resolution workflow
- ✅ Database notifications system
- ✅ PDF report generation (controller ready)
- ✅ 11 complaint categories with Republic Acts

### 🔨 To Complete:
- 📝 All frontend views (dashboards, forms, lists)
- 📝 Notification UI display
- 📝 Search and filter functionality in views
- 📝 Timeline/Activity log for complaints
- 📝 User profile management pages

## 📊 Complaint Categories

1. Noise Disturbance (RA 386)
2. Illegal Parking (RA 4136)
3. Domestic Violence (RA 9262)
4. Property Dispute (RA 386)
5. Illegal Gambling (PD 1602)
6. Waste Disposal Violation (RA 9003)
7. Stray Animals (RA 8485)
8. Child Abuse (RA 7610)
9. Public Safety Hazard
10. Illegal Construction (PD 1096)
11. Other

## 🔐 Security Features

- Password hashing with bcrypt
- CSRF protection
- Role-based access control
- National ID uniqueness validation
- File type validation for uploads
- Middleware protection on all routes

## 📱 Media Upload Configuration

Supported file types:
- **Images:** JPEG, PNG, JPG
- **Videos:** MP4, MPEG, MOV
- **Max size:** 20MB per file

## 🚦 Complaint Workflow

```
[Citizen Files] → [Pending]
        ↓
[Secretary Reviews] → [Validated/Rejected]
        ↓
[Captain Reviews] → [In Progress]
        ↓
[Captain Resolves] → [Resolved]
```

## 💾 Database

Currently using SQLite (configured in `.env`). To switch to MySQL:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=brgy_complaint
DB_USERNAME=root
DB_PASSWORD=your_password
```

Then run: `php artisan migrate:fresh --seed`

## 🎯 Next Steps

1. **Create all view files** with modern Tailwind CSS styling
2. **Implement notification display** in navigation/header
3. **Add real-time updates** (optional: Laravel Echo + Pusher)
4. **Create user profile pages** for editing personal information
5. **Add complaint filtering** and search functionality
6. **Implement activity logs** for transparency
7. **Add email notifications** (configure mail in `.env`)
8. **Create backup/export** functionality for data preservation

## 📞 Support & Customization

This system is fully customizable. Key configuration files:
- `config/filesystems.php` - Storage configuration
- `config/auth.php` - Authentication settings
- `database/seeders/` - Default data
- `routes/web.php` - All application routes

## 🔄 Updates & Maintenance

To update the system:
```bash
git pull origin main
composer install
npm install && npm run build
php artisan migrate
php artisan config:clear
php artisan cache:clear
```

---

**Built with:** Laravel 12, Tailwind CSS, Alpine.js, SQLite/MySQL
**License:** MIT
**Version:** 1.0.0
