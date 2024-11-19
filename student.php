<?php session_start();
require 'database.php'; // Your database connection file

$user_id = $_SESSION['user_id']; // Logged-in user ID from session

$query = "
    SELECT 
        forms.id, forms.date_submitted, clubs.club_name, forms.activity_name, 
        forms.form_type, forms.status, forms.date_approved_rejected, forms.reason
    FROM 
        club_memberships
    INNER JOIN 
        clubs ON club_memberships.club_id = clubs.club_id
    INNER JOIN 
        forms ON forms.club_id = clubs.club_id
    WHERE 
        club_memberships.user_id = ?
    ORDER BY 
        forms.date_submitted DESC;
";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$forms = [];
while ($row = $result->fetch_assoc()) {
    $forms[] = $row;
}
?>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Date Submitted</th>
            <th>Club Name</th>
            <th>Activity</th>
            <th>Form Type</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($forms as $form): ?>
            <tr>
                <td><?= $form['date_submitted'] ?></td>
                <td><?= $form['club_name'] ?></td>
                <td><?= $form['activity_name'] ?></td>
                <td><?= $form['form_type'] ?></td>
                <td>
                    <?php if ($form['status'] === 'Approved'): ?>
                        <span class="badge bg-success">Approved</span>
                        <br>Date Approved: <?= $form['date_approved_rejected'] ?>
                    <?php elseif ($form['status'] === 'Pending'): ?>
                        <span class="badge bg-warning">Pending</span>
                    <?php elseif ($form['status'] === 'Rejected'): ?>
                        <span class="badge bg-danger">Rejected</span>
                        <br><a href="view_reason.php?id=<?= $form['id'] ?>" class="btn btn-sm btn-danger">View Reason</a>
                    <?php endif; ?>
                </td>
                <td>
                    <a href="view_form.php?id=<?= $form['id'] ?>" class="btn btn-sm btn-primary">View</a>
                    <?php if ($form['status'] === 'Pending'): ?>
                        <a href="edit_form.php?id=<?= $form['id'] ?>" class="btn btn-sm btn-secondary">Edit</a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>