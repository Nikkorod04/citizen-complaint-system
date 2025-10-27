# Barangay Complaint System - Flowcharts

## 1. System Architecture Overview

```
┌─────────────────────────────────────────────────────────────────────┐
│                    BARANGAY COMPLAINT SYSTEM                        │
├─────────────────────────────────────────────────────────────────────┤
│                                                                     │
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐              │
│  │   CITIZEN    │  │  SECRETARY   │  │   CAPTAIN    │              │
│  │              │  │              │  │              │              │
│  │- Submit      │  │- Verify      │  │- Approve     │              │
│  │  Complaint   │  │  Complaints  │  │  Complaints  │              │
│  │- Submit      │  │- Verify      │  │- Generate    │              │
│  │  Emergency   │  │  Citizens    │  │  Resolutions │              │
│  │  Request     │  │              │  │              │              │
│  └──────────────┘  └──────────────┘  └──────────────┘              │
│                                                                     │
│  ┌──────────────┐                                                  │
│  │    TANOD     │                                                  │
│  │              │                                                  │
│  │- Accept      │                                                  │
│  │  Emergency   │                                                  │
│  │  Requests    │                                                  │
│  │- Update      │                                                  │
│  │  Status      │                                                  │
│  └──────────────┘                                                  │
│                                                                     │
│  ┌──────────────────────────────────────────┐                      │
│  │        MYSQL DATABASE (5.7+)            │                      │
│  │  - users                                 │                      │
│  │  - complaints                            │                      │
│  │  - urgent_requests                       │                      │
│  │  - complaint_categories                  │                      │
│  │  - complaint_tracking_history            │                      │
│  │  - urgent_request_updates                │                      │
│  └──────────────────────────────────────────┘                      │
└─────────────────────────────────────────────────────────────────────┘
```

---

## 2. User Registration & Verification Flow

```
┌─────────────────────────────────────────────────────────────────────┐
│           CITIZEN REGISTRATION & VERIFICATION FLOW                  │
└─────────────────────────────────────────────────────────────────────┘

                              START
                                │
                                ▼
                    ┌─────────────────────┐
                    │  Citizen Registers  │
                    │   (Fill Form)       │
                    └────────┬────────────┘
                             │
                             ▼
            ┌────────────────────────────────┐
            │  User Created in Database      │
            │  Status: pending               │
            │  verification_status: pending  │
            └────────────┬───────────────────┘
                         │
                         ▼
         ┌───────────────────────────────┐
         │  Citizen Submits FIRST        │
         │  Complaint                    │
         └──────────┬────────────────────┘
                    │
                    ▼
        ┌──────────────────────────────┐
        │  Secretary Reviews           │
        │  Complaint                   │
        └──────────┬───────────────────┘
                   │
         ┌─────────┴──────────┐
         │                    │
         ▼                    ▼
    ┌─────────┐          ┌────────┐
    │ VALIDATE│          │ REJECT │
    └────┬────┘          └────────┘
         │
         ▼
┌──────────────────────────────┐
│  Citizen AUTOMATICALLY        │
│  VERIFIED                     │
│  Status: approved             │
│  verified_at: now()           │
└──────────────┬───────────────┘
               │
               ▼
    ┌──────────────────────┐
    │  Can Now:            │
    │  ✅ Submit           │
    │     Complaints       │
    │  ✅ Submit Emergency │
    │     Requests         │
    │  ✅ View QR Code     │
    └──────────────────────┘

NOTE: QR Code is generated ONCE at registration
      NOT per complaint submission
```

---

## 3. Complaint Workflow

