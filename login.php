<?php
session_start();
require_once "./includes/connection_DB.php";
// validation variables
$usernameError = $passwordError = "";
$adminID = $staffID = "";

// post variables
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $isValid = true;
    // Validate admin username
    if (empty($_POST['username'])) {
        $usernameError = "Username cannot be empty.";
        $isValid = false;
    } else {
        if (!preg_match('/^\w{3,15}$/', $username)) {
            $usernameError = "Admin username is invalid.";
            $isValid = false;
            /*
            ^ asserts the start of the string.
        \w matches any word character (equivalent to [a-zA-Z0-9_]).
        {3,15} ensures the length is between 3 and 15 characters.
        $ asserts the end of the string.*/

        }
    }
    // Validate admin password
    if (empty($_POST['password'])) {
        $passwordError = "Password cannot be empty.";
        $isValid = false;
    } else {
        if (!preg_match('/^[1-9A-Za-z]{8,}$/', $password)) {
            $isValid = false;
            $passwordError = "Admin Password Invalid!";
        }
    }
    if ($isValid) {
        $sql = "SELECT id FROM admins WHERE username = '$username' AND password = '$password'";
        $result = mysqli_query($conn, $sql);
        // Check if the query was successful and if it returned at least one row
        if ($result && mysqli_num_rows($result) > 0) {
            // Fetch the first row of the result
            $row = mysqli_fetch_assoc($result);
            $adminID = $row['id'];
        }
    }

    if (!empty($adminID)) {
        $userType = "Admin";
    } else {
        $staffSql = "SELECT id FROM staff WHERE name = '$username'AND mobile = '$password'";
        $staffResult = mysqli_query($conn, $staffSql);
        if (!empty($staffResult)) {
            foreach ($staffResult as $row) {
                $staffID = $row['id'];
            }
        }
    }
    if (!empty($staffID)) {
        $userType = "Staff";
    }
    if (!empty($adminID) || !empty($staffID)) {
        $_SESSION['user_name'] = $username;
        $_SESSION['password'] = $password;
        $_SESSION['user_type'] = $userType;
        header("location: dashboard.php");
    }

}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="./CSS/bootstrap.min.css">
    <link rel="stylesheet" href="./CSS/style.css">
</head>

<body>
    <h1 class="main-title text-center">Login Form</h1>
    <div class="container-xs">
        <form method="POST" class="form w-100 text-center" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
            <input type="hidden" name="update_id" value="<?= $update_id ?>">
            <div class="form-group">
                <label for="username">User Name:</label>
                <input value="<?php echo isset($_POST['username']) ? $_POST['username'] : ""; ?>" type="text"
                    id="username" name="username" class="form-control w-75">
                <span class="error text-bg-danger"><?php echo $usernameError; ?></span>
                <label for="password">Password:</label>
                <input value="<?php echo isset($_POST['password']) ? $_POST['password'] : ""; ?>" type="password"
                    id="password" name="password" class="form-control w-75">
                <span class="text-bg-danger error"><?php echo $passwordError; ?></span>
            </div>
            <div class="d-none alert alert-danger mt-5" id="error-message"></div>
            <button class="btn btn-danger btn-lg mt-5 rounded-pill " type="submit">Login</button>
            <button id="reset-btn" class="btn btn-primary py-2 mt-5 ms-3 rounded-pill " type="button">Forgot
                Password</button>
        </form>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                document.getElementById('reset-btn').addEventListener('click', function () {
                    console.log("button clicked");
                    const errorMessage = document.querySelector("#error-message");
                    let errorMsg = "Contact Admin to regenerate your login password!";
                    errorMessage.innerHTML = `<p>${errorMsg}</p>`;
                    errorMessage.classList.remove('d-none');
                });
            });
        </script>
</body>
<?php mysqli_close($conn); ?>

</html>