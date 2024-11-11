-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Lis 12, 2024 at 12:52 AM
-- Wersja serwera: 10.4.32-MariaDB
-- Wersja PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sklep`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `cartitems`
--

CREATE TABLE `cartitems` (
  `id` int(10) UNSIGNED NOT NULL,
  `idProduct` int(10) UNSIGNED NOT NULL,
  `idShoppingCart` int(10) UNSIGNED NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `addedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `cartitems`
--

INSERT INTO `cartitems` (`id`, `idProduct`, `idShoppingCart`, `price`, `active`, `addedAt`) VALUES
(33, 7, 5, 150000.00, 0, '2024-11-10 23:41:14');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `categories`
--

CREATE TABLE `categories` (
  `id` int(10) NOT NULL,
  `category_name` varchar(50) NOT NULL,
  `parent_id` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category_name`, `parent_id`) VALUES
(1, 'Żyrandole', NULL),
(2, 'Meble', NULL),
(3, 'Obrazy', NULL),
(4, 'Rzeżby', NULL),
(5, 'Szafy', 2),
(6, 'Kredensy', 2),
(7, 'Łoża', 2),
(8, 'Komody', 2),
(9, 'Stoły', 2),
(10, 'Krzesła', 2),
(11, 'Biurka', 2),
(12, 'Lampy', 1),
(13, 'Kinkiety', 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `conditionstate`
--

CREATE TABLE `conditionstate` (
  `id` int(10) UNSIGNED NOT NULL,
  `conditionText` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `conditionstate`
--

INSERT INTO `conditionstate` (`id`, `conditionText`) VALUES
(1, 'Po renowacji'),
(2, 'Nie wymaga renowacji'),
(3, 'Do renowacji');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `messages`
--

CREATE TABLE `messages` (
  `id` int(10) UNSIGNED NOT NULL,
  `idUser` int(10) UNSIGNED NOT NULL,
  `idProduct` int(10) UNSIGNED DEFAULT NULL,
  `subject` varchar(50) NOT NULL,
  `messageText` text NOT NULL,
  `sentAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `responseText` text NOT NULL DEFAULT 'Jeszcze nie ma odpowiedzi.',
  `responseDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `idUser`, `idProduct`, `subject`, `messageText`, `sentAt`, `responseText`, `responseDate`, `email`) VALUES
(7, 5, NULL, 'test', 'test test', '2024-11-11 21:58:55', 'Testuje elo', '2024-11-11 21:58:55', ''),
(15, 12, NULL, 'temat', 'temat', '2024-11-11 20:52:59', 'Jeszcze nie ma odpowiedzi.', '2024-11-11 20:52:59', ''),
(17, 5, NULL, 'test', '3123123', '2024-11-11 20:54:54', 'Jeszcze nie ma odpowiedzi.', '2024-11-11 20:54:54', ''),
(18, 5, NULL, 'test', '3123123', '2024-11-11 20:55:12', 'Jeszcze nie ma odpowiedzi.', '2024-11-11 20:55:12', ''),
(19, 5, NULL, 'test', '3123123', '2024-11-11 20:55:33', 'Jeszcze nie ma odpowiedzi.', '2024-11-11 20:55:33', ''),
(20, 5, NULL, 'test ', 'test', '2024-11-11 20:55:38', 'Jeszcze nie ma odpowiedzi.', '2024-11-11 20:55:38', ''),
(21, 5, NULL, 'test ', 'test', '2024-11-11 20:56:45', 'Jeszcze nie ma odpowiedzi.', '2024-11-11 20:56:45', ''),
(22, 12, NULL, 'Do siebie ', 'na siebie', '2024-11-11 21:57:44', 'Jeszcze nie ma odpowiedzi.', '2024-11-11 21:57:44', '');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `orderitems`
--

CREATE TABLE `orderitems` (
  `id` int(10) UNSIGNED NOT NULL,
  `idProduct` int(10) UNSIGNED NOT NULL,
  `idOrder` int(10) UNSIGNED NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `orders`
--

CREATE TABLE `orders` (
  `id` int(10) UNSIGNED NOT NULL,
  `idUsers` int(10) UNSIGNED NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `idStatus` int(10) UNSIGNED NOT NULL,
  `orderDetails` text NOT NULL,
  `phoneNumber` varchar(10) NOT NULL,
  `email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `idUsers`, `total`, `createdAt`, `idStatus`, `orderDetails`, `phoneNumber`, `email`) VALUES
(12, 5, 150000.00, '2024-11-10 21:09:43', 1, '', '', ''),
(21, 12, 8000.00, '2024-11-11 22:20:36', 1, 'elo', 'elo', 'adres@email.com');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `products`
--

CREATE TABLE `products` (
  `id` int(10) UNSIGNED NOT NULL,
  `idCategories` int(10) NOT NULL,
  `product_name` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `image_main` varchar(50) NOT NULL,
  `idCondition` int(10) UNSIGNED NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `height` int(11) NOT NULL,
  `width` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `idCategories`, `product_name`, `description`, `image_main`, `idCondition`, `price`, `height`, `width`) VALUES
