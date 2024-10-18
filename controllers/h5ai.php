<?php
require_once './models/h5ai.php';

$path = isset($_GET['path']) ? $_GET['path'] : '.';
$h5ai = new H5AI($path);

$h5ai->buildTree();
$tree = $h5ai->getTree();
$currentPath = realpath($h5ai->getPath());

function renderTree($h5ai, $tree, $basePath)
{
    $h5ai->printTree($tree, $basePath);
}
