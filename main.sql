
CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `description` varchar(250) NOT NULL,
  `price` decimal(6,2) NOT NULL,
  `img` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) CHARSET=utf8;

INSERT INTO `products` (`name`, `description`, `price`, `img`) VALUES
('apple', 'An apple is a sweet, edible fruit produced by an apple tree (Malus domestica). Apple trees are cultivated worldwide and are the most widely grown species in the genus Malus.', '0.3', '/assets/images/apple.png'),
('beer', 'Heineken is a super-inoffensive lager with a stronger, bitterer taste than most internationally mass-produced lagers. It\'s perfectly carbonated, pours a straw yellow colour.', '2', '/assets/images/beer.png'),
('water', 'We Have Been Specialized In Manufacturing Water in Bottles For More Than 20 Years. Check out our best product. Get at least 10 bottles for free in case you have our coupon.', '1', '/assets/images/water.png'),
('cheese', 'Cheese is a dairy product derived from milk that is produced in a wide range of flavors, textures, and forms by coagulation of the milk protein casein. Try to make sandwich.', '3.74', '/assets/images/cheese.png');

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) CHARSET=utf8;

CREATE TABLE `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(50) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `date_added` date NOT NULL,
  `delivery_id` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) CHARSET=utf8;

CREATE TABLE `order_products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `current_price` decimal(6,2) NOT NULL,
  PRIMARY KEY (`id`)
) CHARSET=utf8;

CREATE TABLE `product_rating` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `rating` decimal(2,1) NOT NULL,
  PRIMARY KEY (`id`)
) CHARSET=utf8;

ALTER TABLE `users` ADD UNIQUE KEY `email` (`email`);