<?php
include_once "config.php";
include_once "header.php";

$sql = "SELECT * from movies";
$getMovies = $conn->prepare($sql);
$getMovies->execute();

$movies = $getMovies->fetchAll();
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

        <a href="addMovie.php">Add new movie</a>

        <table class="mb-5 table table-bordered">
            <thead>
                <th>ID</th>
                <th>Movie Name</th>
                <th>Movie Description</th>
                <th>Movie Quality</th>
                <th>Movie Rating</th>
                <th>Action</th>
            </thead>
            <tbody>
                <?php
                foreach ($movies as $movie) {
                ?> <tr>
                        <td><?php echo $movie['id'] ?></td>
                        <td><?php echo $movie['movie_name'] ?></td>
                        <td><?php echo $movie['movie_desc'] ?></td>
                        <td><?php echo $movie['movie_quality'] ?></td>
                        <td><?php echo $movie['movie_rating'] ?></td>
                        <td><a href="deleteMovie.php?id=<?php echo $movie['id'] ?>">Delete</a> | <a href="movieEdit.php?id=<?php echo $movie['id'] ?>">Update</a></td>

                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>


<?php
include_once "footer.php";
?>