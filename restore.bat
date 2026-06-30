@echo off
setlocal

set "SCRIPT_DIR=%~dp0"
set "DB_PATH=%SCRIPT_DIR%database\database.sqlite"
set "BACKUP_FILE=%SCRIPT_DIR%database\backup\cinema_backup_20260514.sql"

if not exist "%BACKUP_FILE%" (
    echo Backup file not found: %BACKUP_FILE%
    pause
    exit /b 1
)

del "%DB_PATH%" 2>nul
sqlite3 "%DB_PATH%" < "%BACKUP_FILE%"

echo Database restored from %BACKUP_FILE%
pause