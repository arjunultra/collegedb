<?php
require_once "./includes/connection_DB.php";
// variables
$adminName = $adminMobile = $username = $password = "";
// Validation variables
$adminNameError = $adminMobileError = $adminUserNameError = $adminPasswordError = $duplicateEntryError = "";

// Update variables
$update_id = isset($_REQUEST['update_id']) ? $_REQUEST['update_id'] : "";
$update_admin_name = "";
$update_admin_mobile = "";
$update_admin_username = "";
$update_admin_password = "";

// Fetch admin data for update if update_id is set
if ($update_id) {
    $query = "SELECT * FROM admins WHERE id='$update_id'";
    $result = mysqli_query($conn, $query);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $update_admin_name = $row['admin_name'];
        $update_admin_mobile = $row['admin_mobile'];
        $update_admin_username = $row['username'];
        $update_admin_password = $row['password'];
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $isValid = true;

    // Validate admin name
    if (empty($_POST['admin_name']) || !preg_match("/^[a-zA-Z ]{3,}$/", $_POST['admin_name'])) {
        $adminNameError = "Admin name cannot be empty and must contain only letters.";
        $isValid = false;
    }


    // Validate admin mobile
    if (empty($_POST['admin_mobile']) || !preg_match("/^[0-9]{10}$/", $_POST['admin_mobile'])) {
        $adminMobileError = "Admin mobile cannot be empty and must contain only numbers.";
        $isValid = false;
    }
    //   Validate Username
    if (empty($_POST['username']) || !preg_match("/^[a-zA-Z0-9!@#$%^&*()_+\-=\[\]{};':\"\\|,.<>\/?]*$/", $_POST['username'])) {
        $usernameError = "Username cannot be empty and must contain only alphanumeric characters and special characters.";
        $isValid = false;
    }

    // Validate password
    if (empty($_POST['password']) || !preg_match("/^.{8,}$/", $_POST['password'])) {
        $passwordError = "Password cannot be empty and must be at least 8 characters long.";
        $isValid = false;
    }

    if ($isValid) {
        $adminName = $_POST['admin_name'];
        $adminMobile = $_POST['admin_mobile'];
        $username = $_POST['username'];
        $password = $_POST['password'];

        if ($update_id) {
            // Update operation
            $sqlUpdate = "UPDATE admins SET admin_name='$adminName', admin_mobile='$adminMobile', username='$username', password='$password' WHERE id='$update_id'";
            if (mysqli_query($conn, $sqlUpdate)) {
                echo "<script>alert('Record updated successfully.');</script>";
            } else {
                echo "Error: " . $sqlUpdate . "<br>" . mysqli_error($conn);
            }
        } else {
            // Check for duplicates before insert
            $checkDuplicate = "SELECT * FROM admins WHERE username='$username'";
            $duplicateResult = mysqli_query($conn, $checkDuplicate);

            if (mysqli_num_rows($duplicateResult) > 0) {
                $duplicateEntryError = "This admin username already exists.";
            } else {
                // Insert operation
                $sqlInsert = "INSERT INTO admins (admin_name, admin_mobile, username, password) VALUES ('$adminName', '$adminMobile', '$username', '$password')";
                if (mysqli_query($conn, $sqlInsert)) {
                    echo "<script>
                            alert('New record created successfully.');
                            setTimeout(function() {
                                window.location.href = 'admin_registration.php';
                            }, 3000);
                          </script>";
                } else {
                    echo "Error: " . $sqlInsert . "<br>" . mysqli_error($conn);
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Registration Form</title>
    <link rel="stylesheet" href="./CSS/bootstrap.min.css">
    <link rel="stylesheet" href="./CSS/style.css">
</head>

<body>
    <?php include_once "./sidebar.php" ?>
    <h1 class="main-title text-center">College Admin Registration</h1>
    <div class="container-sm">
        <form method="POST" class="form w-100 text-center" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
            <input type="hidden" name="update_id" value="<?= $update_id ?>">
            <div class="form-group">
                <label for="admin-name">Admin Name:</label>
                <input value="<?php echo isset($_POST['admin_name']) ? $_POST['admin_name'] : $update_admin_name; ?>"
                    type="text" id="admin-name" name="admin_name" class="form-control">
                <span class="error"><?php echo $adminNameError; ?></span>

                <label for="admin-mobile">Admin Mobile:</label>
                <input
                    value="<?php echo isset($_POST['admin_mobile']) ? $_POST['admin_mobile'] : $update_admin_mobile; ?>"
                    type="text" id="admin-mobile" name="admin_mobile" class="form-control">
                <span class="error"><?php echo $adminMobileError; ?></span>

                <label for="admin-username">Username:</label>
                <input value="<?php echo isset($_POST['username']) ? $_POST['username'] : $update_admin_username; ?>"
                    type="text" id="admin-username" name="username" class="form-control">
                <span class="error"><?php echo $adminUserNameError; ?></span>

                <label for="password"> Password:</label>
                <input value="<?php echo isset($_POST['password']) ? $_POST['password'] : $update_admin_password; ?>"
                    type="password" id="admin-password" name="password" class="form-control">
                <span class="error"><?php echo $adminPasswordError; ?></span>
            </div>
            <br>
            <input class="btn btn-primary" type="submit" value="Submit">
            <a class="btn btn-outline-warning ms-3" href="./admin_table.php">Go to Table</a>
            <br><br>
            <span class="error"><?php echo $duplicateEntryError; ?></span>
        </form>
    </div>
</body>

</html>