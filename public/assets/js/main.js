/* Checkbox, скрывающий поля */
document.addEventListener('DOMContentLoaded', function() {
    let toggleInputFields = document.getElementById('toggle-input-fields');
    let inputFields = document.getElementById('input-fields');

    toggleInputFields.addEventListener('change', function() {
        if (toggleInputFields.checked) {
            inputFields.style.display = 'block';
        } else {
            inputFields.style.display = 'none';
        }
    });
});

let problemFileChooser = document.querySelector('.file-chooser-problem');
let solutionFileChooser = document.querySelector('.file-chooser-solution');

problemFileChooser.addEventListener('click', function() {
    createInputFiles('input__images-problem', 'images_problem[]',
        '.filename-list-problem', '.input-list-problem');
});

solutionFileChooser.addEventListener('click', function () {
    createInputFiles('input__images-solution', 'images_solution[]',
        '.filename-list-solution', '.input-list-solution');
});

/* Накопление вновь загруженных файлов */
function createInputFiles(className, name, fileNameList, inputList) {
    let fileNameContainer = document.querySelector(fileNameList);
    let inputContainer = document.querySelector(inputList);

    const input = document.createElement('input');
    input.type = 'file';
    input.multiple = true;
    input.style.display = 'none';
    input.className = className;
    input.name = name;

    inputContainer.appendChild(input)

    input.addEventListener('change', function(e) {
        const newFiles = Array.from(e.target.files);
        let overSize = false;
        let filesUrl = JSON.parse(localStorage.getItem('filesUrl'))

        newFiles.forEach(function (file) {
            if (file.size > 1024 * 1024 * 20) {
                alert('Допустимый размер одного файла - 20 МБ');
                overSize = true;
            }
        })

        if (overSize === true) {
            return
        }

        const files = Array.from(fileNameContainer.querySelectorAll('.row__file-item .row__file-name')).map(file => ({ name: file.textContent }));

        if (files.length + newFiles.length > 5) {
            alert('Можно загрузить не более 5 файлов');
            return;
        }

        newFiles.forEach(function (file) {
            if(filesUrl) {
                filesUrl.push(URL.createObjectURL(file));
            } else {
                filesUrl = [URL.createObjectURL(file)];
            }
            localStorage.setItem('filesUrl', JSON.stringify(filesUrl));
        })

        const allFiles = [...files, ...newFiles];

        displayFiles(allFiles, fileNameContainer);
    });

    input.click();
}

/* Отображение загруженных файлов */
function displayFiles(files, fileNameContainer) {
    fileNameContainer.innerHTML = '';
    let filesUrl = JSON.parse(localStorage.getItem('filesUrl'))

    files.forEach(function (file) {
        const fileItem = document.createElement('div');
        fileItem.classList.add('row__file-item');

        const fileName = document.createElement('a');
        fileName.classList.add('row__file-name');
        fileName.textContent = file.name;
        fileName.href = filesUrl[files.indexOf(file)]
        fileName.setAttribute('download', file.name);

        const deleteIcon = document.createElement('span');
        deleteIcon.classList.add('row__delete-file');
        deleteIcon.innerHTML = '&#10006';
        deleteIcon.addEventListener('click', function() {
            let filesUrl = JSON.parse(localStorage.getItem('filesUrl'))
            const fileIndex = files.indexOf(file);

            files.splice(fileIndex, 1);
            filesUrl.splice(fileIndex, 1)
            displayFiles(files, fileNameContainer);
            localStorage.setItem('filesUrl', JSON.stringify(filesUrl));
        });

        fileItem.appendChild(fileName);
        fileItem.appendChild(deleteIcon);
        fileNameContainer.appendChild(fileItem);
    })
}

function clearStorage() {
    localStorage.removeItem('filesUrl')
}

window.addEventListener('beforeunload', function() {
    clearStorage()
});
