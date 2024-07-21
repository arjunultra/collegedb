<?php
require_once "./includes/connection_DB.php";

// Delete record
if (isset($_REQUEST['delete_id'])) {
    $delete_id = $_REQUEST['delete_id'];
    $deleteQuery = "DELETE FROM staff WHERE id='$delete_id'";
    if (mysqli_query($conn, $deleteQuery)) {
        echo "<p class='bg-danger text-light p-3'>Record deleted successfully.</p>";
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
}

// Fetch staff data
$query = "SELECT * FROM staff";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff List</title>
    <link rel="stylesheet" href="./CSS/bootstrap.min.css">
    <link rel="stylesheet" href="./CSS/style.css">
</head>

<body>
    <h1 class="main-title text-center">Staff List</h1>
    <table class="table table-striped table-hover table-bordered">
        <tr>
            <th>ID</th>
            <th>Photo</th>
            <th>Name</th>
            <th>Qualification</th>
            <th>Experience</th>
            <th>Mobile</th>
            <th>Subject</th>
            <th>Email</th>
            <th>Address</th>
            <th>Date of Joining</th>
            <th>Description</th>
            <th>Display Type</th>
            <th>Actions</th>
        </tr>
        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><img src="uploads/<?php echo $row['photo']; ?>" alt="Photo" width="50"></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['qualification']; ?></td>
                    <td><?php echo $row['experience']; ?></td>
                    <td><?php echo $row['mobile']; ?></td>
                    <td><?php echo $row['subject']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['address']; ?></td>
                    <td><?php echo $row['doj']; ?></td>
                    <td><?php echo $row['description']; ?></td>
                    <td><?php echo $row['display_type']; ?></td>
                    <td class="row">
                        <a class="btn btn-outline-primary"
                            href="staff_registration.php?update_id=<?php echo $row['id']; ?>">Update</a>
                        <a class="btn btn-danger" href="staff_registration_table.php?delete_id=<?php echo $row['id']; ?>"
                            onclick="return confirm('Are you sure you want to delete this record?');">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="13">No records found.</td>
            </tr>
        <?php endif; ?>
    </table>
    <a class="btn btn-success d-block mx-auto w-25" href="staff_registration.php">Go to Form</a>
</body>

</html>