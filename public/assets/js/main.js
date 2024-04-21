
/* Checkbox, скрывающий поля */
document.addEventListener('DOMContentLoaded', function() {
    var toggleInputFields = document.getElementById('toggle-input-fields');
    var inputFields = document.getElementById('input-fields');

    toggleInputFields.addEventListener('change', function() {
        if (toggleInputFields.checked) {
            inputFields.style.display = 'block';
        } else {
            inputFields.style.display = 'none';
        }
    });
});

/* Отображение загруженных файлов */
function displayFiles(files, fileListContainer) {
    fileListContainer.innerHTML = '';

    files.forEach(function(file) {
        const fileItem = document.createElement('div');
        fileItem.classList.add('row__file-item');

        const fileName = document.createElement('span');
        fileName.classList.add('row__file-name');
        fileName.textContent = file.name;

        const deleteIcon = document.createElement('span');
        deleteIcon.classList.add('row__delete-file');
        deleteIcon.innerHTML = '&#10006';
        deleteIcon.addEventListener('click', function() {
            const fileIndex = files.indexOf(file);
            if (fileIndex !== -1) {
                files.splice(fileIndex, 1);
                displayFiles(files, fileListContainer);
            }
        });

        fileItem.appendChild(fileName);
        fileItem.appendChild(deleteIcon);
        fileListContainer.appendChild(fileItem);
    });
}

/* Накопление вновь загруженных файлов */
const fileChooserButtons = document.querySelectorAll('.file-chooser');
fileChooserButtons.forEach(function(button, index) {
    button.addEventListener('click', function() {

        const input = document.createElement('input');
        input.type = 'file';
        input.multiple = true;
        input.style.display = 'none';

        input.addEventListener('change', function(e) {
            const newFiles = Array.from(e.target.files);
            const fileListContainer = document.querySelectorAll('.row__file-list')[index];
            const files = Array.from(fileListContainer.querySelectorAll('.row__file-item .row__file-name')).map(file => ({ name: file.textContent }));

            const allFiles = [...files, ...newFiles];

            displayFiles(allFiles, fileListContainer);
        });

        input.click();
    });
});