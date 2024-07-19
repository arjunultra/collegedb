<?php
require_once "./includes/connection_DB.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cardId = $_POST['card_id'];
    $cardTitle = $_POST['card_title'];
    $cardEmail = $_POST['card_email'];
    $senderName = $_POST['sender_name'];
    $senderMessage = $_POST['sender_message'];
    // Table creation
    $sql = "CREATE TABLE IF NOT EXISTS messages (
        id INT AUTO_INCREMENT PRIMARY KEY,
        card_id INT NOT NULL,
        card_title VARCHAR(255) NOT NULL,
        card_email VARCHAR(255) NOT NULL,
        sender_name VARCHAR(255) NOT NULL,
        sender_message VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";

    if ($conn->query($sql) === TRUE) {
        $msgg = "Table messages created successfully";
    } else {
        echo "Error creating table: " . $conn->error;
    }

    // Insert data into the database
    $sql = "INSERT INTO messages (card_id, card_title, card_email, sender_name, sender_message) VALUES ('$cardId', '$cardTitle', '$cardEmail', '$senderName', '$senderMessage')";
    if ($conn->query($sql) == TRUE) {
        echo "<script>
                            alert('Message sent successfully.');
                            setTimeout(function() {
                                window.location.href = 'staff_display.php';
                            }, 3000);
            </script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }


    $conn->close();
}