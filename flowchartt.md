# Barangay Complaint System - Flowchart Guide

## Flowchart Symbols Reference

### Standard Flowchart Symbols

```
┌─────────────┐
│   (OVAL)    │  START / STOP / TERMINAL
│  START/END  │  Used for beginning and end of process
└─────────────┘

┌──────────────────┐
│ (PARALLELOGRAM)  │  INPUT / OUTPUT
│   INPUT/OUTPUT   │  User enters data, system displays info
└──────────────────┘

┌──────────────────┐
│  (RECTANGLE)     │  PROCESS / ACTION
│    PROCESS       │  Execute a task, calculation, or action
└──────────────────┘

      ◇ (DIAMOND)
     ╱ ╲          DECISION / CONDITION
    ╱   ╲         YES/NO question, branching logic
   ╱─────╲
  YES   NO

┌──────────────────┐
│   CONNECTOR      │  JUNCTION POINT
│   (SMALL OVAL)   │  Continue flow on same/different page
└──────────────────┘

    ARROW (→)      FLOW DIRECTION
    Connects symbols, shows sequence
```

---

## 1. AUTHENTICATION FLOW (Login & Register)

### 1.1 Login Flow

```
         ┌─────────────┐
         │    START    │
         └──────┬──────┘
                │
         ┌──────▼──────────────┐
         │  User Visits /login │
         └──────┬──────────────┘
                │
         ┌──────▼────────────────────┐
         │ INPUT: Email & Password   │
         │ (Parallelogram)           │
         └──────┬────────────────────┘
                │
         ┌──────▼──────────────┐
         │  Click "Sign In"    │
         │  (Rectangle)        │
         └──────┬──────────────┘
                │
         ┌──────▼────────────────────────┐
         │  Validate Credentials         │
         │  (Rectangle - Process)        │
         └──────┬────────────────────────┘
                │
              ◇ (Diamond - Decision)
             ╱ ╲
        YES ╱   ╲ NO
           ╱     ╲
          │       │
   ┌──────▼──┐   ┌──────▼──────────────┐
   │ CHECK   │   │ SHOW ERROR MESSAGE  │
   │ ROLE    │   │ (Output)            │
   └──────┬──┘   └──────┬──────────────┘
          │             │
    ┌─────▼─────────┐   │
    │   CITIZEN?    │   │
    │   (Decision)  │   │
    └─┬───┬─────────┘   │
      │YES│NO           │
      │   │        ┌────▼─────────────┐
      │   │        │ Return to Login  │
      │   │        │ (Arrow Loop)     │
      │   │        └────┬─────────────┘
      │   │             │
      │   └────────┬────┘
      │            │
      ├─────┬──────┤
      │     │      │
   CITIZEN SECRETARY/CAPTAIN/TANOD
      │     │      │
      │     │      │
  ┌───▼──┐┌──▼──┐┌─▼───┐
  │ CHECK││CHECK││CHECK│
  │VERIFY││VERIFY││VERIFY│
  │STATUS││STATUS││STATUS│
  └───┬──┘└──┬──┘└─┬───┘
      │      │     │
    ◇APPROVED?  ◇APPROVED?
     ╱ ╲        ╱ ╲
    ╱   ╲      ╱   ╲
   YES   NO   YES   NO
   │     │    │     │
   │  SHOW│   │  SHOW
   │  PENDING   PENDING
   │  MSG  │   │  MSG
   │     │    │     │
   ├─────┘    └─────┤
   │                │
┌──▼────────────────┴─┐
│ REDIRECT TO         │
│ DASHBOARD/PENDING   │
│ (Rectangle)         │
└──┬─────────────────┘
   │
   └──────────────┐
                  │
            ┌─────▼──────┐
            │   END      │
            └────────────┘
```

---

### 1.2 Registration Flow

