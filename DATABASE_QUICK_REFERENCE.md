# Database Structure - Quick Reference Guide

## Simplified Table Overview

### 🧑 USERS (30+ fields)
Primary user table with citizen information and verification status.

| Column | Type | Notes |
|--------|------|-------|
| id | BigInt PK | Auto-increment |
| first_name | String | Letters, spaces, hyphens only |
| middle_name | String | Optional |
| last_name | String | Letters, spaces, hyphens only |
| suffix | String | Jr, Sr, III, etc. (optional) |
| email | String UK | Unique, lowercase |
| password | String | Bcrypt hashed |
| role | Enum | citizen, secretary, captain |
| national_id | String UK | Format: XXXX-XXXX-XXXX-XXXX (16 digits) |
| national_id_image | String | File path to uploaded image |
| date_of_birth | Date | Optional |
| age | Integer | Auto-calculated |
| gender | Enum | male, female, other (optional) |
| civil_status | Enum | single, married, widowed, separated, divorced |
| occupation | String | Letters, spaces, hyphens only |
| phone | String | 11 digits, format: 09XXXXXXXXX |
| house_number | String | Optional |
| street | String | Optional |
| barangay | String | Optional |
| city | String | Optional |
| province | String | Optional |
| zip_code | String | Optional |
| emergency_contact_name | String | Optional, same validation as name |
| emergency_contact_number | String | 11 digits, same format as phone |
| qr_code | String | File path to SVG QR code |
| verification_status | Enum | pending, approved, rejected |
| verified_at | Timestamp | Nullable |
| email_verified_at | Timestamp | Nullable |
| remember_token | String | Session token (optional) |
| created_at | Timestamp | Auto |
| updated_at | Timestamp | Auto |

**Relationships:**
- 1-to-Many: Complaints (user_id)
- 1-to-Many: Complaints as Validator (validated_by)
- 1-to-Many: Complaints as Resolver (resolved_by)
- 1-to-Many: Notifications (notifiable)

---

### 📋 COMPLAINTS (16 fields)
Stores all complaints filed by citizens.

| Column | Type | Notes |
|--------|------|-------|
| id | BigInt PK | Auto-increment |
| complaint_number | String UK | Auto-generated unique identifier |
| user_id | BigInt FK | → Users.id (citizen who filed) |
| complaint_category_id | BigInt FK | → ComplaintCategories.id |
| subject | String | Complaint title |
| description | Text | Max 2000 characters |
| location | String | Where incident occurred (optional) |
| status | Enum | pending, validated, in_progress, resolved, rejected |
| secretary_notes | Text | Notes from secretary during validation |
| captain_resolution | Text | Resolution details from captain |
| recommendation | Text | Recommendations for future (optional) |
| validated_by | BigInt FK | → Users.id (secretary who validated) |
| validated_at | Timestamp | When validation happened |
| resolved_by | BigInt FK | → Users.id (captain who resolved) |
| resolved_at | Timestamp | When resolution happened |
| created_at | Timestamp | Auto |
| updated_at | Timestamp | Auto |

**Relationships:**
- Many-to-1: Users (filed by) - user_id
- Many-to-1: Users (validated by) - validated_by
- Many-to-1: Users (resolved by) - resolved_by
- Many-to-1: ComplaintCategories - complaint_category_id
- 1-to-Many: Media (polymorphic) - evidence files
- 1-to-Many: Notifications

**Status Workflow:**
```
┌─────────┐     ┌───────────┐     ┌────────────┐     ┌──────────┐
│ pending │ --> │ validated │ --> │ in_progress│ --> │ resolved │
└─────────┘     └───────────┘     └────────────┘     └──────────┘
                      │
                      └─--> rejected
```

---

### 📂 COMPLAINT_CATEGORIES (6 fields)
Categorizes complaints with related laws.

| Column | Type | Notes |
|--------|------|-------|
| id | BigInt PK | Auto-increment |
| name | String | Category name (e.g., "Public Infrastructure") |
| description | Text | Detailed description (optional) |
| republic_act | String | Related law (e.g., "RA 9262", "RA 7160") |
| is_active | Boolean | Enable/disable category |
| created_at | Timestamp | Auto |
| updated_at | Timestamp | Auto |

**Examples:**
- Noise Pollution (RA 8749)
- Anti-Violence Against Women (RA 9262)
- Public Infrastructure (RA 7160)
- Environmental Protection (RA 6969)

**Relationships:**
- 1-to-Many: Complaints - complaint_category_id

---

### 🖼️ MEDIA (14 fields)
Stores evidence files (photos/videos) for complaints - **Spatie Media Library**.

| Column | Type | Notes |
|--------|------|-------|
| id | BigInt PK | Auto-increment |
| model_type | String | Polymorphic: "App\Models\Complaint" |
| model_id | BigInt | Complaint ID (polymorphic FK) |
| uuid | String UK | Unique identifier |
| collection_name | String | "evidence" for complaints |
| name | String | Display name |
| file_name | String | Actual filename |
| mime_type | String | image/jpeg, video/mp4, etc. |
| disk | String | "public" (storage disk) |
| size | BigInt | File size in bytes (max 20MB per file) |
| conversions_disk | String | Optional, for image conversions |
| manipulations | Json | Image operations/filters (optional) |
| custom_properties | Json | Additional metadata (optional) |
| responsive_images | Json | Responsive image variants (optional) |
| order_column | Integer | Display order |
| created_at | Timestamp | Auto |
| updated_at | Timestamp | Auto |

