#!/bin/bash

# Production readiness check script
echo "🔍 Checking production readiness..."

# Check if .env.prod exists
if [ ! -f ".env.prod" ]; then
    echo "❌ .env.prod file not found!"
else
    echo "✅ .env.prod file found"
fi

# Check if public/.htaccess exists
if [ ! -f "public/.htaccess" ]; then
    echo "❌ public/.htaccess file not found!"
else
    echo "✅ public/.htaccess file found"
fi

# Check if deploy.sh exists and is executable
if [ ! -x "deploy.sh" ]; then
    echo "❌ deploy.sh not found or not executable!"
else
    echo "✅ deploy.sh ready"
fi

# Check critical directories
directories=("var/cache" "var/log" "public/css" "public/js" "public/img")
for dir in "${directories[@]}"; do
    if [ ! -d "$dir" ]; then
        echo "❌ Directory $dir not found!"
    else
        echo "✅ Directory $dir exists"
    fi
done

# Check critical files
files=("src/Controller/PortfolioController.php" "templates/base.html.twig" "public/css/style.css" "public/js/script.js")
for file in "${files[@]}"; do
    if [ ! -f "$file" ]; then
        echo "❌ File $file not found!"
    else
        echo "✅ File $file exists"
    fi
done

echo ""
echo "🚀 Production readiness check completed!"
echo "If all checks passed, run ./deploy.sh to prepare for deployment."