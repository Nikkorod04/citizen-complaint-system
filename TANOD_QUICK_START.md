# 🚀 QUICK START GUIDE - TANOD EMERGENCY RESPONSE SYSTEM

## 🔑 Demo Accounts

### Tanod (Emergency Responders)
- **Tanod 1:** tanod1@mail.com / password
- **Tanod 2:** tanod2@mail.com / password

### Admin
- **Captain:** captain@mail.com / password
- **Secretary:** secretary@mail.com / password

---

## 📋 How to Test

### 1️⃣ Login as Tanod
```
URL: http://localhost:8000/login
Email: tanod1@mail.com
Password: password

Expected Result: Redirect to http://localhost:8000/tanod/dashboard
```

### 2️⃣ View Tanod Dashboard
You should see:
- 4 stat cards (Pending, Assigned, Active, Resolved Today)
- Currently Active Requests section
- Quick Actions buttons
- Recent Requests table

**Stats:**
- 🟡 **Pending:** Unassigned emergency requests
- 🔵 **Assigned:** Requests assigned to you
- 🟣 **Active:** Requests in progress or on the way
- 🟢 **Resolved Today:** Completed today

### 3️⃣ View Pending Requests
```
Click: "View Pending Requests" button
Expected: Yellow-bordered request cards
Display: Title, Category, Priority, Location, Requester Info
```

### 4️⃣ Accept & Assign Request
```
Click: "Accept & Assign to Me" button
Expected: Request moves to your assigned list
Status Change: submitted → assigned
```

### 5️⃣ Respond to Request
```
Click: "View & Respond" link
Fill: Status (In Progress, On The Way, Resolved)
Add: Optional message
Click: "Update Status"
Expected: Status timeline updated
```

### 6️⃣ View Resolved Requests
```
Click: "Resolved Requests" button
Expected: Green-bordered completed requests
Display: Resolution time shown
```

---

## 📝 Submit Urgent Request (as Citizen)

### 1️⃣ Register as Citizen
```
URL: http://localhost:8000/register
Fill: All required fields
Submit: Register
Expected: Redirected to verification pending page
```

### 2️⃣ Verify Account (as Secretary)
```
Login: secretary@mail.com / password
Go: /secretary/dashboard
Click: "Pending Verifications"
Click: Verify button for your citizen
Expected: Status changes to verified
```

### 3️⃣ Submit Urgent Request (as Citizen)
```
Login: Your citizen account
Go: /urgent-requests
Click: "Submit Urgent Request"
Fill: 
  - Title: e.g., "Car Accident on Main Street"
  - Description: Detailed info
  - Location: Where it is
  - Category: Select from dropdown
  - Priority: High or Urgent
Submit: Form
Expected: Request appears with "submitted" status
```

### 4️⃣ Track Status (as Citizen)
```
Go: /urgent-requests
Click: Your request
View: 
  - Request details
  - Assigned tanod info
  - Status update timeline
  - All tanod responses
```

---

## 🗂️ Request Categories

When submitting urgent requests, choose from:
- 🏥 **Medical** - Health emergencies
- 🚗 **Accident** - Traffic/vehicle accidents
- 🔥 **Fire** - Fire emergencies
- 🛡️ **Security** - Security threats
- ⛈️ **Disaster** - Natural disasters
- ❓ **Other** - Other emergencies

---

## ⚡ Request Priority Levels

- **High** - Non-emergency but urgent
- **Urgent** - Critical emergency requiring immediate response

---

## 📊 Dashboard Metrics Explained

### Pending Requests (🟡)
Requests waiting to be accepted by any tanod
- Visible to all tanods
- Click "Accept & Assign" to self-assign

### Assigned to Me (🔵)
Requests you've accepted but haven't started responding to yet
- Only visible to assigned tanod
- Status: "assigned"

### Active Responses (🟣)
Requests you're currently handling
- Status: "in_progress" OR "on_the_way"
- Tanod has started responding

### Resolved Today (🟢)
Requests you completed today
- Status: "resolved"
- Shows in stat card when resolved after current date started

---

## 🔄 Request Status Workflow

```
1. SUBMITTED (Yellow)
   └─ Citizen submits request
   └─ Waiting for tanod assignment

2. ASSIGNED (Blue)
   └─ Tanod accepts & assigns to self
   └─ Awaiting response

3. IN PROGRESS (Orange)
   └─ Tanod started handling
   └─ Actively working on it

4. ON THE WAY (Purple)
   └─ Tanod en route to location
   └─ About to arrive

5. RESOLVED (Green)
   └─ Emergency handled
   └─ Request completed
```

---

## 🔗 Important Routes

### For Tanods
```
/tanod/dashboard          Main dashboard
/tanod/pending            Unassigned requests
/tanod/assigned           Your assigned requests
/tanod/resolved           Your resolved requests
/tanod/{id}               Request details & respond
```

### For Citizens
```
/urgent-requests          Your requests list
/urgent-requests/create   Submit new request
/urgent-requests/{id}     View & track request
```

### For All Users
```
/dashboard                Role-based dashboard redirect
/profile                  User profile
```

---

## 💡 Pro Tips

### For Tanods
1. Check dashboard every shift for pending requests
2. Add descriptive messages when updating status
3. Mark as "On The Way" to notify citizen of ETA
4. Include resolution notes when closing requests
5. View resolved history to track performance

### For Citizens
1. Provide accurate location when submitting
2. Include detailed description of emergency
3. Check "Resolved" requests for tanod notes
4. Keep emergency contact info updated
5. Follow tanod instructions in messages

---

## ⚙️ System Features

✅ **Real-time Updates**
- Status changes appear immediately
- Timeline shows all interactions

✅ **Audit Trail**
- Every action logged with timestamp
- Complete history of request
- Shows who changed what when

✅ **Geolocation Support**
- Tanods can share location coordinates
- Optional latitude/longitude on updates

✅ **Contact Information**
- Citizen phone & email visible to assigned tanod
- Enables direct communication if needed

✅ **Performance Tracking**
- Time from submission to assignment
- Time from submission to resolution
- Shows response efficiency

---

## 🐛 Troubleshooting

### Issue: Login page shows old demo accounts only
**Solution:** 
- Clear browser cache (Ctrl+Shift+Del)
- Or use Incognito/Private browsing window

### Issue: Dashboard showing "You're logged in!" instead of dashboard
**Solution:**
- Make sure you logged in as correct role
- Check URL is /tanod/dashboard (for tanod)
- Clear browser cache

### Issue: Can't see requests in pending list
**Solution:**
- Make sure citizen submitted urgent request (not complaint)
- Request must have status "submitted"
- Refresh page after new submission

### Issue: Forms showing validation errors
**Solution:**
- Fill all required fields (marked with *)
- Follow field requirements:
  - Title: max 255 characters
  - Description: max 1000 characters
  - Category & Priority: must select from dropdown

---

## 📞 Contact & Support

For issues or questions:
1. Check this guide first
2. Review TANOD_FINAL_STATUS_REPORT.md for technical details
3. Review TANOD_FEATURE_IMPLEMENTATION.md for architecture

---

## ✅ Verification Checklist

After setup, verify:
- [ ] Can login as tanod1@mail.com
- [ ] Dashboard displays 4 stat cards
- [ ] Can view pending requests
- [ ] Can accept & assign request
- [ ] Can update status with message
- [ ] Can view resolved requests
- [ ] Can register as citizen
- [ ] Can submit urgent request as citizen
- [ ] Can see assigned tanod info
- [ ] Can track status updates in real-time

---

**Version:** 1.0  
**Last Updated:** October 23, 2025  
**Status:** ✅ Ready for Use

---
