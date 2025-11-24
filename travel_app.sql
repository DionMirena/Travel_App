-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 24, 2025 at 01:06 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `travel_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `user_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hotel_id` int DEFAULT NULL,
  `check_in` date DEFAULT NULL,
  `check_out` date DEFAULT NULL,
  `guests` int DEFAULT NULL,
  `room_type` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL,
  `status` enum('pending','confirmed','cancelled') COLLATE utf8mb4_unicode_ci DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `user_id`, `user_name`, `user_email`, `hotel_id`, `check_in`, `check_out`, `guests`, `room_type`, `total_amount`, `status`, `created_at`) VALUES
(1, 1, 'Dion Mirena', 'dionmirena01@gmail.com', 1, '2024-12-15', '2024-12-20', 2, 'Deluxe Suite', 1100.00, 'confirmed', '2025-11-21 15:49:00'),
(2, 2, 'John Smith', 'john.smith@example.com', 1, '2024-12-18', '2024-12-22', 2, 'Standard Room', 480.00, 'confirmed', '2025-11-21 15:49:00'),
(3, 3, 'Sarah Johnson', 'sarah.j@example.com', 5, '2024-12-10', '2024-12-15', 4, 'Family Room', 700.00, 'confirmed', '2025-11-21 15:49:00'),
(4, 4, 'Mike Wilson', 'mike.wilson@demo.com', 8, '2024-12-22', '2024-12-26', 2, 'Historic Suite', 880.00, 'pending', '2025-11-21 15:49:00'),
(5, 5, 'Lisa Brown', 'lisa.brown@sample.com', 15, '2024-12-25', '2025-01-02', 2, 'Royal Suite', 3600.00, 'confirmed', '2025-11-21 15:49:00'),
(6, 1, 'Dion Mirena', 'dionmirena01@gmail.com', 22, '2024-12-28', '2024-12-31', 1, 'Business Suite', 750.00, 'confirmed', '2025-11-21 15:49:00'),
(7, 6, 'Malik Mccormick', 'wiribep@mailinator.com', 6, '2025-11-22', '2025-11-26', 2, 'Historic Room', 440.00, 'pending', '2025-11-21 15:54:26'),
(8, 9, 'Test', 'test@gmail.com', 7, '2025-11-21', '2025-11-22', 2, 'Premium Suite', 130.00, 'pending', '2025-11-21 16:45:52'),
(9, 12, 'MacKenzie Lowe', 'wylytap@mailinator.com', 16, '2025-11-29', '2025-11-28', 2, 'Sky View Room', 250.00, 'pending', '2025-11-22 15:52:37'),
(10, 12, 'MacKenzie Lowe', 'wylytap@mailinator.com', 16, '2025-11-29', '2025-11-28', 2, 'Sky View Room', 250.00, 'pending', '2025-11-22 15:52:37'),
(11, 13, 'didi', 'didi@gmail.com', 9, '2025-11-24', '2025-11-25', 2, 'Vatican View Room', 160.00, 'pending', '2025-11-23 11:35:29'),
(12, 14, 'Elton Workman', 'desym@mailinator.com', 6, '2025-11-24', '2025-11-27', 2, 'Historic Room', 330.00, 'pending', '2025-11-23 17:08:41'),
(13, 16, 'Lisandra Yang', 'conoqaje@mailinator.com', 20, '2025-11-24', '2025-11-26', 2, 'City View Room', 300.00, 'pending', '2025-11-24 11:12:30'),
(14, 16, 'Lisandra Yang', 'conoqaje@mailinator.com', 32, '2025-11-29', '2025-12-01', 2, 'Business Room', 140.00, 'pending', '2025-11-24 11:15:49'),
(15, 16, 'Lisandra Yang', 'conoqaje@mailinator.com', 20, '2025-12-02', '2025-12-05', 2, 'City View Room', 450.00, 'pending', '2025-11-24 11:19:15');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `name`, `email`, `message`, `created_at`) VALUES
(1, 'Robert Taylor', 'robert.t@example.com', 'I would like to inquire about group booking discounts for 10+ rooms.', '2025-11-21 15:49:00'),
(2, 'Emily Chen', 'emily.chen@sample.com', 'Do you offer airport transfer services from CDG to your Paris hotels?', '2025-11-21 15:49:00'),
(3, 'David Kim', 'david.kim@demo.com', 'I am interested in your loyalty program and membership benefits.', '2025-11-21 15:49:00'),
(4, 'Dion Mirena', 'dionmirena01@gmail.com', 'gfwregergerg', '2025-11-24 11:39:04'),
(5, 'Dion Mirena', 'dionmirena01@gmail.com', 'gfwregergerg', '2025-11-24 11:39:05'),
(6, 'Dion Mirena', 'dionmirena01@gmail.com', 'gfwregergerg', '2025-11-24 11:39:06'),
(7, 'df', 'hutylada@mailinator.com', 'fsdfgsrgswgswgswgs', '2025-11-24 11:43:03'),
(8, 'gr', 'Social@gmail.com', 'fbsrbbtsbrgsb', '2025-11-24 11:43:27'),
(9, 'fvssvf', 'viola@gmail.com', 'fav', '2025-11-24 11:44:35'),
(10, 'DVBDFBVD', 'wiribep@mailinator.com', 'DFBGDBGDBGDB', '2025-11-24 11:49:00');

-- --------------------------------------------------------

--
-- Table structure for table `hotels`
--

CREATE TABLE `hotels` (
  `id` int NOT NULL,
  `place_id` int DEFAULT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `image` text COLLATE utf8mb4_unicode_ci,
  `price` decimal(10,2) DEFAULT NULL,
  `amenities` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hotels`
