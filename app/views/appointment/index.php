<?php require_once '../app/views/templates/header.php'; ?>
<?php require_once '../app/views/templates/aside.php'; ?>

<main>
  <div class="heading">
    <p class="headingName">Create Appointment</p>
  </div>

  <div class="registerUser">
    <div class="container">
      <form action="" >
        <div class="row mb-2">
        <div class="form-group">
            <label>Appointment Date:</label>
            <input
              type="date"
              class="form-control"
              onChange={handleDobChange}
              placeholder="dob"
            />
          </div>
          <div class="form-group">
            <label>Appointment Time</label>
            <input
              type="text"
              value=""
              class="form-control"
              placeholder="Appointment Time"
              readOnly
            />
          </div>
          
        </div>
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
            <label>Age</label>
            <input
              type="number"
              class="form-control"
              placeholder="Age"
              readOnly
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
        <div class="form-group">
            <label>Symptoms </label>
            
            <textarea
              type="text"
              name="perTole"
              class="form-control"
            ></textarea>
          </div>
        <div class="row mb-2">
          <div class="form-group">
            <label>Department</label>
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
            <label>Consultant Doctor</label>
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
           
           
          
        </div>
       
        <div class="button-group">
          <button type="submit" class="btn btnSubmit">
            Create
          </button>
        </div>
      </form>
    </div>
  </div>
</main>