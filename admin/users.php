<?php
session_start();
require '../includes/db.php';

if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['admin', 'superadmin', 'moderator'])) {
    header("Location: ../login.php");
    exit();
}

//deleting a user for admin and superadmin
if (isset($_GET['delete']) && in_array($_SESSION['role'], ['admin', 'superadmin'])) {
    $delete_id = $_GET['delete'];
    
    //can not delete oneself
    if ($delete_id != $_SESSION['user_id']) {
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$delete_id]);
    }
    header("Location: users.php");
    exit();}

//updating roles - only for superadmins
if (isset($_POST['update_role']) && $_SESSION['role'] == 'superadmin') {
    $stmt = $pdo->prepare("UPDATE users SET role = ? WHERE id = ?");
    $stmt->execute([$_POST['role'], $_POST['user_id']]);
    header("Location: users.php");
    exit();}
if (isset($_POST['update_role']) && $_SESSION['role'] == 'superadmin') {
    $stmt = $pdo->prepare("UPDATE users SET role = ? WHERE id = ?");
    $stmt->execute([$_POST['role'], $_POST['user_id']]);
    header("Location: users.php");
    exit();}

//getting all users
$stmt = $pdo->prepare("SELECT * FROM users ORDER BY id DESC");
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!--html doc-->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UBUY - Manage Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>



<section id="admin-section">
    <div class="container">

        <a href="index.php" class="back-link">
            <i class="bi bi-arrow-left"></i> Back to Admin Panel
        </a>

        <div class="admin-header">
            <h2><i class="bi bi-people"></i> Manage Users</h2>
        </div>

        <div class="admin-table-box">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Type</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo $user['id']; ?></td>
                            <td><?php echo htmlspecialchars($user['full_name']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td><?php echo ucfirst($user['account_type']); ?></td>
                            <td>
                                <?php if ($_SESSION['role'] == 'superadmin' && $user['id'] != $_SESSION['user_id']): ?>
                                    <form action="users.php" method="POST" style="display:inline;">
                                        <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                        <select name="role" class="role-select" onchange="this.form.submit()">
                                            <option value="user" <?php if($user['role']=='user') echo 'selected'; ?>>User</option>
                                            <option value="moderator"<?php if($user['role']=='moderator') echo 'selected'; ?>>Moderator</option>
                                            <option value="admin" <?php if($user['role']=='admin') echo 'selected'; ?>>Admin</option>
                                            <option value="superadmin" <?php if($user['role']=='superadmin') echo 'selected'; ?>>SuperAdmin</option>
                                        </select>
                                        <input type="hidden" name="update_role" value="1">
                                    </form>
                                <?php else: ?>
                                    <span class="account-badge"><?php echo ucfirst($user['role']); ?></span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if (in_array($_SESSION['role'], ['admin','superadmin']) && $user['id'] != $_SESSION['user_id']): ?>
                                    <a href="users.php?delete=<?php echo $user['id']; ?>"
                                       class="delete-btn"
                                       onclick="return confirm('Delete this user?')">
                                        <i class="bi bi-trash"></i> Delete
                                    </a>
                                <?php else: ?>
                                    <span style="color:#aaa; font-size:0.85rem;">—</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </div>
</section>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="../assets/main.js"></script>
</body>
</html>