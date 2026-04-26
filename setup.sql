-- setup.sql

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `php_music`
--
CREATE DATABASE IF NOT EXISTS `php_music` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `php_music`;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `artist` text COLLATE utf8mb4_unicode_ci,
  `password_hash` text COLLATE utf8mb4_unicode_ci,
  `last_upload_date` date DEFAULT NULL,
  `daily_upload_count` int(11) DEFAULT 0,
  `verified` varchar(3) COLLATE utf8mb4_unicode_ci DEFAULT 'no',
  `profile_picture` longblob,
  `profile_picture_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


--
-- Table structure for table `music`
--
CREATE TABLE `music` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `file` text COLLATE utf8mb4_unicode_ci,
  `title` text COLLATE utf8mb4_unicode_ci,
  `artist` text COLLATE utf8mb4_unicode_ci,
  `album` text COLLATE utf8mb4_unicode_ci,
  `genre` text COLLATE utf8mb4_unicode_ci,
  `year` int(11) DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `image` longblob,
  `last_modified` int(11) DEFAULT NULL,
  `bitrate` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `music_user_id_idx` (`user_id`),
  KEY `music_artist_idx` (`artist`(255)),
  KEY `music_album_idx` (`album`(255)),
  KEY `music_genre_idx` (`genre`(255)),
  CONSTRAINT `music_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Table structure for table `favorites`
--
CREATE TABLE `favorites` (
  `user_id` int(11) NOT NULL,
  `song_id` int(11) NOT NULL,
  `sort_order` int(11) DEFAULT NULL,
  PRIMARY KEY (`user_id`,`song_id`),
  KEY `fav_user_id_idx` (`user_id`),
  CONSTRAINT `favorites_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `favorites_ibfk_2` FOREIGN KEY (`song_id`) REFERENCES `music` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Table structure for table `playlists`
--
CREATE TABLE `playlists` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `public_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `public_id` (`public_id`),
  KEY `playlists_user_id_idx` (`user_id`),
  CONSTRAINT `playlists_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Table structure for table `playlist_songs`
--
CREATE TABLE `playlist_songs` (
  `playlist_id` int(11) NOT NULL,
  `song_id` int(11) NOT NULL,
  `sort_order` int(11) DEFAULT NULL,
  `added_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`playlist_id`,`song_id`),
  KEY `playlist_songs_playlist_id_idx` (`playlist_id`),
  CONSTRAINT `playlist_songs_ibfk_1` FOREIGN KEY (`playlist_id`) REFERENCES `playlists` (`id`) ON DELETE CASCADE,
  CONSTRAINT `playlist_songs_ibfk_2` FOREIGN KEY (`song_id`) REFERENCES `music` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Table structure for table `history`
--
CREATE TABLE `history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `song_id` int(11) NOT NULL,
  `played_at` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `history_user_id_idx` (`user_id`),
  CONSTRAINT `history_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `history_ibfk_2` FOREIGN KEY (`song_id`) REFERENCES `music` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Table structure for table `play_counts`
--
CREATE TABLE `play_counts` (
  `user_id` int(11) NOT NULL,
  `song_id` int(11) NOT NULL,
  `play_count` int(11) DEFAULT 1,
  `last_played` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`user_id`,`song_id`),
  KEY `play_counts_user_id_idx` (`user_id`),
  CONSTRAINT `play_counts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `play_counts_ibfk_2` FOREIGN KEY (`song_id`) REFERENCES `music` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


--
-- Create initial Music Library user
--
INSERT INTO `users` (`id`, `email`, `artist`, `password_hash`, `verified`) VALUES
(1, 'musiclibrary@mail.com', 'Music Library', '$2y$10$NotARealHashChangeMe12345', 'yes');


COMMIT;
