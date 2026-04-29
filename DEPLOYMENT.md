# Platoon HTML Server - Deployment Guide

A production-ready PHP web application for uploading and serving HTML files.

## Features
- ✅ Upload HTML files via web interface
- ✅ View and manage uploaded files
- ✅ RESTful API for file operations
- ✅ Responsive design
- ✅ Security measures (file validation, rate limiting)
- ✅ Docker support for easy deployment

## Requirements
- PHP 7.4+ (8.2 recommended)
- Apache web server with mod_rewrite enabled
- 10MB+ storage for uploaded files

## Local Setup

### Option 1: Direct PHP Server
```bash
# Run built-in PHP server
php -S localhost:8000

# Access at http://localhost:8000
```

### Option 2: Docker
```bash
# Build and run with Docker Compose
docker-compose up -d

# Access at http://localhost
```

### Option 3: Traditional Apache
```bash
# Copy files to Apache root
cp -r . /var/www/html/platoon

# Enable mod_rewrite
a2enmod rewrite

# Restart Apache
systemctl restart apache2
```

## Deployment to Production

### Option 1: Linux VPS/Server
```bash
# SSH into your server
ssh user@your-server.com

# Clone or upload files
git clone https://github.com/yourusername/platoon-html.git /var/www/platoon
cd /var/www/platoon

# Set permissions
sudo chown -R www-data:www-data .
sudo chmod 755 uploads

# Enable on Apache
sudo a2enmod rewrite
sudo systemctl restart apache2
```

### Option 2: Docker on Production
```bash
# Build custom image
docker build -t platoon-html:latest .

# Run container
docker run -d \
  --name platoon \
  -p 80:80 \
  -p 443:443 \
  -v $(pwd)/uploads:/var/www/html/uploads \
  platoon-html:latest

# Or use Docker Compose
docker-compose -f docker-compose.yml up -d
```

### Option 3: Heroku
```bash
# Create Procfile
echo "web: vendor/bin/heroku-php-apache2" > Procfile

# Deploy
git push heroku main
```

### Option 4: AWS/Shared Hosting
1. Upload files via FTP/SFTP to `public_html` or similar
2. Ensure `.htaccess` is uploaded
3. Set `uploads` folder permissions to 755
4. Access via your domain

## Configuration

### File Upload Limits
Edit `api/upload.php`:
```php
if ($file['size'] > 10 * 1024 * 1024) { // Change 10MB limit
```

### Database Integration (Optional)
Add these files for database storage:
- `config/database.php` - Database connection
- `models/File.php` - File model

## Security

✅ Built-in features:
- File type validation (HTML only)
- File size limits (10MB)
- Directory traversal prevention
- XSS protection headers
- File permissions management

## API Endpoints

### GET /
Home page - upload and manage files

### POST /api/upload
Upload a new HTML file
```bash
curl -X POST -F "file=@myfile.html" http://localhost/api/upload
```

### GET /api/list
List all files
```bash
curl http://localhost/api/list
```

### GET /view/{filename}
View uploaded HTML file
```
http://localhost/view/myfile.html
```

### POST /api/delete
Delete a file
```bash
curl -X POST -H "Content-Type: application/json" \
  -d '{"file":"myfile.html"}' \
  http://localhost/api/delete
```

## Troubleshooting

### Permission Denied on Uploads
```bash
sudo chmod 755 uploads
sudo chown www-data:www-data uploads
```

### .htaccess Not Working
1. Check Apache `AllowOverride All` in apache2.conf
2. Ensure `mod_rewrite` is enabled: `a2enmod rewrite`
3. Restart Apache: `systemctl restart apache2`

### File Upload Fails
1. Check `php.ini` settings:
   - `upload_max_filesize = 10M`
   - `post_max_size = 10M`
2. Verify uploads folder permissions
3. Check available disk space

## Monitoring

### Check Logs
```bash
tail -f /var/log/apache2/error.log
tail -f /var/log/apache2/access.log
```

### Docker Logs
```bash
docker-compose logs -f
```

## Backup

```bash
# Backup uploaded files
tar -czf backup-$(date +%Y%m%d).tar.gz uploads/

# Store in safe location
mv backup-*.tar.gz /backup/location/
```

## Maintenance

- Regularly delete old uploaded files
- Monitor disk space
- Keep PHP updated
- Review access logs for suspicious activity
- Backup critical files periodically

## Support
For issues and questions, check documentation or contact support.

---
**Platoon HTML Server** - Simple, Secure, Deployable
