# Urgent Request Workflow Guide

## Overview
The urgent request system has a specific workflow that must be followed. The "Unauthorized" error occurs when trying to update status on a request that hasn't been assigned to you yet.

## Complete Workflow

### Step 1: Citizen Submits Urgent Request
**Who:** Any verified citizen  
**Where:** Citizen Dashboard → Click "Urgent Report" button  
**URL:** `http://localhost:8000/urgent-requests/create`

**What to fill:**
- **Title** (required): Brief description of emergency (e.g., "Car accident on main street")
- **Description** (required): Detailed explanation
- **Location** (required): Exact location
- **Category** (required): Select from:
  - Medical
  - Accident
  - Fire
  - Security
  - Disaster
  - Other
- **Priority** (required): Select "high" or "urgent"

**Result:** Request created with status = "submitted"

---

### Step 2: Tanod Views Pending Requests
**Who:** Tanod user  
**Where:** Tanod Dashboard → Click "Pending Requests" or navigate directly  
**URL:** `http://localhost:8000/tanod/pending`

**What you see:**
- List of all unassigned urgent requests (status = "submitted")
- Each request shows: title, category, priority, location, submitted time
- Each request has "Accept & Assign to Me" button

---

### Step 3: Tanod Assigns Request to Self
**Who:** Tanod user  
**Where:** Pending Requests page  
**Action:** Click "Accept & Assign to Me" button on any request

**URL that will be called:** `POST /tanod/{urgent_request_id}/assign`

**Result:**
- Request status changes from "submitted" → "assigned"
- `tanod_id` is set to your user ID
- `assigned_at` timestamp is recorded

---

### Step 4: Tanod Views Assigned Request
**Where:** Tanod Dashboard → "My Assigned Requests"  
**URL:** `http://localhost:8000/tanod/assigned`

**Or after assigning:**
- You'll be redirected to the request details page
- URL: `http://localhost:8000/tanod/{urgent_request_id}`

---

### Step 5: Tanod Updates Status (THIS IS WHERE YOU GET UNAUTHORIZED ERROR)
**Who:** Only the tanod assigned to this request  
**Where:** Request details page (Step 4)  
**Action:** Fill "Respond to Request" form and click "Update Status"

**URL:** `POST /tanod/{urgent_request_id}/update-status`

**Form fields:**
- **Response Status** (required): Select one:
  - In Progress (Orange)
  - On The Way (Purple)  
  - Resolved (Green)
- **Message** (optional): Additional details for requester
- **Latitude** (auto-captured if available): GPS latitude
- **Longitude** (auto-captured if available): GPS longitude

**Result:**
- Request status updated to selected status
- `responded_at` timestamp recorded
- If resolved: `resolved_at` timestamp recorded
- New entry added to `urgent_request_updates` table with audit trail

---

## ❌ Why You Get "Unauthorized" Error

The error occurs when:
1. ✗ Urgent request ID doesn't exist
2. ✗ You haven't assigned yourself to that request yet
3. ✗ The request is assigned to a different tanod
4. ✗ You're not authenticated as a tanod

## ✅ How to Fix It

### Option 1: Follow the Complete Workflow (RECOMMENDED)
1. Login as **citizen** (e.g., user@mail.com)
2. Go to Dashboard → Click "Urgent Report"
3. Submit a test urgent request
4. **Logout** and Login as **tanod** (e.g., tanod1@mail.com)
5. Go to Dashboard → Click "Pending Requests"
6. Click "Accept & Assign to Me" on your submitted request
7. Now you can click "Update Status" and it will work!

### Option 2: Check if Urgent Request Exists (DEBUG)
Run this in Laravel Tinker:

```bash
php artisan tinker
```

Then execute:
```php
App\Models\UrgentRequest::all();  // See all urgent requests
App\Models\UrgentRequest::find(1); // Check if ID 1 exists
```

### Option 3: Verify Your Assignment
In the same Tinker session:
```php
$user = App\Models\User::where('email', 'tanod1@mail.com')->first();
$user->assignedUrgentRequests()->get(); // See requests assigned to you
```

---

## Database State Reference

### urgent_requests table columns:
- `id` - Request ID
- `citizen_id` - Who submitted it
- `tanod_id` - Who is assigned (NULL until assigned)
- `status` - Current status (submitted → assigned → in_progress → on_the_way → resolved)
- `title`, `description`, `location`, `category`, `priority`
- `submitted_at`, `assigned_at`, `responded_at`, `resolved_at`

### Key Status Values:
| Status | Meaning | Next Step |
|--------|---------|-----------|
| `submitted` | Waiting for tanod assignment | Tanod clicks "Accept" |
| `assigned` | Assigned but not responded | Tanod clicks "Update Status" |
| `in_progress` | Tanod is handling it | Update to on_the_way or resolved |
| `on_the_way` | Tanod is en route | Update to in_progress or resolved |
| `resolved` | Issue completed | View in history |
| `cancelled` | Citizen cancelled | Final state |

---

## Demo Accounts

### Citizen (to submit urgent requests):
- **Email:** (any verified citizen email)
- **Purpose:** Submit urgent requests for testing

### Tanod (to respond to requests):
- **Email:** tanod1@mail.com
- **Password:** password
- **Role:** tanod

- **Email:** tanod2@mail.com
- **Password:** password
- **Role:** tanod

---

## Common Issues & Solutions

### Issue: "Unauthorized" when clicking Update Status
**Cause:** Request not assigned to you yet  
**Solution:** 
1. Go to `/tanod/pending`
2. Click "Accept & Assign to Me" first
3. Then try updating status

### Issue: Can't see pending requests
**Cause:** Your role might not be 'tanod'  
**Solution:** Check your user role in database:
```php
$user = Auth::user();
echo $user->role; // Should output: tanod
```

### Issue: Request disappears after assigning
**Cause:** It moved to "My Assigned Requests"  
**Solution:** Go to `/tanod/assigned` to find it

---

## Testing Checklist

- [ ] Login as citizen
- [ ] Navigate to Dashboard
- [ ] Click "Urgent Report" button
- [ ] Fill form with test data
- [ ] Submit urgent request
- [ ] See confirmation message
- [ ] Logout
- [ ] Login as tanod1@mail.com
- [ ] Go to Dashboard
- [ ] Click "Pending Requests"
- [ ] See the request you just created
- [ ] Click "Accept & Assign to Me"
- [ ] See redirect to request details page
- [ ] See "Respond to Request" form
- [ ] Select a status option
- [ ] Add a message (optional)
- [ ] Click "Update Status" button
- [ ] See success message
- [ ] Check status changed in request details

