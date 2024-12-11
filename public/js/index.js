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