```
┌─────────────────────────────────────────────────────────────────────┐
│               COMPLAINT WORKFLOW (FULL CYCLE)                       │
└─────────────────────────────────────────────────────────────────────┘

┌──────────────────┐
│    STEP 1        │
│  CITIZEN SUBMITS │
└────────┬─────────┘
         │
         ▼
    ┌────────────────────────────────┐
    │ Complaint Created              │
    │ - Status: pending              │
    │ - submitted_at: now()          │
    │ - citizen_id: set              │
    └────────┬──────────────────────┘
             │
             ▼
┌──────────────────┐
│    STEP 2        │
│   SECRETARY      │
│   VALIDATES      │
└────────┬─────────┘
         │
         ▼
    ┌────────────────────────────────┐
    │ Secretary Reviews Complaint    │
    │ Path: /secretary/pending       │
    └────────┬──────────────────────┘
             │
    ┌────────┴────────┐
    │                 │
    ▼                 ▼
┌────────┐       ┌───────────┐
│VALIDATE│       │ REJECT    │
└───┬────┘       └───────┬───┘
    │                    │
    │                    ▼
    │            ┌─────────────────┐
    │            │ Status: rejected │
    │            │ END PROCESS      │
    │            └─────────────────┘
    │
    ▼
┌──────────────────────────────┐
│ Status: validated            │
│ secretary_id: set            │
│ validated_at: now()          │
│ Citizen AUTOMATICALLY        │
│ verified if first complaint  │
└────────┬─────────────────────┘
         │
         ▼
┌──────────────────┐
│    STEP 3        │
│   CAPTAIN        │
│  APPROVES        │
└────────┬─────────┘
         │
         ▼
    ┌────────────────────────────────┐
    │ Captain Reviews Complaint      │
    │ Path: /captain/pending         │
    └────────┬──────────────────────┘
             │
    ┌────────┴────────┐
    │                 │
    ▼                 ▼
┌────────┐       ┌───────────┐
│APPROVE │       │ REJECT    │
└───┬────┘       └───────┬───┘
    │                    │
    │                    ▼
    │            ┌─────────────────┐
    │            │ Status: rejected │
    │            │ END PROCESS      │
    │            └─────────────────┘
    │
    ▼
┌──────────────────────────────┐
│ Status: investigating        │
│ captain_id: set              │
│ Investigation starts         │
└────────┬─────────────────────┘
         │
         ▼
┌──────────────────┐
│    STEP 4        │
│  INVESTIGATION   │
│   IN PROGRESS    │
└────────┬─────────┘
         │
    ┌────────────────┐
    │ Time Passes... │
    │ (Days/Weeks)   │
    └────────┬───────┘
             │
             ▼
    ┌──────────────────────────┐
    │ Captain Marks RESOLVED   │
    │ Path: /captain/resolved  │
    └────────┬─────────────────┘
             │
             ▼
┌──────────────────────────────┐
│ Status: resolved             │
│ resolved_at: now()           │
│ PROCESS COMPLETE             │
└──────────────────────────────┘

STATUS PROGRESSION:
pending → validated → investigating → resolved
          (or rejected at any point)
```

---

## 4. Emergency/Urgent Request Workflow