```
         ┌─────────────┐
         │    START    │
         └──────┬──────┘
                │
         ┌──────▼────────────────┐
         │ User Visits /register │
         └──────┬────────────────┘
                │
         ┌──────▼──────────────────────────┐
         │ INPUT: Personal Information     │
         │ (Parallelogram)                 │
         │ - Name, DOB, National ID        │
         │ - Gender, Civil Status          │
         │ - Occupation                    │
         └──────┬──────────────────────────┘
                │
         ┌──────▼──────────────────────────┐
         │ INPUT: Identification           │
         │ (Parallelogram)                 │
         │ - National ID Number            │
         │ - Upload ID Image               │
         └──────┬──────────────────────────┘
                │
         ┌──────▼──────────────────────────┐
         │ INPUT: Contact Information      │
         │ (Parallelogram)                 │
         │ - Email, Phone                  │
         │ - Address Details               │
         └──────┬──────────────────────────┘
                │
         ┌──────▼──────────────────────────┐
         │ INPUT: Emergency Contact        │
         │ (Parallelogram)                 │
         │ - Contact Name, Phone           │
         └──────┬──────────────────────────┘
                │
         ┌──────▼──────────────────────────┐
         │ INPUT: Security Information     │
         │ (Parallelogram)                 │
         │ - Password (min 8 chars)        │
         │ - Confirm Password              │
         └──────┬──────────────────────────┘
                │
         ┌──────▼──────────────────────────┐
         │ Click "Create Account"          │
         │ (Rectangle - Button Action)     │
         └──────┬──────────────────────────┘
                │
         ┌──────▼──────────────────────────┐
         │ VALIDATE ALL FIELDS             │
         │ (Rectangle - Process)           │
         │ - Check required fields         │
         │ - Validate email format         │
         │ - Validate National ID (16)     │
         │ - Check age ≥ 18                │
         │ - Verify no duplicate email/ID  │
         └──────┬──────────────────────────┘
                │
              ◇ VALIDATION PASSED?
             ╱ ╲
        YES ╱   ╲ NO
           ╱     ╲
          │       └──────┬──────────────────────┐
          │              │ SHOW ERROR MESSAGES  │
          │              │ (Output)             │
          │              │ (Arrow loops back)   │
          │              └──────────────────────┘
          │
    ┌─────▼──────────────────────┐
    │ HASH PASSWORD              │
    │ (Rectangle - Process)      │
    │ Using bcrypt               │
    └─────┬──────────────────────┘
          │
    ┌─────▼──────────────────────┐
    │ STORE NATIONAL ID IMAGE    │
    │ (Rectangle - Process)      │
    │ Save to: storage/public    │
    └─────┬──────────────────────┘
          │
    ┌─────▼──────────────────────┐
    │ CALCULATE AGE              │
    │ (Rectangle - Process)      │
    │ From Date of Birth         │
    └─────┬──────────────────────┘
          │
    ┌─────▼──────────────────────┐
    │ CREATE USER RECORD         │
    │ (Rectangle - Database)     │
    │ - role: 'citizen'          │
    │ - verification_status:     │
    │   'pending'                │
    └─────┬──────────────────────┘
          │
    ┌─────▼──────────────────────┐
    │ SEND VERIFICATION EMAIL    │
    │ (Rectangle - Process)      │
    │ (Optional)                 │
    └─────┬──────────────────────┘
          │
    ┌─────▼──────────────────────┐
    │ LOGIN USER AUTOMATICALLY   │
    │ (Rectangle - Process)      │
    └─────┬──────────────────────┘
          │
    ┌─────▼──────────────────────┐
    │ REDIRECT TO PENDING        │
    │ VERIFICATION PAGE          │
    │ (Rectangle - Navigation)   │
    └─────┬──────────────────────┘
          │
    ┌─────▼─────────────────────────────┐
    │ DISPLAY: Verification Pending     │
    │ Message (Output)                  │
    │ "Wait for Secretary to verify"    │
    └─────┬─────────────────────────────┘
          │
    ┌─────▼──────────┐
    │      END       │
    └────────────────┘
```

---

## 2. CITIZEN DASHBOARD FLOW

```
         ┌─────────────────────────────┐
         │ CITIZEN LOGS IN             │
         │ (Previous Login Flow)       │
         └──────┬──────────────────────┘
                │
         ┌──────▼──────────────────────┐
         │ IS VERIFICATION APPROVED?   │
         │ (Diamond - Decision)        │
         └──────┬──────────────────────┘
                │
              ◇
             ╱ ╲
        YES ╱   ╲ NO
           ╱     ╲
          │       └─┬──────────────────────┐
          │         │ SHOW: Verification  │
          │         │ Pending Page        │
          │         │ (Output)            │
          │         │ "Awaiting approval" │
          │         └─────────────────────┘
          │
    ┌─────▼─────────────────────┐
    │ LOAD CITIZEN DASHBOARD    │
    │ (Rectangle - Process)     │
    │ Load stats, complaints    │
    └─────┬─────────────────────┘
          │
    ┌─────▼─────────────────────────────────┐
    │ DISPLAY: Dashboard View (Output)      │
    │ ┌─────────────────────────────────┐  │
    │ │ - My Statistics                 │  │
    │ │   • Total Complaints Filed      │  │
    │ │   • Pending                     │  │
    │ │   • Validated                   │  │
    │ │   • In Progress                 │  │
    │ │   • Resolved                    │  │
    │ │ - Recent Complaints (Table)     │  │
    │ │ - QR Code Display               │  │
    │ │ - Quick Actions (Buttons)       │  │
    │ └─────────────────────────────────┘  │
    └─────┬─────────────────────────────────┘
          │
         ◇ USER SELECTS ACTION?
        ╱ ╲ ╲ ╲
       ╱   ╲ ╲ ╲
    1 ╱  2  ╲3 ╲4
     ╱      ╲  ╲
    
FILE    VIEW ALL    VIEW MY    SUBMIT
COMPLAINT COMPLAINTS PROFILE URGENT REQUEST
    │       │          │         │
    │       │          │         │
┌───▼──┐┌───▼──┐┌──────▼──┐┌─────▼──┐
│      ││      ││         ││        │
│ ...continued (see below)
```

### 2.1 File Complaint Sub-flow

