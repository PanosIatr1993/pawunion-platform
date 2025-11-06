-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Εξυπηρετητής: 127.0.0.1
-- Χρόνος δημιουργίας: 07 Απρ 2025 στις 16:11:32
-- Έκδοση διακομιστή: 10.4.32-MariaDB
-- Έκδοση PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Βάση δεδομένων: `pawunion_db`
--
CREATE DATABASE IF NOT EXISTS `pawunion_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `pawunion_db`;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `breeds`
--

DROP TABLE IF EXISTS `breeds`;
CREATE TABLE `breeds` (
  `breed_id` int(11) NOT NULL,
  `breed_name` varchar(50) NOT NULL,
  `type_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Άδειασμα δεδομένων του πίνακα `breeds`
--

INSERT INTO `breeds` (`breed_id`, `breed_name`, `type_id`) VALUES
(1, 'Affenpinscher', 1),
(2, 'Akita', 1),
(3, 'Alaskan Malamute', 1),
(4, 'American Bulldog', 1),
(5, 'American Cocker Spaniel', 1),
(6, 'American Eskimo Dog', 1),
(7, 'American Pit Bull Terrier', 1),
(8, 'American Staffordshire Terrier', 1),
(9, 'Australian Shepherd', 1),
(10, 'Australian Terrier', 1),
(11, 'Basset Hound', 1),
(12, 'Beagle', 1),
(13, 'Belgian Malinois', 1),
(14, 'Bernese Mountain Dog', 1),
(15, 'Bichon Frise', 1),
(16, 'Bloodhound', 1),
(17, 'Border Collie', 1),
(18, 'Border Terrier', 1),
(19, 'Boston Terrier', 1),
(20, 'Boxer', 1),
(21, 'Brittany Spaniel', 1),
(22, 'Bulldog (English)', 1),
(23, 'Bull Terrier (Miniature & Standard)', 1),
(24, 'Bullmastiff', 1),
(25, 'Cairn Terrier', 1),
(26, 'Cavalier King Charles Spaniel', 1),
(27, 'Chesapeake Bay Retriever', 1),
(28, 'Chihuahua', 1),
(29, 'Chinese Crested', 1),
(30, 'Chow Chow', 1),
(31, 'Cocker Spaniel (English & American)', 1),
(32, 'Collie (Rough & Smooth)', 1),
(33, 'Corgi (Pembroke Welsh)', 1),
(34, 'Dachshund', 1),
(35, 'Dalmatian', 1),
(36, 'Doberman Pinscher', 1),
(37, 'English Setter', 1),
(38, 'English Springer Spaniel', 1),
(39, 'French Bulldog', 1),
(40, 'German Shepherd', 1),
(41, 'German Shorthaired Pointer', 1),
(42, 'Giant Schnauzer', 1),
(43, 'Golden Retriever', 1),
(44, 'Goldendoodle', 1),
(45, 'Great Dane', 1),
(46, 'Great Pyrenees', 1),
(47, 'Greyhound', 1),
(48, 'Havanese', 1),
(49, 'Irish Setter', 1),
(50, 'Irish Terrier', 1),
(51, 'Irish Wolfhound', 1),
(52, 'Italian Greyhound', 1),
(53, 'Jack Russell Terrier', 1),
(54, 'Japanese Chin', 1),
(55, 'Keeshond', 1),
(56, 'King Charles Spaniel', 1),
(57, 'Labrador Retriever', 1),
(58, 'Lhasa Apso', 1),
(59, 'Maltese', 1),
(60, 'Miniature Pinscher', 1),
(61, 'Miniature Schnauzer', 1),
(62, 'Newfoundland', 1),
(63, 'Norfolk Terrier', 1),
(64, 'Norwegian Elkhound', 1),
(65, 'Nova Scotia Duck Tolling Retriever', 1),
(66, 'Old English Sheepdog', 1),
(67, 'Papillon', 1),
(68, 'Pekingese', 1),
(69, 'Pomeranian', 1),
(70, 'Poodle (Toy, Miniature, Standard)', 1),
(71, 'Portuguese Water Dog', 1),
(72, 'Pug', 1),
(73, 'Rat Terrier', 1),
(74, 'Rhodesian Ridgeback', 1),
(75, 'Rottweiler', 1),
(76, 'Saint Bernard', 1),
(77, 'Samoyed', 1),
(78, 'Schipperke', 1),
(79, 'Scottish Terrier', 1),
(80, 'Shetland Sheepdog', 1),
(81, 'Shiba Inu', 1),
(82, 'Shih Tzu', 1),
(83, 'Siberian Husky', 1),
(84, 'Soft Coated Wheaten Terrier', 1),
(85, 'Staffordshire Bull Terrier', 1),
(86, 'Standard Schnauzer', 1),
(87, 'Tibetan Spaniel', 1),
(88, 'Tibetan Terrier', 1),
(89, 'Toy Fox Terrier', 1),
(90, 'Vizsla', 1),
(91, 'Weimaraner', 1),
(92, 'Welsh Terrier', 1),
(93, 'West Highland White Terrier', 1),
(94, 'Whippet', 1),
(95, 'Wire Fox Terrier', 1),
(96, 'Wirehaired Pointing Griffon', 1),
(97, 'Yorkshire Terrier', 1),
(98, 'Abyssinian', 2),
(99, 'American Bobtail', 2),
(100, 'American Curl', 2),
(101, 'American Shorthair', 2),
(102, 'Balinese', 2),
(103, 'Bengal', 2),
(104, 'Birman', 2),
(105, 'Bombay', 2),
(106, 'British Shorthair', 2),
(107, 'Burmese', 2),
(108, 'Chartreux', 2),
(109, 'Colorpoint Shorthair', 2),
(110, 'Cornish Rex', 2),
(111, 'Devon Rex', 2),
(112, 'Egyptian Mau', 2),
(113, 'European Burmese', 2),
(114, 'Exotic Shorthair', 2),
(115, 'Havana Brown', 2),
(116, 'Himalayan', 2),
(117, 'Japanese Bobtail', 2),
(118, 'Korat', 2),
(119, 'LaPerm', 2),
(120, 'Maine Coon', 2),
(121, 'Manx', 2),
(122, 'Norwegian Forest Cat', 2),
(123, 'Ocicat', 2),
(124, 'Oriental Longhair', 2),
(125, 'Oriental Shorthair', 2),
(126, 'Persian', 2),
(127, 'Ragamuffin', 2),
(128, 'Ragdoll', 2),
(129, 'Russian Blue', 2),
(130, 'Scottish Fold', 2),
(131, 'Selkirk Rex', 2),
(132, 'Siamese', 2),
(133, 'Siberian', 2),
(134, 'Singapura', 2),
(135, 'Snowshoe', 2),
(136, 'Somali', 2),
(137, 'Sphynx', 2),
(138, 'Tonkinese', 2),
(139, 'Turkish Angora', 2),
(140, 'Turkish Van', 2);

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `pets`
--

