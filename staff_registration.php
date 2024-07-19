<?php
require_once "./includes/connection_DB.php";

// Variables
$staffPhoto = $staffName = $staffQualification = $staffExperience = $staffMobile = $staffSubject = $staffEmail = $staffAddress = $staffDOJ = $staffDesc = $displayType = $subjectName = "";

// Error variables
$photoErr = $nameErr = $qualificationErr = $experienceErr = $mobileErr = $subjectErr = $emailErr = $addressErr = $dojErr = $descErr = $duplicateEntryError = "";

// Update variables
$update_id = isset($_REQUEST['update_id']) ? $_REQUEST['update_id'] : "";
$update_photo = $update_name = $update_Qualification = $update_experience = $update_mobile = $update_subject = $update_email = $update_address = $update_doj = $update_desc = $update_display_type = "";
// table creation
$createTableQuery = "CREATE TABLE IF NOT EXISTS staff (
    id INT AUTO_INCREMENT PRIMARY KEY,
    photo VARCHAR(255),
    name VARCHAR(255) NOT NULL,
    qualification VARCHAR(255) NOT NULL,
    experience INT NOT NULL,
    mobile VARCHAR(255) NOT NULL,
    subject VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    address VARCHAR(255) NOT NULL,
    doj DATE NOT NULL,
    description VARCHAR(255) NOT NULL,
    display_type VARCHAR(255))";
if (mysqli_query($conn, $createTableQuery)) {
    $msg = "Table checked/created successfully.";
} else {
    echo "Error creating table: " . mysqli_error($conn);
}

// Fetching data from POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $update_id = isset($_POST['update_id']) ? $_POST['update_id'] : "";
    $staffPhoto = isset($_FILES['staffPhoto']['name']) ? $_FILES['staffPhoto']['name'] : "";
    $staffName = isset($_POST['staffName']) ? $_POST['staffName'] : "";
    $staffQualification = isset($_POST['staffQualification']) ? $_POST['staffQualification'] : "";
    $staffExperience = isset($_POST['staffExperience']) ? $_POST['staffExperience'] : "";
    $staffMobile = isset($_POST['staffMobile']) ? $_POST['staffMobile'] : "";
    $staffSubject = isset($_POST['staffSubject']) ? $_POST['staffSubject'] : "";
    $staffEmail = isset($_POST['staffEmail']) ? $_POST['staffEmail'] : "";
    $staffAddress = isset($_POST['staffAddress']) ? $_POST['staffAddress'] : "";
    $staffDOJ = isset($_POST['staffDOJ']) ? $_POST['staffDOJ'] : "";
    $staffDesc = isset($_POST['staffDesc']) ? $_POST['staffDesc'] : "";
    $displayType = isset($_POST['displayType']) ? $_POST['displayType'] : "";
    $subjectName = isset($_POST['subject_select']) ? $_POST['subject_select'] : "";

    // Validation
    $isValid = true;

    if (!preg_match("/^[a-zA-Z ]*$/", $staffName)) {
        $nameErr = "Invalid name format";
        $isValid = false;
    }
    if (!preg_match("/^[\w\s!@#$%^&*(),.?\":{}|<>]*$/", $staffQualification)) {
        $qualificationErr = "Invalid qualification format";
        $isValid = false;
    }
    if (!preg_match("/^[0-9]+$/", $staffExperience)) {
        $experienceErr = "Invalid experience format";
        $isValid = false;
    }
    if (!preg_match("/^[0-9]{10}$/", $staffMobile)) {
        $mobileErr = "Invalid mobile number format";
        $isValid = false;
    }
    if (!preg_match("/^[a-zA-Z ]*$/", $staffSubject)) {
        $subjectErr = "Invalid subject format";
        $isValid = false;
    }
    if (!filter_var($staffEmail, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format";
        $isValid = false;
    }
    if (!preg_match("/^[a-zA-Z0-9 ,]*$/", $staffAddress)) {
        $addressErr = "Invalid address format";
        $isValid = false;
    }
    if (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $staffDOJ)) {
        $dojErr = "Invalid date of joining format";
        $isValid = false;
    }
    if (!preg_match("/^[a-zA-Z0-9 ,.!?]*$/", $staffDesc)) {
        $descErr = "Invalid description format";
        $isValid = false;
    }
    if (!preg_match("/^[a-zA-Z0-9 ]*$/", $displayType)) {
        $duplicateEntryError = "Invalid display type format";
        $isValid = false;
    }

    if ($isValid) {
        // Handle file upload
        if ($staffPhoto) {
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($staffPhoto);
            move_uploaded_file($_FILES['staffPhoto']['tmp_name'], $target_file);
        }

        if ($update_id) {
            // Update existing record
            $sql = "UPDATE staff SET 
                    photo='$staffPhoto', 
                    name='$staffName', 
                    qualification='$staffQualification', 
                    experience='$staffExperience', 
                    mobile='$staffMobile', 
                    subject='$staffSubject', 
                    email='$staffEmail', 
                    address='$staffAddress', 
                    doj='$staffDOJ', 
                    description='$staffDesc', 
                    display_type='$displayType' 
                    WHERE id='$update_id'";
        } else {
            // Insert new record
            $sql = "INSERT INTO staff (photo, name, qualification, experience, mobile, subject, email, address, doj, description, display_type) VALUES 
                    ('$staffPhoto', '$staffName', '$staffQualification', '$staffExperience', '$staffMobile', '$staffSubject', '$staffEmail', '$staffAddress', '$staffDOJ', '$staffDesc', '$displayType')";
        }

        // Execute query
        if (mysqli_query($conn, $sql)) {
            echo $update_id ? "Record updated successfully" : "New record created successfully";
        } else {
            echo "Error: " . $sql . "" . mysqli_error($conn);
        }

        // Close connection
        mysqli_close($conn);
    }
}