```
┌─────────────────────────────────────────────────────────────────────┐
│           EMERGENCY URGENT REQUEST WORKFLOW (NEW FEATURE)           │
└─────────────────────────────────────────────────────────────────────┘

┌──────────────────┐
│    STEP 1        │
│  CITIZEN SUBMITS │
│  URGENT REQUEST  │
└────────┬─────────┘
         │
         ▼
    ┌──────────────────────────────┐
    │ Go to Dashboard              │
    │ Click "Urgent Report" Button │
    │ Fill Form:                   │
    │ - title                      │
    │ - description                │
    │ - location                   │
    │ - category (6 options)       │
    │ - priority (high/urgent)     │
    └────────┬─────────────────────┘
             │
             ▼
    ┌──────────────────────────────┐
    │ Urgent Request Created       │
    │ - Status: submitted          │
    │ - citizen_id: set            │
    │ - submitted_at: now()        │
    │ - tanod_id: NULL (unassigned)│
    └────────┬─────────────────────┘
             │
             ▼ (Tanods Notified)
┌──────────────────┐
│    STEP 2        │
│  TANOD ACCEPTS   │
│  & ASSIGNS       │
└────────┬─────────┘
         │
         ▼
    ┌──────────────────────────────┐
    │ Tanod Views:                 │
    │ /tanod/pending               │
    │ (All unassigned requests)    │
    └────────┬─────────────────────┘
             │
             ▼
    ┌──────────────────────────────┐
    │ Tanod Clicks:                │
    │ "Accept & Assign to Me"      │
    └────────┬─────────────────────┘
             │
             ▼
    ┌──────────────────────────────┐
    │ Urgent Request Updated       │
    │ - Status: assigned           │
    │ - tanod_id: set              │
    │ - assigned_at: now()         │
    │ Redirect to details page     │
    └────────┬─────────────────────┘
             │
             ▼
┌──────────────────┐
│    STEP 3        │
│  TANOD RESPONDS  │
│  & UPDATES       │
│  STATUS          │
└────────┬─────────┘
         │
         ▼
    ┌──────────────────────────────┐
    │ Tanod Views Request Details  │
    │ Sees "Respond to Request"    │
    │ Form:                        │
    │ - Status Options:            │
    │   • In Progress              │
    │   • On The Way               │
    │   • Resolved                 │
    │ - Optional Message           │
    │ - Optional GPS Coords        │
    └────────┬─────────────────────┘
             │
             ▼
    ┌──────────────────────────────┐
    │ Tanod Selects Status         │
    │ "In Progress"                │
    └────────┬─────────────────────┘
             │
             ▼
    ┌──────────────────────────────┐
    │ Click "Update Status"        │
    │ Creates Entry in:            │
    │ urgent_request_updates       │
    │ Status: in_progress          │
    │ responded_at: now()          │
    │ Form REMAINS VISIBLE         │
    │ (Citizen Notified)           │
    └────────┬─────────────────────┘
             │
             ▼ (Tanod traveling...)
┌──────────────────┐
│    STEP 4        │
│  TANOD UPDATES   │
│  TO "ON THE WAY" │
└────────┬─────────┘
         │
         ▼
    ┌──────────────────────────────┐
    │ Same Form Still Visible      │
    │ Tanod Selects:               │
    │ "On The Way"                 │
    │ Optional: Add Message        │
    │ Optional: GPS Location       │
    └────────┬─────────────────────┘
             │
             ▼
    ┌──────────────────────────────┐
    │ Click "Update Status" Again  │
    │ Creates NEW Entry in:        │
    │ urgent_request_updates       │
    │ New Status: on_the_way       │
    │ Previous updates shown in    │
    │ Response History             │
    │ (Citizen Notified)           │
    └────────┬─────────────────────┘
             │
             ▼ (Tanod arrives & handles...)
┌──────────────────┐
│    STEP 5        │
│  TANOD MARKS     │
│  RESOLVED        │
└────────┬─────────┘
         │
         ▼
    ┌──────────────────────────────┐
    │ Tanod Selects:               │
    │ "Resolved"                   │
    │ Optional: Final Message      │
    │ Optional: GPS Location       │
    └────────┬─────────────────────┘
             │
             ▼
    ┌──────────────────────────────┐
    │ Click "Update Status"        │
    │ Creates FINAL Entry          │
    │ Status: resolved             │
    │ resolved_at: now()           │
    │ Form DISAPPEARS              │
    │ Response History Shown       │
    │ (Citizen Notified)           │
    └────────┬─────────────────────┘
             │
             ▼
    ┌──────────────────────────────┐
    │ Request COMPLETE             │
    │ Moved to /tanod/resolved     │
    │ Available in citizen's       │
    │ /urgent-requests history     │
    └──────────────────────────────┘

STATUS PROGRESSION:
submitted (unassigned)
    ↓ [Tanod accepts]
assigned (tanod assigned, not yet responded)
    ↓ [Tanod responds]
in_progress (tanod actively handling)
    ↓ or on_the_way (tanod traveling)
    ↓ [Tanod completes]
resolved (COMPLETE)

ALTERNATIVE PATH:
submitted/assigned → cancelled (citizen cancels anytime before resolution)
```

---

## 5. Authentication & Role-Based Access

