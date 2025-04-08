#!/bin/bash
# Database Restore Script for Wildlife Zoo Management System
# Version: 1.0
# Usage: ./restore_db.sh [backup_file.sql.gz]

# Load database configuration
DB_CONFIG="./../config/database.php"
if [ ! -f "$DB_CONFIG" ]; then
  echo "Error: Database configuration file not found!"
  exit 1
fi

# Extract database credentials
DB_HOST=$(grep "'db_host'" $DB_CONFIG | cut -d"'" -f4)
DB_NAME=$(grep "'db_name'" $DB_CONFIG | cut -d"'" -f4)
DB_USER=$(grep "'db_user'" $DB_CONFIG | cut -d"'" -f4)
DB_PASS=$(grep "'db_pass'" $DB_CONFIG | cut -d"'" -f4)

# Check if backup file was provided
if [ -z "$1" ]; then
  echo "Usage: $0 [backup_file.sql.gz]"
  echo "Available backups:"
  ls -lh ./backups/zoo_db_backup_*.sql.gz 2>/dev/null || echo "No backups found in ./backups"
  exit 1
fi

BACKUP_FILE=$1

# Verify backup file exists
if [ ! -f "$BACKUP_FILE" ]; then
  echo "Error: Backup file not found!"
  exit 1
fi

# Confirmation prompt
read -p "WARNING: This will overwrite the $DB_NAME database. Continue? [y/N] " confirm
if [[ ! $confirm =~ ^[Yy]$ ]]; then
  echo "Restore cancelled"
  exit 0
fi

# Restore process
echo "Restoring database from $BACKUP_FILE..."

# Check if uncompressed restore is needed
if [[ $BACKUP_FILE == *.gz ]]; then
  gunzip -c "$BACKUP_FILE" | mysql -h $DB_HOST -u $DB_USER -p"$DB_PASS" $DB_NAME
else
  mysql -h $DB_HOST -u $DB_USER -p"$DB_PASS" $DB_NAME < "$BACKUP_FILE"
fi

# Verify restore
if [ $? -eq 0 ]; then
  echo "Database restored successfully!"
  
  # Get table count for verification
  TABLE_COUNT=$(mysql -h $DB_HOST -u $DB_USER -p"$DB_PASS" $DB_NAME -sNe "SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = '$DB_NAME';")
  echo "Database contains $TABLE_COUNT tables"
else
  echo "Restore failed!"
  exit 1
fi