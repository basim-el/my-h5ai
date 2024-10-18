<!DOCTYPE html>
<html lang="en">


<body>
    <h1>Arborescence des fichiers et dossiers</h1>
    <p>Chemin d'accès actuel : <?php echo $currentPath; ?></p>
    <div class="test">
        <?php renderTree($h5ai, $tree, $basePath); ?>
        <div id="folder-content"></div>
    </div>
    <script src="./script/index.js" defer></script>
</body>


</html>