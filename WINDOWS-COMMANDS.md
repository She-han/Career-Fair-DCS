# Windows PowerShell Commands Guide for Laravel Sail

## � Admin Login Credentials

**Email:** `admin@careerfair.com`  
**Password:** `admin123`

After successful login, admin users are automatically redirected to `/admin/dashboard`.

---

## �🔴 PROBLEM: `./vendor/bin/sail` Commands Don't Work on Windows PowerShell

### Why It Doesn't Work:
- `./` is Unix/Linux/Mac syntax
- Windows PowerShell uses `.\` (backslash)
- Laravel Sail provides a `sail.bat` file for Windows

## ✅ SOLUTION: 3 Ways to Run Sail Commands on Windows

### Method 1: Use sail.bat (RECOMMENDED)
```powershell
# Instead of: ./vendor/bin/sail artisan migrate
# Use:
.\sail.bat artisan migrate

# Examples:
.\sail.bat artisan config:clear
.\sail.bat artisan view:clear
.\sail.bat artisan route:clear
.\sail.bat artisan optimize
.\sail.bat composer install
.\sail.bat npm run build
```

### Method 2: Use Docker Exec Directly (FASTEST)
```powershell
# Artisan commands
docker exec career-fair-dcs-laravel.test-1 php artisan config:clear
docker exec career-fair-dcs-laravel.test-1 php artisan view:clear
docker exec career-fair-dcs-laravel.test-1 php artisan migrate
docker exec career-fair-dcs-laravel.test-1 php artisan db:seed

# Composer commands
docker exec career-fair-dcs-laravel.test-1 composer dump-autoload

# Check PHP version
docker exec career-fair-dcs-laravel.test-1 php -v
```

### Method 3: Use PowerShell Alias (CONVENIENT)
```powershell
# Add this to your PowerShell profile for permanent use
Set-Alias sail '.\sail.bat'

# Then you can use:
sail artisan migrate
sail artisan cache:clear
sail up -d
sail down
```

To add permanently:
```powershell
# Open PowerShell profile
notepad $PROFILE

# Add this line:
function sail { & ".\sail.bat" @args }

# Save and reload:
. $PROFILE
```

## 🚀 Complete Fix Process for Your Project

### Step 1: Clear All Caches
```powershell
docker exec career-fair-dcs-laravel.test-1 php artisan config:clear
docker exec career-fair-dcs-laravel.test-1 php artisan view:clear
docker exec career-fair-dcs-laravel.test-1 php artisan route:clear
docker exec career-fair-dcs-laravel.test-1 php artisan cache:clear
```

### Step 2: Rebuild Frontend Assets
```powershell
npm run build
```

### Step 3: Restart Laravel Container
```powershell
docker compose restart laravel.test
```

### Step 4: Verify Changes
```powershell
# Wait 5 seconds then check
Start-Sleep -Seconds 5

# Test homepage
Invoke-WebRequest -Uri 'http://localhost' -UseBasicParsing | Select-Object StatusCode

# Check if container is running
docker ps --filter name=laravel.test
```

## 🔧 Quick Reference: Command Conversions

| Unix/Linux Command | Windows PowerShell Command |
|-------------------|---------------------------|
| `./vendor/bin/sail up` | `.\sail.bat up` or `docker compose up -d` |
| `./vendor/bin/sail down` | `.\sail.bat down` or `docker compose down` |
| `./vendor/bin/sail artisan migrate` | `docker exec career-fair-dcs-laravel.test-1 php artisan migrate` |
| `./vendor/bin/sail composer install` | `docker exec career-fair-dcs-laravel.test-1 composer install` |
| `./vendor/bin/sail npm run dev` | `npm run dev` |
| `./vendor/bin/sail artisan tinker` | `docker exec -it career-fair-dcs-laravel.test-1 php artisan tinker` |

## 📦 Common Commands You'll Need

### Laravel Artisan Commands
```powershell
# Clear caches
docker exec career-fair-dcs-laravel.test-1 php artisan optimize:clear

# Run migrations
docker exec career-fair-dcs-laravel.test-1 php artisan migrate

# Seed database
docker exec career-fair-dcs-laravel.test-1 php artisan db:seed

# Create new migration
docker exec career-fair-dcs-laravel.test-1 php artisan make:migration create_table_name

# Create new controller
docker exec career-fair-dcs-laravel.test-1 php artisan make:controller ControllerName

# List routes
docker exec career-fair-dcs-laravel.test-1 php artisan route:list

# Storage link
docker exec career-fair-dcs-laravel.test-1 php artisan storage:link
```

### Docker Container Management
```powershell
# Start all containers
docker compose up -d

# Stop all containers
docker compose down

# Restart specific container
docker compose restart laravel.test

# View logs
docker logs career-fair-dcs-laravel.test-1 --tail 50
docker logs career-fair-dcs-laravel.test-1 -f  # Follow logs