```
┌─────────────────────────────────────────────────────────────────────┐
│              AUTHENTICATION & AUTHORIZATION FLOW                    │
└─────────────────────────────────────────────────────────────────────┘

                              START
                                │
                                ▼
                        ┌────────────────┐
                        │  User Visits   │
                        │ /localhost:8000│
                        └────────┬───────┘
                                 │
                    ┌────────────┴────────────┐
                    │                         │
                    ▼                         ▼
        ┌──────────────────────┐    ┌──────────────────┐
        │  Authenticated?      │    │ Go to Login Page │
        │  (Has Auth Token)    │    │                  │
        │  YES                 │    │ Input Email &    │
        └────────┬─────────────┘    │ Password         │
                 │                  └────────┬─────────┘
                 ▼                           │
        ┌──────────────────────┐             ▼
        │ Middleware Check:    │      ┌──────────────────┐
        │ - Is role valid?     │      │ Validate         │
        │ - Is citizen verified?      │ Credentials      │
        │   (if needed)        │      └────────┬─────────┘
        └────────┬─────────────┘               │
                 │                  ┌─────────┴──────────┐
         ┌───────┴────────┐        │                    │
         │                │        ▼                    ▼
         ▼                ▼   ┌──────────┐         ┌──────────┐
    ┌──────────┐    ┌──────────┐VALID    │        │ INVALID  │
    │PASS ALL  │    │FAIL AUTH │  │       │        │ Redirect │
    │CHECKS    │    │          │  ▼       │        │ to Login │
    └────┬─────┘    └──────────┘┌──────┐ │        └──────────┘
         │                       │Create│ │
         │                       │Token │ │
         │                       └──┬───┘ │
         │                          │     │
         │               ┌──────────┴─────┘
         │               │
         ▼               ▼
    ┌──────────────────────────┐
    │ Check User Role          │
    └────────┬────────────────┘
             │
    ┌────────┼────────┬───────────┬──────────┐
    │        │        │           │          │
    ▼        ▼        ▼           ▼          ▼
┌──────┐┌──────┐┌──────┐┌──────┐┌──────┐
│CITIZ-││SEC'Y ││CAPT ││TANOD │
│EN    │      │      │      │
└───┬──┘└───┬──┘└───┬──┘└───┬──┘
    │       │       │       │
    ▼       ▼       ▼       ▼
/citizen /secre /captain /tanod
/dash-   tary/  /dash-   /dash-
board    dash-  board    board
         board

MIDDLEWARE STACK:
┌─────────────────────────────────────────┐
│ ALL ROUTES: [auth] middleware           │
│ Verifies user is logged in              │
├─────────────────────────────────────────┤
│ ROLE ROUTES: [auth, role:citizen]       │
│ Verifies user has correct role          │
├─────────────────────────────────────────┤
│ CITIZEN FEATURES: [auth, role:citizen,  │
│ verified.citizen]                       │
│ Verifies citizen is verified            │
└─────────────────────────────────────────┘

AUTHORIZATION CHECKS:
┌─────────────────────────────────────────┐
│ Route-Level:                            │
│ If role doesn't match → 403 Forbidden   │
├─────────────────────────────────────────┤
│ Model-Level:                            │
│ if (complaint.citizen_id !== auth().id) │
│   → abort(403, 'Unauthorized')          │
└─────────────────────────────────────────┘
```

---

## 6. Dashboard Routing Flow

```
┌─────────────────────────────────────────────────────────────────────┐
│               DASHBOARD ROUTING BY ROLE                             │
└─────────────────────────────────────────────────────────────────────┘

                    User Clicks Dashboard
                    OR Goes to /dashboard
                              │
                              ▼
                    ┌──────────────────────┐
                    │ Route /dashboard     │
                    │ Check Auth::user()   │
                    │ Check $user->role    │
                    └────────┬─────────────┘
                             │
        ┌────────────────────┼────────────────────┬──────────────┐
        │                    │                    │              │
        ▼                    ▼                    ▼              ▼
    ┌────────┐          ┌────────┐         ┌────────┐      ┌────────┐
    │CITIZEN │          │SECRETARY         │CAPTAIN │      │TANOD   │
    │        │          │        │         │        │      │        │
    └───┬────┘          └───┬────┘         └───┬────┘      └───┬────┘
        │                   │                   │              │
        ▼                   ▼                   ▼              ▼
    /citizen          /secretary         /captain         /tanod
    /dashboard        /dashboard         /dashboard       /dashboard
        │                   │                   │              │
        ▼                   ▼                   ▼              ▼
    ┌────────┐          ┌─────────┐       ┌────────┐      ┌────────┐
    │ 4 Stats│          │3 Stats  │       │5 Stats │      │4 Stats │
    │ Cards: │          │ Cards:  │       │ Cards: │      │ Cards: │
    │ •Total │          │•Pending │       │•Total  │      │•Pending│
    │•Pending│          │ Verif's │       │•Awaiting       │•Assigned
    │•Validat│          │•Pending │       │ Review │      │•Active │
    │•Resolved          │ Complain│       │•Investi│      │•Resolved
    │        │          │•Validat │       │ gating │      │ Today  │
    └────┬───┘          │ Today   │       │•Resolved       └───┬────┘
         │              └──┬──────┘       │ Month  │          │
         │                 │              │•Resolved         │
         ▼                 ▼              │ Today  │          ▼
    Quick           Quick Actions    │        │    Quick
    Actions:        - View Pending   └────┬───┘    Actions:
    - File New      - Process                      - View
      Complaint       Complaints      Dashboard      Pending
    - Urgent        - View           Cards,         Requests
      Report          Validating     Tables,      - View
    - View All                       Reports       Assigned
      Complaints   Active List:      Active List   Requests
    - My QR         - Recent                      - View
      Code          - Current                      Resolved
                    - Trending

    View Recent     View Processing   View          View
    Complaints      Complaints        Resolutions   Progress
```

