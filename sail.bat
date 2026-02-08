@echo off
setlocal enabledelayedexpansion

set SCRIPT_DIR=%~dp0
set SAIL_SCRIPT=%SCRIPT_DIR%vendor\bin\sail

REM Change to project directory first
cd /d "%SCRIPT_DIR%"

REM Execute sail with Git Bash
"C:\Program Files\Git\bin\bash.exe" -c "./vendor/bin/sail %*"
