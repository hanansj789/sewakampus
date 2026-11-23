-- SewaKampus — skema awal MySQL 8.0
-- Status: Draf. Diturunkan dari 02_Data/P13-Data-Dictionary.md dan bukti 3NF.
-- PR14-04. Belum dijalankan di database kosong.

SET NAMES utf8mb4;
SET time_zone = '+07:00';

CREATE DATABASE IF NOT EXISTS sewakampus
  CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE sewakampus;

-- 1. users
CREATE TABLE users (
  id             BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  public_id      CHAR(26)        NOT NULL,
  full_name      VARCHAR(100)    NOT NULL,
  email          VARCHAR(150)    NOT NULL,
  password_hash  VARCHAR(255)    NOT NULL,
  phone          VARCHAR(20)     NULL,
  role           VARCHAR(20)     NOT NULL DEFAULT 'STUDENT',
  account_status VARCHAR(20)     NOT NULL DEFAULT 'PENDING_VERIFICATION',
  created_at     DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at     DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  deleted_at     DATETIME        NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uq_users_public_id (public_id),
  UNIQUE KEY uq_users_email (email),
  CONSTRAINT ck_users_role CHECK (role IN ('STUDENT','ADMIN')),
  CONSTRAINT ck_users_status CHECK (account_status IN ('PENDING_VERIFICATION','ACTIVE','SUSPENDED'))
) ENGINE=InnoDB;

-- 2. student_verifications
CREATE TABLE student_verifications (
  id               BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  public_id        CHAR(26)        NOT NULL,
  user_id          BIGINT UNSIGNED NOT NULL,
  nim              VARCHAR(20)     NOT NULL,
  name_on_card     VARCHAR(100)    NOT NULL,
  study_program    VARCHAR(100)    NOT NULL,
  faculty          VARCHAR(100)    NULL,
  ktm_file_path    VARCHAR(500)    NOT NULL,
  ktm_file_hash    CHAR(64)        NULL,
  status           VARCHAR(20)     NOT NULL DEFAULT 'PENDING',
  reviewed_by      BIGINT UNSIGNED NULL,
  rejection_reason VARCHAR(500)    NULL,
  created_at       DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP,
  reviewed_at      DATETIME        NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uq_verifications_public_id (public_id),
  KEY ix_verifications_user (user_id),
  KEY ix_verifications_status (status),
  CONSTRAINT fk_verifications_user FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE,
  CONSTRAINT fk_verifications_reviewer FOREIGN KEY (reviewed_by) REFERENCES users (id) ON DELETE SET NULL,
  CONSTRAINT ck_verifications_status CHECK (status IN ('PENDING','APPROVED','REJECTED'))
) ENGINE=InnoDB;

-- 3. item_categories
CREATE TABLE item_categories (
  id         BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  public_id  CHAR(26)        NOT NULL,
  name       VARCHAR(80)     NOT NULL,
  slug       VARCHAR(80)     NOT NULL,
  is_active  BOOLEAN         NOT NULL DEFAULT TRUE,
  sort_order INT             NOT NULL DEFAULT 0,
  created_at DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY uq_categories_public_id (public_id),
  UNIQUE KEY uq_categories_name (name),
  UNIQUE KEY uq_categories_slug (slug)
) ENGINE=InnoDB;

-- 4. items
CREATE TABLE items (
  id             BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  public_id      CHAR(26)        NOT NULL,
  owner_id       BIGINT UNSIGNED NOT NULL,
  category_id    BIGINT UNSIGNED NOT NULL,
  title          VARCHAR(120)    NOT NULL,
  description    TEXT            NOT NULL,
  `condition`    VARCHAR(20)     NOT NULL,
  daily_rate     DECIMAL(12,2)   NOT NULL,
  deposit_amount DECIMAL(12,2)   NOT NULL,
  pickup_point   VARCHAR(120)    NOT NULL,
  status         VARCHAR(20)     NOT NULL DEFAULT 'DRAFT',
  average_rating DECIMAL(3,2)    NOT NULL DEFAULT 0.00,
  review_count   INT UNSIGNED    NOT NULL DEFAULT 0,
  created_at     DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at     DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  deleted_at     DATETIME        NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uq_items_public_id (public_id),
  KEY ix_items_owner (owner_id),
  KEY ix_items_category_status (category_id, status),
  CONSTRAINT fk_items_owner FOREIGN KEY (owner_id) REFERENCES users (id) ON DELETE RESTRICT,
  CONSTRAINT fk_items_category FOREIGN KEY (category_id) REFERENCES item_categories (id) ON DELETE RESTRICT,
  CONSTRAINT ck_items_condition CHECK (`condition` IN ('NEW','GOOD','FAIR')),
  CONSTRAINT ck_items_status CHECK (status IN ('DRAFT','ACTIVE','PAUSED','ARCHIVED')),
  CONSTRAINT ck_items_rate CHECK (daily_rate >= 0),
  CONSTRAINT ck_items_deposit CHECK (deposit_amount >= 0),
  CONSTRAINT ck_items_rating CHECK (average_rating BETWEEN 0 AND 5)
) ENGINE=InnoDB;