---

## 7. Data Model Relationships

```
┌─────────────────────────────────────────────────────────────────────┐
│                  DATABASE RELATIONSHIP DIAGRAM                      │
└─────────────────────────────────────────────────────────────────────┘

                        ┌─────────────┐
                        │   USERS     │
                        ├─────────────┤
                        │ id (PK)     │
                        │ email       │
                        │ role        │
                        │ verify_stat │
                        └──────┬──────┘
                               │
             ┌─────────────────┼─────────────────┬──────────────┐
             │                 │                 │              │
             ▼                 ▼                 ▼              ▼
    ┌───────────────┐ ┌──────────────┐ ┌──────────────┐ ┌─────────┐
    │COMPLAINTS     │ │URGENT_REQUEST│ │COMPLAINT_    │ │URGENT_  │
    ├───────────────┤ ├──────────────┤ │TRACKING_     │ │REQUEST_ │
    │ id (PK)       │ │ id (PK)      │ │HISTORY       │ │UPDATES  │
    │ citizen_id(FK)├─┤ citizen_id   │ ├──────────────┤ ├─────────┤
    │ secretary_id  │ │(FK)          │ │ id (PK)      │ │ id (PK) │
    │(FK)           │ │ tanod_id(FK) │ │ complaint_id │ │ urgent_ │
    │ captain_id    │ │              │ │(FK)          │ │ request │
    │(FK)           │ │ status       │ │ changed_by   │ │ _id(FK) │
    │ category_id   │ │ submitted_at │ │(FK)          │ │ tanod_id│
    │(FK)           │ │ assigned_at  │ │ old_status   │ │(FK)    │
    │ status        │ │ responded_at │ │ new_status   │ │ status  │
    │ submitted_at  │ │ resolved_at  │ │ reason       │ │ message │
    │ validated_at  │ └──────────────┘ │ created_at   │ │ lat/lng │
    │ resolved_at   │        │          └──────────────┘ │ created │
    └────────┬──────┘        └──────────────────┐        └─────────┘
             │                                  │
             ▼                                  ▼
    ┌──────────────────┐            ┌──────────────────┐
    │COMPLAINT_        │            │COMPLAINT_        │
    │CATEGORIES        │            │CATEGORIES        │
    ├──────────────────┤            ├──────────────────┤
    │ id (PK)          │            │ id (PK)          │
    │ name             │            │ name             │
    │ description      │            │ description      │
    └──────────────────┘            └──────────────────┘

KEY RELATIONSHIPS:
─────────────────────────────────────────

User:
  ├─ submittedComplaints (hasMany) → Complaint
  ├─ validatedComplaints (hasMany) → Complaint (as secretary)
  ├─ approvedComplaints (hasMany) → Complaint (as captain)
  ├─ submittedUrgentRequests (hasMany) → UrgentRequest
  ├─ assignedUrgentRequests (hasMany) → UrgentRequest (as tanod)
  └─ urgentRequestUpdates (hasMany) → UrgentRequestUpdate

Complaint:
  ├─ citizen (belongsTo) → User
  ├─ secretary (belongsTo) → User
  ├─ captain (belongsTo) → User
  ├─ category (belongsTo) → ComplaintCategory
  └─ tracking (hasMany) → ComplaintTrackingHistory

UrgentRequest:
  ├─ citizen (belongsTo) → User
  ├─ tanod (belongsTo) → User
  └─ updates (hasMany) → UrgentRequestUpdate

UrgentRequestUpdate:
  ├─ urgentRequest (belongsTo) → UrgentRequest
  └─ tanod (belongsTo) → User
```

---

## 8. Complete System User Journey