--

INSERT INTO `hotels` (`id`, `place_id`, `name`, `description`, `image`, `price`, `amenities`) VALUES
(1, 1, 'Hotel Lumiere', 'Luxury boutique hotel in the heart of Paris with Eiffel Tower views, Michelin-star dining, and exclusive spa services. Perfect for romantic escapes and luxury travelers.', 'assets/paris-hotel1.jpg', 120.00, 'Pool,Free WiFi,Breakfast,Spa,Room Service'),
(2, 1, 'Champs Elysees Plaza', 'Elegant hotel on famous Champs-Élysées avenue, featuring classic Parisian architecture, gourmet restaurants, and panoramic city views from rooftop terrace.', 'assets/paris-hotel2.jpg', 180.00, 'Free WiFi,Breakfast,Luxury,City View'),
(3, 1, 'Montmartre Retreat', 'Charming boutique hotel in artistic Montmartre district, offering cozy rooms, French breakfast, and walking distance to Sacré-Cœur Basilica.', 'assets/paris-hotel3.jpg', 90.00, 'Free WiFi,Breakfast,Historic,Artistic'),
(4, 1, 'Seine River View', 'Modern hotel overlooking Seine River, with contemporary design, fitness center, and easy access to Louvre Museum and Notre-Dame.', 'assets/paris-hotel4.jpg', 150.00, 'Pool,Free WiFi,Breakfast,River View,Fitness'),
(5, 2, 'Riverside Inn', 'Charming hotel overlooking Barcelona\'s waterfront, featuring Mediterranean-inspired design, rooftop pool, and proximity to major attractions.', 'assets/barcelona-hotel1.jpg', 85.00, 'Pool,Free WiFi,Breakfast,Sea View'),
(6, 2, 'Gothic Quarter Hotel', 'Historic hotel in Barcelona\'s Gothic Quarter, offering authentic Catalan architecture, courtyard garden, and tapas bar.', 'assets/barcelona-hotel2.jpg', 110.00, 'Free WiFi,Breakfast,Historic,City Center'),
(7, 2, 'Sagrada Familia View', 'Contemporary hotel with direct views of Gaudí\'s masterpiece, featuring modern amenities and easy access to public transportation.', 'assets/barcelona-hotel3.jpg', 130.00, 'Free WiFi,Breakfast,Monument View'),
(8, 3, 'Colosseum Stay', 'Historic hotel near ancient Roman sites, offering authentic Italian hospitality, courtyard gardens, and traditional Roman cuisine.', 'assets/rome-hotel1.jpg', 110.00, 'Free WiFi,Breakfast,Historic,City Center'),
(9, 3, 'Vatican City Hotel', 'Elegant accommodation near Vatican City, featuring Renaissance-inspired decor, rooftop restaurant, and Vatican Museum access.', 'assets/rome-hotel2.jpg', 160.00, 'Pool,Free WiFi,Breakfast,Luxury'),
(10, 3, 'Trastevere Charm', 'Boutique hotel in romantic Trastevere neighborhood, known for cobblestone streets, local trattorias, and authentic Roman atmosphere.', 'assets/rome-hotel3.jpg', 95.00, 'Free WiFi,Breakfast,Historic,Local Culture'),
(11, 3, 'Roman Forum View', 'Modern hotel with panoramic views of Roman Forum, offering spa services, fine dining, and luxury accommodations.', 'assets/rome-hotel4.jpg', 200.00, 'Pool,Free WiFi,Breakfast,Spa,Luxury'),
(12, 4, 'London Central', 'Elegant hotel in Mayfair with British sophistication, afternoon tea service, and walking distance to royal landmarks.', 'assets/london-hotel1.jpg', 150.00, 'Free WiFi,Breakfast,Luxury,City Center'),
(13, 4, 'Thames Riverside', 'Contemporary hotel along Thames River, featuring modern British design, riverside restaurant, and views of London Eye.', 'assets/london-hotel2.jpg', 170.00, 'Free WiFi,Breakfast,River View,Fitness'),
(14, 4, 'Kensington Garden', 'Charming hotel near Kensington Gardens, offering classic English decor, garden views, and proximity to museums.', 'assets/london-hotel3.jpg', 120.00, 'Free WiFi,Breakfast,Garden View,Historic'),
(15, 5, 'Dubai Palace', 'Opulent 5-star resort with Arabian luxury, private butlers, multiple swimming pools, and exclusive beach club access.', 'assets/dubai-hotel1.jpg', 200.00, 'Pool,Free WiFi,Breakfast,Spa,Luxury,Beach'),
(16, 5, 'Burj Khalifa View', 'Luxury hotel with direct views of Burj Khalifa, featuring sky-high restaurants, infinity pool, and shopping mall access.', 'assets/dubai-hotel2.jpg', 250.00, 'Pool,Free WiFi,Breakfast,Luxury,City View'),
(17, 5, 'Desert Oasis Resort', 'Unique desert resort offering traditional Bedouin experiences, camel rides, stargazing, and authentic Arabian nights.', 'assets/dubai-hotel3.jpg', 180.00, 'Pool,Free WiFi,Breakfast,Desert,Adventure'),
(18, 5, 'Marina Bay Hotel', 'Modern hotel in Dubai Marina with yacht club access, watersports, and panoramic views of artificial islands.', 'assets/dubai-hotel4.jpg', 160.00, 'Pool,Free WiFi,Breakfast,Marina View'),
(19, 6, 'Tokyo Garden Hotel', 'Serene urban retreat blending Japanese minimalism with modern comfort, featuring Zen gardens and traditional tea ceremonies.', 'assets/tokyo-hotel1.jpg', 130.00, 'Free WiFi,Breakfast,Garden,Traditional'),
(20, 6, 'Shibuya Sky View', 'High-rise hotel in bustling Shibuya district, offering panoramic city views, modern amenities, and direct subway access.', 'assets/tokyo-hotel2.jpg', 150.00, 'Free WiFi,Breakfast,City View,Fitness'),
(21, 6, 'Traditional Ryokan', 'Authentic Japanese inn featuring tatami rooms, hot spring baths, kaiseki meals, and cultural experiences.', 'assets/tokyo-hotel3.jpg', 180.00, 'Free WiFi,Breakfast,Hot Spring,Traditional'),
(22, 7, 'Manhattan Inn', 'Contemporary hotel in Midtown with skyline views, business facilities, and easy access to Broadway and Central Park.', 'assets/ny-hotel1.jpg', 160.00, 'Free WiFi,Breakfast,City View,Business'),
(23, 7, 'Central Park View', 'Luxury hotel overlooking Central Park, featuring elegant suites, fine dining, and proximity to Fifth Avenue shopping.', 'assets/ny-hotel2.jpg', 220.00, 'Pool,Free WiFi,Breakfast,Luxury,Park View'),
(24, 7, 'Brooklyn Loft', 'Trendy boutique hotel in Williamsburg, offering industrial-chic design, rooftop bar, and artistic neighborhood vibe.', 'assets/ny-hotel3.jpg', 140.00, 'Free WiFi,Breakfast,Artsy,Local Culture'),
(25, 7, 'Times Square Lights', 'Vibrant hotel in heart of Times Square, featuring Broadway-themed decor, entertainment packages, and 24/7 energy.', 'assets/ny-hotel4.jpg', 190.00, 'Free WiFi,Breakfast,Entertainment,City Center'),
(26, 8, 'Golden Horn Hotel', 'Authentic Turkish hospitality in Sultanahmet, offering Ottoman-inspired decor, Turkish baths, and rooftop Bosphorus views.', 'assets/istanbul-hotel1.jpg', 90.00, 'Free WiFi,Breakfast,Historic,Turkish Bath'),
(27, 8, 'Bosphorus Palace', 'Luxury hotel on Bosphorus strait, featuring marble interiors, seafood restaurants, and cruise ship access.', 'assets/istanbul-hotel2.jpg', 150.00, 'Pool,Free WiFi,Breakfast,Luxury,Sea View'),
(28, 8, 'Grand Bazaar Suites', 'Traditional hotel near Grand Bazaar, offering authentic Turkish decor, spice market tours, and cultural experiences.', 'assets/istanbul-hotel3.jpg', 110.00, 'Free WiFi,Breakfast,Historic,Cultural'),
(29, 9, 'Athens View', 'Acropolis-view hotel with Greek island aesthetics, rooftop restaurant, and proximity to ancient archaeological sites.', 'assets/athens-hotel1.jpg', 100.00, 'Free WiFi,Breakfast,Acropolis View'),
(30, 9, 'Plaka Traditional', 'Charming hotel in Plaka old town, featuring neoclassical architecture, courtyard restaurant, and walking streets.', 'assets/athens-hotel2.jpg', 85.00, 'Free WiFi,Breakfast,Historic,Traditional'),
(31, 9, 'Mediterranean Resort', 'Beachfront hotel near Athens Riviera, offering pool, Greek cuisine, and easy access to ancient sites.', 'assets/athens-hotel3.jpg', 120.00, 'Pool,Free WiFi,Breakfast,Beach'),
(32, 10, 'Newborn City Hotel', 'Modern hotel in Prishtina city center, featuring contemporary design, business center, and vibrant nightlife access.', 'assets/prishtina-hotel1.jpg', 70.00, 'Free WiFi,Breakfast,City Center,Business'),
(33, 10, 'Kosovo Heritage', 'Boutique hotel showcasing Kosovo culture, traditional architecture, local cuisine, and historical tours.', 'assets/prishtina-hotel2.jpg', 60.00, 'Free WiFi,Breakfast,Cultural,Historic');