```
         ┌──────────────────────────┐
         │ Click: File Complaint    │
         │ (Rectangle - Button)     │
         └──────┬───────────────────┘
                │
         ┌──────▼──────────────────────┐
         │ LOAD: Complaint Form        │
         │ (Rectangle - Page Load)     │
         └──────┬──────────────────────┘
                │
         ┌──────▼──────────────────────┐
         │ INPUT: Complaint Details   │
         │ (Parallelogram)            │
         │ - Category (select)         │
         │ - Subject                   │
         │ - Description (max 2000)    │
         │ - Location                  │
         └──────┬──────────────────────┘
                │
         ┌──────▼──────────────────────┐
         │ INPUT: Upload Evidence      │
         │ (Parallelogram)            │
         │ - Photos/Videos (optional)  │
         │ - Max 20MB per file         │
         │ - Supported formats:        │
         │   • Images: JPEG, PNG, JPG  │
         │   • Videos: MP4, MPEG, MOV  │
         └──────┬──────────────────────┘
                │
         ┌──────▼──────────────────────┐
         │ Click: Submit Complaint     │
         │ (Rectangle - Button)        │
         └──────┬──────────────────────┘
                │
         ┌──────▼──────────────────────┐
         │ VALIDATE FORM DATA          │
         │ (Rectangle - Process)       │
         │ - All required fields       │
         │ - File type validation      │
         │ - File size check           │
         └──────┬──────────────────────┘
                │
              ◇ VALIDATION OK?
             ╱ ╲
        YES ╱   ╲ NO
           ╱     ╘═══════════════════┐
          │                         │
    ┌─────▼──────────────────────┐  │
    │ UPLOAD EVIDENCE FILES      │  │
    │ (Rectangle - Process)      │  │
    │ Store in: /public/{id}     │  │
    │ Using Spatie Media Library │  │
    └─────┬──────────────────────┘  │
          │                         │
    ┌─────▼──────────────────────────┐ │
    │ GENERATE COMPLAINT NUMBER      │ │
    │ (Rectangle - Process)          │ │
    │ Format: CP-YYYYMMDD-XXX        │ │
    └─────┬──────────────────────────┘ │
          │                         │
    ┌─────▼──────────────────────────┐ │
    │ CREATE COMPLAINT RECORD        │ │
    │ (Rectangle - Database)         │ │
    │ - user_id: citizen ID          │ │
    │ - category_id                  │ │
    │ - subject, description         │ │
    │ - status: 'pending'            │ │
    │ - created_at: now              │ │
    └─────┬──────────────────────────┘ │
          │                         │
    ┌─────▼──────────────────────────┐ │
    │ SEND CONFIRMATION NOTIFICATION │ │
    │ (Rectangle - Process)          │ │
    │ Notify: Citizen, Secretary     │ │
    └─────┬──────────────────────────┘ │
          │                         │
    ┌─────▼──────────────────────────┐ │
    │ SHOW SUCCESS MESSAGE (Output)  │ │
    │ "Complaint submitted!"         │ │
    │ "Complaint #: CP-..."          │ │
    └─────┬──────────────────────────┘ │
          │                         │
    ┌─────▼──────────────────────────┐ │
    │ REDIRECT TO COMPLAINTS LIST    │ │
    │ (Rectangle - Navigation)       │ │
    └─────┬──────────────────────────┘ │
          │                         │
         ┌┴──────────────────────────┐
         │ Loop back to Dashboard    │
         │ or View Details          │
         └──────────────────────────┘

         SHOW ERROR & LOOP BACK ─────┘
```

### 2.2 Submit Urgent Request Sub-flow

```
         ┌──────────────────────────┐
         │ Click: Submit Urgent     │
         │ Request                  │
         │ (Rectangle - Button)     │
         └──────┬───────────────────┘
                │
         ┌──────▼──────────────────────┐
         │ LOAD: Urgent Request Form   │
         │ (Rectangle - Page Load)     │
         └──────┬──────────────────────┘
                │
         ┌──────▼──────────────────────┐
         │ INPUT: Emergency Details    │
         │ (Parallelogram)            │
         │ - Title                     │
         │ - Description               │
         │ - Location (address)        │
         │ - Category:                 │
         │   • Medical                 │
         │   • Accident                │
         │   • Fire                    │
         │   • Security                │
         │   • Disaster                │
         │   • Other                   │
         │ - Priority: High/Urgent     │
         └──────┬──────────────────────┘
                │
         ┌──────▼──────────────────────┐
         │ Click: Submit Request       │
         │ (Rectangle - Button)        │
         └──────┬──────────────────────┘
                │
         ┌──────▼──────────────────────┐
         │ VALIDATE FORM DATA          │
         │ (Rectangle - Process)       │
         │ - All required fields       │
         │ - Valid location            │
         └──────┬──────────────────────┘
                │
              ◇ VALIDATION OK?
             ╱ ╲
        YES ╱   ╲ NO (Show errors)
           ╱     ╘════════════════════┐
          │                          │
    ┌─────▼──────────────────────┐   │
    │ CREATE URGENT REQUEST      │   │
    │ (Rectangle - Database)     │   │
    │ - citizen_id: current user │   │
    │ - status: 'submitted'      │   │
    │ - submitted_at: now        │   │
    │ - priority: selected       │   │
    └─────┬──────────────────────┘   │
          │                          │
    ┌─────▼──────────────────────────┐│
    │ NOTIFY TANOD TEAM              ││
    │ (Rectangle - Process)          ││
    │ Send real-time notification    ││
    └─────┬──────────────────────────┘│
          │                          │
    ┌─────▼──────────────────────────┐│
    │ SHOW SUCCESS MESSAGE (Output)  ││
    │ "Request submitted!"           ││
    │ "Request #: UR-..."            ││
    │ "Tanods notified"              ││
    └─────┬──────────────────────────┘│
          │                          │
    ┌─────▼──────────────────────────┐│
    │ REDIRECT TO REQUEST TRACKING   ││
    │ (Rectangle - Navigation)       ││
    └─────┬──────────────────────────┘│
          │                          │
         ┌┴──────────────────────────┐
         │ Show real-time updates    │
         │ from Tanod team           │
         └──────────────────────────┘

         SHOW ERROR & LOOP BACK ─────┘
```

---

## 3. SECRETARY DASHBOARD FLOW

