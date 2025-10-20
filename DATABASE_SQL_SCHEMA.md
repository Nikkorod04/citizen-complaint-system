# Database Schema - SQL Reference

## Complete SQL Schema

```sql
-- ============================================================================
-- USERS TABLE - Core user information with demographics and verification
-- ============================================================================
CREATE TABLE users (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    
    -- Name fields (separated)
    first_name VARCHAR(255) NOT NULL,
    middle_name VARCHAR(255) NULLABLE,
    last_name VARCHAR(255) NOT NULL,
    suffix VARCHAR(255) NULLABLE,
    
    -- Authentication
    email VARCHAR(255) NOT NULL UNIQUE,
    email_verified_at TIMESTAMP NULLABLE,
    password VARCHAR(255) NOT NULL,
    remember_token VARCHAR(100) NULLABLE,
    
    -- Role-based access
    role ENUM('citizen', 'secretary', 'captain') DEFAULT 'citizen' NOT NULL,
    
    -- Identification
    national_id VARCHAR(255) NOT NULL UNIQUE,
    national_id_image VARCHAR(255) NULLABLE,
    
    -- Demographics
    date_of_birth DATE NULLABLE,
    age INT NULLABLE,
    gender ENUM('male', 'female', 'other') NULLABLE,
    civil_status ENUM('single', 'married', 'widowed', 'separated', 'divorced') NULLABLE,
    occupation VARCHAR(255) NULLABLE,
    
    -- Address breakdown
    house_number VARCHAR(255) NULLABLE,
    street VARCHAR(255) NULLABLE,
    barangay VARCHAR(255) NULLABLE,
    city VARCHAR(255) NULLABLE,
    province VARCHAR(255) NULLABLE,
    zip_code VARCHAR(255) NULLABLE,
    
    -- Contact information
    phone VARCHAR(255) NULLABLE,
    emergency_contact_name VARCHAR(255) NULLABLE,
    emergency_contact_number VARCHAR(255) NULLABLE,
    
    -- QR Code & Verification
    qr_code VARCHAR(255) NULLABLE,
    verification_status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending' NOT NULL,
    verified_at TIMESTAMP NULLABLE,
    
    -- Timestamps
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    -- Indexes
    INDEX idx_email (email),
    INDEX idx_national_id (national_id),
    INDEX idx_role (role),
    INDEX idx_verification_status (verification_status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- COMPLAINT_CATEGORIES TABLE - Categories for complaints with related laws
-- ============================================================================
CREATE TABLE complaint_categories (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    description TEXT NULLABLE,
    republic_act VARCHAR(255) NULLABLE,
    is_active BOOLEAN DEFAULT TRUE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    -- Indexes
    INDEX idx_is_active (is_active)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- COMPLAINTS TABLE - Core complaint data with status tracking
-- ============================================================================
CREATE TABLE complaints (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    complaint_number VARCHAR(255) NOT NULL UNIQUE,
    
    -- Foreign Keys
    user_id BIGINT UNSIGNED NOT NULL,
    complaint_category_id BIGINT UNSIGNED NOT NULL,
    
    -- Complaint Details
    subject VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    location VARCHAR(255) NULLABLE,
    
    -- Status Management
    status ENUM('pending', 'validated', 'in_progress', 'resolved', 'rejected') 
           DEFAULT 'pending' NOT NULL,
    
    -- Notes & Resolution
    secretary_notes TEXT NULLABLE,
    captain_resolution TEXT NULLABLE,
    recommendation TEXT NULLABLE,
    
    -- Processing Tracking
    validated_by BIGINT UNSIGNED NULLABLE,
    validated_at TIMESTAMP NULLABLE,
    resolved_by BIGINT UNSIGNED NULLABLE,
    resolved_at TIMESTAMP NULLABLE,
    
    -- Timestamps
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    -- Foreign Keys
    CONSTRAINT fk_complaints_user_id 
        FOREIGN KEY (user_id) 
        REFERENCES users(id) ON DELETE CASCADE,
    
    CONSTRAINT fk_complaints_category_id 
        FOREIGN KEY (complaint_category_id) 
        REFERENCES complaint_categories(id) ON DELETE CASCADE,
    
    CONSTRAINT fk_complaints_validated_by 
        FOREIGN KEY (validated_by) 
        REFERENCES users(id) ON DELETE SET NULL,
    
    CONSTRAINT fk_complaints_resolved_by 
        FOREIGN KEY (resolved_by) 
        REFERENCES users(id) ON DELETE SET NULL,
    
    -- Indexes
    INDEX idx_complaint_number (complaint_number),
    INDEX idx_user_id (user_id),
    INDEX idx_category_id (complaint_category_id),
    INDEX idx_status (status),
    INDEX idx_created_at (created_at),
    INDEX idx_user_status (user_id, status),
    INDEX idx_validated_by (validated_by),
    INDEX idx_resolved_by (resolved_by)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- MEDIA TABLE - Evidence files (photos/videos) - Spatie Media Library
-- ============================================================================
CREATE TABLE media (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    
    -- Polymorphic relationship
    model_type VARCHAR(255) NOT NULL,
    model_id BIGINT UNSIGNED NOT NULL,
    
    -- Media identification
    uuid VARCHAR(36) NULLABLE UNIQUE,
    collection_name VARCHAR(255) NOT NULL,
    name VARCHAR(255) NOT NULL,
    file_name VARCHAR(255) NOT NULL,
    
    -- File properties
    mime_type VARCHAR(255) NOT NULL,
    disk VARCHAR(255) NOT NULL,
    conversions_disk VARCHAR(255) NULLABLE,
    size BIGINT UNSIGNED NOT NULL,
    
    -- Additional data
    manipulations JSON NULLABLE,
    custom_properties JSON NULLABLE,
    responsive_images JSON NULLABLE,
    
    -- Ordering
    order_column INT UNSIGNED NOT NULL,
    
    -- Timestamps
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    -- Indexes
    INDEX idx_model (model_type, model_id),
    INDEX idx_uuid (uuid),
    INDEX idx_collection (collection_name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- NOTIFICATIONS TABLE - Laravel Notifications (Polymorphic)
-- ============================================================================
CREATE TABLE notifications (
    id CHAR(36) PRIMARY KEY,
    type VARCHAR(255) NOT NULL,
    
    -- Polymorphic relationship
    notifiable_type VARCHAR(255) NOT NULL,
    notifiable_id BIGINT UNSIGNED NOT NULL,
    
    -- Notification data
    data LONGTEXT NOT NULL,
    read_at TIMESTAMP NULLABLE,
    
    -- Timestamps
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    -- Indexes
    INDEX idx_notifiable (notifiable_type, notifiable_id),
    INDEX idx_read_at (read_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- PASSWORD_RESET_TOKENS TABLE - Password reset functionality
-- ============================================================================
CREATE TABLE password_reset_tokens (
    email VARCHAR(255) PRIMARY KEY,
    token VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NULLABLE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- SESSIONS TABLE - Session management
-- ============================================================================
CREATE TABLE sessions (
    id VARCHAR(255) PRIMARY KEY,
    user_id BIGINT UNSIGNED NULLABLE,
    ip_address VARCHAR(45) NULLABLE,
    user_agent TEXT NULLABLE,
    payload LONGTEXT NOT NULL,
    last_activity INT NOT NULL,
    
    -- Indexes
    INDEX idx_user_id (user_id),
    INDEX idx_last_activity (last_activity)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- CACHE TABLE - Cache storage
-- ============================================================================
CREATE TABLE cache (
    `key` VARCHAR(255) PRIMARY KEY,
    value MEDIUMTEXT NOT NULL,
    expiration INT NOT NULL,
    
    -- Indexes
    INDEX idx_expiration (expiration)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- JOBS TABLE - Job queue for background tasks
-- ============================================================================
CREATE TABLE jobs (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    queue VARCHAR(255) NOT NULL,
    payload LONGTEXT NOT NULL,
    attempts TINYINT UNSIGNED NOT NULL,
    reserved_at INT UNSIGNED NULLABLE,
    available_at INT UNSIGNED NOT NULL,
    created_at INT UNSIGNED NOT NULL,
    
    -- Indexes
    INDEX idx_queue (queue),
    INDEX idx_available_at (available_at),
    INDEX idx_reserved_at (reserved_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

---

## Key Constraints Summary

```sql
-- Primary Keys (Auto-increment)
ALTER TABLE users AUTO_INCREMENT=1000;
ALTER TABLE complaints AUTO_INCREMENT=1000;
ALTER TABLE complaint_categories AUTO_INCREMENT=100;
ALTER TABLE media AUTO_INCREMENT=1000;

