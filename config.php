<?php
// config.php

// --- DATABASE CONFIGURATION ---
define('DB_HOST', 'localhost');      // Your database host (e.g., 'localhost' or an IP address)
define('DB_NAME', 'php_music');      // The name of your database
define('DB_USER', 'root');           // Your database username
define('DB_PASS', '');               // Your database password

// --- APPLICATION SETTINGS ---
define('MUSIC_DIR', __DIR__);
define('APP_VERSION', '1.8');
define('PAGE_SIZE', 25);
define('ADMIN_PAGE_SIZE', 20);
define('DAILY_UPLOAD_LIMIT', 10);

// --- SECURITY ---
// To generate a new hash, create a temporary PHP file with:
// <?php echo password_hash('your_password_here', PASSWORD_DEFAULT); ?>
// Then copy the output and paste it below.
define('ADMIN_PASSWORD_HASH', '$2y$10$E.qJ4nL9.D4g/y2u5u4/COe.3.i9nB5ZfG.t.y6bV8cW7zX2O9U0a'); // Default is 'admin'