```
         ┌─────────────────────────────┐
         │ SECRETARY LOGS IN           │
         │ (Login Flow)                │
         └──────┬──────────────────────┘
                │
    ┌──────────────────────────────────┐
    │ LOAD SECRETARY DASHBOARD         │
    │ (Rectangle - Process)            │
    │ Load pending verifications,      │
    │ pending complaints               │
    └──────┬───────────────────────────┘
           │
    ┌──────▼───────────────────────────────┐
    │ DISPLAY: Dashboard View (Output)     │
    │ ┌──────────────────────────────┐    │
    │ │ - Statistics                 │    │
    │ │   • Pending Verifications    │    │
    │ │   • Pending Complaints       │    │
    │ │   • Validated This Month     │    │
    │ │ - Pending Users (Table)      │    │
    │ │ - Pending Complaints (Table) │    │
    │ │ - Quick Actions              │    │
    │ └──────────────────────────────┘    │
    └──────┬───────────────────────────────┘
           │
           ◇ USER SELECTS ACTION?
          ╱ ╲ ╲
         ╱   ╲ ╲
      1  ╱  2  ╲3
       ╱       ╲
    
VERIFY    VALIDATE    VIEW
CITIZENS  COMPLAINTS  PROFILE
    │        │          │
    │        │          │
    │        │          └──────[To Profile View]
    │        │
    │        └──────┬──────────────────┐
    │               │                  │
    └──────┬────────┘                  │
           │                           │
```

### 3.1 Verify Citizens Sub-flow

```
         ┌──────────────────────────┐
         │ Click: Verify Citizens   │
         │ (Rectangle - Button)     │
         └──────┬───────────────────┘
                │
         ┌──────▼──────────────────────┐
         │ LOAD: Pending Users List    │
         │ (Rectangle - Page Load)     │
         │ WHERE verification_status   │
         │ = 'pending'                 │
         └──────┬──────────────────────┘
                │
         ┌──────▼──────────────────────┐
         │ DISPLAY: User Cards         │
         │ (Output - List View)        │
         │ - Profile info              │
         │ - National ID               │
         │ - ID Image Preview          │
         │ - Buttons: Approve/Reject   │
         └──────┬──────────────────────┘
                │
         ┌──────▼──────────────────────┐
         │ Click: View User Details    │
         │ (Rectangle - Button)        │
         └──────┬──────────────────────┘
                │
         ┌──────▼──────────────────────┐
         │ DISPLAY: Full Details       │
         │ (Output)                    │
         │ - All personal info         │
         │ - Large ID image            │
         │ - Verification options      │
         └──────┬──────────────────────┘
                │
                ◇ APPROVE OR REJECT?
               ╱ ╲
          APPROVE  REJECT
              │       │
              │       └──┬─────────────────┐
              │          │ INPUT: Reason   │
              │          │ (Parallelogram) │
              │          │ (Optional note) │
              │          └──┬──────────────┘
              │             │
    ┌─────────▼──────────────▼──────────────┐
    │ UPDATE USER RECORD                     │
    │ (Rectangle - Database)                │
    │ - verification_status: 'approved'     │
    │   OR 'rejected'                       │
    │ - verified_at: timestamp              │
    └─────────┬──────────────────────────────┘
              │
    ┌─────────▼──────────────────────────────┐
    │ IF APPROVED: Generate QR Code          │
    │ (Rectangle - Process)                  │
    │ - Using QRCodeService                  │
    │ - SVG format                           │
    │ - Store in: /storage/qr-codes          │
    └─────────┬──────────────────────────────┘
              │
    ┌─────────▼──────────────────────────────┐
    │ SEND NOTIFICATION EMAIL                │
    │ (Rectangle - Process)                  │
    │ - Approved: Success message            │
    │ - Rejected: Reason for rejection       │
    └─────────┬──────────────────────────────┘
              │
    ┌─────────▼──────────────────────────────┐
    │ SHOW SUCCESS MESSAGE (Output)          │
    │ "User verification updated!"           │
    └─────────┬──────────────────────────────┘
              │
    ┌─────────▼──────────────────────────────┐
    │ REFRESH PENDING USERS LIST             │
    │ (Rectangle - Page Reload)              │
    │ Remove verified user from list         │
    └─────────┬──────────────────────────────┘
              │
             ┌┴──────────────────────────────┐
             │ Return to Pending Users      │
             │ Continue verifying others    │
             └──────────────────────────────┘
```

### 3.2 Validate Complaints Sub-flow

