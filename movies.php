<?php
include_once "config.php";
include_once "header.php";

$sql = "SELECT * FROM movies";
$getMovies = $conn->prepare($sql);
$getMovies->execute();

$movies = $getMovies->fetchAll();
?>
<div class="d-flex" style="height: 100vh;">
    <div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark" style="width: 280px;">
        <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
            <span class="fs-4">Sidebar</span>
        </a>
        <hr>
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item">
                <a href="dashboard.php" class="nav-link text-white" >Users</a>
            </li>
            <li>
                <a href="movies.php" class="nav-link text-white active" aria-current="page">Movies</a>
            </li>
            <li>
                <a href="bookings.php" class="nav-link text-white" >Booking</a>
            </li>
            <li>
                <a href="logout.php" class="nav-link text-white pt-2" >Logout</a>
            </li>
        </ul>
    </div>

    <div class="p-5">
        <a href="addMovie.php" class="btn btn-primary mb-4">Add New Movie</a>

        <table class="table table-bordered">
            <thead>
                <th>ID</th>
                <th>Image</th>
                <th>Movie Name</th>
                <th>Movie Description</th>
                <th>Movie Quality</th>
                <th>Movie Rating</th>
                <th>Action</th>
            </thead>
            <tbody>
                <?php foreach ($movies as $movie): ?>
                    <tr>
                        <td><?php echo $movie['id']; ?></td>
                        <td>
                            <?php if ($movie['movie_image'] && file_exists($movie['movie_image'])): ?>
                                <img src="<?php echo $movie['movie_image']; ?>" width="100" height="100" style="object-fit: cover;" />
                            <?php else: ?>
                                <span>No Image</span>
                            <?php endif; ?>
                        </td>
                        <td><?php echo htmlspecialchars($movie['movie_name']); ?></td>
                        <td><?php echo htmlspecialchars($movie['movie_desc']); ?></td>
                        <td><?php echo htmlspecialchars($movie['movie_quality']); ?></td>
                        <td><?php echo htmlspecialchars($movie['movie_rating']); ?></td>
                        <td>
                            <a href="deleteMovie.php?id=<?php echo $movie['id']; ?>">Delete</a> | 
                            <a href="movieEdit.php?id=<?php echo $movie['id']; ?>">Update</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include_once "footer.php"; ?>
a