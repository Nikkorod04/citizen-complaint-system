# Barangay Complaint System - Database Structure

## Overview
Complete relational database structure for the Barangay Complaint Analysis, Intervention, and Recommendation System with QR Integration.

---

## Database Diagram (ERD - Entity Relationship Diagram)

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                                  USERS TABLE                                 │
├─────────────────────────────────────────────────────────────────────────────┤
│ id (PK)                          │ BIGINT UNSIGNED PRIMARY KEY              │
│ first_name                       │ VARCHAR(255)                              │
│ middle_name                      │ VARCHAR(255) NULLABLE                     │
│ last_name                        │ VARCHAR(255)                              │
│ suffix                           │ VARCHAR(255) NULLABLE (Jr, Sr, III)      │
│ email (UNIQUE)                   │ VARCHAR(255)                              │
│ email_verified_at                │ TIMESTAMP NULLABLE                        │
│ password                         │ VARCHAR(255)                              │
│ remember_token                   │ VARCHAR(100) NULLABLE                     │
│─────────────────────────────────────────────────────────────────────────────│
│ ROLE & VERIFICATION              │                                           │
│ role                             │ ENUM('citizen', 'secretary', 'captain')  │
│ verification_status              │ ENUM('pending', 'approved', 'rejected')  │
│ verified_at                      │ TIMESTAMP NULLABLE                        │
│─────────────────────────────────────────────────────────────────────────────│
│ IDENTIFICATION                   │                                           │
│ national_id (UNIQUE)             │ VARCHAR(255) NULLABLE (16 digits)        │
│ national_id_image                │ VARCHAR(255) NULLABLE (file path)        │
│─────────────────────────────────────────────────────────────────────────────│
│ DEMOGRAPHICS                     │                                           │
│ date_of_birth                    │ DATE NULLABLE                             │
│ age                              │ INT NULLABLE (auto-calculated)            │
│ gender                           │ ENUM('male', 'female', 'other')          │
│ civil_status                     │ ENUM('single', 'married', 'widowed',    │
│                                  │       'separated', 'divorced')            │
│ occupation                       │ VARCHAR(255) NULLABLE                     │
│─────────────────────────────────────────────────────────────────────────────│
│ ADDRESS INFORMATION              │                                           │
│ house_number                     │ VARCHAR(255) NULLABLE                     │
│ street                           │ VARCHAR(255) NULLABLE                     │
│ barangay                         │ VARCHAR(255) NULLABLE                     │
│ city                             │ VARCHAR(255) NULLABLE                     │
│ province                         │ VARCHAR(255) NULLABLE                     │
│ zip_code                         │ VARCHAR(255) NULLABLE                     │
│─────────────────────────────────────────────────────────────────────────────│
│ CONTACT INFORMATION              │                                           │
│ phone                            │ VARCHAR(255) NULLABLE (11 digits)        │
│ emergency_contact_name           │ VARCHAR(255) NULLABLE                     │
│ emergency_contact_number         │ VARCHAR(255) NULLABLE (11 digits)        │
│─────────────────────────────────────────────────────────────────────────────│
│ QR CODE                          │                                           │
│ qr_code                          │ VARCHAR(255) NULLABLE (file path)        │
│─────────────────────────────────────────────────────────────────────────────│
│ TIMESTAMPS                       │                                           │
│ created_at                       │ TIMESTAMP                                 │
│ updated_at                       │ TIMESTAMP                                 │
└─────────────────────────────────────────────────────────────────────────────┘
           ↓                                        ↓
           │ user_id (FK)                         │ validated_by (FK)
           │                                      │ resolved_by (FK)
           └──────────────┬───────────────────────┘
                          │
┌──────────────────────────────────────────────────────────────────────────────┐
│                            COMPLAINTS TABLE                                   │
├──────────────────────────────────────────────────────────────────────────────┤
│ id (PK)                          │ BIGINT UNSIGNED PRIMARY KEY              │
│ complaint_number (UNIQUE)        │ VARCHAR(255) (auto-generated)            │
│ user_id (FK)                     │ BIGINT UNSIGNED → USERS.id              │
│ complaint_category_id (FK)       │ BIGINT UNSIGNED → COMPLAINT_CATEGORIES │
│ subject                          │ VARCHAR(255)                              │
│ description                      │ TEXT (max 2000 chars)                    │
│ location                         │ VARCHAR(255) NULLABLE                     │
│──────────────────────────────────────────────────────────────────────────────│
│ STATUS & WORKFLOW                │                                           │
│ status                           │ ENUM('pending', 'validated',             │
│                                  │       'in_progress', 'resolved',         │
│                                  │       'rejected')                        │
│ secretary_notes                  │ TEXT NULLABLE                             │
│ captain_resolution               │ TEXT NULLABLE                             │
│ recommendation                   │ TEXT NULLABLE                             │
│──────────────────────────────────────────────────────────────────────────────│
│ PROCESSING TRACKING              │                                           │
│ validated_by (FK)                │ BIGINT UNSIGNED NULLABLE → USERS.id     │
│ validated_at                     │ TIMESTAMP NULLABLE                        │
│ resolved_by (FK)                 │ BIGINT UNSIGNED NULLABLE → USERS.id     │
│ resolved_at                      │ TIMESTAMP NULLABLE                        │
│──────────────────────────────────────────────────────────────────────────────│
│ TIMESTAMPS                       │                                           │
│ created_at                       │ TIMESTAMP                                 │
│ updated_at                       │ TIMESTAMP                                 │
└──────────────────────────────────────────────────────────────────────────────┘
           │ complaint_category_id (FK)
           │
           ↓