```
         ┌──────────────────────────┐
         │ Click: Validate          │
         │ Complaints               │
         │ (Rectangle - Button)     │
         └──────┬───────────────────┘
                │
         ┌──────▼──────────────────────┐
         │ LOAD: Pending Complaints    │
         │ (Rectangle - Page Load)     │
         │ WHERE status = 'pending'    │
         └──────┬──────────────────────┘
                │
         ┌──────▼──────────────────────┐
         │ DISPLAY: Complaint List     │
         │ (Output)                    │
         │ - Complaint number          │
         │ - Category                  │
         │ - Subject                   │
         │ - Filed by (citizen)        │
         │ - Date filed                │
         │ - Status badge              │
         │ - Action button: Review     │
         └──────┬──────────────────────┘
                │
         ┌──────▼──────────────────────┐
         │ Click: Review Complaint     │
         │ (Rectangle - Button)        │
         └──────┬──────────────────────┘
                │
         ┌──────▼──────────────────────────┐
         │ DISPLAY: Full Complaint Details │
         │ (Output)                       │
         │ - All complaint info            │
         │ - Citizen info                  │
         │ - Evidence (photos/videos)      │
         │ - Media gallery                 │
         │ - Action buttons                │
         └──────┬──────────────────────────┘
                │
                ◇ VALIDATE OR REJECT?
               ╱ ╲
          VALIDATE  REJECT
              │       │
              │       └──┬─────────────────┐
              │          │ INPUT: Notes    │
              │          │ (Parallelogram) │
              │          │ Why rejected    │
              │          └──┬──────────────┘
              │             │
    ┌─────────▼──────────────▼──────────────┐
    │ UPDATE COMPLAINT RECORD                │
    │ (Rectangle - Database)                │
    │ IF VALIDATED:                         │
    │ - status: 'validated'                 │
    │ - validated_by: secretary_id          │
    │ - validated_at: timestamp             │
    │ IF REJECTED:                          │
    │ - status: 'rejected'                  │
    │ - secretary_notes: reason             │
    └─────────┬──────────────────────────────┘
              │
    ┌─────────▼──────────────────────────────┐
    │ SEND NOTIFICATION                      │
    │ (Rectangle - Process)                  │
    │ - To: Citizen                          │
    │ - To: Captain (if validated)           │
    │ - Message: Validation status           │
    └─────────┬──────────────────────────────┘
              │
    ┌─────────▼──────────────────────────────┐
    │ SHOW SUCCESS MESSAGE (Output)          │
    │ "Complaint validation complete!"       │
    └─────────┬──────────────────────────────┘
              │
    ┌─────────▼──────────────────────────────┐
    │ REFRESH PENDING COMPLAINTS LIST        │
    │ (Rectangle - Page Reload)              │
    │ Remove validated complaint             │
    └─────────┬──────────────────────────────┘
              │
             ┌┴──────────────────────────────┐
             │ Continue validating or        │
             │ return to dashboard          │
             └──────────────────────────────┘
```

---

## 4. CAPTAIN DASHBOARD FLOW

```
         ┌─────────────────────────────┐
         │ CAPTAIN LOGS IN             │
         │ (Login Flow)                │
         └──────┬──────────────────────┘
                │
    ┌──────────────────────────────────┐
    │ LOAD CAPTAIN DASHBOARD           │
    │ (Rectangle - Process)            │
    │ Load all complaints stats,       │
    │ reports data                     │
    └──────┬───────────────────────────┘
           │
    ┌──────▼───────────────────────────────┐
    │ DISPLAY: Dashboard View (Output)     │
    │ ┌──────────────────────────────┐    │
    │ │ - Overview Statistics         │    │
    │ │   • Total Complaints          │    │
    │ │   • By Status (breakdown)     │    │
    │ │   • By Category (breakdown)   │    │
    │ │   • Resolution Rate           │    │
    │ │ - All Complaints (Table)      │    │
    │ │ - Quick Actions               │    │
    │ │ - Generate Reports            │    │
    │ └──────────────────────────────┘    │
    └──────┬───────────────────────────────┘
           │
           ◇ USER SELECTS ACTION?
          ╱ ╲ ╲ ╲
         ╱   ╲ ╲ ╲
      1  ╱  2  ╲3 ╲4
       ╱       ╲  ╲
    
MANAGE    FILTER   GENERATE  VIEW
COMPLAINTS BY STATUS REPORTS PROFILE
    │        │       │       │
```

### 4.1 Manage Complaints Sub-flow

```
         ┌──────────────────────────┐
         │ Click: Manage            │
         │ Complaints               │
         │ (Rectangle - Button)     │
         └──────┬───────────────────┘
                │
         ┌──────▼──────────────────────┐
         │ LOAD: All Complaints        │
         │ (Rectangle - Page Load)     │
         │ Filter: status != 'rejected'│
         └──────┬──────────────────────┘
                │
         ┌──────▼──────────────────────┐
         │ DISPLAY: Complaints Table   │
         │ (Output)                    │
         │ - Complaint number          │
         │ - Category                  │
         │ - Citizen                   │
         │ - Status (badge)            │
         │ - Validation date           │
         │ - Action: View/Resolve      │
         └──────┬──────────────────────┘
                │
         ┌──────▼──────────────────────┐
         │ Click: View/Resolve         │
         │ (Rectangle - Button)        │
         └──────┬──────────────────────┘
                │
         ┌──────▼──────────────────────┐
         │ DISPLAY: Complaint Details  │
         │ (Output)                    │
         │ - All info                  │
         │ - Evidence media            │
         │ - Secretary notes           │
         │ - Resolution form           │
         └──────┬──────────────────────┘
                │
         ┌──────▼──────────────────────┐
         │ Check Complaint Status      │
         │ (Rectangle - Logic)         │
         └──────┬──────────────────────┘
                │
              ◇ STATUS?
             ╱ ╲ ╲
      VALIDATED  IN_PROGRESS  RESOLVED
        │             │          │
        │             │          └─┐
        │             │            │
        │             │    ┌───────┴─────────┐
        │             │    │ SHOW: Details   │
        │             │    │ Only (Read-only)│
        │             │    │ No form         │
        │             │    └─────────────────┘
        │             │
        │    ┌────────┴──────────────────────┐
        │    │ INPUT: Status Update (if     │
        │    │ not already in_progress)    │
        │    │ (Parallelogram)             │
        │    │ Change to: in_progress      │
        │    └────────┬─────────────────────┘
        │             │
    ┌───▼─────────────▼──────────────┐
    │ INPUT: Resolution Details      │
    │ (Parallelogram)                │
    │ - Captain resolution (text)    │
    │ - Recommendation               │
    │ - Action taken                 │
    │ - Satisfied flag (yes/no)      │
    └───┬──────────────────────────────┘
        │
    ┌───▼──────────────────────────────┐
    │ Click: Mark as Resolved          │
    │ (Rectangle - Button)             │
    └───┬──────────────────────────────┘
        │
    ┌───▼──────────────────────────────┐
    │ UPDATE COMPLAINT RECORD           │
    │ (Rectangle - Database)           │
    │ - status: 'resolved'             │
    │ - resolved_by: captain_id        │
    │ - resolved_at: timestamp         │
    │ - captain_resolution: text       │
    │ - recommendation: text           │
    └───┬──────────────────────────────┘
        │
    ┌───▼──────────────────────────────┐
    │ SEND NOTIFICATION                │
    │ (Rectangle - Process)            │
    │ - To: Citizen                    │
    │ - Resolution details             │
    │ - Feedback request               │
    └───┬──────────────────────────────┘
        │
    ┌───▼──────────────────────────────┐
    │ SHOW SUCCESS MESSAGE (Output)    │
    │ "Complaint resolved!"            │
    │ "Citizen has been notified"      │
    └───┬──────────────────────────────┘
        │
    ┌───▼──────────────────────────────┐
    │ REFRESH COMPLAINTS LIST          │
    │ (Rectangle - Page Reload)        │
    └───┬──────────────────────────────┘
        │
       ┌┴──────────────────────────────┐
       │ Return to Dashboard           │
       │ or continue managing          │
       └──────────────────────────────┘
```

