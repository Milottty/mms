<?php
session_start();

include_once "config.php";
include_once "header.php";

$sql = "SELECT * from users";
$getUsers = $conn->prepare($sql);
$getUsers->execute();

$users = $getUsers->fetchAll();

if(!isset($_SESSION['username'])){
    header("Location: login.php");
}

foreach ($users as $user) {
}


?>
<div class="d-flex" style="height: 100vh;">
    <div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark" style="width: 280px;">
        <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
            <svg class="bi me-2" width="40" height="70">
                <use xlink:href="#bootstrap"></use>
            </svg>
            <span class="fs-4">Sidebar</span>
        </a>
        <hr>
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item">
                <a href="dashboard.php" class="nav-link active" aria-current="page">
                    <svg class="bi me-2" width="16" height="16">
                        <use xlink:href="dashboard.php"></use>
                    </svg>
                    Users
                </a>
            </li>
            <li>
                <a href="movies.php" class="nav-link text-white">
                    <svg class="bi me-2" width="16" height="16">
                        <use xlink:href="movies.php"></use>
                    </svg>
                    Movies
                </a>
            </li>
            <li>
                <a href="bookings.php" class="nav-link text-white">
                    <svg class="bi me-2" width="16" height="16">
                        <use xlink:href="bookings.php"></use>
                    </svg>
                    Booking
                </a>
            </li>
            <li>
                    <a href="logout.php" class="nav-link text-white" onclick="return confirm('Are you sure you want to logout?')">
                        <svg class="bi me-2" width="16" height="16">
                            <use xlink:href="logout.php"></use>
                        </svg>
                        Logout
                    </a>
            </li>
        </ul>
        <hr>
        <div class="dropdown">
            <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="<?php $_SESSION['profile_image'] = $user['profile_image'];?> " alt="" width="32" height="32" class="rounded-circle me-2">
                <strong><?= $_SESSION['username'] ?></strong>
            </a>
            <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                <li><a class="dropdown-item" href="#">New project...</a></li>
                <li><a class="dropdown-item" href="#">Settings</a></li>
                <li><a class="dropdown-item" href="#">Profile</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="#">Sign out</a></li>
            </ul>
        </div>
    </div>
    <div class="p-5">
        <table class="mb-5 table table-bordered">
             <h1>Wellcome, <?= $_SESSION['username'] ?></h1>
            <thead>
                <th>ID</th>
                <th>Name</th>
                <th>Username</th>
                <th>Email</th>
                <th>Action</th>
            </thead>
            <tbody>
                <?php
                foreach ($users as $user) {
                ?> <tr>
                        <td><?php echo $user['id'] ?></td>
                        <td><?php echo $user['emri'] ?></td>
                        <td><?php echo $user['username'] ?></td>
                        <td><?php echo $user['email'] ?></td>
                        <td><a href="delete.php?id=<?php echo $user['id'] ?>">Delete</a> | <a href="edit.php?id=<?php echo $user['id'] ?>">Update</a></td>



                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>













<?php include_once "footer.php"; ?>