(7, 3, 'Dziewczyna przy oknie Henry Timmerman', 'Obraz', '55e13d_c83a2d44d42e4bf3a51789d62b65df42~mv2.webp', 2, 150000.00, 50, 100),
(8, 3, 'Młody Marokańczyk 1930 Adam Styka', 'Młody Marokańczyk 1930 Adam Styka', 'c84591_f682e4efbdec46bfb8da4faf8ae807a7~mv2.webp', 2, 20000.00, 250, 100),
(9, 8, 'Komoda złote lustro', 'Komoda ze złotym lustrem.', 'c84591_dc11bc4df5784abab2a8d347fed1d735~mv2.jpg', 1, 4500.00, 100, 200),
(10, 5, 'Szafa', 'Szafa lite drewno', 'c84591_cf5601b53d794a279dd9ee92a8c11648~mv2.webp', 1, 3450.00, 220, 300),
(11, 4, 'Aniołek Figuralny kwietnik', 'Aniołek.', 'c84591_36102f41d3434748a21d0255416b3a8e~mv2.webp', 2, 1600.00, 120, 30),
(12, 6, 'Antyczny kredens', 'Antyczny kredens', 'c84591_bc7469eac6c74ac6a31dfc4908c8bac5~mv2.jpg', 1, 20000.00, 250, 300),
(13, 8, 'Szafka pod telewizor / komoda palacowa', 'Szafka pod telewizor / komoda palacowa', 'c84591_3e9246d171ec41fcbc0f60c02b27e4f6~mv2.jpg', 1, 7000.00, 120, 400),
(14, 12, 'Lampa biała ', 'Lampa która jest biała', 'c84591_a66cff5a943740ce8b2bd0e553c1a0b9~mv2.png', 2, 1800.00, 30, 8),
(15, 12, 'Lampa złota ', 'Lampa złota 1007/S', 'c84591_158edf53b92843609223b95820106a1d~mv2.png', 2, 1800.00, 34, 10),
(16, 1, 'Żyrandol złoty', 'Żyrandol złoty 1000/12+8+4\r\n 12 punktów świetlnych w dolnym rzędzie - E14\r\n\r\n8 punktów świetlnych  w środkowym rzędzie - E14\r\n\r\n4 punkty świetlne w górnym rzedzie - E14', 'c84591_f3685b37feb149dca388cb6e670d24aa~mv2.png', 2, 150000.00, 200, 110),
(17, 1, 'Żyrandol czerwony', 'Żyrandol czerwony 1002/5\r\n5 punktów świetlnych - E14', 'c84591_dd50892be40946c3b8a4a24abdf36ecc~mv2.png', 2, 18000.00, 75, 80),
(18, 1, 'Żyrandol niebieski ', 'Żyrandol niebieski 1000/8\r\n8 punktów świetlnych - E14', 'c84591_024d7c1108064fb582b7a219008bcc39~mv2.png', 2, 22000.00, 82, 96),
(19, 5, 'Szafa bogato rzeźbiona ciemny orzech', 'Szafa bogato rzeźbiona ciemny orzech', 'c84591_379e76e36d1d4c4ca6bdcf422e1c348f~mv2.jpg', 2, 6000.00, 300, 300),
(20, 4, 'Rzeżba leżąca kobieta', 'Z brązu.', 's-l400.jpg', 3, 8000.00, 250, 600);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `product_images`
--

CREATE TABLE `product_images` (
  `id` int(10) UNSIGNED NOT NULL,
  `idProduct` int(10) UNSIGNED NOT NULL,
  `imageUrl` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `idProduct`, `imageUrl`) VALUES
(9, 7, '55e13d_5fd42af0f97f4c1089d135d8b6ebc19c~mv2.webp'),
(10, 7, '55e13d_03617102a064447f910fdeb33de345c5~mv2.webp'),
(11, 8, 'c84591_3960664a28e94192b8e204fabc3af3b6~mv2.webp'),
(12, 9, 'c84591_4c1cc6216cf348c4adf9264b3f4fa01a~mv2.jpg'),
(13, 9, 'c84591_07b890105ca14cf39d470fe34c66bcfe~mv2.jpg'),
(14, 10, 'c84591_b18c18131be646838547e82fc2a92d50~mv2.webp'),
(15, 11, 'c84591_7ea3a7978061452d87318f9d836c14ae~mv2.jpg'),
(16, 11, 'c84591_76eade4aab8f4e07998d5479565c0577~mv2.jpg'),
(17, 11, 'c84591_62198af39dac463d93257f57b514d3e5~mv2.jpg'),
(18, 12, 'c84591_83f1e32b1d3942668b74ae61e6f6b55e~mv2.jpg'),
(19, 12, 'c84591_d5d20e88c3bb41a394a800d621a08fca~mv2.jpg'),
(20, 13, 'c84591_2eff207acbcb4fd890ee49eab0da2ddf~mv2.jpg'),
(21, 13, 'c84591_8f9bbb7b3a3a4b8bbdf0ca16c15cf96f~mv2.jpg'),
(22, 13, 'c84591_8fbfd0c4744944ba91d0dab4faed9507~mv2.jpg'),
(23, 13, 'c84591_8fef78d6bccf49bda02b259f6c587d17~mv2.jpg'),
(24, 13, 'c84591_76df7cb5c37946949f759b2abb7837c6~mv2.jpg'),
(25, 13, 'c84591_bf2cf1d9182e4ca0b58f1e66c297b24f~mv2.jpg'),
(26, 19, 'c84591_72490e3ce4f246bcbe1e197d616258aa~mv2.jpg');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `reviews`
--