-- Unique Constraints
CREATE UNIQUE INDEX uk_users_email ON users(email);
CREATE UNIQUE INDEX uk_users_national_id ON users(national_id);
CREATE UNIQUE INDEX uk_complaints_number ON complaints(complaint_number);
CREATE UNIQUE INDEX uk_media_uuid ON media(uuid);

-- Cascade Behavior
-- ON DELETE CASCADE: User → All their complaints deleted
-- ON DELETE SET NULL: Secretary/Captain reference kept as NULL if user deleted
```

---

## View Examples (for queries)

```sql
-- View: All pending complaints with citizen info
CREATE VIEW v_pending_complaints AS
SELECT 
    c.id,
    c.complaint_number,
    c.subject,
    u.first_name,
    u.last_name,
    u.email,
    cat.name AS category,
    c.created_at
FROM complaints c
JOIN users u ON c.user_id = u.id
JOIN complaint_categories cat ON c.complaint_category_id = cat.id
WHERE c.status = 'pending'
ORDER BY c.created_at DESC;

-- View: Complaint processing timeline
CREATE VIEW v_complaint_timeline AS
SELECT 
    c.id,
    c.complaint_number,
    c.status,
    c.created_at AS filed_at,
    c.validated_at,
    sv.first_name AS validated_by,
    c.resolved_at,
    sc.first_name AS resolved_by
