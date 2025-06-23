<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php 
        // Safe output with fallbacks
        $title = defined('APP_NAME') ? APP_NAME : 'VibePic';
        if (isset($pageTitle)) {
            echo htmlspecialchars($pageTitle) . ' | ' . $title;
        } else {
            echo $title;
        }
    ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="<?php echo defined('URL_ROOT') ? URL_ROOT . '/assets/css/style.css' : '/assets/css/style.css'; ?>" rel="stylesheet">
</head>
<body>
    <div class="container-fluid p-0"></div>