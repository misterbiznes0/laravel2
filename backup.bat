@echo off
setlocal

REM Используем sqlite3.exe из папки проекта
set "SQLITE3=%~dp0sqlite3.exe"

if not exist "%SQLITE3%" (
    echo sqlite3.exe not found in project folder!
    echo Please download sqlite3.exe and place it here.
    pause
    exit /b 1
)

set "SCRIPT_DIR=%~dp0"
set "DB_PATH=%SCRIPT_DIR%database\database.sqlite"
set "BACKUP_DIR=%SCRIPT_DIR%database\backup"
set "DATE=%DATE:~6,4%%DATE:~3,2%%DATE:~0,2%"
set "BACKUP_FILE=%BACKUP_DIR%\cinema_backup_%DATE%.sql"

if not exist "%BACKUP_DIR%" mkdir "%BACKUP_DIR%"

"%SQLITE3%" "%DB_PATH%" .dump > "%BACKUP_FILE%"

if %errorlevel% equ 0 (
    echo Backup saved to %BACKUP_FILE%
) else (
    echo Backup failed!
)

pause