```
┌─────────────────────────────────────────────────────────────────────┐
│            COMPLETE USER JOURNEY - ALL PATHS                        │
└─────────────────────────────────────────────────────────────────────┘

═══════════════════════════════════════════════════════════════════════

PATH 1: NEW CITIZEN - COMPLAINT SUBMISSION
─────────────────────────────────────────────

1. Visit http://localhost:8000
2. Click Register
3. Fill Registration Form
4. Account Created (unverified)
5. Login with credentials
6. Redirected to /citizen/dashboard
7. Try to submit complaint
8. Restricted (not verified)
9. Wait for verification
10. Secretary validates first complaint
11. Citizen AUTOMATICALLY verified
12. Now can submit more complaints
13. Track complaint status through workflow

═══════════════════════════════════════════════════════════════════════

PATH 2: NEW CITIZEN - EMERGENCY REQUEST
──────────────────────────────────────────

1. Login as verified citizen
2. Go to /citizen/dashboard
3. See "Urgent Report" button
4. Click button
5. Fill emergency request form
   - Title, Description, Location
   - Category (medical, accident, fire, etc)
   - Priority (high, urgent)
6. Submit request
7. Status: submitted
8. Tanods see new request in /tanod/pending
9. Tanod accepts & assigns
10. Status: assigned
11. Tanod updates status
12. See progress in real-time
13. Track until resolved

═══════════════════════════════════════════════════════════════════════

PATH 3: SECRETARY - VERIFICATION WORKFLOW
───────────────────────────────────────────

1. Login as secretary@mail.com
2. Redirected to /secretary/dashboard
3. See pending verifications count
4. Click "Pending Verifications"
5. Review complaints from unverified citizens
6. Validate or Reject each complaint
7. If validate: citizen AUTOMATICALLY verified
8. Complaint moves to validated status
9. Captain can now review
10. Secretary can view analytics dashboard

═══════════════════════════════════════════════════════════════════════

PATH 4: CAPTAIN - APPROVAL WORKFLOW
─────────────────────────────────────

1. Login as captain@mail.com
2. Redirected to /captain/dashboard
3. See comprehensive stats (5 cards)
4. See validated complaints awaiting review
5. Review each complaint details
6. Approve → Investigation starts
7. Reject → With feedback
8. Later: Mark as resolved
9. Add resolution notes
10. View resolved complaints history

═══════════════════════════════════════════════════════════════════════

PATH 5: TANOD - EMERGENCY RESPONSE
────────────────────────────────────

1. Login as tanod1@mail.com
2. Redirected to /tanod/dashboard
3. See pending emergency requests
4. Navigate to /tanod/pending
5. See unassigned requests
6. Click "Accept & Assign to Me"
7. Redirected to request details
8. Select "In Progress" status
9. Add optional message
10. Click "Update Status"
11. Form still visible
12. Update to "On The Way"
13. Add location if available
14. Click "Update Status" again
15. Form still visible
16. Finally select "Resolved"
17. Add final message
18. Click "Update Status"
19. Form disappears
20. See complete response history
21. Check /tanod/resolved to see completed requests

═══════════════════════════════════════════════════════════════════════
```

---

## 9. Status Change Progression Diagram

```
┌─────────────────────────────────────────────────────────────────────┐
│              STATUS PROGRESSION - ALL POSSIBLE PATHS                │
└─────────────────────────────────────────────────────────────────────┘

COMPLAINT STATUSES:
──────────────────

            PENDING
             │
             ├──→ VALIDATED ──→ INVESTIGATING ──→ RESOLVED
             │                                      ▲
             └──────→ REJECTED ───────────────────┘
                (can happen from any status)

┌─────────────────────────────────────────┐
│ Pending → Validated: Secretary validates │
│ Validated → Investigating: Captain      │
│ Investigating → Resolved: Captain       │
│ X → Rejected: At any stage               │
└─────────────────────────────────────────┘

URGENT REQUEST STATUSES:
───────────────────────

            SUBMITTED (unassigned)
                │
                └──→ ASSIGNED
                     │
                     ├──→ IN_PROGRESS
                     │   │
                     │   └──→ ON_THE_WAY
                     │       │
                     │       └──→ RESOLVED
                     │
                     └──→ CANCELLED (if citizen cancels)

┌──────────────────────────────────────────────────┐
│ Submitted → Assigned: Tanod accepts              │
│ Assigned → In Progress: Tanod responds           │
│ In Progress → On The Way: Tanod updates          │
│ On The Way → Resolved: Tanod completes          │
│ Any Status → Cancelled: Citizen cancels         │
└──────────────────────────────────────────────────┘

VERIFICATION STATUSES:
──────────────────────

        PENDING (new registration)
            │
            └──→ APPROVED (upon 1st validated complaint)
                │
                └──→ REJECTED (optional admin action)

┌──────────────────────────────────────────────┐
│ When Secretary validates first complaint:    │
│ Citizen verification_status → APPROVED       │
│ verified_at timestamp → recorded              │
│ All citizen features now accessible           │
└──────────────────────────────────────────────┘
```

