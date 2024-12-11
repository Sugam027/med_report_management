<?php require_once '../app/views/templates/header.php'; ?>
<?php require_once '../app/views/templates/aside.php'; ?>

<main>
  <div class="heading">
    <p class="headingName">Register user</p>
  </div>

  <div class="registerUser">
    <div class="container">
      <!-- Display success or error messages -->
      <?php if (!empty($data['success'])): ?>
        <div class="alert alert-success">
          <?= htmlspecialchars($data['success']); ?>
        </div>
      <?php endif; ?>

      <?php if (!empty($data['error'])): ?>
        <div class="alert alert-danger">
          <?= htmlspecialchars($data['error']); ?>
        </div>
      <?php endif; ?>
      <form id="register-form" action="" method="POST">
        <div class="row mb-2">
          <div class="form-group">
            <label>
              Role:
              <a class="text-danger">
                
              </a>
            </label>
            <select
              name="role"
              id="role-select"
              class="form-control">
              <option value="" disabled> --Select Role-- </option> 
              <?php foreach($data['roles'] as $role): ?>
                <option name="role" value="<?= $role->id; ?>"><?= $role->title; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <label>Username</label>
            <input
              type="text"
              name="username"
              class="form-control"
              id="username"
              placeholder="Username"
              readOnly
            >
          </div>
          <div class="form-group">
            <input
              type="hidden"
              id="password"
              name="password"
              class="form-control"
            >
          </div>
        </div>
        <p class="title">Personal details</p>
        <div class="row mb-2">
          <div class="form-group">
            <label>Full name</label>
            <input
              type="text"
              name="full_name"
              value=""
              oninput="handleFullNameChange(this.value)"
              class="form-control"
              placeholder="Fullname"
            >
          </div>
          <div class="form-group">
            <label>DOB</label>
            <input
              type="date"
              name="dob"
              class="form-control"
              oninput="handleDobChange(this.value)"
              placeholder="dob"
            >
          </div>
          <div class="form-group">
            <label>
              Gender:
              <a class="text-danger">
              </a>
            </label>
            <select
              name="gender"
              defaultValue=""
              class="form-control">
              <option value="" disabled>
                --Select Gender--
              </option>
              <option value="male">Male</option>
              <option value="female">Female</option>
              <option value="others">Others</option>
            </select>
          </div>
          <div class="form-group">
            <label>Age</label>
            <input
              type="number"
              id="age"
              name="age"
              class="form-control"
              placeholder="Age"
              readOnly
            >
          </div>
          <div class="form-group">
            <label>
              Blood Group:
              <a class="text-danger">
                
              </a>
            </label>
            <select
              name="blood_group"
              defaultValue=""
              class="form-control">
              <option value="" disabled>
                --Select Blood Group--
              </option>
              <option value="unknown">Unknown</option>
              <option value="A+">A+</option>
              <option value="A-">A-</option>
              <option value="B+">B+</option>
              <option value="B-">B-</option>
              <option value="AB+">AB+</option>
              <option value="AB-">AB-</option>
              <option value="O+">O+</option>
              <option value="O-">O-</option>
            </select>
          </div>
          <div class="form-group">
            <label>Father name</label>
            <input
              type="text"
              name="father_name"
              class="form-control"
              placeholder="Fathername"
            >
            
          </div>
          <div class="form-group">
            <label>Mother name</label>
            <input
              type="text"
              name="mother_name"
              class="form-control"
              placeholder="Mothername"
            >
          </div>
          
        </div>
        <label class="is-minor">
          </label>
          <input
            type="checkbox"
            id="is-minor"
            name="is_minor"
          >
          I am a minor
        <!-- {isMinor ? (
          <p class="title"> Parent's Contact details</p>
        ) : ( -->
          <p class="title">Contact details</p>
        <!-- )} -->
        <div class="row mb-2">
          <div class="form-group">
            <label>Email</label>
            <input
              type="email"
              name="email"
              class="form-control"
              placeholder="Email"
            >
          </div>
          <div class="form-group">
            <label>Phone</label>
            <input
              type="text"
              name="phone"
              class="form-control"
              placeholder="Phone"
            >
          </div>
        </div>
        <div id="doctor-details">
          <p class="title">Doctor details</p>
          <div class="row mb-2">
          <div class="form-group">
              <label>
                Department:
                <a class="text-danger">
                  
                </a>
              </label>
              <select
                name="department"
                defaultValue=""
                class="form-control">
                <option value="" disabled>
                  --Select Blood Group--
                </option>
                <option value="unknown">Unknown</option>
                <option value="A+">A+</option>
                <option value="A-">A-</option>
                <option value="B+">B+</option>
                <option value="B-">B-</option>
                <option value="AB+">AB+</option>
                <option value="AB-">AB-</option>
                <option value="O+">O+</option>
                <option value="O-">O-</option>
              </select>
            </div>
            <div class="form-group">
              <label>License Number:</label>
              <input
                type="text"
                name="license_number"
                class="form-control"
                placeholder="License number"
              >
            </div>
            <div class="form-group">
              <label>No.of Experience</label>
              <input
                type="number"
                id="experience"
                name="experience_years"
                class="form-control"
                placeholder="No. of experience"
              >
            </div>
            
          </div>
        </div>
        <p class="title">Address Details</p>
        <!-- <div class="row mb-2">
          <div class="form-group">
            <label>Province</label>
            <select
              defaultValue=""
              name="perProvince"
              class="form-control">
              <option value="" disabled>
                -- Select Province --
              </option>
              
            </select>
          </div>

          <div class="form-group">
            <label>District</label>
            <select
              defaultValue=""
              name="perDistrict"
              class="form-control">
              <option value="" disabled>
                -- Select District --
              </option>
              
            </select>
          </div>
          <div class="form-group">
            <label>Municipality</label>

            <select
              defaultValue=""
              name="perMunicipality"
              class="form-control">
              <option value="" disabled>
                -- Select Municipality --
              </option>
              
            </select>
          </div>
          <div class="form-group">
            <label>Ward No: </label>
            
            <input
              type="number"
              name="perWard"
              class="form-control"
            >
          </div>
          <div class="form-group">
            <label>Tole: </label>
            
            <input
              type="text"
              name="perTole"
              class="form-control"
            >
          </div>
        </div> -->
        <div class="row mb-2">
          <div class="form-group">
          <label>Permanent Address: </label>
            <input
              type="text"
              name="permanent_address"
              class="form-control"
              placeholder="municipality-ward, district"
            >
          </div>
        
          <div class="form-group">
            <label>Temporary Address: </label>
            <input
              type="text"
              name="temporary_address"
              class="form-control"
              placeholder="municipality-ward, district"
            >
          </div>
        </div>
        <div class="button-group">
          <button type="submit" class="btn btnSubmit">
            Register
          </button>
        </div>
      </form>
    </div>
  </div>
</main>

<script src="../js/index.js"></script>
