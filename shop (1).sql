-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 02, 2018 at 12:56 AM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `Ordering` int(11) DEFAULT NULL,
  `Parent` int(11) NOT NULL,
  `Visibility` tinyint(4) NOT NULL DEFAULT '0',
  `Allow_Comments` tinyint(4) NOT NULL DEFAULT '0',
  `Allow_Ads` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`ID`, `Name`, `Description`, `Ordering`, `Parent`, `Visibility`, `Allow_Comments`, `Allow_Ads`) VALUES
(5, 'Games', '', 1, 0, 0, 0, 0),
(12, 'Tools', 'TooLs ', 7, 0, 0, 0, 0),
(17, 'Shooting', '', 0, 5, 0, 0, 0),
(19, 'Family', '', 9, 0, 0, 0, 0),
(20, 'Education', '', 3, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `C_ID` int(11) NOT NULL,
  `Comment` text NOT NULL,
  `Status` tinyint(4) NOT NULL,
  `Comment_Date` date NOT NULL,
  `Rating_Stars` int(11) NOT NULL,
  `Item_Id` int(11) NOT NULL,
  `User_Id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`C_ID`, `Comment`, `Status`, `Comment_Date`, `Rating_Stars`, `Item_Id`, `User_Id`) VALUES
(1, 'great\r\n', 1, '2018-05-18', 4, 1, 1),
(2, 'It is very fast transfer software I had ever seen', 1, '2018-05-18', 5, 2, 28),
(3, 'aaaaaaaaaaaaaaaaaaaaa I forgot\r\n\r\n', 1, '2018-05-19', 3, 9, 1),
(4, 'this app is good ', 1, '2018-05-19', 5, 9, 33),
(5, 'I Like it !!!', 1, '2018-05-19', 4, 3, 1),
(6, 'Fun *_*', 1, '2018-05-19', 5, 3, 28),
(7, 'لعبة ', 1, '2018-05-20', 4, 9, 32),
(8, 'el stream 5 in stream', 1, '2018-05-21', 5, 11, 34),
(9, 'Facebook!\r\n', 1, '2018-05-21', 4, 17, 1),
(10, 'Excellent strategy Associated with RPG, excellent gragika great gameplay.', 1, '2018-05-24', 5, 14, 1),
(11, 'لعبة جيدة أحببتها', 1, '2018-05-24', 4, 14, 28),
(12, 'Wow this game is fantastic. Several type of gameplays in one game. You have gameplay like Clash of Kings, Dawn of Titans and RPG quests in one game. While you are building your castle up you have other options to keep you occupied for hours. This is by far my favorite game.', 1, '2018-05-24', 5, 14, 34),
(13, 'Build your castle, raise an army, lead heroes into epic, grand-scale wars against players around the world, and rule over the kingdom!', 1, '2018-05-24', 3, 14, 36),
(14, 'dada', 1, '2018-05-26', 3, 10, 37);

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `Image_ID` int(11) NOT NULL,
  `Image` varchar(255) DEFAULT NULL,
  `Item_Id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`Image_ID`, `Image`, `Item_Id`) VALUES
