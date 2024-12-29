// add multiple prescription in prescription/add pages
document.addEventListener("DOMContentLoaded", function () {
  const prescriptionContainer = document.getElementById("prescriptionContainer");

  let index = 0;

  // Function to create a new prescription field
  function createPrescriptionField(index) {
  return `
      <div class="row prescription-row" data-index="${index}">
          <div class="form-group mb-2">
              <label>Medicine ${index + 1}:</label>
              <input type="text" class="form-control" name="medicines[]" data-index="${index}">
          </div>
          <div class="col-md-6 mb-2">
              <label>Instructions:</label>
              <input type="text" class="form-control" name="instructions[]" data-index="${index}">
          </div>
          <div class="mb-2 button-group">
              <button type="button" class="btn btn-danger subPrescriptionBtn" style="display: none;">-</button>
              <button type="button" class="btn btn-primary addPrescriptionBtn" style="display: none;">+</button>
          </div>
      </div>
  `;
  }

  // Function to initialize the first prescription field
  function initializePrescription() {
    const defaultPrescription = createPrescriptionField(index);
    prescriptionContainer.innerHTML = defaultPrescription;
    updateButtonVisibility();
    index++;
  }

  // Function to update the visibility of buttons based on conditions
  function updateButtonVisibility() {
    const rows = prescriptionContainer.querySelectorAll(".prescription-row");
    rows.forEach((row, i) => {
        const subButton = row.querySelector(".subPrescriptionBtn");
        const addButton = row.querySelector(".addPrescriptionBtn");

        // Show "+" button only for the last row
        addButton.style.display = i === rows.length - 1 ? "inline-block" : "none";

        // Show "-" button for all rows except when there is only one row
        subButton.style.display = rows.length > 1 ? "inline-block" : "none";
    });
  }

  // Function to renumber prescription fields
  function renumberPrescriptions() {
    const rows = prescriptionContainer.querySelectorAll(".prescription-row");
    rows.forEach((row, newIndex) => {
        row.setAttribute("data-index", newIndex);
        row.querySelector("label").textContent = `Medicine ${newIndex + 1}:`;
        row.querySelector("input[name='medicines[]']").setAttribute("data-index", newIndex);
        row.querySelector("input[name='instructions[]']").setAttribute("data-index", newIndex);
    });
  }

  // Event delegation for dynamically created buttons
  prescriptionContainer.addEventListener("click", function (e) {
    // Add new prescription field on "+" button click
    if (e.target.classList.contains("addPrescriptionBtn")) {
        const newPrescription = createPrescriptionField(index);
        prescriptionContainer.insertAdjacentHTML("beforeend", newPrescription);
        index++;
        updateButtonVisibility();
    }

    // Remove prescription field on "-" button click
    if (e.target.classList.contains("subPrescriptionBtn")) {
        const row = e.target.closest(".prescription-row");
        prescriptionContainer.removeChild(row);
        renumberPrescriptions();
        index--;
        updateButtonVisibility();
    }
  });

  // Initialize with one default prescription field
  initializePrescription();
});

// JavaScript for filtering records

document.addEventListener("DOMContentLoaded", function () {
    const filterMenuItems = document.querySelectorAll(".recordsMenu ul li");
    const records = document.querySelectorAll(".records");

    filterMenuItems.forEach((item) => {
        item.addEventListener("click", () => {
            // Remove the active class from all menu items
            filterMenuItems.forEach((menuItem) => menuItem.classList.remove("active"));

            // Add the active class to the clicked menu item
            item.classList.add("active");

            // Get the selected filter
            const filter = item.textContent.trim().toLowerCase();

            // Get the current date
            const currentDate = new Date();
            const today = currentDate.toISOString().split("T")[0];
            console.log(today);
            const yesterday = new Date(currentDate);
            yesterday.setDate(currentDate.getDate() - 1);
            const yesterdayDate = yesterday.toISOString().split("T")[0];

            // Define date ranges for filters
            const filters = {
                all: () => true,
                today: (recordDate) => recordDate === today,
                yesterday: (recordDate) => recordDate === yesterdayDate,
                "last week": (recordDate) => {
                    const lastWeek = new Date(currentDate);
                    lastWeek.setDate(currentDate.getDate() - 7);
                    return new Date(recordDate) >= lastWeek && new Date(recordDate) <= currentDate;
                },
                "last month": (recordDate) => {
                    const lastMonth = new Date(currentDate);
                    lastMonth.setMonth(currentDate.getMonth() - 1);
                    return new Date(recordDate) >= lastMonth && new Date(recordDate) <= currentDate;
                },
                "last year": (recordDate) => {
                    const lastYear = new Date(currentDate);
                    lastYear.setFullYear(currentDate.getFullYear() - 1);
                    return new Date(recordDate) >= lastYear && new Date(recordDate) <= currentDate;
                }
            };

            // Filter the records
            records.forEach((record) => {
                const recordDate = record.querySelector(".date .day").textContent.trim().replace(/\s+/g, "-");
                const showRecord = filters[filter] ? filters[filter](recordDate) : false;

                // Show or hide the record based on the filter
                record.style.display = showRecord ? "flex" : "none";
            });
        });
    });
});

