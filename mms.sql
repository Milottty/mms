-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 25, 2025 at 10:05 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mms`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(255) NOT NULL,
  `user_id` int(255) NOT NULL,
  `movie_id` int(255) NOT NULL,
  `nr_tickets` int(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `time` varchar(255) NOT NULL,
  `cinema` varchar(50) NOT NULL
  FOREIGN KEY (`user_id`) REFERENCES users(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`movie_id`) REFERENCES movies(`id`) ON DELETE CASCADE

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `user_id`, `movie_id`, `nr_tickets`, `date`, `time`, `cinema`) VALUES
(1, 2, 1, 2, '2025-05-15', '00:23', ''),
(2, 1, 3, 2, '2025-04-30', '06:41', 'Cinestar'),
(3, 5, 2, 4, '2025-05-13', '21:51', 'Cinestar');

-- --------------------------------------------------------

--
-- Table structure for table `movies`
--

CREATE TABLE `movies` (
  `id` int(255) NOT NULL,
  `movie_name` varchar(255) NOT NULL,
  `movie_desc` varchar(255) NOT NULL,
  `movie_quality` varchar(255) NOT NULL,
  `movie_rating` varchar(255) NOT NULL,
  `year` int(4) NOT NULL DEFAULT 0,
  `views` int(11) NOT NULL DEFAULT 0,
  `movie_image` varchar(255) NOT NULL,
  `type` varchar(10) DEFAULT 'Movie',
  `movie_url` varchar(255) NOT NULL,
  `cinema` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `movies`
--

INSERT INTO `movies` (`id`, `movie_name`, `movie_desc`, `movie_quality`, `movie_rating`, `year`, `views`, `movie_image`, `type`, `movie_url`, `cinema`) VALUES
(2, 'The Walking Dead', '\"The Walking Dead\" is a post-apocalyptic horror series following a group of survivors navigating a world overrun by zombies.', 'Full HD', '9', 2010, 1202559, 'uploads/TheWalkingDeadPoster.jpg', 'serial', 'https://www.youtube.com/watch?v=R1v0uFms68U', 'Cineplex'),
(3, 'The Fast and the Furious', '\"The Fast and the Furious\"  is an action film that follows Brian O\'Conner, an undercover LAPD officer.', 'Full HD', '8', 2001, 429293, 'uploads/Fast_One_Poster.webp', 'movie', 'https://www.youtube.com/watch?v=L_Cb1OepkY8', 'Cineplex'),
(11, 'The Godfather', 'The aging patriarch of an organized crime dynasty transfers control of his clandestine empire to his reluctant son.', 'HD', '8', 2000, 7759191, 'uploads/download (4).jfif', 'Movie', 'https://www.youtube.com/watch?v=oNA6iInsRVg', 'Cineplex'),
(12, 'The Dark Knight', '\"The Dark Knight\" is a superhero film about Batman (Christian Bale) and his struggle against the Joker (Heath Ledger), a chaotic criminal mastermind who wreaks havoc in Gotham City. The film also explores the complexities of Batman\'s identity and his rela', 'Full HD', '8', 2008, 6256778, 'uploads/MV5BMTMxNTMwODM0NF5BMl5BanBnXkFtZTcwODAyMTk2Mw@@._V1_FMjpg_UX1000_.jpg', 'Movie', 'https://www.youtube.com/watch?v=EXeTwQWrcwY', 'Cineplex'),
(13, 'Gladiator', 'A former Roman General sets out to exact vengeance against the corrupt emperor who murdered his family and sent him into slavery.', 'Full HD', '8', 2000, 5599813, 'uploads/Gladiator_(2000_film_poster).png', 'Movie', 'https://www.youtube.com/watch?v=P5ieIbInFpg', 'Cineplex'),
(14, 'American Psycho', 'A wealthy New York City investment banking executive, Patrick Bateman, hides his alternate psychopathic ego from his co-workers and friends as he delves deeper into his violent, hedonistic fantasies.', 'HD', '7', 2000, 4665217, 'uploads/MV5BNzBjM2I5ZjUtNmIzNy00OGNkLWIwZDMtOTAwYWUwMzA2YjdlXkEyXkFqcGc@._V1_.jpg', 'Movie', 'https://www.youtube.com/watch?v=81mibtQWWBg', 'Cineplex'),
(15, 'Finding Nemo', 'After his son is captured in the Great Barrier Reef and taken to Sydney, a timid clownfish sets out on a journey to bring him home.', 'HD', '8', 2003, 7609208, 'uploads/nemo.jpg', 'Movie', 'https://www.youtube.com/watch?v=9oQ628Seb9w', 'Cineplex'),
(16, 'South Park', 'Follows the misadventures of four irreverent grade-schoolers in the quiet, dysfunctional town of South Park, Colorado.', 'HD', '8', 2025, 7946277, 'uploads/MV5BNTBlMzA3ZTUtODZjNi00NTM0LWExMjMtNjJhYzA3YTkwMWYwXkEyXkFqcGc@._V1_.jpg', 'serial', 'https://www.youtube.com/watch?v=DQS-w_0dVjQ', 'Cineplex'),
(17, 'Naruto', 'Naruto is a Japanese manga series by Masashi Kishimoto, centered around the ninja-training adventures of Naruto Uzumaki, a young boy who dreams of becoming the Hokage, the leader of his village', 'HD', '10', 2002, 5724439, 'uploads/NarutoCoverTankobon1__1_.jpg', 'Movie', 'https://www.youtube.com/watch?v=-G9BqkgZXRA', 'Cineplex'),
(18, 'Culpa Mia', '\"Culpa Mía,\" meaning \"My Fault,\" is a Spanish romantic drama film, and the first installment of a trilogy based on the popular Wattpad story by Mercedes Ron', '4K', '7', 2023, 9631623, 'uploads/0_lFzgk5vmpx11z1aE.jpg', 'Movie', 'https://www.youtube.com/watch?v=3CpKBAPqqM0', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(255) NOT NULL,
  `emri` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `confirm_password` varchar(255) NOT NULL,
  `is_admin` varchar(255) NOT NULL,
  `profile_image` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `theme` varchar(10) DEFAULT 'dark',
  `language` varchar(10) DEFAULT 'en'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `emri`, `username`, `email`, `password`, `confirm_password`, `is_admin`, `profile_image`, `role`, `theme`, `language`) VALUES
(1, '', 'admin', 'admin@gmail.com', '$2y$10$8tC8X/95GiMFungT4gh/EO0gjbKJ/UygKHLM9HC4o7jZzxCnpzrvq', '', '1', '', 'admin', 'dark', 'en'),
(2, 'Milot', 'milot', 'milotymeri09@gmail.com', '$2y$10$HNHkaE.x2wS1kl00jjDeg.1QuHig53v6QWN81CDDtkkE6W4.g51wu', '$2y$10$HNHkaE.x2wS1kl00jjDeg.1QuHig53v6QWN81CDDtkkE6W4.g51wu', '0', 'uploads/1748105302_ghost.webp', 'user', 'dark', 'en'),
(3, 'Lorik', 'lorik', 'lorikymeri24@gmail.com', '$2y$10$Y9rxxyD4x4Fb7igjg5a0p.uhCEUNjD7fTNjKxeiPYJc92Bs5PGW1y', '$2y$10$Y9rxxyD4x4Fb7igjg5a0p.uhCEUNjD7fTNjKxeiPYJc92Bs5PGW1y', '0', 'uploads/1748105437_cute-cat.gif', 'user', 'dark', 'en'),
(4, 'Milot', 'milotymeri', 'milotymeri1@gmail.com', '$2y$10$8CQEvbpMe12vu7n1Hc7DDuF04uXdBCqT6kHYxSqGWBiqdJOptLXcO', '$2y$10$8CQEvbpMe12vu7n1Hc7DDuF04uXdBCqT6kHYxSqGWBiqdJOptLXcO', '0', 'uploads/1748186801_6830de8e63d3e_ghost.webp', 'user', 'dark', 'en'),
(5, 'Vehap', 'vehap', 'vehap@gmail.com', '$2y$10$9Q5cvfh7LgeLb97FUAXW5usg93MYbvV4ERw/4nYOpjDNbbL/SXljC', '$2y$10$9Q5cvfh7LgeLb97FUAXW5usg93MYbvV4ERw/4nYOpjDNbbL/SXljC', '0', 'uploads/1748202404_www.YTS.MX.jpg', 'user', 'dark', 'en');

-- --------------------------------------------------------

--
-- Table structure for table `watchlist`
--

CREATE TABLE `watchlist` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  `watched_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



--
-- Dumping data for table `watchlist`
--

INSERT INTO `watchlist` (`id`, `user_id`, `movie_id`, `watched_at`) VALUES
(1, 4, 11, '2025-05-25 15:45:28'),
(2, 5, 2, '2025-05-25 19:47:21');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `watchlist`
--
ALTER TABLE `watchlist`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `movie_id` (`movie_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `movies`
--
ALTER TABLE `movies`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `watchlist`
--
ALTER TABLE `watchlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `watchlist`
--
ALTER TABLE `watchlist`
  ADD CONSTRAINT `watchlist_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `watchlist_ibfk_2` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

CREATE TABLE `rating` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT NOT NULL,
    `movie_id` INT NOT NULL,
    `rating` TINYINT NOT NULL CHECK (rating BETWEEN 1 AND 5),
    `date_rated` DATETIME DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_rating (`user_id`, `movie_id`),
    FOREIGN KEY (`user_id`) REFERENCES users(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`movie_id`) REFERENCES movies(`id`) ON DELETE CASCADE
);