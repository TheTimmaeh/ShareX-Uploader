# ShareX-Uploader
This custom uploader designed for ShareX handles all types of upload (Image/Text/File/URL Shortening).

Types will be uploaded to separate folders:

| Type | Folder | Link |
|---|---|---|
| Image | /var/www/i/ | http://example.com/i/image.jpg |
| Text | /var/www/f/ | http://example.com/f/text.txt |
| File | /var/www/f/ | http://exmaple.com/f/file.zip |
| URL Shortening | /var/www/l/ | http://example.com/l/ABC123 |

## Server Setup
Simply upload the sharex.php to your web root, create the folders 'i' and 'f' (with chown www-data) and adjust your webserver config.

### Apache
Add the following code to your .htaccess file in your web root

```
RewriteEngine On
RewriteRule ^l/([a-zA-Z0-9]+)$ sharex.php [L]
```

### Nginx
Add the following code to your config (e.g. /etc/nginx/sites-available/default)

```
location /l {
  rewrite ^/l/([a-zA-Z0-9]+)$ /sharex.php last;
}
```

## ShareX Setup
Download fileuploader.sxcu and urlshortener.sxcu, adjust the request URL and your API key, and import them to your ShareX configuration.