// replace - of date
// Get all elements with the class 'day'
var dayElements = document.querySelectorAll('.day');

// Iterate through each element and update its text content
dayElements.forEach(function(dayElement) {
    var originalDate = dayElement.textContent.trim();
    var formattedDate = originalDate.replace(/-/g, ' '); // Replace hyphens with spaces
    dayElement.textContent = formattedDate; // Update the content of the element
});

// header (side and show the profileInfo model)
let profileInfo = 'none';
const handleModel = () => {
  const newDisplay = profileInfo === 'block' ? 'none' : 'block';
  profileInfo = newDisplay;
  document.getElementById('profileInfoModel').style.display = profileInfo;
};

const handleOutsideClick = (event) => {
    const profileModel = document.getElementById('profileInfoModel');
    const headerProfile = document.querySelector('.headerProfile');

    if (!profileModel.contains(event.target) && !headerProfile.contains(event.target)) {
        profileInfo = 'none';
        profileModel.style.display = profileInfo;
    }
};

document.addEventListener('mousedown', handleOutsideClick);

document.getElementById('profileInfoModel').style.display = profileInfo;

// Add event listeners for toggling the profile model
document.querySelector('.headerProfile').addEventListener('click', handleModel);
document.querySelector('.changePicture').addEventListener('click', handleModel);
document.querySelector('.editDetails').addEventListener('click', handleModel);
document.querySelector('.userProfile').addEventListener('click', handleModel);

// Cleanup function for removing event listener on page unload
window.onunload = () => {
    document.querySelector('.headerProfile').removeEventListener('click', handleModel);
};

// display session message

document.addEventListener('DOMContentLoaded', () => {
    const sessionMessage = document.getElementById('sessionMessage');
    if (sessionMessage && sessionMessage.innerText.trim() !== "") {
        sessionMessage.style.display = 'block';
        setTimeout(() => {
            sessionMessage.style.display = 'none';
        }, 4000); // Display for 4 seconds
    }
});

// aside component 
document.addEventListener('DOMContentLoaded', function() {
  // Select all parent menu items
  const navItems = document.querySelectorAll('.nav-item');
  
  // Get the current path
  const currentPath = window.location.pathname;
  
  navItems.forEach(item => {
    const link = item.querySelector('a.nav-link');
    
    // Check if the clicked nav-item has a ul element (submenu)
    const submenu = item.querySelector('ul');
    
    // Add event listener for the menu click to show/hide submenu
    item.addEventListener('click', function(e) {
      if (submenu) {
        e.stopPropagation(); // Prevent click from propagating to parent elements
        
        // Toggle the 'active' class to show/hide submenu
        item.classList.toggle('dropdown');
        
        submenu.style.display = submenu.style.display === 'block' ? 'none' : 'block';
        
        // Close other open menus if needed
        navItems.forEach(nav => {
          if (nav !== item) {
            // nav.classList.remove('active');
            const otherSubmenu = nav.querySelector('ul');
            if (otherSubmenu) {
              otherSubmenu.style.display = 'none';
            }
          }
        });
      }
    });

    // Check for the current path for main nav links
    if (link && link.getAttribute('href') === currentPath) {
      item.classList.add('active');
    }

    // Check if any sub-item matches the current path
    const subItems = item.querySelectorAll('.sub-item a');
    subItems.forEach(subLink => {
      if (subLink.getAttribute('href') === currentPath) {
        subLink.classList.add('active'); // Mark sub-item as active
        item.classList.add('active'); // Mark parent nav-item as active
        item.classList.add('dropdown'); // Mark parent nav-item as active
        submenu.style.display = 'block'; // Show the submenu when the sub-item is active
        submenu.classList.add('active'); // Mark parent nav-item as active
      }
    });
  });
});


// change the username based on the input fullname 

let debounceTimer;
function handleFullNameChange(fullname) {
clearTimeout(debounceTimer);

// Set a new timer to delay the username update by 1 second (1000 milliseconds)
    debounceTimer = setTimeout(() => {
    if (fullname) {
        // Generate a random 2-digit number
        let randomNum = Math.floor(Math.random() * 90 + 10); // Random 2-digit number
        let username = generateUsername(fullname, randomNum);

        // Update the username input field
        document.getElementById('username').value = username;
    } else {
        // Clear the username input field if fullname is empty
        document.getElementById('username').value = '';
    }
    }, 1000);

    // Function to generate the username
    function generateUsername(fullname, randomNum) {
    // Remove spaces, convert to lowercase, and append random number
    return fullname.replace(/\s+/g, '').toLowerCase() +'_'+randomNum;
    }
}

