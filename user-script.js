const dropArea = document.querySelector('.drag-area');
const dragText = document.querySelector('.header');
const dragText2 = document.querySelector('.header2');

const support =  document.querySelector('.support');
const icon =  document.querySelector('.icon');
const button = document.querySelector('.button');
let input = dropArea.querySelector('input');
let file;

// when file is inside drag area
dropArea.addEventListener('dragover', (event) => {
  event.preventDefault();
  dropArea.classList.add('active');
  dragText.textContent = 'Release to Upload';
  // console.log('File is inside the drag area');
});
// when file leave the drag area
dropArea.addEventListener('dragleave', () => {
  dropArea.classList.remove('active');
  // console.log('File left the drag area');
  dragText.textContent = 'Drag & Drop';
});
// when file is dropped
dropArea.addEventListener('drop', (event) => {
  event.preventDefault();
  // console.log('File is dropped in drag area');
  file = event.dataTransfer.files[0]; // grab single file even of user selects multiple files
  // console.log(file);
  displayFile();
});
function displayFile() {
  let fileType = file.type;
  let validExtensions = ['image/jpeg', 'image/jpg', 'image/png'];

  if (validExtensions.includes(fileType)) {
    let fileReader = new FileReader();

    fileReader.onload = () => {
      let fileURL = fileReader.result;

      // Create an img element
      let imgElement = document.createElement('img');
      imgElement.src = fileURL;
      imgElement.alt = '';

      // Append the img element to the dropArea
      dropArea.appendChild(imgElement);
      dropArea.removeChild(dragText);
        dropArea.removeChild(icon);
      dropArea.removeChild(support);
    dropArea.removeChild(dragText2);
    };

    fileReader.readAsDataURL(file);
  } else {
    alert('This is not an Image File');
    dropArea.classList.remove('active');
  }
}

button.onclick = () => {
  input.click();
};
// when browse
input.addEventListener('change', function () {
  file = this.files[0];
  dropArea.classList.add('active');
  displayFile();
});


const theme = document.querySelector('.edit-btn');

const themeModal = document.querySelector('.create-event');
// Opens Modal
const openThemeModal = () => {
    themeModal.style.display = 'grid';
}

// Closes Modal
const closeThemeModal = (e) => {
    if(e.target.classList.contains('create-event')) {
        themeModal.style.display = 'none';
    }
}

themeModal.addEventListener('click', closeThemeModal);
theme.addEventListener('click', openThemeModal);