<?php require_once '../app/views/templates/header.php'; ?>
<?php require_once '../app/views/templates/aside.php'; ?>

<main>
  <div class="heading">
    <p class="headingName">Register user</p>
  </div>

  <div class="registerUser">
    <div class="container">
      <form action="" >
        <div class="row mb-2">
          <div class="form-group">
            <label>
              Role:
              <a class="text-danger">
                
              </a>
            </label>
            <select
              name="role"
              class="form-control">
              <option value="" disabled> --Select Role-- </option> 
              <?php foreach($data['roles'] as $role): ?>
                <option name="role" value="<?= $role->id; ?>"><?= $role->title; ?></option>
              <?php endforeach; ?>
              <!-- <option value="patient">Patient</option>
              <option value="doctor">Doctor</option> -->
            </select>
          </div>
          <div class="form-group">
            <label>UserID</label>
            <input
              type="text"
              value=""
              class="form-control"
              placeholder="UserID"
              readOnly
            />
          </div>
          <div class="form-group">
            <label>Username</label>
            <input
              type="text"
              value= ""
              class="form-control"
              placeholder="Username"
              readOnly
            />
          </div>
        </div>
        <p class="title">Personal details</p>
        <div class="row mb-2">
          <div class="form-group">
            <label>Full name</label>
            <input
              type="text"
              value=""
              onChange={handleFullNameChange}
              class="form-control"
              placeholder="Fullname"
            />
          </div>
          <div class="form-group">
            <label>DOB</label>
            <input
              type="date"
              class="form-control"
              onChange={handleDobChange}
              placeholder="dob"
            />
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
                {" "}
                --Select Gender--{" "}
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
              class="form-control"
              placeholder="Age"
              readOnly
            />
          </div>
          <div class="form-group">
            <label>
              Blood Group:
              <a class="text-danger">
                
              </a>
            </label>
            <select
              name="bloodGroup"
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
              class="form-control"
              placeholder="Fathername"
            />
            
          </div>
          <div class="form-group">
            <label>Mother name</label>
            <input
              type="text"
              class="form-control"
              placeholder="Mothername"
            />
          </div>
          
            <div class="form-group mb-2">
              <label>Department</label>
              <input
                type="text"
                class="form-control"
                placeholder="Department"
              />
              
            </div>
        </div>
        <label htmlFor="is-minor" class="is-minor">
          <input
            type="checkbox"
            id="is-minor"
            name="isMinor"
          />
          I am a minor
        </label>
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
              class="form-control"
              placeholder="Email"
            />
          </div>
          <div class="form-group">
            <label>Phone</label>
            <input
              type="text"
              class="form-control"
              placeholder="Phone"
            />
          </div>
        </div>
        <p class="title">Address Details</p>
        <p>Permanent Address</p>
        <!-- <a class="text-danger">
          {errors.city?.message && <span> {errors.city?.message}</span>}
        </a> -->
        <div class="row mb-2">
          <div class="form-group">
            <label>Province</label>
            <select
              defaultValue=""
              name="perProvince"
              class="form-control">
              <option value="" disabled>
                {" "}
                -- Select Province --{" "}
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
                {" "}
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
                {" "}
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
            />
          </div>
          <div class="form-group">
            <label>Tole: </label>
            
            <input
              type="text"
              name="perTole"
              class="form-control"
            />
          </div>
        </div>
        <p>Temporary Address</p>
        <div class="row mb-2">
          <div class="form-group">
            <label>Province</label>
            

            <select
              defaultValue=""
              name="perProvince"
              class="form-control">
              <option value="" disabled>
                {" "}
                -- Select Province --{" "}
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
                {" "}
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
                {" "}
                -- Select Municipality --
              </option>
              
            </select>
          </div>
        
          <div class="form-group">
            <label>Ward No: </label>
            
            <input
              type="number"
              name="tempWard"
              class="form-control"
            />
          </div>
          <div class="form-group">
            <label>Tole: </label>
            
            <input
              type="text"
              name="tempTole"
              class="form-control"
            />
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