// update the age based on the date of birth
function handleDobChange(dob) {
  // Check if dob is valid
  if (dob) {
    const dobDate = new Date(dob);
    const today = new Date();

    // Calculate age
    let age = today.getFullYear() - dobDate.getFullYear();
    const monthDifference = today.getMonth() - dobDate.getMonth();

    // Adjust age if the birthday hasn't occurred yet this year
    if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < dobDate.getDate())) {
      age--;
    }

    // Update the age input field
    document.getElementById('age').value = age;

    // Check or uncheck the minor checkbox based on age
    const isMinorCheckbox = document.getElementById('is-minor');
    isMinorCheckbox.checked = age < 16; // Check if age is less than 16
  } else {
    // Clear the age field and uncheck the checkbox if DOB is empty
    document.getElementById('age').value = '';
    document.getElementById('is-minor').checked = false; // Uncheck the checkbox
  }
} ;

// show doctor detail on role doctor
document.getElementById('role-select').addEventListener('change', function() {
  var role = this.value.toLowerCase();
  var doctorDetails = document.getElementById('doctor-details');
  if (role === '2') {

    doctorDetails.style.display = 'block';
  } else {
    doctorDetails.style.display = 'none';
  }
});

// auto generate password
function generatePassword(length) {
  const charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*";
  let password = "";
  for (let i = 0; i < length; i++) {
    const randomIndex = Math.floor(Math.random() * charset.length);
    password += charset[randomIndex];
  }
  return password;
}

// Assign the generated password to the hidden field
document.addEventListener('DOMContentLoaded', function() {
  const passwordField = document.getElementById('password');
  const generatedPassword = generatePassword(12); // Generate a 12-character password
  passwordField.value = generatedPassword;
  // console.log("Generated Password:", generatedPassword); // For debugging purposes (can be removed in production)
});

// toggle the profile model
document.addEventListener('DOMContentLoaded', function() {
  let profileInfo = 'none';
  const handleModel = () => {
    const newDisplay = profileInfo === 'block' ? 'none' : 'block';
    profileInfo = newDisplay;
    document.getElementById('profileInfoModel').style.display = profileInfo;
};

const handleOutsideClick = (event) => {
    const profileModel = document.getElementById('profileInfoModel');
    const headerProfile = document.querySelector('.headerProfile');

    if (!profileModel.contains(event.target) && !headerProfile.contains(event.target)) {
        profileInfo = 'none';
        profileModel.style.display = profileInfo;
    }
};

document.addEventListener('mousedown', handleOutsideClick);

document.getElementById('profileInfoModel').style.display = profileInfo;

// Add event listeners for toggling the profile model
document.querySelector('.headerProfile').addEventListener('click', handleModel);
document.querySelector('.changePicture').addEventListener('click', handleModel);
document.querySelector('.editDetails').addEventListener('click', handleModel);
document.querySelector('.userProfile').addEventListener('click', handleModel);

// Cleanup function for removing event listener on page unload
// window.onunload = () => {
//     document.querySelector('.headerProfile').removeEventListener('click', handleModel);
// };
});

// manage_sechedule page (can be removed later)
document.addEventListener('DOMContentLoaded', function() {
  const doctorSelect = document.getElementById('doctor');

  // Variable to store typed characters
  let searchBuffer = '';
  let timeoutId;

  // Function to search within the select options
  doctorSelect.addEventListener('keydown', function(event) {
    clearTimeout(timeoutId); // Clear the timeout for resetting the search buffer
    
    // Only process alphanumeric characters
    if (/[a-zA-Z0-9]/.test(event.key)) {
      searchBuffer += event.key.toLowerCase();  // Append the typed character to the buffer
    } else if (event.key === 'Backspace') {
      searchBuffer = searchBuffer.slice(0, -1);  // Remove the last character on backspace
    }

    let found = false;
    for (let i = 0; i < doctorSelect.options.length; i++) {
      const option = doctorSelect.options[i];
      const doctorName = option.text.toLowerCase();

      // Check if the option contains the search term
      if (doctorName.startsWith(searchBuffer) && option.value !== "") {
        option.selected = true;  // Select the matching option
        found = true;
        break;
      }
    }

    // Reset the search buffer after a short delay (e.g., 1.5 seconds)
    timeoutId = setTimeout(() => {
      searchBuffer = '';
    }, 1500);

    // If no match is found, reset to the first option
    if (!found) {
      doctorSelect.selectedIndex = 0;
    }
  });
});






