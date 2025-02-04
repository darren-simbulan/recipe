-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 04, 2025 at 04:37 PM
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
-- Database: `user_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `recipe_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `recipe_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `favorites`
--

INSERT INTO `favorites` (`id`, `user_id`, `recipe_id`, `created_at`) VALUES
(0, 1, 4, '2025-02-04 11:11:24'),
(0, 1, 10, '2025-02-04 13:40:06'),
(0, 1, 16, '2025-02-04 14:38:02');

-- --------------------------------------------------------

--
-- Table structure for table `reactions`
--

CREATE TABLE `reactions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `recipe_id` int(11) NOT NULL,
  `reaction_type` enum('like','love','haha','wow','sad','angry') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reactions`
--

INSERT INTO `reactions` (`id`, `user_id`, `recipe_id`, `reaction_type`, `created_at`) VALUES
(1, 1, 10, 'like', '2025-02-04 13:26:35');

-- --------------------------------------------------------

--
-- Table structure for table `recipes`
--

CREATE TABLE `recipes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `ingredients` text NOT NULL,
  `instructions` text NOT NULL,
  `category` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_added` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recipes`
--

INSERT INTO `recipes` (`id`, `user_id`, `title`, `image`, `ingredients`, `instructions`, `category`, `created_at`, `date_added`) VALUES
(13, 1, 'Sisig', 'uploads/sisig.jpg', '1 lb pork belly \r\n\r\n1 whole pork snout + jowls \r\n\r\n1 pig ear \r\n\r\n1/2 c chicken liver\r\n\r\nFor boiling:\r\n\r\n1 c vinegar\r\n\r\n1/2 c soy sauce\r\n\r\n12 garlic cloves (1 head of garlic’s worth) \r\n\r\n2 bay leaves\r\n\r\n1 T salt \r\n\r\n1/2 t peppercorns\r\n\r\n1 - sisig seasoning packet, or:\r\n\r\n1/4 c kalamansi juice\r\n\r\n1/4 c vinegar\r\n\r\n1 t salt\r\n\r\n1/2 t ground pepper\r\n\r\n1 t garlic powder\r\n\r\nI T oil\r\n\r\n10 thai chilis, chopped\r\n\r\n3/4 c chopped shallots (can also use red onion)\r\n\r\n1/4 c mayonnaise\r\n\r\n1 egg, for topping\r\n\r\n1 T butter (optional)', '1. Combine pork belly, face, ears, vinegar, soy sauce in a stock pot. Fill with water until meat is covered.  Add bay leaves, salt, and peppercorns. Bring to a boil then simmer for at least an hour or until meat is no longer tight and tough.\r\n\r\n2. Remove meat from pot and grill for 10 minutes.\r\n\r\n3. Chop pork belly and face meat into 1/4 - 1/2 inch cubes.  Finely chop pig ear pieces.\r\n\r\n4. Mix chopped pork in a bowl and add Thai chilis, kalamansi juice, vinegar, salt, pepper, and garlic powder (or sisig seasoning packet)\r\n\r\n5. In a saute pan over medium heat, add 1 T oil and saute shallots for 1-2 minutes.  Add chicken livers; mash and saute until cooked through.\r\n\r\n6. Add chopped pork (with liquids) to saute pan, saute until meat is hot. Add mayonnaise and combine.\r\n\r\n7. (Optional) Heat a cast iron platter, add 1 T butter, add a serving of sisig and top with a cracked egg while still hot.', 'Ulam', '2025-02-04 14:29:39', '2025-02-04 07:29:39'),
(14, 1, 'Pinakbet', 'uploads/pinakbet.jpg', '200 g pork belly, cut into small pieces\r\n2 tbsp canola oil\r\n1 small pc red onion, chopped\r\n1 tbsp ginger, cut into strips\r\n3 cloves garlic, chopped\r\n3 pcs ripe tomatoes, cubed\r\n2 tbsp shrimp paste (bagoong)\r\n2 cups squash, cubed\r\n1/2 cup water\r\n1 pc Knorr Shrimp Cube\r\n1 bunch sitaw, cut into 2 inch pieces\r\n1 pc small ampalaya, sliced thinly\r\n1 -2 eggplants, sliced\r\n6 -8 pcs okra, sliced', 'Fry pork belly in hot oil until brown and crispy. Drain and set aside.\r\n\r\nUsing the same pan, saute onions, ginger, garlic. Add tomatoes and continue sautéing until soft. Then Add shrimp paste. Mix well.\r\n\r\nAdd squash, water and Knorr Shrimp Cube. Cover and let cook over medium heat for 8 minutes.\r\n\r\nAdd sitaw, ampalaya, eggplants and okra. Mix and cover. Let cook for another 5-8 minutes. Serve warm.', 'Ulam', '2025-02-04 14:31:40', '2025-02-04 07:31:40'),
(15, 1, 'Menudo', 'uploads/menudo.jpg', '1\r\nkg pork tenderloin, cubed\r\n3\r\nmedium potatoes, cubed\r\n2\r\nmedium carrots, cubed\r\n1⁄2\r\ncup raisins\r\n1\r\nmedium red bell pepper, diced\r\n1\r\nmedium green bell pepper, diced\r\n500\r\nml tomato sauce\r\n100\r\ng liver spread (originally, we use fresh pork liver but since it\'s very difficult to find a good liver, I substitute)\r\n1\r\nmedium onion, chopped\r\n2\r\ngarlic cloves, chopped\r\n50\r\ng grated romano cheese (Parmesan is also good)', 'Combine all marinade ingredients. Divide the marinade in halves. Save half. Add pork cubes on the other half with the bay leaf and marinate for at least 30 minutes.\r\nRemove pork from the marinade, drip dry.\r\nSauté garlic and onion, add pork and the unused half of the marinade and bay leaf, simmer uncovered, reduce the liquid to half.\r\nAdd fresh pork liver if you prefer the fresh ingredient, cover and cook.\r\nAdd tomato sauce, liver paste (if this is what you\'re using), carrots, potatoes and raisins, simmer stirring occasionally.\r\nAdd peppers and adjust the seasoning.\r\nAdd the grated cheese, let it melt, stir and distribute evenly. Serve hot.', 'Ulam', '2025-02-04 14:34:02', '2025-02-04 07:34:02'),
(16, 1, 'Kare Kare', 'uploads/kare kare.jpg', '3 lbs oxtail cut in 2 inch slices you an also use tripe or beef slices\r\n▢1 piece small banana flower bud sliced\r\n▢1 bundle pechay or bok choy\r\n▢1 bundle string beans cut into 2 inch slices\r\n▢4 pieces eggplants sliced\r\n▢1 cup ground peanuts\r\n▢1/2 cup peanut butter\r\n▢1/2 cup shrimp paste\r\n▢34 Ounces water about 1 Liter\r\n▢1/2 cup annatto seeds soaked in a cup of water\r\n▢1/2 cup toasted ground rice\r\n▢1 tbsp garlic minced\r\n▢1 piece onion chopped\r\n▢salt and pepper', 'In a large pot, bring the water to a boil\r\nPut in the oxtail followed by the onions and simmer for 2.5 to 3 hrs or until tender (35 minutes if using a pressure cooker)\r\n\r\nOnce the meat is tender, add the ground peanuts, peanut butter, and coloring (water from the annatto seed mixture) and simmer for 5 to 7 minutes\r\nAdd the toasted ground rice and simmer for 5 minutes\r\nOn a separate pan, saute the garlic then add the banana flower, eggplant, and string beans and cook for 5 minutes\r\nTransfer the cooked vegetables to the large pot (where the rest of the ingredients are)\r\nAdd salt and pepper to taste\r\nServe hot with shrimp paste. Enjoy!', 'Ulam', '2025-02-04 14:37:43', '2025-02-04 07:37:43'),
(17, 1, 'Caldereta', 'uploads/caldereta.jpg', '▢2 lbs beef cubed\r\n▢3 pieces garlic cloves crushed and chopped\r\n▢1 piece onion finely chopped\r\n▢2 cups beef broth\r\n▢1 piece red bell pepper sliced\r\n▢1 piece green bell pepper sliced\r\n▢1 cup tomato sauce\r\n▢½ cup liver spread processed using blender\r\n▢1 teaspoon chili flakes\r\n▢3 pieces dried bay leaves\r\n▢2 cups potatoes sliced\r\n▢2 cups carrots sliced\r\n▢1/4 cup cooking oil\r\n▢⅔ cup green olives\r\n▢salt and pepper to taste', 'Heat the cooking oil in the cooking pot or pressure cooker.\r\n1/4 cup cooking oil\r\nSauté the onion and garlic.\r\n1 piece onion, 3 pieces garlic cloves\r\nAdd the beef. Cook for 5 minutes or until the color turns light brown.\r\n2 lbs beef\r\nAdd the dried bay leaves and chili flakes or crushed pepper. Stir.\r\n3 pieces dried bay leaves, 1 teaspoon chili flakes\r\nAdd the liver spread. Stir.\r\n½ cup liver spread\r\nPour-in the tomato sauce and beef broth.\r\n1 cup tomato sauce, 2 cups beef broth\r\nCook the beef until it becomes tender (about 30 mins if using a pressure cooker, or 1 to 2 hours if using an ordinary pot).\r\nAdd potato and carrots. Cook for 8 to 10 minutes.\r\n2 cups potatoes, 2 cups carrots\r\nPut the green olives and bell peppers in the cooking pot. Stir and continue to cook for 5 minutes more.\r\n1 piece red bell pepper, ⅔ cup green olives, 1 piece green bell pepper\r\nAdd salt and pepper to taste\r\nsalt and pepper to taste', 'Ulam', '2025-02-04 14:41:30', '2025-02-04 07:41:30'),
(18, 1, 'Sinigang', 'uploads/sinigang.jpg', '4¼ cups water\r\n2 cups pork spare rib cut into chunks\r\n1 pc red onion, quartered\r\n2 pcs medium sized tomato, quartered\r\n8 pcs sitaw, sliced into 2” pieces\r\n250 g kangkong stalk and leaves\r\n1 pc talong, sliced\r\n2 pcs siling pangsigang\r\n1 (20g) pack Knorr Sinigang sa Sampalok Mix Original\r\nOptional: labanos, okra', 'Begin by washing pork spare ribs in cold running water to remove any visible impurities. Then, place pork ribs submerge in a medium pot with a liter of water. Bring to a boil without covering the pot and allow the scum to float to the surface. Meticulously remove the scums from the surface of the water using a slotted spoon or a spatula. Scums are impurities found in meat.\r\n\r\nAfter the broth clears up, turn you heat to medium setting, then it’s time toss in your onions and tomatoes to add flavor to the broth. Cover your pot and let it simmer to fully cook your meat. Use a fork to pierce the meat so that the flavors would also enter the meaty parts of the spare ribs, You also do this so you can tell if it’s already set and tender.\r\n\r\nYou can already add your vegetables. Start by adding the sitaw, kangkong stalks and talong into the pot and cook until these turn dark green. If you decide to use labanos and okra, you can also add those at this point. This should take roughly around 2-3 minutes.\r\n\r\nAdd in your siling sigang, kangkong leaves and the Knorr Sinigang sa Sampaloc Mix. Stir and let it simmer. It should be done in about 2-3 minutes.\r\n\r\nAll done! Transfer your Sinigang to a serving bowl. This is a happy treat that warms, soothes and satisfies everyone in the family! Remember to prepare extra servings of rice to enjoy the extra asim kilig taste of this Filipino classic soup. Enjoy!', 'Ulam', '2025-02-04 14:47:16', '2025-02-04 07:47:16');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'admin', '123'),
(6, '123', '123');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `recipe_id` (`recipe_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `reactions`
--
ALTER TABLE `reactions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_reaction` (`user_id`,`recipe_id`);

--
-- Indexes for table `recipes`
--
ALTER TABLE `recipes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `reactions`
--
ALTER TABLE `reactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `recipes`
--
ALTER TABLE `recipes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `recipes`
--
ALTER TABLE `recipes`
  ADD CONSTRAINT `recipes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
