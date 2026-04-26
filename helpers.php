<?php
// helpers.php

function send_json($data) {
  if (!headers_sent()) {
    header('Content-Type: application/json; charset=utf-8');
  }
  $json = json_encode($data, JSON_INVALID_UTF8_SUBSTITUTE);
  if ($json === false) {
    http_response_code(500);
    echo '{"status":"error", "message":"JSON encoding error: ' . json_last_error_msg() . '"}';
  } else {
    echo $json;
  }
  exit;
}

function sanitize_for_path($string) {
  $string = strtolower($string);
  $string = preg_replace('/[^a-z0-9]/', '', $string);
  return empty($string) ? 'unknown' : $string;
}

function get_upload_limit() {
  $max_upload = ini_get('upload_max_filesize');
  $max_post = ini_get('post_max_size');
  return "Max file size: " . min($max_upload, $max_post);
}

function process_image_to_webp($imageData, $target_width = 500, $quality = 75) {
  if (!$imageData || !function_exists('imagecreatefromstring') || !function_exists('imagewebp')) {
    return null;
  }
  $sourceImage = @imagecreatefromstring($imageData);
  if (!$sourceImage) { return null; }

  $resizedImage = imagecreatetruecolor($target_width, $target_width);
  imagealphablending($resizedImage, false);
  imagesavealpha($resizedImage, true);
  imagecopyresampled($resizedImage, $sourceImage, 0, 0, 0, 0, $target_width, $target_width, imagesx($sourceImage), imagesy($sourceImage));

  ob_start();
  imagewebp($resizedImage, null, $quality);
  $webpData = ob_get_clean();
  imagedestroy($sourceImage);
  imagedestroy($resizedImage);
  return $webpData;
}