┌──────────────────────────────────────────────────────────────────────────────┐
│                       COMPLAINT_CATEGORIES TABLE                              │
├──────────────────────────────────────────────────────────────────────────────┤
│ id (PK)                          │ BIGINT UNSIGNED PRIMARY KEY              │
│ name                             │ VARCHAR(255)                              │
│ description                      │ TEXT NULLABLE                             │
│ republic_act                     │ VARCHAR(255) NULLABLE (e.g., "RA 9262") │
│ is_active                        │ BOOLEAN DEFAULT TRUE                     │
│ created_at                       │ TIMESTAMP                                 │
│ updated_at                       │ TIMESTAMP                                 │
└──────────────────────────────────────────────────────────────────────────────┘
           ↓
           │ model_id (polymorphic)
           │ model_type = 'App\Models\Complaint'
           │
┌──────────────────────────────────────────────────────────────────────────────┐
│                              MEDIA TABLE                                      │
│                   (Spatie Media Library - Polymorphic)                        │
├──────────────────────────────────────────────────────────────────────────────┤
│ id (PK)                          │ BIGINT UNSIGNED PRIMARY KEY              │
│ model_type                       │ VARCHAR(255) (polymorphic: Complaint)    │
│ model_id                         │ BIGINT UNSIGNED (complaint ID)            │
│ uuid                             │ VARCHAR(36) UNIQUE NULLABLE              │
│ collection_name                  │ VARCHAR(255) ('evidence')                │
│ name                             │ VARCHAR(255)                              │
│ file_name                        │ VARCHAR(255)                              │
│ mime_type                        │ VARCHAR(255) (e.g., image/jpeg, video/mp4)
│ disk                             │ VARCHAR(255) ('public')                  │
│ conversions_disk                 │ VARCHAR(255) NULLABLE                    │
│ size                             │ BIGINT UNSIGNED (file size in bytes)    │
│ manipulations                    │ JSON NULLABLE                             │
│ custom_properties                │ JSON NULLABLE                             │
│ responsive_images                │ JSON NULLABLE                             │
│ order_column                     │ INT UNSIGNED                              │
│ created_at                       │ TIMESTAMP                                 │
│ updated_at                       │ TIMESTAMP                                 │
└──────────────────────────────────────────────────────────────────────────────┘


┌──────────────────────────────────────────────────────────────────────────────┐
│                          NOTIFICATIONS TABLE                                  │
│                        (Laravel Notifications)                                │
├──────────────────────────────────────────────────────────────────────────────┤
│ id (PK)                          │ UUID PRIMARY KEY                          │
│ type                             │ VARCHAR(255) (notification class name)    │
│ notifiable_type                  │ VARCHAR(255) (polymorphic: User)         │
│ notifiable_id                    │ BIGINT UNSIGNED (user ID)                │
│ data                             │ TEXT (JSON notification data)             │
│ read_at                          │ TIMESTAMP NULLABLE                        │
│ created_at                       │ TIMESTAMP                                 │
│ updated_at                       │ TIMESTAMP                                 │
└──────────────────────────────────────────────────────────────────────────────┘
```

---

## Table Relationships

### Users Table (Primary)
- **1-to-Many**: Users → Complaints (complaints filed by user)
- **1-to-Many**: Users → Complaints (secretary validating complaints)
- **1-to-Many**: Users → Complaints (captain resolving complaints)

### Complaints Table
- **Many-to-1**: Complaints → Users (filed_by - user_id)
- **Many-to-1**: Complaints → Users (validated_by - secretary)
- **Many-to-1**: Complaints → Users (resolved_by - captain)
- **Many-to-1**: Complaints → ComplaintCategories (complaint_category_id)
- **1-to-Many**: Complaints → Media (polymorphic - evidence files)

### ComplaintCategories Table
- **1-to-Many**: ComplaintCategories → Complaints

### Media Table (Polymorphic - Spatie Media Library)
- Stores images and videos for complaints
- Can store media for other models in future (polymorphic design)
- Each media file belongs to a complaint via `model_id` and `model_type`

### Notifications Table (Polymorphic)
- Stores notifications for users
- Can be extended for other models in future

---

## Key Features

### Role-Based Access Control
```
USERS.role:
- citizen: Can file complaints, view own complaints, see their QR code
- secretary: Can verify users, validate complaints, add notes
- captain: Can manage all complaints, resolve, add resolutions
```

### Complaint Status Workflow
```
pending → validated → in_progress → resolved
                   ↘ rejected