**Storage Path:** `/storage/public/{complaint_id}/{filename}`

**Supported Files:**
- Images: JPG, PNG (max 20MB)
- Videos: MP4, MPEG, MOV (max 20MB)
- Max 5 files per complaint

**Relationships:**
- Polymorphic: Complaints (model_id, model_type)

---

### 🔔 NOTIFICATIONS (9 fields)
Laravel notifications system - **Polymorphic**.

| Column | Type | Notes |
|--------|------|-------|
| id | UUID PK | Unique identifier |
| type | String | Notification class name |
| notifiable_type | String | Polymorphic: "App\Models\User" |
| notifiable_id | BigInt | User ID (polymorphic FK) |
| data | Text | JSON notification data |
| read_at | Timestamp | When user read (nullable) |
| created_at | Timestamp | Auto |
| updated_at | Timestamp | Auto |

**Notification Types:**
- User registered and pending verification
- Complaint filed successfully
- Complaint validated by secretary
- Complaint rejected by secretary
- Complaint marked in progress
- Complaint resolved

**Relationships:**
- Polymorphic: Users - notifiable_id

---

## Quick Relationships Map

```
┌──────────────────────────────────────────────────────┐
│                      USERS                           │
│  (Citizens, Secretaries, Captains)                   │
└──────────────────┬───────────────────────────────────┘
                   │
        ┌──────────┼──────────┐
        │          │          │
        │          │          │
    filed_by   validated_by  resolved_by
        │          │          │
        ↓          ↓          ↓
┌──────────────────────────────────────┐
│           COMPLAINTS                 │
│  (Status: pending→validated→resolved)│
└──────────────────┬───────────────────┘
                   │
        ┌──────────┴──────────┐
        │                     │
        ↓                     ↓
┌─────────────────┐  ┌──────────────────┐
│  COMPLAINT_     │  │     MEDIA        │
│  CATEGORIES     │  │   (Evidence)     │
└─────────────────┘  └──────────────────┘
```

---

## Data Validation Examples

### User Registration
```
Name: "Ma. Rosa Santos-Garcia" ✅
Age: Auto-calculated from DOB ✅
National ID: 1234-5678-9012-3456 ✅ (auto-formatted)
Phone: 09173456789 ✅ (11 digits, 09 prefix)
Email: maria.santos@gmail.com ✅ (lowercase, valid format)
Occupation: "Housewife" ✅ (letters, spaces only)
Emergency Contact Phone: 09123456789 ✅ (11 digits)
```

### Complaint Filing
```
Subject: "Damaged Road on Main Street"
Description: "The road near the market has a large pothole..." (max 2000)
Location: "Main Street, Barangay San Jose"
Category: "Public Infrastructure"
Evidence: photo1.jpg (2.1 MB) ✅, video1.mp4 (18.5 MB) ✅ (max 5 files)
```

---

## Access Control by Role

### CITIZEN (role = 'citizen')
- View own complaints only
- File new complaints
- View own QR code (if verified)
- Cannot view other users' data
- Cannot approve/reject
- Cannot resolve

### SECRETARY (role = 'secretary')
- View unverified users
- Approve/Reject user registrations
- View pending complaints (status = 'pending')
- Validate complaints (change status to 'validated')
- Add validation notes
- Reject complaints with reasons

### CAPTAIN (role = 'captain')
- View all complaints
- Mark complaints "in_progress"
- Resolve complaints (status = 'resolved')
- Add resolution details & recommendations
- View analytics & reports
- Export complaint data

---

## Storage Organization

```
storage/
├── app/
│   └── public/
│       ├── national-ids/           # User National ID images
│       │   ├── user-1-photo.jpg
│       │   └── user-2-photo.jpg
│       │
│       ├── qr-codes/               # QR code SVGs
│       │   ├── user-1-1760900722.svg
│       │   └── user-2-1760901234.svg
│       │
│       └── 1/                      # Complaint ID directories
│           ├── photo1.jpg
│           ├── photo2.jpg
│           └── video1.mp4
│
└── logs/
    └── laravel.log
```

**URL Mapping:**
```
/storage/national-ids/user-1-photo.jpg
/storage/qr-codes/user-1-1760900722.svg
/storage/1/photo1.jpg
```

---

## Key Constraints & Rules

| Constraint | Details |
|-----------|---------|
| **Unique** | email, national_id, complaint_number, media.uuid |
| **Cascade Delete** | If user deleted, their complaints deleted |
| **Nullable Foreign Keys** | validated_by, resolved_by (set NULL on user delete) |
| **Default Values** | verification_status='pending', status='pending', role='citizen', is_active=true |
| **Indexes** | Created on PK, UK, FK, and search columns |
| **Timestamps** | All tables have created_at, updated_at (except password_reset_tokens) |

