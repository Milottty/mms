<?php
    include_once 'config.php';

    session_start();

    $id = $_GET['id'];

    $sql = "SELECT * FROM users WHERE id=:id";
    $prep = $conn->prepare($sql);
    $prep->bindParam(":id", $id);
    $prep->execute();
    $data = $prep->fetch();

    if (!$data || $data['username'] !== $_SESSION['username']) {
        // Unauthorized access attempt
        header("Location: dashboard.php");
        exit();
}



?>



    <?php  include_once 'header.php'?>
 <div class="d-flex" style="height: 100vh;">

        <div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark" style="width: 280px;">
            <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                <svg class="bi me-2" width="40" height="32">
                    <use xlink:href="#bootstrap"></use>
                </svg>
                <span class="fs-4">Sidebar</span>
            </a>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a href="#" class="nav-link active" aria-current="page">
                        <svg class="bi me-2" width="16" height="16">
                            <use xlink:href="#home"></use>
                        </svg>
                        Home
                    </a>
                </li>
                <li>
                    <a href="#" class="nav-link text-white">
                        <svg class="bi me-2" width="16" height="16">
                            <use xlink:href="#speedometer2"></use>
                        </svg>
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="#" class="nav-link text-white">
                        <svg class="bi me-2" width="16" height="16">
                            <use xlink:href="#table"></use>
                        </svg>
                        Orders
                    </a>
                </li>
                <li>
                    <a href="#" class="nav-link text-white">
                        <svg class="bi me-2" width="16" height="16">
                            <use xlink:href="#grid"></use>
                        </svg>
                        Products
                    </a>
                </li>
                <li>
                    <a href="#" class="nav-link text-white">
                        <svg class="bi me-2" width="16" height="16">
                            <use xlink:href="#people-circle"></use>
                        </svg>
                        Customers
                    </a>
                </li>
                <li>
                    <a href="logout.php" class="nav-link text-white">
                        <svg class="bi me-2" width="16" height="16">
                            <use xlink:href="#people-circle"></use>
                        </svg>
                        Logout
                    </a>
                </li>
            </ul>
            <hr>
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="https://github.com/mdo.png" alt="" width="32" height="32" class="rounded-circle me-2">
                    <strong>mdo</strong>
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

                <tbody>
                <form action="update.php" method="POST">
         <input type="hidden" name="id" value="<?php  echo $data['id']?>" placeholder="Id..."><br><br>
        <input type="text" name="emri" value="<?php  echo $data['emri']?>" placeholder="Name..."><br><br>
        <input type="text" name="username" value="<?php  echo $data['username']?>" placeholder="Username..."><br><br>
        <input type="email" name="email" value="<?php  echo $data['email']?>"placeholder="Email..."><br><br>
        <button type="submit" name="submit">Update</button>
    </form>

                    
        </div>
    </div>
    


<?php include_once 'footer.php' ?>