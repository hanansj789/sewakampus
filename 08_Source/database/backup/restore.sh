#!/usr/bin/env bash
# Restore backup SewaKampus ke database tujuan.
# Pemakaian: ./restore.sh <berkas.sql.gz> <nama_database_tujuan>
set -euo pipefail

MYSQL_BIN="${MYSQL_BIN:-/c/Users/ASUS/tools/mysql8/mysql-8.0.43-winx64/bin}"
DB_HOST="${DB_HOST:-127.0.0.1}"
DB_PORT="${DB_PORT:-3311}"
DB_USER="${DB_USER:-root}"

if [ "$#" -ne 2 ]; then
  echo "Pemakaian: $0 <berkas.sql.gz> <nama_database_tujuan>" >&2
  exit 1
fi

FILE="$1"
TARGET="$2"

if [ ! -f "$FILE" ]; then
  echo "Berkas tidak ditemukan: $FILE" >&2
  exit 1
fi

"$MYSQL_BIN/mysql" --host="$DB_HOST" --port="$DB_PORT" --user="$DB_USER" \
  -e "DROP DATABASE IF EXISTS \`$TARGET\`; CREATE DATABASE \`$TARGET\` CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;"

gunzip -c "$FILE" | "$MYSQL_BIN/mysql" --host="$DB_HOST" --port="$DB_PORT" --user="$DB_USER" "$TARGET"

"$MYSQL_BIN/mysql" --host="$DB_HOST" --port="$DB_PORT" --user="$DB_USER" -e \
  "SELECT table_name, table_rows FROM information_schema.tables WHERE table_schema='$TARGET' AND table_type='BASE TABLE' ORDER BY table_name;"