CREATE TABLE `reviews` (
  `id` int(10) UNSIGNED NOT NULL,
  `idUser` int(10) UNSIGNED NOT NULL,
  `rating` int(10) NOT NULL DEFAULT 5,
  `content` text NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `shoppingcart`
--

CREATE TABLE `shoppingcart` (
  `id` int(10) UNSIGNED NOT NULL,
  `idUser` int(10) UNSIGNED NOT NULL,
  `idSession` varchar(50) NOT NULL,
  `text` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `shoppingcart`
--

INSERT INTO `shoppingcart` (`id`, `idUser`, `idSession`, `text`, `date`) VALUES
(5, 5, 'frdpuc6ueunm16rhc87ei64mta', '', '2024-11-10 21:09:36'),
(8, 12, '407te84nm6mrfu2elm9q50c35t', '', '2024-11-11 22:07:42');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `status`
--

CREATE TABLE `status` (
  `id` int(10) UNSIGNED NOT NULL,
  `statusText` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`id`, `statusText`) VALUES
(1, 'Oczekuje na zatwierdzenie.'),
(2, 'Wysłane'),
(3, 'Dostarczone'),
(4, 'Anulowane');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'user',
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `adress` text NOT NULL,
  `phoneNumber` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `role`, `date`, `adress`, `phoneNumber`) VALUES
(5, 'admin', 'f3ef258757994c916d2d93fa71b89c41', 'admin@email.com', 'admin', '2024-11-10 22:18:24', '', NULL),
(12, 'uzytkownik', 'c9455fc6943ad37378261ca60f7a68a2', 'adres@email.com', 'user', '2024-11-11 20:47:17', '', NULL);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(10) UNSIGNED NOT NULL,
  `idUser` int(10) UNSIGNED NOT NULL,
  `idProduct` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`id`, `idUser`, `idProduct`) VALUES
(125, 5, 9);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `cartitems`
--
ALTER TABLE `cartitems`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idProduct` (`idProduct`),
  ADD KEY `idShoppingCart` (`idShoppingCart`);

--
-- Indeksy dla tabeli `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Indeksy dla tabeli `conditionstate`
--
ALTER TABLE `conditionstate`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idUser` (`idUser`),
  ADD KEY `idProduct` (`idProduct`);

--
-- Indeksy dla tabeli `orderitems`
--
ALTER TABLE `orderitems`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idOrder` (`idOrder`),
  ADD KEY `idProduct` (`idProduct`);

--
-- Indeksy dla tabeli `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idUsers` (`idUsers`),
  ADD KEY `idStatus` (`idStatus`);

--
-- Indeksy dla tabeli `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idCategories` (`idCategories`),
  ADD KEY `idCondition` (`idCondition`);

--
-- Indeksy dla tabeli `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idProduct` (`idProduct`);

--
-- Indeksy dla tabeli `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idUser` (`idUser`);

--
-- Indeksy dla tabeli `shoppingcart`
--
ALTER TABLE `shoppingcart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idUser` (`idUser`);

--
-- Indeksy dla tabeli `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idUser` (`idUser`),
  ADD KEY `idProduct` (`idProduct`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cartitems`
--
ALTER TABLE `cartitems`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `conditionstate`
--
ALTER TABLE `conditionstate`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `orderitems`
--
ALTER TABLE `orderitems`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shoppingcart`
--
ALTER TABLE `shoppingcart`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=140;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cartitems`
--
ALTER TABLE `cartitems`
  ADD CONSTRAINT `cartitems_ibfk_1` FOREIGN KEY (`idProduct`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cartitems_ibfk_2` FOREIGN KEY (`idShoppingCart`) REFERENCES `shoppingcart` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`idProduct`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orderitems`
--
ALTER TABLE `orderitems`
  ADD CONSTRAINT `orderitems_ibfk_1` FOREIGN KEY (`idOrder`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orderitems_ibfk_2` FOREIGN KEY (`idProduct`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`idUsers`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`idStatus`) REFERENCES `status` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`idCategories`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`idCondition`) REFERENCES `conditionstate` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`idProduct`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `shoppingcart`
--
ALTER TABLE `shoppingcart`
  ADD CONSTRAINT `shoppingcart_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `wishlist_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `wishlist_ibfk_2` FOREIGN KEY (`idProduct`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
