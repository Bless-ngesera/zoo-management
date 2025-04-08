# Wildlife Zoo Management System Maintenance Guide

## System Overview
The Wildlife Zoo Management System consists of:
- PHP web application
- MySQL database
- File storage (uploads, logs, cache)

## Daily Maintenance Tasks

### 1. Database Backups
```bash
# Run automated backup
./scripts/backup_db.sh /backup/storage

# Verify last backup
ls -lh /backup/storage/zoo_db_backup_*.sql.gz | head -n 1
```

### 2. Error Log Review
```bash
# Check PHP errors
tail -n 100 logs/php_errors.log

# Check application logs
tail -n 100 logs/application.log
```

### 3. System Health Check
```bash
# Disk space
df -h

# Memory usage
free -m

# Running processes
htop
```

## Weekly Maintenance Tasks

### 1. Database Optimization
```sql
-- Check table status
CHECK TABLE users;
CHECK TABLE animals;
CHECK TABLE tickets;

-- Optimize tables
OPTIMIZE TABLE users;
OPTIMIZE TABLE animals;
OPTIMIZE TABLE tickets;
```

### 2. Log Rotation
```bash
# Compress and archive logs
find logs/ -name "*.log" -mtime +7 -exec gzip {} \;

# Remove old logs (keep 30 days)
find logs/ -name "*.log.gz" -mtime +30 -delete
```

### 3. Security Updates
```bash
# Update system packages
sudo apt update && sudo apt upgrade -y

# Update PHP dependencies
composer update --no-dev
```

## Monthly Maintenance

### 1. Full System Backup
1. Stop application services
2. Backup database: `./scripts/backup_db.sh /backup/monthly`
3. Backup application files: `tar -czvf /backup/monthly/app_$(date +%Y%m).tar.gz .`
4. Restart services

### 2. User Account Review
```sql
-- List inactive users
SELECT * FROM users WHERE status = 'inactive' OR last_login < DATE_SUB(NOW(), INTERVAL 90 DAY);
```

### 3. Performance Tuning
```bash
# Analyze slow queries
mysqldumpslow -s t /var/log/mysql/mysql-slow.log

# Check index usage
mysql -e "SHOW INDEX FROM animals;"
```

## Emergency Procedures

### Database Recovery
1. Identify affected tables
2. Restore from backup:
```bash
./scripts/restore_db.sh /backup/storage/zoo_db_backup_20230620.sql.gz
```
3. Verify data integrity
4. Notify affected users if needed

### Application Outage
1. Check error logs
2. Verify database connection
3. Restart web server:
```bash
sudo systemctl restart apache2
```
4. Monitor recovery

## Monitoring Checklist

| Check                | Frequency | Command                      |
|----------------------|-----------|------------------------------|
| Disk Space           | Daily     | `df -h`                      |
| Memory Usage         | Daily     | `free -m`                    |
| Database Connections | Weekly    | `SHOW STATUS LIKE 'Threads%'`|
| Backup Integrity     | Weekly    | `gunzip -t backupfile.gz`     |
| Security Patches     | Monthly   | `apt list --upgradable`       |

## Contact Information

**Technical Support**: 
- Email: support@wildlifezoo.com 
- Phone: +91 1800 123 4567 (24/7)

**Critical Issues**:
- Emergency Pager: +91 98765 43210
- On-call Engineer: engineer@wildlifezoo.com