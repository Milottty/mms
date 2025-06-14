CREATE TABLE `users`(
    `id` int(255)NOT NULL,
    `emri` varchar(255)NOT NULL,
    `username` varchar(255)NOT NULL,
    `email` varchar(255)NOT NULL,
    `password` varchar(255)NOT NULL,
    `confirm_password` varchar(255)NOT NULL,
    `is_admin` varchar(255)NOT NULL,
    `profile_image` varchar(255)NOT NULL
);

CREATE TABLE `movies`(
    `id` int(255)NOT NULL,
    `movie_name` varchar(255)NOT NULL,
    `movie_desc` varchar(255)NOT NULL,
    `movie_quality` varchar(255)NOT NULL,
    `movie_rating` varchar(255)NOT NULL,
    `movie_image` varchar(255)NOT NULL
 );

CREATE TABLE `bookings`(
    `id` int(255)NOT NULL,
    `user_id` int(255)NOT NULL,
    `movie_id` int(255)NOT NULL,
    `nr_tickets` int(255)NOT NULL,
    `date` varchar(255)NOT NULL,
    `time` varchar(255)NOT NULL
);
CREATE TABLE `watchlist` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NOT NULL,
  `movie_id` INT NOT NULL,
 `watched_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `users`(id),
  FOREIGN KEY (`movie_id`) REFERENCES `movies`(id)
);



CREATE TABLE  `rating` (
    `id` int(255)NOT NULL,
    `user_id` int(255)NOT NULL,
    `movie_id` int(255)NOT NULL,
    `date` varchar(255)NOT NULL,
    `time` varchar(255)NOT NULL
);





ALTER TABLE `users`
    ADD PRIMARY KEY (`id`);

ALTER TABLE `movies`
    ADD PRIMARY KEY (`id`);

ALTER TABLE `bookings`
    ADD PRIMARY KEY (`id`);


ALTER TABLE `rating`
    ADD PRIMARY KEY (`id`);





ALTER TABLE `users`
    MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

ALTER TABLE `movies`
    MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

    
ALTER TABLE `bookings`
    MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

ALTER TABLE `rating`
    MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

ALTER TABLE `movies`
  ADD COLUMN year INT(4) NOT NULL DEFAULT 0 AFTER movie_rating,
  ADD COLUMN views INT(11) NOT NULL DEFAULT 0 AFTER year;


  ALTER TABLE `users` ADD COLUMN role ENUM('admin', 'user') NOT NULL DEFAULT 'user';  

  ALTER TABLE `movies` ADD COLUMN type VARCHAR(10) DEFAULT 'Movie';

ALTER TABLE `movies` ADD COLUMN movie_url VARCHAR(255) NOT NULL;


ALTER TABLE `movies` ADD COLUMN `cinema` VARCHAR(50);

ALTER TABLE `users` ADD COLUMN theme VARCHAR(10) DEFAULT 'dark';
ALTER TABLE `users` ADD COLUMN language VARCHAR(10) DEFAULT 'en';