(1, '890564_229461278686.jpg', 1),
(2, '566071_375305378754.jpg', 1),
(3, '614014_929230522156.jpg', 1),
(4, '697968_51555.jpg', 1),
(5, '326904_634308375671.jpg', 2),
(6, '731171_89965620514.jpg', 2),
(7, '434631_470306718262.jpg', 2),
(8, '917267_37580.jpg', 2),
(9, '38696_282135801331.jpg', 3),
(10, '690521_971680789826.jpg', 3),
(11, '702088_185516988648.jpg', 3),
(12, '451813_46122.jpg', 3),
(13, '445557_817414584168.jpg', 4),
(14, '707245_732056858307.jpg', 4),
(15, '604065_188568258789.jpg', 4),
(16, '84747_92919.jpg', 4),
(17, '907959_469269886414.jpg', 5),
(18, '902069_21789564849.jpg', 5),
(19, '367248_625580143066.jpg', 5),
(20, '720978_49022.jpg', 5),
(21, '859192_372406172119.jpg', 6),
(22, '12725_873230215057.jpg', 6),
(23, '83618_178619518127.jpg', 6),
(24, '821381_25771.jpg', 6),
(25, '230438_885132168609.jpg', 7),
(26, '552063_145355673584.jpg', 7),
(27, '922394_277038480194.jpg', 7),
(28, '233520_84094.jpg', 7),
(29, '575501_700043134521.jpg', 8),
(30, '164581_675476909882.jpg', 8),
(31, '69458_885163781311.jpg', 8),
(32, '758393_67849.jpg', 8),
(33, '784638_542847109527.jpg', 9),
(34, '362121_691742479736.jpg', 9),
(35, '42999_673035893769.jpg', 9),
(36, '563110_103288.jpg', 9),
(37, '885559_746430440674.jpg', 10),
(38, '785187_571472823456.jpg', 10),
(39, '899048_560455638245.jpg', 10),
(40, '414154_38068.jpg', 10),
(41, '789368_51156690576.jpg', 11),
(42, '874543_561218955780.jpg', 11),
(43, '572388_20449888928.jpg', 11),
(44, '788666_45928.jpg', 11),
(45, '531830_924317877228.jpg', 12),
(46, '478943_112762308471.jpg', 12),
(47, '562653_752747269867.jpg', 12),
(48, '495361_81701.jpg', 12),
(49, '687592_152343982209.jpg', 13),
(50, '171814_885712809937.jpg', 13),
(51, '472321_156555535004.jpg', 13),
(52, '645264_36735.jpg', 13),
(53, '740235_62286900330.jpg', 14),
(54, '293915_304077333649.jpg', 14),
(55, '41320_974457545654.jpg', 14),
(56, '478058_37714.jpg', 14),
(57, '937012_761017311950.jpg', 15),
(58, '410614_274292337066.jpg', 15),
(59, '663880_83343664307.jpg', 15),
(60, '661163_60545.jpg', 15),
(61, '6103_917023441589.jpg', 16),
(62, '166229_76135351666.jpg', 16),
(63, '680237_491302256836.jpg', 16),
(64, '871857_70463.jpg', 16),
(65, '943879_618836736054.jpg', 17),
(66, '122192_633209318420.jpg', 17),
(67, '303314_16113883088.jpg', 17),
(68, '117614_79716.jpg', 17),
(69, '669403_9823009918.jpg', 18),
(70, '504700_232757450439.jpg', 18),
(71, '849640_596863591034.jpg', 18),
(72, '565064_17099.jpg', 18),
(73, '67352_608765544586.jpg', 19),
(74, '33508_122894725342.jpg', 19),
(75, '63995_211609848359.jpg', 19),
(76, '863404_101310.jpg', 19);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `Item_ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `App` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `Price` float NOT NULL,
  `Add_Date` date NOT NULL,
  `developer_Made` varchar(255) CHARACTER SET latin1 NOT NULL,
  `Image` varchar(255) NOT NULL,
  `Approve` tinyint(4) NOT NULL DEFAULT '0',
  `Rating` float NOT NULL DEFAULT '0',
  `Rates` int(11) NOT NULL DEFAULT '0',
  `Stars` int(11) NOT NULL DEFAULT '0',
  `Cat_ID` int(11) NOT NULL,
  `Member_ID` int(11) NOT NULL,
  `Tags` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`Item_ID`, `Name`, `App`, `Description`, `Price`, `Add_Date`, `developer_Made`, `Image`, `Approve`, `Rating`, `Rates`, `Stars`, `Cat_ID`, `Member_ID`, `Tags`) VALUES
(1, 'Piano Tailes', '134185_424866.apk', 'good game', 0, '2018-05-18', 'cheeta Mobile', '531342_121093575958.png', 1, 4, 1, 4, 5, 1, 'cheetaMobile'),
(2, 'SHAREit ', '816864_555542.apk', 'Transfer & Share', 0, '2018-05-18', 'SHAREit Technologies Co.Ltd', '989899_572571880707.png', 1, 5, 1, 5, 12, 28, ''),
(3, 'Candy Crush Saga', '881684_933350.apk', 'puzzle Game', 0, '2018-05-19', 'Sega', '459991_625183177948.png', 1, 4.5, 2, 9, 5, 28, 'puzzle'),
(4, 'Messenger', '152313_369507.apk', 'Text and Video Chat for Free', 0, '2018-05-19', 'FaceBook', '993317_195129989594.png', 1, 0, 0, 0, 19, 28, 'facebook,Chat'),
(5, 'Khan Academy', '706513_27221.apk', 'Khan Academy allows you to learn almost anything for free.', 0, '2018-05-19', 'Khan Academy', '965485_411438817231.png', 1, 0, 0, 0, 20, 28, 'Edication'),
(6, 'Udemy ', '530060_387634.apk', 'Online Courses', 0, '2018-05-19', 'Udemy ', '74676_65710563629.png', 1, 0, 0, 0, 20, 32, 'Courses'),
(7, 'Duolingo', '7873_453705.apk', 'Learn Languages Free ', 0, '2018-05-19', 'Duolingo', '524414_37872739197.png', 1, 0, 0, 0, 20, 32, 'Languages'),
(8, 'Clash Royale', '666290_486755.apk', 'Clash Royale is a brand new, real-time, head-to-head battle game set in the Clash Universe', 0, '2018-05-19', 'Supercell', '910126_971070535797.png', 1, 0, 0, 0, 5, 32, 'Supercell'),
(9, 'Subway Surfers', '364807_609467.apk', 'DASH as fast as you can! ', 0, '2018-05-19', 'Kiloo', '408691_674103338318.png', 1, 4, 3, 12, 5, 32, 'run'),
(10, 'Angry Birds Classic', '271271_679627.apk', 'Use the unique powers of the Angry Birds to destroy the greedy pigs', 0.99, '2018-05-19', 'Rovio Entertainment Corporation', '964325_128784976716.png', 1, 3, 1, 3, 5, 1, 'Rovio,AngryBirds'),
(11, 'Steam', '345001_966248.apk', 'you can participate in the Steam community wherever you go', 1.99, '2018-05-19', 'Valve', '237274_130249386383.png', 1, 5, 1, 5, 12, 1, 'steam'),
(12, 'Pocket Monster', '313659_721894.apk', 'Pocket Monster -- High quality classic game remake !', 0, '2018-05-19', 'li moyu', '499146_721100898499.png', 1, 0, 0, 0, 5, 1, 'li moyu, game'),
(13, 'Beat Street', '803406_354217.apk', 'Beat Street is the first beat &#39;em up with intuitive single-touch controls and is a love letter to the 90s beat &#39;em up genre! ', 0, '2018-05-19', 'Lucky Kat Studios', '828736_896393255432.png', 1, 0, 0, 0, 5, 1, 'Lucky Kat Studios , fight'),
(14, 'Iron Throne', '324920_808716.apk', 'Claim your kingdom’s Iron Throne!  Build your castle, raise an army, lead heroes into epic, grand-scale wars against players around the world, and rule over the kingdom!', 0, '2018-05-20', 'Netmarble', '695221_327698564545.png', 1, 4.25, 4, 17, 5, 1, 'Strategy'),
(15, 'Angry Birds 2', '300995_450806.apk', 'Angry Birds have received countless praise and amazing downloads since it was released the first version.', 0, '2018-05-20', 'Rovio Entertainment Corporation', '964264_903382564056.png', 1, 0, 0, 0, 5, 1, 'Rovio,AngryBirds'),
(16, 'Clash of Clans', '798798_836304.png', 'From rage-­filled Barbarians with glorious mustaches to pyromaniac wizards, raise your own army and lead your clan to victory! Build your village to fend off raiders, battle against millions of players worldwide, and forge a powerful clan with others to destroy enemy clans.', 0, '2018-05-20', 'Supercell', '499176_333801104827.png', 1, 0, 0, 0, 5, 32, 'Strategy,Supercell'),
(17, 'Facebook', '369018_162262.apk', 'Keeping up with friends is faster and easier than ever. Share updates and photos, engage with friends and Pages, and stay connected to communities important to you. ', 0, '2018-05-21', 'facebook', '425110_307464343506.png', 1, 4, 1, 4, 19, 34, 'facebook,Chat,socialMedia'),
(18, 'Jurassic World™ Alive', '569885_962983.apk', 'They’re ALIVE in our world!  Dinosaurs have returned to rule the Earth. They have fled Jurassic World on the unstable island of Isla Nublar… and they’re roaming free in your cities and neighborhoods.', 0, '2018-05-21', 'Ludia Inc.', '816895_168243199646.png', 1, 0, 0, 0, 5, 6, 'dinosaurs , Ludia Inc'),
(19, 'Shadow Battle 2.2', '645569_462494.apk', 'The SHADOW force has corrupted our Universe by its dankness power, all life forms are covered under its effect. The souls of the most powerful heroes have been sealed inside the magical artifact called Cube. Only you - the Commander - can free the imprisoned heroes, take the lead and fight against the SHADOW to bring peace back to the Universe.', 0, '2018-05-21', 'Blackhole Studio', '169922_89822417517.png', 1, 0, 0, 0, 5, 6, 'Shadow,Battle');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL COMMENT 'To Identify user',
  `UserName` varchar(255) NOT NULL COMMENT 'Login UserName',
  `Password` varchar(255) NOT NULL,
  `Email` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `FullName` varchar(255) NOT NULL,
  `GroupID` int(11) NOT NULL DEFAULT '0',
  `TrustStatus` int(11) NOT NULL DEFAULT '0' COMMENT 'Seller Rank',
  `RegStatus` int(11) NOT NULL DEFAULT '0' COMMENT 'user Approval (Active)',
  `Date` date NOT NULL,
  `Avatar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `UserName`, `Password`, `Email`, `FullName`, `GroupID`, `TrustStatus`, `RegStatus`, `Date`, `Avatar`) VALUES
