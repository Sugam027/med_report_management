<?php require_once '../app/views/templates/header.php'; ?>
<?php require_once '../app/views/templates/aside.php'; ?>

<main>
  <div class="heading titleHead">
    <p class="headingName">Doctor timing</p>
    <!-- <div class="searchBar">
      <img src="../images/search.png" alt="">
      <input type="search" class="form-control" placeholder="Search" />
    </div> -->
    <div class="button-group">
    <a href="/schedule"><p class="btn">Back</p></a>
    </div>
  </div>

  <div class="container">
    <form action="" method="post">
      <div class="form-group">
        <label for="doctor">Search Doctor:</label>
        <input list="doctors" id="doctor" name="doctor_name" class="form-control" placeholder="Type doctor name..." required>
        <datalist id="doctors">
            <?php foreach ($data['doctors'] as $doctor): ?>
                <option value="<?= $doctor['name']; ?>" data-id="<?= $doctor['user_id']; ?>"></option>
            <?php endforeach; ?>
        </datalist>
      </div>
      <div class="form-group">
        <label>Morning shift: </label>
        <div class="form-control d-flex">
          <div>
            <input type="checkbox" name="morning[]" value="sunday" id="mor_sunday">
            <label for="mor_sunday">Sunday</label>
          </div>
          <div>
            <input type="checkbox" name="morning[]" value="monday" id="mor_monday">
            <label for="mor_monday">Monday</label>
          </div>
          <div>
            <input type="checkbox" name="morning[]" value="tuesday" id="mor_tuesday">
            <label for="mor_tuesday">Tuesday</label>
          </div>
          <div>
            <input type="checkbox" name="morning[]" value="wednesday" id="mor_wednesday">
            <label for="mor_wednesday">Wednesday</label>
          </div>
          <div>
            <input type="checkbox" name="morning[]" value="thursday" id="mor_thursday">
            <label for="mor_thursday">Thursday</label>
          </div>
          <div>
            <input type="checkbox" name="morning[]" value="friday" id="mor_friday">
            <label for="mor_friday">Friday</label>
          </div>
          <div>
            <input type="checkbox" name="morning[]" value="saturday" id="mor_saturday">
            <label for="mor_saturday">Saturday</label>
          </div>
        </div>
      </div>

      <div class="form-group">
        <label>Evening shift: </label>
        <div class="form-control d-flex">
          <div>
            <input type="checkbox" name="evening[]" value="sunday" id="eve_nig_sunday">
            <label for="eve_nig_sunday">Sunday</label>
          </div>
          <div>
            <input type="checkbox" name="evening[]" value="monday" id="eve_nig_monday">
            <label for="eve_nig_monday">Monday</label>
          </div>
          <div>
            <input type="checkbox" name="evening[]" value="tuesday" id="eve_nig_tuesday">
            <label for="eve_nig_tuesday">Tuesday</label>
          </div>
          <div>
            <input type="checkbox" name="evening[]" value="wednesday" id="eve_nig_wednesday">
            <label for="eve_nig_wednesday">Wednesday</label>
          </div>
          <div>
            <input type="checkbox" name="evening[]" value="thursday" id="eve_nig_thursday">
            <label for="eve_nig_thursday">Thursday</label>
          </div>
          <div>
            <input type="checkbox" name="evening[]" value="friday" id="eve_nig_friday">
            <label for="eve_nig_friday">Friday</label>
          </div>
          <div>
            <input type="checkbox" name="evening[]" value="saturday" id="eve_nig_saturday">
            <label for="eve_nig_saturday">Saturday</label>
          </div>
        </div>
      </div>
      <div class="form-group">
        <label>Night shift: </label>
        <div class="form-control d-flex">
          <div>
            <input type="checkbox" name="night[]" value="sunday" id="nig_sunday">
            <label for="nig_sunday">Sunday</label>
          </div>
          <div>
            <input type="checkbox" name="night[]" value="monday" id="nig_monday">
            <label for="nig_monday">Monday</label>
          </div>
          <div>
            <input type="checkbox" name="night[]" value="tuesday" id="nig_tuesday">
            <label for="nig_tuesday">Tuesday</label>
          </div>
          <div>
            <input type="checkbox" name="night[]" value="wednesday" id="nig_wednesday">
            <label for="nig_wednesday">Wednesday</label>
          </div>
          <div>
            <input type="checkbox" name="night[]" value="thursday" id="nig_thursday">
            <label for="nig_thursday">Thursday</label>
          </div>
          <div>
            <input type="checkbox" name="night[]" value="friday" id="nig_friday">
            <label for="nig_friday">Friday</label>
          </div>
          <div>
            <input type="checkbox" name="night[]" value="saturday" id="nig_saturday">
            <label for="nig_saturday">Saturday</label>
          </div>
        </div>
      </div>
      <div class="form-group">
        <label>leave Day: </label>
        <div class="form-control d-flex">
          <div>
            <input type="checkbox" name="leave[]" value="sunday" id="sunday">
            <label for="sunday">Sunday</label>
          </div>
          <div>
            <input type="checkbox" name="leave[]" value="monday" id="monday">
            <label for="monday">Monday</label>
          </div>
          <div>
            <input type="checkbox" name="leave[]" value="tuesday" id="tuesday">
            <label for="tuesday">Tuesday</label>
          </div>
          <div>
            <input type="checkbox" name="leave[]" value="wednesday" id="wednesday">
            <label for="wednesday">Wednesday</label>
          </div>
          <div>
            <input type="checkbox" name="leave[]" value="thursday" id="thursday">
            <label for="thursday">Thursday</label>
          </div>
          <div>
            <input type="checkbox" name="leave[]" value="friday" id="friday">
            <label for="friday">Friday</label>
          </div>
          <div>
            <input type="checkbox" name="leave[]" value="saturday" id="saturday">
            <label for="saturday">Saturday</label>
          </div>
        </div>
      </div>
      <div class="button-group">
        <button type="submit" class="btn btnSubmit">
          Update Schedule
        </button>
      </div>
    </form>
  </div>

      
  
</main>
<?php require_once '../app/views/templates/footer.php'; ?>
