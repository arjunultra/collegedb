<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar</title>
    <link rel="stylesheet" href="./CSS/bootstrap.min.css">
    <link rel="stylesheet" href="./CSS/style.css">
</head>

<body>
    <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions"
        aria-controls="offcanvasWithBothOptions">Menu</button>

    <div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptions"
        aria-labelledby="offcanvasWithBothOptionsLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasWithBothOptionsLabel">Menu</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body d-flex flex-column align-items-center gap-2">
            <div><a class="btn btn-primary d-block" href="admin_registration.php">Admin Registration</a></div>
            <div><a class="btn btn-warning" href="staff_registration.php">Staff Registration Form</a></div>
            <div><a class="btn btn-dark" href="staff_listing">Show Staff List</a></div>
            <div><a class="btn btn-success" href="subjects_form.php">Subjects Creation</a></div>
        </div>
    </div>
    <script src="./JS/bootstrap.bundle.min.js"></script>
</body>

</html>