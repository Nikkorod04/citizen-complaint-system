# 🚀 Tanod Feature - Quick Reference Guide

## Login Credentials

### Tanod Demo Accounts
```
Tanod 1:
  Email:    tanod1@mail.com
  Password: password
  
Tanod 2:
  Email:    tanod2@mail.com
  Password: password
```

### Other Demo Accounts
```
Captain:
  Email:    captain@mail.com
  Password: password
  
Secretary:
  Email:    secretary@mail.com
  Password: password
```

---

## Key URLs

### Tanod Dashboard & Management
```
Tanod Login           → http://localhost:8000/login
Tanod Dashboard       → http://localhost:8000/tanod/dashboard
Pending Requests      → http://localhost:8000/tanod/pending
My Assigned Requests  → http://localhost:8000/tanod/assigned
Resolved Requests     → http://localhost:8000/tanod/resolved
Request Details       → http://localhost:8000/tanod/{id}
```

### Citizen Urgent Requests
```
Urgent Requests List  → http://localhost:8000/urgent-requests
Submit New Request    → http://localhost:8000/urgent-requests/create
View Request          → http://localhost:8000/urgent-requests/{id}
Track Status          → http://localhost:8000/urgent-requests/{id}/track
```

---

## Database Tables

### urgent_requests
```sql
- id (PK)
- citizen_id (FK) → users.id
- tanod_id (FK) → users.id (nullable)
- title, description, location
- category (medical|accident|fire|security|disaster|other)
- priority (high|urgent)
- status (submitted|assigned|in_progress|on_the_way|resolved|cancelled)
- submitted_at, assigned_at, responded_at, resolved_at (timestamps)
- created_at, updated_at
```

### urgent_request_updates
```sql
- id (PK)
- urgent_request_id (FK) → urgent_requests.id
- tanod_id (FK) → users.id
- status (in_progress|on_the_way|resolved)
- message (nullable)
- latitude, longitude (nullable)
- created_at, updated_at
```

---

## Models & Methods

### UrgentRequest Model
```php
// Relationships
$request->citizen()      // BelongsTo User
$request->tanod()        // BelongsTo User (nullable)
$request->updates()      // HasMany UrgentRequestUpdate

// Methods
$request->isUrgent()     // Check if priority is urgent
$request->isResolved()   // Check if status is resolved
$request->isActive()     // Check if actively being worked on
$request->getStatusColor() // Get Tailwind color classes
```

### UrgentRequestUpdate Model
```php
// Relationships
$update->urgentRequest() // BelongsTo UrgentRequest
$update->tanod()         // BelongsTo User

// Methods
$update->getStatusBadge() // Get HTML badge
```

### User Model (New Methods)
```php
$user->isTanod()                    // Check if tanod
$user->submittedUrgentRequests()    // Get citizen's requests
$user->assignedUrgentRequests()     // Get tanod's requests
$user->urgentRequestUpdates()       // Get tanod's updates
```

---

## Controller Methods

### TanodController
```php
// Display methods
dashboard()          // Main dashboard with stats
pending()            // List pending requests
assigned()           // List assigned requests
resolved()           // List resolved requests
show($request)       // View request details

// Action methods
assign($request)     // Assign request to self
updateStatus($request) // Update request status
```

### UrgentRequestController
```php
// Display methods
index()              // List citizen's requests
create()             // Show submission form
show($request)       // View request details
track($request)      // Track request status

// Action methods
store()              // Save new request
cancel($request)     // Cancel request
destroy($request)    // Delete request
```

---

## Routes Summary

### Tanod Routes (7 routes)
```
GET  /tanod/dashboard              → dashboard()
GET  /tanod/pending                → pending()
GET  /tanod/assigned               → assigned()
GET  /tanod/resolved               → resolved()
GET  /tanod/{id}                   → show()
POST /tanod/{id}/assign            → assign()
POST /tanod/{id}/update-status     → updateStatus()
```

### Urgent Request Routes (7 routes)
```
GET    /urgent-requests            → index()
GET    /urgent-requests/create     → create()
POST   /urgent-requests            → store()
GET    /urgent-requests/{id}       → show()
DELETE /urgent-requests/{id}       → destroy()
POST   /urgent-requests/{id}/cancel → cancel()
GET    /urgent-requests/{id}/track  → track()
```

---

## Status Flow

```
Citizen submits request
        ↓
Status: submitted (yellow badge)
        ↓
Tanod accepts & assigns
        ↓
Status: assigned (blue badge)
        ↓
Tanod updates status
        ├─ In Progress (orange badge)
        ├─ On The Way (purple badge)
        └─ Resolved (green badge)
        ↓
Request Completed
```

---

## Views

### Citizen Views (3 views)
- `urgent-requests/index.blade.php` - List of requests
- `urgent-requests/create.blade.php` - Submission form
- `urgent-requests/show.blade.php` - Details & tracking

