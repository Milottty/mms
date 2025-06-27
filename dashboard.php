<?php
session_start();
include_once "config.php";
include_once "header.php";
include_once "navbar.php";

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header("Location: user_dashboard.php");
    exit();
}
$sql = "SELECT * FROM users";
$getUsers = $conn->prepare($sql);
$getUsers->execute();
$users = $getUsers->fetchAll();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

?>

<style>
    body {
        background-color: #121212;
        color: white;
    }

    .navbar-dark .navbar-nav .nav-link {
        color: rgba(255, 255, 255, 0.85);
    }

    .navbar-dark .navbar-nav .nav-link:hover {
        color: #fff;
    }

    .table {
        background-color: #1e1e1e;
        color: white;
    }

    .table th,
    .table td {
        color: white;
        vertical-align: middle;
    }

    .dropdown-menu-dark {
        background-color: #333;
    }

    .dropdown-menu-dark .dropdown-item:hover {
        background-color: #dc3545;
    }
</style>

<div class="container mt-5">
    <h1 class="mb-4">Welcome, <?= $_SESSION['username'] ?></h1>
    <div class="table-responsive">
        <table class="table table-bordered table-dark table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= $user['id'] ?></td>
                        <td><?= $user['emri'] ?></td>
                        <td><?= $user['username'] ?></td>
                        <td><?= $user['email'] ?></td>
                        <td>
                            <a href="delete.php?id=<?= $user['id'] ?>" class="text-danger">Delete</a> |
                            <a href="edit.php?id=<?= $user['id'] ?>" class="text-info">Update</a>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>

<?php include_once "footer.php"; ?>
