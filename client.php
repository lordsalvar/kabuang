<?php
// Start the session and include database connection
session_start();
require 'database.php'; // Update with your database connection file

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    die("You must be logged in to access this page.");
}

$user_id = $_SESSION['user_id']; // Logged-in user ID from session

// Initialize variables
$proposals = [];
$error = "";

// Fetch the club name for the logged-in user
$club_query = "
    SELECT clubs.club_name
    FROM club_memberships
    INNER JOIN clubs ON club_memberships.club_id = clubs.club_id
    WHERE club_memberships.user_id = ?
";
$club_stmt = $conn->prepare($club_query);
$club_stmt->bind_param("i", $user_id);
$club_stmt->execute();
$club_result = $club_stmt->get_result();

if ($club_row = $club_result->fetch_assoc()) {
    $club_name = $club_row['club_name'];

    // Fetch activity proposals for the user's club
    $proposal_query = "
        SELECT 
            proposal_id, club_name, acronym, club_type, designation, 
            activity_title, program_category, activity_date, venue, status
        FROM 
            activity_proposals
        WHERE 
            club_name = ?
        ORDER BY 
            activity_date DESC
    ";
    $proposal_stmt = $conn->prepare($proposal_query);
    $proposal_stmt->bind_param("s", $club_name);
    $proposal_stmt->execute();
    $proposal_result = $proposal_stmt->get_result();

    while ($row = $proposal_result->fetch_assoc()) {
        $proposals[] = $row;
    }
} else {
    $error = "No club found for the logged-in user.";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activity Proposals Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
    <?php include 'includes/clientnavbar.php' ?>
    <div class="container mt-5">
        <h1 class="mb-4">Activity Proposals Dashboard</h1>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php else: ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Activity Title</th>
                        <th>Club Name</th>
                        <th>Program Category</th>
                        <th>Activity Date</th>
                        <th>Venue</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($proposals)): ?>
                        <tr>
                            <td colspan="7" class="text-center">No activity proposals found.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($proposals as $proposal): ?>
                            <tr>
                                <td><?= htmlspecialchars($proposal['activity_title']) ?></td>
                                <td><?= htmlspecialchars($proposal['club_name']) ?></td>
                                <td><?= htmlspecialchars($proposal['program_category']) ?></td>
                                <td><?= htmlspecialchars($proposal['activity_date']) ?></td>
                                <td><?= htmlspecialchars($proposal['venue']) ?></td>
                                <td>
                                    <?php if ($proposal['status'] === 'Approved'): ?>
                                        <span class="badge bg-success">Approved</span>
                                    <?php elseif ($proposal['status'] === 'Pending'): ?>
                                        <span class="badge bg-warning">Pending</span>
                                    <?php elseif ($proposal['status'] === 'Rejected'): ?>
                                        <span class="badge bg-danger">Rejected</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary"><?= htmlspecialchars($proposal['status']) ?></span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="view_proposal.php?id=<?= $proposal['proposal_id'] ?>" class="btn btn-sm btn-primary">View</a>
                                    <?php if ($proposal['status'] === 'Pending'): ?>
                                        <a href="edit_proposal.php?id=<?= $proposal['proposal_id'] ?>" class="btn btn-sm btn-secondary">Edit</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>

</html>