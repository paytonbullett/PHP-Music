<?php
// database.php

require_once 'config.php';

function get_db() {
  static $db = null; // Use a static variable to maintain the connection
  if ($db === null) {
    try {
      $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
      $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
      ];
      $db = new PDO($dsn, DB_USER, DB_PASS, $options);
    } catch (PDOException $e) {
      // For a production environment, you should log this error instead of displaying it.
      header('Content-Type: application/json');
      http_response_code(500);
      echo json_encode(['status' => 'error', 'message' => 'Database connection failed: ' . $e->getMessage()]);
      exit;
    }
  }
  return $db;
}