-- 5. item_photos
CREATE TABLE item_photos (
  id         BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  item_id    BIGINT UNSIGNED NOT NULL,
  file_path  VARCHAR(500)    NOT NULL,
  alt_text   VARCHAR(150)    NULL,
  sort_order INT             NOT NULL DEFAULT 0,
  is_primary BOOLEAN         NOT NULL DEFAULT FALSE,
  created_at DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY uq_photos_item_sort (item_id, sort_order),
  CONSTRAINT fk_photos_item FOREIGN KEY (item_id) REFERENCES items (id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- 6. item_availabilities
CREATE TABLE item_availabilities (
  id         BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  item_id    BIGINT UNSIGNED NOT NULL,
  start_date DATE            NOT NULL,
  end_date   DATE            NOT NULL,
  status     VARCHAR(20)     NOT NULL DEFAULT 'AVAILABLE',
  note       VARCHAR(255)    NULL,
  created_at DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  KEY ix_availability_item_range (item_id, start_date, end_date),
  CONSTRAINT fk_availability_item FOREIGN KEY (item_id) REFERENCES items (id) ON DELETE CASCADE,
  CONSTRAINT ck_availability_status CHECK (status IN ('AVAILABLE','BLOCKED')),
  CONSTRAINT ck_availability_range CHECK (end_date >= start_date)
) ENGINE=InnoDB;

-- 7. bookings
CREATE TABLE bookings (
  id                    BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  public_id             CHAR(26)        NOT NULL,
  item_id               BIGINT UNSIGNED NOT NULL,
  renter_id             BIGINT UNSIGNED NOT NULL,
  owner_id              BIGINT UNSIGNED NOT NULL,
  start_date            DATE            NOT NULL,
  end_date              DATE            NOT NULL,
  daily_rate_snapshot   DECIMAL(12,2)   NOT NULL,
  subtotal              DECIMAL(12,2)   NOT NULL,
  deposit_snapshot      DECIMAL(12,2)   NOT NULL,
  total_amount          DECIMAL(12,2)   NOT NULL,
  status                VARCHAR(20)     NOT NULL DEFAULT 'PENDING',
  pickup_point          VARCHAR(120)    NOT NULL,
  renter_note           VARCHAR(500)    NULL,
  owner_note            VARCHAR(500)    NULL,
  approved_at           DATETIME        NULL,
  cancelled_at          DATETIME        NULL,
  cancellation_reason   VARCHAR(500)    NULL,
  created_at            DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at            DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY uq_bookings_public_id (public_id),
  KEY ix_bookings_item_status (item_id, status),
  KEY ix_bookings_renter (renter_id),
  KEY ix_bookings_owner (owner_id),
  CONSTRAINT fk_bookings_item FOREIGN KEY (item_id) REFERENCES items (id) ON DELETE RESTRICT,
  CONSTRAINT fk_bookings_renter FOREIGN KEY (renter_id) REFERENCES users (id) ON DELETE RESTRICT,
  CONSTRAINT fk_bookings_owner FOREIGN KEY (owner_id) REFERENCES users (id) ON DELETE RESTRICT,
  CONSTRAINT ck_bookings_status CHECK (status IN ('PENDING','APPROVED','REJECTED','CANCELLED','HANDED_OVER','RETURNED','COMPLETED','DISPUTED')),
  CONSTRAINT ck_bookings_range CHECK (end_date >= start_date),
  CONSTRAINT ck_bookings_amounts CHECK (daily_rate_snapshot >= 0 AND subtotal >= 0 AND deposit_snapshot >= 0 AND total_amount >= 0),
  CONSTRAINT ck_bookings_parties CHECK (renter_id <> owner_id)
) ENGINE=InnoDB;

-- 8. booking_status_histories
CREATE TABLE booking_status_histories (
  id          BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  booking_id  BIGINT UNSIGNED NOT NULL,
  from_status VARCHAR(20)     NOT NULL,
  to_status   VARCHAR(20)     NOT NULL,
  changed_by  BIGINT UNSIGNED NULL,
  reason      VARCHAR(500)    NULL,
  created_at  DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  KEY ix_history_booking (booking_id, created_at),
  CONSTRAINT fk_history_booking FOREIGN KEY (booking_id) REFERENCES bookings (id) ON DELETE CASCADE,
  CONSTRAINT fk_history_user FOREIGN KEY (changed_by) REFERENCES users (id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- 9. deposits
CREATE TABLE deposits (
  id               BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  public_id        CHAR(26)        NOT NULL,
  booking_id       BIGINT UNSIGNED NOT NULL,
  amount           DECIMAL(12,2)   NOT NULL,
  status           VARCHAR(20)     NOT NULL DEFAULT 'PENDING',
  method           VARCHAR(20)     NOT NULL DEFAULT 'SIMULATED',
  paid_at          DATETIME        NULL,
  refunded_at      DATETIME        NULL,
  forfeited_amount DECIMAL(12,2)   NOT NULL DEFAULT 0.00,
  created_at       DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY uq_deposits_public_id (public_id),
  UNIQUE KEY uq_deposits_booking (booking_id),
  CONSTRAINT fk_deposits_booking FOREIGN KEY (booking_id) REFERENCES bookings (id) ON DELETE CASCADE,
  CONSTRAINT ck_deposits_status CHECK (status IN ('PENDING','PAID_SIMULATED','HELD','REFUNDED','FORFEITED')),
  CONSTRAINT ck_deposits_method CHECK (method IN ('SIMULATED')),
  CONSTRAINT ck_deposits_amount CHECK (amount >= 0 AND forfeited_amount >= 0 AND forfeited_amount <= amount)
) ENGINE=InnoDB;

-- 10. handovers
CREATE TABLE handovers (
  id                 BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  public_id          CHAR(26)        NOT NULL,
  booking_id         BIGINT UNSIGNED NOT NULL,
  direction          VARCHAR(10)     NOT NULL,
  location           VARCHAR(120)    NOT NULL,
  condition_notes    TEXT            NULL,
  photo_path         VARCHAR(500)    NOT NULL,
  renter_confirmed_at DATETIME       NULL,
  owner_confirmed_at  DATETIME       NULL,
  created_at         DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY uq_handovers_public_id (public_id),
  UNIQUE KEY uq_handovers_booking_direction (booking_id, direction),
  CONSTRAINT fk_handovers_booking FOREIGN KEY (booking_id) REFERENCES bookings (id) ON DELETE CASCADE,
  CONSTRAINT ck_handovers_direction CHECK (direction IN ('OUT','RETURN'))
) ENGINE=InnoDB;

-- 11. reviews
CREATE TABLE reviews (
  id            BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  public_id     CHAR(26)        NOT NULL,
  booking_id    BIGINT UNSIGNED NOT NULL,
  reviewer_id   BIGINT UNSIGNED NOT NULL,
  reviewee_id   BIGINT UNSIGNED NOT NULL,
  reviewer_role VARCHAR(10)     NOT NULL,
  rating        TINYINT UNSIGNED NOT NULL,
  comment       VARCHAR(1000)   NULL,
  status        VARCHAR(20)     NOT NULL DEFAULT 'PUBLISHED',
  created_at    DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY uq_reviews_public_id (public_id),
  UNIQUE KEY uq_reviews_booking_role (booking_id, reviewer_role),
  KEY ix_reviews_reviewee (reviewee_id, status),
  CONSTRAINT fk_reviews_booking FOREIGN KEY (booking_id) REFERENCES bookings (id) ON DELETE CASCADE,
  CONSTRAINT fk_reviews_reviewer FOREIGN KEY (reviewer_id) REFERENCES users (id) ON DELETE RESTRICT,
  CONSTRAINT fk_reviews_reviewee FOREIGN KEY (reviewee_id) REFERENCES users (id) ON DELETE RESTRICT,
  CONSTRAINT ck_reviews_role CHECK (reviewer_role IN ('RENTER','OWNER')),
  CONSTRAINT ck_reviews_rating CHECK (rating BETWEEN 1 AND 5),
  CONSTRAINT ck_reviews_status CHECK (status IN ('PUBLISHED','HIDDEN')),
  CONSTRAINT ck_reviews_parties CHECK (reviewer_id <> reviewee_id)
) ENGINE=InnoDB;

-- 12. disputes
CREATE TABLE disputes (
  id              BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  public_id       CHAR(26)        NOT NULL,
  booking_id      BIGINT UNSIGNED NOT NULL,
  opened_by       BIGINT UNSIGNED NOT NULL,
  against_user_id BIGINT UNSIGNED NULL,
  category        VARCHAR(30)     NOT NULL,
  description     TEXT            NOT NULL,
  evidence_path   VARCHAR(500)    NULL,
  status          VARCHAR(20)     NOT NULL DEFAULT 'OPEN',
  resolution      VARCHAR(500)    NULL,
  resolved_by     BIGINT UNSIGNED NULL,
  resolved_at     DATETIME        NULL,
  created_at      DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY uq_disputes_public_id (public_id),
  KEY ix_disputes_booking (booking_id),
  KEY ix_disputes_status (status),
  CONSTRAINT fk_disputes_booking FOREIGN KEY (booking_id) REFERENCES bookings (id) ON DELETE RESTRICT,
  CONSTRAINT fk_disputes_opener FOREIGN KEY (opened_by) REFERENCES users (id) ON DELETE RESTRICT,
  CONSTRAINT fk_disputes_against FOREIGN KEY (against_user_id) REFERENCES users (id) ON DELETE SET NULL,
  CONSTRAINT fk_disputes_resolver FOREIGN KEY (resolved_by) REFERENCES users (id) ON DELETE SET NULL,
  CONSTRAINT ck_disputes_category CHECK (category IN ('DAMAGE','LATE_RETURN','NOT_AS_DESCRIBED','NO_SHOW','OTHER')),
  CONSTRAINT ck_disputes_status CHECK (status IN ('OPEN','IN_REVIEW','RESOLVED','REJECTED'))
) ENGINE=InnoDB;

-- 13. notifications
CREATE TABLE notifications (
  id                BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  public_id         CHAR(26)        NOT NULL,
  user_id           BIGINT UNSIGNED NOT NULL,
  type              VARCHAR(40)     NOT NULL,
  title             VARCHAR(120)    NOT NULL,
  body              VARCHAR(500)    NOT NULL,
  channel           VARCHAR(20)     NOT NULL DEFAULT 'IN_APP',
  status            VARCHAR(20)     NOT NULL DEFAULT 'QUEUED',
  entity_type       VARCHAR(30)     NULL,
  entity_public_id  CHAR(26)        NULL,
  read_at           DATETIME        NULL,
  created_at        DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY uq_notifications_public_id (public_id),
  KEY ix_notifications_user (user_id, status, created_at),
  CONSTRAINT fk_notifications_user FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE,
  CONSTRAINT ck_notifications_channel CHECK (channel IN ('IN_APP','EMAIL')),
  CONSTRAINT ck_notifications_status CHECK (status IN ('QUEUED','SENT','FAILED','READ'))
) ENGINE=InnoDB;

-- 14. audit_logs
CREATE TABLE audit_logs (
  id          BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  actor_id    BIGINT UNSIGNED NULL,
  action      VARCHAR(60)     NOT NULL,
  entity_type VARCHAR(40)     NOT NULL,
  entity_id   BIGINT UNSIGNED NULL,
  metadata    JSON            NULL,
  created_at  DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  KEY ix_audit_entity (entity_type, entity_id),
  KEY ix_audit_actor (actor_id, created_at),
  CONSTRAINT fk_audit_actor FOREIGN KEY (actor_id) REFERENCES users (id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- Nilai rating kanonik. Cache di items dihitung ulang dari view ini.
CREATE OR REPLACE VIEW v_item_rating AS
SELECT i.id AS item_id,
       COALESCE(ROUND(AVG(r.rating), 2), 0.00) AS average_rating,
       COUNT(r.id) AS review_count
FROM items i
LEFT JOIN bookings b ON b.item_id = i.id
LEFT JOIN reviews r ON r.booking_id = b.id AND r.status = 'PUBLISHED'
GROUP BY i.id;