DROP TABLE IF EXISTS `pets`;
CREATE TABLE `pets` (
  `pet_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `type_id` int(11) NOT NULL,
  `breed_id` int(11) NOT NULL,
  `color` varchar(50) NOT NULL,
  `age` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Άδειασμα δεδομένων του πίνακα `pets`
--

INSERT INTO `pets` (`pet_id`, `user_id`, `name`, `type_id`, `breed_id`, `color`, `age`) VALUES
(13, 2, 'Anja', 2, 116, 'white', 6),
(14, 2, 'John', 1, 18, 'White', 11),
(15, 1, 'Max', 1, 1, 'Black', 4),
(16, 1, 'John', 1, 2, 'Blonde', 4),
(18, 1, 'Rita', 1, 3, 'White and grey', 1),
(19, 1, 'Ben', 1, 4, 'White with a brown spot on the eye', 4),
(20, 1, 'Rania', 2, 98, 'Orange', 4),
(21, 1, 'Rex', 1, 40, 'Brown and black', 5);

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `pet_reports`
--

DROP TABLE IF EXISTS `pet_reports`;
CREATE TABLE `pet_reports` (
  `report_id` int(11) NOT NULL,
  `pet_id` int(11) NOT NULL,
  `report_type` enum('lost','found') NOT NULL,
  `report_status` enum('active','resolved') NOT NULL,
  `region_last_seen` int(11) NOT NULL,
  `priority_level` tinyint(1) NOT NULL DEFAULT 0,
  `priority_reason` enum('Medical','Stolen','Young','Elderly') NOT NULL,
  `image_url` varchar(250) NOT NULL,
  `emotional_note` varchar(150) NOT NULL,
  `emoticon` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Άδειασμα δεδομένων του πίνακα `pet_reports`
--

INSERT INTO `pet_reports` (`report_id`, `pet_id`, `report_type`, `report_status`, `region_last_seen`, `priority_level`, `priority_reason`, `image_url`, `emotional_note`, `emoticon`) VALUES
(6, 13, 'found', 'resolved', 10, 0, '', '/assets/images/pets/1743884757_anja.jfif', '', ''),
(7, 14, 'lost', 'active', 10, 1, 'Elderly', '/assets/images/pets/1743887887_john.jpg', '', '💔'),
(8, 15, 'found', 'resolved', 77, 0, '', '/assets/images/pets/1743961995_max.jpg', 'Please find my Max!', '😢'),
(9, 16, 'lost', 'active', 77, 0, '', '/assets/images/pets/1743962053_john.jpeg', '', ''),
(11, 18, 'lost', 'active', 5, 1, 'Young', '/assets/images/pets/1743962209_rita.jpg', '', '😭'),
(12, 19, 'found', 'resolved', 77, 0, '', '/assets/images/pets/1743962264_ben.jfif', 'Little Ben I&#039;m missing you!!!', ''),
(13, 20, 'lost', 'active', 5, 1, 'Medical', '/assets/images/pets/1743962808_rania.jfif', '', ''),
(14, 21, 'lost', 'active', 77, 1, 'Stolen', '/assets/images/pets/1744022417_rex.jfif', 'My little Rex has been stolen. Please keep an eye for him. There will be a huge reward if he&#039;s found!', '🆘');

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `pet_types`
--

DROP TABLE IF EXISTS `pet_types`;
CREATE TABLE `pet_types` (
  `type_id` int(11) NOT NULL,
  `type_name` enum('Dog','Cat','Bird') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Άδειασμα δεδομένων του πίνακα `pet_types`
--

INSERT INTO `pet_types` (`type_id`, `type_name`) VALUES
(1, 'Dog'),
(2, 'Cat');

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `regions`
--

DROP TABLE IF EXISTS `regions`;
CREATE TABLE `regions` (
  `region_id` int(11) NOT NULL,
  `region_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Άδειασμα δεδομένων του πίνακα `regions`
--

INSERT INTO `regions` (`region_id`, `region_name`) VALUES
(1, 'Aegaleo'),
(2, 'Afidnes'),
(3, 'Agia Paraskevi'),
(4, 'Agioi Anargyroi'),
(5, 'Agios Artemios'),
(6, 'Agios Dimitrios'),
(7, 'Agios Nikolaos'),
(8, 'Alimos'),
(9, 'Amerikis Square (Platia Amerikis)'),
(10, 'Ampelokipoi'),
(11, 'Anixi'),
(12, 'Ano Ilisia'),
(13, 'Ano Kypseli'),
(14, 'Ano Petralona'),
(15, 'Argyroupoli'),
(16, 'Artemida'),
(17, 'Asyrmatos'),
(18, 'Attiki'),
(19, 'Chalandri'),
(20, 'Dafni'),
(21, 'Dexameni'),
(22, 'Drapetsona'),
(23, 'Drosia'),
(24, 'Ekali'),
(25, 'Elliniko'),
(26, 'Elonas'),
(27, 'Erythros'),
(28, 'Exarchia'),
(29, 'Filopappou'),
(30, 'Gazi'),
(31, 'Gendarmerie zone'),
(32, 'Gerakas'),
(33, 'Glyfada'),
(34, 'Goudi'),
(35, 'Grammatiko'),
(36, 'Gyzi'),
(37, 'Haïdari'),
(38, 'Ilion'),
(39, 'Ilisia'),
(40, 'Kaisariani'),
(41, 'Kalivia'),
(42, 'Kalivia Thorikou'),
(43, 'Kallithea'),
(44, 'Kalyvia'),
(45, 'Kamatero'),
(46, 'Kapandriti'),
(47, 'Keratea'),
(48, 'Kifisia'),
(49, 'Kolonaki'),
(50, 'Kolonos'),
(51, 'Koropi'),
(52, 'Korydallos'),
(53, 'Koukaki'),
(54, 'Kountouriotika'),
(55, 'Kouvaras'),
(56, 'Kynosargous'),
(57, 'Kypseli'),
(58, 'Lagonisi'),
(59, 'Lambrini'),
(60, 'Lavrio'),
(61, 'Lofos Skouze'),
(62, 'Lykovrysi'),
(63, 'Makrygianni'),
(64, 'Marathonas'),
(65, 'Markopoulo Mesogeas'),
(66, 'Marousi'),
(67, 'Metamorfosi'),
(68, 'Metaxourgeio'),
(69, 'Monastiraki'),
(70, 'Moschato'),
(71, 'Nea Filadelfeia'),
(72, 'Nea Ionia'),
(73, 'Nea Kypseli'),
(74, 'Nea Makri'),
(75, 'Nea Smyrni'),
(76, 'Neapoli'),
(77, 'Neos Kosmos'),
(78, 'Nikaia'),
(79, 'Omonia'),
(80, 'Paiania'),
(81, 'Palaia Fokaia'),
(82, 'Palaio Faliro'),
(83, 'Pangrati'),
(84, 'Panormou'),
(85, 'Papagou'),
(86, 'Patission'),
(87, 'Pefki'),
(88, 'Penteli'),
(89, 'Perama'),
(90, 'Peristeri'),
(91, 'Petroupoli'),
(92, 'Pikermi'),
(93, 'Plaka'),
(94, 'Platia Attikis'),
(95, 'Polygono'),
(96, 'Profitis Ilias'),
(97, 'Proskopon'),
(98, 'Psiri'),
(99, 'Psychiko'),
(100, 'Rafina'),
(101, 'Rouf'),
(102, 'Saronida'),
(103, 'Sepolia'),
(104, 'Spata'),
(105, 'Stamata'),
(106, 'Strefi'),
(107, 'Strefi Hill'),
(108, 'Syntagma'),
(109, 'Tavros'),
(110, 'Thissio'),
(111, 'Tourkovounia'),
(112, 'Varnavas'),
(113, 'Vathi'),
(114, 'Victoria'),
(115, 'Votanikos'),
(116, 'Voula'),
(117, 'Vouliagmeni'),
(118, 'Vrilissia'),
(119, 'Zefyri'),
(120, 'Zografou');

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(250) NOT NULL,
  `location_region` int(11) NOT NULL,
  `phone_number` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Άδειασμα δεδομένων του πίνακα `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `username`, `email`, `password_hash`, `location_region`, `phone_number`) VALUES
(1, 'Panagiotis', 'Iatridis', 'Panosiatr1993', 'panosiatridis1993@gmail.com', '$2y$10$g9V2kl1VSTqDDTE51lC8o.rwwKyG.31bcCyLQ0fLNANNTUo9hdaxW', 77, '6948569600'),
(2, 'Aggeliki', 'Nikoli', 'ag_nikoli', 'ag_nikoli@yahoo.gr', '$2y$10$Aa/22eJLYWfzhqi/e5NJYeygXRcUQhUcFYvgjzixDtFqr.bGqINou', 10, '6983041016'),
(6, 'Ilias', 'Iatridis', 'iliasiatr2006', 'iliasiatr@gmail.com', '$2y$10$OJqeI.NvP12ikm5vMZJGRuQX33zY67s7F6f3jntvg6.2tWs3zn7wu', 83, '6987972194'),
(7, 'Fenia', 'Iatridi', 'Feniatr', 'Fenia@gmail.com', '$2y$10$pHkfofndV4mzSVdmilUL8.gBXaNel.mrYXoLG/Sd8LVLqYYLI1GkW', 5, '6977150959'),
(8, 'Panos', 'Iatras', 'panagiotis1993', 'panosiatridis@outlook.com', '$2y$10$iPjxuBeQBo.riN14F2bpL.zpOWrNS2kqMBNP5OnY5b7wfoTanMHI.', 13, '6948569700');

--
-- Ευρετήρια για άχρηστους πίνακες
--

--
-- Ευρετήρια για πίνακα `breeds`
--
ALTER TABLE `breeds`
  ADD PRIMARY KEY (`breed_id`),
  ADD KEY `type_constraint` (`type_id`);

--
-- Ευρετήρια για πίνακα `pets`
--
ALTER TABLE `pets`
  ADD PRIMARY KEY (`pet_id`),
  ADD KEY `user_constraint` (`user_id`),
  ADD KEY `breed_constraint` (`breed_id`),
  ADD KEY `breed_constraint(1)` (`type_id`);

--
-- Ευρετήρια για πίνακα `pet_reports`
--
ALTER TABLE `pet_reports`
  ADD PRIMARY KEY (`report_id`),
  ADD UNIQUE KEY `image_url` (`image_url`),
  ADD KEY `pet_constraint` (`pet_id`),
  ADD KEY `region_constraint` (`region_last_seen`);

--
-- Ευρετήρια για πίνακα `pet_types`
--
ALTER TABLE `pet_types`
  ADD PRIMARY KEY (`type_id`);

--
-- Ευρετήρια για πίνακα `regions`
--
ALTER TABLE `regions`
  ADD PRIMARY KEY (`region_id`),
  ADD UNIQUE KEY `region_name` (`region_name`);

--
-- Ευρετήρια για πίνακα `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phone_number` (`phone_number`),
  ADD KEY `location_constraint` (`location_region`);

--
-- AUTO_INCREMENT για άχρηστους πίνακες
--

--
-- AUTO_INCREMENT για πίνακα `breeds`
--
ALTER TABLE `breeds`
  MODIFY `breed_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=141;

--
-- AUTO_INCREMENT για πίνακα `pets`
--
ALTER TABLE `pets`
  MODIFY `pet_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT για πίνακα `pet_reports`
--
ALTER TABLE `pet_reports`
  MODIFY `report_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT για πίνακα `pet_types`
--
ALTER TABLE `pet_types`
  MODIFY `type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT για πίνακα `regions`
--
ALTER TABLE `regions`
  MODIFY `region_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT για πίνακα `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Περιορισμοί για άχρηστους πίνακες
--

--
-- Περιορισμοί για πίνακα `breeds`
--
ALTER TABLE `breeds`
  ADD CONSTRAINT `type_constraint` FOREIGN KEY (`type_id`) REFERENCES `pet_types` (`type_id`);

--
-- Περιορισμοί για πίνακα `pets`
--
ALTER TABLE `pets`
  ADD CONSTRAINT `breed_constraint` FOREIGN KEY (`breed_id`) REFERENCES `breeds` (`breed_id`),
  ADD CONSTRAINT `breed_constraint(1)` FOREIGN KEY (`type_id`) REFERENCES `breeds` (`type_id`),
  ADD CONSTRAINT `user_constraint` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Περιορισμοί για πίνακα `pet_reports`
--
ALTER TABLE `pet_reports`
  ADD CONSTRAINT `pet_constraint` FOREIGN KEY (`pet_id`) REFERENCES `pets` (`pet_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `region_constraint` FOREIGN KEY (`region_last_seen`) REFERENCES `regions` (`region_id`);

--
-- Περιορισμοί για πίνακα `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `location_constraint` FOREIGN KEY (`location_region`) REFERENCES `regions` (`region_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
