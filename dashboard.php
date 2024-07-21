<?php
session_start();
require_once "./includes/connection_DB.php";
$errorMsg = "";
// Ensure session variables are set
if (isset($_SESSION["user_name"]) && isset($_SESSION["user_type"])) {
    $user_name = $_SESSION["user_name"];
    $userType = $_SESSION["user_type"];

    echo "<p class='display-4 text-center text-bg-success'>Hello " . $user_name . " welcome 👋</p>";
    echo "<p class='display-6 text-center text-bg-info'>You are logged in as " . $userType . "</p>";

    $sqlResult = "SELECT * FROM messages WHERE card_title = '$user_name'";
    $resultMessage = mysqli_query($conn, $sqlResult);

    $senderName = "";
    $senderMessage = "";
    $createdAt = "";
    $sender = [];
    $message = [];
    $timeStamp = [];

    if (mysqli_num_rows($resultMessage) > 0) {
        while ($row = mysqli_fetch_assoc($resultMessage)) {
            $senderName = $row['sender_name'];
            $senderMessage = $row['sender_message'];
            $createdAt = $row['created_at'];
        }
    } else {
        $errorMsg = "<h2 class='text-bg-danger text-center'>You have no messages!</h2>";
    }

    if (!empty($senderName) && !empty($senderMessage)) {
        $sender = explode(',', $senderName);
        $message = explode(',', $senderMessage);
        $timeStamp = explode(',', $createdAt);
    }
} else {
    // Redirect to login if session variables are not set
    header("Location: login.php");
    exit();
}
?>

<!-- html starts -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Dashboard</title>
    <link rel="stylesheet" href="./CSS/bootstrap.min.css">
    <link rel="stylesheet" href="./CSS/style.css">
</head>

<body>
    <?php include_once ('sidebar.php') ?>
    <!-- marks display area -->
    <div class="container">
        <?php if ($userType == "Admin") { ?>
            <div class='container d-none'></div>
        <?php } else { ?>
            <div id="resultTableContainer" class="table-responsive">
                <?= "<h2 class='text-center display-5'><span class='text-capitalize display-3 text-bg-danger rounded-pill px-5'>{$user_name}'s</span> Dashboard</h2>" ?>
                <table id="resultTable" class="table table-striped table-hover table-bordered">
                    <thead class="table-dark bg-primary">
                        <tr>
                            <th>Sender Name</th>
                            <th>Sender Message</th>
                            <th>Sent On</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php echo $errorMsg ?>
                        <?php if (!empty($sender) && !empty($message)) {
                            for ($i = 0; $i < count($message); $i++) { ?>
                                <tr>
                                    <td><?php echo $sender[$i] ?></td>
                                    <td><?php echo $message[$i] ?></td>
                                    <td><?php echo $timeStamp[$i] ?></td>
                                </tr>
                            <?php }
                        } ?>
                    </tbody>
                </table>
            </div>
        <?php } ?>
    </div>
    <a class="btn btn-outline-danger btn-lg d-block w-25 mt-5 mx-auto" href="logout.php">log out</a>
</body>

</html>