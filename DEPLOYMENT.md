# Deployment Instructions for O2Switch

## 🚀 Production Deployment Steps

### 1. Prepare the Project for Production

Run the deployment script to prepare your project:

```bash
./deploy.sh
```

This script will:
- Clear all caches
- Install production dependencies
- Warm up the cache
- Set proper permissions

### 2. Configure Production Environment

1. **Copy the production environment file:**
   ```bash
   cp .env.prod .env
   ```

2. **Update the .env file with:**
   - Generate a new `APP_SECRET` (32 random characters)
   - Configure database if needed in the future
   - Verify email settings

### 3. Upload Files to O2Switch

Upload these files/directories to your O2Switch hosting:

```
symfony-portfolio/
├── bin/
├── config/
├── public/              # ← This should be your document root
├── src/
├── templates/
├── translations/
├── var/
├── vendor/
├── .env                 # ← Your production environment file
├── composer.json
├── composer.lock
└── symfony.lock
```

### 4. Configure Domain and Directory

In your O2Switch control panel:
1. Point `portfolio.cameleonne.fr` to the `/public` directory
2. The document root should be: `/path/to/symfony-portfolio/public`

### 5. Email Configuration

The project is configured to use:
- **Sender:** `no-reply@cameleonne.fr`
- **Recipient:** `contact@cameleonne.fr`
- **SMTP:** O2Switch's default SMTP settings

If you need to customize email settings, update the `MAILER_DSN` in your `.env` file:

```env
# For O2Switch SMTP (adjust as needed)
MAILER_DSN=smtp://username:password@mail.cameleonne.fr:587?encryption=tls
```

### 6. File Permissions

Ensure these directories have proper permissions:
```bash
chmod -R 755 var/cache var/log
chmod -R 644 .env
```

### 7. Test the Deployment

1. Visit `https://portfolio.cameleonne.fr`
2. Test all pages:
   - Homepage (/)
   - Contact form (/contact)
   - Project pages (/projet/*)
3. Test contact form functionality

## 📧 Email Configuration Details

### Default Configuration
- **From:** `no-reply@cameleonne.fr`
- **Reply-To:** User's email address
- **To:** `contact@cameleonne.fr`
- **Subject:** "Nouveau message depuis le portfolio - [Name]"

### O2Switch Email Settings
O2Switch typically provides:
- **SMTP Server:** `mail.cameleonne.fr` or `localhost`
- **Port:** 587 (TLS) or 465 (SSL)
- **Authentication:** Required

## 🔒 Security Considerations

1. **Environment Variables:** Never commit `.env` files with production secrets
2. **APP_SECRET:** Use a unique, random 32-character string for production
3. **File Permissions:** Ensure proper permissions on var/ directories
4. **HTTPS:** O2Switch should provide SSL certificates

## 🛠️ Troubleshooting

### Common Issues:

1. **500 Error:**
   - Check `var/log/prod.log` for errors
   - Verify file permissions
   - Ensure `.env` is properly configured

2. **Email Not Sending:**
   - Verify SMTP settings in `.env`
   - Check that `no-reply@cameleonne.fr` is configured in your O2Switch email
   - Test with a simple SMTP client

3. **Assets Not Loading:**
   - Verify document root points to `/public`
   - Check `.htaccess` file is uploaded
   - Clear browser cache

### Debug Commands:
```bash
# Check configuration
php bin/console debug:config

# Check routes
php bin/console debug:router

# Clear cache
php bin/console cache:clear --env=prod

# Check logs
tail -f var/log/prod.log
```

## 📝 Post-Deployment Checklist

- [ ] Domain points to `/public` directory
- [ ] All pages load correctly
- [ ] Contact form submits successfully
- [ ] Emails are received at `contact@cameleonne.fr`
- [ ] Mobile responsiveness works
- [ ] All images and assets load
- [ ] Navigation works properly
- [ ] SSL certificate is active

## 🔄 Updates and Maintenance

To update the site:
1. Make changes locally
2. Run `./deploy.sh`
3. Upload changed files to O2Switch
4. Clear cache if needed: `php bin/console cache:clear --env=prod`

---

**Note:** This deployment guide is specifically tailored for O2Switch hosting with the domain `portfolio.cameleonne.fr`.