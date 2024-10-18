<div class="file-explorer-container">
    <form id="view-form" action="" method="get">
        <label for="view-select">Vue : </label>
        <select name="view" id="view-select">
            <option value="list">Liste</option>
            <option value="icon">Grande icône</option>
            <option value="medium">Icône moyenne</option>
            <option value="details" selected>Détails</option>
        </select>
        <button type="submit">Afficher</button>
    </form>


    <?php

    $size = isset($_GET['size']) ? $_GET['size'] : 'medium';
    if (isset($_GET['path'])) {
        $path = "../" . $_GET['path'];
        $directory = new DirectoryIterator($path);
        echo '<ul class="file-explorer details">';
        $parentDirectory = dirname($_GET['path']);
        echo '<li><button onclick="loadFolderContent(\'' . $parentDirectory . '\')">RETOUR</button></li>';
        if (isset($_GET['view'])) {
            $view = $_GET['view'];
            switch ($view) {
                case 'list':
                    $size = '';
                    break;
                case 'icon':
                    $size = 'large';
                    break;
                case 'medium':
                    $size = 'medium';
                    break;
                case 'details':
                    $size = 'details';
                    break;
                default:
                    $size = 'medium';
                    break;
            }
        }

        foreach ($directory as $fileInfo) {
            if ($fileInfo->isDot()) {
                continue;
            }
            if ($fileInfo->isDir()) {
                $folderSize = getDirectorySize("$path/" . $fileInfo->getFilename());
                echo '<li class="folder-name file" data-path="' . $_GET['path'] . '/' . $fileInfo->getFilename() . '">';
                echo '<i class="fas fa-folder icon-' . $size . '"></i>';
                echo $fileInfo->getFilename();
                echo '<span class="file-info">';
                echo '<span class="file-date">Modifié le ' . date("d/m/Y H:i:s", $fileInfo->getMTime()) . '</span>';
                echo '<span class="file-size">' . formatSizeUnits($folderSize) . '</span>';
                echo '</span>';
                echo '</li>';
            } else {
                $extension = pathinfo($fileInfo->getFilename(), PATHINFO_EXTENSION);
                echo '<li class="file">';
                switch ($extension) {
                    case 'txt':
                        echo "<span class='fas fa-file-alt'></span> ";
                        break;
                    case 'js':
                        echo "<span class='fab fa-js'></span> ";
                        break;
                    case 'html':
                    case 'htm':
                        echo "<span class='fab fa-html5'></span> ";
                        break;
                    case 'php':
                        echo "<span class='fab fa-php'></span> ";
                        break;
                    case 'css':
                        echo "<span class='fab fa-css3-alt'></span> ";
                        break;
                    case 'json':
                        echo "<span class='fas fa-file-code'></span> ";
                        break;
                    case 'py':
                        echo "<span class='fab fa-python'></span> ";
                        break;
                    case 'xml':
                        echo "<span class='fas fa-file-code'></span> ";
                        break;
                    case 'jpg':
                    case 'jpeg':
                        echo "<span class='fas fa-file-image'></span> ";
                        break;
                    case 'png':
                        echo "<span class='fas fa-file-image'></span> ";
                        break;
                    case 'svg':
                        echo "<span class='fas fa-file-image'></span> ";
                        break;
                    case 'mp4':
                        echo "<span class='fas fa-file-video'></span> ";
                        break;
                    case 'mp3':
                        echo "<span class='fas fa-file-audio'></span> ";
                        break;
                    case 'zip':
                        echo "<span class='fas fa-file-archive'></span> ";
                        break;
                    case 'tar.gz':
                        echo "<span class='fas fa-file-archive'></span> ";
                        break;
                    case 'sql':
                        echo "<span class='fas fa-file-code'></span> ";
                        break;
                    case 'doc':
                    case 'docx':
                        echo "<span class='fas fa-file-word'></span> ";
                        break;
                    case 'xls':
                    case 'xlsx':
                        echo "<span class='fas fa-file-excel'></span> ";
                        break;
                    case 'ppt':
                    case 'pptx':
                        echo "<span class='fas fa-file-powerpoint'></span> ";
                        break;
                    case 'pdf':
                        echo "<span class='fas fa-file-pdf'></span> ";
                        break;
                    case 'ico':
                        echo "<span class='far fa-image'></span> ";
                        break;
                    case 'gif':
                        echo "<span class='far fa-image'></span> ";
                        break;
                    case 'bmp':
                        echo "<span class='far fa-image'></span> ";
                        break;
                    case 'tiff':
                        echo "<span class='far fa-image'></span> ";
                        break;
                    case 'wav':
                        echo "<span class='fas fa-file-audio'></span> ";
                        break;
                    case 'ogg':
                        echo "<span class='fas fa-file-audio'></span> ";
                        break;
                    case 'wma':
                        echo "<span class='fas fa-file-audio'></span> ";
                        break;
                    case 'avi':
                        echo "<span class='fas fa-file-video'></span> ";
                        break;
                    case 'wmv':
                        echo "<span class='fas fa-file-video'></span> ";
                        break;
                    case 'mov':
                        echo "<span class='fas fa-file-video'></span> ";
                        break;
                    case 'flv':
                        echo "<span class='fas fa-file-video'></span> ";
                        break;
                    case 'csv':
                        echo "<span class='fas fa-file-csv'></span> ";
                        break;
                    case 'exe':
                        echo "<span class='fas fa-cogs'></span> ";
                        break;
                    default:
                        echo "<span class='fas fa-file'></span> ";
                        break;
                }
                echo $fileInfo->getFilename();
                echo '<span class="file-info">';
                echo '<span class="file-date">Modifié le ' . date("d/m/Y H:i:s", $fileInfo->getMTime()) . '</span>';
                echo '<span class="file-size">' . formatSizeUnits($fileInfo->getSize()) . '</span>';
                echo '</span>';
                echo '</li>';
            }
        }
        echo '</ul>';
    }
    function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824) {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        } elseif ($bytes > 1) {
            $bytes = $bytes . ' bytes';
        } elseif ($bytes == 1) {
            $bytes = $bytes . ' byte';
        } else {
            $bytes = '0 bytes';
        }
        return $bytes;
    }

    function getDirectorySize($dir)
    {
        $size = 0;
        $files = scandir($dir);
        foreach ($files as $file) {
            if ($file != "." && $file != "..") {
                if (is_dir("$dir/$file")) {
                    $size += getDirectorySize("$dir/$file");
                } else {
                    $size += filesize("$dir/$file");
                }
            }
        }
        return $size;
    }
    ?>
</div>