-- --------------------------------------------------------

--
-- Table structure for table `places`
--

CREATE TABLE `places` (
  `id` int NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `image` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `places`
--

INSERT INTO `places` (`id`, `name`, `description`, `image`) VALUES
(1, 'Paris', 'The iconic City of Light, Paris enchants visitors with its romantic ambiance, world-class art museums, and exquisite cuisine. Marvel at the Eiffel Tower, explore the Louvre Museum, stroll along the Seine River, and indulge in authentic French pastries at charming sidewalk cafes. Perfect for romantic getaways and cultural experiences.', 'assets/paris.jpg'),
(2, 'Barcelona', 'Vibrant Mediterranean city where Gothic architecture meets modernist masterpieces. Explore Gaudí\'s surreal Sagrada Familia, wander through the colorful Park Güell, relax at Barceloneta Beach, and experience the electric energy of Las Ramblas. Famous for its tapas culture, football passion, and stunning Mediterranean coastline.', 'assets/barcelona.jpg'),
(3, 'Rome', 'The Eternal City where ancient history comes alive at every corner. Walk in the footsteps of gladiators at the Colosseum, toss a coin in the Trevi Fountain, explore the Roman Forum, and marvel at Michelangelo\'s Sistine Chapel. Indulge in authentic pasta carbonara and gelato while soaking in 2,500 years of history.', 'assets/rome.jpg'),
(4, 'London', 'A dynamic blend of royal tradition and modern innovation. Witness the Changing of the Guard at Buckingham Palace, explore the Tower of London, admire panoramic views from the London Eye, and experience world-class theater in the West End. From historic pubs to cutting-edge fashion, London offers endless discovery.', 'assets/london.jpg'),
(5, 'Dubai', 'A futuristic oasis rising from the desert, Dubai redefines luxury and innovation. Ascend the breathtaking Burj Khalifa, shop in extravagant malls, experience desert safaris, and relax on pristine beaches. A city of superlatives where traditional souks meet ultra-modern architecture and unparalleled hospitality.', 'assets/dubai.jpg'),
(6, 'Tokyo', 'Where ancient traditions harmonize with futuristic technology. Discover serene temples alongside neon-lit streets, experience world-renowned sushi, explore the electronic wonderland of Akihabara, and witness the beauty of cherry blossom season. A city that seamlessly blends respect for tradition with cutting-edge innovation.', 'assets/tokyo.jpg'),
(7, 'New York', 'The city that never sleeps pulses with iconic energy and diversity. Take in skyline views from the Empire State Building, stroll through Central Park, experience Broadway magic, and explore world-class museums. From Times Square\'s bright lights to Brooklyn\'s artistic vibe, NYC offers an unforgettable urban adventure.', 'assets/newyork.jpg'),
(8, 'Istanbul', 'The magical bridge between Europe and Asia, where East meets West in a captivating fusion. Admire the Blue Mosque\'s grandeur, explore the ancient Hagia Sophia, get lost in the Grand Bazaar\'s labyrinth, and cruise the Bosphorus. A city rich in Ottoman history, aromatic spices, and warm hospitality.', 'assets/istanbul.jpg'),
(9, 'Athens', 'The cradle of Western civilization, where democracy and philosophy were born. Stand in awe of the Acropolis and Parthenon, explore ancient Agora, discover world-class museums, and savor authentic Greek cuisine in Plaka\'s charming streets. A living museum where 3,000 years of history surround you.', 'assets/athens.jpg'),
(10, 'Prishtina', 'Kosovo\'s vibrant capital blends rich history with youthful energy. Discover the Newborn Monument, explore the Imperial Mosque, experience the city\'s growing cafe culture, and witness the transformation of a nation. A city of resilience, warm hospitality, and emerging European charm.', 'assets/prishtina.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `hotel_id` int DEFAULT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rating` int NOT NULL,
  `review` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `hotel_id`, `name`, `rating`, `review`, `date`) VALUES
(1, 1, 1, 'Dion Mirena', 5, 'Absolutely amazing experience! The staff was incredibly helpful and the room was spotless. Will definitely return on my next visit.', '2025-11-21 15:49:00'),
(2, 2, 1, 'John Smith', 4, 'Great location and comfortable beds. The breakfast buffet had a good variety. Only minor issue was slow WiFi in the room.', '2025-11-21 15:49:00'),
(3, 3, 1, 'Sarah Johnson', 5, 'Loved every moment of our stay. The Eiffel Tower view from our room was breathtaking. Highly recommended for romantic getaways!', '2025-11-21 15:49:00'),
(4, 1, 2, 'Dion Mirena', 4, 'Beautiful hotel with excellent service. The spa was fantastic but the pool was a bit crowded during peak hours.', '2025-11-21 15:49:00'),
(5, 4, 2, 'Mike Wilson', 5, 'Outstanding service and luxurious accommodations. The rooftop terrace has the best views in Paris!', '2025-11-21 15:49:00'),
(6, 5, 3, 'Lisa Brown', 3, 'Good hotel but overpriced for what you get. Location is excellent but rooms are smaller than expected.', '2025-11-21 15:49:00'),
(7, 2, 5, 'John Smith', 5, 'Perfect stay! The attention to detail was impressive. Will definitely book again when in Barcelona.', '2025-11-21 15:49:00'),
(8, 3, 5, 'Sarah Johnson', 4, 'Great value for money. Clean rooms, friendly staff, and amazing sea views from the rooftop pool.', '2025-11-21 15:49:00'),
(9, 1, 8, 'Dion Mirena', 5, 'Authentic Roman experience! The hotel\'s historic charm combined with modern amenities made our stay unforgettable.', '2025-11-21 15:49:00'),
(10, 4, 8, 'Mike Wilson', 4, 'Excellent location near the Colosseum. Helpful staff and comfortable rooms. Would stay here again.', '2025-11-21 15:49:00'),
(11, 5, 9, 'Lisa Brown', 5, 'The Vatican view room was worth every penny! Waking up to that view was magical.', '2025-11-21 15:49:00'),
(12, 2, 12, 'John Smith', 4, 'Classic British elegance with modern comforts. Afternoon tea was a delightful experience.', '2025-11-21 15:49:00'),
(13, 3, 13, 'Sarah Johnson', 5, 'Absolutely luxurious! The river views are spectacular and the service is impeccable.', '2025-11-21 15:49:00'),
(14, 1, 15, 'Dion Mirena', 5, 'Dubai luxury at its finest! The private beach and multiple pools made this an unforgettable vacation.', '2025-11-21 15:49:00'),
(15, 4, 16, 'Mike Wilson', 4, 'Incredible views of Burj Khalifa. The infinity pool is a must-try experience.', '2025-11-21 15:49:00'),
(16, 5, 19, 'Lisa Brown', 5, 'Traditional Japanese hospitality at its best. The tea ceremony was a beautiful cultural experience.', '2025-11-21 15:49:00'),
(17, 2, 22, 'John Smith', 4, 'Great Manhattan location with stunning skyline views. Perfect for business travelers.', '2025-11-21 15:49:00'),
(18, 3, 23, 'Sarah Johnson', 5, 'Central Park view room was worth the splurge! Waking up to that view every morning was magical.', '2025-11-21 15:49:00'),
(19, 1, 26, 'Dion Mirena', 4, 'Authentic Turkish experience with modern comforts. The Turkish bath was rejuvenating.', '2025-11-21 15:49:00'),
(20, 4, 27, 'Mike Wilson', 5, 'Breathtaking Bosphorus views! The seafood restaurant is exceptional.', '2025-11-21 15:49:00'),
(21, 9, NULL, 'Test', 5, 'GG', '2025-11-21 16:46:35'),
(22, 10, NULL, 'test', 5, 'jvh', '2025-11-21 16:54:14'),
(23, 12, 5, 'MacKenzie Lowe', 4, 'njyhnyfnf', '2025-11-22 13:16:48'),
(24, 15, 29, 'Chloe Henson', 5, 'vfsvdfv', '2025-11-24 10:17:42');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` int NOT NULL,
  `hotel_id` int DEFAULT NULL,
  `room_type` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `quantity` int DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `hotel_id`, `room_type`, `price`, `quantity`, `description`) VALUES
(1, 1, 'Standard Room', 120.00, 8, 'Comfortable standard room with city view'),
(2, 1, 'Deluxe Suite', 220.00, 4, 'Spacious suite with Eiffel Tower view'),
(3, 1, 'Executive Room', 180.00, 6, 'Executive room with premium amenities'),
(4, 2, 'Classic Room', 180.00, 7, 'Classic room with Champs-Élysées view'),
(5, 2, 'Luxury Suite', 320.00, 3, 'Luxurious suite with balcony'),
(6, 2, 'Presidential Suite', 500.00, 1, 'Ultra-luxurious presidential suite'),
(7, 3, 'Cozy Room', 90.00, 10, 'Cozy room in artistic neighborhood'),
(8, 3, 'Superior Room', 130.00, 5, 'Superior room with Montmartre view'),
(9, 3, 'Artist Studio', 160.00, 3, 'Spacious studio with artistic decor'),
(10, 4, 'River View Room', 150.00, 7, 'Room with Seine River view'),
(11, 4, 'Junior Suite', 220.00, 4, 'Junior suite with balcony'),
(12, 4, 'Executive Suite', 300.00, 2, 'Executive suite with river views'),
(13, 5, 'Standard Double', 85.00, 8, 'Standard room with sea view'),
(14, 5, 'Family Room', 140.00, 4, 'Spacious family room'),
(15, 5, 'Rooftop Suite', 200.00, 2, 'Suite with rooftop access'),
(16, 6, 'Historic Room', 110.00, 6, 'Room with historic character'),
(17, 6, 'Superior Double', 160.00, 4, 'Superior room in Gothic Quarter'),
(18, 6, 'Courtyard Suite', 220.00, 2, 'Suite overlooking courtyard garden'),
(19, 7, 'City View Room', 130.00, 7, 'Room with city views'),
(20, 7, 'Monument View Room', 180.00, 5, 'Room with Sagrada Familia view'),
(21, 7, 'Premium Suite', 250.00, 2, 'Suite with panoramic views'),
(22, 8, 'Classic Room', 110.00, 8, 'Classic Roman-style room'),
(23, 8, 'Garden View Room', 160.00, 5, 'Room overlooking courtyard garden'),
(24, 8, 'Historic Suite', 220.00, 3, 'Suite with historic elements'),
(25, 9, 'Vatican View Room', 160.00, 6, 'Room with Vatican City view'),
(26, 9, 'Rooftop Room', 210.00, 4, 'Room with rooftop access'),
(27, 9, 'Papal Suite', 350.00, 1, 'Ultra-luxurious papal suite'),
(28, 10, 'Trastevere Room', 95.00, 10, 'Authentic local experience room'),
(29, 10, 'Superior Double', 140.00, 5, 'Superior room in historic area'),
(30, 10, 'Romantic Suite', 190.00, 2, 'Romantic suite for couples'),
(31, 11, 'Forum View Room', 200.00, 4, 'Room with Roman Forum view'),
(32, 11, 'Luxury Suite', 350.00, 2, 'Ultra-luxurious suite with spa access'),
(33, 11, 'Imperial Suite', 500.00, 1, 'Imperial suite with butler service'),
(34, 12, 'Classic Room', 150.00, 8, 'Classic British-style room'),
(35, 12, 'Afternoon Tea Suite', 250.00, 3, 'Suite with tea service'),
(36, 12, 'Royal Suite', 400.00, 1, 'Royal suite with luxury amenities'),
(37, 13, 'River View Room', 170.00, 6, 'Room with Thames River view'),
(38, 13, 'Executive Suite', 280.00, 3, 'Executive suite with river balcony'),
(39, 13, 'Penthouse', 450.00, 1, 'Penthouse with panoramic views'),
(40, 14, 'Garden Room', 120.00, 7, 'Room with garden views'),
(41, 14, 'Family Suite', 200.00, 3, 'Spacious family accommodation'),
(42, 14, 'Victorian Suite', 280.00, 2, 'Suite with Victorian decor'),
(43, 15, 'Deluxe Room', 200.00, 8, 'Deluxe room with Arabian decor'),
(44, 15, 'Royal Suite', 450.00, 3, 'Ultra-luxurious royal suite'),
(45, 15, 'Presidential Palace', 800.00, 1, 'Exclusive presidential palace suite'),
(46, 16, 'Sky View Room', 250.00, 6, 'Room with Burj Khalifa view'),
(47, 16, 'Luxury Suite', 450.00, 3, 'Luxury suite with premium amenities'),
(48, 16, 'Sky Palace', 700.00, 1, 'Exclusive sky palace suite'),
(49, 17, 'Desert Room', 180.00, 7, 'Traditional desert-style room'),
(50, 17, 'Luxury Tent', 280.00, 4, 'Luxurious desert camping experience'),
(51, 17, 'Royal Bedouin Suite', 400.00, 2, 'Royal suite with desert views'),
(52, 18, 'Marina View Room', 160.00, 8, 'Room with marina views'),
(53, 18, 'Yacht Club Suite', 300.00, 3, 'Suite with yacht club access'),
(54, 18, 'Penthouse Suite', 500.00, 1, 'Penthouse with marina views'),
(55, 19, 'Zen Room', 130.00, 9, 'Traditional Japanese-style room'),
(56, 19, 'Garden Suite', 220.00, 3, 'Suite with private garden'),
(57, 19, 'Tea Ceremony Suite', 300.00, 1, 'Suite with tea ceremony space'),
(58, 20, 'City View Room', 150.00, 7, 'Room with Shibuya views'),
(59, 20, 'Executive Floor', 220.00, 4, 'Executive level accommodation'),
(60, 20, 'Skyline Suite', 350.00, 2, 'Suite with panoramic skyline views'),
(61, 21, 'Traditional Room', 180.00, 6, 'Authentic tatami room'),
(62, 21, 'Hot Spring Suite', 280.00, 3, 'Suite with private hot spring'),
(63, 21, 'Imperial Suite', 400.00, 1, 'Imperial suite with garden'),
(64, 22, 'Standard Room', 160.00, 8, 'Standard Manhattan room'),
(65, 22, 'Business Suite', 250.00, 3, 'Suite with office setup'),
(66, 22, 'Executive Suite', 350.00, 2, 'Executive suite with city views'),
(67, 23, 'Park View Room', 220.00, 5, 'Room with Central Park view'),
(68, 23, 'Luxury Suite', 400.00, 2, 'Ultra-luxurious park-facing suite'),
(69, 23, 'Penthouse', 600.00, 1, 'Penthouse with park views'),
(70, 24, 'Loft Room', 140.00, 7, 'Industrial-chic loft room'),
(71, 24, 'Artist Suite', 220.00, 3, 'Suite with artistic elements'),
(72, 24, 'Rooftop Suite', 300.00, 1, 'Suite with rooftop access'),
(73, 25, 'Times Square Room', 190.00, 6, 'Room with Times Square view'),
(74, 25, 'Broadway Suite', 320.00, 2, 'Themed suite with show tickets'),
(75, 25, 'Entertainment Suite', 450.00, 1, 'Suite with entertainment system'),
(76, 26, 'Standard Room', 90.00, 9, 'Standard room with Turkish decor'),
(77, 26, 'Bosphorus View Room', 150.00, 5, 'Room with strait views'),
(78, 26, 'Ottoman Suite', 220.00, 2, 'Suite with Ottoman decor'),
(79, 27, 'Sea View Room', 150.00, 6, 'Room with Bosphorus view'),
(80, 27, 'Palace Suite', 280.00, 3, 'Luxurious palace-style suite'),
(81, 27, 'Royal Suite', 400.00, 1, 'Royal suite with butler service'),
(82, 28, 'Bazaar Room', 110.00, 8, 'Room near Grand Bazaar'),
(83, 28, 'Cultural Suite', 190.00, 3, 'Suite with cultural elements'),
(84, 28, 'Heritage Suite', 260.00, 1, 'Suite with heritage artifacts'),
(85, 29, 'Acropolis View Room', 100.00, 7, 'Room with Acropolis view'),
(86, 29, 'Rooftop Suite', 180.00, 3, 'Suite with panoramic views'),
(87, 29, 'Executive Room', 140.00, 5, 'Executive room with city views'),
(88, 30, 'Traditional Room', 85.00, 9, 'Traditional Greek-style room'),
(89, 30, 'Superior Room', 130.00, 4, 'Superior Plaka accommodation'),
(90, 30, 'Heritage Suite', 190.00, 2, 'Suite with heritage elements'),
(91, 31, 'Beach Room', 120.00, 6, 'Room with beach access'),
(92, 31, 'Family Suite', 200.00, 3, 'Spacious family room'),
(93, 31, 'Luxury Villa', 300.00, 1, 'Private luxury villa'),
(94, 32, 'Business Room', 70.00, 10, 'Modern business room'),
(95, 32, 'Executive Suite', 130.00, 3, 'Executive suite with office'),
(96, 32, 'Presidential Room', 200.00, 1, 'Presidential level room'),
(97, 33, 'Heritage Room', 60.00, 8, 'Traditional Kosovo-style room'),
(98, 33, 'Cultural Suite', 110.00, 3, 'Suite with cultural exhibits'),
(99, 33, 'Family Room', 90.00, 4, 'Spacious family accommodation');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_verified` tinyint(1) DEFAULT '0',
  `verify_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reset_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reset_expires` datetime DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `is_verified`, `verify_token`, `reset_token`, `reset_expires`, `photo`, `created_at`) VALUES
