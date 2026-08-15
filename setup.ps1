Write-Host "Fixing dependencies..." -ForegroundColor Yellow

# Clean
if (Test-Path node_modules) {
    Remove-Item -Recurse -Force node_modules
}
if (Test-Path package-lock.json) {
    Remove-Item -Force package-lock.json
}

# Install
Write-Host "Installing dependencies..." -ForegroundColor Yellow
npm install

# Install specific packages
Write-Host "Installing axios..." -ForegroundColor Yellow
npm install axios

Write-Host "Installing Alpine.js..." -ForegroundColor Yellow
npm install alpinejs @alpinejs/persist

# Build
Write-Host "Building assets..." -ForegroundColor Yellow
npm run build

Write-Host "Done!" -ForegroundColor Green