#!/usr/bin/env bash
# Backup harian SewaKampus. Portabel: sesuaikan MYSQL_BIN bila lokasi berbeda.
set -euo pipefail

MYSQL_BIN="${MYSQL_BIN:-/c/Users/ASUS/tools/mysql8/mysql-8.0.43-winx64/bin}"
DB_NAME="${DB_NAME:-sewakampus}"
DB_HOST="${DB_HOST:-127.0.0.1}"
DB_PORT="${DB_PORT:-3311}"
DB_USER="${DB_USER:-root}"
OUT_DIR="${OUT_DIR:-$HOME/sewakampus-backups}"
RETENTION_DAYS="${RETENTION_DAYS:-7}"

mkdir -p "$OUT_DIR"
STAMP="$(date +%Y%m%d-%H%M%S)"
FILE="$OUT_DIR/${DB_NAME}-${STAMP}.sql"

"$MYSQL_BIN/mysqldump" \
  --host="$DB_HOST" --port="$DB_PORT" --user="$DB_USER" \
  --single-transaction --routines --triggers --events \
  --set-gtid-purged=OFF \
  "$DB_NAME" > "$FILE"

gzip -f "$FILE"

# Hapus backup lebih tua dari masa retensi.
find "$OUT_DIR" -name "${DB_NAME}-*.sql.gz" -mtime +"$RETENTION_DAYS" -delete

ls -lh "$FILE.gz"
