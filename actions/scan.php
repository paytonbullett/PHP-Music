<?php
// actions/scan.php
require_once __DIR__ . '/../database.php';
require_once __DIR__ . '/../helpers.php';
require_once __DIR__ . '/../config.php';

if (file_exists(__DIR__ . '/../getid3/getid3.php')) {
  require_once __DIR__ . '/../getid3/getid3.php';
}

$db = get_db();
perform_full_scan($db);

// PASTE THE ENTIRE perform_full_scan($db) FUNCTION HERE
// FROM THE ORIGINAL index.php FILE
function perform_full_scan($db) {
    // ... function content ...
}
?>
