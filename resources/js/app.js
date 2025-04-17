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

document.addEventListener('DOMContentLoaded', () => {
  const fileInput = document.getElementById('fileInput');
  const submitBtn = document.getElementById('submitBtn');
  const uploadDefault = document.getElementById('uploadDefault');
  const uploadSelected = document.getElementById('uploadSelected');
  const fileNamesInLabel = document.getElementById('fileNamesInLabel');
  const submissionForm = document.getElementById('submission-form');
  const submitButton = submissionForm.querySelector('button[type="submit"]');

  fileInput.addEventListener('change', function () {
    submitBtn.disabled = fileInput.files.length === 0;
  });

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
        li.classList.add('flex', 'items-center', 'justify-between', 'gap-2', 'mb-1');
  
        const fileNameSpan = document.createElement('span');
        fileNameSpan.textContent = file.name;
  
        const removeButton = document.createElement('button');
        removeButton.type = 'button';
        removeButton.classList.add('p-1');
        removeButton.innerHTML = `
          <svg xmlns="http://www.w3.org/2000/svg"
               fill="none"
               viewBox="0 0 24 24"
               stroke-width="1.5"
               stroke="currentColor"
               class="w-5 h-5 text-red-500 hover:text-red-700">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4a1 1 0 011 1v1H9V4a1 1 0 011-1z" />
          </svg>
        `;
  
        // ❗ Penting: cegah label trigger file input
        removeButton.addEventListener('click', (e) => {
          e.preventDefault();
          e.stopPropagation();
          selectedFiles = selectedFiles.filter(f => f.name !== file.name);
          updateFileListUI();
  
          // Kosongkan fileInput agar bisa upload file dengan nama yang sama lagi
          fileInput.value = '';
        });
  
        li.appendChild(fileNameSpan);
        li.appendChild(removeButton);
        fileNamesInLabel.appendChild(li);
      });
    } else {
      uploadDefault.classList.remove('hidden');
      uploadSelected.classList.add('hidden');
    }
  }
  
  submissionForm.addEventListener('submit', function (e) {
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
      .then(async response => {
        const data = await response.json();

        if (!response.ok) {
          throw new Error(data.message || 'Terjadi kesalahan pada server.');
        }

        alert(data.message || 'Tugas berhasil dikumpulkan!');
        window.location.href = data.redirect || window.location.href;
      })
      .catch(error => {
        console.error('Catch error:', error);
        alert(error.message || 'Terjadi kesalahan saat mengupload file.');
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

