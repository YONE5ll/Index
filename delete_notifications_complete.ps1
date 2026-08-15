# delete_notifications_complete.ps1
Write-Host "========================================" -ForegroundColor Cyan
Write-Host "   DELETING NOTIFICATIONS PAGE" -ForegroundColor Red
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""

# 1. Delete View Files
Write-Host "Step 1: Deleting view files..." -ForegroundColor Yellow
$viewPath = "resources\views\pages\notifications"
if (Test-Path $viewPath) {
    Remove-Item -Recurse -Force $viewPath
    Write-Host "Deleted: $viewPath" -ForegroundColor Green
} else {
    Write-Host "View not found: $viewPath" -ForegroundColor Yellow
}

# 2. Delete Controller
Write-Host ""
Write-Host "Step 2: Deleting controller..." -ForegroundColor Yellow
$controllerPath = "app\Http\Controllers\NotificationController.php"
if (Test-Path $controllerPath) {
    Remove-Item -Force $controllerPath
    Write-Host "Deleted: $controllerPath" -ForegroundColor Green
} else {
    Write-Host "Controller not found: $controllerPath" -ForegroundColor Yellow
}

# 3. Delete Model
Write-Host ""
Write-Host "Step 3: Deleting model..." -ForegroundColor Yellow
$modelPath = "app\Models\Notification.php"
if (Test-Path $modelPath) {
    Remove-Item -Force $modelPath
    Write-Host "Deleted: $modelPath" -ForegroundColor Green
} else {
    Write-Host "Model not found: $modelPath" -ForegroundColor Yellow
}

# 4. Delete Migrations
Write-Host ""
Write-Host "Step 4: Deleting migrations..." -ForegroundColor Yellow
$migrations = Get-ChildItem "database\migrations\*notifications*" -ErrorAction SilentlyContinue
if ($migrations) {
    foreach ($migration in $migrations) {
        Remove-Item -Force $migration.FullName
        Write-Host "Deleted migration: $($migration.Name)" -ForegroundColor Green
    }
} else {
    Write-Host "No migrations found" -ForegroundColor Gray
}

# 5. Remove from routes/web.php
Write-Host ""
Write-Host "Step 5: Removing routes from web.php..." -ForegroundColor Yellow

$routesFile = "routes\web.php"
$backupFile = "routes\web.php.notifications.backup"

if (Test-Path $routesFile) {
    Copy-Item $routesFile $backupFile -Force
    Write-Host "Backup created: $backupFile" -ForegroundColor Green

    $content = Get-Content $routesFile -Raw
    
    # Remove Notification routes - multiple patterns
    $patterns = @(
        "(?s)// Notifications Routes.*?Route::prefix\('notifications'\)->name\('notifications\.'\)->group\(function \(\) \{(.*?)\}\);",
        "(?s)// Notifications.*?Route::get\('/notifications'.*?\);",
        "Route::get\('/notifications'.*?\).*?;",
        "Route::post\('/notifications/{id}/read'.*?\).*?;",
        "Route::post\('/notifications/mark-all-read'.*?\).*?;",
        "Route::delete\('/notifications/{id}'.*?\).*?;",
        "Route::delete\('/notifications'.*?\).*?;",
        "Route::get\('/notifications/{id}/click'.*?\).*?;",
        "Route::get\('/notifications/unread-count'.*?\).*?;",
        "Route::get\('/notifications/recent'.*?\).*?;",
        "Route::get\('/test-notifications'.*?\).*?;"
    )
    
    foreach ($pattern in $patterns) {
        $content = $content -replace $pattern, ""
    }
    
    # Remove NotificationController imports
    $content = $content -replace "use App\\Http\\Controllers\\NotificationController;`r?`n", ""
    
    # Clean up extra blank lines
    $content = $content -replace "`r?`n`r?`n`r?`n", "`r?`n`r?`n"
    
    Set-Content -Path $routesFile -Value $content -NoNewline
    Write-Host "Routes removed from web.php" -ForegroundColor Green
} else {
    Write-Host "Routes file not found" -ForegroundColor Yellow
}

# 6. Remove from sidebar.blade.php
Write-Host ""
Write-Host "Step 6: Removing from sidebar..." -ForegroundColor Yellow

$sidebarFile = "resources\views\layouts\sidebar.blade.php"
$sidebarBackup = "resources\views\layouts\sidebar.blade.php.notifications.backup"