# Check container status
docker ps
docker ps -a  # Include stopped containers

# Access container shell
docker exec -it career-fair-dcs-laravel.test-1 bash

# Check container resource usage
docker stats career-fair-dcs-laravel.test-1
```

### Frontend Development
```powershell
# Build for production
npm run build

# Development with hot reload
npm run dev

# Install packages
npm install

# Update packages
npm update
```

## 🐛 Troubleshooting

### Issue: Theme Toggle Not Working

**Fix:**
```powershell
# 1. Clear all caches
docker exec career-fair-dcs-laravel.test-1 php artisan optimize:clear

# 2. Rebuild assets
npm run build

# 3. Hard refresh browser (Ctrl + Shift + R)
# 4. Clear browser cache
```

### Issue: Changes Not Showing

**Fix:**
```powershell
# 1. Clear Laravel caches
docker exec career-fair-dcs-laravel.test-1 php artisan config:clear
docker exec career-fair-dcs-laravel.test-1 php artisan view:clear
docker exec career-fair-dcs-laravel.test-1 php artisan route:clear

# 2. Rebuild frontend
npm run build

# 3. Restart container
docker compose restart laravel.test

# 4. Wait and test
Start-Sleep -Seconds 5
Invoke-WebRequest -Uri 'http://localhost' -UseBasicParsing
```

### Issue: Database Connection Error

**Fix:**
```powershell
# Check if MySQL is running
docker ps --filter name=mysql

# Check MySQL logs
docker logs career-fair-dcs-mysql-1 --tail 50

# Restart MySQL
docker compose restart mysql

# Recreate containers if needed
docker compose down
docker compose up -d
```

### Issue: Assets Not Loading (404 Errors)

**Fix:**
```powershell
# 1. Check if build folder exists
Test-Path ".\public\build"

# 2. Rebuild assets
npm run build

# 3. Check manifest
Get-Content ".\public\build\manifest.json"

# 4. Clear browser cache (Ctrl + Shift + R)
```

## 💡 Pro Tips

### Create a PowerShell Helper Script
Create a file `dev.ps1` in your project root:
```powershell
# dev.ps1
param (
    [Parameter(Mandatory=$true)]
    [string]$Command
)

switch ($Command) {
    "up" { docker compose up -d }
    "down" { docker compose down }
    "restart" { docker compose restart laravel.test }
    "clear" {
        docker exec career-fair-dcs-laravel.test-1 php artisan optimize:clear
        Write-Host "Caches cleared!" -ForegroundColor Green
    }
    "fresh" {
        docker exec career-fair-dcs-laravel.test-1 php artisan migrate:fresh --seed
        Write-Host "Database refreshed!" -ForegroundColor Green
    }
    "build" {
        npm run build
        Write-Host "Assets built!" -ForegroundColor Green
    }
    "logs" {
        docker logs career-fair-dcs-laravel.test-1 -f
    }
    default {
        Write-Host "Unknown command. Available: up, down, restart, clear, fresh, build, logs" -ForegroundColor Red
    }
}
```

Usage:
```powershell
.\dev.ps1 up
.\dev.ps1 clear
.\dev.ps1 build
```

### Quick Commands Cheatsheet
Save this as `COMMANDS.md` in your project:

```markdown
# Quick Commands

## Start/Stop
docker compose up -d                 # Start all containers
docker compose down                  # Stop all containers
docker compose restart laravel.test  # Restart Laravel

## Clear Everything
docker exec career-fair-dcs-laravel.test-1 php artisan optimize:clear
npm run build

## Database
docker exec career-fair-dcs-laravel.test-1 php artisan migrate
docker exec career-fair-dcs-laravel.test-1 php artisan db:seed
docker exec career-fair-dcs-laravel.test-1 php artisan migrate:fresh --seed

## Logs
docker logs career-fair-dcs-laravel.test-1 --tail 50
docker logs career-fair-dcs-laravel.test-1 -f

## Access Container
docker exec -it career-fair-dcs-laravel.test-1 bash
```

## 🎯 Current Issue Fix Commands

Run these commands in order to fix your current issues:

```powershell
# 1. Clear everything
docker exec career-fair-dcs-laravel.test-1 php artisan optimize:clear

# 2. Rebuild assets
npm run build

# 3. Restart container
docker compose restart laravel.test

# 4. Wait for container to start
Start-Sleep -Seconds 7

# 5. Test
$response = Invoke-WebRequest -Uri 'http://localhost' -UseBasicParsing
Write-Host "Status: $($response.StatusCode)"
```

## 📚 Additional Resources

- [Laravel Sail Documentation](https://laravel.com/docs/sail)
- [Docker Documentation](https://docs.docker.com/)
- [PowerShell Documentation](https://docs.microsoft.com/en-us/powershell/)

---

**Remember:** Always use `docker exec` or `.\sail.bat` instead of `./vendor/bin/sail` on Windows!
