<?php 
session_start(); // Must be at the very top before any output
include("header.php"); 
include("dbcon.php"); 
?>

<div class="container" style="margin-top: 30px;">
    <div class="row" style="margin-bottom: 20px;">
        <div class="col-md-6">
            <h2>ALL STUDENTS REPORT</h2>
        </div>
        <div class="col-md-6" style="text-align: right;">
            <?php 
            // Show Add Student, Add Admin, and Logout if admin, otherwise show Admin Login button
            if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
                ?>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">ADD STUDENTS</button>
                <a href="add_admin.php" class="btn btn-secondary">Add New Admin</a>
                <a href="logout.php" class="btn btn-danger">Admin Logout</a>
                <?php
            } else {
                ?>
                <a href="login.php" class="btn btn-warning">Admin Login</a>
                <?php
            }
            ?>
        </div>
    </div>

    <table class="table table-hover table-bordered table-striped">
        <thead> 
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Age</th>
                <?php if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true): ?>
                    <th>Update</th>
                    <th>Delete</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php
            $query = "SELECT * FROM students";
            $result = mysqli_query($connection, $query);

            if (!$result) {
                die("Query Failed: " . mysqli_error($connection));
            } else {
                while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['firstName']; ?></td>
                        <td><?php echo $row['lastName']; ?></td>
                        <td><?php echo $row['age']; ?></td>
                        
                        <!-- Show Update and Delete buttons only to logged-in Admin -->
                        <?php if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true): ?>
                            <td><a href="update_page.php?id=<?php echo $row['id']; ?>" class="btn btn-success">Update</a></td>
                            <td><a href="delete.php?id=<?php echo $row['id']; ?>" class="btn btn-danger">Delete</a></td>
                        <?php endif; ?>
                    </tr>
                    <?php
                }
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Modal (Only functional if admin is logged in and button is visible) -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="insert_data.php" method="post">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Student</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="form-group mb-3">
                <label>First Name</label>
                <input type="text" name="f_name" class="form-control" required>
            </div>
            <div class="form-group mb-3">
                <label>Last Name</label>
                <input type="text" name="l_name" class="form-control" required>
            </div>
            <div class="form-group mb-3">
                <label>Age</label>
                <input type="number" name="age" class="form-control" required>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <input type="submit" class="btn btn-success" name="add_students" value="ADD">
        </div>
      </div>
    </form>
  </div>
</div>

<?php include("footer.php"); ?>