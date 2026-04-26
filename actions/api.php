<?php
// actions/api.php

// This file is included from index.php, so it doesn't need its own session_start()
require_once __DIR__ . '/../database.php';
require_once __DIR__ . '/../helpers.php';
require_once __DIR__ . '/../config.php'; // For constants like PAGE_SIZE

// Ensure the getID3 library is available
if (file_exists(__DIR__ . '/../getid3/getid3.php')) {
  require_once __DIR__ . '/../getid3/getid3.php';
}

$db = get_db();
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');
header('Expires: 0');

// The $action variable is available from index.php
$user_id = $_SESSION['user_id'] ?? null;
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset = ($page - 1) * PAGE_SIZE;
$limit_clause = " LIMIT " . PAGE_SIZE . " OFFSET " . $offset;

// The entire 'switch ($action)' block from your original file goes here.
// Make sure to remove the 'init_db' and other function definitions
// that are now in helpers.php or database.php.

// For example:
switch ($action) {
    case 'get_app_icon':
      header('Content-Type: image/svg+xml');
      $size = intval($_GET['size'] ?? 192);
      echo '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="white" class="bi bi-boombox-fill" viewBox="0 0 16 16"><path d="M11.538 6.237a.5.5 0 0 0-.738.03l-1.36 2.04a.5.5 0 0 0 .37.823h2.72a.5.5 0 0 0 .37-.823l-1.359-2.04a.5.5 0 0 0-.363-.17z"/><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM4.5 5.5a1 1 0 1 0 0-2 1 1 0 0 0 0 2m7 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2M6 6.5a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 0-1h-3a.5.5 0 0 0-.5.5m-1.5 6a.5.5 0 0 0 .5.5h5a.5.5 0 0 0 0-1h-5a.5.5 0 0 0-.5.5"/></svg>';
      exit;

    // ... and so on for all the other cases.
    // get_session, register, login, logout, etc.
    // PASTE THE ENTIRE switch($action) BLOCK HERE
    // FROM THE ORIGINAL index.php FILE
}