(1, 'salah ', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'salah@daci.com', 'daci Mohamed                                             ', 1, 0, 1, '2018-01-01', '474792_785370.png'),
(3, 'yacine', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'daci@daci.com', 'daci daci          ', 0, 0, 1, '2018-01-02', '88348_147339.png'),
(6, 'ayoub', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'ayoub@daci.com', 'daci ayoub                ', 0, 0, 1, '2018-01-03', '202057_72815.png'),
(19, 'Admin2', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'admin@daci.com', 'daci daci  ', 1, 1, 1, '2018-03-19', '398041_841309.jpg'),
(28, 'Djenidi', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'Ali@Daci.com', '     ', 0, 0, 1, '2018-04-03', '844391_212219.jpg'),
(32, 'daci', '601f1889667efaebb33b8c12572835da3f027f78', 'daci@salah.com', ' ', 0, 0, 1, '2018-05-19', '244690_16693.png'),
(33, 'fathi', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '3laoa@3lal.com', '   ', 0, 0, 1, '2018-05-19', '329376_263122.jpg'),
(34, 'alahmed', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'selamatahmed61@gmail.com', '  ', 0, 0, 1, '2018-05-21', '663635_181732.png'),
(35, 'Hachem', '601f1889667efaebb33b8c12572835da3f027f78', 'Hachem@email.ms', ' ', 0, 0, 1, '2018-05-23', '701_468872.jpg'),
(36, 'Mossa', '601f1889667efaebb33b8c12572835da3f027f78', 'Mossa@Hania.dz', ' ', 0, 0, 1, '2018-05-24', '717224_85418.jpg'),
(37, 'mabouk', '601f1889667efaebb33b8c12572835da3f027f78', 'mab@fg.fg', ' ', 0, 0, 0, '2018-05-26', '976319_920441.jpg'),
(38, 'user', '601f1889667efaebb33b8c12572835da3f027f78', 'user@ser.se', '', 0, 0, 0, '2018-05-29', ''),
(40, 'larbi', '601f1889667efaebb33b8c12572835da3f027f78', 'LARBI@gmail.com', '', 0, 0, 1, '2018-06-01', ''),
(41, 'Djelloul', '601f1889667efaebb33b8c12572835da3f027f78', 'Djalloul@email.dz', '', 0, 0, 0, '2018-06-01', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Name` (`Name`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`C_ID`),
  ADD KEY `Itmes_Comment` (`Item_Id`),
  ADD KEY `User_Comment` (`User_Id`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`Image_ID`),
  ADD KEY `Item_Image` (`Item_Id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`Item_ID`),
  ADD KEY `member_1` (`Member_ID`),
  ADD KEY `cat_1` (`Cat_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `UserName` (`UserName`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `C_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `Image_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;
--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `Item_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'To Identify user', AUTO_INCREMENT=42;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `Itmes_Comment` FOREIGN KEY (`Item_Id`) REFERENCES `items` (`Item_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `User_Comment` FOREIGN KEY (`User_Id`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `Item_Image` FOREIGN KEY (`Item_Id`) REFERENCES `items` (`Item_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `cat_1` FOREIGN KEY (`Cat_ID`) REFERENCES `categories` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `member_1` FOREIGN KEY (`Member_ID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
