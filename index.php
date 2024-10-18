<!DOCTYPE html>
<html lang="en">

<head>
    <title>Arborescence des fichiers et dossiers</title>
    <link rel="stylesheet" href="./views/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
</head>

</html>

<?php
require_once './controllers/h5ai.php';
$basePath = $h5ai->getPath();

include './views/h5ai.php';