if (Test-Path $sidebarFile) {
    Copy-Item $sidebarFile $sidebarBackup -Force
    Write-Host "Backup created: $sidebarBackup" -ForegroundColor Green
    
    $sidebarContent = Get-Content $sidebarFile -Raw
    
    # Remove Notifications menu item - multiple patterns
    $patterns = @(
        "\[\s*'icon'\s*=>\s*'[^']*'\s*,\s*'label'\s*=>\s*'Notifications'\s*,\s*'route'\s*=>\s*'notifications\.index'\s*\]\s*,?",
        "\[\s*'icon'\s*=>\s*'[^']*'\s*,\s*'label'\s*=>\s*'Notifications'\s*,\s*'route'\s*=>\s*'notifications\..*'\s*\]\s*,?",
        "\[\s*'icon'\s*=>\s*'[^']*'\s*,\s*'label'\s*=>\s*'Alerts'\s*,\s*'route'\s*=>\s*'notifications\.index'\s*\]\s*,?"
    )
    
    foreach ($pattern in $patterns) {
        $sidebarContent = $sidebarContent -replace $pattern, ""
    }
    
    # Clean up extra commas
    $sidebarContent = $sidebarContent -replace ",(\s*)\]", "]"
    $sidebarContent = $sidebarContent -replace ",(\s*)$", ""
    
    Set-Content -Path $sidebarFile -Value $sidebarContent -NoNewline
    Write-Host "Sidebar menu item removed" -ForegroundColor Green
} else {
    Write-Host "Sidebar file not found" -ForegroundColor Yellow
}

# 7. Remove from navbar if exists
Write-Host ""
Write-Host "Step 7: Removing from navbar..." -ForegroundColor Yellow

$navbarFile = "resources\views\components\navigation\navbar.blade.php"
if (Test-Path $navbarFile) {
    $navbarBackup = "resources\views\components\navigation\navbar.blade.php.notifications.backup"
    Copy-Item $navbarFile $navbarBackup -Force
    Write-Host "Navbar backup created: $navbarBackup" -ForegroundColor Green
    
    $navbarContent = Get-Content $navbarFile -Raw
    $navbarContent = $navbarContent -replace "notifications", ""
    $navbarContent = $navbarContent -replace "Notifications", ""
    $navbarContent = $navbarContent -replace "Alerts", ""
    $navbarContent = $navbarContent -replace "notification-badge", ""
    
    Set-Content -Path $navbarFile -Value $navbarContent -NoNewline
    Write-Host "Navbar updated" -ForegroundColor Green
}

# 8. Clear Cache
Write-Host ""
Write-Host "Step 8: Clearing cache..." -ForegroundColor Yellow
php artisan route:clear
php artisan view:clear
php artisan cache:clear
php artisan config:clear
php artisan optimize:clear
Write-Host "Cache cleared" -ForegroundColor Green

# 9. Drop database tables
Write-Host ""
Write-Host "Step 9: Dropping database tables..." -ForegroundColor Yellow

$tables = @(
    "notifications",
    "user_notifications"
)

$dropped = 0
foreach ($table in $tables) {
    try {
        $checkTable = php artisan tinker --execute="Schema::hasTable('$table')" 2>$null
        if ($checkTable -match "true") {
            php artisan tinker --execute="DB::statement('SET FOREIGN_KEY_CHECKS=0'); Schema::dropIfExists('$table'); DB::statement('SET FOREIGN_KEY_CHECKS=1');" 2>$null
            Write-Host "Dropped table: $table" -ForegroundColor Green
            $dropped++
        }
    } catch {
        # Table doesn't exist, skip
    }
}

if ($dropped -eq 0) {
    Write-Host "No notifications tables found to drop" -ForegroundColor Gray
}

# 10. Summary
Write-Host ""
Write-Host "========================================" -ForegroundColor Cyan
Write-Host "NOTIFICATIONS PAGE COMPLETELY DELETED!" -ForegroundColor Green
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""
Write-Host "Deleted Items:" -ForegroundColor Yellow
Write-Host "- View: resources/views/pages/notifications" -ForegroundColor White
Write-Host "- Controller: app/Http/Controllers/NotificationController.php" -ForegroundColor White
Write-Host "- Model: app/Models/Notification.php" -ForegroundColor White
Write-Host "- Migrations: All notification related migrations" -ForegroundColor White
Write-Host "- Routes: Removed from routes/web.php" -ForegroundColor White
Write-Host "- Sidebar: Removed from sidebar.blade.php" -ForegroundColor White
Write-Host "- Navbar: Cleaned up" -ForegroundColor White
Write-Host "- Database Tables: Dropped if existed" -ForegroundColor White
Write-Host ""
Write-Host "Backups created:" -ForegroundColor Yellow
Write-Host "- routes/web.php.notifications.backup" -ForegroundColor White
Write-Host "- resources/views/layouts/sidebar.blade.php.notifications.backup" -ForegroundColor White
Write-Host "- resources/views/components/navigation/navbar.blade.php.notifications.backup" -ForegroundColor White
Write-Host ""
Write-Host "To restore backups, run:" -ForegroundColor Yellow
Write-Host "Copy-Item routes/web.php.notifications.backup routes/web.php -Force" -ForegroundColor White
Write-Host "Copy-Item resources/views/layouts/sidebar.blade.php.notifications.backup resources/views/layouts/sidebar.blade.php -Force" -ForegroundColor White
Write-Host "Copy-Item resources/views/components/navigation/navbar.blade.php.notifications.backup resources/views/components/navigation/navbar.blade.php -Force" -ForegroundColor White
Write-Host ""
Write-Host "========================================" -ForegroundColor Cyan