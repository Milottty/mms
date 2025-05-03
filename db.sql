CREATE TABLE `users`(
    `id` int(255)NOT NULL,
    `emri` varchar(255)NOT NULL,
    `username` varchar(255)NOT NULL,
    `email` varchar(255)NOT NULL,
    `password` varchar(255)NOT NULL,
    `confirm_password` varchar(255)NOT NULL,
    `is_admin` varchar(255)NOT NULL
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


ALTER TABLE `users`
    ADD PRIMARY KEY (`id`);

ALTER TABLE `movies`
    ADD PRIMARY KEY (`id`);

ALTER TABLE `bookings`
    ADD PRIMARY KEY (`id`);


ALTER TABLE `users`
    MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

ALTER TABLE `movies`
    MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

    
ALTER TABLE `bookings`
    MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;