```

### Data Validation Rules
| Field | Validation |
|-------|-----------|
| national_id | 16 digits with auto-formatting (XXXX-XXXX-XXXX-XXXX) |
| phone | 11 digits, starts with 09 (09XXXXXXXXX) |
| email | Unique, valid email format, lowercase |
| age | Auto-calculated from date_of_birth |
| first_name, last_name, occupation | Letters, spaces, hyphens only (no numbers) |
| description | Max 2000 characters |

### File Storage
- **National ID Images**: `storage/app/public/national-ids/`
- **Complaint Evidence**: `storage/app/public/{complaint_id}/`
- **QR Codes**: `storage/app/public/qr-codes/`

### Access Through URLs
```
/storage/national-ids/{filename}
/storage/{complaint_id}/{filename}
/storage/qr-codes/user-{id}-{timestamp}.svg
```

---

## Database Indexes

**Primary Keys (Implicit Indexes):**
- users.id
- complaints.id
- complaint_categories.id
- media.id
- notifications.id

**Unique Indexes:**
- users.email
- users.national_id
- complaints.complaint_number
- media.uuid

**Foreign Key Indexes (Implicit):**
- complaints.user_id → users.id
- complaints.complaint_category_id → complaint_categories.id
- complaints.validated_by → users.id
- complaints.resolved_by → users.id

**Search/Query Indexes (Recommended):**
```sql
INDEX (users.role)
INDEX (users.verification_status)
INDEX (complaints.status)
INDEX (complaints.created_at)
INDEX (complaints.user_id, status)
INDEX (media.model_id, model_type)
```

---

## Sample Data Relationships

### Example Scenario:

**User (Citizen):**
```
ID: 3
first_name: Juan
last_name: Dela Cruz
role: citizen
national_id: 1234-5678-9012-3456
verification_status: approved
qr_code: qr-codes/user-3-1760900722.svg
```

**Complaint (Filed by User 3):**
```
ID: 1
complaint_number: CP-20251021-001
user_id: 3 (FK → Users)
complaint_category_id: 5 (FK → ComplaintCategories)
subject: Pothole on Main Street
status: validated
validated_by: 2 (FK → Users - Secretary)
validated_at: 2025-10-20 14:30:00
```

**Media (Evidence for Complaint 1):**
```
ID: 1
model_type: App\Models\Complaint
model_id: 1 (FK → Complaints)
collection_name: evidence
file_name: pothole-photo.jpg
disk: public
size: 2097152 (2MB)
```

**ComplaintCategory:**
```
ID: 5
name: Public Infrastructure
description: Issues related to roads, drainage, etc.
republic_act: RA 7160
is_active: true
```

---

## SQL Schema Summary

```sql
-- Total Fields by Table:
USERS: 30+ fields
COMPLAINTS: 16 fields
COMPLAINT_CATEGORIES: 6 fields
MEDIA: 14 fields (Spatie Media Library)
NOTIFICATIONS: 9 fields
SESSIONS: 6 fields
PASSWORD_RESET_TOKENS: 3 fields
CACHE: 2 fields
JOBS: 12 fields

-- Total Tables: 9
-- Total Relationships: 6 One-to-Many, 1 Polymorphic (Media), 1 Polymorphic (Notifications)
```

---

## Migration Timeline

| Order | Migration | Purpose |
|-------|-----------|---------|
| 1 | 0001_01_01_000000 | Create users, password_reset_tokens, sessions |
| 2 | 2025_10_15_165938 | Add role fields to users |
| 3 | 2025_10_15_165948 | Create complaint_categories |
| 4 | 2025_10_15_170054 | Create complaints |
| 5 | 2025_10_15_170227 | Create notifications |
| 6 | 2025_10_15_172909 | Enhance users table with detailed info |
| 7 | 2025_10_15_173519 | Add national_id_image to users |
| 8 | 2025_10_15_165910 | Create media table (Spatie) |

---

## Notes

- **Cascading Deletes**: When a user is deleted, their complaints are also deleted (ON DELETE CASCADE)
- **Soft Deletes**: Consider adding for users and complaints for audit trails
- **Polymorphic Design**: Media and Notifications tables can easily support other models
- **QR Code Data**: Stored as SVG in storage, contains JSON: `{user_id, name, national_id, type, generated_at}`
- **Age Field**: Auto-calculated from date_of_birth during registration and updates

