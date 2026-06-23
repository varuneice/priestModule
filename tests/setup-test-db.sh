#!/usr/bin/env bash
# =============================================================================
# setup-test-db.sh
# Creates and seeds the HDBS test database.
# Run this once before executing the test suite.
#
# Usage:
#   bash tests/setup-test-db.sh
#
# Requirements:
#   - XAMPP MySQL must be running
#   - Run from the project root: priestModule/
# =============================================================================

MYSQL="/c/xampp/mysql/bin/mysql.exe"
DB_HOST="localhost"
DB_USER="root"
DB_PASS=""
DB_NAME="hdbs_test"

SCHEMA_FILE="tests/fixtures/schema.sql"
SEED_FILE="tests/fixtures/seed.sql"

echo "------------------------------------------------------------"
echo " HDBS Test Database Setup"
echo "------------------------------------------------------------"

# Check MySQL is reachable
echo "[1/4] Checking MySQL connection..."
if ! "$MYSQL" -h "$DB_HOST" -u "$DB_USER" -e "SELECT 1;" > /dev/null 2>&1; then
    echo "  ERROR: Cannot connect to MySQL at $DB_HOST."
    echo "  Please start MySQL via the XAMPP Control Panel and try again."
    exit 1
fi
echo "  OK — MySQL is reachable."

# Drop and recreate test database
echo "[2/4] Creating test database '$DB_NAME'..."
"$MYSQL" -h "$DB_HOST" -u "$DB_USER" -e "DROP DATABASE IF EXISTS \`$DB_NAME\`; CREATE DATABASE \`$DB_NAME\` CHARACTER SET utf8 COLLATE utf8_general_ci;" 2>&1
if [ $? -ne 0 ]; then
    echo "  ERROR: Failed to create database."
    exit 1
fi
echo "  OK — Database created."

# Import schema
echo "[3/4] Importing schema..."
"$MYSQL" -h "$DB_HOST" -u "$DB_USER" "$DB_NAME" < "$SCHEMA_FILE" 2>&1
if [ $? -ne 0 ]; then
    echo "  ERROR: Failed to import schema."
    exit 1
fi
echo "  OK — Schema imported."

# Import seed data
echo "[4/4] Seeding test data..."
"$MYSQL" -h "$DB_HOST" -u "$DB_USER" "$DB_NAME" < "$SEED_FILE" 2>&1
if [ $? -ne 0 ]; then
    echo "  WARNING: Seed data import had issues (some tables may not exist yet)."
else
    echo "  OK — Seed data loaded."
fi

echo "------------------------------------------------------------"
echo " Test database '$DB_NAME' is ready."
echo " Run tests with:  bash run-tests.sh"
echo "------------------------------------------------------------"