### 4.2 Generate Reports Sub-flow

```
         ┌──────────────────────────┐
         │ Click: Generate Reports  │
         │ (Rectangle - Button)     │
         └──────┬───────────────────┘
                │
         ┌──────▼──────────────────────┐
         │ LOAD: Report Generator      │
         │ (Rectangle - Page Load)     │
         └──────┬──────────────────────┘
                │
         ┌──────▼──────────────────────┐
         │ INPUT: Report Filters       │
         │ (Parallelogram)             │
         │ - Date range                │
         │ - Category filter           │
         │ - Status filter             │
         │ - Report type (summary/     │
         │   detailed)                 │
         └──────┬──────────────────────┘
                │
         ┌──────▼──────────────────────┐
         │ Click: Generate Report      │
         │ (Rectangle - Button)        │
         └──────┬──────────────────────┘
                │
         ┌──────▼──────────────────────┐
         │ QUERY DATABASE              │
         │ (Rectangle - Process)       │
         │ - Get complaints matching   │
         │   filters                   │
         │ - Calculate statistics      │
         │ - Generate summary data     │
         └──────┬──────────────────────┘
                │
         ┌──────▼──────────────────────┐
         │ GENERATE PDF REPORT         │
         │ (Rectangle - Process)       │
         │ Using DomPDF package        │
         │ - Header with date range    │
         │ - Statistics tables         │
         │ - Charts/graphs             │
         │ - Complaint list            │
         │ - Footer                    │
         └──────┬──────────────────────┘
                │
         ┌──────▼──────────────────────┐
         │ DOWNLOAD / DISPLAY REPORT   │
         │ (Output)                    │
         │ PDF file generated          │
         │ Option: Download or View    │
         └──────┬──────────────────────┘
                │
         ┌──────▼──────────────────────┐
         │ SHOW SUCCESS MESSAGE        │
         │ "Report generated!"         │
         │ "Downloading..."            │
         └──────┬──────────────────────┘
                │
               ┌┴──────────────────────┐
               │ Return to dashboard   │
               └──────────────────────┘
```

---

## 5. TANOD (BARANGAY POLICE) DASHBOARD FLOW

```
         ┌─────────────────────────────┐
         │ TANOD LOGS IN               │
         │ (Login Flow)                │
         └──────┬──────────────────────┘
                │
    ┌──────────────────────────────────┐
    │ LOAD TANOD DASHBOARD             │
    │ (Rectangle - Process)            │
    │ Load pending urgent requests,    │
    │ assigned requests, stats         │
    └──────┬───────────────────────────┘
           │
    ┌──────▼───────────────────────────────┐
    │ DISPLAY: Dashboard View (Output)     │
    │ ┌──────────────────────────────┐    │
    │ │ - Statistics                 │    │
    │ │   • Pending Requests (count) │    │
    │ │   • Assigned to Me           │    │
    │ │   • In Progress              │    │
    │ │   • Resolved This Month      │    │
    │ │ - Recent Requests (Table)    │    │
    │ │ - Quick Actions              │    │
    │ └──────────────────────────────┘    │
    └──────┬───────────────────────────────┘
           │
           ◇ USER SELECTS ACTION?
          ╱ ╲ ╲
         ╱   ╲ ╲
      1  ╱  2  ╲3
       ╱       ╲
    
VIEW       ACCEPT/       VIEW
PENDING    MANAGE        MY
REQUESTS   MY REQUESTS  PROFILE
    │           │          │
```

### 5.1 View Pending & Accept Requests Sub-flow

