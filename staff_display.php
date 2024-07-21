<?php
session_start();

// Check if the session is valid
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // Redirect to login page or show an error message
    header("Location: login.php");
    exit();
}
require_once "./includes/connection_DB.php";
$rows = [];
$sqlListing = "SELECT * FROM staff Where display_type = 'public'";
$resultListing = mysqli_query($conn, $sqlListing);

if (mysqli_num_rows($resultListing) > 0) {
    while ($row = mysqli_fetch_assoc($resultListing)) {
        $rows[] = $row;
    }
}
// print_r($resultListing);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Display</title>
    <link rel="stylesheet" href="./CSS/bootstrap.min.css">
    <link rel="stylesheet" href="./CSS/style.css">
</head>

<body>
    <?php include_once "./sidebar.php" ?>
    <div class="justify-content-center align-items-center d-flex row vh-100">
        <?php
        if (!empty($rows)) {
            foreach ($rows as $row) {
                ?>
                <div class="card" style="width: 18rem; height: auto;">
                    <img id="profile-img" src="./uploads/<?php echo ($row['photo']); ?>" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h3 class="card-title"><?php echo ($row['name']); ?></h3>
                        <p class="card-text"><?php echo ($row['description']); ?></p>
                        <button type="button" class="btn btn-primary show-details-btn" data-bs-toggle="modal"
                            data-bs-target="#exampleModal" data-id="<?php echo ($row['id']); ?>"
                            data-img="./uploads/<?php echo ($row['photo']); ?>" data-title="<?php echo ($row['name']); ?>"
                            data-description="<?php echo ($row['description']); ?>"
                            data-qualification="<?php echo "Qualification: " . ($row['qualification']); ?>"
                            data-subject="<?php echo "Handling Subject - " . ($row['subject']); ?>"
                            data-experience="<?php echo "Experience: " . $row['experience'] . " years"; ?>"
                            data-mobile="<?php echo "Mobile: " . ($row['mobile']); ?>"
                            data-email="<?php echo "Email: " . ($row['email']); ?>"
                            data-address="<?php echo "Address: " . ($row['address']); ?>"
                            data-doj="<?php echo "Date of Joining: " . ($row['doj']); ?>">
                            Show more details
                        </button>
                    </div>
                </div>
            <?php }
        } ?>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-dark" id="exampleModalLabel">Card Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-dark">
                    <h2 id="modal-subject"></h2>
                    <img src="" id="modal-img" class="w-50" alt="...">
                    <h3 id="modal-title"></h3>
                    <p id="modal-description"></p>
                    <p id="modal-qualification"></p>
                    <p id="modal-experience"></p>
                    <p id="modal-mobile"></p>
                    <p id="modal-email"></p>
                    <p id="modal-address"></p>
                    <p id="modal-doj"></p>
                    <p id="display-type"></p>
                    <form action="process_form.php" method="post">
                        <input type="hidden" name="card_id" id="card-id">
                        <input type="hidden" name="card_title" id="card-title">
                        <input type="hidden" name="card_email" id="card-email">
                        <label for="sender-name">Name: <input class="form-control" type="text" name="sender_name"
                                id="sender-name"></label>
                        <label for="sender-message">Message: <input class="form-control" type="text"
                                name="sender_message" id="sender-message"></label>
                        <input class="d-block mx-auto btn btn-primary" name="submit" type="submit" value="Submit">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <script src="./JS/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const exampleModal = document.getElementById('exampleModal');
            exampleModal.addEventListener('show.bs.modal', (event) => {
                const button = event.relatedTarget;
                const id = button.dataset.id;
                const img = button.dataset.img;
                const title = button.dataset.title;
                const description = button.dataset.description;
                const qualification = button.dataset.qualification;
                const subject = button.dataset.subject;
                const experience = button.dataset.experience;
                const mobile = button.dataset.mobile;
                const email = button.dataset.email;
                const address = button.dataset.address;
                const doj = button.dataset.doj;


                const modalImg = exampleModal.querySelector('#modal-img');
                const modalTitle = exampleModal.querySelector('#modal-title');
                const modalDescription = exampleModal.querySelector('#modal-description');
                const modalQualification = exampleModal.querySelector('#modal-qualification');
                const modalSubject = exampleModal.querySelector('#modal-subject');
                const modalExperience = exampleModal.querySelector('#modal-experience');
                const modalMobile = exampleModal.querySelector('#modal-mobile');
                const modalEmail = exampleModal.querySelector('#modal-email');
                const modalAddress = exampleModal.querySelector('#modal-address');
                const modalDoj = exampleModal.querySelector('#modal-doj');
                const cardId = exampleModal.querySelector('#card-id');
                const cardTitle = exampleModal.querySelector('#card-title');
                const cardEmail = exampleModal.querySelector('#card-email');

                modalImg.src = img;
                modalTitle.textContent = title;
                modalDescription.textContent = description;
                modalQualification.textContent = qualification;
                modalSubject.textContent = subject;
                modalExperience.textContent = experience;
                modalMobile.textContent = mobile;
                modalEmail.textContent = email;
                modalAddress.textContent = address;
                modalDoj.textContent = doj;
                cardId.value = id;
                cardTitle.value = title;
                cardEmail.value = email;
            });
        });
    </script>
</body>

</html>