// Fetch existing data if update_id is set
if ($update_id) {
    $result = mysqli_query($conn, "SELECT * FROM staff WHERE id='$update_id'");
    if ($row = mysqli_fetch_assoc($result)) {
        $update_photo = $row['photo'];
        $update_name = $row['name'];
        $update_Qualification = $row['qualification'];
        $update_experience = $row['experience'];
        $update_mobile = $row['mobile'];
        $update_subject = $row['subject'];
        $update_email = $row['email'];
        $update_address = $row['address'];
        $update_doj = $row['doj'];
        $update_desc = $row['description'];
        $update_display_type = $row['display_type'];
    }
}
// Fetch subjects data from subjects table
$sqlSubjects = "SELECT * FROM subjects";
$resultSubjects = mysqli_query($conn, $sqlSubjects);
$subjectOptions = "";

if (mysqli_num_rows($resultSubjects) > 0) {
    while ($row = mysqli_fetch_assoc($resultSubjects)) {
        $selected = ($row['subject_name'] == $subjectName) ? 'selected' : '';
        $subjectOptions .= "<option value='" . $row['subject_name'] . "' $selected>" . $row['subject_name'] . "</option>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Registration Form</title>
    <link rel="stylesheet" href="./CSS/bootstrap.min.css">
    <link rel="stylesheet" href="./CSS/style.css">
</head>

<body>
    <div class="container-md d-flex flex-column align-items-center justify-content-center">
        <h1 class="main-title text-center">Staff Registration Form</h1>
        <form class="w-75" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" enctype="multipart/form-data">
            <input class="form-control" type="hidden" name="update_id" value="<?php echo $update_id; ?>">
            <label for="staffPhoto">Photo:</label>
            <input class="form-control" type="file" name="staffPhoto">
            <span class="alert-danger"><?php echo $photoErr; ?></span>

            <label for="staffName">Name:</label>
            <input class="form-control" type="text" name="staffName" value="<?php echo $update_name; ?>">
            <span class="alert-danger"><?php echo $nameErr; ?></span>

            <label for="staffQualification">Qualification:</label>
            <input class="form-control" type="text" name="staffQualification"
                value="<?php echo $update_Qualification; ?>">
            <span class="alert-danger"><?php echo $qualificationErr; ?></span>

            <label for="staffExperience">Experience:</label>
            <input class="form-control" type="text" name="staffExperience" value="<?php echo $update_experience; ?>">
            <span class="alert-danger"><?php echo $experienceErr; ?></span>

            <label for="staffMobile">Mobile:</label>
            <input class="form-control" type="text" name="staffMobile" value="<?php echo $update_mobile; ?>">
            <span class="alert-danger"><?php echo $mobileErr; ?></span>

            <label for="staffSubject">Subject:</label>
            <select name="subject_select" id="subject-select">
                <option selected value="">Select a Subject</option>
                <?php echo $subjectOptions ?>
            </select>
            <span class="alert-danger"><?php echo $subjectErr; ?></span>

            <label for="staffEmail">Email:</label>
            <input class="form-control" type="email" name="staffEmail" value="<?php echo $update_email; ?>">
            <span class="alert-danger"><?php echo $emailErr; ?></span>

            <label for="staffAddress">Address:</label>
            <input class="form-control" type="text" name="staffAddress" value="<?php echo $update_address; ?>">
            <span class="alert-danger"><?php echo $addressErr; ?></span>

            <label for="staffDOJ">Date of Joining:</label>
            <input class="form-control" type="date" name="staffDOJ" value="<?php echo $update_doj; ?>">
            <span class="alert-danger"><?php echo $dojErr; ?></span>

            <label for="staffDesc">Description:</label>
            <textarea name="staffDesc"><?php echo $update_desc; ?></textarea>
            <span class="alert-danger"><?php echo $descErr; ?></span>

            <label for="displayType">Display Type:</label>
            <select name="displayType" id="display-type">
                <option selected value="">Please Select a Value</option>
                <option value="public">Public</option>
                <option value="private">Private</option>
            </select>
            <input class="form-control" type="hidden" name="display_type" value="<?php echo $update_display_type; ?>">
            <span class="alert-danger"><?php echo $duplicateEntryError; ?></span>
            <input type="submit" class="d-block mx-auto mt-3 btn btn-danger" name="submit" value="Register">
        </form>
    </div>
</body>

</html>