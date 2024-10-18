function loadFolderContent(path) {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', './models/load_folder.php?path=' + encodeURIComponent(path));
    xhr.onload = function () {
        if (xhr.status === 200) {
            document.getElementById('folder-content').innerHTML = xhr.responseText;
            updateView();
            addEventListenersToFolders2();
        } else {
            console.error('Erreur de chargement : ' + xhr.statusText);
        }
    };
    xhr.onerror = function () {
        console.error('Erreur de réseau');
    };
    xhr.send();
}

function addEventListenersToFolders() {
    var folders = document.querySelectorAll('.folder-item');
    folders.forEach(function (folder) {
        folder.querySelector('.folder-name').addEventListener('click', function () {
            var childList = folder.querySelector('ul');
            if (childList.style.display === 'none' || childList.style.display === '') {
                childList.style.display = 'block';
            } else {
                childList.style.display = 'none';
            }

            var path = folder.getAttribute('data-path');
            // loadFolderContent(path);
        });
    });
}

function addEventListenersToFolders2() {
    var folder = document.querySelector('#folder-content');
    folderNames = folder.querySelectorAll('.folder-name');

    folderNames.forEach((folderName) => {
        folderName.addEventListener('click', function () {
            var path = folderName.getAttribute('data-path');
            loadFolderContent(path);
        });
    });
}

function updateView() {
    const viewForm = document.getElementById('view-form');
    const viewSelect = document.getElementById('view-select');
    const fileExplorer = document.querySelector('.file-explorer');

    viewForm.addEventListener('submit', (event) => {
        event.preventDefault();
        const view = viewSelect.value;
        switch (view) {
            case 'list':
                fileExplorer.classList.remove('grid', 'medium', 'details');
                break;
            case 'icon':
                fileExplorer.classList.remove('medium', 'details');
                fileExplorer.classList.add('grid');
                break;
            case 'medium':
                fileExplorer.classList.remove('grid', 'details');
                fileExplorer.classList.add('medium');
                break;
            case 'details':
                fileExplorer.classList.remove('grid', 'medium');
                fileExplorer.classList.add('details');
                break;
        }
    });
}

const folders = document.querySelectorAll('.folder');

folders.forEach(folder => {
    folder.addEventListener('click', () => {
        const path = folder.dataset.path;
        window.location.href = `?path=${path}`;
    });
});

document.addEventListener('DOMContentLoaded', function () {
    loadFolderContent(".");
    addEventListenersToFolders();
});

