#!/bin/bash
# Database Backup Script for Wildlife Zoo Management System
# Version: 1.0
# Usage: ./backup_db.sh [output_dir]

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

# Set output directory
OUTPUT_DIR=${1:-"./backups"}
mkdir -p "$OUTPUT_DIR"

# Generate filename with timestamp
TIMESTAMP=$(date +"%Y%m%d_%H%M%S")
BACKUP_FILE="$OUTPUT_DIR/zoo_db_backup_$TIMESTAMP.sql.gz"

# Backup command
echo "Backing up database $DB_NAME to $BACKUP_FILE..."
mysqldump -h $DB_HOST -u $DB_USER -p"$DB_PASS" $DB_NAME | gzip > $BACKUP_FILE

# Verify backup
if [ $? -eq 0 ]; then
  BACKUP_SIZE=$(du -h $BACKUP_FILE | cut -f1)
  echo "Backup completed successfully! Size: $BACKUP_SIZE"
  
  # Rotate old backups (keep last 7 days)
  find "$OUTPUT_DIR" -name "zoo_db_backup_*.sql.gz" -mtime +7 -exec rm {} \;
  echo "Rotated backups older than 7 days"
else
  echo "Backup failed!"
  exit 1
fi