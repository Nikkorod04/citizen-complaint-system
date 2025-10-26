# Fix: Assigned Requests Not Showing After Status Update

## Problem
When a tanod updates a request status from "assigned" to "on_the_way" or "in_progress", the request disappears from `/tanod/assigned` page.

## Root Cause
The "My Assigned Requests" view was **only** showing requests with status = "assigned". Once you updated the status to "on_the_way", "in_progress", or other statuses, the request no longer matched the filter and disappeared.

```php
// OLD CODE (INCORRECT)
$assignedRequests = UrgentRequest::where('tanod_id', $user->id)
    ->where('status', 'assigned')  // ❌ Only shows 'assigned' status
    ->latest('assigned_at')
    ->paginate(10);
```

## Solution
Updated the `assigned()` method in `TanodController` to show all active requests assigned to the tanod, regardless of their current status progression.

```php
// NEW CODE (FIXED)
$assignedRequests = UrgentRequest::where('tanod_id', $user->id)
    ->whereIn('status', ['assigned', 'in_progress', 'on_the_way'])  // ✅ Shows all active statuses
    ->latest('assigned_at')
    ->paginate(10);
```

## Changes Made

### 1. Updated TanodController
**File:** `app/Http/Controllers/TanodController.php`

**Method:** `assigned()`

**Change:** Updated status filter from `->where('status', 'assigned')` to `->whereIn('status', ['assigned', 'in_progress', 'on_the_way'])`

### 2. Updated Tanod Assigned View
**File:** `resources/views/tanod/assigned.blade.php`

**Changes:**
- Updated page header from "My Assigned Requests" to "My Active Requests"
- Added subtitle: "Requests assigned, in progress, or on the way"
- Updated status badge to show actual current status (using `getStatusColor()` method)
- Status now displays: "Assigned", "In Progress", or "On The Way" with appropriate colors

## Behavior After Fix

| Status | Where It Shows | Color | Notes |
|--------|---|---|---|
| `assigned` | Dashboard (Active), Assigned page | Blue | Just assigned but not yet responded |
| `in_progress` | Dashboard (Active), Assigned page | Orange | Tanod is actively handling it |
| `on_the_way` | Dashboard (Active), Assigned page | Purple | Tanod is traveling to location |
| `resolved` | Dashboard (Resolved), Resolved page | Green | Completed |
| `submitted` | Pending page | Yellow | Waiting for tanod to assign |

## Request Lifecycle

```
submitted (Pending page)
    ↓ [Tanod clicks "Accept & Assign"]
assigned (Assigned page)
    ↓ [Tanod clicks "Update Status"]
in_progress or on_the_way (Still on Assigned page, but updated)
    ↓ [Tanod clicks "Update Status" → Resolved]
resolved (Moved to Resolved page)
```

## Dashboard Cards Updated

The dashboard now correctly shows:
- **Pending:** Unassigned requests (status = submitted)
- **Assigned:** Requests assigned to me (status = assigned only)
- **Active:** Requests I'm currently handling (status = in_progress OR on_the_way)
- **Resolved Today:** Requests completed today (status = resolved, resolved_at = today)

## Testing Steps

1. **Login as Citizen**
   - Submit an urgent request
   
2. **Login as Tanod**
   - Go to Dashboard → see "Pending" count increased
   - Go to Pending Requests → click "Accept & Assign to Me"
   - See the request moved to Assigned page
   
3. **Click "View & Respond"**
   - Select "On The Way" status
   - Click "Update Status"
   
4. **Check Assigned Page Again**
   - ✅ Request should still be visible
   - ✅ Status badge should show "On The Way" (purple)
   - ✅ Dashboard "Active" count should show 1

5. **Click "View & Respond" again**
   - Select "Resolved" status
   - Click "Update Status"
   
6. **Check Pages**
   - ✅ Assigned page: Request no longer shows (not active anymore)
   - ✅ Resolved page: Request appears with green status
   - ✅ Dashboard: "Resolved Today" count increased

## Files Modified

1. `app/Http/Controllers/TanodController.php` - Updated `assigned()` method
2. `resources/views/tanod/assigned.blade.php` - Updated header and status display
3. `public/build/assets/app-*.js` and `app-*.css` - Rebuilt assets

## Status Colors Reference

Used throughout the application:

```blade
@if($request->status === 'submitted')
    bg-yellow-100 text-yellow-800
@elseif($request->status === 'assigned')
    bg-blue-100 text-blue-800
@elseif($request->status === 'in_progress')
    bg-orange-100 text-orange-800
@elseif($request->status === 'on_the_way')
    bg-purple-100 text-purple-800
@elseif($request->status === 'resolved')
    bg-green-100 text-green-800
@endif
```

## Verification

To verify the fix works:

```bash
# Clear caches
php artisan view:clear
php artisan config:clear

# Rebuild assets (already done)
npm run build
```

✅ All commands completed successfully!

## Future Improvements

1. Could add a filter button to show only specific statuses
2. Could add search/filter by citizen name
3. Could add time-based sorting (oldest first, newest first)
4. Could show average response time per tanod

