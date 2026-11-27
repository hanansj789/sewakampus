-- SewaKampus — prosedur dan view untuk proses kritis
-- Status: Ada. Dijalankan pada MySQL 8.0.43, database sewakampus.
-- Dipakai sebagai jaring pengaman di level database ketika status booking berubah.

USE sewakampus;

DROP PROCEDURE IF EXISTS sp_transition_booking;

DELIMITER $$

CREATE PROCEDURE sp_transition_booking(
    IN p_booking_id BIGINT UNSIGNED,
    IN p_from_status VARCHAR(20),
    IN p_to_status VARCHAR(20),
    IN p_actor_id BIGINT UNSIGNED,
    IN p_reason VARCHAR(500)
)
BEGIN
    DECLARE v_status VARCHAR(20) DEFAULT NULL;

    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        RESIGNAL;
    END;

    START TRANSACTION;

    SELECT status INTO v_status
    FROM bookings
    WHERE id = p_booking_id
    FOR UPDATE;

    IF v_status IS NULL THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Booking tidak ditemukan';
    END IF;

    IF v_status <> p_from_status THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Status booking tidak sesuai';
    END IF;

    IF NOT (
        (p_from_status = 'PENDING' AND p_to_status IN ('APPROVED', 'REJECTED', 'CANCELLED'))
        OR (p_from_status = 'APPROVED' AND p_to_status IN ('HANDED_OVER', 'CANCELLED'))
        OR (p_from_status = 'HANDED_OVER' AND p_to_status IN ('RETURNED', 'DISPUTED'))
        OR (p_from_status = 'RETURNED' AND p_to_status IN ('COMPLETED', 'DISPUTED'))
    ) THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Transisi status tidak diizinkan';
    END IF;

    UPDATE bookings
    SET status = p_to_status,
        approved_at = IF(p_to_status = 'APPROVED', NOW(), approved_at),
        cancelled_at = IF(p_to_status = 'CANCELLED', NOW(), cancelled_at)
    WHERE id = p_booking_id;

    INSERT INTO booking_status_histories
        (booking_id, from_status, to_status, changed_by, reason, created_at)
    VALUES
        (p_booking_id, p_from_status, p_to_status, p_actor_id, p_reason, NOW());

    COMMIT;
END$$

DELIMITER ;

CREATE OR REPLACE VIEW v_booking_status_summary AS
SELECT status,
       COUNT(*) AS total,
       ROUND(AVG(total_amount), 2) AS rata_rata_total
FROM bookings
GROUP BY status;
