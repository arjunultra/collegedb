<?php
require_once "./includes/connection_DB.php";
// Getting Data from subjects table in srisw
$sql = "SELECT * FROM subjects";
$result = mysqli_query($conn, $sql);




?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Subjects Form Data</title>
    <link rel="stylesheet" href="./CSS/bootstrap.min.css">
    <link rel="stylesheet" href="./CSS/style.css">
</head>

<body>
    <div class="container mt-5">
        <h2>Subjects Form Data</h2>
        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered">
                <thead class="table-dark bg-primary">
                    <tr>
                        <th>ID</th>
                        <th>Subject Code</th>
                        <th>Subject Name</th>
                        <th class="text-center">Function</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($result) == !empty($result)) {
                        // Fetch all data at once and store it in an associative array
                        $allRows = mysqli_fetch_all($result, MYSQLI_ASSOC);

                        // Iterate through each row using a foreach loop
                        foreach ($allRows as $row) { ?>
                            <tr>
                                <td><?php echo $row["id"] ?></td>
                                <td><?php echo $row["subject_code"] ?></td>
                                <td><?php echo $row["subject_name"] ?></td>
                                <td class='d-flex'> <a target="_blank" class="btn btn-outline-primary w-50 me-2"
                                        href="subjects_form.php?update_id=<?php echo $row['id']; ?>">UPDATE</a>
                                    <a class="btn btn-danger w-50"
                                        href="subjects_table.php?delete_id=<?php echo $row['id']; ?>">DELETE</a>
                                </td>
                            </tr>
                        <?php }
                    } else {
                        echo "<tr><td class='bg-danger text-light text-center fw-bold h1' colspan='5'>No results found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
            <?php
            // Delete functionality
            if (isset($_GET['delete_id']) && !empty($_GET['delete_id'])) {
                $delete_id = $_GET['delete_id'];
                $sql = "DELETE FROM subjects WHERE id=$delete_id";
                if (mysqli_query($conn, $sql)) {
                    echo ("<h5 class='d-inline-block p-2 text-center text-danger fw-bold border border-danger'>Record Deleted Successfully</h2>");
                } else {
                    echo "Error deleting record: " . mysqli_error($conn);
                }
            }
            ?>
        </div>
    </div>
    <?php
    mysqli_close($conn);
    ?>
</body>

</html>