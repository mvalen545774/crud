<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDO CRUD System</title>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php
require 'insert.php';
require 'update.php';
require 'delete.php';
require 'select.php';

$editUser = null;
if (isset($_GET['edit'])) {
    $users_id = $_GET['edit'];
    $stmt = $pdo->prepare("SELECT users.*, orders.product, orders.amount FROM users LEFT JOIN orders ON users.users_id = orders.users_id WHERE users.users_id = ?");
    $stmt->execute([$users_id]);
    $editUser = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<header>
    <span class="logo">CRUD System</span>
</header>

<main>
    <h1 class="page-title">User Management</h1>
    <p class="page-subtitle">Manage users and their orders in one place.</p>

    <div class="grid">

        <!-- Form Card -->
        <div class="card">
            <div class="card-title">
                <span class="dot"></span>
                <?= $editUser ? 'Update User' : 'Add New User' ?>
            </div>

            <form method="POST">
                <?php if ($editUser): ?>
                    <input type="hidden" name="users_id" value="<?= $editUser['users_id'] ?>">
                <?php endif; ?>

                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" value="<?= $editUser['name'] ?? '' ?>" placeholder="Enter full name" required>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" value="<?= $editUser['email'] ?? '' ?>" placeholder="Enter email address" required>
                </div>

                <div class="form-group">
                    <label>Product</label>
                    <input type="text" name="product" value="<?= $editUser['product'] ?? '' ?>" placeholder="Enter product name" required>
                </div>

                <div class="form-group">
                    <label>Amount</label>
                    <input type="number" step="0.01" name="amount" value="<?= $editUser['amount'] ?? '' ?>" placeholder="0.00" required>
                </div>

                <?php if ($editUser): ?>
                    <button type="submit" name="update" class="btn btn-warning">Update User</button>
                <?php else: ?>
                    <button type="submit" name="add" class="btn btn-primary">Add User</button>
                <?php endif; ?>
            </form>
        </div>

        <!-- Table Card -->
        <div class="table-card">
            <div class="table-header">
                <div class="card-title">
                    <span class="dot"></span>
                    User List
                </div>
                <span class="count-badge"><?= count($users) ?> records</span>
            </div>

            <?php if (empty($users)): ?>
                <div class="empty-state">
                    <div class="icon">📭</div>
                    <p>No users yet. Add one to get started!</p>
                </div>
            <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Product</th>
                        <th>Amount</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                    <tr>
                        <td class="id-cell">#<?= $user['users_id'] ?></td>
                        <td class="name-cell"><?= htmlspecialchars($user['name']) ?></td>
                        <td class="email-cell"><?= htmlspecialchars($user['email']) ?></td>
                        <td>
                            <?php if ($user['product']): ?>
                                <span class="product-pill"><?= htmlspecialchars($user['product']) ?></span>
                            <?php else: ?>
                                <span class="null-cell">—</span>
                            <?php endif; ?>
                        </td>
                        <td class="amount-cell">
                            <?php if ($user['amount']): ?>
                                ₱<?= number_format($user['amount'], 2) ?>
                            <?php else: ?>
                                <span class="null-cell">—</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="actions">
                                <a href="?edit=<?= $user['users_id'] ?>" class="action-btn action-edit">Edit</a>
                                <a href="?delete=<?= $user['users_id'] ?>" class="action-btn action-delete" onclick="return confirm('Delete this user?')">Delete</a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php endif; ?>
        </div>

    </div>
</main>

</body>
</html>