### Tanod Views (5 views)
- `tanod/dashboard.blade.php` - Dashboard with stats
- `tanod/pending.blade.php` - Pending requests
- `tanod/assigned.blade.php` - Assigned requests
- `tanod/resolved.blade.php` - Resolved history
- `tanod/show.blade.php` - Details & response form

---

## Common Commands

### Clear Caches
```bash
php artisan cache:clear      # Clear app cache
php artisan config:clear     # Clear config cache
php artisan route:clear      # Clear route cache
php artisan view:clear       # Clear view cache
```

### Database Operations
```bash
php artisan migrate                    # Run all migrations
php artisan db:seed --class=AdminUserSeeder  # Seed demo users
php artisan tinker                     # Interactive shell
```

### Build & Assets
```bash
npm run build                 # Build CSS/JS
npm run dev                   # Build for development
php artisan view:clear       # Clear compiled views
```

---

## Status Codes & Colors

### Status Badges
| Status | Color | Badge Class |
|--------|-------|-------------|
| submitted | Yellow | `bg-yellow-100 text-yellow-800` |
| assigned | Blue | `bg-blue-100 text-blue-800` |
| in_progress | Orange | `bg-orange-100 text-orange-800` |
| on_the_way | Purple | `bg-purple-100 text-purple-800` |
| resolved | Green | `bg-green-100 text-green-800` |
| cancelled | Red | `bg-red-100 text-red-800` |

### Priority Badge
| Priority | Color |
|----------|-------|
| high | Red |
| urgent | Dark Red |

---

## Middleware Stack

### Tanod Routes
```php
['auth', 'role:tanod', 'verified.citizen']
```
- User must be authenticated
- User must have 'tanod' role
- User must be verified citizen

### Urgent Request Routes
```php
['auth', 'role:citizen', 'verified.citizen']
```
- User must be authenticated
- User must have 'citizen' role
- User must be verified citizen

---

## Request Submission Fields

### Required Fields
- **Title** (max 255 chars) - What is the emergency?
- **Description** (max 1000 chars) - Detailed information
- **Location** (max 255 chars) - Where is it happening?
- **Category** - medical|accident|fire|security|disaster|other
- **Priority** - high|urgent

### Optional Fields (in updates)
- **Message** - Tanod response message (max 500 chars)
- **Latitude** - Location coordinate
- **Longitude** - Location coordinate

---

## File Structure

```
app/Models/
├── UrgentRequest.php .......................... 81 lines
└── UrgentRequestUpdate.php ................... 50 lines

app/Http/Controllers/
├── TanodController.php ....................... 158 lines
└── UrgentRequestController.php ............... 119 lines

database/migrations/
├── 2025_10_22_000001_add_tanod_role_and_urgent_requests.php
└── 2025_10_22_000002_add_tanod_to_role_enum.php

resources/views/
├── urgent-requests/
│   ├── index.blade.php ....................... 102 lines
│   ├── create.blade.php ...................... 110 lines
│   └── show.blade.php ........................ 180 lines
└── tanod/
    ├── dashboard.blade.php ................... 180 lines
    ├── pending.blade.php ..................... 100 lines
    ├── assigned.blade.php .................... 85 lines
    ├── resolved.blade.php .................... 80 lines
    └── show.blade.php ........................ 200 lines
```

---

## Testing Quick Steps

### 1. Test Tanod Login
```
URL: http://localhost:8000/login
Email: tanod1@mail.com
Password: password
Expected: /tanod/dashboard
```

### 2. Test View Dashboard
```
Verify stats cards appear
Verify recent requests table shows
```

### 3. Test Pending Requests
```
Click "View Pending Requests"
Expected: Yellow-bordered request cards
```

### 4. Test Accept Request
```
Click "Accept & Assign to Me"
Expected: Request assigned to self
```

### 5. Test Update Status
```
Click "View & Respond"
Select status update
Add message (optional)
Click "Update Status"
Expected: Status update recorded
```

---

## Troubleshooting

### Issue: "You're logged in!" page for Tanod
**Solution:** Clear route cache
```bash
php artisan route:clear
```

### Issue: Controller not found error
**Solution:** Verify controller file exists
```bash
ls app/Http/Controllers/Tanod*
```

### Issue: Routes not working
**Solution:** Clear all caches
```bash
php artisan cache:clear && php artisan route:clear
```

### Issue: Migrations not applied
**Solution:** Run migrations
```bash
php artisan migrate
php artisan db:seed --class=AdminUserSeeder
```

### Issue: Demo accounts not found
**Solution:** Seed the database
```bash
php artisan db:seed --class=AdminUserSeeder
```

---

## Documentation Files

- `TANOD_FEATURE_IMPLEMENTATION.md` - Full technical documentation
- `TANOD_DASHBOARD_FIX.md` - Fix for routing issue
- `VERIFICATION_REPORT.md` - Complete verification report
- `COMPLETE_CHECKLIST.md` - Full implementation checklist
- `QUICK_REFERENCE_GUIDE.md` - This file

---

**Last Updated:** October 23, 2025  
**Status:** ✅ Ready for Use

---