---

## 10. Request/Response Cycle

```
┌─────────────────────────────────────────────────────────────────────┐
│             TYPICAL REQUEST/RESPONSE CYCLE                          │
└─────────────────────────────────────────────────────────────────────┘

CLIENT BROWSER                          SERVER (Laravel)
──────────────                          ────────────────

GET /citizen/dashboard
         │
         ├─────────────────────────────→ Route Matching
         │                              Middleware Check
         │                              - auth
         │                              - role:citizen
         │                              - verified.citizen
         │                              ↓
         │                              CitizenController
         │                              →dashboard()
         │                              ↓
         │                              Fetch stats
         │                              Fetch complaints
         │                              Load view
         │                              ↓
         │←──────────────────────────── Render HTML
Render Dashboard Page
         │
User Clicks "File New Complaint"
         │
GET /complaints/create
         │
         ├─────────────────────────────→ Load form view
         │
         │←──────────────────────────── Return form HTML
Show Form
         │
User Fills & Submits Form
         │
POST /complaints
         │
         ├─────────────────────────────→ Route Matching
         │                              Middleware Check
         │                              ↓
         │                              Validate Input
         │                              - subject: required
         │                              - description: required
         │                              - category_id: required
         │                              ↓
         │                              Create Complaint
         │                              - citizen_id = auth().id()
         │                              - status = 'pending'
         │                              - submitted_at = now()
         │                              ↓
         │                              Save to Database
         │                              ↓
         │←──────────────────────────── Redirect with Message
Redirect to /complaints/{id}
         │
GET /complaints/{id}
         │
         ├─────────────────────────────→ Fetch complaint
         │                              Check authorization
         │                              - if citizen_id !== user.id
         │                                  → 403 Forbidden
         │                              ↓
         │                              Load complaint details
         │                              Load tracking history
         │                              ↓
         │←──────────────────────────── Render details view
Show Complaint Success Message
& Complaint Details

DATABASE OPERATIONS:
───────────────────

Write: INSERT → complaints (new complaint)
       INSERT → complaint_tracking_history (status change)
       
Read:  SELECT → user (get auth user)
       SELECT → complaints (list user's complaints)
       SELECT → complaint_tracking_history (audit trail)
       
Update: UPDATE → complaints (change status)
        INSERT → complaint_tracking_history (record change)
```

---

## 11. Error Handling Flow

```
┌─────────────────────────────────────────────────────────────────────┐
│                    ERROR HANDLING FLOW                              │
└─────────────────────────────────────────────────────────────────────┘

                    REQUEST RECEIVED
                          │
                          ▼
                  ┌────────────────┐
                  │ Route Match?   │
                  └────────┬───────┘
                           │
                ┌──────────┴──────────┐
                │                     │
               YES                   NO
                │                     │
                ▼                     ▼
          ┌──────────┐         ┌───────────┐
          │Middleware│         │ 404 Error │
          │ Checks   │         │ Not Found │
          └────┬─────┘         └───────────┘
               │
      ┌────────┴────────┐
      │                 │
     PASS             FAIL
      │                 │
      ▼                 ▼
  ┌────────┐       ┌──────────┐
  │Validate│       │ 403 Error│
  │ Input  │       │Forbidden │
  └────┬───┘       └──────────┘
       │                │
  ┌────┴────┐      └ Redirect
 PASS      FAIL        to login
   │        │
   ▼        ▼
┌───────┐┌─────────┐
│Process││422 Error│
│Request│Unprocess│
└───┬───┘│able     │
    │    └─────────┘
    │         │
    ▼         └─ Return form
┌────────┐      with errors
│Execute │
│Logic   │
└───┬────┘
    │
┌───┴────┐
│         │
SUCCESS  ERROR
│         │
▼         ▼
┌──────┐┌──────────┐
│200 OK││500 Error │
│Render││Server    │
│View  ││Error     │
└──────┘└──────────┘

COMMON ERRORS:
──────────────

401 Unauthorized
├─ Not logged in
└─ Redirect to /login

403 Forbidden
├─ Wrong role
├─ Not verified citizen
└─ Unauthorized access to resource

404 Not Found
├─ Route doesn't exist
└─ Resource doesn't exist

422 Unprocessable Entity
├─ Validation failed
└─ Return form with error messages

500 Server Error
├─ Unhandled exception
└─ Log error, show error page
```