FROM complaints c
LEFT JOIN users sv ON c.validated_by = sv.id
LEFT JOIN users sc ON c.resolved_by = sc.id
ORDER BY c.created_at DESC;

-- View: Users pending verification
CREATE VIEW v_pending_users AS
SELECT 
    u.id,
    CONCAT(u.first_name, ' ', u.last_name) AS full_name,
    u.email,
    u.national_id,
    u.national_id_image,
    u.created_at
FROM users u
WHERE u.role = 'citizen' 
  AND u.verification_status = 'pending'
ORDER BY u.created_at ASC;
```

---

## Query Examples

```sql
-- Get all complaints for a citizen (user_id = 3)
SELECT * FROM complaints 
WHERE user_id = 3 
ORDER BY created_at DESC;

-- Get validated complaints ready for captain review
SELECT * FROM complaints 
WHERE status = 'validated' 
ORDER BY validated_at ASC;

-- Get complaint count by status
SELECT status, COUNT(*) as count 
FROM complaints 
GROUP BY status;

-- Get complaint count by category
SELECT cat.name, COUNT(c.id) as count
FROM complaints c
JOIN complaint_categories cat ON c.complaint_category_id = cat.id
GROUP BY cat.id, cat.name;

-- Get average resolution time
SELECT 
    AVG(DATEDIFF(resolved_at, created_at)) as avg_days,
    MIN(DATEDIFF(resolved_at, created_at)) as min_days,
    MAX(DATEDIFF(resolved_at, created_at)) as max_days
FROM complaints
WHERE resolved_at IS NOT NULL;

-- Get top complainants
SELECT 
    u.id,
    CONCAT(u.first_name, ' ', u.last_name) as name,
    COUNT(c.id) as complaint_count
FROM users u
LEFT JOIN complaints c ON u.id = c.user_id
WHERE u.role = 'citizen'
GROUP BY u.id
ORDER BY complaint_count DESC
LIMIT 10;

-- Get unresolved complaints by citizen
SELECT 
    u.id,
    CONCAT(u.first_name, ' ', u.last_name) as name,
    u.phone,
    COUNT(c.id) as unresolved_count
FROM users u
JOIN complaints c ON u.id = c.user_id
WHERE c.status IN ('pending', 'validated', 'in_progress')
GROUP BY u.id
ORDER BY unresolved_count DESC;
```

---

## Performance Optimization

### Recommended Indexes (already created)
```sql
-- Frequently used in WHERE clauses
INDEX idx_users_role (role)
INDEX idx_users_verification_status (verification_status)
INDEX idx_complaints_status (status)
INDEX idx_complaints_created_at (created_at)
INDEX idx_complaints_user_status (user_id, status)

-- Foreign key joins
INDEX idx_complaints_user_id (user_id)
INDEX idx_complaints_category_id (complaint_category_id)
INDEX idx_complaints_validated_by (validated_by)
INDEX idx_complaints_resolved_by (resolved_by)

-- Unique lookups
INDEX idx_users_email (email)
INDEX idx_users_national_id (national_id)
INDEX idx_complaints_number (complaint_number)

-- Polymorphic queries
INDEX idx_media_model (model_type, model_id)
INDEX idx_notifications_notifiable (notifiable_type, notifiable_id)
```

### Query Optimization Tips
1. **Use indexes on foreign keys** - Already done
2. **Select specific columns** - Don't use SELECT *
3. **Use EXPLAIN** - Analyze slow queries
4. **Paginate results** - Limit to 10-50 records per page
5. **Cache complex queries** - Use Redis for frequently accessed data
6. **Archive old data** - Consider archiving complaints older than 2 years