```
         ┌──────────────────────────┐
         │ Click: View Pending      │
         │ Requests                 │
         │ (Rectangle - Button)     │
         └──────┬───────────────────┘
                │
         ┌──────▼──────────────────────┐
         │ LOAD: Pending Requests List │
         │ (Rectangle - Page Load)     │
         │ WHERE status = 'submitted'  │
         │ AND tanod_id IS NULL        │
         │ ORDER BY priority DESC      │
         └──────┬──────────────────────┘
                │
         ┌──────▼──────────────────────┐
         │ DISPLAY: Requests List      │
         │ (Output)                    │
         │ - Request number            │
         │ - Citizen name              │
         │ - Emergency type (category) │
         │ - Location                  │
         │ - Priority (High/Urgent)    │
         │ - Status badge              │
         │ - Time submitted            │
         │ - Action: View/Accept       │
         └──────┬──────────────────────┘
                │
         ┌──────▼──────────────────────┐
         │ Click: View Request Details │
         │ (Rectangle - Button)        │
         └──────┬──────────────────────┘
                │
         ┌──────▼──────────────────────┐
         │ DISPLAY: Full Request Info  │
         │ (Output)                    │
         │ - Citizen contact info      │
         │ - Emergency description     │
         │ - Location details          │
         │ - Category                  │
         │ - Priority level            │
         │ - Time submitted            │
         │ - Action: Accept & Assign   │
         └──────┬──────────────────────┘
                │
         ┌──────▼──────────────────────┐
         │ Click: Accept & Assign      │
         │ (Rectangle - Button)        │
         │ "Assign to Me"              │
         └──────┬──────────────────────┘
                │
         ┌──────▼──────────────────────┐
         │ UPDATE URGENT REQUEST       │
         │ (Rectangle - Database)      │
         │ - tanod_id: current_user_id │
         │ - status: 'assigned'        │
         │ - assigned_at: timestamp    │
         └──────┬──────────────────────┘
                │
         ┌──────▼──────────────────────┐
         │ SEND NOTIFICATIONS          │
         │ (Rectangle - Process)       │
         │ - To: Citizen (assigned)    │
         │ - To: All Tanods (updated)  │
         │ - Tanod name, contact       │
         └──────┬──────────────────────┘
                │
         ┌──────▼──────────────────────┐
         │ SHOW SUCCESS MESSAGE        │
         │ (Output)                    │
         │ "Request assigned to you!"  │
         │ "Citizen has been notified" │
         └──────┬──────────────────────┘
                │
         ┌──────▼──────────────────────┐
         │ REDIRECT TO MY ASSIGNED     │
         │ REQUESTS                    │
         │ (Rectangle - Navigation)    │
         └──────┬──────────────────────┘
                │
               ┌┴──────────────────────┐
               │ Show assigned request │
               │ in assigned list      │
               └──────────────────────┘
```

### 5.2 Manage Assigned Requests Sub-flow

```
         ┌──────────────────────────┐
         │ Click: My Assigned       │
         │ Requests                 │
         │ (Rectangle - Button)     │
         └──────┬───────────────────┘
                │
         ┌──────▼──────────────────────┐
         │ LOAD: My Requests           │
         │ (Rectangle - Page Load)     │
         │ WHERE tanod_id = current_id │
         │ AND status != 'resolved'    │
         └──────┬──────────────────────┘
                │
         ┌──────▼──────────────────────┐
         │ DISPLAY: My Requests List   │
         │ (Output)                    │
         │ - Request details           │
         │ - Current status            │
         │ - Updates history           │
         │ - Action: Update Status     │
         └──────┬──────────────────────┘
                │
         ┌──────▼──────────────────────┐
         │ Click: Update Status        │
         │ (Rectangle - Button)        │
         └──────┬──────────────────────┘
                │
         ┌──────▼──────────────────────┐
         │ DISPLAY: Status Update Form │
         │ (Output)                    │
         │ - Current status            │
         │ - New status options:       │
         │   • In Progress             │
         │   • On The Way              │
         │   • Resolved                │
         │ - Message field (optional)  │
         │ - Location fields (optional)│
         │   • Latitude                │
         │   • Longitude               │
         └──────┬──────────────────────┘
                │
         ┌──────▼──────────────────────┐
         │ INPUT: Update Details       │
         │ (Parallelogram)             │
         │ - Select new status         │
         │ - Optional: Add message     │
         │ - Optional: Enter location  │
         └──────┬──────────────────────┘
                │
         ┌──────▼──────────────────────┐
         │ Click: Submit Update        │
         │ (Rectangle - Button)        │
         └──────┬──────────────────────┘
                │
         ┌──────▼──────────────────────┐
         │ CREATE UPDATE RECORD        │
         │ (Rectangle - Database)      │
         │ - UrgentRequestUpdate table │
         │ - urgent_request_id         │
         │ - tanod_id                  │
         │ - status: selected          │
         │ - message: optional         │
         │ - latitude/longitude: opt   │
         │ - created_at: timestamp     │
         └──────┬──────────────────────┘
                │
         ┌──────▼──────────────────────┐
         │ UPDATE URGENT REQUEST       │
         │ (Rectangle - Database)      │
         │ - status: new status        │
         │ - responded_at: timestamp   │
         │   (if first update)         │
         │ - resolved_at: timestamp    │
         │   (if marked resolved)      │
         └──────┬──────────────────────┘
                │
         ┌──────▼──────────────────────┐
         │ SEND REAL-TIME NOTIFICATION │
         │ (Rectangle - Process)       │
         │ - To: Citizen               │
         │ - Status update message     │
         │ - Location (if provided)    │
         │ - Using WebSocket/Pusher    │
         │   (for real-time)           │
         └──────┬──────────────────────┘
                │
         ┌──────▼──────────────────────┐
         │ SHOW SUCCESS MESSAGE        │
         │ (Output)                    │
         │ "Status updated!"           │
         │ "Citizen notified"          │
         └──────┬──────────────────────┘
                │
         ┌──────▼──────────────────────┐
         │ IF MARKED RESOLVED:         │
         │ SHOW: Complete Form         │
         │ (Output)                    │
         │ - Final notes               │
         │ - Actions taken             │
         │ - Satisfaction rating       │
         └──────┬──────────────────────┘
                │
         ┌──────▼──────────────────────┐
         │ REFRESH ASSIGNED REQUESTS   │
         │ (Rectangle - Page Reload)   │
         └──────┬──────────────────────┘
                │
               ┌┴──────────────────────┐
               │ Continue managing or  │
               │ return to dashboard   │
               └──────────────────────┘
```

