import "jsvectormap/dist/jsvectormap.min.css";
import "flatpickr/dist/flatpickr.min.css";
import "dropzone/dist/dropzone.css";
import "../css/app.css";

import Alpine from "alpinejs";
import persist from "@alpinejs/persist";
import flatpickr from "flatpickr";
import Dropzone from "dropzone";

import chart01 from "./components/charts/chart-01";
import chart02 from "./components/charts/chart-02";
import chart03 from "./components/charts/chart-03";
import map01 from "./components/map-01";
import "./components/calendar-init.js";
import "./components/image-resize";

Alpine.plugin(persist);
window.Alpine = Alpine;
Alpine.start();

// Init flatpickr
flatpickr(".datepicker", {
  mode: "range",
  static: true,
  monthSelectorType: "static",
  dateFormat: "M j, Y",
  defaultDate: [new Date().setDate(new Date().getDate() - 6), new Date()],
  prevArrow:
    '<svg class="stroke-current" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15.25 6L9 12.25L15.25 18.5" stroke="" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>',
  nextArrow:
    '<svg class="stroke-current" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8.75 19L15 12.75L8.75 6.5" stroke="" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>',
  onReady: (selectedDates, dateStr, instance) => {
    // eslint-disable-next-line no-param-reassign
    instance.element.value = dateStr.replace("to", "-");
    const customClass = instance.element.getAttribute("data-class");
    instance.calendarContainer.classList.add(customClass);
  },
  onChange: (selectedDates, dateStr, instance) => {
    // eslint-disable-next-line no-param-reassign
    instance.element.value = dateStr.replace("to", "-");
  },
});

// Init Dropzone
document.addEventListener('DOMContentLoaded', () => {
  Dropzone.autoDiscover = false;

  const dropzoneElement = document.querySelector("#assignmentDropzone");

  if (dropzoneElement) {
    const myDropzone = new Dropzone("#assignmentDropzone", {
      url: "#", // Tidak digunakan karena form di-handle Laravel
      autoProcessQueue: false,
      maxFiles: 1,
      acceptedFiles: ".pdf,.doc,.docx,.zip,.rar",
      addRemoveLinks: true,
      dictDefaultMessage: "",

      init: function () {
        this.on("addedfile", function (file) {
          const fileInput = document.getElementById("fileInput");
          if (fileInput) {
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);
            fileInput.files = dataTransfer.files;
          }
        });

        this.on("removedfile", function () {
          const fileInput = document.getElementById("fileInput");
          if (fileInput) {
            fileInput.value = "";
          }
        });
      }
    });
  }
});

document.addEventListener('DOMContentLoaded', function () {
  const fileInput = document.getElementById('uploadTugasInput');
  const uploadDefault = document.getElementById('uploadDefault');
  const uploadSelected = document.getElementById('uploadSelected');
  const fileList = document.getElementById('fileNamesInLabel');
  const uploadLabel = document.getElementById('uploadLabel');

  let uploadedFiles = [];

  function renderFileList() {
    fileList.innerHTML = '';

    if (uploadedFiles.length === 0) {
      uploadDefault.classList.remove('hidden');
      uploadSelected.classList.add('hidden');
      return;
    }

    uploadedFiles.forEach((file, index) => {
      const li = document.createElement('li');
      li.classList.add('flex', 'items-center', 'justify-between', 'mb-1');

      const fileNameSpan = document.createElement('span');
      fileNameSpan.textContent = `${index + 1}. ${file.name}`;

      const deleteBtn = document.createElement('button');
      deleteBtn.innerHTML = '🗑️'; // Bisa diganti SVG icon
      deleteBtn.classList.add('ml-2', 'text-red-500', 'hover:text-red-700');
      deleteBtn.setAttribute('type', 'button');
      deleteBtn.addEventListener('click', () => {
        uploadedFiles.splice(index, 1);
        renderFileList();
      });

      li.appendChild(fileNameSpan);
      li.appendChild(deleteBtn);
      fileList.appendChild(li);
    });

    uploadDefault.classList.add('hidden');
    uploadSelected.classList.remove('hidden');
  }

  fileInput.addEventListener('change', function () {
    const newFiles = Array.from(fileInput.files);
    uploadedFiles = uploadedFiles.concat(newFiles);
    renderFileList();
    fileInput.value = ''; // Reset input agar bisa pilih file yang sama lagi kalau mau
  });

  const form = document.querySelector('form');
  form.addEventListener('submit', function (e) {
    e.preventDefault();

    const formData = new FormData(form);

    uploadedFiles.forEach(file => {
      formData.append('files[]', file);
    });

    fetch(form.action, {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
      },
      body: formData
    })
    .then(response => {
      if (!response.ok) throw new Error('Upload gagal');
      return response.json();
    })
    .then(data => {
      alert('Upload berhasil!');
      uploadedFiles = [];
      fileInput.value = '';
      renderFileList();
    })
    .catch(error => {
      console.error(error);
      alert('Terjadi kesalahan saat upload!');
    });
  });
});

