<?php

session_start();
if ($_SESSION['role'] !== 'client') {
    header('Location: login.php');
    exit();
}
include '../database.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Forms</title>
    <link
        rel="stylesheet"
        href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
</head>

<body>
    <?php include '../includes/clientnavbar.php'; ?>
    <hr>
    <hr>
    <hr>
    <div class="container mt-5">
        <div class="text-center mb-5">
            <h1>Welcome to the Forms Page</h1>
            <p>Access all necessary forms here</p>
        </div>
        <div class="row">
            <!-- Activity Proposal Form -->
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Activity Proposal Form</h5>
                        <p class="card-text">
                            Submit your proposal for activities here.
                        </p>
                        <a
                            href="../activity_proposal_form.php"
                            class="btn btn-primary">Access Form</a>
                    </div>
                </div>
            </div>

            <!-- Parent Consent Form -->
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Parent Consent Form</h5>
                        <p class="card-text">
                            Get parental consent for activity participation.
                        </p>
                        <a
                            href="parent_consent_form."
                            class="btn btn-primary">Access Form</a>
                    </div>
                </div>
            </div>

            <!-- Affidavit of Consent Form -->
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">
                            Affidavit of Consent Form
                        </h5>
                        <p class="card-text">
                            Submit your affidavit of consent for activities.
                        </p>
                        <a
                            href="affidavit_consent_form.html"
                            class="btn btn-primary">Access Form</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</body>
<?php include '../includes/footer.php' ?>

</html>