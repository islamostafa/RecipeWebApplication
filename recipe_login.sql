-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 30, 2023 at 01:34 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `recipe_login`
--

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE `ratings` (
  `recipe_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ratings`
--

INSERT INTO `ratings` (`recipe_id`, `rating`, `user`) VALUES
(1, 5, 17),
(2, 5, 17),
(3, 5, 17),
(4, 1, 17);

-- --------------------------------------------------------

--
-- Table structure for table `recipes`
--

CREATE TABLE `recipes` (
  `recipe_id` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` varchar(255) NOT NULL,
  `Prep_time` varchar(255) NOT NULL,
  `Cook_time` varchar(255) NOT NULL,
  `Rating` int(11) NOT NULL,
  `image_link` varchar(255) NOT NULL,
  `alt_text` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recipes`
--

INSERT INTO `recipes` (`recipe_id`, `Name`, `Description`, `Prep_time`, `Cook_time`, `Rating`, `image_link`, `alt_text`) VALUES
(1, 'Spaghetti Bolognese', 'It consists of spaghetti served with a sauce made from tomatoes, minced beef, garlic, wine and herbs', '30 minutes', '1 to 2 hours', 5, './images/Spaghetti-Bolognese.jpg', 'Image of spaghetti bolognese, served in a bowl, next to some parmesan cheese'),
(2, 'Vegan pancakes', 'Try this vegan fluffy American pancake recipe for a perfect start to the day. Serve these pancakes with fresh berries, maple syrup or chocolate sauce for a really luxurious start to the day.', '30 minutes', '10 to 30 minutes', 3, './images/Vegan-Pancakes.jpg', 'Image of a stack of vegan pancakes, topped with cream, golden syrup and blueberries'),
(3, 'Healthy pizza', 'No yeast required for this easy, healthy pizza, topped with colourful vegetables that\'s ready in 30 minutes.This is a great recipe if you want to feed the kids in a hurry!', '30 minutes', '10 to 30 minutes', 4, './images/Healthy-Pizza.jpg', 'Image of a pizza with vegetables on, next to a pizza cutter'),
(4, 'Couscous salad', 'A nutritious and satisfying vegan couscous salad packed with colour, flavour and texture, from dried cranberries, pistachios and pine nuts.', '30 minutes', '10 minutes', 1, './images/Couscous-Salad.jpg', 'Image of a couscous salad, served in a bowl with a spoon'),
(5, 'Plum clafoutis', 'Halved plums are covered in a light batter and then baked in the oven to make this traditional French dessert. British plums are at their best in September, so make the most of them then and try this simple pud.', '30 minutes', '30 minutes to 1 hour', 5, './images/Plum-Clafoutis.jpg', 'Image of a plum clafoutis served in a baking dish, next to a spoon');

-- --------------------------------------------------------

--
-- Table structure for table `recipe_categories`
--

CREATE TABLE `recipe_categories` (
  `recipe_id` int(11) NOT NULL,
  `Category` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recipe_categories`
--

INSERT INTO `recipe_categories` (`recipe_id`, `Category`) VALUES
(2, 'Breakfast'),
(2, 'Dessert'),
(1, 'Main'),
(1, 'Meat'),
(1, 'Pasta'),
(2, 'Vegan'),
(3, 'Main'),
(3, 'Vegetarian'),
(4, 'Main'),
(4, 'Vegan'),
(5, 'Dessert'),
(5, 'Vegetarian');

-- --------------------------------------------------------

--
-- Table structure for table `recipe_ingredients`
--

CREATE TABLE `recipe_ingredients` (
  `recipe_id` int(11) NOT NULL,
  `Ingredient` varchar(255) NOT NULL,
  `Quantity` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recipe_ingredients`
--

INSERT INTO `recipe_ingredients` (`recipe_id`, `Ingredient`, `Quantity`) VALUES
(1, 'Olive oil', '2 tbsp'),
(1, 'Chopped smoked streaky bacon', '6 rashers'),
(1, 'Chopped onions', '2 large'),
(1, 'Garlic cloves', '3'),
(1, 'Minced beaf', '1kg'),
(1, 'Red wine', '2 large glasses'),
(1, 'Chopped tomatoes', '2x400g cans'),
(1, 'Antipasti marinated mushrooms', '1x290g jar'),
(1, 'Bay leaves', '2 fresh or dried'),
(1, 'Oregano', '1 tsp dried'),
(1, 'Thyme', '1 tsp dried'),
(1, 'Balsamic vinegar', 'Drizzle'),
(1, 'Sun-dried tomato halves in oil', '12-14'),
(1, 'Salt and pepper', 'Pinch'),
(1, 'Fresh basil leaves', 'Handful'),
(1, 'Dried spaghetti', '800g-1kg'),
(1, 'Freshly grated parmesan', 'Handful'),
(2, 'Self-raising flour', '125g'),
(2, 'Caster sugar', '2 tbsp'),
(2, 'Baking powder', '1 tsp'),
(2, 'Sea salt', 'Pinch'),
(2, 'Soya or almond milk', '150ml'),
(2, 'Vanilla extract', '1/4 tsp'),
(2, 'Sunflower oil', '4tsp'),
(3, 'Self-raising brown or wholemeal flour', '125g'),
(3, 'Fine sea salt', 'Pinch'),
(3, 'Full-fat plain yoghurt', '125g'),
(3, 'Yellow or orange pepper', '1'),
(3, 'Courgette', '1'),
(3, 'Red onion', '1'),
(3, 'Extra virgin olive oil', '1 tbsp'),
(3, 'Dried chilli flakes', '1/2 tsp'),
(3, 'Mozzarella, cheddar or goats cheese', '50g'),
(3, 'Black pepper', 'Pinch'),
(3, 'Basil leaves', 'Handful'),
(4, 'Couscous', '225g'),
(4, 'Lemons', '8'),
(4, 'Dried cranberries', '180g'),
(4, 'Toasted pine nuts', '120g'),
(4, 'Unsalted chopped pistachios', '160g'),
(4, 'Olive oil', '125ml'),
(4, 'Chopped parsley', '60g'),
(4, 'Crushed garlic cloves', '4'),
(4, 'Red wine vinegar', '4 tbsp'),
(4, 'Red onion', '1'),
(4, 'Salt', '1tsp'),
(4, 'Rocket leaves', '80g'),
(5, 'Milk', '125ml'),
(5, 'Double cream', '125ml'),
(5, 'Vanilla extract', '2-3 drops'),
(5, 'Eggs', '4'),
(5, 'Caster sugar', '170g'),
(5, 'Plain flour', '1 tbsp'),
(5, 'Butter', '30g'),
(5, 'Plums', '500g'),
(5, 'Brown sugar', '2tbsp'),
(5, 'Flaked almonds', '30g'),
(5, 'Icing sugar', 'Dusting'),
(5, 'Double cream', 'Drizzle');

-- --------------------------------------------------------

--
-- Table structure for table `recipe_steps`
--

CREATE TABLE `recipe_steps` (
  `recipe_id` int(11) NOT NULL,
  `Step_number` int(11) NOT NULL,
  `Description` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recipe_steps`
--

INSERT INTO `recipe_steps` (`recipe_id`, `Step_number`, `Description`) VALUES
(1, 1, 'Heat the oil in a large, heavy-based saucepan and fry the bacon until golden over a medium heat. Add the onions and garlic, frying until softened. Increase the heat and add the minced beef. Fry it until it has browned, breaking down any chunks of meat with a wooden spoon. Pour in the wine and boil until it has reduced in volume by about a third. Reduce the temperature and stir in the tomatoes, drained mushrooms, bay leaves, oregano, thyme and balsamic vinegar.'),
(1, 2, 'Either blitz the sun-dried tomatoes in a small blender with a little of the oil to loosen, or just finely chop before adding to the pan. Season well with salt and pepper. Cover with a lid and simmer the Bolognese sauce over a gentle heat for 1-1½ hours until it\'s rich and thickened, stirring occasionally. At the end of the cooking time, stir in the basil and add any extra seasoning if necessary.'),
(1, 3, 'Remove from the heat to \'settle\' while you cook the spaghetti in plenty of boiling salted water (for the time stated on the packet). Drain and divide between warmed plates. Scatter a little parmesan over the spaghetti before adding a good ladleful of the Bolognese sauce, finishing with a scattering of more cheese and a twist of black pepper.'),
(2, 1, 'Put the flour, sugar, baking powder and salt in a bowl and mix thoroughly. Add the milk and vanilla extract and mix with a whisk until smooth.'),
(2, 2, 'Place a large non-stick frying pan over a medium heat. Add 2 teaspoons of the oil and wipe around the pan with a heatproof brush or carefully using a thick wad of kitchen paper.'),
(2, 3, 'Once the pan is hot, pour a small ladleful (around two dessert spoons) of the batter into one side of the pan and spread with the back of the spoon until around 10cm/4in in diameter. Make a second pancake in exactly the same way, greasing the pan with the remaining oil before adding the batter.'),
(2, 4, 'Cook for about a minute, or until bubbles are popping on the surface and just the edges look dry and slightly shiny. Quickly and carefully flip over and cook on the other side for a further minute, or until light, fluffy and pale golden brown. If you turn the pancakes too late, they will be too set to rise evenly. You can always flip again if you need the first side to go a little browner.'),
(2, 5, 'Transfer to a plate and keep warm in a single layer (so they don’t get squished) on a baking tray in a low oven while the rest of the pancakes are cooked in exactly the same way. Serve with your preferred toppings.'),
(3, 1, 'Preheat the oven to 220C/200C Fan/Gas 7.'),
(3, 2, 'To prepare the topping, put the pepper, courgette, red onion and oil in a bowl, season with lots of black pepper and mix together. Scatter the vegetables over a large baking tray and roast for 15 minutes.'),
(3, 3, 'Meanwhile, make the pizza base. Mix the flour and salt in a large bowl. Add the yoghurt and 1 tablespoon of cold water and mix with a spoon, then use your hands to form a soft, spongy dough. Turn out onto a lightly floured surface and knead for about 1 minute.'),
(3, 4, 'Using a floured rolling pin, roll the dough into a roughly oval shape, approx. 3mm/⅛in thick, turning regularly. (Ideally, the pizza should be around 30cm/12in long and 20cm/8in wide, but it doesn’t matter if the shape is uneven, it just needs to fit onto the same baking tray that the vegetables were cooked on.)'),
(3, 5, 'Transfer the roasted vegetables to a bowl. Slide the pizza dough onto the baking tray and bake for 5 minutes. Take the tray out of the oven and turn the dough over.'),
(3, 6, 'For the tomato sauce, mix the passata with the oregano and spread over the dough. Top with the roasted vegetables, sprinkle with the chilli flakes and then the cheese. Bake the pizza for a further 8–10 minutes, or until the dough is cooked through and the cheese beginning to brown.'),
(3, 7, 'Season with black pepper, drizzle with a slurp of olive oil and, if you like, scatter fresh basil leaves on top just before serving.'),
(4, 1, 'In a large bowl mix all the ingredients together except the rocket, then taste and adjust the seasoning, adding more salt if necessary. Toss in the rocket and serve immediately.'),
(5, 1, 'Preheat the oven to 180C/350F/Gas 4.'),
(5, 2, 'Pour the milk, cream and vanilla into a pan and boil for a minute. Remove from the heat and set aside to cool.'),
(5, 3, 'Tip the eggs and sugar into a bowl and beat together until light and fluffy. Fold the flour into the mixture, a little at a time.'),
(5, 4, 'Pour the cooled milk and cream onto the egg and sugar mixture, whisking lightly. Set aside.'),
(5, 5, 'Place a little butter into an ovenproof dish and heat in the oven until foaming. Add the plums and brown sugar and bake for 5 minutes, then pour the batter into the dish and scatter with flaked almonds, if using.'),
(5, 6, 'Cook in the oven for about 30 minutes, until golden-brown and set but still light and soft inside.'),
(5, 7, 'Dust with icing sugar and serve immediately with cream.');

-- --------------------------------------------------------

--
-- Table structure for table `saved_recipes`
--

CREATE TABLE `saved_recipes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `recipe_id` int(11) NOT NULL,
  `saved_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `saved_recipes`
--

INSERT INTO `saved_recipes` (`id`, `user_id`, `recipe_id`, `saved_at`) VALUES
(76, 1, 1, '2023-07-29 16:28:00');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `hash_password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `hash_password`) VALUES
(1, 'rob', 'rc@outlook.com', '$2y$10$KBOMT1FjnRm9AXsAXX3BvOJNhOY3nwECLoXSXRaZFfez7kRcxqVP2'),
(17, 'rob', 'r@outlook.com', '$2y$10$kkK0qA/AgV06Ok6vL8EXiOTUEEQnnSMcl6xROPKsYC16ZK5C.Dig6'),
(20, 'rob', 'arc@outlook.com', '$2y$10$miw1Wa0RTBWVzT.4r83tbueBDHdQ.gt62rxMcH1Y3G1BUBxHcync.'),
(21, 'rob', 'eb@outlook.com', '$2y$10$SxDyKxYjk3xLsR.1zRRWdOSlrr3RKBjVKce6H3Tkvs2qEJvr24y/O'),
(22, 'rob', 'robc@outlook.com', '$2y$10$egGoEFIgtEQ0GFtrmZFpNe0ZheMSziPVb72jjuQNkKNdUNYdEg8F2'),
(23, 'a', 'a@a.com', '$2y$10$ie8d/mrSWuqoENZbBCuYFeaDCHec5dyBt0XoS3C3tD9lll2Ss27Yi'),
(24, 'b', 'b@outlook.com', '$2y$10$skvG7KhM9xNk9P06YcEHVOP6F1ijo4fQxoGRsCNgC2FdJ/G4dvZwa'),
(26, 'r', 'a@outlook.com', '$2y$10$yZD1XmyaNzIvWKw0QaM10uB.XqpeL1ZBXx6fR.ms3s79CEhDBxJAC');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ratings`
--
ALTER TABLE `ratings`
  ADD UNIQUE KEY `recipe_id` (`recipe_id`,`user`),
  ADD UNIQUE KEY `recipe_id_2` (`recipe_id`,`user`),
  ADD KEY `user_id` (`user`);

--
-- Indexes for table `recipes`
--
ALTER TABLE `recipes`
  ADD PRIMARY KEY (`recipe_id`);

--
-- Indexes for table `recipe_categories`
--
ALTER TABLE `recipe_categories`
  ADD KEY `id` (`recipe_id`);

--
-- Indexes for table `recipe_ingredients`
--
ALTER TABLE `recipe_ingredients`
  ADD KEY `recipe` (`recipe_id`);

--
-- Indexes for table `recipe_steps`
--
ALTER TABLE `recipe_steps`
  ADD KEY `recipe_id` (`recipe_id`);

--
-- Indexes for table `saved_recipes`
--
ALTER TABLE `saved_recipes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user` (`user_id`),
  ADD KEY `id_recipe` (`recipe_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `recipes`
--
ALTER TABLE `recipes`
  MODIFY `recipe_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `saved_recipes`
--
ALTER TABLE `saved_recipes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `recipe_categories`
--
ALTER TABLE `recipe_categories`
  ADD CONSTRAINT `id` FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`recipe_id`);

--
-- Constraints for table `recipe_ingredients`
--
ALTER TABLE `recipe_ingredients`
  ADD CONSTRAINT `recipe` FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`recipe_id`);

--
-- Constraints for table `recipe_steps`
--
ALTER TABLE `recipe_steps`
  ADD CONSTRAINT `recipe_id` FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`recipe_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
