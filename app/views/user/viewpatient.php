<?php require_once '../app/views/templates/header.php'; ?>
<?php require_once '../app/views/templates/aside.php'; ?>

<main>
    <div class="heading">
        <p class="headingName">Register user</p>
    </div>
    <div className="tableContainer">
        <table className="table">
          <thead>
            <tr>
              <th>S.N</th>
              <th>UserId</th>
              <th>Name</th>
              <th>Phone</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>

          <tbody>
            <tr key={index}>
                <td>1</td>
                <td>1000</td>
                <td>Sugam</td>
                <td>9742487088</td>
                <td>Active</td>
                <td>
                    <button><a href="" className="btn btn-primary me-2">Edit</a></button>
                    <button className='btn btn-danger'>Deactivate</button>
                </td>
            </tr>
                 
          </tbody>
        </table>

    </div>


</main>