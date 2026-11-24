-- SewaKampus — verifikasi skema dan seed
-- Status: Ada. Dijalankan pada MySQL 8.0.43, 24 November 2026.
-- Pemakaian: mysql -h 127.0.0.1 -P 3311 -u root sewakampus < 002_verify.sql

SET NAMES utf8mb4;

SELECT 'tables' AS check_name,
       CASE WHEN COUNT(*) = 14 THEN 'PASS' ELSE 'FAIL' END AS result,
       CONCAT('found=', COUNT(*), ' expected=14') AS detail
FROM information_schema.tables
WHERE table_schema = DATABASE() AND table_type = 'BASE TABLE'

UNION ALL

SELECT 'views',
       CASE WHEN COUNT(*) = 1 THEN 'PASS' ELSE 'FAIL' END,
       CONCAT('found=', COUNT(*), ' expected=1')
FROM information_schema.views
WHERE table_schema = DATABASE()

UNION ALL

SELECT 'users_min_30',
       CASE WHEN COUNT(*) >= 30 THEN 'PASS' ELSE 'FAIL' END,
       CONCAT('count=', COUNT(*))
FROM users

UNION ALL

SELECT 'items_min_30',
       CASE WHEN COUNT(*) >= 30 THEN 'PASS' ELSE 'FAIL' END,
       CONCAT('count=', COUNT(*))
FROM items

UNION ALL

SELECT 'categories_min_8',
       CASE WHEN COUNT(*) >= 8 THEN 'PASS' ELSE 'FAIL' END,
       CONCAT('count=', COUNT(*))
FROM item_categories

UNION ALL

SELECT 'bookings_min_10',
       CASE WHEN COUNT(*) >= 10 THEN 'PASS' ELSE 'FAIL' END,
       CONCAT('count=', COUNT(*))
FROM bookings

UNION ALL

SELECT 'status_history_min_20',
       CASE WHEN COUNT(*) >= 20 THEN 'PASS' ELSE 'FAIL' END,
       CONCAT('count=', COUNT(*))
FROM booking_status_histories

UNION ALL

SELECT 'orphan_booking_item',
       CASE WHEN COUNT(*) = 0 THEN 'PASS' ELSE 'FAIL' END,
       CONCAT('orphans=', COUNT(*))
FROM bookings b
LEFT JOIN items i ON i.id = b.item_id
WHERE i.id IS NULL

UNION ALL

SELECT 'orphan_booking_user',
       CASE WHEN COUNT(*) = 0 THEN 'PASS' ELSE 'FAIL' END,
       CONCAT('orphans=', COUNT(*))
FROM bookings b
LEFT JOIN users r ON r.id = b.renter_id
LEFT JOIN users o ON o.id = b.owner_id
WHERE r.id IS NULL OR o.id IS NULL

UNION ALL

SELECT 'self_rental',
       CASE WHEN COUNT(*) = 0 THEN 'PASS' ELSE 'FAIL' END,
       CONCAT('rows=', COUNT(*))
FROM bookings
WHERE renter_id = owner_id

UNION ALL

SELECT 'duplicate_handover_direction',
       CASE WHEN COUNT(*) = 0 THEN 'PASS' ELSE 'FAIL' END,
       CONCAT('rows=', COUNT(*))
FROM (
    SELECT booking_id, direction, COUNT(*) AS n
    FROM handovers
    GROUP BY booking_id, direction
    HAVING n > 1
) d

UNION ALL

SELECT 'invalid_booking_status',
       CASE WHEN COUNT(*) = 0 THEN 'PASS' ELSE 'FAIL' END,
       CONCAT('rows=', COUNT(*))
FROM bookings
WHERE status NOT IN ('PENDING','APPROVED','REJECTED','CANCELLED','HANDED_OVER','RETURNED','COMPLETED','DISPUTED')

UNION ALL

SELECT 'rating_view_covers_items',
       CASE WHEN COUNT(*) = (SELECT COUNT(*) FROM items) THEN 'PASS' ELSE 'FAIL' END,
       CONCAT('view_rows=', COUNT(*), ' items=', (SELECT COUNT(*) FROM items))
FROM v_item_rating

UNION ALL

SELECT 'rating_view_no_null',
       CASE WHEN COUNT(*) = 0 THEN 'PASS' ELSE 'FAIL' END,
       CONCAT('null_rows=', COUNT(*))
FROM v_item_rating
WHERE average_rating IS NULL OR review_count IS NULL

UNION ALL

SELECT 'rating_view_range',
       CASE WHEN COUNT(*) = 0 THEN 'PASS' ELSE 'FAIL' END,
       CONCAT('bad_rows=', COUNT(*))
FROM v_item_rating
WHERE average_rating < 0 OR average_rating > 5

UNION ALL

SELECT 'unreviewed_item_zero',
       CASE WHEN COUNT(*) = 0 THEN 'PASS' ELSE 'FAIL' END,
       CONCAT('bad_rows=', COUNT(*))
FROM v_item_rating
WHERE review_count = 0 AND average_rating <> 0.00;
