<?php
class H5AI
{
    private $_tree;
    private $_path;

    public function __construct($path = '.')
    {
        $this->_tree = [];
        $this->_path = $path;
    }

    public function getPath()
    {
        return $this->_path;
    }

    public function getTree()
    {
        return $this->_tree;
    }

    public function buildTree()
    {
        $directory = new DirectoryIterator($this->_path);

        foreach ($directory as $fileInfo) {
            if ($fileInfo->isDot()) {
                continue;
            }

            $file = $fileInfo->getFilename();
            $filePath = $this->_path . DIRECTORY_SEPARATOR . $file;

            if ($fileInfo->isDir()) {
                $subTree = new H5AI($filePath);
                $subTree->buildTree();
                $this->_tree[$file] = $subTree->getTree();
            } elseif ($fileInfo->isFile()) {
                $this->_tree[] = $file;
            } else {
                throw new Exception("Impossible de traiter le fichier : " . $file);
            }
        }
    }

    public function printTree($tree, $basePath, $indent = 0)
    {
        echo "<ul class='file-tree'>";
        if ($indent == 0) {
            echo "<li class='folder-item' data-path='" . htmlspecialchars($basePath) . "'>";
            echo "<i class='fas fa-folder'></i> ";
            if ($basePath == '.') {
                echo "<span class='folder-name'>" . basename(getcwd()) . "</span>";
            } else {
                echo "<span class='folder-name'>" . ($basePath == '/' ? '/' : basename($basePath)) . "</span>";
            }
            echo "<ul>";
        }

        foreach ($tree as $index => $value) {
            echo "<li>";
            if (is_array($value)) {
                $newBasePath = $basePath . DIRECTORY_SEPARATOR . $index;
                echo "<li class='folder-item' data-path='" . htmlspecialchars($newBasePath) . "'>";
                echo "<i class='fas fa-folder'></i> ";
                echo "<span class='folder-name'>" . $index . "/</span>";
                $this->printTree($value, $newBasePath, $indent + 1);
            } else {
                $extension = pathinfo($value, PATHINFO_EXTENSION);
                $filePath = $basePath . DIRECTORY_SEPARATOR . $value;

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

                echo $value;

                if ($extension === 'html') {
                    $favicon = $this->getFavicon($filePath);
                    if ($favicon) {
                        echo " <img src='{$favicon}' alt='Favicon' class='favicon'>";
                    }
                }
            }
            echo "</li>";
        }

        if ($indent == 0) {
            echo "</ul>";
            echo "</li>";
        }
        echo "</ul>";
    }



    private function getFavicon($filePath)
    {
        if (!file_exists($filePath)) {
            return null;
        }

        $content = file_get_contents($filePath);

        if (empty($content)) {
            return null;
        }

        $doc = new DOMDocument();
        libxml_use_internal_errors(true);
        $doc->loadHTML($content);
        libxml_clear_errors();

        $links = $doc->getElementsByTagName('link');

        foreach ($links as $link) {
            if ($link->getAttribute('rel') === 'icon' || $link->getAttribute('rel') === 'shortcut icon') {
                $faviconPath = $link->getAttribute('href');

                if (filter_var($faviconPath, FILTER_VALIDATE_URL)) {
                    return $faviconPath;
                }

                $pathInfo = pathinfo($filePath);
                $dirPath = $pathInfo['dirname'];

                $absoluteFaviconPath = realpath($dirPath . DIRECTORY_SEPARATOR . $faviconPath);

                if ($absoluteFaviconPath !== false) {
                    return $absoluteFaviconPath;
                }
            }
        }

        return null;
    }
}
