<!DOCTYPE html>
<html lang ="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link rel="stylesheet" href="style.css" />
</head>
<?php 
require_once("functs_temp.php");

changeSession();

?>
<body>
    
    <?php
    include("navbar.php");
    ?>

    <?php

    showFoodReport();

    ?>
    
</body>
</html>