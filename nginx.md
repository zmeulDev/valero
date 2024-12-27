# Steps to Add a New Website (`citybrk.ro`) Using Nginx and SSL

## Step 1: Create a Directory for the New Website
Ensure the directory for `citybrk.ro` is created:
```bash
sudo mkdir -p /var/www/citybrkro/public
sudo chown -R $USER:$USER /var/www/citybrkro
sudo chmod -R 755 /var/www/citybrkro
```

## Step 2: Add a Sample HTML/PHP File
Add a basic `index.php` or `index.html` to test:
```bash
echo "<?php phpinfo(); ?>" > /var/www/citybrkro/public/index.php
```

## Step 3: Create a New Nginx Configuration File
Create a configuration file for `citybrk.ro`:
```bash
sudo nano /etc/nginx/sites-available/citybrk.ro
```

Add the following content:
```nginx
server {
    server_name citybrk.ro www.citybrk.ro;

    root /var/www/citybrkro/public;
    index index.php index.html;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock; # Adjust PHP version if needed
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.ht {
        deny all;
    }

    error_log /var/log/nginx/citybrkro-error.log;
    access_log /var/log/nginx/citybrkro-access.log;

    listen 443 ssl; # managed by Certbot
    ssl_certificate /etc/letsencrypt/live/citybrk.ro/fullchain.pem; # managed by Certbot
    ssl_certificate_key /etc/letsencrypt/live/citybrk.ro/privkey.pem; # managed by Certbot
    include /etc/letsencrypt/options-ssl-nginx.conf; # managed by Certbot
    ssl_dhparam /etc/letsencrypt/ssl-dhparams.pem; # managed by Certbot
}

server {
    if ($host = www.citybrk.ro) {
        return 301 https://$host$request_uri;
    } # managed by Certbot

    if ($host = citybrk.ro) {
        return 301 https://$host$request_uri;
    } # managed by Certbot

    listen 80;
    server_name citybrk.ro www.citybrk.ro;
    return 404; # managed by Certbot
}
```

## Step 4: Enable the Site
Enable the `citybrk.ro` configuration:
```bash
sudo ln -s /etc/nginx/sites-available/citybrk.ro /etc/nginx/sites-enabled/
```

## Step 5: Test Nginx Configuration
Ensure there are no syntax errors:
```bash
sudo nginx -t
```

Reload Nginx to apply changes:
```bash
sudo systemctl reload nginx
```

## Step 6: Generate SSL Certificates
Run Certbot to obtain and install SSL certificates:
```bash
sudo certbot --nginx -d citybrk.ro -d www.citybrk.ro
```

Follow the prompts to agree to the terms and choose redirection (force HTTPS).

## Step 7: Verify the New Website
1. Open a browser and visit `https://citybrk.ro` and `https://www.citybrk.ro`.
2. If there are issues, check logs:
   - Nginx error log:
     ```bash
     sudo tail -f /var/log/nginx/citybrkro-error.log
     ```
   - Nginx access log:
     ```bash
     sudo tail -f /var/log/nginx/citybrkro-access.log
     ```

## Step 8: Optional Cleanup
Remove unnecessary default configurations if no longer needed:
```bash
sudo rm /etc/nginx/sites-enabled/default
```
Then reload Nginx:
```bash
sudo systemctl reload nginx
```

## Step 9: Clone a GitHub Repository
To clone a GitHub repository, follow these steps:

1. Navigate to the directory where you want to clone the repository and remove public folder:
   ```bash
   cd /var/www/citybrkro
   sudo rm -rf public/
   ```


2. Clone the repository:
   ```bash
   git clone https://github.com/zmeulDev/valero.git .
   ```

3. Check the contents of the directory:
   ```bash
   ls -la
   ```

4. Ensure proper permissions:
   ```bash
   sudo chown -R $USER:$USER /var/www/citybrkro
   sudo chmod -R 755 /var/www/citybrkro
   ```

# Summary
The above steps will add the `citybrk.ro` website to your Nginx setup with HTTPS support and guide you on cloning a GitHub repository into the website's directory. Ensure to replace PHP versions, repository URLs, or directory paths as needed. Use the logs for troubleshooting if necessary.