---

## 6. SYSTEM-WIDE LEGEND & COLOR CODING

### Status Colors & Badges

```
╔═══════════════════════════════════════════════════════════╗
║              STATUS COLOR SCHEME                          ║
╠═══════════════════════════════════════════════════════════╣
║ COMPLAINT STATUSES:                                       ║
║  • Pending      → YELLOW    (bg-yellow-100)              ║
║  • Validated    → BLUE      (bg-blue-100)                ║
║  • In Progress  → ORANGE    (bg-orange-100)              ║
║  • Resolved     → GREEN     (bg-green-100)               ║
║  • Rejected     → RED       (bg-red-100)                 ║
║                                                          ║
║ URGENT REQUEST STATUSES:                                 ║
║  • Submitted    → YELLOW    (bg-yellow-100)              ║
║  • Assigned     → BLUE      (bg-blue-100)                ║
║  • In Progress  → ORANGE    (bg-orange-100)              ║
║  • On The Way   → PURPLE    (bg-purple-100)              ║
║  • Resolved     → GREEN     (bg-green-100)               ║
║  • Cancelled    → RED       (bg-red-100)                 ║
║                                                          ║
║ VERIFICATION STATUSES:                                   ║
║  • Pending      → YELLOW    (bg-yellow-100)              ║
║  • Approved     → GREEN     (bg-green-100)               ║
║  • Rejected     → RED       (bg-red-100)                 ║
╚═══════════════════════════════════════════════════════════╝
```

### User Role Colors

```
CITIZEN      → BLUE     (#2563EB)
SECRETARY    → PURPLE   (#7C3AED)
CAPTAIN      → RED      (#DC2626)
TANOD        → AMBER    (#D97706)
ADMIN        → SLATE    (#475569)
```

---

## 7. KEY DECISION POINTS IN SYSTEM

### All Diamond (Decision) Points Used:

1. **Login Flow**
   - Valid credentials? (YES/NO)
   - User role check (CITIZEN/SECRETARY/CAPTAIN/TANOD)
   - Verification status approved? (YES/NO)

2. **Registration Flow**
   - All validation passed? (YES/NO)

3. **Complaint Filing**
   - Form validation OK? (YES/NO)

4. **Citizen Request Submission**
   - Form validation OK? (YES/NO)

5. **Secretary Verification**
   - Approve or Reject? (APPROVE/REJECT)

6. **Secretary Complaint Validation**
   - Validate or Reject? (VALIDATE/REJECT)

7. **Captain Resolution**
   - Complaint status? (VALIDATED/IN_PROGRESS/RESOLVED)

8. **Tanod Request Management**
   - Status selection for update? (IN_PROGRESS/ON_THE_WAY/RESOLVED)

---

## 8. DATABASE OPERATIONS IN FLOWCHART

Whenever you see **(Database)** in the flowchart, it means:

```
┌─────────────────────────────────────┐
│ DATABASE OPERATION (Rectangle)      │
│ - CREATE, READ, UPDATE, DELETE      │
│ - Affected table specified          │
│ - Specific fields updated/inserted  │
└─────────────────────────────────────┘
```

**Example tables involved:**
- `users`
- `complaints`
- `urgent_requests`
- `urgent_request_updates`
- `complaint_categories`
- `media`
- `notifications`

---

## 9. QUICK REFERENCE: PROCESS FLOWS

### Simple Process = Rectangle
```
┌──────────────────┐
│ SIMPLE PROCESS   │
│ (Single action)  │
└──────────────────┘
```

### Complex Process = Multiple Rectangles
```
┌──────────────────┐
│ LOAD DATA        │
└────────┬─────────┘
         │
┌────────▼─────────┐
│ VALIDATE DATA    │
└────────┬─────────┘
         │
┌────────▼─────────┐
│ SAVE TO DATABASE │
└──────────────────┘
```

### Input/Output = Parallelogram
```
┌──────────────────────────┐
│ USER ENTERS DATA         │
│ (Form, Fields, etc.)     │
└──────────────────────────┘
```

### Decision = Diamond
```
      ◇
     ╱ ╲
    ╱   ╲
   YES  NO
   │    │
```

---

## 10. HOW TO USE THIS FLOWCHART GUIDE

### To Create Flowchart Software/Diagrams:

**Recommended Tools:**
1. **Lucidchart** - Professional flowchart tool
2. **Draw.io** - Free, web-based
3. **Miro** - Collaborative whiteboard
4. **Microsoft Visio** - Enterprise standard
5. **Figma** - Design & flowchart tool

### Steps to Create:

1. **Copy the symbols** from this guide
2. **Follow the flow logic** for each user role
3. **Use the color scheme** for status/priority
4. **Add icons** for visual appeal
5. **Export as PNG/PDF** for documentation

### What Each Section Covers:

- **Section 1**: Authentication (Login & Register)
- **Section 2**: Citizen workflows (Dashboard, File Complaint, Urgent Request)
- **Section 3**: Secretary workflows (Verify Citizens, Validate Complaints)
- **Section 4**: Captain workflows (Manage Complaints, Generate Reports)
- **Section 5**: Tanod workflows (View & Accept Requests, Manage Assignments)
- **Section 6**: Color coding & status legends
- **Section 7**: All decision points
- **Section 8**: Database operations reference
- **Section 9**: Symbol quick reference
- **Section 10**: This usage guide

---

**Last Updated:** October 29, 2025  
**System:** Barangay Complaint Analysis, Intervention, and Recommendation System  
**Version:** 1.0
