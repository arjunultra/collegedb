<?php
require_once "./includes/connection_DB.php";
// Fetch admins data for display
$sqlAdmins = "SELECT * FROM admins";
$resultAdmins = mysqli_query($conn, $sqlAdmins);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Table</title>
    <link rel="stylesheet" href="./CSS/bootstrap.min.css">
    <link rel="stylesheet" href="./CSS/style.css">
</head>

<body>

    <h1 class="main-title text-center">Admin Registration Records</h1>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Mobile</th>
                <th>User Name</th>
                <th>Password</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (mysqli_num_rows($resultAdmins) > 0) {
                while ($row = mysqli_fetch_assoc($resultAdmins)) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['admin_name'] . "</td>";
                    echo "<td>" . $row['admin_mobile'] . "</td>";
                    echo "<td>" . $row['username'] . "</td>";
                    echo "<td>" . $row['password'] . "</td>";
                    echo "<td>
                            <a href='admin_registration.php?update_id=" . $row['id'] . "' class='btn btn-warning'>Update</a>
                            <a href='admin_table.php?delete_id=" . $row['id'] . "' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to delete this record?\");'>Delete</a>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr class='text-bg-danger'><td colspan='7' class='text-center'>No records found</td></tr>";
            }
            ?>
            <?php
            // Delete operation
            if (isset($_GET['delete_id'])) {
                $delete_id = $_GET['delete_id'];
                $sqlDelete = "DELETE FROM admins WHERE id='$delete_id'";
                if (mysqli_query($conn, $sqlDelete)) {
                    echo "<script>
                alert('Record deleted successfully.');
                //  window.location.href = 'admin_table.php';
              </script>";
                } else {
                    echo "Error: " . $sqlDelete . "<br>" . mysqli_error($conn);
                }
            }

            // Close connection
            mysqli_close($conn);
            ?>
        </tbody>
    </table>
    <a class="d-block w-25 mx-auto btn btn-primary text-center" href="admin_registration.php">Go to Registration
        Form</a>
</body>

</html>