document.addEventListener('DOMContentLoaded', () => {
  const fileInput = document.getElementById('fileInput');
  const uploadDefault = document.getElementById('uploadDefault');
  const uploadSelected = document.getElementById('uploadSelected');
  const fileNamesInLabel = document.getElementById('fileNamesInLabel');
  const submissionForm = document.getElementById('submission-form');
  const submitButton = submissionForm.querySelector('button[type="submit"]');

  let selectedFiles = [];

  fileInput.addEventListener('change', () => {
    const newFiles = Array.from(fileInput.files);

    newFiles.forEach(file => {
      if (!selectedFiles.some(existingFile => existingFile.name === file.name)) {
        selectedFiles.push(file);
      }
    });

    updateFileListUI();
  });

  function updateFileListUI() {
    fileNamesInLabel.innerHTML = '';

    if (selectedFiles.length > 0) {
      uploadDefault.classList.add('hidden');
      uploadSelected.classList.remove('hidden');

      selectedFiles.forEach(file => {
        const li = document.createElement('li');
        li.textContent = file.name;

        const removeButton = document.createElement('button');
        removeButton.textContent = '❌';
        removeButton.classList.add('ml-2', 'text-red-500', 'hover:text-red-700');
        removeButton.addEventListener('click', () => {
          selectedFiles = selectedFiles.filter(f => f.name !== file.name);
          updateFileListUI();
        });

        li.appendChild(removeButton);
        fileNamesInLabel.appendChild(li);
      });
    } else {
      uploadDefault.classList.remove('hidden');
      uploadSelected.classList.add('hidden');
    }
  }

  submissionForm.addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData();
    selectedFiles.forEach(file => {
      formData.append('files[]', file);
    });

    const url = submissionForm.getAttribute('action');

    submitButton.disabled = true;
    submitButton.innerText = 'Mengirim...';

    fetch(url, {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
      },
      body: formData
    })
    .then(response => {
      if (!response.ok) throw new Error('Gagal mengupload file!');
      return response.json();
    })
    .then(data => {
      alert('Tugas berhasil dikumpulkan!');
      location.reload(); // Atau redirect sesuai kebutuhan
    })
    .catch(error => {
      console.error(error);
      alert('Terjadi kesalahan saat mengupload file.');
    })
    .finally(() => {
      submitButton.disabled = false;
      submitButton.innerText = 'Kumpulkan Tugas';
    });
  });
});


// Document Loaded
document.addEventListener("DOMContentLoaded", () => {
  chart01();
  chart02();
  chart03();
  map01();
});

// Get the current year
const year = document.getElementById("year");
if (year) {
  year.textContent = new Date().getFullYear();
}

// For Copy//
document.addEventListener("DOMContentLoaded", () => {
  const copyInput = document.getElementById("copy-input");
  if (copyInput) {
    // Select the copy button and input field
    const copyButton = document.getElementById("copy-button");
    const copyText = document.getElementById("copy-text");
    const websiteInput = document.getElementById("website-input");

    // Event listener for the copy button
    copyButton.addEventListener("click", () => {
      // Copy the input value to the clipboard
      navigator.clipboard.writeText(websiteInput.value).then(() => {
        // Change the text to "Copied"
        copyText.textContent = "Copied";

        // Reset the text back to "Copy" after 2 seconds
        setTimeout(() => {
          copyText.textContent = "Copy";
        }, 2000);
      });
    });
  }
});

document.addEventListener("DOMContentLoaded", function () {
  const searchInput = document.getElementById("search-input");
  const searchButton = document.getElementById("search-button");

  // Function to focus the search input
  function focusSearchInput() {
    searchInput.focus();
  }

  // Add click event listener to the search button
  if (searchButton && searchInput) {
    searchButton.addEventListener("click", focusSearchInput);

    document.addEventListener("keydown", function (event) {
      if ((event.metaKey || event.ctrlKey) && event.key === "k") {
        event.preventDefault();
        focusSearchInput();
      }
    });

    document.addEventListener("keydown", function (event) {
      if (event.key === "/" && document.activeElement !== searchInput) {
        event.preventDefault();
        focusSearchInput();
      }
    });
  }

  // Add keyboard event listener for Cmd+K (Mac) or Ctrl+K (Windows/Linux)
  document.addEventListener("keydown", function (event) {
    if ((event.metaKey || event.ctrlKey) && event.key === "k") {
      event.preventDefault(); // Prevent the default browser behavior
      focusSearchInput();
    }
  });

  // Add keyboard event listener for "/" key
  document.addEventListener("keydown", function (event) {
    if (event.key === "/" && document.activeElement !== searchInput) {
      event.preventDefault(); // Prevent the "/" character from being typed
      focusSearchInput();
    }
  });
});