(1, 'Dion Mirena', 'dionmirena01@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1, NULL, NULL, NULL, NULL, '2025-11-21 15:49:00'),
(2, 'John Smith', 'john.smith@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1, NULL, NULL, NULL, NULL, '2025-11-21 15:49:00'),
(3, 'Sarah Johnson', 'sarah.j@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1, NULL, NULL, NULL, NULL, '2025-11-21 15:49:00'),
(4, 'Mike Wilson', 'mike.wilson@demo.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1, NULL, NULL, NULL, NULL, '2025-11-21 15:49:00'),
(5, 'Lisa Brown', 'lisa.brown@sample.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1, NULL, NULL, NULL, NULL, '2025-11-21 15:49:00'),
(6, 'dsadsds', 'wiribep@mailinator.com', '$2y$10$3YwfKPIk6qIMazd2BzCRguqd.44AzcMAvYct9dikSxs8SpeAQ.ym.', 0, NULL, NULL, NULL, 'uploads/1763740619_Screenshot 2025-01-19 211101.png', '2025-11-21 15:52:50'),
(9, 'Test', 'test@gmail.com', '$2y$10$yUX1rECdws2BnO4mU99tF.7cbOWSMm6suBNcLlYmexg4KIP7g3Utq', 0, NULL, NULL, NULL, 'uploads/1763743671_image.jpg', '2025-11-21 16:45:10'),
(10, 'test', 'testtest@gmail.com', '$2y$10$O6uU7igjy1HHELxSr0rIW.wx.rK09VdQcl7z9ApLdtezQHuZcu4u.', 0, NULL, NULL, NULL, NULL, '2025-11-21 16:53:11'),
(11, 'Leilani Richardson', 'gato@mailinator.com', '$2y$10$72z.yyUUYrNqS7a4cHiategU0UkBGJAg1tl/6BnZ7OtTeSdTnX3Pq', 0, NULL, NULL, NULL, 'uploads/1763764546_Screenshot 2025-01-19 211101.png', '2025-11-21 22:21:58'),
(12, 'MacKenzie Lowe', 'wylytap@mailinator.com', '$2y$10$bSBUg/z9HVb1pkHT7w.nbeFeEPQ0hiSsRYRQRm.BMKJYgsxA57bbW', 0, NULL, NULL, NULL, NULL, '2025-11-21 22:36:20'),
(13, 'didi', 'didi@gmail.com', '$2y$10$ejby5IZr9egJNNrqQLaXLOQZKUVm1xpDv2XWienpOigJ38RiF.Li6', 0, NULL, NULL, NULL, 'uploads/1763897765_408bfdbf-50b9-4524-95a2-43ef317524dc.jpeg', '2025-11-23 11:34:43'),
(14, 'Elton Workman', 'desym@mailinator.com', '$2y$10$KY3yxYPeSXoLZXwLBZw.Q.0r3K.OC4BfV4n1.FJetQYiTfLsfFeVy', 0, NULL, NULL, NULL, 'uploads/1763917743_Screenshot 2025-01-19 211101.png', '2025-11-23 17:08:06'),
(15, 'Dion', 'hutylada@mailinator.com', '$2y$10$q.beMNdgczgbxSIs.l/NGet.csdrsnfuUkNbMzPjMSPtyPPKH53xW', 0, NULL, NULL, NULL, 'uploads/1763979477_Screenshot 2025-01-19 211327.png', '2025-11-24 10:15:18'),
(16, 'Lisandra Yang', 'conoqaje@mailinator.com', '$2y$10$TwtlTL9jF2GPh9v.Z3ROXOgy1c7I5GzTc27F8LRWJma5ACpO1HgWK', 0, NULL, NULL, NULL, NULL, '2025-11-24 10:53:35'),
(17, 'blah', 'blah@gmail.com', '$2y$10$qs7oOqECcKN7aB7hpXm7LeQBpcnNVIH0e4MkuCwJC2xDevHf0dNCa', 0, NULL, NULL, NULL, NULL, '2025-11-24 11:37:17');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_bookings_user_id` (`user_id`),
  ADD KEY `idx_bookings_hotel_id` (`hotel_id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hotels`
--
ALTER TABLE `hotels`
  ADD PRIMARY KEY (`id`),
  ADD KEY `place_id` (`place_id`);

--
-- Indexes for table `places`
--
ALTER TABLE `places`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_reviews_hotel_id` (`hotel_id`),
  ADD KEY `idx_reviews_user_id` (`user_id`),
  ADD KEY `idx_reviews_date` (`date`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hotel_id` (`hotel_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_users_email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `hotels`
--
ALTER TABLE `hotels`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `places`
--
ALTER TABLE `places`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`hotel_id`) REFERENCES `hotels` (`id`);

--
-- Constraints for table `hotels`
--
ALTER TABLE `hotels`
  ADD CONSTRAINT `hotels_ibfk_1` FOREIGN KEY (`place_id`) REFERENCES `places` (`id`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`hotel_id`) REFERENCES `hotels` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `rooms`
--
ALTER TABLE `rooms`
  ADD CONSTRAINT `rooms_ibfk_1` FOREIGN KEY (`hotel_id`) REFERENCES `hotels` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