---

## 12. Real-Time Update Flow (Citizen Receives Updates)

```
┌─────────────────────────────────────────────────────────────────────┐
│         CITIZEN RECEIVES REAL-TIME UPDATES (In Progress)            │
└─────────────────────────────────────────────────────────────────────┘

CITIZEN SUBMITS REQUEST
     │
     ├─→ Notification Sent to Tanods
     │
     ▼
CITIZEN VIEWS TRACKING PAGE
/urgent-requests/{id}/track
     │
     ├─→ Status: submitted
     ├─→ No Response History Yet
     │
     ▼ (Tanod accepts)
     │
CITIZEN REFRESHES PAGE
     │
     ├─→ Status: assigned
     ├─→ Can see assigned Tanod info
     ├─→ Response History:
     │   - Assigned at 2:30 PM
     │
     ▼ (Tanod updates status)
     │
CITIZEN NOTIFIED
(Future: Email/SMS notification)
     │
     ├─→ Update: "In Progress - Responding to your request"
     │
     ▼
CITIZEN REFRESHES PAGE
     │
     ├─→ Status: in_progress
     ├─→ Response History:
     │   - Assigned at 2:30 PM
     │   - In Progress at 2:45 PM
     │     Message: "Responding to your request"
     │
     ▼ (Tanod updates status again)
     │
CITIZEN NOTIFIED
     │
     ├─→ Update: "On The Way - 5 minutes away"
     │
     ▼
CITIZEN REFRESHES PAGE
     │
     ├─→ Status: on_the_way
     ├─→ Response History:
     │   - Assigned at 2:30 PM
     │   - In Progress at 2:45 PM
     │   - On The Way at 3:00 PM
     │     Message: "5 minutes away"
     │
     ▼ (Tanod resolves)
     │
CITIZEN NOTIFIED
     │
     ├─→ Update: "Resolved - Issue has been addressed"
     │
     ▼
CITIZEN VIEWS PAGE
     │
     ├─→ Status: resolved
     ├─→ Complete Timeline:
     │   - Submitted by you
     │   - Assigned to Tanod
     │   - In Progress
     │   - On The Way
     │   - Resolved
     │     Final Message: "Issue resolved"
     │
     └─→ Can Rate/Comment (future feature)

DATA FLOW:
──────────

Citizen Table
    ↓
UrgentRequest table (status: submitted)
    ↓ (Tanod accepts)
UrgentRequest table (status: assigned)
UrgentRequestUpdate table (new entry)
    ↓ (Citizen checks status)
Citizen fetches from DB
    ↓ (Tanod responds)
UrgentRequest table (status: in_progress)
UrgentRequestUpdate table (new entry with message)
    ↓ (Citizen receives notification)
    ↓ (Citizen refreshes page)
Citizen views latest updates
```

---

## Legend & Symbols

```
───────────────────────────────────────
  FLOWCHART LEGEND & SYMBOLS
───────────────────────────────────────

┌──────┐                 Box/Process
│      │
└──────┘

   │                     Flow Arrow
   ▼

  ◇                      Decision Diamond
  
┌─────┐                 Terminated/End
└─────┘

   →                     Alternative Path

[AUTH]                   Middleware Check

(FK)                     Foreign Key

(PK)                     Primary Key

N+1                      Database Problem

===============            Section Divider

```

---

## Quick Reference

### Common Status Codes
- **200 OK** - Request successful
- **302 Found** - Redirect
- **400 Bad Request** - Invalid input
- **401 Unauthorized** - Not authenticated
- **403 Forbidden** - No permission
- **404 Not Found** - Resource doesn't exist
- **422 Unprocessable** - Validation failed
- **500 Server Error** - Internal error

### Complaint Statuses
- **pending** → Yellow
- **validated** → Blue
- **investigating** → Orange
- **resolved** → Green
- **rejected** → Red

### Urgent Request Statuses
- **submitted** → Yellow
- **assigned** → Blue
- **in_progress** → Orange
- **on_the_way** → Purple
- **resolved** → Green
- **cancelled** → Red

### User Roles
- **citizen** - Submit complaints/requests
- **secretary** - Verify submissions
- **captain** - Approve & resolve
- **tanod** - Respond to emergencies

