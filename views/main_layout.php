<?php
// views/main_layout.php
require_once __DIR__ . '/../config.php'; // For APP_VERSION
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Music</title>
    
    <!-- External CSS and CDN Links -->
    <link rel="icon" type="image/svg+xml" href="?action=get_app_icon" />
    <meta name="theme-color" content="#121212"/>
    <link rel="manifest" href="?pwa=manifest">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    
    <?php echo $initialViewJS; ?>
  </head>
  <body class="logged-out">

    <!-- PASTE THE ENTIRE HTML BODY HERE -->
    <!-- (from <div class="app-container"> to the </div> before the script tag) -->
    <div class="app-container">
        <!-- ... ALL THE HTML FOR THE PLAYER ... -->
    </div>
    
    <!-- ALL THE MODAL HTML -->

    <!-- External JS and CDN Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    <script src="js/app.js"></script>
  </body>
</html>
