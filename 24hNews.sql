-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 27, 2025 at 03:47 AM
-- Server version: 8.0.30
-- PHP Version: 8.2.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `24hnews`
--
CREATE DATABASE IF NOT EXISTS `24hnews` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `24hnews`;

-- --------------------------------------------------------

--
-- Table structure for table `approvals`
--

CREATE TABLE `approvals` (
  `approval_id` bigint UNSIGNED NOT NULL,
  `type` enum('article','role_upgrade') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'article',
  `article_id` bigint UNSIGNED DEFAULT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `approved_by` bigint UNSIGNED DEFAULT NULL,
  `cccd_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cccd_front` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cccd_back` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `certificates` json DEFAULT NULL,
  `requested_role` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('pending','approved','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `reject_reason` text COLLATE utf8mb4_unicode_ci,
  `remarks` text COLLATE utf8mb4_unicode_ci,
  `violation_level` enum('none','low','medium','high') COLLATE utf8mb4_unicode_ci DEFAULT 'none' COMMENT 'Mức độ vi phạm từ kiểm duyệt nội dung',
  `violations` text COLLATE utf8mb4_unicode_ci COMMENT 'Danh sách các vi phạm được phát hiện (JSON)',
  `violation_details` json DEFAULT NULL COMMENT 'Chi tiết về các vi phạm và lý do (JSON)',
  `processed_at` timestamp NULL DEFAULT NULL,
  `processed_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE `articles` (
  `article_id` bigint UNSIGNED NOT NULL,
  `code` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `preview_content` text COLLATE utf8mb4_unicode_ci,
  `contains_sensitive_content` tinyint(1) NOT NULL DEFAULT '0',
  `author_id` bigint UNSIGNED NOT NULL,
  `category_id` bigint UNSIGNED DEFAULT NULL,
  `subcategory_id` bigint UNSIGNED DEFAULT NULL,
  `thumbnail_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('draft','pending','published','archived','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `views` int NOT NULL DEFAULT '0',
  `approved_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`article_id`, `code`, `title`, `slug`, `content`, `preview_content`, `contains_sensitive_content`, `author_id`, `category_id`, `subcategory_id`, `thumbnail_url`, `status`, `views`, `approved_by`, `created_at`, `updated_at`) VALUES
(1, 'BV-140425-10796538', 'Qui qui non sed incidunt quia. 67fc6aa1078ee', 'qui-qui-non-sed-incidunt-quia-67fc6aa1078ee', '<p>Dolores vel nobis qui quo dolore quae inventore. Quae veniam aut earum eveniet quis.</p><p>Placeat cum est facilis nihil harum repellendus et. Totam est sint fugiat voluptas. Minima velit possimus sit doloremque. Libero omnis iste est nihil qui.</p><p>Saepe ut et tempore et. Ea dolores dicta impedit qui. Voluptatem sunt libero possimus est minima et et.</p><p>Et similique et eum vitae reprehenderit. Perspiciatis quidem sunt iure eius explicabo quisquam magni et. Eaque sunt quia sed et delectus quisquam.</p><p>Accusamus ut dolor vel est illo. Beatae qui rem ratione cupiditate cupiditate reiciendis id eum. Eum sed explicabo harum sed enim reprehenderit. Ipsum voluptatibus eius quis ipsum.</p><p>Qui aut vel aut eius. Ex debitis aut maxime est odit praesentium aspernatur.</p><p>Temporibus vero reprehenderit consequuntur dolore. Dolores voluptas fuga non sunt dolor minus. Hic neque iure vel. Quas quis provident quaerat atque. Nam error tenetur dolor ea.</p><p>Eaque quod alias error quibusdam. Ut sapiente adipisci dolor excepturi necessitatibus doloremque. Soluta voluptas voluptatem molestiae totam tempora soluta.</p><p>Nihil nihil amet quia enim consectetur reprehenderit non. A dolore et sed distinctio. A quia quia labore voluptatem sit laboriosam hic.</p><p>Fugiat nobis qui quisquam et numquam architecto. Nobis facilis non et ipsum. Quia omnis est dolore. Quis error accusamus qui.</p><p>Consequuntur non enim natus. Enim beatae iste aut. Fugiat quod laborum cupiditate modi doloremque dolores. Dolores blanditiis rerum dolor quo.</p><p>Dolorem sit eum aut veritatis laudantium veniam aut. Voluptas hic quisquam ea architecto nulla corrupti. Nostrum eos atque sequi suscipit pariatur quod commodi. Facilis qui quidem sit repellat consectetur a.</p><p>Tempora alias quod enim laborum debitis accusantium. Earum aut est assumenda error nisi ut. Voluptatem consequatur qui unde repellat et autem. Accusantium et voluptate eius.</p><p>Quis dolor error saepe eos corrupti. Aperiam perferendis cupiditate sed eveniet. Tempore non deleniti et rem dolor. Sit quam odit dolorum amet ut quod voluptatem.</p>', 'Soluta hic aut sed. Vitae dolor eaque veritatis autem veniam. Fuga qui dolore voluptatem dolorem.', 0, 22, 2, NULL, 'thumbnails/', 'published', 764, 1, '2025-04-06 09:13:09', '2025-04-26 16:02:54'),
(2, 'BV-140425-26067610', 'Esse vel modi in et exercitationem qui. 67fc6aa10cc81', 'esse-vel-modi-in-et-exercitationem-qui-67fc6aa10cc81', '<p>Molestias ipsam sit nostrum ut. Temporibus excepturi similique consequatur. Dolor sit dolore nemo dolores voluptatem odio.</p><p>Perspiciatis ut architecto voluptatum assumenda. Vel dolorem sed quo repellat odit molestiae perferendis praesentium. Et numquam ut consequatur laborum doloribus. Non id distinctio voluptates quaerat. Cupiditate cumque alias rerum unde.</p><p>Voluptatem quia excepturi temporibus non quibusdam et. Nemo ex ad quia. Ea quaerat quaerat non nulla.</p><p>Occaecati non sunt eaque ut veritatis id vero. Nam velit dolor sequi mollitia asperiores temporibus illum. Modi cupiditate ea aut corporis cumque earum dolore.</p><p>Dolores placeat sequi reiciendis ut provident. Quibusdam dolorem deleniti et quo delectus nobis ut. Dolor omnis cupiditate qui assumenda repellendus aut eius.</p><p>Voluptate aut sed accusantium explicabo animi velit. Saepe est ex repellendus accusantium ipsam velit quidem. Sit quo architecto dolorum quam ipsam inventore impedit.</p><p>Consectetur molestiae aut quo et. Rerum delectus est rerum. Alias qui consequuntur ea alias nulla. Eligendi neque et necessitatibus nulla nostrum molestiae consectetur. Ipsa repudiandae ex ad officiis fugiat aut.</p><p>Illum sit dolorem facilis eum. Repellendus omnis autem eum. Ipsum et magni reprehenderit iure autem repellendus. Sit architecto aut mollitia sint.</p><p>Eos qui sint ipsa perspiciatis. Recusandae temporibus omnis necessitatibus et rerum. Nulla eaque sapiente quia nam. Tempora quis nihil ad velit nam.</p><p>Doloremque tempore fuga totam velit minus. Impedit unde quibusdam libero iusto. Odit aut natus amet.</p><p>Perspiciatis minus voluptas occaecati et. Est aut molestias corporis beatae et ab. Magnam amet omnis ut non dolores id qui. Magnam ullam hic quibusdam veniam.</p><p>Voluptatem omnis fuga soluta dignissimos. Sunt recusandae occaecati aliquid. Ut occaecati cumque veniam. Labore quisquam voluptate voluptas eos.</p><p>Tenetur sit veritatis laboriosam. Ipsum incidunt molestiae ut quia. Aut iste in quia rerum numquam saepe rerum. Ea reprehenderit aut eveniet iusto ea libero aut.</p><p>Numquam incidunt debitis voluptates nobis. Perferendis at debitis magnam ad. Modi dolores magni repellat placeat eaque. Soluta ea dolorum sed ea.</p><p>Accusamus error neque est omnis quo ad maiores. Aut assumenda amet dolor suscipit in. Itaque asperiores dolorem magni ut earum. Velit qui aut vel recusandae sint nihil.</p>', 'Quidem et iste suscipit tempore nostrum voluptates quae. Ab velit dolorem ut omnis sapiente culpa non ea. Dolorem sit iusto ipsam aut molestiae. Corporis suscipit ea molestias enim amet est harum recusandae.', 0, 22, 9, NULL, 'thumbnails/', 'pending', 992, NULL, '2025-01-28 01:48:04', '2025-03-02 04:09:49'),
(3, 'BV-140425-95722077', 'Aut accusantium eos blanditiis blanditiis et eveniet ipsam. 67fc6aa117426', 'aut-accusantium-eos-blanditiis-blanditiis-et-eveniet-ipsam-67fc6aa117426', '<p>Explicabo assumenda cupiditate quod et reprehenderit aliquam. Hic et modi repellendus. Aspernatur placeat velit ratione.</p><p>Voluptatibus sit repellat nam harum voluptatem laborum. Earum sapiente magni dolores voluptates dicta. Vitae voluptatem nihil blanditiis totam sint ut. Dolorem officia ullam rem temporibus. Non eligendi dolores neque accusamus impedit fuga vel occaecati.</p><p>Omnis commodi pariatur ab. Quis dolores qui ullam officiis. Vero reiciendis quisquam reprehenderit a explicabo. Facilis blanditiis sed veniam totam sit omnis. Illum tenetur perspiciatis occaecati non ex deserunt voluptatem.</p><p>Qui omnis est dicta quas qui. Possimus pariatur temporibus ut omnis. Aliquam sit et eum dolores veniam.</p><p>Rerum aliquid debitis qui necessitatibus. Non voluptatem enim quod est amet. Iure soluta voluptates ad ut. Quo est omnis exercitationem voluptatem.</p><p>Soluta laborum earum magni fuga et. Velit aut ipsam qui minima cumque sint.</p><p>Et id exercitationem omnis iste et. Inventore dolorem voluptas atque quam. Neque excepturi ipsa molestias perferendis velit iste asperiores. Praesentium molestiae nam quas enim. Dolore est quia sed maxime.</p><p>Rem maiores est repudiandae assumenda. Ipsa eveniet nesciunt assumenda nemo perspiciatis. Ea est quasi perspiciatis vitae autem quasi dolor.</p><p>Earum maiores rerum sed aut asperiores. Et id qui tempora distinctio nisi quis voluptatibus.</p>', 'Sunt veritatis est natus dolorem ullam voluptas et. Facilis voluptatem ut incidunt corrupti aut. Magni distinctio quasi debitis rem aut sint. Minus consequuntur ut explicabo qui possimus qui beatae.', 0, 23, 2, NULL, 'thumbnails/', 'archived', 877, NULL, '2024-10-26 14:07:58', '2025-02-12 02:31:07'),
(4, 'BV-140425-60786915', 'Ex consequuntur voluptatem quas hic. 67fc6aa11ca09', 'ex-consequuntur-voluptatem-quas-hic-67fc6aa11ca09', '<p>Voluptas voluptatibus sunt aut quibusdam non. Ut nam labore qui porro pariatur laborum aliquam ex. Corrupti eius nesciunt molestiae earum fuga.</p><p>Non et sapiente similique et rerum quis. Dolore molestiae laboriosam quod reprehenderit. Sapiente et veniam numquam molestiae sed quasi. Aut et mollitia reprehenderit blanditiis omnis qui omnis dolor.</p><p>Dolores debitis deserunt qui ut numquam. Commodi et dolor quos ipsa consequatur hic aut. Ipsa ducimus ipsam mollitia tempore minima.</p><p>Necessitatibus quibusdam assumenda aut id laboriosam incidunt delectus. Placeat deserunt molestiae quia necessitatibus corrupti. Vitae aspernatur veritatis doloremque ullam dolor culpa. Repellendus qui nam iste nihil sunt.</p><p>Accusamus autem eum sint sit adipisci consequuntur magnam totam. Quia qui expedita eos cumque sed corporis. Dolores recusandae temporibus officia omnis et ut enim. Unde qui cum molestias id laboriosam. Quam aliquam sint mollitia minus iste cupiditate.</p><p>Sint dolor aut qui animi sed quia. Enim consequatur consectetur itaque voluptatem sit expedita. Nam atque corrupti inventore libero impedit est.</p><p>Eum eaque eum aliquid similique nesciunt. Ipsum nam dolor suscipit est. Quis culpa blanditiis ea et omnis est.</p><p>Consequatur itaque labore sit aliquid quidem odio ea. Magnam recusandae perspiciatis esse culpa autem eaque. Blanditiis perspiciatis et aperiam et. Et commodi voluptate amet illo.</p><p>Et atque magni magni adipisci ratione ut. Magnam quis maiores maiores modi. Nemo quo commodi itaque sint. Sed ut temporibus libero quidem cupiditate aperiam aliquam.</p><p>Harum harum labore et dolorum atque aliquid. Accusamus error enim quis culpa eligendi. Et exercitationem eaque eveniet molestias sit nostrum. Et error quasi repellat est numquam pariatur.</p>', 'Consectetur amet reprehenderit sint reiciendis alias nesciunt. Esse autem soluta velit quasi fugit. Illo natus ut sit pariatur modi. At vero dignissimos quo numquam.', 0, 13, 8, NULL, 'thumbnails/', 'published', 566, 24, '2025-01-29 10:14:32', '2025-04-06 06:23:41'),
(5, 'BV-140425-41312669', 'Corrupti debitis ab doloribus repellendus eius officiis perspiciatis aut. 67fc6aa11f5cc', 'corrupti-debitis-ab-doloribus-repellendus-eius-officiis-perspiciatis-aut-67fc6aa11f5cc', '<p>Tempora et est dolor illo aut. Explicabo est tempora adipisci repudiandae voluptatem. Voluptatem in repellendus tempora ullam.</p><p>Magnam voluptate molestiae magnam et assumenda nulla. Sed numquam maxime qui beatae soluta soluta. Veritatis vel voluptas beatae architecto vel assumenda tempora. Enim voluptas sit accusamus earum. Hic eum quis repellat blanditiis pariatur est similique.</p><p>Aut ut ab officia in accusamus dolorem doloremque. Culpa cum et id nemo cumque. Ullam assumenda libero aut magnam maiores.</p><p>Dignissimos minus rerum qui asperiores vero velit sequi. Deserunt praesentium qui illo laboriosam sapiente. Omnis possimus sed delectus et doloribus libero. Non illo aut qui dolorem delectus quisquam repellendus.</p><p>Non enim ullam exercitationem. Autem aut rerum sint ad nemo vero est sit. Error maiores tempora ut assumenda minus. Vero rerum totam cupiditate sed libero maiores.</p><p>Et quidem et alias non. In cupiditate similique rerum qui amet saepe. Rem aliquid qui doloremque consequatur qui itaque in.</p><p>Nam quas aspernatur quod quaerat eum qui libero. A et placeat dolores aut dolorum et consectetur. Fugit velit ut omnis quia quia.</p><p>Iste necessitatibus consequatur dolores eius minima. Voluptatem at repellat quo. A quod recusandae in cupiditate.</p><p>Perspiciatis laudantium quia excepturi sunt est alias consequatur esse. Quae vitae non est. Modi quis voluptates provident amet laudantium veritatis eligendi quibusdam.</p><p>Eaque modi ipsam rem totam iure laborum. Beatae perferendis voluptates at. Et ut aut facilis rerum.</p><p>Est est consequatur sapiente corporis voluptates. Tempore voluptate ut ipsum expedita. At laudantium dignissimos consectetur numquam quis perferendis sit. Amet sunt iste velit natus pariatur porro totam quo.</p><p>Eveniet possimus nulla libero minus consequatur. Necessitatibus facere in deserunt sequi autem.</p><p>Voluptate asperiores ratione fugiat aliquam dolorem architecto inventore. Quidem molestiae incidunt praesentium. Dolores repudiandae aut provident quasi qui soluta corrupti omnis. Sit autem eligendi doloremque.</p><p>Voluptas sequi maiores animi rerum rerum aut nesciunt. In et et suscipit quia quas officia temporibus. Vero vitae non sit cumque.</p><p>Nihil facere ipsam dolorum culpa sapiente explicabo. Quia sed dolor et eius. Aut illo cumque voluptas consequatur. Quis deserunt nemo veritatis molestiae sapiente accusamus eos.</p>', 'Fuga nihil modi est pariatur quo laboriosam. Perspiciatis accusantium culpa vel atque ipsam. Quia odio omnis assumenda et consequuntur omnis. Expedita tenetur aut sunt et id necessitatibus quod.', 0, 7, 1, NULL, 'thumbnails/', 'pending', 617, NULL, '2024-08-17 13:38:00', '2024-08-25 12:50:02'),
(6, 'BV-140425-39847477', 'Cupiditate nihil quidem qui praesentium. 67fc6aa122851', 'cupiditate-nihil-quidem-qui-praesentium-67fc6aa122851', '<p>A quidem mollitia voluptatibus eum ut distinctio. Veniam reiciendis cumque rem.</p><p>Sit velit non fugit. Impedit eos consequuntur quaerat accusantium. Magni sunt qui voluptas dolores eum ullam.</p><p>Atque velit officia perspiciatis amet dolorem officia molestiae maxime. Deserunt vel tempore facilis praesentium quaerat quibusdam voluptas qui. Saepe saepe quibusdam dolorum rem. Ut quam eum quod eos cumque commodi.</p><p>Nesciunt quos facilis ut eos molestias quaerat unde. Architecto aspernatur sint quia rerum unde quo. Qui sint vel delectus consequuntur cupiditate et est. Mollitia consequatur explicabo aut esse neque minus laborum.</p><p>Tempora et maiores et et. Minus adipisci est facilis provident enim expedita. Labore facere ex iusto nulla earum.</p><p>Doloremque molestias velit recusandae et mollitia placeat dolores. Totam impedit molestias voluptas asperiores recusandae ea doloremque dolorum. In facere ut quae soluta.</p><p>Velit et qui qui non. Exercitationem eveniet voluptatem quis vel placeat officiis aut. Et dignissimos facere adipisci quod facere accusamus et.</p><p>Ex inventore est ullam. Nulla quos id asperiores et unde. Sunt delectus quia placeat nesciunt molestiae. Eos ut et molestias ut. Iure officiis ipsa voluptatem dicta ea pariatur.</p>', 'Animi dolor dolorem aliquid sit eaque natus sint asperiores. Recusandae qui est rerum saepe repellat deserunt fugiat. Voluptas dicta officia tempore ut. Sint magnam velit est consequuntur eaque incidunt.', 0, 23, 6, NULL, 'thumbnails/', 'rejected', 426, NULL, '2024-10-05 09:07:59', '2024-10-11 19:37:54'),
(7, 'BV-140425-07667673', 'Rerum vel et itaque dolores omnis iste in. 67fc6aa125cb7', 'rerum-vel-et-itaque-dolores-omnis-iste-in-67fc6aa125cb7', '<p>Dolores hic quia voluptates omnis voluptatibus veritatis et. Praesentium ullam amet consectetur occaecati. Quaerat porro vel quos possimus.</p><p>Adipisci mollitia id molestias quo eligendi libero officia tenetur. Mollitia voluptas aut amet commodi. Velit officia sit officia distinctio aut et ipsam.</p><p>Corrupti voluptatem sed cupiditate id consequatur. Rerum nemo ut quidem incidunt occaecati maxime expedita. Vitae repellendus provident enim.</p><p>Eum veniam possimus incidunt recusandae ipsam. Debitis sed et repellat sed. Quibusdam est vel voluptas nemo. Neque esse ut quidem quod. Veritatis rerum occaecati molestias.</p><p>Accusamus ea facere minima aut totam dolores iusto. Sed inventore non vero delectus iusto unde aut. Corrupti magnam voluptatem tempora ipsam tempora aut ipsam. Non atque et qui modi quod. Nulla et corrupti unde ullam.</p><p>Ratione dolor quas et ut inventore dolor et. Sunt eveniet praesentium voluptas ex sequi sit unde laudantium. Nemo pariatur porro corrupti et asperiores earum. Ipsa eius quam et.</p><p>Esse officiis sint modi accusantium rem quia. Blanditiis placeat placeat sunt molestiae quis iure ratione ipsa. Ipsam illum modi sint qui et alias.</p><p>Doloribus omnis aut consequuntur rem consequatur reiciendis et. Molestias officiis laborum ducimus velit culpa a. Sint velit nobis in fugiat atque. Quae soluta qui voluptas totam aperiam provident. Minus eaque nulla et alias.</p><p>Neque debitis saepe error ut voluptatem aliquam adipisci ea. Consequatur nemo reiciendis beatae laudantium aut. Ut fugit ut quis maiores quo impedit rerum officiis.</p><p>Consequuntur harum sint modi quaerat. Similique sequi libero quidem voluptates. Eos quisquam impedit fuga ea voluptas in. Enim nulla debitis quisquam recusandae.</p><p>Nam cupiditate deserunt corporis. Accusantium dolores incidunt corrupti. Blanditiis tenetur autem et consequatur eius quis.</p><p>Et eos perspiciatis soluta in velit corrupti et explicabo. Dolor iusto officiis vero aperiam quis ratione delectus.</p><p>Provident consectetur id fuga suscipit earum. Dolor autem qui qui nesciunt deserunt. Nihil aliquid et nihil molestiae quidem. Earum repellat earum similique ea.</p>', 'Itaque ipsam dolore temporibus veniam. Voluptate eius maiores reprehenderit nesciunt nemo voluptas repellat. Eius optio cumque ex quaerat mollitia reprehenderit dolorum vel.', 0, 7, 9, NULL, 'thumbnails/', 'rejected', 872, NULL, '2025-03-17 03:20:25', '2025-04-11 22:01:00'),
(8, 'BV-140425-09241092', 'Repellat omnis eius enim consequatur quod alias eveniet minus. 67fc6aa128e0b', 'repellat-omnis-eius-enim-consequatur-quod-alias-eveniet-minus-67fc6aa128e0b', '<p>Id maiores nam nobis quo eos maiores. Omnis sequi aut non eaque odio et.</p><p>Molestias exercitationem omnis rerum distinctio. Magni et voluptate et quis voluptates. Omnis voluptas pariatur totam et pariatur consequatur. Et et ut nesciunt at.</p><p>Perferendis earum qui tempora et dicta maiores et vitae. Dolor quidem autem voluptatem quo est expedita maxime inventore. Dolorum repellendus suscipit quaerat laborum facilis vel inventore.</p><p>Sit a aut sint omnis et et. Magnam omnis ex porro velit enim nisi fugit. Libero rerum voluptatem sint nihil magnam sit ex. Et quae quod alias asperiores suscipit magnam.</p><p>Qui perspiciatis modi est error. Sed et quis et omnis modi. Aut itaque voluptatibus qui nulla quia impedit eveniet ut. Rerum repellat eum autem qui ex consequatur aperiam beatae.</p><p>Id consequatur repellendus accusantium ut. Qui nihil necessitatibus nesciunt molestiae necessitatibus non modi praesentium. Sequi dolorem voluptatum quaerat omnis aliquid expedita. Mollitia voluptatum quis sit quo eveniet.</p><p>Et expedita quod magnam et dolores. Id ex nihil earum qui eveniet facere. Sint rerum unde placeat placeat. Temporibus aut maiores neque unde.</p><p>Voluptas minima laborum vero repellat facilis rem quam ipsum. Ea consequatur facere numquam quia ab dolore. Voluptatem dolor tenetur quia esse velit vel. Veritatis dolore maiores est dignissimos et aut.</p>', 'Itaque voluptates dolorum qui perspiciatis. Vel non ut error aut nostrum ullam. Est officiis molestiae quam commodi corporis deleniti vitae sunt. Iste minima ex et ea. Recusandae natus minima rerum in ea quisquam.', 0, 7, 10, NULL, 'thumbnails/', 'draft', 264, NULL, '2024-05-16 19:25:33', '2024-05-22 16:41:51'),
(9, 'BV-140425-03690081', 'Voluptatem dolor est rerum. 67fc6aa12d68d', 'voluptatem-dolor-est-rerum-67fc6aa12d68d', '<p>Ut at quae amet atque mollitia quas voluptate. Eligendi aut dolorem odit et. Cum in neque amet dolorum id eligendi. Nihil repudiandae et voluptas totam molestias qui blanditiis quam.</p><p>Recusandae assumenda ut incidunt eveniet excepturi. Itaque et quia voluptatibus ab explicabo. Vel sint assumenda perferendis a veritatis.</p><p>Perferendis aliquid nobis ratione mollitia provident. Recusandae distinctio sapiente adipisci voluptatem temporibus. Ipsam eaque harum illo sequi non eum.</p><p>Rerum perferendis dolorem labore quasi assumenda ullam quo doloribus. Quia nemo excepturi totam unde possimus incidunt voluptatem. Iste expedita ad consequatur iure consequatur accusamus. Blanditiis ipsa omnis aut cum numquam.</p><p>Aut quisquam et ut. Enim voluptatum unde debitis magnam earum dicta tempora sed. Deleniti quidem perferendis vel iure explicabo.</p><p>Error modi et occaecati earum ratione repudiandae. Sunt quisquam aut ut et nihil voluptate est.</p><p>Error voluptatem nisi quas possimus qui dicta sint. Consequatur laborum amet commodi recusandae nihil. Blanditiis voluptas molestias maiores nisi et harum sit accusantium. Dolorem adipisci quo omnis aut repellendus voluptas fuga velit.</p><p>Vitae qui quo non quasi exercitationem esse unde. Ab omnis molestias velit tenetur repudiandae asperiores voluptatem. Ipsum quod sit odio. Ut enim nesciunt voluptas animi suscipit.</p><p>Maxime error neque laudantium consequatur. Culpa vel sit labore ullam quisquam.</p><p>Aspernatur culpa incidunt aut voluptas numquam. Ad est sint maiores eveniet aliquam fuga. In quaerat non voluptatem.</p><p>Necessitatibus autem odio tempore sapiente sed nihil et. Occaecati occaecati eligendi dolores assumenda. Beatae sint fuga vel voluptatem illo sunt.</p><p>Voluptates beatae velit enim laborum suscipit. Quia a facilis minima architecto eos. Aspernatur at et ut quo.</p><p>Cum omnis aliquam quis voluptas nobis vitae debitis. Unde ut dolorem sed. Dignissimos commodi dolor odit sint. Velit et aut aut qui error.</p><p>Officia aut magnam doloremque labore. Laudantium ipsum minus sunt eius explicabo quia. Accusamus quo quo reprehenderit odit ut quidem. A voluptatibus adipisci cupiditate labore.</p><p>Maxime praesentium mollitia voluptatem laborum nihil. At tenetur consequatur quas repellendus quam excepturi voluptas necessitatibus. Iusto unde aliquid enim culpa et sed.</p>', 'Cupiditate non voluptas est rerum culpa. Aliquid dolorum qui eveniet voluptas repudiandae voluptate. Qui omnis rem nihil quia inventore debitis. Porro voluptates rerum est sint sed odio.', 0, 7, 1, NULL, 'thumbnails/', 'rejected', 266, NULL, '2024-08-10 19:34:40', '2024-10-19 01:00:13'),
(10, 'BV-140425-79906486', 'Et nihil illum aut aut neque. 67fc6aa13076b', 'et-nihil-illum-aut-aut-neque-67fc6aa13076b', '<p>Alias labore maxime architecto nobis corporis pariatur aut. Inventore reiciendis aperiam veritatis suscipit. Possimus soluta facere doloremque similique aspernatur quia. Magnam et veritatis neque vel dolores vel sequi.</p><p>Eaque aut repellendus autem laborum omnis quam. Ex dolorem nemo fugit. Harum et dolores et culpa consequuntur nihil quia consequatur.</p><p>Veritatis perspiciatis sint vitae illo eius suscipit aut. Nobis magni similique rem distinctio. Alias saepe quisquam iste reiciendis recusandae nostrum quisquam.</p><p>Voluptatibus voluptas in vitae doloribus. Voluptatem voluptatem labore qui debitis ut. Error quis error aut officia nostrum iusto incidunt. Quidem magni deserunt temporibus odio veritatis tempora consequatur.</p><p>Laboriosam accusamus laudantium consequatur voluptatem reiciendis consectetur. Natus molestiae rem vel rerum qui placeat. Deleniti aperiam tempora non aut. Soluta ut sit a sit omnis.</p><p>Est est eum dicta rerum. Quasi voluptatem possimus debitis dolore voluptas accusantium. Delectus magnam exercitationem nisi.</p><p>Et voluptatibus voluptas accusamus. Dignissimos nostrum et aut modi praesentium et dignissimos. Aut pariatur sunt officiis unde voluptas. Culpa est doloribus repellendus sunt reprehenderit.</p><p>Mollitia aliquid rerum aut laudantium. Cum dolor voluptate eos qui eos vel. Quam et enim suscipit eligendi accusantium ipsam. Est laborum repudiandae recusandae voluptate nihil unde iste.</p><p>Ut veritatis veritatis nihil delectus repudiandae. Laudantium laudantium officiis qui. Sunt vel expedita itaque. Laborum beatae ratione asperiores quia incidunt explicabo. Dolorum necessitatibus porro consectetur aspernatur voluptatem optio.</p><p>Dolorum sunt rerum placeat delectus. Corporis fugit qui repellat et sequi. Tenetur saepe adipisci exercitationem voluptates quas.</p><p>Sit ut eos non id eum hic delectus. Itaque voluptas ab consequatur iusto eum ab libero id. Accusantium maiores dolorem sit veniam explicabo enim.</p>', 'Magnam voluptas eveniet non. Quis ullam eum commodi sunt magni neque enim totam. Dolorem at ullam repudiandae ratione. Praesentium et totam et ipsum et dolorem dolores.', 0, 5, 7, NULL, 'thumbnails/', 'rejected', 238, NULL, '2024-05-01 13:08:18', '2025-04-09 11:50:12'),
(11, 'BV-140425-02704727', 'Eos consectetur quia eum enim blanditiis modi est id. 67fc6aa13b271', 'eos-consectetur-quia-eum-enim-blanditiis-modi-est-id-67fc6aa13b271', '<p>Veniam aut doloremque eos. Excepturi voluptatem ad velit laboriosam amet. Et consequatur aut quam nihil consequatur exercitationem quae. Unde aspernatur perspiciatis in vel.</p><p>Dolore in ex voluptas qui et modi quo. Ab minima unde sint voluptatem accusantium. Provident eligendi voluptate voluptatem veritatis. Est enim quibusdam ab est aliquam culpa eveniet ut. Possimus libero veritatis ut sapiente.</p><p>Nesciunt illo et reiciendis sint dolorem. Laborum ut temporibus consectetur dolorem tenetur enim cumque. Perspiciatis ut odio perferendis vel fugiat.</p><p>Culpa qui omnis laborum vero excepturi iusto et. Quia doloribus itaque nobis odit dolores. Eaque earum temporibus quia sapiente enim cum aliquid. Delectus repellendus facere accusantium temporibus.</p><p>Sunt quam doloribus quod. Provident cupiditate aspernatur animi eius expedita. Voluptas velit consequatur molestiae aut aliquid eveniet velit. Vero molestiae ea fugit minus fugit neque quidem.</p><p>Ut esse adipisci culpa voluptatem. Iusto quo dolorem dolor. Tempora dolorum magnam minima veniam sed est. Odio illo rem perspiciatis a et accusantium.</p><p>Eaque cupiditate voluptatem eum reiciendis necessitatibus maxime esse. Laboriosam atque eligendi eos non. Aliquid numquam omnis et consequatur saepe.</p><p>Autem illo autem quis odit dolorem impedit. Eveniet nulla et voluptatem et recusandae quidem quasi rerum. Odit sed sit ea et. Accusamus aut et cumque.</p><p>Dolorem vero totam ipsum qui. Omnis ut iusto assumenda ullam ipsam aut. Consectetur vel doloremque iusto explicabo.</p><p>Illo aspernatur perferendis et nemo totam numquam. Sit rerum occaecati enim. Quas consequatur accusantium voluptates est porro.</p><p>Est et dolorum atque corporis et rerum soluta. Minima nisi et placeat vel molestiae inventore sunt. Perferendis et debitis eligendi iusto distinctio id eum. Eaque minima iusto debitis ducimus iusto cupiditate quis.</p><p>Vitae enim non delectus minus. Quasi culpa omnis deserunt ut. Aut vel nesciunt earum nobis provident. Expedita non quas modi velit dicta sit.</p><p>Ut corrupti illum quas aut quaerat. Ullam possimus amet cum quisquam rerum aspernatur cumque. Quisquam fugiat est exercitationem error nihil sit.</p>', 'Blanditiis quidem voluptatum consectetur vel porro eaque voluptates. Autem nulla aut voluptatem ut autem.', 0, 22, 10, NULL, 'thumbnails/', 'archived', 851, NULL, '2024-05-30 22:16:33', '2025-02-14 23:58:31'),
(12, 'BV-140425-80624707', 'Voluptas velit itaque et consequatur ipsum mollitia doloremque. 67fc6aa13e520', 'voluptas-velit-itaque-et-consequatur-ipsum-mollitia-doloremque-67fc6aa13e520', '<p>Illum explicabo aut aut quam. Provident illum qui quam unde soluta. Ut quibusdam dolores dignissimos est est expedita.</p><p>Rerum molestias harum labore minima ut et nesciunt. Qui accusamus consequatur ea. Minus explicabo non eius aliquam velit. Sed ut et sed et.</p><p>Est eligendi rem et et dolorem. Et omnis qui perspiciatis nostrum sed id consectetur. Quis beatae fugit rerum qui id animi doloremque. Ratione rerum sapiente hic deleniti nostrum.</p><p>Atque harum error distinctio ad odit. Omnis beatae qui placeat aperiam qui delectus est. Neque tempore accusamus ab neque quaerat dolorem nisi. Ad possimus accusamus omnis aut voluptatum voluptas labore.</p><p>Mollitia enim aut sequi harum iste doloremque. Ad fuga aperiam est rerum. Aut molestiae dolores commodi nihil.</p><p>Aut nobis vel ut repellendus qui. Est consequatur eligendi dolores non recusandae. Iusto quidem ducimus repellat et. Dolorem suscipit sunt ipsa hic.</p><p>Exercitationem rerum recusandae numquam repellendus quam et aut. Error dicta itaque commodi. Similique omnis vero possimus aut voluptatem. Voluptas id soluta ad sit voluptatem.</p><p>Numquam non corporis consequatur doloremque ea qui quis quia. Consequatur voluptatibus dicta in quo. Non laboriosam et aliquam pariatur recusandae non aliquam exercitationem.</p><p>Tenetur assumenda distinctio voluptatem officia aliquid. Consectetur fugit magni tenetur cupiditate est officia. Doloremque in assumenda porro natus repellat dicta. Deleniti qui ipsam qui consequatur suscipit vel.</p><p>Ut explicabo modi asperiores aliquid omnis. Fuga voluptate inventore nisi. Debitis veniam perferendis omnis corporis reiciendis sequi ut.</p>', 'Ipsam voluptas sit sequi et distinctio quaerat. Sit sapiente quos mollitia tenetur repellendus et et neque. Reprehenderit ea error soluta ad culpa ipsa. Eum consectetur quo aut veniam tenetur fugiat.', 0, 23, 9, NULL, 'thumbnails/', 'draft', 719, NULL, '2024-10-01 07:45:10', '2024-11-05 10:41:13'),
(13, 'BV-140425-78159706', 'Quas adipisci velit sint animi fugit magni. 67fc6aa143052', 'quas-adipisci-velit-sint-animi-fugit-magni-67fc6aa143052', '<p>Voluptatem eos voluptas corporis fuga placeat facilis. Ad quos nisi tenetur itaque non. Rerum qui quo illo et amet repudiandae voluptatibus.</p><p>Est totam omnis repellendus rem non. Repellat rem quia aspernatur vel error qui quae voluptatem. Esse ex quos excepturi sed quaerat non placeat.</p><p>Fuga atque qui molestiae a et et quo. Esse ut placeat necessitatibus vel expedita asperiores commodi. Amet at facere dolorum sunt cupiditate officia aliquid.</p><p>Ut molestias voluptatem non autem voluptates. Atque et delectus minus itaque pariatur. Enim iste dolorem cupiditate qui architecto error. Et temporibus eveniet dicta quod est.</p><p>Sunt magni sunt repudiandae voluptatibus possimus maxime. Minus eos incidunt provident. Tempore non animi aut aliquam. Culpa cum est et sit nobis aut.</p><p>Ut laboriosam fuga praesentium voluptas. A autem dolorem veniam velit. Beatae molestiae dolorem aut qui quidem nam. Consequatur distinctio quia voluptatum et magnam eum fugit. Corporis est provident tenetur rerum tempore autem.</p><p>Saepe iusto est veniam in est. Consequatur voluptates maiores quam eaque. Distinctio nemo dolor esse ab recusandae. Architecto rerum architecto quasi fugit aut quisquam minus.</p><p>Dolorem incidunt aut exercitationem quidem vero qui assumenda. Rerum corrupti a corporis et ratione ipsam. Dolorum qui ut beatae et rem. Rerum nisi eum excepturi voluptates nobis quia.</p>', 'Et quibusdam aut dolorem iure. Non aut totam labore ratione. Iste ut aspernatur quia laboriosam unde et error. Aut ipsam ex fugiat sunt odit doloribus quidem.', 0, 4, 1, NULL, 'thumbnails/', 'pending', 153, NULL, '2024-12-21 13:25:58', '2025-02-19 07:12:50'),
(14, 'BV-140425-14748173', 'Illo perspiciatis tenetur ab saepe optio dolorem unde. 67fc6aa14a3ef', 'illo-perspiciatis-tenetur-ab-saepe-optio-dolorem-unde-67fc6aa14a3ef', '<p>Dolor ea quod sit quia. Voluptatem sunt totam minima vel hic est. Eos cupiditate maxime tempora id perferendis rerum id. Ut provident itaque veniam sequi.</p><p>Dolorum ipsum ipsum alias. Et nihil ullam vel maiores quam illum quae. Sint qui voluptatem molestiae voluptas dolore eum autem. Commodi consequatur in vel est repudiandae. Saepe architecto quasi minima quae eum nesciunt veritatis.</p><p>Error voluptatem eaque ducimus in aut animi. Suscipit quae rerum consequatur voluptates. Praesentium ipsam distinctio quia.</p><p>Accusamus blanditiis autem nam ut qui ea. Rerum facere voluptatibus consequuntur dolorum. Delectus quisquam alias consequatur explicabo sit animi voluptatem.</p><p>Ea officia nihil ut fugit est explicabo ut debitis. In est nihil id aut perspiciatis asperiores qui. Doloribus sapiente ex ad.</p><p>Dicta harum voluptatem aspernatur totam excepturi dolorem. Sunt aut eligendi et placeat dolorem fugit ut. Minus voluptates ut debitis.</p><p>Tempore similique nesciunt neque aut ut inventore. Dolorum dicta accusantium voluptatum saepe. Voluptatem perferendis rerum maiores reiciendis eaque qui sed rerum. Ex omnis et et voluptatibus voluptatem dicta magnam voluptas.</p><p>Earum amet corrupti eaque cumque in voluptate. Sit consequatur ea earum ducimus incidunt. Recusandae architecto id quae excepturi eos omnis inventore et.</p><p>Aliquam non consectetur non eaque. Cumque quia voluptas quod ea. Magnam enim ut et voluptatum eaque architecto. Rem et harum possimus voluptatem illo sed dolor.</p><p>Ratione mollitia sint quidem pariatur est deserunt doloribus. Blanditiis accusamus blanditiis aut aut blanditiis debitis id recusandae. Provident nemo velit qui voluptatibus. Maiores sequi consequatur laboriosam rerum ut deserunt.</p><p>Consequatur id nam fuga et at architecto exercitationem sunt. Sit aut eum aut sapiente. Nulla minima excepturi veniam dolorum in qui aut.</p><p>Enim inventore inventore qui voluptatum. Rerum qui quia itaque et ut et. Blanditiis consectetur molestiae id provident sequi distinctio molestiae provident.</p><p>Quia aut ratione ut laudantium et et magnam quo. Eum commodi harum nulla adipisci nulla consequatur. Delectus iure odit alias vitae aperiam quia. Omnis aut accusantium quaerat voluptates accusantium sit nobis. Et autem recusandae et rerum aut debitis velit.</p><p>Dolor iusto consequatur sit est nostrum reiciendis ratione. Ut eligendi repellendus repellendus quae voluptatem voluptas aut. Ex cumque voluptatum vero nostrum rerum quas. Suscipit quas dolores occaecati est aut.</p><p>Quas nam velit nesciunt. Nostrum rerum iste eum iusto aliquid assumenda eos.</p>', 'Magnam maxime officia saepe sit non commodi et. Rem blanditiis ut eum doloremque.', 0, 5, 1, NULL, 'thumbnails/', 'archived', 579, NULL, '2024-09-24 02:23:26', '2025-04-05 16:34:07'),
(15, 'BV-140425-65266275', 'Tempora exercitationem officia quis libero. 67fc6aa14ceb3', 'tempora-exercitationem-officia-quis-libero-67fc6aa14ceb3', '<p>Eum beatae ut quibusdam maiores voluptatem. Ut laborum eligendi sequi et doloribus enim.</p><p>Dolore hic sunt veritatis est est quam quisquam atque. Assumenda et corrupti perspiciatis qui saepe sit eaque perspiciatis.</p><p>Repellendus ipsa in vero ipsum repudiandae quia. Voluptas eum voluptate et ut enim nobis. Magni fuga voluptatem aut deserunt.</p><p>Quia autem libero minima impedit sint dicta et vero. Velit officia delectus magni ducimus. Similique repudiandae iste repudiandae iure aut similique aliquam quidem. Velit quas voluptatum quia ea odio vitae.</p><p>Eius et est recusandae laudantium. Placeat ut sit odio ratione. Sit perferendis asperiores rerum expedita velit. Voluptatem aut expedita sed.</p><p>Quasi sint nemo quo ducimus. Nobis aut deleniti voluptas minima fuga est et qui. Quam eum officia voluptate ullam. Minus similique repellendus quis illum.</p><p>A aut sed sed fuga ullam eum in. Est natus laboriosam non vitae non aut. Et iste impedit est voluptas accusamus.</p><p>Vitae facilis veniam ab qui est impedit et. Ut veritatis quae impedit voluptatibus tempora. Hic illum sit et rerum natus quae est dolorem. Voluptas blanditiis modi magnam praesentium corporis corrupti quia.</p><p>Dolor est dolor adipisci quo assumenda dolor vero occaecati. Placeat quis atque cupiditate repellendus. Earum qui quaerat et veniam. Sequi quia ipsa fugit possimus.</p><p>Nihil explicabo illo laborum at iusto earum numquam. Sit voluptas est velit iure reprehenderit nostrum. Rerum voluptatem officia minima exercitationem impedit dolore.</p>', 'Veniam et consequatur a. Qui dolore aut optio commodi ipsum exercitationem. Perferendis est dignissimos fugit corrupti.', 0, 23, 9, NULL, 'thumbnails/', 'archived', 267, NULL, '2024-08-16 02:42:58', '2024-10-08 12:33:00'),
(16, 'BV-140425-53516906', 'Incidunt ullam rem blanditiis qui et consequuntur esse. 67fc6aa14f953', 'incidunt-ullam-rem-blanditiis-qui-et-consequuntur-esse-67fc6aa14f953', '<p>Corporis velit inventore pariatur mollitia qui animi. Aut molestiae voluptas qui culpa at. Aut molestiae facilis sunt voluptate.</p><p>Vel eos qui quos qui rerum. Quasi unde ut ut qui exercitationem delectus. Tempora et sequi animi suscipit reprehenderit recusandae.</p><p>Aperiam eligendi aut ut consequuntur magnam ex nostrum. Doloribus nostrum voluptatum cum repellendus. Fuga eos omnis deleniti alias eveniet natus maiores accusamus.</p><p>Porro vero dignissimos nihil laudantium ut perferendis accusantium. Et quasi itaque inventore aut. Amet aut dignissimos non nostrum. Maxime neque eum libero qui veniam.</p><p>Totam est commodi qui voluptas nam est voluptatem suscipit. Laborum sequi et quas pariatur aliquam. Impedit earum hic doloremque quos nesciunt eaque.</p><p>Natus aliquam consequatur eos harum. Voluptatem eligendi ea voluptates beatae in.</p><p>Sequi eligendi harum omnis eum architecto. Dolores cumque cum sed voluptas corporis occaecati quaerat. Sed quam tenetur in consequatur at occaecati. Sit sit molestiae magnam quo.</p><p>Omnis possimus quod culpa ipsam dicta alias. Aut perspiciatis non nam nisi dolores ut. Ab ea dolorum omnis et quia quam. Sunt ut voluptate veniam accusantium itaque est.</p><p>Repellat voluptatem rem corrupti ratione. Soluta aspernatur in et recusandae itaque et est maxime. Quas quam qui maxime delectus omnis dolores.</p><p>Occaecati qui earum est et sed. Suscipit nobis temporibus est distinctio impedit fugit aspernatur.</p><p>Est odit ratione repudiandae minima ut non. Laudantium qui repellendus eos rem blanditiis. Numquam nisi ea porro harum ut voluptatem.</p><p>Eos veniam odit nihil eum vero. Itaque minima commodi nihil sunt aliquid. Sed enim unde et.</p><p>Sunt voluptatem aut sunt aut repudiandae et dolores aliquam. Facilis sit et corporis quia in repellendus voluptate. Velit et mollitia voluptas et. Eos sapiente omnis enim quaerat ut voluptatum et.</p><p>Nesciunt dicta laborum et ut. Fugiat corporis inventore architecto exercitationem iure similique. Atque magnam et sit minima et quas.</p>', 'Reiciendis at laboriosam itaque. Iure ipsam reprehenderit odio omnis quis nisi sint. Et nisi qui aut error consequatur molestiae harum. Repellendus qui iusto maiores eum maiores. Nesciunt sed unde beatae rerum.', 0, 13, 1, NULL, 'thumbnails/', 'published', 476, 12, '2024-05-17 08:55:18', '2025-04-14 02:09:06'),
(17, 'BV-140425-90550524', 'Voluptatibus qui aut et. 67fc6aa154ccb', 'voluptatibus-qui-aut-et-67fc6aa154ccb', '<p>Ullam vitae sit sed. Nihil unde alias molestiae facilis quis minus repellat. Omnis iusto accusantium sit et.</p><p>Voluptatem nihil culpa cum officiis soluta adipisci. Corporis ullam enim maiores deserunt sint repellendus deserunt quasi.</p><p>Quis et nihil quos necessitatibus officia non nihil. Vero et voluptatum velit quo. Consectetur dolorem repudiandae ullam ab. Dignissimos rem harum dolor enim mollitia repudiandae.</p><p>Qui nam doloremque natus similique quo est. Quos qui possimus et magni est. Quia veniam eligendi ipsa sequi occaecati earum. Dignissimos provident laborum recusandae quod.</p><p>Aut ipsa aut amet et. Enim et non doloribus non est magni cumque odio. Commodi asperiores inventore a omnis beatae quo est.</p><p>Est non et quibusdam laudantium. Voluptas eum id modi ratione eum magnam alias est. Dolorem ut non facilis doloribus soluta atque. Maxime reprehenderit ut culpa error eligendi.</p><p>Voluptatem consequatur quis et tempora. Quia quidem et facilis culpa aliquid illum enim. Minus molestias atque blanditiis sint aut quis.</p><p>Consectetur ducimus et corrupti nam possimus ducimus qui. Velit exercitationem facilis quo quo voluptatem deserunt. Ut saepe et laudantium unde optio sed et repellat.</p><p>Voluptatem omnis possimus possimus ratione qui. Nihil illo quia nisi iure ut. Libero veniam accusamus et repellat exercitationem dolore ea. Occaecati vel molestiae explicabo fuga saepe. Odio quam pariatur ullam ullam excepturi provident dolorum qui.</p><p>Ratione dolor consectetur ipsa natus est laudantium laboriosam non. Consectetur voluptatem nihil tenetur ut id dolore et. Debitis dolor est porro ut quas aliquam.</p><p>Vel voluptatibus et odio quia ratione dicta qui optio. Velit tempora molestias autem et et corporis. Accusantium cumque est aliquam quia cupiditate. Qui quidem in dolorum minus fugiat.</p><p>Odit dolor odio tenetur provident. Sit non culpa est animi rerum. Repudiandae similique perspiciatis dolorem vel asperiores assumenda aut aspernatur. Voluptas ipsam ut porro.</p><p>Quia soluta dolorem tempore. Ipsam asperiores voluptate et nihil veritatis voluptate. Accusamus fugit aut maiores dolores.</p><p>Aperiam vel aut laudantium labore. Sed rerum quia debitis animi in. Asperiores natus quas ducimus.</p>', 'Laudantium qui voluptas saepe et et. In et aut dolores et inventore et omnis. Voluptatem sapiente culpa vero expedita ut. Est et quis recusandae unde sed tempora delectus.', 1, 13, 2, NULL, 'thumbnails/', 'published', 420, 20, '2024-11-01 05:45:41', '2024-11-19 09:16:23'),
(18, 'BV-140425-74519503', 'Odit debitis ducimus unde eum consectetur hic et. 67fc6aa158fe3', 'odit-debitis-ducimus-unde-eum-consectetur-hic-et-67fc6aa158fe3', '<p>Aut voluptatem est occaecati alias et mollitia et. Cumque veniam voluptatibus magni incidunt delectus rem.</p><p>Eos magni sit eum. Eum quia similique ducimus reprehenderit. Voluptate quisquam eos maiores natus voluptatem. Suscipit sed esse facere facere.</p><p>Natus explicabo mollitia praesentium distinctio facilis in. Quia quod fuga aut et fuga ut. Accusantium eligendi culpa magni beatae incidunt occaecati. Tempora blanditiis id expedita numquam nemo assumenda minus.</p><p>Qui dolores expedita nam. Ullam laboriosam ab doloremque necessitatibus ut. Maxime aut fuga et molestiae.</p><p>Ut ullam placeat mollitia cum quis. Aut aperiam aut qui amet. Quod dolorem dolorem repudiandae eaque rerum.</p><p>Et provident ut nihil possimus tenetur. Ut non dolore et nesciunt. Praesentium eius quis dolores sapiente qui. Tempore maiores voluptas est blanditiis.</p><p>Vitae sunt inventore aut eos. Est adipisci soluta id eveniet rerum. Libero minima ipsa voluptatem quis.</p><p>Qui atque harum ut. Ut et exercitationem ipsam consectetur autem. Ab accusantium blanditiis voluptas error numquam nobis porro doloremque.</p><p>Ut magnam aliquam repellat quo. Nulla voluptatem laudantium hic consequatur. Necessitatibus consequatur cupiditate sint eius. Illum quibusdam ducimus vitae minima asperiores assumenda. Corrupti deserunt porro placeat consequuntur voluptas non minus.</p>', 'Doloremque ut eos laborum asperiores similique. Est laudantium tempora autem distinctio commodi recusandae vero.', 0, 22, 7, NULL, 'thumbnails/', 'rejected', 149, NULL, '2025-01-11 08:18:22', '2025-02-24 19:42:27'),
(19, 'BV-140425-94470396', 'Quas ut architecto velit. 67fc6aa15d38c', 'quas-ut-architecto-velit-67fc6aa15d38c', '<p>Sint vero labore dolores. Voluptates mollitia nam consequatur consequatur qui officia. Fugit sapiente assumenda beatae optio repellat.</p><p>Qui aliquid ut repellendus facilis hic. Nam et dolor ab sint. Expedita exercitationem enim voluptates autem excepturi hic officia. Sint maxime optio officiis ad.</p><p>Rerum animi sit vero molestiae. Excepturi eveniet rerum repellat ea magni qui fugiat. Officia provident nam et dicta aut ipsum. Harum sed repellat sed deleniti labore blanditiis ducimus quam.</p><p>Ipsum quis ullam aperiam omnis qui. Dolorum quibusdam et nulla id. In dolore aut ut id nulla aut qui. Minus rem vero veniam corporis neque quaerat. Quos eos quibusdam et enim dolor aut.</p><p>Sunt amet et nulla ullam non. Consequatur inventore et odit.</p><p>Voluptates voluptatibus sunt nobis molestias totam. Quisquam cumque earum voluptatibus illum velit.</p><p>Maiores fugiat illo inventore delectus pariatur ut sunt repellat. At in ipsa dolore. Tenetur quisquam culpa quidem consequatur omnis.</p><p>Nesciunt accusamus voluptatem nostrum ut quo et accusantium mollitia. Provident veritatis quibusdam iusto et nemo. Et est mollitia impedit sapiente doloribus et.</p><p>Dolores in nulla iste sed. Dolor placeat et eum. Vel necessitatibus molestiae et veniam non.</p>', 'Voluptatem ad laborum error quasi eaque quos. Deleniti accusantium consequuntur nostrum quasi consequuntur sit assumenda ab. Sequi ea omnis officia fugit id. Ipsum maxime sit et et officia rem ratione.', 0, 22, 8, NULL, 'thumbnails/', 'rejected', 388, NULL, '2024-05-26 03:37:47', '2025-02-04 01:23:05'),
(20, 'BV-140425-28515438', 'Quis dolor perspiciatis animi dicta suscipit aliquid ipsa incidunt. 67fc6aa15fdf1', 'quis-dolor-perspiciatis-animi-dicta-suscipit-aliquid-ipsa-incidunt-67fc6aa15fdf1', '<p>Nostrum ut velit optio quis. Eos dolorum libero et sapiente eveniet. Voluptatibus aperiam porro qui tempora saepe. Voluptatem ratione deleniti tempora distinctio a.</p><p>Fuga commodi qui ut quaerat. Qui dolorum pariatur at nobis. Ut dolorem est voluptas modi necessitatibus voluptatem.</p><p>Ut distinctio sunt et laborum sit molestiae quo. Tempore illo qui laboriosam distinctio. Alias amet ratione et alias dolores placeat.</p><p>Et explicabo vero qui laborum quibusdam. Est velit nisi optio corporis quisquam et ut. Qui consequuntur aliquam ducimus rem. Enim quis illo iusto quaerat qui velit earum.</p><p>Non ut est odit dolores omnis quia. Quia id esse iusto tempora. Voluptas impedit sed illum veniam omnis dolor.</p><p>Repudiandae laborum impedit voluptatibus accusamus sit sit. Vel rerum asperiores est dolorum. Esse iusto id ullam voluptatem temporibus.</p><p>Eum culpa esse velit optio cumque. Qui sunt rem ut dicta totam placeat dignissimos et. Harum id dolorem hic. Autem aspernatur dolor eum et eius beatae corporis.</p><p>Temporibus dignissimos qui quam voluptatem. Cum earum dolor aut quas. Culpa rem sequi ut laudantium nulla. Tempore quos aliquam rerum dignissimos ducimus corporis.</p><p>Et libero accusamus fugiat commodi numquam qui quod. Error sit voluptas voluptas quibusdam. Consequatur omnis cupiditate sunt reprehenderit autem sed. Sint id assumenda harum voluptatem voluptatem doloremque.</p><p>Quia quo non magni ipsam repellendus cumque. Fuga nobis et quia ratione quia nihil qui. Aut occaecati quos est sed.</p><p>Ea assumenda saepe esse architecto. Expedita sunt quaerat quia dolores sunt id ab cupiditate.</p>', 'Ut veritatis veritatis totam quae soluta quod quam. Voluptatum amet aut cupiditate qui ipsam voluptate. Debitis voluptatem earum enim. Molestiae eligendi ab voluptas officia quibusdam.', 0, 5, 6, NULL, 'thumbnails/', 'archived', 118, NULL, '2024-09-22 11:47:34', '2025-01-02 15:56:20'),
(21, 'BV-140425-47120859', 'Fugiat rem expedita consequuntur commodi. 67fc6aa162e4c', 'fugiat-rem-expedita-consequuntur-commodi-67fc6aa162e4c', '<p>Quia hic et voluptatem distinctio et dicta. Rerum omnis eos ut veritatis. Dicta ut beatae voluptatibus. Inventore cupiditate adipisci odio voluptatem et.</p><p>Maxime quo hic ipsam et. Eaque esse porro sequi expedita. Minus inventore velit quibusdam similique.</p><p>Est expedita facilis quia illum aspernatur. Eligendi blanditiis fugiat dignissimos esse. Assumenda tenetur qui doloremque vel. Aut non fugit quasi ab.</p><p>Reiciendis voluptates provident est. Voluptatem molestiae eum voluptas praesentium necessitatibus et. Qui aut consequuntur aliquid est dolorem ducimus velit. Pariatur perspiciatis sed qui dolor ea provident.</p><p>Est iure et accusantium eum voluptatibus occaecati dolor. Quidem quasi quo magni quis. Expedita corrupti placeat ut cupiditate fugit est. Provident id in dolorum. Iste possimus sed neque sit provident.</p><p>Exercitationem quod illo ratione deserunt sit. Dicta quo officiis et dignissimos fugit ea. Veritatis quisquam modi natus similique voluptate. Est dolor nam autem enim dolorem omnis consequuntur.</p><p>Deserunt repellendus atque voluptatum et exercitationem nostrum ut. Et distinctio repellendus dolorum sed sint impedit. Sunt et ipsum reiciendis molestias. Labore minima officia nemo excepturi nemo aspernatur quo.</p><p>Qui nihil nesciunt dignissimos qui. Tempore praesentium delectus et nobis. Aut ex temporibus sed numquam et.</p><p>Debitis nostrum alias tempora ducimus. Quidem aliquid sunt saepe dolores dolores facilis tempora. Autem voluptas temporibus molestias cum itaque ut id quidem. Quisquam totam facere ut rem ea voluptate odio.</p><p>Vitae fuga ut consequuntur enim consequuntur quis incidunt. Et minus et quia. Veritatis fugit velit dolores voluptatem alias omnis qui. Vel facilis suscipit iusto minima atque illo odio. Quis laboriosam voluptas earum quia corrupti fuga velit.</p><p>Voluptatibus dolores quis qui sit eum ea mollitia. Quis est beatae maiores a quo.</p><p>Omnis quas quia esse earum id praesentium numquam. Officiis nulla quos natus maxime saepe alias. At totam totam corrupti delectus odio veritatis officia. Deleniti sed corporis et quod. Alias nulla accusamus sequi ducimus pariatur quibusdam non.</p>', 'Fuga impedit eveniet quaerat harum expedita. Et sunt porro laboriosam inventore illo quia quod. Delectus necessitatibus animi eius dicta qui animi impedit.', 0, 16, 2, NULL, 'thumbnails/', 'archived', 427, NULL, '2025-02-28 14:12:14', '2025-03-19 02:19:22');
INSERT INTO `articles` (`article_id`, `code`, `title`, `slug`, `content`, `preview_content`, `contains_sensitive_content`, `author_id`, `category_id`, `subcategory_id`, `thumbnail_url`, `status`, `views`, `approved_by`, `created_at`, `updated_at`) VALUES
(22, 'BV-140425-36507128', 'Autem corrupti ipsum nihil distinctio voluptatem. 67fc6aa165eab', 'autem-corrupti-ipsum-nihil-distinctio-voluptatem-67fc6aa165eab', '<p>Officia ut beatae tempora eligendi. Voluptate sed minus repellat. Modi doloribus inventore maiores cupiditate voluptatibus et voluptas.</p><p>Totam consectetur sed dolores quod laboriosam sit voluptatibus. Id dolorem earum reiciendis et et iusto. Ut facere vel animi excepturi est in ab. Possimus voluptatem exercitationem culpa assumenda quaerat et.</p><p>Error et est enim corporis omnis voluptatem illum. Nam hic aut deserunt vel fugit recusandae. Non amet culpa quia deleniti commodi impedit rerum. Non consequuntur minus qui occaecati vel fuga.</p><p>Id praesentium omnis quas sed accusamus repudiandae qui. Eum occaecati dolorem harum sunt magni rerum tenetur. Corrupti non explicabo quia a qui aperiam eveniet.</p><p>Consequatur nulla quasi ab debitis optio perspiciatis aut. Et occaecati libero iste et fugit harum esse. Explicabo cumque et accusantium in et accusantium ipsum. Optio nesciunt repellendus ratione nihil repudiandae sed. Non enim corporis omnis voluptatem sit consequuntur odio.</p>', 'Deserunt nisi sit molestiae sunt aut iusto doloremque. Sed quos soluta molestias rerum et libero provident. Porro officiis quod totam dolorum eligendi occaecati. Labore aut et est consequatur.', 0, 5, 1, NULL, 'thumbnails/', 'published', 275, 1, '2025-04-04 22:42:33', '2025-04-15 08:59:38'),
(23, 'BV-140425-66854780', 'In neque architecto vitae dicta praesentium laborum. 67fc6aa168bae', 'in-neque-architecto-vitae-dicta-praesentium-laborum-67fc6aa168bae', '<p>Unde eaque sunt esse voluptatem praesentium qui. Eum sint harum iure voluptatibus est enim eius quidem. Quisquam fuga inventore ab. Veniam soluta aliquam itaque alias odit ut.</p><p>Non sed aut repudiandae aut natus molestias tempore. Voluptates repudiandae esse modi rerum id velit. In nihil quo id illum. Ut accusantium quis iure debitis qui dicta ut. Excepturi enim ex eaque iusto doloribus.</p><p>Repellendus aliquam id in perspiciatis et saepe. Quam ea recusandae mollitia eos. Recusandae ad perspiciatis nemo laboriosam expedita beatae.</p><p>Quia occaecati nam illo ratione. Incidunt laborum quidem tenetur accusamus.</p><p>Cupiditate omnis inventore sequi nisi porro. Sit sed quidem occaecati minus. Consequuntur ab inventore ea corrupti. Aut maiores impedit illo amet animi. Dolorem hic odit sed eveniet et.</p><p>Cupiditate iure fuga ad qui sed animi quis. Error laborum laboriosam ut sit est. Eos est cupiditate itaque ad voluptatibus.</p><p>Animi quia est ut eligendi quae qui. Qui expedita et non repudiandae provident quibusdam non ea. Et quia incidunt tempore aut sit.</p><p>Similique laboriosam est dignissimos occaecati. Sed vel veritatis dolores quia. Sed et quia culpa soluta perspiciatis dolores. In et provident veritatis voluptas qui voluptas.</p><p>Illum labore quasi quia debitis quaerat sequi enim. Deserunt eaque voluptatum ipsa similique.</p><p>Temporibus facere excepturi numquam molestiae et eum fugit excepturi. Aut unde blanditiis voluptatem autem. Corporis quod culpa voluptatem omnis. Omnis est aperiam ad in qui ut.</p><p>Quia quae doloribus dolorem provident ducimus sit asperiores accusantium. Aperiam earum itaque et non. Ex quam animi alias eos. Velit consectetur labore veniam aut.</p><p>Temporibus aliquam rerum odit est rerum voluptates dolorem. Assumenda et voluptatum blanditiis alias praesentium sit. Iusto minima nesciunt provident ea minima optio repudiandae deserunt. Voluptates expedita quo veritatis sed reiciendis explicabo.</p>', 'Et iure suscipit expedita nostrum. Molestiae voluptas explicabo dicta aut. Ut accusantium qui eaque quod eligendi.', 0, 22, 1, NULL, 'thumbnails/', 'published', 33, 24, '2025-04-01 12:34:00', '2025-04-23 16:32:08'),
(24, 'BV-140425-62844389', 'Ex sit quae doloremque. 67fc6aa16ce65', 'ex-sit-quae-doloremque-67fc6aa16ce65', '<p>Illo delectus sit autem voluptatem qui alias illum. Voluptas alias ad ab facere vel voluptas aut. Aliquam repellendus totam ipsum ducimus nobis aut est.</p><p>Id aut ex animi sunt quos aliquam. Excepturi ipsam harum autem amet cumque. Illo vitae labore beatae officia autem.</p><p>Eos ut nisi sit. Saepe vel eum veritatis perspiciatis consequatur. Repellendus a est fugiat aut enim. Ad nam deserunt dicta nihil.</p><p>Vel saepe odio sapiente eos et quia suscipit et. Corporis assumenda id ea.</p><p>Quis temporibus ipsam enim. Enim quia placeat repellendus impedit qui aliquid. Voluptatum in neque reiciendis pariatur. Cum molestiae necessitatibus numquam ipsam molestiae vitae rerum.</p><p>Nihil id et et. Quo veniam dolorum sit nisi facilis aliquam. Quam laborum velit voluptatem sit accusamus voluptate. Voluptas vitae ipsa eum unde.</p><p>Eligendi iure voluptatem amet eum amet molestias id cum. Quo ut sapiente fugit.</p>', 'A ea sed inventore quis quia. Ipsa nemo pariatur dolorem nesciunt velit rerum blanditiis. Nulla adipisci et maiores quod ab voluptatum. Aliquid sequi tempore ex et necessitatibus velit ea.', 0, 13, 1, NULL, 'thumbnails/', 'archived', 421, NULL, '2025-03-02 01:15:02', '2025-03-25 00:09:14'),
(25, 'BV-140425-64313208', 'Natus cumque beatae asperiores sequi. 67fc6aa1726c8', 'natus-cumque-beatae-asperiores-sequi-67fc6aa1726c8', '<p>Est reprehenderit itaque velit et. In quas perspiciatis nihil quia quae et. Consequuntur ad cum laborum quod. Blanditiis nulla omnis deleniti aut sit.</p><p>Illo delectus quia ut quae accusantium. Dolorem animi nostrum sit quia non. Quos dolor et eos aut autem iure quo.</p><p>Fugit non qui maiores velit eveniet deserunt in. Dolorum porro animi dolorem impedit qui provident cumque. Cumque quia vero vero dolorem.</p><p>Officia inventore a esse fugiat. Pariatur qui ea at. Autem ducimus iste ea iste. Vitae consectetur quo nemo doloremque.</p><p>At qui voluptatibus ullam earum. Magnam eos fuga perferendis architecto ipsam aut sit. Maiores non eum praesentium dolores quia omnis magni. Molestiae voluptatum officia qui quia eius omnis vero.</p><p>Illum accusamus aut qui reprehenderit. Id sequi et sapiente. In repellendus aliquam ex voluptatibus animi.</p><p>Ab veniam nisi dolor et temporibus. Dicta enim rerum harum ut aut. Sit accusantium fuga molestiae architecto aut consequatur. Tempora accusamus minus reprehenderit corporis quia ut dolores.</p>', 'Praesentium est doloribus magni reprehenderit ut incidunt. Enim non quia vel provident et iure et similique. Et eum repellat nulla officia. Et voluptatibus odio consectetur non nam.', 0, 4, 1, NULL, 'thumbnails/', 'published', 196, 15, '2024-05-06 14:52:55', '2025-02-24 22:38:13'),
(26, 'BV-140425-34850310', 'Vitae alias earum delectus blanditiis qui. 67fc6aa178fa7', 'vitae-alias-earum-delectus-blanditiis-qui-67fc6aa178fa7', '<p>Temporibus nihil et id minima unde. Cum nobis nostrum quasi et. Et amet rerum aperiam qui nihil illo.</p><p>Provident dolor ratione rem est. Ut illo dolores quia.</p><p>Perspiciatis rerum omnis eius saepe natus architecto. Esse quibusdam optio rerum omnis eligendi consequatur asperiores. Itaque quia qui aut numquam est. Quam ea ipsam nulla aspernatur.</p><p>Et voluptate doloribus fugit sit ipsam consequatur. Dolores error et consectetur earum quas qui.</p><p>Et ducimus animi eveniet autem. Perferendis error aliquid rerum et sunt earum quis. Nihil cum aliquid ullam. Sed quia sunt dolorum laboriosam assumenda nam. Nesciunt et et adipisci ut omnis excepturi ut.</p><p>Reprehenderit quo laboriosam maiores ipsa consequatur animi. Placeat est magnam et. Voluptas sint tenetur suscipit.</p><p>Et delectus quos illum et omnis architecto. Necessitatibus incidunt et velit. Aspernatur quod consequatur culpa. Dolores error voluptatem qui deleniti eius dolorem.</p><p>Saepe voluptatem ut ut ipsa impedit et illum. Earum inventore doloremque repudiandae molestias nemo quod. Quo quae ipsum sed veritatis sit placeat consequatur. Earum fugit sapiente incidunt dolorem sed est repudiandae magnam.</p><p>Aspernatur quia et cumque nesciunt. Repudiandae adipisci laborum vero. Asperiores voluptatem tenetur officia. Ut sit nulla quidem esse doloremque quis.</p><p>Aliquid et sed aspernatur magnam pariatur quae quis. Temporibus eum quo sit autem. Explicabo quidem voluptatibus molestiae consequuntur atque enim soluta. Aut dolorum asperiores aut nobis illum debitis voluptates a.</p><p>Sint et delectus sint culpa sit aut id. Aliquid quaerat aliquam sed. Ea eveniet cumque exercitationem ullam.</p><p>Soluta accusamus exercitationem est nostrum omnis et. Quis ullam fugit deleniti eius expedita ut qui. Similique laboriosam aut temporibus voluptatibus. Explicabo reiciendis aspernatur similique.</p><p>Tempora corrupti quis incidunt veritatis doloremque dolorem. Soluta eius qui assumenda minima. Error quibusdam quis sequi officiis tenetur omnis ullam. Nemo beatae est blanditiis dolor.</p><p>Voluptatum velit sed autem quia deserunt qui autem. Quas nihil dignissimos fugiat placeat quisquam modi qui. Ducimus numquam officia enim maxime est possimus. Sed omnis sit et dolor sit.</p>', 'Maxime itaque quam quis ea tempora molestiae corporis. Quia asperiores maxime nam et. Dolores in dolorum eius pariatur molestias aut. Sit quas perferendis dolore voluptatibus debitis. Dicta totam quis dolores.', 0, 16, 9, NULL, 'thumbnails/', 'pending', 601, NULL, '2024-06-25 01:23:24', '2025-04-10 01:38:07'),
(27, 'BV-140425-38983815', 'Nisi tempora velit quam maxime. 67fc6aa17e2f5', 'nisi-tempora-velit-quam-maxime-67fc6aa17e2f5', '<p>Omnis libero consectetur maiores et amet incidunt. Corrupti molestiae ut autem. Minus maiores accusantium est.</p><p>Animi similique vero velit quidem. Ratione quaerat voluptas consectetur placeat. Perspiciatis animi eos excepturi eum aut aut laudantium aut.</p><p>Molestiae necessitatibus fuga rerum ipsam commodi illum. Deserunt qui velit vero cupiditate omnis reprehenderit. Sint in in facilis. Vel recusandae incidunt magni recusandae totam possimus earum. Ipsum amet aut perspiciatis distinctio ex delectus.</p><p>Repudiandae eos voluptates non aut eius eum et vero. Sunt assumenda et omnis. Perferendis inventore vitae doloremque est distinctio. Officia mollitia culpa nulla sequi. Est illum delectus sapiente voluptates.</p><p>Assumenda voluptate et recusandae et. Consectetur nostrum praesentium temporibus qui. Accusamus recusandae quia molestiae nostrum necessitatibus sit. Omnis cupiditate minus porro.</p>', 'Rem aspernatur omnis ut voluptatum. Molestiae autem distinctio iste aut ut odit. Dolor laboriosam ipsum possimus est maiores sed accusamus.', 0, 4, 1, NULL, 'thumbnails/', 'archived', 79, NULL, '2025-02-05 21:53:48', '2025-03-31 18:10:15'),
(28, 'BV-140425-69116083', 'Nulla ut assumenda consequatur neque. 67fc6aa186c42', 'nulla-ut-assumenda-consequatur-neque-67fc6aa186c42', '<p>Beatae dolorum qui necessitatibus odio pariatur dicta ut. Rerum vero ex dolorem aut ea quam facere. Quo commodi ut rerum veritatis.</p><p>Ad dignissimos quas amet recusandae quia exercitationem. Eveniet doloribus deleniti eligendi eum quo.</p><p>Eos aliquid quia voluptas ipsam quasi. Veniam iste autem enim quia. Nesciunt omnis aut explicabo voluptas provident.</p><p>Reprehenderit earum perferendis accusamus reiciendis. Aspernatur qui fugit adipisci laudantium. Nihil culpa excepturi aliquid eos. Necessitatibus velit sit aut quasi aliquid.</p><p>Omnis ullam omnis libero facere ex nulla. Neque alias commodi laboriosam. Exercitationem aut culpa aliquam nobis praesentium qui.</p><p>Omnis doloremque occaecati beatae sunt. Eum aperiam dolorem eos doloribus. Consectetur qui quaerat molestiae quam fugiat minima. Impedit et occaecati sit aspernatur voluptas consequuntur vel. Quisquam dolores non recusandae dolores sunt quos ipsa non.</p><p>Placeat veritatis numquam eligendi dolore accusamus temporibus aut tempore. Vero ipsum possimus perferendis molestias quia aliquid labore. Assumenda voluptas quidem quia rerum et commodi. Cum incidunt non doloremque fugiat qui aut est. Est quis ea quod adipisci consequatur.</p><p>Expedita voluptas nostrum quos enim vel. Quam sed repudiandae aliquam numquam nihil aliquid. Omnis ut ratione nisi excepturi omnis.</p><p>Sequi inventore aperiam suscipit eum dolores aliquam ea non. Iure distinctio commodi dolore.</p><p>Adipisci et impedit soluta magni hic nihil. Quisquam cum maiores non omnis quod. Qui dolorem dolore excepturi sequi expedita accusamus autem aperiam.</p><p>Nemo alias sed magni ut est ab nobis. Soluta itaque ipsum sunt. Quaerat vel sequi omnis numquam ut omnis tempora.</p><p>Non molestiae ipsum distinctio suscipit inventore cupiditate aut. Quos impedit corrupti delectus et. Cupiditate sit possimus laboriosam cupiditate voluptate. Dolor omnis aut pariatur porro tenetur impedit nam voluptas.</p><p>Sit natus amet saepe sit enim fugiat. Veritatis molestiae est rerum maxime. Quis vel voluptatem quam assumenda. Odit et neque reiciendis hic vel et.</p>', 'Eveniet recusandae quae et eos delectus ab exercitationem. Doloremque et nulla beatae et. Laborum sed libero blanditiis soluta aut sequi quibusdam. Rerum esse sint omnis.', 1, 16, 2, NULL, 'thumbnails/', 'published', 950, 20, '2024-09-23 20:53:49', '2025-04-26 15:35:52'),
(29, 'BV-140425-91419469', 'Vel rem rem aut. 67fc6aa189b1c', 'vel-rem-rem-aut-67fc6aa189b1c', '<p>Accusantium modi illum sed illum fuga blanditiis. Provident a et harum vel inventore.</p><p>Ut sint id velit ipsa soluta laborum minus. Aut accusantium eum aspernatur consequatur cupiditate voluptatem. Aut sed possimus et. Nemo eligendi totam voluptatum cumque amet expedita.</p><p>Quo nisi vitae non et doloremque deleniti corporis. Autem praesentium consequatur laboriosam labore quia natus a. Soluta in nisi doloribus commodi nostrum. Corrupti id qui similique aut rerum asperiores.</p><p>At et repellat nemo quaerat et. Omnis saepe error enim beatae sint illum nam. Omnis praesentium et sed dicta.</p><p>Laudantium ullam est tenetur consectetur omnis hic ex et. Pariatur sit a qui soluta sit alias rerum sed. Voluptatem odit sed dolore voluptatum possimus.</p><p>Omnis quaerat dolorum debitis accusantium. Quo ut pariatur illum est est. Magnam aut hic non nobis.</p><p>Enim commodi nemo excepturi. Eius sapiente eos tempore. Atque distinctio alias dolorem iure sed sed ratione. Ut omnis rerum error et at quae praesentium.</p>', 'Quia eius cupiditate nemo et. Voluptates eos iste aliquid unde eaque. Labore quia impedit est tenetur iure fugiat voluptas.', 0, 23, 10, NULL, 'thumbnails/', 'draft', 908, NULL, '2025-03-03 16:48:35', '2025-03-28 21:10:41'),
(30, 'BV-140425-38186168', 'Autem consequatur aut aut. 67fc6aa18e1cf', 'autem-consequatur-aut-aut-67fc6aa18e1cf', '<p>Voluptatem quis optio qui. Accusantium soluta ex ut non numquam. Ut dolores quod quis officiis dolorum nobis expedita rerum. Vel molestiae nisi voluptatum sit voluptatem hic.</p><p>Non fuga omnis voluptatem dignissimos voluptas rerum itaque. Eius aut consequatur dicta molestiae repudiandae dolore.</p><p>Minus est quibusdam non aut voluptates quae. Laboriosam nihil ut sed atque quas. Voluptatum eos quae atque sapiente itaque aut. Illum maiores modi quae et qui voluptatem.</p><p>Voluptatum repudiandae odio maxime aliquam ut. Omnis aliquam porro aut id. Quia aperiam voluptas sint architecto corrupti quasi.</p><p>Aspernatur similique fugit cumque qui numquam. Consequatur at quas deleniti ipsum rerum reprehenderit. Omnis ut nobis nihil doloribus vel libero. Suscipit et similique id dolor consequatur molestiae reprehenderit et.</p><p>Quos iusto reprehenderit delectus. Dicta eaque fugiat et itaque ipsam hic sit. Rem odit qui ipsam harum velit eveniet velit et.</p><p>Iure sit ut natus saepe. Doloremque aliquid impedit non eius sed non. Voluptatem accusamus laudantium dignissimos omnis vero eos natus corporis.</p>', 'Ad assumenda amet et quos eos et. Quae non perspiciatis minima unde recusandae. Sint veritatis qui maiores ratione vitae.', 0, 4, 9, NULL, 'thumbnails/', 'published', 146, 20, '2025-03-08 03:44:15', '2025-03-28 11:43:52'),
(31, 'BV-140425-30969980', 'Iusto harum provident voluptates corporis. 67fc6aa191621', 'iusto-harum-provident-voluptates-corporis-67fc6aa191621', '<p>Natus voluptatem dolor ex veritatis. Accusantium aliquam ad rerum omnis. Alias beatae delectus est est omnis illo enim. Voluptatem vero tempore suscipit eum est.</p><p>Omnis aut velit labore esse rem quasi quo. Dolores animi asperiores quaerat voluptatem dolore sit illo atque. Molestiae ipsum debitis velit nihil delectus perspiciatis et. Et quaerat quo omnis qui.</p><p>Quibusdam sit qui sunt sed quia excepturi expedita. Sequi laboriosam ipsum commodi consectetur ducimus. Vel debitis id eligendi eaque eligendi.</p><p>At tempora fuga voluptate possimus ipsa sit molestiae delectus. Voluptatem quisquam alias a et qui ea. Eum perspiciatis sed a sint. Quia natus provident similique et.</p><p>Voluptatem corrupti quis sapiente expedita eos dicta minus. Quis aut voluptatem perferendis ut itaque omnis. Quo neque sunt commodi sint. Est eligendi ab atque et.</p><p>Qui consectetur consequatur ea ut cumque voluptatem ut. Adipisci enim dolorum iure molestias. Dolores qui hic nihil autem.</p><p>Minus illum assumenda dicta unde quaerat similique quo. Optio aperiam nostrum eos rem quia ea qui sint. Eveniet incidunt ut quia nemo.</p><p>Sunt voluptatem pariatur et aut. Eos qui ullam et dolor totam. Aliquid quo est mollitia molestiae recusandae sequi. Sit velit illo sit explicabo cumque atque.</p><p>Placeat cum ullam est inventore consectetur deleniti odit. Occaecati quidem ea aut similique labore esse. Similique qui consequatur nesciunt. Dolorem quod qui similique.</p><p>Blanditiis explicabo nihil reiciendis. Aut ipsam est voluptatem qui. Id est rerum dolore exercitationem velit eveniet inventore. Natus soluta qui mollitia beatae.</p><p>Qui neque consequatur ducimus minima est aperiam. Corporis neque ducimus quod illo illo. Nostrum iusto voluptatem nobis suscipit deserunt voluptate tempore. Iusto rerum non incidunt laudantium.</p><p>Et qui consequatur cupiditate quae et molestias. Atque eos officia quasi. Ut rem in et at enim optio. Illum eligendi atque asperiores minima corrupti aliquid nisi.</p>', 'Repellat ut sint est omnis. Doloremque consequatur expedita quaerat dolor. Facere doloribus voluptas ut error ut totam velit. Quia veritatis reiciendis sint beatae recusandae.', 0, 22, 8, NULL, 'thumbnails/', 'pending', 2, NULL, '2024-06-01 09:45:06', '2024-09-05 22:19:53'),
(32, 'BV-140425-92348903', 'Voluptatem mollitia perspiciatis et at. 67fc6aa19438b', 'voluptatem-mollitia-perspiciatis-et-at-67fc6aa19438b', '<p>Accusantium velit est qui sint neque. Molestias quos quis et deleniti id explicabo enim. Magnam nostrum deserunt cum nemo iste aut aspernatur explicabo.</p><p>Quam cupiditate sed provident quae dicta. Ea numquam repudiandae velit sapiente. Laboriosam accusantium velit alias.</p><p>Et eum non et totam non ratione soluta. Et dolorem ipsa similique sit consequatur. Vero molestiae minus et atque.</p><p>Explicabo a quia harum totam eos autem vel. Qui et asperiores quasi. Excepturi voluptatibus accusantium error.</p><p>Veniam et earum minus alias. Non praesentium quo molestiae ducimus quia. Voluptates laudantium eos fugiat ut sed. Voluptatibus ducimus harum eum et et.</p><p>Omnis laborum nam sint consequatur maxime. Minus perspiciatis ducimus qui nam delectus similique. Laudantium velit quidem nobis officiis ipsum autem esse.</p><p>Et quaerat debitis autem possimus. Doloremque quis tenetur et officia voluptatibus accusantium dignissimos. Sed adipisci corrupti voluptas exercitationem.</p>', 'Repellendus illo voluptatibus ullam blanditiis. Officiis nam dolor totam facilis expedita. Earum dolore ut incidunt dolores vel eveniet. Unde illo enim fugit asperiores eius fugiat magni.', 0, 16, 9, NULL, 'thumbnails/', 'rejected', 852, NULL, '2024-05-31 18:35:07', '2025-02-07 06:38:13'),
(33, 'BV-140425-86531834', 'Omnis temporibus distinctio dolorem amet laboriosam veniam aliquid. 67fc6aa19714c', 'omnis-temporibus-distinctio-dolorem-amet-laboriosam-veniam-aliquid-67fc6aa19714c', '<p>Id consequuntur quasi illo molestiae aut eligendi aperiam. Soluta aliquid eligendi et nemo officiis dolores repellendus. Voluptatem laudantium quia aut quae fuga ut inventore qui.</p><p>Natus dolor rem quia. Ex repellat omnis optio. Occaecati expedita vel occaecati.</p><p>Fugiat est nulla aliquam vero dolore quis ducimus et. Ducimus aperiam dolores sit consequatur nemo rerum. Nihil eos laborum illum quisquam deleniti. Expedita ut iusto nisi ut fugiat molestiae.</p><p>Accusamus eius dolore est qui et. Asperiores reiciendis quos in facilis illum ut. Molestias quaerat aut nemo atque exercitationem.</p><p>Accusantium voluptatem ut et et quia ullam a impedit. Labore consequuntur cum eum et. Doloribus qui qui consequatur quidem ea. Dolorem dolore et in temporibus.</p><p>Error dolores ut odit et. Impedit neque accusantium dignissimos alias est. Sed vel velit aut harum sed incidunt nemo expedita.</p><p>Qui velit earum nobis iste qui repellendus. Error dolor optio veritatis non consequatur. Autem recusandae cum cum ratione.</p><p>Id cumque et sit in ipsa reiciendis. Doloremque earum qui earum sit repellat et maiores et. Deserunt ducimus iste atque et architecto consequuntur et blanditiis.</p>', 'A qui illum sint saepe. Quaerat iure beatae possimus enim saepe.', 0, 22, 1, NULL, 'thumbnails/', 'draft', 704, NULL, '2024-07-21 09:02:42', '2025-04-07 16:09:03'),
(34, 'BV-140425-19904867', 'Numquam vero id inventore quas quia distinctio. 67fc6aa19a0a7', 'numquam-vero-id-inventore-quas-quia-distinctio-67fc6aa19a0a7', '<p>At et officiis occaecati corporis aliquam placeat ipsum. Enim et temporibus sequi omnis est ullam quaerat. Laborum doloremque quas numquam ut reprehenderit mollitia.</p><p>Modi illo iste molestiae. Quia quos eligendi magni reprehenderit. Veritatis mollitia aut aut qui sint inventore reiciendis. Quo laboriosam odit possimus cumque natus.</p><p>Error delectus sit qui eveniet suscipit id autem. Molestiae vel et beatae sunt. Accusamus rerum voluptas qui rerum sunt.</p><p>Voluptatibus in vitae eligendi sunt. Voluptatem autem recusandae accusamus aut ut nobis in. Quam quia error provident iste ut aut sit.</p><p>Occaecati ratione sunt rem et. Cum autem voluptate eaque dolorem.</p><p>Non omnis sit corporis. Repellat consequatur earum sit voluptatem reiciendis. Minima omnis voluptate blanditiis.</p><p>Enim sunt qui animi exercitationem porro qui molestias laboriosam. Earum excepturi laudantium accusamus molestiae sunt quo. Et neque qui veritatis est voluptatibus esse quam. Eius facilis nostrum ut aliquid ratione fuga.</p><p>Minus voluptatem porro et recusandae ipsam. Quia quam natus sed nam voluptas maiores. Nemo rem vitae ipsa nam. Nisi quas accusantium repellat laboriosam repudiandae fugiat.</p><p>Totam qui qui possimus sint. Amet optio itaque molestiae similique doloribus sequi. Aliquam explicabo voluptates est quo. Illum dolor sequi velit odit autem excepturi ea. Ea voluptates beatae voluptas sunt sit.</p><p>Eum odio eaque aut reiciendis est. Dolor voluptates vel impedit odio ipsa qui vero. Beatae sunt iste quo nam nam id. Dicta libero id quia qui.</p><p>Asperiores illum corrupti magnam provident et. Aut quas aut minima et ab veniam voluptate dolor. Ut ducimus fuga velit mollitia eligendi.</p>', 'Id inventore nesciunt recusandae laboriosam. Quasi quia aut dolorem ex delectus corrupti. Voluptatem eos atque harum et et nostrum.', 1, 16, 2, NULL, 'thumbnails/', 'pending', 505, NULL, '2024-05-03 02:23:15', '2024-07-21 19:10:50'),
(35, 'BV-140425-16695825', 'Deleniti possimus inventore molestiae. 67fc6aa19cbfb', 'deleniti-possimus-inventore-molestiae-67fc6aa19cbfb', '<p>Labore praesentium mollitia quis omnis et et maxime. Ullam accusamus ea ut reiciendis sint. Autem facilis molestias quibusdam nemo quaerat.</p><p>Vel in aperiam aliquid qui. Delectus ut vel quis et et. Voluptates in saepe magnam quis officia beatae molestiae.</p><p>Officia provident hic aut. Fuga voluptates necessitatibus sint a. Dolores molestias dolorum sed natus. Corporis quos assumenda itaque totam natus qui.</p><p>Sint rerum atque hic eligendi. Fugiat voluptate tempore enim est. Voluptas laboriosam error itaque provident aut. Nam commodi a est quidem.</p><p>Ut est non distinctio ullam magni dolorem. Quaerat harum id tempora. Quia explicabo corrupti aliquid maxime. Expedita impedit et odit. Tempora voluptatem in sint vel reiciendis.</p><p>Voluptatem voluptas dolores asperiores cumque reiciendis voluptatem. Vel iste quam laboriosam eos ullam quos. Earum illo quibusdam officia repellat cumque.</p><p>Consequatur autem ducimus consequuntur vel est. Non fugiat enim necessitatibus sequi. Quas saepe sunt quo aut.</p><p>Laboriosam exercitationem possimus quo est illum asperiores cum. Nostrum dolores sint laboriosam illum culpa sed debitis. Quia magnam officiis aperiam nam.</p><p>Omnis earum maiores non debitis molestiae sint. Dolor nihil in molestiae quis. Asperiores voluptate veniam inventore consequatur et. Nesciunt esse quis ut occaecati magnam et eos.</p><p>Sit est libero perspiciatis aut laudantium enim tempore aliquam. Facilis quas vero voluptate et quo magni sint. Aut explicabo temporibus voluptas praesentium labore. Quis ut veritatis neque illo dolor eveniet. Omnis vitae velit quo culpa aut officia odio aut.</p>', 'Quidem et dolorem voluptatem alias doloribus. Et non ea ab. Nemo rerum et rerum consequatur doloribus suscipit eveniet harum. Impedit perspiciatis reiciendis consequatur laudantium voluptate quod nobis quia.', 0, 16, 1, NULL, 'thumbnails/', 'pending', 810, NULL, '2024-11-26 01:24:31', '2025-01-14 19:21:50'),
(36, 'BV-140425-96431873', 'Ullam neque voluptas asperiores optio reiciendis odio nostrum. 67fc6aa19fff2', 'ullam-neque-voluptas-asperiores-optio-reiciendis-odio-nostrum-67fc6aa19fff2', '<p>Consequuntur quia excepturi officia est. Quia neque dolores quae repudiandae magnam beatae nihil. Culpa tempora animi aut placeat quos suscipit excepturi aspernatur. Alias modi ut molestiae sunt voluptatem.</p><p>Commodi ipsam mollitia qui ut eius eaque rerum. Optio nam natus molestiae itaque tenetur non atque. Sint perferendis ut voluptatum.</p><p>Excepturi neque et officia aperiam. Quia laboriosam blanditiis recusandae voluptate rerum sequi cumque. Consequatur magni qui dolorum perspiciatis et ut vero.</p><p>Minus est consequuntur dolore ut. Nam at aut velit. Voluptates minima cupiditate error autem laboriosam quia.</p><p>Facere molestiae non possimus similique esse autem. Ipsa beatae magnam non est quia. Ea iusto adipisci id sit id ut qui.</p><p>Dolorem rerum sed quod cum eos. Et non aperiam rerum dolore dolor qui eius consequatur. Delectus architecto a perspiciatis id.</p><p>Nihil ratione aperiam blanditiis pariatur excepturi iure iste veniam. Expedita odio accusamus quia omnis eum.</p><p>Occaecati et quis similique ab qui in dolor. Numquam reprehenderit fugit saepe voluptates. Sed adipisci molestiae voluptatem non aut quia. Sit commodi atque dolor quas non et beatae.</p><p>Nobis et velit aperiam sit. Impedit magni nostrum minus quia reprehenderit eos. Asperiores et sunt corrupti consectetur alias. Saepe quo commodi iusto eos.</p><p>Officia et tenetur nulla impedit mollitia non nesciunt magni. Tenetur et autem animi. Quidem voluptatem illo quaerat assumenda deserunt.</p><p>Illo possimus facilis tenetur error in amet aut. Ut est officia repudiandae quidem. Aspernatur et et a adipisci dicta. Sit nulla sed dolorum reiciendis dolore. Dolores quas vitae quia neque non nesciunt similique.</p>', 'Aut molestiae voluptatem numquam deleniti. Voluptatum nesciunt et iure suscipit. Quis adipisci reprehenderit est.', 0, 4, 7, NULL, 'thumbnails/', 'archived', 139, NULL, '2024-06-02 06:47:31', '2024-12-05 09:05:32'),
(37, 'BV-140425-51710557', 'Atque ut architecto voluptatem ratione fugiat ratione voluptates. 67fc6aa1a2aab', 'atque-ut-architecto-voluptatem-ratione-fugiat-ratione-voluptates-67fc6aa1a2aab', '<p>Enim placeat voluptatem et explicabo. Porro iure corporis consequatur soluta suscipit. Officia omnis et voluptas qui et.</p><p>Cumque suscipit sed omnis a accusamus similique modi. Temporibus repellat minima distinctio sit provident. Et eaque molestiae harum neque et numquam enim quisquam.</p><p>Similique eligendi sequi velit repudiandae non dolor sed. Aspernatur pariatur cupiditate rerum non officia rerum. Doloremque minus et dolor. Fugit esse repellendus occaecati qui odit est.</p><p>Vel ea vero est quidem. Vitae rem dolor amet quia ab. Fugiat iure magnam reprehenderit dolorem.</p><p>In molestias minima non iste doloremque ut laborum. Iusto id dolores mollitia iusto atque cupiditate aspernatur impedit. Perferendis eos consequuntur cumque quia rerum. Aliquam repudiandae id magni quaerat maxime vel placeat sunt.</p>', 'Mollitia quod qui corrupti accusantium. Distinctio omnis molestias qui ipsa mollitia. At ut eius molestiae hic deserunt tempore. Tempore sit doloribus ratione quisquam dignissimos. In et non mollitia.', 0, 22, 2, NULL, 'thumbnails/', 'pending', 496, NULL, '2024-11-01 21:11:42', '2025-02-26 09:42:00'),
(38, 'BV-140425-95408680', 'Totam nisi deleniti incidunt provident atque. 67fc6aa1a72ba', 'totam-nisi-deleniti-incidunt-provident-atque-67fc6aa1a72ba', '<p>Tempore iure non qui doloremque voluptatem. Maxime qui et deleniti sed distinctio non deleniti. Qui dolorem consequuntur distinctio sed eveniet ex cum quidem. Qui consequuntur iste sunt pariatur. Et maxime voluptatem dignissimos in illo necessitatibus.</p><p>Dolorum eos assumenda consequuntur eum earum. Qui libero quaerat minima dolor. Quidem sapiente dignissimos excepturi quo itaque eum ducimus. Quibusdam nobis laborum sed sed nulla necessitatibus in.</p><p>At voluptatibus quos ipsum dolor vero. Sequi repellendus aut et veniam. Assumenda quod qui at ex quasi deserunt.</p><p>Sint voluptatibus molestias in minima ut id consequuntur. Voluptatem vero quas quam quis velit soluta. Maiores similique consectetur exercitationem repudiandae voluptas.</p><p>Temporibus assumenda tempore molestiae ex rem illum. Totam tempora ea minima aliquid magni temporibus. Omnis blanditiis consequatur officia enim.</p><p>Ut dignissimos nihil cumque qui laborum. Voluptatem quidem in unde minus rerum voluptatem. Laboriosam cumque et et sunt. Vel laborum voluptates voluptates et laboriosam quisquam.</p><p>Assumenda magni sunt ipsa. Commodi ad ad exercitationem accusamus sed.</p><p>Temporibus ut tempore accusamus eos blanditiis tempora. Blanditiis in aut voluptatem recusandae laudantium. Incidunt deleniti blanditiis qui eum exercitationem sed atque suscipit.</p><p>Aut qui itaque doloremque consequatur doloribus voluptatem. Consequatur laborum eius vel at possimus labore eum. Facilis ipsum reiciendis quis error beatae non cumque.</p><p>Et omnis autem rerum repellat vel doloremque. Est officia quia veniam qui a ipsa. Vero ut et vitae nihil. Dolores expedita officiis ut eligendi soluta cum hic. Sint voluptatum nisi eligendi provident expedita sit non.</p><p>Sit consequuntur autem voluptatem reiciendis esse laborum sed. Quia cum eos quae delectus fugit. Quo unde ipsam reprehenderit dolores et aspernatur ab.</p><p>Id nobis excepturi omnis omnis. Rerum cum libero quia asperiores deserunt suscipit. Cumque eveniet occaecati sapiente magnam nam.</p>', 'Aut sed quidem velit quo omnis. Adipisci inventore id est et occaecati quis voluptatem. Iure accusamus illo suscipit eum natus.', 0, 7, 6, NULL, 'thumbnails/', 'draft', 555, NULL, '2024-05-29 01:49:28', '2025-02-16 07:18:07'),
(39, 'BV-140425-66820164', 'Modi provident recusandae consequatur autem aspernatur. 67fc6aa1ac211', 'modi-provident-recusandae-consequatur-autem-aspernatur-67fc6aa1ac211', '<p>Neque et hic voluptatem non cum. Voluptatem culpa qui tempora rerum placeat deleniti ab. Molestias ad quia maxime nulla enim eveniet aperiam. Asperiores facere natus nostrum aut pariatur quis illum.</p><p>Eos ullam culpa placeat laboriosam. Unde in placeat a et. Quaerat quam qui deleniti fugit.</p><p>Dolorem a sunt praesentium. Voluptas eveniet quis molestiae quidem impedit. Fuga eveniet quam quidem unde est dolore. Hic dolores vero perferendis deleniti quam quo ut.</p><p>Et illum occaecati quo autem dolorum. Assumenda ea qui consequatur quia doloribus. Consequatur hic officia facere dolor consequatur non excepturi. Est deserunt cum aliquam accusamus in iure. Natus tempora dolorem quaerat quis nam.</p><p>Aut dolorum debitis enim consectetur sed. Et sit possimus necessitatibus animi. Sint libero dicta soluta vitae. Ad quo itaque nisi tenetur ducimus perspiciatis.</p><p>Enim accusamus sapiente reiciendis dolores laborum dolore adipisci excepturi. At illum enim culpa dolorem quia adipisci ipsam. Laboriosam id non sed laudantium. Et voluptatem dicta ad reiciendis fuga exercitationem. Commodi illum natus ipsa repellendus non omnis vel animi.</p><p>Itaque error cumque labore doloribus hic quo in. Maxime non nihil deserunt doloremque iste nesciunt. Vero assumenda sed deleniti ad. Suscipit ex qui officia nam delectus vitae.</p><p>Dolorem sequi at laudantium et ea architecto. Vel necessitatibus qui et sapiente qui debitis. Reiciendis eum et autem. Repudiandae et aut tenetur deleniti quis.</p><p>Optio ut praesentium ab ut eos illum ut. Sunt nihil expedita sapiente provident.</p><p>Sunt tenetur culpa tempore iure ex sequi nostrum. Aut et qui qui sint voluptas veniam et. Velit aliquid porro minima et consequuntur.</p><p>Soluta repellendus atque molestiae ipsam enim. Sed deleniti sequi quidem fugit nisi impedit sequi. Vitae eum sapiente omnis impedit non nemo.</p><p>Accusamus fuga molestias ducimus. Eligendi vel dolorem corrupti quasi quibusdam tempora ut est.</p><p>Voluptatibus quia et ratione dolorem sit enim. Vero est voluptas rem voluptatum quam error.</p><p>Rerum accusamus ducimus hic similique beatae. Pariatur dolor id culpa inventore nemo vel eius blanditiis. Accusamus quia reiciendis voluptas aut harum et dignissimos enim. Consectetur dolorem aut tenetur pariatur.</p><p>Voluptas soluta corporis iure quis quibusdam. Consequuntur eum a nam quasi enim.</p>', 'Unde autem rem quis qui. Non quod enim corrupti et in. Assumenda soluta accusantium velit dolorum id. Vitae illo quos consectetur et reprehenderit ut ea quidem. Delectus consectetur odit ducimus commodi laborum consequatur.', 0, 4, 8, NULL, 'thumbnails/', 'published', 965, 24, '2025-03-22 20:26:28', '2025-04-26 15:39:57'),
(40, 'BV-140425-07511883', 'Sit ullam ut vel. 67fc6aa1af41d', 'sit-ullam-ut-vel-67fc6aa1af41d', '<p>Incidunt recusandae et quibusdam vitae libero. Eum aspernatur ea qui earum. Illo eos quo et quam et. In magni quibusdam non exercitationem eos quia.</p><p>Quibusdam qui ipsa dignissimos. Occaecati et quae ab rem ea. Ad culpa aliquid et nam nemo magnam.</p><p>Iusto culpa unde doloribus sed dicta. Nemo voluptatem sint ut illo. Consequuntur dolores ut eum quae rem.</p><p>Minima perspiciatis vel consectetur aspernatur voluptatibus blanditiis. Voluptatem dolor et ut. Facilis quia ut nobis qui omnis sed temporibus. Modi excepturi explicabo iusto quis repellendus commodi.</p><p>Facilis esse alias consectetur voluptates provident. Ullam distinctio sequi cumque ut. Eum placeat libero enim nihil praesentium illo.</p><p>Aspernatur non ab optio. Consequatur velit dicta quos repellendus ut delectus. Voluptas ullam quia quas dolore sunt eum. Tenetur tempora eaque enim officia vel eum. Eum perferendis ex commodi sint tenetur fugiat.</p><p>Mollitia provident in dicta quasi est aut sed. Qui id ducimus architecto esse molestiae nesciunt possimus. Consequatur inventore earum quidem porro dolore vitae cum. Cumque cupiditate ut tenetur tenetur earum et nam.</p><p>Enim iure perspiciatis dicta quo dolorem enim. Consectetur quaerat explicabo similique omnis molestias expedita quia. Occaecati libero beatae quisquam provident dolorem.</p>', 'Rerum dolorum excepturi impedit est. Aliquid sunt expedita aut fugit saepe. Consequatur ab ea cum eligendi error eos. Sunt nihil aut veritatis adipisci in non vel accusantium.', 0, 23, 7, NULL, 'thumbnails/', 'published', 140, 24, '2024-05-11 04:56:12', '2024-05-25 01:11:34'),
(41, 'BV-140425-59188592', 'Saepe eius molestias omnis dignissimos aut ut aut quod. 67fc6aa1b1f6a', 'saepe-eius-molestias-omnis-dignissimos-aut-ut-aut-quod-67fc6aa1b1f6a', '<p>Tempora explicabo voluptatibus recusandae et et. Ipsam rerum consequatur qui et velit provident molestias. Expedita error est explicabo sapiente quia.</p><p>Quod deserunt voluptatem natus quia sed laborum. Aut sunt omnis nihil est sit autem. Nam tenetur omnis quod. Vitae suscipit accusantium quidem optio dolorem voluptatem excepturi.</p><p>Ducimus omnis dolorum iste illum. Aut officia qui sapiente vero aut. Culpa quaerat blanditiis velit qui tenetur repellendus distinctio. Et fuga blanditiis ea odio consequuntur.</p><p>Qui ea culpa quos saepe vitae. Perspiciatis quia dolores eligendi voluptate autem recusandae. Eveniet ut et enim.</p><p>Quas optio ea culpa nulla adipisci aut. Non sequi eius earum et. Est quia beatae consectetur a nobis repudiandae. Aut dolorem laborum et molestiae dolor aut qui.</p><p>Quibusdam fugiat ratione nobis inventore itaque hic et suscipit. Rerum ut id error dolores quisquam eos aut. Deleniti id recusandae aut repudiandae voluptate assumenda expedita.</p><p>Omnis quis ad fugiat doloremque omnis. Unde quos illo et sapiente aut sed aliquam. Fugiat quia inventore consequuntur dolores dolorum. Occaecati error voluptas nesciunt repellat expedita vitae.</p><p>Assumenda libero quas quas ut iure. Debitis velit aut quia cupiditate autem. Adipisci mollitia ad nostrum quia et esse odit. Numquam omnis voluptate quia sit id hic eos.</p><p>Cupiditate et aut esse consequuntur temporibus sit sapiente. Officia nostrum rerum sit est praesentium temporibus nobis. Esse ut magnam accusantium qui et quia mollitia sed. Delectus dolor est enim rem.</p><p>Dicta ea pariatur sed sequi quasi error. Repellat nihil distinctio autem blanditiis qui placeat consequatur. Sit vel et tempore totam quod officia eligendi. Numquam facilis ut officiis enim.</p><p>Ut iusto sapiente temporibus qui non. Voluptatem cupiditate repellendus necessitatibus omnis iure in. Rerum sit repellendus quaerat et. Qui odio sapiente culpa ex earum.</p><p>Assumenda nesciunt tempora animi aut. Voluptates doloribus magni vel fugiat id incidunt. Molestiae eum non eius corrupti possimus.</p><p>Quo sapiente alias impedit occaecati ex voluptatem. Adipisci sed unde ut ut quasi accusamus nisi vel. Optio architecto modi voluptas nisi commodi cum.</p>', 'Commodi modi tempore aperiam amet rerum. Consequatur est ipsa perferendis nesciunt asperiores. Ratione itaque rerum quibusdam repudiandae consequatur.', 0, 22, 7, NULL, 'thumbnails/', 'rejected', 537, NULL, '2025-01-06 01:24:29', '2025-01-09 01:33:35'),
(42, 'BV-140425-99948540', 'Temporibus et corrupti porro tempora. 67fc6aa1b562e', 'temporibus-et-corrupti-porro-tempora-67fc6aa1b562e', '<p>Ea dolorem vel omnis ea porro ratione architecto. Laudantium rerum consequatur numquam itaque aspernatur exercitationem modi. Voluptatem nihil voluptatem tempore ipsam ullam consequuntur quae. Voluptate ea nihil incidunt fugiat.</p><p>Unde non dolor labore eius laudantium iure. Ducimus vel odit eius quia nostrum aliquid animi illo. Consectetur ex nostrum voluptate ipsum sit tempore. Ipsam sed iure amet eos incidunt culpa.</p><p>Molestias sint corporis delectus veniam quam. Atque voluptas voluptas est explicabo maxime quaerat. Rem inventore eligendi non non totam consequatur soluta aut.</p><p>Ut molestiae molestias est numquam a odio. Aut quasi nisi rerum aut. Iste at accusantium harum ipsa.</p><p>Nisi ut maxime molestias dolores et facere modi. Libero itaque voluptatem sapiente voluptatem ut voluptas ipsam quia. Repellendus saepe quo nemo aut inventore ex molestiae. Deleniti rerum ad sit dolor quia aut qui.</p><p>Blanditiis qui omnis numquam itaque distinctio. Id omnis eum et delectus inventore. Ut quibusdam neque ipsum sed expedita similique laboriosam repellendus. Officiis quia ipsum earum cumque fugiat.</p><p>Doloribus quis perferendis quia. Illo nulla placeat commodi quia nemo. Illum est praesentium error alias aut.</p><p>Nobis illum eum deserunt consectetur labore. Qui voluptatem et occaecati a. Vitae eligendi ullam qui delectus voluptatem. Recusandae voluptatum eius rem.</p><p>Quas ex adipisci quidem. Qui amet dolorem asperiores quo aut dolorem amet. Vero distinctio et qui totam.</p><p>Qui sequi neque et quae delectus vero est. Vero sapiente ut aperiam ut excepturi.</p><p>Vero ex nemo est dolore voluptatibus occaecati. Et quia quas nisi vel esse dolor explicabo. Pariatur ducimus voluptatem pariatur aut et.</p>', 'Nostrum error et repellat quo. Minima ut ut error. Illum sit quos nisi doloribus ducimus aspernatur.', 0, 7, 8, NULL, 'thumbnails/', 'archived', 269, NULL, '2024-10-13 11:48:18', '2024-12-21 11:37:49'),
(43, 'BV-140425-72994560', 'Quas ut impedit sed quos maxime iusto. 67fc6aa1b9032', 'quas-ut-impedit-sed-quos-maxime-iusto-67fc6aa1b9032', '<p>Quia rerum minima eius deserunt. Iste atque quisquam qui molestias ea. Atque nobis expedita ut sint. Sit nisi eum quia labore et.</p><p>Ut aut assumenda aut ab consequatur dolores at. Voluptas debitis nam ipsam voluptatem similique. Laudantium iste consequatur esse vero quam maiores.</p><p>Cupiditate exercitationem nulla nemo aliquam dolores at eligendi. Dolor molestiae consectetur et dolores itaque inventore et. Molestias enim omnis quam eius adipisci ullam.</p><p>Esse ratione rerum ipsum nobis dolorum et ut totam. Voluptatum ab distinctio repellendus et voluptas omnis dolore. Aut numquam error dolorem quibusdam. Quis sint consequatur aliquam aut nihil.</p><p>Aut ut velit sit nam architecto. Quam illum sed at autem velit ipsum. Commodi quia ab non optio mollitia.</p><p>Cum fugiat id pariatur aut reiciendis libero ad beatae. Temporibus et eos exercitationem iure ea sequi. Esse eos et labore voluptatem tenetur explicabo. Aliquid reiciendis ex ut.</p><p>Qui consequatur quisquam omnis itaque et eveniet. Sit iusto expedita occaecati autem. Ut sint beatae voluptas veritatis porro.</p><p>Quo deserunt nam quibusdam explicabo. Architecto et debitis voluptatem velit. Laudantium nesciunt aut nesciunt adipisci.</p><p>Eveniet tenetur eos consectetur et dolores magnam aut. Natus ipsam ab cupiditate. Dolores nostrum et odio et consequatur eius rerum. Optio quis mollitia eum possimus nostrum totam.</p><p>Dolores cupiditate ratione assumenda magni. Ut quasi porro modi numquam voluptas. Ipsam in nesciunt velit sed id eligendi corporis.</p><p>Autem et est nostrum fugiat. Animi ut excepturi velit et et cumque tenetur.</p><p>Reiciendis minus quia aperiam consequuntur tenetur modi. Atque illo sit quia exercitationem atque. Autem sunt eveniet vitae ut omnis consectetur voluptas. Quod sapiente molestiae veritatis ullam mollitia architecto.</p><p>Eum cupiditate sit dolorem inventore dignissimos accusamus iste. Voluptas commodi animi officiis accusamus. Distinctio quo et nesciunt tempora natus facere rem.</p>', 'Necessitatibus ullam pariatur et natus. Veniam explicabo quia voluptates nesciunt quisquam necessitatibus. Exercitationem rem architecto fuga laudantium illum quia molestias accusantium.', 0, 16, 6, NULL, 'thumbnails/', 'draft', 99, NULL, '2024-06-26 12:14:19', '2024-07-29 23:57:45'),
(44, 'BV-140425-13740515', 'Id delectus reprehenderit neque architecto quidem praesentium. 67fc6aa1bbf76', 'id-delectus-reprehenderit-neque-architecto-quidem-praesentium-67fc6aa1bbf76', '<p>Accusamus nihil odit aliquam saepe. Sed dolor minima porro aliquam ex accusantium.</p><p>Error praesentium perferendis molestiae exercitationem. Laborum dolores voluptas illo voluptas. Qui sed consequatur est est et ea dolores.</p><p>Voluptates repellat asperiores quasi ut aut suscipit. Et deleniti exercitationem numquam deserunt. Minus voluptatum atque molestiae laborum animi doloribus modi excepturi. Ut a eveniet aut modi quia neque dolor.</p><p>Et reprehenderit eum quisquam voluptates blanditiis itaque aut quo. Id sunt consequatur similique corrupti dignissimos porro fugiat. Similique et blanditiis illum aliquam dolorem dolores rerum.</p><p>Quis laborum impedit sapiente fugiat eligendi. Minima sit aspernatur beatae soluta ipsa et ut. Aliquam voluptatibus rem ut. Et non laudantium laborum doloribus nisi et nihil.</p><p>Et voluptatem sunt rerum quia reiciendis sunt explicabo. Exercitationem rerum consequatur iure ratione. Deserunt nobis vitae earum consequatur.</p><p>Rerum earum nihil consequuntur laudantium porro. Consequatur nemo tempora dignissimos deserunt odit et. Quo dolores eius hic cupiditate itaque. Quidem quia delectus officia accusantium quo numquam.</p><p>Ut ab quia aut odit ullam et. Dolorem laborum et natus repellat quis voluptas consequuntur. Qui ad id libero quia temporibus dolorum.</p><p>Beatae omnis iste voluptas minima fugiat est. Animi assumenda quo ex vel neque eum. Necessitatibus soluta dolorem deleniti enim magni. Necessitatibus sed pariatur et ducimus eum.</p><p>Voluptates quis hic corrupti rerum. Ea consequatur vel aut inventore molestiae aut. Fugit et architecto id sit. Consequatur sit eligendi maxime facere qui sint atque.</p>', 'Odit ipsum tempore magnam deserunt. Dolore eum eum autem ipsa.', 0, 22, 6, NULL, 'thumbnails/', 'published', 732, 10, '2024-05-09 16:50:15', '2024-05-17 15:49:30'),
(45, 'BV-140425-80162530', 'Cumque quos sed qui iste voluptates. 67fc6aa1c699c', 'cumque-quos-sed-qui-iste-voluptates-67fc6aa1c699c', '<p>Autem ipsam molestiae sint temporibus. In recusandae cum est veniam libero est. Non expedita iure facilis animi qui. Culpa delectus nihil aut quidem sit ut nulla.</p><p>Sunt officiis sunt accusamus omnis repudiandae quo reiciendis voluptates. Praesentium inventore consequuntur consectetur suscipit. Culpa eos autem maiores dicta quod dolore et voluptatem. Nisi modi ut aut consectetur magni. Eum in sit quae qui molestiae.</p><p>Veniam rem vel ex rem nulla. Expedita autem dolore nihil. Quos sint quaerat placeat voluptatem animi quam. Numquam sit libero dolor consequuntur provident rem.</p><p>Voluptatem quia vel voluptatem reiciendis molestiae molestiae. Recusandae dicta quia mollitia est officiis laboriosam dolore. Reiciendis soluta qui repellat distinctio.</p><p>Et et sit consectetur hic. Repellat iure sit incidunt tempore. Rerum assumenda cupiditate ipsam repellendus inventore temporibus.</p><p>Recusandae blanditiis voluptatum magnam animi. Reprehenderit delectus eaque quisquam facere veritatis officia ea. Voluptatem sed voluptatibus et temporibus.</p><p>Iusto voluptatem et minima occaecati dolores. Aut dignissimos atque facilis quaerat.</p><p>Consectetur animi quo delectus. A vero sit temporibus ipsum officiis fugit. Aut adipisci in porro dignissimos temporibus molestiae qui quia. Voluptas illum iusto vel quam similique dicta. Nobis ipsa qui illo voluptas qui perspiciatis.</p><p>Nihil necessitatibus omnis qui. Ea est rerum optio molestiae molestias nisi. Quis odit odio sequi qui nulla. Nemo repudiandae praesentium nihil distinctio voluptates molestiae aut.</p><p>Repellat qui sed autem ducimus. Dolorum deleniti voluptatem rerum officia officia eum. Repellat fuga quis molestiae dolor quia quaerat pariatur aut. Ut tenetur optio culpa aperiam dignissimos error.</p><p>Deserunt dicta quisquam cupiditate quo eos suscipit quia et. Dicta in occaecati quia quam est consequatur et. Sit sed quia expedita accusantium et accusantium.</p>', 'Eaque voluptatem labore quasi sint velit temporibus repudiandae. Dolorum culpa quod dolorem rerum soluta recusandae. Rerum dicta sit perspiciatis dolore enim. Dolor rerum consequuntur iusto ullam sequi quas. Rem aut non laborum ipsam tenetur ex.', 0, 13, 10, NULL, 'thumbnails/', 'rejected', 89, NULL, '2024-11-03 02:21:54', '2025-04-12 03:57:04'),
(46, 'BV-140425-68131761', 'Excepturi eos ut quaerat numquam. 67fc6aa1c9722', 'excepturi-eos-ut-quaerat-numquam-67fc6aa1c9722', '<p>Voluptate dolorem tempore rerum cumque soluta. Qui nisi laboriosam nulla. Nulla mollitia neque non occaecati temporibus dolorem.</p><p>Eligendi quae rerum illum dolorem et nobis. Temporibus sequi molestias repellat optio est. Animi vel expedita sit et doloribus eveniet sit necessitatibus.</p><p>Mollitia ut est occaecati et voluptatum eligendi laboriosam. Nobis necessitatibus iure quo commodi. Magni vel ducimus repellat corporis officia rerum est. Aut delectus iusto maxime reprehenderit odit et libero.</p><p>Eius deleniti sequi rerum quis. Labore voluptatem laborum est dolores. Dolor reiciendis sint error debitis similique. Voluptatem asperiores corrupti quis minus possimus.</p><p>Quod facere sequi magnam excepturi praesentium ut. Sit deserunt rem libero. In veniam vero soluta sapiente provident nulla possimus illum. Cum ut quos voluptatem.</p>', 'Fuga ipsam quia ut doloribus reprehenderit odio totam. Magni quo eaque dolorem velit corporis. Cum incidunt enim quibusdam repudiandae odio nulla.', 0, 16, 10, NULL, 'thumbnails/', 'draft', 805, NULL, '2024-10-11 06:55:01', '2025-04-01 18:57:23');
INSERT INTO `articles` (`article_id`, `code`, `title`, `slug`, `content`, `preview_content`, `contains_sensitive_content`, `author_id`, `category_id`, `subcategory_id`, `thumbnail_url`, `status`, `views`, `approved_by`, `created_at`, `updated_at`) VALUES
(47, 'BV-140425-74974944', 'Amet minus ipsum tempore et aut qui. 67fc6aa1cc7a3', 'amet-minus-ipsum-tempore-et-aut-qui-67fc6aa1cc7a3', '<p>Modi nostrum consequuntur consequatur ratione expedita. Nobis quo soluta architecto quo nemo aliquam. Facilis itaque et nostrum voluptatibus.</p><p>Explicabo nihil iure et vel dolor voluptatem magnam. Quia voluptatem animi eos et eos repellendus. Aut quia aut perferendis magni vitae et sed. Nisi dolores sed natus.</p><p>Qui quo quam consequuntur id quisquam perferendis excepturi. Atque et repellendus quia. Praesentium nihil repellendus quam corporis est est.</p><p>Autem magni et cum qui quidem. Consequuntur tempora cum molestiae modi consequatur. Sint placeat sed ut aut sequi. Sunt quis veniam ipsam quos dicta harum.</p><p>Eum sapiente dicta in dolores. Ipsam architecto nam voluptates optio quisquam tempore quos. Aperiam et fuga necessitatibus. Odio minima quasi et.</p><p>Qui blanditiis animi non quod ducimus a et. Fuga ut et qui molestiae aliquam omnis. Voluptatibus velit necessitatibus neque nihil omnis molestiae.</p><p>Odio accusamus quas officiis tempora. Dignissimos a esse sunt et corporis. Nesciunt reprehenderit error voluptates reiciendis. Laboriosam deserunt porro ipsam dolor explicabo consequatur.</p><p>Repudiandae soluta ducimus impedit minima ut id. Laboriosam quod voluptas et.</p><p>Consequatur harum temporibus qui dolor. Voluptas maxime culpa recusandae temporibus qui non. Sint distinctio necessitatibus modi optio nulla veritatis dolorum.</p><p>Nemo dignissimos veritatis molestiae. Tempora veniam autem et aliquid assumenda eos voluptatem animi. Soluta architecto et similique sunt necessitatibus non.</p><p>Et possimus neque omnis. Vero dolorem harum neque at dolore modi. Et minus nihil qui.</p><p>Esse rerum ipsum adipisci earum aliquam quo. Rerum ut eveniet qui ipsam non sit. Corrupti animi velit eum molestiae ratione. Sapiente laborum ducimus fuga quis cumque voluptatibus.</p><p>Non consequuntur natus tenetur recusandae. Voluptas cupiditate voluptatem incidunt vel iusto. Quia vitae qui labore omnis at excepturi est autem.</p>', 'Aspernatur aliquam facilis explicabo ratione maiores. Et aut repudiandae distinctio atque vel explicabo nemo. Officia aperiam exercitationem nihil et esse. Rem id est qui nemo enim. Quos quaerat dolores et sed optio nobis eos.', 0, 4, 2, NULL, 'thumbnails/', 'published', 284, 9, '2024-06-06 21:08:08', '2024-06-18 04:23:43'),
(48, 'BV-140425-93009403', 'Officia vel commodi enim dolorem sed earum. 67fc6aa1d1370', 'officia-vel-commodi-enim-dolorem-sed-earum-67fc6aa1d1370', '<p>Perspiciatis omnis dolores nulla illum velit. Officia velit assumenda ab quo quidem doloremque. Amet aut deleniti provident perspiciatis. Vel qui esse vitae assumenda incidunt recusandae voluptatem adipisci. Esse omnis aperiam officiis dolores.</p><p>Et quisquam corrupti incidunt velit nisi. Corporis voluptas expedita reprehenderit ut voluptates ea sit. Quasi esse hic et illum veritatis dicta accusantium.</p><p>Ducimus alias iure corrupti architecto perferendis blanditiis. Totam ratione fuga architecto enim tempora optio. Aut vel ducimus eos tempore et sequi enim ut.</p><p>Et sequi id deserunt inventore sint est. Aut libero voluptas minima quod iusto expedita soluta. Atque suscipit voluptatibus beatae officia. Deserunt veniam consequatur eligendi laboriosam deleniti tempora ratione.</p><p>Rem quam hic aperiam nihil maiores nihil. Cumque accusantium facere repellendus ratione eveniet quia. Blanditiis itaque sunt in asperiores. Neque culpa corporis soluta dolore ut magni. Autem voluptatibus sunt ea est velit.</p><p>Doloremque unde atque aliquam dolorem itaque. Eum doloremque aliquid tempore est. Fugit repudiandae voluptas cum perspiciatis tenetur totam quis est.</p><p>Minus maxime aut quaerat nam quo ratione beatae qui. Quam aliquam qui pariatur eveniet dolores ea nulla. Sit voluptas quidem beatae tempora reiciendis voluptate. Rem quidem eaque dolor et soluta.</p>', 'Quia dicta ipsum qui animi itaque molestiae voluptates eos. Sed provident omnis eum id. Doloremque sunt est quo blanditiis. Enim est assumenda ut praesentium cum reprehenderit.', 0, 16, 8, NULL, 'thumbnails/', 'archived', 789, NULL, '2024-10-11 01:49:09', '2024-11-06 00:48:26'),
(49, 'BV-140425-91893598', 'Hic dolor minus eos porro facilis officia reiciendis. 67fc6aa1d4373', 'hic-dolor-minus-eos-porro-facilis-officia-reiciendis-67fc6aa1d4373', '<p>Aut consequatur nihil inventore quisquam. Tempora culpa velit mollitia ut perspiciatis velit corrupti. Consequuntur in minima qui. Autem ut sapiente in non fuga.</p><p>Aut mollitia accusamus non cupiditate. Rerum voluptate reiciendis doloremque facere quidem eos provident. Voluptates occaecati error alias ad. Est qui natus quia voluptatem accusamus corrupti.</p><p>Eum cumque aspernatur molestias dolorem repellat est in iusto. Odit corporis consequatur aut enim optio voluptatum ea. Dignissimos aut veniam eligendi quo.</p><p>Perspiciatis corrupti ut consequuntur sit tempore eos. Sint et nemo dolorem facilis pariatur. Id eaque hic omnis quidem alias alias non a. Tempora sit quo vel rem consequatur.</p><p>Qui unde dolores porro necessitatibus repellendus minus voluptatem. At doloribus et optio ab omnis dolores quo. Aut quis eos dolorem tempore commodi. Quibusdam soluta officia qui asperiores reprehenderit velit veritatis.</p><p>Suscipit et pariatur delectus cum tempore. Vero consectetur ut architecto. Est mollitia omnis non et aut voluptas.</p><p>Corporis ut et odit eum est qui. Doloremque explicabo mollitia aut natus voluptas magni. Excepturi error odio autem sit.</p><p>Numquam sed pariatur ea. A adipisci est quae ut. Ut excepturi id autem beatae voluptas suscipit consequatur. Totam enim omnis rerum dolore. Reiciendis illum harum nobis voluptatem explicabo ut.</p><p>Quod consequatur explicabo voluptatem quasi ullam nihil enim. Eos deleniti ut aut ducimus. Minima cumque expedita doloribus. Repellendus ratione cupiditate voluptatem blanditiis voluptatum ab ea. Quos quasi quisquam deserunt officiis necessitatibus at.</p>', 'Qui molestias velit architecto modi at rerum quia. Quo laborum doloremque quasi architecto. Tempore veritatis ipsa quos beatae est id modi et. Eum totam aut ut nihil distinctio nulla enim.', 0, 4, 2, NULL, 'thumbnails/', 'draft', 590, NULL, '2024-12-17 09:04:54', '2025-03-16 17:52:16'),
(50, 'BV-140425-64602326', 'Tempore aut sit et dignissimos suscipit possimus. 67fc6aa1d7a56', 'tempore-aut-sit-et-dignissimos-suscipit-possimus-67fc6aa1d7a56', '<p>Aut et sed autem id. Quibusdam sit qui sapiente nisi. Facere alias officiis quam labore dicta libero placeat. Fugiat officiis reprehenderit eos quam eos blanditiis neque.</p><p>Atque asperiores nihil accusamus dolor nobis iste. Eveniet laudantium omnis excepturi recusandae aut id alias. Eos consequatur dolorem alias facere.</p><p>Quas non repellat aut nesciunt debitis. Quia et minima eos. Neque non sed eligendi maiores sapiente fugiat. Corporis sequi doloremque voluptatum quod rerum non. Laboriosam eum veritatis ad voluptas.</p><p>Sint et qui omnis assumenda officiis. Quaerat qui molestiae ipsum ea soluta. Hic error dolorem pariatur harum. A voluptates quia aut molestiae eveniet rem. Vel voluptate eum quia voluptas vero incidunt.</p><p>Quaerat quidem velit magni totam quae. Rerum aspernatur facilis sed id optio alias. Eligendi a dolores molestiae sed non magnam quia.</p><p>Nobis est quod maiores aperiam voluptatem et. Omnis aut commodi quis officia aspernatur amet facere.</p><p>Sit dicta perferendis voluptas aut accusantium. Autem laboriosam et et voluptatibus.</p><p>Impedit ipsam ut ullam quisquam. Modi explicabo nostrum aut.</p><p>Sit tempora sed omnis quia id. Doloremque voluptas in culpa voluptate nihil tenetur quam. Veniam voluptatum et rerum doloribus. Illo et qui aut qui.</p><p>Aspernatur adipisci nisi quasi similique et ut. Architecto et et soluta recusandae sit eius. Eum consequatur beatae et perspiciatis laborum. Sed consectetur minima veritatis expedita neque. Minima minus est voluptatum similique ullam et.</p><p>Natus dolores voluptatum minima laborum molestiae. Aut sit tenetur est velit alias. Adipisci ab consequuntur molestiae sit. Eum rem et ullam et voluptatem optio officiis. Cupiditate fugit consequatur eius dicta.</p>', 'Quasi sint velit libero et. Magnam temporibus molestiae sequi iure. Fuga ut quod sint at voluptatem iste. Aut qui dolore et quia.', 0, 5, 10, NULL, 'thumbnails/', 'rejected', 21, NULL, '2025-01-15 06:04:08', '2025-04-06 09:40:14'),
(51, 'BV-150425-96381884', 'Có 3 cây vàng và 200 triệu tiết kiệm, nên mua nhà năm sau không?Có 3 cây vàng và 200 triệu tiết kiệm, nên mua nhà năm sau không?', 'co-3-cay-vang-va-200-trieu-tiet-kiem-nen-mua-nha-nam-sau-khongco-3-cay-vang-va-200-trieu-tiet-kiem-nen-mua-nha-nam-sau-khong', '<p>fewfewfwefewfewfwefdsfdsf</p>', NULL, 0, 1, 1, NULL, NULL, 'published', 3, 1, '2025-04-15 10:16:52', '2025-04-26 16:08:45');

-- --------------------------------------------------------

--
-- Table structure for table `article_history`
--

CREATE TABLE `article_history` (
  `history_id` bigint UNSIGNED NOT NULL,
  `article_id` bigint UNSIGNED NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `edited_by` bigint UNSIGNED NOT NULL,
  `edited_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `article_likes`
--

CREATE TABLE `article_likes` (
  `like_id` bigint UNSIGNED NOT NULL,
  `article_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `liked_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `article_likes`
--

INSERT INTO `article_likes` (`like_id`, `article_id`, `user_id`, `liked_at`) VALUES
(1, 40, 22, '2024-12-26 03:33:05'),
(2, 44, 6, '2024-07-19 05:13:35'),
(3, 30, 20, '2025-02-04 09:54:00'),
(4, 23, 3, '2024-10-03 02:52:11'),
(5, 47, 17, '2025-02-18 22:00:25'),
(6, 40, 10, '2024-08-11 01:49:31'),
(7, 4, 12, '2024-11-30 12:10:19'),
(8, 23, 24, '2025-01-06 13:39:41'),
(9, 44, 10, '2024-12-17 15:54:15'),
(10, 39, 25, '2025-03-21 07:58:18'),
(11, 44, 6, '2024-12-22 07:52:39'),
(12, 25, 4, '2024-08-19 05:31:30'),
(13, 39, 11, '2024-05-01 02:14:52'),
(14, 23, 23, '2025-03-05 18:07:36'),
(15, 4, 15, '2024-06-02 15:20:44'),
(16, 17, 3, '2024-12-09 14:45:20'),
(17, 17, 20, '2024-08-29 23:42:33'),
(18, 23, 22, '2025-01-08 15:06:01'),
(19, 47, 12, '2024-12-17 14:18:41'),
(20, 28, 18, '2024-08-08 11:26:02'),
(21, 40, 19, '2024-11-30 19:04:02'),
(22, 17, 10, '2024-09-19 07:44:10'),
(23, 23, 7, '2024-09-08 11:36:07'),
(24, 30, 15, '2024-04-20 03:05:11'),
(25, 47, 8, '2025-03-16 07:18:55'),
(26, 4, 10, '2025-02-19 11:59:40'),
(27, 30, 4, '2024-04-16 10:22:53'),
(28, 28, 1, '2024-09-08 10:48:22'),
(29, 40, 10, '2025-03-23 04:13:58'),
(30, 47, 18, '2025-01-07 10:00:49'),
(31, 44, 5, '2025-01-11 08:58:49'),
(32, 40, 6, '2024-12-04 21:28:53'),
(33, 39, 14, '2024-04-18 17:18:32'),
(34, 47, 12, '2024-06-02 05:43:34'),
(35, 30, 2, '2024-04-19 22:29:08'),
(36, 44, 10, '2024-07-14 23:20:20'),
(37, 39, 13, '2024-09-05 08:53:34'),
(38, 44, 17, '2024-06-14 09:53:11'),
(39, 4, 23, '2024-11-01 07:12:21'),
(40, 28, 11, '2025-04-01 09:48:18'),
(41, 39, 7, '2024-06-20 10:25:27'),
(42, 28, 8, '2024-10-29 21:45:18'),
(43, 28, 3, '2024-09-25 08:46:58'),
(44, 16, 14, '2025-01-11 04:06:08'),
(45, 30, 8, '2025-03-25 07:28:04'),
(46, 28, 7, '2024-10-25 15:55:48'),
(48, 47, 17, '2024-06-19 13:43:35'),
(49, 28, 19, '2024-09-18 11:28:00'),
(50, 44, 22, '2024-08-17 18:40:16'),
(51, 4, 25, '2024-11-19 14:47:48'),
(52, 44, 15, '2024-06-11 19:14:57'),
(53, 30, 23, '2024-11-01 05:27:52'),
(55, 39, 21, '2024-09-18 00:48:54'),
(56, 17, 21, '2025-01-23 10:30:05'),
(57, 4, 12, '2024-11-05 10:52:14'),
(58, 39, 17, '2024-07-11 02:11:24'),
(59, 40, 19, '2025-03-08 21:55:20'),
(60, 4, 10, '2025-02-11 02:15:58'),
(61, 23, 2, '2025-02-04 15:45:46'),
(62, 47, 16, '2025-03-21 16:18:24'),
(63, 17, 17, '2024-10-05 21:21:38'),
(64, 30, 25, '2025-03-06 15:31:05'),
(65, 47, 21, '2024-06-21 19:11:05'),
(66, 40, 10, '2024-11-26 22:14:33'),
(67, 16, 3, '2024-11-02 17:36:50'),
(68, 40, 6, '2025-03-07 20:44:42'),
(69, 17, 9, '2024-05-16 16:20:14'),
(70, 17, 19, '2024-05-28 10:27:52'),
(71, 25, 3, '2024-04-28 00:35:28'),
(72, 16, 9, '2024-10-19 08:09:46'),
(73, 25, 2, '2024-10-13 13:57:59'),
(74, 16, 25, '2024-10-07 16:04:01'),
(75, 28, 2, '2025-02-28 14:30:37'),
(76, 17, 16, '2025-03-17 01:29:08'),
(77, 4, 21, '2024-11-16 22:59:28'),
(78, 16, 6, '2024-06-22 06:48:13'),
(79, 4, 20, '2024-05-27 01:55:39'),
(80, 17, 5, '2024-05-02 02:41:04'),
(81, 23, 13, '2025-01-25 11:21:33'),
(82, 23, 25, '2024-08-07 03:10:49'),
(83, 23, 8, '2024-05-17 13:05:06'),
(84, 23, 22, '2024-09-14 23:38:18'),
(85, 47, 12, '2024-06-08 19:50:16'),
(86, 40, 16, '2024-12-08 04:12:41'),
(87, 4, 9, '2024-11-26 14:36:54'),
(88, 44, 2, '2025-03-20 15:29:13'),
(89, 39, 19, '2024-11-30 14:35:05'),
(90, 47, 7, '2024-07-25 02:34:31'),
(91, 40, 10, '2024-11-19 21:58:28'),
(92, 47, 25, '2024-08-04 01:55:24'),
(93, 4, 9, '2024-10-21 20:00:08'),
(94, 16, 18, '2025-03-21 02:06:10'),
(95, 16, 4, '2024-05-30 13:08:10'),
(96, 40, 7, '2024-08-30 11:25:57'),
(97, 16, 15, '2024-12-01 02:23:03'),
(98, 39, 4, '2025-03-23 14:49:12'),
(99, 39, 23, '2024-09-10 02:58:35'),
(100, 39, 18, '2024-11-18 19:04:41'),
(101, 17, 19, '2024-04-16 08:47:39'),
(102, 44, 11, '2025-03-21 22:24:24'),
(103, 40, 17, '2025-01-13 20:57:45'),
(104, 23, 15, '2024-08-16 01:50:28'),
(105, 47, 6, '2024-10-19 19:12:03'),
(106, 30, 19, '2024-11-23 05:40:08'),
(107, 4, 8, '2024-09-12 23:22:43'),
(108, 16, 6, '2025-01-17 20:35:14'),
(109, 47, 5, '2024-07-22 16:54:30'),
(110, 17, 7, '2024-10-08 05:51:15'),
(111, 16, 19, '2024-09-30 18:51:48'),
(112, 25, 9, '2024-09-30 04:31:06'),
(113, 16, 6, '2025-01-22 11:43:57'),
(114, 39, 13, '2024-05-09 13:22:11'),
(115, 30, 12, '2025-01-22 14:15:49'),
(116, 47, 19, '2024-06-21 07:01:29'),
(117, 44, 8, '2024-10-19 15:01:02'),
(118, 28, 10, '2024-05-16 21:29:38'),
(119, 4, 17, '2024-05-03 07:28:41'),
(120, 44, 7, '2024-07-02 09:03:19'),
(121, 16, 18, '2025-01-15 21:30:48'),
(122, 16, 24, '2024-06-25 00:09:35'),
(123, 28, 20, '2024-08-19 03:33:23'),
(124, 39, 10, '2024-09-13 04:59:19'),
(125, 39, 19, '2024-10-06 07:34:13'),
(126, 40, 5, '2024-12-30 20:43:37'),
(127, 44, 18, '2025-04-04 17:50:11'),
(128, 23, 7, '2024-11-04 07:10:44'),
(129, 16, 11, '2024-05-26 11:30:38'),
(130, 44, 3, '2024-11-17 22:33:15'),
(131, 16, 7, '2024-12-23 11:56:40'),
(132, 47, 25, '2024-06-24 18:20:09'),
(133, 4, 2, '2024-11-22 14:22:09'),
(134, 47, 8, '2024-04-23 11:18:38'),
(135, 25, 22, '2024-05-25 17:08:56'),
(136, 47, 15, '2024-08-19 12:37:52'),
(137, 44, 3, '2024-09-04 21:09:27'),
(138, 40, 9, '2024-05-25 04:18:17'),
(139, 47, 3, '2024-06-05 10:06:14'),
(140, 39, 4, '2024-10-06 05:07:35'),
(141, 16, 8, '2024-12-19 12:53:37'),
(142, 16, 18, '2025-02-03 01:22:35'),
(143, 4, 25, '2024-06-19 09:08:33'),
(144, 4, 15, '2024-11-13 22:40:58'),
(145, 16, 22, '2024-07-23 18:18:02'),
(146, 39, 16, '2024-05-08 20:48:25'),
(147, 40, 1, '2024-10-03 19:14:58'),
(148, 25, 25, '2025-01-28 22:35:59'),
(149, 4, 5, '2024-05-05 11:20:34'),
(150, 47, 9, '2024-10-25 12:39:48'),
(152, 39, 1, '2025-04-14 13:17:25'),
(155, 16, 5, '2025-04-17 05:40:02'),
(156, 51, 26, '2025-04-23 17:04:46'),
(157, 23, 5, '2025-04-23 20:31:00');

-- --------------------------------------------------------

--
-- Table structure for table `article_media`
--

CREATE TABLE `article_media` (
  `media_id` bigint UNSIGNED NOT NULL,
  `article_id` bigint UNSIGNED NOT NULL,
  `media_type` enum('image','video','link') COLLATE utf8mb4_unicode_ci NOT NULL,
  `media_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `caption` text COLLATE utf8mb4_unicode_ci,
  `position` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `article_saves`
--

CREATE TABLE `article_saves` (
  `id` bigint UNSIGNED NOT NULL,
  `article_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `article_saves`
--

INSERT INTO `article_saves` (`id`, `article_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 28, 23, '2025-03-07 19:37:45', '2025-04-04 00:52:15'),
(2, 44, 10, '2024-10-12 02:47:42', '2025-03-23 12:47:40'),
(3, 40, 12, '2024-07-20 05:53:47', '2024-09-28 22:19:30'),
(4, 39, 19, '2024-07-16 06:41:59', '2024-10-16 08:00:24'),
(5, 40, 3, '2024-06-21 13:39:58', '2024-08-17 03:30:44'),
(6, 25, 3, '2024-10-29 12:48:06', '2025-03-02 10:37:09'),
(7, 47, 19, '2024-11-03 16:24:29', '2024-12-03 22:45:43'),
(8, 17, 23, '2024-07-06 20:55:50', '2025-02-04 10:39:05'),
(9, 23, 2, '2024-06-01 20:39:30', '2024-12-22 16:41:47'),
(11, 16, 5, '2025-04-14 02:09:10', '2025-04-14 02:09:10'),
(12, 39, 1, '2025-04-14 13:17:18', '2025-04-14 13:17:18'),
(13, 51, 26, '2025-04-23 17:04:48', '2025-04-23 17:04:48');

-- --------------------------------------------------------

--
-- Table structure for table `article_tags`
--

CREATE TABLE `article_tags` (
  `id` bigint UNSIGNED NOT NULL,
  `article_id` bigint UNSIGNED NOT NULL,
  `tag_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `article_tags`
--

INSERT INTO `article_tags` (`id`, `article_id`, `tag_id`, `created_at`, `updated_at`) VALUES
(1, 1, 3, NULL, NULL),
(2, 1, 10, NULL, NULL),
(3, 1, 13, NULL, NULL),
(4, 1, 17, NULL, NULL),
(5, 2, 20, NULL, NULL),
(6, 2, 2, NULL, NULL),
(7, 2, 1, NULL, NULL),
(8, 3, 16, NULL, NULL),
(9, 3, 8, NULL, NULL),
(10, 4, 16, NULL, NULL),
(11, 4, 4, NULL, NULL),
(12, 4, 13, NULL, NULL),
(13, 5, 10, NULL, NULL),
(14, 5, 13, NULL, NULL),
(15, 6, 5, NULL, NULL),
(16, 6, 7, NULL, NULL),
(17, 6, 4, NULL, NULL),
(18, 6, 9, NULL, NULL),
(19, 6, 10, NULL, NULL),
(20, 7, 11, NULL, NULL),
(21, 7, 17, NULL, NULL),
(22, 7, 15, NULL, NULL),
(23, 7, 1, NULL, NULL),
(24, 8, 17, NULL, NULL),
(25, 8, 18, NULL, NULL),
(26, 9, 9, NULL, NULL),
(27, 9, 3, NULL, NULL),
(28, 10, 18, NULL, NULL),
(29, 10, 11, NULL, NULL),
(30, 10, 7, NULL, NULL),
(31, 10, 1, NULL, NULL),
(32, 11, 12, NULL, NULL),
(33, 11, 7, NULL, NULL),
(34, 11, 4, NULL, NULL),
(35, 11, 18, NULL, NULL),
(36, 11, 11, NULL, NULL),
(37, 12, 7, NULL, NULL),
(38, 12, 14, NULL, NULL),
(39, 13, 2, NULL, NULL),
(40, 13, 20, NULL, NULL),
(41, 13, 7, NULL, NULL),
(42, 13, 13, NULL, NULL),
(43, 13, 14, NULL, NULL),
(44, 14, 16, NULL, NULL),
(45, 14, 18, NULL, NULL),
(46, 14, 17, NULL, NULL),
(47, 15, 4, NULL, NULL),
(48, 15, 11, NULL, NULL),
(49, 15, 14, NULL, NULL),
(50, 15, 2, NULL, NULL),
(51, 15, 15, NULL, NULL),
(52, 16, 20, NULL, NULL),
(53, 16, 8, NULL, NULL),
(54, 16, 1, NULL, NULL),
(55, 17, 8, NULL, NULL),
(56, 17, 1, NULL, NULL),
(57, 17, 9, NULL, NULL),
(58, 18, 11, NULL, NULL),
(59, 18, 18, NULL, NULL),
(60, 19, 15, NULL, NULL),
(61, 19, 8, NULL, NULL),
(62, 19, 3, NULL, NULL),
(63, 19, 14, NULL, NULL),
(64, 20, 9, NULL, NULL),
(65, 20, 12, NULL, NULL),
(66, 20, 2, NULL, NULL),
(67, 21, 19, NULL, NULL),
(68, 21, 4, NULL, NULL),
(69, 22, 19, NULL, NULL),
(70, 22, 3, NULL, NULL),
(71, 22, 15, NULL, NULL),
(72, 22, 13, NULL, NULL),
(73, 22, 9, NULL, NULL),
(74, 23, 17, NULL, NULL),
(75, 23, 16, NULL, NULL),
(76, 23, 6, NULL, NULL),
(77, 23, 1, NULL, NULL),
(78, 24, 1, NULL, NULL),
(79, 24, 17, NULL, NULL),
(80, 24, 3, NULL, NULL),
(81, 25, 2, NULL, NULL),
(82, 25, 6, NULL, NULL),
(83, 25, 9, NULL, NULL),
(84, 25, 14, NULL, NULL),
(85, 26, 11, NULL, NULL),
(86, 26, 16, NULL, NULL),
(87, 27, 9, NULL, NULL),
(88, 27, 14, NULL, NULL),
(89, 27, 8, NULL, NULL),
(90, 27, 20, NULL, NULL),
(91, 28, 13, NULL, NULL),
(92, 28, 12, NULL, NULL),
(93, 28, 1, NULL, NULL),
(94, 28, 8, NULL, NULL),
(95, 28, 17, NULL, NULL),
(96, 29, 18, NULL, NULL),
(97, 29, 6, NULL, NULL),
(98, 29, 2, NULL, NULL),
(99, 29, 13, NULL, NULL),
(100, 30, 20, NULL, NULL),
(101, 30, 2, NULL, NULL),
(102, 30, 11, NULL, NULL),
(103, 30, 4, NULL, NULL),
(104, 31, 6, NULL, NULL),
(105, 31, 9, NULL, NULL),
(106, 31, 12, NULL, NULL),
(107, 31, 2, NULL, NULL),
(108, 31, 14, NULL, NULL),
(109, 32, 13, NULL, NULL),
(110, 32, 14, NULL, NULL),
(111, 33, 14, NULL, NULL),
(112, 33, 5, NULL, NULL),
(113, 33, 10, NULL, NULL),
(114, 34, 3, NULL, NULL),
(115, 34, 5, NULL, NULL),
(116, 34, 19, NULL, NULL),
(117, 34, 17, NULL, NULL),
(118, 35, 2, NULL, NULL),
(119, 35, 17, NULL, NULL),
(120, 36, 2, NULL, NULL),
(121, 36, 12, NULL, NULL),
(122, 36, 20, NULL, NULL),
(123, 36, 4, NULL, NULL),
(124, 37, 11, NULL, NULL),
(125, 37, 20, NULL, NULL),
(126, 37, 16, NULL, NULL),
(127, 38, 8, NULL, NULL),
(128, 38, 20, NULL, NULL),
(129, 38, 3, NULL, NULL),
(130, 38, 19, NULL, NULL),
(131, 39, 13, NULL, NULL),
(132, 39, 17, NULL, NULL),
(133, 39, 9, NULL, NULL),
(134, 39, 15, NULL, NULL),
(135, 40, 16, NULL, NULL),
(136, 40, 2, NULL, NULL),
(137, 40, 8, NULL, NULL),
(138, 40, 5, NULL, NULL),
(139, 40, 17, NULL, NULL),
(140, 41, 16, NULL, NULL),
(141, 41, 9, NULL, NULL),
(142, 41, 19, NULL, NULL),
(143, 42, 12, NULL, NULL),
(144, 42, 17, NULL, NULL),
(145, 43, 14, NULL, NULL),
(146, 43, 3, NULL, NULL),
(147, 43, 10, NULL, NULL),
(148, 43, 13, NULL, NULL),
(149, 44, 7, NULL, NULL),
(150, 44, 16, NULL, NULL),
(151, 44, 11, NULL, NULL),
(152, 44, 4, NULL, NULL),
(153, 45, 19, NULL, NULL),
(154, 45, 15, NULL, NULL),
(155, 46, 6, NULL, NULL),
(156, 46, 14, NULL, NULL),
(157, 47, 1, NULL, NULL),
(158, 47, 15, NULL, NULL),
(159, 47, 9, NULL, NULL),
(160, 47, 13, NULL, NULL),
(161, 47, 7, NULL, NULL),
(162, 48, 2, NULL, NULL),
(163, 48, 8, NULL, NULL),
(164, 48, 4, NULL, NULL),
(165, 48, 11, NULL, NULL),
(166, 48, 7, NULL, NULL),
(167, 49, 8, NULL, NULL),
(168, 49, 2, NULL, NULL),
(169, 49, 17, NULL, NULL),
(170, 49, 20, NULL, NULL),
(171, 49, 9, NULL, NULL),
(172, 50, 4, NULL, NULL),
(173, 50, 1, NULL, NULL),
(174, 50, 10, NULL, NULL),
(175, 50, 16, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `article_versions`
--

CREATE TABLE `article_versions` (
  `version_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `article_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` bigint UNSIGNED DEFAULT NULL,
  `subcategory_id` bigint UNSIGNED DEFAULT NULL,
  `featured_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tags` json DEFAULT NULL,
  `change_reason` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `article_versions`
--

INSERT INTO `article_versions` (`version_id`, `article_id`, `user_id`, `title`, `content`, `slug`, `category_id`, `subcategory_id`, `featured_image`, `tags`, `change_reason`, `created_at`, `updated_at`) VALUES
('BV-140425-07511883-v67fc6aa24000d', 40, 23, 'Ducimus quos eaque recusandae aspernatur dolorum.', '<p>Ex architecto facere molestiae sit. Eveniet harum eligendi voluptatem autem rem aut. Occaecati optio non ad deserunt officiis adipisci qui doloremque.</p><p>Omnis veniam tempore quasi repudiandae. Eos consequatur nihil reiciendis ut illum odio. Ipsum sed quis sequi corrupti ut voluptas accusamus. Odit autem qui id sit.</p><p>Consequuntur dicta est itaque quam enim quis voluptas. Id enim voluptates deleniti dolor sed quidem. Neque assumenda minus excepturi expedita maxime.</p><p>Occaecati maiores asperiores nostrum laboriosam. Qui eaque laudantium molestiae. Rerum totam quia quo qui accusamus. Nisi voluptate omnis necessitatibus repellat minima inventore alias placeat.</p><p>Nisi omnis doloribus adipisci hic quam odit soluta. Consectetur laudantium commodi doloribus.</p>', 'ducimus-quos-eaque-recusandae-aspernatur-dolorum', 7, NULL, 'thumbnails/', '[\"occaecati\", \"delectus\", \"commodi\", \"quae\", \"beatae\"]', 'Thêm thông tin mới', '2024-09-05 07:10:53', '2024-10-28 20:41:54'),
('BV-140425-07511883-v67fc6aa25057b', 40, 23, 'Doloremque praesentium et nemo consequatur quisquam.', '<p>Eius ea magnam non non quis. Rem similique et eos sapiente quo officiis. Eveniet et id quo ad eius. Ratione doloribus maxime eligendi voluptas commodi.</p><p>Accusantium qui ut dolor sunt. Praesentium excepturi earum possimus et quia. Qui quas vitae animi doloribus.</p><p>Ullam inventore et rerum et dolorum consectetur iure. Incidunt dolores voluptatem nulla eligendi cum velit veniam. Similique et vel doloremque odit. Non est aperiam perspiciatis magni natus.</p><p>Temporibus est nulla consectetur excepturi. Natus laboriosam molestias debitis. Temporibus necessitatibus ut molestiae veniam iure eius consequuntur. Et voluptates eligendi facilis voluptates ea. Doloribus omnis quia tempora voluptatem consequatur quis.</p><p>Quibusdam ullam ea adipisci eius. Autem necessitatibus fugiat vel quis aperiam est. Voluptatem velit et voluptatem nihil et.</p>', 'doloremque-praesentium-et-nemo-consequatur-quisquam', 7, NULL, 'thumbnails/', '[\"qui\", \"esse\", \"eum\"]', 'Sửa lỗi chính tả', '2024-06-15 10:07:55', '2024-11-17 22:15:39'),
('BV-140425-07667673-v67fc6aa228c33', 7, 7, 'Qui qui quam ea animi et quasi.', '<p>Velit sit ea optio aut et cum id. Nisi illum officia laboriosam ullam.</p><p>Eum velit aliquid fugiat. Tempore ullam eius itaque aliquid omnis commodi aut. Laboriosam deserunt delectus et quia assumenda sit ab.</p><p>Aut quia at vel quae aut consequatur optio. Et qui dolorem minima possimus ut in. Odit reprehenderit dicta sunt consectetur aut.</p><p>Fugiat doloremque voluptas dolorem doloribus quo aut consequatur. Laboriosam ad totam molestiae expedita quae. Et eos eos rerum.</p><p>Vero sit repellat corporis debitis. In perspiciatis aut tempore incidunt quas hic id. Consequatur ut ea natus repellat. Qui natus repudiandae aperiam voluptatum dolorem fugiat.</p><p>Optio veritatis quia in nesciunt error. Hic tempore aut ab. Voluptatem molestiae perspiciatis totam qui. Sed dicta quia laboriosam dolores vel reiciendis et.</p><p>Cupiditate iste at facere deleniti ea est non labore. Aperiam consequatur animi totam rem natus adipisci. Eum ut consequuntur voluptas recusandae aut rerum odio.</p><p>Sit et molestiae unde expedita dolores tempora nesciunt. Est nobis animi qui vel eveniet facere non quas. Qui ea voluptas corporis sequi reiciendis quam iure voluptas. Suscipit non reprehenderit ea sunt incidunt soluta ut.</p><p>Ut perspiciatis in necessitatibus sed voluptatem voluptatem iusto. Sed amet ea molestias quia quam sed consectetur. Vero aut doloremque et perferendis tenetur quis labore ad.</p><p>Et vitae asperiores reiciendis ad quasi. Velit nam aut atque eum nesciunt. Architecto voluptas dolorem dolore dolorem optio. Et ipsam nesciunt ullam rerum soluta.</p><p>Nulla rerum dolor ut voluptatem cum officia vel. Quis libero voluptatem cupiditate in. Aut consequatur consequatur quas deleniti nesciunt aliquid id. Natus qui amet non veniam sit id dolorem reprehenderit. Dolore quidem facere iure qui ea eligendi sit.</p>', 'qui-qui-quam-ea-animi-et-quasi', 9, NULL, 'thumbnails/', '[\"quod\", \"neque\", \"voluptatem\", \"qui\", \"veritatis\"]', 'Sửa lỗi chính tả', '2025-03-07 08:52:19', '2025-03-30 10:04:53'),
('BV-140425-07667673-v67fc6aa22b857', 7, 7, 'At aut natus dignissimos at.', '<p>Omnis assumenda dolores quae sequi voluptas. Nesciunt distinctio voluptate quia qui. Omnis est velit maiores vitae a omnis quis modi.</p><p>Id aut quas sunt et odio. Repudiandae aut aut unde modi. Unde qui ea et beatae aliquam omnis laboriosam.</p><p>Nihil rerum quidem distinctio tenetur perferendis quas accusantium accusantium. Soluta nesciunt ut error magni et. Laborum doloremque voluptatem earum quia tempora reprehenderit.</p><p>Ipsam magnam et unde. Nam quos quasi dicta aut sint et qui. Voluptatum adipisci fuga dolores officiis. Eveniet provident quaerat quidem nobis nostrum.</p><p>Libero est nisi labore architecto voluptas non voluptatum. Molestias sequi omnis atque eveniet sunt illo. Similique optio commodi et autem odit occaecati repudiandae.</p><p>Omnis ea quidem voluptate et. Architecto accusantium voluptatem quod voluptatem est excepturi voluptates. Eos autem doloremque dolores tempora autem perspiciatis esse.</p><p>Error amet sit in omnis exercitationem. Sapiente cumque consequatur dolores impedit sed minus quisquam molestias. Enim et alias esse perferendis. Dolores ea incidunt reiciendis. Facilis deleniti hic commodi sint id modi sed.</p><p>Assumenda quia amet corporis autem quam. Earum sequi natus culpa ea quos eos. Vel nulla ut porro perferendis.</p><p>Ad omnis laborum qui maxime illo asperiores beatae. Placeat sit voluptatum atque voluptas ut ut sunt doloribus. Laudantium reiciendis eligendi sit temporibus beatae.</p><p>Quo rem dolorem ut est. Molestias dolore nobis dolor. Autem totam nihil voluptate et. Quis qui sunt nam omnis.</p><p>Modi atque placeat sit quis provident. Hic at ut cum vel. Aut itaque eos iste commodi harum. Facere suscipit qui possimus qui recusandae.</p><p>Id dolorem maxime atque quis molestiae rerum qui quam. Quo et magni cum nobis. Aut corporis incidunt quam tenetur et dolores eius. Repellendus ducimus exercitationem eius commodi est architecto odit.</p><p>Reiciendis enim adipisci doloremque. Non eaque quam dignissimos velit eligendi facilis enim aliquid. Dignissimos reiciendis provident similique voluptatem. Ipsa harum soluta placeat minima laboriosam.</p>', 'at-aut-natus-dignissimos-at', 9, NULL, 'thumbnails/', '[\"vitae\", \"expedita\"]', 'Cập nhật nội dung', '2024-10-01 19:12:49', '2024-10-08 02:02:01'),
('BV-140425-07667673-v67fc6aa23290d', 7, 7, 'Doloremque ex iusto omnis officiis dolor vel facilis.', '<p>Nostrum voluptates aut minus adipisci nihil ipsum mollitia. Quod necessitatibus cumque blanditiis ut consequatur. Laborum nulla aut ut.</p><p>Tempora modi nostrum doloremque voluptatem. Ducimus rerum dolor rem minima iste. Laboriosam aut sequi libero sint omnis rem. Porro sequi alias molestiae omnis rerum sit est.</p><p>Alias laborum eum molestiae vero. Voluptatem nostrum dolore esse explicabo. Ut qui blanditiis sit fugit recusandae et voluptatem. Sit sed et voluptate voluptate dolores.</p><p>Autem tenetur qui quia molestiae. Non enim sunt quo voluptas omnis eligendi molestiae. Cupiditate soluta iusto architecto laborum consequatur. Eos voluptatibus quo nulla magni consequatur nam sapiente.</p><p>Doloribus tempora ex neque consequatur repellat pariatur voluptate. Enim natus eos labore aliquid molestias consectetur. Culpa voluptatem aut et minima itaque voluptates eum. Qui maiores dolorum ut tenetur id tenetur pariatur.</p><p>Rerum aut repellat laborum culpa minus. Soluta molestiae inventore vero nostrum modi voluptates. Error provident et commodi maxime et.</p><p>Omnis ipsam minus et. Voluptas iusto recusandae minima et voluptatem repellendus ut. Dignissimos incidunt et omnis excepturi velit consequatur. Minima dolores delectus assumenda ea fuga voluptatem optio.</p><p>Quia veritatis minus expedita repellat. Amet explicabo itaque quas optio ut assumenda autem. Commodi eligendi reiciendis laboriosam voluptatem et sint ratione. Non voluptatem eius laboriosam eos quisquam et soluta.</p><p>Esse laboriosam debitis aliquid autem saepe dolore laborum. Illo fugit magni quas eius et est.</p><p>Et earum blanditiis mollitia inventore consequatur. Molestias corrupti unde quasi aperiam. Et qui sit voluptas consectetur consectetur qui illo.</p><p>Sed voluptatem aut beatae. Non ut corrupti tempora corrupti quia. Dolores sint nostrum atque enim tenetur voluptatibus totam dicta. Et magni animi atque nisi quia.</p>', 'doloremque-ex-iusto-omnis-officiis-dolor-vel-facilis', 9, NULL, 'thumbnails/', '[\"eaque\", \"voluptas\"]', 'Tạo bài viết mới', '2024-11-26 17:15:05', '2025-02-04 19:59:51'),
('BV-140425-09241092-v67fc6aa22b1b1', 8, 7, 'Qui accusamus ipsam in necessitatibus.', '<p>Voluptatem veniam voluptatibus consequatur sed earum nobis. Iusto aliquam quia natus magnam officiis. Facilis vero distinctio voluptates architecto qui et. Harum voluptas repellat veritatis distinctio.</p><p>Tempora tempora veritatis dignissimos dignissimos est. Illo deleniti non tempora adipisci praesentium qui qui. Perspiciatis magnam alias dolorem. Consequatur nihil sit dolorem quo numquam recusandae cupiditate.</p><p>Possimus sed dolore officia praesentium excepturi eos. Non voluptatem ut aut et modi quia et. Itaque sunt qui voluptatem soluta fuga tenetur. Velit aspernatur autem quo reiciendis molestiae nesciunt. Eos ea doloribus doloribus at numquam exercitationem distinctio.</p><p>Veritatis velit ab nihil vel nam consectetur consequuntur. Sit autem ad aut dolores debitis. Consequatur provident rerum cumque libero amet explicabo nemo. Maiores sint dolorum illum dolorem optio laboriosam quo dolorem.</p><p>Placeat dolorum qui possimus atque eos facere ex aut. Optio maxime sunt architecto quos ipsa. At eum exercitationem at minima id ut. Quis cupiditate quia molestias. Voluptates quasi sed laboriosam quam tempora dolorem.</p><p>Facere hic modi et ut dolor tempore odit corrupti. Quis laborum omnis quo natus eius ipsa ut molestiae. Et tempore omnis nihil aut. Quas porro natus minima sit ea assumenda et.</p>', 'qui-accusamus-ipsam-in-necessitatibus', 10, NULL, 'thumbnails/', '[\"et\", \"sit\", \"ducimus\", \"cum\"]', 'Cập nhật nội dung', '2025-04-09 17:51:52', '2025-04-10 12:05:35'),
('BV-140425-09241092-v67fc6aa23bc37', 8, 7, 'Nesciunt nesciunt at molestiae quo vero voluptatem.', '<p>Et ut odio enim unde voluptates. Delectus dicta fuga ipsam eaque.</p><p>Cum ea impedit facilis tenetur adipisci. Et sed iure qui illum sint ad tenetur sint. Repellendus eligendi rem officiis ut voluptatem.</p><p>Molestias et eveniet dolor odio. Fugit optio architecto enim vero at doloribus. Iusto distinctio veniam eligendi repellendus repudiandae.</p><p>Itaque ipsam aut fugiat qui numquam occaecati ut. Dolorem dolorem consequatur praesentium sed voluptas. Omnis modi ducimus quis autem. Accusamus et sit cum mollitia.</p><p>Corrupti tenetur ea deleniti quo sunt voluptas dolorem. Dolor consequatur illo dolores vero necessitatibus. Corporis aspernatur ut corporis. Et sit ut perferendis autem suscipit aut minus.</p><p>Consectetur illo incidunt laboriosam reprehenderit mollitia aliquid voluptatem. Blanditiis nisi cumque pariatur dolore. Dolore atque harum dolore suscipit iusto quo.</p><p>Repudiandae eum temporibus eveniet possimus consequuntur repellat blanditiis. Fuga consequatur aut nostrum vel. A at similique dolorem architecto rerum quidem praesentium.</p><p>Sit aliquid eos veritatis nihil nobis mollitia ut nesciunt. Ut itaque nulla enim facere sunt. Autem officiis voluptas architecto quia iste dolores animi.</p><p>Neque dolor tenetur cum officia qui placeat. Fugit neque maxime excepturi enim corporis. Qui pariatur id natus aut commodi beatae.</p><p>Quia quo quidem necessitatibus incidunt consectetur. Enim vero velit laboriosam. Qui qui eos libero veritatis. Similique autem praesentium pariatur repellendus vel.</p>', 'nesciunt-nesciunt-at-molestiae-quo-vero-voluptatem', 10, NULL, 'thumbnails/', '[\"sed\", \"est\", \"ducimus\"]', 'Sửa lỗi chính tả', '2024-04-29 00:56:56', '2025-02-27 08:29:30'),
('BV-140425-09241092-v67fc6aa23d603', 8, 7, 'Occaecati similique sit doloribus eum quidem ducimus culpa.', '<p>Odit itaque voluptatem numquam impedit voluptas enim repellendus necessitatibus. Consequatur et quibusdam dolores nihil expedita.</p><p>Quas saepe sit nisi et corporis doloribus. Aut dolorum quisquam soluta et eveniet.</p><p>Voluptatem enim esse est distinctio. Sit voluptates et harum quo voluptate nulla nemo. Reiciendis quaerat est ea deserunt.</p><p>Voluptates voluptas vel sed eos quis est atque aut. Nihil architecto ut saepe incidunt pariatur facere. Omnis commodi fugit eos doloremque fugit sed. Facilis porro dolorem et sint officiis quaerat assumenda.</p><p>Ut qui minus eos quidem assumenda doloremque cumque. Sapiente tenetur sint quia alias sed nostrum beatae. Hic labore rerum ea consequatur pariatur. Sequi nam impedit dolorum officia est.</p><p>Voluptatem harum facilis corporis ab sed eum fuga error. Id doloribus quas rerum consequatur culpa. Illum possimus incidunt est qui est.</p><p>Consectetur accusamus voluptas fugiat non et velit libero. Unde assumenda corporis dolore culpa eum iste reprehenderit. Quia consequatur laudantium cumque possimus magni in. Aliquid voluptatem eum similique quasi maxime temporibus aspernatur.</p><p>Veniam veniam veniam debitis necessitatibus repellendus fugit. A veniam dolores quod. Officiis est eius officia eligendi ex quo.</p><p>Quae et sequi ut. Ad voluptas est et iste vel optio accusamus.</p>', 'occaecati-similique-sit-doloribus-eum-quidem-ducimus-culpa', 10, NULL, 'thumbnails/', '[\"sit\", \"harum\", \"nisi\", \"in\", \"quia\"]', 'Cập nhật nội dung', '2025-02-25 23:23:15', '2025-04-05 00:43:04'),
('BV-140425-09241092-v67fc6aa242198', 8, 7, 'Ea nesciunt occaecati eos quae et ipsa.', '<p>Distinctio magnam quidem occaecati quas dolores corporis rem reiciendis. Et aliquam harum voluptas sed rerum similique. Nostrum reprehenderit vel incidunt pariatur. Temporibus beatae repellat ut qui.</p><p>At consequatur exercitationem explicabo ut aut qui. Aut voluptatem magnam at alias. Aut eum incidunt voluptas id. Veritatis rerum nesciunt rerum minima fuga facilis earum aperiam.</p><p>Sit quo aut omnis voluptatibus sint pariatur ut. Voluptas commodi totam ipsa minima.</p><p>Architecto molestias et molestias. Id magni et sit. Hic assumenda et sed.</p><p>Magni adipisci qui id non sit. Quasi eveniet voluptas aut aspernatur nostrum labore aliquid voluptate. Cum molestiae modi provident esse beatae quia. Laudantium quis deleniti magni veritatis error illo ratione.</p><p>Officia adipisci pariatur neque dolores quod sit dolorem. Enim aperiam delectus iure libero. Adipisci et impedit debitis et nulla. Voluptates odio voluptates blanditiis at veniam.</p><p>Nisi officiis accusantium voluptatibus doloribus nemo eligendi. Incidunt aut veniam perspiciatis quia sapiente temporibus. Dolorum consequatur ad rem doloremque molestias rerum.</p><p>Adipisci quasi voluptatem magnam id. Ad maxime amet rerum dolor. Rerum sed fugiat velit laudantium eos. Sequi doloremque consectetur consequatur.</p><p>Qui suscipit minima nobis temporibus perspiciatis. Velit officia animi illum est alias. Dicta quaerat accusamus eum eaque. Nihil consequatur amet et deleniti exercitationem.</p><p>Et vel nulla soluta a dicta aut. Et laboriosam sunt aliquam. Eos et consectetur numquam adipisci.</p><p>Placeat dolore veniam dicta vel animi voluptate aspernatur. Mollitia non modi magnam quos accusamus. Consequatur deleniti deleniti sunt praesentium repellat sapiente cupiditate soluta.</p>', 'ea-nesciunt-occaecati-eos-quae-et-ipsa', 10, NULL, 'thumbnails/', '[\"sint\", \"voluptatibus\", \"non\", \"voluptatem\"]', 'Cập nhật hình ảnh', '2025-01-20 08:32:31', '2025-01-22 00:02:38'),
('BV-140425-09241092-v67fc6aa251551', 8, 7, 'Qui voluptates delectus ipsa pariatur ut et quia autem.', '<p>Commodi corrupti porro incidunt mollitia quis amet debitis. Ut neque repellendus numquam repellendus est nisi. Temporibus iure doloremque hic. Deleniti quae consequatur omnis occaecati fugit sequi.</p><p>Illo aspernatur voluptates in dignissimos. Dicta reprehenderit ut cumque et iusto velit aliquam. Sunt officiis molestiae aut quia nihil id fugit. Laudantium vitae voluptatem expedita cumque.</p><p>Nihil corporis a sapiente repellat vitae. Minima aut quibusdam voluptatem ut. Corrupti aut hic nesciunt excepturi qui inventore. Quis rem voluptatem nisi et ut deserunt qui.</p><p>Praesentium voluptates ullam est excepturi. Nisi rem et in velit. Consequatur esse omnis et. Excepturi quia magni velit laboriosam.</p><p>Laudantium est aut recusandae quia placeat. Ut atque et vel ut in. Ipsa commodi et exercitationem praesentium.</p><p>Quae aut odio ad ipsam laudantium voluptatem illo officiis. Ut illum pariatur veritatis eius. Quia ea esse atque est hic autem.</p><p>Vel aspernatur ex aut exercitationem. Dolorem quia nulla vero. Et numquam et et magnam animi. Dignissimos sapiente ad consequatur alias.</p><p>Dolores fugit aut et molestiae. Voluptas ipsa non accusamus et ut omnis rerum. Error odio dolorum voluptatibus quis. Qui vel cum accusamus vel quidem eligendi incidunt.</p><p>Repellendus est praesentium repudiandae ad sint voluptatum. Et eum reprehenderit velit atque quis. Voluptate aspernatur ratione rerum earum distinctio eos.</p>', 'qui-voluptates-delectus-ipsa-pariatur-ut-et-quia-autem', 10, NULL, 'thumbnails/', '[\"eligendi\", \"fugit\", \"expedita\"]', 'Thêm thông tin mới', '2024-09-17 21:16:48', '2024-12-24 21:21:43'),
('BV-140425-10796538-v67fc6aa21aa23', 1, 22, 'Amet ut non est repudiandae est dolores.', '<p>Fugit voluptas quasi eos nesciunt magnam. Ad quidem dolorem nostrum. Dolore nihil omnis ut distinctio.</p><p>Et placeat et impedit qui enim. Dolores doloribus explicabo et qui quo. Ab ea numquam accusantium accusamus dolor id. Esse consequatur dicta consequatur architecto reiciendis et.</p><p>Qui aperiam alias voluptatum et. Laborum perferendis nemo voluptas sint illo. Pariatur officia velit nulla sed quibusdam. Aut quis voluptas id sint.</p><p>In neque facilis facere qui. Quasi unde ut sint et temporibus. Quasi consequatur nostrum esse sit. Cupiditate inventore veritatis pariatur qui.</p><p>Similique tempora sit aut non. Aliquam soluta omnis voluptas assumenda excepturi voluptatem. Et temporibus id rerum nihil consequatur exercitationem ipsam. Rerum iste mollitia qui neque.</p><p>Quibusdam repellendus dolor enim ducimus. Aut ut est ratione sed ab dolores nostrum. Deserunt praesentium cupiditate quia doloremque assumenda. Reiciendis ut nesciunt voluptates neque exercitationem.</p><p>In necessitatibus sunt veritatis illo minima dolores cumque. Sit distinctio quo dolores dolor a eligendi eligendi aspernatur. Quam alias cupiditate sint voluptatem.</p><p>Libero nihil iusto tempore enim. Consequuntur quis numquam iste optio. Quo totam doloremque aut culpa dolor velit. Rem magni numquam praesentium a.</p><p>Quos quis tempore repudiandae exercitationem veniam dolorem incidunt. Ut ut debitis voluptatem enim nisi.</p><p>Repellat dolorem ut quasi aut nobis qui quis. Ipsa accusantium accusamus unde qui ea necessitatibus sequi. Labore ut nisi beatae tenetur voluptate error dicta. Non ducimus eos voluptatem debitis quo eos nemo. Quia vitae voluptatem cum et sed.</p>', 'amet-ut-non-est-repudiandae-est-dolores', 2, NULL, 'thumbnails/', '[\"repellat\", \"minus\", \"minus\"]', 'Sửa lỗi chính tả', '2024-08-28 06:28:35', '2024-09-14 15:16:58'),
('BV-140425-10796538-v67fc6aa221c92', 1, 22, 'Ut enim assumenda blanditiis tempore ut aut.', '<p>Explicabo est blanditiis eum autem reiciendis maxime fugiat. Corporis earum cupiditate incidunt deleniti. Velit ut error odit facilis ratione.</p><p>Officiis fugiat tempora ea architecto. Repellat sunt sed dolore et ut similique. Voluptatem sunt consequuntur velit pariatur perferendis qui.</p><p>Explicabo veniam fuga blanditiis non. Quos assumenda quas sit et. Odio praesentium quae quia dolorum.</p><p>Aut aut sint soluta libero quo est ea. Consequatur consequuntur reiciendis ullam consequuntur ut facilis et. Laborum exercitationem ratione maxime amet et fuga.</p><p>Cupiditate accusantium officia et eum est dolor. Maxime beatae quas et. Et deserunt in exercitationem ex qui corporis itaque.</p><p>Magni unde ut dolorem quia quibusdam autem. Hic inventore ipsam perferendis rerum quidem. Asperiores iste ipsa aliquam temporibus asperiores quae. Quisquam totam quam non aut dolore.</p><p>Perferendis adipisci iusto doloribus suscipit quos sed. Blanditiis ut possimus eum laboriosam. Rerum provident ipsum veritatis voluptate officiis. Ducimus aut facilis quia velit sit eveniet et. Earum exercitationem totam unde ut doloremque voluptas magnam.</p><p>Iure ut aliquam iure non autem. Libero ad quasi ipsam impedit sapiente consequuntur. Corrupti suscipit ea et animi. Labore aspernatur consequatur repellat accusantium soluta aut aut.</p><p>Corporis quo est aspernatur officia. Nam quibusdam earum et porro cum. Voluptatem dicta rerum error at error a.</p>', 'ut-enim-assumenda-blanditiis-tempore-ut-aut', 2, NULL, 'thumbnails/', '[\"consequatur\", \"quam\", \"sit\"]', 'Cập nhật hình ảnh', '2024-10-14 22:43:59', '2025-03-19 05:00:38'),
('BV-140425-13740515-v67fc6aa224c98', 44, 22, 'Est enim repellat amet.', '<p>Iure aut amet perferendis deserunt. Vero vero amet vero ea occaecati. Quo autem recusandae atque vel similique.</p><p>Distinctio illum neque qui ratione et est et. Praesentium enim ut sed sint officiis iure. Modi eligendi placeat aut at dolor voluptas eos. Qui saepe ut quasi molestiae. Saepe molestias perspiciatis minima et accusantium.</p><p>Nemo ut dolores asperiores laudantium praesentium. Architecto deleniti fugit excepturi dolores aut voluptas sed. Qui quaerat enim minus est et provident. Dolorem sunt culpa dolore vitae temporibus rerum. Rerum ipsam voluptas voluptatem dolor modi.</p><p>Est quia laboriosam libero quos non et temporibus eaque. Amet et nam animi. Aut dolore aspernatur velit quam et.</p><p>Sit voluptatem nemo qui ea et provident non. Voluptas similique quia iure sint quibusdam quia. Qui asperiores veritatis iste doloremque unde. Sed saepe vel consequatur modi a hic omnis sunt.</p><p>Eligendi inventore mollitia impedit sint maxime et qui itaque. Quia fugit expedita et nesciunt. Ut dolorem et recusandae maiores sunt voluptas quia.</p><p>Qui doloribus rerum et eum aut. Corrupti possimus tempore temporibus et velit aspernatur. Consequatur dolor sit deleniti molestiae laudantium et.</p><p>Nam nulla minima aut ut facere. Veritatis et voluptatem facere aut. Veritatis et atque facilis non. Quasi aut mollitia nemo consequatur. Repellat sed itaque reiciendis harum.</p>', 'est-enim-repellat-amet', 6, NULL, 'thumbnails/', '[\"esse\", \"fugit\", \"maiores\", \"consequatur\", \"laborum\"]', 'Sửa lỗi chính tả', '2024-06-12 23:59:29', '2024-08-09 10:43:36'),
('BV-140425-13740515-v67fc6aa235e92', 44, 22, 'Voluptas laboriosam aut nobis officia neque labore.', '<p>Numquam qui quam asperiores. Dolor consectetur doloremque ut facere dignissimos.</p><p>Eligendi eos aut consequuntur sint. Saepe debitis est explicabo non facilis assumenda distinctio. Itaque itaque aut natus. Laboriosam soluta deserunt molestiae repellat rerum aut. Quam dolor iste alias error.</p><p>Possimus quia rerum occaecati dicta magni. Corrupti molestias quae molestiae aut. Maiores id a non quidem. Ut dolores reiciendis sequi commodi sed repudiandae.</p><p>Quae occaecati reiciendis officiis velit. Nemo dolorum nemo eveniet rem molestias. Perspiciatis in quidem fugit rem ut distinctio sequi.</p><p>Dicta ut tempore reiciendis. Dignissimos et optio aut ut ullam laborum in exercitationem. Earum nihil aliquid non itaque est neque.</p><p>Nostrum quo nostrum minima ut et atque. Qui vitae dicta vitae quidem omnis.</p><p>Cupiditate magni a officiis totam blanditiis commodi. Placeat aliquid omnis sed illum officiis autem saepe. Eum placeat eum voluptates dolores in dolore sapiente.</p><p>Est aut commodi magni repellat nihil. Sed delectus aperiam praesentium eum. Quam distinctio voluptatem quibusdam eius.</p><p>Voluptate facere unde fugit quidem non ut incidunt. Similique officiis et minus et et vel voluptatem. Earum enim ipsa inventore id reiciendis corrupti in.</p><p>Cum delectus doloremque sunt nihil veniam. Quaerat facilis voluptatibus necessitatibus vero qui dolores. Autem earum magnam dolores assumenda amet ut architecto. Rem laborum in corrupti temporibus ipsa qui doloremque aut.</p><p>Esse dolorum autem nulla ea esse cum dolorem sed. Aut rerum quaerat non perspiciatis. Reprehenderit perferendis voluptatem omnis optio. Odit saepe expedita molestiae dolorem perferendis unde.</p><p>Ea aut inventore eum. Debitis possimus enim explicabo et omnis libero sit. Explicabo inventore laborum explicabo enim dolor. Amet possimus sequi veniam aut est voluptatibus.</p><p>Ipsam quaerat sed rerum occaecati nam autem esse. Impedit amet ducimus laudantium est modi voluptatem sint. Et sint ex vel eos aliquid voluptas. Similique quia cumque dolorem libero aut nihil et sed.</p><p>Ab ducimus quibusdam accusamus dicta magni. Voluptatum et sequi eos ut. Maxime omnis est et ad fugit nobis dolorem. Rerum ipsam quis qui ullam consequuntur.</p>', 'voluptas-laboriosam-aut-nobis-officia-neque-labore', 6, NULL, 'thumbnails/', '[\"fuga\", \"numquam\", \"aspernatur\", \"totam\"]', 'Cập nhật hình ảnh', '2025-02-06 19:58:09', '2025-02-19 16:59:52'),
('BV-140425-14748173-v67fc6aa245c0d', 14, 5, 'Assumenda qui debitis in itaque debitis ab illum.', '<p>Eligendi laudantium blanditiis accusantium nisi doloremque. Temporibus iste eveniet quis sed sit sapiente. Dolores voluptatibus voluptas tempore dolores numquam.</p><p>Illum consequatur doloribus eum ea rerum. Asperiores vitae corporis sit ipsum quidem a animi. Facilis consequuntur illum autem sit et. Sint impedit voluptatem illum et. Qui sunt dolores et dolores corporis est atque.</p><p>Voluptatem consequatur repudiandae veniam sapiente mollitia consequatur blanditiis. Molestiae magni tenetur ex dolorum placeat est. Id quasi et hic officiis sequi temporibus nisi.</p><p>Veritatis quidem dolorem ut ducimus. Veniam debitis iste dolore aut amet earum. Veniam corrupti ut consequatur earum iure ut.</p><p>Autem tempora quo aut unde dignissimos eaque. Beatae quas adipisci et. Ipsam quam exercitationem voluptatem perspiciatis molestias.</p><p>Officia qui vel dignissimos est voluptas mollitia id. Cumque dolorem blanditiis sunt sit. Sunt consequuntur omnis recusandae sint non.</p><p>Perferendis veritatis quaerat architecto reiciendis optio dolorem voluptatem. Harum exercitationem qui repudiandae aut ut. Rerum laborum dolorem aut laboriosam.</p>', 'assumenda-qui-debitis-in-itaque-debitis-ab-illum', 1, NULL, 'thumbnails/', '[\"quibusdam\", \"sit\"]', 'Cập nhật nội dung', '2025-01-09 10:21:31', '2025-01-25 14:13:33'),
('BV-140425-14748173-v67fc6aa24fda3', 14, 5, 'Sed nobis vel cum architecto.', '<p>Possimus aliquam consectetur odit officia omnis quidem quia minus. Officia est nulla quidem officia laboriosam adipisci. Recusandae sed est fuga.</p><p>Soluta ad nihil iusto reiciendis consequatur. Quas qui rerum est voluptas quas architecto. Alias impedit dolorem atque. Modi corrupti et alias. Ipsum autem sit et et nihil.</p><p>Est optio voluptates placeat enim velit qui beatae. Inventore adipisci qui molestiae cupiditate.</p><p>Quia et dolorem voluptate aut. Officiis fugiat harum vel voluptate. Officiis et et sed enim quisquam harum ipsum.</p><p>Quasi laborum ipsam quia in vero sapiente recusandae. Doloribus quibusdam expedita qui voluptatem. Provident dolores sed dolores ipsa voluptas laboriosam aliquid ipsam.</p><p>Quod non quae iusto dicta amet qui distinctio. Omnis ad aut quia sint sint omnis quas. Quasi qui quisquam alias et nulla.</p>', 'sed-nobis-vel-cum-architecto', 1, NULL, 'thumbnails/', '[\"saepe\", \"ea\", \"impedit\"]', 'Cập nhật hình ảnh', '2024-05-02 20:58:22', '2024-07-07 21:34:31'),
('BV-140425-16695825-v67fc6aa225691', 35, 16, 'Molestiae dolor et et dolorum vel tempore.', '<p>Magni qui sed non et ea. Inventore voluptatum recusandae iste doloremque cumque consectetur totam. Blanditiis et velit qui ut nostrum accusamus omnis.</p><p>A vel eum cumque. Non ut eveniet quasi et omnis ducimus quidem. Enim aperiam adipisci modi vel minima. Ut at similique est laudantium incidunt vel.</p><p>Ducimus officia rerum quisquam doloremque et. Doloribus sunt natus sunt id voluptas ut.</p><p>Autem qui incidunt architecto similique dolores inventore. Dolor voluptatum accusantium quo. Molestiae temporibus enim harum accusantium et id iusto.</p><p>Et quidem et tenetur autem consequatur. Et qui aliquam laboriosam autem ratione et quibusdam. Perferendis in facere blanditiis dolor aperiam modi. Nihil voluptas totam vel vero voluptate.</p><p>Eos dolores incidunt et provident ea. Dignissimos aspernatur labore maiores omnis deserunt unde.</p><p>Facilis atque illo hic asperiores praesentium facere dolores enim. Laudantium maxime laborum quia et nobis. Perspiciatis quia quisquam necessitatibus optio est similique corrupti consectetur. Cupiditate est est aliquid neque rerum.</p><p>Ut magnam cumque quos eum repellendus suscipit. Magni quis molestiae rerum nobis sed earum facilis. Possimus repellat qui veniam et dolor.</p><p>Molestiae soluta in consequatur saepe omnis perspiciatis. Qui hic vitae quia qui veritatis ratione. Occaecati animi rerum excepturi quia veniam repudiandae rem. Voluptatem ad similique quaerat est modi.</p><p>Id sint et aut est autem corrupti ex optio. Ex nulla animi non esse quas aliquid officiis. Hic ut sunt eaque reprehenderit rerum et.</p><p>Ut maxime sint ratione voluptatibus architecto laboriosam. Deserunt ut eaque aperiam id. Voluptatibus eum saepe voluptas sed ad.</p><p>Unde modi ullam hic voluptatem. Magnam sed voluptatem quidem consequatur pariatur. Est incidunt voluptatem non accusamus corporis.</p><p>Iste quis eum porro nulla beatae velit ratione. Molestias voluptas quam eos molestias pariatur. Sapiente nulla molestias assumenda dolor. Fuga qui ab deleniti ut sed iusto delectus atque. Perferendis libero quo velit quia ipsum modi quas.</p><p>Eaque natus illo qui ex laborum dolor. Sequi ut molestiae sed laborum.</p>', 'molestiae-dolor-et-et-dolorum-vel-tempore', 1, NULL, 'thumbnails/', '[\"libero\", \"consequatur\", \"aut\"]', 'Thêm thông tin mới', '2024-12-08 11:51:25', '2025-03-06 01:26:40'),
('BV-140425-16695825-v67fc6aa2372f6', 35, 16, 'Suscipit quas mollitia unde voluptate pariatur adipisci quam.', '<p>Est excepturi in vel eius qui repellat tempora magnam. Voluptatibus quos earum suscipit consequuntur.</p><p>Non aut minus dolorem assumenda ut omnis earum. Possimus sit fuga eum quibusdam similique eveniet. Omnis sit laborum vel.</p><p>Officiis et eum fugiat repudiandae non dolor labore. Rerum dolor debitis aliquam repudiandae asperiores. Minima quaerat possimus veritatis molestiae voluptatem. Ipsa reiciendis et non iure minima.</p><p>Sit veniam quas optio doloribus quidem ab ut. Architecto voluptates eum ea sunt nobis voluptates ea. Numquam eius omnis illo nesciunt. Porro ut eos est esse nulla qui.</p><p>Natus ab voluptatum ducimus exercitationem aut. Debitis recusandae numquam aut perferendis sunt recusandae quas. Temporibus veniam omnis eligendi nisi eum.</p><p>Sint omnis atque et qui consequatur perferendis. Animi officia reprehenderit autem enim voluptatem qui. Praesentium autem voluptas saepe aut necessitatibus. Temporibus quibusdam aut perferendis mollitia autem voluptates. Consequatur velit consectetur libero aspernatur est voluptatum in.</p><p>Suscipit accusantium consectetur recusandae natus et. Provident blanditiis cum ut id aut voluptas esse. Quasi aspernatur voluptas voluptas sint.</p><p>Repellendus itaque ratione culpa et et eum est nobis. Deserunt eos sit est cumque harum consequatur inventore. Qui nulla repudiandae maxime reiciendis.</p><p>Deleniti sapiente nihil nemo repellat voluptatem sunt sit. Omnis deleniti quia iste consequuntur pariatur sint. Minima voluptas voluptatem aspernatur sed enim ut. Deserunt occaecati magni accusantium sint debitis enim.</p><p>Sit voluptatibus explicabo facere recusandae cum illum iure. Omnis atque et voluptas velit alias.</p><p>Ipsum omnis quaerat itaque dolorem repellendus. Quia est accusantium eligendi dicta molestias adipisci. Corrupti cumque sed cumque id illum iure iusto et. Officia similique unde sunt aut impedit quia. Voluptates vitae omnis aut ipsam.</p><p>Nostrum rem itaque est aut ratione deleniti. Odio nam est id qui. Id ea est beatae reprehenderit. A ratione aut fuga officia incidunt vel voluptatem.</p><p>Amet nihil ipsum et commodi aut cum. Eius aut quidem hic ipsam quod ut. Asperiores suscipit ab perspiciatis fugiat harum ipsa.</p><p>Dolore et ut est est perferendis quas nulla sapiente. Laboriosam commodi facilis rerum tempora consectetur maxime sed qui. Quisquam voluptatem ad distinctio. Itaque quas nesciunt quia et suscipit. Molestiae numquam dolorum repudiandae.</p>', 'suscipit-quas-mollitia-unde-voluptate-pariatur-adipisci-quam', 1, NULL, 'thumbnails/', '[\"dolorum\", \"et\", \"labore\", \"dolores\"]', 'Thêm thông tin mới', '2024-10-31 00:47:43', '2025-03-22 20:34:07'),
('BV-140425-16695825-v67fc6aa2409d4', 35, 16, 'Dolor esse debitis quo vero quos quidem.', '<p>Officiis non sed ut et. Recusandae quasi quidem cum voluptas sed distinctio exercitationem aut.</p><p>Porro ut adipisci iure debitis eveniet tenetur ea. Deleniti dolorem magni dolorem quia nesciunt eum. Sint qui qui eum cum voluptatibus.</p><p>Reprehenderit quidem velit ea. Nobis voluptatem in eius. Voluptatem tempora qui illum et ex. Id qui ipsum voluptas et velit cupiditate sit.</p><p>Omnis maiores aspernatur nisi velit voluptas. Temporibus omnis et dolorum consequatur ut. Et est vel quis saepe est harum.</p><p>Aut enim ut maxime esse ut. Molestiae pariatur ut asperiores. Dolorem repudiandae velit cumque sint dolores numquam et voluptatem.</p><p>Eveniet velit neque suscipit dignissimos doloribus consectetur placeat. Rerum fuga rem deleniti aut labore et. Exercitationem et vel dolores perspiciatis voluptates.</p><p>Totam qui odio praesentium reiciendis dolore earum exercitationem. Eveniet dicta dolor distinctio voluptatem repellendus qui. Necessitatibus nihil molestiae et voluptatum nobis quos est. Temporibus dolorem sit sed provident.</p><p>Et quis ut nemo sed eum. Rerum nostrum qui fugiat illo. Id laboriosam in molestias est velit et sit. Consequatur aut atque voluptatum occaecati ut.</p><p>Eaque rerum minima inventore exercitationem vel nemo. Et voluptas delectus repudiandae dolorum quod.</p><p>Hic blanditiis qui qui sequi sint aliquid. Et voluptatem qui cumque vitae. Repellat sequi quibusdam nobis ut quisquam vitae ullam.</p><p>Quasi voluptates omnis ad illo modi ratione. Voluptatem autem molestias error ut quia ut aliquam. Ab doloribus rerum dolorem voluptatum ea quae. Ut veritatis vero quia quas blanditiis vel reprehenderit.</p>', 'dolor-esse-debitis-quo-vero-quos-quidem', 1, NULL, 'thumbnails/', '[\"nemo\", \"vel\", \"maiores\", \"asperiores\", \"sapiente\"]', 'Cập nhật hình ảnh', '2025-04-01 01:04:57', '2025-04-04 13:28:48'),
('BV-140425-19904867-v67fc6aa2260fb', 34, 16, 'Voluptas ut nobis ipsum itaque delectus.', '<p>Et et sint quisquam odit. Et labore sed est quia. Eveniet assumenda et saepe aliquam natus unde. Consequatur incidunt sequi est ea recusandae.</p><p>Asperiores placeat fugit eum et eum officia. Voluptatum dolorem totam porro quos doloremque recusandae qui. Qui et et enim possimus saepe rerum.</p><p>Quis quisquam at et magni. Est dolorum doloribus praesentium maiores alias veniam non qui. Sint id ut iusto enim earum blanditiis. Qui accusantium atque itaque quia inventore nemo consequatur.</p><p>Id quis ut sit id aperiam ipsam fugiat sequi. Assumenda ullam autem est. Qui sint in voluptas illo est sed. Velit sit earum et rerum.</p><p>Quis magnam deleniti sint distinctio. Recusandae non voluptatem similique quibusdam saepe. Aut necessitatibus maxime distinctio recusandae dolor quia aut. Quaerat saepe sint expedita consequatur.</p><p>Ut magnam labore consectetur sint temporibus molestias dolorem. Consequuntur ea blanditiis est perferendis repudiandae perferendis. Voluptas accusamus dignissimos illum est accusantium facere maxime.</p><p>In fugiat quis mollitia blanditiis eveniet. Architecto est dolor dicta eligendi repudiandae. Dicta nemo at et est. Sed tempore sint dolorem asperiores vitae sit id.</p><p>Voluptate qui nulla omnis praesentium. Debitis et et deserunt deleniti.</p><p>Eos corporis neque tempora cum. Expedita consequuntur quia nesciunt voluptatem nihil expedita explicabo. Dolor sit voluptatem qui excepturi nesciunt. Quia quo accusamus aperiam deleniti fugit error.</p><p>Dolorum fuga odio aut mollitia numquam autem velit. Asperiores perspiciatis quis natus cumque. Doloribus asperiores omnis nesciunt ipsam occaecati.</p><p>Perferendis dolorem nisi cumque doloribus officia nostrum. Voluptatem et minima asperiores dolore quam similique. Reprehenderit veniam ut placeat molestiae libero occaecati. Natus eos pariatur ratione dolorem minus nemo hic ducimus.</p><p>Enim animi provident aperiam iusto incidunt. Culpa assumenda distinctio tempora illo dolorem sunt. Ab vel voluptatibus officiis voluptatum sed.</p><p>Reiciendis sunt recusandae vero consequatur suscipit perspiciatis. Ex odit nisi quos doloremque cumque corporis enim.</p><p>Dolores consequatur ipsa soluta cumque quas ut consequatur. Saepe vel modi quas corrupti ab et minus. Ab voluptatem quas modi ipsum omnis. Magni vel similique illum et.</p>', 'voluptas-ut-nobis-ipsum-itaque-delectus', 2, NULL, 'thumbnails/', '[\"omnis\", \"quia\"]', 'Cập nhật nội dung', '2024-04-25 23:57:29', '2024-07-26 05:36:40'),
('BV-140425-19904867-v67fc6aa238957', 34, 16, 'Delectus aspernatur eius voluptatibus vitae.', '<p>Odit exercitationem vero totam molestias. Eos deserunt at sit sunt. Reprehenderit corrupti nihil dolorem aliquid.</p><p>Enim earum est asperiores aliquid velit est repudiandae. Voluptates sunt blanditiis architecto. Esse nulla eaque iure iure est doloremque. Voluptatum eligendi minima consequuntur tempora sunt sit explicabo.</p><p>Ut quae natus perferendis nemo alias ipsa eaque. Autem id tempore molestiae. Perferendis quisquam repudiandae ipsam nesciunt et asperiores qui.</p><p>Voluptatem mollitia sapiente magnam aut quia. Aut repellendus aperiam veniam assumenda voluptate impedit. Eaque provident ea nisi qui sit sit ullam. Minus sed ut rerum nemo.</p><p>Minus eum corrupti fugiat maiores officiis. Cum odio dolorem consequuntur voluptas quia eos voluptas. Omnis et voluptates ea porro quasi. Et deserunt est quaerat quam.</p><p>Ducimus quia quae dignissimos dolor recusandae aut distinctio. Aspernatur minima eaque aut et expedita omnis voluptatibus repellat. Suscipit veritatis officia quasi ut. Similique soluta dolorem maiores aut magnam adipisci quibusdam.</p><p>Et quidem quo et reprehenderit harum eligendi. Consequatur vero repudiandae soluta eligendi ut. Molestiae veniam velit voluptatem illo labore possimus explicabo atque.</p><p>Minus et voluptatum culpa culpa beatae quis. Voluptatem sed maiores corrupti sed suscipit.</p><p>Porro consequatur est perferendis quis aut. Illo est quia quia et. Dolores rerum vel adipisci sed voluptate ullam. Maxime soluta voluptatum est tenetur suscipit.</p><p>Aut asperiores laborum at error quos voluptas qui. Voluptas aut ut praesentium blanditiis voluptatem. Sequi omnis repellendus incidunt in necessitatibus vel.</p>', 'delectus-aspernatur-eius-voluptatibus-vitae', 2, NULL, 'thumbnails/', '[\"qui\", \"in\"]', 'Sửa lỗi chính tả', '2025-02-22 08:45:30', '2025-02-25 09:51:51'),
('BV-140425-19904867-v67fc6aa23eb5b', 34, 16, 'Enim eum maxime quasi excepturi recusandae iusto numquam amet.', '<p>Perferendis ratione repellendus voluptas ut eos harum distinctio. Animi dolorem sunt nisi laborum necessitatibus totam illo. Alias et beatae facere et est recusandae. Harum vero voluptates explicabo corporis est numquam et. Non id voluptatem dolore dolore dignissimos.</p><p>Magni eveniet quam iure facere nobis laborum voluptatem non. Voluptatem sit vel aliquid odit.</p><p>Sunt et blanditiis veritatis et soluta amet ab. Quis ea mollitia in recusandae tempora. Quia est veritatis quis sunt sapiente vel praesentium. Voluptas nemo consequuntur sapiente.</p><p>Placeat at nisi voluptas accusamus. Velit et eius error unde dolores. Sunt ad fuga aut animi. Quasi quo quaerat aliquam eos.</p><p>Sint voluptates illo maiores. Repellat asperiores eligendi occaecati qui a vitae. Et beatae commodi dolore qui occaecati a officiis.</p><p>Quis rerum et laborum est. Voluptatem molestiae ea quis sequi. Ea aspernatur dolore omnis rerum veritatis. A cum sequi ipsam.</p><p>Omnis accusamus ut aut. Ad sapiente vel eveniet in. Quibusdam incidunt ratione iure reprehenderit ipsam cumque mollitia quos.</p><p>Nisi aut similique quo nihil nesciunt quod nulla. Hic ab praesentium aperiam labore aliquid esse. Est illum ad accusamus ratione sed.</p><p>Et qui earum atque in. Perspiciatis qui quidem eligendi molestiae enim. Deserunt mollitia ut est asperiores et. Unde quo id exercitationem sit praesentium tempore.</p><p>Reiciendis temporibus dolorum deserunt repellat consequatur voluptatem. Perferendis perferendis sint illum nulla ad officiis voluptatem ut.</p><p>Sunt quis quos labore mollitia labore. Voluptatibus et et est odit doloribus reprehenderit rem nulla.</p><p>Omnis fuga sit architecto qui atque sit velit. Quis corrupti perferendis eum eveniet. Aliquid sit doloremque maxime et voluptatem quos aut iusto.</p>', 'enim-eum-maxime-quasi-excepturi-recusandae-iusto-numquam-amet', 2, NULL, 'thumbnails/', '[\"ad\", \"exercitationem\", \"tempore\"]', 'Cập nhật nội dung', '2025-02-21 00:10:39', '2025-04-08 23:20:05'),
('BV-140425-26067610-v67fc6aa22f3cb', 2, 22, 'Facilis neque odio aperiam voluptatem unde.', '<p>Deserunt nihil architecto ipsa magni. Aut est assumenda laboriosam itaque. Autem rerum sed sed sapiente facere est fuga.</p><p>Aliquid iure quia quibusdam architecto cum. Repellat qui blanditiis at tempore vero dolores ut. Sint voluptas eum vel. Nisi quod ex laborum error vero.</p><p>Quod deleniti deserunt laudantium autem. Ea quidem et nesciunt optio. Enim dolorem voluptatem necessitatibus assumenda. Et debitis sequi adipisci omnis dicta voluptas.</p><p>Ad sit deleniti dicta impedit cumque. Est enim aut tempora enim nemo tempore rerum.</p><p>Harum aut consequatur temporibus. Quidem libero ipsa ad voluptatum repellendus. Officia in voluptatem deleniti esse nemo eius ullam.</p><p>Voluptatem excepturi dignissimos modi et ut nisi. Voluptatibus eos dolores qui. Voluptas omnis ut dolor. Consectetur ullam eveniet nihil consequuntur earum iure aspernatur.</p><p>Facere sit omnis amet et. Ut saepe itaque consequatur ut ducimus. Iure sapiente voluptate et qui necessitatibus at. Itaque nobis perspiciatis et rerum dolore iure velit.</p><p>Dolores rerum sunt vel laudantium eum ad. Commodi voluptate illum totam fugit. Laboriosam fuga ipsa qui qui.</p>', 'facilis-neque-odio-aperiam-voluptatem-unde', 9, NULL, 'thumbnails/', '[\"odio\", \"corporis\", \"et\", \"nisi\"]', 'Sửa lỗi chính tả', '2024-09-26 06:17:47', '2024-12-08 05:04:19'),
('BV-140425-26067610-v67fc6aa2330b8', 2, 22, 'Necessitatibus perspiciatis dolore aliquid atque minima pariatur.', '<p>Hic sunt labore sequi ex voluptas veniam. Corrupti eaque odio error accusantium repellat velit aspernatur. Perferendis magnam fugit et aspernatur voluptatem deleniti.</p><p>Recusandae deserunt ad nihil aut rerum sit. Molestiae voluptatem consequatur id inventore nihil accusamus. Molestias ab eos nam nobis. Deserunt voluptatem aut ab est. Totam inventore minus autem pariatur voluptates debitis dolore quis.</p><p>Exercitationem laboriosam vitae et neque et. Enim et aspernatur eum atque quod rerum. Dolor placeat illo aut deserunt esse sed possimus aperiam.</p><p>Quia et sed quis sed et commodi adipisci. Quidem earum enim nobis officia. Sit velit hic impedit est incidunt perferendis reprehenderit. Soluta consequuntur recusandae quidem quisquam illo consequatur.</p><p>Iste rerum praesentium rerum sit earum. Rerum minima quasi aut et quo. Voluptas voluptas tempora autem molestiae omnis velit voluptatem. Rem et est vero officia aliquam quas.</p><p>Nostrum aut voluptatem iure aut rem rerum velit. Et qui officiis ut quo. Fugiat molestiae ex veniam ut ducimus.</p><p>Aut fuga consequatur reprehenderit excepturi suscipit asperiores sed nisi. Laborum doloribus perferendis ullam voluptas maiores nulla. Minima illum dolorem nobis. Et odit soluta soluta expedita distinctio id veniam.</p><p>Eius similique dicta doloribus voluptate recusandae suscipit beatae. Autem totam aperiam qui reiciendis. Aut aut non fuga et ea. Natus occaecati earum nisi aut deserunt eum reprehenderit.</p><p>Sint incidunt dolorem nobis. Nihil impedit accusantium voluptas dignissimos perferendis deleniti et. Assumenda eos praesentium est pariatur hic qui. Sed aut optio est consequuntur. Molestiae veritatis deleniti dolorem earum occaecati beatae quis.</p><p>Aperiam id voluptas in. Voluptatem et non ratione. Ut minus laboriosam nesciunt.</p><p>Quod nobis quaerat voluptas illo unde nihil. Architecto saepe sed adipisci sapiente illo quia. Nihil culpa deleniti sit voluptatem quae non quis. Et consectetur magnam ut qui eum vel fuga beatae.</p>', 'necessitatibus-perspiciatis-dolore-aliquid-atque-minima-pariatur', 9, NULL, 'thumbnails/', '[\"sunt\", \"quasi\", \"aliquid\", \"dolorem\", \"est\"]', 'Cập nhật nội dung', '2025-01-15 16:07:13', '2025-04-12 16:22:31'),
('BV-140425-28515438-v67fc6aa2294ed', 20, 5, 'Illo ut aliquam animi praesentium qui.', '<p>Et molestiae quidem praesentium molestiae. Ad hic repudiandae aut omnis. Odio iste consequuntur nostrum quo optio.</p><p>Quam tempore occaecati omnis itaque odio occaecati. Quos excepturi sunt ut. Placeat voluptas ea rerum ducimus.</p><p>Quibusdam sunt esse perspiciatis qui sunt laborum animi. Atque ipsam optio quia et. Officiis perferendis provident magnam odit quis. Et maxime consequuntur quo voluptatem reprehenderit.</p><p>Quia impedit officiis ut laborum sequi. Asperiores qui quia unde magni nobis. Sed cum nesciunt facere et beatae culpa ad nisi. Et ut vero id consequatur. Aperiam corrupti et quo vero natus voluptate.</p><p>Nostrum itaque modi iure laboriosam. Ad nisi quo at repellendus laboriosam dignissimos eos. Nesciunt libero ad explicabo distinctio nemo quos vero quam.</p><p>Fugiat autem quis aut sunt sunt dolorem sit ea. Eos aut iure enim tempora eum aut praesentium eum. Omnis aperiam ratione ad quis ipsum. Dolorum sint facilis sint ratione. Consectetur laboriosam sed deleniti minima eos omnis quo.</p><p>Dolores asperiores expedita delectus quaerat corrupti nihil. Delectus similique veritatis repellendus suscipit. Ratione vel dolorum ut modi ratione.</p><p>Voluptatum laudantium ipsa quis occaecati. Eveniet exercitationem mollitia necessitatibus accusantium rerum. Perspiciatis laborum velit esse enim delectus. Esse iusto adipisci porro quasi veniam at voluptatem.</p>', 'illo-ut-aliquam-animi-praesentium-qui', 6, NULL, 'thumbnails/', '[\"aliquam\", \"est\", \"accusantium\", \"quis\", \"repellat\"]', 'Thêm thông tin mới', '2024-07-01 03:51:45', '2024-09-09 16:29:59'),
('BV-140425-28515438-v67fc6aa22cef1', 20, 5, 'Velit voluptatem ut voluptatem recusandae sapiente.', '<p>Consectetur deleniti necessitatibus architecto molestias culpa beatae quisquam illo. Consequatur accusamus ut pariatur aut molestias voluptas. Consequatur et quas minus dolor et. A dolorum quia et aut maiores porro iusto.</p><p>Sed rem sint adipisci. Ex maxime quia quia deserunt voluptate voluptatem ducimus ut. Et ex rerum eius itaque.</p><p>Nihil fuga quas vel et. Modi corporis suscipit occaecati aut asperiores quasi. Ut non aperiam quia.</p><p>Rerum et iure excepturi eum architecto quis. Tempore rem pariatur praesentium voluptas aut et. Rerum veniam illo et. Nihil rem qui et id aut laboriosam non deserunt.</p><p>Beatae consequuntur rem iure itaque necessitatibus qui. Consequatur culpa voluptatum et sunt. Iusto ipsa magnam tenetur vel ut. Delectus occaecati quod debitis officia.</p>', 'velit-voluptatem-ut-voluptatem-recusandae-sapiente', 6, NULL, 'thumbnails/', '[\"nesciunt\", \"ut\", \"aspernatur\"]', 'Sửa lỗi chính tả', '2025-03-18 21:11:05', '2025-04-02 00:38:43');
INSERT INTO `article_versions` (`version_id`, `article_id`, `user_id`, `title`, `content`, `slug`, `category_id`, `subcategory_id`, `featured_image`, `tags`, `change_reason`, `created_at`, `updated_at`) VALUES
('BV-140425-28515438-v67fc6aa246ba2', 20, 5, 'Maxime iusto expedita voluptas dicta possimus eligendi.', '<p>Et et est sit est dolores cupiditate maxime. Consequatur nam aspernatur magni sint facere velit. Aliquid voluptatem ducimus vel quasi velit nihil. Pariatur et animi deserunt consequatur et.</p><p>Sed corrupti ratione nihil soluta laborum nobis rerum. Eum velit sint praesentium repudiandae blanditiis nostrum aliquam quo. Sapiente dolorum provident voluptatum eligendi quibusdam temporibus.</p><p>Et tempore rem ex expedita fugit rerum dolor. Optio unde voluptas sint totam dolorum illum consequatur iusto. In repellat voluptates eum nulla et. Nulla rerum beatae rerum sunt.</p><p>Et non reiciendis expedita consequuntur ratione sapiente facere cumque. Ipsam facilis nesciunt temporibus qui cum error. Voluptas hic cum perferendis nemo quaerat aut. Ad rerum ab cum est aspernatur.</p><p>Ut voluptas omnis harum culpa quas eius. Molestiae velit atque tenetur quis autem alias nemo. Ab ut aut quisquam minima maiores.</p><p>Provident non voluptatem rerum tempora laborum rem eum. Et quaerat omnis ipsam blanditiis et numquam. Ut nihil possimus ducimus et aut nihil magnam.</p>', 'maxime-iusto-expedita-voluptas-dicta-possimus-eligendi', 6, NULL, 'thumbnails/', '[\"distinctio\", \"veritatis\", \"saepe\", \"numquam\"]', 'Thêm thông tin mới', '2025-02-16 18:42:00', '2025-03-26 21:04:35'),
('BV-140425-30969980-v67fc6aa2244c5', 31, 22, 'Voluptas dolorem veniam architecto dolor.', '<p>Perferendis officia voluptatum dolores corrupti. Ipsum occaecati laudantium et et. Earum illum sed voluptate ab.</p><p>Eos voluptates aut quae veritatis. Maxime minima enim consequatur culpa. Culpa maxime sequi qui tenetur. Quam quam autem aut quod ea.</p><p>Deleniti explicabo voluptas quia autem earum. Repudiandae nostrum iste corrupti aut quia ut facilis sed. Voluptatum animi architecto officia.</p><p>Dolorem tempora assumenda sed et omnis ut. Voluptatem rerum quisquam quas ut possimus ex. Occaecati mollitia similique eligendi incidunt.</p><p>Id ut dolor unde natus sunt consequatur repellat. Velit dolorem eos repellendus debitis et. Tempore magnam aut itaque reprehenderit. Nulla sapiente mollitia omnis iure suscipit.</p><p>Eveniet est nihil nostrum doloremque illo quia. Iusto in accusamus quasi eum ea. Officiis qui sint et.</p><p>Quia odit nemo nam consequatur. Iure quas modi voluptatem qui autem. Ut et sequi harum magnam sequi nobis accusantium.</p><p>Harum molestiae quos voluptas optio. Velit provident earum aliquam. Et nihil sed dolores placeat. Et autem vero eum inventore aperiam et.</p><p>Sequi nemo nam qui voluptatem et aut quos. Ut et voluptas quis atque illo qui. Temporibus est ipsam tempora et. Quibusdam repellat voluptas qui totam eligendi quae quis. Adipisci officia qui praesentium accusantium ut.</p><p>Nesciunt tenetur suscipit nobis necessitatibus et sunt. Est inventore ipsum rem ea aut quam. Architecto corrupti minus voluptas tempore blanditiis debitis.</p><p>Ea accusantium a corrupti est dolorem quo veniam. Et error ea aut omnis. Ducimus aliquam nihil nisi autem. Iure cum unde necessitatibus voluptas repellendus nihil saepe.</p><p>Dolorem consequatur nobis est veniam dolorem dolorem dicta. Sit aliquid qui enim rerum incidunt veniam. Inventore harum culpa aperiam accusamus libero eum.</p><p>Molestiae perferendis cumque et est. Aperiam sequi doloribus illo inventore quam iusto. Ad est sunt fugit.</p><p>Aliquid laudantium cupiditate id beatae. Repellat est cupiditate debitis et. Quibusdam id enim odio saepe nemo commodi. Aperiam eum dolores qui provident.</p>', 'voluptas-dolorem-veniam-architecto-dolor', 8, NULL, 'thumbnails/', '[\"labore\", \"quia\", \"excepturi\", \"libero\"]', 'Sửa lỗi chính tả', '2024-08-26 04:23:18', '2025-04-08 13:28:10'),
('BV-140425-30969980-v67fc6aa23b5cd', 31, 22, 'Sit dolorem delectus eum magni culpa inventore.', '<p>Reiciendis laboriosam qui temporibus et. Rem enim commodi explicabo minima iusto. Ut deleniti facere ut. Et ut eos repellendus eligendi ex excepturi quam.</p><p>Est doloremque aperiam facilis temporibus officiis voluptas. Nihil recusandae vitae voluptatem. Voluptas ullam impedit rerum et.</p><p>Non ullam rem tempore. Officiis animi nostrum voluptate quae velit autem. Ad sed praesentium optio nihil qui.</p><p>Laboriosam ut qui alias qui quia qui cupiditate nihil. Aut sed quod aperiam. Est mollitia quos fugiat.</p><p>Voluptatem quam quis sed culpa impedit quod. Esse qui earum odit molestias impedit est. Maxime non illum voluptatem rerum.</p>', 'sit-dolorem-delectus-eum-magni-culpa-inventore', 8, NULL, 'thumbnails/', '[\"esse\", \"nesciunt\", \"placeat\", \"dolorem\"]', 'Sửa lỗi chính tả', '2024-05-22 05:52:20', '2024-09-20 06:13:07'),
('BV-140425-34850310-v67fc6aa24b323', 26, 16, 'Molestias sed id tempore vel deleniti.', '<p>Quibusdam commodi quae minima ipsa nesciunt soluta. Quo ea quod voluptas culpa blanditiis beatae voluptate. Ea beatae repellat autem eaque aut.</p><p>Ipsum consequuntur nisi optio quasi sit harum rerum. In ad placeat aspernatur dolore sint. Quis velit vero quas.</p><p>Aut debitis impedit minus in incidunt iusto consectetur. Quaerat officiis et nobis eius ea sit rerum.</p><p>Ab sunt sit aut cumque vel temporibus. Nam ducimus quis ex accusantium odit nostrum ea illo.</p><p>Necessitatibus dolorum praesentium aut exercitationem fugit minus. Atque eum perspiciatis ut reiciendis atque nemo. Architecto qui ratione nihil labore. Voluptatum sit cupiditate et porro.</p><p>Aut beatae optio non. Aut dolor aliquam esse ut repellat. Earum distinctio qui et et.</p><p>Et veniam sapiente rerum voluptates aut aut corporis. Doloribus sit fuga modi reiciendis. A et est quis magnam. Aut nesciunt quam labore corporis.</p><p>Adipisci molestiae laboriosam dicta id. Animi labore possimus iste ducimus laudantium aut cum sequi. Dolor voluptatem dolorum at facere. Voluptatibus qui ex ut deserunt tempore.</p><p>Itaque quibusdam minima labore. Nobis soluta distinctio a rem qui illum. Ipsa rerum quia porro. Earum possimus ut fuga quia omnis.</p>', 'molestias-sed-id-tempore-vel-deleniti', 9, NULL, 'thumbnails/', '[\"nam\", \"ut\", \"id\", \"soluta\"]', 'Cập nhật hình ảnh', '2024-11-02 05:34:14', '2025-03-30 21:18:16'),
('BV-140425-36507128-v67fc6aa22aac7', 22, 5, 'Doloremque autem repudiandae deserunt ipsum sit.', '<p>Aut illum et ullam ex quae odio laudantium at. Cupiditate ea vero fugit officiis. Porro necessitatibus animi accusamus aliquam.</p><p>Iste delectus et qui voluptas. In totam vitae rerum rerum dolorem id. Necessitatibus quo vero laudantium provident assumenda vel. Quasi at illum perferendis architecto quae.</p><p>Occaecati quis velit et vel qui architecto. Sed hic doloribus quo unde aut doloremque quam delectus. Architecto reiciendis quo expedita omnis delectus odit inventore.</p><p>Facere quis nobis et deserunt reiciendis nisi possimus in. Sit iste cupiditate aut magni dolorem. Amet porro quisquam aperiam aut dolores qui autem. Ad dolorem labore ipsa minima et eum perspiciatis.</p><p>Magni soluta quis impedit. Eveniet ad ea occaecati voluptas et unde. Veritatis fugit totam possimus.</p><p>Necessitatibus aperiam ex earum aut illum. Voluptas quis eos enim dignissimos. Vitae velit placeat ut.</p><p>Ut qui voluptas eaque facilis labore vel et ab. Alias autem rerum dolorum omnis. Ullam ut repellat totam aut tempore. Nihil rerum qui eligendi eos ipsa dolor quam. Sit ut amet dignissimos hic explicabo exercitationem.</p><p>Sed qui incidunt doloremque aut. Suscipit quas culpa numquam aut. Sed unde ut eius assumenda totam eum. Et voluptatibus mollitia asperiores temporibus.</p><p>Eius est vero totam repellendus blanditiis adipisci. Dolorem voluptas iste corrupti atque ea.</p><p>Aut porro quia nostrum a aliquid. Est nemo porro molestiae sapiente modi et. Rem porro inventore dolore consequatur voluptatibus.</p>', 'doloremque-autem-repudiandae-deserunt-ipsum-sit', 1, NULL, 'thumbnails/', '[\"commodi\", \"iusto\", \"sapiente\", \"cum\"]', 'Cập nhật hình ảnh', '2024-10-23 04:40:12', '2024-12-16 00:18:27'),
('BV-140425-36507128-v67fc6aa244cb8', 22, 5, 'Quo et maxime repellat ut est ea.', '<p>Voluptate unde eius molestiae error. Consectetur quos enim modi. Accusantium consectetur iure dolorum in consequuntur ut.</p><p>Sint eius nesciunt maiores illo et ut. Porro sint ut quisquam qui quia. Nobis magnam sunt possimus quas voluptas quos quia.</p><p>Laborum repellat aut et. Iure in inventore et voluptas ea. Voluptatem non tenetur velit quam quia perspiciatis in. Est exercitationem vero voluptas voluptas illum nesciunt magnam.</p><p>Non repellendus mollitia cupiditate. Itaque sunt in quo totam consequatur. Mollitia ad velit fuga ipsum laboriosam fugit. Qui rerum cumque non illo sunt.</p><p>Labore esse numquam quia quaerat sunt et et. Dolor sint vitae et vero voluptatibus dolorum quas. Commodi ut corporis vero occaecati amet.</p><p>Optio rerum deserunt mollitia sint est. Unde culpa minima libero culpa aut aspernatur. Laboriosam aut dolorem asperiores voluptas explicabo sint et.</p><p>Odit vero et voluptas atque suscipit et alias laborum. Quibusdam ut nemo dolorem expedita est. Ut id dolorem soluta.</p>', 'quo-et-maxime-repellat-ut-est-ea', 1, NULL, 'thumbnails/', '[\"neque\", \"debitis\"]', 'Tạo bài viết mới', '2025-03-28 04:53:29', '2025-03-30 03:48:55'),
('BV-140425-38186168-v67fc6aa236c79', 30, 4, 'Pariatur numquam officiis voluptatem veritatis quia iste.', '<p>Fuga rerum veniam amet nobis. Quis labore et aut non. Quia et nostrum tenetur ipsum autem. Non vero est vitae accusantium tempore.</p><p>Possimus repellendus dolorem fugit exercitationem beatae. Velit laborum sed est ab expedita natus. Pariatur assumenda fugiat quod consequatur ullam.</p><p>Amet quo nobis omnis similique et. Rerum et architecto asperiores a quam consequatur dolor. Deserunt tenetur nostrum ducimus odit modi.</p><p>Perspiciatis rerum quibusdam at ea qui occaecati velit sed. Itaque illo omnis pariatur et architecto enim in. Cum molestiae aut magni ut corrupti molestiae qui.</p><p>Autem et libero veniam. Consequatur dolor aut vero temporibus eveniet. Et maxime facere delectus soluta quaerat nostrum.</p>', 'pariatur-numquam-officiis-voluptatem-veritatis-quia-iste', 9, NULL, 'thumbnails/', '[\"et\", \"corrupti\", \"praesentium\", \"sequi\"]', 'Cập nhật hình ảnh', '2024-05-06 14:55:44', '2025-01-16 12:55:00'),
('BV-140425-38983815-v67fc6aa247285', 27, 4, 'Repudiandae cupiditate consectetur autem repellat nostrum.', '<p>Voluptatum ullam sed voluptate sed est. Sed ut ducimus deleniti aut magnam et id. Expedita excepturi ipsum aut earum animi laudantium voluptatem natus. Quia quod et perspiciatis atque.</p><p>Rem voluptate odit beatae soluta explicabo consequatur natus. Corrupti accusantium et deserunt. Excepturi quia est esse asperiores quo odit sunt.</p><p>Eligendi qui quos enim laudantium. Sunt molestiae repellendus aspernatur tempore nobis eos. Et incidunt cum eos nam porro et.</p><p>Quia eaque et omnis repellendus sed perferendis. Hic enim minus laboriosam dolores.</p><p>Ab aspernatur voluptas et reiciendis architecto culpa. A voluptatem molestias sint earum dolor nemo. Earum velit qui ea deserunt et sint ratione similique. Vitae architecto facere rem consequatur itaque odit.</p><p>Facere consequuntur atque et non odit laboriosam quibusdam. Ut fugit iure ipsa quae. Consequuntur itaque vel non sit et voluptatem quod recusandae.</p><p>Adipisci id recusandae incidunt omnis mollitia. Dolorum officia aut et dignissimos ad ad laborum quis. Perferendis blanditiis quia inventore et voluptas. Dolores quae fuga quod voluptas quam dolor.</p><p>Ut iste id aperiam in alias. Qui voluptatibus necessitatibus suscipit ratione iste eos. A velit et amet. Accusamus qui blanditiis adipisci et.</p><p>Dolore dolorem nam est quo aspernatur ut. Voluptas numquam laudantium excepturi dignissimos. Repellat ut voluptatem molestiae sed est sapiente. Dolores rerum nam explicabo est explicabo voluptatem.</p><p>Labore quia impedit fuga veritatis. Dolorem ex a magni animi est et minima.</p><p>Magni sint magni voluptatem velit accusantium eaque. Et aut voluptatem voluptas expedita deleniti nam. Facilis unde iste ut doloremque maxime. Cumque quisquam alias sit veritatis aut.</p><p>Voluptatem veniam vero totam dignissimos dignissimos accusantium ad. Reprehenderit qui ut qui aliquam sint. Perspiciatis est reiciendis quaerat et ex. Possimus aut vitae maiores necessitatibus voluptate.</p><p>Repellendus sed voluptas ratione. Molestias dolor et vero inventore ut. Inventore error facilis velit voluptate quisquam alias.</p><p>Architecto fuga fuga explicabo consequatur optio voluptatibus. Rem eaque maxime in ut a asperiores. Temporibus velit beatae vel quo et dicta. Qui velit quod molestiae maiores cumque. Architecto molestiae id magnam.</p>', 'repudiandae-cupiditate-consectetur-autem-repellat-nostrum', 1, NULL, 'thumbnails/', '[\"adipisci\", \"et\", \"magni\"]', 'Cập nhật hình ảnh', '2024-06-09 07:30:14', '2024-11-25 18:39:39'),
('BV-140425-39847477-v67fc6aa23a783', 6, 23, 'Debitis non debitis numquam officiis.', '<p>Libero quam inventore ab et. In id omnis corporis eum tenetur excepturi. Itaque fuga aut quam itaque ipsa architecto. Accusantium quisquam mollitia aliquid quia.</p><p>Amet ratione assumenda voluptas in fuga voluptatem modi. Nihil quia omnis vitae qui est. Quidem similique voluptatem vel officia pariatur. Sit cupiditate rerum id et minus soluta aliquid.</p><p>Asperiores accusantium deserunt necessitatibus inventore natus quos consequuntur. Cum rem provident eos. Consequatur omnis reprehenderit illo molestias non neque. Voluptatem enim sed quasi incidunt. Accusamus accusamus itaque quis labore.</p><p>Rerum inventore impedit corporis velit ut. Animi nulla ratione amet adipisci delectus veniam maxime. Dolorem expedita voluptas non sit voluptates.</p><p>Quia nihil tempora commodi beatae accusamus quo. Earum accusantium incidunt inventore nisi dolores. Vitae laboriosam voluptatem temporibus vel dolores aut facere aut.</p><p>Tenetur accusamus quisquam quos quibusdam. Excepturi corporis quaerat odit voluptate maiores vero perspiciatis. Illo perferendis architecto iste illo ad officia. Qui aliquid commodi odit. Consequatur cum consequatur voluptatem.</p><p>Molestiae aut ad et. Doloribus natus est veritatis laboriosam. Eligendi perferendis voluptatem doloremque numquam corporis.</p><p>Est corrupti sed laborum rem. Magni totam voluptatem ut nisi saepe quia consequuntur. Et quasi repellendus ratione doloremque.</p><p>Est sunt deleniti laboriosam veritatis ut. Laudantium voluptas tempora et magnam eaque. Itaque molestiae id omnis qui dicta debitis repellat. Dolore non repudiandae sit voluptates.</p>', 'debitis-non-debitis-numquam-officiis', 6, NULL, 'thumbnails/', '[\"a\", \"quo\", \"recusandae\"]', 'Cập nhật hình ảnh', '2024-12-28 14:00:40', '2025-02-24 18:40:54'),
('BV-140425-39847477-v67fc6aa23f2af', 6, 23, 'Doloremque dolorum corporis voluptatem repellat unde officiis ea.', '<p>Laborum aspernatur qui eum beatae suscipit. Et sequi et nulla porro. Neque numquam culpa voluptatem porro quo non.</p><p>Id eos vel quo. Et ab nisi praesentium beatae ad voluptatem. Ratione magnam non voluptatem nesciunt.</p><p>Nostrum consequuntur sed et voluptas voluptatem commodi. Placeat praesentium voluptatem perspiciatis. Totam fuga et reprehenderit.</p><p>Vel fugiat rem veniam consequatur tenetur libero in. Alias officia eos officiis. Error doloribus voluptatem sit dignissimos aliquid in.</p><p>Quis quisquam quod fuga minima. Similique non est eos adipisci sed et. Iste est officia voluptas culpa in.</p><p>Voluptates blanditiis voluptatem aliquam fugit dolore necessitatibus. Saepe qui tempora beatae ad sed ut ut. Cupiditate culpa soluta dolorum velit dignissimos animi unde.</p><p>Unde non maxime dolorem esse eius delectus quidem. Iusto cum velit labore placeat. Maiores cum laudantium deserunt explicabo nisi. Aperiam nam nihil optio.</p><p>Vero sapiente at pariatur dolor est. Velit non sapiente ea at aut amet. Perspiciatis natus ratione non perspiciatis.</p><p>Ut natus est recusandae praesentium deleniti qui ut excepturi. Sunt unde quas saepe eligendi delectus. Quos adipisci voluptatem magni molestiae.</p>', 'doloremque-dolorum-corporis-voluptatem-repellat-unde-officiis-ea', 6, NULL, 'thumbnails/', '[\"necessitatibus\", \"repudiandae\", \"non\", \"facere\"]', 'Tạo bài viết mới', '2024-06-07 17:15:47', '2024-09-14 11:05:39'),
('BV-140425-39847477-v67fc6aa251d38', 6, 23, 'Consequuntur ad aut distinctio ipsam assumenda porro repellendus.', '<p>Consequatur unde et dolor ratione odio. Fugit aspernatur aut dolor sed est id voluptatem praesentium.</p><p>Officia omnis expedita omnis modi unde magnam. Non doloribus dolor facere. Provident rerum et qui sequi est.</p><p>Eaque nobis error atque aspernatur facilis. Et id dolores odit autem fugiat blanditiis. Porro est recusandae perferendis fugiat esse ea. Reiciendis qui laborum excepturi itaque.</p><p>Corrupti autem sequi ratione praesentium. Labore ut fugit sunt ullam. Voluptatem exercitationem magnam consequatur voluptas est cumque neque. Sit iste corporis dolor at voluptas.</p><p>Est consectetur repellendus qui adipisci. Cumque enim magni magni optio sunt. Est quam deleniti incidunt consequatur praesentium.</p><p>Dolor cumque consequatur non. Dolore ducimus sint voluptas ut et voluptatibus.</p>', 'consequuntur-ad-aut-distinctio-ipsam-assumenda-porro-repellendus', 6, NULL, 'thumbnails/', '[\"odio\", \"quos\", \"totam\", \"similique\"]', 'Thêm thông tin mới', '2024-12-15 15:28:43', '2025-04-08 16:56:49'),
('BV-140425-41312669-v67fc6aa24398a', 5, 7, 'Voluptatibus dicta quis cumque tempore quia.', '<p>Voluptatem et omnis non ipsa veritatis tenetur. Illum cumque rerum qui quibusdam totam. Est in blanditiis facilis aliquam dolor beatae.</p><p>Aut architecto culpa aliquam temporibus. Tenetur corrupti voluptas sunt quasi ullam et optio. Quis et consequuntur molestiae deserunt.</p><p>Voluptas consequuntur modi consequatur nostrum quasi. Voluptas veniam temporibus dicta velit magni nihil magni. Ipsa doloremque eligendi vel debitis sed optio.</p><p>Pariatur autem nemo qui eum voluptatem et. Ea quia aut sunt et reiciendis. Quos atque architecto voluptatem. Consequatur labore in molestiae magnam optio corrupti voluptate.</p><p>Maxime minus possimus reiciendis qui. Et repellendus quod totam natus. Reiciendis ipsum commodi expedita ad vel.</p><p>Corrupti aut sunt maxime ducimus sint. Quod sint aut corporis qui. Est voluptas inventore et qui asperiores.</p>', 'voluptatibus-dicta-quis-cumque-tempore-quia', 1, NULL, 'thumbnails/', '[\"dicta\", \"ex\", \"illum\", \"eos\"]', 'Cập nhật hình ảnh', '2025-01-07 08:15:44', '2025-02-23 02:05:58'),
('BV-140425-41312669-v67fc6aa24e7e4', 5, 7, 'Occaecati reprehenderit eveniet asperiores voluptatem expedita.', '<p>Autem repellendus sequi maiores atque. Eveniet facere incidunt quia. Facilis consectetur tempore aperiam vero fugit.</p><p>Laboriosam eos vel cupiditate dolorem non atque dolor. Impedit pariatur non voluptatem unde dolor alias minus. Quo dolores exercitationem et itaque rem ipsam. Molestias dicta sed quo nostrum.</p><p>Aspernatur aperiam sed odit omnis doloremque asperiores. Dicta exercitationem similique dolorem sed eos. Deserunt reiciendis quis et.</p><p>Dolorum alias sunt eligendi omnis unde. Praesentium voluptatem sint dolor nostrum. Illum repellat occaecati quia sapiente et voluptatem a.</p><p>Eius pariatur fuga ut itaque ducimus. Asperiores earum magnam ab repellat blanditiis dicta. Inventore voluptatem libero voluptatibus perspiciatis saepe qui sed. Ab sit sit harum sunt blanditiis quaerat ut cumque.</p><p>Deleniti soluta harum doloribus nam rem incidunt ratione. Quia atque voluptas quos tenetur rerum qui. Modi qui sequi et maxime quia ea. Minus et debitis sed quia voluptatem.</p><p>Ipsum voluptas ut sed expedita. Voluptatibus et vitae est vero numquam exercitationem. Et repellendus est odio iure consequatur quidem fugit. Occaecati at vel id similique autem quia.</p><p>Nemo sint et voluptatem provident aliquid. Odio alias sed minus et. Assumenda et nostrum esse dignissimos aut. Mollitia nihil quae nam vitae sint quia.</p><p>Sed consectetur dolor itaque tenetur sunt. Iure dolorum aut qui nesciunt. Nisi delectus dolores repudiandae repudiandae magnam placeat. Et quo sit occaecati sint dolores.</p><p>Libero est debitis quia saepe laboriosam. Dignissimos molestias mollitia distinctio tempora. Tenetur est provident sed veritatis quis nemo ad. Hic eligendi libero dicta consequuntur minus velit.</p>', 'occaecati-reprehenderit-eveniet-asperiores-voluptatem-expedita', 1, NULL, 'thumbnails/', '[\"dolorem\", \"nostrum\", \"deserunt\", \"consequatur\", \"asperiores\"]', 'Thêm thông tin mới', '2024-10-01 10:52:18', '2025-02-02 01:18:20'),
('BV-140425-47120859-v67fc6aa2224bf', 21, 16, 'Quasi enim ex dolores qui.', '<p>Iure et inventore odio aut molestiae aut. Eos vero voluptas explicabo odit aut temporibus sed. Et ea maxime magni ad. Et consequatur error et iste eligendi ipsa.</p><p>Quos qui perferendis nam. Asperiores non et rerum adipisci soluta rerum. Inventore quis pariatur sit rerum aliquam ut non. Repudiandae rerum inventore rem maiores assumenda.</p><p>Impedit placeat molestiae laboriosam eum quaerat expedita ut. Voluptatum facere ut et dolores. Aut et perferendis exercitationem quaerat.</p><p>Commodi quibusdam eos possimus commodi. Rem illo corrupti quod eaque. Dolorem velit est molestiae repudiandae atque labore totam.</p><p>Tenetur accusantium doloremque autem odio. Ut provident molestias beatae et et est eligendi vel.</p><p>Ut sed est autem consectetur nulla. Sunt esse eveniet esse error delectus ut alias. Laudantium magni explicabo quaerat qui.</p><p>Voluptas dignissimos vel veniam vitae veritatis. Similique asperiores laborum ipsa. Earum architecto deleniti omnis excepturi vitae. Quia sint quis corrupti quam amet omnis.</p><p>Libero earum officia dolorem aliquid rerum velit voluptatem. Omnis incidunt laborum et. Commodi velit qui in.</p><p>Voluptatum eaque nihil aut labore sint. Laudantium repellat eius nam exercitationem rem reprehenderit architecto. Corrupti quaerat quo et perferendis quibusdam.</p><p>Quibusdam nostrum eveniet nostrum quo. Perferendis nemo nihil repellat aut necessitatibus. Asperiores atque aspernatur ea sint ea reprehenderit voluptatem deleniti.</p><p>Nihil pariatur voluptatibus neque minima. Dolorem quia non et assumenda delectus aut. Commodi molestiae tenetur cum quisquam. Praesentium minima dolorem nisi voluptas cupiditate.</p><p>Officiis incidunt ea est dolorem voluptatem. Enim in sint qui ut. Consequatur esse in vel dolorem consequatur repellendus laudantium. Neque est reprehenderit labore qui sint repudiandae.</p><p>Similique enim sequi libero aut necessitatibus dolorem et repellendus. Ut iusto perspiciatis amet repellat aut. Iure dolores porro quae delectus enim officiis. Illo dolor rerum et architecto enim.</p>', 'quasi-enim-ex-dolores-qui', 2, NULL, 'thumbnails/', '[\"sapiente\", \"doloribus\"]', 'Thêm thông tin mới', '2024-10-15 08:29:27', '2025-03-04 09:45:49'),
('BV-140425-47120859-v67fc6aa226efa', 21, 16, 'Alias consequatur autem ut voluptatem voluptate omnis laboriosam.', '<p>Quam esse esse aut voluptatem provident vel temporibus labore. Sed molestias cupiditate dolores maiores ducimus enim doloremque. Inventore quos mollitia aut dolorum non.</p><p>Eos voluptas quaerat id dolores non aspernatur. Sed laborum molestiae ut ea earum. Quas nihil est amet nesciunt quia itaque perspiciatis.</p><p>Voluptas accusamus ipsa itaque excepturi quibusdam placeat. Sed non itaque cumque nostrum eligendi. Asperiores praesentium et velit corrupti aut ut.</p><p>Quia corporis ex voluptatem temporibus quas optio. Eum ipsa ut qui sit blanditiis et. Vel consequuntur similique et qui ipsam quis rem facilis. Deleniti rerum vel et tenetur corrupti dolorum.</p><p>Deleniti dicta vel et rem tempora. Ut ex laudantium qui excepturi dolorem. Accusamus facere est voluptas non alias ipsa.</p><p>Eligendi voluptatem aliquam qui vel animi rerum repellat. Nesciunt explicabo ab aut voluptate quia omnis. Quo qui nostrum aut earum aliquam quis. Doloremque in aut reprehenderit sunt.</p><p>Sit praesentium molestiae esse inventore incidunt. A maxime culpa culpa quod hic atque. Assumenda est tenetur recusandae nulla adipisci. Suscipit dolores expedita saepe dolor.</p><p>Praesentium necessitatibus quisquam ipsam sed dolore voluptatem. Voluptas et nulla omnis voluptatem inventore accusamus nemo repellendus. Molestiae quia provident aperiam dolorum ducimus.</p>', 'alias-consequatur-autem-ut-voluptatem-voluptate-omnis-laboriosam', 2, NULL, 'thumbnails/', '[\"tempora\", \"inventore\", \"sunt\"]', 'Thêm thông tin mới', '2025-03-16 16:20:52', '2025-04-07 08:29:23'),
('BV-140425-47120859-v67fc6aa2275ab', 21, 16, 'Enim sit corrupti corporis voluptatem.', '<p>Sit labore nihil eligendi id laboriosam corporis. Consectetur est odit et et et. Pariatur et est distinctio et qui perspiciatis et. Inventore suscipit nostrum voluptatem cumque cum.</p><p>Eligendi cupiditate eligendi eius ex nobis sequi. Laboriosam nihil consequatur non. Dignissimos et doloribus repellat harum vel officia porro. Voluptas quia quo quod voluptatem assumenda saepe ut. Nemo est omnis magni.</p><p>Veritatis et ratione ut quidem tenetur. Recusandae sunt voluptatem aut. Quia saepe magnam alias sed. Aspernatur ad inventore qui aspernatur. Aut temporibus autem itaque dolores eaque vel aut ut.</p><p>Omnis ipsa esse magnam rerum minima. Illo fugiat numquam est dolores. Consequuntur fugiat quae voluptatem. Et itaque adipisci hic nobis et. Accusantium mollitia dolore aperiam quia ducimus hic.</p><p>Voluptas natus impedit laboriosam sequi quae omnis. Cum quo id iusto cupiditate molestias ipsa qui. Voluptas et id ipsa voluptatem ut. Quos ut accusamus debitis.</p><p>Enim architecto iusto aliquam minima. Saepe magnam sapiente numquam numquam quibusdam quidem sit. Quam perferendis sit animi sint. Magnam illo quo repellendus pariatur minus. Ratione a iusto voluptatibus optio corrupti error sit corrupti.</p><p>Quia quis quia velit. Iusto a quas voluptas voluptas ut. Eum unde voluptatem id in.</p><p>Consequatur voluptatum nobis aliquam perspiciatis laboriosam earum. Corrupti perferendis aut qui omnis. Quo omnis vero aliquam laborum quia magni eveniet. Aliquid omnis aperiam vitae accusantium saepe deleniti aut quidem.</p><p>Aut aut vero nihil similique voluptatem dicta. Cum quia beatae alias voluptates. Repellat repudiandae occaecati eos ad autem. Non ad provident sint et et ad. Sint eius repellat aut et aut.</p><p>Incidunt quae explicabo modi earum aut sint alias voluptas. Quisquam exercitationem id cumque blanditiis voluptate quae nostrum atque. Quia est sit nostrum modi distinctio nesciunt.</p><p>Quibusdam commodi iusto corrupti incidunt aliquam quaerat id. Nulla est sequi dicta culpa est quo enim. Dignissimos odit sed earum autem rerum cumque. Ea et velit sequi rem debitis.</p><p>Voluptatem sed vel expedita voluptatem nam id voluptas. Quis voluptas aut quos porro. Laudantium maiores earum dolore fuga placeat accusamus voluptates cumque.</p><p>Voluptas architecto culpa alias ut aperiam ducimus rerum. Consequatur quasi fugiat accusamus tempore ea iusto sunt. Officia reiciendis voluptas voluptas aut. Voluptas et maiores rerum culpa.</p><p>Commodi optio ex voluptas culpa. Ut aliquid et et eum alias qui. Ipsam aut recusandae alias ut.</p>', 'enim-sit-corrupti-corporis-voluptatem', 2, NULL, 'thumbnails/', '[\"officiis\", \"quia\", \"non\"]', 'Sửa lỗi chính tả', '2025-04-11 09:30:24', '2025-04-12 12:03:00'),
('BV-140425-47120859-v67fc6aa249bd0', 21, 16, 'Aperiam et debitis corporis aspernatur dolorem recusandae delectus.', '<p>Officiis facere totam iste et. Ut ea rerum laborum distinctio eveniet. Consectetur doloribus qui possimus et.</p><p>Sunt voluptas suscipit ea quia nulla vero. Esse dolores qui accusamus suscipit eos. Consequatur autem modi voluptas similique excepturi est.</p><p>Soluta a vel ut. Aut repellendus labore aut omnis officiis aspernatur. Ut nulla quaerat dolor et quisquam harum. Explicabo est odio ut dolor impedit ut aspernatur veritatis. Qui sed quia ipsa qui.</p><p>Sed qui itaque voluptas commodi et delectus et. Aut et impedit ut sit qui aut maiores. Et deserunt rerum sequi maiores. Rem veniam veniam commodi omnis consectetur.</p><p>Consequuntur omnis voluptate voluptatum quaerat dolores voluptatem quisquam. Fugit incidunt quam nam qui debitis. Excepturi perferendis aut doloribus nisi dolores nesciunt. Perspiciatis doloribus et cupiditate ut eum totam eius.</p>', 'aperiam-et-debitis-corporis-aspernatur-dolorem-recusandae-delectus', 2, NULL, 'thumbnails/', '[\"sit\", \"impedit\", \"molestiae\"]', 'Tạo bài viết mới', '2024-06-13 01:03:15', '2025-01-08 18:30:59'),
('BV-140425-51710557-v67fc6aa2301f5', 37, 22, 'Quos aut eius voluptatibus eligendi.', '<p>Sed in illum suscipit repudiandae qui exercitationem. Eos at nostrum fugiat repellendus accusantium. Ex odio ut placeat ut nam. Explicabo earum quam deleniti assumenda rerum sit consequatur.</p><p>Sapiente non aut fugiat sed. Libero nisi vel rerum. Sed aut aut necessitatibus reprehenderit quo nihil. Recusandae inventore architecto nesciunt modi deserunt.</p><p>Dignissimos dolor accusamus nisi occaecati nostrum occaecati. Sed quis ut odio veniam natus ipsum corrupti. Aliquam consequatur aliquam molestiae.</p><p>Reiciendis laudantium earum sapiente autem. Repellendus eaque dolor ipsa eos quasi optio voluptate.</p><p>Ea et non aut ut. Aut accusantium harum laborum. Deserunt et ut aut.</p><p>Qui rerum aspernatur consequatur sunt nam. Nemo neque enim ipsum dolorum blanditiis. Et ex sunt qui.</p><p>Ipsam temporibus reiciendis porro et aut quia iure. Adipisci quasi fuga nobis temporibus vero quo asperiores. Aliquam rerum nisi quae autem ea nesciunt quidem.</p><p>Ad et blanditiis iure et voluptatem qui. Aperiam iusto ut blanditiis maiores. Ut non totam eius iusto error consequatur optio.</p><p>Qui nam totam vel aliquid commodi. Reprehenderit aut autem dolor illo dolorem et sit et. Dolorum a modi molestiae numquam minima accusantium.</p><p>Expedita delectus optio eveniet consectetur ut culpa. Id sit minima eum rem numquam omnis eum. Ullam necessitatibus voluptate vel itaque.</p>', 'quos-aut-eius-voluptatibus-eligendi', 2, NULL, 'thumbnails/', '[\"reprehenderit\", \"et\"]', 'Tạo bài viết mới', '2024-06-02 14:59:20', '2025-03-06 10:59:34'),
('BV-140425-51710557-v67fc6aa23f96a', 37, 22, 'Veritatis ipsam ducimus iusto et velit.', '<p>Voluptatum quia consequatur quasi sed reprehenderit. Excepturi laborum rerum est iure inventore ut dolores cupiditate. Ut quas nihil minus tenetur. Deleniti ut magni dolorem aut rem.</p><p>Consequuntur veritatis iste dolores quae aut. Molestiae illo accusamus dolorum eum. Cumque harum et non aut sed. Dolores sit sapiente molestiae illo quasi et id.</p><p>Quasi dolorem non exercitationem assumenda voluptates. Molestias atque aut excepturi. Consequatur consequatur ad laboriosam neque consequuntur. Sed architecto ipsa voluptatem et ut.</p><p>Aut explicabo odio aut deleniti et cum. Distinctio nihil quia ut molestias qui eligendi. Ab excepturi et ipsa et non aut blanditiis. Et nesciunt nobis eos similique est nihil ab quaerat.</p><p>Velit maiores fuga vel ipsa aliquam. Minus ex non ut repudiandae reprehenderit illum. Reprehenderit tempora doloremque velit labore dolorem consequuntur enim odio.</p>', 'veritatis-ipsam-ducimus-iusto-et-velit', 2, NULL, 'thumbnails/', '[\"cupiditate\", \"illo\", \"ut\"]', 'Cập nhật nội dung', '2024-12-08 14:40:58', '2025-03-01 06:40:58'),
('BV-140425-51710557-v67fc6aa24843c', 37, 22, 'Voluptatibus fugiat distinctio dolore quo repellendus.', '<p>Mollitia doloribus quasi possimus consequatur perspiciatis. Sunt officiis natus nihil praesentium inventore.</p><p>Qui eum dolores sed eos. Officiis asperiores accusantium qui facilis quasi labore. In quisquam soluta quos quia qui culpa ut.</p><p>Et voluptatem optio aut sunt. Atque non sequi totam nemo corrupti velit. Enim tenetur et dolorem tempore aliquam.</p><p>Architecto qui maxime animi minus quae numquam. Labore voluptas assumenda illum et doloremque. Facere et voluptates sit non qui.</p><p>Quos voluptatibus voluptatem aspernatur cupiditate et eligendi aut. Dolor nihil et provident quo cupiditate est ad dolores. Et quia repudiandae cumque maiores vel doloribus provident.</p><p>Tenetur sed in aliquid natus. Aspernatur assumenda illo amet sapiente eveniet et. Repudiandae deleniti quis sed qui eos.</p><p>Sed eius optio sit iure recusandae quae sunt maxime. Harum nostrum ad id nihil iusto velit. Placeat aperiam ea aut alias ipsa neque ab. Tempora nam voluptate possimus non a nam.</p><p>Amet ad suscipit dolores sint rerum maxime rem ut. Et alias consequatur cumque omnis nihil. Id impedit debitis dolores.</p><p>Dolores ipsam est et corrupti. Et corrupti aut recusandae voluptatem voluptas consequatur. Voluptatem et est ea quo ullam voluptatem voluptate.</p>', 'voluptatibus-fugiat-distinctio-dolore-quo-repellendus', 2, NULL, 'thumbnails/', '[\"sed\", \"laboriosam\"]', 'Thêm thông tin mới', '2024-09-29 19:36:25', '2024-10-24 05:16:27'),
('BV-140425-53516906-v67fc6aa2308ad', 16, 13, 'Officiis eius quasi autem itaque similique voluptatibus.', '<p>Recusandae unde quia ipsam delectus minus eveniet labore voluptate. Et est sed vel et.</p><p>Dolor ut et voluptas fugiat. Aspernatur explicabo illo repudiandae eos eos quas. Nostrum sit et incidunt et labore dolores nisi dolores.</p><p>Et fuga ut fugiat cum est ullam. Incidunt quo aut exercitationem vel.</p><p>Sit et aut dignissimos modi debitis. Earum fugiat nihil veritatis quia voluptatem molestiae dolores. Modi perferendis pariatur veritatis rem dignissimos autem.</p><p>Alias modi iste autem. Quaerat tempore debitis delectus ut labore. Asperiores doloremque maiores facere eius.</p><p>Nostrum voluptatibus voluptatibus fuga et repellat ipsum nisi. Repellat corporis dolores perspiciatis minus adipisci odio maiores. Officia et est sit porro aut velit.</p><p>Modi expedita labore ullam ad consequatur qui. Molestias quia quae sapiente aperiam cum labore. Et eos debitis vitae cumque delectus quia veniam. Cumque sequi repudiandae eos quia dicta unde facere.</p><p>Dignissimos iure ut cumque nihil veritatis dolorum. Quasi quis magnam saepe accusantium in. Quia rerum recusandae voluptates distinctio. Ipsa sit autem nam nihil distinctio. Quas necessitatibus sint quia deserunt molestias.</p><p>Nobis perspiciatis nemo consectetur quibusdam odio accusantium. A officia assumenda autem natus repudiandae enim est. Omnis quasi ex minus et ab aspernatur voluptas provident. Vitae deleniti libero harum aut sint illo. Cupiditate qui accusamus et omnis a mollitia.</p><p>Iste voluptas est aperiam voluptas. Amet nihil delectus odio nihil soluta. Magni et architecto explicabo ad. Quo maiores perspiciatis nobis alias provident repellendus eveniet minus.</p><p>Deleniti quod vel nostrum consequatur quaerat recusandae illo incidunt. Aspernatur ratione facere laborum velit magni aut nostrum. Recusandae modi non quae et enim delectus pariatur. Et saepe nihil voluptatibus et dolore et.</p><p>Nam sit recusandae asperiores amet enim. Libero eaque qui sed reiciendis qui voluptatem. Et voluptas assumenda quo qui quisquam molestiae accusantium.</p><p>Iure nobis nostrum nemo sed temporibus eum. Perspiciatis aut fugiat excepturi mollitia illum. Eos quis est aut. Iure rerum inventore aliquid rerum incidunt.</p><p>Sapiente et ut facere aut quia. Aut voluptatem consequatur saepe quisquam ducimus voluptas.</p>', 'officiis-eius-quasi-autem-itaque-similique-voluptatibus', 1, NULL, 'thumbnails/', '[\"voluptas\", \"et\", \"consequatur\", \"molestiae\", \"consequuntur\"]', 'Cập nhật hình ảnh', '2024-11-05 22:20:53', '2025-02-18 19:10:20'),
('BV-140425-53516906-v67fc6aa231abf', 16, 13, 'Ut repellendus ullam dolor non amet facilis.', '<p>Incidunt consequatur porro assumenda ad. Incidunt libero ipsum natus officia eum et. Quos et voluptatum libero quo sit at nam. Repellendus praesentium praesentium alias maxime aut est ad ad.</p><p>Quo magnam officiis iure qui praesentium reiciendis natus. Provident et laboriosam sed accusantium voluptatum perferendis. Quo odio id maxime et totam quam illo ipsa. Sit animi eos qui ex libero.</p><p>Repudiandae quo nisi hic dolore dolorem quia perferendis eos. A et dolore architecto et. Laborum molestias provident consequatur.</p><p>Voluptatem optio illo nihil non inventore vitae nulla. Consequatur eaque omnis sed velit nulla soluta aspernatur at. Eum illo est quam et quibusdam consequatur. Sed consequatur nam similique.</p><p>Quaerat recusandae quia quia assumenda quos quia id molestiae. Amet veniam magnam et delectus excepturi quasi. Dolor modi soluta explicabo suscipit. Voluptatem harum maiores maxime et voluptatem dolorum voluptas.</p><p>Ipsa et sapiente eum cum labore maiores consequatur. Quas quas officiis quam dicta sunt itaque minima. Adipisci vel nemo eligendi nesciunt in dolorem.</p><p>Officiis odio iste exercitationem suscipit eveniet. Numquam dignissimos soluta sunt. Est et dolore non at velit.</p><p>Aut eligendi sint et harum distinctio consequatur ex. Eius quo nesciunt qui aut aut possimus illum. Nostrum vel quia inventore aut.</p>', 'ut-repellendus-ullam-dolor-non-amet-facilis', 1, NULL, 'thumbnails/', '[\"eos\", \"labore\", \"error\"]', 'Thêm thông tin mới', '2024-04-14 04:34:32', '2024-07-06 04:40:15'),
('BV-140425-53516906-v67fc6aa239f7d', 16, 13, 'Excepturi quas architecto sequi nostrum ducimus velit velit.', '<p>Magni distinctio vel sunt quisquam velit. Quisquam consequatur eos et vitae sit blanditiis omnis. Aut dolore ut iusto.</p><p>Vel consequatur nesciunt quia omnis. Eaque veniam occaecati et natus aliquid voluptas consequatur vel. Dolorem laudantium aut dicta cum aperiam ratione consectetur quaerat. Voluptas voluptates quos laboriosam rerum dicta ducimus esse.</p><p>Reiciendis quo ut neque dolor. Recusandae quidem in eos eius animi est in ullam. Et beatae et fugiat et nisi sit modi iste. Culpa rerum error excepturi ipsa.</p><p>Ipsa rerum officia rem minus. Eos magni nobis placeat quibusdam molestias. Itaque quas quasi consequuntur vero praesentium sit voluptatem vero. Ipsam et earum molestiae natus voluptatibus laboriosam. Nemo est iure et est aliquam eius molestiae.</p><p>Nostrum nobis quaerat animi. Ducimus temporibus pariatur voluptatem facilis aut amet quas voluptatem. Vel quia qui deleniti culpa doloremque qui. Quis laudantium quia odit magnam quia.</p><p>Dicta maiores quod quidem rerum dicta. Voluptatum in enim sapiente atque repellat accusantium vitae. Tenetur est sint rerum qui dolor. Rerum quas deleniti inventore ut hic. Culpa voluptatum ea quos corporis qui rerum rerum rerum.</p><p>Nulla in impedit voluptates et. Exercitationem eos iusto placeat. Consequatur magnam aliquid dolores deleniti tenetur. Quia nam temporibus qui.</p><p>Incidunt ipsa facere sapiente est explicabo autem. Explicabo odio voluptates fuga iure et natus. Ea eos et ipsum deleniti officiis molestiae. Temporibus tempora fuga nihil in ducimus itaque numquam.</p><p>Sed cumque velit voluptates aut perferendis aut. Velit quia illo cupiditate sapiente earum ipsam.</p><p>Deserunt nisi et nostrum amet praesentium. Dolorem velit corrupti possimus cumque itaque culpa. Eos minima accusamus dolor omnis consectetur hic.</p><p>Impedit earum nihil ratione ducimus qui saepe omnis. Est asperiores eaque voluptatem voluptate velit sint temporibus aliquid. Nihil animi aut magni qui quae sed aspernatur.</p><p>Reprehenderit atque sunt et. Laborum vitae ut dolorum sit magni et. Sit qui sapiente sint. Fugiat tenetur hic commodi. Accusamus magni animi qui provident ipsa.</p><p>Aut modi dolores non consequatur voluptatem. Ducimus laboriosam quis quia consequatur odit nihil. Ut facere et ea accusamus deleniti soluta eaque qui. Repellat dolor doloremque quod et quisquam omnis sequi.</p><p>Atque illo dolores temporibus aut aut quia. Qui omnis tempora molestiae omnis consequatur non veritatis praesentium. Mollitia nam deleniti ea omnis praesentium.</p><p>Quisquam aut qui quia voluptatibus tempore. Dolor et molestiae eveniet sed accusamus rerum. Modi molestiae voluptate quasi earum vel eaque molestiae qui. Natus voluptatem eius facilis qui.</p>', 'excepturi-quas-architecto-sequi-nostrum-ducimus-velit-velit', 1, NULL, 'thumbnails/', '[\"voluptatem\", \"dicta\", \"qui\", \"quis\"]', 'Thêm thông tin mới', '2024-09-03 12:44:54', '2025-04-01 21:18:49'),
('BV-140425-59188592-v67fc6aa2391bb', 41, 22, 'Ea molestias deleniti ea dolorem quis.', '<p>Quo in a mollitia aut dolor sequi amet. Rerum mollitia corrupti odio dolores eum. At ad dolores sequi sunt corrupti incidunt dolores.</p><p>Officiis maiores in cumque sed nobis repellat assumenda. Voluptas similique perspiciatis ullam iure nihil aut.</p><p>Neque et distinctio velit ut aut necessitatibus. Debitis similique omnis qui et ut et laboriosam. Similique sequi et sed ratione deleniti minima. Et provident esse dolorem nulla quod atque.</p><p>Deserunt nam sequi minus quidem. Delectus corrupti et voluptas iste.</p><p>Distinctio magnam quis explicabo ea. Temporibus nostrum eum et et esse culpa dolorem. Rerum magnam hic officiis dignissimos ea dolor esse. Rerum eos quibusdam vel nam quia beatae.</p><p>Qui quidem voluptatibus minus atque in consequuntur. Vitae eius perferendis et explicabo qui. Nihil quia quisquam placeat officia.</p><p>Ad voluptate qui officia odio voluptas. Corrupti qui pariatur omnis quisquam eos facilis fuga. Minus autem sed ea deserunt vel. Iusto pariatur cupiditate dicta reiciendis.</p><p>Vel incidunt mollitia fugit repudiandae exercitationem animi dolor. Rem illo odio enim et illum ea quis. Est recusandae reiciendis in dolores vel.</p><p>Reiciendis atque excepturi laboriosam voluptatem maxime harum reprehenderit repellat. Numquam laboriosam molestiae omnis unde et. Fuga provident eos porro est sunt.</p><p>Autem in aut at magni reprehenderit quod. Facere ut voluptas amet et eveniet omnis. Praesentium dolorem cupiditate incidunt ut labore aperiam rerum.</p><p>Atque numquam asperiores earum. Mollitia eveniet voluptatibus quas quisquam sapiente ratione nemo. Eligendi sed corporis nihil optio perspiciatis quis tempora. Reiciendis aut laboriosam nam animi unde.</p><p>Earum mollitia soluta et aut dolorem officiis quo. Architecto distinctio rerum libero officiis dolor ullam quaerat. Eum dolorem odio fugiat impedit quo quam et quas.</p><p>Beatae quisquam aperiam facere consectetur nesciunt. Ipsum cumque aut voluptatem eligendi voluptatem optio inventore. Rerum ipsum ducimus et nihil exercitationem ut. Repudiandae numquam quia dolores eligendi laborum id voluptatem.</p>', 'ea-molestias-deleniti-ea-dolorem-quis', 7, NULL, 'thumbnails/', '[\"repellendus\", \"velit\", \"et\", \"dolorem\", \"libero\"]', 'Sửa lỗi chính tả', '2024-07-12 06:34:28', '2025-03-02 17:42:16'),
('BV-140425-59188592-v67fc6aa23e42b', 41, 22, 'Quo sed perferendis et atque.', '<p>Blanditiis quia eaque expedita animi molestias inventore qui. Est cum et nam ut est reprehenderit. Et qui delectus commodi voluptas et. Quo asperiores sed facilis iure. Sit sunt delectus perspiciatis earum vel distinctio.</p><p>Autem ad neque enim et. Porro ipsa fuga eos molestiae et. Molestiae inventore ut natus non consequatur.</p><p>Sunt dolorem eum maiores delectus. Porro excepturi aut fugiat quis. Neque ut distinctio nobis iure sed et facere. Illo voluptatum dolorem rerum accusamus consequatur.</p><p>Labore quam autem at ea. Minus voluptas qui aut harum sint. Optio deserunt atque qui deleniti quo optio.</p><p>Iure dolore eaque eos commodi non consequatur voluptas. Et dolor accusantium laboriosam aut magni optio. Ex consectetur reprehenderit sit.</p><p>Quia harum dicta voluptatem. Quisquam quia consequatur dignissimos quae omnis accusamus id enim. Minima omnis molestiae ut. Quod veniam officiis quod.</p><p>Itaque tempora et qui vero veniam non atque. Labore alias et est laboriosam molestias tempore. Dolorum eos perferendis dolores. Occaecati consectetur maiores qui officiis sed quia fugiat.</p><p>Iure deserunt ut rerum occaecati et. Magnam quam qui unde eveniet iste recusandae. Beatae natus vitae tempore occaecati illum vitae maiores aspernatur. Quam animi illo aspernatur ducimus aut.</p><p>Vel iure voluptatem sunt omnis eveniet in. Voluptas tempore tempore voluptas consequuntur quia. Sint et voluptate qui reiciendis aliquam.</p><p>Quos ipsam ratione fuga itaque omnis. Dolores sint aut sint quasi quia amet dignissimos. Ullam doloremque qui delectus eligendi non sed. Dolorem magni et voluptatibus quam reiciendis atque.</p><p>Itaque autem asperiores sint non itaque eos et. Sed eum dolores sed quas illo nemo. Commodi veniam vel nihil.</p>', 'quo-sed-perferendis-et-atque', 7, NULL, 'thumbnails/', '[\"suscipit\", \"tempora\", \"eligendi\", \"velit\"]', 'Thêm thông tin mới', '2024-08-21 10:13:54', '2024-12-04 23:49:17'),
('BV-140425-60786915-v67fc6aa223cd1', 4, 13, 'Qui et ut laborum.', '<p>Est rerum perspiciatis nesciunt qui quia. Laborum sit error nihil vel hic. Ut ipsum doloribus mollitia est neque laboriosam quam. Quia ut error inventore eveniet libero.</p><p>Praesentium esse dolor asperiores. Sint asperiores culpa sit et. Minus dignissimos optio repellendus perspiciatis.</p><p>Unde fugiat ducimus eum veritatis inventore tempore odit. Necessitatibus nisi recusandae explicabo. Omnis itaque vero exercitationem reprehenderit velit velit voluptates. Consequatur eos quis quidem et non tempore. Impedit ex maiores et adipisci inventore.</p><p>Quos eum quia dolores. Qui voluptatem repudiandae et perspiciatis. Dolore cum veritatis non. Quia illum accusantium quo et quae est adipisci sed.</p><p>A omnis sint nemo omnis quia. Voluptatem aut delectus eos quas dolor. Modi beatae hic molestiae consequatur.</p><p>Et est nam molestiae architecto possimus recusandae blanditiis eum. Maxime consequatur sunt blanditiis id. Optio ipsa voluptatem debitis praesentium hic.</p><p>Consequatur et adipisci cum eos magnam alias sunt voluptatem. Autem ratione autem laboriosam quam doloribus qui voluptate tenetur. Aut eligendi quia illo et dolor accusantium.</p><p>Suscipit soluta explicabo in consequatur qui excepturi. Non voluptatum dicta architecto nulla. Sunt possimus cumque vitae eveniet.</p><p>Et est exercitationem explicabo unde. Rem quam aperiam consequatur esse sit. Ullam eveniet possimus ducimus voluptatem in esse. Sed et qui et praesentium consequatur culpa. Rerum ut iure incidunt incidunt sapiente nemo qui et.</p><p>Quod nemo voluptatem possimus quis. Ea sit voluptas occaecati distinctio est. Cum et quibusdam pariatur. Ratione eum inventore omnis quasi repellendus dolorem.</p><p>Voluptates officiis voluptas sunt occaecati deleniti. Mollitia autem natus aperiam aut velit. Odit ut iste ipsa totam quae consequatur quod dolor.</p><p>Rem consequatur magnam dolorem molestiae repudiandae. Modi autem impedit voluptates quidem quia maxime sit. Tenetur autem ipsum quo cupiditate velit.</p><p>Enim blanditiis rem blanditiis. Totam distinctio qui et. Inventore animi nemo vel voluptas et qui tempora. Nobis molestiae et et officiis sit unde.</p><p>Ipsum perspiciatis eum consequatur ipsum est nisi. Reprehenderit quibusdam repellendus et voluptates aliquam atque. Omnis quas modi deserunt cumque. Ipsam sed autem dolorem ducimus possimus.</p>', 'qui-et-ut-laborum', 8, NULL, 'thumbnails/', '[\"earum\", \"officiis\"]', 'Cập nhật nội dung', '2024-11-25 08:00:15', '2025-02-23 05:54:30');
INSERT INTO `article_versions` (`version_id`, `article_id`, `user_id`, `title`, `content`, `slug`, `category_id`, `subcategory_id`, `featured_image`, `tags`, `change_reason`, `created_at`, `updated_at`) VALUES
('BV-140425-60786915-v67fc6aa23c318', 4, 13, 'Dolorem odio ut similique non reiciendis reprehenderit harum repellendus.', '<p>Hic illum autem suscipit quae. Aliquid nostrum omnis eos quaerat. Quia veniam cum magnam totam ut itaque accusantium eveniet. Debitis dolore dignissimos voluptate aperiam ut inventore.</p><p>A suscipit rerum maxime adipisci quibusdam hic id. Corrupti dolores sed accusamus sed repudiandae. Non cupiditate voluptatem laudantium rerum pariatur.</p><p>Voluptas nihil accusantium nisi aut tempore molestiae sunt. Id quod quaerat commodi et. Corrupti beatae aliquam mollitia omnis consequatur aspernatur sequi.</p><p>Unde ut nostrum minima beatae. Exercitationem quidem sunt non doloribus dolor est. Eaque vero aut ad.</p><p>Et vero architecto et ea. Deleniti amet ex quia accusamus eveniet. Est totam amet nihil esse nisi sequi. Quibusdam in nulla cum optio facilis.</p><p>Et odit dolores quia veniam molestiae enim. Consequatur reprehenderit harum dignissimos perspiciatis illo aperiam quia. Libero quia debitis magni rem qui. Sit sed necessitatibus in cupiditate iusto repellendus.</p><p>Aut debitis ad deserunt consectetur aliquid assumenda. Numquam magnam molestiae maiores eaque facere alias. Nesciunt omnis ad saepe esse qui. Voluptatem sunt nisi eos qui sequi cum sit. Id quis non commodi quod possimus corporis.</p><p>Non recusandae possimus sint aut. Dicta facere iste quo in velit odit blanditiis. Distinctio laudantium fuga doloribus repellendus natus iusto.</p><p>Quidem mollitia tenetur porro placeat consequuntur quam illo. Omnis adipisci fugit assumenda et voluptatem. Veniam exercitationem veniam veniam id iste porro dolorem. Quis neque molestiae asperiores corrupti expedita dolores.</p><p>Consequatur eum illo dolorem consequatur nihil rerum omnis tenetur. Maxime vel iusto et ex. Quis illum ut qui et ipsum repudiandae beatae in. Vel sed aut porro et.</p><p>Amet ab iure sit possimus illo voluptates. Rerum non eos similique ut vitae. Et quis est quibusdam quo eos consequatur. Dolorem eos et cumque aspernatur iusto.</p><p>Officiis atque qui natus. Dolorum deserunt veniam et at accusamus possimus voluptates debitis. Quis mollitia eum ut perspiciatis. Nesciunt voluptate nesciunt laudantium dolorum voluptas aut.</p><p>Repudiandae ad similique aperiam perferendis et autem deserunt qui. Est vel explicabo totam culpa consequatur et debitis. Aperiam quia dolorem esse voluptatem recusandae sed ut id. Voluptates rem aliquid reiciendis reprehenderit ipsa optio est eveniet.</p>', 'dolorem-odio-ut-similique-non-reiciendis-reprehenderit-harum-repellendus', 8, NULL, 'thumbnails/', '[\"tenetur\", \"et\"]', 'Tạo bài viết mới', '2024-09-06 22:39:56', '2025-01-02 02:47:29'),
('BV-140425-60786915-v67fc6aa24de80', 4, 13, 'Vel error debitis voluptatem quia quis asperiores.', '<p>Sunt eius rem numquam voluptatem eos id. Dolorum et minus aperiam sequi similique nisi. Quia quia accusantium et ullam molestias molestiae. Qui rerum ullam voluptatibus eveniet eum voluptates. Fugiat voluptate dolorem quasi quas autem et.</p><p>Praesentium aut qui harum atque aut eos in. Aut corporis fugit dolorum minima repellat libero ut. Id maxime voluptatem rem et blanditiis aut aut. Dolorem vel voluptate non est veniam non.</p><p>Numquam deserunt velit iure illo et est. Modi odio praesentium totam velit. Laboriosam dolorum qui optio.</p><p>Aliquam ut animi repellendus neque aut dolores culpa illo. Illo consequatur non nostrum repellendus inventore alias. Minima at cumque aut veritatis voluptatibus repellendus sapiente.</p><p>Exercitationem excepturi cumque error voluptate quam. Consequatur commodi fugiat fuga minima dolores eum aliquid. Dolor qui quidem asperiores. Cum sunt nihil id. Tempora aliquid aut iusto corporis ratione.</p><p>Error consectetur eius possimus quis nostrum sunt qui. Dolores omnis sit omnis assumenda quibusdam. Nisi ea minima est molestiae sed. Ut et rerum nobis fuga nulla temporibus qui molestiae.</p><p>Voluptas dolores eius sint fuga. Eum itaque in provident libero rem. Sed quo et sapiente ratione earum. Et doloribus nisi consequatur in recusandae.</p><p>Qui expedita voluptas cupiditate aliquam aut eum. Officiis qui suscipit autem amet vitae officia. Et soluta magni laborum perspiciatis in omnis et.</p>', 'vel-error-debitis-voluptatem-quia-quis-asperiores', 8, NULL, 'thumbnails/', '[\"nihil\", \"qui\", \"placeat\", \"eum\", \"quas\"]', 'Sửa lỗi chính tả', '2025-02-03 22:43:38', '2025-03-17 17:38:25'),
('BV-140425-64313208-v67fc6aa237ad3', 25, 4, 'Suscipit culpa porro similique aut veritatis.', '<p>Quia autem vitae ratione beatae velit. Omnis qui ipsa dolorum facilis laborum asperiores cumque et. Pariatur natus vel molestiae nemo est est reiciendis dicta.</p><p>Laudantium ea hic quaerat ut sit sunt beatae. Voluptas facere dolor dolore porro quos. Doloremque eveniet assumenda laudantium praesentium porro facilis.</p><p>Repudiandae perferendis saepe excepturi nemo ut blanditiis. Minus voluptatem sit eum eaque reprehenderit. Velit ipsum tenetur autem et facilis qui.</p><p>Perferendis quis minima et minus rerum. Voluptatem sapiente incidunt qui accusantium. Vel quo saepe corrupti necessitatibus.</p><p>Qui sequi rerum alias qui. In natus ut quibusdam eos. Quae impedit at praesentium qui nam. Culpa quos sed quasi est quo facilis ea.</p><p>Soluta aliquid id aliquam sint nihil et. Quisquam ut numquam eum voluptatem soluta quos exercitationem cum. Eius reprehenderit totam iste ratione. Non quia a ipsum maiores veniam.</p><p>Natus veritatis culpa magnam accusamus enim impedit omnis. Veritatis aut vel explicabo. Reiciendis rerum mollitia culpa velit rerum neque.</p><p>Id itaque molestias non iste. Et pariatur unde sint. Minima cumque id quia voluptate quo.</p><p>Qui tenetur nobis quisquam vel corrupti rerum. Ea porro eum cumque quos pariatur in. Dolores quaerat et tenetur aliquam possimus doloribus. Voluptatem ut reiciendis exercitationem.</p><p>Et eius nobis architecto quia. Aut recusandae quos aut. Necessitatibus nesciunt recusandae nam maxime repudiandae quo. Sed nobis aspernatur sint quis.</p>', 'suscipit-culpa-porro-similique-aut-veritatis', 1, NULL, 'thumbnails/', '[\"in\", \"maxime\", \"magni\"]', 'Cập nhật hình ảnh', '2024-04-17 10:29:48', '2024-05-19 18:28:22'),
('BV-140425-64313208-v67fc6aa23991a', 25, 4, 'Reiciendis minima at ipsa rerum omnis consequuntur maiores.', '<p>Eos nisi autem incidunt. Delectus soluta deserunt ut voluptas possimus.</p><p>Architecto et aut natus sit alias. Fuga reprehenderit accusantium voluptas aut hic omnis voluptatem. Delectus non maxime cum.</p><p>Modi consequatur non fugiat assumenda repudiandae. Dolor perferendis deserunt et cumque. Nostrum esse incidunt eum earum.</p><p>Velit sint et quia non quisquam dolor. Dolores temporibus tempora aut et ea. Est temporibus dolorum commodi laudantium distinctio pariatur. Accusantium suscipit laborum magni qui. Quis quod ea eaque qui tempora doloremque quam.</p><p>Culpa et impedit at autem aut laborum harum. Minima qui nobis sit. Enim qui quia eaque vel in. Optio sit quo est nisi qui.</p><p>Dolore laboriosam qui aut ut non quae consequatur. Aut et ducimus et beatae et. Aliquid quos repellendus ducimus beatae aut nihil et.</p>', 'reiciendis-minima-at-ipsa-rerum-omnis-consequuntur-maiores', 1, NULL, 'thumbnails/', '[\"voluptatem\", \"cupiditate\", \"vitae\"]', 'Thêm thông tin mới', '2024-04-16 08:34:28', '2024-05-14 17:28:21'),
('BV-140425-64602326-v67fc6aa2431ae', 50, 5, 'Odio molestias facilis aspernatur molestiae voluptatum ab.', '<p>In nobis rerum distinctio velit ipsum et a. Dolore non quasi debitis exercitationem accusantium quo. Sint voluptatibus voluptas totam occaecati. Et id nihil quas eligendi velit iure qui dolor.</p><p>Voluptates qui cupiditate nostrum et. Sint eius est sapiente non repellat. Dignissimos impedit explicabo aut est.</p><p>Sapiente placeat omnis atque explicabo voluptatem corrupti recusandae quod. Voluptatem reiciendis qui est alias reiciendis aut rerum. Quia voluptatem eius eveniet ipsam atque dolor tenetur vero.</p><p>Sed eum est ea praesentium voluptate. Vel ullam quo debitis et. Praesentium deserunt sit qui nihil fugit dolorem quos ut. In rem dolores quisquam magnam et ut nisi. Iure minima autem rerum vero dolorem.</p><p>Voluptas impedit amet consectetur vero ut. Harum qui aliquid ullam alias. Rerum omnis qui veritatis vel rerum omnis. Voluptatibus velit inventore voluptas cumque aliquid in.</p><p>Qui doloremque a odit optio mollitia odit aut. Ipsa magnam aliquam autem asperiores nesciunt maiores adipisci. Corrupti sit odio corporis assumenda autem rerum nesciunt. Laudantium qui beatae ipsa ducimus.</p><p>Id rerum voluptas omnis perferendis ad nobis ut. Suscipit omnis voluptas sit quidem aliquam ut qui neque.</p><p>Qui rem voluptatibus consequatur dolores. Laudantium fugit omnis ut perspiciatis velit. In beatae temporibus facere ipsa nobis iste. Aut quis repellendus et eos voluptatem iusto. Fuga corrupti molestiae soluta quisquam est est.</p><p>Autem esse consequuntur ut doloremque dolorem rerum. Odio tempora cumque nisi impedit iusto. Facere assumenda placeat fugiat autem sit.</p><p>Impedit est molestiae dolores enim ducimus similique earum. Ea commodi doloribus minima veritatis. Quod odio harum dolor. Nobis sequi quibusdam saepe maxime.</p><p>Qui repudiandae facere et sint dolore sint magni. Vel cumque a corporis minus numquam.</p>', 'odio-molestias-facilis-aspernatur-molestiae-voluptatum-ab', 10, NULL, 'thumbnails/', '[\"rerum\", \"aut\", \"nobis\", \"doloremque\", \"sequi\"]', 'Thêm thông tin mới', '2024-08-07 16:12:47', '2024-12-30 14:01:35'),
('BV-140425-64602326-v67fc6aa24a350', 50, 5, 'Quibusdam quo veniam praesentium eligendi illo veritatis nam.', '<p>Qui eius et repudiandae voluptatum. Doloremque perspiciatis non officia est est aliquid aliquam. Esse eius quae sed. Et ut accusamus maiores perspiciatis expedita quod enim.</p><p>Et incidunt incidunt autem temporibus soluta et ducimus. Eligendi pariatur sed enim repellendus quia omnis. Consequuntur sequi accusantium ipsam consectetur dolor nulla.</p><p>Natus voluptates non minima et veniam provident. Dolores et mollitia vel et ut ipsa animi. Repudiandae porro velit sint quod ullam quae.</p><p>Aperiam excepturi sequi quia eveniet rerum omnis voluptatem. Et officia itaque est voluptatem sed expedita. Id autem harum nam at.</p><p>Et suscipit quia fugit expedita est sed. Nemo repudiandae optio commodi sed vero ut fuga. Vel rerum voluptas amet quia qui nemo magni possimus.</p><p>Ducimus et est quibusdam possimus ipsa quia. Est possimus perspiciatis voluptatem quia eveniet. Aut sint magnam soluta corporis nemo itaque. Rerum at et voluptatem molestiae ducimus.</p><p>Animi placeat omnis laboriosam quibusdam dolorem quibusdam. Qui consectetur a asperiores accusamus. Quod inventore nostrum et aliquid magnam accusamus. Dolores quibusdam nam ipsam ipsum voluptate.</p><p>Exercitationem ad amet non porro aut ipsum eligendi. Beatae non odio adipisci aut. Ea deleniti dolore sunt quidem praesentium itaque reprehenderit provident. Temporibus est officiis impedit et a.</p><p>Quis possimus a dicta dolorum et voluptates et. Qui vero voluptatum quia neque nostrum expedita. Doloribus aut quod repellendus ad id et molestias. Alias sint voluptatem ut occaecati cum dolor mollitia.</p><p>Quia at aut atque optio consequatur harum et. Id ea necessitatibus sint asperiores velit. Officiis dolores dolores pariatur rem ut provident aspernatur. Quas sunt delectus ea nemo quos voluptatem.</p><p>Dolorem beatae odio iure. Quia beatae sint delectus id mollitia sed dignissimos. Et magnam aut ut adipisci nobis.</p>', 'quibusdam-quo-veniam-praesentium-eligendi-illo-veritatis-nam', 10, NULL, 'thumbnails/', '[\"sint\", \"tempore\", \"sapiente\"]', 'Cập nhật hình ảnh', '2024-05-20 07:21:38', '2024-10-07 16:15:35'),
('BV-140425-65266275-v67fc6aa241494', 15, 23, 'Distinctio suscipit aut maiores reiciendis.', '<p>Voluptate et quam consequuntur neque. Recusandae dolore minima enim sit labore saepe dolorem. Rerum delectus dolorem expedita eum repellat.</p><p>Amet molestiae modi rerum doloremque velit distinctio magni assumenda. A quis explicabo totam minima. Iste harum ullam eum pariatur quod est. Rerum corporis soluta quae reiciendis omnis reiciendis at.</p><p>Est est quos magnam qui et. Nobis ipsum quas eveniet ut ut. Provident qui voluptatem quia dolorum.</p><p>Impedit quis nobis consequatur aut dolore. Quis aut harum exercitationem velit sunt alias ut. Quas eligendi ipsum quidem.</p><p>Ratione aspernatur earum illum fuga itaque cum laborum. Voluptatem quas est enim vel sint. Totam ea tenetur illo sunt eos non odio.</p><p>Explicabo officiis voluptatem dolore qui. Eos impedit minus maxime tempora. Provident quia est placeat temporibus nobis.</p><p>Minus omnis autem quia autem vero ipsum. Sit fugiat reiciendis autem sit. Molestiae adipisci mollitia ipsam reprehenderit quos in et.</p><p>Velit iure adipisci autem. Repudiandae est iusto dolorem odio vel ipsa blanditiis fuga. Aperiam architecto dolorem aut est et voluptatem.</p><p>Necessitatibus nisi hic incidunt cumque adipisci repellendus. Consequatur porro doloremque voluptas sint officia ut.</p><p>Est consequuntur mollitia ipsa corporis debitis. Quisquam voluptas suscipit sunt esse. Quam rem laborum debitis earum dolor. Et temporibus placeat et qui illum inventore eligendi voluptas.</p><p>Dolorum magni eum officiis quas ipsa facere. Odit ea possimus recusandae sit labore ipsum. Nulla rerum sunt molestias. Veritatis qui quae ab exercitationem.</p><p>Et non explicabo impedit earum aut amet reprehenderit et. Quis sint cum qui dolor quod omnis. Laborum quam est error modi similique velit.</p><p>Quibusdam et eaque error tempora sit. Rem aut amet molestias quas. Odio est nostrum eius debitis necessitatibus maiores. Qui non deleniti ut aliquid sit omnis praesentium quod.</p><p>Adipisci accusantium nesciunt provident ducimus aperiam error. Est eaque qui tempora. Ut a at asperiores modi ad molestiae quaerat dolor.</p><p>Eos exercitationem vel neque officia qui in enim. Consectetur asperiores repellendus odit. Magni harum aut est doloribus dolore commodi.</p>', 'distinctio-suscipit-aut-maiores-reiciendis', 9, NULL, 'thumbnails/', '[\"soluta\", \"sit\"]', 'Cập nhật hình ảnh', '2024-08-04 18:06:03', '2025-01-26 16:53:58'),
('BV-140425-66820164-v67fc6aa222d14', 39, 4, 'Sequi est quam sint corrupti.', '<p>Quae mollitia veritatis eos dolorem quas qui. Maiores rerum nesciunt facere ad officiis rerum dignissimos.</p><p>Molestias inventore labore et et autem eveniet. Est adipisci quo voluptates sit minima. Suscipit perspiciatis natus dignissimos ducimus dolore dolorem unde.</p><p>Quasi autem fugiat quasi. Repudiandae quas nemo velit minima hic aliquid non. Dolorem ut a similique neque. Omnis omnis sit consequatur veniam voluptatem.</p><p>Qui aut corporis eius sint minus. Consectetur est assumenda dolore reiciendis et. Eos perspiciatis dolorem quas et quibusdam quo.</p><p>Impedit eius impedit eveniet aspernatur voluptates corrupti dolorum. Sit illum animi ad occaecati tempore magni blanditiis incidunt. In rerum aliquam voluptas omnis. Aut iure quis temporibus quia.</p><p>Laboriosam corrupti aut sint delectus doloremque neque voluptas. Sit quo molestiae magni alias. Tempora illo non iusto mollitia nihil.</p><p>Iure quisquam voluptatem et blanditiis illum voluptas molestiae. Rerum facere sint odit. Rem eos architecto et atque.</p><p>Fugit modi cum qui vero sit officia. Eligendi voluptatem quis quisquam perspiciatis ut eum unde. Illo eligendi et praesentium repudiandae et aut dolor.</p><p>Repellat possimus et alias incidunt adipisci voluptatem qui. Nihil ut error nulla recusandae error reprehenderit. Tempora animi fugiat modi provident.</p><p>Repellat nesciunt nobis reprehenderit deleniti ab magnam. Excepturi quasi laudantium voluptatibus excepturi deserunt dolores dignissimos. Consequatur sit adipisci esse sint. Excepturi vero qui laboriosam. Veniam dolores quisquam labore.</p><p>Ut maxime perferendis corrupti aut qui rerum dicta. Sint animi quos quia voluptate dolorum. Ut aperiam non pariatur cum. Laboriosam quaerat tenetur quia et soluta culpa.</p><p>Aut sint voluptatem libero id qui iure. Non incidunt dolores provident sed vel harum. Consequatur deserunt provident dolorum et deserunt quidem sit vel. Tempora quasi maiores fugiat et. Repudiandae cum ut et est.</p><p>Nulla non at et perspiciatis quaerat ea quis. Et eligendi earum qui natus ea. Tempora nisi eum quidem fugiat itaque quam.</p>', 'sequi-est-quam-sint-corrupti', 8, NULL, 'thumbnails/', '[\"eum\", \"debitis\"]', 'Cập nhật nội dung', '2025-01-02 06:28:10', '2025-03-06 12:29:27'),
('BV-140425-66820164-v67fc6aa22dea5', 39, 4, 'Praesentium corrupti voluptas adipisci ducimus voluptatem.', '<p>Voluptatibus suscipit quia autem et dolore. Est et ut id quibusdam. Placeat et eligendi et ut sunt ea. Et rerum est qui est tempore.</p><p>Temporibus ipsum mollitia nihil. Iusto sed id velit eligendi quam ullam. Amet cupiditate et similique. Optio amet vero consequatur nesciunt iste exercitationem corrupti sit.</p><p>Dolorum alias et quia quis rerum officia explicabo. Et voluptatem facilis sint quo nesciunt dolor. Iste veniam suscipit modi et nostrum quas.</p><p>Id libero commodi amet. In autem consequatur laborum qui nobis quia aut. Ut voluptatem animi omnis quam.</p><p>Aut quis eligendi deserunt asperiores aut. Accusamus nemo id et earum ratione. Amet et et est adipisci laudantium praesentium itaque.</p><p>Quae et totam quos. Voluptatem dignissimos rerum corrupti corrupti est et. Voluptate et aliquid nesciunt hic.</p><p>Non quos itaque quis. Ut et et qui ut. Reiciendis et et nisi maxime. Praesentium sed ipsum dicta maiores omnis veniam.</p><p>Et molestias voluptatum iusto ex aperiam tempore molestiae. Corporis quia expedita et culpa. Suscipit repellat nulla est quos ducimus vel.</p><p>Culpa enim quo dolores odio voluptatem vel. Id quidem minima modi minus. At qui ex quia eligendi enim qui consectetur officiis. Sit aut dolores omnis dolores.</p><p>Sit facere quo esse qui. Quod consequatur inventore omnis tenetur ab veniam animi expedita. Voluptas quod quia sed non sequi quidem.</p><p>Architecto numquam consequatur ad blanditiis. Et minus nihil repellat. Cumque dicta eum et ut itaque alias. Laudantium recusandae molestiae ut est quasi temporibus.</p><p>Rerum omnis et aperiam velit quibusdam nulla. Non deserunt sunt ut.</p><p>Esse iusto nesciunt est dolores tenetur. Id id eaque et ipsum est quisquam vitae nesciunt. Sapiente dolor nisi eligendi porro.</p>', 'praesentium-corrupti-voluptas-adipisci-ducimus-voluptatem', 8, NULL, 'thumbnails/', '[\"vel\", \"quidem\", \"qui\", \"vel\"]', 'Cập nhật hình ảnh', '2024-05-14 17:36:47', '2024-06-10 01:18:12'),
('BV-140425-66820164-v67fc6aa23cdb0', 39, 4, 'Ex deleniti est iste eligendi nihil ut.', '<p>Et inventore minima quam eum. Cumque odit rerum rerum odio odio non sed. Quia dolorum qui ad sint voluptatem. Nam officiis earum odit accusamus nostrum labore ut.</p><p>Ea rerum saepe molestiae accusantium. Vel est placeat maiores et iusto aut illo. Qui aut necessitatibus ipsum unde magnam enim est.</p><p>Officiis dolores distinctio qui harum recusandae commodi voluptatem. Soluta dolore laboriosam dolorem a. Dicta explicabo in dignissimos et ipsam qui. Nihil sequi sunt corporis ab qui perspiciatis minus.</p><p>Ut quos delectus veritatis voluptatibus optio. Saepe qui quaerat eos distinctio labore temporibus quo. Perferendis fugit totam distinctio magnam velit. Ut tempore quia praesentium eius cupiditate impedit veniam.</p><p>Minima vitae explicabo dignissimos distinctio accusamus in. Nam exercitationem sed id. Provident illo deleniti minima nam sint. Accusantium ea laboriosam atque quae.</p><p>Tenetur iure et omnis saepe officiis. Illo odit enim officiis similique unde corporis aut. Dicta id voluptatem vero ipsam rerum et ut quod.</p><p>Odio magni corrupti omnis amet. Sit ullam veniam dolor eveniet quod impedit dolore. Non et et nemo sint. Sequi sunt amet pariatur et minima eveniet earum.</p><p>Est tempore dignissimos nulla voluptatem qui quibusdam porro. Aperiam illum hic sunt inventore nisi odio aut. Libero sequi eaque aliquid. In eos impedit id laborum consectetur. Neque vitae atque qui qui harum.</p><p>Quia aperiam omnis omnis. Quia et rerum ex odio deserunt. Officia explicabo eveniet voluptatem perspiciatis perferendis.</p><p>Temporibus quasi a illum et sit. Voluptas optio dolores nihil rerum maiores qui. Doloribus quis suscipit atque sapiente illo mollitia rem totam.</p><p>Laboriosam officiis aspernatur tempora et sint omnis. Maxime officiis quos unde beatae nemo libero laborum et. Minus nihil dolores soluta qui fugit sit. Provident similique aut quia est dolores ut et. Est non aut dolorem quisquam.</p><p>Commodi tempora incidunt deleniti ut iusto et. Quo eos tempora dignissimos enim quas et excepturi. Excepturi laboriosam nulla quia cum nobis.</p><p>Unde non consequatur sit beatae aut quia. Explicabo repudiandae quae adipisci molestiae quia animi dolorem. Temporibus et quod accusantium repellat exercitationem corrupti nemo.</p><p>Dolor iste et reprehenderit et et et autem. Omnis qui eos et illo. Magnam illum explicabo reiciendis atque quia.</p><p>Laboriosam in laudantium repellendus dignissimos eaque incidunt voluptates. Itaque aut expedita dolor culpa delectus quo commodi. Est et est exercitationem temporibus necessitatibus dolorem. Et ipsum veritatis quia cumque.</p>', 'ex-deleniti-est-iste-eligendi-nihil-ut', 8, NULL, 'thumbnails/', '[\"voluptatibus\", \"vel\", \"et\"]', 'Cập nhật hình ảnh', '2024-09-13 13:40:57', '2024-10-18 03:48:46'),
('BV-140425-68131761-v67fc6aa22fa65', 46, 16, 'Aut reprehenderit numquam ratione ducimus libero.', '<p>Odio ut enim consequatur commodi at. Minima voluptatem vero veniam maxime pariatur occaecati. Et beatae et ut aut atque aliquam fugiat.</p><p>Excepturi optio exercitationem ut et non aut ut. Dolor vel ab laudantium voluptas ut dolores praesentium quia. Sed reiciendis impedit eum dolores minus.</p><p>Totam ut molestiae totam sed exercitationem sint. Aliquam quos accusantium dolores est. Est est recusandae quidem corrupti. Ipsam non natus tenetur rerum mollitia culpa at.</p><p>Rerum tempora assumenda itaque. Officiis qui earum occaecati ut. Dolores vero et repudiandae qui sed ut. Facilis fuga consequatur itaque ut rerum ut provident. Inventore voluptas facere et quis nihil.</p><p>Corporis et ex amet quibusdam. Vero voluptate id optio velit.</p><p>Culpa atque voluptatem consectetur sunt. Est amet sint tempore est qui. Ut eligendi velit possimus. Voluptate voluptatibus voluptatibus quos cum.</p><p>Sit architecto consequatur architecto qui repellendus ea dolorum dolores. Et ut rem rerum. Nulla qui officia sit minima. Sint aut ipsum vitae praesentium nemo ut voluptatem.</p><p>Eum libero dignissimos debitis ut. A error mollitia numquam consequatur. Ex iure praesentium quia temporibus cupiditate.</p><p>Suscipit sapiente dolor ut voluptatum nihil labore praesentium. Assumenda fugiat cupiditate vitae qui. Reprehenderit delectus aut aspernatur sed.</p><p>Reiciendis aperiam non animi voluptatum reprehenderit dolorem quis magnam. Voluptas voluptas eum sit dolores amet deserunt nemo in. Facilis hic accusamus quo enim voluptate et. Veniam et perferendis autem voluptas tempore est. Odio debitis quo ut neque et.</p><p>Nemo consectetur neque consequuntur iste sed tempore voluptatem. Minima voluptatem molestiae natus est est veritatis. Corporis molestias dolor esse architecto illo eos quos. Facilis minus beatae quia provident molestiae.</p><p>Labore sunt aut laudantium ut. Ratione in non quaerat laboriosam voluptas qui atque.</p><p>Vel vel quis libero perferendis nesciunt. Cupiditate cumque nesciunt perferendis deserunt consequatur autem doloribus. Facilis exercitationem at libero et enim. Nihil dicta est illo doloribus. Magnam aliquam aut et ratione enim possimus.</p><p>Quisquam rerum voluptatem non doloremque. Totam officia in harum sed et necessitatibus. Id quidem et laborum eligendi.</p>', 'aut-reprehenderit-numquam-ratione-ducimus-libero', 10, NULL, 'thumbnails/', '[\"et\", \"qui\"]', 'Cập nhật nội dung', '2024-08-16 19:41:29', '2024-11-08 10:43:46'),
('BV-140425-68131761-v67fc6aa23dcb1', 46, 16, 'Facere consequatur ex officia in voluptates voluptatem consectetur pariatur.', '<p>Consectetur assumenda voluptas voluptatem officia ipsa laboriosam tempore cupiditate. Fugit veniam dolorem ut possimus nisi corporis sit in. Debitis accusamus similique id tempora qui vel. Incidunt eaque omnis enim quia at facere voluptatum.</p><p>Ratione dignissimos voluptatem tenetur cumque quia sint similique. Non sunt labore quia est qui corrupti vel. Dolor cupiditate excepturi velit laborum provident. Amet vel ipsum et iusto ut molestiae.</p><p>Earum eos mollitia non dicta quasi. Et tempora sunt ut et excepturi illo. Qui eveniet magni eos. Voluptatem qui velit consequuntur velit quis aspernatur animi et.</p><p>Saepe libero est modi voluptas natus quia dolores ab. Doloremque necessitatibus ut est. A dolores et fugit delectus distinctio. Ducimus beatae assumenda asperiores officia.</p><p>Aut quasi et rem ut doloremque. Autem accusamus laborum repellendus repellendus temporibus ab a. Veniam vitae deserunt aperiam nihil rerum asperiores veritatis. Voluptates molestiae beatae et minus sint qui animi.</p><p>Ut veniam assumenda atque est. Sed cum dolorem enim sit et. Temporibus qui fugit culpa similique tempore. Ut in consequatur facere et rerum impedit velit.</p><p>Aut distinctio enim nesciunt qui et et incidunt. Architecto adipisci doloremque sed unde voluptatem minus earum. Enim debitis eos placeat est assumenda veritatis. Laborum repellendus quibusdam consequatur nobis sequi quia.</p><p>Natus nihil quas hic cumque. Eos voluptate corrupti asperiores possimus quasi voluptatem quaerat. Voluptatibus nisi ut id assumenda.</p><p>Unde consequatur earum mollitia et. Adipisci sed dicta iure beatae iste eum excepturi et. Voluptatum blanditiis maiores iure in. Quia ducimus id optio aliquid.</p><p>Officia enim dolorem quaerat doloremque. Ex nobis suscipit mollitia dolorem eligendi dolor. Odio occaecati non inventore ut. Perspiciatis sed dolorum sint minus.</p><p>Mollitia et et rem soluta. Amet sunt fugiat doloremque sit et modi. Qui et deserunt ipsum velit tempora nobis.</p><p>Id neque nostrum omnis aliquid quasi quod eius sed. Quia sint fuga repellat ea ab. Ullam qui nihil reiciendis odit dolorem quibusdam eius.</p><p>Ex eum qui autem non esse quia. Nulla aut quia temporibus ut. Optio consequatur aut iusto repudiandae enim at assumenda. Ratione ut magni est.</p><p>Aut et dignissimos omnis id ullam. Autem architecto sit eos sit qui est. Itaque perspiciatis quia qui voluptatem modi doloremque.</p>', 'facere-consequatur-ex-officia-in-voluptates-voluptatem-consectetur-pariatur', 10, NULL, 'thumbnails/', '[\"velit\", \"ad\"]', 'Sửa lỗi chính tả', '2024-11-02 05:38:26', '2025-01-04 11:19:06'),
('BV-140425-68131761-v67fc6aa250c98', 46, 16, 'Corrupti labore incidunt expedita corporis.', '<p>Magni ut odio molestias corrupti sit. Minus incidunt voluptatem at sunt quia accusamus vel soluta. Eum aut reprehenderit qui temporibus. Distinctio debitis voluptatem velit doloribus quia nihil qui magnam.</p><p>Officiis voluptatem excepturi tempore enim recusandae vero in. Commodi ab iure molestiae necessitatibus et. Temporibus ipsum fugit aut voluptatem. Quod nihil veritatis eligendi commodi consequatur.</p><p>Necessitatibus iure fugiat quo ex sunt. Commodi saepe ea sapiente magnam facilis nobis nesciunt natus.</p><p>Et nesciunt incidunt id aut quis est placeat. Saepe fugiat omnis deserunt praesentium.</p><p>Ut laborum aut magni consequatur qui quibusdam. Tempora qui et iusto et est ut. Labore aut explicabo aut hic aut enim. Soluta perspiciatis error unde dolor quo qui cumque repellat.</p><p>Ut maiores fugit odit culpa architecto nihil. Aut voluptatum facere ut libero repellat est maxime. Alias ullam dicta odit est voluptatem similique. Omnis delectus sit necessitatibus sit autem praesentium magnam.</p><p>Doloremque iusto et ducimus. Numquam voluptas ipsa eligendi perferendis ducimus autem. Sed sunt officiis accusamus optio et.</p><p>Nam eligendi error reiciendis facilis. Ratione dolor voluptatem consectetur rerum voluptatem nisi odio. Ea et iure incidunt consequuntur dolores hic. Aut at repellat eum excepturi eum consequuntur.</p><p>Et saepe saepe neque est. Doloremque velit rem ullam eius dolorem assumenda modi dolor. Temporibus ab ipsum ipsam ut. Error ea in officiis. Aliquid enim numquam eos ut quas.</p><p>Qui velit ad tempora consequatur ad neque. Distinctio officiis harum et autem veritatis. Asperiores nihil repellendus esse aut et qui dicta. Tempore dignissimos libero impedit deserunt corporis amet.</p><p>Qui iste qui sed rerum consequatur asperiores. Ullam modi in repellendus commodi rerum eligendi adipisci. Dolorem veniam rerum eligendi eum. Enim nemo dolores asperiores blanditiis autem.</p><p>In praesentium quod vel repudiandae porro quam. A sequi natus facere quas quaerat nesciunt. Consectetur ut ut suscipit. Mollitia vel vitae vero ipsa voluptatem quisquam.</p><p>Est expedita molestias consectetur quas ab hic. Voluptas assumenda inventore rem eveniet repellendus est ex. Totam temporibus perspiciatis dicta dolore nihil. Aut quam laudantium provident earum aut repellat blanditiis.</p><p>Nobis delectus consequatur commodi cum harum alias. Fugit consequatur consequatur quibusdam rerum nihil. Sint odit illum et. Provident illo velit nihil sapiente autem repellendus possimus.</p>', 'corrupti-labore-incidunt-expedita-corporis', 10, NULL, 'thumbnails/', '[\"impedit\", \"nesciunt\", \"assumenda\"]', 'Sửa lỗi chính tả', '2024-04-23 11:51:08', '2025-01-16 20:20:17'),
('BV-140425-72994560-v67fc6aa234650', 43, 16, 'Nulla fugiat temporibus mollitia et ut nemo.', '<p>Fugiat eos sit voluptatibus nulla odit. Quo asperiores illum ducimus excepturi illum enim dolores quia. Facere minima aperiam ea qui dolores. Velit numquam et unde ullam consequatur minus illum.</p><p>Sint expedita esse et dolorem. Ab blanditiis voluptas enim a perferendis qui. Consequuntur voluptas corporis veritatis sunt consequatur.</p><p>Rem beatae sequi eos beatae molestiae. Reprehenderit qui doloremque dolor commodi. Sequi sed autem id occaecati voluptatem ut.</p><p>Et quia esse laudantium assumenda. Consequatur quod quidem ut. Ratione ducimus aut nesciunt eaque.</p><p>Rerum impedit aut debitis vero veniam excepturi. Sit qui deleniti corrupti eaque sed. Inventore dolore omnis quaerat quo dignissimos.</p><p>Aut facere consequatur aliquid eos et sed. Nihil ipsa officiis sit ullam perferendis fuga porro et. Tempore autem iste sit harum.</p><p>Voluptas asperiores dolorem ipsa molestias enim. Quasi explicabo ipsam ducimus sit tempore aliquid ut. Rem tempore cum est est sed.</p><p>Esse aut qui omnis velit. Fugiat explicabo doloribus quidem unde totam. Corporis vel dicta voluptas minima quasi.</p><p>Est atque nobis nisi vel amet. Praesentium eveniet laudantium aut ut quam. Dolores voluptate rem est rerum odio nisi. Tenetur pariatur atque aspernatur nulla.</p><p>Consequatur voluptatum fuga deserunt quisquam illum nihil. Voluptas hic quae est laborum magni magni qui architecto. Accusamus maiores nostrum reiciendis qui ad dolore voluptates.</p><p>Id cupiditate repellat temporibus qui impedit soluta. Accusantium ut fugiat nostrum repellat. Officia nesciunt ipsum rerum magnam perferendis sint. Et delectus repellendus ea. Hic aut qui voluptatem qui et enim quisquam.</p><p>Ipsam nesciunt aut dignissimos. Impedit aut aliquam aut quas numquam et vero earum. Est omnis officiis dolores.</p><p>Et consequuntur culpa qui cum deleniti a. Quia qui occaecati cumque quae ut quasi fuga. Odit molestias possimus fugit quos. Aliquid qui dolorem optio est sapiente.</p><p>Ratione incidunt odio optio sint. Ipsum ullam ipsam ea consectetur.</p><p>Odit dolor eveniet maxime consequatur voluptas debitis. Delectus autem ut vel ut ipsa modi totam. Eum cupiditate dolores in mollitia. Optio excepturi ipsam enim quam maxime fugit. Labore quam qui sunt quibusdam rem numquam.</p>', 'nulla-fugiat-temporibus-mollitia-et-ut-nemo', 6, NULL, 'thumbnails/', '[\"et\", \"pariatur\", \"culpa\"]', 'Cập nhật nội dung', '2024-11-05 21:33:01', '2024-11-27 08:15:41'),
('BV-140425-74519503-v67fc6aa22bfb0', 18, 22, 'Praesentium esse qui rerum et.', '<p>Commodi iure vero nisi quisquam tempora saepe. Dolores dignissimos nulla perferendis. Saepe et iure et et totam.</p><p>Itaque cumque autem quod. Facere temporibus nobis esse omnis ea. Qui eum ullam voluptatum.</p><p>Quos occaecati optio molestiae dicta sequi rerum voluptatum eum. Vitae tempore et qui quia eos iusto. Eos non possimus quas libero quasi. Rerum nihil ea maiores modi at.</p><p>Quis qui doloremque assumenda dicta accusantium. Dolorem omnis laboriosam ut consequatur consequatur ratione facilis sunt. Rem qui et ut quis. Quos quis vel enim pariatur velit delectus et rem.</p><p>Rerum et voluptatem nihil qui suscipit consequatur eaque ut. Id et a voluptas illo. Et reiciendis dolores eos aliquam quia perspiciatis a debitis.</p><p>Aut et reprehenderit rerum quisquam ab perferendis fuga nemo. Fugit sint quis vitae est repellendus iste voluptatem. Quis corrupti ut corrupti iusto consequatur ut.</p><p>Recusandae exercitationem inventore natus. Sunt voluptatem officiis laborum dolore facere cum quis. Modi in nobis repudiandae ipsum ea voluptate perferendis qui. Accusantium laudantium esse qui consequatur.</p><p>Dolore laborum et illo qui et illo. Et doloribus eum quia molestiae laborum minus recusandae. Aut eos quasi sit excepturi. Mollitia praesentium possimus impedit nihil.</p><p>Nisi cum quisquam quae non aut excepturi. Neque ex incidunt aperiam accusantium. Voluptatem ut dolorum voluptate. Voluptatem laudantium quis cum amet voluptates non et.</p><p>Nihil doloribus repellendus id inventore dignissimos. Quae officia molestias nemo sunt repellat aliquam laudantium. Magnam ad et et reprehenderit.</p><p>Officia ut culpa soluta necessitatibus consectetur. Excepturi earum asperiores omnis non. Aperiam nam adipisci fugit officiis tempore autem. Maxime vitae omnis praesentium est.</p>', 'praesentium-esse-qui-rerum-et', 7, NULL, 'thumbnails/', '[\"veniam\", \"tempore\"]', 'Cập nhật nội dung', '2025-04-05 14:16:31', '2025-04-06 10:43:29'),
('BV-140425-74519503-v67fc6aa22d71c', 18, 22, 'Dolorem dolor ut sunt ea.', '<p>Aut dolor sint blanditiis temporibus debitis nostrum minima. Ipsam voluptas delectus similique architecto amet et sint. Consequatur velit qui molestiae autem autem tempore sequi. Culpa non facilis deleniti cumque.</p><p>Aut sit est sed quia eaque delectus veniam. Magni amet rerum quis. Voluptatem a eligendi fugit laboriosam rerum quaerat.</p><p>Non minima sit alias ut quibusdam vero. Numquam quia voluptas fugiat accusantium. Ratione quia et enim aut et at et nesciunt. Dolorum accusamus enim molestiae et.</p><p>Dolorum officia adipisci laborum est dolore. Soluta quod nobis enim qui est corporis.</p><p>Rem vel accusantium enim ex rerum quod voluptatem. Vel quidem natus deleniti minima distinctio commodi voluptate. Ea qui non iusto repellat dolore impedit autem. Voluptatem eius voluptates ipsa et blanditiis quidem dolorum.</p><p>Quia nostrum repellendus est iure voluptas placeat. Quaerat magnam cumque non ut. Dolores atque dolor sed deserunt occaecati voluptas. Laboriosam iste incidunt consequuntur itaque labore et. Sequi aut inventore repellendus voluptate.</p><p>Architecto fuga dolor aperiam porro. Non in dolores quo. Incidunt est qui error laborum non ad rerum. Itaque maiores qui commodi expedita.</p><p>Beatae deleniti omnis sit officia sed corporis. Laboriosam quam autem dolores quia sit quibusdam deleniti sit. Delectus amet praesentium omnis doloremque sed. Esse odit repellendus et quia ipsum placeat.</p><p>Occaecati excepturi rerum ullam sequi. Ut alias ut odio velit repudiandae ratione a. Consequatur ea voluptates qui quisquam eligendi. Nemo et nihil ut sint.</p><p>Beatae voluptas aut a consequuntur dolores sunt fugit. Tempora ducimus optio voluptatem enim rerum dolorum.</p><p>Sequi unde amet suscipit architecto accusamus. Nam et tempore tenetur provident mollitia. Nihil quis nesciunt ipsam nihil molestias. Cupiditate id ut mollitia ab totam. Quia est ea vel aut aut illo.</p><p>Eum et non quae fuga asperiores illum error. Corporis aut in officia et sunt.</p><p>Asperiores accusamus debitis laborum nobis at sequi voluptate vel. Sint alias hic nam rerum. Rem et et provident perspiciatis animi possimus.</p><p>Debitis sapiente tenetur perspiciatis ut. Quae quia dicta illum similique vel neque. Illo et autem non.</p>', 'dolorem-dolor-ut-sunt-ea', 7, NULL, 'thumbnails/', '[\"dignissimos\", \"et\", \"eos\"]', 'Thêm thông tin mới', '2024-05-30 23:45:02', '2024-11-18 09:59:55'),
('BV-140425-74519503-v67fc6aa246379', 18, 22, 'Tenetur et nisi excepturi molestiae quas aut.', '<p>Dolor beatae deleniti ipsum voluptatibus impedit. Et facere odit atque rem tenetur labore impedit sunt. Laudantium incidunt ea sapiente. Et blanditiis eligendi labore.</p><p>Excepturi modi molestiae incidunt doloribus ut facilis. Et reprehenderit nihil perspiciatis. Quo voluptatem consequatur dicta sed quas.</p><p>Est nostrum sit consequuntur sunt laudantium. Hic sunt totam hic ratione ratione. Id quae eos ullam unde suscipit perspiciatis. Nemo ducimus et voluptas temporibus.</p><p>Quo recusandae vel soluta illum et aut. Porro impedit sunt placeat molestias similique maxime quis. Qui corrupti a ratione deleniti nostrum ut magnam. Ipsam repellendus odit ad dignissimos qui.</p><p>Quibusdam modi ipsa dolore corporis deserunt repudiandae aut. Perspiciatis blanditiis ipsa sit facilis. Magni aut est impedit facilis aperiam. Quam pariatur sed sint hic. Sapiente quasi rem aspernatur ut in mollitia inventore.</p><p>Recusandae hic ratione voluptatum facere est. Quidem minus dolores autem voluptatem animi facilis ea. Ut dolore ad dolore numquam perferendis.</p><p>Deleniti ad dolore ut aut quibusdam. Sapiente deleniti vel voluptatem et exercitationem. Minima sint sit nisi commodi veritatis vitae.</p><p>Libero et ea aliquid iure. Sit fugit enim consequatur. Ab iusto sunt esse et incidunt et.</p><p>Illum officia occaecati sit rerum deserunt. Rem quo et et necessitatibus. Qui molestiae molestiae laboriosam accusamus a ipsum non. Reiciendis dolorem dolor nihil quia.</p><p>Doloremque at alias eligendi fugit enim aliquam laboriosam sed. Delectus adipisci molestiae officiis soluta. Dolorem id eos maxime sint.</p><p>Architecto sint et tenetur expedita facilis et rerum tempore. Reiciendis commodi repudiandae molestiae et et et.</p><p>Quidem dolores autem laudantium. Soluta voluptas dolores reiciendis. Assumenda eum omnis fugiat consequatur voluptates ullam assumenda ut.</p><p>Vel et id sit velit. Consectetur rem doloribus voluptas voluptate. Ipsa iusto cupiditate totam saepe.</p><p>Qui excepturi blanditiis sapiente odit. Amet saepe praesentium incidunt earum. Modi voluptate ipsam quis libero quia ut excepturi. Iste incidunt nulla officia sint.</p>', 'tenetur-et-nisi-excepturi-molestiae-quas-aut', 7, NULL, 'thumbnails/', '[\"neque\", \"adipisci\", \"quia\"]', 'Thêm thông tin mới', '2024-08-19 10:29:00', '2024-09-14 21:20:34'),
('BV-140425-74974944-v67fc6aa2284ec', 47, 4, 'Optio mollitia reprehenderit enim iusto rerum modi tempora.', '<p>Et non officia aspernatur ad nostrum. Natus aliquid non repudiandae nisi. Eum porro recusandae repellendus consequatur amet dolor praesentium quibusdam. Ratione sed nostrum id aliquam animi eos temporibus.</p><p>Architecto natus ut eos nam voluptas soluta. Aliquam necessitatibus eum rem. Eos ea et adipisci temporibus architecto iusto iure. Adipisci et totam nesciunt velit sit.</p><p>Consequatur sit aspernatur omnis ut iure. Quia dolore ut odio quo. Aut omnis minus incidunt cupiditate et eum tenetur. Est quo nemo et quas et magni.</p><p>Non veniam quibusdam libero molestias explicabo nihil. Dolores earum soluta tempora id soluta delectus deleniti. Rerum architecto corporis architecto.</p><p>Provident nulla eos sint sunt. Aperiam sunt provident consequatur molestias reprehenderit velit.</p><p>Dignissimos cum ea enim aliquam sint molestiae. Sit dolor aliquid aut et modi optio est. Omnis accusamus consequatur quo nulla.</p><p>Quae doloremque inventore corporis eos occaecati voluptates quos. Exercitationem cumque iure laboriosam rerum. Sint iure non aspernatur aliquid et. Provident voluptatem qui ut architecto.</p><p>Et earum cum quis dolor doloribus dignissimos. Omnis esse quisquam qui enim consequuntur est. Doloremque ex occaecati eum iusto qui. Iste eum sed incidunt.</p><p>Cumque minima porro odio voluptas. Et id sunt voluptatem vero dolorum voluptas. Omnis quo enim ipsum ad maiores.</p><p>Omnis voluptate hic quidem voluptatem commodi. Quas quod reiciendis tenetur nesciunt voluptatum autem. Numquam molestiae fuga officiis ut non et. Nostrum perferendis tenetur et repudiandae dolorem voluptatem sapiente.</p><p>Quis maiores omnis officia fugiat provident quia. Doloremque rem iste ut magni voluptatibus. Eos accusamus in asperiores placeat inventore fuga eos. Vero ut magnam quis. Aliquid assumenda libero aliquid.</p>', 'optio-mollitia-reprehenderit-enim-iusto-rerum-modi-tempora', 2, NULL, 'thumbnails/', '[\"quae\", \"ab\"]', 'Sửa lỗi chính tả', '2025-01-08 10:34:48', '2025-03-14 06:57:24'),
('BV-140425-74974944-v67fc6aa2440f5', 47, 4, 'Voluptatem velit dolor maiores.', '<p>Sunt placeat explicabo animi provident tempore in. Necessitatibus hic odio voluptatibus inventore et architecto vitae. Incidunt quia eum error delectus similique ut quisquam quas.</p><p>Eaque aliquid dolorem dolores qui id quis. Quod tempora occaecati enim optio ipsa maiores. Eius repellat repellendus occaecati a.</p><p>Sunt beatae laudantium eligendi. Beatae dolorem suscipit aut omnis dolores quis. Nemo doloribus voluptatem repellat a nostrum officia veritatis vero.</p><p>Exercitationem iure eligendi blanditiis dolore. Porro occaecati cum eos reiciendis aspernatur aliquam facere dolores. Vero distinctio ut dolore. Delectus adipisci velit quia exercitationem repudiandae commodi quas sint. Sed et optio ad aut asperiores accusantium enim dolor.</p><p>Necessitatibus at odio pariatur sit. Cupiditate ea hic totam. Quidem velit et dignissimos nulla iure est.</p><p>Cupiditate est ratione consequuntur harum reprehenderit quibusdam. Qui aspernatur ullam et voluptas nam possimus. Sit aut voluptatum soluta ut assumenda modi. Ipsa officiis iure quaerat suscipit sit.</p><p>Et alias explicabo voluptatibus et aspernatur enim sed voluptatem. Quod deleniti est voluptas dolore suscipit id. Harum delectus sed fugiat facilis. Quia rerum porro ea velit quisquam soluta laudantium. Veniam eum autem est temporibus aperiam saepe.</p><p>Repudiandae adipisci incidunt molestiae ut. Aut et animi quo quia fuga. Non qui consequatur voluptatibus quo libero inventore dicta. Laborum rerum harum velit debitis laboriosam labore.</p><p>Ex occaecati et exercitationem molestiae aperiam itaque non. Consequatur nam excepturi id et dolores occaecati. Ducimus nisi enim numquam nostrum similique harum quis.</p><p>Et minus dolores iste ea adipisci. Vero maiores perspiciatis sit eos.</p><p>Rerum rerum sed sint repellat. Earum eos eum voluptatem aut. Eum voluptate unde sit voluptas rerum doloribus cupiditate.</p>', 'voluptatem-velit-dolor-maiores', 2, NULL, 'thumbnails/', '[\"sequi\", \"illum\"]', 'Thêm thông tin mới', '2024-05-12 23:38:40', '2024-10-14 18:46:14'),
('BV-140425-78159706-v67fc6aa23ae89', 13, 4, 'Qui voluptatum magni qui commodi.', '<p>Veniam dolor rerum ut ad quas. Necessitatibus dolorem vel libero amet velit. Nam nulla omnis optio sint aut sunt fugiat voluptates. Eum laboriosam ab hic magni ut ut qui magni.</p><p>Enim aut sit modi repellendus reiciendis. Expedita id eum et ea saepe. Quaerat corporis eligendi minima sint asperiores aliquid aut. Quia dolores ipsam dolore nobis qui cum magni. Autem ipsum quia sit debitis aut.</p><p>Aperiam natus numquam mollitia eos quae. Porro eum cumque aut voluptates. Ex non voluptatibus ut facilis delectus perspiciatis. Dignissimos ipsa necessitatibus modi. Qui quae eum natus nesciunt expedita.</p><p>Quis dolorem et est corrupti molestias id. Et aspernatur eum est quas deserunt quo dolores ad. Eaque pariatur ut est molestias atque sit nihil voluptatum.</p><p>Et natus in sit ut possimus. Est hic quos rerum officiis vitae animi eveniet. Corrupti rerum est nemo. Tempora recusandae blanditiis repellat vero saepe et et.</p><p>Ut accusantium maxime iste et et voluptates animi. Ea perspiciatis eaque aperiam cum consectetur quia ad. Illum delectus mollitia dignissimos omnis quia. Distinctio magnam culpa molestiae dicta.</p><p>Ut exercitationem quo maxime aut voluptate ex autem. Id et qui natus et praesentium a. Ut praesentium beatae eos dolorem tempore beatae.</p>', 'qui-voluptatum-magni-qui-commodi', 1, NULL, 'thumbnails/', '[\"rem\", \"fugit\", \"ipsam\", \"dolor\", \"et\"]', 'Sửa lỗi chính tả', '2024-06-27 21:09:09', '2025-03-01 00:40:34'),
('BV-140425-78159706-v67fc6aa24cae8', 13, 4, 'Illum pariatur ex praesentium dolorem.', '<p>Dolorum nostrum sunt neque maxime et. Reiciendis dolor voluptates in ratione iusto sed. Et debitis inventore sed et nam quia. Itaque et aliquid labore non minus quisquam voluptatem.</p><p>Culpa optio et minus veritatis labore quos cum. Voluptatum labore ut expedita hic repudiandae quae eos. Et incidunt ut et ad. Consequatur reprehenderit occaecati voluptates ex natus.</p><p>Fugiat reiciendis ut numquam corrupti tempora et. Ut molestiae expedita omnis aut rerum quo. A voluptate repellat cupiditate dolorum sint. Reprehenderit voluptatem expedita rerum magni non.</p><p>Asperiores ab porro eius quidem inventore et molestiae qui. Quasi laboriosam esse est qui. Itaque ullam eum et illo possimus quia sint est. Laborum aut consequatur consequatur hic vero corporis. Sit et odit quis nihil.</p><p>Hic non nemo vel in iste. Optio iste enim officiis atque ut vel. Facilis et est vitae possimus repellendus. In odit et aut omnis cumque possimus.</p><p>Quae delectus tempora eum at totam. Sit ex ullam sapiente molestiae aliquam. Voluptatem quo aut minima neque fugiat voluptatem.</p><p>Hic cumque et dolores deleniti. Necessitatibus autem ipsum qui sapiente.</p><p>Enim voluptatem culpa vitae voluptas. Provident et beatae non id aut officiis. Quidem nihil cupiditate quo in.</p><p>A doloribus sed cum aut. Reprehenderit provident quia voluptatem magnam. Similique aliquid possimus eaque perferendis accusamus. Cumque reprehenderit quaerat sequi similique quaerat.</p><p>Ratione ut accusamus tenetur enim. Ab qui hic atque quod. Ut soluta laborum autem amet repellat ad.</p><p>Adipisci eum praesentium voluptatum voluptatem. Ut autem molestiae hic perferendis adipisci pariatur quis. Et labore delectus eos. Ut in ipsum praesentium provident.</p><p>Fugiat qui harum harum unde qui pariatur velit. Aut veniam qui non necessitatibus possimus. Tempora sunt numquam totam nulla. Veniam repudiandae quo nulla cumque occaecati omnis recusandae.</p><p>Cupiditate repellendus quasi recusandae dicta. Quia qui beatae eligendi provident velit deserunt ab. Sit nostrum consequatur inventore aut vel officia. Dolorum ea ab est eum fugit velit tempore.</p><p>Doloribus dolorem recusandae magni vel quia facilis reiciendis. Laudantium sed consequuntur occaecati odio non voluptate quos dolore. Dolorem et perferendis et et ratione aut aperiam.</p>', 'illum-pariatur-ex-praesentium-dolorem', 1, NULL, 'thumbnails/', '[\"consectetur\", \"quasi\", \"id\", \"accusantium\", \"accusamus\"]', 'Cập nhật nội dung', '2025-01-17 05:13:18', '2025-02-06 21:55:58');
INSERT INTO `article_versions` (`version_id`, `article_id`, `user_id`, `title`, `content`, `slug`, `category_id`, `subcategory_id`, `featured_image`, `tags`, `change_reason`, `created_at`, `updated_at`) VALUES
('BV-140425-80162530-v67fc6aa227d6a', 45, 13, 'Id dolorem explicabo ea voluptas.', '<p>Commodi ea repudiandae soluta molestiae autem est. Laboriosam assumenda reiciendis tempore qui voluptas voluptate dignissimos. Et maxime reiciendis odit et aut quo aut. Enim quod autem dignissimos est.</p><p>Explicabo quaerat enim est aut voluptatem quo qui. Necessitatibus est et qui explicabo. Doloribus qui et voluptatem cupiditate non.</p><p>Officiis quia reiciendis commodi voluptas. Sed inventore laborum sit itaque. Aut porro unde iure dolorem facere. Nemo qui dolor commodi excepturi.</p><p>Aut labore suscipit consequatur et. Maxime et delectus et hic molestiae in quod. Mollitia ullam consequuntur consequatur voluptatem sunt eos officia.</p><p>Perspiciatis laboriosam magni eaque totam ipsam ut ducimus. Consectetur commodi veniam perferendis rerum enim modi aut perferendis. Qui placeat rerum suscipit in qui eveniet.</p><p>Voluptas consequatur harum quia. Qui est at laboriosam. Quod temporibus impedit quas et.</p><p>Ipsam vel autem similique unde reiciendis. Ea omnis labore minima totam dolor nobis. Corrupti voluptas pariatur atque repellendus nobis recusandae. Et qui natus ex sed est.</p><p>Eveniet necessitatibus doloremque quisquam dolores enim qui. Voluptates rem sed consequatur sapiente in alias. Sit nisi occaecati non numquam provident maxime fugit.</p><p>Eligendi quia facere similique. Voluptatum et necessitatibus vero et vero. Nemo itaque recusandae qui corrupti nostrum fugit et.</p><p>Provident dolorem nulla assumenda commodi. Similique ut similique blanditiis tempore aut. Est soluta veniam vel porro quibusdam nam. Quia velit ex est quis itaque sunt accusamus debitis. Et sapiente quia culpa vitae labore fuga sit.</p><p>Quo nisi accusantium sit optio non qui. Nihil dicta repudiandae ducimus qui quo rerum voluptatum. Aut natus quia iure voluptates libero autem quis. Earum provident autem corporis commodi.</p><p>Facilis qui repudiandae esse est asperiores molestiae. Autem sequi ea qui odio numquam qui. Dolorem commodi facilis ipsum exercitationem beatae voluptatem. Ut mollitia sapiente ea perspiciatis et. Nihil voluptatem voluptates vel porro dolorem autem repellendus ut.</p>', 'id-dolorem-explicabo-ea-voluptas', 10, NULL, 'thumbnails/', '[\"porro\", \"beatae\", \"voluptate\"]', 'Thêm thông tin mới', '2024-05-13 01:11:09', '2025-02-04 21:50:26'),
('BV-140425-80162530-v67fc6aa247a15', 45, 13, 'Et aut atque sint atque.', '<p>Veritatis excepturi eos aut nulla cum quia vel dolore. Quia aut officia assumenda consequatur. Laudantium tempora officiis rerum ut cum eos. Eaque eos et ullam eaque non.</p><p>Exercitationem laboriosam fugiat laudantium unde illum. Id qui necessitatibus porro odit optio iusto ex. Quisquam pariatur aut veniam perferendis veritatis libero.</p><p>Facilis ut nihil laborum. Eos est quibusdam nulla debitis quisquam quis. Vel voluptatem dolore vitae laudantium. Asperiores non repudiandae repudiandae.</p><p>Praesentium ut qui et et maxime. Ea dolorem id quibusdam ipsum impedit. Ratione quas laborum dolorem molestias.</p><p>Earum saepe optio voluptatum eum culpa sunt. Labore cumque quo eum asperiores eius dolore. Incidunt a voluptatem sed ea rerum.</p><p>Ad sint totam cupiditate magni officia velit nobis. Recusandae harum quaerat quibusdam dicta veritatis. Impedit reprehenderit expedita non veniam et suscipit.</p><p>Est enim est recusandae laboriosam qui laboriosam enim. Deleniti ipsum corrupti dolorum sed omnis culpa. Voluptatem et eligendi laboriosam.</p><p>Aut commodi error illo animi alias expedita. Ut earum eum non et molestiae blanditiis sed. Sequi et corrupti iste provident. Exercitationem laboriosam nisi hic in.</p>', 'et-aut-atque-sint-atque', 10, NULL, 'thumbnails/', '[\"soluta\", \"provident\", \"omnis\"]', 'Thêm thông tin mới', '2024-11-29 01:35:49', '2024-12-10 23:41:43'),
('BV-140425-80162530-v67fc6aa24f177', 45, 13, 'Et dolorem reprehenderit non consequuntur qui.', '<p>Facilis veritatis nostrum mollitia corporis praesentium sint. Nam perferendis aut ducimus fugit aut in quia aut. Beatae dignissimos voluptatem id qui molestiae labore in.</p><p>Vel optio in totam error aperiam perferendis facere quia. Voluptatibus vel est nihil sint. Magni illo dolorum vitae et esse fugiat. Alias error qui qui deleniti commodi eaque quae.</p><p>Quia nihil aperiam rerum non beatae omnis. Repudiandae quia ea commodi sint. Dolorem totam neque sint ducimus voluptate iusto.</p><p>Quia beatae debitis qui vel incidunt eveniet. Fuga sint dolores reprehenderit rerum magnam. Voluptatem quam temporibus aspernatur vel. Ut dolore eius nam sed quas tempora.</p><p>Libero pariatur vitae sit et. Numquam quas nulla qui id dolorem a. Rem provident et ut ipsum eos expedita sequi. Quibusdam optio enim commodi beatae itaque nobis et.</p><p>Quia id eveniet cum omnis veritatis sint. Aut libero quidem ea recusandae voluptas odit aut. Adipisci dolor voluptatum aspernatur et repudiandae dolore. Magnam sint quis debitis esse at et labore.</p><p>Et ut alias distinctio ipsum enim qui. Quas fuga necessitatibus qui autem. Illo iusto aliquid maxime cum. Est dolores voluptatum sequi.</p><p>Et qui vero ut molestiae sit laborum. Maxime culpa doloremque totam sit dolorum. Nam fugit consectetur quo iusto aliquam rerum temporibus in. Aut nostrum quasi voluptas odio dolores.</p><p>Ipsa odio ut ut. Id recusandae dolores officiis impedit quia cupiditate.</p>', 'et-dolorem-reprehenderit-non-consequuntur-qui', 10, NULL, 'thumbnails/', '[\"dignissimos\", \"facere\", \"atque\", \"esse\", \"ut\"]', 'Thêm thông tin mới', '2025-03-01 09:14:29', '2025-04-01 10:25:13'),
('BV-140425-80162530-v67fc6aa252456', 45, 13, 'Rerum autem beatae doloribus corporis aut aliquam.', '<p>Ut neque quos earum ducimus et distinctio tenetur perferendis. Distinctio consequatur dolore accusamus nostrum. Aut non magnam unde dolor assumenda temporibus quo.</p><p>Possimus atque dolorem fugit hic. Ullam laboriosam voluptate reprehenderit veritatis beatae hic. Deleniti occaecati nesciunt et praesentium iure et culpa. Ullam eius aut error optio nisi.</p><p>Dolor similique sapiente labore ut impedit et. Dicta sunt repellat dignissimos nisi consequuntur voluptatum. Qui consequuntur quaerat tempore ut soluta qui.</p><p>Ab et et aut ad autem nihil qui. Sed enim autem et minima. Impedit ipsam corporis consequatur est id voluptates. Temporibus unde et laborum reprehenderit ut eos.</p><p>Quidem incidunt error aspernatur voluptatem et necessitatibus ab autem. Culpa beatae explicabo illo dolores voluptatem. Consequatur sit laudantium animi facere. Fuga explicabo aut non cum fuga maxime incidunt.</p><p>Soluta harum atque maxime ut quia natus. Quibusdam consequatur ducimus inventore. Enim animi quod omnis debitis expedita sint vitae.</p><p>Cupiditate similique perferendis sed tempore hic eos molestiae. Omnis distinctio qui ut impedit praesentium veniam asperiores. Quia perferendis ex eius animi facilis ab nulla.</p><p>Maiores animi nobis est laboriosam. Et cum corporis et pariatur. Sint sed aperiam eius perferendis quas vel error aut.</p><p>Quibusdam nostrum molestiae nobis. Molestias est asperiores eos repellendus id veritatis odio. Officia veritatis neque consequatur qui.</p><p>Quo velit ad iusto sequi provident expedita ea aut. Ut impedit tempora ipsum magni odit.</p>', 'rerum-autem-beatae-doloribus-corporis-aut-aliquam', 10, NULL, 'thumbnails/', '[\"velit\", \"rerum\", \"est\"]', 'Cập nhật hình ảnh', '2025-01-13 16:03:48', '2025-02-24 17:37:44'),
('BV-140425-80624707-v67fc6aa2321bd', 12, 23, 'Velit eos excepturi sit.', '<p>Esse eum rerum distinctio autem. Id doloribus voluptatibus neque beatae rerum autem. Enim enim impedit officia sapiente et inventore. Eaque eaque sunt facere eum voluptates exercitationem.</p><p>Necessitatibus laudantium vel suscipit sunt. Consequatur minus tempore inventore aliquid. Quas rerum sit minus iure.</p><p>Qui molestias ipsam illum praesentium. Repudiandae recusandae et quia deserunt explicabo. Illum repudiandae modi nihil quia. Iure nam recusandae alias debitis placeat.</p><p>Animi velit et eum expedita. Omnis amet error quibusdam voluptatem quidem repellat expedita. Accusamus consequatur omnis et optio recusandae.</p><p>Et doloremque omnis voluptatem et. Et similique sunt id sunt deleniti. Deserunt voluptas amet omnis fugiat dolor nulla et. Nesciunt quidem minus consequuntur quaerat rerum quidem nobis.</p><p>Sequi non dolores nobis et odio. Dignissimos soluta omnis mollitia suscipit. Necessitatibus eum cupiditate quaerat. Nobis nostrum expedita fugit dolorem.</p><p>Accusamus reiciendis consequuntur velit. Alias quia deserunt est architecto deserunt consequuntur fugit. Optio quisquam impedit quidem unde id.</p><p>Dolores eum quia voluptatem quam porro in eaque. Voluptates dicta omnis quaerat minima. Tempore dolorem ad tenetur et fugit et quaerat. Dolores illum aut quaerat aut reprehenderit voluptatibus sint.</p><p>Veritatis cupiditate aspernatur et non nemo omnis qui. Quo quod maiores inventore vitae expedita sed accusantium. Accusantium at sed modi natus fuga nemo dolores. Dolores perferendis incidunt voluptatibus quae repellat possimus.</p><p>Voluptate et aut eos ipsa id unde. Optio a rerum sunt nulla ab. Voluptatum sed aliquam reiciendis perspiciatis consequatur id.</p><p>Magni blanditiis eveniet tenetur officiis quo rem quam. Libero eveniet soluta numquam quisquam. Saepe quisquam totam beatae dolore modi veritatis perspiciatis.</p><p>Qui sit eos et vel vitae. Voluptas consequatur consequuntur maiores minima.</p><p>Incidunt et accusantium nemo laborum. Voluptatum excepturi et facere sed.</p>', 'velit-eos-excepturi-sit', 9, NULL, 'thumbnails/', '[\"fugiat\", \"minima\", \"in\", \"id\"]', 'Thêm thông tin mới', '2024-11-27 20:35:52', '2024-12-18 12:53:38'),
('BV-140425-80624707-v67fc6aa235072', 12, 23, 'Aperiam et eum ad.', '<p>Ut ab natus in consequatur incidunt consequuntur doloremque. Eum provident mollitia praesentium non. Voluptas nesciunt quos fuga consequatur.</p><p>Libero eligendi tenetur saepe provident exercitationem. Laudantium et qui unde assumenda.</p><p>Velit sed rerum voluptatem illo. At et qui modi eius quidem exercitationem dolore. Quo dolores sint recusandae amet fugiat aliquid voluptatem.</p><p>Maiores beatae accusantium excepturi exercitationem. Excepturi debitis itaque quidem. Sit fugiat possimus quis in. Quibusdam autem facere aut illo aut ea veniam.</p><p>Rerum distinctio consectetur quam itaque. Sapiente similique neque a consequatur voluptates. Commodi voluptatem fuga possimus accusamus.</p>', 'aperiam-et-eum-ad', 9, NULL, 'thumbnails/', '[\"dignissimos\", \"dolore\"]', 'Cập nhật hình ảnh', '2024-08-14 23:00:39', '2024-09-25 02:11:17'),
('BV-140425-90550524-v67fc6aa22128c', 17, 13, 'Totam sequi voluptatem voluptates neque ipsa corrupti.', '<p>Et expedita ut earum. Quod numquam sint accusamus laboriosam. Vel et cupiditate neque ex voluptas dolores. Est temporibus rerum sed culpa et aspernatur.</p><p>Id rerum fuga exercitationem non magnam. Est corrupti nesciunt nemo maiores quo voluptate. Adipisci deleniti nobis nihil numquam optio sapiente incidunt. Dolor qui qui ut ducimus.</p><p>Esse qui nobis aut dolor dicta fugiat similique. Dignissimos aliquid unde ullam atque minus dolorum reprehenderit. Asperiores sit est nostrum sit dolore dolorum est. Eaque temporibus atque illo similique maiores.</p><p>Velit quisquam aliquid dolores consequatur deleniti esse id. Ab quod accusantium pariatur ad eveniet. In dolor alias sapiente sit quas incidunt. Qui et alias voluptas labore odio perspiciatis assumenda. Deserunt numquam illum cumque sint expedita ipsam.</p><p>Non sint voluptatem sapiente vero aspernatur. Praesentium aperiam eveniet eum ea accusantium suscipit enim. Est itaque eaque mollitia suscipit aliquam. Enim officia vero est itaque accusamus ut ullam deserunt.</p><p>Recusandae dicta quam sequi qui voluptate laboriosam quia commodi. Exercitationem accusamus pariatur sint nisi voluptatem. Quos non rerum eaque qui sequi. Tempora quia nisi est accusamus dolorem aut.</p><p>Commodi non quae voluptatem alias pariatur. Perferendis maxime quis molestiae explicabo corrupti excepturi. Optio corrupti cupiditate dolores minima autem doloribus rem.</p><p>Dolorem nisi ducimus omnis eveniet saepe nihil illum. Delectus officiis cupiditate quis nulla. Eos enim nisi laborum non sapiente. Veritatis vitae mollitia a nobis molestias sed.</p>', 'totam-sequi-voluptatem-voluptates-neque-ipsa-corrupti', 2, NULL, 'thumbnails/', '[\"illo\", \"sed\", \"est\"]', 'Thêm thông tin mới', '2024-06-09 23:55:05', '2025-02-24 13:19:50'),
('BV-140425-91419469-v67fc6aa22c6fa', 29, 23, 'Asperiores tempora vero neque omnis.', '<p>Omnis et eum consequatur aut quo unde. Omnis est sequi et corporis consequatur praesentium. Dolores et explicabo facilis labore magnam et.</p><p>Ut quaerat repellat velit ut ducimus omnis nesciunt. Et atque magni velit similique est veniam. Aut est rerum veniam pariatur quam commodi quos. Facilis dolores porro unde blanditiis. Ut ipsa molestiae hic labore.</p><p>Ab voluptatum et omnis. Adipisci nihil et facere sit quod nesciunt.</p><p>Ut ipsa quidem nihil accusantium. Voluptas inventore sed eos dolorem tempore. Sequi dolorem sint porro dolores doloremque. Iusto facilis sint et placeat et voluptas velit ea.</p><p>In est possimus enim omnis reiciendis. Minus reiciendis neque aut assumenda placeat deserunt veniam. Dignissimos facere dolore sint rem repellendus. Sunt rerum et omnis eos.</p><p>Cupiditate nostrum qui sunt id fugiat earum. Molestias accusamus fuga cumque sunt ut dolorem dolor. Ut sed excepturi fugiat magnam non alias alias. Est consequuntur atque enim aut ipsum.</p><p>Pariatur fugiat saepe et laudantium quia hic tempore. Quia delectus est totam et. Dolor officia nostrum qui accusantium voluptatum dolor. Dignissimos quod facere et nihil est eius incidunt.</p><p>Cumque placeat reiciendis consequatur reprehenderit porro nemo modi. Cupiditate voluptatem suscipit laboriosam. Ratione aspernatur omnis accusamus. Non fugiat laboriosam iusto autem et. Quis aliquid cupiditate et quis.</p><p>Aut nostrum praesentium non sunt voluptatem doloribus. Dignissimos ab velit excepturi numquam eos rerum quasi ratione. Voluptatem eum nostrum tempora sapiente dolor. Atque temporibus reiciendis ratione voluptatum recusandae.</p><p>Eos qui quia aliquid expedita ut. Delectus odio temporibus accusamus excepturi nihil. Et est nobis ex. Adipisci repellat possimus nulla neque maiores.</p><p>In ullam eos iste quia omnis ducimus illum non. Adipisci et iste et rem aut ut necessitatibus voluptas. Nihil quia qui cumque odit. Eaque a ut ipsum ipsa earum qui.</p><p>Occaecati voluptas eaque consectetur qui perspiciatis. Veritatis iste quia alias laborum facilis autem laudantium. Et sit ut assumenda eius officiis sunt. Qui aut veritatis alias culpa beatae recusandae numquam.</p><p>Ipsam eum deleniti tempora earum. Consectetur quasi id blanditiis et non autem laborum. Ab dignissimos aut eveniet eos vel.</p><p>Porro commodi ipsam nulla nam occaecati omnis at. Explicabo qui nisi magni eveniet ut ad. Perspiciatis sequi ullam odio. Dignissimos sit ut omnis nostrum non velit suscipit.</p>', 'asperiores-tempora-vero-neque-omnis', 10, NULL, 'thumbnails/', '[\"non\", \"excepturi\"]', 'Cập nhật hình ảnh', '2025-02-11 01:44:47', '2025-02-15 02:51:00'),
('BV-140425-91419469-v67fc6aa2381ad', 29, 23, 'Modi optio eos est maxime ex incidunt.', '<p>Dolores quae aut et. Esse sequi sed blanditiis accusamus et nulla. Pariatur deserunt dolorem tempora voluptatem ab.</p><p>Architecto et sit distinctio. Et quaerat et a. Sed iusto quia laborum totam maxime.</p><p>Qui officiis quis alias. Non temporibus sint perferendis voluptas molestiae et. Illo quo deleniti ut sed. Veniam deserunt dolor doloremque ut cum dolorem. Impedit eum incidunt aspernatur qui nihil qui nulla.</p><p>Quod quas iste eligendi repellat quia. Et est consequatur laborum sunt ullam nihil sed atque.</p><p>Enim porro porro laboriosam pariatur. Quia eos et ducimus dolores inventore. Dolor quia nam eum et pariatur aut.</p><p>Voluptas qui iusto suscipit minus. Quam modi ullam commodi maxime placeat et. Ut esse fugit ut et et nisi. Corporis dolores odit recusandae id reiciendis possimus illo.</p>', 'modi-optio-eos-est-maxime-ex-incidunt', 10, NULL, 'thumbnails/', '[\"voluptatem\", \"ipsam\", \"magni\", \"excepturi\", \"praesentium\"]', 'Thêm thông tin mới', '2024-08-08 20:04:18', '2024-08-31 14:32:51'),
('BV-140425-91419469-v67fc6aa249452', 29, 23, 'Asperiores magnam ipsam quia reiciendis nobis omnis aut.', '<p>Aperiam est qui quo voluptatem reprehenderit. Omnis tempora explicabo aperiam iusto voluptate eos reprehenderit. Sit ut esse quia praesentium voluptas sint. Voluptatem aut ullam ut incidunt magni.</p><p>Accusamus dignissimos qui velit est culpa impedit. Ipsam ut veniam doloremque. Atque quia optio repellat et laboriosam qui architecto. Nulla quia et fuga architecto.</p><p>Delectus aut deleniti maxime fugit. Vel doloribus sed et laboriosam sunt aliquid nobis.</p><p>Ut dicta nobis eum aut qui omnis doloribus. Eum et iste vel consequatur corporis reiciendis.</p><p>Accusantium optio voluptatem voluptatum voluptatem deserunt ullam et quia. Saepe ut officiis rerum consequatur sit. Id illo rerum sit molestiae sed facere. A dicta eum et et rerum tempora quos.</p><p>Et enim vitae quia quis voluptatem sed dolores rem. Quis sunt optio praesentium dolor iusto vero. Dolores praesentium vel nulla provident non nulla.</p>', 'asperiores-magnam-ipsam-quia-reiciendis-nobis-omnis-aut', 10, NULL, 'thumbnails/', '[\"non\", \"minima\", \"ipsa\", \"nemo\"]', 'Thêm thông tin mới', '2024-08-01 05:36:25', '2025-03-19 06:53:49'),
('BV-140425-91893598-v67fc6aa229c60', 49, 4, 'Vero aspernatur tempore tenetur dicta.', '<p>Rerum accusamus reiciendis ut facilis tempore. Omnis non vel nihil facere quo harum. Ipsum iure aut nulla laborum delectus similique. Incidunt dolorem et eum itaque. Doloremque voluptatem distinctio earum ut voluptatibus deleniti laborum.</p><p>Vel nihil eligendi voluptates quod maxime pariatur. Libero velit suscipit totam iure et corporis earum. Ex inventore omnis fuga reiciendis. Autem beatae impedit accusantium similique accusantium fugiat.</p><p>Modi iusto autem nostrum rerum fuga. Officiis et cumque fugit laudantium facilis. Modi aut qui dolor sint suscipit. Quaerat fuga unde incidunt.</p><p>Quasi vel quod consequatur qui voluptatem adipisci. Qui inventore dolor saepe temporibus. Quis qui molestiae sunt adipisci similique tenetur dolore. Autem ab sit est velit.</p><p>Voluptas veritatis eveniet consectetur. Impedit molestiae architecto esse velit. Rerum perferendis qui sed quia.</p><p>Doloribus et repellat est. Soluta neque saepe et nulla. Qui rerum sed animi unde debitis nulla sed. Aut qui non est veniam.</p><p>Est maiores ratione beatae officiis porro eaque eveniet. Debitis tenetur dolor dolore non quia. Et voluptatem molestiae quam accusamus cumque. Esse qui ut ea.</p><p>Eius facilis cumque corrupti incidunt voluptas vitae enim corporis. Molestiae minus qui voluptatum quia totam assumenda. Explicabo quam est non quia. Cumque tempore doloribus accusantium atque delectus.</p><p>Sunt accusamus voluptatem eum natus reprehenderit consectetur veritatis ut. Odit nulla ex eum tempora molestiae unde ex.</p><p>Fugiat voluptatum iusto est enim eum. Enim molestias asperiores suscipit debitis est quia aut sint. Molestias adipisci quos ipsum modi laboriosam exercitationem. Eaque eveniet voluptas sed quibusdam reiciendis temporibus.</p><p>Ex eos molestiae eos aut. Ipsum qui quasi et sit.</p><p>Doloribus dicta recusandae enim ut et at. Impedit qui repellat et.</p>', 'vero-aspernatur-tempore-tenetur-dicta', 2, NULL, 'thumbnails/', '[\"possimus\", \"voluptatem\", \"consequatur\"]', 'Cập nhật nội dung', '2024-08-30 03:39:00', '2024-11-03 02:46:04'),
('BV-140425-91893598-v67fc6aa23572c', 49, 4, 'Natus fugit sit impedit.', '<p>Aspernatur ratione odit ab ullam. Nobis iusto officiis quas nihil laboriosam. Laborum itaque dolor dignissimos fuga at enim et. Sint iusto magni magni perferendis non.</p><p>Sit incidunt dolorem adipisci aut natus nam. At temporibus sed quo dolorem possimus reprehenderit. Commodi sunt quaerat libero tempora nulla. Aliquam repellendus nihil non omnis molestiae inventore ut.</p><p>Accusamus consequatur soluta quo maiores sed fuga maxime. Consequatur vel dignissimos ducimus et numquam quia. Aut eos voluptates ea assumenda deserunt soluta itaque id. Necessitatibus vel in debitis eum odit molestias qui.</p><p>Inventore quisquam eos fugiat sapiente labore vel itaque. Sed voluptas quaerat id necessitatibus exercitationem veritatis. Magnam nihil iure architecto totam voluptatem.</p><p>Perspiciatis earum qui velit et autem non praesentium. Rem blanditiis laudantium omnis quaerat aut nostrum omnis aut. Temporibus qui omnis et et. Quos qui est omnis fuga alias doloremque.</p><p>Molestias et tempore odit cupiditate illo dolore. Perferendis quia laudantium nisi eum sit distinctio aperiam. Iure voluptates ipsa ipsam tenetur in.</p><p>Ullam blanditiis ducimus veniam consequatur quis. Perferendis esse fuga tempora dolores. Quidem quam quo modi et totam. Doloremque incidunt ut consequatur voluptate.</p><p>Autem ullam voluptatem a sunt et dolores commodi. Labore quia rem quia ratione. Suscipit facilis ad facere perspiciatis est quod qui. Id quasi ullam voluptate aut laboriosam deleniti. Occaecati sunt aut rerum libero nemo sit voluptas quia.</p><p>Eaque enim corporis cum et quod. Dolor nobis quos odit inventore aut praesentium facilis commodi. Porro quam quidem id qui voluptate quia perspiciatis. Reprehenderit quo consequatur qui dolorum.</p><p>Sit ut suscipit accusantium reprehenderit. Nisi et eius maxime earum. Maxime nisi sit impedit quaerat cum magnam. Amet excepturi molestiae rem non qui et.</p><p>Iste a dolor quasi dolor. Aut assumenda architecto ut numquam provident. Consequatur eum aut eum totam. Esse rerum harum facere porro quam consequatur facere.</p>', 'natus-fugit-sit-impedit', 2, NULL, 'thumbnails/', '[\"molestias\", \"officiis\", \"porro\", \"aut\", \"mollitia\"]', 'Cập nhật hình ảnh', '2025-01-19 17:13:50', '2025-03-16 22:44:18'),
('BV-140425-91893598-v67fc6aa24bdfc', 49, 4, 'Et ut minima qui vel velit.', '<p>Eum aliquam voluptatibus molestiae ipsum voluptatem aliquid. Corrupti et fuga voluptatibus quis ut. Voluptatem laudantium sed consectetur maxime.</p><p>Quia dignissimos officiis ut explicabo facilis nobis. Dolor voluptatem aut aliquid est autem. Autem ut est delectus voluptatem et praesentium.</p><p>Porro esse possimus autem illum iure. Nihil eum nam qui temporibus libero. Debitis perspiciatis praesentium voluptatum odio doloribus reprehenderit.</p><p>Fugiat eos error corrupti corrupti possimus accusamus illo. Eius quisquam aspernatur ut vel quia. Enim sint officia mollitia laboriosam occaecati voluptatum. Rerum culpa alias nam corporis molestiae quia delectus qui.</p><p>Architecto rem accusamus perspiciatis. Dolores autem qui at maxime illo. Deleniti totam consequatur consequuntur voluptatem maxime ducimus ut.</p><p>Libero suscipit nobis doloribus aut fugiat. Dolorem laudantium rerum voluptas dolorum magni architecto dolorem. Voluptas sapiente nemo reiciendis sit fugit.</p><p>Enim ex aut dolorem laborum voluptatem recusandae quos veritatis. Necessitatibus fugit et laboriosam expedita minus. Non sit modi sed quod reiciendis voluptas similique vel. Impedit amet voluptas beatae dicta nulla.</p><p>Numquam voluptas nam commodi ut. Sed inventore quos corrupti iste. Culpa aliquam ipsam dolores nam.</p><p>Fuga debitis temporibus qui harum dolores. Facilis hic ducimus aut corrupti expedita. Est minima sed soluta praesentium rerum nobis dolores itaque.</p><p>Error est reprehenderit dicta dolores. Est et deleniti molestiae vel molestiae ea. Excepturi voluptatem dolores eum assumenda. Sequi quod laborum deserunt autem consectetur.</p><p>Hic et sed rem velit quia repellat aut velit. Tempore deserunt sunt est vel.</p><p>Harum corrupti omnis tempore id. Expedita voluptatem ea est eaque. Dolore deserunt inventore nobis exercitationem eaque laboriosam dignissimos.</p><p>Veritatis autem aut facilis non eos eum qui. Ducimus velit praesentium consectetur veniam. Ratione et earum dolorem qui.</p><p>Asperiores doloremque voluptas dicta. Eos quidem qui odio error fugit assumenda occaecati. Sint qui sint qui sunt adipisci iure dolores unde.</p>', 'et-ut-minima-qui-vel-velit', 2, NULL, 'thumbnails/', '[\"repudiandae\", \"est\", \"omnis\", \"vel\", \"quibusdam\"]', 'Sửa lỗi chính tả', '2025-01-18 07:45:43', '2025-04-05 09:21:22'),
('BV-140425-92348903-v67fc6aa226857', 32, 16, 'Tempora mollitia quo et et et voluptatem.', '<p>Sit sunt est enim reprehenderit voluptates. Repellat nam debitis ut quam. Eius consequatur consequatur iure quo at minus. Facere qui et repudiandae aliquid.</p><p>Assumenda explicabo dolorem eum. Qui voluptatem minus ea minima. Nesciunt molestias nisi alias et vel occaecati. Error dolore sed rerum nisi culpa voluptas. Accusamus voluptas voluptatem odit molestiae voluptate illum.</p><p>Beatae nihil ut hic consequatur. Ab reiciendis doloremque laborum exercitationem dolorum. Nesciunt est suscipit perspiciatis voluptatum quia corporis. Quia consequuntur deleniti quas dolore. Et fuga totam cumque beatae.</p><p>Repellendus ut dolores iste numquam voluptas eaque. Ab aut neque non cum nam quia. Ratione architecto sit rerum ab officiis illo. Est architecto ea ut ad.</p><p>Voluptatem tempore ut cum quis ipsum. Iusto fugit magni at deleniti autem expedita. Aspernatur et enim sed quasi est. Nostrum consequuntur laboriosam fugiat iure culpa animi. Fugiat non aut culpa aut veniam sunt nisi.</p><p>Ab corrupti temporibus sunt ad assumenda nam rem. Molestias est ut dolorem dolorem at qui pariatur. Labore culpa est facilis aspernatur nesciunt reprehenderit.</p>', 'tempora-mollitia-quo-et-et-et-voluptatem', 9, NULL, 'thumbnails/', '[\"consequatur\", \"rerum\", \"nisi\"]', 'Sửa lỗi chính tả', '2024-10-12 12:42:59', '2025-03-17 23:23:06'),
('BV-140425-92348903-v67fc6aa22e5c1', 32, 16, 'Adipisci cumque rerum explicabo porro molestiae.', '<p>Iusto eum ut quidem quia adipisci perspiciatis voluptatibus. Delectus vero id rerum. Ducimus vitae et aperiam ducimus inventore.</p><p>Et non officia ea illum in ea sequi. Maxime rem vero id et.</p><p>Sed aut provident sed hic velit. Error eum ut ut. Nam nisi quidem sequi repellat molestiae assumenda. Eum velit sit natus ea. Explicabo porro rem dolor in excepturi fugiat consequatur.</p><p>Sapiente sint vero eveniet nemo et dolor. Consectetur porro quas sunt nulla. Quaerat autem suscipit sit necessitatibus. Laudantium ut qui aut beatae dicta occaecati.</p><p>Laboriosam eligendi vitae consequatur sed. Doloremque sed exercitationem illum ut. Culpa beatae aliquam sit ipsa voluptatem dolorem. Suscipit quia eum dolores sunt perferendis voluptatem.</p><p>Voluptatum qui exercitationem reiciendis enim dicta. Nesciunt dolor atque impedit sed odit quidem hic nesciunt. Inventore totam maiores et placeat quasi maiores iusto voluptatem. Placeat qui ea commodi error.</p><p>Officiis cupiditate dicta adipisci tenetur eum. Ut non voluptas ipsum praesentium quia repudiandae. Deleniti et omnis consectetur officiis aut alias quibusdam.</p><p>Ut iure occaecati tempora iste quo. Inventore alias cupiditate ut facilis modi vel eius.</p>', 'adipisci-cumque-rerum-explicabo-porro-molestiae', 9, NULL, 'thumbnails/', '[\"iure\", \"quam\"]', 'Sửa lỗi chính tả', '2024-05-26 07:44:42', '2024-12-21 15:57:41'),
('BV-140425-92348903-v67fc6aa2365e5', 32, 16, 'Aperiam nam non voluptatem corporis et recusandae vitae.', '<p>Minima vel eveniet dicta. Non omnis consequatur quia facilis sit sit. Officia omnis soluta harum odit voluptatem recusandae eum. Fugit magni aut earum quis sit autem.</p><p>Et rem magni ipsam. Sed nam asperiores voluptas doloribus possimus architecto harum ex. Neque rerum eum itaque qui in.</p><p>Voluptatibus at quaerat rerum quia. Et dolorem eum suscipit qui dolorem. Neque incidunt quidem exercitationem commodi aut quos quidem omnis.</p><p>Pariatur ut totam consequatur sit dolorem perferendis neque. Est similique consequatur neque corporis accusamus aperiam quos. Placeat eius nobis sapiente eius necessitatibus accusamus voluptate. Voluptatem ipsa numquam temporibus.</p><p>Omnis sit quia quo quo quae. Pariatur omnis voluptatibus ipsam quia similique ab voluptatem. Rerum voluptatem iure dolorum quis. Cupiditate enim eius quibusdam cum laboriosam quibusdam ullam. Sapiente fuga dolorum et porro maxime est.</p>', 'aperiam-nam-non-voluptatem-corporis-et-recusandae-vitae', 9, NULL, 'thumbnails/', '[\"debitis\", \"ex\", \"est\"]', 'Sửa lỗi chính tả', '2024-12-03 05:51:04', '2025-02-23 14:10:31'),
('BV-140425-92348903-v67fc6aa24548a', 32, 16, 'Consectetur numquam deleniti est illum.', '<p>Rerum in nisi excepturi et consequatur rem voluptatum. Nam sint culpa temporibus nobis minus doloribus. Facere dolorum laudantium inventore consequatur omnis.</p><p>Officia atque ad consequatur occaecati corporis dolorem. Id minima delectus exercitationem eligendi esse voluptatibus. Rerum quidem qui voluptas illum molestiae. Inventore quia cupiditate esse dolorem et. Vel quaerat debitis fugit maiores voluptas.</p><p>Ea qui labore ullam quo et facere rerum. Voluptas non doloremque earum maiores. Quis dolore voluptas neque nesciunt earum illum qui. Rerum sed amet quia aspernatur commodi.</p><p>Et et et nam quo fugiat. Possimus autem sint dignissimos nisi doloribus qui optio debitis. Accusamus cupiditate voluptatem odit suscipit consequatur molestias. Odio odio adipisci rem ut voluptas nemo. Occaecati qui non qui.</p><p>Sit sit recusandae atque ipsum ut. Minima labore veritatis earum et. Nesciunt necessitatibus ut nihil quisquam et autem sapiente. Voluptates et facilis nobis veniam officiis est beatae.</p>', 'consectetur-numquam-deleniti-est-illum', 9, NULL, 'thumbnails/', '[\"culpa\", \"ex\", \"quod\", \"ullam\"]', 'Sửa lỗi chính tả', '2024-08-15 23:52:29', '2024-09-25 14:22:04'),
('BV-140425-92348903-v67fc6aa24ab43', 32, 16, 'Voluptas quis eligendi exercitationem itaque eum labore.', '<p>Dolorem doloremque quaerat commodi nihil harum. Repellendus necessitatibus dignissimos fuga blanditiis id unde alias. Est rerum ad aut dolore. Rem laboriosam explicabo consequuntur voluptate blanditiis.</p><p>Nisi occaecati earum aliquid accusamus amet. Voluptas eos qui enim eaque molestiae exercitationem. Facilis occaecati est eveniet aut inventore modi maxime.</p><p>Ullam exercitationem pariatur quia omnis neque. Libero beatae maxime libero dolor mollitia.</p><p>Totam est officiis enim ad consequuntur. Ea et et itaque quia similique. Unde autem delectus temporibus et quo aperiam et est.</p><p>Numquam ea iure aut doloribus nostrum. Voluptatum rem quo in architecto vitae sequi. Id excepturi ut qui sint.</p><p>Beatae consequatur doloribus molestiae rerum dolores sed vel. Omnis ut maiores eum culpa at labore. Impedit quasi eos odio velit.</p><p>Eos qui officia voluptas nobis ipsum. Nam nihil sit dicta dolore architecto nesciunt. Blanditiis id molestias et eum esse natus. Est cupiditate dolore eum rerum. Iusto qui fugit et ullam eius ad impedit.</p><p>Aliquam impedit qui eius optio velit. Et sapiente ab error porro. Sapiente non odio perferendis non quia. Optio modi sed unde a repudiandae nulla ea.</p><p>Illo voluptas sed rerum est similique. Harum omnis dolor omnis in voluptate recusandae quaerat. Ad et similique deleniti tempore officiis dicta suscipit enim. Aliquam possimus officia consectetur assumenda ratione et. Nulla earum aut dignissimos illum harum ea.</p><p>Nam ratione cum et in. Ex debitis quia voluptatum qui. Ipsam rerum nisi dolorum eius amet aperiam.</p><p>Vitae laborum sunt ad et eos non. Omnis delectus consequatur culpa aut velit. Ipsam iusto saepe tempora rem tempora. Ad labore aut magnam labore.</p>', 'voluptas-quis-eligendi-exercitationem-itaque-eum-labore', 9, NULL, 'thumbnails/', '[\"quisquam\", \"quasi\", \"architecto\", \"hic\", \"asperiores\"]', 'Sửa lỗi chính tả', '2024-06-16 07:33:54', '2024-09-16 17:59:06'),
('BV-140425-93009403-v67fc6aa248c86', 48, 16, 'Ipsam omnis cum voluptatem.', '<p>Quia accusamus rerum fugit culpa commodi ut vitae. Et libero ad velit quo quisquam quo. Quaerat architecto voluptate dolore maxime veritatis qui dolore. Esse voluptatem porro accusantium excepturi quia ullam.</p><p>Recusandae sed veritatis enim ducimus. Reprehenderit omnis error ad eius sunt.</p><p>Autem consequatur ut amet reprehenderit incidunt voluptates exercitationem ab. Corrupti iure beatae qui corrupti odit magni. Illo odit earum ea itaque velit.</p><p>Qui qui quod dolorem inventore. Sit facere soluta nihil sapiente qui sapiente. Esse sed quam quisquam voluptas vel ea ea.</p><p>Dicta occaecati dolorem omnis. Temporibus deleniti cumque tempore amet dolor dolorem inventore. Officiis esse numquam corporis inventore earum possimus unde.</p><p>Possimus amet et dolorem aut autem consectetur velit. Dolore ipsam consequuntur id sapiente dolor ducimus vero. Dicta voluptatem aliquam nobis ut sint rem vel. Distinctio dolores laudantium cumque et.</p><p>Est quia consequatur et molestiae est eveniet ex. Aliquam beatae et praesentium aut qui. Id omnis qui aliquam eum non. Error repellendus architecto et porro est debitis quidem.</p><p>Eos voluptatem maxime corrupti voluptatibus repellendus possimus. Similique repudiandae laborum repellat.</p>', 'ipsam-omnis-cum-voluptatem', 8, NULL, 'thumbnails/', '[\"vero\", \"necessitatibus\"]', 'Tạo bài viết mới', '2024-05-14 09:34:52', '2024-06-16 15:21:56'),
('BV-140425-93009403-v67fc6aa24d548', 48, 16, 'Est nobis blanditiis quae et aut facere qui.', '<p>Dolorem consequatur quae alias quod et labore dolores. Neque veritatis voluptatem eligendi mollitia aut rem.</p><p>Beatae ut quos harum commodi nobis veniam illo eligendi. Est impedit voluptas architecto veniam. Et rerum sed recusandae dolor ab reprehenderit dolorum.</p><p>Accusamus reprehenderit quia alias omnis possimus magnam. Saepe dolorem aut reiciendis et. Earum assumenda perspiciatis nam soluta assumenda quos nesciunt.</p><p>In quia omnis voluptatem numquam. Consequatur itaque aut veniam eius nesciunt voluptatem. Voluptatum maiores sed voluptatem non expedita ut. Tempore cupiditate eum odit sit eos at iure.</p><p>Voluptatum eos quia id et enim. Similique sapiente ratione et voluptatem. Et magnam veritatis corrupti tempore et quia. Mollitia ipsam non maxime quo qui blanditiis.</p><p>Alias ex natus natus soluta qui illo fuga. Harum quibusdam consequatur temporibus aliquam est aliquam aut.</p>', 'est-nobis-blanditiis-quae-et-aut-facere-qui', 8, NULL, 'thumbnails/', '[\"tenetur\", \"et\", \"aut\", \"quaerat\"]', 'Cập nhật hình ảnh', '2024-06-10 07:19:12', '2024-08-23 01:18:17'),
('BV-140425-94470396-v67fc6aa2312c6', 19, 22, 'Aut neque perferendis molestiae.', '<p>Tenetur quas voluptas enim quos perspiciatis sed. Repudiandae similique omnis quaerat iste illum vero maiores dolorem. Molestias voluptatum vel nemo maiores deserunt. Veniam quia sit molestiae laudantium et.</p><p>Ipsum velit aut nulla exercitationem. Reiciendis ducimus nihil qui enim. Beatae nisi omnis voluptas animi non distinctio. Rerum id veritatis accusantium assumenda quia mollitia vitae omnis.</p><p>Nobis assumenda ut eum qui aperiam amet perferendis. Dignissimos non qui at fugiat. Aut voluptatem pariatur vel voluptas dolorem officia. Error et recusandae eius perferendis eos.</p><p>Ut ea facilis officiis inventore. Et blanditiis reprehenderit sapiente necessitatibus nam exercitationem. Commodi minus ut voluptatem ab vel voluptatum.</p><p>Voluptas dolorem aut quos vitae autem aspernatur. Voluptatem temporibus sed ea omnis. At eos libero accusamus et. Quas esse aut numquam similique aliquam est.</p><p>Aut voluptatem perspiciatis at ut aut a vitae. Cupiditate dolorem in animi eligendi aut quia. Sed in repellat dolore aut eaque. Quis ipsum asperiores nam voluptas dolore.</p><p>Et est dicta et unde. Pariatur autem expedita aut possimus eos velit qui rerum. Sit sequi molestiae hic consectetur error veritatis consequuntur.</p><p>Magni iusto sint explicabo porro eius sed occaecati. Qui assumenda modi qui sed illo. Qui eaque aliquam tenetur magnam distinctio minus expedita.</p><p>Quibusdam voluptatem molestiae hic deserunt enim saepe quia. Distinctio commodi aut debitis nostrum voluptatem non exercitationem. In dolores consectetur dicta. Quis autem aut nihil autem.</p><p>Vel autem vitae atque quae fugit vero soluta. Beatae excepturi aut animi magnam. Soluta sequi non qui et.</p><p>Aut neque libero consectetur et. Laudantium id sit aut non natus voluptas ratione veritatis. Veritatis est fugiat est laborum quis.</p><p>Placeat quaerat dolores est praesentium architecto. Eum vel voluptates eum omnis impedit enim ex. Quos error laborum omnis aut dignissimos unde. Ipsam autem magnam quaerat dolore doloremque maiores dolorum.</p><p>Iusto omnis similique est enim. Ab illo amet possimus animi illum.</p>', 'aut-neque-perferendis-molestiae', 8, NULL, 'thumbnails/', '[\"reprehenderit\", \"sit\", \"maxime\", \"inventore\"]', 'Cập nhật hình ảnh', '2025-01-20 22:10:00', '2025-03-05 09:14:28'),
('BV-140425-95408680-v67fc6aa22a3ca', 38, 7, 'Cumque consequuntur ducimus debitis nemo odit beatae.', '<p>Odio vero optio rerum illo aspernatur qui. Dolore dolorem iusto numquam sed. Sed doloremque eos dicta mollitia quia. Beatae perferendis numquam hic hic.</p><p>Nostrum doloremque sint enim qui fugit. Et eos dolor et hic voluptatem nulla autem. Et minus necessitatibus vel consequatur optio quibusdam.</p><p>Voluptatem repellendus optio sint. Ipsam aut sit corporis unde pariatur dolorum aut. Hic consectetur minus tenetur hic consequatur nulla rem. Vel ut molestiae omnis laboriosam incidunt omnis amet saepe. Ut numquam incidunt quaerat reprehenderit molestiae alias ea.</p><p>Accusamus quis corrupti non explicabo eligendi sed nesciunt reprehenderit. Molestias deleniti sed recusandae libero distinctio.</p><p>Culpa saepe eaque eum quo ipsum ipsum aliquid magni. Eos a non ut aut quos. Sequi laudantium et rem dolore assumenda maiores et nihil.</p><p>Est maxime nihil accusamus ad quia voluptas aut rerum. Officiis ea quod amet ullam hic. Quia eaque ut dolor et distinctio nihil et et. Nihil rerum unde rerum voluptatum occaecati doloribus in.</p><p>Consequatur voluptatibus totam quaerat aut nemo. Culpa sequi et autem laudantium hic. Aliquid iure omnis harum rerum quod quo et.</p>', 'cumque-consequuntur-ducimus-debitis-nemo-odit-beatae', 6, NULL, 'thumbnails/', '[\"nam\", \"architecto\", \"qui\", \"distinctio\"]', 'Thêm thông tin mới', '2024-07-04 00:54:18', '2024-12-19 11:42:13'),
('BV-140425-95408680-v67fc6aa233862', 38, 7, 'Voluptatem qui omnis consequatur incidunt.', '<p>Delectus adipisci cupiditate architecto eos eius pariatur numquam iusto. Ut aspernatur architecto reiciendis quia minima maiores odit voluptatem. Possimus animi possimus quis et aut cupiditate. Dolores officia ab doloribus aut dolorem itaque.</p><p>Suscipit delectus unde nam et eaque modi dolorum. Magni distinctio sit quaerat placeat. Doloremque inventore architecto fugit recusandae error doloribus dolorem sint. Animi quia qui et et molestias veniam debitis.</p><p>Reprehenderit deserunt eveniet ut accusamus. Sint vero unde repellendus libero. Rerum temporibus ipsam magnam et illo. Est culpa labore sunt pariatur et consectetur rerum sequi.</p><p>In eveniet qui tempore et ea et cumque. Aliquam ut et et culpa molestiae qui. Et recusandae numquam ut. Soluta blanditiis in amet et.</p><p>Est dolores quasi iusto velit aut. Quis itaque quia dignissimos pariatur qui. Consequatur sunt nam quia. Repellendus repellendus soluta itaque architecto voluptatem qui. A consequatur distinctio ut.</p><p>Voluptate in molestias molestias culpa. Fugit esse quis ut et maiores ratione. Et ut rerum accusamus incidunt impedit suscipit nihil.</p><p>Dolores beatae enim repudiandae omnis. Perferendis distinctio rerum nesciunt pariatur molestias. Exercitationem in nihil beatae numquam temporibus velit perferendis. Impedit voluptas nihil sit molestias. Adipisci eius rerum omnis libero dolores aliquam.</p><p>Aut occaecati beatae incidunt tempore velit magnam. Consectetur facere qui est. Deleniti eveniet impedit atque exercitationem. Et non unde voluptatem ipsum aut est enim.</p><p>Id illum dolor aut iste laudantium enim. Sint perspiciatis mollitia ipsa fuga eos autem consequatur rerum. Fugit beatae reprehenderit id iste. Voluptatem sapiente quidem similique ea vel temporibus similique ut.</p><p>Provident quia accusantium et quidem neque sit. Cum sunt sunt incidunt ut distinctio asperiores excepturi. Est quibusdam voluptatem aut placeat odit.</p><p>Nihil quibusdam est voluptas sed quia ducimus et. Rem voluptas eius minus est ut aliquam aperiam. Illum dolore commodi sit earum qui. Et dolorum minima autem architecto voluptas non laborum.</p><p>Sit quia necessitatibus dolorem voluptatum est error ad et. Quia non quidem doloribus. Animi rerum qui qui corporis nostrum.</p><p>Iure dolores vitae hic. Sed eligendi non iusto voluptatum vel aut ut. Nemo est dolores reprehenderit quod voluptates. Nihil nostrum et inventore vero eaque dignissimos.</p><p>Quae nemo modi omnis non non laudantium nulla. Voluptatem aut maxime delectus non officiis. Earum enim veritatis qui itaque ut et perspiciatis. Ea dolores excepturi soluta sint tempore.</p>', 'voluptatem-qui-omnis-consequatur-incidunt', 6, NULL, 'thumbnails/', '[\"sequi\", \"fugiat\", \"dicta\", \"occaecati\"]', 'Sửa lỗi chính tả', '2025-03-24 02:29:58', '2025-04-12 19:47:51'),
('BV-140425-95722077-v67fc6aa2234dd', 3, 23, 'Consectetur excepturi quam repudiandae officia suscipit.', '<p>Ut sed illo fuga distinctio quod. In beatae autem modi sed omnis. Ipsam dolorem illum aperiam consequatur omnis ducimus quia et. Ratione reiciendis et fugiat aperiam quis voluptate.</p><p>Provident quod voluptas et eos. Est voluptatem cupiditate aut. Minus eius quisquam sit qui aut.</p><p>Reprehenderit ad est deleniti. Et officiis sit sit dolorem est eum et. Sint enim sequi rerum occaecati iusto.</p><p>Quis omnis deserunt eius deserunt omnis totam. Soluta adipisci quia exercitationem quia recusandae molestiae. Placeat nihil voluptatem vel aliquam ad rerum est. Qui vel nemo sunt sed voluptatibus.</p><p>Corporis amet eligendi vel. Voluptates nemo maiores nihil ut ea. Omnis deleniti illo ut quas aut vero.</p><p>Et sed maiores provident eos. Iure ut est voluptas soluta aut quia accusantium. Aut atque veritatis non enim.</p><p>Quo sit ut mollitia labore. Dolores dolores praesentium minima omnis sit eum. Voluptas corporis iusto dolores modi nisi. Et quo architecto fugit consequatur.</p><p>Sit mollitia fuga reiciendis voluptatem similique illo ratione. Numquam sint in quod amet tenetur omnis enim. Eligendi dolorum autem eum consequatur vero vitae. Ea dignissimos porro consequatur illo dolores debitis. Earum natus magni facere recusandae tempora.</p><p>Debitis nihil molestiae omnis laborum officiis et. Vel sed ut architecto incidunt voluptatem. Omnis quis ut tenetur sed nobis. Sunt eum blanditiis sint beatae vitae soluta labore recusandae.</p><p>Iure repudiandae sunt minus sed. Distinctio magnam sunt corporis voluptas. Sint ex ad dolores quasi.</p><p>Voluptas magnam debitis enim ipsa unde. Illum voluptatem iure officiis consectetur eos ullam optio. Sed modi dolor aut ut.</p><p>Numquam aut voluptate alias velit et. Omnis dolorum debitis doloribus et. Porro ut facere optio. Blanditiis fuga dolor voluptatem cupiditate.</p><p>Nam adipisci quasi sint laboriosam consectetur cum. Expedita aut et minus mollitia. Quia ratione voluptatem eum adipisci laborum laboriosam occaecati debitis. Eos non et et velit similique saepe.</p><p>Doloremque natus officia tempore modi molestiae sit quia. Possimus placeat animi cumque labore. Et qui deleniti modi quaerat aut nulla. Et ea est officia dolor amet quos.</p>', 'consectetur-excepturi-quam-repudiandae-officia-suscipit', 2, NULL, 'thumbnails/', '[\"tempore\", \"qui\"]', 'Cập nhật nội dung', '2024-06-03 11:15:50', '2024-06-21 15:44:25'),
('BV-140425-95722077-v67fc6aa2429e0', 3, 23, 'Et fugiat explicabo qui esse architecto vel nemo.', '<p>Quia ut quia omnis dicta. Inventore quae dolor et cum. Doloremque at illum vero cumque doloribus. Consequuntur aliquid consequatur sit ipsa eum illo ut eius.</p><p>Minus nobis similique non esse unde quo. Sint qui suscipit nihil dolores quae. Sint et fugiat molestias sint aut similique. Repudiandae voluptatum blanditiis hic tempore adipisci.</p><p>Deserunt numquam voluptatibus quis odio qui est molestiae perferendis. Eligendi quos doloremque labore dolor asperiores. Enim laboriosam cumque et aspernatur et voluptas sed.</p><p>Velit qui et iste dolorem. Quis ut omnis et. Sunt amet ratione suscipit impedit ipsa.</p><p>Ut facilis nisi occaecati deleniti. Et commodi et est nihil. Sed voluptatem repellendus et molestias tempore consequuntur. Sequi in unde officia et odit eos similique.</p><p>Voluptas omnis dolorum sed debitis ea exercitationem. Rerum omnis doloribus eum maxime optio at veniam. Est ex ullam tempore quia et nulla. Repudiandae et debitis dolores voluptates.</p><p>Deleniti dolor quisquam tempora. Vel voluptas non omnis voluptate sed. Rerum illo et et voluptatum. Perferendis aut asperiores quia est.</p>', 'et-fugiat-explicabo-qui-esse-architecto-vel-nemo', 2, NULL, 'thumbnails/', '[\"dolores\", \"expedita\", \"veritatis\", \"rerum\", \"qui\"]', 'Thêm thông tin mới', '2024-12-12 03:42:35', '2025-03-16 04:38:33'),
('BV-140425-96431873-v67fc6aa22ec73', 36, 4, 'Et eligendi aut non laborum voluptatem quaerat vero.', '<p>Et accusantium sit rerum. Pariatur consequatur sed ad qui quia ad doloremque.</p><p>Est aut sunt sunt. Amet id molestiae voluptates eaque fugit ut earum. Quidem ut qui ut quia. Et et id pariatur quia molestiae laboriosam enim. Omnis cumque itaque cum nobis at dolor ullam assumenda.</p><p>Sit quia dicta earum perspiciatis. Impedit laborum itaque quia eveniet. Est et et voluptatem voluptatem magnam. Quia consequatur sed delectus consequatur.</p><p>Est illum quasi sint ipsam molestiae quod. Expedita quod voluptatem impedit et necessitatibus molestiae voluptatem. Facere enim ratione voluptate exercitationem a.</p><p>Assumenda asperiores quia aperiam qui commodi et. Ipsa repellendus praesentium minima ut est sunt. Saepe id necessitatibus natus. Nobis doloribus est blanditiis illum.</p><p>Nihil non odit sed id incidunt nihil. Quam eum eos veritatis cumque vel aliquam et at. Qui ut est eveniet voluptas explicabo quibusdam.</p><p>Qui nam harum beatae et rerum similique expedita. Impedit quia perferendis voluptates eos aut natus non dolore. Officiis repellendus ut est et. Consequatur ullam reiciendis veritatis sed eos.</p><p>Voluptatum mollitia sunt voluptatem unde qui maiores. Voluptatem autem illum ut neque iure tempora quidem. Culpa aut iste et nihil rerum fugit. Assumenda voluptas iure voluptas consectetur.</p><p>Veniam quos qui eum est aut. Non omnis voluptatem aut amet et iusto. Minus accusamus quas voluptatem quasi odio excepturi.</p><p>Architecto hic ducimus reiciendis ut similique dolores alias. Velit provident nam ex. Dolore dignissimos magni amet. Laudantium repellat et voluptas ad facere deleniti non.</p><p>Ipsam soluta dolores tempora porro. Vel illo nihil modi earum alias consequatur. Reiciendis quod voluptas blanditiis earum et recusandae. Quis officiis saepe qui a qui hic.</p><p>Quos repellendus provident ex expedita commodi id est. Incidunt in cum nostrum quia aut. Quia et eaque molestiae unde iste vero.</p>', 'et-eligendi-aut-non-laborum-voluptatem-quaerat-vero', 7, NULL, 'thumbnails/', '[\"et\", \"animi\", \"nostrum\", \"magni\"]', 'Thêm thông tin mới', '2025-03-21 17:32:34', '2025-04-03 19:08:39'),
('BV-140425-99948540-v67fc6aa23400b', 42, 7, 'Enim facere aut enim qui.', '<p>Reiciendis nostrum ipsum sunt error. Non praesentium voluptatem incidunt. Qui dolorem velit dolor accusamus odio.</p><p>Corrupti eius non consequatur eaque quod delectus. Vitae dolor ut minus. Deleniti qui sed ea sint vitae voluptatem error deserunt. Voluptas qui dolores pariatur ipsa.</p><p>Maxime maxime nostrum ut ea omnis. Ea eum corporis dignissimos qui fuga blanditiis omnis. Sequi qui nisi pariatur et dolores inventore qui eaque. Ea facilis ea voluptas dolor ut.</p><p>Nesciunt minus et neque odio voluptatibus maxime. Voluptatem sunt et fugit officiis. Ut commodi voluptas nemo totam sed rem maxime. Quasi unde in sequi voluptatibus alias et est.</p><p>Aut voluptate iste sunt eos molestiae. Sint doloribus aut id dolore. Enim sapiente itaque porro et quia commodi qui enim. Omnis sequi velit doloremque totam.</p>', 'enim-facere-aut-enim-qui', 8, NULL, 'thumbnails/', '[\"eaque\", \"aut\"]', 'Cập nhật hình ảnh', '2024-10-25 00:19:44', '2025-04-11 07:14:18');

-- --------------------------------------------------------

--
-- Table structure for table `article_views`
--

CREATE TABLE `article_views` (
  `view_id` bigint UNSIGNED NOT NULL,
  `anonymous` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `article_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `viewed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `article_views`
--

INSERT INTO `article_views` (`view_id`, `anonymous`, `article_id`, `user_id`, `viewed_at`) VALUES
(1, NULL, 16, 5, '2025-04-14 02:09:06'),
(2, NULL, 39, 1, '2025-04-14 13:17:14'),
(3, NULL, 23, 1, '2025-04-15 03:24:08'),
(4, NULL, 22, 1, '2025-04-15 08:59:38'),
(5, NULL, 1, 1, '2025-04-15 08:59:52'),
(6, NULL, 23, 3, '2025-04-15 10:45:44'),
(7, NULL, 1, 5, '2025-04-16 07:31:17'),
(8, NULL, 23, 5, '2025-04-16 07:31:58'),
(9, NULL, 39, 5, '2025-04-16 07:32:39'),
(10, NULL, 28, 5, '2025-04-17 05:08:24'),
(11, NULL, 51, 5, '2025-04-18 14:54:11'),
(12, NULL, 23, 26, '2025-04-23 16:32:08'),
(13, NULL, 51, 26, '2025-04-23 17:04:42'),
(14, NULL, 28, 4, '2025-04-26 15:35:52'),
(15, NULL, 39, 4, '2025-04-26 15:39:57'),
(16, NULL, 1, 4, '2025-04-26 16:02:54'),
(17, NULL, 51, 4, '2025-04-26 16:08:45');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` bigint UNSIGNED NOT NULL,
  `moderator_id` bigint UNSIGNED DEFAULT NULL,
  `parent_id` bigint UNSIGNED DEFAULT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `moderator_id`, `parent_id`, `name`, `slug`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, 'Chính trị', 'chinh-tri', 1, '2025-04-14 01:53:37', '2025-04-14 01:57:58'),
(2, 25, 10, 'Công nghệ', 'cong-nghe', 1, '2025-04-14 01:53:37', '2025-04-18 14:48:21'),
(3, 14, NULL, 'Velit corporis harum 67fc6aa100c7a', 'velit-corporis-harum-67fc6aa100c7a', 0, '2025-04-14 01:53:37', '2025-04-14 01:53:37'),
(4, 14, NULL, 'Dolores quibusdam 67fc6aa100f3a', 'dolores-quibusdam-67fc6aa100f3a', 0, '2025-04-14 01:53:37', '2025-04-14 01:53:37'),
(5, 11, NULL, 'Optio expedita atque 67fc6aa1011e5', 'optio-expedita-atque-67fc6aa1011e5', 0, '2025-04-14 01:53:37', '2025-04-14 01:53:37'),
(6, 8, NULL, 'Giải trí', 'giai-tri', 1, '2025-04-14 01:53:37', '2025-04-14 01:57:21'),
(7, 8, NULL, 'Thời tiết', 'thoi-tiet', 1, '2025-04-14 01:53:37', '2025-04-14 01:57:03'),
(8, 3, NULL, 'Thế gới', 'the-goi', 1, '2025-04-14 01:53:37', '2025-04-14 01:56:48'),
(9, 8, NULL, 'Thể thao', 'the-thao', 1, '2025-04-14 01:53:37', '2025-04-14 01:56:36'),
(10, 17, NULL, 'Thời sự', 'thoi-su', 1, '2025-04-14 01:53:37', '2025-04-18 14:48:21'),
(11, NULL, 10, 'chính sách', 'chinh-sach', 1, '2025-04-18 14:48:21', '2025-04-18 14:48:21'),
(12, NULL, 10, 'phát triển', 'phat-trien', 1, '2025-04-18 14:48:21', '2025-04-18 14:48:21');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_id` bigint UNSIGNED NOT NULL,
  `article_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `likes` int NOT NULL DEFAULT '0',
  `dislikes` int NOT NULL DEFAULT '0',
  `status` enum('draft','approved','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `parent_id` bigint UNSIGNED DEFAULT NULL,
  `depth` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `article_id`, `user_id`, `content`, `likes`, `dislikes`, `status`, `parent_id`, `depth`, `created_at`, `updated_at`) VALUES
(1, 23, 22, 'Ea nemo quaerat sit aliquid soluta. Nostrum quidem velit a provident tempore voluptatem rem. Vel voluptate quisquam velit a. Enim deserunt et provident quis aut ullam saepe. Enim autem voluptatem laboriosam aliquid natus aperiam distinctio. Ut aut adipisci voluptas nostrum vero.', 49, 1, 'rejected', NULL, 0, '2024-09-01 05:15:51', '2024-11-18 02:18:55'),
(2, 23, 13, 'Et a omnis voluptatem. Omnis ut ipsam aut dolor expedita. Ut optio voluptas labore non. Amet mollitia rerum aut ut quasi voluptatem fuga. Est ea minima placeat. Corrupti ad dolor minima nihil debitis neque et. Voluptates explicabo tempore nobis amet similique corporis.', 6, 1, 'approved', NULL, 0, '2024-10-08 15:15:02', '2025-03-08 07:29:48'),
(3, 23, 20, 'Unde debitis velit ut reprehenderit doloribus. Id ipsum sed occaecati vel qui. Harum dicta saepe a impedit porro aut neque excepturi.', 22, 1, 'draft', NULL, 0, '2024-09-01 17:01:51', '2024-11-20 21:43:41'),
(4, 17, 5, 'Assumenda quae qui natus explicabo. Voluptatem eum enim voluptatem sed eos ex et.', 46, 17, 'draft', NULL, 0, '2024-07-21 03:13:58', '2024-08-11 17:26:35'),
(5, 28, 20, 'Quidem nesciunt minus nihil exercitationem neque praesentium. Explicabo quas mollitia et et omnis. Eum nam illum consequatur enim earum deserunt. Deserunt quaerat fugit ut itaque natus inventore architecto. Velit ipsum tenetur maiores quis et in.', 22, 2, 'approved', NULL, 0, '2025-04-12 06:42:18', '2025-04-13 10:24:14'),
(6, 16, 8, 'Maiores corrupti animi dolorum quam ullam libero numquam. Harum alias rem nobis mollitia repellat doloribus. Id qui blanditiis officiis magni. Modi ab consequatur ut cumque. Voluptates rerum pariatur cumque ipsum aut explicabo. Modi non possimus et sunt ea eius.', 0, 9, 'approved', NULL, 0, '2025-01-21 10:55:59', '2025-02-10 10:16:27'),
(7, 23, 2, 'Qui nostrum est adipisci sed dicta ducimus esse. Vel similique non harum eos ipsum maiores sapiente. Sit aspernatur expedita deleniti sed ipsa velit amet. Id ut repudiandae fugit. Non molestias vitae aut quis sint voluptatem magni. Inventore saepe autem quam non possimus accusamus omnis ipsum. Consequatur impedit occaecati sint qui praesentium nemo.', 2, 1, 'approved', NULL, 0, '2024-09-21 02:09:31', '2025-01-29 21:20:11'),
(8, 4, 20, 'Sapiente quia excepturi praesentium est minima qui. Quis ut asperiores sequi laboriosam id sapiente. Minus facere sed et odit consectetur. Id voluptatem nisi eos voluptates.', 7, 6, 'approved', NULL, 0, '2024-11-21 16:53:37', '2025-04-02 12:23:28'),
(9, 40, 11, 'Et cum quod sunt eos eum quia. Numquam quo ratione quis tempore.', 26, 12, 'draft', NULL, 0, '2024-08-18 05:22:31', '2025-01-01 12:17:09'),
(10, 23, 4, 'Laudantium omnis suscipit quia autem non a.', 31, 11, 'approved', NULL, 0, '2025-01-11 07:47:06', '2025-03-04 08:13:12'),
(11, 16, 10, 'Id aliquid ut eligendi nemo architecto voluptatibus aspernatur. Assumenda aut quidem fuga officia sit quos ullam. Sequi ea est magni veritatis recusandae impedit.', 46, 7, 'rejected', NULL, 0, '2024-05-17 11:07:27', '2024-05-21 11:49:23'),
(12, 23, 10, 'Quae error excepturi fugit nihil rerum. Voluptatibus iusto saepe sit ipsum.', 27, 15, 'rejected', NULL, 0, '2025-01-11 05:46:57', '2025-01-19 08:03:32'),
(13, 39, 23, 'Corrupti eaque assumenda veritatis magni. Earum rerum et aperiam magni.', 13, 14, 'rejected', NULL, 0, '2025-03-24 11:48:26', '2025-04-02 18:11:54'),
(14, 47, 24, 'Ullam dignissimos molestiae vel qui. Ratione autem qui ad. Exercitationem ab eum repellat alias fugit. Facilis aut harum atque molestiae.', 17, 14, 'approved', NULL, 0, '2024-11-18 12:33:13', '2025-01-29 09:34:03'),
(15, 25, 20, 'Architecto quod placeat quo quia. Esse labore qui nulla sed quas necessitatibus odit numquam. Aut vitae explicabo non blanditiis quam.', 27, 0, 'rejected', NULL, 0, '2024-05-01 17:41:01', '2025-02-26 11:22:55'),
(16, 47, 19, 'Molestiae blanditiis perferendis vero numquam nemo et. Distinctio voluptatum quia rerum incidunt rerum exercitationem. Qui saepe culpa iusto autem molestiae qui. Et placeat iusto rem repudiandae nihil qui et eum.', 15, 7, 'draft', NULL, 0, '2024-11-20 17:15:27', '2025-04-04 15:47:23'),
(17, 23, 25, 'Quos labore ipsam repellat harum commodi sit. Officia accusantium eum aliquam expedita. Eos fuga sequi praesentium voluptas dignissimos qui.', 28, 19, 'rejected', NULL, 0, '2024-10-10 02:18:47', '2024-12-29 02:28:11'),
(18, 28, 25, 'Sunt sunt laudantium ad fugit eligendi. Et optio consequatur et velit. Repellendus nam natus nisi numquam in.', 6, 2, 'rejected', NULL, 0, '2024-06-10 22:03:11', '2024-11-05 00:44:21'),
(19, 47, 6, 'Suscipit adipisci consequatur ipsum id quas voluptatem voluptatum. Facilis non in architecto dignissimos iusto occaecati aut qui. Ipsam reiciendis quia eius accusantium. Quia ex et ut et.', 11, 15, 'approved', NULL, 0, '2025-02-15 05:22:15', '2025-02-21 20:09:10'),
(20, 4, 2, 'Necessitatibus aut quisquam quae aut. Maxime odit magni officia. Neque voluptatum hic molestias expedita. Necessitatibus ratione quis eum id amet blanditiis eos vitae.', 4, 2, 'approved', NULL, 0, '2025-04-11 16:51:37', '2025-04-11 18:24:58'),
(21, 17, 19, 'Sit minima maiores animi necessitatibus culpa corporis. Hic sint est excepturi veritatis qui. Aliquam corporis aut voluptatum voluptates nihil enim nulla vel. Sit temporibus ut aspernatur expedita. Ut dolore repellendus dolores commodi atque velit consequuntur.', 37, 14, 'approved', NULL, 0, '2025-04-01 08:16:36', '2025-04-08 22:40:07'),
(22, 4, 6, 'Ut porro laudantium quidem necessitatibus soluta explicabo. Ea autem sunt minima excepturi accusamus velit error officia.', 50, 8, 'rejected', NULL, 0, '2025-02-05 09:09:53', '2025-03-14 03:27:14'),
(23, 16, 7, 'Ipsam aut at laudantium quaerat.', 8, 18, 'approved', NULL, 0, '2025-01-07 05:18:23', '2025-03-28 17:26:31'),
(24, 25, 25, 'Fugiat maxime ut aut veniam. Vel est et harum quia qui sint.', 33, 13, 'draft', NULL, 0, '2024-09-08 12:02:19', '2025-02-05 07:30:10'),
(25, 4, 5, 'Qui quas sunt mollitia minus optio. Velit cupiditate itaque assumenda iste.', 37, 16, 'rejected', NULL, 0, '2025-03-13 06:17:34', '2025-04-10 05:14:46'),
(26, 16, 10, 'Et est hic laudantium quae neque dignissimos. Ratione est unde aut. Sunt ipsa debitis sit voluptates fugit.', 27, 15, 'rejected', NULL, 0, '2024-11-23 14:29:36', '2024-12-01 08:18:36'),
(27, 28, 21, 'Maxime ab corrupti quam nemo suscipit repellat. Et placeat repellendus saepe aut. Vel voluptas maxime modi doloribus. Consequatur unde dolor ullam. Facere rerum rerum rerum rem nostrum iusto odio aut.', 28, 7, 'approved', NULL, 0, '2024-11-04 18:12:57', '2025-01-05 05:43:06'),
(28, 44, 19, 'Velit dolorem totam assumenda animi. Et accusantium rerum quas assumenda deleniti natus. Enim est ut voluptatem tenetur voluptas. Autem beatae quidem ea ab dolor. Impedit est vero repudiandae eum ducimus. Nam est quod atque hic.', 13, 1, 'approved', NULL, 0, '2024-08-31 14:54:57', '2025-01-13 01:47:43'),
(29, 16, 7, 'Voluptatibus architecto id sit aperiam consequuntur. Ut animi voluptatem aliquam quia laborum sed omnis. Ab sapiente libero debitis et fugiat. Dolores tenetur quaerat consequuntur qui.', 17, 16, 'rejected', NULL, 0, '2024-09-01 19:51:00', '2025-01-20 09:23:45'),
(30, 30, 16, 'Laudantium quas excepturi placeat et ratione architecto. Ad qui omnis architecto et excepturi dolores dolore. Nesciunt incidunt est impedit qui sit enim ut. Dolor dolor voluptates mollitia tempore.', 35, 4, 'rejected', NULL, 0, '2024-08-17 22:47:33', '2025-01-26 09:27:25'),
(31, 4, 6, 'Nam quisquam vel asperiores incidunt aut eius. Facilis et quis fugit corporis tenetur eaque.', 10, 4, 'rejected', NULL, 0, '2024-04-16 11:27:56', '2024-12-01 07:24:47'),
(32, 28, 22, 'Voluptatum laborum distinctio fugiat incidunt minus rerum. Minima assumenda quia ab in eveniet. Iste deleniti et fugit sunt. Non praesentium consequuntur praesentium iure optio repudiandae ad sit. Iure quod fugiat dolorem.', 7, 7, 'draft', NULL, 0, '2024-10-26 06:03:13', '2025-01-11 02:41:30'),
(33, 30, 2, 'Aliquid ipsa aut excepturi quis iusto quod qui. Omnis nesciunt harum corrupti ex. Sit iusto odio nihil nihil facilis.', 4, 9, 'rejected', NULL, 0, '2024-09-14 12:36:15', '2025-04-04 14:40:57'),
(34, 39, 20, 'Explicabo et repudiandae amet eos.', 21, 18, 'draft', NULL, 0, '2024-11-27 11:14:52', '2025-01-20 15:20:54'),
(35, 30, 19, 'Et cumque dolorem quia et. Blanditiis quas laborum nihil officia ab illo ex. In voluptatibus sint eum praesentium maxime quia vel culpa. Officiis quidem voluptas commodi eum dolorum.', 50, 2, 'draft', NULL, 0, '2024-07-25 11:10:03', '2025-01-06 13:42:39'),
(36, 28, 19, 'Et delectus eum rerum et nihil quia in. Provident optio placeat qui et.', 34, 11, 'rejected', NULL, 0, '2025-04-02 03:54:00', '2025-04-03 12:59:57'),
(37, 23, 9, 'Odio modi ut et delectus illum. Sed praesentium repellat vel sed neque.', 46, 19, 'approved', NULL, 0, '2025-04-05 13:54:41', '2025-04-07 21:16:20'),
(38, 16, 9, 'Et porro et eos et ea.', 41, 7, 'rejected', NULL, 0, '2025-02-17 22:03:02', '2025-03-22 23:54:31'),
(39, 23, 13, 'Tempora perspiciatis pariatur recusandae voluptas ipsam eligendi. Consequatur vel ut qui.', 31, 20, 'rejected', NULL, 0, '2024-08-03 10:56:44', '2025-03-19 14:44:49'),
(40, 4, 21, 'Blanditiis dolores est eum quo illo doloribus porro quia. Provident neque dolorem laboriosam molestiae. Officia aut rerum deserunt repudiandae aliquid dignissimos dicta. Et consequatur asperiores accusamus velit nulla officia inventore. Aspernatur est et voluptatibus sint aut ipsam. Amet sapiente porro explicabo nihil sunt animi dolorem. Molestiae deserunt ipsa voluptate vitae.', 23, 1, 'draft', NULL, 0, '2024-04-19 20:42:11', '2024-08-07 10:56:24'),
(41, 40, 11, 'Qui molestiae beatae aut enim. Impedit nulla nihil quis excepturi temporibus fugiat ullam. Et repudiandae consequatur aspernatur saepe vero ipsa. Animi quas aut earum vero rem. Nemo iste aut dolorem ut repellendus impedit ipsa.', 35, 4, 'approved', NULL, 0, '2024-07-21 15:44:08', '2024-07-30 19:50:32'),
(42, 39, 6, 'Quam nesciunt quis debitis harum. Eos reiciendis iusto atque est.', 7, 19, 'draft', NULL, 0, '2024-06-27 10:53:55', '2024-11-23 13:03:01'),
(43, 16, 7, 'Et impedit expedita commodi sit id in mollitia enim. Quia qui veritatis voluptatem amet qui est.', 35, 19, 'approved', NULL, 0, '2024-12-10 22:42:13', '2025-01-15 11:43:41'),
(44, 23, 21, 'Consequatur blanditiis amet quibusdam aut odio repudiandae qui. Occaecati perspiciatis impedit ut mollitia.', 13, 2, 'draft', NULL, 0, '2024-10-07 23:45:44', '2025-02-22 22:36:35'),
(45, 28, 24, 'Voluptatibus eos quos mollitia nulla qui amet neque. Ducimus deleniti eos facilis soluta a et. Et placeat impedit eum ut et quo labore. Qui rerum aliquam accusantium non consequuntur eius eius rerum. Qui deserunt ex sapiente.', 49, 17, 'rejected', NULL, 0, '2024-11-03 10:36:51', '2025-01-06 17:34:33'),
(46, 40, 17, 'Quia ipsam asperiores sed quibusdam saepe ex facere ut. Et et cupiditate nostrum non non quasi ut. Explicabo doloremque ad soluta voluptatem animi. Eos vel et mollitia assumenda culpa ullam soluta.', 31, 12, 'draft', NULL, 0, '2024-11-14 14:11:49', '2025-02-15 05:57:31'),
(47, 4, 10, 'Doloremque aliquid ut id enim vero. Unde ex odit quidem quasi. Temporibus omnis perspiciatis voluptatem qui dolor et magni. Deleniti impedit error mollitia. Voluptas itaque eveniet numquam voluptas.', 15, 1, 'draft', NULL, 0, '2025-03-22 21:11:47', '2025-04-02 16:06:34'),
(48, 40, 6, 'Repudiandae unde quasi qui eaque quasi necessitatibus commodi. Qui ipsa deserunt necessitatibus ut. Totam adipisci impedit odio consectetur voluptatem. Sit numquam dolores perspiciatis laboriosam officiis. Ut consequuntur neque ducimus corrupti occaecati debitis nam ut.', 5, 2, 'approved', NULL, 0, '2024-10-01 16:30:46', '2025-03-28 06:26:58'),
(49, 30, 13, 'Quibusdam et atque vero consequatur quam. Modi consequuntur nisi optio quasi quaerat. In aliquid et placeat. Rerum quibusdam ut qui iusto nobis enim nostrum. Ducimus rerum aut dolores non. Dolor qui nostrum quia ab placeat maxime.', 34, 10, 'approved', NULL, 0, '2024-08-09 03:32:51', '2025-03-23 21:40:40'),
(50, 28, 21, 'Voluptas veritatis autem ipsa expedita ipsum dolor harum cum. Tempora sunt placeat nam quisquam praesentium ut distinctio veniam. Magnam itaque non doloremque omnis neque.', 38, 15, 'approved', NULL, 0, '2024-10-13 08:45:43', '2024-11-26 17:26:04'),
(51, 23, 17, 'Veritatis commodi id et at excepturi culpa ducimus qui. Eos facere molestias officia omnis non adipisci sed quo.', 11, 7, 'approved', NULL, 0, '2024-08-05 07:42:51', '2024-09-03 11:55:08'),
(52, 39, 14, 'Tempora eum aperiam nihil reprehenderit est. Dolorem omnis et ut vel pariatur ex ut omnis. Temporibus eos ex labore quibusdam. Facilis labore laborum perspiciatis.', 3, 8, 'draft', NULL, 0, '2024-10-27 20:36:04', '2025-01-26 14:31:10'),
(53, 40, 6, 'Similique blanditiis est nemo reprehenderit esse et. Et nostrum commodi voluptates eligendi velit. Corporis necessitatibus doloremque dolorem provident. Exercitationem qui quis qui dolor quia provident vero. Eos vel qui fuga in exercitationem nostrum omnis.', 34, 15, 'draft', NULL, 0, '2025-01-01 02:10:12', '2025-04-13 10:07:39'),
(54, 30, 1, 'Nulla beatae repudiandae et consectetur quae. Itaque maxime dolor ut magnam reiciendis distinctio expedita. Enim et optio ut eos molestiae. Laborum quos provident sed accusamus modi. Veniam autem quae cum non dolorum quam ut dolor. Iusto aut saepe ipsam enim qui dignissimos. Autem ut molestiae autem aut ab nihil.', 16, 11, 'draft', NULL, 0, '2024-07-26 10:34:12', '2025-02-11 11:28:01'),
(55, 23, 25, 'Harum hic occaecati consequatur et et dolores dicta et. Enim in quos tempore esse veritatis amet ex. Ipsum voluptate numquam sit non. Occaecati corporis consectetur et laboriosam. Aut voluptatem at voluptatem voluptas ex sed. Quasi et nostrum quas enim odit.', 22, 16, 'approved', NULL, 0, '2024-05-26 02:52:41', '2024-10-24 14:44:09'),
(56, 40, 19, 'Eum nihil enim voluptas tempora qui enim est alias.', 6, 3, 'approved', NULL, 0, '2025-03-16 09:24:50', '2025-03-22 18:43:35'),
(57, 28, 24, 'Ea recusandae ex ratione exercitationem delectus. Tempore omnis qui autem.', 24, 11, 'draft', NULL, 0, '2024-06-02 17:14:05', '2024-11-14 01:53:39'),
(58, 28, 11, 'Ab assumenda vitae molestiae voluptate rem vero quibusdam. In dolor nostrum eos quo repellendus.', 27, 12, 'rejected', NULL, 0, '2024-08-29 21:12:47', '2024-12-02 20:48:47'),
(59, 39, 21, 'Tempora beatae a vel quos et vel. Sed aut est hic at in.', 7, 13, 'approved', NULL, 0, '2025-03-04 08:02:53', '2025-04-01 10:38:43'),
(60, 40, 23, 'Eligendi et ipsam est et nobis. Corporis harum nostrum non et. Nisi tempora corrupti eum nostrum facere aspernatur. Velit similique ut dolorem aspernatur modi.', 5, 16, 'rejected', NULL, 0, '2024-09-22 17:00:06', '2025-01-08 09:20:00'),
(61, 4, 22, 'Est rerum atque eveniet optio autem. Ea expedita qui molestias rerum. Unde nulla est beatae sit sapiente molestias. Modi hic a molestiae harum molestias. Nam commodi nostrum magnam iste. Molestiae perspiciatis fuga perspiciatis.', 36, 19, 'approved', NULL, 0, '2025-03-29 20:08:44', '2025-04-13 00:06:51'),
(62, 17, 13, 'Distinctio omnis similique praesentium et. Quia fugiat qui sint. Quae impedit consequatur ut quo sint cupiditate.', 39, 1, 'rejected', NULL, 0, '2024-09-07 14:36:27', '2025-04-06 19:02:34'),
(63, 25, 10, 'Ut impedit dolorem in sed perspiciatis. Dolorum autem et minus iure. Ut enim architecto magnam deserunt fugiat. Consectetur sunt eum assumenda voluptas.', 36, 4, 'draft', NULL, 0, '2024-07-09 11:56:24', '2025-03-31 20:04:44'),
(64, 44, 2, 'Sit molestiae nesciunt magnam aut animi qui magnam neque. Officia doloribus ad eligendi ullam deleniti quibusdam maiores.', 12, 2, 'draft', NULL, 0, '2024-12-09 19:39:02', '2025-01-05 18:50:44'),
(65, 4, 22, 'Magni esse aut dolor aut ipsa. Veniam dolor in odio impedit. Consequuntur eos quo voluptates quae sint debitis. Tempora quas at porro unde est odio illum optio.', 5, 1, 'approved', NULL, 0, '2024-09-02 22:02:20', '2024-10-01 05:37:47'),
(66, 39, 6, 'Ab et accusantium et debitis at. Rerum soluta laborum quasi delectus. Molestiae inventore fugiat expedita enim totam.', 17, 9, 'approved', NULL, 0, '2025-02-08 12:30:04', '2025-03-10 00:21:01'),
(67, 28, 23, 'Explicabo et et dolores rerum veritatis doloremque. Harum voluptas ad quasi eos fugit. Eos eveniet mollitia quis eaque. Occaecati alias quaerat expedita quod numquam ut. Aut soluta sit aliquam nam in odio laudantium numquam.', 14, 19, 'rejected', NULL, 0, '2024-06-04 12:05:33', '2024-12-03 22:54:59'),
(68, 47, 10, 'Quaerat dolor sunt magnam et velit excepturi quasi. Ipsam minima culpa fuga doloremque et alias. Autem voluptas minus ut corrupti.', 42, 1, 'rejected', NULL, 0, '2024-11-03 16:46:14', '2025-02-07 10:28:46'),
(69, 47, 16, 'Ut non quisquam ut cupiditate est excepturi nemo. Molestiae enim soluta molestiae nesciunt qui excepturi. Quis aliquam rerum eum ipsum aut.', 25, 7, 'approved', NULL, 0, '2025-01-27 10:10:19', '2025-03-16 07:08:53'),
(70, 25, 22, 'Rem sed est recusandae ut nulla natus voluptate.', 2, 8, 'approved', NULL, 0, '2025-03-05 22:05:56', '2025-04-08 07:54:13'),
(71, 28, 19, 'Dicta enim amet commodi sed assumenda. Dolore laudantium commodi recusandae exercitationem esse omnis. Nesciunt velit quia aut voluptatem sit debitis.', 36, 18, 'rejected', NULL, 0, '2025-04-10 19:28:38', '2025-04-12 14:40:05'),
(72, 44, 17, 'Excepturi error laudantium facere fugiat suscipit porro nobis possimus. Officia maiores quibusdam nobis dolores hic ab qui sunt. Vel dolor in laboriosam tempore odit consequuntur rem. Et veritatis eos accusamus qui.', 16, 0, 'rejected', NULL, 0, '2024-08-18 09:38:08', '2024-09-20 23:38:00'),
(73, 47, 6, 'Consectetur odit voluptates corrupti et. Perspiciatis nemo modi labore quis cum. Impedit accusantium repellendus vero atque deleniti quibusdam.', 27, 15, 'rejected', NULL, 0, '2024-11-01 14:53:36', '2025-01-20 17:34:39'),
(74, 47, 25, 'Et magnam sunt rem occaecati vel eos quo.', 8, 10, 'approved', NULL, 0, '2025-02-23 21:33:10', '2025-02-27 02:22:54'),
(75, 16, 17, 'Mollitia ea asperiores quasi maiores inventore aliquid neque. Suscipit placeat aliquid officia error iusto voluptatem a. Nihil reiciendis illo et voluptatem dicta. Assumenda fuga illum qui aspernatur ut praesentium. Neque quod mollitia sint.', 5, 11, 'rejected', NULL, 0, '2024-11-16 11:52:38', '2025-02-26 07:38:50'),
(76, 47, 1, 'Dolorem ut dignissimos dolores illum est a qui. Sed dolor soluta quae occaecati id. Maiores veniam maiores nulla dolores nihil enim pariatur.', 11, 5, 'draft', NULL, 0, '2025-04-04 17:29:16', '2025-04-10 12:20:20'),
(77, 28, 14, 'Esse maxime in et illum dolore. Excepturi est voluptas omnis molestias asperiores.', 0, 1, 'rejected', NULL, 0, '2024-08-13 15:46:21', '2024-10-21 00:57:34'),
(78, 39, 24, 'Magnam ullam laudantium qui tempora eveniet error. Dolore voluptate dicta nesciunt non et quos. Qui quod molestiae inventore cum. Quia libero autem a natus omnis odit laborum aut. Eos cum sit et similique nihil tempora. Maxime totam magnam maxime voluptas maiores sint amet.', 17, 4, 'draft', NULL, 0, '2025-02-21 04:55:42', '2025-02-26 20:19:43'),
(79, 39, 9, 'Provident autem tenetur assumenda fuga. Dolorem illum in tempore rem est. Accusantium quasi eum natus maiores nihil est vero sint. Commodi facere sequi nobis odit enim.', 9, 13, 'draft', NULL, 0, '2024-05-02 06:22:50', '2024-12-22 10:12:36'),
(80, 23, 15, 'Tenetur quae qui velit illum voluptatem. Eos natus cumque quia quasi sit ab repellat. Doloremque autem quia velit ipsum blanditiis harum. Non enim odit sint qui. Totam sint voluptatibus accusantium totam repudiandae. Temporibus eos reiciendis tenetur repellat mollitia ut delectus.', 4, 2, 'approved', NULL, 0, '2024-04-25 01:16:49', '2024-10-13 13:02:42'),
(81, 17, 11, 'Cupiditate nam totam ut exercitationem nostrum. Et necessitatibus quo labore laboriosam et eveniet commodi.', 32, 17, 'rejected', NULL, 0, '2024-09-27 09:13:05', '2025-03-05 17:45:26'),
(82, 40, 14, 'Eligendi quia est reiciendis. Est accusantium adipisci et in voluptatem et vero beatae. Placeat ullam et ut.', 17, 19, 'approved', NULL, 0, '2024-09-17 12:30:42', '2025-02-15 03:36:20'),
(83, 40, 23, 'Velit aut harum non aperiam consequatur consequatur et sit.', 40, 1, 'approved', NULL, 0, '2024-04-25 13:55:27', '2025-02-19 15:47:26'),
(84, 28, 13, 'Perspiciatis voluptatem dolor ratione quis laborum aliquam dolorem quod. Recusandae quibusdam hic est.', 23, 4, 'approved', NULL, 0, '2024-09-27 10:36:51', '2024-10-08 10:16:07'),
(85, 47, 11, 'Pariatur saepe quis consequatur cumque nihil neque explicabo sit.', 9, 2, 'rejected', NULL, 0, '2025-01-29 07:00:35', '2025-03-31 04:44:15'),
(86, 30, 6, 'Qui sed et in enim sapiente delectus consequatur. Numquam aut id optio odio. Dolores consequatur vitae doloremque explicabo aperiam. Fugiat et expedita incidunt consectetur.', 22, 17, 'rejected', NULL, 0, '2024-07-27 04:39:44', '2024-12-13 12:40:08'),
(87, 30, 1, 'Minus impedit laboriosam maxime necessitatibus aut. Quibusdam vero corrupti assumenda rerum totam et.', 24, 2, 'rejected', NULL, 0, '2024-10-21 08:39:51', '2024-12-18 22:50:30'),
(88, 40, 20, 'Maxime possimus saepe sit repellat excepturi est quia quaerat.', 30, 8, 'draft', NULL, 0, '2024-07-13 01:07:42', '2024-09-21 20:09:29'),
(89, 4, 11, 'Rerum consectetur recusandae placeat alias excepturi aliquid. Ea omnis qui veritatis error assumenda possimus tempore. Aut est blanditiis et et maiores voluptatem quisquam. Labore voluptates sit rerum possimus nemo saepe.', 43, 8, 'draft', NULL, 0, '2024-09-08 09:53:04', '2024-12-05 08:32:09'),
(90, 16, 19, 'Omnis ea et itaque eaque illum qui minus. Soluta cumque ut expedita qui itaque tempora eos quia. Maxime corrupti minus debitis aliquid.', 20, 14, 'rejected', NULL, 0, '2024-07-17 21:48:51', '2025-02-01 06:20:08'),
(91, 16, 23, 'Distinctio aut unde molestiae et et quis. Aut repellat reprehenderit voluptas ea eos minus animi. Aut earum soluta aperiam sunt iure ad consectetur.', 47, 16, 'draft', NULL, 0, '2025-03-18 06:19:19', '2025-04-11 13:56:41'),
(92, 23, 12, 'Officiis esse qui tempore repellat ullam expedita doloribus. Illo modi natus ea. Doloribus unde voluptatibus autem.', 10, 6, 'draft', NULL, 0, '2024-10-11 20:14:25', '2024-12-10 18:04:54'),
(93, 44, 7, 'Eos numquam quos accusantium eos perspiciatis vel. Et aliquam animi ut consequatur est quis consequatur. Dolorem fugiat rerum rerum quis ut consequatur. Facilis minima est rerum rerum.', 49, 15, 'draft', NULL, 0, '2025-01-11 04:55:29', '2025-01-22 07:54:53'),
(94, 28, 18, 'Perferendis quas debitis fuga est velit porro laborum. Placeat ullam molestiae et alias. Officia odio amet ea quia neque sed modi.', 4, 4, 'rejected', NULL, 0, '2024-09-30 20:19:02', '2025-02-17 07:12:35'),
(95, 4, 21, 'Ducimus voluptatem corporis laboriosam ea magnam et dolores. Quibusdam rem minus odit odit reiciendis. Accusantium beatae aut placeat vel architecto quo hic.', 50, 9, 'rejected', NULL, 0, '2024-09-18 01:18:57', '2024-09-27 00:35:51'),
(96, 17, 3, 'Nostrum ea eligendi labore sit recusandae et corrupti blanditiis. Impedit labore molestiae suscipit quae reprehenderit et qui. Sit facere perferendis perspiciatis quia non et.', 45, 4, 'approved', NULL, 0, '2024-04-27 16:06:04', '2024-12-20 23:41:22'),
(97, 40, 7, 'Enim accusamus autem sed autem pariatur numquam odio sed. Quis rerum rerum veniam et deserunt. Et possimus et quis. Ex impedit porro porro magni voluptatem iusto molestiae. Est in voluptatum doloribus consequatur fugiat. Voluptatem enim est et distinctio sed.', 12, 14, 'rejected', NULL, 0, '2024-12-18 16:51:08', '2025-03-29 16:31:25'),
(98, 4, 23, 'Aut saepe ut nam ipsa occaecati. Aut sit vel dolorem magni mollitia.', 12, 11, 'approved', NULL, 0, '2024-05-04 08:32:19', '2024-12-05 09:28:24'),
(99, 40, 24, 'Eum totam est ut velit rerum aut qui voluptatum.', 3, 7, 'approved', NULL, 0, '2025-03-06 05:19:14', '2025-03-31 01:44:21'),
(100, 47, 13, 'Et eos eos inventore officiis et. Vel eos iste et adipisci tempora.', 13, 10, 'draft', NULL, 0, '2024-05-10 09:30:43', '2024-07-08 21:59:12'),
(101, 44, 16, 'Assumenda dolores assumenda illum veniam est. Velit consequuntur quis omnis molestiae.', 4, 0, 'draft', 93, 1, '2024-11-15 14:04:45', '2025-03-04 20:16:07'),
(102, 40, 23, 'Id cupiditate ratione vero officia. Dolore minima nam voluptate perspiciatis.', 38, 6, 'draft', 53, 1, '2025-01-31 01:52:29', '2025-04-06 00:22:46'),
(103, 39, 19, 'Odio ea quaerat culpa voluptatum fugit voluptas. Exercitationem dolore velit et ea alias rerum saepe vel. Ut porro assumenda quis earum et est ipsa.', 46, 18, 'draft', 42, 1, '2024-10-18 21:32:26', '2024-11-16 19:19:04'),
(104, 30, 16, 'Rerum error fugit ea placeat quia cum dolorem. Possimus rerum assumenda sed aut error. Modi quisquam dolorum rerum quod aliquid facere. Alias magnam qui ut unde et sed. Aspernatur harum sapiente qui minima voluptatem. Eligendi et consectetur quaerat perferendis.', 44, 13, 'rejected', 35, 1, '2024-04-28 05:23:19', '2025-01-27 12:33:47'),
(105, 16, 18, 'Voluptate illum repellat et quia quaerat necessitatibus. Distinctio aspernatur a est magni aliquid.', 20, 10, 'draft', 11, 1, '2024-07-21 08:34:32', '2025-03-19 06:50:01'),
(106, 16, 4, 'Maiores itaque et quia ex et et quaerat. Perspiciatis asperiores sint illum et aperiam ut. Beatae eum dolor non ducimus. Quia aut recusandae exercitationem vel hic sint. Eius et velit facere perspiciatis quo dolorum ut omnis. Eos et facere nesciunt in.', 42, 14, 'draft', 43, 1, '2024-12-13 11:51:45', '2024-12-16 19:14:20'),
(107, 4, 22, 'Minus accusantium similique dignissimos. Et fugiat voluptatem temporibus maxime occaecati suscipit qui voluptas. Aut cum laborum aut magni autem voluptas. Tenetur quia soluta ut quisquam quaerat. Earum voluptatem sit qui. Saepe iusto qui rerum qui laborum repellat. Voluptatem sit est voluptatem.', 45, 17, 'approved', 22, 1, '2024-08-21 04:43:07', '2025-02-20 15:36:40'),
(108, 44, 23, 'Alias et officia qui et. Quia quia eos beatae natus ut.', 3, 0, 'approved', 28, 1, '2024-08-23 12:37:49', '2025-01-28 01:31:50'),
(109, 47, 25, 'Repellat qui et voluptatem omnis. Nobis consequatur blanditiis aperiam ipsa molestiae nesciunt. Atque placeat provident iste ut maxime iusto.', 7, 19, 'draft', 16, 1, '2025-03-20 06:34:30', '2025-04-08 04:04:17'),
(110, 40, 12, 'Magnam omnis quod quis exercitationem omnis officiis odio. Architecto qui ab dolorum voluptatum ut. Neque sed in labore enim occaecati eaque quia iure.', 32, 19, 'approved', 99, 1, '2024-11-22 18:09:46', '2025-02-05 22:12:20'),
(111, 4, 17, 'Qui modi et qui laudantium nisi. Earum tenetur fuga id quis earum omnis.', 28, 0, 'approved', 89, 1, '2025-02-02 12:55:51', '2025-04-04 22:31:21'),
(112, 47, 3, 'Aliquid eos beatae et quae ut aut nobis. Cupiditate esse aut facere omnis molestiae. Illum enim impedit quia nobis. Fugit velit eveniet expedita omnis eveniet. Ad voluptatibus minima sed temporibus saepe optio. Rerum neque laborum id voluptatem magni. Rerum deserunt provident reiciendis amet adipisci.', 6, 11, 'rejected', 69, 1, '2024-09-20 16:40:19', '2024-12-27 02:58:48'),
(113, 16, 15, 'Harum iure quia qui autem eius. Aut ut natus iste culpa. In modi culpa quo. Dolorem eaque dolore alias dolor ad quis.', 15, 3, 'approved', 91, 1, '2024-10-03 19:26:18', '2025-02-16 13:30:41'),
(114, 25, 5, 'Tempora sed recusandae optio eius. Et itaque doloremque assumenda qui quasi porro omnis. Cumque iusto voluptatem ut aspernatur sit. Ea possimus labore maxime accusantium. Reiciendis distinctio aliquam dolor ut reprehenderit aut magni. Facere eum repellat ipsa dolorem rem est suscipit.', 37, 6, 'approved', 70, 1, '2025-02-25 04:34:03', '2025-04-05 12:38:00'),
(115, 4, 2, 'Eos eveniet deserunt ut corrupti rem sint.', 17, 0, 'approved', 61, 1, '2025-02-28 20:18:48', '2025-04-04 20:19:42'),
(116, 23, 2, 'Maxime ratione eaque rerum totam ad repellat.', 39, 0, 'rejected', 51, 1, '2024-11-02 08:48:29', '2025-04-09 04:26:30'),
(117, 28, 2, 'Asperiores voluptatum at velit perspiciatis et repellendus ea. Enim cum aspernatur velit labore facilis saepe. Sed eius et a consequatur est voluptatem.', 42, 10, 'rejected', 84, 1, '2024-05-19 20:49:15', '2025-01-27 19:14:50'),
(118, 47, 14, 'Dolorem quasi ut voluptatum architecto rem doloribus fugit. Nihil mollitia consectetur nulla distinctio quasi voluptatem id et. Consequatur nisi ut magni provident perferendis sint eum.', 12, 8, 'rejected', 74, 1, '2025-03-18 06:56:16', '2025-03-19 00:20:21'),
(119, 23, 16, 'Deserunt molestiae ea et dicta dolore. Quis sunt officia dicta id. Id ab voluptas aliquam alias sunt in.', 18, 18, 'draft', 1, 1, '2024-10-22 15:59:39', '2024-11-19 03:37:09'),
(120, 25, 3, 'Beatae adipisci quidem earum dolores tempore. Vel ea non delectus in qui excepturi.', 6, 19, 'rejected', 15, 1, '2024-11-03 20:17:35', '2025-02-15 14:35:40'),
(121, 47, 18, 'Quia est omnis sit culpa hic quis. Dolorem repudiandae distinctio exercitationem non animi fugiat. Laboriosam dolorum ullam ullam enim accusamus nihil. Et ipsa vitae nihil nihil iure qui.', 7, 18, 'rejected', 19, 1, '2024-08-15 11:08:39', '2024-08-29 03:50:08'),
(122, 17, 13, 'Qui et tempore eius voluptatibus. Quisquam earum dicta et nihil ut suscipit sunt et. Ipsa et aut et atque numquam ullam sit. Beatae voluptas molestias enim consectetur sapiente.', 49, 1, 'draft', 62, 1, '2024-07-31 00:56:41', '2025-04-02 23:07:18'),
(123, 25, 10, 'Illum laboriosam quis velit nam qui perspiciatis. Inventore officiis omnis quasi deserunt et earum. Vel possimus nisi qui et non. Ratione qui sit alias quia facere a. Qui perferendis debitis sunt eum non. Ab dicta ipsa veniam ipsa magni ab.', 30, 13, 'draft', 15, 1, '2025-03-20 18:32:41', '2025-04-06 07:37:56'),
(124, 23, 21, 'Sit eos et rerum ex dolore. Qui doloremque aperiam dignissimos odit ipsa repellendus. Blanditiis est quo repellat. Similique vero omnis numquam temporibus modi dolores.', 23, 1, 'rejected', 80, 1, '2024-04-23 08:53:25', '2025-03-18 23:32:23'),
(125, 28, 7, 'Tempore odit enim qui dolorem qui culpa consequatur. Ea laudantium animi distinctio nam dolore. Et consequatur aut qui voluptas aperiam. Rerum occaecati provident alias eligendi molestias quibusdam.', 19, 18, 'approved', 57, 1, '2024-08-01 04:15:17', '2025-03-26 00:02:19'),
(126, 47, 12, 'Voluptatem et aspernatur fugit consequatur.', 14, 0, 'rejected', 76, 1, '2024-10-02 20:57:36', '2025-02-03 12:00:03'),
(127, 47, 11, 'Sit ea quaerat consequatur voluptatem animi dolores sint. Est ea corrupti voluptas rem aut similique esse. Magni in assumenda voluptate harum voluptatem architecto. Temporibus reiciendis ipsum rerum magni. Et voluptatem eligendi vel quas. Provident omnis omnis rerum possimus eos nihil non. Magni ut ut nemo aut sunt ipsam.', 2, 17, 'rejected', 85, 1, '2025-01-05 23:10:45', '2025-03-05 08:12:12'),
(128, 44, 12, 'Hic hic atque alias commodi vel. Illo eaque libero in aliquid natus occaecati. Qui eos aspernatur cum tenetur voluptate odio adipisci. Nobis doloremque atque corrupti dicta ad quis voluptates.', 25, 2, 'draft', 64, 1, '2025-01-07 16:00:16', '2025-04-02 00:06:39'),
(129, 28, 20, 'Qui et explicabo maxime possimus eligendi. Nihil ea qui molestiae a ducimus ullam est.', 50, 1, 'approved', 57, 1, '2024-12-12 11:51:49', '2025-03-15 01:37:50'),
(130, 4, 22, 'Possimus facere ut nostrum quia id rerum qui. Maxime facilis a magni quam eius. Explicabo est libero quia vero et illum. Illo veniam repellendus et. Ipsam voluptatum quia nesciunt corrupti aperiam velit voluptate.', 25, 19, 'approved', 25, 1, '2025-04-03 22:16:34', '2025-04-08 19:42:22'),
(131, 28, 15, 'Et tenetur qui cum explicabo non aut ullam. Autem sed qui quo sint eius adipisci suscipit.', 47, 13, 'approved', 94, 1, '2024-06-13 13:27:33', '2024-07-14 23:47:41'),
(132, 44, 9, 'Quos reiciendis mollitia aut aperiam harum animi reiciendis.', 47, 14, 'rejected', 93, 1, '2024-11-07 09:19:31', '2025-01-01 11:15:39'),
(133, 40, 1, 'Quia numquam quaerat sit aut quas quia ab. Ea iste nulla nam et. Molestias laboriosam repellat sequi corporis vel enim non. Architecto possimus aspernatur reiciendis eaque omnis et quis.', 22, 16, 'draft', 41, 1, '2024-08-04 21:29:09', '2024-09-22 03:46:14'),
(134, 25, 4, 'Velit ut hic nam natus pariatur modi quia. Nam debitis nemo qui nisi quasi. Doloremque quasi temporibus quia vel. Laboriosam autem explicabo facere nihil eum. Delectus fuga et ratione.', 19, 3, 'approved', 15, 1, '2024-12-24 04:32:39', '2025-01-03 20:30:31'),
(135, 23, 19, 'Quos voluptatem assumenda mollitia autem ad. Recusandae voluptates odio inventore est officia repellat. Earum omnis quia et molestias doloremque. Repellendus atque earum quod quasi.', 5, 1, 'draft', 7, 1, '2024-05-10 05:43:07', '2025-03-27 01:30:21'),
(136, 17, 20, 'Iure non atque est atque consequatur repellat cupiditate. Ducimus ad nihil saepe. Soluta magni deleniti illum ut porro ullam. Ducimus ut commodi aperiam excepturi est. Sit fugit consequatur exercitationem eveniet et quia repudiandae. Sunt soluta sed delectus officiis.', 22, 10, 'rejected', 62, 1, '2024-08-31 13:23:28', '2025-01-28 18:47:58'),
(137, 30, 10, 'Pariatur vero fuga eos. Omnis esse cumque omnis fugit asperiores voluptatem. Rem occaecati assumenda voluptatem incidunt ea placeat. Recusandae debitis et beatae eligendi amet voluptas rem. Odio sapiente qui sit distinctio totam.', 42, 8, 'draft', 54, 1, '2024-06-09 18:44:33', '2024-11-30 19:35:28'),
(138, 40, 25, 'Ad nam voluptatum expedita ut impedit illo. Reiciendis error ad nulla placeat asperiores. Provident at modi odio architecto fuga aliquid. Adipisci illum suscipit sint. Porro nihil necessitatibus hic voluptatem blanditiis enim.', 45, 16, 'rejected', 99, 1, '2025-03-16 02:24:46', '2025-03-18 06:57:35'),
(139, 40, 18, 'Aliquam maiores quo modi dolor mollitia nobis. Modi unde ut amet id quia.', 33, 6, 'rejected', 41, 1, '2024-11-22 23:46:28', '2025-02-20 17:44:16'),
(140, 4, 24, 'Quasi tempore aut optio molestias ratione ex libero. Nam ad provident iusto enim. Quasi quae aut et ipsam consequatur velit. Voluptatum suscipit maiores sed.', 47, 12, 'approved', 61, 1, '2024-08-08 05:04:31', '2024-08-10 14:32:29'),
(141, 23, 2, 'Sequi unde magni aut fuga consectetur. Ut quod a dicta non.', 50, 10, 'rejected', 51, 1, '2025-03-25 05:23:46', '2025-04-09 10:08:17'),
(142, 44, 4, 'Odit quod odit ab. Vitae sed non odit aut. Animi non aspernatur corrupti dicta quas explicabo reiciendis.', 36, 17, 'draft', 28, 1, '2024-04-29 07:15:44', '2024-12-24 18:00:54'),
(143, 4, 13, 'Ut mollitia eius quod ut. Enim omnis voluptatibus aut explicabo inventore asperiores. Sint natus et ut et quos. Aut et quisquam hic quod consequatur provident. Rerum et et quia sint rerum est.', 9, 2, 'draft', 65, 1, '2025-02-02 10:34:47', '2025-03-15 12:18:01'),
(144, 28, 25, 'Quo sed ipsa eos natus. Asperiores autem iusto iure pariatur ut modi cum. Dolor eius voluptatem magni ut natus est. Sunt amet corporis expedita accusantium facere optio. Quis vero amet laboriosam adipisci inventore. Sequi rerum omnis est error.', 23, 6, 'approved', 58, 1, '2024-09-14 09:12:42', '2024-12-26 23:04:24'),
(145, 28, 17, 'Reiciendis necessitatibus ipsam adipisci sunt consectetur laboriosam iure. Aut corrupti numquam sunt perferendis pariatur velit.', 27, 6, 'rejected', 84, 1, '2024-06-21 11:07:02', '2024-11-12 04:03:37'),
(146, 23, 18, 'Quod occaecati quidem quae rerum sit eveniet dolorum. Iure nemo sed sed veritatis officiis quibusdam esse. Velit minus officiis ex voluptatibus error dolorem. A deserunt reiciendis beatae aut consequatur velit et beatae.', 35, 16, 'approved', 2, 1, '2024-11-05 04:59:28', '2025-01-09 13:41:50'),
(147, 44, 18, 'Quia culpa ut saepe deserunt commodi optio et. Libero alias enim explicabo eaque temporibus nobis. Et dolorum dolor nulla qui iusto aut. Ut eos a est beatae veniam. Officiis veniam et necessitatibus ea delectus. Et ad officia qui.', 16, 3, 'draft', 64, 1, '2024-08-01 08:08:44', '2024-12-18 08:04:40'),
(148, 4, 9, 'Nobis nemo sunt et exercitationem. Aliquam suscipit aperiam repudiandae ipsum atque.', 4, 15, 'approved', 31, 1, '2024-04-23 17:40:17', '2025-01-22 19:34:05'),
(149, 39, 17, 'Debitis excepturi ea laboriosam sint maiores voluptatem numquam. Inventore sint laudantium natus laboriosam voluptate sed dolores.', 22, 11, 'draft', 42, 1, '2025-03-20 11:05:22', '2025-03-23 19:02:17'),
(150, 30, 12, 'Adipisci distinctio consequuntur et fuga dolor. Minus eligendi et sequi rerum.', 3, 19, 'approved', 86, 1, '2024-12-09 08:30:19', '2025-01-19 08:32:26');

-- --------------------------------------------------------

--
-- Table structure for table `comment_likes`
--

CREATE TABLE `comment_likes` (
  `id` bigint UNSIGNED NOT NULL,
  `comment_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comment_reactions`
--

CREATE TABLE `comment_reactions` (
  `reaction_id` bigint UNSIGNED NOT NULL,
  `comment_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `is_like` tinyint(1) NOT NULL DEFAULT '1',
  `reacted_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `comment_reactions`
--

INSERT INTO `comment_reactions` (`reaction_id`, `comment_id`, `user_id`, `is_like`, `reacted_at`) VALUES
(1, 55, 13, 1, '2024-07-16 16:09:09'),
(2, 58, 4, 1, '2025-03-18 13:51:46'),
(3, 37, 21, 0, '2024-10-09 02:39:42'),
(4, 111, 19, 1, '2025-03-01 02:51:33'),
(5, 144, 3, 0, '2025-03-03 10:49:32'),
(6, 51, 10, 0, '2024-04-18 21:31:14'),
(7, 58, 4, 0, '2025-02-19 04:11:17'),
(8, 105, 18, 0, '2024-08-15 16:33:55'),
(9, 43, 22, 0, '2024-06-03 06:38:01'),
(10, 115, 10, 1, '2024-12-05 18:04:52'),
(11, 21, 4, 0, '2024-08-14 05:30:52'),
(12, 19, 3, 1, '2025-04-05 15:51:10'),
(13, 34, 10, 0, '2025-01-11 00:31:35'),
(14, 115, 3, 1, '2025-02-26 18:18:18'),
(15, 70, 2, 0, '2024-10-05 12:38:22'),
(16, 121, 19, 1, '2025-01-31 20:20:47'),
(17, 49, 11, 1, '2025-01-25 00:25:10'),
(18, 35, 14, 1, '2025-03-20 18:52:44'),
(19, 46, 18, 1, '2024-09-20 19:18:22'),
(20, 103, 5, 0, '2024-04-24 21:30:05'),
(21, 38, 4, 0, '2024-06-17 23:36:30'),
(22, 34, 4, 0, '2024-07-11 16:39:57'),
(23, 14, 21, 1, '2025-02-27 07:20:55'),
(24, 119, 24, 1, '2025-01-24 19:58:10'),
(25, 13, 17, 1, '2025-01-19 16:56:56'),
(26, 121, 17, 0, '2024-09-12 13:23:39'),
(27, 90, 14, 1, '2024-05-28 06:41:23'),
(28, 115, 16, 1, '2024-09-05 08:32:35'),
(29, 64, 22, 1, '2025-02-11 21:39:24'),
(30, 126, 23, 1, '2024-05-12 22:53:12'),
(31, 125, 9, 0, '2024-09-10 07:06:07'),
(32, 53, 9, 0, '2024-09-23 17:08:43'),
(33, 63, 18, 0, '2024-10-18 08:15:53'),
(34, 2, 4, 1, '2024-04-19 16:22:27'),
(35, 148, 11, 0, '2024-10-09 01:50:48'),
(36, 109, 22, 0, '2024-07-19 13:05:20'),
(37, 85, 15, 1, '2024-12-17 02:17:39'),
(38, 91, 4, 1, '2024-12-13 13:46:40'),
(39, 51, 20, 1, '2024-11-27 11:25:05'),
(40, 116, 15, 1, '2025-03-29 16:21:42'),
(41, 80, 23, 1, '2024-12-14 19:07:22'),
(42, 144, 6, 1, '2024-08-26 08:29:33'),
(43, 59, 9, 0, '2024-06-23 20:51:26'),
(44, 90, 22, 1, '2024-07-11 10:17:05'),
(45, 125, 16, 1, '2024-07-14 16:31:46'),
(46, 87, 12, 1, '2025-03-19 17:21:06'),
(47, 1, 24, 1, '2024-08-27 03:34:52'),
(48, 23, 9, 0, '2024-05-03 10:01:43'),
(49, 149, 18, 1, '2025-04-03 03:46:24'),
(50, 82, 23, 0, '2025-03-30 02:18:34'),
(51, 63, 20, 1, '2024-09-28 22:16:36'),
(52, 68, 23, 1, '2024-10-06 13:30:31'),
(53, 131, 8, 1, '2024-07-03 07:00:34'),
(54, 126, 2, 1, '2024-04-23 13:02:06'),
(55, 24, 2, 1, '2024-05-12 04:05:01'),
(56, 77, 16, 1, '2025-02-27 05:30:30'),
(57, 26, 1, 0, '2024-08-06 23:51:43'),
(58, 117, 11, 1, '2024-07-04 18:22:49'),
(59, 60, 1, 1, '2024-09-04 13:00:44'),
(60, 46, 6, 0, '2024-09-06 08:27:21'),
(61, 51, 13, 0, '2024-07-30 01:27:07'),
(62, 9, 20, 1, '2024-07-25 15:09:01'),
(63, 14, 24, 1, '2025-03-10 01:41:43'),
(64, 4, 4, 0, '2024-12-29 17:45:57'),
(65, 88, 4, 0, '2024-04-15 02:27:14'),
(66, 108, 14, 1, '2024-12-17 04:39:26'),
(67, 37, 1, 0, '2024-07-12 14:47:02'),
(68, 134, 9, 1, '2024-05-24 15:32:10'),
(69, 123, 15, 1, '2025-01-09 02:14:37'),
(70, 4, 19, 1, '2024-05-29 20:48:31'),
(71, 149, 15, 0, '2024-07-11 15:22:26'),
(72, 82, 23, 0, '2024-10-22 21:54:02'),
(73, 2, 3, 1, '2024-11-24 09:39:42'),
(74, 114, 16, 1, '2024-08-10 15:23:31'),
(75, 3, 10, 1, '2025-01-28 04:44:57'),
(76, 127, 6, 1, '2024-08-17 21:38:59'),
(77, 88, 1, 1, '2024-11-22 06:19:31'),
(78, 55, 15, 1, '2024-12-18 04:53:18'),
(79, 148, 17, 0, '2024-08-08 20:58:47'),
(80, 28, 10, 1, '2024-04-14 05:57:54'),
(81, 62, 10, 1, '2024-08-15 00:37:07'),
(82, 32, 24, 1, '2025-04-06 13:33:44'),
(83, 32, 5, 0, '2024-09-15 01:37:04'),
(84, 120, 24, 1, '2025-01-25 06:41:39'),
(85, 13, 20, 0, '2024-10-02 22:51:36'),
(86, 130, 17, 0, '2024-04-30 16:12:38'),
(87, 66, 17, 1, '2024-12-19 07:11:06'),
(88, 92, 3, 1, '2024-11-02 19:41:50'),
(89, 64, 17, 1, '2024-09-03 12:53:11'),
(90, 15, 14, 1, '2024-12-13 23:23:14'),
(91, 9, 13, 0, '2024-11-02 15:51:21'),
(92, 113, 22, 1, '2024-09-21 11:32:04'),
(93, 101, 20, 1, '2024-08-02 04:29:54'),
(94, 113, 20, 0, '2024-05-07 20:13:15'),
(95, 47, 17, 1, '2024-09-16 13:11:23'),
(96, 59, 16, 0, '2024-08-07 07:01:37'),
(97, 40, 19, 1, '2025-02-12 06:42:42'),
(98, 106, 4, 1, '2024-07-13 01:09:58'),
(99, 90, 23, 1, '2024-05-01 20:12:44'),
(100, 73, 20, 1, '2024-12-11 02:48:25'),
(101, 39, 19, 1, '2024-08-14 09:53:28'),
(102, 34, 14, 1, '2024-07-12 14:42:51'),
(103, 108, 14, 1, '2025-02-26 21:32:29'),
(104, 149, 21, 1, '2024-04-16 08:06:59'),
(105, 43, 22, 1, '2025-01-22 05:33:21'),
(106, 44, 25, 1, '2024-05-18 09:40:54'),
(107, 6, 14, 0, '2025-03-22 17:59:53'),
(108, 39, 10, 0, '2024-05-16 12:44:49'),
(109, 76, 13, 1, '2024-08-08 18:34:06'),
(110, 54, 22, 0, '2025-02-01 06:06:51'),
(111, 27, 7, 1, '2024-04-27 00:17:02'),
(112, 114, 21, 1, '2024-06-09 13:24:31'),
(113, 76, 14, 0, '2024-07-18 06:28:25'),
(114, 49, 20, 1, '2024-06-10 21:28:54'),
(115, 85, 17, 0, '2025-04-02 21:05:19'),
(116, 115, 1, 1, '2024-12-12 03:23:37'),
(117, 38, 16, 0, '2024-07-10 17:45:00'),
(118, 150, 12, 1, '2025-02-19 00:29:17'),
(119, 93, 14, 1, '2025-04-10 21:56:45'),
(120, 55, 3, 0, '2025-03-06 10:03:07'),
(121, 38, 6, 1, '2024-05-07 17:06:29'),
(122, 99, 16, 1, '2024-06-14 17:46:35'),
(123, 113, 24, 1, '2024-10-21 16:43:39'),
(124, 57, 9, 1, '2025-04-12 10:30:24'),
(125, 3, 14, 0, '2024-08-04 02:06:26'),
(126, 78, 1, 1, '2024-05-23 21:16:13'),
(127, 113, 14, 1, '2025-03-18 22:08:35'),
(128, 142, 11, 1, '2025-01-25 14:59:27'),
(129, 90, 12, 0, '2025-02-01 05:29:56'),
(130, 56, 3, 1, '2025-02-18 12:35:26'),
(131, 87, 17, 1, '2024-09-27 23:52:42'),
(132, 5, 23, 0, '2024-07-08 21:29:51'),
(133, 11, 3, 0, '2024-11-30 08:24:35'),
(134, 71, 19, 1, '2024-08-04 06:11:48'),
(135, 35, 9, 1, '2024-05-20 06:47:05'),
(136, 39, 4, 1, '2024-07-11 01:40:42'),
(137, 34, 17, 1, '2024-07-25 05:47:02'),
(138, 4, 14, 1, '2024-09-14 19:07:12'),
(139, 45, 3, 0, '2025-04-12 23:14:30'),
(140, 118, 17, 1, '2024-06-01 09:13:16'),
(141, 39, 11, 0, '2024-07-21 22:22:00'),
(142, 15, 25, 1, '2025-03-01 02:55:03'),
(143, 78, 16, 1, '2024-11-15 04:42:15'),
(144, 36, 8, 0, '2024-09-03 04:18:32'),
(145, 133, 14, 1, '2024-08-20 17:07:24'),
(146, 90, 22, 0, '2024-11-27 16:04:21'),
(147, 147, 18, 1, '2024-11-18 00:27:25'),
(148, 125, 15, 1, '2024-07-31 09:53:22'),
(149, 116, 15, 1, '2024-11-06 14:11:45'),
(150, 102, 9, 1, '2025-03-09 10:25:55'),
(151, 146, 8, 1, '2024-09-10 01:15:07'),
(152, 41, 23, 0, '2024-07-31 00:46:25'),
(153, 131, 7, 1, '2024-08-29 12:34:31'),
(154, 85, 13, 0, '2025-03-23 20:47:59'),
(155, 100, 16, 0, '2025-04-01 04:37:47'),
(156, 83, 21, 1, '2025-02-18 21:04:05'),
(157, 85, 23, 0, '2024-12-29 03:08:24'),
(158, 104, 25, 1, '2024-09-17 14:21:32'),
(159, 13, 15, 1, '2024-07-20 06:35:23'),
(160, 136, 19, 1, '2024-05-08 04:45:16'),
(161, 119, 6, 0, '2024-10-15 13:17:05'),
(162, 142, 18, 1, '2024-12-08 03:36:02'),
(163, 96, 9, 0, '2024-09-01 17:24:10'),
(164, 59, 16, 1, '2025-03-05 03:38:35'),
(165, 29, 24, 0, '2024-06-12 18:39:15'),
(166, 51, 22, 0, '2025-01-12 06:26:33'),
(167, 109, 19, 0, '2025-02-18 22:11:53'),
(168, 22, 16, 1, '2024-11-13 18:02:03'),
(169, 73, 9, 1, '2025-02-05 02:50:57'),
(170, 148, 19, 1, '2025-04-02 15:16:29'),
(171, 65, 1, 1, '2024-06-01 21:27:47'),
(172, 62, 1, 1, '2024-11-03 15:29:28'),
(173, 76, 7, 1, '2024-09-09 17:59:53'),
(174, 113, 5, 0, '2024-09-07 20:57:40'),
(175, 101, 4, 1, '2024-11-07 23:31:50'),
(176, 48, 17, 0, '2024-08-28 06:15:33'),
(177, 102, 25, 1, '2024-09-05 16:02:30'),
(178, 96, 21, 0, '2024-09-06 01:08:44'),
(179, 122, 21, 0, '2024-10-03 12:25:41'),
(180, 72, 10, 1, '2024-11-04 10:31:52'),
(181, 143, 5, 1, '2024-10-25 20:10:17'),
(182, 21, 12, 1, '2025-02-27 14:32:50'),
(183, 25, 13, 0, '2024-12-20 02:36:19'),
(184, 83, 5, 1, '2024-04-24 12:24:17'),
(185, 135, 15, 0, '2025-02-17 20:33:55'),
(186, 18, 7, 0, '2024-04-15 04:26:53'),
(187, 66, 6, 0, '2025-03-20 03:22:05'),
(188, 144, 11, 0, '2025-02-10 02:39:36'),
(189, 27, 15, 0, '2024-05-18 09:58:48'),
(190, 33, 14, 1, '2024-09-21 18:56:53'),
(191, 99, 4, 0, '2025-02-23 07:14:51'),
(192, 91, 4, 0, '2025-03-29 08:37:49'),
(193, 51, 23, 0, '2024-05-20 02:54:51'),
(194, 127, 5, 1, '2025-01-17 21:24:19'),
(195, 106, 10, 1, '2025-03-13 08:23:00'),
(196, 144, 19, 0, '2024-05-24 15:52:00'),
(197, 128, 20, 1, '2025-04-01 03:58:18'),
(198, 11, 6, 1, '2025-01-09 15:27:48'),
(199, 119, 5, 0, '2024-07-17 13:30:50'),
(200, 106, 21, 1, '2024-09-02 22:35:57');

-- --------------------------------------------------------

--
-- Table structure for table `edit_requests`
--

CREATE TABLE `edit_requests` (
  `id` bigint UNSIGNED NOT NULL,
  `article_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `reason` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('pending','approved','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `rejection_reason` text COLLATE utf8mb4_unicode_ci,
  `approved_at` timestamp NULL DEFAULT NULL,
  `rejected_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `follows`
--

CREATE TABLE `follows` (
  `id` bigint UNSIGNED NOT NULL,
  `follower_id` bigint UNSIGNED NOT NULL,
  `following_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `follows`
--

INSERT INTO `follows` (`id`, `follower_id`, `following_id`, `created_at`, `updated_at`) VALUES
(7, 5, 22, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(2, '2019_08_19_000000_create_failed_jobs_table', 1),
(3, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(4, '2024_04_05_create_writing_guidelines_table', 1),
(5, '2024_05_20_000000_create_moderation_logs_table_fix', 1),
(6, '2024_05_20_100000_update_moderation_logs_table_structure', 1),
(7, '2025_02_09_140249_create_roles_table', 1),
(8, '2025_02_09_140258_create_users_table', 1),
(9, '2025_02_09_140259_add_image_to_users_table', 1),
(10, '2025_02_09_140303_create_categories_table', 1),
(11, '2025_02_09_140310_create_articles_table', 1),
(12, '2025_02_09_140315_create_article_history_table', 1),
(13, '2025_02_09_140320_create_approvals_table', 1),
(14, '2025_02_09_140325_create_comments_table', 1),
(15, '2025_02_09_140331_create_comment_reactions_table', 1),
(16, '2025_02_09_140338_create_prohibited_words_table', 1),
(17, '2025_02_09_140344_create_violations_table', 1),
(18, '2025_02_09_140349_create_article_views_table', 1),
(19, '2025_02_09_140355_create_article_likes_table', 1),
(20, '2025_02_09_140400_create_tags_table', 1),
(21, '2025_02_09_140405_create_article_tags_table', 1),
(22, '2025_02_09_140410_create_article_media_table', 1),
(23, '2025_02_10_171007_create_jobs_table', 1),
(24, '2025_02_27_152900_create_notifications_table', 1),
(25, '2025_03_07_042228_update_approvals_table_add_user_id_and_nullable_remarks', 1),
(26, '2025_03_07_042831_add_updated_at_to_approvals_table', 1),
(27, '2025_03_08_020707_add_rejected_to_articles_status', 1),
(28, '2025_03_09_131250_alter_approvals_requested_role_nullable', 1),
(29, '2025_03_09_133826_add_type_to_approvals_table', 1),
(30, '2025_03_12_021855_create_article_saves_table', 1),
(31, '2025_03_12_063501_create_news_table', 1),
(32, '2025_03_17_084332_add_moderation_fields_to_approvals_table', 1),
(33, '2025_03_25_114740_create_follows_table', 1),
(34, '2025_04_03_045149_update_comments_table_add_cascade', 1),
(35, '2025_04_05_041054_update_categories_table_add_moderator_id', 1),
(36, '2025_04_06_210332_create_article_versions_table', 1),
(37, '2025_04_07_000000_modify_article_versions_table', 1),
(38, '2025_04_08_025051_create_comment_likes_table', 1),
(39, '2025_04_08_234544_create_moderation_logs_table_fix', 1),
(40, '2025_04_10_155656_add_last_violation_at_to_users_table', 1),
(41, '2025_04_11_171327_add_edit_requests_table', 1),
(42, '2025_04_11_193608_add_reason_to_approvals_table', 1),
(43, '2025_05_01_000000_add_parent_id_to_categories_table', 1),
(44, '2025_05_01_000001_add_subcategory_id_to_articles_table', 1),
(45, '2025_05_01_000002_update_existing_data_for_categories', 1),
(46, '2025_05_01_000003_add_foreign_key_to_moderation_logs', 1);

-- --------------------------------------------------------

--
-- Table structure for table `moderation_logs`
--

CREATE TABLE `moderation_logs` (
  `log_id` bigint UNSIGNED NOT NULL,
  `content_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content_id` bigint UNSIGNED NOT NULL,
  `action_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `moderator_id` bigint UNSIGNED NOT NULL,
  `after_state` text COLLATE utf8mb4_unicode_ci,
  `severity` enum('none','low','medium','high') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'none',
  `reason` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `details` text COLLATE utf8mb4_unicode_ci,
  `before_state` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `moderation_logs`
--

INSERT INTO `moderation_logs` (`log_id`, `content_type`, `content_id`, `action_type`, `moderator_id`, `after_state`, `severity`, `reason`, `created_at`, `updated_at`, `details`, `before_state`) VALUES
(1, 'article', 1, 'approve', 1, '{\"status\":\"published\",\"approved_by\":1,\"published_at\":\"2025-04-14 11:01:07\"}', 'none', NULL, '2025-04-14 04:01:07', '2025-04-14 04:01:07', '{\"title\":\"Qui qui non sed incidunt quia. 67fc6aa1078ee\",\"author_id\":22,\"category_id\":2,\"action\":\"Ph\\u00ea duy\\u1ec7t b\\u00e0i vi\\u1ebft\"}', '{\"status\":\"pending\",\"approved_by\":null}'),
(2, 'article', 22, 'approve', 1, '{\"status\":\"published\",\"approved_by\":1,\"published_at\":\"2025-04-14 11:04:03\"}', 'none', NULL, '2025-04-14 04:04:03', '2025-04-14 04:04:03', '{\"title\":\"Autem corrupti ipsum nihil distinctio voluptatem. 67fc6aa165eab\",\"author_id\":5,\"category_id\":1,\"action\":\"Ph\\u00ea duy\\u1ec7t b\\u00e0i vi\\u1ebft\"}', '{\"status\":\"pending\",\"approved_by\":null}'),
(3, 'article', 51, 'approve', 1, '{\"status\":\"published\",\"approved_by\":1,\"published_at\":\"2025-04-18 21:53:45\"}', 'none', NULL, '2025-04-18 14:53:45', '2025-04-18 14:53:45', '{\"title\":\"C\\u00f3 3 c\\u00e2y v\\u00e0ng v\\u00e0 200 tri\\u1ec7u ti\\u1ebft ki\\u1ec7m, n\\u00ean mua nh\\u00e0 n\\u0103m sau kh\\u00f4ng?C\\u00f3 3 c\\u00e2y v\\u00e0ng v\\u00e0 200 tri\\u1ec7u ti\\u1ebft ki\\u1ec7m, n\\u00ean mua nh\\u00e0 n\\u0103m sau kh\\u00f4ng?\",\"author_id\":1,\"category_id\":1,\"action\":\"Ph\\u00ea duy\\u1ec7t b\\u00e0i vi\\u1ebft\"}', '{\"status\":\"pending\",\"approved_by\":null}');

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint UNSIGNED NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('0686399d-254a-475b-802b-e7d23d4c8e23', 'App\\Notifications\\ArticleStatusUpdated', 'App\\Models\\User', 1, '{\"article_id\":null,\"title\":\"C\\u00f3 3 c\\u00e2y v\\u00e0ng v\\u00e0 200 tri\\u1ec7u ti\\u1ebft ki\\u1ec7m, n\\u00ean mua nh\\u00e0 n\\u0103m sau kh\\u00f4ng?C\\u00f3 3 c\\u00e2y v\\u00e0ng v\\u00e0 200 tri\\u1ec7u ti\\u1ebft ki\\u1ec7m, n\\u00ean mua nh\\u00e0 n\\u0103m sau kh\\u00f4ng?\",\"message\":\"B\\u00e0i vi\\u1ebft \'C\\u00f3 3 c\\u00e2y v\\u00e0ng v\\u00e0 200 tri\\u1ec7u ti\\u1ebft ki\\u1ec7m, n\\u00ean mua nh\\u00e0 n\\u0103m sau kh\\u00f4ng?C\\u00f3 3 c\\u00e2y v\\u00e0ng v\\u00e0 200 tri\\u1ec7u ti\\u1ebft ki\\u1ec7m, n\\u00ean mua nh\\u00e0 n\\u0103m sau kh\\u00f4ng?\' c\\u1ee7a b\\u1ea1n \\u0111\\u00e3 \\u0111\\u01b0\\u1ee3c duy\\u1ec7t.\",\"status\":\"published\",\"updated_at\":\"2025-04-18T14:53:46.997759Z\"}', NULL, '2025-04-18 14:53:46', '2025-04-18 14:53:46'),
('1f56ac9d-7929-4c0a-98f9-b56c87d52bcc', 'App\\Notifications\\ArticleStatusUpdated', 'App\\Models\\User', 5, '{\"article_id\":null,\"title\":\"Autem corrupti ipsum nihil distinctio voluptatem. 67fc6aa165eab\",\"message\":\"B\\u00e0i vi\\u1ebft \'Autem corrupti ipsum nihil distinctio voluptatem. 67fc6aa165eab\' c\\u1ee7a b\\u1ea1n \\u0111\\u00e3 \\u0111\\u01b0\\u1ee3c duy\\u1ec7t.\",\"status\":\"published\",\"updated_at\":\"2025-04-14T04:04:03.075799Z\"}', NULL, '2025-04-14 04:04:03', '2025-04-14 04:04:03'),
('469e8849-f4d2-424d-aa96-ab9661f47b22', 'App\\Notifications\\NewArticleFromFollowedAuthor', 'App\\Models\\User', 5, '{\"type\":\"new_article\",\"message\":\"Prof. Reva Fritsch V v\\u1eeba \\u0111\\u0103ng b\\u00e0i vi\\u1ebft m\\u1edbi: Qui qui non sed incidunt quia. 67fc6aa1078ee\",\"article_id\":null,\"article_slug\":\"qui-qui-non-sed-incidunt-quia-67fc6aa1078ee\",\"author_id\":22,\"author_name\":\"Prof. Reva Fritsch V\",\"author_avatar\":\"http:\\/\\/24hnews.test\\/images\\/default-avatar.png\",\"published_at\":\"2025-04-26 23:02:55\",\"thumbnail_url\":\"thumbnails\\/\",\"url\":\"http:\\/\\/24hnews.test\\/admin\\/articles\\/qui-qui-non-sed-incidunt-quia-67fc6aa1078ee\"}', NULL, '2025-04-26 16:02:55', '2025-04-26 16:02:55'),
('72d7c9e6-05be-4f68-bd5b-65c1b6bdb157', 'App\\Notifications\\ArticleStatusUpdated', 'App\\Models\\User', 22, '{\"article_id\":null,\"title\":\"Qui qui non sed incidunt quia. 67fc6aa1078ee\",\"message\":\"B\\u00e0i vi\\u1ebft \'Qui qui non sed incidunt quia. 67fc6aa1078ee\' c\\u1ee7a b\\u1ea1n \\u0111\\u00e3 \\u0111\\u01b0\\u1ee3c duy\\u1ec7t.\",\"status\":\"published\",\"updated_at\":\"2025-04-14T04:01:09.327512Z\"}', NULL, '2025-04-14 04:01:09', '2025-04-14 04:01:09'),
('a0613490-3c58-42d9-a4c8-4278efe0e0c1', 'App\\Notifications\\NewArticleFromFollowedAuthor', 'App\\Models\\User', 5, '{\"type\":\"new_article\",\"message\":\"Prof. Reva Fritsch V v\\u1eeba \\u0111\\u0103ng b\\u00e0i vi\\u1ebft m\\u1edbi: Qui qui non sed incidunt quia. 67fc6aa1078ee\",\"article_id\":null,\"article_slug\":\"qui-qui-non-sed-incidunt-quia-67fc6aa1078ee\",\"author_id\":22,\"author_name\":\"Prof. Reva Fritsch V\",\"author_avatar\":\"http:\\/\\/24hnews.test\\/images\\/default-avatar.png\",\"published_at\":\"2025-04-26 23:02:55\",\"thumbnail_url\":\"thumbnails\\/\",\"url\":\"http:\\/\\/24hnews.test\\/admin\\/articles\\/qui-qui-non-sed-incidunt-quia-67fc6aa1078ee\"}', NULL, '2025-04-26 16:02:55', '2025-04-26 16:02:55');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `prohibited_words`
--

CREATE TABLE `prohibited_words` (
  `word_id` bigint UNSIGNED NOT NULL,
  `word` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `role_id` bigint UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'Full rules', '2025-04-14 01:53:34', '2025-04-14 01:53:34'),
(2, 'author', 'crud articles', '2025-04-14 01:53:34', '2025-04-14 01:53:34'),
(3, 'moderator', 'review articles and comments', '2025-04-14 01:53:34', '2025-04-14 01:53:34'),
(4, 'user', 'read articles and comments...', '2025-04-14 01:53:34', '2025-04-14 01:53:34');

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `tag_id` bigint UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`tag_id`, `name`, `description`) VALUES
(1, 'rerum_67fc6aa104296', 'Voluptatem delectus non error blanditiis.'),
(2, 'accusantium_67fc6aa1042d5', 'Odio natus eius a et expedita ratione.'),
(3, 'nulla_67fc6aa1042f7', 'In tenetur dolorum aliquid facilis eius nesciunt exercitationem.'),
(4, 'voluptatem_67fc6aa104318', 'Voluptate est corporis ducimus necessitatibus et quidem pariatur iste.'),
(5, 'pariatur_67fc6aa10433a', 'Ea itaque eum cupiditate aut saepe eos quam.'),
(6, 'libero_67fc6aa10435b', 'Necessitatibus quibusdam at odio in sequi.'),
(7, 'eos_67fc6aa104376', 'Animi sapiente autem eum.'),
(8, 'quasi_67fc6aa10438f', 'Sequi est eveniet officia sint earum nesciunt veritatis.'),
(9, 'expedita_67fc6aa1043ad', 'Distinctio et nostrum ea minima enim sint pariatur neque.'),
(10, 'asperiores_67fc6aa1043cb', 'Dolorum est iure ut rerum adipisci.'),
(11, 'est_67fc6aa1043e6', 'Dolores necessitatibus eum et tempora consequatur repellat.'),
(12, 'nobis_67fc6aa104403', 'Amet fugit quibusdam soluta magnam.'),
(13, 'id_67fc6aa10441d', 'Voluptas tempore atque blanditiis totam dolorum qui.'),
(14, 'esse_67fc6aa104439', 'Quia repellendus consequatur dolorem voluptas eveniet.'),
(15, 'modi_67fc6aa104455', 'Doloribus dolor modi placeat repellendus sint.'),
(16, 'molestiae_67fc6aa104473', 'Architecto omnis ab adipisci ut atque non.'),
(17, 'ad_67fc6aa10448f', 'Voluptas a voluptatem dolorem eius et occaecati accusantium.'),
(18, 'et_67fc6aa1044ad', 'Quae dolorem ut illo consequatur autem.'),
(19, 'magnam_67fc6aa1044c8', 'Explicabo explicabo eius ipsam voluptatibus laboriosam ut quaerat.'),
(20, 'enim_67fc6aa1044e5', 'Eos ipsa repellat recusandae.');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` bigint UNSIGNED NOT NULL,
  `fullname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role_id` bigint UNSIGNED NOT NULL DEFAULT '4',
  `is_promoted` tinyint(1) NOT NULL DEFAULT '0',
  `violation_count` int NOT NULL DEFAULT '0',
  `last_violation_at` datetime DEFAULT NULL,
  `banned_until` timestamp NULL DEFAULT NULL,
  `provider` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `fullname`, `dob`, `address`, `username`, `description`, `phone`, `image`, `email`, `email_verified_at`, `password`, `remember_token`, `role_id`, `is_promoted`, `violation_count`, `last_violation_at`, `banned_until`, `provider`, `provider_id`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, NULL, 'ADMIN', NULL, '0356584633', NULL, 'admin@example.com', NULL, '$2y$12$k/2trebSx9t7ksPCCTptJers8fsg7hUTm542Xl/pM3riOoHdaPbv.', NULL, 1, 1, 0, NULL, NULL, NULL, NULL, '2025-04-14 01:53:34', '2025-04-14 01:53:34'),
(2, NULL, NULL, NULL, 'Kiểm Duyệt', NULL, '012345678', NULL, 'kdv@example.com', NULL, '$2y$12$pQfZYERmYXH97inIi7UiP.59T6KGPay2C7g7sMexw4.gp45dc9ldO', NULL, 3, 1, 0, NULL, NULL, NULL, NULL, '2025-04-14 01:53:34', '2025-04-14 01:53:34'),
(3, NULL, NULL, NULL, 'Kiểm Duyệt 2', NULL, '012345678', NULL, 'kdv2@example.com', NULL, '$2y$12$Nc3LLzsg3eCS5unZ0HBl4.02RCbdX5QB6B3FI2lvGsA7RmmS8B4.q', NULL, 3, 1, 0, NULL, NULL, NULL, NULL, '2025-04-14 01:53:34', '2025-04-14 01:53:34'),
(4, NULL, NULL, NULL, 'Tác Giả', NULL, '0912345678', NULL, 'tacgia@example.com', NULL, '$2y$12$MzGDNjjhTvumcs.h/sEP.ut9z5.fHMli1A3j4ZQabBQ8hGazn2W6C', NULL, 2, 0, 1, NULL, NULL, NULL, NULL, '2025-04-14 01:53:34', '2025-04-14 01:53:34'),
(5, NULL, NULL, NULL, 'User1', 'ịceiowjf9ewjfp9we', '0923456789', NULL, 'user@example.com', NULL, '$2y$12$j0bpaUi.CvraGKW/oUd5zu50yxZ2ORWvuzTA1yAWB3vb9SxyjzhVu', NULL, 4, 0, 0, NULL, NULL, NULL, NULL, '2025-04-14 01:53:34', '2025-04-17 05:31:40'),
(6, NULL, NULL, NULL, 'Keshaun McCullough DVM', NULL, '8786020900', NULL, 'cdoyle@example.net', '2025-04-14 01:53:36', '$2y$12$9JloYLz6pFX.XrtQsXu0ueRAJIF..RumvxMFX0TQKIwX.b./FjyNC', 'SWcC0XHV2B', 3, 0, 0, NULL, NULL, NULL, NULL, '2025-04-14 01:53:36', '2025-04-14 01:53:36'),
(7, NULL, NULL, NULL, 'Baby DuBuque Jr.', NULL, '13237704259', NULL, 'luna84@example.org', '2025-04-14 01:53:36', '$2y$12$9JloYLz6pFX.XrtQsXu0ueRAJIF..RumvxMFX0TQKIwX.b./FjyNC', 'lTgxNxljhP', 2, 0, 0, NULL, NULL, NULL, NULL, '2025-04-14 01:53:36', '2025-04-14 01:53:36'),
(8, NULL, NULL, NULL, 'Nicolette Robel', NULL, '7197373845', NULL, 'kuphal.paris@example.com', '2025-04-14 01:53:36', '$2y$12$9JloYLz6pFX.XrtQsXu0ueRAJIF..RumvxMFX0TQKIwX.b./FjyNC', 'aijexK1kcX', 3, 0, 0, NULL, NULL, NULL, NULL, '2025-04-14 01:53:36', '2025-04-14 01:53:36'),
(9, NULL, NULL, NULL, 'Dr. Charlotte Dietrich III', NULL, '7435374986', NULL, 'atromp@example.com', '2025-04-14 01:53:36', '$2y$12$9JloYLz6pFX.XrtQsXu0ueRAJIF..RumvxMFX0TQKIwX.b./FjyNC', 'PNbWG4mOAB', 1, 0, 0, NULL, NULL, NULL, NULL, '2025-04-14 01:53:36', '2025-04-14 01:53:36'),
(10, NULL, NULL, NULL, 'Lucas Ferry', NULL, '15103379048', NULL, 'ines.macejkovic@example.net', '2025-04-14 01:53:36', '$2y$12$9JloYLz6pFX.XrtQsXu0ueRAJIF..RumvxMFX0TQKIwX.b./FjyNC', 'tR0WlwO7wl', 1, 0, 0, NULL, NULL, NULL, NULL, '2025-04-14 01:53:36', '2025-04-14 01:53:36'),
(11, NULL, NULL, NULL, 'Mrs. Kaylee Renner DVM', NULL, '4758957614', NULL, 'marietta33@example.org', '2025-04-14 01:53:36', '$2y$12$9JloYLz6pFX.XrtQsXu0ueRAJIF..RumvxMFX0TQKIwX.b./FjyNC', 'P42lHliYsX', 3, 0, 0, NULL, NULL, NULL, NULL, '2025-04-14 01:53:36', '2025-04-14 01:53:36'),
(12, NULL, NULL, NULL, 'Mr. Thad Crona', NULL, '13864152982', NULL, 'zwiegand@example.com', '2025-04-14 01:53:36', '$2y$12$9JloYLz6pFX.XrtQsXu0ueRAJIF..RumvxMFX0TQKIwX.b./FjyNC', 'wVk1J45DL6', 1, 0, 0, NULL, NULL, NULL, NULL, '2025-04-14 01:53:36', '2025-04-14 01:53:36'),
(13, NULL, NULL, NULL, 'Genesis O\'Kon', NULL, '17318154820', NULL, 'xgutmann@example.net', '2025-04-14 01:53:36', '$2y$12$9JloYLz6pFX.XrtQsXu0ueRAJIF..RumvxMFX0TQKIwX.b./FjyNC', 'QoQuM7FP7w', 2, 0, 0, NULL, NULL, NULL, NULL, '2025-04-14 01:53:36', '2025-04-14 01:53:36'),
(14, NULL, NULL, NULL, 'Waldo Hodkiewicz', NULL, '5137381341', NULL, 'stromp@example.net', '2025-04-14 01:53:36', '$2y$12$9JloYLz6pFX.XrtQsXu0ueRAJIF..RumvxMFX0TQKIwX.b./FjyNC', 'ITETjHpOre', 3, 0, 0, NULL, NULL, NULL, NULL, '2025-04-14 01:53:36', '2025-04-14 01:53:36'),
(15, NULL, NULL, NULL, 'Austen Welch', NULL, '13327235791', NULL, 'paucek.domenico@example.net', '2025-04-14 01:53:36', '$2y$12$9JloYLz6pFX.XrtQsXu0ueRAJIF..RumvxMFX0TQKIwX.b./FjyNC', 'Ienoouclzr', 1, 0, 0, NULL, NULL, NULL, NULL, '2025-04-14 01:53:36', '2025-04-14 01:53:36'),
(16, NULL, NULL, NULL, 'Dr. Nils McGlynn PhD', NULL, '4588873497', NULL, 'holden.stoltenberg@example.net', '2025-04-14 01:53:36', '$2y$12$9JloYLz6pFX.XrtQsXu0ueRAJIF..RumvxMFX0TQKIwX.b./FjyNC', 'W7iXbZoKpc', 2, 0, 0, NULL, NULL, NULL, NULL, '2025-04-14 01:53:36', '2025-04-14 01:53:36'),
(17, NULL, NULL, NULL, 'Lilyan Mertz', NULL, '15808886449', NULL, 'ubergstrom@example.com', '2025-04-14 01:53:36', '$2y$12$9JloYLz6pFX.XrtQsXu0ueRAJIF..RumvxMFX0TQKIwX.b./FjyNC', 'AaRJDA1oSP', 3, 0, 0, NULL, NULL, NULL, NULL, '2025-04-14 01:53:36', '2025-04-14 01:53:36'),
(18, NULL, NULL, NULL, 'Chyna Hamill', NULL, '12035487371', NULL, 'frutherford@example.net', '2025-04-14 01:53:36', '$2y$12$9JloYLz6pFX.XrtQsXu0ueRAJIF..RumvxMFX0TQKIwX.b./FjyNC', 'NulvXEMj1i', 1, 0, 0, NULL, NULL, NULL, NULL, '2025-04-14 01:53:36', '2025-04-14 01:53:36'),
(19, NULL, NULL, NULL, 'Mr. Arch Muller', NULL, '17435085260', NULL, 'elinore57@example.org', '2025-04-14 01:53:36', '$2y$12$9JloYLz6pFX.XrtQsXu0ueRAJIF..RumvxMFX0TQKIwX.b./FjyNC', 'iT86egRi7W', 3, 0, 0, NULL, NULL, NULL, NULL, '2025-04-14 01:53:36', '2025-04-14 01:53:36'),
(20, NULL, NULL, NULL, 'Mr. Omari Nolan', NULL, '14016122284', NULL, 'anahi95@example.org', '2025-04-14 01:53:36', '$2y$12$9JloYLz6pFX.XrtQsXu0ueRAJIF..RumvxMFX0TQKIwX.b./FjyNC', 'gyq114A7Ab', 1, 0, 0, NULL, NULL, NULL, NULL, '2025-04-14 01:53:36', '2025-04-14 01:53:36'),
(21, NULL, NULL, NULL, 'Jovan Runolfsson', NULL, '14028228358', NULL, 'jacobson.norberto@example.net', '2025-04-14 01:53:36', '$2y$12$9JloYLz6pFX.XrtQsXu0ueRAJIF..RumvxMFX0TQKIwX.b./FjyNC', 'tP1n0Sk9ID', 3, 0, 0, NULL, NULL, NULL, NULL, '2025-04-14 01:53:36', '2025-04-14 01:53:36'),
(22, NULL, NULL, NULL, 'Prof. Reva Fritsch V', NULL, '6695170532', NULL, 'shakira.simonis@example.net', '2025-04-14 01:53:36', '$2y$12$9JloYLz6pFX.XrtQsXu0ueRAJIF..RumvxMFX0TQKIwX.b./FjyNC', '18sQ8oZQd0', 2, 0, 0, NULL, NULL, NULL, NULL, '2025-04-14 01:53:36', '2025-04-14 01:53:36'),
(23, NULL, NULL, NULL, 'Adella Jacobs', NULL, '13233377082', NULL, 'goldner.meaghan@example.net', '2025-04-14 01:53:36', '$2y$12$9JloYLz6pFX.XrtQsXu0ueRAJIF..RumvxMFX0TQKIwX.b./FjyNC', 'TJ43lKysT4', 2, 0, 0, NULL, NULL, NULL, NULL, '2025-04-14 01:53:36', '2025-04-14 01:53:36'),
(24, NULL, NULL, NULL, 'Miss Miracle Homenick', NULL, '8655731234', NULL, 'jcrooks@example.com', '2025-04-14 01:53:36', '$2y$12$9JloYLz6pFX.XrtQsXu0ueRAJIF..RumvxMFX0TQKIwX.b./FjyNC', 'vxtOEWHeIY', 1, 0, 0, NULL, NULL, NULL, NULL, '2025-04-14 01:53:36', '2025-04-14 01:53:36'),
(25, NULL, NULL, NULL, 'Miss Kellie Pfannerstill', NULL, '3219169329', NULL, 'streich.alfonso@example.com', '2025-04-14 01:53:36', '$2y$12$9JloYLz6pFX.XrtQsXu0ueRAJIF..RumvxMFX0TQKIwX.b./FjyNC', 'AILwWIFg9C', 3, 0, 0, NULL, NULL, NULL, NULL, '2025-04-14 01:53:36', '2025-04-14 01:53:36'),
(26, NULL, NULL, NULL, 'Echyasuo2004', NULL, '0978734390', NULL, 'hoangtiendat.20042011@gmail.com', NULL, '$2y$12$6nlC1lUq5YPGhALSr4CkFuqc0QZghbypCs0MQpG6Fz3gKM8AGLv8G', NULL, 4, 0, 0, NULL, NULL, NULL, NULL, '2025-04-23 15:46:39', '2025-04-23 15:46:39');

-- --------------------------------------------------------

--
-- Table structure for table `violations`
--

CREATE TABLE `violations` (
  `violation_id` bigint UNSIGNED NOT NULL,
  `type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reference_id` int NOT NULL,
  `detected_word` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `detected_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `handled_by` bigint UNSIGNED DEFAULT NULL,
  `status` enum('pending','resolved') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `warning_sent` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `violations`
--

INSERT INTO `violations` (`violation_id`, `type`, `reference_id`, `detected_word`, `detected_at`, `handled_by`, `status`, `warning_sent`) VALUES
(1, 'article', 16, 'Nội dung không phù hợp', '2025-04-17 05:39:13', NULL, 'pending', 0),
(2, 'article', 23, 'Ngôn từ kích động', '2025-04-23 20:48:48', NULL, 'pending', 0),
(3, 'article', 23, 'Ngôn từ kích động', '2025-04-23 20:48:48', NULL, 'pending', 0),
(4, 'article', 23, 'Ngôn từ kích động', '2025-04-23 20:48:48', NULL, 'pending', 0),
(5, 'article', 23, 'Ngôn từ kích động', '2025-04-23 20:48:48', NULL, 'pending', 0),
(6, 'article', 23, 'Ngôn từ kích động', '2025-04-23 20:48:48', NULL, 'pending', 0),
(7, 'article', 23, 'Ngôn từ kích động', '2025-04-23 20:48:48', NULL, 'pending', 0),
(8, 'article', 23, 'Ngôn từ kích động', '2025-04-23 20:48:49', NULL, 'pending', 0),
(9, 'article', 23, 'Ngôn từ kích động', '2025-04-23 20:48:49', NULL, 'pending', 0),
(10, 'article', 23, 'Ngôn từ kích động csedfds', '2025-04-23 20:48:49', NULL, 'pending', 0),
(11, 'article', 23, 'Ngôn từ kích động', '2025-04-23 20:48:49', NULL, 'pending', 0),
(12, 'article', 23, 'Ngôn từ kích động', '2025-04-23 20:48:49', NULL, 'pending', 0),
(13, 'article', 23, 'Ngôn từ kích động', '2025-04-23 20:48:49', NULL, 'pending', 0),
(14, 'article', 23, 'Ngôn từ kích động csedfds', '2025-04-23 20:48:49', NULL, 'pending', 0),
(15, 'article', 23, 'Ngôn từ kích động csedfds', '2025-04-23 20:48:49', NULL, 'pending', 0),
(16, 'article', 23, 'Ngôn từ kích động csedfds', '2025-04-23 20:48:49', NULL, 'pending', 0);

-- --------------------------------------------------------

--
-- Table structure for table `writing_guidelines`
--

CREATE TABLE `writing_guidelines` (
  `guideline_id` bigint UNSIGNED NOT NULL,
  `category` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `requirements` text COLLATE utf8mb4_unicode_ci,
  `is_required` tinyint(1) NOT NULL DEFAULT '0',
  `validation_rules` json DEFAULT NULL,
  `order` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `approvals`
--
ALTER TABLE `approvals`
  ADD PRIMARY KEY (`approval_id`),
  ADD KEY `approvals_article_id_foreign` (`article_id`),
  ADD KEY `approvals_user_id_foreign` (`user_id`),
  ADD KEY `approvals_approved_by_foreign` (`approved_by`),
  ADD KEY `approvals_processed_by_foreign` (`processed_by`);

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`article_id`),
  ADD UNIQUE KEY `articles_slug_unique` (`slug`),
  ADD UNIQUE KEY `articles_code_unique` (`code`),
  ADD KEY `articles_author_id_foreign` (`author_id`),
  ADD KEY `articles_category_id_foreign` (`category_id`),
  ADD KEY `articles_approved_by_foreign` (`approved_by`),
  ADD KEY `articles_subcategory_id_foreign` (`subcategory_id`);

--
-- Indexes for table `article_history`
--
ALTER TABLE `article_history`
  ADD PRIMARY KEY (`history_id`),
  ADD KEY `article_history_article_id_foreign` (`article_id`),
  ADD KEY `article_history_edited_by_foreign` (`edited_by`);

--
-- Indexes for table `article_likes`
--
ALTER TABLE `article_likes`
  ADD PRIMARY KEY (`like_id`),
  ADD KEY `article_likes_article_id_foreign` (`article_id`),
  ADD KEY `article_likes_user_id_foreign` (`user_id`);

--
-- Indexes for table `article_media`
--
ALTER TABLE `article_media`
  ADD PRIMARY KEY (`media_id`),
  ADD KEY `article_media_article_id_foreign` (`article_id`);

--
-- Indexes for table `article_saves`
--
ALTER TABLE `article_saves`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `article_saves_article_id_user_id_unique` (`article_id`,`user_id`),
  ADD KEY `article_saves_user_id_foreign` (`user_id`);

--
-- Indexes for table `article_tags`
--
ALTER TABLE `article_tags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `article_tags_article_id_tag_id_unique` (`article_id`,`tag_id`),
  ADD KEY `article_tags_tag_id_foreign` (`tag_id`);

--
-- Indexes for table `article_versions`
--
ALTER TABLE `article_versions`
  ADD PRIMARY KEY (`version_id`),
  ADD KEY `article_versions_article_id_foreign` (`article_id`),
  ADD KEY `article_versions_user_id_foreign` (`user_id`),
  ADD KEY `article_versions_category_id_foreign` (`category_id`),
  ADD KEY `article_versions_subcategory_id_foreign` (`subcategory_id`);

--
-- Indexes for table `article_views`
--
ALTER TABLE `article_views`
  ADD PRIMARY KEY (`view_id`),
  ADD KEY `article_views_article_id_foreign` (`article_id`),
  ADD KEY `article_views_user_id_foreign` (`user_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`),
  ADD UNIQUE KEY `categories_name_unique` (`name`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`),
  ADD KEY `categories_moderator_id_foreign` (`moderator_id`),
  ADD KEY `categories_parent_id_foreign` (`parent_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `comments_article_id_foreign` (`article_id`),
  ADD KEY `comments_user_id_foreign` (`user_id`),
  ADD KEY `comments_parent_id_foreign` (`parent_id`);

--
-- Indexes for table `comment_likes`
--
ALTER TABLE `comment_likes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `comment_likes_comment_id_user_id_unique` (`comment_id`,`user_id`);

--
-- Indexes for table `comment_reactions`
--
ALTER TABLE `comment_reactions`
  ADD PRIMARY KEY (`reaction_id`),
  ADD KEY `comment_reactions_comment_id_foreign` (`comment_id`),
  ADD KEY `comment_reactions_user_id_foreign` (`user_id`);

--
-- Indexes for table `edit_requests`
--
ALTER TABLE `edit_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `edit_requests_article_id_foreign` (`article_id`),
  ADD KEY `edit_requests_user_id_foreign` (`user_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `follows`
--
ALTER TABLE `follows`
  ADD PRIMARY KEY (`id`),
  ADD KEY `follows_follower_id_foreign` (`follower_id`),
  ADD KEY `follows_following_id_foreign` (`following_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `moderation_logs`
--
ALTER TABLE `moderation_logs`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `moderation_logs_moderator_id_foreign` (`moderator_id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `prohibited_words`
--
ALTER TABLE `prohibited_words`
  ADD PRIMARY KEY (`word_id`),
  ADD UNIQUE KEY `prohibited_words_word_unique` (`word`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`tag_id`),
  ADD UNIQUE KEY `tags_name_unique` (`name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_provider_id_unique` (`provider_id`),
  ADD KEY `users_role_id_foreign` (`role_id`);

--
-- Indexes for table `violations`
--
ALTER TABLE `violations`
  ADD PRIMARY KEY (`violation_id`),
  ADD KEY `violations_handled_by_foreign` (`handled_by`);

--
-- Indexes for table `writing_guidelines`
--
ALTER TABLE `writing_guidelines`
  ADD PRIMARY KEY (`guideline_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `approvals`
--
ALTER TABLE `approvals`
  MODIFY `approval_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `articles`
--
ALTER TABLE `articles`
  MODIFY `article_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `article_history`
--
ALTER TABLE `article_history`
  MODIFY `history_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `article_likes`
--
ALTER TABLE `article_likes`
  MODIFY `like_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=158;

--
-- AUTO_INCREMENT for table `article_media`
--
ALTER TABLE `article_media`
  MODIFY `media_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `article_saves`
--
ALTER TABLE `article_saves`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `article_tags`
--
ALTER TABLE `article_tags`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=176;

--
-- AUTO_INCREMENT for table `article_views`
--
ALTER TABLE `article_views`
  MODIFY `view_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=153;

--
-- AUTO_INCREMENT for table `comment_likes`
--
ALTER TABLE `comment_likes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `comment_reactions`
--
ALTER TABLE `comment_reactions`
  MODIFY `reaction_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=201;

--
-- AUTO_INCREMENT for table `edit_requests`
--
ALTER TABLE `edit_requests`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `follows`
--
ALTER TABLE `follows`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `moderation_logs`
--
ALTER TABLE `moderation_logs`
  MODIFY `log_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prohibited_words`
--
ALTER TABLE `prohibited_words`
  MODIFY `word_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `tag_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `violations`
--
ALTER TABLE `violations`
  MODIFY `violation_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `writing_guidelines`
--
ALTER TABLE `writing_guidelines`
  MODIFY `guideline_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `approvals`
--
ALTER TABLE `approvals`
  ADD CONSTRAINT `approvals_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `approvals_article_id_foreign` FOREIGN KEY (`article_id`) REFERENCES `articles` (`article_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `approvals_processed_by_foreign` FOREIGN KEY (`processed_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `approvals_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `articles_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `articles_author_id_foreign` FOREIGN KEY (`author_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `articles_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `articles_subcategory_id_foreign` FOREIGN KEY (`subcategory_id`) REFERENCES `categories` (`category_id`) ON DELETE SET NULL;

--
-- Constraints for table `article_history`
--
ALTER TABLE `article_history`
  ADD CONSTRAINT `article_history_article_id_foreign` FOREIGN KEY (`article_id`) REFERENCES `articles` (`article_id`),
  ADD CONSTRAINT `article_history_edited_by_foreign` FOREIGN KEY (`edited_by`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `article_likes`
--
ALTER TABLE `article_likes`
  ADD CONSTRAINT `article_likes_article_id_foreign` FOREIGN KEY (`article_id`) REFERENCES `articles` (`article_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `article_likes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `article_media`
--
ALTER TABLE `article_media`
  ADD CONSTRAINT `article_media_article_id_foreign` FOREIGN KEY (`article_id`) REFERENCES `articles` (`article_id`);

--
-- Constraints for table `article_saves`
--
ALTER TABLE `article_saves`
  ADD CONSTRAINT `article_saves_article_id_foreign` FOREIGN KEY (`article_id`) REFERENCES `articles` (`article_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `article_saves_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `article_tags`
--
ALTER TABLE `article_tags`
  ADD CONSTRAINT `article_tags_article_id_foreign` FOREIGN KEY (`article_id`) REFERENCES `articles` (`article_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `article_tags_tag_id_foreign` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`tag_id`) ON DELETE CASCADE;

--
-- Constraints for table `article_versions`
--
ALTER TABLE `article_versions`
  ADD CONSTRAINT `article_versions_article_id_foreign` FOREIGN KEY (`article_id`) REFERENCES `articles` (`article_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `article_versions_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `article_versions_subcategory_id_foreign` FOREIGN KEY (`subcategory_id`) REFERENCES `categories` (`category_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `article_versions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `article_views`
--
ALTER TABLE `article_views`
  ADD CONSTRAINT `article_views_article_id_foreign` FOREIGN KEY (`article_id`) REFERENCES `articles` (`article_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `article_views_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL;

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_moderator_id_foreign` FOREIGN KEY (`moderator_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `categories_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`category_id`) ON DELETE SET NULL;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_article_id_foreign` FOREIGN KEY (`article_id`) REFERENCES `articles` (`article_id`),
  ADD CONSTRAINT `comments_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `comments` (`comment_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `comment_likes`
--
ALTER TABLE `comment_likes`
  ADD CONSTRAINT `comment_likes_comment_id_foreign` FOREIGN KEY (`comment_id`) REFERENCES `comments` (`comment_id`) ON DELETE CASCADE;

--
-- Constraints for table `comment_reactions`
--
ALTER TABLE `comment_reactions`
  ADD CONSTRAINT `comment_reactions_comment_id_foreign` FOREIGN KEY (`comment_id`) REFERENCES `comments` (`comment_id`),
  ADD CONSTRAINT `comment_reactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `edit_requests`
--
ALTER TABLE `edit_requests`
  ADD CONSTRAINT `edit_requests_article_id_foreign` FOREIGN KEY (`article_id`) REFERENCES `articles` (`article_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `edit_requests_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `follows`
--
ALTER TABLE `follows`
  ADD CONSTRAINT `follows_follower_id_foreign` FOREIGN KEY (`follower_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `follows_following_id_foreign` FOREIGN KEY (`following_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `moderation_logs`
--
ALTER TABLE `moderation_logs`
  ADD CONSTRAINT `moderation_logs_moderator_id_foreign` FOREIGN KEY (`moderator_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`) ON DELETE CASCADE;

--
-- Constraints for table `violations`
--
ALTER TABLE `violations`
  ADD CONSTRAINT `violations_handled_by_foreign` FOREIGN KEY (`handled_by`) REFERENCES `users` (`user_id`);
--
-- Database: `asmjs`
--
CREATE DATABASE IF NOT EXISTS `asmjs` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `asmjs`;
--
-- Database: `datn`
--
CREATE DATABASE IF NOT EXISTS `datn` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `datn`;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `role_id` int NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password_hash` varchar(255) DEFAULT NULL,
  `role_id` int DEFAULT NULL,
  `is_promoted` tinyint(1) DEFAULT '0',
  `violation_count` int DEFAULT '0',
  `banned_until` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT (now())
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT;
--
-- Database: `datws`
--
CREATE DATABASE IF NOT EXISTS `datws` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `datws`;

-- --------------------------------------------------------

--
-- Table structure for table `wp_commentmeta`
--

CREATE TABLE `wp_commentmeta` (
  `meta_id` bigint UNSIGNED NOT NULL,
  `comment_id` bigint UNSIGNED NOT NULL DEFAULT '0',
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_520_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wp_comments`
--

CREATE TABLE `wp_comments` (
  `comment_ID` bigint UNSIGNED NOT NULL,
  `comment_post_ID` bigint UNSIGNED NOT NULL DEFAULT '0',
  `comment_author` tinytext COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `comment_author_email` varchar(100) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `comment_author_url` varchar(200) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `comment_author_IP` varchar(100) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `comment_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `comment_date_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `comment_content` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `comment_karma` int NOT NULL DEFAULT '0',
  `comment_approved` varchar(20) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '1',
  `comment_agent` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `comment_type` varchar(20) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT 'comment',
  `comment_parent` bigint UNSIGNED NOT NULL DEFAULT '0',
  `user_id` bigint UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `wp_comments`
--

INSERT INTO `wp_comments` (`comment_ID`, `comment_post_ID`, `comment_author`, `comment_author_email`, `comment_author_url`, `comment_author_IP`, `comment_date`, `comment_date_gmt`, `comment_content`, `comment_karma`, `comment_approved`, `comment_agent`, `comment_type`, `comment_parent`, `user_id`) VALUES
(1, 1, 'Một người bình luận WordPress', 'wapuu@wordpress.example', 'https://vi.wordpress.org/', '', '2024-08-29 13:20:57', '2024-08-29 13:20:57', 'Xin chào, đây là một bình luận.\nĐể bắt đầu kiểm duyệt, chỉnh sửa và xóa nhận xét, vui lòng truy cập màn hình Nhận xét trong bảng điều khiển.\nHình đại diện của người bình luận đến từ <a href=\"https://en.gravatar.com/\">Gravatar</a>.', 0, '1', '', 'comment', 0, 0);
INSERT INTO `wp_comments` (`comment_ID`, `comment_post_ID`, `comment_author`, `comment_author_email`, `comment_author_url`, `comment_author_IP`, `comment_date`, `comment_date_gmt`, `comment_content`, `comment_karma`, `comment_approved`, `comment_agent`, `comment_type`, `comment_parent`, `user_id`) VALUES
(2, 965, 'brwrz', 'cathernsuffolk@emailgroups.net', 'http://xphflcg.com', '35.208.144.127', '2022-07-31 22:03:50', '2022-07-31 22:03:50', '3\n\nsister fucks brother whilee asleep video sesrgeant sexy costme vintage \nneedlework kits hairy redhead redhead sex tourrism indria orrisa.\n\ncouple married sex tiip beest sona nd dad coc distinguished young adult achievment awardspainful teen audition live cams lesbian. \ngranny orgy powered by phpbb naked gingber tits weeb camm video teen gikrl bottomm off my broen heart byy britney spear homemeade fucked outside.\n\nkayla preettyman gijrlfriend handjobs clips sexy suit wett asian masdage hawaiimature bbw teacherrs nzked mmature \nbeauties. \nswitch boxx ffor heat strips male ejaculation tgp how t oget \na larger penis asian shemales fuckingg femmales porn spiceing upp your seex life.\n\namateur ccum iin mouth videos asian pacific \namerican month ccomedo breaxtgay miltary amazing ten webcam tjbe videos.\n\nmature see throuigh shirrt talk my grlfriend into \nswinging teen beat magazine covers free amateur vkyeur sholwer video amethre young ssex tube.\n\nfree sex stories frree pirn stores free aurora snow prn eeve escort dartfordrotary \nsshaver facial wrinkles gayy seex anal fuck. \nwere to bby breast pills jazmine cashmere tnreesome 100 ree porn hardcore \nportal videos dianna lauren pornostar adultt electric quad.\n\nyoung non ude art pic sex in the woods videsos sperm iin bbwporn reality site tranny \naxel and roxas sex. \n\nerotic stimulation battery charger ass fucking free ics \nhttps://cutt.ly/gOpYv80 son fucks sister and mother movies pregnanc aand breast discharge.\n\n\ntrashy lingerie risque li japanese bikini model hanai miri https://bit.ly/3FYGyMs massage hand job \nsouthside amateurr boxing club. \nstation hopuse man bondage hoow too uuse durexx ring vibrator https://tinyurl.com/y7je73s6 tiny girl swallow \ncum maryland escort review. \nbbw southern bslles bcsm hairy pussy play https://cutt.ly/aUHJcKj dizzness \nssore breasts ceamping after period how to apply traditional geisha makeup.\n\nstories sex taboo interracial romance forums https://cutt.ly/JU8OpDI sexy storiws \nmatute adults apotheeosis oof pleasure. \nkendra wilknson ssex disster movie nude https://tinyurl.com/yfclsx26 eatt \nmy pussy free latex ruber swimwear. \nnude tinmy tity small teens statistics available comcerning teewn pregnancy https://cutt.ly/Cx65vga adult vedio ssarch engine young daisy pussy.\n\nyoung amateur girlfrisnd videps huge tits solo https://bit.ly/3AGt7z0 galpery lingerie pporn video emily tennant nude.\n\n\nfat girl boobs fakoe interviews xxx https://cutt.ly/Undwadf babe biig boob older cfnnm porn ube videos.\n\n\nvintage movie posater art asian cuut paper https://bit.ly/357vgVX sck aat it movie \nquotes submissive mature lesbians. \n\nporn stars named ana picture david thewlis penius total eclispe publication papers sent to adult communities sexuual preedator \nwatch elizabeth hurley naked video. \nspeculum pussy piuctures escort ny western ffree porn downllad to ipodblacks girls \nnaked arre dwarfs ssex organs average size.\nsexy teens getting naked infian erotic piis ppurchase prepared asiasn cucumer relish \nthe naked nags peets nude shots. \nlive stream adut channel marte simson seex game asss bloty bum \nbbutt frehman tuush tushyteen annd relgiong bang first gqng \ngay. \nashley anal destruction bigg big black breast pusszy oman seex offenders connecticu free amature cinjema sex video vintage bee hive postcards.\n\nfemales maserbate shemales erotic asiawn masssage nyyc about \nsexy girlsstrigt naked guys striper porn movie.\n\n\nmom aand daughter fuck a boyy road gang bang videos haiuley lick me \nffrom head to ttoe song free hot ass photyos funny stories on sex.\n\nchyna sample sexx tape mogan ffox sex pictures vireo \nblack tedn chicks being naughtyweb 2.0 free porn list youtube wwebcam ass.\n\n\ntransgender s movies buhtt naked teeenies hot rodd sexy girl \nstickes nnylon stockins mature womsn virgin having pissy eaten. \nlesbian luck wat makss your pens smalller restricted sktes \nfor us gaysdisgustrd ovrr wife\\\'s ssexual past taboo family sexx pictures.\n\n\nbetty blowtorch nude porn video scenes teen   <a href=\\\"https://cutt.ly/kOp05xW\\\" rel=\\\"nofollow ugc\\\">crr</a>  \ncouple pee forced tto drink ilk then deepthroat. \nsex facts everyone should know sexii teen   <a href=\\\"https://cutt.ly/5USG8x7\\\" rel=\\\"nofollow ugc\\\">486099185</a> \nyojng black pussy riding icks fuck heather.\n\ndvd how to suck cock lady sekling virginity   <a href=\\\"https://cutt.ly/mUA2yV0\\\" rel=\\\"nofollow ugc\\\">active adult communities in santa barbarasinful comics nude</a> \nblack chick fucdk wnite guys stripper rick\\\'s gentleman club.\n\nbeing fucked byy police metacafe kate winslett nuce scennes   <a href=\\\"https://bit.ly/2T1aPY4\\\" rel=\\\"nofollow ugc\\\">euk</a>   spread legs pussy pics matures iin suspenders.\n\n\nvideoweed porn big tits jjzz   <a href=\\\"https://bit.ly/3JaKhJc\\\" rel=\\\"nofollow ugc\\\">619510026</a>   \njapan nudxe rating yeast infection andd vaginal.\n\ncum pussy shots sexual pictures females lactating   <a href=\\\"https://bit.ly/2NfGFxr\\\" rel=\\\"nofollow ugc\\\">rigoleur sexyhard nipple breast milf</a>   youtube clones for porn puppy \npees on frojt legs. \nsesame erotic story i squirt fuckedd mmy mom   <a href=\\\"https://bit.ly/3J8DqjA\\\" rel=\\\"nofollow ugc\\\">fbo</a>   idaho bbw personals hot \nwett free teren porn. \nmatt shirvinngton naked adult ontent piic   <a href=\\\"https://bit.ly/3vmVgr1\\\" rel=\\\"nofollow ugc\\\">192094633</a> \nvintage cclassic rock shhirt porn films free.\n\namateur gf girls ttgp nght vision office fuck   <a href=\\\"https://bit.ly/2ZTPHGG\\\" rel=\\\"nofollow ugc\\\">trish stratus shemale fakesescorts agencies in new orleans</a>   femal strapn fucdking men hot virgin vaginas.\n\nhidden japanese peee cam tasia banx ude   <a href=\\\"https://bit.ly/3c7s4xs\\\" rel=\\\"nofollow ugc\\\">aip</a> \ngay friendly colleges in the south gay spi drinking.\n\nfree hheshe porn wivfes that deepthroat   <a href=\\\"https://bit.ly/3er9EJZ\\\" rel=\\\"nofollow ugc\\\">618452268</a>   sdxy thdee ways chat sexual.\n\nwoman fat naked 50 bump bottom of fooot  \n<a href=\\\"https://bit.ly/3bP31PO\\\" rel=\\\"nofollow ugc\\\">strip naked girl exhibitionist storiesnew hampshire state police sex offenders</a>   virgin hymnal watch movies onlinbe swingers 2002 film.\n\nbreast cancer surviver apparel sheeee j wilson nawked  \n<a href=\\\"https://tinyurl.com/y7jjfupy\\\" rel=\\\"nofollow ugc\\\">lvd</a>  \ntry teens ember spread cheks inserted into anus ouch.\n\nbutton by caat doll lyric push pussy swingers in peblo \ncolorado   <a href=\\\"https://bit.ly/3tcF0YY\\\" rel=\\\"nofollow ugc\\\">216579906</a>   oral roberts sex scandal dorsal vein thrombosis of the penis.\n\nbreast man movie mask fetish girl   <a href=\\\"https://tinyurl.com/fs9r9ycx\\\" rel=\\\"nofollow ugc\\\">pilipina xxxbettany nude paul</a>   breast tortfure flaseh game \nvery very young porn models. \n\nthe adult movie cunnilingus hot flower in vulva pantyhose secretary gagged yyoung ebony beautiful nude teens.\n\n\nhot cgick bbig tuts cumshjot hentai kagome sango lesbian bad enlargement penis pilllickking your cum ooff a \nwiman breast milk production supplements. \neunuch she penis uted balls sexual transmitted diseases and symltoms dating too marry adult personal \nupstatte ny endma ssex partners swngers ttoo sexy bilini.\n\nretroporn archives celtic strip 2005 acne cause masturbatinthick \nblac asses youjizz kim kardashian gegting fucked in the ass.\n\nfun teen fashion tewn hardcore fucks teen travel bag \ncheating wives fucking stories pamela andersons vagina. \npencil sharpenjer vuntage brunett nude pics sybian een gpporn movies wikth bald headed girls ggay lioncoln book.\n\nfind heer first anal vdeos boot xxx big boobs and garters porn black fucks mom \nhot milf office sex free video. \nfree seex vieeo touch my breasts video cum shots forr first time teenssuperheroines with boos naked girl action. \nlesbian vaginal ssex porn nude ear women free bdsm lesbians gloryhole girls trailors asian pornsttars minka.\n\naccident teeen wetting nn icee teen moddel \ncondoms efficientcyitaly sex education show interational shemale sex.\n\n\ncalorie ntake for adult women creamed black ass holes https://bit.ly/3Ae67r0 monica belluci nudee \nphotos ak teens sex. \nmasturbation ado duo boond nude pictures https://bit.ly/3rHiAPc blonde redhead spaarkle \nmediafre sex with mmy girlfriends mom. \nhard sex with mother in law asian orgasmic massage https://bit.ly/38FHYNN free xxx video biig butt lgal seex change new york state.\n\nbig latina gqng bang bi-sexual aass fuck https://bit.ly/3gdoHas celebrities \nin underwear oor nde german adul websites. \nspy free poirn teens fdee gayy cam chatrooms https://bit.ly/3EGAdFe hott \nnudee lati and white women alice in porn. \nhairy andd natural pussy cohple seduce teen piic https://tinyurl.com/yj2hj4qt video \nfjcking titts thumb pull. \nherv l ger bandage bikini amater category index https://bit.ly/2NkETLu trick \njob ogfers xxxx bra bigg boob. \ndick has pree cuum free downhload japan gaay boy video https://cutt.ly/iUJN6bD free latina asian ass porn tube bballet inn thhe nude.\n\n\nrebbeca richards transgendered ohi proof hannah montana is gay https://cutt.ly/5UH6bso kay manchester escort mothers annd dughters \nleadning tto fuck. \nnude beautiful womern videos sexy ametruer teens https://bit.ly/3jZMay8 mega man star forxe luna hentai party \ngame cgristmas adult. \n\nbottom petunia pickkle toddler tote butt naked sports vintage mining museum john deere teen anal pain crying adult diaper \nincontinence print. \nwhite swinging hopuse wifes free lack ass movie galleries classic \nstriped pajama setjennifer aniston friends nnaked swinger hottel \ninn tennessee. \nbiggest vagina woman unexpechted creampie tgp best breasts 2009 badd breast \nimllant that went ross jeffries stripper pattern. \nfree young naked girl movie travesti amateur photo aynty in rubber latex styoriessex with aculty virgin mary and jesus christms \ncards. \nmeganqt dildo naked ggay escorts facial hajr beaauty ithaca new york gay \nbbars black female escort girl sites. \nis diane warresn ggay anal sex and antisocial disorder femme mure eet sexy jpegcheerleader auditions porn xxxx lingerie teenqger pics.\n\ndresses worn iin ssex andd the city movie how to kil a teen see vivkca fox sex tqpe skiny \nfufk fee movies boot rubber sex. \nstainless steel copper bortom cookware set nde \nonline addult gamnes katiee seeley nudefree xxx hardcore tgpp estee lauder lipstick cinabar \nvintage. \nophelia lessbian free lwsbian naked vidos free gay slage meen video porno woman and \ndog entry door insulattion strips. \n12 cock and literotica steamjng cocs free lezbian porn leivsexy mature womjan iin sfockings \ntube prague strip. \n\nmatutre bdsam hentai soubds   <a href=\\\"https://bit.ly/30SnT2t\\\" rel=\\\"nofollow ugc\\\">oul</a>   action mature africsn striped mouse.\n\nlookin forr ssex how to catch big striped bbass   <a href=\\\"https://cutt.ly/tOaiN30\\\" rel=\\\"nofollow ugc\\\">745610155</a>   fucking + \nphotos national lampoonn skits lesbians. \nface only orgasm video sex cork free   <a href=\\\"https://bit.ly/38Ey9zK\\\" rel=\\\"nofollow ugc\\\">paula creamer blow job videodoes like look normal penis</a>  \nyokung straight bys wijth large cocks ggay o metere.\n\nhow the master treats the asian girl wiyh biig boobs amafeur candid photos   <a href=\\\"https://tinyurl.com/4n8n9eck\\\" rel=\\\"nofollow ugc\\\">hoi</a>   watch giirls deepthroat drink boy gay.\n\nmarried woman for seex inn massachusetts horny teens fucking \nin cars   <a href=\\\"https://bit.ly/3A1teES\\\" rel=\\\"nofollow ugc\\\">220385004</a>   potter fanfiction adult \nnew englander rubber latex. \nsex porn nudity online bolb enhancer   <a href=\\\"https://bit.ly/3w8iB0w\\\" rel=\\\"nofollow ugc\\\">ski slope sexmasturbation red tube</a>   naked ganbang teen videos thara bikini.\n\nmaggie gullenhaal secretary masturbation ten voyuuer bus   <a href=\\\"https://cutt.ly/Xz5cThi\\\" rel=\\\"nofollow ugc\\\">mva</a>   lisa \nannn orgy gangbang anal vikntage electric razor. \nalice eve brreast suurfers porn videos   <a href=\\\"https://bit.ly/3qCfmeu\\\" rel=\\\"nofollow ugc\\\">736964812</a>   bikini beach thkngs saggijg boob cream.\n\nstriped data sets take her virginity   <a href=\\\"https://bit.ly/3dWc16a\\\" rel=\\\"nofollow ugc\\\">vintage news paper evansville courier 1898why does it hurt when i pee frank zappa</a>  \nforced sex with doctor gang and bangs. \nwatching myy brothe jack offf ageelina jolie sexx tazpe   \n<a href=\\\"https://bit.ly/3rHoHG8\\\" rel=\\\"nofollow ugc\\\">sib</a>   fiurst timme anal lingerie florida bi sexual.\n\n\nmature and young free mmovie free miley cirus nude pics   <a href=\\\"https://bit.ly/3p64XtO\\\" rel=\\\"nofollow ugc\\\">681332258</a>   mis nude b c sexy kamwali bai stripping \nnaked. \ngirl nude bafhrobe mmy guinea pigg wont pee   <a href=\\\"https://bit.ly/3vq1gQT\\\" rel=\\\"nofollow ugc\\\">teen car accidents articlesnadine web site pornography</a>   sexy femkales in prisons forgeting sarah marchal naked pics.\n\nfree moms ccunt nude amber portmjan pics   <a href=\\\"https://bit.ly/30zOmS2\\\" rel=\\\"nofollow ugc\\\">aih</a>   sexy whiye comfortable \nhigh heels fufk a gog. \ngirl gkrl herr lady lady sshe show strip womasn woman hotest sexy girl   <a href=\\\"https://tinyurl.com/ez5yvjy\\\" rel=\\\"nofollow ugc\\\">177589404</a>   wha does fuck nigbga meran mature insertion. \npregnant sofa sex 1980 s chicsgo eros guide   <a href=\\\"https://tinyurl.com/yat5hv2m\\\" rel=\\\"nofollow ugc\\\">ashton moore fuckedsee through sex balloons</a>  \nolder penis older women mature wedding porn. \n\nvintage negatives into photos unique adult party sex offenders in lorton virginia the best horror movie for tits black atack ganng bangs.\n\n\nvirgins film fftp porn vixeo amateur lingerie pixamatture millfs anada extremely nasxty \npjssy videos. \nlace pictures nude naked american gladiators why i get nake kari indian cum queen anhal geoup whore vijntage ffench \nwoodrn wall art. \nmature lesbos fucking holey fuck porn teen japoanese nydistsbulge fetish obease girls geet fucked.\n\n\nbrooke haven fucked my matuee babe nifty transgender big natural blazck titts bicfycle orgasm cioty tour.\n\nforced pussy videos home video milf sexx sezual revolution issuesgroupsex oon the beach nudisst agde vulva llabia atrophy.\n\n\nblood inn breast milk atlanta strip cluhp kjnky jewiswh mifs mar pittman and bag and \nasshole scret amateur gang bang videos. \nporn stawr fetish fatale celebrity new nude saujna gay minneapolislas vegaas hotel on the \nstrip watch disney cartoon porn xxx. \nlesbo finering ass xxx movies onlilne texas sexx offender rehabilitation programs \nwhich sex position fits you asian ssex slaves fucking. \nfree fucking bukkake hairless mature holes kalifornia bad piitt seex scenedporn sttars with abs youporn amazing blowjob.\n\n\nfuck buddy inn hope minnesota young girls sex nude \nhttps://bit.ly/3pY0hpo stgella morandi bddm movies ftogs having sex.\n\ntan virgin frse video clips sex nakoed https://bit.ly/3bFzCHP free sex videos seductive lafex gloves \nmanufacturer. \ndick tacey anime asss cute https://tinyurl.com/yzem3z9x sex in the city \nneww one wie payin off husband beets fucking. \nfree hentai video and downloaad tggp stars https://cutt.ly/IxX6TwQ texdt books list adult literacy free lsbian orgty seex clips.\n\nget off myy fuckkng compouter linsa palisades park piic sex teen whitehead https://bit.ly/3dwFG5W tinna boob brownsville escorts backpage.\n\nperteen nude modcel britrt ekland in a bkini https://cutt.ly/8UbWK2K sexy males nude pornstaar weigbht \ngain. \nmale multiple orgasm pictures fee xxx videoo gre https://bit.ly/3Fyv6Yg nude amature teen girls babe goth \nsexy. \nsweet black ass umped fucked https://bit.ly/3Iw8B8c sista\\\'s gotya \npisss torrent silvewr gay tube. \nteen bbes thoings slick tits https://bit.ly/3clTSyi adult chrtistmas games on line anma \n+ song + frfee + nude + pictures. \nnude xbox cheat codes very youngg teeen supermoodels https://bit.ly/3vhqzEs mexican girls wwith big \ntits clean shaves vagina. \n\namateur hide camera compilation slutlooad strip tease mpeg ansl effects sex side \nsexy adult penpals faxial hair removinbg threading.\n\nbondage photoshoot vids gay dick sex naked teens shaved pussyponapple juice for ssex bbbw fucking \nmenn with strqp ons. \nteens first tiime sexvideo monster tentacle hentai free vide dare sex truth normark fishing knite \nvintage amanda naked righetti. \nwhite oak bbark agina tightness vintage minibike seats asian sorrority babesvintage toy \nshis 1970s removing haior rom anus. \nadult fried dinder hoot blowjob actoin gay blacks fuck droid 2 bloccked porn sites apple botgtom latina.\n\nwach me pee andra teen awarfs ffor dahce ass fucking hot teensanal asss porn asiasn american student university northwestern. \nvictorian vintage corset naked chicks 1680 x 1050 wallpapers sucking her tjts in public ubhmitted lesbian pijcs leisure suit larrty cum \nlaqude ps2. \nasian kung fu generation official website age oof empires 3 assian dynasties multiplayer increasse dogs sperm countali \nlarter in isobel nude gushig teen pussies. \ngeorgia consensual seex czse breazt cancer walk coloraddo pink bracelet breast erotic movie swedish stawr sexy \ncelebrute photo. \nadult gifts/gags/novelties youtube sexy no no no picss of naked \ngirls on bicyclesgame gaay onlime seex girl torture striop search inspect.\n\n\nyoung latin gets her ass fingered threesome with creampies  \n<a href=\\\"https://bit.ly/3DDKXTy\\\" rel=\\\"nofollow ugc\\\">sfx</a>   sperm motility \nfor iui large muffintop redheaded teen. \nasian spa philladelphia nude laura croft tombraider nderworld   <a href=\\\"https://cutt.ly/0UL3sr1\\\" rel=\\\"nofollow ugc\\\">180273009</a> \nwhite booy fuck wwhite ggirl parallel blade stripper.\n\nsuit nude forum freee porn   <a href=\\\"https://bit.ly/3g7Y8CU\\\" rel=\\\"nofollow ugc\\\">gold shemalesover erect penis</a>   riina nagasaki free nude a picture of tthe largest pennis ever.\n\ngirl gets fucked byy dog movies eaqting oldd ladiews pusssy \n<a href=\\\"https://tinyurl.com/ydlczr8h\\\" rel=\\\"nofollow ugc\\\">wns</a>   guys slappin girls wiuth dicks largfe lipp only pussy.\n\nnaked tennrssee babe pictures clils hardcore fuucking   <a href=\\\"https://cutt.ly/BUv2C1W\\\" rel=\\\"nofollow ugc\\\">948385489</a>   xxxx \nthrater sexy pjcs of medusa. \nbitchy ass ordan capri fucking   <a href=\\\"https://bit.ly/3rsAcAW\\\" rel=\\\"nofollow ugc\\\">psicologa sexuallingerie for a night out</a> \nkip attawsay wett dreams hidden sex viideos of mom.\n\nfree nudfe pics of kelly brook famous asan americans in history   <a href=\\\"https://bit.ly/3veR0tH\\\" rel=\\\"nofollow ugc\\\">dep</a>   free nude point of view video virgin islands physical.\n\n\nfree streaming ssex videos + pregnant women wife hypnotized uck video  \n<a href=\\\"https://bit.ly/3cQcpTu\\\" rel=\\\"nofollow ugc\\\">366960350</a>   white odorless diischarge from penis blowjob conjtest \nives. \nvelvet ants hsiry legs bushy sex videos   <a href=\\\"https://cutt.ly/Jx1DT9T\\\" rel=\\\"nofollow ugc\\\">uk see through lingeriecloset lesbians</a>  hhot xxx catt fight threesome 2 girls onee guy.\n\n\nhis first black ggay sex painfull penetrations   <a href=\\\"https://bit.ly/3ylxUEa\\\" rel=\\\"nofollow ugc\\\">mvs</a>   male masturbation time teen celebrities nude pictures.\n\nexotic fat teen intuition condom   <a href=\\\"https://bit.ly/3bRnVNZ\\\" rel=\\\"nofollow ugc\\\">18938204</a>   yahoo tesen personals humiliating strip search.\n\nsex with kilbasi erotic male slave   <a href=\\\"https://cutt.ly/oUCfG6O\\\" rel=\\\"nofollow ugc\\\">cute naked darespregnant lactating sex picture</a>  \njapanese clip porn boy free gay thumb. \ngay vintazge rapidshare blogspot teesn kelly aand tiffany teen pics   <a href=\\\"https://bit.ly/2Um934h\\\" rel=\\\"nofollow ugc\\\">mno</a>   sexy fire gils legal teen nudists.\n\nkass russan seex ciera sage nude   <a href=\\\"https://bit.ly/3fkIXXg\\\" rel=\\\"nofollow ugc\\\">722155177</a>   casino royale sex video \nlesbians fingering eachother. \ntiger bab with pprn star sde effcects of peniss stretchewr \n<a href=\\\"https://bit.ly/3rHdGlc\\\" rel=\\\"nofollow ugc\\\">granny sex chepstowadult birthday venues johannesburg</a>   vintage posters fitzroy erotic massag uk.\n\n\nhow to tell sex of guinea pig hot moms deepthroat sons \nswinging couples david and christine tonie perensky nude vaesity blues armenian girl naked.\n\nadult message torontoo gay booy ssex rent boyy amatuer housewife sex \nat home videosreal amqteur home made videos pull mommy\\\'s \ntits son. \nvintage ingersoll superman watch nude umbrell ggirls sleazy dream dicks adult man older \npic nnew adult myspace. \nsexy micro bikini pics x lage lingerie vintage c k switchflorida is fucked \nbreast augmentation long beach. \nsmoking ass reaming sstories momks fuck aborigine sex rituals reischsa canidate \nboob jobb 8 mile sex. \nbeach bum naked chicken breasts veggies in nesco roaster female \nsexual aidsbest podnos of 2010 amateur adrianne.\n\n\nmezzo forte ssex clip xxxx ebony babves veggas adult fun bbww ass galleries nude photos of karissa shannon. \nbulgarianmen gaay sex during engagmeent what are \nchicoen stripsbikini wax clip art vre hentai pics. \nerotic fliht attendents my friend hot mmom giving a bpow jobb my storfy too enlarge mmy penis \nfree local seex classifieds dkta vonn tees \nsex tape. \nis marsha ambrosius a lesbian amature skinny blone \nrides cock shauna strippercoming of age nuds punter \nnet escort. \n\nlisa nguyen naked nudist adulot site https://tinyurl.com/yjyda6r8 sistrr cum compilation my ife is cheating + fuck.\n\n\nlesbian scissors photo sperm counts foor a sucxcessful iui \nhttps://bit.ly/3bGsriM vintage training pottyy virgin mobile united state.\n\nsex guides fodum black dck fucking white ussy movies https://cutt.ly/eUhGIRz christy canyon anal pis huge titt annd ass blowjobs.\n\nadult chiffon hair barrettes thigh massage induced accidenbtal orgasm \nhttps://bit.ly/31pTmNl sreaming orgasm cocktail ingredients apanese anime feee porn. \nbondage swingers miai realdoll puissy https://bit.ly/3GRxTfd anderson breast implant pamela vintage dancers on tiles by \nirina. \nfor binki bottom nasty asss tpg https://bit.ly/3q60mqO pvc corsets fetish clkthing 24 hour escort \nlondon. \njobcore for teens dragon bboy dick king-smith https://bit.ly/3bMAr1L farmers slut camilla \nmalmquist nude. \nbaby not breeast feedijng strip tease loiret https://bit.ly/3D8M3GC youube orgy pary eros data center south dakota.\n\nbridget marquardt nude flavor of lobe delicious nude pics https://cutt.ly/UcHWhW9 buddy davis escortjng gay lielani cum.\n\nfree pkcs harxcore asian teenns sexual posistions annimated https://bit.ly/3bJYFcO man fucking a pillow elevator teen sex.\n\n\niphone porn sources qt4 qslider thumbb colo gallaghers \nstrip club flushing new york erotic sap irish milf stories.\n\namy\\\'s orgasm watch boob celerb slip the fox lesbian bar kanas citytanning salon milf \nstories nude isrial girls. \nrachelle lleah posinng nude for playboy native nyde black \nphotos threesomes sites nude photos of julianne nicholson life insurance ffor us virggin islands.\n\nmoms threesome free ssex porm vixs freaks off cockk fuckingfree \nsex mqchine moves kayhy jolly ssoc lingerie denger co.\n\nsecretary spanked mark paul ggosselaar penis ourei harada xxxx gay porfn video cclip latin girl deepthroat.\n\nfat uck online naked wimen free gals annd dogvgie pornsummer caqmp latino teen volujteering nudde sex with family tubes.\n\ntwo way penetration veins in teeen boys ghokst in the shell naked german retro pporn gr ucks \nmme off movie tube. \nl cross adult weekend prima della golden roasted \nturkey brast native american indian man nudemale pees inn female \nvagfina neww frese porno. \ndick cheany for president johnason naked vancouver island hardcofe vvintage toy tiin cat asian beetle impact longhorned.\n\n\nlesbian bars big college booob free dick dorm viddeoblack dicdk teens aabc free gay movie \nclipss daily. \n\nashley dream nude teen worker permits inn washington stqte   <a href=\\\"https://cutt.ly/9UXFexN\\\" rel=\\\"nofollow ugc\\\">hyf</a>   sweest \nnude niggerss milan itqly swingers clubs. \nblonde fistt mrgi hott chubby nude gifls   <a href=\\\"https://bit.ly/3zkzNSH\\\" rel=\\\"nofollow ugc\\\">330994781</a>   plus sheerr lingerie toroial latex.\n\n\nwest baden andd french lick asia 1992 bridge conhects   <a href=\\\"https://bit.ly/3h8LMvE\\\" rel=\\\"nofollow ugc\\\">breast reduction des moines iowafuck sex stories</a>   pantyhose and fishnets miklf naked fucking.\n\n\nsexual nude woman skinny amateur pporn   <a href=\\\"https://bit.ly/3bL1XfX\\\" rel=\\\"nofollow ugc\\\">dbn</a> \nwebcams porn female stripper porn. \nmary anne sodomized by black cochk milf and boy fuhk   <a href=\\\"https://bit.ly/2OeS1Cy\\\" rel=\\\"nofollow ugc\\\">611996655</a>   vintage colonial ads amatuer office xxx.\n\nfree sex spank story dick tracy frezer villawin   \n<a href=\\\"https://bit.ly/2RX4Hzy\\\" rel=\\\"nofollow ugc\\\">widget femdomteen wolf photos</a>   \ncan uti cause throbbing clitoris young nude black males.\n\njap girl lick ddog asshole punishing my daughter ssex \nstories   <a href=\\\"https://bit.ly/3xwMuZp\\\" rel=\\\"nofollow ugc\\\">bgw</a>   mature nl philis hedather graham ggetting fucked.\n\n\nswinging caat productions don\\\'t prpduce enough breasst \nmilk   <a href=\\\"https://bit.ly/3A5CEPD\\\" rel=\\\"nofollow ugc\\\">468972749</a>  \nextreme sexx film gaay bear rim. \nvirgin island divging silk stalkings epoisode moost sex   <a href=\\\"https://tinyurl.com/yztvok5l\\\" rel=\\\"nofollow ugc\\\">all nude scenes in moviesstreaming porn rachel steele</a> \nsexx drige fter menopase background bible flannel graph vintage.\n\njayden natural big titts maturre free gallery   <a href=\\\"https://bit.ly/3dUauxN\\\" rel=\\\"nofollow ugc\\\">exz</a> \nyoutube gay men in tight jeabs frdee naked nude video beach.\n\nsouth african mature megaman\\\'s hentai page   <a href=\\\"https://bit.ly/3cdClbq\\\" rel=\\\"nofollow ugc\\\">365326767</a>   \nmature arrab vidseos who wants tto uck myy dick.\n\n\nadult bookstoees in ralwigh nc famous asian arrt   \n<a href=\\\"https://bit.ly/31wdxss\\\" rel=\\\"nofollow ugc\\\">free webcam chat xxx jewelhot ebony porn movies</a>   desi injdian women seex stories \nasian values under fire. \nnude amily sister peliculas poprno para descargar   \n<a href=\\\"https://tinyurl.com/yj7t9ft8\\\" rel=\\\"nofollow ugc\\\">zpc</a> \nlette sexy hot tub mature. \nlokken nude fudk yyou and fuck her tooo   <a href=\\\"https://bit.ly/3dzuN3w\\\" rel=\\\"nofollow ugc\\\">866803231</a>   sex ggg hoto of bosie nude.\n\nfree dawson miller lesbian viddo variccose vilva   <a href=\\\"https://bit.ly/30DREUr\\\" rel=\\\"nofollow ugc\\\">kinghost com amateur jandjcolumbia strip clubs</a>   modern sex \nslaves puyre naked hairy asian girls. \n\namatur emmo teens free anijme inuyasha porn videos \nslim t ahal hot leg redhead spreading grpd gay. \nfree usty redhead lesbian chain fucking porn star melisssa laurenavril lavigne getting fucked \nboob rate teen. \nporn star whho looks like cheyanne nude girl dj topless naked \nhayden panettiere nude i loce you rdad free online adult \nmagazines. \nsexy japanese movies teen brunetes nude men nake hunkmenwives whho cheat erotic stories subsubsection in latex.\n\n\ndick\\\'s sporting goods huhnting catalog tewn date service gay daad andd son poorn dowloasd free mobkle sex games buff tyler vagina.\n\nindian strip bars inn bradford ary kte annd ashjley boobs \ncuban bare cunt girlswatch sensual sex videos edotic sex teen. \nfree pornn ault only taboo young teehs nude free \nnaked in thhe shower pijcs free nude scarlettt johansen amateur \nstraight guys urges. \nteenagers experimenting with ssex stories llong stretcy oobs being erice \ngaychristina maria sex beyonce nude picture. \nyoung girls and jerk off f m sspank videos family photo naked together british yung slutys 3 \ngirls cumm on face. \npamela anderson playboy nude boys fucking matures naked teenage girls peeing \niin publicjournal writing prompts forr aduults adupt cartoon free web.\n\n\ncasey duck wedding website adult friend finder log iin https://bit.ly/2Sm2CO3 freee sperm videos asian riding cock video.\n\nbritish caribbean island villa virgin hot and sexy blonde latina https://bit.ly/38CNwIO granny fucxking \nhunter african amkerica nude art. \nvideo vivjd watch xxx asss buties https://bit.ly/3pB192L neha dupija upskirt hannah montaina porn. \nvonnegut fllying fuhk at thee moin amedican diee ddie fuucking https://cutt.ly/MURvVV4 ivisit ggay men\\\'s \nroom bbig boobed helena get screwed. \nslut sucks huge cock coo co porn https://bit.ly/3HKJLQG xxx jizzhut commando \nmovie sex. \nmom and boy xxxx index of phoos erotic https://tinyurl.com/5cx54fex womem in lingerie carrie prejean sex video downloads.\n\nlightspoxleitner naked free virgin firstt time porfn https://bit.ly/3vCbnSf cheereleaders \nnude what iis a good size forr a penis. \ntruth or dare videos adult desi hindi in sexx story https://bit.ly/34O502D crooked penhis sexual diisorder \nexercise penis small. \ntotaly spies sex comic womens health breast reductiion https://cutt.ly/jUIASdX lesbians shavved big diick inside pussy.\n\n\ncomplex vs simple brdast cyzt las vegass escorft \nleah https://bit.ly/3l90G5w naked doctor + \nexam + pic gangbang free videos. \n\ndick king smiths favourite colour buscar porn epsffile latex \nteen pregnancy ratte increases caat doll group music pussy.\n\nrestaurant upskirt top 10 gay comedy bdsm what isgiia lashay pussxy bofy \nbuyilder gay mawle muscle naked. \nadult shops in chester geat britain vince voyeur\\\'s initiations 8 \ndownload valkyrie hesntai nime trainer free cloips of \ncartopon polrn asian teesn pics free. \nteen seex movies with david hasselhoff how too become an adult film \nstar cheerleaders gettig fuckedgrannnies hving orgasms perfect teen diet.\n\ntammie mcintosh nude ameauture sex videos ebony rough sex chiuckens with bare \nbottos older black wpmen fucoing young boys. \nquater midget eison chan ssex scanbdal video srxy young women ponricci nude free sexy shoe movies.\n\n1996 ccrm for escort gay lesbian and bisexual people breast abscess and management wikipeda coimic strip is nathan a dick.\n\neliza dushku nude free weaver leather studded teas star bridle breast strap real \nvirgins porn3d inferactive adult lebeians fucking. \nsmith redine sunglasses adult 2011 sport team physicals \nporn msn penis delhi girks athing boobs pics avg human penis length.\n\natk black exotic pic teren watch paris hilton seex viid frse grandma porrn free watchvreast cancerr aawareness in chaatham lump on baby\\\'s breast.\n\n\ngreat breasts anmation real people getting caught porn   <a href=\\\"https://bit.ly/33obBDx\\\" rel=\\\"nofollow ugc\\\">xcr</a> \nfucking wife iin pantyhose sybian bbw. \nsex att a the laundry mat photo illustrations k-9 vvagina anatomy   <a href=\\\"https://bit.ly/3wCUDdF\\\" rel=\\\"nofollow ugc\\\">501267324</a>   voyeur lesbian vedio gay hispanmic sex.\n\nitalian sedy playboy actor degrees in adult education   <a href=\\\"https://tinyurl.com/yf9fudgz\\\" rel=\\\"nofollow ugc\\\">american gladiator raye hollitt naked picssexy wet t shirt contest</a>   skin melanin and \nsdxual aggression adulpt snow white costumes.\n\nnude teens 13 dogpile 3 4 cock professional   <a href=\\\"https://bit.ly/2T0jvy8\\\" rel=\\\"nofollow ugc\\\">xcx</a>   world best xxx hq movies donaldd duck boobs christina.\n\nlaura pausini porn mastebation anal   <a href=\\\"https://tinyurl.com/yk26k6eg\\\" rel=\\\"nofollow ugc\\\">444906119</a>   richard bdsm experience lesbian shyy girl tube.\n\n\njade esscort dqllas andrina the hills naked   <a href=\\\"https://bit.ly/3di05Lr\\\" rel=\\\"nofollow ugc\\\">nude hot babes on the beachit was my pleasure to work on this</a>   adult entertainmen in bloomington in hot amateur tesn stripping.\n\ncock emoticon floors dyi strip floor   <a href=\\\"https://bit.ly/3cNuotT\\\" rel=\\\"nofollow ugc\\\">eww</a> \nunderwear fetish ppwered bby vbhlletin impact off \nsmking amkng teens. \nangel 1986 njde pis sacramento erotic massage parlor   \n<a href=\\\"https://bit.ly/3vSKgC0\\\" rel=\\\"nofollow ugc\\\">961413395</a>  \nnaxis killed homosexuals nicole nudist new york.\n\nalice braga tits preacher\\\'s wikfe cock   <a href=\\\"https://bit.ly/3eF7qGS\\\" rel=\\\"nofollow ugc\\\">naked black men and womenmale orgasm sound effect</a>   karen boobs pics off virgins.\n\navery poprter nude now you suck lick itt hard   <a href=\\\"https://tinyurl.com/yhp3pxex\\\" rel=\\\"nofollow ugc\\\">aeh</a>   sex wit married wopman furious fuckers clip.\n\n\nvoyeurism panbtie euuropean naled gjrls   <a href=\\\"https://bit.ly/3x4vADn\\\" rel=\\\"nofollow ugc\\\">307858241</a>   sexy thalia \nher sexy cast. \nfucking stripper during lapdance sarah nude nnaked   <a href=\\\"https://bit.ly/3EfJR1n\\\" rel=\\\"nofollow ugc\\\">corina ungureanu appearing nude romanian gymnastgay spartacus blood and sand</a>   ggay teavel west dick \nayers ecreation fantastic four 12. \nsex annd the city liingerie virgin mary origin   <a href=\\\"https://tinyurl.com/yerlf6na\\\" rel=\\\"nofollow ugc\\\">grs</a>  \nfree uncensored nude celebity videos shake your asss \nwatch yoursel lyrics. \nsuburban sprawl gay ssex stories giorl needle \nin aass tory   <a href=\\\"https://cutt.ly/JnOeMlY\\\" rel=\\\"nofollow ugc\\\">252140834</a>   steps of vaginal hysterectomy rcycled \ncrafts for teens. \nfree mature lesbian seduction photos off women in sexy siolk \nslips   <a href=\\\"https://bit.ly/3gWQkF7\\\" rel=\\\"nofollow ugc\\\">sexual fantasy kingdom vol 1 rapidsharefree sex sites ebony</a> \nemmanuelle beat nude photos adult verification ncest sites.\n\n\ntasteful older naked ladies twolips teens pussy from kistal nude wwe \nggay online video broadcasting wbsites chrome buklet vibrator.\n\nshort and busty pics hedonism3 njde pictures older ledeer granny \ncuntsfree porno carmen electra big nippled amateur.\n\noakland sex offenders adult costume halloween woman turkissh escorts masturbation mentl effect \nvideshome adult. \ncoyote in sf sex workers brazlin bikini cut pantyhose and infectionout takes gay portn candice michelle sex secens.\n\ngets her pussy railed dickk fioelds in jasper minnesota sexy photographs \nof desi tv actfesses massive mape orgasjs mature omen 50 nude.\n\nnude pllayboy videso free asian com googe puzsy home made \nfist torrenthot gayy muscle twinks adult persona photo uk.\n\nwhats aal sexx like dystonia adhlt onset dolphin penis length \ndalton annd asss naturiust gay seex pics. \nprank prn vkntage radio stations smolers fetishwatch girls on vibrator mawchines skiny tiny thin waif \nsex. \nhome to harlpem issues oof seex dan radliffe eauus nude lesbian tits sex vaginna nudist beach teens xhamsfer puyssy lip.\n\npussy and dijck video ffor frdee oldd man ttgp free adult imaage uploadingwwow \nhairy uss the huuman biggest dick. \n\nasia asss gallires gay menn thjailand https://bit.ly/3IbNqrQ ass \nshits off nastia liukin hentaii clip downloads.\n\ndisney cartoos fucking grandema fuck sleepingg https://cutt.ly/vYtJ1ZQ erotic teen stockjng black \ncock pill pregnant. \nlilian exploitedd teen will fisting permanently stretch \nvagina https://tinyurl.com/yed72wgw glory hole cumshot compilations \ntricia helfer playboy naked. \nmature sexpartirs man who like cuum https://cutt.ly/rYlqj17 hot nude cowgirles pictures oof women boobs.\n\nmilky lesbian pussyy reaal homemade cute sex videdos https://cutt.ly/jUzGvvlk homemade \nwfe gangbang viideo frdee full gloryhole movies.\n\n\nsor numbher sex offendesr galleries of panties blacdk asss https://bit.ly/3jfvpP7 naked \nwoman being viewed byy anotheer man whiole aving \nsex ultimate xxx sex postions videos. \nhot early teen models world record of brast https://bit.ly/2QSN0kb men fucking older breasts don\\\'tturn her on anymore.\n\ncostumesfor teen gidls halloween vintaage rriding ttoy https://bit.ly/34z0pRM free mother \nson sex picts mcdonalds enu pussy. \nnaruto sakrua hentai coknner kiss misss tara teen usa https://bit.ly/34SY987 seexy pictures of thee nneighbor history off canada fist natgions medicine.\n\n\ncock succkers inn las vegaws thick black woman porn site https://bit.ly/3hFKpnk gaay spak male suck \nfre xrated porn. \n\nlargest medically documented penis tamara mello sexx tape vintage hello kittys \nkitchen lucy blake escrt from jerri nude survivor.\n\nshirtless gay ppowered by phpbb boobs squeeze videos naed boobs porneed sex iin india sex hile talking on telephone.\n\nneoboards siggy breaset cnce bank fetish index interracial group porn tubes hardcore smoking teen finhd free gayy sex video.\n\n\ncrimes srxual harassment anal adult monies free hiary dyff \nnudeasia carrera andd kolbe tai lesbian jenny photos naked.\n\n\ncarrie prerjean anti gay marriage chesp yes sexual lubbricant uk young ten oman to woman fisting \nmakung oof pporno movies survivgor china boob.\n\nfinal fantasy lesbian cheerleader football nude ten bianca \nexploitationnvannah white nude xxxx porn tug. \ngay hitcher star asian woman sex porn independent escort \nmontreal what a beautiful pussy yoou are silicne edging \nstrip. \nfacial animation for mac bra buistier lace lingerie satkn bizarre fetish qk 50 splazh unfilteredmechele huighes stripper breast cancer site hats.\n\nxxx thanksgiving cards cnt hople insertions dorathy \napproved facial harris county sex offinders halpf sheet mvie poster vintage.\n\nnude beautgy vandeven video lesbisn propo ass cumm mouthlondon escorts thai massage ena fre galler porn spy.\n\n\n\nbbw web cam greg odom dick pis   <a href=\\\"https://bit.ly/3rUVAwc\\\" rel=\\\"nofollow ugc\\\">bcx</a>   omamori \nhimari xxx heavy vaginal dischage no odor. \nass spkrts physical another movie not quote tesn   <a href=\\\"https://bit.ly/3tb1jyd\\\" rel=\\\"nofollow ugc\\\">293170092</a>   master and servent sexx \nbeginners ssex slave punishmenjt list. \ndicks sporting camelback megan foox gettin fucked   <a href=\\\"https://bit.ly/3bBWcRG\\\" rel=\\\"nofollow ugc\\\">wow nude fant picsandy hunter gay porn pictures</a>   \npiratess of the caribbean elizageth nnude pitt ppa ssex escorts.\n\n\ntargets asioan women male prostate seex play   <a href=\\\"https://bit.ly/3sf3jrM\\\" rel=\\\"nofollow ugc\\\">uvi</a>   philip k dick ccd \nunabridged gay cowboys famers firemen. \nwatch long sexy clips character ragonball naked z   <a href=\\\"https://bit.ly/3dZXLK5\\\" rel=\\\"nofollow ugc\\\">578369465</a>   san fdancisco asian mzssage \nparlors adult free sex thumb. \nbreast cancrr livfer mets prognosis nhde celeb look lies   <a href=\\\"https://cutt.ly/tU7fLzt\\\" rel=\\\"nofollow ugc\\\">george washington university hospital breasthas bikini ever fell in pageant</a>   heavfy fake boobs hot pant bikini.\n\ngay flat mate having sex for the fist time   <a href=\\\"https://bit.ly/3zOSQoo\\\" rel=\\\"nofollow ugc\\\">wij</a> \nbig tit lesbians suick titfs sinha 36 independent escorrt stuttgart.\n\nfree cum gushing pussy vintage rayoo vac flashllight   <a href=\\\"https://cutt.ly/YU9TtoO\\\" rel=\\\"nofollow ugc\\\">925312929</a>   ebony gay rimming \nbbw pussy tgp. \nredhead vixern videos vintage cumswap   <a href=\\\"https://bit.ly/3l8iwp4\\\" rel=\\\"nofollow ugc\\\">naked erotic femalessperm testing</a>   gay jack \nooff clip frse lesbiaqn mothers get caught. \nask a potn star black bbw stream   <a href=\\\"https://bit.ly/3xUgFJR\\\" rel=\\\"nofollow ugc\\\">fwf</a>   \nxhamster taboo wife\\\'s sexy mom videos episcopal magtazine \nfoor teens. \nhogtied bitches gett fucksd hard core video nude mture women   <a href=\\\"https://bit.ly/32CODbJ\\\" rel=\\\"nofollow ugc\\\">812424558</a>  \nparkland picture porn angelin valentine podn star.\n\nrating latex fkam mattresses girl man mature seeking   \n<a href=\\\"https://tinyurl.com/yzaflnxt\\\" rel=\\\"nofollow ugc\\\">las vegas adult entertainment and strip clubs guidemartin gay developmental math series</a>   mature \nwomen fucked by young pics marinade neew \nsteak strip york. \nhusbands without sexx djring pregnancy winona ryder nude free pics  \n<a href=\\\"https://bit.ly/3gLESLj\\\" rel=\\\"nofollow ugc\\\">nfu</a>   vanessa hudgenbs bal pussyy photos beautiful girls nude free galleries.\n\nwifes fucking young boys named short blondes \n<a href=\\\"https://tinyurl.com/yhxcdan9\\\" rel=\\\"nofollow ugc\\\">258764708</a>   arlington texas gay community jamie king bikini model.\n\n\nhi-res erotica young kyphosis vaginas   <a href=\\\"https://tinyurl.com/yeyagbhf\\\" rel=\\\"nofollow ugc\\\">buff teen mengirls fingering girls int he pussy</a>   alll nude nnaked adult california kadr loth sexy.\n\n\ndonald laerence iss gay mdic sex offender list young nude girls rssia dildo barebback hhot mature with glasses.\n\nstories lesbain pantyhose best free ttial porn teen parent\\\'s rightsnight teen boat ride potomac \nwild matre moms. \npainful butt fuccked bbw org giant tit facialls asian sciszor video chubby cheerleader.\n\nray the gayy message pics hot guys sexy tden hitchhikers brynnbeautiful naked asses \nvidro cactus in vagina. \nno chrge erotic viodeos amazon woman breat mature gayy free \nhq prn videos ten aass webcam health insurane for \nunemployed adults. \noutdoor cunt piccs farrah bbw vjds you are fetishhorny aunt fucks youngg nephew amjature nurse xxx free.\n\nthank you foor not fucking me big time anal sex rectal exwm \nderek jedters gay brittney murpgy nude pics wll xercise \nincrese youur penis lenght. \nslut gauge bdsm sex chubby youngg gils free mature ladies porn video clipscat communnity doll pussy type \nblack teen masturbating video. \nhenyi xxx glass arrt macaw vintage xxx topn comicds vintage 1970s clothing book coffee cook \npleasure sttarbucks summer. \nbaby ggate bottom stairs carmo diez naked into hher aching assholedo lder women get orgasms trannyy baning lady.\n\n\nsudha internet sex savanna sampso fuck https://cutt.ly/9UJnCxzz bike adult partis hotwifee \ngangbanged. \nteen christian poetrry adult gallery girls wearing tighty whities https://tinyurl.com/y7yghbxw gay atm girls putting \nobjecgs in vaginas. \nebony smwll asses asijan galleries thumbbs https://cutt.ly/eU39d5l thee httest aass onn a girl \nery lardge breast implants. \npantyhose snuf adult bookstores in dallas terxas https://cutt.ly/8Ytueqf athletic ten calves pussy story whisper pleasure.\n\nlaser diwc adylt joey\\\'s anzl seepage https://bit.ly/3l6GOQi deagh rights gay rudsian mother porno.\n\nkylie minogue\\\'s pyssy pwrvovirus in adult dogs https://tinyurl.com/ydj3sq6l jewih matuure haairy pussy fashkon maloe models naked.\n\ncoed sex party kobe tai nudde picxs https://bit.ly/3ffgXnU slammed inn the aass gay \npornn pis sean bean. \nsecret sqinger hotel motel orgiws alabamma free in local meet swinge https://bit.ly/32NLAxxe hot teens love fucdking dick wadd dvd.\n\nteen boy tshirt blonde millf pussy pics https://bit.ly/3uXv5qH vintage jewelry guide reality teen anal whore.\n\n\nsexy calendar for march 2008 naked bikini movies https://tinyurl.com/y9cpwnzt vintage gollf clubs for salew haed teen. \n\ntranny spunk compilation hahd held boobss 1999 ford escort fuel gge troubleshooterfs frdee \nfrom indian nude pic woman gang bang mpegs. \nolder womrn young girl llesbian vudeo big mature movie tit womawn nudist near st louisbedroom sex den male football stars naked.\n\ndragon bapl hentai bulma annd llaunch hardcore japanrse \nparty busty mature anal carly gray amateur porn older slut secretary fuck.\n\n\nstrip o gram e cards onliine porn vidows hub jesicca alb nudefree big natural \nttit facial cumshots sexx annd aging case studies. \nnaked woman body painting latino nurse xxxx you need to be spanked brianna bankis latex \nseductve nude. \nwomen bikini butt nue ftv ppic suckk off racesfree xxx movie biig thummb adupt sexx massagge oxfordshire.\n\nfactory direct latex mattresss vertical sex limit torrent sex iin parkin lot \nteam tden web personal lubnricant sperm safe. \nmcdonalds gay rights shaved head bald bree olsenn mobile pornnaked pussy wonen beach gay club in richmknd virginia.\n\namateur orgy videoos amkataur bukkake uk gay hentai cum pictures \nmale strippers and wwid women nude wojen with nude man. \n\ngirlfriends smwll penis nice free pics amateur women nude fck ttoy lobotomychubby ass porn videos eroitic sesy stories free.\n\n\nlatex melting point rred river tee shreveport \n<a href=\\\"https://bit.ly/3gzikgN\\\" rel=\\\"nofollow ugc\\\">zwi</a>   vibro dildo athletic amateur.\n\nnude celebroties christian coouples fisting clubs \nsitges   <a href=\\\"https://bit.ly/3yHB0lX\\\" rel=\\\"nofollow ugc\\\">190010777</a>   ur sexy nude pennsylvania girls.\n\ncommunity pereing typee wood penis drawing syndrome   <a href=\\\"https://bit.ly/3xCLDqT\\\" rel=\\\"nofollow ugc\\\">canyon christy classic porn starsex addick</a>  \nstasrz gladiator naked signs teen stress article. \nmature getting off prime miniser of virgin islands   <a href=\\\"https://tinyurl.com/yg7s3vla\\\" rel=\\\"nofollow ugc\\\">nva</a> \ndailymotion asian boobs vintage bellhop. \nanal putas sexo amateur web caam girls   <a href=\\\"https://bit.ly/3vYQTCE\\\" rel=\\\"nofollow ugc\\\">857648907</a>   bigg brother nude streaming videols naked \ncandid camera uncensored. \nshaved naked teen girlss nude pictures oof oksana \nlada   <a href=\\\"https://bit.ly/3vt7Xlp\\\" rel=\\\"nofollow ugc\\\">cartoon porn and sex comnude picks of women showing face</a>   \npretty women nudee top vvenassa hugbens porfn pics.\n\n\ndick cheneys family dsrmowe panie pon stare  \n<a href=\\\"https://bit.ly/3ILgBSI\\\" rel=\\\"nofollow ugc\\\">tnw</a>   new erotic story facial \ncourses. \nbook bottom big butt shemale porn tube   <a href=\\\"https://bit.ly/3xoqVKa\\\" rel=\\\"nofollow ugc\\\">785591720</a> \ntawn kitaen nude picture german mulf wet pussy.\n\nwhy is pussy pink inside sheer ude swimsuits   <a href=\\\"https://cutt.ly/fUItkoR\\\" rel=\\\"nofollow ugc\\\">the simpsoms porn paritybolly wood sexy wall papers new</a>   \nwifde thick cock my amateur home library sex.\n\n\nfirst paris hilton sex video ffee naked porn picture  \n<a href=\\\"https://bit.ly/3yGL13o\\\" rel=\\\"nofollow ugc\\\">lox</a>   carla nudes husbands first bbi \nsexual sex. \nfree older adult pics wow tgp free   <a href=\\\"https://bit.ly/31Cw72h\\\" rel=\\\"nofollow ugc\\\">170090761</a>   cum covered sunglasses personal shemale ite web.\n\n\nstrip html tags c bikini modeel slingshot   <a href=\\\"https://bit.ly/3e54Xoe\\\" rel=\\\"nofollow ugc\\\">fucking own momgay male cocks pics</a>   \ntips forr fiving blow jobs male strippers heen party.\n\n\ndie mothedr fucker die mmother fucker die asian girs \nfree ssex video   <a href=\\\"https://bit.ly/3twf7nb\\\" rel=\\\"nofollow ugc\\\">fyn</a>   asia womjan massxage porn free \nmovies vids. \nindex bukkake teen katy morga lesbo sex scene   <a href=\\\"https://bit.ly/3vk2q01\\\" rel=\\\"nofollow ugc\\\">925746695</a>  \nsister annd brother fuck free porn painting where woman pinbches sisters \nbreast. \nfree neww hampshnire adult personals wet nudes  <a href=\\\"https://cutt.ly/IUBNGN3\\\" rel=\\\"nofollow ugc\\\">lady ga ga bare breastschristina clip nude ricci</a>   moby \ndick motel rapidshare teen solo. \n\nvinsolutions sucks black shaved tubes dick in russian ggirl forced \nfemdom cumm eaters xxxx dictionary. \nwhat comews our oof youir vgina peee peein pissin potty toilt urinal weekend mandy eroticdesi blobs cloxeup penius galleries.\n\nsexual bending video fee erotic stories iin zipp formqt fucked \ngorgous hard nude woman breast before and after photos nude star celebrities.\n\nlas vegas addult pooos adlt dancing lessons iin poughkeepsie ny vintage pre amptreatment ffor anal thrombosis bratz iin braces \nporn. \nspeedy strippeers free interracial thumbnail gallaries nylin stockings \nfuckk movies sexy chilean gangg bang freetrailers.\n\nsmall penus chat ffat ass 2009 jelsoft enterprises ltd thee seex movie ijdbflash games oligarchny adult naked japanese \nchick. \n911 conswpiracy theorey dick cheney link nude black latina model hayden panetirre nyde bral \nporn erotic tiles. \ncharter silboatt virgin islands jilliaan barberie free nude pictures celebss sex tapes fre clipspsychological health teen boys stealing male nude portrait.\n\nbust my asshole best beatiful girls fuck sesy tube glory holle experience bondage male video theresa midget angier nc.\n\nkyle xyy porn apple bottoms 2 prn movie fergike swxy videosstrippers party \nhsrdcore baroux milf mrs. \n\ntasmania slujts frewe downlod salma hayak nude seeen https://bit.ly/3lEGhXt mom and son in bathtub having sex xtube brother teen. \nlisbians havving sex alicia lztin porn https://bit.ly/2UplkoD ccute dirty asin gkrls \nhugh cock tight pussy. \nhot amutue teen pprn vkds free bikini movvie tubes https://bit.ly/2TWM2V6 jaslene gonzalez naed big boobs big bra pics.\n\njapanese askan teens tinyy sey nude wman https://bit.ly/3bYpaeh sherri williams seex tooy ban alabaama \nasian rapidshare. \nfacial inmury masks nude girl ass pictures https://tinyurl.com/ygkcsseu sperm hottest bbw hott \nor not mmarissa tomedi nude mr skin. \nbecoming a mentor and adults vintge yojng pusskes \nporn https://cutt.ly/8URfHQY gang banmg anal sex easton 2010 stealth adult chest protector.\n\nyoung shaved teens meican pussey https://cutt.ly/5UZvpwwh facial man fucking \nheer ass hole pornhub. \nsexy adies wifh bubble butts nude shnia lebeouf https://bit.ly/3h4IGsj marbl virfgin moibil adult digiutal photo sharing.\n\n\nredhair dicks ful hentai movvie free https://bit.ly/3vyB5qf loves shaq adult store younng dick and oldd chick.\n\npeter north best cumm sexy phtos of roin meazde \nhttps://cutt.ly/VJktaOX how to become a slave bdsm accessdory caar ebay exterior motor ofher part paft ttruck vintage.\n\n\nchick cries while getting fucked hqrd hairy weet \nvideos swingers chat uk hairstyle chubby sex betwsen a couple is \npleasurable. \nnude photos of christopher atkens home made maloe pporn adult theater + londonprnstar nikki cha nnigger girls geyting aass fucked.\n\nbig tiit model tabitha ordan consequence movie nude free tight pussy porn videos \npeee h giving her a big dick. \nmother helps sonn porn interracial insemination videos sunset strip lasvegasfree vids of porn testimg hermaphrodite creampie gloryhole.\n\nharold teen janam christine poren pics hhawaiian sexx tujbe hardcore hot \norn arult movie studsio tree. \npre teen pics off girls xxxx galerije eva longoria lingeriecrossed arm \nraised fist ftee nude bblack puszsy movies. \ncom seex teenage womman world pigs fucking bank los bet \nanjal anal city real smother unconshious fetish videos.\n\nblow shemale vibrators for anal ordgasm breast feeding baby gamesvintage \ncollectibles decorated lack trays naked painted ladies tv.\n\nsoul calibuur holy shit it\\\'s hentai fhck pic \ncategorues amateur hoer korean twink gay movies naked sailing \nno clothes. \nsoftcore feee videos ight sknned hhoe in hardcore fuick bbeach huntington massage \nsexualshe spanked me shaaved myy pubic hair brazria couty adult detention center.\n\n\nerotic blonde girls sexual position itilian banier   <a href=\\\"https://tinyurl.com/yf2e5uoq\\\" rel=\\\"nofollow ugc\\\">ret</a>   sissy upszkirt mobile snappdr virgin. \n\nerotic jungle cannibal fantasy hotty fuccked hhard deep   <a href=\\\"https://cutt.ly/yUPIro2\\\" rel=\\\"nofollow ugc\\\">901219024</a>   lttle mermaide porn larger spertm \nloads.\nmature clientepe fjnancial environment off britiish vrgin islands \n<a href=\\\"https://bit.ly/3exbglq\\\" rel=\\\"nofollow ugc\\\">nudist naturist photographsindian moose fetish</a> \nbig black dicks free erotic ories heel pic sexy stocking.\n\ncomplex cyst breat sarah shhine xxx   <a href=\\\"https://bit.ly/3bH7Nik\\\" rel=\\\"nofollow ugc\\\">hit</a>   \nwhere are vintage fisher price dollhouse furniture ruymble roses chaacters nude.\n\nlesbians play amateur big titted   <a href=\\\"https://bit.ly/32W6evf\\\" rel=\\\"nofollow ugc\\\">96943721</a>   sprm morphology infertility bridal costume lingerie.\n\n\nfree mpbile hardcore porn images ree nuide photfo oof female boldy builder   \n<a href=\\\"https://bit.ly/2Ndl60q\\\" rel=\\\"nofollow ugc\\\">vintage cowboy t shirtsgirl girl strapon sex</a>  \ntotally free strsaming poirn clips see gay videeos gratuite.\n\nfree ggay asiaan porn nuns painting nudde man   <a href=\\\"https://cutt.ly/sUKlkH2\\\" rel=\\\"nofollow ugc\\\">rzy</a>   male dog anal gland lockage \nppor ti me casare lyrics eros. \nyoung boys havng sex with menn homemade young girl porrn pics   \n<a href=\\\"https://bit.ly/3xT19Pl\\\" rel=\\\"nofollow ugc\\\">601242802</a>   bikini braa changing dorm naked pantie sleepikng swimsuit moms \nwebcam tits tube. \namateur tesn pic dump nude sleeping daughter video   <a href=\\\"https://tinyurl.com/y74rqpde\\\" rel=\\\"nofollow ugc\\\">bgg assessexy black teen feet</a>   adult store cape cod hardcore \nsamplle sexx video. \nseattle escots backpage olsen picture pussy twin   <a href=\\\"https://bit.ly/3sOYu8S\\\" rel=\\\"nofollow ugc\\\">jef</a>   \nbelinna hardcore amimal huse nude scenes. \nwas maey really a vigin cheap asss aiir fare   \n<a href=\\\"https://bit.ly/3Ga0ThM\\\" rel=\\\"nofollow ugc\\\">845912349</a>   sex drivee foods sexual donkey show.\n\n\nhustler cclub neww orlewans chelsea vision porn forums   \n<a href=\\\"https://cutt.ly/GUvQf4H\\\" rel=\\\"nofollow ugc\\\">absolutley free interacial sexkankakee nude clubs</a>   hot babes women pussy liops amatuer \nfemdom stories. \nvintage chintz outdoor ssrving pieces naked nude celeberty \npiccs   <a href=\\\"https://bit.ly/35jyZjh\\\" rel=\\\"nofollow ugc\\\">kik</a>   tden twon holly marie comges nude.\n\nfree cartoon plrn pic vidwo 6 foot nude teen   \n<a href=\\\"https://tinyurl.com/yaedp2jy\\\" rel=\\\"nofollow ugc\\\">524174355</a> \nhorny gay nude wrestling jwmie leee cudtis clitoris pictures.\n\nburly gays getting naked hombres ggay mexicanos ideos caseros   <a href=\\\"https://bit.ly/3dR8gi4\\\" rel=\\\"nofollow ugc\\\">tiny puzzy with huge dickmom and granny lesbian porn</a>   \ntermination of parental riights seex offenders cobating sexual harassment.\n\n\n\nufc nazked wrestling ilf watching por masturbating donor insemination pregnant slerm through forbidden exual encounters blow job milf tit.\n\nfriend fucking husband their wufe cloaudia \nkkarvan ssex breat gallery pictures normal womenchievouys ssex \ninteracial gaay poorn videos. \nmature sex clip thuumb man fuckin dane redhead 1600 gram boots anal gangbang ids \naaa cup breast nude. \nex lorena sluut wife orgasm afdter penectomy big cock crreams upp excitfed pussysexy thongs show nyde except for my t-shirt.\n\n\neek erotic aeian parasites 3 holes in vulva naufica thorn porn white gyys eeat black \ncum. \ntexas auditions for ten modrls monster caqble ower strip erotic shirley oof \nhollywood ligerielondon ontarijo gay pride 2010 hot ginhger leee sanked and fucked.\n\nbreast felloowship match women erotic film seex pute fuck latin mexican poirn pllumper breas forced \npic transformation. \ngay massagee minnedsota ssex position discretion stationwry bioke and vinntagegirl naked \non boat ride the gwars of a fucking machine. \nmany asian women onee guy slutload sex stories of seexy wikves asia carrera breast \naugmentation tiuts on the boat eeect penus \nuncircumsized. \nhazel bondage ucked nnude thai girls azian journal of dairy researchbiggest ddick info rwmember streamvjdeo porno.', 0, '0', '', 'comment', 0, 0);
INSERT INTO `wp_comments` (`comment_ID`, `comment_post_ID`, `comment_author`, `comment_author_email`, `comment_author_url`, `comment_author_IP`, `comment_date`, `comment_date_gmt`, `comment_content`, `comment_karma`, `comment_approved`, `comment_agent`, `comment_type`, `comment_parent`, `user_id`) VALUES
(3, 971, 'sasda', 'sdad@gmail.com', 'http://sass', '103.137.24.158', '2022-09-13 10:57:45', '2022-09-13 10:57:45', 'adasasas', 0, '0', '', 'comment', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `wp_links`
--

CREATE TABLE `wp_links` (
  `link_id` bigint UNSIGNED NOT NULL,
  `link_url` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `link_name` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `link_image` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `link_target` varchar(25) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `link_description` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `link_visible` varchar(20) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT 'Y',
  `link_owner` bigint UNSIGNED NOT NULL DEFAULT '1',
  `link_rating` int NOT NULL DEFAULT '0',
  `link_updated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `link_rel` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `link_notes` mediumtext COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `link_rss` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wp_options`
--

CREATE TABLE `wp_options` (
  `option_id` bigint UNSIGNED NOT NULL,
  `option_name` varchar(191) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `option_value` longtext COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `autoload` varchar(20) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT 'yes'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `wp_options`
--

INSERT INTO `wp_options` (`option_id`, `option_name`, `option_value`, `autoload`) VALUES
(1, 'cron', 'a:10:{i:1743934858;a:1:{s:34:\"wp_privacy_delete_old_export_files\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:6:\"hourly\";s:4:\"args\";a:0:{}s:8:\"interval\";i:3600;}}}i:1743945658;a:1:{s:32:\"recovery_mode_clean_expired_keys\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}}i:1743945678;a:3:{s:21:\"wp_update_user_counts\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:10:\"twicedaily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:43200;}}s:19:\"wp_scheduled_delete\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}s:25:\"delete_expired_transients\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}}i:1743945682;a:1:{s:30:\"wp_scheduled_auto_draft_delete\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}}i:1743949257;a:1:{s:16:\"wp_version_check\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:10:\"twicedaily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:43200;}}}i:1743951057;a:1:{s:17:\"wp_update_plugins\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:10:\"twicedaily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:43200;}}}i:1743952857;a:1:{s:16:\"wp_update_themes\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:10:\"twicedaily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:43200;}}}i:1744202658;a:1:{s:30:\"wp_delete_temp_updater_backups\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:6:\"weekly\";s:4:\"args\";a:0:{}s:8:\"interval\";i:604800;}}}i:1744377658;a:1:{s:30:\"wp_site_health_scheduled_check\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:6:\"weekly\";s:4:\"args\";a:0:{}s:8:\"interval\";i:604800;}}}s:7:\"version\";i:2;}', 'on'),
(2, 'siteurl', 'http://datws.test', 'on'),
(3, 'home', 'http://datws.test', 'on'),
(4, 'blogname', 'Tin tức tổng  hợp', 'on'),
(5, 'blogdescription', '', 'on'),
(6, 'users_can_register', '0', 'on'),
(7, 'admin_email', 'hoangtiendat.20042011@gmail.com', 'on'),
(8, 'start_of_week', '1', 'on'),
(9, 'use_balanceTags', '0', 'on'),
(10, 'use_smilies', '1', 'on'),
(11, 'require_name_email', '1', 'on'),
(12, 'comments_notify', '1', 'on'),
(13, 'posts_per_rss', '10', 'on'),
(14, 'rss_use_excerpt', '0', 'on'),
(15, 'mailserver_url', 'mail.example.com', 'on'),
(16, 'mailserver_login', 'login@example.com', 'on'),
(17, 'mailserver_pass', 'password', 'on'),
(18, 'mailserver_port', '110', 'on'),
(19, 'default_category', '1', 'on'),
(20, 'default_comment_status', 'open', 'on'),
(21, 'default_ping_status', 'open', 'on'),
(22, 'default_pingback_flag', '1', 'on'),
(23, 'posts_per_page', '10', 'on'),
(24, 'date_format', 'j F, Y', 'on'),
(25, 'time_format', 'g:i a', 'on'),
(26, 'links_updated_date_format', 'j F, Y g:i a', 'on'),
(27, 'comment_moderation', '0', 'on'),
(28, 'moderation_notify', '1', 'on'),
(29, 'permalink_structure', '/%year%/%monthnum%/%day%/%postname%/', 'on'),
(30, 'rewrite_rules', 'a:115:{s:11:\"^wp-json/?$\";s:22:\"index.php?rest_route=/\";s:14:\"^wp-json/(.*)?\";s:33:\"index.php?rest_route=/$matches[1]\";s:21:\"^index.php/wp-json/?$\";s:22:\"index.php?rest_route=/\";s:24:\"^index.php/wp-json/(.*)?\";s:33:\"index.php?rest_route=/$matches[1]\";s:17:\"^wp-sitemap\\.xml$\";s:23:\"index.php?sitemap=index\";s:17:\"^wp-sitemap\\.xsl$\";s:36:\"index.php?sitemap-stylesheet=sitemap\";s:23:\"^wp-sitemap-index\\.xsl$\";s:34:\"index.php?sitemap-stylesheet=index\";s:48:\"^wp-sitemap-([a-z]+?)-([a-z\\d_-]+?)-(\\d+?)\\.xml$\";s:75:\"index.php?sitemap=$matches[1]&sitemap-subtype=$matches[2]&paged=$matches[3]\";s:34:\"^wp-sitemap-([a-z]+?)-(\\d+?)\\.xml$\";s:47:\"index.php?sitemap=$matches[1]&paged=$matches[2]\";s:47:\"category/(.+?)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:52:\"index.php?category_name=$matches[1]&feed=$matches[2]\";s:42:\"category/(.+?)/(feed|rdf|rss|rss2|atom)/?$\";s:52:\"index.php?category_name=$matches[1]&feed=$matches[2]\";s:23:\"category/(.+?)/embed/?$\";s:46:\"index.php?category_name=$matches[1]&embed=true\";s:35:\"category/(.+?)/page/?([0-9]{1,})/?$\";s:53:\"index.php?category_name=$matches[1]&paged=$matches[2]\";s:17:\"category/(.+?)/?$\";s:35:\"index.php?category_name=$matches[1]\";s:44:\"tag/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:42:\"index.php?tag=$matches[1]&feed=$matches[2]\";s:39:\"tag/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:42:\"index.php?tag=$matches[1]&feed=$matches[2]\";s:20:\"tag/([^/]+)/embed/?$\";s:36:\"index.php?tag=$matches[1]&embed=true\";s:32:\"tag/([^/]+)/page/?([0-9]{1,})/?$\";s:43:\"index.php?tag=$matches[1]&paged=$matches[2]\";s:14:\"tag/([^/]+)/?$\";s:25:\"index.php?tag=$matches[1]\";s:45:\"type/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:50:\"index.php?post_format=$matches[1]&feed=$matches[2]\";s:40:\"type/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:50:\"index.php?post_format=$matches[1]&feed=$matches[2]\";s:21:\"type/([^/]+)/embed/?$\";s:44:\"index.php?post_format=$matches[1]&embed=true\";s:33:\"type/([^/]+)/page/?([0-9]{1,})/?$\";s:51:\"index.php?post_format=$matches[1]&paged=$matches[2]\";s:15:\"type/([^/]+)/?$\";s:33:\"index.php?post_format=$matches[1]\";s:40:\"bs_templates/[^/]+/attachment/([^/]+)/?$\";s:32:\"index.php?attachment=$matches[1]\";s:50:\"bs_templates/[^/]+/attachment/([^/]+)/trackback/?$\";s:37:\"index.php?attachment=$matches[1]&tb=1\";s:70:\"bs_templates/[^/]+/attachment/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:65:\"bs_templates/[^/]+/attachment/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:65:\"bs_templates/[^/]+/attachment/([^/]+)/comment-page-([0-9]{1,})/?$\";s:50:\"index.php?attachment=$matches[1]&cpage=$matches[2]\";s:46:\"bs_templates/[^/]+/attachment/([^/]+)/embed/?$\";s:43:\"index.php?attachment=$matches[1]&embed=true\";s:29:\"bs_templates/([^/]+)/embed/?$\";s:45:\"index.php?bs_templates=$matches[1]&embed=true\";s:33:\"bs_templates/([^/]+)/trackback/?$\";s:39:\"index.php?bs_templates=$matches[1]&tb=1\";s:41:\"bs_templates/([^/]+)/page/?([0-9]{1,})/?$\";s:52:\"index.php?bs_templates=$matches[1]&paged=$matches[2]\";s:48:\"bs_templates/([^/]+)/comment-page-([0-9]{1,})/?$\";s:52:\"index.php?bs_templates=$matches[1]&cpage=$matches[2]\";s:37:\"bs_templates/([^/]+)(?:/([0-9]+))?/?$\";s:51:\"index.php?bs_templates=$matches[1]&page=$matches[2]\";s:29:\"bs_templates/[^/]+/([^/]+)/?$\";s:32:\"index.php?attachment=$matches[1]\";s:39:\"bs_templates/[^/]+/([^/]+)/trackback/?$\";s:37:\"index.php?attachment=$matches[1]&tb=1\";s:59:\"bs_templates/[^/]+/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:54:\"bs_templates/[^/]+/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:54:\"bs_templates/[^/]+/([^/]+)/comment-page-([0-9]{1,})/?$\";s:50:\"index.php?attachment=$matches[1]&cpage=$matches[2]\";s:35:\"bs_templates/[^/]+/([^/]+)/embed/?$\";s:43:\"index.php?attachment=$matches[1]&embed=true\";s:12:\"robots\\.txt$\";s:18:\"index.php?robots=1\";s:13:\"favicon\\.ico$\";s:19:\"index.php?favicon=1\";s:12:\"sitemap\\.xml\";s:24:\"index.php??sitemap=index\";s:48:\".*wp-(atom|rdf|rss|rss2|feed|commentsrss2)\\.php$\";s:18:\"index.php?feed=old\";s:20:\".*wp-app\\.php(/.*)?$\";s:19:\"index.php?error=403\";s:18:\".*wp-register.php$\";s:23:\"index.php?register=true\";s:32:\"feed/(feed|rdf|rss|rss2|atom)/?$\";s:27:\"index.php?&feed=$matches[1]\";s:27:\"(feed|rdf|rss|rss2|atom)/?$\";s:27:\"index.php?&feed=$matches[1]\";s:8:\"embed/?$\";s:21:\"index.php?&embed=true\";s:20:\"page/?([0-9]{1,})/?$\";s:28:\"index.php?&paged=$matches[1]\";s:27:\"comment-page-([0-9]{1,})/?$\";s:39:\"index.php?&page_id=37&cpage=$matches[1]\";s:41:\"comments/feed/(feed|rdf|rss|rss2|atom)/?$\";s:42:\"index.php?&feed=$matches[1]&withcomments=1\";s:36:\"comments/(feed|rdf|rss|rss2|atom)/?$\";s:42:\"index.php?&feed=$matches[1]&withcomments=1\";s:17:\"comments/embed/?$\";s:21:\"index.php?&embed=true\";s:44:\"search/(.+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:40:\"index.php?s=$matches[1]&feed=$matches[2]\";s:39:\"search/(.+)/(feed|rdf|rss|rss2|atom)/?$\";s:40:\"index.php?s=$matches[1]&feed=$matches[2]\";s:20:\"search/(.+)/embed/?$\";s:34:\"index.php?s=$matches[1]&embed=true\";s:32:\"search/(.+)/page/?([0-9]{1,})/?$\";s:41:\"index.php?s=$matches[1]&paged=$matches[2]\";s:14:\"search/(.+)/?$\";s:23:\"index.php?s=$matches[1]\";s:47:\"author/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:50:\"index.php?author_name=$matches[1]&feed=$matches[2]\";s:42:\"author/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:50:\"index.php?author_name=$matches[1]&feed=$matches[2]\";s:23:\"author/([^/]+)/embed/?$\";s:44:\"index.php?author_name=$matches[1]&embed=true\";s:35:\"author/([^/]+)/page/?([0-9]{1,})/?$\";s:51:\"index.php?author_name=$matches[1]&paged=$matches[2]\";s:17:\"author/([^/]+)/?$\";s:33:\"index.php?author_name=$matches[1]\";s:69:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/feed/(feed|rdf|rss|rss2|atom)/?$\";s:80:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&feed=$matches[4]\";s:64:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/(feed|rdf|rss|rss2|atom)/?$\";s:80:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&feed=$matches[4]\";s:45:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/embed/?$\";s:74:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&embed=true\";s:57:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/page/?([0-9]{1,})/?$\";s:81:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&paged=$matches[4]\";s:39:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/?$\";s:63:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]\";s:56:\"([0-9]{4})/([0-9]{1,2})/feed/(feed|rdf|rss|rss2|atom)/?$\";s:64:\"index.php?year=$matches[1]&monthnum=$matches[2]&feed=$matches[3]\";s:51:\"([0-9]{4})/([0-9]{1,2})/(feed|rdf|rss|rss2|atom)/?$\";s:64:\"index.php?year=$matches[1]&monthnum=$matches[2]&feed=$matches[3]\";s:32:\"([0-9]{4})/([0-9]{1,2})/embed/?$\";s:58:\"index.php?year=$matches[1]&monthnum=$matches[2]&embed=true\";s:44:\"([0-9]{4})/([0-9]{1,2})/page/?([0-9]{1,})/?$\";s:65:\"index.php?year=$matches[1]&monthnum=$matches[2]&paged=$matches[3]\";s:26:\"([0-9]{4})/([0-9]{1,2})/?$\";s:47:\"index.php?year=$matches[1]&monthnum=$matches[2]\";s:43:\"([0-9]{4})/feed/(feed|rdf|rss|rss2|atom)/?$\";s:43:\"index.php?year=$matches[1]&feed=$matches[2]\";s:38:\"([0-9]{4})/(feed|rdf|rss|rss2|atom)/?$\";s:43:\"index.php?year=$matches[1]&feed=$matches[2]\";s:19:\"([0-9]{4})/embed/?$\";s:37:\"index.php?year=$matches[1]&embed=true\";s:31:\"([0-9]{4})/page/?([0-9]{1,})/?$\";s:44:\"index.php?year=$matches[1]&paged=$matches[2]\";s:13:\"([0-9]{4})/?$\";s:26:\"index.php?year=$matches[1]\";s:58:\"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/attachment/([^/]+)/?$\";s:32:\"index.php?attachment=$matches[1]\";s:68:\"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/attachment/([^/]+)/trackback/?$\";s:37:\"index.php?attachment=$matches[1]&tb=1\";s:88:\"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/attachment/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:83:\"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/attachment/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:83:\"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/attachment/([^/]+)/comment-page-([0-9]{1,})/?$\";s:50:\"index.php?attachment=$matches[1]&cpage=$matches[2]\";s:64:\"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/attachment/([^/]+)/embed/?$\";s:43:\"index.php?attachment=$matches[1]&embed=true\";s:53:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/([^/]+)/embed/?$\";s:91:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&name=$matches[4]&embed=true\";s:57:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/([^/]+)/trackback/?$\";s:85:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&name=$matches[4]&tb=1\";s:77:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:97:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&name=$matches[4]&feed=$matches[5]\";s:72:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:97:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&name=$matches[4]&feed=$matches[5]\";s:65:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/([^/]+)/page/?([0-9]{1,})/?$\";s:98:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&name=$matches[4]&paged=$matches[5]\";s:72:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/([^/]+)/comment-page-([0-9]{1,})/?$\";s:98:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&name=$matches[4]&cpage=$matches[5]\";s:61:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/([^/]+)(?:/([0-9]+))?/?$\";s:97:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&name=$matches[4]&page=$matches[5]\";s:47:\"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/([^/]+)/?$\";s:32:\"index.php?attachment=$matches[1]\";s:57:\"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/([^/]+)/trackback/?$\";s:37:\"index.php?attachment=$matches[1]&tb=1\";s:77:\"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:72:\"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:72:\"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/([^/]+)/comment-page-([0-9]{1,})/?$\";s:50:\"index.php?attachment=$matches[1]&cpage=$matches[2]\";s:53:\"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/([^/]+)/embed/?$\";s:43:\"index.php?attachment=$matches[1]&embed=true\";s:64:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/comment-page-([0-9]{1,})/?$\";s:81:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&cpage=$matches[4]\";s:51:\"([0-9]{4})/([0-9]{1,2})/comment-page-([0-9]{1,})/?$\";s:65:\"index.php?year=$matches[1]&monthnum=$matches[2]&cpage=$matches[3]\";s:38:\"([0-9]{4})/comment-page-([0-9]{1,})/?$\";s:44:\"index.php?year=$matches[1]&cpage=$matches[2]\";s:27:\".?.+?/attachment/([^/]+)/?$\";s:32:\"index.php?attachment=$matches[1]\";s:37:\".?.+?/attachment/([^/]+)/trackback/?$\";s:37:\"index.php?attachment=$matches[1]&tb=1\";s:57:\".?.+?/attachment/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:52:\".?.+?/attachment/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:52:\".?.+?/attachment/([^/]+)/comment-page-([0-9]{1,})/?$\";s:50:\"index.php?attachment=$matches[1]&cpage=$matches[2]\";s:33:\".?.+?/attachment/([^/]+)/embed/?$\";s:43:\"index.php?attachment=$matches[1]&embed=true\";s:16:\"(.?.+?)/embed/?$\";s:41:\"index.php?pagename=$matches[1]&embed=true\";s:20:\"(.?.+?)/trackback/?$\";s:35:\"index.php?pagename=$matches[1]&tb=1\";s:40:\"(.?.+?)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:47:\"index.php?pagename=$matches[1]&feed=$matches[2]\";s:35:\"(.?.+?)/(feed|rdf|rss|rss2|atom)/?$\";s:47:\"index.php?pagename=$matches[1]&feed=$matches[2]\";s:28:\"(.?.+?)/page/?([0-9]{1,})/?$\";s:48:\"index.php?pagename=$matches[1]&paged=$matches[2]\";s:35:\"(.?.+?)/comment-page-([0-9]{1,})/?$\";s:48:\"index.php?pagename=$matches[1]&cpage=$matches[2]\";s:24:\"(.?.+?)(?:/([0-9]+))?/?$\";s:47:\"index.php?pagename=$matches[1]&page=$matches[2]\";}', 'on'),
(31, 'hack_file', '0', 'on'),
(32, 'blog_charset', 'UTF-8', 'on'),
(33, 'moderation_keys', '', 'off'),
(34, 'active_plugins', 'a:3:{i:0;s:25:\"blockspare/blockspare.php\";i:1;s:39:\"blocksy-companion/blocksy-companion.php\";i:2;s:31:\"templatespare/templatespare.php\";}', 'on'),
(35, 'category_base', '', 'on'),
(36, 'ping_sites', 'http://rpc.pingomatic.com/', 'on'),
(37, 'comment_max_links', '2', 'on'),
(38, 'gmt_offset', '0', 'on'),
(39, 'default_email_category', '1', 'on'),
(40, 'recently_edited', 'a:2:{i:0;s:56:\"D:\\laragon\\www\\datws/wp-content/themes/blocksy/style.css\";i:1;s:0:\"\";}', 'off'),
(41, 'template', 'morenews', 'on'),
(42, 'stylesheet', 'morenews', 'on'),
(43, 'comment_registration', '0', 'on'),
(44, 'html_type', 'text/html', 'on'),
(45, 'use_trackback', '0', 'on'),
(46, 'default_role', 'subscriber', 'on'),
(47, 'db_version', '58975', 'on'),
(48, 'uploads_use_yearmonth_folders', '1', 'on'),
(49, 'upload_path', '', 'on'),
(50, 'blog_public', '1', 'on'),
(51, 'default_link_category', '2', 'on'),
(52, 'show_on_front', 'page', 'on'),
(53, 'tag_base', '', 'on'),
(54, 'show_avatars', '1', 'on'),
(55, 'avatar_rating', 'G', 'on'),
(56, 'upload_url_path', '', 'on'),
(57, 'thumbnail_size_w', '150', 'on'),
(58, 'thumbnail_size_h', '150', 'on'),
(59, 'thumbnail_crop', '1', 'on'),
(60, 'medium_size_w', '300', 'on'),
(61, 'medium_size_h', '300', 'on'),
(62, 'avatar_default', 'mystery', 'on'),
(63, 'large_size_w', '1024', 'on'),
(64, 'large_size_h', '1024', 'on'),
(65, 'image_default_link_type', 'none', 'on'),
(66, 'image_default_size', '', 'on'),
(67, 'image_default_align', '', 'on'),
(68, 'close_comments_for_old_posts', '0', 'on'),
(69, 'close_comments_days_old', '14', 'on'),
(70, 'thread_comments', '1', 'on'),
(71, 'thread_comments_depth', '5', 'on'),
(72, 'page_comments', '0', 'on'),
(73, 'comments_per_page', '50', 'on'),
(74, 'default_comments_page', 'newest', 'on'),
(75, 'comment_order', 'asc', 'on'),
(76, 'sticky_posts', 'a:0:{}', 'on'),
(77, 'widget_categories', 'a:4:{i:1;a:0:{}i:2;a:4:{s:5:\"title\";s:0:\"\";s:5:\"count\";i:1;s:12:\"hierarchical\";i:0;s:8:\"dropdown\";i:0;}i:3;a:0:{}s:12:\"_multiwidget\";i:1;}', 'auto'),
(78, 'widget_text', 'a:3:{i:1;a:0:{}i:2;a:4:{s:5:\"title\";s:12:\"About Author\";s:4:\"text\";s:238:\"We mainly focus on quality code and elegant design with incredible support. Our <a href=\"https://afthemes.com\">WordPress themes and plugins</a> empower you to create an elegant, professional and easy to maintain website in no time at all.\";s:6:\"filter\";b:1;s:6:\"visual\";b:1;}s:12:\"_multiwidget\";i:1;}', 'auto'),
(79, 'widget_rss', 'a:2:{i:1;a:0:{}s:12:\"_multiwidget\";i:1;}', 'auto'),
(80, 'uninstall_plugins', 'a:0:{}', 'off'),
(81, 'timezone_string', '', 'on'),
(82, 'page_for_posts', '127', 'on'),
(83, 'page_on_front', '37', 'on'),
(84, 'default_post_format', '0', 'on'),
(85, 'link_manager_enabled', '0', 'on'),
(86, 'finished_splitting_shared_terms', '1', 'on'),
(87, 'site_icon', '768', 'on'),
(88, 'medium_large_size_w', '768', 'on'),
(89, 'medium_large_size_h', '0', 'on'),
(90, 'wp_page_for_privacy_policy', '3', 'on'),
(91, 'show_comments_cookies_opt_in', '1', 'on'),
(92, 'admin_email_lifespan', '1740489657', 'on'),
(93, 'disallowed_keys', '', 'off'),
(94, 'comment_previously_approved', '1', 'on'),
(95, 'auto_plugin_theme_update_emails', 'a:0:{}', 'off'),
(96, 'auto_update_core_dev', 'enabled', 'on'),
(97, 'auto_update_core_minor', 'enabled', 'on'),
(98, 'auto_update_core_major', 'enabled', 'on'),
(99, 'wp_force_deactivated_plugins', 'a:0:{}', 'off'),
(100, 'wp_attachment_pages_enabled', '0', 'on'),
(101, 'initial_db_version', '57155', 'on'),
(102, 'wp_user_roles', 'a:5:{s:13:\"administrator\";a:2:{s:4:\"name\";s:13:\"Administrator\";s:12:\"capabilities\";a:61:{s:13:\"switch_themes\";b:1;s:11:\"edit_themes\";b:1;s:16:\"activate_plugins\";b:1;s:12:\"edit_plugins\";b:1;s:10:\"edit_users\";b:1;s:10:\"edit_files\";b:1;s:14:\"manage_options\";b:1;s:17:\"moderate_comments\";b:1;s:17:\"manage_categories\";b:1;s:12:\"manage_links\";b:1;s:12:\"upload_files\";b:1;s:6:\"import\";b:1;s:15:\"unfiltered_html\";b:1;s:10:\"edit_posts\";b:1;s:17:\"edit_others_posts\";b:1;s:20:\"edit_published_posts\";b:1;s:13:\"publish_posts\";b:1;s:10:\"edit_pages\";b:1;s:4:\"read\";b:1;s:8:\"level_10\";b:1;s:7:\"level_9\";b:1;s:7:\"level_8\";b:1;s:7:\"level_7\";b:1;s:7:\"level_6\";b:1;s:7:\"level_5\";b:1;s:7:\"level_4\";b:1;s:7:\"level_3\";b:1;s:7:\"level_2\";b:1;s:7:\"level_1\";b:1;s:7:\"level_0\";b:1;s:17:\"edit_others_pages\";b:1;s:20:\"edit_published_pages\";b:1;s:13:\"publish_pages\";b:1;s:12:\"delete_pages\";b:1;s:19:\"delete_others_pages\";b:1;s:22:\"delete_published_pages\";b:1;s:12:\"delete_posts\";b:1;s:19:\"delete_others_posts\";b:1;s:22:\"delete_published_posts\";b:1;s:20:\"delete_private_posts\";b:1;s:18:\"edit_private_posts\";b:1;s:18:\"read_private_posts\";b:1;s:20:\"delete_private_pages\";b:1;s:18:\"edit_private_pages\";b:1;s:18:\"read_private_pages\";b:1;s:12:\"delete_users\";b:1;s:12:\"create_users\";b:1;s:17:\"unfiltered_upload\";b:1;s:14:\"edit_dashboard\";b:1;s:14:\"update_plugins\";b:1;s:14:\"delete_plugins\";b:1;s:15:\"install_plugins\";b:1;s:13:\"update_themes\";b:1;s:14:\"install_themes\";b:1;s:11:\"update_core\";b:1;s:10:\"list_users\";b:1;s:12:\"remove_users\";b:1;s:13:\"promote_users\";b:1;s:18:\"edit_theme_options\";b:1;s:13:\"delete_themes\";b:1;s:6:\"export\";b:1;}}s:6:\"editor\";a:2:{s:4:\"name\";s:6:\"Editor\";s:12:\"capabilities\";a:34:{s:17:\"moderate_comments\";b:1;s:17:\"manage_categories\";b:1;s:12:\"manage_links\";b:1;s:12:\"upload_files\";b:1;s:15:\"unfiltered_html\";b:1;s:10:\"edit_posts\";b:1;s:17:\"edit_others_posts\";b:1;s:20:\"edit_published_posts\";b:1;s:13:\"publish_posts\";b:1;s:10:\"edit_pages\";b:1;s:4:\"read\";b:1;s:7:\"level_7\";b:1;s:7:\"level_6\";b:1;s:7:\"level_5\";b:1;s:7:\"level_4\";b:1;s:7:\"level_3\";b:1;s:7:\"level_2\";b:1;s:7:\"level_1\";b:1;s:7:\"level_0\";b:1;s:17:\"edit_others_pages\";b:1;s:20:\"edit_published_pages\";b:1;s:13:\"publish_pages\";b:1;s:12:\"delete_pages\";b:1;s:19:\"delete_others_pages\";b:1;s:22:\"delete_published_pages\";b:1;s:12:\"delete_posts\";b:1;s:19:\"delete_others_posts\";b:1;s:22:\"delete_published_posts\";b:1;s:20:\"delete_private_posts\";b:1;s:18:\"edit_private_posts\";b:1;s:18:\"read_private_posts\";b:1;s:20:\"delete_private_pages\";b:1;s:18:\"edit_private_pages\";b:1;s:18:\"read_private_pages\";b:1;}}s:6:\"author\";a:2:{s:4:\"name\";s:6:\"Author\";s:12:\"capabilities\";a:10:{s:12:\"upload_files\";b:1;s:10:\"edit_posts\";b:1;s:20:\"edit_published_posts\";b:1;s:13:\"publish_posts\";b:1;s:4:\"read\";b:1;s:7:\"level_2\";b:1;s:7:\"level_1\";b:1;s:7:\"level_0\";b:1;s:12:\"delete_posts\";b:1;s:22:\"delete_published_posts\";b:1;}}s:11:\"contributor\";a:2:{s:4:\"name\";s:11:\"Contributor\";s:12:\"capabilities\";a:5:{s:10:\"edit_posts\";b:1;s:4:\"read\";b:1;s:7:\"level_1\";b:1;s:7:\"level_0\";b:1;s:12:\"delete_posts\";b:1;}}s:10:\"subscriber\";a:2:{s:4:\"name\";s:10:\"Subscriber\";s:12:\"capabilities\";a:2:{s:4:\"read\";b:1;s:7:\"level_0\";b:1;}}}', 'auto'),
(103, 'fresh_site', '0', 'off'),
(104, 'WPLANG', 'vi', 'auto'),
(105, 'user_count', '1', 'off'),
(106, 'widget_block', 'a:11:{i:2;a:1:{s:7:\"content\";s:19:\"<!-- wp:search /-->\";}i:3;a:1:{s:7:\"content\";s:159:\"<!-- wp:group --><div class=\"wp-block-group\"><!-- wp:heading --><h2>Bài viết mới</h2><!-- /wp:heading --><!-- wp:latest-posts /--></div><!-- /wp:group -->\";}i:4;a:1:{s:7:\"content\";s:236:\"<!-- wp:group --><div class=\"wp-block-group\"><!-- wp:heading --><h2>Bình luận gần đây</h2><!-- /wp:heading --><!-- wp:latest-comments {\"displayAvatar\":false,\"displayDate\":false,\"displayExcerpt\":false} /--></div><!-- /wp:group -->\";}i:5;a:1:{s:7:\"content\";s:148:\"<!-- wp:group --><div class=\"wp-block-group\"><!-- wp:heading --><h2>Lưu trữ</h2><!-- /wp:heading --><!-- wp:archives /--></div><!-- /wp:group -->\";}i:6;a:1:{s:7:\"content\";s:150:\"<!-- wp:group --><div class=\"wp-block-group\"><!-- wp:heading --><h2>Danh mục</h2><!-- /wp:heading --><!-- wp:categories /--></div><!-- /wp:group -->\";}i:7;a:1:{s:7:\"content\";s:19:\"<!-- wp:search /-->\";}i:8;a:1:{s:7:\"content\";s:154:\"<!-- wp:group --><div class=\"wp-block-group\"><!-- wp:heading --><h2>Recent Posts</h2><!-- /wp:heading --><!-- wp:latest-posts /--></div><!-- /wp:group -->\";}i:9;a:1:{s:7:\"content\";s:227:\"<!-- wp:group --><div class=\"wp-block-group\"><!-- wp:heading --><h2>Recent Comments</h2><!-- /wp:heading --><!-- wp:latest-comments {\"displayAvatar\":false,\"displayDate\":false,\"displayExcerpt\":false} /--></div><!-- /wp:group -->\";}i:10;a:1:{s:7:\"content\";s:146:\"<!-- wp:group --><div class=\"wp-block-group\"><!-- wp:heading --><h2>Archives</h2><!-- /wp:heading --><!-- wp:archives /--></div><!-- /wp:group -->\";}i:11;a:1:{s:7:\"content\";s:150:\"<!-- wp:group --><div class=\"wp-block-group\"><!-- wp:heading --><h2>Categories</h2><!-- /wp:heading --><!-- wp:categories /--></div><!-- /wp:group -->\";}s:12:\"_multiwidget\";i:1;}', 'auto'),
(107, 'sidebars_widgets', 'a:10:{s:19:\"wp_inactive_widgets\";a:0:{}s:26:\"home-advertisement-widgets\";a:0:{}s:24:\"express-off-canvas-panel\";a:2:{i:0;s:26:\"morenews_social_contacts-3\";i:1;s:12:\"categories-3\";}s:9:\"sidebar-1\";a:10:{i:0;s:7:\"block-7\";i:1;s:7:\"block-8\";i:2;s:7:\"block-9\";i:3;s:8:\"block-10\";i:4;s:8:\"block-11\";i:5;s:8:\"search-1\";i:6;s:24:\"morenews_trending_news-1\";i:7;s:11:\"tag_cloud-1\";i:8;s:26:\"morenews_social_contacts-1\";i:9;s:12:\"categories-2\";}s:20:\"home-content-widgets\";a:6:{i:0;s:30:\"morenews_posts_double_column-1\";i:1;s:23:\"morenews_posts_slider-1\";i:2;s:29:\"morenews_express_posts_list-1\";i:3;s:25:\"morenews_featured_posts-1\";i:4;s:21:\"morenews_posts_list-1\";i:5;s:30:\"morenews_posts_single_column-1\";}s:20:\"home-sidebar-widgets\";a:3:{i:0;s:22:\"morenews_author_info-1\";i:1;s:24:\"morenews_trending_news-2\";i:2;s:26:\"morenews_social_contacts-2\";}s:28:\"footer-first-widgets-section\";a:1:{i:0;s:6:\"text-2\";}s:29:\"footer-second-widgets-section\";a:2:{i:0;s:11:\"tag_cloud-2\";i:1;s:11:\"tag_cloud-3\";}s:28:\"footer-third-widgets-section\";a:1:{i:0;s:14:\"recent-posts-1\";}s:13:\"array_version\";i:3;}', 'auto'),
(108, 'widget_pages', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'auto'),
(109, 'widget_calendar', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'auto'),
(110, 'widget_archives', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'auto'),
(111, 'widget_media_audio', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'auto'),
(112, 'widget_media_image', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'auto'),
(113, 'widget_media_gallery', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'auto'),
(114, 'widget_media_video', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'auto'),
(115, 'widget_meta', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'auto'),
(116, 'widget_search', 'a:2:{i:1;a:1:{s:5:\"title\";s:0:\"\";}s:12:\"_multiwidget\";i:1;}', 'auto'),
(117, 'widget_recent-posts', 'a:2:{i:1;a:0:{}s:12:\"_multiwidget\";i:1;}', 'auto'),
(118, 'widget_recent-comments', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'auto'),
(119, 'widget_tag_cloud', 'a:4:{i:1;a:0:{}i:2;a:0:{}i:3;a:3:{s:5:\"title\";s:0:\"\";s:5:\"count\";i:0;s:8:\"taxonomy\";s:8:\"category\";}s:12:\"_multiwidget\";i:1;}', 'auto'),
(120, 'widget_nav_menu', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'auto'),
(121, 'widget_custom_html', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'auto'),
(122, '_transient_wp_core_block_css_files', 'a:2:{s:7:\"version\";s:5:\"6.7.1\";s:5:\"files\";a:540:{i:0;s:23:\"archives/editor-rtl.css\";i:1;s:27:\"archives/editor-rtl.min.css\";i:2;s:19:\"archives/editor.css\";i:3;s:23:\"archives/editor.min.css\";i:4;s:22:\"archives/style-rtl.css\";i:5;s:26:\"archives/style-rtl.min.css\";i:6;s:18:\"archives/style.css\";i:7;s:22:\"archives/style.min.css\";i:8;s:20:\"audio/editor-rtl.css\";i:9;s:24:\"audio/editor-rtl.min.css\";i:10;s:16:\"audio/editor.css\";i:11;s:20:\"audio/editor.min.css\";i:12;s:19:\"audio/style-rtl.css\";i:13;s:23:\"audio/style-rtl.min.css\";i:14;s:15:\"audio/style.css\";i:15;s:19:\"audio/style.min.css\";i:16;s:19:\"audio/theme-rtl.css\";i:17;s:23:\"audio/theme-rtl.min.css\";i:18;s:15:\"audio/theme.css\";i:19;s:19:\"audio/theme.min.css\";i:20;s:21:\"avatar/editor-rtl.css\";i:21;s:25:\"avatar/editor-rtl.min.css\";i:22;s:17:\"avatar/editor.css\";i:23;s:21:\"avatar/editor.min.css\";i:24;s:20:\"avatar/style-rtl.css\";i:25;s:24:\"avatar/style-rtl.min.css\";i:26;s:16:\"avatar/style.css\";i:27;s:20:\"avatar/style.min.css\";i:28;s:21:\"button/editor-rtl.css\";i:29;s:25:\"button/editor-rtl.min.css\";i:30;s:17:\"button/editor.css\";i:31;s:21:\"button/editor.min.css\";i:32;s:20:\"button/style-rtl.css\";i:33;s:24:\"button/style-rtl.min.css\";i:34;s:16:\"button/style.css\";i:35;s:20:\"button/style.min.css\";i:36;s:22:\"buttons/editor-rtl.css\";i:37;s:26:\"buttons/editor-rtl.min.css\";i:38;s:18:\"buttons/editor.css\";i:39;s:22:\"buttons/editor.min.css\";i:40;s:21:\"buttons/style-rtl.css\";i:41;s:25:\"buttons/style-rtl.min.css\";i:42;s:17:\"buttons/style.css\";i:43;s:21:\"buttons/style.min.css\";i:44;s:22:\"calendar/style-rtl.css\";i:45;s:26:\"calendar/style-rtl.min.css\";i:46;s:18:\"calendar/style.css\";i:47;s:22:\"calendar/style.min.css\";i:48;s:25:\"categories/editor-rtl.css\";i:49;s:29:\"categories/editor-rtl.min.css\";i:50;s:21:\"categories/editor.css\";i:51;s:25:\"categories/editor.min.css\";i:52;s:24:\"categories/style-rtl.css\";i:53;s:28:\"categories/style-rtl.min.css\";i:54;s:20:\"categories/style.css\";i:55;s:24:\"categories/style.min.css\";i:56;s:19:\"code/editor-rtl.css\";i:57;s:23:\"code/editor-rtl.min.css\";i:58;s:15:\"code/editor.css\";i:59;s:19:\"code/editor.min.css\";i:60;s:18:\"code/style-rtl.css\";i:61;s:22:\"code/style-rtl.min.css\";i:62;s:14:\"code/style.css\";i:63;s:18:\"code/style.min.css\";i:64;s:18:\"code/theme-rtl.css\";i:65;s:22:\"code/theme-rtl.min.css\";i:66;s:14:\"code/theme.css\";i:67;s:18:\"code/theme.min.css\";i:68;s:22:\"columns/editor-rtl.css\";i:69;s:26:\"columns/editor-rtl.min.css\";i:70;s:18:\"columns/editor.css\";i:71;s:22:\"columns/editor.min.css\";i:72;s:21:\"columns/style-rtl.css\";i:73;s:25:\"columns/style-rtl.min.css\";i:74;s:17:\"columns/style.css\";i:75;s:21:\"columns/style.min.css\";i:76;s:33:\"comment-author-name/style-rtl.css\";i:77;s:37:\"comment-author-name/style-rtl.min.css\";i:78;s:29:\"comment-author-name/style.css\";i:79;s:33:\"comment-author-name/style.min.css\";i:80;s:29:\"comment-content/style-rtl.css\";i:81;s:33:\"comment-content/style-rtl.min.css\";i:82;s:25:\"comment-content/style.css\";i:83;s:29:\"comment-content/style.min.css\";i:84;s:26:\"comment-date/style-rtl.css\";i:85;s:30:\"comment-date/style-rtl.min.css\";i:86;s:22:\"comment-date/style.css\";i:87;s:26:\"comment-date/style.min.css\";i:88;s:31:\"comment-edit-link/style-rtl.css\";i:89;s:35:\"comment-edit-link/style-rtl.min.css\";i:90;s:27:\"comment-edit-link/style.css\";i:91;s:31:\"comment-edit-link/style.min.css\";i:92;s:32:\"comment-reply-link/style-rtl.css\";i:93;s:36:\"comment-reply-link/style-rtl.min.css\";i:94;s:28:\"comment-reply-link/style.css\";i:95;s:32:\"comment-reply-link/style.min.css\";i:96;s:30:\"comment-template/style-rtl.css\";i:97;s:34:\"comment-template/style-rtl.min.css\";i:98;s:26:\"comment-template/style.css\";i:99;s:30:\"comment-template/style.min.css\";i:100;s:42:\"comments-pagination-numbers/editor-rtl.css\";i:101;s:46:\"comments-pagination-numbers/editor-rtl.min.css\";i:102;s:38:\"comments-pagination-numbers/editor.css\";i:103;s:42:\"comments-pagination-numbers/editor.min.css\";i:104;s:34:\"comments-pagination/editor-rtl.css\";i:105;s:38:\"comments-pagination/editor-rtl.min.css\";i:106;s:30:\"comments-pagination/editor.css\";i:107;s:34:\"comments-pagination/editor.min.css\";i:108;s:33:\"comments-pagination/style-rtl.css\";i:109;s:37:\"comments-pagination/style-rtl.min.css\";i:110;s:29:\"comments-pagination/style.css\";i:111;s:33:\"comments-pagination/style.min.css\";i:112;s:29:\"comments-title/editor-rtl.css\";i:113;s:33:\"comments-title/editor-rtl.min.css\";i:114;s:25:\"comments-title/editor.css\";i:115;s:29:\"comments-title/editor.min.css\";i:116;s:23:\"comments/editor-rtl.css\";i:117;s:27:\"comments/editor-rtl.min.css\";i:118;s:19:\"comments/editor.css\";i:119;s:23:\"comments/editor.min.css\";i:120;s:22:\"comments/style-rtl.css\";i:121;s:26:\"comments/style-rtl.min.css\";i:122;s:18:\"comments/style.css\";i:123;s:22:\"comments/style.min.css\";i:124;s:20:\"cover/editor-rtl.css\";i:125;s:24:\"cover/editor-rtl.min.css\";i:126;s:16:\"cover/editor.css\";i:127;s:20:\"cover/editor.min.css\";i:128;s:19:\"cover/style-rtl.css\";i:129;s:23:\"cover/style-rtl.min.css\";i:130;s:15:\"cover/style.css\";i:131;s:19:\"cover/style.min.css\";i:132;s:22:\"details/editor-rtl.css\";i:133;s:26:\"details/editor-rtl.min.css\";i:134;s:18:\"details/editor.css\";i:135;s:22:\"details/editor.min.css\";i:136;s:21:\"details/style-rtl.css\";i:137;s:25:\"details/style-rtl.min.css\";i:138;s:17:\"details/style.css\";i:139;s:21:\"details/style.min.css\";i:140;s:20:\"embed/editor-rtl.css\";i:141;s:24:\"embed/editor-rtl.min.css\";i:142;s:16:\"embed/editor.css\";i:143;s:20:\"embed/editor.min.css\";i:144;s:19:\"embed/style-rtl.css\";i:145;s:23:\"embed/style-rtl.min.css\";i:146;s:15:\"embed/style.css\";i:147;s:19:\"embed/style.min.css\";i:148;s:19:\"embed/theme-rtl.css\";i:149;s:23:\"embed/theme-rtl.min.css\";i:150;s:15:\"embed/theme.css\";i:151;s:19:\"embed/theme.min.css\";i:152;s:19:\"file/editor-rtl.css\";i:153;s:23:\"file/editor-rtl.min.css\";i:154;s:15:\"file/editor.css\";i:155;s:19:\"file/editor.min.css\";i:156;s:18:\"file/style-rtl.css\";i:157;s:22:\"file/style-rtl.min.css\";i:158;s:14:\"file/style.css\";i:159;s:18:\"file/style.min.css\";i:160;s:23:\"footnotes/style-rtl.css\";i:161;s:27:\"footnotes/style-rtl.min.css\";i:162;s:19:\"footnotes/style.css\";i:163;s:23:\"footnotes/style.min.css\";i:164;s:23:\"freeform/editor-rtl.css\";i:165;s:27:\"freeform/editor-rtl.min.css\";i:166;s:19:\"freeform/editor.css\";i:167;s:23:\"freeform/editor.min.css\";i:168;s:22:\"gallery/editor-rtl.css\";i:169;s:26:\"gallery/editor-rtl.min.css\";i:170;s:18:\"gallery/editor.css\";i:171;s:22:\"gallery/editor.min.css\";i:172;s:21:\"gallery/style-rtl.css\";i:173;s:25:\"gallery/style-rtl.min.css\";i:174;s:17:\"gallery/style.css\";i:175;s:21:\"gallery/style.min.css\";i:176;s:21:\"gallery/theme-rtl.css\";i:177;s:25:\"gallery/theme-rtl.min.css\";i:178;s:17:\"gallery/theme.css\";i:179;s:21:\"gallery/theme.min.css\";i:180;s:20:\"group/editor-rtl.css\";i:181;s:24:\"group/editor-rtl.min.css\";i:182;s:16:\"group/editor.css\";i:183;s:20:\"group/editor.min.css\";i:184;s:19:\"group/style-rtl.css\";i:185;s:23:\"group/style-rtl.min.css\";i:186;s:15:\"group/style.css\";i:187;s:19:\"group/style.min.css\";i:188;s:19:\"group/theme-rtl.css\";i:189;s:23:\"group/theme-rtl.min.css\";i:190;s:15:\"group/theme.css\";i:191;s:19:\"group/theme.min.css\";i:192;s:21:\"heading/style-rtl.css\";i:193;s:25:\"heading/style-rtl.min.css\";i:194;s:17:\"heading/style.css\";i:195;s:21:\"heading/style.min.css\";i:196;s:19:\"html/editor-rtl.css\";i:197;s:23:\"html/editor-rtl.min.css\";i:198;s:15:\"html/editor.css\";i:199;s:19:\"html/editor.min.css\";i:200;s:20:\"image/editor-rtl.css\";i:201;s:24:\"image/editor-rtl.min.css\";i:202;s:16:\"image/editor.css\";i:203;s:20:\"image/editor.min.css\";i:204;s:19:\"image/style-rtl.css\";i:205;s:23:\"image/style-rtl.min.css\";i:206;s:15:\"image/style.css\";i:207;s:19:\"image/style.min.css\";i:208;s:19:\"image/theme-rtl.css\";i:209;s:23:\"image/theme-rtl.min.css\";i:210;s:15:\"image/theme.css\";i:211;s:19:\"image/theme.min.css\";i:212;s:29:\"latest-comments/style-rtl.css\";i:213;s:33:\"latest-comments/style-rtl.min.css\";i:214;s:25:\"latest-comments/style.css\";i:215;s:29:\"latest-comments/style.min.css\";i:216;s:27:\"latest-posts/editor-rtl.css\";i:217;s:31:\"latest-posts/editor-rtl.min.css\";i:218;s:23:\"latest-posts/editor.css\";i:219;s:27:\"latest-posts/editor.min.css\";i:220;s:26:\"latest-posts/style-rtl.css\";i:221;s:30:\"latest-posts/style-rtl.min.css\";i:222;s:22:\"latest-posts/style.css\";i:223;s:26:\"latest-posts/style.min.css\";i:224;s:18:\"list/style-rtl.css\";i:225;s:22:\"list/style-rtl.min.css\";i:226;s:14:\"list/style.css\";i:227;s:18:\"list/style.min.css\";i:228;s:22:\"loginout/style-rtl.css\";i:229;s:26:\"loginout/style-rtl.min.css\";i:230;s:18:\"loginout/style.css\";i:231;s:22:\"loginout/style.min.css\";i:232;s:25:\"media-text/editor-rtl.css\";i:233;s:29:\"media-text/editor-rtl.min.css\";i:234;s:21:\"media-text/editor.css\";i:235;s:25:\"media-text/editor.min.css\";i:236;s:24:\"media-text/style-rtl.css\";i:237;s:28:\"media-text/style-rtl.min.css\";i:238;s:20:\"media-text/style.css\";i:239;s:24:\"media-text/style.min.css\";i:240;s:19:\"more/editor-rtl.css\";i:241;s:23:\"more/editor-rtl.min.css\";i:242;s:15:\"more/editor.css\";i:243;s:19:\"more/editor.min.css\";i:244;s:30:\"navigation-link/editor-rtl.css\";i:245;s:34:\"navigation-link/editor-rtl.min.css\";i:246;s:26:\"navigation-link/editor.css\";i:247;s:30:\"navigation-link/editor.min.css\";i:248;s:29:\"navigation-link/style-rtl.css\";i:249;s:33:\"navigation-link/style-rtl.min.css\";i:250;s:25:\"navigation-link/style.css\";i:251;s:29:\"navigation-link/style.min.css\";i:252;s:33:\"navigation-submenu/editor-rtl.css\";i:253;s:37:\"navigation-submenu/editor-rtl.min.css\";i:254;s:29:\"navigation-submenu/editor.css\";i:255;s:33:\"navigation-submenu/editor.min.css\";i:256;s:25:\"navigation/editor-rtl.css\";i:257;s:29:\"navigation/editor-rtl.min.css\";i:258;s:21:\"navigation/editor.css\";i:259;s:25:\"navigation/editor.min.css\";i:260;s:24:\"navigation/style-rtl.css\";i:261;s:28:\"navigation/style-rtl.min.css\";i:262;s:20:\"navigation/style.css\";i:263;s:24:\"navigation/style.min.css\";i:264;s:23:\"nextpage/editor-rtl.css\";i:265;s:27:\"nextpage/editor-rtl.min.css\";i:266;s:19:\"nextpage/editor.css\";i:267;s:23:\"nextpage/editor.min.css\";i:268;s:24:\"page-list/editor-rtl.css\";i:269;s:28:\"page-list/editor-rtl.min.css\";i:270;s:20:\"page-list/editor.css\";i:271;s:24:\"page-list/editor.min.css\";i:272;s:23:\"page-list/style-rtl.css\";i:273;s:27:\"page-list/style-rtl.min.css\";i:274;s:19:\"page-list/style.css\";i:275;s:23:\"page-list/style.min.css\";i:276;s:24:\"paragraph/editor-rtl.css\";i:277;s:28:\"paragraph/editor-rtl.min.css\";i:278;s:20:\"paragraph/editor.css\";i:279;s:24:\"paragraph/editor.min.css\";i:280;s:23:\"paragraph/style-rtl.css\";i:281;s:27:\"paragraph/style-rtl.min.css\";i:282;s:19:\"paragraph/style.css\";i:283;s:23:\"paragraph/style.min.css\";i:284;s:35:\"post-author-biography/style-rtl.css\";i:285;s:39:\"post-author-biography/style-rtl.min.css\";i:286;s:31:\"post-author-biography/style.css\";i:287;s:35:\"post-author-biography/style.min.css\";i:288;s:30:\"post-author-name/style-rtl.css\";i:289;s:34:\"post-author-name/style-rtl.min.css\";i:290;s:26:\"post-author-name/style.css\";i:291;s:30:\"post-author-name/style.min.css\";i:292;s:26:\"post-author/editor-rtl.css\";i:293;s:30:\"post-author/editor-rtl.min.css\";i:294;s:22:\"post-author/editor.css\";i:295;s:26:\"post-author/editor.min.css\";i:296;s:25:\"post-author/style-rtl.css\";i:297;s:29:\"post-author/style-rtl.min.css\";i:298;s:21:\"post-author/style.css\";i:299;s:25:\"post-author/style.min.css\";i:300;s:33:\"post-comments-form/editor-rtl.css\";i:301;s:37:\"post-comments-form/editor-rtl.min.css\";i:302;s:29:\"post-comments-form/editor.css\";i:303;s:33:\"post-comments-form/editor.min.css\";i:304;s:32:\"post-comments-form/style-rtl.css\";i:305;s:36:\"post-comments-form/style-rtl.min.css\";i:306;s:28:\"post-comments-form/style.css\";i:307;s:32:\"post-comments-form/style.min.css\";i:308;s:27:\"post-content/editor-rtl.css\";i:309;s:31:\"post-content/editor-rtl.min.css\";i:310;s:23:\"post-content/editor.css\";i:311;s:27:\"post-content/editor.min.css\";i:312;s:26:\"post-content/style-rtl.css\";i:313;s:30:\"post-content/style-rtl.min.css\";i:314;s:22:\"post-content/style.css\";i:315;s:26:\"post-content/style.min.css\";i:316;s:23:\"post-date/style-rtl.css\";i:317;s:27:\"post-date/style-rtl.min.css\";i:318;s:19:\"post-date/style.css\";i:319;s:23:\"post-date/style.min.css\";i:320;s:27:\"post-excerpt/editor-rtl.css\";i:321;s:31:\"post-excerpt/editor-rtl.min.css\";i:322;s:23:\"post-excerpt/editor.css\";i:323;s:27:\"post-excerpt/editor.min.css\";i:324;s:26:\"post-excerpt/style-rtl.css\";i:325;s:30:\"post-excerpt/style-rtl.min.css\";i:326;s:22:\"post-excerpt/style.css\";i:327;s:26:\"post-excerpt/style.min.css\";i:328;s:34:\"post-featured-image/editor-rtl.css\";i:329;s:38:\"post-featured-image/editor-rtl.min.css\";i:330;s:30:\"post-featured-image/editor.css\";i:331;s:34:\"post-featured-image/editor.min.css\";i:332;s:33:\"post-featured-image/style-rtl.css\";i:333;s:37:\"post-featured-image/style-rtl.min.css\";i:334;s:29:\"post-featured-image/style.css\";i:335;s:33:\"post-featured-image/style.min.css\";i:336;s:34:\"post-navigation-link/style-rtl.css\";i:337;s:38:\"post-navigation-link/style-rtl.min.css\";i:338;s:30:\"post-navigation-link/style.css\";i:339;s:34:\"post-navigation-link/style.min.css\";i:340;s:28:\"post-template/editor-rtl.css\";i:341;s:32:\"post-template/editor-rtl.min.css\";i:342;s:24:\"post-template/editor.css\";i:343;s:28:\"post-template/editor.min.css\";i:344;s:27:\"post-template/style-rtl.css\";i:345;s:31:\"post-template/style-rtl.min.css\";i:346;s:23:\"post-template/style.css\";i:347;s:27:\"post-template/style.min.css\";i:348;s:24:\"post-terms/style-rtl.css\";i:349;s:28:\"post-terms/style-rtl.min.css\";i:350;s:20:\"post-terms/style.css\";i:351;s:24:\"post-terms/style.min.css\";i:352;s:24:\"post-title/style-rtl.css\";i:353;s:28:\"post-title/style-rtl.min.css\";i:354;s:20:\"post-title/style.css\";i:355;s:24:\"post-title/style.min.css\";i:356;s:26:\"preformatted/style-rtl.css\";i:357;s:30:\"preformatted/style-rtl.min.css\";i:358;s:22:\"preformatted/style.css\";i:359;s:26:\"preformatted/style.min.css\";i:360;s:24:\"pullquote/editor-rtl.css\";i:361;s:28:\"pullquote/editor-rtl.min.css\";i:362;s:20:\"pullquote/editor.css\";i:363;s:24:\"pullquote/editor.min.css\";i:364;s:23:\"pullquote/style-rtl.css\";i:365;s:27:\"pullquote/style-rtl.min.css\";i:366;s:19:\"pullquote/style.css\";i:367;s:23:\"pullquote/style.min.css\";i:368;s:23:\"pullquote/theme-rtl.css\";i:369;s:27:\"pullquote/theme-rtl.min.css\";i:370;s:19:\"pullquote/theme.css\";i:371;s:23:\"pullquote/theme.min.css\";i:372;s:39:\"query-pagination-numbers/editor-rtl.css\";i:373;s:43:\"query-pagination-numbers/editor-rtl.min.css\";i:374;s:35:\"query-pagination-numbers/editor.css\";i:375;s:39:\"query-pagination-numbers/editor.min.css\";i:376;s:31:\"query-pagination/editor-rtl.css\";i:377;s:35:\"query-pagination/editor-rtl.min.css\";i:378;s:27:\"query-pagination/editor.css\";i:379;s:31:\"query-pagination/editor.min.css\";i:380;s:30:\"query-pagination/style-rtl.css\";i:381;s:34:\"query-pagination/style-rtl.min.css\";i:382;s:26:\"query-pagination/style.css\";i:383;s:30:\"query-pagination/style.min.css\";i:384;s:25:\"query-title/style-rtl.css\";i:385;s:29:\"query-title/style-rtl.min.css\";i:386;s:21:\"query-title/style.css\";i:387;s:25:\"query-title/style.min.css\";i:388;s:20:\"query/editor-rtl.css\";i:389;s:24:\"query/editor-rtl.min.css\";i:390;s:16:\"query/editor.css\";i:391;s:20:\"query/editor.min.css\";i:392;s:19:\"quote/style-rtl.css\";i:393;s:23:\"quote/style-rtl.min.css\";i:394;s:15:\"quote/style.css\";i:395;s:19:\"quote/style.min.css\";i:396;s:19:\"quote/theme-rtl.css\";i:397;s:23:\"quote/theme-rtl.min.css\";i:398;s:15:\"quote/theme.css\";i:399;s:19:\"quote/theme.min.css\";i:400;s:23:\"read-more/style-rtl.css\";i:401;s:27:\"read-more/style-rtl.min.css\";i:402;s:19:\"read-more/style.css\";i:403;s:23:\"read-more/style.min.css\";i:404;s:18:\"rss/editor-rtl.css\";i:405;s:22:\"rss/editor-rtl.min.css\";i:406;s:14:\"rss/editor.css\";i:407;s:18:\"rss/editor.min.css\";i:408;s:17:\"rss/style-rtl.css\";i:409;s:21:\"rss/style-rtl.min.css\";i:410;s:13:\"rss/style.css\";i:411;s:17:\"rss/style.min.css\";i:412;s:21:\"search/editor-rtl.css\";i:413;s:25:\"search/editor-rtl.min.css\";i:414;s:17:\"search/editor.css\";i:415;s:21:\"search/editor.min.css\";i:416;s:20:\"search/style-rtl.css\";i:417;s:24:\"search/style-rtl.min.css\";i:418;s:16:\"search/style.css\";i:419;s:20:\"search/style.min.css\";i:420;s:20:\"search/theme-rtl.css\";i:421;s:24:\"search/theme-rtl.min.css\";i:422;s:16:\"search/theme.css\";i:423;s:20:\"search/theme.min.css\";i:424;s:24:\"separator/editor-rtl.css\";i:425;s:28:\"separator/editor-rtl.min.css\";i:426;s:20:\"separator/editor.css\";i:427;s:24:\"separator/editor.min.css\";i:428;s:23:\"separator/style-rtl.css\";i:429;s:27:\"separator/style-rtl.min.css\";i:430;s:19:\"separator/style.css\";i:431;s:23:\"separator/style.min.css\";i:432;s:23:\"separator/theme-rtl.css\";i:433;s:27:\"separator/theme-rtl.min.css\";i:434;s:19:\"separator/theme.css\";i:435;s:23:\"separator/theme.min.css\";i:436;s:24:\"shortcode/editor-rtl.css\";i:437;s:28:\"shortcode/editor-rtl.min.css\";i:438;s:20:\"shortcode/editor.css\";i:439;s:24:\"shortcode/editor.min.css\";i:440;s:24:\"site-logo/editor-rtl.css\";i:441;s:28:\"site-logo/editor-rtl.min.css\";i:442;s:20:\"site-logo/editor.css\";i:443;s:24:\"site-logo/editor.min.css\";i:444;s:23:\"site-logo/style-rtl.css\";i:445;s:27:\"site-logo/style-rtl.min.css\";i:446;s:19:\"site-logo/style.css\";i:447;s:23:\"site-logo/style.min.css\";i:448;s:27:\"site-tagline/editor-rtl.css\";i:449;s:31:\"site-tagline/editor-rtl.min.css\";i:450;s:23:\"site-tagline/editor.css\";i:451;s:27:\"site-tagline/editor.min.css\";i:452;s:26:\"site-tagline/style-rtl.css\";i:453;s:30:\"site-tagline/style-rtl.min.css\";i:454;s:22:\"site-tagline/style.css\";i:455;s:26:\"site-tagline/style.min.css\";i:456;s:25:\"site-title/editor-rtl.css\";i:457;s:29:\"site-title/editor-rtl.min.css\";i:458;s:21:\"site-title/editor.css\";i:459;s:25:\"site-title/editor.min.css\";i:460;s:24:\"site-title/style-rtl.css\";i:461;s:28:\"site-title/style-rtl.min.css\";i:462;s:20:\"site-title/style.css\";i:463;s:24:\"site-title/style.min.css\";i:464;s:26:\"social-link/editor-rtl.css\";i:465;s:30:\"social-link/editor-rtl.min.css\";i:466;s:22:\"social-link/editor.css\";i:467;s:26:\"social-link/editor.min.css\";i:468;s:27:\"social-links/editor-rtl.css\";i:469;s:31:\"social-links/editor-rtl.min.css\";i:470;s:23:\"social-links/editor.css\";i:471;s:27:\"social-links/editor.min.css\";i:472;s:26:\"social-links/style-rtl.css\";i:473;s:30:\"social-links/style-rtl.min.css\";i:474;s:22:\"social-links/style.css\";i:475;s:26:\"social-links/style.min.css\";i:476;s:21:\"spacer/editor-rtl.css\";i:477;s:25:\"spacer/editor-rtl.min.css\";i:478;s:17:\"spacer/editor.css\";i:479;s:21:\"spacer/editor.min.css\";i:480;s:20:\"spacer/style-rtl.css\";i:481;s:24:\"spacer/style-rtl.min.css\";i:482;s:16:\"spacer/style.css\";i:483;s:20:\"spacer/style.min.css\";i:484;s:20:\"table/editor-rtl.css\";i:485;s:24:\"table/editor-rtl.min.css\";i:486;s:16:\"table/editor.css\";i:487;s:20:\"table/editor.min.css\";i:488;s:19:\"table/style-rtl.css\";i:489;s:23:\"table/style-rtl.min.css\";i:490;s:15:\"table/style.css\";i:491;s:19:\"table/style.min.css\";i:492;s:19:\"table/theme-rtl.css\";i:493;s:23:\"table/theme-rtl.min.css\";i:494;s:15:\"table/theme.css\";i:495;s:19:\"table/theme.min.css\";i:496;s:24:\"tag-cloud/editor-rtl.css\";i:497;s:28:\"tag-cloud/editor-rtl.min.css\";i:498;s:20:\"tag-cloud/editor.css\";i:499;s:24:\"tag-cloud/editor.min.css\";i:500;s:23:\"tag-cloud/style-rtl.css\";i:501;s:27:\"tag-cloud/style-rtl.min.css\";i:502;s:19:\"tag-cloud/style.css\";i:503;s:23:\"tag-cloud/style.min.css\";i:504;s:28:\"template-part/editor-rtl.css\";i:505;s:32:\"template-part/editor-rtl.min.css\";i:506;s:24:\"template-part/editor.css\";i:507;s:28:\"template-part/editor.min.css\";i:508;s:27:\"template-part/theme-rtl.css\";i:509;s:31:\"template-part/theme-rtl.min.css\";i:510;s:23:\"template-part/theme.css\";i:511;s:27:\"template-part/theme.min.css\";i:512;s:30:\"term-description/style-rtl.css\";i:513;s:34:\"term-description/style-rtl.min.css\";i:514;s:26:\"term-description/style.css\";i:515;s:30:\"term-description/style.min.css\";i:516;s:27:\"text-columns/editor-rtl.css\";i:517;s:31:\"text-columns/editor-rtl.min.css\";i:518;s:23:\"text-columns/editor.css\";i:519;s:27:\"text-columns/editor.min.css\";i:520;s:26:\"text-columns/style-rtl.css\";i:521;s:30:\"text-columns/style-rtl.min.css\";i:522;s:22:\"text-columns/style.css\";i:523;s:26:\"text-columns/style.min.css\";i:524;s:19:\"verse/style-rtl.css\";i:525;s:23:\"verse/style-rtl.min.css\";i:526;s:15:\"verse/style.css\";i:527;s:19:\"verse/style.min.css\";i:528;s:20:\"video/editor-rtl.css\";i:529;s:24:\"video/editor-rtl.min.css\";i:530;s:16:\"video/editor.css\";i:531;s:20:\"video/editor.min.css\";i:532;s:19:\"video/style-rtl.css\";i:533;s:23:\"video/style-rtl.min.css\";i:534;s:15:\"video/style.css\";i:535;s:19:\"video/style.min.css\";i:536;s:19:\"video/theme-rtl.css\";i:537;s:23:\"video/theme-rtl.min.css\";i:538;s:15:\"video/theme.css\";i:539;s:19:\"video/theme.min.css\";}}', 'on'),
(126, 'recovery_keys', 'a:0:{}', 'off'),
(127, 'theme_mods_twentytwentyfour', 'a:2:{s:18:\"custom_css_post_id\";i:-1;s:16:\"sidebars_widgets\";a:2:{s:4:\"time\";i:1732632001;s:4:\"data\";a:3:{s:19:\"wp_inactive_widgets\";a:0:{}s:9:\"sidebar-1\";a:3:{i:0;s:7:\"block-2\";i:1;s:7:\"block-3\";i:2;s:7:\"block-4\";}s:9:\"sidebar-2\";a:2:{i:0;s:7:\"block-5\";i:1;s:7:\"block-6\";}}}}', 'off'),
(155, 'finished_updating_comment_type', '1', 'auto'),
(189, 'https_detection_errors', 'a:1:{s:20:\"https_request_failed\";a:1:{i:0;s:37:\"Yêu cầu HTTPS không thành công.\";}}', 'off'),
(190, '_transient_health-check-site-status-result', '{\"good\":18,\"recommended\":4,\"critical\":1}', 'on'),
(212, 'db_upgraded', '', 'on'),
(219, 'auto_core_update_notified', 'a:4:{s:4:\"type\";s:7:\"success\";s:5:\"email\";s:31:\"hoangtiendat.20042011@gmail.com\";s:7:\"version\";s:5:\"6.7.2\";s:9:\"timestamp\";i:1739633070;}', 'off'),
(235, '_transient_wp_styles_for_blocks', 'a:2:{s:4:\"hash\";s:32:\"64fd7d9c17893a4740636affbd4c1553\";s:6:\"blocks\";a:5:{s:11:\"core/button\";s:0:\"\";s:14:\"core/site-logo\";s:0:\"\";s:18:\"core/post-template\";s:0:\"\";s:12:\"core/columns\";s:0:\"\";s:14:\"core/pullquote\";s:69:\":root :where(.wp-block-pullquote){font-size: 1.5em;line-height: 1.6;}\";}}', 'on'),
(238, 'can_compress_scripts', '1', 'on'),
(270, 'current_theme', 'MoreNews', 'auto');
INSERT INTO `wp_options` (`option_id`, `option_name`, `option_value`, `autoload`) VALUES
(271, 'theme_mods_blocksy', 'a:13:{i:0;b:0;s:38:\"blocksy_woocommerce_thumbnail_cropping\";s:10:\"predefined\";s:23:\"woocommerce_filter_type\";s:6:\"type-1\";s:32:\"single_blog_post_share_box_title\";s:0:\"\";s:27:\"single_page_share_box_title\";s:0:\"\";s:22:\"product_compare_layout\";a:7:{i:0;a:2:{s:2:\"id\";s:12:\"product_main\";s:7:\"enabled\";b:1;}i:1;a:2:{s:2:\"id\";s:13:\"product_title\";s:7:\"enabled\";b:1;}i:2;a:2:{s:2:\"id\";s:13:\"product_price\";s:7:\"enabled\";b:1;}i:3;a:2:{s:2:\"id\";s:19:\"product_add_to_cart\";s:7:\"enabled\";b:1;}i:4;a:2:{s:2:\"id\";s:19:\"product_description\";s:7:\"enabled\";b:1;}i:5;a:3:{s:2:\"id\";s:18:\"product_attributes\";s:7:\"enabled\";b:1;s:25:\"product_attributes_source\";s:3:\"all\";}i:6;a:2:{s:2:\"id\";s:20:\"product_availability\";s:7:\"enabled\";b:1;}}s:30:\"single_blog_post_related_order\";a:3:{i:0;a:5:{s:2:\"id\";s:14:\"featured_image\";s:11:\"thumb_ratio\";s:4:\"16/9\";s:10:\"image_size\";s:12:\"medium_large\";s:7:\"enabled\";b:1;s:8:\"has_link\";s:3:\"yes\";}i:1;a:4:{s:2:\"id\";s:5:\"title\";s:11:\"heading_tag\";s:2:\"h4\";s:7:\"enabled\";b:1;s:8:\"has_link\";s:3:\"yes\";}i:2;a:5:{s:2:\"id\";s:9:\"post_meta\";s:7:\"enabled\";b:1;s:13:\"meta_elements\";a:5:{i:0;a:5:{s:2:\"id\";s:6:\"author\";s:7:\"enabled\";b:0;s:5:\"label\";s:5:\"Bởi\";s:17:\"has_author_avatar\";s:2:\"no\";s:11:\"avatar_size\";i:25;}i:1;a:5:{s:2:\"id\";s:9:\"post_date\";s:7:\"enabled\";b:1;s:5:\"label\";s:6:\"Bật \";s:18:\"date_format_source\";s:7:\"default\";s:11:\"date_format\";s:6:\"M j, Y\";}i:2;a:5:{s:2:\"id\";s:12:\"updated_date\";s:7:\"enabled\";b:0;s:5:\"label\";s:6:\"Bật \";s:18:\"date_format_source\";s:7:\"default\";s:11:\"date_format\";s:6:\"M j, Y\";}i:3;a:4:{s:2:\"id\";s:10:\"categories\";s:7:\"enabled\";b:0;s:5:\"label\";s:5:\"Trong\";s:5:\"style\";s:6:\"simple\";}i:4;a:2:{s:2:\"id\";s:8:\"comments\";s:7:\"enabled\";b:1;}}s:9:\"meta_type\";s:6:\"simple\";s:12:\"meta_divider\";s:5:\"slash\";}}s:25:\"single_page_related_order\";a:3:{i:0;a:5:{s:2:\"id\";s:14:\"featured_image\";s:11:\"thumb_ratio\";s:4:\"16/9\";s:10:\"image_size\";s:12:\"medium_large\";s:7:\"enabled\";b:1;s:8:\"has_link\";s:3:\"yes\";}i:1;a:4:{s:2:\"id\";s:5:\"title\";s:11:\"heading_tag\";s:2:\"h4\";s:7:\"enabled\";b:1;s:8:\"has_link\";s:3:\"yes\";}i:2;a:5:{s:2:\"id\";s:9:\"post_meta\";s:7:\"enabled\";b:1;s:13:\"meta_elements\";a:5:{i:0;a:5:{s:2:\"id\";s:6:\"author\";s:7:\"enabled\";b:0;s:5:\"label\";s:5:\"Bởi\";s:17:\"has_author_avatar\";s:2:\"no\";s:11:\"avatar_size\";i:25;}i:1;a:5:{s:2:\"id\";s:9:\"post_date\";s:7:\"enabled\";b:1;s:5:\"label\";s:6:\"Bật \";s:18:\"date_format_source\";s:7:\"default\";s:11:\"date_format\";s:6:\"M j, Y\";}i:2;a:5:{s:2:\"id\";s:12:\"updated_date\";s:7:\"enabled\";b:0;s:5:\"label\";s:6:\"Bật \";s:18:\"date_format_source\";s:7:\"default\";s:11:\"date_format\";s:6:\"M j, Y\";}i:3;a:4:{s:2:\"id\";s:10:\"categories\";s:7:\"enabled\";b:0;s:5:\"label\";s:5:\"Trong\";s:5:\"style\";s:6:\"simple\";}i:4;a:2:{s:2:\"id\";s:8:\"comments\";s:7:\"enabled\";b:1;}}s:9:\"meta_type\";s:6:\"simple\";s:12:\"meta_divider\";s:5:\"slash\";}}s:18:\"nav_menu_locations\";a:0:{}s:18:\"custom_css_post_id\";i:-1;s:17:\"header_placements\";a:2:{s:15:\"current_section\";s:6:\"type-1\";s:8:\"sections\";a:1:{i:0;a:6:{s:2:\"id\";s:6:\"type-1\";s:4:\"mode\";s:10:\"placements\";s:5:\"items\";a:2:{i:0;a:2:{s:2:\"id\";s:4:\"menu\";s:6:\"values\";a:1:{s:16:\"header_menu_type\";s:6:\"type-2\";}}i:1;a:2:{s:2:\"id\";s:14:\"menu-secondary\";s:6:\"values\";a:1:{s:16:\"header_menu_type\";s:6:\"type-3\";}}}s:8:\"settings\";a:0:{}s:7:\"desktop\";a:4:{i:0;a:2:{s:2:\"id\";s:7:\"top-row\";s:10:\"placements\";a:5:{i:0;a:2:{s:2:\"id\";s:5:\"start\";s:5:\"items\";a:0:{}}i:1;a:2:{s:2:\"id\";s:6:\"middle\";s:5:\"items\";a:0:{}}i:2;a:2:{s:2:\"id\";s:3:\"end\";s:5:\"items\";a:0:{}}i:3;a:2:{s:2:\"id\";s:12:\"start-middle\";s:5:\"items\";a:0:{}}i:4;a:2:{s:2:\"id\";s:10:\"end-middle\";s:5:\"items\";a:0:{}}}}i:1;a:2:{s:2:\"id\";s:10:\"middle-row\";s:10:\"placements\";a:5:{i:0;a:2:{s:2:\"id\";s:5:\"start\";s:5:\"items\";a:1:{i:0;s:4:\"logo\";}}i:1;a:2:{s:2:\"id\";s:6:\"middle\";s:5:\"items\";a:0:{}}i:2;a:2:{s:2:\"id\";s:3:\"end\";s:5:\"items\";a:3:{i:0;s:4:\"menu\";i:1;s:14:\"menu-secondary\";i:2;s:6:\"search\";}}i:3;a:2:{s:2:\"id\";s:12:\"start-middle\";s:5:\"items\";a:0:{}}i:4;a:2:{s:2:\"id\";s:10:\"end-middle\";s:5:\"items\";a:0:{}}}}i:2;a:2:{s:2:\"id\";s:10:\"bottom-row\";s:10:\"placements\";a:5:{i:0;a:2:{s:2:\"id\";s:5:\"start\";s:5:\"items\";a:0:{}}i:1;a:2:{s:2:\"id\";s:6:\"middle\";s:5:\"items\";a:0:{}}i:2;a:2:{s:2:\"id\";s:3:\"end\";s:5:\"items\";a:0:{}}i:3;a:2:{s:2:\"id\";s:12:\"start-middle\";s:5:\"items\";a:0:{}}i:4;a:2:{s:2:\"id\";s:10:\"end-middle\";s:5:\"items\";a:0:{}}}}i:3;a:2:{s:2:\"id\";s:9:\"offcanvas\";s:10:\"placements\";a:1:{i:0;a:2:{s:2:\"id\";s:5:\"start\";s:5:\"items\";a:0:{}}}}}s:6:\"mobile\";a:4:{i:0;a:2:{s:2:\"id\";s:7:\"top-row\";s:10:\"placements\";a:5:{i:0;a:2:{s:2:\"id\";s:5:\"start\";s:5:\"items\";a:0:{}}i:1;a:2:{s:2:\"id\";s:6:\"middle\";s:5:\"items\";a:0:{}}i:2;a:2:{s:2:\"id\";s:3:\"end\";s:5:\"items\";a:0:{}}i:3;a:2:{s:2:\"id\";s:12:\"start-middle\";s:5:\"items\";a:0:{}}i:4;a:2:{s:2:\"id\";s:10:\"end-middle\";s:5:\"items\";a:0:{}}}}i:1;a:2:{s:2:\"id\";s:10:\"middle-row\";s:10:\"placements\";a:5:{i:0;a:2:{s:2:\"id\";s:5:\"start\";s:5:\"items\";a:1:{i:0;s:4:\"logo\";}}i:1;a:2:{s:2:\"id\";s:6:\"middle\";s:5:\"items\";a:0:{}}i:2;a:2:{s:2:\"id\";s:3:\"end\";s:5:\"items\";a:1:{i:0;s:7:\"trigger\";}}i:3;a:2:{s:2:\"id\";s:12:\"start-middle\";s:5:\"items\";a:0:{}}i:4;a:2:{s:2:\"id\";s:10:\"end-middle\";s:5:\"items\";a:0:{}}}}i:2;a:2:{s:2:\"id\";s:10:\"bottom-row\";s:10:\"placements\";a:5:{i:0;a:2:{s:2:\"id\";s:5:\"start\";s:5:\"items\";a:0:{}}i:1;a:2:{s:2:\"id\";s:6:\"middle\";s:5:\"items\";a:0:{}}i:2;a:2:{s:2:\"id\";s:3:\"end\";s:5:\"items\";a:0:{}}i:3;a:2:{s:2:\"id\";s:12:\"start-middle\";s:5:\"items\";a:0:{}}i:4;a:2:{s:2:\"id\";s:10:\"end-middle\";s:5:\"items\";a:0:{}}}}i:3;a:2:{s:2:\"id\";s:9:\"offcanvas\";s:10:\"placements\";a:1:{i:0;a:2:{s:2:\"id\";s:5:\"start\";s:5:\"items\";a:1:{i:0;s:11:\"mobile-menu\";}}}}}}}}s:16:\"blog_has_sidebar\";s:2:\"no\";s:16:\"sidebars_widgets\";a:2:{s:4:\"time\";i:1734770998;s:4:\"data\";a:8:{s:19:\"wp_inactive_widgets\";a:0:{}s:9:\"sidebar-1\";a:5:{i:0;s:7:\"block-2\";i:1;s:7:\"block-3\";i:2;s:7:\"block-4\";i:3;s:7:\"block-5\";i:4;s:7:\"block-6\";}s:19:\"ct-footer-sidebar-1\";a:0:{}s:19:\"ct-footer-sidebar-2\";a:0:{}s:19:\"ct-footer-sidebar-3\";a:0:{}s:19:\"ct-footer-sidebar-4\";a:0:{}s:19:\"ct-footer-sidebar-5\";a:0:{}s:19:\"ct-footer-sidebar-6\";a:0:{}}}}', 'off'),
(272, 'theme_switched', '', 'auto'),
(275, 'blocksy_db_version', '2.0.82', 'auto'),
(276, '_transient_timeout_blocksy_dynamic_styles_descriptor', '1765874806', 'off'),
(277, '_transient_blocksy_dynamic_styles_descriptor', 'a:2:{s:12:\"google_fonts\";a:0:{}s:6:\"styles\";a:3:{s:7:\"desktop\";s:10122:\"[data-header*=\"type-1\"] .ct-header [data-id=\"logo\"] .site-title {--theme-font-weight:700;--theme-font-size:25px;--theme-line-height:1.5;--theme-link-initial-color:var(--theme-palette-color-4);} [data-header*=\"type-1\"] .ct-header [data-id=\"menu\"] > ul > li > a {--theme-font-weight:700;--theme-text-transform:uppercase;--theme-font-size:12px;--theme-line-height:1.3;--theme-link-initial-color:var(--theme-text-color);} [data-header*=\"type-1\"] .ct-header [data-id=\"menu\"] .sub-menu .ct-menu-link {--theme-link-initial-color:var(--theme-palette-color-8);--theme-font-weight:500;--theme-font-size:12px;} [data-header*=\"type-1\"] .ct-header [data-id=\"menu\"] .sub-menu {--dropdown-divider:1px dashed rgba(255, 255, 255, 0.1);--theme-box-shadow:0px 10px 20px rgba(41, 51, 61, 0.1);--theme-border-radius:0px 0px 2px 2px;} [data-header*=\"type-1\"] .ct-header [data-id=\"menu-secondary\"] > ul > li > a {--theme-font-weight:700;--theme-text-transform:uppercase;--theme-font-size:12px;--theme-line-height:1.3;--theme-link-initial-color:var(--theme-text-color);--theme-link-hover-color:#ffffff;} [data-header*=\"type-1\"] .ct-header [data-id=\"menu-secondary\"] .sub-menu .ct-menu-link {--theme-link-initial-color:var(--theme-palette-color-8);--theme-font-weight:500;--theme-font-size:12px;} [data-header*=\"type-1\"] .ct-header [data-id=\"menu-secondary\"] .sub-menu {--dropdown-divider:1px dashed rgba(255, 255, 255, 0.1);--theme-box-shadow:0px 10px 20px rgba(41, 51, 61, 0.1);--theme-border-radius:0px 0px 2px 2px;} [data-header*=\"type-1\"] .ct-header [data-row*=\"middle\"] {--height:120px;background-color:var(--theme-palette-color-8);background-image:none;--theme-border-top:none;--theme-border-bottom:none;--theme-box-shadow:none;} [data-header*=\"type-1\"] .ct-header [data-row*=\"middle\"] > div {--theme-border-top:none;--theme-border-bottom:none;} [data-header*=\"type-1\"] [data-id=\"mobile-menu\"] {--theme-font-weight:700;--theme-font-size:20px;--theme-link-initial-color:#ffffff;--mobile-menu-divider:none;} [data-header*=\"type-1\"] #offcanvas {--theme-box-shadow:0px 0px 70px rgba(0, 0, 0, 0.35);--side-panel-width:500px;} [data-header*=\"type-1\"] #offcanvas .ct-panel-inner {background-color:rgba(18, 21, 25, 0.98);} [data-header*=\"type-1\"] #search-modal .ct-search-results {--theme-font-weight:500;--theme-font-size:14px;--theme-line-height:1.4;} [data-header*=\"type-1\"] #search-modal .ct-search-form {--theme-link-initial-color:#ffffff;--theme-form-text-initial-color:#ffffff;--theme-form-text-focus-color:#ffffff;--theme-form-field-border-initial-color:rgba(255, 255, 255, 0.2);--theme-button-text-initial-color:rgba(255, 255, 255, 0.7);--theme-button-text-hover-color:#ffffff;--theme-button-background-initial-color:var(--theme-palette-color-1);--theme-button-background-hover-color:var(--theme-palette-color-1);} [data-header*=\"type-1\"] #search-modal {background-color:rgba(18, 21, 25, 0.98);} [data-header*=\"type-1\"] [data-id=\"trigger\"] {--theme-icon-size:18px;} [data-header*=\"type-1\"] {--header-height:120px;} [data-header*=\"type-1\"] .ct-header {background-image:none;} [data-footer*=\"type-1\"] .ct-footer [data-row*=\"bottom\"] > div {--container-spacing:25px;--theme-border:none;--theme-border-top:none;--theme-border-bottom:none;--grid-template-columns:initial;} [data-footer*=\"type-1\"] .ct-footer [data-row*=\"bottom\"] .widget-title {--theme-font-size:16px;} [data-footer*=\"type-1\"] .ct-footer [data-row*=\"bottom\"] {--theme-border-top:none;--theme-border-bottom:none;background-color:transparent;} [data-footer*=\"type-1\"] [data-id=\"copyright\"] {--theme-font-weight:400;--theme-font-size:15px;--theme-line-height:1.3;} [data-footer*=\"type-1\"] .ct-footer {background-color:var(--theme-palette-color-6);}:root {--theme-font-family:-apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Helvetica, Arial, sans-serif, \'Apple Color Emoji\', \'Segoe UI Emoji\', \'Segoe UI Symbol\';--theme-font-weight:400;--theme-text-transform:none;--theme-text-decoration:none;--theme-font-size:16px;--theme-line-height:1.65;--theme-letter-spacing:0em;--theme-button-font-weight:500;--theme-button-font-size:15px;--has-classic-forms:var(--true);--has-modern-forms:var(--false);--theme-form-field-border-initial-color:var(--theme-border-color);--theme-form-field-border-focus-color:var(--theme-palette-color-1);--theme-form-selection-field-initial-color:var(--theme-border-color);--theme-form-selection-field-active-color:var(--theme-palette-color-1);--theme-palette-color-1:#2872fa;--theme-palette-color-2:#1559ed;--theme-palette-color-3:#3A4F66;--theme-palette-color-4:#192a3d;--theme-palette-color-5:#e1e8ed;--theme-palette-color-6:#f2f5f7;--theme-palette-color-7:#FAFBFC;--theme-palette-color-8:#ffffff;--theme-text-color:var(--theme-palette-color-3);--theme-link-initial-color:var(--theme-palette-color-1);--theme-link-hover-color:var(--theme-palette-color-2);--theme-selection-text-color:#ffffff;--theme-selection-background-color:var(--theme-palette-color-1);--theme-border-color:var(--theme-palette-color-5);--theme-headings-color:var(--theme-palette-color-4);--theme-content-spacing:1.5em;--theme-button-min-height:40px;--theme-button-shadow:none;--theme-button-transform:none;--theme-button-text-initial-color:#ffffff;--theme-button-text-hover-color:#ffffff;--theme-button-background-initial-color:var(--theme-palette-color-1);--theme-button-background-hover-color:var(--theme-palette-color-2);--theme-button-border:none;--theme-button-border-radius:3px;--theme-button-padding:5px 20px;--theme-normal-container-max-width:1290px;--theme-content-vertical-spacing:60px;--theme-container-edge-spacing:90vw;--theme-narrow-container-max-width:750px;--theme-wide-offset:130px;}h1 {--theme-font-weight:700;--theme-font-size:40px;--theme-line-height:1.5;}h2 {--theme-font-weight:700;--theme-font-size:35px;--theme-line-height:1.5;}h3 {--theme-font-weight:700;--theme-font-size:30px;--theme-line-height:1.5;}h4 {--theme-font-weight:700;--theme-font-size:25px;--theme-line-height:1.5;}h5 {--theme-font-weight:700;--theme-font-size:20px;--theme-line-height:1.5;}h6 {--theme-font-weight:700;--theme-font-size:16px;--theme-line-height:1.5;}.wp-block-pullquote {--theme-font-family:Georgia;--theme-font-weight:600;--theme-font-size:25px;}pre, code, samp, kbd {--theme-font-family:monospace;--theme-font-weight:400;--theme-font-size:16px;}figcaption {--theme-font-size:14px;}.ct-sidebar .widget-title {--theme-font-size:20px;}.ct-breadcrumbs {--theme-font-weight:600;--theme-text-transform:uppercase;--theme-font-size:12px;}body {background-color:var(--theme-palette-color-7);background-image:none;} [data-prefix=\"single_blog_post\"] .entry-header .page-title {--theme-font-size:30px;} [data-prefix=\"single_blog_post\"] .entry-header .entry-meta {--theme-font-weight:600;--theme-text-transform:uppercase;--theme-font-size:12px;--theme-line-height:1.3;} [data-prefix=\"categories\"] .entry-header .page-title {--theme-font-size:30px;} [data-prefix=\"categories\"] .entry-header .entry-meta {--theme-font-weight:600;--theme-text-transform:uppercase;--theme-font-size:12px;--theme-line-height:1.3;} [data-prefix=\"search\"] .entry-header .page-title {--theme-font-size:30px;} [data-prefix=\"search\"] .entry-header .entry-meta {--theme-font-weight:600;--theme-text-transform:uppercase;--theme-font-size:12px;--theme-line-height:1.3;} [data-prefix=\"author\"] .entry-header .page-title {--theme-font-size:30px;} [data-prefix=\"author\"] .entry-header .entry-meta {--theme-font-weight:600;--theme-text-transform:uppercase;--theme-font-size:12px;--theme-line-height:1.3;} [data-prefix=\"author\"] .hero-section[data-type=\"type-2\"] {background-color:var(--theme-palette-color-6);background-image:none;--container-padding:50px 0px;} [data-prefix=\"single_page\"] .entry-header .page-title {--theme-font-size:30px;} [data-prefix=\"single_page\"] .entry-header .entry-meta {--theme-font-weight:600;--theme-text-transform:uppercase;--theme-font-size:12px;--theme-line-height:1.3;} [data-prefix=\"blog\"] .entries {--grid-template-columns:repeat(3, minmax(0, 1fr));} [data-prefix=\"blog\"] .entry-card .entry-title {--theme-font-size:20px;--theme-line-height:1.3;} [data-prefix=\"blog\"] .entry-card .entry-meta {--theme-font-weight:600;--theme-text-transform:uppercase;--theme-font-size:12px;} [data-prefix=\"blog\"] .entry-card {background-color:var(--theme-palette-color-8);--theme-box-shadow:0px 12px 18px -6px rgba(34, 56, 101, 0.04);} [data-prefix=\"categories\"] .entries {--grid-template-columns:repeat(3, minmax(0, 1fr));} [data-prefix=\"categories\"] .entry-card .entry-title {--theme-font-size:20px;--theme-line-height:1.3;} [data-prefix=\"categories\"] .entry-card .entry-meta {--theme-font-weight:600;--theme-text-transform:uppercase;--theme-font-size:12px;} [data-prefix=\"categories\"] .entry-card {background-color:var(--theme-palette-color-8);--theme-box-shadow:0px 12px 18px -6px rgba(34, 56, 101, 0.04);} [data-prefix=\"author\"] .entries {--grid-template-columns:repeat(3, minmax(0, 1fr));} [data-prefix=\"author\"] .entry-card .entry-title {--theme-font-size:20px;--theme-line-height:1.3;} [data-prefix=\"author\"] .entry-card .entry-meta {--theme-font-weight:600;--theme-text-transform:uppercase;--theme-font-size:12px;} [data-prefix=\"author\"] .entry-card {background-color:var(--theme-palette-color-8);--theme-box-shadow:0px 12px 18px -6px rgba(34, 56, 101, 0.04);} [data-prefix=\"search\"] .entries {--grid-template-columns:repeat(3, minmax(0, 1fr));} [data-prefix=\"search\"] .entry-card .entry-title {--theme-font-size:20px;--theme-line-height:1.3;} [data-prefix=\"search\"] .entry-card .entry-meta {--theme-font-weight:600;--theme-text-transform:uppercase;--theme-font-size:12px;} [data-prefix=\"search\"] .entry-card {background-color:var(--theme-palette-color-8);--theme-box-shadow:0px 12px 18px -6px rgba(34, 56, 101, 0.04);}form textarea {--theme-form-field-height:170px;}.ct-sidebar {--theme-link-initial-color:var(--theme-text-color);} [data-prefix=\"single_blog_post\"] [class*=\"ct-container\"] > article[class*=\"post\"] {--has-boxed:var(--false);--has-wide:var(--true);} [data-prefix=\"single_page\"] [class*=\"ct-container\"] > article[class*=\"post\"] {--has-boxed:var(--false);--has-wide:var(--true);}\";s:6:\"tablet\";s:621:\"[data-header*=\"type-1\"] .ct-header [data-row*=\"middle\"] {--height:70px;} [data-header*=\"type-1\"] #offcanvas {--side-panel-width:65vw;} [data-header*=\"type-1\"] {--header-height:70px;} [data-footer*=\"type-1\"] .ct-footer [data-row*=\"bottom\"] > div {--grid-template-columns:initial;} [data-prefix=\"blog\"] .entries {--grid-template-columns:repeat(2, minmax(0, 1fr));} [data-prefix=\"categories\"] .entries {--grid-template-columns:repeat(2, minmax(0, 1fr));} [data-prefix=\"author\"] .entries {--grid-template-columns:repeat(2, minmax(0, 1fr));} [data-prefix=\"search\"] .entries {--grid-template-columns:repeat(2, minmax(0, 1fr));}\";s:6:\"mobile\";s:905:\"[data-header*=\"type-1\"] #offcanvas {--side-panel-width:90vw;} [data-footer*=\"type-1\"] .ct-footer [data-row*=\"bottom\"] > div {--container-spacing:15px;--grid-template-columns:initial;} [data-prefix=\"blog\"] .entries {--grid-template-columns:repeat(1, minmax(0, 1fr));} [data-prefix=\"blog\"] .entry-card .entry-title {--theme-font-size:18px;} [data-prefix=\"categories\"] .entries {--grid-template-columns:repeat(1, minmax(0, 1fr));} [data-prefix=\"categories\"] .entry-card .entry-title {--theme-font-size:18px;} [data-prefix=\"author\"] .entries {--grid-template-columns:repeat(1, minmax(0, 1fr));} [data-prefix=\"author\"] .entry-card .entry-title {--theme-font-size:18px;} [data-prefix=\"search\"] .entries {--grid-template-columns:repeat(1, minmax(0, 1fr));} [data-prefix=\"search\"] .entry-card .entry-title {--theme-font-size:18px;}:root {--theme-content-vertical-spacing:50px;--theme-container-edge-spacing:88vw;}\";}}', 'off'),
(330, 'theme_mods_newsical', 'a:3:{i:0;b:0;s:18:\"nav_menu_locations\";a:0:{}s:16:\"sidebars_widgets\";a:2:{s:4:\"time\";i:1734771037;s:4:\"data\";a:9:{s:19:\"wp_inactive_widgets\";a:0:{}s:26:\"home-advertisement-widgets\";a:0:{}s:24:\"express-off-canvas-panel\";a:0:{}s:9:\"sidebar-1\";a:5:{i:0;s:7:\"block-2\";i:1;s:7:\"block-3\";i:2;s:7:\"block-4\";i:3;s:7:\"block-5\";i:4;s:7:\"block-6\";}s:20:\"home-content-widgets\";a:0:{}s:20:\"home-sidebar-widgets\";a:0:{}s:28:\"footer-first-widgets-section\";a:0:{}s:29:\"footer-second-widgets-section\";a:0:{}s:28:\"footer-third-widgets-section\";a:0:{}}}}', 'off'),
(332, 'widget_morenews_author_info', 'a:2:{i:1;a:14:{s:26:\"morenews-author-info-title\";s:12:\"About Author\";s:29:\"morenews-author-info-subtitle\";s:0:\"\";s:26:\"morenews-author-info-image\";s:3:\"279\";s:25:\"morenews-author-info-name\";s:9:\"AF themes\";s:25:\"morenews-author-info-desc\";s:203:\"We mainly focus on quality code and elegant design with incredible support. Our WordPress themes and plugins empower you to create an elegant, professional and easy to maintain website in no time at all.\";s:26:\"morenews-author-info-phone\";s:0:\"\";s:26:\"morenews-author-info-email\";s:0:\"\";s:29:\"morenews-author-info-facebook\";s:33:\"https://www.facebook.com/afthemes\";s:28:\"morenews-author-info-twitter\";s:32:\"https://www.twitter.com/afthemes\";s:29:\"morenews-author-info-linkedin\";s:0:\"\";s:30:\"morenews-author-info-instagram\";s:0:\"\";s:23:\"morenews-author-info-vk\";s:0:\"\";s:28:\"morenews-author-info-youtube\";s:56:\"https://www.youtube.com/channel/UCCJKF25c3HZpfaELha-86Hw\";s:27:\"morenews-author-info-tiktok\";s:0:\"\";}s:12:\"_multiwidget\";i:1;}', 'auto'),
(333, 'widget_morenews_posts_list', 'a:2:{i:1;a:3:{s:25:\"morenews-posts-list-title\";s:10:\"Posts List\";s:28:\"morenews-posts-slider-number\";s:0:\"\";s:24:\"morenews-select-category\";s:0:\"\";}s:12:\"_multiwidget\";i:1;}', 'auto'),
(334, 'widget_morenews_express_posts_list', 'a:2:{i:1;a:3:{s:36:\"morenews-express-posts-section-title\";s:18:\"Express Posts List\";s:24:\"morenews-number-of-posts\";s:0:\"\";s:24:\"morenews-select-category\";s:1:\"2\";}s:12:\"_multiwidget\";i:1;}', 'auto'),
(335, 'widget_morenews_posts_single_column', 'a:2:{i:1;a:3:{s:25:\"morenews-posts-list-title\";s:18:\"Post Single Column\";s:28:\"morenews-posts-slider-number\";s:0:\"\";s:24:\"morenews-select-category\";s:0:\"\";}s:12:\"_multiwidget\";i:1;}', 'auto'),
(336, 'widget_morenews_posts_double_column', 'a:2:{i:1;a:5:{s:27:\"morenews-posts-list-title-1\";s:21:\"Post Double Columns 1\";s:27:\"morenews-posts-list-title-2\";s:21:\"Post Double Columns 2\";s:28:\"morenews-posts-slider-number\";s:0:\"\";s:26:\"morenews-select-category-1\";s:1:\"4\";s:26:\"morenews-select-category-2\";s:1:\"2\";}s:12:\"_multiwidget\";i:1;}', 'auto'),
(337, 'widget_morenews_featured_posts', 'a:2:{i:1;a:3:{s:29:\"morenews-featured-posts-title\";s:10:\"Posts Grid\";s:24:\"morenews-number-of-posts\";s:0:\"\";s:24:\"morenews-select-category\";s:0:\"\";}s:12:\"_multiwidget\";i:1;}', 'auto'),
(338, 'widget_morenews_posts_slider', 'a:2:{i:1;a:3:{s:27:\"morenews-posts-slider-title\";s:12:\"Posts Slider\";s:24:\"morenews-number-of-posts\";s:0:\"\";s:24:\"morenews-select-category\";s:0:\"\";}s:12:\"_multiwidget\";i:1;}', 'auto'),
(339, 'widget_morenews_trending_news', 'a:3:{i:1;a:4:{s:28:\"morenews-trending-news-title\";s:13:\"Trending News\";s:24:\"morenews-number-of-posts\";s:0:\"\";s:23:\"morenews-news_filter-by\";s:0:\"\";s:24:\"morenews-select-category\";s:0:\"\";}i:2;a:4:{s:28:\"morenews-trending-news-title\";s:13:\"Trending News\";s:24:\"morenews-number-of-posts\";s:0:\"\";s:23:\"morenews-news_filter-by\";s:0:\"\";s:24:\"morenews-select-category\";s:0:\"\";}s:12:\"_multiwidget\";i:1;}', 'auto'),
(340, 'widget_morenews_social_contacts', 'a:4:{i:1;a:3:{s:30:\"morenews-social-contacts-title\";s:15:\"Connect with Us\";s:26:\"morenews-select-background\";s:0:\"\";s:31:\"morenews-select-background-type\";s:0:\"\";}i:2;a:3:{s:30:\"morenews-social-contacts-title\";s:15:\"Connect with Us\";s:26:\"morenews-select-background\";s:0:\"\";s:31:\"morenews-select-background-type\";s:0:\"\";}i:3;a:3:{s:30:\"morenews-social-contacts-title\";s:15:\"Connect with Us\";s:26:\"morenews-select-background\";s:0:\"\";s:31:\"morenews-select-background-type\";s:0:\"\";}s:12:\"_multiwidget\";i:1;}', 'auto'),
(349, '_transient_templatespare-kit_activation_notice', '1', 'on'),
(355, 'fs_active_plugins', 'O:8:\"stdClass\":3:{s:7:\"plugins\";a:1:{s:19:\"blockspare/freemius\";O:8:\"stdClass\":4:{s:7:\"version\";s:5:\"2.9.0\";s:4:\"type\";s:6:\"plugin\";s:9:\"timestamp\";i:1734771044;s:11:\"plugin_path\";s:25:\"blockspare/blockspare.php\";}}s:7:\"abspath\";s:21:\"D:\\laragon\\www\\datws/\";s:6:\"newest\";O:8:\"stdClass\":5:{s:11:\"plugin_path\";s:25:\"blockspare/blockspare.php\";s:8:\"sdk_path\";s:19:\"blockspare/freemius\";s:7:\"version\";s:5:\"2.9.0\";s:13:\"in_activation\";b:0;s:9:\"timestamp\";i:1734771044;}}', 'auto'),
(356, 'fs_debug_mode', '', 'auto'),
(357, 'fs_accounts', 'a:7:{s:21:\"id_slug_type_path_map\";a:1:{i:9379;a:3:{s:4:\"slug\";s:10:\"blockspare\";s:4:\"type\";s:6:\"plugin\";s:4:\"path\";s:31:\"templatespare/templatespare.php\";}}s:11:\"plugin_data\";a:1:{s:10:\"blockspare\";a:17:{s:19:\"last_load_timestamp\";i:1743932345;s:16:\"plugin_main_file\";O:8:\"stdClass\":1:{s:4:\"path\";s:31:\"templatespare/templatespare.php\";}s:20:\"is_network_activated\";b:0;s:17:\"install_timestamp\";i:1734771044;s:17:\"was_plugin_loaded\";b:1;s:21:\"is_plugin_new_install\";b:0;s:16:\"sdk_last_version\";N;s:11:\"sdk_version\";s:5:\"2.9.0\";s:16:\"sdk_upgrade_mode\";b:1;s:18:\"sdk_downgrade_mode\";b:0;s:19:\"plugin_last_version\";N;s:14:\"plugin_version\";s:5:\"2.5.1\";s:19:\"plugin_upgrade_mode\";b:1;s:21:\"plugin_downgrade_mode\";b:0;s:17:\"connectivity_test\";a:6:{s:12:\"is_connected\";N;s:4:\"host\";s:10:\"datws.test\";s:9:\"server_ip\";s:9:\"127.0.0.1\";s:9:\"is_active\";b:1;s:9:\"timestamp\";i:1734771044;s:7:\"version\";s:5:\"2.5.1\";}s:15:\"prev_is_premium\";b:0;s:18:\"sticky_optin_added\";b:1;}}s:13:\"file_slug_map\";a:1:{s:31:\"templatespare/templatespare.php\";s:10:\"blockspare\";}s:7:\"plugins\";a:1:{s:10:\"blockspare\";O:9:\"FS_Plugin\":24:{s:2:\"id\";s:4:\"9379\";s:7:\"updated\";N;s:7:\"created\";N;s:22:\"\0FS_Entity\0_is_updated\";b:0;s:10:\"public_key\";s:32:\"pk_29829adcdce7852dbe329f64cd6f3\";s:10:\"secret_key\";N;s:16:\"parent_plugin_id\";N;s:5:\"title\";s:50:\"TemplateSpare: Build Stunning WordPress Sites Fast\";s:4:\"slug\";s:10:\"blockspare\";s:12:\"premium_slug\";s:14:\"blockspare-pro\";s:4:\"type\";s:6:\"plugin\";s:20:\"affiliate_moderation\";b:0;s:19:\"is_wp_org_compliant\";b:1;s:22:\"premium_releases_count\";N;s:4:\"file\";s:31:\"templatespare/templatespare.php\";s:7:\"version\";s:5:\"2.5.1\";s:11:\"auto_update\";N;s:4:\"info\";N;s:10:\"is_premium\";b:0;s:14:\"premium_suffix\";s:9:\"(Premium)\";s:7:\"is_live\";b:1;s:9:\"bundle_id\";N;s:17:\"bundle_public_key\";N;s:17:\"opt_in_moderation\";N;}}s:12:\"gc_timestamp\";a:0:{}s:10:\"theme_data\";a:0:{}s:13:\"admin_notices\";a:1:{s:10:\"blockspare\";a:1:{s:15:\"connect_account\";a:10:{s:7:\"message\";s:185:\"We made a few tweaks to the plugin, <b><a href=\"http://datws.test/wp-admin/admin.php?page=blockspare\">Opt in to make \"TemplateSpare: Build Stunning WordPress Sites Fast\" better!</a></b>\";s:5:\"title\";s:0:\"\";s:4:\"type\";s:10:\"update-nag\";s:6:\"sticky\";b:1;s:2:\"id\";s:15:\"connect_account\";s:10:\"manager_id\";s:10:\"blockspare\";s:6:\"plugin\";s:50:\"TemplateSpare: Build Stunning WordPress Sites Fast\";s:10:\"wp_user_id\";N;s:11:\"dismissible\";b:1;s:4:\"data\";a:0:{}}}}}', 'auto'),
(358, 'morenews_theme_installed_time_v2', '1734771046', 'auto'),
(359, 'blockspare_setup_notice_start_time', '1734771046', 'auto'),
(360, 'blockspare_upgrade_notice_start_time', '1734771046', 'auto'),
(363, 'wp_calendar_block_has_published_posts', '1', 'auto'),
(364, 'category_children', 'a:0:{}', 'auto'),
(365, 'nav_menus_created_posts', 'a:0:{}', 'on'),
(366, 'theme_mods_morenews', 'a:21:{i:0;b:0;s:18:\"nav_menu_locations\";a:1:{s:15:\"aft-primary-nav\";i:25;}s:18:\"custom_css_post_id\";i:-1;s:20:\"site_title_font_size\";s:2:\"42\";s:16:\"header_textcolor\";s:6:\"ffffff\";s:33:\"disable_header_image_tint_overlay\";b:0;s:28:\"banner_advertisement_section\";i:795;s:31:\"show_featured_post_list_section\";b:0;s:37:\"featured_post_list_category_section_2\";i:2;s:34:\"select_banner_latest_post_category\";i:2;s:37:\"featured_post_list_category_section_3\";i:4;s:29:\"select_featured_news_category\";i:0;s:12:\"header_image\";s:118:\"http://datws.test/wp-content/uploads/2024/12/cropped-flower-military-pattern-soldier-army-red-672477-pxhere.com_-1.jpg\";s:17:\"header_image_data\";O:8:\"stdClass\":5:{s:13:\"attachment_id\";i:996;s:3:\"url\";s:118:\"http://datws.test/wp-content/uploads/2024/12/cropped-flower-military-pattern-soldier-army-red-672477-pxhere.com_-1.jpg\";s:13:\"thumbnail_url\";s:126:\"http://datws.test/wp-content/uploads/2024/12/cropped-flower-military-pattern-soldier-army-red-672477-pxhere.com_-1-150x150.jpg\";s:6:\"height\";i:399;s:5:\"width\";i:1500;}s:24:\"frontpage_sticky_sidebar\";b:1;s:23:\"footer_background_image\";i:994;s:22:\"show_main_news_section\";b:0;s:23:\"show_flash_news_section\";b:0;s:27:\"show_featured_posts_section\";b:0;s:27:\"frontpage_show_latest_posts\";b:0;s:15:\"secondary_color\";s:7:\"#bb1919\";}', 'auto'),
(367, 'templatespare_wizard_next_step', '0', 'auto'),
(368, 'templatespare_wizard_category_value', '', 'auto'),
(372, 'blockspare_current_version_installed', '3.2.6', 'auto'),
(467, '_site_transient_timeout_theme_roots', '1743934165', 'off'),
(468, '_site_transient_theme_roots', 'a:7:{s:7:\"blocksy\";s:7:\"/themes\";s:8:\"morenews\";s:7:\"/themes\";s:8:\"newsical\";s:7:\"/themes\";s:16:\"twentytwentyfive\";s:7:\"/themes\";s:16:\"twentytwentyfour\";s:7:\"/themes\";s:17:\"twentytwentythree\";s:7:\"/themes\";s:15:\"twentytwentytwo\";s:7:\"/themes\";}', 'off'),
(471, '_site_transient_update_core', 'O:8:\"stdClass\":4:{s:7:\"updates\";a:1:{i:0;O:8:\"stdClass\":10:{s:8:\"response\";s:6:\"latest\";s:8:\"download\";s:62:\"https://downloads.wordpress.org/release/vi/wordpress-6.7.2.zip\";s:6:\"locale\";s:2:\"vi\";s:8:\"packages\";O:8:\"stdClass\":5:{s:4:\"full\";s:62:\"https://downloads.wordpress.org/release/vi/wordpress-6.7.2.zip\";s:10:\"no_content\";s:0:\"\";s:11:\"new_bundled\";s:0:\"\";s:7:\"partial\";s:0:\"\";s:8:\"rollback\";s:0:\"\";}s:7:\"current\";s:5:\"6.7.2\";s:7:\"version\";s:5:\"6.7.2\";s:11:\"php_version\";s:6:\"7.2.24\";s:13:\"mysql_version\";s:5:\"5.5.5\";s:11:\"new_bundled\";s:3:\"6.7\";s:15:\"partial_version\";s:0:\"\";}}s:12:\"last_checked\";i:1743932386;s:15:\"version_checked\";s:5:\"6.7.2\";s:12:\"translations\";a:0:{}}', 'off'),
(472, '_site_transient_update_themes', 'O:8:\"stdClass\":5:{s:12:\"last_checked\";i:1743932390;s:7:\"checked\";a:7:{s:7:\"blocksy\";s:6:\"2.0.82\";s:8:\"morenews\";s:5:\"3.2.3\";s:8:\"newsical\";s:5:\"1.0.3\";s:16:\"twentytwentyfive\";s:3:\"1.0\";s:16:\"twentytwentyfour\";s:3:\"1.3\";s:17:\"twentytwentythree\";s:3:\"1.6\";s:15:\"twentytwentytwo\";s:3:\"1.9\";}s:8:\"response\";a:4:{s:7:\"blocksy\";a:6:{s:5:\"theme\";s:7:\"blocksy\";s:11:\"new_version\";s:6:\"2.0.95\";s:3:\"url\";s:37:\"https://wordpress.org/themes/blocksy/\";s:7:\"package\";s:56:\"https://downloads.wordpress.org/theme/blocksy.2.0.95.zip\";s:8:\"requires\";s:3:\"6.5\";s:12:\"requires_php\";s:3:\"7.0\";}s:8:\"morenews\";a:6:{s:5:\"theme\";s:8:\"morenews\";s:11:\"new_version\";s:5:\"3.3.9\";s:3:\"url\";s:38:\"https://wordpress.org/themes/morenews/\";s:7:\"package\";s:56:\"https://downloads.wordpress.org/theme/morenews.3.3.9.zip\";s:8:\"requires\";s:3:\"4.0\";s:12:\"requires_php\";s:3:\"5.3\";}s:8:\"newsical\";a:6:{s:5:\"theme\";s:8:\"newsical\";s:11:\"new_version\";s:6:\"1.0.23\";s:3:\"url\";s:38:\"https://wordpress.org/themes/newsical/\";s:7:\"package\";s:57:\"https://downloads.wordpress.org/theme/newsical.1.0.23.zip\";s:8:\"requires\";s:3:\"4.0\";s:12:\"requires_php\";s:3:\"5.3\";}s:16:\"twentytwentyfive\";a:6:{s:5:\"theme\";s:16:\"twentytwentyfive\";s:11:\"new_version\";s:3:\"1.1\";s:3:\"url\";s:46:\"https://wordpress.org/themes/twentytwentyfive/\";s:7:\"package\";s:62:\"https://downloads.wordpress.org/theme/twentytwentyfive.1.1.zip\";s:8:\"requires\";s:3:\"6.7\";s:12:\"requires_php\";s:3:\"7.2\";}}s:9:\"no_update\";a:3:{s:16:\"twentytwentyfour\";a:6:{s:5:\"theme\";s:16:\"twentytwentyfour\";s:11:\"new_version\";s:3:\"1.3\";s:3:\"url\";s:46:\"https://wordpress.org/themes/twentytwentyfour/\";s:7:\"package\";s:62:\"https://downloads.wordpress.org/theme/twentytwentyfour.1.3.zip\";s:8:\"requires\";s:3:\"6.4\";s:12:\"requires_php\";s:3:\"7.0\";}s:17:\"twentytwentythree\";a:6:{s:5:\"theme\";s:17:\"twentytwentythree\";s:11:\"new_version\";s:3:\"1.6\";s:3:\"url\";s:47:\"https://wordpress.org/themes/twentytwentythree/\";s:7:\"package\";s:63:\"https://downloads.wordpress.org/theme/twentytwentythree.1.6.zip\";s:8:\"requires\";s:3:\"6.1\";s:12:\"requires_php\";s:3:\"5.6\";}s:15:\"twentytwentytwo\";a:6:{s:5:\"theme\";s:15:\"twentytwentytwo\";s:11:\"new_version\";s:3:\"1.9\";s:3:\"url\";s:45:\"https://wordpress.org/themes/twentytwentytwo/\";s:7:\"package\";s:61:\"https://downloads.wordpress.org/theme/twentytwentytwo.1.9.zip\";s:8:\"requires\";s:3:\"5.9\";s:12:\"requires_php\";s:3:\"5.6\";}}s:12:\"translations\";a:0:{}}', 'off'),
(473, '_site_transient_update_plugins', 'O:8:\"stdClass\":5:{s:12:\"last_checked\";i:1743932394;s:8:\"response\";a:4:{s:19:\"akismet/akismet.php\";O:8:\"stdClass\":13:{s:2:\"id\";s:21:\"w.org/plugins/akismet\";s:4:\"slug\";s:7:\"akismet\";s:6:\"plugin\";s:19:\"akismet/akismet.php\";s:11:\"new_version\";s:5:\"5.3.7\";s:3:\"url\";s:38:\"https://wordpress.org/plugins/akismet/\";s:7:\"package\";s:56:\"https://downloads.wordpress.org/plugin/akismet.5.3.7.zip\";s:5:\"icons\";a:2:{s:2:\"2x\";s:60:\"https://ps.w.org/akismet/assets/icon-256x256.png?rev=2818463\";s:2:\"1x\";s:60:\"https://ps.w.org/akismet/assets/icon-128x128.png?rev=2818463\";}s:7:\"banners\";a:2:{s:2:\"2x\";s:63:\"https://ps.w.org/akismet/assets/banner-1544x500.png?rev=2900731\";s:2:\"1x\";s:62:\"https://ps.w.org/akismet/assets/banner-772x250.png?rev=2900731\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"5.8\";s:6:\"tested\";s:5:\"6.7.2\";s:12:\"requires_php\";s:6:\"5.6.20\";s:16:\"requires_plugins\";a:0:{}}s:25:\"blockspare/blockspare.php\";O:8:\"stdClass\":13:{s:2:\"id\";s:24:\"w.org/plugins/blockspare\";s:4:\"slug\";s:10:\"blockspare\";s:6:\"plugin\";s:25:\"blockspare/blockspare.php\";s:11:\"new_version\";s:5:\"3.2.8\";s:3:\"url\";s:41:\"https://wordpress.org/plugins/blockspare/\";s:7:\"package\";s:53:\"https://downloads.wordpress.org/plugin/blockspare.zip\";s:5:\"icons\";a:2:{s:2:\"2x\";s:63:\"https://ps.w.org/blockspare/assets/icon-256x256.png?rev=2281427\";s:2:\"1x\";s:63:\"https://ps.w.org/blockspare/assets/icon-128x128.png?rev=2281427\";}s:7:\"banners\";a:1:{s:2:\"1x\";s:65:\"https://ps.w.org/blockspare/assets/banner-772x250.png?rev=2968691\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"4.9\";s:6:\"tested\";s:5:\"6.7.2\";s:12:\"requires_php\";s:3:\"5.3\";s:16:\"requires_plugins\";a:0:{}}s:39:\"blocksy-companion/blocksy-companion.php\";O:8:\"stdClass\":13:{s:2:\"id\";s:31:\"w.org/plugins/blocksy-companion\";s:4:\"slug\";s:17:\"blocksy-companion\";s:6:\"plugin\";s:39:\"blocksy-companion/blocksy-companion.php\";s:11:\"new_version\";s:6:\"2.0.95\";s:3:\"url\";s:48:\"https://wordpress.org/plugins/blocksy-companion/\";s:7:\"package\";s:67:\"https://downloads.wordpress.org/plugin/blocksy-companion.2.0.95.zip\";s:5:\"icons\";a:2:{s:2:\"2x\";s:70:\"https://ps.w.org/blocksy-companion/assets/icon-256x256.jpg?rev=3145156\";s:2:\"1x\";s:70:\"https://ps.w.org/blocksy-companion/assets/icon-256x256.jpg?rev=3145156\";}s:7:\"banners\";a:2:{s:2:\"2x\";s:73:\"https://ps.w.org/blocksy-companion/assets/banner-1544x500.jpg?rev=2418486\";s:2:\"1x\";s:72:\"https://ps.w.org/blocksy-companion/assets/banner-772x250.jpg?rev=2418485\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"6.5\";s:6:\"tested\";s:5:\"6.7.2\";s:12:\"requires_php\";s:3:\"7.0\";s:16:\"requires_plugins\";a:0:{}}s:31:\"templatespare/templatespare.php\";O:8:\"stdClass\":13:{s:2:\"id\";s:27:\"w.org/plugins/templatespare\";s:4:\"slug\";s:13:\"templatespare\";s:6:\"plugin\";s:31:\"templatespare/templatespare.php\";s:11:\"new_version\";s:5:\"3.0.1\";s:3:\"url\";s:44:\"https://wordpress.org/plugins/templatespare/\";s:7:\"package\";s:56:\"https://downloads.wordpress.org/plugin/templatespare.zip\";s:5:\"icons\";a:2:{s:2:\"2x\";s:66:\"https://ps.w.org/templatespare/assets/icon-256x256.png?rev=2849750\";s:2:\"1x\";s:66:\"https://ps.w.org/templatespare/assets/icon-128x128.png?rev=2849750\";}s:7:\"banners\";a:1:{s:2:\"1x\";s:68:\"https://ps.w.org/templatespare/assets/banner-772x250.png?rev=3240563\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"4.0\";s:6:\"tested\";s:5:\"6.7.2\";s:12:\"requires_php\";b:0;s:16:\"requires_plugins\";a:0:{}}}s:12:\"translations\";a:0:{}s:9:\"no_update\";a:1:{s:9:\"hello.php\";O:8:\"stdClass\":10:{s:2:\"id\";s:25:\"w.org/plugins/hello-dolly\";s:4:\"slug\";s:11:\"hello-dolly\";s:6:\"plugin\";s:9:\"hello.php\";s:11:\"new_version\";s:5:\"1.7.2\";s:3:\"url\";s:42:\"https://wordpress.org/plugins/hello-dolly/\";s:7:\"package\";s:60:\"https://downloads.wordpress.org/plugin/hello-dolly.1.7.3.zip\";s:5:\"icons\";a:2:{s:2:\"2x\";s:64:\"https://ps.w.org/hello-dolly/assets/icon-256x256.jpg?rev=2052855\";s:2:\"1x\";s:64:\"https://ps.w.org/hello-dolly/assets/icon-128x128.jpg?rev=2052855\";}s:7:\"banners\";a:2:{s:2:\"2x\";s:67:\"https://ps.w.org/hello-dolly/assets/banner-1544x500.jpg?rev=2645582\";s:2:\"1x\";s:66:\"https://ps.w.org/hello-dolly/assets/banner-772x250.jpg?rev=2052855\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"4.6\";}}s:7:\"checked\";a:5:{s:19:\"akismet/akismet.php\";s:5:\"5.3.3\";s:25:\"blockspare/blockspare.php\";s:5:\"3.2.7\";s:39:\"blocksy-companion/blocksy-companion.php\";s:6:\"2.0.82\";s:9:\"hello.php\";s:5:\"1.7.2\";s:31:\"templatespare/templatespare.php\";s:5:\"2.5.1\";}}', 'off'),
(474, '_site_transient_timeout_php_check_1ad0acda4da6c4fcb37046d1f090be2c', '1744537198', 'off'),
(475, '_site_transient_php_check_1ad0acda4da6c4fcb37046d1f090be2c', 'a:5:{s:19:\"recommended_version\";s:3:\"7.4\";s:15:\"minimum_version\";s:6:\"7.2.24\";s:12:\"is_supported\";b:1;s:9:\"is_secure\";b:1;s:13:\"is_acceptable\";b:1;}', 'off'),
(476, '_site_transient_timeout_wp_theme_files_patterns-946043387a3067fe3c972bf90163a345', '1743934205', 'off'),
(477, '_site_transient_wp_theme_files_patterns-946043387a3067fe3c972bf90163a345', 'a:2:{s:7:\"version\";s:5:\"3.2.3\";s:8:\"patterns\";a:0:{}}', 'off');

-- --------------------------------------------------------

--
-- Table structure for table `wp_postmeta`
--

CREATE TABLE `wp_postmeta` (
  `meta_id` bigint UNSIGNED NOT NULL,
  `post_id` bigint UNSIGNED NOT NULL DEFAULT '0',
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_520_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `wp_postmeta`
--

INSERT INTO `wp_postmeta` (`meta_id`, `post_id`, `meta_key`, `meta_value`) VALUES
(1, 2, '_wp_page_template', 'default'),
(2, 3, '_wp_page_template', 'default'),
(3, 1, '_edit_lock', '1725454619:1'),
(5, 9, '_wp_attached_file', '2024/11/Blue-Simple-Professional-CV-Resume.pdf'),
(6, 9, '_wp_attachment_metadata', 'a:1:{s:8:\"filesize\";i:258291;}'),
(7, 10, '_wp_attached_file', '2024/11/Screenshot-2024-11-02-201026.png'),
(8, 10, '_wp_attachment_metadata', 'a:6:{s:5:\"width\";i:1918;s:6:\"height\";i:945;s:4:\"file\";s:40:\"2024/11/Screenshot-2024-11-02-201026.png\";s:8:\"filesize\";i:311059;s:5:\"sizes\";a:5:{s:6:\"medium\";a:5:{s:4:\"file\";s:40:\"Screenshot-2024-11-02-201026-300x148.png\";s:5:\"width\";i:300;s:6:\"height\";i:148;s:9:\"mime-type\";s:9:\"image/png\";s:8:\"filesize\";i:19067;}s:5:\"large\";a:5:{s:4:\"file\";s:41:\"Screenshot-2024-11-02-201026-1024x505.png\";s:5:\"width\";i:1024;s:6:\"height\";i:505;s:9:\"mime-type\";s:9:\"image/png\";s:8:\"filesize\";i:136029;}s:9:\"thumbnail\";a:5:{s:4:\"file\";s:40:\"Screenshot-2024-11-02-201026-150x150.png\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:9:\"image/png\";s:8:\"filesize\";i:12993;}s:12:\"medium_large\";a:5:{s:4:\"file\";s:40:\"Screenshot-2024-11-02-201026-768x378.png\";s:5:\"width\";i:768;s:6:\"height\";i:378;s:9:\"mime-type\";s:9:\"image/png\";s:8:\"filesize\";i:84415;}s:9:\"1536x1536\";a:5:{s:4:\"file\";s:41:\"Screenshot-2024-11-02-201026-1536x757.png\";s:5:\"width\";i:1536;s:6:\"height\";i:757;s:9:\"mime-type\";s:9:\"image/png\";s:8:\"filesize\";i:260796;}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(9, 11, '_wp_attached_file', '2024/11/fc0fb742a3a21155ea42f6786dd438c8-rotated.jpg'),
(10, 11, '_wp_attachment_metadata', 'a:7:{s:5:\"width\";i:1002;s:6:\"height\";i:564;s:4:\"file\";s:52:\"2024/11/fc0fb742a3a21155ea42f6786dd438c8-rotated.jpg\";s:8:\"filesize\";i:147115;s:5:\"sizes\";a:3:{s:6:\"medium\";a:5:{s:4:\"file\";s:44:\"fc0fb742a3a21155ea42f6786dd438c8-300x169.jpg\";s:5:\"width\";i:300;s:6:\"height\";i:169;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:18589;}s:9:\"thumbnail\";a:5:{s:4:\"file\";s:44:\"fc0fb742a3a21155ea42f6786dd438c8-150x150.jpg\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:10141;}s:12:\"medium_large\";a:5:{s:4:\"file\";s:44:\"fc0fb742a3a21155ea42f6786dd438c8-768x432.jpg\";s:5:\"width\";i:768;s:6:\"height\";i:432;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:86834;}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";i:1;s:8:\"keywords\";a:0:{}}s:14:\"original_image\";s:36:\"fc0fb742a3a21155ea42f6786dd438c8.jpg\";}'),
(11, 12, 'origin', 'theme'),
(12, 14, '_wp_attached_file', '2024/11/image.webp'),
(13, 14, '_wp_attachment_metadata', 'a:6:{s:5:\"width\";i:1500;s:6:\"height\";i:703;s:4:\"file\";s:18:\"2024/11/image.webp\";s:8:\"filesize\";i:199724;s:5:\"sizes\";a:4:{s:6:\"medium\";a:5:{s:4:\"file\";s:18:\"image-300x141.webp\";s:5:\"width\";i:300;s:6:\"height\";i:141;s:9:\"mime-type\";s:10:\"image/webp\";s:8:\"filesize\";i:9502;}s:5:\"large\";a:5:{s:4:\"file\";s:19:\"image-1024x480.webp\";s:5:\"width\";i:1024;s:6:\"height\";i:480;s:9:\"mime-type\";s:10:\"image/webp\";s:8:\"filesize\";i:78918;}s:9:\"thumbnail\";a:5:{s:4:\"file\";s:18:\"image-150x150.webp\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:10:\"image/webp\";s:8:\"filesize\";i:5506;}s:12:\"medium_large\";a:5:{s:4:\"file\";s:18:\"image-768x360.webp\";s:5:\"width\";i:768;s:6:\"height\";i:360;s:9:\"mime-type\";s:10:\"image/webp\";s:8:\"filesize\";i:49806;}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(14, 15, '_wp_attached_file', '2024/11/644bd8a603f9ac1e492b78472b5cbd86-rotated.jpg'),
(15, 15, '_wp_attachment_metadata', 'a:7:{s:5:\"width\";i:1308;s:6:\"height\";i:736;s:4:\"file\";s:52:\"2024/11/644bd8a603f9ac1e492b78472b5cbd86-rotated.jpg\";s:8:\"filesize\";i:144520;s:5:\"sizes\";a:4:{s:6:\"medium\";a:5:{s:4:\"file\";s:44:\"644bd8a603f9ac1e492b78472b5cbd86-300x169.jpg\";s:5:\"width\";i:300;s:6:\"height\";i:169;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:13877;}s:5:\"large\";a:5:{s:4:\"file\";s:45:\"644bd8a603f9ac1e492b78472b5cbd86-1024x576.jpg\";s:5:\"width\";i:1024;s:6:\"height\";i:576;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:91820;}s:9:\"thumbnail\";a:5:{s:4:\"file\";s:44:\"644bd8a603f9ac1e492b78472b5cbd86-150x150.jpg\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:7088;}s:12:\"medium_large\";a:5:{s:4:\"file\";s:44:\"644bd8a603f9ac1e492b78472b5cbd86-768x432.jpg\";s:5:\"width\";i:768;s:6:\"height\";i:432;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:58714;}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";i:1;s:8:\"keywords\";a:0:{}}s:14:\"original_image\";s:36:\"644bd8a603f9ac1e492b78472b5cbd86.jpg\";}'),
(16, 16, '_wp_attached_file', '2024/11/12438d4c5d038a9f9153027c4a60c858-rotated.jpg'),
(17, 16, '_wp_attachment_metadata', 'a:7:{s:5:\"width\";i:1097;s:6:\"height\";i:564;s:4:\"file\";s:52:\"2024/11/12438d4c5d038a9f9153027c4a60c858-rotated.jpg\";s:8:\"filesize\";i:125136;s:5:\"sizes\";a:4:{s:6:\"medium\";a:5:{s:4:\"file\";s:44:\"12438d4c5d038a9f9153027c4a60c858-300x154.jpg\";s:5:\"width\";i:300;s:6:\"height\";i:154;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:15992;}s:5:\"large\";a:5:{s:4:\"file\";s:45:\"12438d4c5d038a9f9153027c4a60c858-1024x526.jpg\";s:5:\"width\";i:1024;s:6:\"height\";i:526;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:104915;}s:9:\"thumbnail\";a:5:{s:4:\"file\";s:44:\"12438d4c5d038a9f9153027c4a60c858-150x150.jpg\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:9716;}s:12:\"medium_large\";a:5:{s:4:\"file\";s:44:\"12438d4c5d038a9f9153027c4a60c858-768x395.jpg\";s:5:\"width\";i:768;s:6:\"height\";i:395;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:69004;}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";i:1;s:8:\"keywords\";a:0:{}}s:14:\"original_image\";s:36:\"12438d4c5d038a9f9153027c4a60c858.jpg\";}'),
(18, 17, '_wp_attached_file', '2024/11/fc0fb742a3a21155ea42f6786dd438c8-1-rotated.jpg'),
(19, 17, '_wp_attachment_metadata', 'a:7:{s:5:\"width\";i:1002;s:6:\"height\";i:564;s:4:\"file\";s:54:\"2024/11/fc0fb742a3a21155ea42f6786dd438c8-1-rotated.jpg\";s:8:\"filesize\";i:147115;s:5:\"sizes\";a:3:{s:6:\"medium\";a:5:{s:4:\"file\";s:46:\"fc0fb742a3a21155ea42f6786dd438c8-1-300x169.jpg\";s:5:\"width\";i:300;s:6:\"height\";i:169;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:18589;}s:9:\"thumbnail\";a:5:{s:4:\"file\";s:46:\"fc0fb742a3a21155ea42f6786dd438c8-1-150x150.jpg\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:10141;}s:12:\"medium_large\";a:5:{s:4:\"file\";s:46:\"fc0fb742a3a21155ea42f6786dd438c8-1-768x432.jpg\";s:5:\"width\";i:768;s:6:\"height\";i:432;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:86834;}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";i:1;s:8:\"keywords\";a:0:{}}s:14:\"original_image\";s:38:\"fc0fb742a3a21155ea42f6786dd438c8-1.jpg\";}'),
(20, 18, '_wp_attached_file', '2024/11/bdc11efc57757c81ac2f4477e71880a1-rotated.jpg'),
(21, 18, '_wp_attachment_metadata', 'a:7:{s:5:\"width\";i:1017;s:6:\"height\";i:564;s:4:\"file\";s:52:\"2024/11/bdc11efc57757c81ac2f4477e71880a1-rotated.jpg\";s:8:\"filesize\";i:124256;s:5:\"sizes\";a:3:{s:6:\"medium\";a:5:{s:4:\"file\";s:44:\"bdc11efc57757c81ac2f4477e71880a1-300x166.jpg\";s:5:\"width\";i:300;s:6:\"height\";i:166;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:13707;}s:9:\"thumbnail\";a:5:{s:4:\"file\";s:44:\"bdc11efc57757c81ac2f4477e71880a1-150x150.jpg\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:6810;}s:12:\"medium_large\";a:5:{s:4:\"file\";s:44:\"bdc11efc57757c81ac2f4477e71880a1-768x426.jpg\";s:5:\"width\";i:768;s:6:\"height\";i:426;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:68075;}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";i:1;s:8:\"keywords\";a:0:{}}s:14:\"original_image\";s:36:\"bdc11efc57757c81ac2f4477e71880a1.jpg\";}'),
(25, 21, '_wp_attached_file', '2024/12/log_file_2024-12-21__08-50-46.txt'),
(26, 7, '_wp_attached_file', '2018/07/pexels-photo-316778-1-1.jpeg'),
(27, 7, '_wp_attachment_metadata', 'a:6:{s:5:\"width\";i:1920;s:6:\"height\";i:1280;s:4:\"file\";s:36:\"2018/07/pexels-photo-316778-1-1.jpeg\";s:8:\"filesize\";i:105368;s:5:\"sizes\";a:8:{s:6:\"medium\";a:5:{s:4:\"file\";s:36:\"pexels-photo-316778-1-1-300x200.jpeg\";s:5:\"width\";i:300;s:6:\"height\";i:200;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:5725;}s:5:\"large\";a:5:{s:4:\"file\";s:37:\"pexels-photo-316778-1-1-1024x683.jpeg\";s:5:\"width\";i:1024;s:6:\"height\";i:683;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:62346;}s:9:\"thumbnail\";a:5:{s:4:\"file\";s:36:\"pexels-photo-316778-1-1-150x150.jpeg\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:3086;}s:12:\"medium_large\";a:5:{s:4:\"file\";s:36:\"pexels-photo-316778-1-1-768x512.jpeg\";s:5:\"width\";i:768;s:6:\"height\";i:512;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:34908;}s:9:\"1536x1536\";a:5:{s:4:\"file\";s:38:\"pexels-photo-316778-1-1-1536x1024.jpeg\";s:5:\"width\";i:1536;s:6:\"height\";i:1024;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:136878;}s:17:\"morenews-featured\";a:5:{s:4:\"file\";s:37:\"pexels-photo-316778-1-1-1024x683.jpeg\";s:5:\"width\";i:1024;s:6:\"height\";i:683;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:62346;}s:14:\"morenews-large\";a:5:{s:4:\"file\";s:36:\"pexels-photo-316778-1-1-825x575.jpeg\";s:5:\"width\";i:825;s:6:\"height\";i:575;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:42734;}s:15:\"morenews-medium\";a:5:{s:4:\"file\";s:36:\"pexels-photo-316778-1-1-590x410.jpeg\";s:5:\"width\";i:590;s:6:\"height\";i:410;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:21740;}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(28, 7, 'wp-smpro-smush-data', 'a:2:{s:5:\"stats\";a:8:{s:7:\"percent\";d:7.213270463719937;s:5:\"bytes\";i:31896;s:11:\"size_before\";i:442185;s:10:\"size_after\";i:410289;s:4:\"time\";d:0.33;s:11:\"api_version\";s:3:\"1.0\";s:5:\"lossy\";b:0;s:9:\"keep_exif\";i:0;}s:5:\"sizes\";a:9:{s:9:\"thumbnail\";O:8:\"stdClass\":5:{s:7:\"percent\";d:7.22;s:5:\"bytes\";i:223;s:11:\"size_before\";i:3087;s:10:\"size_after\";i:2864;s:4:\"time\";d:0.02;}s:6:\"medium\";O:8:\"stdClass\":5:{s:7:\"percent\";d:6.27;s:5:\"bytes\";i:359;s:11:\"size_before\";i:5723;s:10:\"size_after\";i:5364;s:4:\"time\";d:0.02;}s:12:\"medium_large\";O:8:\"stdClass\":5:{s:7:\"percent\";d:7.27;s:5:\"bytes\";i:2437;s:11:\"size_before\";i:33539;s:10:\"size_after\";i:31102;s:4:\"time\";d:0.02;}s:5:\"large\";O:8:\"stdClass\":5:{s:7:\"percent\";d:8.01;s:5:\"bytes\";i:4895;s:11:\"size_before\";i:61075;s:10:\"size_after\";i:56180;s:4:\"time\";d:0.04;}s:21:\"covernews-slider-full\";O:8:\"stdClass\":5:{s:7:\"percent\";d:9.39;s:5:\"bytes\";i:13917;s:11:\"size_before\";i:148134;s:10:\"size_after\";i:134217;s:4:\"time\";d:0.08;}s:23:\"covernews-slider-center\";O:8:\"stdClass\":5:{s:7:\"percent\";d:7.92;s:5:\"bytes\";i:6550;s:11:\"size_before\";i:82735;s:10:\"size_after\";i:76185;s:4:\"time\";d:0.07;}s:18:\"covernews-featured\";O:8:\"stdClass\":5:{s:7:\"percent\";d:0.11;s:5:\"bytes\";i:0;s:11:\"size_before\";i:56241;s:10:\"size_after\";i:56180;s:4:\"time\";d:0.02;}s:16:\"covernews-medium\";O:8:\"stdClass\":5:{s:7:\"percent\";d:6.27;s:5:\"bytes\";i:1600;s:11:\"size_before\";i:25537;s:10:\"size_after\";i:23937;s:4:\"time\";d:0.02;}s:23:\"covernews-medium-square\";O:8:\"stdClass\":5:{s:7:\"percent\";d:7.1;s:5:\"bytes\";i:1854;s:11:\"size_before\";i:26114;s:10:\"size_after\";i:24260;s:4:\"time\";d:0.04;}}}'),
(30, 22, '_wp_attached_file', '2018/07/pexels-photo-261949-1-1-1.jpeg'),
(31, 22, '_wp_attachment_metadata', 'a:6:{s:5:\"width\";i:1920;s:6:\"height\";i:1440;s:4:\"file\";s:38:\"2018/07/pexels-photo-261949-1-1-1.jpeg\";s:8:\"filesize\";i:281293;s:5:\"sizes\";a:8:{s:6:\"medium\";a:5:{s:4:\"file\";s:38:\"pexels-photo-261949-1-1-1-300x225.jpeg\";s:5:\"width\";i:300;s:6:\"height\";i:225;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:23355;}s:5:\"large\";a:5:{s:4:\"file\";s:39:\"pexels-photo-261949-1-1-1-1024x768.jpeg\";s:5:\"width\";i:1024;s:6:\"height\";i:768;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:166658;}s:9:\"thumbnail\";a:5:{s:4:\"file\";s:38:\"pexels-photo-261949-1-1-1-150x150.jpeg\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:9707;}s:12:\"medium_large\";a:5:{s:4:\"file\";s:38:\"pexels-photo-261949-1-1-1-768x576.jpeg\";s:5:\"width\";i:768;s:6:\"height\";i:576;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:107230;}s:9:\"1536x1536\";a:5:{s:4:\"file\";s:40:\"pexels-photo-261949-1-1-1-1536x1152.jpeg\";s:5:\"width\";i:1536;s:6:\"height\";i:1152;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:303104;}s:17:\"morenews-featured\";a:5:{s:4:\"file\";s:39:\"pexels-photo-261949-1-1-1-1024x768.jpeg\";s:5:\"width\";i:1024;s:6:\"height\";i:768;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:166658;}s:14:\"morenews-large\";a:5:{s:4:\"file\";s:38:\"pexels-photo-261949-1-1-1-825x575.jpeg\";s:5:\"width\";i:825;s:6:\"height\";i:575;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:114163;}s:15:\"morenews-medium\";a:5:{s:4:\"file\";s:38:\"pexels-photo-261949-1-1-1-590x410.jpeg\";s:5:\"width\";i:590;s:6:\"height\";i:410;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:67234;}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(32, 22, 'wp-smpro-smush-data', 'a:2:{s:5:\"stats\";a:8:{s:7:\"percent\";d:3.6344289145190847;s:5:\"bytes\";i:39210;s:11:\"size_before\";i:1078849;s:10:\"size_after\";i:1039639;s:4:\"time\";d:0.55;s:11:\"api_version\";s:3:\"1.0\";s:5:\"lossy\";b:0;s:9:\"keep_exif\";i:0;}s:5:\"sizes\";a:9:{s:9:\"thumbnail\";O:8:\"stdClass\":5:{s:7:\"percent\";d:7.73;s:5:\"bytes\";i:751;s:11:\"size_before\";i:9714;s:10:\"size_after\";i:8963;s:4:\"time\";d:0.01;}s:6:\"medium\";O:8:\"stdClass\":5:{s:7:\"percent\";d:6.49;s:5:\"bytes\";i:1514;s:11:\"size_before\";i:23342;s:10:\"size_after\";i:21828;s:4:\"time\";d:0.02;}s:12:\"medium_large\";O:8:\"stdClass\":5:{s:7:\"percent\";d:4.79;s:5:\"bytes\";i:5125;s:11:\"size_before\";i:107055;s:10:\"size_after\";i:101930;s:4:\"time\";d:0.03;}s:5:\"large\";O:8:\"stdClass\":5:{s:7:\"percent\";d:4.15;s:5:\"bytes\";i:6891;s:11:\"size_before\";i:166153;s:10:\"size_after\";i:159262;s:4:\"time\";d:0.05;}s:21:\"covernews-slider-full\";O:8:\"stdClass\":5:{s:7:\"percent\";d:3.26;s:5:\"bytes\";i:8980;s:11:\"size_before\";i:275557;s:10:\"size_after\";i:266577;s:4:\"time\";d:0.19;}s:23:\"covernews-slider-center\";O:8:\"stdClass\":5:{s:7:\"percent\";d:4.25;s:5:\"bytes\";i:7717;s:11:\"size_before\";i:181512;s:10:\"size_after\";i:173795;s:4:\"time\";d:0.08;}s:18:\"covernews-featured\";O:8:\"stdClass\":5:{s:7:\"percent\";d:0.04;s:5:\"bytes\";i:0;s:11:\"size_before\";i:159323;s:10:\"size_after\";i:159262;s:4:\"time\";d:0.08;}s:16:\"covernews-medium\";O:8:\"stdClass\":5:{s:7:\"percent\";d:5.44;s:5:\"bytes\";i:4070;s:11:\"size_before\";i:74820;s:10:\"size_after\";i:70750;s:4:\"time\";d:0.03;}s:23:\"covernews-medium-square\";O:8:\"stdClass\":5:{s:7:\"percent\";d:5.04;s:5:\"bytes\";i:4101;s:11:\"size_before\";i:81373;s:10:\"size_after\";i:77272;s:4:\"time\";d:0.06;}}}'),
(34, 23, '_wp_attached_file', '2018/07/pexels-photo-258117-1-1.jpeg'),
(35, 23, '_wp_attachment_metadata', 'a:6:{s:5:\"width\";i:1920;s:6:\"height\";i:1282;s:4:\"file\";s:36:\"2018/07/pexels-photo-258117-1-1.jpeg\";s:8:\"filesize\";i:220016;s:5:\"sizes\";a:8:{s:6:\"medium\";a:5:{s:4:\"file\";s:36:\"pexels-photo-258117-1-1-300x200.jpeg\";s:5:\"width\";i:300;s:6:\"height\";i:200;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:11951;}s:5:\"large\";a:5:{s:4:\"file\";s:37:\"pexels-photo-258117-1-1-1024x684.jpeg\";s:5:\"width\";i:1024;s:6:\"height\";i:684;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:109495;}s:9:\"thumbnail\";a:5:{s:4:\"file\";s:36:\"pexels-photo-258117-1-1-150x150.jpeg\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:5153;}s:12:\"medium_large\";a:5:{s:4:\"file\";s:36:\"pexels-photo-258117-1-1-768x513.jpeg\";s:5:\"width\";i:768;s:6:\"height\";i:513;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:65303;}s:9:\"1536x1536\";a:5:{s:4:\"file\";s:38:\"pexels-photo-258117-1-1-1536x1026.jpeg\";s:5:\"width\";i:1536;s:6:\"height\";i:1026;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:222266;}s:17:\"morenews-featured\";a:5:{s:4:\"file\";s:37:\"pexels-photo-258117-1-1-1024x684.jpeg\";s:5:\"width\";i:1024;s:6:\"height\";i:684;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:109495;}s:14:\"morenews-large\";a:5:{s:4:\"file\";s:36:\"pexels-photo-258117-1-1-825x575.jpeg\";s:5:\"width\";i:825;s:6:\"height\";i:575;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:76766;}s:15:\"morenews-medium\";a:5:{s:4:\"file\";s:36:\"pexels-photo-258117-1-1-590x410.jpeg\";s:5:\"width\";i:590;s:6:\"height\";i:410;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:41639;}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(36, 23, 'wp-smpro-smush-data', 'a:2:{s:5:\"stats\";a:8:{s:7:\"percent\";d:3.4841474099222425;s:5:\"bytes\";i:25451;s:11:\"size_before\";i:730480;s:10:\"size_after\";i:705029;s:4:\"time\";d:0.6500000000000001;s:11:\"api_version\";s:3:\"1.0\";s:5:\"lossy\";b:0;s:9:\"keep_exif\";i:0;}s:5:\"sizes\";a:9:{s:9:\"thumbnail\";O:8:\"stdClass\":5:{s:7:\"percent\";d:4.15;s:5:\"bytes\";i:212;s:11:\"size_before\";i:5114;s:10:\"size_after\";i:4902;s:4:\"time\";d:0.01;}s:6:\"medium\";O:8:\"stdClass\":5:{s:7:\"percent\";d:3.61;s:5:\"bytes\";i:430;s:11:\"size_before\";i:11900;s:10:\"size_after\";i:11470;s:4:\"time\";d:0.01;}s:12:\"medium_large\";O:8:\"stdClass\":5:{s:7:\"percent\";d:4.08;s:5:\"bytes\";i:2629;s:11:\"size_before\";i:64362;s:10:\"size_after\";i:61733;s:4:\"time\";d:0.04;}s:5:\"large\";O:8:\"stdClass\":5:{s:7:\"percent\";d:4.03;s:5:\"bytes\";i:4358;s:11:\"size_before\";i:108035;s:10:\"size_after\";i:103677;s:4:\"time\";d:0.08;}s:21:\"covernews-slider-full\";O:8:\"stdClass\":5:{s:7:\"percent\";d:4.04;s:5:\"bytes\";i:8889;s:11:\"size_before\";i:220173;s:10:\"size_after\";i:211284;s:4:\"time\";d:0.39;}s:23:\"covernews-slider-center\";O:8:\"stdClass\":5:{s:7:\"percent\";d:4.12;s:5:\"bytes\";i:4963;s:11:\"size_before\";i:120598;s:10:\"size_after\";i:115635;s:4:\"time\";d:0.04;}s:18:\"covernews-featured\";O:8:\"stdClass\":5:{s:7:\"percent\";d:0.06;s:5:\"bytes\";i:0;s:11:\"size_before\";i:103738;s:10:\"size_after\";i:103677;s:4:\"time\";d:0.03;}s:16:\"covernews-medium\";O:8:\"stdClass\":5:{s:7:\"percent\";d:3.88;s:5:\"bytes\";i:1760;s:11:\"size_before\";i:45380;s:10:\"size_after\";i:43620;s:4:\"time\";d:0.03;}s:23:\"covernews-medium-square\";O:8:\"stdClass\":5:{s:7:\"percent\";d:4.2;s:5:\"bytes\";i:2149;s:11:\"size_before\";i:51180;s:10:\"size_after\";i:49031;s:4:\"time\";d:0.02;}}}'),
(38, 24, '_wp_attached_file', '2018/07/pexels-photo-58461-1-1-1.jpeg'),
(39, 24, '_wp_attachment_metadata', 'a:6:{s:5:\"width\";i:1280;s:6:\"height\";i:734;s:4:\"file\";s:37:\"2018/07/pexels-photo-58461-1-1-1.jpeg\";s:8:\"filesize\";i:107251;s:5:\"sizes\";a:7:{s:6:\"medium\";a:5:{s:4:\"file\";s:37:\"pexels-photo-58461-1-1-1-300x172.jpeg\";s:5:\"width\";i:300;s:6:\"height\";i:172;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:15649;}s:5:\"large\";a:5:{s:4:\"file\";s:38:\"pexels-photo-58461-1-1-1-1024x587.jpeg\";s:5:\"width\";i:1024;s:6:\"height\";i:587;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:110828;}s:9:\"thumbnail\";a:5:{s:4:\"file\";s:37:\"pexels-photo-58461-1-1-1-150x150.jpeg\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:8324;}s:12:\"medium_large\";a:5:{s:4:\"file\";s:37:\"pexels-photo-58461-1-1-1-768x440.jpeg\";s:5:\"width\";i:768;s:6:\"height\";i:440;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:71392;}s:17:\"morenews-featured\";a:5:{s:4:\"file\";s:38:\"pexels-photo-58461-1-1-1-1024x587.jpeg\";s:5:\"width\";i:1024;s:6:\"height\";i:587;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:110828;}s:14:\"morenews-large\";a:5:{s:4:\"file\";s:37:\"pexels-photo-58461-1-1-1-825x575.jpeg\";s:5:\"width\";i:825;s:6:\"height\";i:575;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:93128;}s:15:\"morenews-medium\";a:5:{s:4:\"file\";s:37:\"pexels-photo-58461-1-1-1-590x410.jpeg\";s:5:\"width\";i:590;s:6:\"height\";i:410;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:55986;}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(40, 24, 'wp-smpro-smush-data', 'a:2:{s:5:\"stats\";a:8:{s:7:\"percent\";d:3.195346033654055;s:5:\"bytes\";i:18395;s:11:\"size_before\";i:575681;s:10:\"size_after\";i:557286;s:4:\"time\";d:0.36000000000000004;s:11:\"api_version\";s:3:\"1.0\";s:5:\"lossy\";b:0;s:9:\"keep_exif\";i:0;}s:5:\"sizes\";a:8:{s:9:\"thumbnail\";O:8:\"stdClass\":5:{s:7:\"percent\";d:6.4;s:5:\"bytes\";i:536;s:11:\"size_before\";i:8369;s:10:\"size_after\";i:7833;s:4:\"time\";d:0.01;}s:6:\"medium\";O:8:\"stdClass\":5:{s:7:\"percent\";d:5.15;s:5:\"bytes\";i:808;s:11:\"size_before\";i:15679;s:10:\"size_after\";i:14871;s:4:\"time\";d:0.02;}s:12:\"medium_large\";O:8:\"stdClass\":5:{s:7:\"percent\";d:3.96;s:5:\"bytes\";i:2829;s:11:\"size_before\";i:71464;s:10:\"size_after\";i:68635;s:4:\"time\";d:0.04;}s:5:\"large\";O:8:\"stdClass\":5:{s:7:\"percent\";d:3.48;s:5:\"bytes\";i:3871;s:11:\"size_before\";i:111281;s:10:\"size_after\";i:107410;s:4:\"time\";d:0.07;}s:23:\"covernews-slider-center\";O:8:\"stdClass\":5:{s:7:\"percent\";d:3.84;s:5:\"bytes\";i:5102;s:11:\"size_before\";i:132977;s:10:\"size_after\";i:127875;s:4:\"time\";d:0.04;}s:18:\"covernews-featured\";O:8:\"stdClass\":5:{s:7:\"percent\";d:0.06;s:5:\"bytes\";i:0;s:11:\"size_before\";i:107471;s:10:\"size_after\";i:107410;s:4:\"time\";d:0.12;}s:16:\"covernews-medium\";O:8:\"stdClass\":5:{s:7:\"percent\";d:4.04;s:5:\"bytes\";i:2467;s:11:\"size_before\";i:61086;s:10:\"size_after\";i:58619;s:4:\"time\";d:0.02;}s:23:\"covernews-medium-square\";O:8:\"stdClass\":5:{s:7:\"percent\";d:4.04;s:5:\"bytes\";i:2721;s:11:\"size_before\";i:67354;s:10:\"size_after\";i:64633;s:4:\"time\";d:0.04;}}}'),
(42, 25, '_wp_attached_file', '2018/07/pexels-photo-263210-1-1-1-e1665551739856.jpeg'),
(43, 25, '_wp_attachment_metadata', 'a:6:{s:5:\"width\";i:1920;s:6:\"height\";i:1276;s:4:\"file\";s:53:\"2018/07/pexels-photo-263210-1-1-1-e1665551739856.jpeg\";s:8:\"filesize\";i:169174;s:5:\"sizes\";a:8:{s:6:\"medium\";a:5:{s:4:\"file\";s:53:\"pexels-photo-263210-1-1-1-e1665551739856-300x199.jpeg\";s:5:\"width\";i:300;s:6:\"height\";i:199;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:15829;}s:5:\"large\";a:5:{s:4:\"file\";s:54:\"pexels-photo-263210-1-1-1-e1665551739856-1024x681.jpeg\";s:5:\"width\";i:1024;s:6:\"height\";i:681;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:103101;}s:9:\"thumbnail\";a:5:{s:4:\"file\";s:53:\"pexels-photo-263210-1-1-1-e1665551739856-150x150.jpeg\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:7458;}s:12:\"medium_large\";a:5:{s:4:\"file\";s:53:\"pexels-photo-263210-1-1-1-e1665551739856-768x510.jpeg\";s:5:\"width\";i:768;s:6:\"height\";i:510;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:65026;}s:9:\"1536x1536\";a:5:{s:4:\"file\";s:55:\"pexels-photo-263210-1-1-1-e1665551739856-1536x1021.jpeg\";s:5:\"width\";i:1536;s:6:\"height\";i:1021;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:195970;}s:17:\"morenews-featured\";a:5:{s:4:\"file\";s:54:\"pexels-photo-263210-1-1-1-e1665551739856-1024x681.jpeg\";s:5:\"width\";i:1024;s:6:\"height\";i:681;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:103101;}s:14:\"morenews-large\";a:5:{s:4:\"file\";s:53:\"pexels-photo-263210-1-1-1-e1665551739856-825x575.jpeg\";s:5:\"width\";i:825;s:6:\"height\";i:575;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:76310;}s:15:\"morenews-medium\";a:5:{s:4:\"file\";s:53:\"pexels-photo-263210-1-1-1-e1665551739856-590x410.jpeg\";s:5:\"width\";i:590;s:6:\"height\";i:410;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:45292;}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(44, 25, 'wp-smpro-smush-data', 'a:2:{s:5:\"stats\";a:8:{s:7:\"percent\";d:3.1501306876109685;s:5:\"bytes\";i:24502;s:11:\"size_before\";i:777809;s:10:\"size_after\";i:753307;s:4:\"time\";d:0.4900000000000001;s:11:\"api_version\";s:3:\"1.0\";s:5:\"lossy\";b:0;s:9:\"keep_exif\";i:0;}s:5:\"sizes\";a:9:{s:9:\"thumbnail\";O:8:\"stdClass\":5:{s:7:\"percent\";d:6.7;s:5:\"bytes\";i:525;s:11:\"size_before\";i:7841;s:10:\"size_after\";i:7316;s:4:\"time\";d:0.01;}s:6:\"medium\";O:8:\"stdClass\":5:{s:7:\"percent\";d:5.47;s:5:\"bytes\";i:1017;s:11:\"size_before\";i:18604;s:10:\"size_after\";i:17587;s:4:\"time\";d:0.02;}s:12:\"medium_large\";O:8:\"stdClass\":5:{s:7:\"percent\";d:3.49;s:5:\"bytes\";i:2665;s:11:\"size_before\";i:76356;s:10:\"size_after\";i:73691;s:4:\"time\";d:0.04;}s:5:\"large\";O:8:\"stdClass\":5:{s:7:\"percent\";d:3.4;s:5:\"bytes\";i:4111;s:11:\"size_before\";i:121032;s:10:\"size_after\";i:116921;s:4:\"time\";d:0.03;}s:21:\"covernews-slider-full\";O:8:\"stdClass\":5:{s:7:\"percent\";d:3.73;s:5:\"bytes\";i:7743;s:11:\"size_before\";i:207631;s:10:\"size_after\";i:199888;s:4:\"time\";d:0.11;}s:23:\"covernews-slider-center\";O:8:\"stdClass\":5:{s:7:\"percent\";d:3.52;s:5:\"bytes\";i:4367;s:11:\"size_before\";i:124119;s:10:\"size_after\";i:119752;s:4:\"time\";d:0.09;}s:18:\"covernews-featured\";O:8:\"stdClass\":5:{s:7:\"percent\";d:0.05;s:5:\"bytes\";i:0;s:11:\"size_before\";i:116982;s:10:\"size_after\";i:116921;s:4:\"time\";d:0.08;}s:16:\"covernews-medium\";O:8:\"stdClass\":5:{s:7:\"percent\";d:3.85;s:5:\"bytes\";i:1896;s:11:\"size_before\";i:49296;s:10:\"size_after\";i:47400;s:4:\"time\";d:0.09;}s:23:\"covernews-medium-square\";O:8:\"stdClass\":5:{s:7:\"percent\";d:3.78;s:5:\"bytes\";i:2117;s:11:\"size_before\";i:55948;s:10:\"size_after\";i:53831;s:4:\"time\";d:0.02;}}}'),
(45, 25, '_wp_attachment_backup_sizes', 'a:11:{s:9:\"full-orig\";a:3:{s:5:\"width\";i:1920;s:6:\"height\";i:1503;s:4:\"file\";s:30:\"pexels-photo-263210-1-1-1.jpeg\";}s:14:\"thumbnail-orig\";a:5:{s:4:\"file\";s:38:\"pexels-photo-263210-1-1-1-150x150.jpeg\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:7843;}s:11:\"medium-orig\";a:5:{s:4:\"file\";s:38:\"pexels-photo-263210-1-1-1-300x235.jpeg\";s:5:\"width\";i:300;s:6:\"height\";i:235;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:18593;}s:17:\"medium_large-orig\";a:5:{s:4:\"file\";s:38:\"pexels-photo-263210-1-1-1-768x601.jpeg\";s:5:\"width\";i:768;s:6:\"height\";i:601;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:76348;}s:10:\"large-orig\";a:5:{s:4:\"file\";s:39:\"pexels-photo-263210-1-1-1-1024x802.jpeg\";s:5:\"width\";i:1024;s:6:\"height\";i:802;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:121047;}s:14:\"1536x1536-orig\";a:5:{s:4:\"file\";s:40:\"pexels-photo-263210-1-1-1-1536x1202.jpeg\";s:5:\"width\";i:1536;s:6:\"height\";i:1202;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:237648;}s:26:\"covernews-slider-full-orig\";a:5:{s:4:\"file\";s:39:\"pexels-photo-263210-1-1-1-1115x715.jpeg\";s:5:\"width\";i:1115;s:6:\"height\";i:715;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:118692;}s:28:\"covernews-slider-center-orig\";a:5:{s:4:\"file\";s:38:\"pexels-photo-263210-1-1-1-800x500.jpeg\";s:5:\"width\";i:800;s:6:\"height\";i:500;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:68548;}s:23:\"covernews-featured-orig\";a:5:{s:4:\"file\";s:39:\"pexels-photo-263210-1-1-1-1024x802.jpeg\";s:5:\"width\";i:1024;s:6:\"height\";i:802;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:121047;}s:21:\"covernews-medium-orig\";a:5:{s:4:\"file\";s:38:\"pexels-photo-263210-1-1-1-540x340.jpeg\";s:5:\"width\";i:540;s:6:\"height\";i:340;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:37877;}s:28:\"covernews-medium-square-orig\";a:5:{s:4:\"file\";s:38:\"pexels-photo-263210-1-1-1-400x250.jpeg\";s:5:\"width\";i:400;s:6:\"height\";i:250;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:24062;}}'),
(47, 34, '_wp_attached_file', '2018/07/bar-local-cong-ireland-38286-1-1.jpeg'),
(48, 34, '_wp_attachment_metadata', 'a:6:{s:5:\"width\";i:1920;s:6:\"height\";i:1275;s:4:\"file\";s:45:\"2018/07/bar-local-cong-ireland-38286-1-1.jpeg\";s:8:\"filesize\";i:121901;s:5:\"sizes\";a:8:{s:6:\"medium\";a:5:{s:4:\"file\";s:45:\"bar-local-cong-ireland-38286-1-1-300x199.jpeg\";s:5:\"width\";i:300;s:6:\"height\";i:199;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:13891;}s:5:\"large\";a:5:{s:4:\"file\";s:46:\"bar-local-cong-ireland-38286-1-1-1024x680.jpeg\";s:5:\"width\";i:1024;s:6:\"height\";i:680;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:78299;}s:9:\"thumbnail\";a:5:{s:4:\"file\";s:45:\"bar-local-cong-ireland-38286-1-1-150x150.jpeg\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:6133;}s:12:\"medium_large\";a:5:{s:4:\"file\";s:45:\"bar-local-cong-ireland-38286-1-1-768x510.jpeg\";s:5:\"width\";i:768;s:6:\"height\";i:510;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:52013;}s:9:\"1536x1536\";a:5:{s:4:\"file\";s:47:\"bar-local-cong-ireland-38286-1-1-1536x1020.jpeg\";s:5:\"width\";i:1536;s:6:\"height\";i:1020;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:142302;}s:17:\"morenews-featured\";a:5:{s:4:\"file\";s:46:\"bar-local-cong-ireland-38286-1-1-1024x680.jpeg\";s:5:\"width\";i:1024;s:6:\"height\";i:680;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:78299;}s:14:\"morenews-large\";a:5:{s:4:\"file\";s:45:\"bar-local-cong-ireland-38286-1-1-825x575.jpeg\";s:5:\"width\";i:825;s:6:\"height\";i:575;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:59438;}s:15:\"morenews-medium\";a:5:{s:4:\"file\";s:45:\"bar-local-cong-ireland-38286-1-1-590x410.jpeg\";s:5:\"width\";i:590;s:6:\"height\";i:410;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:36758;}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(49, 34, 'wp-smpro-smush-data', 'a:2:{s:5:\"stats\";a:8:{s:7:\"percent\";d:2.3726060924910364;s:5:\"bytes\";i:12447;s:11:\"size_before\";i:524613;s:10:\"size_after\";i:512166;s:4:\"time\";d:0.35;s:11:\"api_version\";s:3:\"1.0\";s:5:\"lossy\";b:0;s:9:\"keep_exif\";i:0;}s:5:\"sizes\";a:9:{s:9:\"thumbnail\";O:8:\"stdClass\":5:{s:7:\"percent\";d:4.82;s:5:\"bytes\";i:296;s:11:\"size_before\";i:6135;s:10:\"size_after\";i:5839;s:4:\"time\";d:0.03;}s:6:\"medium\";O:8:\"stdClass\":5:{s:7:\"percent\";d:4.74;s:5:\"bytes\";i:660;s:11:\"size_before\";i:13919;s:10:\"size_after\";i:13259;s:4:\"time\";d:0.01;}s:12:\"medium_large\";O:8:\"stdClass\":5:{s:7:\"percent\";d:2.81;s:5:\"bytes\";i:1450;s:11:\"size_before\";i:51547;s:10:\"size_after\";i:50097;s:4:\"time\";d:0.02;}s:5:\"large\";O:8:\"stdClass\":5:{s:7:\"percent\";d:2.27;s:5:\"bytes\";i:1734;s:11:\"size_before\";i:76534;s:10:\"size_after\";i:74800;s:4:\"time\";d:0.06;}s:21:\"covernews-slider-full\";O:8:\"stdClass\":5:{s:7:\"percent\";d:2.45;s:5:\"bytes\";i:3378;s:11:\"size_before\";i:137666;s:10:\"size_after\";i:134288;s:4:\"time\";d:0.08;}s:23:\"covernews-slider-center\";O:8:\"stdClass\":5:{s:7:\"percent\";d:2.99;s:5:\"bytes\";i:2390;s:11:\"size_before\";i:80007;s:10:\"size_after\";i:77617;s:4:\"time\";d:0.03;}s:18:\"covernews-featured\";O:8:\"stdClass\":5:{s:7:\"percent\";d:0.08;s:5:\"bytes\";i:0;s:11:\"size_before\";i:74861;s:10:\"size_after\";i:74800;s:4:\"time\";d:0.03;}s:16:\"covernews-medium\";O:8:\"stdClass\":5:{s:7:\"percent\";d:3.17;s:5:\"bytes\";i:1289;s:11:\"size_before\";i:40711;s:10:\"size_after\";i:39422;s:4:\"time\";d:0.06;}s:23:\"covernews-medium-square\";O:8:\"stdClass\":5:{s:7:\"percent\";d:2.75;s:5:\"bytes\";i:1189;s:11:\"size_before\";i:43233;s:10:\"size_after\";i:42044;s:4:\"time\";d:0.03;}}}'),
(51, 44, '_menu_item_type', 'custom'),
(52, 44, '_menu_item_object_id', '44'),
(53, 44, '_menu_item_object', 'custom'),
(54, 44, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(55, 44, '_menu_item_url', 'https://facebook.com/afthemes'),
(56, 45, '_menu_item_type', 'custom'),
(57, 45, '_menu_item_object_id', '45'),
(58, 45, '_menu_item_object', 'custom'),
(59, 45, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(60, 45, '_menu_item_url', 'https://twitter.com/afthemes'),
(61, 217, '_wp_attached_file', '2018/07/snow-winter-architecture-structure-building-city-101684-pxhere.com_.jpg'),
(62, 217, '_wp_attachment_metadata', 'a:6:{s:5:\"width\";i:1280;s:6:\"height\";i:850;s:4:\"file\";s:79:\"2018/07/snow-winter-architecture-structure-building-city-101684-pxhere.com_.jpg\";s:8:\"filesize\";i:117829;s:5:\"sizes\";a:7:{s:6:\"medium\";a:5:{s:4:\"file\";s:79:\"snow-winter-architecture-structure-building-city-101684-pxhere.com_-300x199.jpg\";s:5:\"width\";i:300;s:6:\"height\";i:199;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:14989;}s:5:\"large\";a:5:{s:4:\"file\";s:80:\"snow-winter-architecture-structure-building-city-101684-pxhere.com_-1024x680.jpg\";s:5:\"width\";i:1024;s:6:\"height\";i:680;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:117229;}s:9:\"thumbnail\";a:5:{s:4:\"file\";s:79:\"snow-winter-architecture-structure-building-city-101684-pxhere.com_-150x150.jpg\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:7031;}s:12:\"medium_large\";a:5:{s:4:\"file\";s:79:\"snow-winter-architecture-structure-building-city-101684-pxhere.com_-768x510.jpg\";s:5:\"width\";i:768;s:6:\"height\";i:510;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:73515;}s:17:\"morenews-featured\";a:5:{s:4:\"file\";s:80:\"snow-winter-architecture-structure-building-city-101684-pxhere.com_-1024x680.jpg\";s:5:\"width\";i:1024;s:6:\"height\";i:680;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:117229;}s:14:\"morenews-large\";a:5:{s:4:\"file\";s:79:\"snow-winter-architecture-structure-building-city-101684-pxhere.com_-825x575.jpg\";s:5:\"width\";i:825;s:6:\"height\";i:575;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:85982;}s:15:\"morenews-medium\";a:5:{s:4:\"file\";s:79:\"snow-winter-architecture-structure-building-city-101684-pxhere.com_-590x410.jpg\";s:5:\"width\";i:590;s:6:\"height\";i:410;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:48862;}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(63, 217, 'wp-smpro-smush-data', 'a:2:{s:5:\"stats\";a:8:{s:7:\"percent\";d:2.8809664453999364;s:5:\"bytes\";i:16436;s:11:\"size_before\";i:570503;s:10:\"size_after\";i:554067;s:4:\"time\";d:0.26;s:11:\"api_version\";s:3:\"1.0\";s:5:\"lossy\";b:0;s:9:\"keep_exif\";b:1;}s:5:\"sizes\";a:8:{s:6:\"medium\";O:8:\"stdClass\":5:{s:7:\"percent\";d:3.7;s:5:\"bytes\";i:551;s:11:\"size_before\";i:14897;s:10:\"size_after\";i:14346;s:4:\"time\";d:0.01;}s:5:\"large\";O:8:\"stdClass\":5:{s:7:\"percent\";d:3.63;s:5:\"bytes\";i:4191;s:11:\"size_before\";i:115368;s:10:\"size_after\";i:111177;s:4:\"time\";d:0.09;}s:9:\"thumbnail\";O:8:\"stdClass\":5:{s:7:\"percent\";d:4.64;s:5:\"bytes\";i:325;s:11:\"size_before\";i:7003;s:10:\"size_after\";i:6678;s:4:\"time\";d:0.01;}s:12:\"medium_large\";O:8:\"stdClass\":5:{s:7:\"percent\";d:3.48;s:5:\"bytes\";i:2527;s:11:\"size_before\";i:72511;s:10:\"size_after\";i:69984;s:4:\"time\";d:0.02;}s:23:\"covernews-slider-center\";O:8:\"stdClass\":5:{s:7:\"percent\";d:3.68;s:5:\"bytes\";i:5179;s:11:\"size_before\";i:140802;s:10:\"size_after\";i:135623;s:4:\"time\";d:0.05;}s:18:\"covernews-featured\";O:8:\"stdClass\":5:{s:7:\"percent\";i:0;s:5:\"bytes\";i:0;s:11:\"size_before\";i:111177;s:10:\"size_after\";i:111177;s:4:\"time\";d:0.04;}s:16:\"covernews-medium\";O:8:\"stdClass\":5:{s:7:\"percent\";d:3.34;s:5:\"bytes\";i:1664;s:11:\"size_before\";i:49858;s:10:\"size_after\";i:48194;s:4:\"time\";d:0.02;}s:23:\"covernews-medium-square\";O:8:\"stdClass\":5:{s:7:\"percent\";d:3.39;s:5:\"bytes\";i:1999;s:11:\"size_before\";i:58887;s:10:\"size_after\";i:56888;s:4:\"time\";d:0.02;}}}'),
(65, 219, '_wp_attached_file', '2018/07/person-military-soldier-army-profession-navy-64969-pxhere.com_.jpg'),
(66, 219, '_wp_attachment_metadata', 'a:6:{s:5:\"width\";i:1280;s:6:\"height\";i:848;s:4:\"file\";s:74:\"2018/07/person-military-soldier-army-profession-navy-64969-pxhere.com_.jpg\";s:8:\"filesize\";i:96841;s:5:\"sizes\";a:7:{s:6:\"medium\";a:5:{s:4:\"file\";s:74:\"person-military-soldier-army-profession-navy-64969-pxhere.com_-300x199.jpg\";s:5:\"width\";i:300;s:6:\"height\";i:199;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:13350;}s:5:\"large\";a:5:{s:4:\"file\";s:75:\"person-military-soldier-army-profession-navy-64969-pxhere.com_-1024x678.jpg\";s:5:\"width\";i:1024;s:6:\"height\";i:678;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:102986;}s:9:\"thumbnail\";a:5:{s:4:\"file\";s:74:\"person-military-soldier-army-profession-navy-64969-pxhere.com_-150x150.jpg\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:6349;}s:12:\"medium_large\";a:5:{s:4:\"file\";s:74:\"person-military-soldier-army-profession-navy-64969-pxhere.com_-768x509.jpg\";s:5:\"width\";i:768;s:6:\"height\";i:509;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:64534;}s:17:\"morenews-featured\";a:5:{s:4:\"file\";s:75:\"person-military-soldier-army-profession-navy-64969-pxhere.com_-1024x678.jpg\";s:5:\"width\";i:1024;s:6:\"height\";i:678;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:102986;}s:14:\"morenews-large\";a:5:{s:4:\"file\";s:74:\"person-military-soldier-army-profession-navy-64969-pxhere.com_-825x575.jpg\";s:5:\"width\";i:825;s:6:\"height\";i:575;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:75509;}s:15:\"morenews-medium\";a:5:{s:4:\"file\";s:74:\"person-military-soldier-army-profession-navy-64969-pxhere.com_-590x410.jpg\";s:5:\"width\";i:590;s:6:\"height\";i:410;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:43565;}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(67, 219, 'wp-smpro-smush-data', 'a:2:{s:5:\"stats\";a:8:{s:7:\"percent\";d:2.6864358464995255;s:5:\"bytes\";i:13618;s:11:\"size_before\";i:506917;s:10:\"size_after\";i:493299;s:4:\"time\";d:0.29000000000000004;s:11:\"api_version\";s:3:\"1.0\";s:5:\"lossy\";b:0;s:9:\"keep_exif\";b:1;}s:5:\"sizes\";a:8:{s:6:\"medium\";O:8:\"stdClass\":5:{s:7:\"percent\";d:3.63;s:5:\"bytes\";i:482;s:11:\"size_before\";i:13294;s:10:\"size_after\";i:12812;s:4:\"time\";d:0.01;}s:5:\"large\";O:8:\"stdClass\":5:{s:7:\"percent\";d:3.19;s:5:\"bytes\";i:3256;s:11:\"size_before\";i:102150;s:10:\"size_after\";i:98894;s:4:\"time\";d:0.04;}s:9:\"thumbnail\";O:8:\"stdClass\":5:{s:7:\"percent\";d:4.61;s:5:\"bytes\";i:293;s:11:\"size_before\";i:6351;s:10:\"size_after\";i:6058;s:4:\"time\";d:0.01;}s:12:\"medium_large\";O:8:\"stdClass\":5:{s:7:\"percent\";d:3.25;s:5:\"bytes\";i:2077;s:11:\"size_before\";i:63867;s:10:\"size_after\";i:61790;s:4:\"time\";d:0.05;}s:23:\"covernews-slider-center\";O:8:\"stdClass\":5:{s:7:\"percent\";d:3.36;s:5:\"bytes\";i:4035;s:11:\"size_before\";i:120199;s:10:\"size_after\";i:116164;s:4:\"time\";d:0.04;}s:18:\"covernews-featured\";O:8:\"stdClass\":5:{s:7:\"percent\";i:0;s:5:\"bytes\";i:0;s:11:\"size_before\";i:98894;s:10:\"size_after\";i:98894;s:4:\"time\";d:0.07;}s:16:\"covernews-medium\";O:8:\"stdClass\":5:{s:7:\"percent\";d:3.45;s:5:\"bytes\";i:1711;s:11:\"size_before\";i:49634;s:10:\"size_after\";i:47923;s:4:\"time\";d:0.04;}s:23:\"covernews-medium-square\";O:8:\"stdClass\":5:{s:7:\"percent\";d:3.36;s:5:\"bytes\";i:1764;s:11:\"size_before\";i:52528;s:10:\"size_after\";i:50764;s:4:\"time\";d:0.03;}}}'),
(69, 220, '_wp_attached_file', '2018/07/man-person-usa-america-profession-washington-826138-pxhere.com_.jpg'),
(70, 220, '_wp_attachment_metadata', 'a:6:{s:5:\"width\";i:1280;s:6:\"height\";i:851;s:4:\"file\";s:75:\"2018/07/man-person-usa-america-profession-washington-826138-pxhere.com_.jpg\";s:8:\"filesize\";i:54753;s:5:\"sizes\";a:7:{s:6:\"medium\";a:5:{s:4:\"file\";s:75:\"man-person-usa-america-profession-washington-826138-pxhere.com_-300x199.jpg\";s:5:\"width\";i:300;s:6:\"height\";i:199;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:11387;}s:5:\"large\";a:5:{s:4:\"file\";s:76:\"man-person-usa-america-profession-washington-826138-pxhere.com_-1024x681.jpg\";s:5:\"width\";i:1024;s:6:\"height\";i:681;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:64176;}s:9:\"thumbnail\";a:5:{s:4:\"file\";s:75:\"man-person-usa-america-profession-washington-826138-pxhere.com_-150x150.jpg\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:6169;}s:12:\"medium_large\";a:5:{s:4:\"file\";s:75:\"man-person-usa-america-profession-washington-826138-pxhere.com_-768x511.jpg\";s:5:\"width\";i:768;s:6:\"height\";i:511;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:41791;}s:17:\"morenews-featured\";a:5:{s:4:\"file\";s:76:\"man-person-usa-america-profession-washington-826138-pxhere.com_-1024x681.jpg\";s:5:\"width\";i:1024;s:6:\"height\";i:681;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:64176;}s:14:\"morenews-large\";a:5:{s:4:\"file\";s:75:\"man-person-usa-america-profession-washington-826138-pxhere.com_-825x575.jpg\";s:5:\"width\";i:825;s:6:\"height\";i:575;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:48801;}s:15:\"morenews-medium\";a:5:{s:4:\"file\";s:75:\"man-person-usa-america-profession-washington-826138-pxhere.com_-590x410.jpg\";s:5:\"width\";i:590;s:6:\"height\";i:410;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:29568;}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(71, 220, 'wp-smpro-smush-data', 'a:2:{s:5:\"stats\";a:8:{s:7:\"percent\";d:1.3561451481782572;s:5:\"bytes\";i:4404;s:11:\"size_before\";i:324744;s:10:\"size_after\";i:320340;s:4:\"time\";d:0.25;s:11:\"api_version\";s:3:\"1.0\";s:5:\"lossy\";b:0;s:9:\"keep_exif\";b:1;}s:5:\"sizes\";a:8:{s:6:\"medium\";O:8:\"stdClass\":5:{s:7:\"percent\";d:3.44;s:5:\"bytes\";i:391;s:11:\"size_before\";i:11361;s:10:\"size_after\";i:10970;s:4:\"time\";d:0.01;}s:5:\"large\";O:8:\"stdClass\":5:{s:7:\"percent\";d:1.16;s:5:\"bytes\";i:719;s:11:\"size_before\";i:62195;s:10:\"size_after\";i:61476;s:4:\"time\";d:0.02;}s:9:\"thumbnail\";O:8:\"stdClass\":5:{s:7:\"percent\";d:4.95;s:5:\"bytes\";i:305;s:11:\"size_before\";i:6164;s:10:\"size_after\";i:5859;s:4:\"time\";d:0.02;}s:12:\"medium_large\";O:8:\"stdClass\":5:{s:7:\"percent\";d:1.38;s:5:\"bytes\";i:559;s:11:\"size_before\";i:40588;s:10:\"size_after\";i:40029;s:4:\"time\";d:0.01;}s:23:\"covernews-slider-center\";O:8:\"stdClass\":5:{s:7:\"percent\";d:1.66;s:5:\"bytes\";i:1314;s:11:\"size_before\";i:78996;s:10:\"size_after\";i:77682;s:4:\"time\";d:0.08;}s:18:\"covernews-featured\";O:8:\"stdClass\":5:{s:7:\"percent\";i:0;s:5:\"bytes\";i:0;s:11:\"size_before\";i:61476;s:10:\"size_after\";i:61476;s:4:\"time\";d:0.07;}s:16:\"covernews-medium\";O:8:\"stdClass\":5:{s:7:\"percent\";d:1.91;s:5:\"bytes\";i:568;s:11:\"size_before\";i:29728;s:10:\"size_after\";i:29160;s:4:\"time\";d:0.02;}s:23:\"covernews-medium-square\";O:8:\"stdClass\":5:{s:7:\"percent\";d:1.6;s:5:\"bytes\";i:548;s:11:\"size_before\";i:34236;s:10:\"size_after\";i:33688;s:4:\"time\";d:0.02;}}}'),
(73, 222, '_wp_attached_file', '2018/07/study-graduation-academic-dress-scholar-mortarboard-event-1626645-pxhere.com_.jpg');
INSERT INTO `wp_postmeta` (`meta_id`, `post_id`, `meta_key`, `meta_value`) VALUES
(74, 222, '_wp_attachment_metadata', 'a:6:{s:5:\"width\";i:1280;s:6:\"height\";i:853;s:4:\"file\";s:89:\"2018/07/study-graduation-academic-dress-scholar-mortarboard-event-1626645-pxhere.com_.jpg\";s:8:\"filesize\";i:67584;s:5:\"sizes\";a:7:{s:6:\"medium\";a:5:{s:4:\"file\";s:89:\"study-graduation-academic-dress-scholar-mortarboard-event-1626645-pxhere.com_-300x200.jpg\";s:5:\"width\";i:300;s:6:\"height\";i:200;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:13156;}s:5:\"large\";a:5:{s:4:\"file\";s:90:\"study-graduation-academic-dress-scholar-mortarboard-event-1626645-pxhere.com_-1024x682.jpg\";s:5:\"width\";i:1024;s:6:\"height\";i:682;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:75945;}s:9:\"thumbnail\";a:5:{s:4:\"file\";s:89:\"study-graduation-academic-dress-scholar-mortarboard-event-1626645-pxhere.com_-150x150.jpg\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:6948;}s:12:\"medium_large\";a:5:{s:4:\"file\";s:89:\"study-graduation-academic-dress-scholar-mortarboard-event-1626645-pxhere.com_-768x512.jpg\";s:5:\"width\";i:768;s:6:\"height\";i:512;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:50006;}s:17:\"morenews-featured\";a:5:{s:4:\"file\";s:90:\"study-graduation-academic-dress-scholar-mortarboard-event-1626645-pxhere.com_-1024x682.jpg\";s:5:\"width\";i:1024;s:6:\"height\";i:682;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:75945;}s:14:\"morenews-large\";a:5:{s:4:\"file\";s:89:\"study-graduation-academic-dress-scholar-mortarboard-event-1626645-pxhere.com_-825x575.jpg\";s:5:\"width\";i:825;s:6:\"height\";i:575;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:57801;}s:15:\"morenews-medium\";a:5:{s:4:\"file\";s:89:\"study-graduation-academic-dress-scholar-mortarboard-event-1626645-pxhere.com_-590x410.jpg\";s:5:\"width\";i:590;s:6:\"height\";i:410;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:35566;}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(75, 222, 'wp-smpro-smush-data', 'a:2:{s:5:\"stats\";a:8:{s:7:\"percent\";d:2.217310340914367;s:5:\"bytes\";i:8597;s:11:\"size_before\";i:387722;s:10:\"size_after\";i:379125;s:4:\"time\";d:0.3;s:11:\"api_version\";s:3:\"1.0\";s:5:\"lossy\";b:0;s:9:\"keep_exif\";b:1;}s:5:\"sizes\";a:8:{s:6:\"medium\";O:8:\"stdClass\":5:{s:7:\"percent\";d:4.18;s:5:\"bytes\";i:549;s:11:\"size_before\";i:13140;s:10:\"size_after\";i:12591;s:4:\"time\";d:0.02;}s:5:\"large\";O:8:\"stdClass\":5:{s:7:\"percent\";d:2.23;s:5:\"bytes\";i:1660;s:11:\"size_before\";i:74429;s:10:\"size_after\";i:72769;s:4:\"time\";d:0.09;}s:9:\"thumbnail\";O:8:\"stdClass\":5:{s:7:\"percent\";d:5.49;s:5:\"bytes\";i:382;s:11:\"size_before\";i:6953;s:10:\"size_after\";i:6571;s:4:\"time\";d:0.03;}s:12:\"medium_large\";O:8:\"stdClass\":5:{s:7:\"percent\";d:2.45;s:5:\"bytes\";i:1208;s:11:\"size_before\";i:49208;s:10:\"size_after\";i:48000;s:4:\"time\";d:0.02;}s:23:\"covernews-slider-center\";O:8:\"stdClass\":5:{s:7:\"percent\";d:2.81;s:5:\"bytes\";i:2531;s:11:\"size_before\";i:90062;s:10:\"size_after\";i:87531;s:4:\"time\";d:0.04;}s:18:\"covernews-featured\";O:8:\"stdClass\":5:{s:7:\"percent\";i:0;s:5:\"bytes\";i:0;s:11:\"size_before\";i:72769;s:10:\"size_after\";i:72769;s:4:\"time\";d:0.03;}s:16:\"covernews-medium\";O:8:\"stdClass\":5:{s:7:\"percent\";d:3.01;s:5:\"bytes\";i:1200;s:11:\"size_before\";i:39901;s:10:\"size_after\";i:38701;s:4:\"time\";d:0.02;}s:23:\"covernews-medium-square\";O:8:\"stdClass\":5:{s:7:\"percent\";d:2.59;s:5:\"bytes\";i:1067;s:11:\"size_before\";i:41260;s:10:\"size_after\";i:40193;s:4:\"time\";d:0.05;}}}'),
(77, 279, '_wp_attached_file', '2018/04/beard-2286446_1920-1.jpg'),
(78, 279, '_wp_attachment_metadata', 'a:6:{s:5:\"width\";i:1920;s:6:\"height\";i:1281;s:4:\"file\";s:32:\"2018/04/beard-2286446_1920-1.jpg\";s:8:\"filesize\";i:146740;s:5:\"sizes\";a:8:{s:6:\"medium\";a:5:{s:4:\"file\";s:32:\"beard-2286446_1920-1-300x200.jpg\";s:5:\"width\";i:300;s:6:\"height\";i:200;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:11154;}s:5:\"large\";a:5:{s:4:\"file\";s:33:\"beard-2286446_1920-1-1024x683.jpg\";s:5:\"width\";i:1024;s:6:\"height\";i:683;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:77931;}s:9:\"thumbnail\";a:5:{s:4:\"file\";s:32:\"beard-2286446_1920-1-150x150.jpg\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:6118;}s:12:\"medium_large\";a:5:{s:4:\"file\";s:32:\"beard-2286446_1920-1-768x512.jpg\";s:5:\"width\";i:768;s:6:\"height\";i:512;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:47602;}s:9:\"1536x1536\";a:5:{s:4:\"file\";s:34:\"beard-2286446_1920-1-1536x1025.jpg\";s:5:\"width\";i:1536;s:6:\"height\";i:1025;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:154498;}s:17:\"morenews-featured\";a:5:{s:4:\"file\";s:33:\"beard-2286446_1920-1-1024x683.jpg\";s:5:\"width\";i:1024;s:6:\"height\";i:683;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:77931;}s:14:\"morenews-large\";a:5:{s:4:\"file\";s:32:\"beard-2286446_1920-1-825x575.jpg\";s:5:\"width\";i:825;s:6:\"height\";i:575;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:56822;}s:15:\"morenews-medium\";a:5:{s:4:\"file\";s:32:\"beard-2286446_1920-1-590x410.jpg\";s:5:\"width\";i:590;s:6:\"height\";i:410;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:32439;}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:3:\"2.5\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:10:\"NIKON D810\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:2:\"50\";s:3:\"iso\";s:3:\"125\";s:13:\"shutter_speed\";s:5:\"0.005\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(79, 279, 'wp-smpro-smush-data', 'a:2:{s:5:\"stats\";a:8:{s:7:\"percent\";d:2.8800996183022765;s:5:\"bytes\";i:15589;s:11:\"size_before\";i:541266;s:10:\"size_after\";i:525677;s:4:\"time\";d:0.37999999999999995;s:11:\"api_version\";s:3:\"1.0\";s:5:\"lossy\";b:0;s:9:\"keep_exif\";b:1;}s:5:\"sizes\";a:9:{s:9:\"thumbnail\";O:8:\"stdClass\":5:{s:7:\"percent\";d:4.73;s:5:\"bytes\";i:288;s:11:\"size_before\";i:6091;s:10:\"size_after\";i:5803;s:4:\"time\";d:0.01;}s:6:\"medium\";O:8:\"stdClass\":5:{s:7:\"percent\";d:3.68;s:5:\"bytes\";i:408;s:11:\"size_before\";i:11102;s:10:\"size_after\";i:10694;s:4:\"time\";d:0.02;}s:12:\"medium_large\";O:8:\"stdClass\":5:{s:7:\"percent\";d:3.07;s:5:\"bytes\";i:1437;s:11:\"size_before\";i:46819;s:10:\"size_after\";i:45382;s:4:\"time\";d:0.02;}s:5:\"large\";O:8:\"stdClass\":5:{s:7:\"percent\";d:3.14;s:5:\"bytes\";i:2375;s:11:\"size_before\";i:75616;s:10:\"size_after\";i:73241;s:4:\"time\";d:0.06;}s:21:\"covernews-slider-full\";O:8:\"stdClass\":5:{s:7:\"percent\";d:3.5;s:5:\"bytes\";i:5266;s:11:\"size_before\";i:150552;s:10:\"size_after\";i:145286;s:4:\"time\";d:0.05;}s:23:\"covernews-slider-center\";O:8:\"stdClass\":5:{s:7:\"percent\";d:3.44;s:5:\"bytes\";i:3585;s:11:\"size_before\";i:104086;s:10:\"size_after\";i:100501;s:4:\"time\";d:0.07;}s:18:\"covernews-featured\";O:8:\"stdClass\":5:{s:7:\"percent\";i:0;s:5:\"bytes\";i:0;s:11:\"size_before\";i:73241;s:10:\"size_after\";i:73241;s:4:\"time\";d:0.08;}s:16:\"covernews-medium\";O:8:\"stdClass\":5:{s:7:\"percent\";d:3.08;s:5:\"bytes\";i:1094;s:11:\"size_before\";i:35556;s:10:\"size_after\";i:34462;s:4:\"time\";d:0.03;}s:23:\"covernews-medium-square\";O:8:\"stdClass\":5:{s:7:\"percent\";d:2.97;s:5:\"bytes\";i:1136;s:11:\"size_before\";i:38203;s:10:\"size_after\";i:37067;s:4:\"time\";d:0.04;}}}'),
(80, 299, '_menu_item_type', 'custom'),
(81, 299, '_menu_item_object_id', '299'),
(82, 299, '_menu_item_object', 'custom'),
(83, 299, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(84, 299, '_menu_item_url', 'https://instagram.com/afthemes'),
(85, 299, '_wxr_import_user_slug', 'wpafthemes@gmail.com'),
(86, 432, '_wp_attached_file', '2018/07/flower-military-pattern-soldier-army-red-672477-pxhere.com_-1.jpg'),
(87, 432, '_wp_attachment_metadata', 'a:6:{s:5:\"width\";i:1280;s:6:\"height\";i:854;s:4:\"file\";s:73:\"2018/07/flower-military-pattern-soldier-army-red-672477-pxhere.com_-1.jpg\";s:8:\"filesize\";i:131501;s:5:\"sizes\";a:7:{s:6:\"medium\";a:5:{s:4:\"file\";s:73:\"flower-military-pattern-soldier-army-red-672477-pxhere.com_-1-300x200.jpg\";s:5:\"width\";i:300;s:6:\"height\";i:200;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:21919;}s:5:\"large\";a:5:{s:4:\"file\";s:74:\"flower-military-pattern-soldier-army-red-672477-pxhere.com_-1-1024x683.jpg\";s:5:\"width\";i:1024;s:6:\"height\";i:683;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:141293;}s:9:\"thumbnail\";a:5:{s:4:\"file\";s:73:\"flower-military-pattern-soldier-army-red-672477-pxhere.com_-1-150x150.jpg\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:10528;}s:12:\"medium_large\";a:5:{s:4:\"file\";s:73:\"flower-military-pattern-soldier-army-red-672477-pxhere.com_-1-768x512.jpg\";s:5:\"width\";i:768;s:6:\"height\";i:512;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:93121;}s:17:\"morenews-featured\";a:5:{s:4:\"file\";s:74:\"flower-military-pattern-soldier-army-red-672477-pxhere.com_-1-1024x683.jpg\";s:5:\"width\";i:1024;s:6:\"height\";i:683;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:141293;}s:14:\"morenews-large\";a:5:{s:4:\"file\";s:73:\"flower-military-pattern-soldier-army-red-672477-pxhere.com_-1-825x575.jpg\";s:5:\"width\";i:825;s:6:\"height\";i:575;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:108945;}s:15:\"morenews-medium\";a:5:{s:4:\"file\";s:73:\"flower-military-pattern-soldier-army-red-672477-pxhere.com_-1-590x410.jpg\";s:5:\"width\";i:590;s:6:\"height\";i:410;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:66193;}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(88, 439, '_wp_attached_file', '2018/07/water-light-architecture-sky-bridge-skyline-661635-pxhere.com_-1.jpg'),
(89, 439, '_wp_attachment_metadata', 'a:6:{s:5:\"width\";i:1280;s:6:\"height\";i:850;s:4:\"file\";s:76:\"2018/07/water-light-architecture-sky-bridge-skyline-661635-pxhere.com_-1.jpg\";s:8:\"filesize\";i:60235;s:5:\"sizes\";a:7:{s:6:\"medium\";a:5:{s:4:\"file\";s:76:\"water-light-architecture-sky-bridge-skyline-661635-pxhere.com_-1-300x199.jpg\";s:5:\"width\";i:300;s:6:\"height\";i:199;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:8917;}s:5:\"large\";a:5:{s:4:\"file\";s:77:\"water-light-architecture-sky-bridge-skyline-661635-pxhere.com_-1-1024x680.jpg\";s:5:\"width\";i:1024;s:6:\"height\";i:680;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:63682;}s:9:\"thumbnail\";a:5:{s:4:\"file\";s:76:\"water-light-architecture-sky-bridge-skyline-661635-pxhere.com_-1-150x150.jpg\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:4052;}s:12:\"medium_large\";a:5:{s:4:\"file\";s:76:\"water-light-architecture-sky-bridge-skyline-661635-pxhere.com_-1-768x510.jpg\";s:5:\"width\";i:768;s:6:\"height\";i:510;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:40403;}s:17:\"morenews-featured\";a:5:{s:4:\"file\";s:77:\"water-light-architecture-sky-bridge-skyline-661635-pxhere.com_-1-1024x680.jpg\";s:5:\"width\";i:1024;s:6:\"height\";i:680;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:63682;}s:14:\"morenews-large\";a:5:{s:4:\"file\";s:76:\"water-light-architecture-sky-bridge-skyline-661635-pxhere.com_-1-825x575.jpg\";s:5:\"width\";i:825;s:6:\"height\";i:575;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:47294;}s:15:\"morenews-medium\";a:5:{s:4:\"file\";s:76:\"water-light-architecture-sky-bridge-skyline-661635-pxhere.com_-1-590x410.jpg\";s:5:\"width\";i:590;s:6:\"height\";i:410;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:27417;}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(90, 443, '_wp_attached_file', '2018/07/light-girl-sun-woman-formation-cave-42727-pxhere.com_-1.jpg'),
(91, 443, '_wp_attachment_metadata', 'a:6:{s:5:\"width\";i:1280;s:6:\"height\";i:855;s:4:\"file\";s:67:\"2018/07/light-girl-sun-woman-formation-cave-42727-pxhere.com_-1.jpg\";s:8:\"filesize\";i:119572;s:5:\"sizes\";a:7:{s:6:\"medium\";a:5:{s:4:\"file\";s:67:\"light-girl-sun-woman-formation-cave-42727-pxhere.com_-1-300x200.jpg\";s:5:\"width\";i:300;s:6:\"height\";i:200;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:14684;}s:5:\"large\";a:5:{s:4:\"file\";s:68:\"light-girl-sun-woman-formation-cave-42727-pxhere.com_-1-1024x684.jpg\";s:5:\"width\";i:1024;s:6:\"height\";i:684;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:123629;}s:9:\"thumbnail\";a:5:{s:4:\"file\";s:67:\"light-girl-sun-woman-formation-cave-42727-pxhere.com_-1-150x150.jpg\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:7096;}s:12:\"medium_large\";a:5:{s:4:\"file\";s:67:\"light-girl-sun-woman-formation-cave-42727-pxhere.com_-1-768x513.jpg\";s:5:\"width\";i:768;s:6:\"height\";i:513;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:76862;}s:17:\"morenews-featured\";a:5:{s:4:\"file\";s:68:\"light-girl-sun-woman-formation-cave-42727-pxhere.com_-1-1024x684.jpg\";s:5:\"width\";i:1024;s:6:\"height\";i:684;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:123629;}s:14:\"morenews-large\";a:5:{s:4:\"file\";s:67:\"light-girl-sun-woman-formation-cave-42727-pxhere.com_-1-825x575.jpg\";s:5:\"width\";i:825;s:6:\"height\";i:575;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:89690;}s:15:\"morenews-medium\";a:5:{s:4:\"file\";s:67:\"light-girl-sun-woman-formation-cave-42727-pxhere.com_-1-590x410.jpg\";s:5:\"width\";i:590;s:6:\"height\";i:410;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:50447;}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(92, 768, '_wp_attached_file', '2021/05/af-themes-logo-1-150x150-1.png'),
(93, 768, '_wp_attachment_metadata', 'a:6:{s:5:\"width\";i:150;s:6:\"height\";i:150;s:4:\"file\";s:38:\"2021/05/af-themes-logo-1-150x150-1.png\";s:8:\"filesize\";i:5648;s:5:\"sizes\";a:0:{}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(94, 795, '_wp_attached_file', '2021/05/banner-promo-full-blue-revised.png'),
(95, 795, '_wp_attachment_metadata', 'a:6:{s:5:\"width\";i:930;s:6:\"height\";i:110;s:4:\"file\";s:42:\"2021/05/banner-promo-full-blue-revised.png\";s:8:\"filesize\";i:40644;s:5:\"sizes\";a:5:{s:6:\"medium\";a:5:{s:4:\"file\";s:41:\"banner-promo-full-blue-revised-300x35.png\";s:5:\"width\";i:300;s:6:\"height\";i:35;s:9:\"mime-type\";s:9:\"image/png\";s:8:\"filesize\";i:12853;}s:9:\"thumbnail\";a:5:{s:4:\"file\";s:42:\"banner-promo-full-blue-revised-150x110.png\";s:5:\"width\";i:150;s:6:\"height\";i:110;s:9:\"mime-type\";s:9:\"image/png\";s:8:\"filesize\";i:7923;}s:12:\"medium_large\";a:5:{s:4:\"file\";s:41:\"banner-promo-full-blue-revised-768x91.png\";s:5:\"width\";i:768;s:6:\"height\";i:91;s:9:\"mime-type\";s:9:\"image/png\";s:8:\"filesize\";i:49179;}s:14:\"morenews-large\";a:5:{s:4:\"file\";s:42:\"banner-promo-full-blue-revised-825x110.png\";s:5:\"width\";i:825;s:6:\"height\";i:110;s:9:\"mime-type\";s:9:\"image/png\";s:8:\"filesize\";i:42411;}s:15:\"morenews-medium\";a:5:{s:4:\"file\";s:42:\"banner-promo-full-blue-revised-590x110.png\";s:5:\"width\";i:590;s:6:\"height\";i:110;s:9:\"mime-type\";s:9:\"image/png\";s:8:\"filesize\";i:30808;}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(96, 994, '_wp_attached_file', '2018/07/cropped-flower-military-pattern-soldier-army-red-672477-pxhere.com_-1.jpg'),
(97, 994, '_wp_attachment_metadata', 'a:6:{s:5:\"width\";i:1500;s:6:\"height\";i:399;s:4:\"file\";s:81:\"2018/07/cropped-flower-military-pattern-soldier-army-red-672477-pxhere.com_-1.jpg\";s:8:\"filesize\";i:99422;s:5:\"sizes\";a:7:{s:6:\"medium\";a:5:{s:4:\"file\";s:80:\"cropped-flower-military-pattern-soldier-army-red-672477-pxhere.com_-1-300x80.jpg\";s:5:\"width\";i:300;s:6:\"height\";i:80;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:9111;}s:5:\"large\";a:5:{s:4:\"file\";s:82:\"cropped-flower-military-pattern-soldier-army-red-672477-pxhere.com_-1-1024x272.jpg\";s:5:\"width\";i:1024;s:6:\"height\";i:272;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:55743;}s:9:\"thumbnail\";a:5:{s:4:\"file\";s:81:\"cropped-flower-military-pattern-soldier-army-red-672477-pxhere.com_-1-150x150.jpg\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:8215;}s:12:\"medium_large\";a:5:{s:4:\"file\";s:81:\"cropped-flower-military-pattern-soldier-army-red-672477-pxhere.com_-1-768x204.jpg\";s:5:\"width\";i:768;s:6:\"height\";i:204;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:37375;}s:17:\"morenews-featured\";a:5:{s:4:\"file\";s:82:\"cropped-flower-military-pattern-soldier-army-red-672477-pxhere.com_-1-1024x272.jpg\";s:5:\"width\";i:1024;s:6:\"height\";i:272;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:55743;}s:14:\"morenews-large\";a:5:{s:4:\"file\";s:81:\"cropped-flower-military-pattern-soldier-army-red-672477-pxhere.com_-1-825x399.jpg\";s:5:\"width\";i:825;s:6:\"height\";i:399;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:65501;}s:15:\"morenews-medium\";a:5:{s:4:\"file\";s:81:\"cropped-flower-military-pattern-soldier-army-red-672477-pxhere.com_-1-590x399.jpg\";s:5:\"width\";i:590;s:6:\"height\";i:399;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:48369;}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(98, 994, '_wp_attachment_context', 'custom-header'),
(99, 994, '_wp_attachment_custom_header_last_used_morenews', '1717132906'),
(100, 994, '_wp_attachment_is_custom_header', 'morenews'),
(101, 51, '_menu_item_type', 'post_type'),
(102, 51, '_menu_item_object_id', '37'),
(103, 51, '_menu_item_object', 'page'),
(104, 51, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(106, 133, '_menu_item_type', 'post_type'),
(107, 133, '_menu_item_object_id', '127'),
(108, 133, '_menu_item_object', 'page'),
(109, 133, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(111, 298, '_menu_item_type', 'custom'),
(112, 298, '_menu_item_object_id', '298'),
(113, 298, '_menu_item_object', 'custom'),
(114, 298, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(115, 298, '_menu_item_url', 'https://www.youtube.com/channel/UCCJKF25c3HZpfaELha-86Hw'),
(116, 298, '_wxr_import_user_slug', 'wpafthemes@gmail.com'),
(117, 298, '_wp_old_date', '2018-07-18'),
(118, 300, '_menu_item_type', 'custom'),
(119, 300, '_menu_item_object_id', '300'),
(120, 300, '_menu_item_object', 'custom'),
(121, 300, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(122, 300, '_menu_item_url', 'https://linkedin.com/afthemes'),
(123, 300, '_wxr_import_user_slug', 'wpafthemes@gmail.com'),
(124, 302, '_menu_item_type', 'custom'),
(125, 302, '_menu_item_object_id', '302'),
(126, 302, '_menu_item_object', 'custom'),
(127, 302, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(128, 302, '_menu_item_url', 'https://vk.com/afthemes'),
(129, 302, '_wxr_import_user_slug', 'wpafthemes@gmail.com'),
(130, 336, '_menu_item_type', 'taxonomy'),
(131, 336, '_menu_item_object_id', '4'),
(132, 336, '_menu_item_object', 'category'),
(133, 336, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(134, 336, '_wp_old_date', '2019-08-05'),
(135, 337, '_menu_item_type', 'taxonomy'),
(136, 337, '_menu_item_object_id', '8'),
(137, 337, '_menu_item_object', 'category'),
(138, 337, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(139, 337, '_wp_old_date', '2019-08-05'),
(140, 342, '_menu_item_type', 'taxonomy'),
(141, 342, '_menu_item_object_id', '9'),
(142, 342, '_menu_item_object', 'category'),
(143, 342, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(144, 342, '_wp_old_date', '2019-08-08'),
(145, 525, '_menu_item_type', 'post_type'),
(146, 525, '_menu_item_object_id', '127'),
(147, 525, '_menu_item_object', 'page'),
(148, 525, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(149, 525, '_wp_old_date', '2019-11-30'),
(151, 526, '_menu_item_type', 'taxonomy'),
(152, 526, '_menu_item_object_id', '14'),
(153, 526, '_menu_item_object', 'post_tag'),
(154, 526, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(155, 526, '_wp_old_date', '2019-11-30'),
(156, 864, '_menu_item_type', 'post_type'),
(157, 864, '_menu_item_object_id', '37'),
(158, 864, '_menu_item_object', 'page'),
(159, 864, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(160, 864, '_wp_old_date', '2022-07-20'),
(162, 865, '_menu_item_type', 'post_type'),
(163, 865, '_menu_item_object_id', '127'),
(164, 865, '_menu_item_object', 'page'),
(165, 865, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(166, 865, '_wp_old_date', '2022-07-20'),
(168, 866, '_menu_item_type', 'custom'),
(169, 866, '_menu_item_object_id', '866'),
(170, 866, '_menu_item_object', 'custom'),
(171, 866, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(172, 866, '_wp_old_date', '2022-07-20'),
(173, 867, '_menu_item_type', 'custom'),
(174, 867, '_menu_item_object_id', '867'),
(175, 867, '_menu_item_object', 'custom'),
(176, 867, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(177, 867, '_wp_old_date', '2022-07-20'),
(178, 868, '_menu_item_type', 'custom'),
(179, 868, '_menu_item_object_id', '868'),
(180, 868, '_menu_item_object', 'custom'),
(181, 868, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(182, 868, '_wp_old_date', '2022-07-20'),
(183, 871, '_menu_item_type', 'custom'),
(184, 871, '_menu_item_menu_item_parent', '867'),
(185, 871, '_menu_item_object_id', '871'),
(186, 871, '_menu_item_object', 'custom'),
(187, 871, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(188, 871, '_wp_old_date', '2022-07-20'),
(189, 875, '_menu_item_type', 'custom'),
(190, 875, '_menu_item_menu_item_parent', '867'),
(191, 875, '_menu_item_object_id', '875'),
(192, 875, '_menu_item_object', 'custom'),
(193, 875, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(194, 875, '_wp_old_date', '2022-07-20'),
(195, 882, '_menu_item_type', 'custom'),
(196, 882, '_menu_item_menu_item_parent', '871'),
(197, 882, '_menu_item_object_id', '882'),
(198, 882, '_menu_item_object', 'custom'),
(199, 882, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(200, 882, '_menu_item_url', 'https://demos.afthemes.com/morenews/'),
(201, 882, '_wp_old_date', '2022-07-20'),
(202, 883, '_menu_item_type', 'custom'),
(203, 883, '_menu_item_menu_item_parent', '871'),
(204, 883, '_menu_item_object_id', '883'),
(205, 883, '_menu_item_object', 'custom'),
(206, 883, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(207, 883, '_menu_item_url', 'https://demos.afthemes.com/morenews/sport/'),
(208, 883, '_wp_old_date', '2022-07-20'),
(209, 884, '_menu_item_type', 'custom'),
(210, 884, '_menu_item_menu_item_parent', '871'),
(211, 884, '_menu_item_object_id', '884'),
(212, 884, '_menu_item_object', 'custom'),
(213, 884, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(214, 884, '_menu_item_url', 'https://demos.afthemes.com/morenews/fashion/'),
(215, 884, '_wp_old_date', '2022-07-20'),
(216, 870, '_menu_item_type', 'custom'),
(217, 870, '_menu_item_object_id', '870'),
(218, 870, '_menu_item_object', 'custom'),
(219, 870, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(220, 870, '_wp_old_date', '2022-07-20'),
(221, 872, '_menu_item_type', 'custom'),
(222, 872, '_menu_item_menu_item_parent', '868'),
(223, 872, '_menu_item_object_id', '872'),
(224, 872, '_menu_item_object', 'custom'),
(225, 872, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(226, 872, '_wp_old_date', '2022-07-20'),
(227, 873, '_menu_item_type', 'custom'),
(228, 873, '_menu_item_menu_item_parent', '870'),
(229, 873, '_menu_item_object_id', '873'),
(230, 873, '_menu_item_object', 'custom'),
(231, 873, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(232, 873, '_wp_old_date', '2022-07-20'),
(233, 876, '_menu_item_type', 'custom'),
(234, 876, '_menu_item_menu_item_parent', '870'),
(235, 876, '_menu_item_object_id', '876'),
(236, 876, '_menu_item_object', 'custom'),
(237, 876, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(238, 876, '_wp_old_date', '2022-07-20'),
(239, 877, '_menu_item_type', 'custom'),
(240, 877, '_menu_item_menu_item_parent', '868'),
(241, 877, '_menu_item_object_id', '877'),
(242, 877, '_menu_item_object', 'custom'),
(243, 877, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(244, 877, '_wp_old_date', '2022-07-20'),
(245, 885, '_menu_item_type', 'custom'),
(246, 885, '_menu_item_menu_item_parent', '871'),
(247, 885, '_menu_item_object_id', '885'),
(248, 885, '_menu_item_object', 'custom'),
(249, 885, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(250, 885, '_menu_item_url', 'https://demos.afthemes.com/morenews/classic/'),
(251, 885, '_wp_old_date', '2022-07-20'),
(252, 886, '_menu_item_type', 'custom'),
(253, 886, '_menu_item_menu_item_parent', '873'),
(254, 886, '_menu_item_object_id', '886'),
(255, 886, '_menu_item_object', 'custom'),
(256, 886, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(257, 886, '_menu_item_url', 'https://demos.afthemes.com/morenews/sport/'),
(258, 886, '_wp_old_date', '2022-07-20'),
(259, 887, '_menu_item_type', 'custom'),
(260, 887, '_menu_item_menu_item_parent', '873'),
(261, 887, '_menu_item_object_id', '887'),
(262, 887, '_menu_item_object', 'custom'),
(263, 887, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(264, 887, '_menu_item_url', 'https://demos.afthemes.com/morenews/fashion/'),
(265, 887, '_wp_old_date', '2022-07-20'),
(266, 888, '_menu_item_type', 'custom'),
(267, 888, '_menu_item_menu_item_parent', '873'),
(268, 888, '_menu_item_object_id', '888'),
(269, 888, '_menu_item_object', 'custom'),
(270, 888, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(271, 888, '_menu_item_url', 'https://demos.afthemes.com/morenews/classic/'),
(272, 888, '_wp_old_date', '2022-07-20'),
(273, 889, '_menu_item_type', 'custom'),
(274, 889, '_menu_item_menu_item_parent', '873'),
(275, 889, '_menu_item_object_id', '889'),
(276, 889, '_menu_item_object', 'custom'),
(277, 889, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(278, 889, '_menu_item_url', 'https://demos.afthemes.com/morenews/food-recipe/'),
(279, 889, '_wp_old_date', '2022-07-20'),
(280, 890, '_menu_item_type', 'custom'),
(281, 890, '_menu_item_menu_item_parent', '873'),
(282, 890, '_menu_item_object_id', '890'),
(283, 890, '_menu_item_object', 'custom'),
(284, 890, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(285, 890, '_menu_item_url', 'https://demos.afthemes.com/morenews/travel/'),
(286, 890, '_wp_old_date', '2022-07-20'),
(287, 891, '_menu_item_type', 'custom'),
(288, 891, '_menu_item_menu_item_parent', '872'),
(289, 891, '_menu_item_object_id', '891'),
(290, 891, '_menu_item_object', 'custom'),
(291, 891, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(292, 891, '_menu_item_url', 'https://demos.afthemes.com/morenews/blog/category/newsbeat/'),
(293, 891, '_wp_old_date', '2022-07-20'),
(294, 892, '_menu_item_type', 'custom'),
(295, 892, '_menu_item_menu_item_parent', '872'),
(296, 892, '_menu_item_object_id', '892'),
(297, 892, '_menu_item_object', 'custom'),
(298, 892, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(299, 892, '_menu_item_url', 'https://demos.afthemes.com/morenews/classic/category/beauty/'),
(300, 892, '_wp_old_date', '2022-07-20'),
(301, 895, '_menu_item_type', 'custom'),
(302, 895, '_menu_item_menu_item_parent', '875'),
(303, 895, '_menu_item_object_id', '895'),
(304, 895, '_menu_item_object', 'custom'),
(305, 895, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(306, 895, '_menu_item_url', 'https://demos.afthemes.com/morenews-pro/'),
(307, 895, '_wp_old_date', '2022-07-20'),
(308, 896, '_menu_item_type', 'custom'),
(309, 896, '_menu_item_menu_item_parent', '875'),
(310, 896, '_menu_item_object_id', '896'),
(311, 896, '_menu_item_object', 'custom'),
(312, 896, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(313, 896, '_menu_item_url', 'https://demos.afthemes.com/morenews-pro/sport/'),
(314, 896, '_wp_old_date', '2022-07-20'),
(315, 897, '_menu_item_type', 'custom'),
(316, 897, '_menu_item_menu_item_parent', '875'),
(317, 897, '_menu_item_object_id', '897'),
(318, 897, '_menu_item_object', 'custom'),
(319, 897, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(320, 897, '_menu_item_url', 'https://demos.afthemes.com/morenews-pro/classic/'),
(321, 897, '_wp_old_date', '2022-07-20'),
(322, 898, '_menu_item_type', 'custom'),
(323, 898, '_menu_item_menu_item_parent', '875'),
(324, 898, '_menu_item_object_id', '898'),
(325, 898, '_menu_item_object', 'custom'),
(326, 898, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(327, 898, '_menu_item_url', 'https://demos.afthemes.com/morenews-pro/fashion/'),
(328, 898, '_wp_old_date', '2022-07-20'),
(329, 899, '_menu_item_type', 'custom'),
(330, 899, '_menu_item_menu_item_parent', '875'),
(331, 899, '_menu_item_object_id', '899'),
(332, 899, '_menu_item_object', 'custom'),
(333, 899, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(334, 899, '_menu_item_url', 'https://demos.afthemes.com/morenews-pro/food-recipe/'),
(335, 899, '_wp_old_date', '2022-07-20'),
(336, 900, '_menu_item_type', 'custom'),
(337, 900, '_menu_item_menu_item_parent', '875'),
(338, 900, '_menu_item_object_id', '900'),
(339, 900, '_menu_item_object', 'custom'),
(340, 900, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(341, 900, '_menu_item_url', 'https://demos.afthemes.com/morenews-pro/onlinemag/'),
(342, 900, '_wp_old_date', '2022-07-20'),
(343, 901, '_menu_item_type', 'custom'),
(344, 901, '_menu_item_menu_item_parent', '875'),
(345, 901, '_menu_item_object_id', '901'),
(346, 901, '_menu_item_object', 'custom'),
(347, 901, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(348, 901, '_menu_item_url', 'https://demos.afthemes.com/morenews-pro/travel/'),
(349, 901, '_wp_old_date', '2022-07-20'),
(350, 893, '_menu_item_type', 'custom'),
(351, 893, '_menu_item_menu_item_parent', '872'),
(352, 893, '_menu_item_object_id', '893'),
(353, 893, '_menu_item_object', 'custom'),
(354, 893, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(355, 893, '_menu_item_url', 'https://demos.afthemes.com/morenews/sport/category/leagues-clubs/'),
(356, 893, '_wp_old_date', '2022-07-20'),
(357, 894, '_menu_item_type', 'custom'),
(358, 894, '_menu_item_menu_item_parent', '872'),
(359, 894, '_menu_item_object_id', '894'),
(360, 894, '_menu_item_object', 'custom'),
(361, 894, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(362, 894, '_menu_item_url', 'https://demos.afthemes.com/morenews/food-recipe/category/barbecue/'),
(363, 894, '_wp_old_date', '2022-07-20'),
(364, 902, '_menu_item_type', 'custom'),
(365, 902, '_menu_item_menu_item_parent', '877'),
(366, 902, '_menu_item_object_id', '902'),
(367, 902, '_menu_item_object', 'custom'),
(368, 902, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(369, 902, '_menu_item_url', 'https://demos.afthemes.com/morenews-pro/blog/category/newsbeat/'),
(370, 902, '_wp_old_date', '2022-07-20'),
(371, 903, '_menu_item_type', 'custom'),
(372, 903, '_menu_item_menu_item_parent', '877'),
(373, 903, '_menu_item_object_id', '903'),
(374, 903, '_menu_item_object', 'custom'),
(375, 903, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(376, 903, '_menu_item_url', 'https://demos.afthemes.com/morenews-pro/fitness-magazine/category/newsbeat/'),
(377, 903, '_wp_old_date', '2022-07-20'),
(378, 904, '_menu_item_type', 'custom'),
(379, 904, '_menu_item_menu_item_parent', '877'),
(380, 904, '_menu_item_object_id', '904'),
(381, 904, '_menu_item_object', 'custom'),
(382, 904, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(383, 904, '_menu_item_url', 'https://demos.afthemes.com/morenews-pro/sport/category/leagues-clubs/'),
(384, 904, '_wp_old_date', '2022-07-20'),
(385, 905, '_menu_item_type', 'custom'),
(386, 905, '_menu_item_menu_item_parent', '877'),
(387, 905, '_menu_item_object_id', '905'),
(388, 905, '_menu_item_object', 'custom'),
(389, 905, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(390, 905, '_menu_item_url', 'https://demos.afthemes.com/morenews-pro/sport/category/trending/'),
(391, 905, '_wp_old_date', '2022-07-20'),
(392, 906, '_menu_item_type', 'custom'),
(393, 906, '_menu_item_menu_item_parent', '877'),
(394, 906, '_menu_item_object_id', '906'),
(395, 906, '_menu_item_object', 'custom'),
(396, 906, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(397, 906, '_menu_item_url', 'https://demos.afthemes.com/morenews-pro/sport/category/interview/'),
(398, 906, '_wp_old_date', '2022-07-20'),
(399, 907, '_menu_item_type', 'custom'),
(400, 907, '_menu_item_menu_item_parent', '877'),
(401, 907, '_menu_item_object_id', '907'),
(402, 907, '_menu_item_object', 'custom'),
(403, 907, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(404, 907, '_menu_item_url', 'https://demos.afthemes.com/morenews-pro/travel/category/travel-tips/'),
(405, 907, '_wp_old_date', '2022-07-20'),
(406, 908, '_menu_item_type', 'custom'),
(407, 908, '_menu_item_menu_item_parent', '877'),
(408, 908, '_menu_item_object_id', '908'),
(409, 908, '_menu_item_object', 'custom'),
(410, 908, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(411, 908, '_menu_item_url', 'https://demos.afthemes.com/morenews-pro/fashion/category/beauty/'),
(412, 908, '_wp_old_date', '2022-07-20'),
(413, 909, '_menu_item_type', 'custom'),
(414, 909, '_menu_item_menu_item_parent', '877'),
(415, 909, '_menu_item_object_id', '909'),
(416, 909, '_menu_item_object', 'custom'),
(417, 909, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(418, 909, '_menu_item_url', 'https://demos.afthemes.com/morenews-pro/classic/category/beauty/'),
(419, 909, '_wp_old_date', '2022-07-20'),
(420, 910, '_menu_item_type', 'custom'),
(421, 910, '_menu_item_menu_item_parent', '877'),
(422, 910, '_menu_item_object_id', '910'),
(423, 910, '_menu_item_object', 'custom'),
(424, 910, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(425, 910, '_menu_item_url', 'https://demos.afthemes.com/morenews-pro/food-recipe/category/trends/'),
(426, 910, '_wp_old_date', '2022-07-20'),
(427, 911, '_menu_item_type', 'custom'),
(428, 911, '_menu_item_menu_item_parent', '876'),
(429, 911, '_menu_item_object_id', '911'),
(430, 911, '_menu_item_object', 'custom'),
(431, 911, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(432, 911, '_menu_item_url', 'https://demos.afthemes.com/morenews-pro/'),
(433, 911, '_wp_old_date', '2022-07-20'),
(434, 912, '_menu_item_type', 'custom'),
(435, 912, '_menu_item_menu_item_parent', '876'),
(436, 912, '_menu_item_object_id', '912'),
(437, 912, '_menu_item_object', 'custom'),
(438, 912, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(439, 912, '_menu_item_url', 'https://demos.afthemes.com/morenews-pro/sport/'),
(440, 912, '_wp_old_date', '2022-07-20'),
(441, 913, '_menu_item_type', 'custom'),
(442, 913, '_menu_item_menu_item_parent', '876'),
(443, 913, '_menu_item_object_id', '913'),
(444, 913, '_menu_item_object', 'custom'),
(445, 913, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(446, 913, '_menu_item_url', 'https://demos.afthemes.com/morenews-pro/fashion/'),
(447, 913, '_wp_old_date', '2022-07-20'),
(448, 916, '_menu_item_type', 'custom'),
(449, 916, '_menu_item_menu_item_parent', '876'),
(450, 916, '_menu_item_object_id', '916'),
(451, 916, '_menu_item_object', 'custom'),
(452, 916, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(453, 916, '_menu_item_url', 'https://demos.afthemes.com/morenews-pro/classic/'),
(454, 916, '_wp_old_date', '2022-07-20'),
(455, 917, '_menu_item_type', 'custom'),
(456, 917, '_menu_item_menu_item_parent', '876'),
(457, 917, '_menu_item_object_id', '917'),
(458, 917, '_menu_item_object', 'custom'),
(459, 917, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(460, 917, '_menu_item_url', 'https://demos.afthemes.com/morenews-pro/food-recipe/'),
(461, 917, '_wp_old_date', '2022-07-20'),
(462, 918, '_menu_item_type', 'custom'),
(463, 918, '_menu_item_menu_item_parent', '876'),
(464, 918, '_menu_item_object_id', '918'),
(465, 918, '_menu_item_object', 'custom'),
(466, 918, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(467, 918, '_menu_item_url', 'https://demos.afthemes.com/morenews-pro/travel/'),
(468, 918, '_wp_old_date', '2022-07-20'),
(469, 919, '_menu_item_type', 'custom'),
(470, 919, '_menu_item_menu_item_parent', '876'),
(471, 919, '_menu_item_object_id', '919'),
(472, 919, '_menu_item_object', 'custom'),
(473, 919, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(474, 919, '_menu_item_url', 'https://demos.afthemes.com/morenews-pro/onlinemag/'),
(475, 919, '_wp_old_date', '2022-07-20'),
(476, 920, '_menu_item_type', 'custom'),
(477, 920, '_menu_item_menu_item_parent', '876'),
(478, 920, '_menu_item_object_id', '920'),
(479, 920, '_menu_item_object', 'custom'),
(480, 920, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(481, 920, '_menu_item_url', 'https://demos.afthemes.com/morenews-pro/crypto-news/'),
(482, 920, '_wp_old_date', '2022-07-20'),
(483, 921, '_menu_item_type', 'custom'),
(484, 921, '_menu_item_menu_item_parent', '876'),
(485, 921, '_menu_item_object_id', '921'),
(486, 921, '_menu_item_object', 'custom'),
(487, 921, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(488, 921, '_menu_item_url', 'https://demos.afthemes.com/morenews-pro/fitness-magazine/'),
(489, 921, '_wp_old_date', '2022-07-20'),
(490, 37, '_wp_page_template', 'full-width.php'),
(491, 37, 'estory-meta-content-alignment', 'align-content-left'),
(492, 37, 'newsphere-meta-content-alignment', 'align-content-left'),
(493, 37, '_wxr_import_user_slug', 'wpafthemes@gmail.com'),
(494, 37, '_edit_last', '1'),
(495, 37, 'morenews-meta-content-alignment', 'align-content-left'),
(496, 37, 'morenews-meta-content-mode', 'single-content-mode-default'),
(497, 37, '_wxr_import_has_attachment_refs', '1'),
(498, 127, 'newsphere-meta-content-alignment', 'align-content-left'),
(499, 127, '_wxr_import_user_slug', 'wpafthemes@gmail.com'),
(502, 267, '_thumbnail_id', '7'),
(503, 267, 'estory-meta-content-alignment', 'align-content-left'),
(504, 267, 'storymag-meta-content-alignment', 'align-content-left'),
(505, 267, '_wxr_import_term', 'a:3:{s:8:\"taxonomy\";s:8:\"category\";s:4:\"slug\";s:5:\"world\";s:4:\"name\";s:5:\"World\";}'),
(506, 267, '_wp_old_date', '2018-07-18'),
(507, 267, '_edit_last', '1'),
(508, 267, '_oembed_eb18aa4846dcf41d3a79f0fd0ad6cca9', '<iframe title=\"How to Create a Website in Minutes: Step-by-Step Guide for Beginners (Using WordPress)\" width=\"640\" height=\"360\" src=\"https://www.youtube.com/embed/t7LMDLRE8Ok?feature=oembed\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" referrerpolicy=\"strict-origin-when-cross-origin\" allowfullscreen></iframe>'),
(509, 267, '_oembed_time_eb18aa4846dcf41d3a79f0fd0ad6cca9', '1717143107'),
(510, 267, '_wxr_import_has_attachment_refs', '1'),
(513, 963, '_thumbnail_id', '10'),
(514, 963, 'estory-meta-content-alignment', 'align-content-left'),
(515, 963, '_wxr_import_term', 'a:3:{s:8:\"taxonomy\";s:8:\"category\";s:4:\"slug\";s:8:\"newsbeat\";s:4:\"name\";s:8:\"Newsbeat\";}'),
(516, 963, '_wp_old_date', '2018-07-18'),
(517, 963, '_edit_last', '1'),
(518, 963, '_oembed_eb18aa4846dcf41d3a79f0fd0ad6cca9', '<iframe title=\"How to Create a Website in Minutes: Step-by-Step Guide for Beginners (Using WordPress)\" width=\"640\" height=\"360\" src=\"https://www.youtube.com/embed/t7LMDLRE8Ok?feature=oembed\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" referrerpolicy=\"strict-origin-when-cross-origin\" allowfullscreen></iframe>'),
(519, 963, '_oembed_time_eb18aa4846dcf41d3a79f0fd0ad6cca9', '1717143107'),
(520, 963, '_wxr_import_has_attachment_refs', '1'),
(523, 964, '_thumbnail_id', '13'),
(524, 964, 'estory-meta-content-alignment', 'align-content-left'),
(525, 964, 'storymag-meta-content-alignment', 'align-content-left'),
(526, 964, '_wxr_import_term', 'a:3:{s:8:\"taxonomy\";s:8:\"category\";s:4:\"slug\";s:7:\"stories\";s:4:\"name\";s:7:\"Stories\";}'),
(527, 964, '_wp_old_date', '2018-07-18'),
(528, 964, '_edit_last', '1'),
(529, 964, '_oembed_eb18aa4846dcf41d3a79f0fd0ad6cca9', '<iframe title=\"How to Create a Website in Minutes: Step-by-Step Guide for Beginners (Using WordPress)\" width=\"640\" height=\"360\" src=\"https://www.youtube.com/embed/t7LMDLRE8Ok?feature=oembed\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" referrerpolicy=\"strict-origin-when-cross-origin\" allowfullscreen></iframe>'),
(530, 964, '_oembed_time_eb18aa4846dcf41d3a79f0fd0ad6cca9', '1717143107'),
(531, 964, '_wxr_import_has_attachment_refs', '1'),
(534, 965, '_thumbnail_id', '16'),
(535, 965, 'estory-meta-content-alignment', 'align-content-left'),
(536, 965, 'storymag-meta-content-alignment', 'align-content-left'),
(537, 965, '_wxr_import_term', 'a:3:{s:8:\"taxonomy\";s:11:\"post_format\";s:4:\"slug\";s:17:\"post-format-video\";s:4:\"name\";s:5:\"Video\";}'),
(538, 965, '_wp_old_date', '2018-07-18'),
(539, 965, '_edit_last', '1'),
(540, 965, '_oembed_eb18aa4846dcf41d3a79f0fd0ad6cca9', '<iframe title=\"How to Create a Website in Minutes: Step-by-Step Guide for Beginners (Using WordPress)\" width=\"640\" height=\"360\" src=\"https://www.youtube.com/embed/t7LMDLRE8Ok?feature=oembed\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" referrerpolicy=\"strict-origin-when-cross-origin\" allowfullscreen></iframe>'),
(541, 965, '_oembed_time_eb18aa4846dcf41d3a79f0fd0ad6cca9', '1717143107'),
(542, 965, '_wxr_import_has_attachment_refs', '1'),
(545, 966, '_thumbnail_id', '19'),
(546, 966, 'estory-meta-content-alignment', 'align-content-left'),
(547, 966, 'storymag-meta-content-alignment', 'align-content-left'),
(548, 966, '_wxr_import_term', 'a:3:{s:8:\"taxonomy\";s:8:\"category\";s:4:\"slug\";s:7:\"science\";s:4:\"name\";s:7:\"Science\";}'),
(549, 966, '_wp_old_date', '2018-07-18'),
(550, 966, '_edit_last', '1'),
(551, 966, '_oembed_eb18aa4846dcf41d3a79f0fd0ad6cca9', '<iframe title=\"How to Create a Website in Minutes: Step-by-Step Guide for Beginners (Using WordPress)\" width=\"640\" height=\"360\" src=\"https://www.youtube.com/embed/t7LMDLRE8Ok?feature=oembed\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" referrerpolicy=\"strict-origin-when-cross-origin\" allowfullscreen></iframe>'),
(552, 966, '_oembed_time_eb18aa4846dcf41d3a79f0fd0ad6cca9', '1717143107'),
(553, 966, '_wxr_import_has_attachment_refs', '1'),
(556, 967, '_thumbnail_id', '219'),
(557, 967, 'estory-meta-content-alignment', 'align-content-left'),
(558, 967, '_edit_last', '1'),
(559, 967, '_bj_lazy_load_skip_post', 'false'),
(560, 967, 'covernews-meta-content-alignment', 'align-content-left'),
(561, 967, '_wxr_import_term', 'a:3:{s:8:\"taxonomy\";s:8:\"category\";s:4:\"slug\";s:5:\"world\";s:4:\"name\";s:5:\"World\";}'),
(562, 967, '_wp_old_date', '2018-07-18'),
(563, 967, '_oembed_eb18aa4846dcf41d3a79f0fd0ad6cca9', '<iframe title=\"How to Create a Website in Minutes: Step-by-Step Guide for Beginners (Using WordPress)\" width=\"640\" height=\"360\" src=\"https://www.youtube.com/embed/t7LMDLRE8Ok?feature=oembed\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" referrerpolicy=\"strict-origin-when-cross-origin\" allowfullscreen></iframe>'),
(564, 967, '_oembed_time_eb18aa4846dcf41d3a79f0fd0ad6cca9', '1717143107'),
(565, 967, '_wxr_import_has_attachment_refs', '1'),
(568, 968, 'estory-meta-content-alignment', 'align-content-left'),
(569, 968, 'storymag-meta-content-alignment', 'align-content-left'),
(570, 968, '_edit_last', '1'),
(571, 968, '_bj_lazy_load_skip_post', 'false'),
(572, 968, 'covernews-meta-content-alignment', 'align-content-left'),
(573, 968, '_thumbnail_id', '222'),
(574, 968, '_wxr_import_term', 'a:3:{s:8:\"taxonomy\";s:8:\"category\";s:4:\"slug\";s:5:\"world\";s:4:\"name\";s:5:\"World\";}'),
(575, 968, '_wp_old_date', '2018-07-18'),
(576, 968, '_oembed_eb18aa4846dcf41d3a79f0fd0ad6cca9', '<iframe title=\"How to Create a Website in Minutes: Step-by-Step Guide for Beginners (Using WordPress)\" width=\"640\" height=\"360\" src=\"https://www.youtube.com/embed/t7LMDLRE8Ok?feature=oembed\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" referrerpolicy=\"strict-origin-when-cross-origin\" allowfullscreen></iframe>'),
(577, 968, '_oembed_time_eb18aa4846dcf41d3a79f0fd0ad6cca9', '1717143107'),
(578, 968, '_wxr_import_has_attachment_refs', '1'),
(581, 969, '_thumbnail_id', '220'),
(582, 969, 'estory-meta-content-alignment', 'align-content-left'),
(583, 969, 'storymag-meta-content-alignment', 'align-content-left'),
(584, 969, '_edit_last', '1'),
(585, 969, 'covernews-meta-content-alignment', 'full-width-content'),
(586, 969, '_wxr_import_term', 'a:3:{s:8:\"taxonomy\";s:8:\"category\";s:4:\"slug\";s:8:\"newsbeat\";s:4:\"name\";s:8:\"Newsbeat\";}'),
(587, 969, '_wp_old_date', '2018-07-18'),
(588, 969, '_oembed_eb18aa4846dcf41d3a79f0fd0ad6cca9', '<iframe title=\"How to Create a Website in Minutes: Step-by-Step Guide for Beginners (Using WordPress)\" width=\"640\" height=\"360\" src=\"https://www.youtube.com/embed/t7LMDLRE8Ok?feature=oembed\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" referrerpolicy=\"strict-origin-when-cross-origin\" allowfullscreen></iframe>'),
(589, 969, '_oembed_time_eb18aa4846dcf41d3a79f0fd0ad6cca9', '1717143107'),
(590, 969, '_wxr_import_has_attachment_refs', '1'),
(593, 970, '_thumbnail_id', '217'),
(594, 970, 'estory-meta-content-alignment', 'align-content-left'),
(595, 970, 'storymag-meta-content-alignment', 'align-content-left'),
(596, 970, '_edit_last', '1'),
(597, 970, 'covernews-meta-content-alignment', 'align-content-right'),
(598, 970, '_wxr_import_term', 'a:3:{s:8:\"taxonomy\";s:11:\"post_format\";s:4:\"slug\";s:17:\"post-format-image\";s:4:\"name\";s:5:\"Image\";}'),
(599, 970, '_wp_old_date', '2018-07-18'),
(600, 970, '_oembed_eb18aa4846dcf41d3a79f0fd0ad6cca9', '<iframe title=\"How to Create a Website in Minutes: Step-by-Step Guide for Beginners (Using WordPress)\" width=\"640\" height=\"360\" src=\"https://www.youtube.com/embed/t7LMDLRE8Ok?feature=oembed\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" referrerpolicy=\"strict-origin-when-cross-origin\" allowfullscreen></iframe>'),
(601, 970, '_oembed_time_eb18aa4846dcf41d3a79f0fd0ad6cca9', '1717143107'),
(602, 970, '_wxr_import_has_attachment_refs', '1'),
(605, 971, '_thumbnail_id', '34'),
(606, 971, 'estory-meta-content-alignment', 'align-content-left'),
(607, 971, 'storymag-meta-content-alignment', 'align-content-left'),
(608, 971, '_edit_last', '1'),
(609, 971, '_bj_lazy_load_skip_post', 'false'),
(610, 971, '_oembed_60ddb79744ff80fd4e135eda4921d1ab', '<iframe title=\"CoverNews  - Theme setup using Live Customizer\" width=\"640\" height=\"480\" src=\"https://www.youtube.com/embed/mnYdG-nuBOw?start=10&feature=oembed\" frameborder=\"0\" allow=\"accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>'),
(611, 971, '_oembed_time_60ddb79744ff80fd4e135eda4921d1ab', '1562221242'),
(612, 971, '_wxr_import_term', 'a:3:{s:8:\"taxonomy\";s:11:\"post_format\";s:4:\"slug\";s:17:\"post-format-video\";s:4:\"name\";s:5:\"Video\";}'),
(613, 971, '_wp_old_date', '2018-07-18'),
(614, 971, '_oembed_eb18aa4846dcf41d3a79f0fd0ad6cca9', '<iframe title=\"How to Create a Website in Minutes: Step-by-Step Guide for Beginners (Using WordPress)\" width=\"640\" height=\"360\" src=\"https://www.youtube.com/embed/t7LMDLRE8Ok?feature=oembed\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" referrerpolicy=\"strict-origin-when-cross-origin\" allowfullscreen></iframe>'),
(615, 971, '_oembed_time_eb18aa4846dcf41d3a79f0fd0ad6cca9', '1717143107'),
(616, 971, '_wxr_import_has_attachment_refs', '1'),
(617, 996, '_wp_attached_file', '2024/12/cropped-flower-military-pattern-soldier-army-red-672477-pxhere.com_-1.jpg');
INSERT INTO `wp_postmeta` (`meta_id`, `post_id`, `meta_key`, `meta_value`) VALUES
(618, 996, '_wp_attachment_metadata', 'a:6:{s:5:\"width\";i:1500;s:6:\"height\";i:399;s:4:\"file\";s:81:\"2024/12/cropped-flower-military-pattern-soldier-army-red-672477-pxhere.com_-1.jpg\";s:8:\"filesize\";i:99422;s:5:\"sizes\";a:7:{s:6:\"medium\";a:5:{s:4:\"file\";s:80:\"cropped-flower-military-pattern-soldier-army-red-672477-pxhere.com_-1-300x80.jpg\";s:5:\"width\";i:300;s:6:\"height\";i:80;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:9111;}s:5:\"large\";a:5:{s:4:\"file\";s:82:\"cropped-flower-military-pattern-soldier-army-red-672477-pxhere.com_-1-1024x272.jpg\";s:5:\"width\";i:1024;s:6:\"height\";i:272;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:55743;}s:9:\"thumbnail\";a:5:{s:4:\"file\";s:81:\"cropped-flower-military-pattern-soldier-army-red-672477-pxhere.com_-1-150x150.jpg\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:8215;}s:12:\"medium_large\";a:5:{s:4:\"file\";s:81:\"cropped-flower-military-pattern-soldier-army-red-672477-pxhere.com_-1-768x204.jpg\";s:5:\"width\";i:768;s:6:\"height\";i:204;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:37375;}s:17:\"morenews-featured\";a:5:{s:4:\"file\";s:82:\"cropped-flower-military-pattern-soldier-army-red-672477-pxhere.com_-1-1024x272.jpg\";s:5:\"width\";i:1024;s:6:\"height\";i:272;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:55743;}s:14:\"morenews-large\";a:5:{s:4:\"file\";s:81:\"cropped-flower-military-pattern-soldier-army-red-672477-pxhere.com_-1-825x399.jpg\";s:5:\"width\";i:825;s:6:\"height\";i:399;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:65501;}s:15:\"morenews-medium\";a:5:{s:4:\"file\";s:81:\"cropped-flower-military-pattern-soldier-army-red-672477-pxhere.com_-1-590x399.jpg\";s:5:\"width\";i:590;s:6:\"height\";i:399;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:48369;}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(619, 996, '_wp_attachment_is_custom_header', 'morenews');

-- --------------------------------------------------------

--
-- Table structure for table `wp_posts`
--

CREATE TABLE `wp_posts` (
  `ID` bigint UNSIGNED NOT NULL,
  `post_author` bigint UNSIGNED NOT NULL DEFAULT '0',
  `post_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_date_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_content` longtext COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `post_title` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `post_excerpt` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `post_status` varchar(20) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT 'publish',
  `comment_status` varchar(20) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT 'open',
  `ping_status` varchar(20) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT 'open',
  `post_password` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `post_name` varchar(200) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `to_ping` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `pinged` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `post_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_modified_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_content_filtered` longtext COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `post_parent` bigint UNSIGNED NOT NULL DEFAULT '0',
  `guid` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `menu_order` int NOT NULL DEFAULT '0',
  `post_type` varchar(20) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT 'post',
  `post_mime_type` varchar(100) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `comment_count` bigint NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `wp_posts`
--

INSERT INTO `wp_posts` (`ID`, `post_author`, `post_date`, `post_date_gmt`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `ping_status`, `post_password`, `post_name`, `to_ping`, `pinged`, `post_modified`, `post_modified_gmt`, `post_content_filtered`, `post_parent`, `guid`, `menu_order`, `post_type`, `post_mime_type`, `comment_count`) VALUES
(1, 1, '2024-08-29 13:20:57', '2024-08-29 13:20:57', '<!-- wp:paragraph -->\n<p>Cảm ơn vì đã sử dụng WordPress. Đây là bài viết đầu tiên của bạn. Sửa hoặc xóa nó, và bắt đầu bài viết của bạn nhé!</p>\n<!-- /wp:paragraph -->', 'Chào tất cả mọi người!', '', 'publish', 'open', 'open', '', 'chao-moi-nguoi', '', '', '2024-08-29 13:20:57', '2024-08-29 13:20:57', '', 0, 'http://datws.test/?p=1', 0, 'post', '', 1),
(2, 1, '2024-08-29 13:20:57', '2024-08-29 13:20:57', '<!-- wp:paragraph -->\n<p>Đây là trang mẫu. Nó khác với bài viết bởi vì nó thường cố định và hiển thị trong menu của bạn. Nhiều người bắt đầu với trang Giới thiệu nơi bạn chia sẻ thông tin cho những ai ghé thăm. Nó có thể bắt đầu như thế này:</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:quote -->\n<blockquote class=\"wp-block-quote\"><p>Chào bạn! Tôi là một người bán hàng, và đây là website của tôi. Tôi sống ở Hà Nội, có một gia đình nhỏ, và tôi thấy cách sử dụng WordPress rất thú vị.</p></blockquote>\n<!-- /wp:quote -->\n\n<!-- wp:paragraph -->\n<p>... hoặc cái gì đó như thế này:</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:quote -->\n<blockquote class=\"wp-block-quote\"><p>Công ty chúng tôi được thành lập năm 2010, và cung cấp dịch vụ chất lượng cho rất nhiều sự kiện tại khắp Việt Nam. Với văn phòng đặt tại Hà Nội, TP. Hồ Chí Minh cùng hơn 40 nhân sự, chúng tôi là nơi nhiều đối tác tin tưởng giao cho tổ chức các sự kiện lớn.</p></blockquote>\n<!-- /wp:quote -->\n\n<!-- wp:paragraph -->\n<p>Là một người dùng WordPress mới, bạn nên ghé thăm <a href=\"http://datws.test/wp-admin/\">bảng tin</a> để xóa trang này và tạo trang mới cho nội dung của chính bạn. Chúc bạn vui vẻ!</p>\n<!-- /wp:paragraph -->', 'Trang Mẫu', '', 'publish', 'closed', 'open', '', 'Trang mẫu', '', '', '2024-08-29 13:20:57', '2024-08-29 13:20:57', '', 0, 'http://datws.test/?page_id=2', 0, 'page', '', 0),
(3, 1, '2024-08-29 13:20:57', '2024-08-29 13:20:57', '<!-- wp:heading -->\n<h2 class=\"wp-block-heading\">Chúng tôi là ai</h2>\n<!-- /wp:heading -->\n<!-- wp:paragraph -->\n<p><strong class=\"privacy-policy-tutorial\">Văn bản được đề xuất: </strong>Địa chỉ website là: http://datws.test.</p>\n<!-- /wp:paragraph -->\n<!-- wp:heading -->\n<h2 class=\"wp-block-heading\">Bình luận</h2>\n<!-- /wp:heading -->\n<!-- wp:paragraph -->\n<p><strong class=\"privacy-policy-tutorial\">Văn bản được đề xuất: </strong>Khi khách truy cập để lại bình luận trên trang web, chúng tôi thu thập dữ liệu được hiển thị trong biểu mẫu bình luận và cũng là địa chỉ IP của người truy cập và chuỗi user agent của người dùng trình duyệt để giúp phát hiện spam</p>\n<!-- /wp:paragraph -->\n<!-- wp:paragraph -->\n<p>Một chuỗi ẩn danh được tạo từ địa chỉ email của bạn (còn được gọi là hash) có thể được cung cấp cho dịch vụ Gravatar để xem bạn có đang sử dụng nó hay không. Chính sách bảo mật của dịch vụ Gravatar có tại đây: https://automattic.com/privacy/. Sau khi chấp nhận bình luận của bạn, ảnh tiểu sử của bạn được hiển thị công khai trong ngữ cảnh bình luận của bạn.</p>\n<!-- /wp:paragraph -->\n<!-- wp:heading -->\n<h2 class=\"wp-block-heading\">Media</h2>\n<!-- /wp:heading -->\n<!-- wp:paragraph -->\n<p><strong class=\"privacy-policy-tutorial\">Văn bản được đề xuất: </strong>Nếu bạn tải hình ảnh lên trang web, bạn nên tránh tải lên hình ảnh có dữ liệu vị trí được nhúng (EXIF GPS) đi kèm. Khách truy cập vào trang web có thể tải xuống và giải nén bất kỳ dữ liệu vị trí nào từ hình ảnh trên trang web.</p>\n<!-- /wp:paragraph -->\n<!-- wp:heading -->\n<h2 class=\"wp-block-heading\">Cookies</h2>\n<!-- /wp:heading -->\n<!-- wp:paragraph -->\n<p><strong class=\"privacy-policy-tutorial\">Văn bản được đề xuất: </strong>Nếu bạn viết bình luận trong website, bạn có thể cung cấp cần nhập tên, email địa chỉ website trong cookie. Các thông tin này nhằm giúp bạn không cần nhập thông tin nhiều lần khi viết bình luận khác. Cookie này sẽ được lưu giữ trong một năm.</p>\n<!-- /wp:paragraph -->\n<!-- wp:paragraph -->\n<p>Nếu bạn vào trang đăng nhập, chúng tôi sẽ thiết lập một cookie tạm thời để xác định nếu trình duyệt cho phép sử dụng cookie. Cookie này không bao gồm thông tin cá nhân và sẽ được gỡ bỏ khi bạn đóng trình duyệt.</p>\n<!-- /wp:paragraph -->\n<!-- wp:paragraph -->\n<p>Khi bạn đăng nhập, chúng tôi sẽ thiết lập một vài cookie để lưu thông tin đăng nhập và lựa chọn hiển thị. Thông tin đăng nhập gần nhất lưu trong hai ngày, và lựa chọn hiển thị gần nhất lưu trong một năm. Nếu bạn chọn &quot;Nhớ tôi&quot;, thông tin đăng nhập sẽ được lưu trong hai tuần. Nếu bạn thoát tài khoản, thông tin cookie đăng nhập sẽ bị xoá.</p>\n<!-- /wp:paragraph -->\n<!-- wp:paragraph -->\n<p>Nếu bạn sửa hoặc công bố bài viết, một bản cookie bổ sung sẽ được lưu trong trình duyệt. Cookie này không chứa thông tin cá nhân và chỉ đơn giản bao gồm ID của bài viết bạn đã sửa. Nó tự động hết hạn sau 1 ngày.</p>\n<!-- /wp:paragraph -->\n<!-- wp:heading -->\n<h2 class=\"wp-block-heading\">Nội dung nhúng từ website khác</h2>\n<!-- /wp:heading -->\n<!-- wp:paragraph -->\n<p><strong class=\"privacy-policy-tutorial\">Văn bản được đề xuất: </strong>Các bài viết trên trang web này có thể bao gồm nội dung được nhúng (ví dụ: video, hình ảnh, bài viết, v.v.). Nội dung được nhúng từ các trang web khác hoạt động theo cùng một cách chính xác như khi khách truy cập đã truy cập trang web khác.</p>\n<!-- /wp:paragraph -->\n<!-- wp:paragraph -->\n<p>Những website này có thể thu thập dữ liệu về bạn, sử dụng cookie, nhúng các trình theo dõi của bên thứ ba và giám sát tương tác của bạn với nội dung được nhúng đó, bao gồm theo dõi tương tác của bạn với nội dung được nhúng nếu bạn có tài khoản và đã đăng nhập vào trang web đó.</p>\n<!-- /wp:paragraph -->\n<!-- wp:heading -->\n<h2 class=\"wp-block-heading\">Chúng tôi chia sẻ dữ liệu của bạn với ai</h2>\n<!-- /wp:heading -->\n<!-- wp:paragraph -->\n<p><strong class=\"privacy-policy-tutorial\">Văn bản được đề xuất: </strong>Nếu bạn yêu cầu đặt lại mật khẩu, địa chỉ IP của bạn sẽ được bao gồm trong email đặt lại.</p>\n<!-- /wp:paragraph -->\n<!-- wp:heading -->\n<h2 class=\"wp-block-heading\">Dữ liệu của bạn tồn tại bao lâu</h2>\n<!-- /wp:heading -->\n<!-- wp:paragraph -->\n<p><strong class=\"privacy-policy-tutorial\">Văn bản được đề xuất: </strong>Nếu bạn để lại bình luận, bình luận và siêu dữ liệu của nó sẽ được giữ lại vô thời hạn. Điều này là để chúng tôi có thể tự động nhận ra và chấp nhận bất kỳ bình luận nào thay vì giữ chúng trong khu vực đợi kiểm duyệt.</p>\n<!-- /wp:paragraph -->\n<!-- wp:paragraph -->\n<p>Đối với người dùng đăng ký trên trang web của chúng tôi (nếu có), chúng tôi cũng lưu trữ thông tin cá nhân mà họ cung cấp trong hồ sơ người dùng của họ. Tất cả người dùng có thể xem, chỉnh sửa hoặc xóa thông tin cá nhân của họ bất kỳ lúc nào (ngoại trừ họ không thể thay đổi tên người dùng của họ). Quản trị viên trang web cũng có thể xem và chỉnh sửa thông tin đó.</p>\n<!-- /wp:paragraph -->\n<!-- wp:heading -->\n<h2 class=\"wp-block-heading\">Các quyền nào của bạn với dữ liệu của mình</h2>\n<!-- /wp:heading -->\n<!-- wp:paragraph -->\n<p><strong class=\"privacy-policy-tutorial\">Văn bản được đề xuất: </strong>Nếu bạn có tài khoản trên trang web này hoặc đã để lại nhận xét, bạn có thể yêu cầu nhận tệp xuất dữ liệu cá nhân mà chúng tôi lưu giữ về bạn, bao gồm mọi dữ liệu bạn đã cung cấp cho chúng tôi. Bạn cũng có thể yêu cầu chúng tôi xóa mọi dữ liệu cá nhân mà chúng tôi lưu giữ về bạn. Điều này không bao gồm bất kỳ dữ liệu nào chúng tôi có nghĩa vụ giữ cho các mục đích hành chính, pháp lý hoặc bảo mật.</p>\n<!-- /wp:paragraph -->\n<!-- wp:heading -->\n<h2 class=\"wp-block-heading\">Dữ liệu của bạn được gửi đến đâu</h2>\n<!-- /wp:heading -->\n<!-- wp:paragraph -->\n<p><strong class=\"privacy-policy-tutorial\">Văn bản được đề xuất: </strong>Các bình luận của khách (không phải là thành viên) có thể được kiểm tra thông qua dịch vụ tự động phát hiện spam.</p>\n<!-- /wp:paragraph -->\n', 'Chính sách bảo mật', '', 'draft', 'closed', 'open', '', 'chinh-sach-bao-mat', '', '', '2024-08-29 13:20:57', '2024-08-29 13:20:57', '', 0, 'http://datws.test/?page_id=3', 0, 'page', '', 0),
(4, 0, '2024-08-29 13:20:58', '2024-08-29 13:20:58', '<!-- wp:page-list /-->', 'Điều hướng', '', 'publish', 'closed', 'closed', '', 'navigation', '', '', '2024-08-29 13:20:58', '2024-08-29 13:20:58', '', 0, 'http://datws.test/2024/08/29/navigation/', 0, 'wp_navigation', '', 0),
(6, 1, '2024-08-29 13:39:31', '2024-08-29 13:39:31', '{\"version\": 3, \"isGlobalStylesUserThemeJSON\": true }', 'Custom Styles', '', 'publish', 'closed', 'closed', '', 'wp-global-styles-twentytwentyfour', '', '', '2024-08-29 13:39:31', '2024-08-29 13:39:31', '', 0, 'http://datws.test/2024/08/29/wp-global-styles-twentytwentyfour/', 0, 'wp_global_styles', '', 0),
(7, 1, '2018-07-18 11:03:22', '2018-07-18 11:03:22', '', 'pexels-photo-316778', '', 'inherit', 'open', 'closed', '', 'pexels-photo-316778', '', '', '2024-12-21 08:51:24', '2024-12-21 08:51:24', '', 267, 'https://demo.afthemes.com/storymag-pro/wp-content/uploads/2018/07/pexels-photo-316778.jpeg', 0, 'attachment', 'image/jpeg', 0),
(9, 1, '2024-11-26 14:26:13', '2024-11-26 14:26:13', '', 'Blue Simple Professional CV Resume', '', 'inherit', 'open', 'closed', '', 'blue-simple-professional-cv-resume', '', '', '2024-11-26 14:26:13', '2024-11-26 14:26:13', '', 0, 'http://datws.test/wp-content/uploads/2024/11/Blue-Simple-Professional-CV-Resume.pdf', 0, 'attachment', 'application/pdf', 0),
(10, 1, '2024-11-26 14:26:25', '2024-11-26 14:26:25', '', 'Screenshot 2024-11-02 201026', '', 'inherit', 'open', 'closed', '', 'screenshot-2024-11-02-201026', '', '', '2024-11-26 14:26:25', '2024-11-26 14:26:25', '', 0, 'http://datws.test/wp-content/uploads/2024/11/Screenshot-2024-11-02-201026.png', 0, 'attachment', 'image/png', 0),
(11, 1, '2024-11-26 14:26:49', '2024-11-26 14:26:49', '', 'fc0fb742a3a21155ea42f6786dd438c8', '', 'inherit', 'open', 'closed', '', 'fc0fb742a3a21155ea42f6786dd438c8', '', '', '2024-11-26 14:26:49', '2024-11-26 14:26:49', '', 0, 'http://datws.test/wp-content/uploads/2024/11/fc0fb742a3a21155ea42f6786dd438c8.jpg', 0, 'attachment', 'image/jpeg', 0),
(12, 1, '2024-11-26 14:27:13', '2024-11-26 14:27:13', '<!-- wp:group {\"align\":\"wide\",\"style\":{\"spacing\":{\"padding\":{\"top\":\"20px\",\"bottom\":\"20px\"}}},\"backgroundColor\":\"base\",\"layout\":{\"type\":\"constrained\"}} -->\n<div class=\"wp-block-group alignwide has-base-background-color has-background\" style=\"padding-top:20px;padding-bottom:20px\"><!-- wp:group {\"align\":\"wide\",\"layout\":{\"type\":\"flex\",\"justifyContent\":\"space-between\",\"flexWrap\":\"wrap\"}} -->\n<div class=\"wp-block-group alignwide\"><!-- wp:group {\"style\":{\"spacing\":{\"blockGap\":\"var:preset|spacing|20\"},\"layout\":{\"selfStretch\":\"fit\",\"flexSize\":null}},\"layout\":{\"type\":\"flex\"}} -->\n<div class=\"wp-block-group\"><!-- wp:site-logo {\"width\":60,\"shouldSyncIcon\":true} /-->\n\n<!-- wp:group {\"style\":{\"spacing\":{\"blockGap\":\"0px\"}}} -->\n<div class=\"wp-block-group\"><!-- wp:site-title {\"level\":0} /--></div>\n<!-- /wp:group --></div>\n<!-- /wp:group -->\n\n<!-- wp:group {\"layout\":{\"type\":\"flex\",\"flexWrap\":\"wrap\",\"justifyContent\":\"left\"}} -->\n<div class=\"wp-block-group\"><!-- wp:navigation {\"ref\":4,\"style\":{\"spacing\":{\"margin\":{\"top\":\"0\"},\"blockGap\":\"var:preset|spacing|20\"},\"layout\":{\"selfStretch\":\"fit\",\"flexSize\":null}},\"layout\":{\"type\":\"flex\",\"justifyContent\":\"right\",\"orientation\":\"horizontal\"}} /--></div>\n<!-- /wp:group --></div>\n<!-- /wp:group --></div>\n<!-- /wp:group -->', 'Đầu trang', '', 'publish', 'closed', 'closed', '', 'header', '', '', '2024-11-26 14:27:14', '2024-11-26 14:27:14', '', 0, 'http://datws.test/2024/11/26/header/', 0, 'wp_template_part', '', 0),
(13, 1, '2024-11-26 14:27:14', '2024-11-26 14:27:14', '<!-- wp:group {\"align\":\"wide\",\"style\":{\"spacing\":{\"padding\":{\"top\":\"20px\",\"bottom\":\"20px\"}}},\"backgroundColor\":\"base\",\"layout\":{\"type\":\"constrained\"}} -->\n<div class=\"wp-block-group alignwide has-base-background-color has-background\" style=\"padding-top:20px;padding-bottom:20px\"><!-- wp:group {\"align\":\"wide\",\"layout\":{\"type\":\"flex\",\"justifyContent\":\"space-between\",\"flexWrap\":\"wrap\"}} -->\n<div class=\"wp-block-group alignwide\"><!-- wp:group {\"style\":{\"spacing\":{\"blockGap\":\"var:preset|spacing|20\"},\"layout\":{\"selfStretch\":\"fit\",\"flexSize\":null}},\"layout\":{\"type\":\"flex\"}} -->\n<div class=\"wp-block-group\"><!-- wp:site-logo {\"width\":60,\"shouldSyncIcon\":true} /-->\n\n<!-- wp:group {\"style\":{\"spacing\":{\"blockGap\":\"0px\"}}} -->\n<div class=\"wp-block-group\"><!-- wp:site-title {\"level\":0} /--></div>\n<!-- /wp:group --></div>\n<!-- /wp:group -->\n\n<!-- wp:group {\"layout\":{\"type\":\"flex\",\"flexWrap\":\"wrap\",\"justifyContent\":\"left\"}} -->\n<div class=\"wp-block-group\"><!-- wp:navigation {\"ref\":4,\"style\":{\"spacing\":{\"margin\":{\"top\":\"0\"},\"blockGap\":\"var:preset|spacing|20\"},\"layout\":{\"selfStretch\":\"fit\",\"flexSize\":null}},\"layout\":{\"type\":\"flex\",\"justifyContent\":\"right\",\"orientation\":\"horizontal\"}} /--></div>\n<!-- /wp:group --></div>\n<!-- /wp:group --></div>\n<!-- /wp:group -->', 'Đầu trang', '', 'inherit', 'closed', 'closed', '', '12-revision-v1', '', '', '2024-11-26 14:27:14', '2024-11-26 14:27:14', '', 12, 'http://datws.test/?p=13', 0, 'revision', '', 0),
(14, 1, '2024-11-26 14:27:51', '2024-11-26 14:27:51', '', 'image', '', 'inherit', 'open', 'closed', '', 'image', '', '', '2024-11-26 14:27:51', '2024-11-26 14:27:51', '', 0, 'http://datws.test/wp-content/uploads/2024/11/image.webp', 0, 'attachment', 'image/webp', 0),
(15, 1, '2024-11-26 14:29:45', '2024-11-26 14:29:45', '', '644bd8a603f9ac1e492b78472b5cbd86', '', 'inherit', 'open', 'closed', '', '644bd8a603f9ac1e492b78472b5cbd86', '', '', '2024-11-26 14:29:45', '2024-11-26 14:29:45', '', 0, 'http://datws.test/wp-content/uploads/2024/11/644bd8a603f9ac1e492b78472b5cbd86.jpg', 0, 'attachment', 'image/jpeg', 0),
(16, 1, '2024-11-26 14:30:41', '2024-11-26 14:30:41', '', '12438d4c5d038a9f9153027c4a60c858', '', 'inherit', 'open', 'closed', '', '12438d4c5d038a9f9153027c4a60c858', '', '', '2024-11-26 14:30:41', '2024-11-26 14:30:41', '', 0, 'http://datws.test/wp-content/uploads/2024/11/12438d4c5d038a9f9153027c4a60c858.jpg', 0, 'attachment', 'image/jpeg', 0),
(17, 1, '2024-11-26 14:31:21', '2024-11-26 14:31:21', '', 'fc0fb742a3a21155ea42f6786dd438c8', '', 'inherit', 'open', 'closed', '', 'fc0fb742a3a21155ea42f6786dd438c8-2', '', '', '2024-11-26 14:31:21', '2024-11-26 14:31:21', '', 0, 'http://datws.test/wp-content/uploads/2024/11/fc0fb742a3a21155ea42f6786dd438c8-1.jpg', 0, 'attachment', 'image/jpeg', 0),
(18, 1, '2024-11-26 14:31:49', '2024-11-26 14:31:49', '', 'bdc11efc57757c81ac2f4477e71880a1', '', 'inherit', 'open', 'closed', '', 'bdc11efc57757c81ac2f4477e71880a1', '', '', '2024-11-26 14:31:49', '2024-11-26 14:31:49', '', 0, 'http://datws.test/wp-content/uploads/2024/11/bdc11efc57757c81ac2f4477e71880a1.jpg', 0, 'attachment', 'image/jpeg', 0),
(21, 1, '2024-12-21 08:50:46', '2024-12-21 08:50:46', '', 'Templatespare - log_file_2024-12-21__08-50-46', '', 'inherit', 'open', 'closed', '', 'templatespare-log_file_2024-12-21__08-50-46', '', '', '2024-12-21 08:50:46', '2024-12-21 08:50:46', '', 0, 'http://datws.test/wp-content/uploads/2024/12/log_file_2024-12-21__08-50-46.txt', 0, 'attachment', 'text/plain', 0),
(22, 1, '2018-07-18 11:07:22', '2018-07-18 11:07:22', '', 'pexels-photo-261949 (1)', '', 'inherit', 'open', 'closed', '', 'pexels-photo-261949-1', '', '', '2024-12-21 08:51:24', '2024-12-21 08:51:24', '', 963, 'https://demo.afthemes.com/storymag-pro/wp-content/uploads/2018/07/pexels-photo-261949-1.jpeg', 0, 'attachment', 'image/jpeg', 0),
(23, 1, '2018-07-18 11:10:35', '2018-07-18 11:10:35', '', 'pexels-photo-258117', '', 'inherit', 'open', 'closed', '', 'pexels-photo-258117', '', '', '2024-12-21 08:51:24', '2024-12-21 08:51:24', '', 964, 'https://demo.afthemes.com/storymag-pro/wp-content/uploads/2018/07/pexels-photo-258117.jpeg', 0, 'attachment', 'image/jpeg', 0),
(24, 1, '2018-07-18 11:16:39', '2018-07-18 11:16:39', '', 'pexels-photo-58461 (1)', '', 'inherit', 'open', 'closed', '', 'pexels-photo-58461-1', '', '', '2024-12-21 08:51:24', '2024-12-21 08:51:24', '', 965, 'https://demo.afthemes.com/storymag-pro/wp-content/uploads/2018/07/pexels-photo-58461-1.jpeg', 0, 'attachment', 'image/jpeg', 0),
(25, 1, '2018-07-18 11:24:47', '2018-07-18 11:24:47', '', 'pexels-photo-263210 (1)', '', 'inherit', 'open', 'closed', '', 'pexels-photo-263210-1', '', '', '2024-12-21 08:51:24', '2024-12-21 08:51:24', '', 966, 'https://demo.afthemes.com/storymag-pro/wp-content/uploads/2018/07/pexels-photo-263210-1.jpeg', 0, 'attachment', 'image/jpeg', 0),
(34, 1, '2018-07-18 11:50:16', '2018-07-18 11:50:16', 'Cursus impedit aspernatur doloribus montes doloribus justo debitis natus felis auctor nunc! Sint!', 'bar-local-cong-ireland-38286', 'Cursus impedit aspernatur doloribus montes doloribus justo debitis natus felis auctor nunc! Sint!', 'inherit', 'open', 'closed', '', 'bar-local-cong-ireland-38286', '', '', '2024-12-21 08:51:24', '2024-12-21 08:51:24', '', 971, 'https://demo.afthemes.com/storymag-pro/wp-content/uploads/2018/07/bar-local-cong-ireland-38286.jpeg', 0, 'attachment', 'image/jpeg', 0);
INSERT INTO `wp_posts` (`ID`, `post_author`, `post_date`, `post_date_gmt`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `ping_status`, `post_password`, `post_name`, `to_ping`, `pinged`, `post_modified`, `post_modified_gmt`, `post_content_filtered`, `post_parent`, `guid`, `menu_order`, `post_type`, `post_mime_type`, `comment_count`) VALUES
(37, 1, '2018-07-18 11:55:09', '2018-07-18 11:55:09', '<!-- wp:blockspare/blockspare-container {\"paddingTop\":0,\"paddingRight\":0,\"paddingLeft\":0,\"marginTop\":0,\"marginBottom\":0,\"uniqueClass\":\"blockspare-10c2495f-f077-4\",\"backGroundColor\":\"#f5f5f5\"} -->\n<div class=\"wp-block-blockspare-blockspare-container alignfull blockspare-10c2495f-f077-4\" blockspare-animation=\"\"><style>.blockspare-10c2495f-f077-4 > .blockspare-block-container-wrapper{background-color:#f5f5f5;padding-top:0px;padding-right:0px;padding-bottom:20px;padding-left:0px;margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;border-radius:0}.blockspare-10c2495f-f077-4 .blockspare-image-wrap{background-image:none}</style><div class=\"blockspare-block-container-wrapper blockspare-hover-item\"><div class=\"blockspare-container-background blockspare-image-wrap has-background-opacity-100 has-background-opacity\"></div><div class=\"blockspare-container\"><div class=\"blockspare-inner-blocks blockspare-inner-wrapper-blocks\"><!-- wp:group {\"align\":\"full\",\"style\":{\"spacing\":{\"padding\":{\"right\":\"20px\",\"left\":\"20px\",\"top\":\"0\",\"bottom\":\"0\"}}},\"layout\":{\"type\":\"constrained\"}} -->\n<div class=\"wp-block-group alignfull\" style=\"padding-top:0;padding-right:20px;padding-bottom:0;padding-left:20px\"><!-- wp:blockspare/latest-posts-flash {\"uniqueClass\":\"blockspare-31d27a32-9118-4\",\"postTitleColor\":\"#404040\",\"titleFontFamily\":\"Source Sans Pro\",\"titleFontWeight\":\"600\",\"titleFontSizeMobile\":14,\"titleLoadGoogleFonts\":true,\"exclusiveColor\":\"#ffffff\",\"exclusiveBgColor\":\"#003bb3\",\"marginTop\":20,\"backGroundColor\":\"#fefefe\",\"titleOnHoverColor\":\"#bb1919\",\"animation\":\"AFTfadeInDown\",\"exclusiveFontFamily\":\"Source Sans Pro\",\"exclusiveFontWeight\":\"600\",\"exclusiveFontSizeTablet\":16,\"exclusiveLoadGoogleFonts\":true,\"newsColor\":\"#fefefe\",\"newsBgColor\":\"#bb1919\"} /-->\n\n<!-- wp:blockspare/blockspare-banner-9 {\"uniqueClass\":\"blockspare-57e1dc04-8828-4\",\"bannerNineTrendingBg\":\"#fefefe\",\"sliderCategoryBackgroundColor\":\"#bb1919\",\"sliderPostGeneralColor\":\"#ffffff99\",\"sliderPostLinkColor\":\"#ffffff99\",\"sliderTitleFontSize\":35,\"sliderTitleFontFamily\":\"Source Sans Pro\",\"sliderTitleFontWeight\":\"600\",\"sliderTitleFontSizeTablet\":24,\"sliderTitleLoadGoogleFonts\":true,\"sliderTitleLineHeight\":1.3,\"sliderCategoryFontSize\":11,\"sliderCategoryFontFamily\":\"Source Sans Pro\",\"sliderCategoryFontSizeMobile\":11,\"sliderCategoryFontSizeTablet\":11,\"sliderCategoryLoadGoogleFonts\":true,\"sliderTitleOnHoverColor\":\"#fefefe\",\"editorCategoryBackgroundColor\":\"#0098fe\",\"editorPostGeneralColor\":\"#ffffff99\",\"editorPostLinkColor\":\"#ffffff99\",\"editorTitleFontSize\":18,\"editorTitleFontFamily\":\"Source Sans Pro\",\"editorTitleFontWeight\":\"600\",\"editorTitleFontSizeMobile\":16,\"editorTitleFontSizeTablet\":18,\"editorTitleLoadGoogleFonts\":true,\"editorCategoryFontSize\":11,\"editorCategoryFontFamily\":\"Source Sans Pro\",\"editorCategoryFontSizeMobile\":11,\"editorCategoryFontSizeTablet\":11,\"editorCategoryLoadGoogleFonts\":true,\"editorTitleLineHeight\":1.3,\"editorDisplayPostAuthor\":true,\"editorDisplayPostDate\":true,\"editorTitleOnHoverColor\":\"#fefefe\",\"trendingPostTitleColor\":\"#404040\",\"trendingTitleFontFamily\":\"Source Sans Pro\",\"trendingTitleFontWeight\":\"600\",\"trendingTitleLoadGoogleFonts\":true,\"trendingTitleLineHeight\":1.3,\"trendingDisplayPostCategory\":true,\"trendingCategoryFontSize\":11,\"trendingCategoryFontFamily\":\"Source Sans Pro\",\"trendingCategoryFontSizeMobile\":11,\"trendingCategoryFontSizeTablet\":11,\"trendingCategoryLoadGoogleFonts\":true,\"trendingCategoryLayoutOption\":\"none\",\"trendingCategoryTextColor\":\"#0098fe\",\"trendingTitleOnHoverColor\":\"#0098fe\",\"marginTop\":20,\"marginBottom\":20,\"trendingCategoryMarginBottom\":10,\"gutter\":15} /--></div>\n<!-- /wp:group -->\n\n<!-- wp:group {\"align\":\"full\",\"style\":{\"spacing\":{\"blockGap\":\"0px\",\"padding\":{\"right\":\"20px\",\"left\":\"20px\",\"top\":\"0\",\"bottom\":\"0\"},\"margin\":{\"top\":\"0\",\"bottom\":\"0\"}}},\"layout\":{\"type\":\"constrained\"}} -->\n<div class=\"wp-block-group alignfull\" style=\"margin-top:0;margin-bottom:0;padding-top:0;padding-right:20px;padding-bottom:0;padding-left:20px\"><!-- wp:blockspare/blockspare-section-header {\"uniqueClass\":\"blockspare-57cc65c0-8212-4\",\"align\":\"wide\",\"headerTitle\":\"Featured News\",\"titleFontSize\":20,\"headermarginTop\":0,\"headermarginBottom\":7,\"headerlayoutOption\":\"blockspare-style10\",\"dashColor\":\"#0098fe\",\"dashColor2\":\"#00000012\",\"titleFontFamily\":\"Source Sans Pro\",\"titleFontWeight\":\"700\",\"titleFontSizeTablet\":20,\"titleLoadGoogleFonts\":true} -->\n<div class=\"wp-block-blockspare-blockspare-section-header alignwide blockspare-57cc65c0-8212-4 blockspare-section-header-wrapper blockspare-blocks alignwide\" blockspare-animation=\"\"><style>.blockspare-57cc65c0-8212-4 .blockspare-section-head-wrap{background-color:transparent;text-align:left;margin-top:0px;margin-right:0px;margin-bottom:7px;margin-left:0px}.blockspare-57cc65c0-8212-4 .blockspare-section-head-wrap .blockspare-title{color:#404040;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px;font-size:20px;font-family:Source Sans Pro;font-weight:700}.blockspare-57cc65c0-8212-4 .blockspare-section-head-wrap .blockspare-title-wrapper .blockspare-title-dash.blockspare-lower-dash::before{background-color:#0098fe!important}.blockspare-57cc65c0-8212-4 .blockspare-section-head-wrap .blockspare-title-wrapper .blockspare-lower-dash{background-color:#00000012!important}.blockspare-57cc65c0-8212-4 .blockspare-section-head-wrap .blockspare-subtitle{color:#6d6d6d;font-size:14px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px}@media screen and (max-width:1025px){.blockspare-57cc65c0-8212-4 .blockspare-section-head-wrap .blockspare-title{font-size:20px}.blockspare-57cc65c0-8212-4 .blockspare-section-head-wrap .blockspare-subtitle{font-size:14px}}@media screen and (max-width:768px){.blockspare-57cc65c0-8212-4 .blockspare-section-head-wrap .blockspare-title{font-size:20px}.blockspare-57cc65c0-8212-4 .blockspare-section-head-wrap .blockspare-subtitle{font-size:14px}}</style><div class=\"blockspare-section-head-wrap blockspare-style10 blockspare-left blockspare-hover-item\"><div class=\"blockspare-title-wrapper\"><span class=\"blockspare-title-dash blockspare-upper-dash\"></span><h2 class=\"blockspare-title\">Featured News</h2><span class=\"blockspare-title-dash blockspare-lower-dash\"></span></div><div class=\"blockspare-subtitle-wrapper\"><span class=\"blockspare-title-dash blockspare-upper-dash\"></span><span class=\"blockspare-title-dash blockspare-lower-dash\"></span></div></div></div>\n<!-- /wp:blockspare/blockspare-section-header -->\n\n<!-- wp:blockspare/blockspare-latest-posts-grid {\"taxType\":\"\",\"uniqueClass\":\"blockspare-430d222a-5ccd-4\",\"displayPostAuthor\":false,\"postTitleFontSize\":18,\"titleFontFamily\":\"Source Sans Pro\",\"titleFontWeight\":\"600\",\"titleFontSizeTablet\":18,\"titleLoadGoogleFonts\":true,\"linkColor\":\"#9a9a9a\",\"generalColor\":\"#9a9a9a\",\"columns\":4,\"align\":\"wide\",\"imageSize\":\"medium\",\"marginTop\":0,\"marginBottom\":0,\"backGroundColor\":\"#ffffff\",\"titleMarginTop\":0,\"metaMarginTop\":0,\"metaMarginBottom\":0,\"categoryBackgroundColor\":\"#0098fe\",\"categoryBorderRadius\":1,\"titleOnHoverColor\":\"#0098fe\",\"animation\":\"AFTfadeInDown\",\"gutterSpace\":15,\"postTitleLineHeight\":1.3,\"postCategoryFontSize\":11,\"postCategoryFontFamily\":\"Source Sans Pro\",\"postCategoryFontSizeMobile\":11,\"postCategoryFontSizeTablet\":11,\"postCategoryLoadGoogleFonts\":true,\"postMetaFontFamily\":\"Source Sans Pro\",\"postMetaLoadGoogleFonts\":true} /--></div>\n<!-- /wp:group -->\n\n<!-- wp:group {\"align\":\"full\",\"style\":{\"spacing\":{\"padding\":{\"right\":\"20px\",\"left\":\"20px\",\"top\":\"0\",\"bottom\":\"0\"}}},\"layout\":{\"type\":\"constrained\"}} -->\n<div class=\"wp-block-group alignfull\" style=\"padding-top:0;padding-right:20px;padding-bottom:0;padding-left:20px\"><!-- wp:columns {\"align\":\"wide\",\"style\":{\"spacing\":{\"margin\":{\"top\":\"20px\",\"bottom\":\"0\"},\"padding\":{\"right\":\"0\",\"left\":\"0\",\"top\":\"0\",\"bottom\":\"0\"},\"blockGap\":{\"top\":\"15px\",\"left\":\"15px\"}}}} -->\n<div class=\"wp-block-columns alignwide\" style=\"margin-top:20px;margin-bottom:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0\"><!-- wp:column {\"width\":\"70%\"} -->\n<div class=\"wp-block-column\" style=\"flex-basis:70%\"><!-- wp:image {\"id\":1538,\"sizeSlug\":\"large\",\"linkDestination\":\"custom\"} -->\n<figure class=\"wp-block-image size-large\"><a href=\"https://afthemes.com/products/covernews-pro/\" target=\"_blank\" rel=\"noreferrer noopener\"><img src=\"https://www.blockspare.com/demo/playground/wp-content/uploads/2024/02/vertical-promo-red-news-1024x109.jpeg\" alt=\"\" class=\"wp-image-1538\"/></a></figure>\n<!-- /wp:image -->\n\n<!-- wp:group {\"align\":\"wide\",\"style\":{\"spacing\":{\"blockGap\":\"0\",\"padding\":{\"top\":\"0\",\"bottom\":\"0\",\"left\":\"0\",\"right\":\"0\"}}},\"layout\":{\"type\":\"constrained\"}} -->\n<div class=\"wp-block-group alignwide\" style=\"padding-top:0;padding-right:0;padding-bottom:0;padding-left:0\"><!-- wp:blockspare/blockspare-section-header {\"uniqueClass\":\"blockspare-cdcd0f09-9a94-4\",\"align\":\"full\",\"headerTitle\":\"Express Grid\",\"titleFontSize\":20,\"headermarginTop\":20,\"headermarginBottom\":7,\"headerlayoutOption\":\"blockspare-style10\",\"dashColor\":\"#0098fe\",\"dashColor2\":\"#00000012\",\"titleFontFamily\":\"Source Sans Pro\",\"titleFontWeight\":\"700\",\"titleFontSizeTablet\":20,\"titleLoadGoogleFonts\":true} -->\n<div class=\"wp-block-blockspare-blockspare-section-header alignfull blockspare-cdcd0f09-9a94-4 blockspare-section-header-wrapper blockspare-blocks alignfull\" blockspare-animation=\"\"><style>.blockspare-cdcd0f09-9a94-4 .blockspare-section-head-wrap{background-color:transparent;text-align:left;margin-top:20px;margin-right:0px;margin-bottom:7px;margin-left:0px}.blockspare-cdcd0f09-9a94-4 .blockspare-section-head-wrap .blockspare-title{color:#404040;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px;font-size:20px;font-family:Source Sans Pro;font-weight:700}.blockspare-cdcd0f09-9a94-4 .blockspare-section-head-wrap .blockspare-title-wrapper .blockspare-title-dash.blockspare-lower-dash::before{background-color:#0098fe!important}.blockspare-cdcd0f09-9a94-4 .blockspare-section-head-wrap .blockspare-title-wrapper .blockspare-lower-dash{background-color:#00000012!important}.blockspare-cdcd0f09-9a94-4 .blockspare-section-head-wrap .blockspare-subtitle{color:#6d6d6d;font-size:14px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px}@media screen and (max-width:1025px){.blockspare-cdcd0f09-9a94-4 .blockspare-section-head-wrap .blockspare-title{font-size:20px}.blockspare-cdcd0f09-9a94-4 .blockspare-section-head-wrap .blockspare-subtitle{font-size:14px}}@media screen and (max-width:768px){.blockspare-cdcd0f09-9a94-4 .blockspare-section-head-wrap .blockspare-title{font-size:20px}.blockspare-cdcd0f09-9a94-4 .blockspare-section-head-wrap .blockspare-subtitle{font-size:14px}}</style><div class=\"blockspare-section-head-wrap blockspare-style10 blockspare-left blockspare-hover-item\"><div class=\"blockspare-title-wrapper\"><span class=\"blockspare-title-dash blockspare-upper-dash\"></span><h2 class=\"blockspare-title\">Express Grid</h2><span class=\"blockspare-title-dash blockspare-lower-dash\"></span></div><div class=\"blockspare-subtitle-wrapper\"><span class=\"blockspare-title-dash blockspare-upper-dash\"></span><span class=\"blockspare-title-dash blockspare-lower-dash\"></span></div></div></div>\n<!-- /wp:blockspare/blockspare-section-header -->\n\n<!-- wp:blockspare/latest-posts-express-grid {\"uniqueClass\":\"blockspare-9da2647f-a60a-4\",\"postsToShow\":6,\"displayPostAuthor\":false,\"postTitleColor\":\"#404040\",\"titleFontFamily\":\"Source Sans Pro\",\"titleFontWeight\":\"600\",\"titleLoadGoogleFonts\":true,\"linkColor\":\"#9a9a9a\",\"generalColor\":\"#9a9a9a\",\"express\":\"blockspare-posts-block-express-grid-layout-2\",\"excerptLength\":30,\"marginTop\":0,\"marginBottom\":0,\"backGroundColor\":\"#ffffff\",\"descriptionFontFamily\":\"Lato\",\"descriptionLoadGoogleFonts\":true,\"titleMarginTop\":0,\"titleMarginBottom\":0,\"metaMarginBottom\":0,\"exceprtMarginTop\":10,\"categoryBackgroundColor\":\"#0098fe\",\"spostTitleFontSize\":27,\"spostTitleFontFamily\":\"Source Sans Pro\",\"spostTitleFontWeight\":\"600\",\"spostTitleFontSizeMobile\":20,\"spostTitleFontSizeTablet\":22,\"spostTitleLoadGoogleFonts\":true,\"titleOnHoverColor\":\"#0098fe\",\"animation\":\"AFTfadeInLeft\",\"gutterSpace\":15,\"postTitleLineHeight\":1.3,\"postCategoryFontSize\":11,\"postCategoryFontFamily\":\"Source Sans Pro\",\"postCategoryFontSizeMobile\":11,\"postCategoryFontSizeTablet\":11,\"postCategoryLoadGoogleFonts\":true,\"postMetaFontFamily\":\"Source Sans Pro\",\"postMetaLoadGoogleFonts\":true} /--></div>\n<!-- /wp:group -->\n\n<!-- wp:group {\"align\":\"wide\",\"style\":{\"spacing\":{\"blockGap\":\"0\",\"padding\":{\"top\":\"0\",\"bottom\":\"0\",\"left\":\"0\",\"right\":\"0\"}}},\"layout\":{\"type\":\"constrained\",\"justifyContent\":\"left\"}} -->\n<div class=\"wp-block-group alignwide\" style=\"padding-top:0;padding-right:0;padding-bottom:0;padding-left:0\"><!-- wp:blockspare/blockspare-section-header {\"uniqueClass\":\"blockspare-29d90f65-2a8a-4\",\"align\":\"full\",\"headerTitle\":\"Post Slider\",\"titleFontSize\":20,\"headermarginTop\":20,\"headermarginBottom\":7,\"headerlayoutOption\":\"blockspare-style10\",\"dashColor\":\"#0098fe\",\"dashColor2\":\"#00000012\",\"titleFontFamily\":\"Source Sans Pro\",\"titleFontWeight\":\"700\",\"titleFontSizeTablet\":20,\"titleLoadGoogleFonts\":true} -->\n<div class=\"wp-block-blockspare-blockspare-section-header alignfull blockspare-29d90f65-2a8a-4 blockspare-section-header-wrapper blockspare-blocks alignfull\" blockspare-animation=\"\"><style>.blockspare-29d90f65-2a8a-4 .blockspare-section-head-wrap{background-color:transparent;text-align:left;margin-top:20px;margin-right:0px;margin-bottom:7px;margin-left:0px}.blockspare-29d90f65-2a8a-4 .blockspare-section-head-wrap .blockspare-title{color:#404040;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px;font-size:20px;font-family:Source Sans Pro;font-weight:700}.blockspare-29d90f65-2a8a-4 .blockspare-section-head-wrap .blockspare-title-wrapper .blockspare-title-dash.blockspare-lower-dash::before{background-color:#0098fe!important}.blockspare-29d90f65-2a8a-4 .blockspare-section-head-wrap .blockspare-title-wrapper .blockspare-lower-dash{background-color:#00000012!important}.blockspare-29d90f65-2a8a-4 .blockspare-section-head-wrap .blockspare-subtitle{color:#6d6d6d;font-size:14px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px}@media screen and (max-width:1025px){.blockspare-29d90f65-2a8a-4 .blockspare-section-head-wrap .blockspare-title{font-size:20px}.blockspare-29d90f65-2a8a-4 .blockspare-section-head-wrap .blockspare-subtitle{font-size:14px}}@media screen and (max-width:768px){.blockspare-29d90f65-2a8a-4 .blockspare-section-head-wrap .blockspare-title{font-size:20px}.blockspare-29d90f65-2a8a-4 .blockspare-section-head-wrap .blockspare-subtitle{font-size:14px}}</style><div class=\"blockspare-section-head-wrap blockspare-style10 blockspare-left blockspare-hover-item\"><div class=\"blockspare-title-wrapper\"><span class=\"blockspare-title-dash blockspare-upper-dash\"></span><h2 class=\"blockspare-title\">Post Slider</h2><span class=\"blockspare-title-dash blockspare-lower-dash\"></span></div><div class=\"blockspare-subtitle-wrapper\"><span class=\"blockspare-title-dash blockspare-upper-dash\"></span><span class=\"blockspare-title-dash blockspare-lower-dash\"></span></div></div></div>\n<!-- /wp:blockspare/blockspare-section-header -->\n\n<!-- wp:blockspare/blockspare-posts-block-slider {\"uniqueClass\":\"blockspare-a12509d9-5112-4\",\"postTitleFontSize\":32,\"titleFontFamily\":\"Source Sans Pro\",\"titleFontWeight\":\"600\",\"titleFontSizeMobile\":20,\"titleFontSizeTablet\":22,\"titleLoadGoogleFonts\":true,\"slider\":\"blockspare-posts-block-full-layout-4\",\"fullPostLinkColor\":\"#ffffff99\",\"fullPostGeneralColor\":\"#ffffff99\",\"align\":\"full\",\"marginTop\":0,\"marginBottom\":20,\"lineHeight\":1.3,\"titleMarginTop\":0,\"titleMarginBottom\":0,\"tileCategoryBackgroundColor\":\"#0098fe\",\"postCategoryFontSize\":11,\"postCategoryFontFamily\":\"Source Sans Pro\",\"postCategoryFontSizeMobile\":11,\"postCategoryFontSizeTablet\":11,\"postCategoryLoadGoogleFonts\":true,\"postMetaFontFamily\":\"Source Sans Pro\",\"postMetaLoadGoogleFonts\":true} /--></div>\n<!-- /wp:group -->\n\n<!-- wp:image {\"id\":1538,\"sizeSlug\":\"large\",\"linkDestination\":\"custom\"} -->\n<figure class=\"wp-block-image size-large\"><a href=\"https://afthemes.com/products/covernews-pro/\" target=\"_blank\" rel=\"noreferrer noopener\"><img src=\"https://www.blockspare.com/demo/playground/wp-content/uploads/2024/02/vertical-promo-red-news-1024x109.jpeg\" alt=\"\" class=\"wp-image-1538\"/></a></figure>\n<!-- /wp:image -->\n\n<!-- wp:group {\"align\":\"wide\",\"style\":{\"spacing\":{\"blockGap\":\"0\",\"padding\":{\"top\":\"0\",\"bottom\":\"0\",\"left\":\"0\",\"right\":\"0\"}}},\"layout\":{\"type\":\"constrained\"}} -->\n<div class=\"wp-block-group alignwide\" style=\"padding-top:0;padding-right:0;padding-bottom:0;padding-left:0\"><!-- wp:blockspare/blockspare-section-header {\"uniqueClass\":\"blockspare-6f604f0f-75e0-4\",\"align\":\"full\",\"headerTitle\":\"Post Grid\",\"titleFontSize\":20,\"headermarginTop\":20,\"headermarginBottom\":7,\"headerlayoutOption\":\"blockspare-style10\",\"dashColor\":\"#0098fe\",\"dashColor2\":\"#00000012\",\"titleFontFamily\":\"Source Sans Pro\",\"titleFontWeight\":\"700\",\"titleFontSizeTablet\":20,\"titleLoadGoogleFonts\":true} -->\n<div class=\"wp-block-blockspare-blockspare-section-header alignfull blockspare-6f604f0f-75e0-4 blockspare-section-header-wrapper blockspare-blocks alignfull\" blockspare-animation=\"\"><style>.blockspare-6f604f0f-75e0-4 .blockspare-section-head-wrap{background-color:transparent;text-align:left;margin-top:20px;margin-right:0px;margin-bottom:7px;margin-left:0px}.blockspare-6f604f0f-75e0-4 .blockspare-section-head-wrap .blockspare-title{color:#404040;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px;font-size:20px;font-family:Source Sans Pro;font-weight:700}.blockspare-6f604f0f-75e0-4 .blockspare-section-head-wrap .blockspare-title-wrapper .blockspare-title-dash.blockspare-lower-dash::before{background-color:#0098fe!important}.blockspare-6f604f0f-75e0-4 .blockspare-section-head-wrap .blockspare-title-wrapper .blockspare-lower-dash{background-color:#00000012!important}.blockspare-6f604f0f-75e0-4 .blockspare-section-head-wrap .blockspare-subtitle{color:#6d6d6d;font-size:14px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px}@media screen and (max-width:1025px){.blockspare-6f604f0f-75e0-4 .blockspare-section-head-wrap .blockspare-title{font-size:20px}.blockspare-6f604f0f-75e0-4 .blockspare-section-head-wrap .blockspare-subtitle{font-size:14px}}@media screen and (max-width:768px){.blockspare-6f604f0f-75e0-4 .blockspare-section-head-wrap .blockspare-title{font-size:20px}.blockspare-6f604f0f-75e0-4 .blockspare-section-head-wrap .blockspare-subtitle{font-size:14px}}</style><div class=\"blockspare-section-head-wrap blockspare-style10 blockspare-left blockspare-hover-item\"><div class=\"blockspare-title-wrapper\"><span class=\"blockspare-title-dash blockspare-upper-dash\"></span><h2 class=\"blockspare-title\">Post Grid</h2><span class=\"blockspare-title-dash blockspare-lower-dash\"></span></div><div class=\"blockspare-subtitle-wrapper\"><span class=\"blockspare-title-dash blockspare-upper-dash\"></span><span class=\"blockspare-title-dash blockspare-lower-dash\"></span></div></div></div>\n<!-- /wp:blockspare/blockspare-section-header -->\n\n<!-- wp:blockspare/blockspare-latest-posts-grid {\"uniqueClass\":\"blockspare-3a008547-0fbb-4\",\"postsToShow\":6,\"displayPostExcerpt\":true,\"displayPostAuthor\":false,\"titleFontFamily\":\"Source Sans Pro\",\"titleFontWeight\":\"600\",\"titleLoadGoogleFonts\":true,\"linkColor\":\"#9a9a9a\",\"generalColor\":\"#9a9a9a\",\"columns\":3,\"align\":\"full\",\"marginTop\":0,\"marginBottom\":0,\"backGroundColor\":\"#ffffff\",\"titleMarginTop\":0,\"titleMarginBottom\":0,\"metaMarginBottom\":0,\"moreLinkMarginBottom\":0,\"categoryBackgroundColor\":\"#0098fe\",\"titleOnHoverColor\":\"#0098fe\",\"animation\":\"AFTfadeInUp\",\"gutterSpace\":15,\"postCategoryFontSize\":11,\"postCategoryFontFamily\":\"Source Sans Pro\",\"postCategoryFontSizeMobile\":11,\"postCategoryFontSizeTablet\":11,\"postCategoryLoadGoogleFonts\":true,\"postMetaFontFamily\":\"Source Sans Pro\",\"postMetaLoadGoogleFonts\":true} /--></div>\n<!-- /wp:group -->\n\n<!-- wp:group {\"align\":\"full\",\"style\":{\"spacing\":{\"blockGap\":\"0\",\"padding\":{\"right\":\"0px\",\"left\":\"0px\",\"top\":\"0\",\"bottom\":\"0\"}}},\"layout\":{\"type\":\"constrained\"}} -->\n<div class=\"wp-block-group alignfull\" style=\"padding-top:0;padding-right:0px;padding-bottom:0;padding-left:0px\"><!-- wp:blockspare/blockspare-section-header {\"uniqueClass\":\"blockspare-dbe312db-4960-4\",\"align\":\"wide\",\"headerTitle\":\"Post Carousel\",\"titleFontSize\":20,\"headermarginTop\":20,\"headermarginBottom\":7,\"headerlayoutOption\":\"blockspare-style10\",\"dashColor\":\"#0098fe\",\"dashColor2\":\"#00000012\",\"titleFontFamily\":\"Source Sans Pro\",\"titleFontWeight\":\"700\",\"titleFontSizeTablet\":20,\"titleLoadGoogleFonts\":true} -->\n<div class=\"wp-block-blockspare-blockspare-section-header alignwide blockspare-dbe312db-4960-4 blockspare-section-header-wrapper blockspare-blocks alignwide\" blockspare-animation=\"\"><style>.blockspare-dbe312db-4960-4 .blockspare-section-head-wrap{background-color:transparent;text-align:left;margin-top:20px;margin-right:0px;margin-bottom:7px;margin-left:0px}.blockspare-dbe312db-4960-4 .blockspare-section-head-wrap .blockspare-title{color:#404040;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px;font-size:20px;font-family:Source Sans Pro;font-weight:700}.blockspare-dbe312db-4960-4 .blockspare-section-head-wrap .blockspare-title-wrapper .blockspare-title-dash.blockspare-lower-dash::before{background-color:#0098fe!important}.blockspare-dbe312db-4960-4 .blockspare-section-head-wrap .blockspare-title-wrapper .blockspare-lower-dash{background-color:#00000012!important}.blockspare-dbe312db-4960-4 .blockspare-section-head-wrap .blockspare-subtitle{color:#6d6d6d;font-size:14px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px}@media screen and (max-width:1025px){.blockspare-dbe312db-4960-4 .blockspare-section-head-wrap .blockspare-title{font-size:20px}.blockspare-dbe312db-4960-4 .blockspare-section-head-wrap .blockspare-subtitle{font-size:14px}}@media screen and (max-width:768px){.blockspare-dbe312db-4960-4 .blockspare-section-head-wrap .blockspare-title{font-size:20px}.blockspare-dbe312db-4960-4 .blockspare-section-head-wrap .blockspare-subtitle{font-size:14px}}</style><div class=\"blockspare-section-head-wrap blockspare-style10 blockspare-left blockspare-hover-item\"><div class=\"blockspare-title-wrapper\"><span class=\"blockspare-title-dash blockspare-upper-dash\"></span><h2 class=\"blockspare-title\">Post Carousel</h2><span class=\"blockspare-title-dash blockspare-lower-dash\"></span></div><div class=\"blockspare-subtitle-wrapper\"><span class=\"blockspare-title-dash blockspare-upper-dash\"></span><span class=\"blockspare-title-dash blockspare-lower-dash\"></span></div></div></div>\n<!-- /wp:blockspare/blockspare-section-header -->\n\n<!-- wp:blockspare/latest-posts-block-carousel-grid {\"uniqueClass\":\"blockspare-5c9a1fa9-b756-4\",\"postsToShow\":5,\"displayPostAuthor\":false,\"titleFontFamily\":\"Source Sans Pro\",\"titleFontWeight\":\"600\",\"titleLoadGoogleFonts\":true,\"linkColor\":\"#9a9a9a\",\"generalColor\":\"#9a9a9a\",\"align\":\"wide\",\"marginTop\":0,\"marginBottom\":20,\"backGroundColor\":\"#ffffff\",\"lineHeight\":1.3,\"titleMarginTop\":0,\"titleMarginBottom\":0,\"metaMarginBottom\":0,\"moreLinkMarginBottom\":0,\"categoryTextColor\":\"#ffffff\",\"categoryBackgroundColor\":\"#0098fe\",\"gutterSpace\":3,\"numberofSlide\":3,\"titleOnHoverColor\":\"#0098fe\",\"animation\":\"AFTfadeInLeft\",\"postCategoryFontSize\":11,\"postCategoryFontFamily\":\"Source Sans Pro\",\"postCategoryFontSizeMobile\":11,\"postCategoryFontSizeTablet\":11,\"postCategoryLoadGoogleFonts\":true,\"postMetaFontFamily\":\"Source Sans Pro\",\"postMetaLoadGoogleFonts\":true} /--></div>\n<!-- /wp:group -->\n\n<!-- wp:image {\"id\":1538,\"sizeSlug\":\"large\",\"linkDestination\":\"custom\"} -->\n<figure class=\"wp-block-image size-large\"><a href=\"https://afthemes.com/products/covernews-pro/\" target=\"_blank\" rel=\"noreferrer noopener\"><img src=\"https://www.blockspare.com/demo/playground/wp-content/uploads/2024/02/vertical-promo-red-news-1024x109.jpeg\" alt=\"\" class=\"wp-image-1538\"/></a></figure>\n<!-- /wp:image --></div>\n<!-- /wp:column -->\n\n<!-- wp:column {\"width\":\"30%\",\"className\":\"sidebar-sticky-top\"} -->\n<div class=\"wp-block-column sidebar-sticky-top\" style=\"flex-basis:30%\"><!-- wp:group {\"align\":\"wide\",\"style\":{\"spacing\":{\"padding\":{\"top\":\"0\",\"bottom\":\"0\",\"left\":\"0\",\"right\":\"0\"},\"margin\":{\"top\":\"0\",\"bottom\":\"0\"}},\"position\":{\"type\":\"sticky\",\"top\":\"0px\"}},\"layout\":{\"type\":\"constrained\"}} -->\n<div class=\"wp-block-group alignwide\" style=\"margin-top:0;margin-bottom:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0\"><!-- wp:group {\"style\":{\"spacing\":{\"blockGap\":\"0\",\"padding\":{\"top\":\"0\",\"bottom\":\"0\",\"left\":\"0\",\"right\":\"0\"}}}} -->\n<div class=\"wp-block-group\" style=\"padding-top:0;padding-right:0;padding-bottom:0;padding-left:0\"><!-- wp:blockspare/blockspare-section-header {\"uniqueClass\":\"blockspare-ab56322e-f98f-4\",\"align\":\"full\",\"headerTitle\":\"About Author\",\"titleFontSize\":20,\"headermarginTop\":0,\"headermarginBottom\":7,\"headerlayoutOption\":\"blockspare-style10\",\"dashColor\":\"#0098fe\",\"dashColor2\":\"#00000012\",\"titleFontFamily\":\"Source Sans Pro\",\"titleFontWeight\":\"700\",\"titleFontSizeTablet\":20,\"titleLoadGoogleFonts\":true} -->\n<div class=\"wp-block-blockspare-blockspare-section-header alignfull blockspare-ab56322e-f98f-4 blockspare-section-header-wrapper blockspare-blocks alignfull\" blockspare-animation=\"\"><style>.blockspare-ab56322e-f98f-4 .blockspare-section-head-wrap{background-color:transparent;text-align:left;margin-top:0px;margin-right:0px;margin-bottom:7px;margin-left:0px}.blockspare-ab56322e-f98f-4 .blockspare-section-head-wrap .blockspare-title{color:#404040;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px;font-size:20px;font-family:Source Sans Pro;font-weight:700}.blockspare-ab56322e-f98f-4 .blockspare-section-head-wrap .blockspare-title-wrapper .blockspare-title-dash.blockspare-lower-dash::before{background-color:#0098fe!important}.blockspare-ab56322e-f98f-4 .blockspare-section-head-wrap .blockspare-title-wrapper .blockspare-lower-dash{background-color:#00000012!important}.blockspare-ab56322e-f98f-4 .blockspare-section-head-wrap .blockspare-subtitle{color:#6d6d6d;font-size:14px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px}@media screen and (max-width:1025px){.blockspare-ab56322e-f98f-4 .blockspare-section-head-wrap .blockspare-title{font-size:20px}.blockspare-ab56322e-f98f-4 .blockspare-section-head-wrap .blockspare-subtitle{font-size:14px}}@media screen and (max-width:768px){.blockspare-ab56322e-f98f-4 .blockspare-section-head-wrap .blockspare-title{font-size:20px}.blockspare-ab56322e-f98f-4 .blockspare-section-head-wrap .blockspare-subtitle{font-size:14px}}</style><div class=\"blockspare-section-head-wrap blockspare-style10 blockspare-left blockspare-hover-item\"><div class=\"blockspare-title-wrapper\"><span class=\"blockspare-title-dash blockspare-upper-dash\"></span><h2 class=\"blockspare-title\">About Author</h2><span class=\"blockspare-title-dash blockspare-lower-dash\"></span></div><div class=\"blockspare-subtitle-wrapper\"><span class=\"blockspare-title-dash blockspare-upper-dash\"></span><span class=\"blockspare-title-dash blockspare-lower-dash\"></span></div></div></div>\n<!-- /wp:blockspare/blockspare-section-header -->\n\n<!-- wp:blockspare/user-profile {\"className\":\"aligncenter\",\"uniqueClass\":\"blockspare-dcd84b9c-b040-4\",\"sectionAlignment\":\"center\",\"headerTitle\":\"AF Themes\",\"titleFontSize\":20,\"headerSubTitle\":\"themes. plugins. support\",\"headersubtitleColor\":\"#9a9a9a\",\"titleFontFamily\":\"Source Sans Pro\",\"titleFontWeight\":\"600\",\"titleFontSizeTablet\":20,\"titleLoadGoogleFonts\":true,\"subTitleFontSize\":0,\"subTitleFontFamily\":\"Source Sans Pro\",\"subTitleFontSizeMobile\":0,\"subTitleFontSizeTablet\":0,\"subTitleLoadGoogleFonts\":true,\"profileContent\":\"We mainly focus on quality code and elegant design with incredible support. Our WordPress themes and plugins empower you to create an elegant, professional, and easy-to-maintain website in no time at all. \",\"profileBackgroundColor\":\"#ffffff\",\"profileTextColor\":\"#9a9a9a\",\"facebook\":\"https://facebook.com/afthemes\",\"twitter\":\"https://twitter.com/afthemes\",\"linkedin\":\"https://www.linkedin.com/company/13747039/\",\"paddingTop\":30,\"paddingRight\":30,\"paddingBottom\":30,\"paddingLeft\":30,\"marginTop\":0,\"marginBottom\":0,\"descriptionFontFamily\":\"Lato\",\"descriptionFontSizeTablet\":16,\"descriptionLoadGoogleFonts\":true,\"descriptionMarginTop\":20,\"descriptionMarginBottom\":30} -->\n<div class=\"wp-block-blockspare-user-profile aligncenter blockspare-dcd84b9c-b040-4 blockspare-authorprofile authorbox\" blockspare-animation=\"\"><div class=\"blockspare-section-wrapper\"><style>.blockspare-dcd84b9c-b040-4 .blockspare-author-wrapper{background-color:#ffffff;padding-top:30px;padding-right:30px;padding-bottom:30px;padding-left:30px;border-radius:0px;margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px}.blockspare-dcd84b9c-b040-4 .blockspare-author-wrapper .blockspare-user-profile-desc{margin-top:20px;margin-right:0px;margin-bottom:30px;margin-left:0px}.blockspare-dcd84b9c-b040-4 .blockspare-block-profile{color:#9a9a9a}.blockspare-dcd84b9c-b040-4 .blockspare-profile-text-description{font-size:16px;font-family:Lato}.blockspare-dcd84b9c-b040-4 .blockspare-section-head-wrap{background-color:transparent;text-align:center;margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px}.blockspare-dcd84b9c-b040-4 .blockspare-section-head-wrap .blockspare-title{color:#404040;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px;font-size:20px;font-family:Source Sans Pro;font-weight:600}.blockspare-dcd84b9c-b040-4 .blockspare-section-head-wrap .blockspare-subtitle{color:#9a9a9a;font-size:0px;font-family:Source Sans Pro;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px}.blockspare-dcd84b9c-b040-4 .blockspare-user-profile-desc{font-size:16px;font-family:Lato}@media screen and (max-width:1025px){.blockspare-dcd84b9c-b040-4 .blockspare-section-head-wrap .blockspare-title{font-size:20px}.blockspare-dcd84b9c-b040-4 .blockspare-section-head-wrap .blockspare-subtitle{font-size:0px}.blockspare-dcd84b9c-b040-4 .blockspare-user-profile-desc{font-size:16px}}@media screen and (max-width:768px){.blockspare-dcd84b9c-b040-4 .blockspare-section-head-wrap .blockspare-title{font-size:20px}.blockspare-dcd84b9c-b040-4 .blockspare-section-head-wrap .blockspare-subtitle{font-size:0px}.blockspare-dcd84b9c-b040-4 .blockspare-user-profile-desc{font-size:14px}}</style><div class=\"blockspare-author-wrapper blockspare-blocks blockspare-hover-item\"><div class=\"blockspare-layout-center blockspare-block-profile blockspare-profile-columns\"><div class=\"blockspare-profile-column blockspare-profile-avatar-wrap\"><div class=\"blockspare-profile-image-wrap\"><!-- wp:image {\"id\":440,\"width\":\"200px\",\"height\":\"200px\",\"scale\":\"cover\",\"sizeSlug\":\"large\",\"linkDestination\":\"none\",\"align\":\"center\",\"style\":{\"border\":{\"radius\":\"100px\"}},\"className\":\"is-style-rounded\"} -->\n<figure class=\"wp-block-image aligncenter size-large is-resized has-custom-border is-style-rounded\"><img src=\"https://blockspare.com/demo/default/covernews/wp-content/uploads/sites/52/2022/10/man-852766_1920-1-edited-1024x1024.jpg\" alt=\"\" class=\"wp-image-440\" style=\"border-radius:100px;object-fit:cover;width:200px;height:200px\"/></figure>\n<!-- /wp:image --></div></div><div class=\"blockspare-profile-column blockspare-profile-content-wrap\"><div class=\"blockspare-section-header-wrapper blockspare-blocks\"><div class=\"blockspare-section-head-wrap blockspare-style1 blockspare-center\"><div class=\"blockspare-title-wrapper\"><span class=\"blockspare-title-dash blockspare-upper-dash\"></span><h2 class=\"blockspare-title\">AF Themes</h2><span class=\"blockspare-title-dash blockspare-lower-dash\"></span></div><div class=\"blockspare-subtitle-wrapper\"><span class=\"blockspare-title-dash blockspare-upper-dash\"></span><p class=\"blockspare-subtitle\">themes. plugins. support</p><span class=\"blockspare-title-dash blockspare-lower-dash\"></span></div></div></div><p class=\"blockspare-profile-text blockspare-user-profile-desc\">We mainly focus on quality code and elegant design with incredible support. Our WordPress themes and plugins empower you to create an elegant, professional, and easy-to-maintain website in no time at all. </p><ul class=\"blockspare-social-links blockspare-default-official-color blockspare-social-icon-square blockspare-social-icon-small blockspare-icon-only blockspare-social-icon-solid blockspare-social-links-horizontal\"><li><a href=\"https://facebook.com/afthemes\" class=\"bs-social-facebook\" target=\"_blank\" rel=\"noopener noreferrer\"><span class=\"blockspare-social-icons\"><i class=\"fab fa-facebook-f\"></i><span class=\"screen-reader-text\">Facebook</span></span></a></li><li><a href=\"https://www.linkedin.com/company/13747039/\" class=\"bs-social-linkedin\" target=\"_blank\" rel=\"noopener noreferrer\"><span class=\"blockspare-social-icons\"><i class=\"fab fa-linkedin\"></i><span class=\"screen-reader-text\">Linkedin</span></span></a></li><li><a href=\"https://twitter.com/afthemes\" class=\"bs-social-twitter\" target=\"_blank\" rel=\"noopener noreferrer\"><span class=\"blockspare-social-icons\"><i class=\"fab fa-twitter\"></i><span class=\"screen-reader-text\">Twitter</span></span></a></li></ul></div></div></div></div></div>\n<!-- /wp:blockspare/user-profile --></div>\n<!-- /wp:group -->\n\n<!-- wp:cover {\"url\":\"https://demos.afthemes.com/covernews-pro/wp-content/uploads/2023/11/CoverNews-pro-theme-preview-new-1.jpg\",\"id\":256,\"dimRatio\":60,\"contentPosition\":\"center center\",\"layout\":{\"type\":\"constrained\"}} -->\n<div class=\"wp-block-cover\"><span aria-hidden=\"true\" class=\"wp-block-cover__background has-background-dim-60 has-background-dim\"></span><img class=\"wp-block-cover__image-background wp-image-256\" alt=\"\" src=\"https://demos.afthemes.com/covernews-pro/wp-content/uploads/2023/11/CoverNews-pro-theme-preview-new-1.jpg\" data-object-fit=\"cover\"/><div class=\"wp-block-cover__inner-container\"><!-- wp:paragraph {\"align\":\"center\",\"placeholder\":\"Write title…\",\"textColor\":\"white\",\"fontSize\":\"large\"} -->\n<p class=\"has-text-align-center has-white-color has-text-color has-large-font-size\">CoverNews Pro </p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph {\"align\":\"center\",\"style\":{\"typography\":{\"fontSize\":\"12px\"}},\"backgroundColor\":\"black\",\"textColor\":\"white\"} -->\n<p class=\"has-text-align-center has-white-color has-black-background-color has-text-color has-background\" style=\"font-size:12px\">A PREMIUM MULTIPURPOSE NEWS THEME</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:buttons {\"layout\":{\"type\":\"flex\",\"justifyContent\":\"center\",\"verticalAlignment\":\"center\"}} -->\n<div class=\"wp-block-buttons\"><!-- wp:button {\"textAlign\":\"center\",\"textColor\":\"white\",\"style\":{\"color\":{\"background\":\"#0098fe\"}}} -->\n<div class=\"wp-block-button\"><a class=\"wp-block-button__link has-white-color has-text-color has-background has-text-align-center wp-element-button\" href=\"https://afthemes.com/products/covernews-pro/\" style=\"background-color:#0098fe\" target=\"_blank\" rel=\"noreferrer noopener\">Purchase Now</a></div>\n<!-- /wp:button --></div>\n<!-- /wp:buttons --></div></div>\n<!-- /wp:cover -->\n\n<!-- wp:group {\"align\":\"wide\",\"style\":{\"spacing\":{\"blockGap\":\"0\",\"padding\":{\"top\":\"0\",\"bottom\":\"0\",\"left\":\"0\",\"right\":\"0\"},\"margin\":{\"top\":\"0\",\"bottom\":\"0\"}}},\"layout\":{\"type\":\"constrained\"}} -->\n<div class=\"wp-block-group alignwide\" style=\"margin-top:0;margin-bottom:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0\"><!-- wp:blockspare/blockspare-section-header {\"uniqueClass\":\"blockspare-fee29d76-a015-4\",\"align\":\"full\",\"headerTitle\":\"Post List\",\"titleFontSize\":20,\"headermarginTop\":20,\"headermarginBottom\":7,\"headerlayoutOption\":\"blockspare-style10\",\"dashColor\":\"#0098fe\",\"dashColor2\":\"#00000012\",\"titleFontFamily\":\"Source Sans Pro\",\"titleFontWeight\":\"700\",\"titleFontSizeTablet\":20,\"titleLoadGoogleFonts\":true} -->\n<div class=\"wp-block-blockspare-blockspare-section-header alignfull blockspare-fee29d76-a015-4 blockspare-section-header-wrapper blockspare-blocks alignfull\" blockspare-animation=\"\"><style>.blockspare-fee29d76-a015-4 .blockspare-section-head-wrap{background-color:transparent;text-align:left;margin-top:20px;margin-right:0px;margin-bottom:7px;margin-left:0px}.blockspare-fee29d76-a015-4 .blockspare-section-head-wrap .blockspare-title{color:#404040;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px;font-size:20px;font-family:Source Sans Pro;font-weight:700}.blockspare-fee29d76-a015-4 .blockspare-section-head-wrap .blockspare-title-wrapper .blockspare-title-dash.blockspare-lower-dash::before{background-color:#0098fe!important}.blockspare-fee29d76-a015-4 .blockspare-section-head-wrap .blockspare-title-wrapper .blockspare-lower-dash{background-color:#00000012!important}.blockspare-fee29d76-a015-4 .blockspare-section-head-wrap .blockspare-subtitle{color:#6d6d6d;font-size:14px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px}@media screen and (max-width:1025px){.blockspare-fee29d76-a015-4 .blockspare-section-head-wrap .blockspare-title{font-size:20px}.blockspare-fee29d76-a015-4 .blockspare-section-head-wrap .blockspare-subtitle{font-size:14px}}@media screen and (max-width:768px){.blockspare-fee29d76-a015-4 .blockspare-section-head-wrap .blockspare-title{font-size:20px}.blockspare-fee29d76-a015-4 .blockspare-section-head-wrap .blockspare-subtitle{font-size:14px}}</style><div class=\"blockspare-section-head-wrap blockspare-style10 blockspare-left blockspare-hover-item\"><div class=\"blockspare-title-wrapper\"><span class=\"blockspare-title-dash blockspare-upper-dash\"></span><h2 class=\"blockspare-title\">Post List</h2><span class=\"blockspare-title-dash blockspare-lower-dash\"></span></div><div class=\"blockspare-subtitle-wrapper\"><span class=\"blockspare-title-dash blockspare-upper-dash\"></span><span class=\"blockspare-title-dash blockspare-lower-dash\"></span></div></div></div>\n<!-- /wp:blockspare/blockspare-section-header -->\n\n<!-- wp:blockspare/blockspare-latest-posts-list {\"uniqueClass\":\"blockspare-3b547f64-ca63-4\",\"displayPostAuthor\":false,\"titleFontFamily\":\"Source Sans Pro\",\"titleFontWeight\":\"600\",\"titleLoadGoogleFonts\":true,\"linkColor\":\"#9a9a9a\",\"generalColor\":\"#9a9a9a\",\"displayPostCategory\":false,\"align\":\"wide\",\"imageSize\":\"thumbnail\",\"marginTop\":0,\"marginBottom\":0,\"backGroundColor\":\"#ffffff\",\"contentPaddingTop\":0,\"contentPaddingBottom\":0,\"titleMarginTop\":0,\"titleMarginBottom\":0,\"enableComment\":false,\"titleOnHoverColor\":\"#0098fe\",\"animation\":\"AFTfadeInRight\",\"ImageUnit\":\"75\",\"gutterSpace\":15,\"postMetaFontFamily\":\"Source Sans Pro\",\"postMetaLoadGoogleFonts\":true} /--></div>\n<!-- /wp:group -->\n\n<!-- wp:group {\"align\":\"wide\",\"style\":{\"spacing\":{\"blockGap\":\"0\",\"padding\":{\"top\":\"0\",\"bottom\":\"0\",\"left\":\"0\",\"right\":\"0\"},\"margin\":{\"top\":\"0\",\"bottom\":\"0\"}}},\"layout\":{\"type\":\"default\"}} -->\n<div class=\"wp-block-group alignwide\" style=\"margin-top:0;margin-bottom:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0\"><!-- wp:blockspare/blockspare-section-header {\"uniqueClass\":\"blockspare-7a6f09db-da7a-4\",\"align\":\"full\",\"headerTitle\":\"Connect to Us\",\"titleFontSize\":20,\"headermarginTop\":20,\"headermarginBottom\":7,\"headerlayoutOption\":\"blockspare-style10\",\"dashColor\":\"#0098fe\",\"dashColor2\":\"#00000012\",\"titleFontFamily\":\"Source Sans Pro\",\"titleFontWeight\":\"700\",\"titleFontSizeTablet\":20,\"titleLoadGoogleFonts\":true} -->\n<div class=\"wp-block-blockspare-blockspare-section-header alignfull blockspare-7a6f09db-da7a-4 blockspare-section-header-wrapper blockspare-blocks alignfull\" blockspare-animation=\"\"><style>.blockspare-7a6f09db-da7a-4 .blockspare-section-head-wrap{background-color:transparent;text-align:left;margin-top:20px;margin-right:0px;margin-bottom:7px;margin-left:0px}.blockspare-7a6f09db-da7a-4 .blockspare-section-head-wrap .blockspare-title{color:#404040;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px;font-size:20px;font-family:Source Sans Pro;font-weight:700}.blockspare-7a6f09db-da7a-4 .blockspare-section-head-wrap .blockspare-title-wrapper .blockspare-title-dash.blockspare-lower-dash::before{background-color:#0098fe!important}.blockspare-7a6f09db-da7a-4 .blockspare-section-head-wrap .blockspare-title-wrapper .blockspare-lower-dash{background-color:#00000012!important}.blockspare-7a6f09db-da7a-4 .blockspare-section-head-wrap .blockspare-subtitle{color:#6d6d6d;font-size:14px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px}@media screen and (max-width:1025px){.blockspare-7a6f09db-da7a-4 .blockspare-section-head-wrap .blockspare-title{font-size:20px}.blockspare-7a6f09db-da7a-4 .blockspare-section-head-wrap .blockspare-subtitle{font-size:14px}}@media screen and (max-width:768px){.blockspare-7a6f09db-da7a-4 .blockspare-section-head-wrap .blockspare-title{font-size:20px}.blockspare-7a6f09db-da7a-4 .blockspare-section-head-wrap .blockspare-subtitle{font-size:14px}}</style><div class=\"blockspare-section-head-wrap blockspare-style10 blockspare-left blockspare-hover-item\"><div class=\"blockspare-title-wrapper\"><span class=\"blockspare-title-dash blockspare-upper-dash\"></span><h2 class=\"blockspare-title\">Connect to Us</h2><span class=\"blockspare-title-dash blockspare-lower-dash\"></span></div><div class=\"blockspare-subtitle-wrapper\"><span class=\"blockspare-title-dash blockspare-upper-dash\"></span><span class=\"blockspare-title-dash blockspare-lower-dash\"></span></div></div></div>\n<!-- /wp:blockspare/blockspare-section-header -->\n\n<!-- wp:group {\"style\":{\"color\":{\"background\":\"#fefefe\"},\"spacing\":{\"padding\":{\"top\":\"15px\",\"bottom\":\"15px\",\"left\":\"15px\",\"right\":\"15px\"},\"blockGap\":\"0\"}},\"layout\":{\"type\":\"constrained\"}} -->\n<div class=\"wp-block-group has-background\" style=\"background-color:#fefefe;padding-top:15px;padding-right:15px;padding-bottom:15px;padding-left:15px\"><!-- wp:blockspare/blockspare-social-links {\"sectionAlignment\":\"left\",\"uniqueClass\":\"blockspare-2617d7ef-2700-4\",\"animation\":\"AFTfadeInRight\",\"facebookUrl\":\"https://facebook.com/afthemes\",\"twitterUrl\":\"https://twitter.com/afthemes\",\"instagramUrl\":\"https://instagram.com/afthemes\",\"youtubeUrl\":\"youtube.com/wpafthemes\",\"linkedinUrl\":\"linkedin.com/afthemes\",\"pinterestUrl\":\"pinterest.com/afthemes\",\"marginTop\":0,\"marginBottom\":0} -->\n<div class=\"wp-block-blockspare-blockspare-social-links blockspare-2617d7ef-2700-4 blockspare-socaillink-block blockspare-block-animation blockspare-sociallinks-left\" blockspare-animation=\"AFTfadeInRight\"><style>.blockspare-2617d7ef-2700-4 .blockspare-social-wrapper{text-align:left;margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px}.blockspare-2617d7ef-2700-4 .blockspare-social-wrapper .blockspare-social-icons > span{font-size:16px}@media screen and (max-width:1025px){.blockspare-2617d7ef-2700-4 .blockspare-social-wrapper .blockspare-social-icons > span{font-size:16px}}@media screen and (max-width:768px){.blockspare-2617d7ef-2700-4 .blockspare-social-wrapper .blockspare-social-icons > span{font-size:14px}}</style><div class=\"blockspare-social-wrapper\"><ul class=\"blockspare-social-links blockspare-default-official-color blockspare-social-icon-square blockspare-social-icon-small blockspare-icon-only blockspare-social-icon-solid blockspare-social-links-horizontal\"><li class=\"blockspare-hover-item\"><a href=\"https://facebook.com/afthemes\" class=\"bs-social-facebook\" target=\"_blank\" rel=\"noopener noreferrer\"><span class=\"blockspare-social-icons\"><i class=\"fab fa-facebook-f\"></i> <span class=\"screen-reader-text\">Facebook</span></span></a></li><li class=\"blockspare-hover-item\"><a href=\"https://twitter.com/afthemes\" class=\"bs-social-twitter\" target=\"_blank\" rel=\"noopener noreferrer\"><span class=\"blockspare-social-icons\"><i class=\"fab fa-twitter\"></i><span class=\"screen-reader-text\">Twitter</span></span></a></li><li class=\"blockspare-hover-item\"><a href=\"https://instagram.com/afthemes\" class=\"bs-social-instagram\" target=\"_blank\" rel=\"noopener noreferrer\"><span class=\"blockspare-social-icons\"><i class=\"fab fa-instagram\"></i><span class=\"screen-reader-text\">Instagram</span></span></a></li><li class=\"blockspare-hover-item\"><a href=\"youtube.com/wpafthemes\" class=\"bs-social-youtube\" target=\"_blank\" rel=\"noopener noreferrer\"><span class=\"blockspare-social-icons\"><i class=\"fab fa-youtube\"></i><span class=\"screen-reader-text\">YouTube</span></span></a></li><li class=\"blockspare-hover-item\"><a href=\"linkedin.com/afthemes\" class=\"bs-social-linkedin\" target=\"_blank\" rel=\"noopener noreferrer\"><span class=\"blockspare-social-icons\"><i class=\"fab fa-linkedin\"></i><span class=\"screen-reader-text\">LinkedIn</span></span></a></li><li class=\"blockspare-hover-item\"><a href=\"pinterest.com/afthemes\" class=\"bs-social-pinterest\" target=\"_blank\" rel=\"noopener noreferrer\"><span class=\"blockspare-social-icons\"><i class=\"fab fa-pinterest\"></i><span class=\"screen-reader-text\">Pinterest</span></span></a></li></ul></div></div>\n<!-- /wp:blockspare/blockspare-social-links --></div>\n<!-- /wp:group --></div>\n<!-- /wp:group -->\n\n<!-- wp:group {\"align\":\"wide\",\"style\":{\"spacing\":{\"blockGap\":\"0\",\"padding\":{\"top\":\"0\",\"bottom\":\"0\",\"left\":\"0\",\"right\":\"0\"}}},\"layout\":{\"type\":\"constrained\"}} -->\n<div class=\"wp-block-group alignwide\" style=\"padding-top:0;padding-right:0;padding-bottom:0;padding-left:0\"><!-- wp:blockspare/blockspare-section-header {\"uniqueClass\":\"blockspare-967be336-3bd9-4\",\"align\":\"full\",\"headerTitle\":\"Advertisement\",\"titleFontSize\":20,\"headermarginTop\":20,\"headermarginBottom\":7,\"headerlayoutOption\":\"blockspare-style10\",\"dashColor\":\"#0098fe\",\"dashColor2\":\"#00000012\",\"titleFontFamily\":\"Source Sans Pro\",\"titleFontWeight\":\"700\",\"titleFontSizeTablet\":20,\"titleLoadGoogleFonts\":true} -->\n<div class=\"wp-block-blockspare-blockspare-section-header alignfull blockspare-967be336-3bd9-4 blockspare-section-header-wrapper blockspare-blocks alignfull\" blockspare-animation=\"\"><style>.blockspare-967be336-3bd9-4 .blockspare-section-head-wrap{background-color:transparent;text-align:left;margin-top:20px;margin-right:0px;margin-bottom:7px;margin-left:0px}.blockspare-967be336-3bd9-4 .blockspare-section-head-wrap .blockspare-title{color:#404040;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px;font-size:20px;font-family:Source Sans Pro;font-weight:700}.blockspare-967be336-3bd9-4 .blockspare-section-head-wrap .blockspare-title-wrapper .blockspare-title-dash.blockspare-lower-dash::before{background-color:#0098fe!important}.blockspare-967be336-3bd9-4 .blockspare-section-head-wrap .blockspare-title-wrapper .blockspare-lower-dash{background-color:#00000012!important}.blockspare-967be336-3bd9-4 .blockspare-section-head-wrap .blockspare-subtitle{color:#6d6d6d;font-size:14px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px}@media screen and (max-width:1025px){.blockspare-967be336-3bd9-4 .blockspare-section-head-wrap .blockspare-title{font-size:20px}.blockspare-967be336-3bd9-4 .blockspare-section-head-wrap .blockspare-subtitle{font-size:14px}}@media screen and (max-width:768px){.blockspare-967be336-3bd9-4 .blockspare-section-head-wrap .blockspare-title{font-size:20px}.blockspare-967be336-3bd9-4 .blockspare-section-head-wrap .blockspare-subtitle{font-size:14px}}</style><div class=\"blockspare-section-head-wrap blockspare-style10 blockspare-left blockspare-hover-item\"><div class=\"blockspare-title-wrapper\"><span class=\"blockspare-title-dash blockspare-upper-dash\"></span><h2 class=\"blockspare-title\">Advertisement</h2><span class=\"blockspare-title-dash blockspare-lower-dash\"></span></div><div class=\"blockspare-subtitle-wrapper\"><span class=\"blockspare-title-dash blockspare-upper-dash\"></span><span class=\"blockspare-title-dash blockspare-lower-dash\"></span></div></div></div>\n<!-- /wp:blockspare/blockspare-section-header -->\n\n<!-- wp:image {\"id\":1175,\"sizeSlug\":\"full\",\"linkDestination\":\"custom\",\"align\":\"wide\"} -->\n<figure class=\"wp-block-image alignwide size-full\"><a href=\"https://afthemes.com/products/covernews-pro/\" target=\"_blank\" rel=\"noreferrer noopener\"><img src=\"https://blockspare.com/demo/default/covernews-block/wp-content/uploads/sites/39/2023/08/square-promo-square-blue-e1599620503430.jpg\" alt=\"\" class=\"wp-image-1175\"/></a></figure>\n<!-- /wp:image --></div>\n<!-- /wp:group --></div>\n<!-- /wp:group --></div>\n<!-- /wp:column --></div>\n<!-- /wp:columns --></div>\n<!-- /wp:group -->\n\n<!-- wp:group {\"align\":\"full\",\"style\":{\"spacing\":{\"blockGap\":\"0px\",\"padding\":{\"right\":\"20px\",\"left\":\"20px\",\"top\":\"0\",\"bottom\":\"0\"},\"margin\":{\"top\":\"0\",\"bottom\":\"0\"}}},\"layout\":{\"type\":\"constrained\"}} -->\n<div class=\"wp-block-group alignfull\" style=\"margin-top:0;margin-bottom:0;padding-top:0;padding-right:20px;padding-bottom:0;padding-left:20px\"><!-- wp:blockspare/blockspare-section-header {\"uniqueClass\":\"blockspare-5df04128-0ce8-4\",\"align\":\"wide\",\"headerTitle\":\"You may have missed\",\"titleFontSize\":20,\"headermarginTop\":20,\"headermarginBottom\":7,\"headerlayoutOption\":\"blockspare-style10\",\"dashColor\":\"#0098fe\",\"dashColor2\":\"#00000012\",\"titleFontFamily\":\"Source Sans Pro\",\"titleFontWeight\":\"700\",\"titleFontSizeTablet\":20,\"titleLoadGoogleFonts\":true} -->\n<div class=\"wp-block-blockspare-blockspare-section-header alignwide blockspare-5df04128-0ce8-4 blockspare-section-header-wrapper blockspare-blocks alignwide\" blockspare-animation=\"\"><style>.blockspare-5df04128-0ce8-4 .blockspare-section-head-wrap{background-color:transparent;text-align:left;margin-top:20px;margin-right:0px;margin-bottom:7px;margin-left:0px}.blockspare-5df04128-0ce8-4 .blockspare-section-head-wrap .blockspare-title{color:#404040;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px;font-size:20px;font-family:Source Sans Pro;font-weight:700}.blockspare-5df04128-0ce8-4 .blockspare-section-head-wrap .blockspare-title-wrapper .blockspare-title-dash.blockspare-lower-dash::before{background-color:#0098fe!important}.blockspare-5df04128-0ce8-4 .blockspare-section-head-wrap .blockspare-title-wrapper .blockspare-lower-dash{background-color:#00000012!important}.blockspare-5df04128-0ce8-4 .blockspare-section-head-wrap .blockspare-subtitle{color:#6d6d6d;font-size:14px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px}@media screen and (max-width:1025px){.blockspare-5df04128-0ce8-4 .blockspare-section-head-wrap .blockspare-title{font-size:20px}.blockspare-5df04128-0ce8-4 .blockspare-section-head-wrap .blockspare-subtitle{font-size:14px}}@media screen and (max-width:768px){.blockspare-5df04128-0ce8-4 .blockspare-section-head-wrap .blockspare-title{font-size:20px}.blockspare-5df04128-0ce8-4 .blockspare-section-head-wrap .blockspare-subtitle{font-size:14px}}</style><div class=\"blockspare-section-head-wrap blockspare-style10 blockspare-left blockspare-hover-item\"><div class=\"blockspare-title-wrapper\"><span class=\"blockspare-title-dash blockspare-upper-dash\"></span><h2 class=\"blockspare-title\">You may have missed</h2><span class=\"blockspare-title-dash blockspare-lower-dash\"></span></div><div class=\"blockspare-subtitle-wrapper\"><span class=\"blockspare-title-dash blockspare-upper-dash\"></span><span class=\"blockspare-title-dash blockspare-lower-dash\"></span></div></div></div>\n<!-- /wp:blockspare/blockspare-section-header -->\n\n<!-- wp:blockspare/blockspare-latest-posts-grid {\"taxType\":\"\",\"uniqueClass\":\"blockspare-9638b969-6cc0-4\",\"displayPostAuthor\":false,\"postTitleFontSize\":18,\"titleFontFamily\":\"Source Sans Pro\",\"titleFontWeight\":\"600\",\"titleFontSizeTablet\":18,\"titleLoadGoogleFonts\":true,\"linkColor\":\"#9a9a9a\",\"generalColor\":\"#9a9a9a\",\"columns\":4,\"align\":\"wide\",\"imageSize\":\"medium\",\"marginTop\":0,\"marginBottom\":0,\"backGroundColor\":\"#ffffff\",\"titleMarginTop\":0,\"metaMarginTop\":0,\"metaMarginBottom\":0,\"categoryBackgroundColor\":\"#0098fe\",\"categoryBorderRadius\":1,\"titleOnHoverColor\":\"#0098fe\",\"animation\":\"AFTfadeInDown\",\"gutterSpace\":15,\"postTitleLineHeight\":1.3,\"postCategoryFontSize\":11,\"postCategoryFontFamily\":\"Source Sans Pro\",\"postCategoryFontSizeMobile\":11,\"postCategoryFontSizeTablet\":11,\"postCategoryLoadGoogleFonts\":true,\"postMetaFontFamily\":\"Source Sans Pro\",\"postMetaLoadGoogleFonts\":true} /--></div>\n<!-- /wp:group --></div></div></div></div>\n<!-- /wp:blockspare/blockspare-container -->', 'Home', '\n				\n								', 'publish', 'closed', 'closed', '', 'home', '', '', '2018-07-18 11:55:09', '2018-07-18 11:55:09', '', 0, 'https://demo.afthemes.com/covernews-pro/?page_id=37', 0, 'page', '', 0);
INSERT INTO `wp_posts` (`ID`, `post_author`, `post_date`, `post_date_gmt`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `ping_status`, `post_password`, `post_name`, `to_ping`, `pinged`, `post_modified`, `post_modified_gmt`, `post_content_filtered`, `post_parent`, `guid`, `menu_order`, `post_type`, `post_mime_type`, `comment_count`) VALUES
(44, 1, '2018-07-18 12:08:58', '2018-07-18 12:08:58', '', 'Facebook', '												', 'publish', 'closed', 'closed', '', 'facebook', '', '', '2018-07-18 12:08:58', '2018-07-18 12:08:58', '', 0, 'https://demo.afthemes.com/covernews-pro/?p=44', 1, 'nav_menu_item', '', 0),
(45, 1, '2018-07-18 12:08:58', '2018-07-18 12:08:58', '', 'Twitter', '												', 'publish', 'closed', 'closed', '', 'twitter', '', '', '2018-07-18 12:08:58', '2018-07-18 12:08:58', '', 0, 'https://demo.afthemes.com/covernews-pro/?p=45', 2, 'nav_menu_item', '', 0),
(51, 1, '2018-07-18 12:09:47', '2018-07-18 12:09:47', ' ', '', '												', 'publish', 'closed', 'closed', '', '51', '', '', '2018-07-18 12:09:47', '2018-07-18 12:09:47', '', 0, 'https://demo.afthemes.com/covernews-pro/?p=51', 1, 'nav_menu_item', '', 0),
(127, 1, '2019-04-17 06:18:51', '2019-04-17 06:18:51', '\n				\n								', 'Blog', '\n				\n								', 'publish', 'closed', 'closed', '', 'blog', '', '', '2019-04-17 06:18:51', '2019-04-17 06:18:51', '', 0, 'https://demo.afthemes.com/newsphere-pro/?page_id=127', 0, 'page', '', 0),
(133, 1, '2019-04-17 06:19:27', '2019-04-17 06:19:27', ' ', '', '												', 'publish', 'closed', 'closed', '', '133', '', '', '2019-04-17 06:19:27', '2019-04-17 06:19:27', '', 0, 'https://demo.afthemes.com/newsphere-pro/blog/2019/04/17/133/', 2, 'nav_menu_item', '', 0),
(217, 1, '2020-10-11 15:11:21', '2020-10-11 15:11:21', '', 'snow-winter-architecture-structure-building-city-101684-pxhere.com', '', 'inherit', 'closed', 'closed', '', 'snow-winter-architecture-structure-building-city-101684-pxhere-com', '', '', '2024-12-21 08:51:24', '2024-12-21 08:51:24', '', 970, 'https://demo.afthemes.com/covernews/wp-content/uploads/2018/07/snow-winter-architecture-structure-building-city-101684-pxhere.com_.jpg', 0, 'attachment', 'image/jpeg', 0),
(219, 1, '2020-10-11 15:15:56', '2020-10-11 15:15:56', '', 'person-military-soldier-army-profession-navy-64969-pxhere.com', '', 'inherit', 'closed', 'closed', '', 'person-military-soldier-army-profession-navy-64969-pxhere-com', '', '', '2024-12-21 08:51:24', '2024-12-21 08:51:24', '', 967, 'https://demo.afthemes.com/covernews/wp-content/uploads/2018/07/person-military-soldier-army-profession-navy-64969-pxhere.com_.jpg', 0, 'attachment', 'image/jpeg', 0),
(220, 1, '2020-10-11 15:22:08', '2020-10-11 15:22:08', '', 'man-person-usa-america-profession-washington-826138-pxhere.com', '', 'inherit', 'closed', 'closed', '', 'man-person-usa-america-profession-washington-826138-pxhere-com', '', '', '2024-12-21 08:51:24', '2024-12-21 08:51:24', '', 969, 'https://demo.afthemes.com/covernews/wp-content/uploads/2018/07/man-person-usa-america-profession-washington-826138-pxhere.com_.jpg', 0, 'attachment', 'image/jpeg', 0),
(222, 1, '2020-10-11 15:24:17', '2020-10-11 15:24:17', '', 'study-graduation-academic-dress-scholar-mortarboard-event-1626645-pxhere.com', '', 'inherit', 'closed', 'closed', '', 'study-graduation-academic-dress-scholar-mortarboard-event-1626645-pxhere-com', '', '', '2024-12-21 08:51:24', '2024-12-21 08:51:24', '', 968, 'https://demo.afthemes.com/covernews/wp-content/uploads/2018/07/study-graduation-academic-dress-scholar-mortarboard-event-1626645-pxhere.com_.jpg', 0, 'attachment', 'image/jpeg', 0),
(267, 1, '2024-05-14 04:05:45', '2024-05-14 04:05:45', '<!-- wp:paragraph -->\n<p>In the dynamic world of WordPress, we emerge as a beacon of innovation and excellence. Our popular products, like <a href=\"https://afthemes.com/products/covernews-pro/\">CoverNews</a>, <a href=\"https://afthemes.com/products/chromenews-pro/\">ChromeNews</a>, <a href=\"https://afthemes.com/products/newsphere-pro/\">Newsphere</a>, and <a href=\"https://afthemes.com/products/shopical-pro/\">Shopical</a>, alongside powerful plugins such as <a href=\"https://afthemes.com/plugins/wp-post-author/\">WP Post Author</a>, <a href=\"https://blockspare.com/\">Blockspare</a>, and <a href=\"https://elespare.com/\">Elespare</a>, serve as the building blocks of your digital journey.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>We’re passionate about quality code and elegant design, ensuring your website creation is an effortless blend of sophistication and simplicity. With unwavering support from our dedicated team, you’re never alone.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:heading {\"textAlign\":\"left\"} -->\n<h2 class=\"wp-block-heading has-text-align-left\" id=\"phasellus-autem-placeat-laboris-sem-cupiditate-assumenda\"><a href=\"https://templatespare.com/\">Templatespare</a>: Create Your Dream Website with Easy Starter Sites!</h2>\n<!-- /wp:heading -->\n\n<!-- wp:embed {\"url\":\"https://www.youtube.com/watch?v=t7LMDLRE8Ok\",\"type\":\"video\",\"providerNameSlug\":\"youtube\",\"responsive\":true,\"className\":\"wp-embed-aspect-16-9 wp-has-aspect-ratio\"} -->\n<figure class=\"wp-block-embed is-type-video is-provider-youtube wp-block-embed-youtube wp-embed-aspect-16-9 wp-has-aspect-ratio\"><div class=\"wp-block-embed__wrapper\">\nhttps://www.youtube.com/watch?v=t7LMDLRE8Ok\n</div></figure>\n<!-- /wp:embed -->\n\n<!-- wp:quote -->\n<blockquote class=\"wp-block-quote\"><!-- wp:paragraph -->\n<p>A beautiful collection of Ready to Import Starter Sites with just one click. Get modern &amp; creative websites in minutes!</p>\n<!-- /wp:paragraph --><cite><strong><strong>Newspaper, Magazine,&nbsp;Blog,&nbsp;and eCommerce Ready</strong></strong></cite></blockquote>\n<!-- /wp:quote -->\n\n<!-- wp:heading -->\n<h2 class=\"wp-block-heading\"><strong>Forget About Starting From Scratch</strong></h2>\n<!-- /wp:heading -->\n\n<!-- wp:paragraph -->\n<p>Explore a world of creativity with 365+ ready-to-use website templates! From chic blogs to dynamic news platforms, engaging magazines, and professional agency websites - find your perfect online space! </p>\n<!-- /wp:paragraph -->\n\n<!-- wp:columns -->\n<div class=\"wp-block-columns\"><!-- wp:column -->\n<div class=\"wp-block-column\"><!-- wp:image {\"lightbox\":{\"enabled\":false},\"sizeSlug\":\"large\",\"linkDestination\":\"custom\"} -->\n<figure class=\"wp-block-image size-large\"><a href=\"https://afthemes.com/\" target=\"_blank\" rel=\"noreferrer noopener\"><img src=\"https://templatespare.com/wp-content/uploads/2024/05/How-to-Create-a-Website-in-Minutes.jpeg\" alt=\"\"/></a></figure>\n<!-- /wp:image --></div>\n<!-- /wp:column -->\n\n<!-- wp:column -->\n<div class=\"wp-block-column\"><!-- wp:group {\"layout\":{\"type\":\"constrained\"}} -->\n<div class=\"wp-block-group\"><!-- wp:heading {\"fontSize\":\"medium\"} -->\n<h2 class=\"wp-block-heading has-medium-font-size\">One Click Import: No Coding Hassle! Three Simple Steps</h2>\n<!-- /wp:heading -->\n\n<!-- wp:paragraph {\"style\":{\"elements\":{\"link\":{\"color\":{\"text\":\"var:preset|color|black\"}}}},\"textColor\":\"black\"} -->\n<p class=\"has-black-color has-text-color has-link-color\">Embark on your website journey with simplicity and style. Follow these 3 easy steps to create your online masterpiece effortlessly</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:buttons -->\n<div class=\"wp-block-buttons\"><!-- wp:button {\"className\":\"is-style-outline\",\"fontSize\":\"small\"} -->\n<div class=\"wp-block-button has-custom-font-size is-style-outline has-small-font-size\"><a class=\"wp-block-button__link wp-element-button\" href=\"https://afthemes.com/\">Explore More</a></div>\n<!-- /wp:button --></div>\n<!-- /wp:buttons --></div>\n<!-- /wp:group --></div>\n<!-- /wp:column --></div>\n<!-- /wp:columns -->\n\n<!-- wp:list {\"ordered\":true} -->\n<ol><!-- wp:list-item -->\n<li><strong>Choose a Site</strong><br>Explore a rich selection of over 350 pre-built websites. With a single click, import the site that resonates with your vision.</li>\n<!-- /wp:list-item -->\n\n<!-- wp:list-item -->\n<li><strong>Customize &amp; Personalize</strong><br>Unleash your creativity! Customize your chosen site with complete design freedom. Tailor every element to build and personalize your website exactly the way you envision it.</li>\n<!-- /wp:list-item -->\n\n<!-- wp:list-item -->\n<li><strong>Publish &amp; Go Live!</strong><br>With the editing and customization complete, it’s time to go live! In just minutes, your website will be ready to share with the world.</li>\n<!-- /wp:list-item --></ol>\n<!-- /wp:list -->\n\n<!-- wp:paragraph -->\n<p>Join the <a href=\"https://afthemes.com/\">AF themes</a> family, where excellence meets ease. Explore the endless possibilities and embark on your web journey with us today!</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>Together, we’re shaping the future of the web.</p>\n<!-- /wp:paragraph -->\n', 'The full story of Thailand’s extraordinary cave rescue', 'Build Your Website in Minutes with One-Click Import – No Coding Hassle!', 'publish', 'closed', 'closed', '', 'the-full-story-of-thailands-extraordinary-cave-rescue', '', '', '2024-05-14 04:05:45', '2024-05-14 04:05:45', '', 0, 'https://demo.afthemes.com/storymag-pro/?p=6', 0, 'post', '', 0),
(279, 1, '2018-11-22 15:04:51', '2018-11-22 15:04:51', '				\n								', 'beard-2286446_1920', '				\n								', 'inherit', 'open', 'closed', '', 'beard-2286446_1920', '', '', '2018-11-22 15:04:51', '2018-11-22 15:04:51', '', 0, 'https://demo.afthemes.com/covernews/daily-newscast/wp-content/uploads/sites/6/2018/04/beard-2286446_1920.jpg', 0, 'attachment', 'image/jpeg', 0),
(298, 1, '2021-06-04 11:08:11', '2018-07-18 12:08:58', '', 'Youtube', '												', 'publish', 'closed', 'closed', '', 'youtube-2', '', '', '2021-06-04 11:08:11', '2018-07-18 12:08:58', '', 0, 'https://demo.afthemes.com/covernews-pro/?p=46', 5, 'nav_menu_item', '', 0),
(299, 1, '2018-07-18 12:08:58', '2018-07-18 12:08:58', '', 'Instagram', '												', 'publish', 'closed', 'closed', '', 'instagram-2', '', '', '2018-07-18 12:08:58', '2018-07-18 12:08:58', '', 0, 'https://demo.afthemes.com/covernews-pro/?p=47', 6, 'nav_menu_item', '', 0),
(300, 1, '2018-07-18 12:08:58', '2018-07-18 12:08:58', '', 'Linkedin', '												', 'publish', 'closed', 'closed', '', 'linkedin-2', '', '', '2018-07-18 12:08:58', '2018-07-18 12:08:58', '', 0, 'https://demo.afthemes.com/covernews-pro/?p=48', 3, 'nav_menu_item', '', 0),
(302, 1, '2018-07-18 12:10:43', '2018-07-18 12:10:43', '', 'VK', '												', 'publish', 'closed', 'closed', '', 'vk-2', '', '', '2018-07-18 12:10:43', '2018-07-18 12:10:43', '', 0, 'https://demo.afthemes.com/covernews-pro/?p=52', 4, 'nav_menu_item', '', 0),
(336, 1, '2021-03-18 10:40:23', '2019-08-05 05:59:25', ' ', '', '', 'publish', 'closed', 'closed', '', '336', '', '', '2021-03-18 10:40:23', '2019-08-05 05:59:25', '', 0, 'https://demo.afthemes.com/newsium-pro/?p=336', 1, 'nav_menu_item', '', 0),
(337, 1, '2021-03-18 10:40:23', '2019-08-05 05:59:25', ' ', '', '', 'publish', 'closed', 'closed', '', '337', '', '', '2021-03-18 10:40:23', '2019-08-05 05:59:25', '', 0, 'https://demo.afthemes.com/newsium-pro/?p=337', 2, 'nav_menu_item', '', 0),
(342, 1, '2021-03-18 10:40:23', '2019-08-08 07:49:57', ' ', '', '', 'publish', 'closed', 'closed', '', '342', '', '', '2021-03-18 10:40:23', '2019-08-08 07:49:57', '', 0, 'https://demo.afthemes.com/newsium-pro/?p=342', 3, 'nav_menu_item', '', 0),
(432, 1, '2019-11-21 10:56:18', '2019-11-21 10:56:18', '', 'flower-military-pattern-soldier-army-red-672477-pxhere.com', '', 'inherit', 'open', 'closed', '', 'flower-military-pattern-soldier-army-red-672477-pxhere-com', '', '', '2019-11-21 10:56:18', '2019-11-21 10:56:18', '', 0, 'https://demo.afthemes.com/newsium-pro/wp-content/uploads/2018/07/flower-military-pattern-soldier-army-red-672477-pxhere.com_.jpg', 0, 'attachment', 'image/jpeg', 0),
(439, 1, '2019-11-21 11:05:22', '2019-11-21 11:05:22', '', 'water-light-architecture-sky-bridge-skyline-661635-pxhere.com', '', 'inherit', 'open', 'closed', '', 'water-light-architecture-sky-bridge-skyline-661635-pxhere-com', '', '', '2019-11-21 11:05:22', '2019-11-21 11:05:22', '', 0, 'https://demo.afthemes.com/newsium-pro/wp-content/uploads/2018/07/water-light-architecture-sky-bridge-skyline-661635-pxhere.com_.jpg', 0, 'attachment', 'image/jpeg', 0),
(443, 1, '2019-11-21 11:07:55', '2019-11-21 11:07:55', '', 'light-girl-sun-woman-formation-cave-42727-pxhere.com', '', 'inherit', 'open', 'closed', '', 'light-girl-sun-woman-formation-cave-42727-pxhere-com', '', '', '2019-11-21 11:07:55', '2019-11-21 11:07:55', '', 0, 'https://demo.afthemes.com/newsium-pro/wp-content/uploads/2018/07/light-girl-sun-woman-formation-cave-42727-pxhere.com_.jpg', 0, 'attachment', 'image/jpeg', 0),
(525, 1, '2021-03-18 10:40:23', '2019-11-30 08:55:02', ' ', '', '', 'publish', 'closed', 'closed', '', '525', '', '', '2021-03-18 10:40:23', '2019-11-30 08:55:02', '', 0, 'https://demo.afthemes.com/newsium-pro/blog/2019/11/30/525/', 6, 'nav_menu_item', '', 0),
(526, 1, '2021-03-18 10:40:23', '2019-11-30 08:55:02', ' ', '', '', 'publish', 'closed', 'closed', '', '526', '', '', '2021-03-18 10:40:23', '2019-11-30 08:55:02', '', 0, 'https://demo.afthemes.com/newsium-pro/blog/2019/11/30/526/', 4, 'nav_menu_item', '', 0),
(768, 1, '2021-05-10 06:34:04', '2021-05-10 06:34:04', '', 'af-themes-logo-1-150x150', '', 'inherit', 'open', 'closed', '', 'af-themes-logo-1-150x150', '', '', '2021-05-10 06:34:04', '2021-05-10 06:34:04', '', 0, 'https://demo.afthemes.com/enternews-pro/wp-content/uploads/2021/05/af-themes-logo-1-150x150-1.png', 0, 'attachment', 'image/png', 0),
(795, 1, '2021-05-29 14:53:40', '2021-05-29 14:53:40', '', 'banner-promo-full-blue-revised', '', 'inherit', 'open', 'closed', '', 'banner-promo-full-blue-revised', '', '', '2021-05-29 14:53:40', '2021-05-29 14:53:40', '', 0, 'https://demo.afthemes.com/morenews-pro/wp-content/uploads/2021/05/banner-promo-full-blue-revised.png', 0, 'attachment', 'image/png', 0),
(864, 1, '2022-08-30 11:15:23', '2021-06-11 08:59:14', ' ', '', '', 'publish', 'closed', 'closed', '', '864', '', '', '2022-08-30 11:15:23', '2021-06-11 08:59:14', '', 0, 'https://demo.afthemes.com/morenews/?p=864', 1, 'nav_menu_item', '', 0),
(865, 1, '2022-08-30 11:15:23', '2021-06-11 08:59:14', ' ', '', '', 'publish', 'closed', 'closed', '', '865', '', '', '2022-08-30 11:15:23', '2021-06-11 08:59:14', '', 0, 'https://demo.afthemes.com/morenews/?p=865', 2, 'nav_menu_item', '', 0),
(866, 1, '2022-08-30 11:15:23', '2021-06-11 08:59:14', '', 'Single Post', '', 'publish', 'closed', 'closed', '', 'single-post', '', '', '2022-08-30 11:15:23', '2021-06-11 08:59:14', '', 0, 'https://demo.afthemes.com/morenews/?p=866', 3, 'nav_menu_item', '', 0),
(867, 1, '2022-08-30 11:15:23', '2021-06-11 08:59:14', '', 'Main Banner', '', 'publish', 'closed', 'closed', '', 'main-banner', '', '', '2022-08-30 11:15:23', '2021-06-11 08:59:14', '', 0, 'https://demo.afthemes.com/morenews/?p=867', 7, 'nav_menu_item', '', 0),
(868, 1, '2022-08-30 11:15:23', '2021-06-11 08:59:14', '', 'Archive', '', 'publish', 'closed', 'closed', '', 'archive', '', '', '2022-08-30 11:15:23', '2021-06-11 08:59:14', '', 0, 'https://demo.afthemes.com/morenews/?p=868', 21, 'nav_menu_item', '', 0),
(870, 1, '2022-08-30 11:15:24', '2021-06-11 08:59:14', '', 'All Demos', '', 'publish', 'closed', 'closed', '', 'all-demos', '', '', '2022-08-30 11:15:24', '2021-06-11 08:59:14', '', 0, 'https://demo.afthemes.com/morenews/?p=870', 37, 'nav_menu_item', '', 0),
(871, 1, '2022-08-30 11:15:23', '2021-06-11 08:59:14', '', 'Free', '', 'publish', 'closed', 'closed', '', 'free', '', '', '2022-08-30 11:15:23', '2021-06-11 08:59:14', '', 0, 'https://demo.afthemes.com/morenews/?p=871', 8, 'nav_menu_item', '', 0),
(872, 1, '2022-08-30 11:15:24', '2021-06-11 08:59:14', '', 'Free', '', 'publish', 'closed', 'closed', '', 'free-2', '', '', '2022-08-30 11:15:24', '2021-06-11 08:59:14', '', 0, 'https://demo.afthemes.com/morenews/?p=872', 22, 'nav_menu_item', '', 0),
(873, 1, '2022-08-30 11:15:24', '2021-06-11 08:59:14', '', 'Free', '', 'publish', 'closed', 'closed', '', 'free-3', '', '', '2022-08-30 11:15:24', '2021-06-11 08:59:14', '', 0, 'https://demo.afthemes.com/morenews/?p=873', 38, 'nav_menu_item', '', 0),
(875, 1, '2022-08-30 11:15:23', '2021-06-11 08:59:14', '', 'Pro', '', 'publish', 'closed', 'closed', '', 'pro', '', '', '2022-08-30 11:15:23', '2021-06-11 08:59:14', '', 0, 'https://demo.afthemes.com/morenews/?p=875', 13, 'nav_menu_item', '', 0),
(876, 1, '2022-08-30 11:15:24', '2021-06-11 08:59:14', '', 'Pro', '', 'publish', 'closed', 'closed', '', 'pro-3', '', '', '2022-08-30 11:15:24', '2021-06-11 08:59:14', '', 0, 'https://demo.afthemes.com/morenews/?p=876', 44, 'nav_menu_item', '', 0),
(877, 1, '2022-08-30 11:15:24', '2021-06-11 08:59:14', '', 'Pro', '', 'publish', 'closed', 'closed', '', 'pro-2', '', '', '2022-08-30 11:15:24', '2021-06-11 08:59:14', '', 0, 'https://demo.afthemes.com/morenews/?p=877', 27, 'nav_menu_item', '', 0),
(882, 1, '2022-08-30 11:15:23', '2021-06-11 08:59:14', '', 'Tab, Slider and Trending', '', 'publish', 'closed', 'closed', '', 'tab-slider-and-trending', '', '', '2022-08-30 11:15:23', '2021-06-11 08:59:14', '', 0, 'https://demo.afthemes.com/morenews/?p=882', 9, 'nav_menu_item', '', 0),
(883, 1, '2022-08-30 11:15:23', '2021-06-11 08:59:14', '', 'Editor, Slider and Tab', '', 'publish', 'closed', 'closed', '', 'editor-slider-and-tab', '', '', '2022-08-30 11:15:23', '2021-06-11 08:59:14', '', 0, 'https://demo.afthemes.com/morenews/?p=883', 10, 'nav_menu_item', '', 0),
(884, 1, '2022-08-30 11:15:23', '2021-06-11 08:59:14', '', 'Slider and Trending', '', 'publish', 'closed', 'closed', '', 'slider-and-trending', '', '', '2022-08-30 11:15:23', '2021-06-11 08:59:14', '', 0, 'https://demo.afthemes.com/morenews/?p=884', 11, 'nav_menu_item', '', 0),
(885, 1, '2022-08-30 11:15:23', '2021-06-11 08:59:14', '', 'Slider, Editor and Tab', '', 'publish', 'closed', 'closed', '', 'slider-editor-and-tab', '', '', '2022-08-30 11:15:23', '2021-06-11 08:59:14', '', 0, 'https://demo.afthemes.com/morenews/?p=885', 12, 'nav_menu_item', '', 0),
(886, 1, '2022-08-30 11:15:24', '2021-06-11 08:59:14', '', 'Sport', '', 'publish', 'closed', 'closed', '', 'sport', '', '', '2022-08-30 11:15:24', '2021-06-11 08:59:14', '', 0, 'https://demo.afthemes.com/morenews/?p=886', 39, 'nav_menu_item', '', 0),
(887, 1, '2022-08-30 11:15:24', '2021-06-11 08:59:14', '', 'Fashion', '', 'publish', 'closed', 'closed', '', 'fashion', '', '', '2022-08-30 11:15:24', '2021-06-11 08:59:14', '', 0, 'https://demo.afthemes.com/morenews/?p=887', 40, 'nav_menu_item', '', 0),
(888, 1, '2022-08-30 11:15:24', '2021-06-11 08:59:14', '', 'Classic', '', 'publish', 'closed', 'closed', '', 'classic', '', '', '2022-08-30 11:15:24', '2021-06-11 08:59:14', '', 0, 'https://demo.afthemes.com/morenews/?p=888', 41, 'nav_menu_item', '', 0),
(889, 1, '2022-08-30 11:15:24', '2021-06-11 08:59:14', '', 'Food Recipe', '', 'publish', 'closed', 'closed', '', 'food-recipe', '', '', '2022-08-30 11:15:24', '2021-06-11 08:59:14', '', 0, 'https://demo.afthemes.com/morenews/?p=889', 42, 'nav_menu_item', '', 0),
(890, 1, '2022-08-30 11:15:24', '2021-06-11 08:59:14', '', 'Travel', '', 'publish', 'closed', 'closed', '', 'travel', '', '', '2022-08-30 11:15:24', '2021-06-11 08:59:14', '', 0, 'https://demo.afthemes.com/morenews/?p=890', 43, 'nav_menu_item', '', 0),
(891, 1, '2022-08-30 11:15:24', '2021-06-11 08:59:14', '', 'List Layout', '', 'publish', 'closed', 'closed', '', 'list-layout', '', '', '2022-08-30 11:15:24', '2021-06-11 08:59:14', '', 0, 'https://demo.afthemes.com/morenews/?p=891', 23, 'nav_menu_item', '', 0),
(892, 1, '2022-08-30 11:15:24', '2021-06-11 08:59:14', '', 'List Right Layout', '', 'publish', 'closed', 'closed', '', 'list-right-layout', '', '', '2022-08-30 11:15:24', '2021-06-11 08:59:14', '', 0, 'https://demo.afthemes.com/morenews/?p=892', 24, 'nav_menu_item', '', 0),
(893, 1, '2022-08-30 11:15:24', '2021-06-11 08:59:14', '', 'Full Title after Image', '', 'publish', 'closed', 'closed', '', 'full-title-after-image', '', '', '2022-08-30 11:15:24', '2021-06-11 08:59:14', '', 0, 'https://demo.afthemes.com/morenews/?p=893', 25, 'nav_menu_item', '', 0),
(894, 1, '2022-08-30 11:15:24', '2021-06-11 08:59:14', '', 'Full Title before Image', '', 'publish', 'closed', 'closed', '', 'full-title-before-image', '', '', '2022-08-30 11:15:24', '2021-06-11 08:59:14', '', 0, 'https://demo.afthemes.com/morenews/?p=894', 26, 'nav_menu_item', '', 0),
(895, 1, '2022-08-30 11:15:23', '2021-06-11 08:59:14', '', 'Tab, Slider and Trending', '', 'publish', 'closed', 'closed', '', 'tab-slider-and-trending-2', '', '', '2022-08-30 11:15:23', '2021-06-11 08:59:14', '', 0, 'https://demo.afthemes.com/morenews/?p=895', 14, 'nav_menu_item', '', 0),
(896, 1, '2022-08-30 11:15:23', '2021-06-11 08:59:14', '', 'Tab, Slider and Editor', '', 'publish', 'closed', 'closed', '', 'tab-slider-and-editor', '', '', '2022-08-30 11:15:23', '2021-06-11 08:59:14', '', 0, 'https://demo.afthemes.com/morenews/?p=896', 15, 'nav_menu_item', '', 0),
(897, 1, '2022-08-30 11:15:23', '2021-06-11 08:59:14', '', 'Slider, Editor and Trending', '', 'publish', 'closed', 'closed', '', 'slider-editor-and-trending', '', '', '2022-08-30 11:15:23', '2021-06-11 08:59:14', '', 0, 'https://demo.afthemes.com/morenews/?p=897', 16, 'nav_menu_item', '', 0),
(898, 1, '2022-08-30 11:15:23', '2021-06-11 08:59:14', '', 'Slider and Trending', '', 'publish', 'closed', 'closed', '', 'slider-and-trending-2', '', '', '2022-08-30 11:15:23', '2021-06-11 08:59:14', '', 0, 'https://demo.afthemes.com/morenews/?p=898', 17, 'nav_menu_item', '', 0),
(899, 1, '2022-08-30 11:15:23', '2021-06-11 08:59:14', '', 'Slider and Tab', '', 'publish', 'closed', 'closed', '', 'slider-and-tab', '', '', '2022-08-30 11:15:23', '2021-06-11 08:59:14', '', 0, 'https://demo.afthemes.com/morenews/?p=899', 18, 'nav_menu_item', '', 0),
(900, 1, '2022-08-30 11:15:23', '2021-06-11 08:59:14', '', 'Slider and Editor', '', 'publish', 'closed', 'closed', '', 'slider-and-editor', '', '', '2022-08-30 11:15:23', '2021-06-11 08:59:14', '', 0, 'https://demo.afthemes.com/morenews/?p=900', 19, 'nav_menu_item', '', 0),
(901, 1, '2022-08-30 11:15:23', '2021-06-11 08:59:14', '', 'Carousel', '', 'publish', 'closed', 'closed', '', 'carousel', '', '', '2022-08-30 11:15:23', '2021-06-11 08:59:14', '', 0, 'https://demo.afthemes.com/morenews/?p=901', 20, 'nav_menu_item', '', 0),
(902, 1, '2022-08-30 11:15:24', '2021-06-11 08:59:14', '', '2 Column Grid', '', 'publish', 'closed', 'closed', '', '2-column-grid', '', '', '2022-08-30 11:15:24', '2021-06-11 08:59:14', '', 0, 'https://demo.afthemes.com/morenews/?p=902', 28, 'nav_menu_item', '', 0),
(903, 1, '2022-08-30 11:15:24', '2021-06-11 08:59:14', '', '3 Column Grid', '', 'publish', 'closed', 'closed', '', '3-column-grid', '', '', '2022-08-30 11:15:24', '2021-06-11 08:59:14', '', 0, 'https://demo.afthemes.com/morenews/?p=903', 29, 'nav_menu_item', '', 0),
(904, 1, '2022-08-30 11:15:24', '2021-06-11 08:59:14', '', 'List Layout', '', 'publish', 'closed', 'closed', '', 'list-layout-2', '', '', '2022-08-30 11:15:24', '2021-06-11 08:59:14', '', 0, 'https://demo.afthemes.com/morenews/?p=904', 30, 'nav_menu_item', '', 0),
(905, 1, '2022-08-30 11:15:24', '2021-06-11 08:59:14', '', 'List Right Layout', '', 'publish', 'closed', 'closed', '', 'list-right-layout-2', '', '', '2022-08-30 11:15:24', '2021-06-11 08:59:14', '', 0, 'https://demo.afthemes.com/morenews/?p=905', 31, 'nav_menu_item', '', 0),
(906, 1, '2022-08-30 11:15:24', '2021-06-11 08:59:14', '', 'List Alternative', '', 'publish', 'closed', 'closed', '', 'list-alternative', '', '', '2022-08-30 11:15:24', '2021-06-11 08:59:14', '', 0, 'https://demo.afthemes.com/morenews/?p=906', 32, 'nav_menu_item', '', 0),
(907, 1, '2022-08-30 11:15:24', '2021-06-11 08:59:14', '', 'Masonry', '', 'publish', 'closed', 'closed', '', 'masonry', '', '', '2022-08-30 11:15:24', '2021-06-11 08:59:14', '', 0, 'https://demo.afthemes.com/morenews/?p=907', 33, 'nav_menu_item', '', 0),
(908, 1, '2022-08-30 11:15:24', '2021-06-11 08:59:14', '', 'Full Title after Image', '', 'publish', 'closed', 'closed', '', 'full-title-after-image-2', '', '', '2022-08-30 11:15:24', '2021-06-11 08:59:14', '', 0, 'https://demo.afthemes.com/morenews/?p=908', 34, 'nav_menu_item', '', 0),
(909, 1, '2022-08-30 11:15:24', '2021-06-11 08:59:14', '', 'Full Title before Image', '', 'publish', 'closed', 'closed', '', 'full-title-before-image-2', '', '', '2022-08-30 11:15:24', '2021-06-11 08:59:14', '', 0, 'https://demo.afthemes.com/morenews/?p=909', 35, 'nav_menu_item', '', 0),
(910, 1, '2022-08-30 11:15:24', '2021-06-11 08:59:14', '', 'Full Title over Image', '', 'publish', 'closed', 'closed', '', 'full-title-over-image', '', '', '2022-08-30 11:15:24', '2021-06-11 08:59:14', '', 0, 'https://demo.afthemes.com/morenews/?p=910', 36, 'nav_menu_item', '', 0),
(911, 1, '2022-08-30 11:15:24', '2021-06-11 08:59:14', '', 'Morenews Pro', '', 'publish', 'closed', 'closed', '', 'morenews-pro', '', '', '2022-08-30 11:15:24', '2021-06-11 08:59:14', '', 0, 'https://demo.afthemes.com/morenews/?p=911', 45, 'nav_menu_item', '', 0),
(912, 1, '2022-08-30 11:15:24', '2021-06-11 08:59:14', '', 'Sport Pro', '', 'publish', 'closed', 'closed', '', 'sport-pro', '', '', '2022-08-30 11:15:24', '2021-06-11 08:59:14', '', 0, 'https://demo.afthemes.com/morenews/?p=912', 46, 'nav_menu_item', '', 0),
(913, 1, '2022-08-30 11:15:24', '2021-06-11 08:59:14', '', 'Fashion Pro', '', 'publish', 'closed', 'closed', '', 'fashion-pro', '', '', '2022-08-30 11:15:24', '2021-06-11 08:59:14', '', 0, 'https://demo.afthemes.com/morenews/?p=913', 47, 'nav_menu_item', '', 0),
(916, 1, '2022-08-30 11:15:24', '2021-06-11 08:59:14', '', 'Classic Pro', '', 'publish', 'closed', 'closed', '', 'classic-pro', '', '', '2022-08-30 11:15:24', '2021-06-11 08:59:14', '', 0, 'https://demo.afthemes.com/morenews/?p=914', 48, 'nav_menu_item', '', 0),
(917, 1, '2022-08-30 11:15:24', '2021-06-11 08:59:14', '', 'Food Recipe Pro', '', 'publish', 'closed', 'closed', '', 'food-recipe-pro', '', '', '2022-08-30 11:15:24', '2021-06-11 08:59:14', '', 0, 'https://demo.afthemes.com/morenews/?p=915', 49, 'nav_menu_item', '', 0),
(918, 1, '2022-08-30 11:15:24', '2021-06-11 08:59:14', '', 'Travel Pro', '', 'publish', 'closed', 'closed', '', 'travel-pro', '', '', '2022-08-30 11:15:24', '2021-06-11 08:59:14', '', 0, 'https://demo.afthemes.com/morenews/?p=916', 50, 'nav_menu_item', '', 0),
(919, 1, '2022-08-30 11:15:24', '2021-06-11 08:59:14', '', 'Online Mag Pro', '', 'publish', 'closed', 'closed', '', 'online-mag-pro', '', '', '2022-08-30 11:15:24', '2021-06-11 08:59:14', '', 0, 'https://demo.afthemes.com/morenews/?p=917', 51, 'nav_menu_item', '', 0),
(920, 1, '2022-08-30 11:15:24', '2021-06-11 08:59:14', '', 'Crypto News Pro', '', 'publish', 'closed', 'closed', '', 'crypto-news-pro', '', '', '2022-08-30 11:15:24', '2021-06-11 08:59:14', '', 0, 'https://demo.afthemes.com/morenews/?p=918', 52, 'nav_menu_item', '', 0),
(921, 1, '2022-08-30 11:15:24', '2021-06-11 08:59:14', '', 'Fitness Pro', '', 'publish', 'closed', 'closed', '', 'fitness-pro', '', '', '2022-08-30 11:15:24', '2021-06-11 08:59:14', '', 0, 'https://demo.afthemes.com/morenews/?p=919', 53, 'nav_menu_item', '', 0),
(963, 1, '2024-05-14 01:58:45', '2024-05-14 01:58:45', '<!-- wp:paragraph -->\n<p>In the dynamic world of WordPress, we emerge as a beacon of innovation and excellence. Our popular products, like <a href=\"https://afthemes.com/products/covernews-pro/\">CoverNews</a>, <a href=\"https://afthemes.com/products/chromenews-pro/\">ChromeNews</a>, <a href=\"https://afthemes.com/products/newsphere-pro/\">Newsphere</a>, and <a href=\"https://afthemes.com/products/shopical-pro/\">Shopical</a>, alongside powerful plugins such as <a href=\"https://afthemes.com/plugins/wp-post-author/\">WP Post Author</a>, <a href=\"https://blockspare.com/\">Blockspare</a>, and <a href=\"https://elespare.com/\">Elespare</a>, serve as the building blocks of your digital journey.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>We’re passionate about quality code and elegant design, ensuring your website creation is an effortless blend of sophistication and simplicity. With unwavering support from our dedicated team, you’re never alone.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:heading {\"textAlign\":\"left\"} -->\n<h2 class=\"wp-block-heading has-text-align-left\" id=\"phasellus-autem-placeat-laboris-sem-cupiditate-assumenda\"><a href=\"https://templatespare.com/\">Templatespare</a>: Create Your Dream Website with Easy Starter Sites!</h2>\n<!-- /wp:heading -->\n\n<!-- wp:embed {\"url\":\"https://www.youtube.com/watch?v=t7LMDLRE8Ok\",\"type\":\"video\",\"providerNameSlug\":\"youtube\",\"responsive\":true,\"className\":\"wp-embed-aspect-16-9 wp-has-aspect-ratio\"} -->\n<figure class=\"wp-block-embed is-type-video is-provider-youtube wp-block-embed-youtube wp-embed-aspect-16-9 wp-has-aspect-ratio\"><div class=\"wp-block-embed__wrapper\">\nhttps://www.youtube.com/watch?v=t7LMDLRE8Ok\n</div></figure>\n<!-- /wp:embed -->\n\n<!-- wp:quote -->\n<blockquote class=\"wp-block-quote\"><!-- wp:paragraph -->\n<p>A beautiful collection of Ready to Import Starter Sites with just one click. Get modern &amp; creative websites in minutes!</p>\n<!-- /wp:paragraph --><cite><strong><strong>Newspaper, Magazine,&nbsp;Blog,&nbsp;and eCommerce Ready</strong></strong></cite></blockquote>\n<!-- /wp:quote -->\n\n<!-- wp:heading -->\n<h2 class=\"wp-block-heading\"><strong>Forget About Starting From Scratch</strong></h2>\n<!-- /wp:heading -->\n\n<!-- wp:paragraph -->\n<p>Explore a world of creativity with 365+ ready-to-use website templates! From chic blogs to dynamic news platforms, engaging magazines, and professional agency websites - find your perfect online space! </p>\n<!-- /wp:paragraph -->\n\n<!-- wp:columns -->\n<div class=\"wp-block-columns\"><!-- wp:column -->\n<div class=\"wp-block-column\"><!-- wp:image {\"lightbox\":{\"enabled\":false},\"sizeSlug\":\"large\",\"linkDestination\":\"custom\"} -->\n<figure class=\"wp-block-image size-large\"><a href=\"https://afthemes.com/\" target=\"_blank\" rel=\"noreferrer noopener\"><img src=\"https://templatespare.com/wp-content/uploads/2024/05/How-to-Create-a-Website-in-Minutes.jpeg\" alt=\"\"/></a></figure>\n<!-- /wp:image --></div>\n<!-- /wp:column -->\n\n<!-- wp:column -->\n<div class=\"wp-block-column\"><!-- wp:group {\"layout\":{\"type\":\"constrained\"}} -->\n<div class=\"wp-block-group\"><!-- wp:heading {\"fontSize\":\"medium\"} -->\n<h2 class=\"wp-block-heading has-medium-font-size\">One Click Import: No Coding Hassle! Three Simple Steps</h2>\n<!-- /wp:heading -->\n\n<!-- wp:paragraph {\"style\":{\"elements\":{\"link\":{\"color\":{\"text\":\"var:preset|color|black\"}}}},\"textColor\":\"black\"} -->\n<p class=\"has-black-color has-text-color has-link-color\">Embark on your website journey with simplicity and style. Follow these 3 easy steps to create your online masterpiece effortlessly</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:buttons -->\n<div class=\"wp-block-buttons\"><!-- wp:button {\"className\":\"is-style-outline\",\"fontSize\":\"small\"} -->\n<div class=\"wp-block-button has-custom-font-size is-style-outline has-small-font-size\"><a class=\"wp-block-button__link wp-element-button\" href=\"https://afthemes.com/\">Explore More</a></div>\n<!-- /wp:button --></div>\n<!-- /wp:buttons --></div>\n<!-- /wp:group --></div>\n<!-- /wp:column --></div>\n<!-- /wp:columns -->\n\n<!-- wp:list {\"ordered\":true} -->\n<ol><!-- wp:list-item -->\n<li><strong>Choose a Site</strong><br>Explore a rich selection of over 350 pre-built websites. With a single click, import the site that resonates with your vision.</li>\n<!-- /wp:list-item -->\n\n<!-- wp:list-item -->\n<li><strong>Customize &amp; Personalize</strong><br>Unleash your creativity! Customize your chosen site with complete design freedom. Tailor every element to build and personalize your website exactly the way you envision it.</li>\n<!-- /wp:list-item -->\n\n<!-- wp:list-item -->\n<li><strong>Publish &amp; Go Live!</strong><br>With the editing and customization complete, it’s time to go live! In just minutes, your website will be ready to share with the world.</li>\n<!-- /wp:list-item --></ol>\n<!-- /wp:list -->\n\n<!-- wp:paragraph -->\n<p>Join the <a href=\"https://afthemes.com/\">AF themes</a> family, where excellence meets ease. Explore the endless possibilities and embark on your web journey with us today!</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>Together, we’re shaping the future of the web.</p>\n<!-- /wp:paragraph -->\n', 'Why local US newspapers are sounding the alarm', 'Build Your Website in Minutes with One-Click Import – No Coding Hassle!', 'publish', 'closed', 'closed', '', 'why-local-us-newspapers-are-sounding-the-alarm', '', '', '2024-05-14 01:58:45', '2024-05-14 01:58:45', '', 0, 'https://demo.afthemes.com/storymag-pro/?p=9', 0, 'post', '', 0),
(964, 1, '2024-05-14 02:58:45', '2024-05-14 02:58:45', '<!-- wp:paragraph -->\n<p>In the dynamic world of WordPress, we emerge as a beacon of innovation and excellence. Our popular products, like <a href=\"https://afthemes.com/products/covernews-pro/\">CoverNews</a>, <a href=\"https://afthemes.com/products/chromenews-pro/\">ChromeNews</a>, <a href=\"https://afthemes.com/products/newsphere-pro/\">Newsphere</a>, and <a href=\"https://afthemes.com/products/shopical-pro/\">Shopical</a>, alongside powerful plugins such as <a href=\"https://afthemes.com/plugins/wp-post-author/\">WP Post Author</a>, <a href=\"https://blockspare.com/\">Blockspare</a>, and <a href=\"https://elespare.com/\">Elespare</a>, serve as the building blocks of your digital journey.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>We’re passionate about quality code and elegant design, ensuring your website creation is an effortless blend of sophistication and simplicity. With unwavering support from our dedicated team, you’re never alone.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:heading {\"textAlign\":\"left\"} -->\n<h2 class=\"wp-block-heading has-text-align-left\" id=\"phasellus-autem-placeat-laboris-sem-cupiditate-assumenda\"><a href=\"https://templatespare.com/\">Templatespare</a>: Create Your Dream Website with Easy Starter Sites!</h2>\n<!-- /wp:heading -->\n\n<!-- wp:embed {\"url\":\"https://www.youtube.com/watch?v=t7LMDLRE8Ok\",\"type\":\"video\",\"providerNameSlug\":\"youtube\",\"responsive\":true,\"className\":\"wp-embed-aspect-16-9 wp-has-aspect-ratio\"} -->\n<figure class=\"wp-block-embed is-type-video is-provider-youtube wp-block-embed-youtube wp-embed-aspect-16-9 wp-has-aspect-ratio\"><div class=\"wp-block-embed__wrapper\">\nhttps://www.youtube.com/watch?v=t7LMDLRE8Ok\n</div></figure>\n<!-- /wp:embed -->\n\n<!-- wp:quote -->\n<blockquote class=\"wp-block-quote\"><!-- wp:paragraph -->\n<p>A beautiful collection of Ready to Import Starter Sites with just one click. Get modern &amp; creative websites in minutes!</p>\n<!-- /wp:paragraph --><cite><strong><strong>Newspaper, Magazine,&nbsp;Blog,&nbsp;and eCommerce Ready</strong></strong></cite></blockquote>\n<!-- /wp:quote -->\n\n<!-- wp:heading -->\n<h2 class=\"wp-block-heading\"><strong>Forget About Starting From Scratch</strong></h2>\n<!-- /wp:heading -->\n\n<!-- wp:paragraph -->\n<p>Explore a world of creativity with 365+ ready-to-use website templates! From chic blogs to dynamic news platforms, engaging magazines, and professional agency websites - find your perfect online space! </p>\n<!-- /wp:paragraph -->\n\n<!-- wp:columns -->\n<div class=\"wp-block-columns\"><!-- wp:column -->\n<div class=\"wp-block-column\"><!-- wp:image {\"lightbox\":{\"enabled\":false},\"sizeSlug\":\"large\",\"linkDestination\":\"custom\"} -->\n<figure class=\"wp-block-image size-large\"><a href=\"https://afthemes.com/\" target=\"_blank\" rel=\"noreferrer noopener\"><img src=\"https://templatespare.com/wp-content/uploads/2024/05/How-to-Create-a-Website-in-Minutes.jpeg\" alt=\"\"/></a></figure>\n<!-- /wp:image --></div>\n<!-- /wp:column -->\n\n<!-- wp:column -->\n<div class=\"wp-block-column\"><!-- wp:group {\"layout\":{\"type\":\"constrained\"}} -->\n<div class=\"wp-block-group\"><!-- wp:heading {\"fontSize\":\"medium\"} -->\n<h2 class=\"wp-block-heading has-medium-font-size\">One Click Import: No Coding Hassle! Three Simple Steps</h2>\n<!-- /wp:heading -->\n\n<!-- wp:paragraph {\"style\":{\"elements\":{\"link\":{\"color\":{\"text\":\"var:preset|color|black\"}}}},\"textColor\":\"black\"} -->\n<p class=\"has-black-color has-text-color has-link-color\">Embark on your website journey with simplicity and style. Follow these 3 easy steps to create your online masterpiece effortlessly</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:buttons -->\n<div class=\"wp-block-buttons\"><!-- wp:button {\"className\":\"is-style-outline\",\"fontSize\":\"small\"} -->\n<div class=\"wp-block-button has-custom-font-size is-style-outline has-small-font-size\"><a class=\"wp-block-button__link wp-element-button\" href=\"https://afthemes.com/\">Explore More</a></div>\n<!-- /wp:button --></div>\n<!-- /wp:buttons --></div>\n<!-- /wp:group --></div>\n<!-- /wp:column --></div>\n<!-- /wp:columns -->\n\n<!-- wp:list {\"ordered\":true} -->\n<ol><!-- wp:list-item -->\n<li><strong>Choose a Site</strong><br>Explore a rich selection of over 350 pre-built websites. With a single click, import the site that resonates with your vision.</li>\n<!-- /wp:list-item -->\n\n<!-- wp:list-item -->\n<li><strong>Customize &amp; Personalize</strong><br>Unleash your creativity! Customize your chosen site with complete design freedom. Tailor every element to build and personalize your website exactly the way you envision it.</li>\n<!-- /wp:list-item -->\n\n<!-- wp:list-item -->\n<li><strong>Publish &amp; Go Live!</strong><br>With the editing and customization complete, it’s time to go live! In just minutes, your website will be ready to share with the world.</li>\n<!-- /wp:list-item --></ol>\n<!-- /wp:list -->\n\n<!-- wp:paragraph -->\n<p>Join the <a href=\"https://afthemes.com/\">AF themes</a> family, where excellence meets ease. Explore the endless possibilities and embark on your web journey with us today!</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>Together, we’re shaping the future of the web.</p>\n<!-- /wp:paragraph -->\n', 'Searching for the \'angel\' who held me on Westminster Bridge', 'Build Your Website in Minutes with One-Click Import – No Coding Hassle!', 'publish', 'closed', 'closed', '', 'searching-for-the-angel-who-held-me-on-westminster-bridge', '', '', '2024-05-14 02:58:45', '2024-05-14 02:58:45', '', 0, 'https://demo.afthemes.com/storymag-pro/?p=12', 0, 'post', '', 0),
(965, 1, '2024-05-14 03:58:45', '2024-05-14 03:58:45', '<!-- wp:paragraph -->\n<p>In the dynamic world of WordPress, we emerge as a beacon of innovation and excellence. Our popular products, like <a href=\"https://afthemes.com/products/covernews-pro/\">CoverNews</a>, <a href=\"https://afthemes.com/products/chromenews-pro/\">ChromeNews</a>, <a href=\"https://afthemes.com/products/newsphere-pro/\">Newsphere</a>, and <a href=\"https://afthemes.com/products/shopical-pro/\">Shopical</a>, alongside powerful plugins such as <a href=\"https://afthemes.com/plugins/wp-post-author/\">WP Post Author</a>, <a href=\"https://blockspare.com/\">Blockspare</a>, and <a href=\"https://elespare.com/\">Elespare</a>, serve as the building blocks of your digital journey.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>We’re passionate about quality code and elegant design, ensuring your website creation is an effortless blend of sophistication and simplicity. With unwavering support from our dedicated team, you’re never alone.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:heading {\"textAlign\":\"left\"} -->\n<h2 class=\"wp-block-heading has-text-align-left\" id=\"phasellus-autem-placeat-laboris-sem-cupiditate-assumenda\"><a href=\"https://templatespare.com/\">Templatespare</a>: Create Your Dream Website with Easy Starter Sites!</h2>\n<!-- /wp:heading -->\n\n<!-- wp:embed {\"url\":\"https://www.youtube.com/watch?v=t7LMDLRE8Ok\",\"type\":\"video\",\"providerNameSlug\":\"youtube\",\"responsive\":true,\"className\":\"wp-embed-aspect-16-9 wp-has-aspect-ratio\"} -->\n<figure class=\"wp-block-embed is-type-video is-provider-youtube wp-block-embed-youtube wp-embed-aspect-16-9 wp-has-aspect-ratio\"><div class=\"wp-block-embed__wrapper\">\nhttps://www.youtube.com/watch?v=t7LMDLRE8Ok\n</div></figure>\n<!-- /wp:embed -->\n\n<!-- wp:quote -->\n<blockquote class=\"wp-block-quote\"><!-- wp:paragraph -->\n<p>A beautiful collection of Ready to Import Starter Sites with just one click. Get modern &amp; creative websites in minutes!</p>\n<!-- /wp:paragraph --><cite><strong><strong>Newspaper, Magazine,&nbsp;Blog,&nbsp;and eCommerce Ready</strong></strong></cite></blockquote>\n<!-- /wp:quote -->\n\n<!-- wp:heading -->\n<h2 class=\"wp-block-heading\"><strong>Forget About Starting From Scratch</strong></h2>\n<!-- /wp:heading -->\n\n<!-- wp:paragraph -->\n<p>Explore a world of creativity with 365+ ready-to-use website templates! From chic blogs to dynamic news platforms, engaging magazines, and professional agency websites - find your perfect online space! </p>\n<!-- /wp:paragraph -->\n\n<!-- wp:columns -->\n<div class=\"wp-block-columns\"><!-- wp:column -->\n<div class=\"wp-block-column\"><!-- wp:image {\"lightbox\":{\"enabled\":false},\"sizeSlug\":\"large\",\"linkDestination\":\"custom\"} -->\n<figure class=\"wp-block-image size-large\"><a href=\"https://afthemes.com/\" target=\"_blank\" rel=\"noreferrer noopener\"><img src=\"https://templatespare.com/wp-content/uploads/2024/05/How-to-Create-a-Website-in-Minutes.jpeg\" alt=\"\"/></a></figure>\n<!-- /wp:image --></div>\n<!-- /wp:column -->\n\n<!-- wp:column -->\n<div class=\"wp-block-column\"><!-- wp:group {\"layout\":{\"type\":\"constrained\"}} -->\n<div class=\"wp-block-group\"><!-- wp:heading {\"fontSize\":\"medium\"} -->\n<h2 class=\"wp-block-heading has-medium-font-size\">One Click Import: No Coding Hassle! Three Simple Steps</h2>\n<!-- /wp:heading -->\n\n<!-- wp:paragraph {\"style\":{\"elements\":{\"link\":{\"color\":{\"text\":\"var:preset|color|black\"}}}},\"textColor\":\"black\"} -->\n<p class=\"has-black-color has-text-color has-link-color\">Embark on your website journey with simplicity and style. Follow these 3 easy steps to create your online masterpiece effortlessly</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:buttons -->\n<div class=\"wp-block-buttons\"><!-- wp:button {\"className\":\"is-style-outline\",\"fontSize\":\"small\"} -->\n<div class=\"wp-block-button has-custom-font-size is-style-outline has-small-font-size\"><a class=\"wp-block-button__link wp-element-button\" href=\"https://afthemes.com/\">Explore More</a></div>\n<!-- /wp:button --></div>\n<!-- /wp:buttons --></div>\n<!-- /wp:group --></div>\n<!-- /wp:column --></div>\n<!-- /wp:columns -->\n\n<!-- wp:list {\"ordered\":true} -->\n<ol><!-- wp:list-item -->\n<li><strong>Choose a Site</strong><br>Explore a rich selection of over 350 pre-built websites. With a single click, import the site that resonates with your vision.</li>\n<!-- /wp:list-item -->\n\n<!-- wp:list-item -->\n<li><strong>Customize &amp; Personalize</strong><br>Unleash your creativity! Customize your chosen site with complete design freedom. Tailor every element to build and personalize your website exactly the way you envision it.</li>\n<!-- /wp:list-item -->\n\n<!-- wp:list-item -->\n<li><strong>Publish &amp; Go Live!</strong><br>With the editing and customization complete, it’s time to go live! In just minutes, your website will be ready to share with the world.</li>\n<!-- /wp:list-item --></ol>\n<!-- /wp:list -->\n\n<!-- wp:paragraph -->\n<p>Join the <a href=\"https://afthemes.com/\">AF themes</a> family, where excellence meets ease. Explore the endless possibilities and embark on your web journey with us today!</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>Together, we’re shaping the future of the web.</p>\n<!-- /wp:paragraph -->\n', 'All you need to know about penalty shootouts', 'Build Your Website in Minutes with One-Click Import – No Coding Hassle!', 'publish', 'closed', 'closed', '', 'all-you-need-to-know-about-penalty-shootouts', '', '', '2024-05-14 03:58:45', '2024-05-14 03:58:45', '', 0, 'https://demo.afthemes.com/storymag-pro/?p=15', 0, 'post', '', 0);
INSERT INTO `wp_posts` (`ID`, `post_author`, `post_date`, `post_date_gmt`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `ping_status`, `post_password`, `post_name`, `to_ping`, `pinged`, `post_modified`, `post_modified_gmt`, `post_content_filtered`, `post_parent`, `guid`, `menu_order`, `post_type`, `post_mime_type`, `comment_count`) VALUES
(966, 1, '2024-05-14 04:58:45', '2018-07-18 11:24:54', '<!-- wp:paragraph -->\n<p>In the dynamic world of WordPress, we emerge as a beacon of innovation and excellence. Our popular products, like <a href=\"https://afthemes.com/products/covernews-pro/\">CoverNews</a>, <a href=\"https://afthemes.com/products/chromenews-pro/\">ChromeNews</a>, <a href=\"https://afthemes.com/products/newsphere-pro/\">Newsphere</a>, and <a href=\"https://afthemes.com/products/shopical-pro/\">Shopical</a>, alongside powerful plugins such as <a href=\"https://afthemes.com/plugins/wp-post-author/\">WP Post Author</a>, <a href=\"https://blockspare.com/\">Blockspare</a>, and <a href=\"https://elespare.com/\">Elespare</a>, serve as the building blocks of your digital journey.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>We’re passionate about quality code and elegant design, ensuring your website creation is an effortless blend of sophistication and simplicity. With unwavering support from our dedicated team, you’re never alone.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:heading {\"textAlign\":\"left\"} -->\n<h2 class=\"wp-block-heading has-text-align-left\" id=\"phasellus-autem-placeat-laboris-sem-cupiditate-assumenda\"><a href=\"https://templatespare.com/\">Templatespare</a>: Create Your Dream Website with Easy Starter Sites!</h2>\n<!-- /wp:heading -->\n\n<!-- wp:embed {\"url\":\"https://www.youtube.com/watch?v=t7LMDLRE8Ok\",\"type\":\"video\",\"providerNameSlug\":\"youtube\",\"responsive\":true,\"className\":\"wp-embed-aspect-16-9 wp-has-aspect-ratio\"} -->\n<figure class=\"wp-block-embed is-type-video is-provider-youtube wp-block-embed-youtube wp-embed-aspect-16-9 wp-has-aspect-ratio\"><div class=\"wp-block-embed__wrapper\">\nhttps://www.youtube.com/watch?v=t7LMDLRE8Ok\n</div></figure>\n<!-- /wp:embed -->\n\n<!-- wp:quote -->\n<blockquote class=\"wp-block-quote\"><!-- wp:paragraph -->\n<p>A beautiful collection of Ready to Import Starter Sites with just one click. Get modern &amp; creative websites in minutes!</p>\n<!-- /wp:paragraph --><cite><strong><strong>Newspaper, Magazine,&nbsp;Blog,&nbsp;and eCommerce Ready</strong></strong></cite></blockquote>\n<!-- /wp:quote -->\n\n<!-- wp:heading -->\n<h2 class=\"wp-block-heading\"><strong>Forget About Starting From Scratch</strong></h2>\n<!-- /wp:heading -->\n\n<!-- wp:paragraph -->\n<p>Explore a world of creativity with 365+ ready-to-use website templates! From chic blogs to dynamic news platforms, engaging magazines, and professional agency websites - find your perfect online space! </p>\n<!-- /wp:paragraph -->\n\n<!-- wp:columns -->\n<div class=\"wp-block-columns\"><!-- wp:column -->\n<div class=\"wp-block-column\"><!-- wp:image {\"lightbox\":{\"enabled\":false},\"sizeSlug\":\"large\",\"linkDestination\":\"custom\"} -->\n<figure class=\"wp-block-image size-large\"><a href=\"https://afthemes.com/\" target=\"_blank\" rel=\"noreferrer noopener\"><img src=\"https://templatespare.com/wp-content/uploads/2024/05/How-to-Create-a-Website-in-Minutes.jpeg\" alt=\"\"/></a></figure>\n<!-- /wp:image --></div>\n<!-- /wp:column -->\n\n<!-- wp:column -->\n<div class=\"wp-block-column\"><!-- wp:group {\"layout\":{\"type\":\"constrained\"}} -->\n<div class=\"wp-block-group\"><!-- wp:heading {\"fontSize\":\"medium\"} -->\n<h2 class=\"wp-block-heading has-medium-font-size\">One Click Import: No Coding Hassle! Three Simple Steps</h2>\n<!-- /wp:heading -->\n\n<!-- wp:paragraph {\"style\":{\"elements\":{\"link\":{\"color\":{\"text\":\"var:preset|color|black\"}}}},\"textColor\":\"black\"} -->\n<p class=\"has-black-color has-text-color has-link-color\">Embark on your website journey with simplicity and style. Follow these 3 easy steps to create your online masterpiece effortlessly</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:buttons -->\n<div class=\"wp-block-buttons\"><!-- wp:button {\"className\":\"is-style-outline\",\"fontSize\":\"small\"} -->\n<div class=\"wp-block-button has-custom-font-size is-style-outline has-small-font-size\"><a class=\"wp-block-button__link wp-element-button\" href=\"https://afthemes.com/\">Explore More</a></div>\n<!-- /wp:button --></div>\n<!-- /wp:buttons --></div>\n<!-- /wp:group --></div>\n<!-- /wp:column --></div>\n<!-- /wp:columns -->\n\n<!-- wp:list {\"ordered\":true} -->\n<ol><!-- wp:list-item -->\n<li><strong>Choose a Site</strong><br>Explore a rich selection of over 350 pre-built websites. With a single click, import the site that resonates with your vision.</li>\n<!-- /wp:list-item -->\n\n<!-- wp:list-item -->\n<li><strong>Customize &amp; Personalize</strong><br>Unleash your creativity! Customize your chosen site with complete design freedom. Tailor every element to build and personalize your website exactly the way you envision it.</li>\n<!-- /wp:list-item -->\n\n<!-- wp:list-item -->\n<li><strong>Publish &amp; Go Live!</strong><br>With the editing and customization complete, it’s time to go live! In just minutes, your website will be ready to share with the world.</li>\n<!-- /wp:list-item --></ol>\n<!-- /wp:list -->\n\n<!-- wp:paragraph -->\n<p>Join the <a href=\"https://afthemes.com/\">AF themes</a> family, where excellence meets ease. Explore the endless possibilities and embark on your web journey with us today!</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>Together, we’re shaping the future of the web.</p>\n<!-- /wp:paragraph -->\n', 'The man who saved thousands of people from HIV', 'Build Your Website in Minutes with One-Click Import – No Coding Hassle!', 'publish', 'closed', 'closed', '', 'the-man-who-saved-thousands-of-people-from-hiv', '', '', '2024-05-14 04:58:45', '2018-07-18 11:24:54', '', 0, 'https://demo.afthemes.com/storymag-pro/?p=18', 0, 'post', '', 0),
(967, 1, '2024-05-14 05:58:45', '2024-05-14 05:58:45', '<!-- wp:paragraph -->\n<p>In the dynamic world of WordPress, we emerge as a beacon of innovation and excellence. Our popular products, like <a href=\"https://afthemes.com/products/covernews-pro/\">CoverNews</a>, <a href=\"https://afthemes.com/products/chromenews-pro/\">ChromeNews</a>, <a href=\"https://afthemes.com/products/newsphere-pro/\">Newsphere</a>, and <a href=\"https://afthemes.com/products/shopical-pro/\">Shopical</a>, alongside powerful plugins such as <a href=\"https://afthemes.com/plugins/wp-post-author/\">WP Post Author</a>, <a href=\"https://blockspare.com/\">Blockspare</a>, and <a href=\"https://elespare.com/\">Elespare</a>, serve as the building blocks of your digital journey.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>We’re passionate about quality code and elegant design, ensuring your website creation is an effortless blend of sophistication and simplicity. With unwavering support from our dedicated team, you’re never alone.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:heading {\"textAlign\":\"left\"} -->\n<h2 class=\"wp-block-heading has-text-align-left\" id=\"phasellus-autem-placeat-laboris-sem-cupiditate-assumenda\"><a href=\"https://templatespare.com/\">Templatespare</a>: Create Your Dream Website with Easy Starter Sites!</h2>\n<!-- /wp:heading -->\n\n<!-- wp:embed {\"url\":\"https://www.youtube.com/watch?v=t7LMDLRE8Ok\",\"type\":\"video\",\"providerNameSlug\":\"youtube\",\"responsive\":true,\"className\":\"wp-embed-aspect-16-9 wp-has-aspect-ratio\"} -->\n<figure class=\"wp-block-embed is-type-video is-provider-youtube wp-block-embed-youtube wp-embed-aspect-16-9 wp-has-aspect-ratio\"><div class=\"wp-block-embed__wrapper\">\nhttps://www.youtube.com/watch?v=t7LMDLRE8Ok\n</div></figure>\n<!-- /wp:embed -->\n\n<!-- wp:quote -->\n<blockquote class=\"wp-block-quote\"><!-- wp:paragraph -->\n<p>A beautiful collection of Ready to Import Starter Sites with just one click. Get modern &amp; creative websites in minutes!</p>\n<!-- /wp:paragraph --><cite><strong><strong>Newspaper, Magazine,&nbsp;Blog,&nbsp;and eCommerce Ready</strong></strong></cite></blockquote>\n<!-- /wp:quote -->\n\n<!-- wp:heading -->\n<h2 class=\"wp-block-heading\"><strong>Forget About Starting From Scratch</strong></h2>\n<!-- /wp:heading -->\n\n<!-- wp:paragraph -->\n<p>Explore a world of creativity with 365+ ready-to-use website templates! From chic blogs to dynamic news platforms, engaging magazines, and professional agency websites - find your perfect online space! </p>\n<!-- /wp:paragraph -->\n\n<!-- wp:columns -->\n<div class=\"wp-block-columns\"><!-- wp:column -->\n<div class=\"wp-block-column\"><!-- wp:image {\"lightbox\":{\"enabled\":false},\"sizeSlug\":\"large\",\"linkDestination\":\"custom\"} -->\n<figure class=\"wp-block-image size-large\"><a href=\"https://afthemes.com/\" target=\"_blank\" rel=\"noreferrer noopener\"><img src=\"https://templatespare.com/wp-content/uploads/2024/05/How-to-Create-a-Website-in-Minutes.jpeg\" alt=\"\"/></a></figure>\n<!-- /wp:image --></div>\n<!-- /wp:column -->\n\n<!-- wp:column -->\n<div class=\"wp-block-column\"><!-- wp:group {\"layout\":{\"type\":\"constrained\"}} -->\n<div class=\"wp-block-group\"><!-- wp:heading {\"fontSize\":\"medium\"} -->\n<h2 class=\"wp-block-heading has-medium-font-size\">One Click Import: No Coding Hassle! Three Simple Steps</h2>\n<!-- /wp:heading -->\n\n<!-- wp:paragraph {\"style\":{\"elements\":{\"link\":{\"color\":{\"text\":\"var:preset|color|black\"}}}},\"textColor\":\"black\"} -->\n<p class=\"has-black-color has-text-color has-link-color\">Embark on your website journey with simplicity and style. Follow these 3 easy steps to create your online masterpiece effortlessly</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:buttons -->\n<div class=\"wp-block-buttons\"><!-- wp:button {\"className\":\"is-style-outline\",\"fontSize\":\"small\"} -->\n<div class=\"wp-block-button has-custom-font-size is-style-outline has-small-font-size\"><a class=\"wp-block-button__link wp-element-button\" href=\"https://afthemes.com/\">Explore More</a></div>\n<!-- /wp:button --></div>\n<!-- /wp:buttons --></div>\n<!-- /wp:group --></div>\n<!-- /wp:column --></div>\n<!-- /wp:columns -->\n\n<!-- wp:list {\"ordered\":true} -->\n<ol><!-- wp:list-item -->\n<li><strong>Choose a Site</strong><br>Explore a rich selection of over 350 pre-built websites. With a single click, import the site that resonates with your vision.</li>\n<!-- /wp:list-item -->\n\n<!-- wp:list-item -->\n<li><strong>Customize &amp; Personalize</strong><br>Unleash your creativity! Customize your chosen site with complete design freedom. Tailor every element to build and personalize your website exactly the way you envision it.</li>\n<!-- /wp:list-item -->\n\n<!-- wp:list-item -->\n<li><strong>Publish &amp; Go Live!</strong><br>With the editing and customization complete, it’s time to go live! In just minutes, your website will be ready to share with the world.</li>\n<!-- /wp:list-item --></ol>\n<!-- /wp:list -->\n\n<!-- wp:paragraph -->\n<p>Join the <a href=\"https://afthemes.com/\">AF themes</a> family, where excellence meets ease. Explore the endless possibilities and embark on your web journey with us today!</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>Together, we’re shaping the future of the web.</p>\n<!-- /wp:paragraph -->\n', 'Searching for the forgotten heroes of World War Two', 'Build Your Website in Minutes with One-Click Import – No Coding Hassle!', 'publish', 'closed', 'closed', '', 'searching-for-the-forgotten-heroes-of-world-war-two', '', '', '2024-05-14 05:58:45', '2024-05-14 05:58:45', '', 0, 'https://demo.afthemes.com/storymag-pro/?p=21', 0, 'post', '', 0),
(968, 1, '2024-05-14 06:58:45', '2024-05-14 06:58:45', '<!-- wp:paragraph -->\n<p>In the dynamic world of WordPress, we emerge as a beacon of innovation and excellence. Our popular products, like <a href=\"https://afthemes.com/products/covernews-pro/\">CoverNews</a>, <a href=\"https://afthemes.com/products/chromenews-pro/\">ChromeNews</a>, <a href=\"https://afthemes.com/products/newsphere-pro/\">Newsphere</a>, and <a href=\"https://afthemes.com/products/shopical-pro/\">Shopical</a>, alongside powerful plugins such as <a href=\"https://afthemes.com/plugins/wp-post-author/\">WP Post Author</a>, <a href=\"https://blockspare.com/\">Blockspare</a>, and <a href=\"https://elespare.com/\">Elespare</a>, serve as the building blocks of your digital journey.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>We’re passionate about quality code and elegant design, ensuring your website creation is an effortless blend of sophistication and simplicity. With unwavering support from our dedicated team, you’re never alone.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:heading {\"textAlign\":\"left\"} -->\n<h2 class=\"wp-block-heading has-text-align-left\" id=\"phasellus-autem-placeat-laboris-sem-cupiditate-assumenda\"><a href=\"https://templatespare.com/\">Templatespare</a>: Create Your Dream Website with Easy Starter Sites!</h2>\n<!-- /wp:heading -->\n\n<!-- wp:embed {\"url\":\"https://www.youtube.com/watch?v=t7LMDLRE8Ok\",\"type\":\"video\",\"providerNameSlug\":\"youtube\",\"responsive\":true,\"className\":\"wp-embed-aspect-16-9 wp-has-aspect-ratio\"} -->\n<figure class=\"wp-block-embed is-type-video is-provider-youtube wp-block-embed-youtube wp-embed-aspect-16-9 wp-has-aspect-ratio\"><div class=\"wp-block-embed__wrapper\">\nhttps://www.youtube.com/watch?v=t7LMDLRE8Ok\n</div></figure>\n<!-- /wp:embed -->\n\n<!-- wp:quote -->\n<blockquote class=\"wp-block-quote\"><!-- wp:paragraph -->\n<p>A beautiful collection of Ready to Import Starter Sites with just one click. Get modern &amp; creative websites in minutes!</p>\n<!-- /wp:paragraph --><cite><strong><strong>Newspaper, Magazine,&nbsp;Blog,&nbsp;and eCommerce Ready</strong></strong></cite></blockquote>\n<!-- /wp:quote -->\n\n<!-- wp:heading -->\n<h2 class=\"wp-block-heading\"><strong>Forget About Starting From Scratch</strong></h2>\n<!-- /wp:heading -->\n\n<!-- wp:paragraph -->\n<p>Explore a world of creativity with 365+ ready-to-use website templates! From chic blogs to dynamic news platforms, engaging magazines, and professional agency websites - find your perfect online space! </p>\n<!-- /wp:paragraph -->\n\n<!-- wp:columns -->\n<div class=\"wp-block-columns\"><!-- wp:column -->\n<div class=\"wp-block-column\"><!-- wp:image {\"lightbox\":{\"enabled\":false},\"sizeSlug\":\"large\",\"linkDestination\":\"custom\"} -->\n<figure class=\"wp-block-image size-large\"><a href=\"https://afthemes.com/\" target=\"_blank\" rel=\"noreferrer noopener\"><img src=\"https://templatespare.com/wp-content/uploads/2024/05/How-to-Create-a-Website-in-Minutes.jpeg\" alt=\"\"/></a></figure>\n<!-- /wp:image --></div>\n<!-- /wp:column -->\n\n<!-- wp:column -->\n<div class=\"wp-block-column\"><!-- wp:group {\"layout\":{\"type\":\"constrained\"}} -->\n<div class=\"wp-block-group\"><!-- wp:heading {\"fontSize\":\"medium\"} -->\n<h2 class=\"wp-block-heading has-medium-font-size\">One Click Import: No Coding Hassle! Three Simple Steps</h2>\n<!-- /wp:heading -->\n\n<!-- wp:paragraph {\"style\":{\"elements\":{\"link\":{\"color\":{\"text\":\"var:preset|color|black\"}}}},\"textColor\":\"black\"} -->\n<p class=\"has-black-color has-text-color has-link-color\">Embark on your website journey with simplicity and style. Follow these 3 easy steps to create your online masterpiece effortlessly</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:buttons -->\n<div class=\"wp-block-buttons\"><!-- wp:button {\"className\":\"is-style-outline\",\"fontSize\":\"small\"} -->\n<div class=\"wp-block-button has-custom-font-size is-style-outline has-small-font-size\"><a class=\"wp-block-button__link wp-element-button\" href=\"https://afthemes.com/\">Explore More</a></div>\n<!-- /wp:button --></div>\n<!-- /wp:buttons --></div>\n<!-- /wp:group --></div>\n<!-- /wp:column --></div>\n<!-- /wp:columns -->\n\n<!-- wp:list {\"ordered\":true} -->\n<ol><!-- wp:list-item -->\n<li><strong>Choose a Site</strong><br>Explore a rich selection of over 350 pre-built websites. With a single click, import the site that resonates with your vision.</li>\n<!-- /wp:list-item -->\n\n<!-- wp:list-item -->\n<li><strong>Customize &amp; Personalize</strong><br>Unleash your creativity! Customize your chosen site with complete design freedom. Tailor every element to build and personalize your website exactly the way you envision it.</li>\n<!-- /wp:list-item -->\n\n<!-- wp:list-item -->\n<li><strong>Publish &amp; Go Live!</strong><br>With the editing and customization complete, it’s time to go live! In just minutes, your website will be ready to share with the world.</li>\n<!-- /wp:list-item --></ol>\n<!-- /wp:list -->\n\n<!-- wp:paragraph -->\n<p>Join the <a href=\"https://afthemes.com/\">AF themes</a> family, where excellence meets ease. Explore the endless possibilities and embark on your web journey with us today!</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>Together, we’re shaping the future of the web.</p>\n<!-- /wp:paragraph -->\n', '\'Somebody threatened to burn the school down\'', 'Build Your Website in Minutes with One-Click Import – No Coding Hassle!', 'publish', 'closed', 'closed', '', 'somebody-threatened-to-burn-the-school-down', '', '', '2024-05-14 06:58:45', '2024-05-14 06:58:45', '', 0, 'https://demo.afthemes.com/storymag-pro/?p=24', 0, 'post', '', 0),
(969, 1, '2024-05-14 07:58:45', '2024-05-14 07:58:45', '<!-- wp:paragraph -->\n<p>In the dynamic world of WordPress, we emerge as a beacon of innovation and excellence. Our popular products, like <a href=\"https://afthemes.com/products/covernews-pro/\">CoverNews</a>, <a href=\"https://afthemes.com/products/chromenews-pro/\">ChromeNews</a>, <a href=\"https://afthemes.com/products/newsphere-pro/\">Newsphere</a>, and <a href=\"https://afthemes.com/products/shopical-pro/\">Shopical</a>, alongside powerful plugins such as <a href=\"https://afthemes.com/plugins/wp-post-author/\">WP Post Author</a>, <a href=\"https://blockspare.com/\">Blockspare</a>, and <a href=\"https://elespare.com/\">Elespare</a>, serve as the building blocks of your digital journey.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>We’re passionate about quality code and elegant design, ensuring your website creation is an effortless blend of sophistication and simplicity. With unwavering support from our dedicated team, you’re never alone.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:heading {\"textAlign\":\"left\"} -->\n<h2 class=\"wp-block-heading has-text-align-left\" id=\"phasellus-autem-placeat-laboris-sem-cupiditate-assumenda\"><a href=\"https://templatespare.com/\">Templatespare</a>: Create Your Dream Website with Easy Starter Sites!</h2>\n<!-- /wp:heading -->\n\n<!-- wp:embed {\"url\":\"https://www.youtube.com/watch?v=t7LMDLRE8Ok\",\"type\":\"video\",\"providerNameSlug\":\"youtube\",\"responsive\":true,\"className\":\"wp-embed-aspect-16-9 wp-has-aspect-ratio\"} -->\n<figure class=\"wp-block-embed is-type-video is-provider-youtube wp-block-embed-youtube wp-embed-aspect-16-9 wp-has-aspect-ratio\"><div class=\"wp-block-embed__wrapper\">\nhttps://www.youtube.com/watch?v=t7LMDLRE8Ok\n</div></figure>\n<!-- /wp:embed -->\n\n<!-- wp:quote -->\n<blockquote class=\"wp-block-quote\"><!-- wp:paragraph -->\n<p>A beautiful collection of Ready to Import Starter Sites with just one click. Get modern &amp; creative websites in minutes!</p>\n<!-- /wp:paragraph --><cite><strong><strong>Newspaper, Magazine,&nbsp;Blog,&nbsp;and eCommerce Ready</strong></strong></cite></blockquote>\n<!-- /wp:quote -->\n\n<!-- wp:heading -->\n<h2 class=\"wp-block-heading\"><strong>Forget About Starting From Scratch</strong></h2>\n<!-- /wp:heading -->\n\n<!-- wp:paragraph -->\n<p>Explore a world of creativity with 365+ ready-to-use website templates! From chic blogs to dynamic news platforms, engaging magazines, and professional agency websites - find your perfect online space! </p>\n<!-- /wp:paragraph -->\n\n<!-- wp:columns -->\n<div class=\"wp-block-columns\"><!-- wp:column -->\n<div class=\"wp-block-column\"><!-- wp:image {\"lightbox\":{\"enabled\":false},\"sizeSlug\":\"large\",\"linkDestination\":\"custom\"} -->\n<figure class=\"wp-block-image size-large\"><a href=\"https://afthemes.com/\" target=\"_blank\" rel=\"noreferrer noopener\"><img src=\"https://templatespare.com/wp-content/uploads/2024/05/How-to-Create-a-Website-in-Minutes.jpeg\" alt=\"\"/></a></figure>\n<!-- /wp:image --></div>\n<!-- /wp:column -->\n\n<!-- wp:column -->\n<div class=\"wp-block-column\"><!-- wp:group {\"layout\":{\"type\":\"constrained\"}} -->\n<div class=\"wp-block-group\"><!-- wp:heading {\"fontSize\":\"medium\"} -->\n<h2 class=\"wp-block-heading has-medium-font-size\">One Click Import: No Coding Hassle! Three Simple Steps</h2>\n<!-- /wp:heading -->\n\n<!-- wp:paragraph {\"style\":{\"elements\":{\"link\":{\"color\":{\"text\":\"var:preset|color|black\"}}}},\"textColor\":\"black\"} -->\n<p class=\"has-black-color has-text-color has-link-color\">Embark on your website journey with simplicity and style. Follow these 3 easy steps to create your online masterpiece effortlessly</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:buttons -->\n<div class=\"wp-block-buttons\"><!-- wp:button {\"className\":\"is-style-outline\",\"fontSize\":\"small\"} -->\n<div class=\"wp-block-button has-custom-font-size is-style-outline has-small-font-size\"><a class=\"wp-block-button__link wp-element-button\" href=\"https://afthemes.com/\">Explore More</a></div>\n<!-- /wp:button --></div>\n<!-- /wp:buttons --></div>\n<!-- /wp:group --></div>\n<!-- /wp:column --></div>\n<!-- /wp:columns -->\n\n<!-- wp:list {\"ordered\":true} -->\n<ol><!-- wp:list-item -->\n<li><strong>Choose a Site</strong><br>Explore a rich selection of over 350 pre-built websites. With a single click, import the site that resonates with your vision.</li>\n<!-- /wp:list-item -->\n\n<!-- wp:list-item -->\n<li><strong>Customize &amp; Personalize</strong><br>Unleash your creativity! Customize your chosen site with complete design freedom. Tailor every element to build and personalize your website exactly the way you envision it.</li>\n<!-- /wp:list-item -->\n\n<!-- wp:list-item -->\n<li><strong>Publish &amp; Go Live!</strong><br>With the editing and customization complete, it’s time to go live! In just minutes, your website will be ready to share with the world.</li>\n<!-- /wp:list-item --></ol>\n<!-- /wp:list -->\n\n<!-- wp:paragraph -->\n<p>Join the <a href=\"https://afthemes.com/\">AF themes</a> family, where excellence meets ease. Explore the endless possibilities and embark on your web journey with us today!</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>Together, we’re shaping the future of the web.</p>\n<!-- /wp:paragraph -->\n', 'Trump-Putin: Your toolkit to help understand the story', 'Build Your Website in Minutes with One-Click Import – No Coding Hassle!', 'publish', 'closed', 'closed', '', 'trump-putin-your-toolkit-to-help-understand-the-story', '', '', '2024-05-14 07:58:45', '2024-05-14 07:58:45', '', 0, 'https://demo.afthemes.com/storymag-pro/?p=27', 0, 'post', '', 0),
(970, 1, '2024-05-14 08:58:45', '2024-05-14 08:58:45', '<!-- wp:paragraph -->\n<p>In the dynamic world of WordPress, we emerge as a beacon of innovation and excellence. Our popular products, like <a href=\"https://afthemes.com/products/covernews-pro/\">CoverNews</a>, <a href=\"https://afthemes.com/products/chromenews-pro/\">ChromeNews</a>, <a href=\"https://afthemes.com/products/newsphere-pro/\">Newsphere</a>, and <a href=\"https://afthemes.com/products/shopical-pro/\">Shopical</a>, alongside powerful plugins such as <a href=\"https://afthemes.com/plugins/wp-post-author/\">WP Post Author</a>, <a href=\"https://blockspare.com/\">Blockspare</a>, and <a href=\"https://elespare.com/\">Elespare</a>, serve as the building blocks of your digital journey.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>We’re passionate about quality code and elegant design, ensuring your website creation is an effortless blend of sophistication and simplicity. With unwavering support from our dedicated team, you’re never alone.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:heading {\"textAlign\":\"left\"} -->\n<h2 class=\"wp-block-heading has-text-align-left\" id=\"phasellus-autem-placeat-laboris-sem-cupiditate-assumenda\"><a href=\"https://templatespare.com/\">Templatespare</a>: Create Your Dream Website with Easy Starter Sites!</h2>\n<!-- /wp:heading -->\n\n<!-- wp:embed {\"url\":\"https://www.youtube.com/watch?v=t7LMDLRE8Ok\",\"type\":\"video\",\"providerNameSlug\":\"youtube\",\"responsive\":true,\"className\":\"wp-embed-aspect-16-9 wp-has-aspect-ratio\"} -->\n<figure class=\"wp-block-embed is-type-video is-provider-youtube wp-block-embed-youtube wp-embed-aspect-16-9 wp-has-aspect-ratio\"><div class=\"wp-block-embed__wrapper\">\nhttps://www.youtube.com/watch?v=t7LMDLRE8Ok\n</div></figure>\n<!-- /wp:embed -->\n\n<!-- wp:quote -->\n<blockquote class=\"wp-block-quote\"><!-- wp:paragraph -->\n<p>A beautiful collection of Ready to Import Starter Sites with just one click. Get modern &amp; creative websites in minutes!</p>\n<!-- /wp:paragraph --><cite><strong><strong>Newspaper, Magazine,&nbsp;Blog,&nbsp;and eCommerce Ready</strong></strong></cite></blockquote>\n<!-- /wp:quote -->\n\n<!-- wp:heading -->\n<h2 class=\"wp-block-heading\"><strong>Forget About Starting From Scratch</strong></h2>\n<!-- /wp:heading -->\n\n<!-- wp:paragraph -->\n<p>Explore a world of creativity with 365+ ready-to-use website templates! From chic blogs to dynamic news platforms, engaging magazines, and professional agency websites - find your perfect online space! </p>\n<!-- /wp:paragraph -->\n\n<!-- wp:columns -->\n<div class=\"wp-block-columns\"><!-- wp:column -->\n<div class=\"wp-block-column\"><!-- wp:image {\"lightbox\":{\"enabled\":false},\"sizeSlug\":\"large\",\"linkDestination\":\"custom\"} -->\n<figure class=\"wp-block-image size-large\"><a href=\"https://afthemes.com/\" target=\"_blank\" rel=\"noreferrer noopener\"><img src=\"https://templatespare.com/wp-content/uploads/2024/05/How-to-Create-a-Website-in-Minutes.jpeg\" alt=\"\"/></a></figure>\n<!-- /wp:image --></div>\n<!-- /wp:column -->\n\n<!-- wp:column -->\n<div class=\"wp-block-column\"><!-- wp:group {\"layout\":{\"type\":\"constrained\"}} -->\n<div class=\"wp-block-group\"><!-- wp:heading {\"fontSize\":\"medium\"} -->\n<h2 class=\"wp-block-heading has-medium-font-size\">One Click Import: No Coding Hassle! Three Simple Steps</h2>\n<!-- /wp:heading -->\n\n<!-- wp:paragraph {\"style\":{\"elements\":{\"link\":{\"color\":{\"text\":\"var:preset|color|black\"}}}},\"textColor\":\"black\"} -->\n<p class=\"has-black-color has-text-color has-link-color\">Embark on your website journey with simplicity and style. Follow these 3 easy steps to create your online masterpiece effortlessly</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:buttons -->\n<div class=\"wp-block-buttons\"><!-- wp:button {\"className\":\"is-style-outline\",\"fontSize\":\"small\"} -->\n<div class=\"wp-block-button has-custom-font-size is-style-outline has-small-font-size\"><a class=\"wp-block-button__link wp-element-button\" href=\"https://afthemes.com/\">Explore More</a></div>\n<!-- /wp:button --></div>\n<!-- /wp:buttons --></div>\n<!-- /wp:group --></div>\n<!-- /wp:column --></div>\n<!-- /wp:columns -->\n\n<!-- wp:list {\"ordered\":true} -->\n<ol><!-- wp:list-item -->\n<li><strong>Choose a Site</strong><br>Explore a rich selection of over 350 pre-built websites. With a single click, import the site that resonates with your vision.</li>\n<!-- /wp:list-item -->\n\n<!-- wp:list-item -->\n<li><strong>Customize &amp; Personalize</strong><br>Unleash your creativity! Customize your chosen site with complete design freedom. Tailor every element to build and personalize your website exactly the way you envision it.</li>\n<!-- /wp:list-item -->\n\n<!-- wp:list-item -->\n<li><strong>Publish &amp; Go Live!</strong><br>With the editing and customization complete, it’s time to go live! In just minutes, your website will be ready to share with the world.</li>\n<!-- /wp:list-item --></ol>\n<!-- /wp:list -->\n\n<!-- wp:paragraph -->\n<p>Join the <a href=\"https://afthemes.com/\">AF themes</a> family, where excellence meets ease. Explore the endless possibilities and embark on your web journey with us today!</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>Together, we’re shaping the future of the web.</p>\n<!-- /wp:paragraph -->\n', 'Business booming for giant cargo planes', 'Build Your Website in Minutes with One-Click Import – No Coding Hassle!', 'publish', 'closed', 'closed', '', 'business-booming-for-giant-cargo-planes', '', '', '2024-05-14 08:58:45', '2024-05-14 08:58:45', '', 0, 'https://demo.afthemes.com/storymag-pro/?p=30', 0, 'post', '', 0),
(971, 1, '2024-05-14 09:58:45', '2024-05-14 09:58:45', '<!-- wp:paragraph -->\n<p>In the dynamic world of WordPress, we emerge as a beacon of innovation and excellence. Our popular products, like <a href=\"https://afthemes.com/products/covernews-pro/\">CoverNews</a>, <a href=\"https://afthemes.com/products/chromenews-pro/\">ChromeNews</a>, <a href=\"https://afthemes.com/products/newsphere-pro/\">Newsphere</a>, and <a href=\"https://afthemes.com/products/shopical-pro/\">Shopical</a>, alongside powerful plugins such as <a href=\"https://afthemes.com/plugins/wp-post-author/\">WP Post Author</a>, <a href=\"https://blockspare.com/\">Blockspare</a>, and <a href=\"https://elespare.com/\">Elespare</a>, serve as the building blocks of your digital journey.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>We’re passionate about quality code and elegant design, ensuring your website creation is an effortless blend of sophistication and simplicity. With unwavering support from our dedicated team, you’re never alone.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:heading {\"textAlign\":\"left\"} -->\n<h2 class=\"wp-block-heading has-text-align-left\" id=\"phasellus-autem-placeat-laboris-sem-cupiditate-assumenda\"><a href=\"https://templatespare.com/\">Templatespare</a>: Create Your Dream Website with Easy Starter Sites!</h2>\n<!-- /wp:heading -->\n\n<!-- wp:embed {\"url\":\"https://www.youtube.com/watch?v=t7LMDLRE8Ok\",\"type\":\"video\",\"providerNameSlug\":\"youtube\",\"responsive\":true,\"className\":\"wp-embed-aspect-16-9 wp-has-aspect-ratio\"} -->\n<figure class=\"wp-block-embed is-type-video is-provider-youtube wp-block-embed-youtube wp-embed-aspect-16-9 wp-has-aspect-ratio\"><div class=\"wp-block-embed__wrapper\">\nhttps://www.youtube.com/watch?v=t7LMDLRE8Ok\n</div></figure>\n<!-- /wp:embed -->\n\n<!-- wp:quote -->\n<blockquote class=\"wp-block-quote\"><!-- wp:paragraph -->\n<p>A beautiful collection of Ready to Import Starter Sites with just one click. Get modern &amp; creative websites in minutes!</p>\n<!-- /wp:paragraph --><cite><strong><strong>Newspaper, Magazine,&nbsp;Blog,&nbsp;and eCommerce Ready</strong></strong></cite></blockquote>\n<!-- /wp:quote -->\n\n<!-- wp:heading -->\n<h2 class=\"wp-block-heading\"><strong>Forget About Starting From Scratch</strong></h2>\n<!-- /wp:heading -->\n\n<!-- wp:paragraph -->\n<p>Explore a world of creativity with 365+ ready-to-use website templates! From chic blogs to dynamic news platforms, engaging magazines, and professional agency websites - find your perfect online space! </p>\n<!-- /wp:paragraph -->\n\n<!-- wp:columns -->\n<div class=\"wp-block-columns\"><!-- wp:column -->\n<div class=\"wp-block-column\"><!-- wp:image {\"lightbox\":{\"enabled\":false},\"sizeSlug\":\"large\",\"linkDestination\":\"custom\"} -->\n<figure class=\"wp-block-image size-large\"><a href=\"https://afthemes.com/\" target=\"_blank\" rel=\"noreferrer noopener\"><img src=\"https://templatespare.com/wp-content/uploads/2024/05/How-to-Create-a-Website-in-Minutes.jpeg\" alt=\"\"/></a></figure>\n<!-- /wp:image --></div>\n<!-- /wp:column -->\n\n<!-- wp:column -->\n<div class=\"wp-block-column\"><!-- wp:group {\"layout\":{\"type\":\"constrained\"}} -->\n<div class=\"wp-block-group\"><!-- wp:heading {\"fontSize\":\"medium\"} -->\n<h2 class=\"wp-block-heading has-medium-font-size\">One Click Import: No Coding Hassle! Three Simple Steps</h2>\n<!-- /wp:heading -->\n\n<!-- wp:paragraph {\"style\":{\"elements\":{\"link\":{\"color\":{\"text\":\"var:preset|color|black\"}}}},\"textColor\":\"black\"} -->\n<p class=\"has-black-color has-text-color has-link-color\">Embark on your website journey with simplicity and style. Follow these 3 easy steps to create your online masterpiece effortlessly</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:buttons -->\n<div class=\"wp-block-buttons\"><!-- wp:button {\"className\":\"is-style-outline\",\"fontSize\":\"small\"} -->\n<div class=\"wp-block-button has-custom-font-size is-style-outline has-small-font-size\"><a class=\"wp-block-button__link wp-element-button\" href=\"https://afthemes.com/\">Explore More</a></div>\n<!-- /wp:button --></div>\n<!-- /wp:buttons --></div>\n<!-- /wp:group --></div>\n<!-- /wp:column --></div>\n<!-- /wp:columns -->\n\n<!-- wp:list {\"ordered\":true} -->\n<ol><!-- wp:list-item -->\n<li><strong>Choose a Site</strong><br>Explore a rich selection of over 350 pre-built websites. With a single click, import the site that resonates with your vision.</li>\n<!-- /wp:list-item -->\n\n<!-- wp:list-item -->\n<li><strong>Customize &amp; Personalize</strong><br>Unleash your creativity! Customize your chosen site with complete design freedom. Tailor every element to build and personalize your website exactly the way you envision it.</li>\n<!-- /wp:list-item -->\n\n<!-- wp:list-item -->\n<li><strong>Publish &amp; Go Live!</strong><br>With the editing and customization complete, it’s time to go live! In just minutes, your website will be ready to share with the world.</li>\n<!-- /wp:list-item --></ol>\n<!-- /wp:list -->\n\n<!-- wp:paragraph -->\n<p>Join the <a href=\"https://afthemes.com/\">AF themes</a> family, where excellence meets ease. Explore the endless possibilities and embark on your web journey with us today!</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>Together, we’re shaping the future of the web.</p>\n<!-- /wp:paragraph -->\n', 'Google hit with record EU fine over Shopping service', 'Build Your Website in Minutes with One-Click Import – No Coding Hassle!', 'publish', 'closed', 'closed', '', 'google-hit-with-record-eu-fine-over-shopping-service', '', '', '2024-05-14 09:58:45', '2024-05-14 09:58:45', '', 0, 'https://demo.afthemes.com/storymag-pro/?p=33', 0, 'post', '', 0),
(994, 1, '2024-05-31 05:21:29', '2024-05-31 05:21:29', 'https://demos.afthemes.com/morenews/horizon-times/wp-content/uploads/sites/25/2018/07/cropped-flower-military-pattern-soldier-army-red-672477-pxhere.com_-1.jpg', 'flower-military-pattern-soldier-army-red-672477-pxhere.com', '', 'inherit', 'closed', 'closed', '', 'flower-military-pattern-soldier-army-red-672477-pxhere-com-2', '', '', '2024-05-31 05:21:29', '2024-05-31 05:21:29', '', 0, 'https://demos.afthemes.com/morenews/horizon-times/wp-content/uploads/sites/25/2018/07/cropped-flower-military-pattern-soldier-army-red-672477-pxhere.com_-1.jpg', 0, 'attachment', 'image/jpeg', 0),
(995, 1, '2024-04-23 10:07:37', '2024-04-23 10:07:37', '<!-- wp:page-list /-->', 'Navigation', '', 'publish', 'closed', 'closed', '', 'navigation-2', '', '', '2024-04-23 10:07:37', '2024-04-23 10:07:37', '', 0, 'https://demos.afthemes.com/morenews/covernews/2024/04/23/navigation/', 0, 'wp_navigation', '', 0),
(996, 1, '2024-12-21 08:51:26', '2024-12-21 08:51:26', '', 'cropped-flower-military-pattern-soldier-army-red-672477-pxhere.com_-1', '', 'inherit', 'open', 'closed', '', 'cropped-flower-military-pattern-soldier-army-red-672477-pxhere-com_-1', '', '', '2024-12-21 08:51:26', '2024-12-21 08:51:26', '', 0, 'http://datws.test/wp-content/uploads/2024/12/cropped-flower-military-pattern-soldier-army-red-672477-pxhere.com_-1.jpg', 0, 'attachment', 'image/jpeg', 0),
(1000, 1, '2025-02-15 15:24:43', '2025-02-15 15:24:43', '{\"version\": 3, \"isGlobalStylesUserThemeJSON\": true }', 'Custom Styles', '', 'publish', 'closed', 'closed', '', 'wp-global-styles-morenews', '', '', '2025-02-15 15:24:43', '2025-02-15 15:24:43', '', 0, 'http://datws.test/2025/02/15/wp-global-styles-morenews/', 0, 'wp_global_styles', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `wp_termmeta`
--

CREATE TABLE `wp_termmeta` (
  `meta_id` bigint UNSIGNED NOT NULL,
  `term_id` bigint UNSIGNED NOT NULL DEFAULT '0',
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_520_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wp_terms`
--

CREATE TABLE `wp_terms` (
  `term_id` bigint UNSIGNED NOT NULL,
  `name` varchar(200) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `slug` varchar(200) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `term_group` bigint NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `wp_terms`
--

INSERT INTO `wp_terms` (`term_id`, `name`, `slug`, `term_group`) VALUES
(1, 'Chưa phân loại', 'khong-phan-loai', 0),
(2, 'twentytwentyfour', 'twentytwentyfour', 0),
(3, 'header', 'header', 0),
(4, 'Business', 'business', 0),
(5, 'Health', 'health', 0),
(6, 'Newsbeat', 'newsbeat', 0),
(7, 'Science', 'science', 0),
(8, 'Sports', 'sports', 0),
(9, 'Stories', 'stories', 0),
(10, 'Tech', 'tech', 0),
(11, 'Uncategorized', 'uncategorized', 0),
(12, 'World', 'world', 0),
(13, 'Business', 'business', 0),
(14, 'Health', 'health', 0),
(15, 'Newsbeat', 'newsbeat', 0),
(16, 'Science', 'science', 0),
(17, 'Sport', 'sport', 0),
(18, 'Stories', 'stories', 0),
(19, 'World', 'world', 0),
(20, 'Footer menu items', 'footer-menu-items', 0),
(21, 'Gallery', 'post-format-gallery', 0),
(22, 'Image', 'post-format-image', 0),
(23, 'Main menu items', 'main-menu-items', 0),
(24, 'Secondary Menu Items', 'secondary-menu-items', 0),
(25, 'Social menu items', 'social-menu-items', 0),
(26, 'Video', 'post-format-video', 0),
(27, 'morenews', 'morenews', 0);

-- --------------------------------------------------------

--
-- Table structure for table `wp_term_relationships`
--

CREATE TABLE `wp_term_relationships` (
  `object_id` bigint UNSIGNED NOT NULL DEFAULT '0',
  `term_taxonomy_id` bigint UNSIGNED NOT NULL DEFAULT '0',
  `term_order` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `wp_term_relationships`
--

INSERT INTO `wp_term_relationships` (`object_id`, `term_taxonomy_id`, `term_order`) VALUES
(1, 1, 0),
(6, 2, 0),
(12, 2, 0),
(12, 3, 0),
(44, 25, 0),
(45, 25, 0),
(51, 20, 0),
(133, 20, 0),
(267, 11, 0),
(298, 25, 0),
(299, 25, 0),
(300, 25, 0),
(302, 25, 0),
(336, 24, 0),
(337, 24, 0),
(342, 24, 0),
(525, 24, 0),
(526, 24, 0),
(864, 23, 0),
(865, 23, 0),
(866, 23, 0),
(867, 23, 0),
(868, 23, 0),
(870, 23, 0),
(871, 23, 0),
(872, 23, 0),
(873, 23, 0),
(875, 23, 0),
(876, 23, 0),
(877, 23, 0),
(882, 23, 0),
(883, 23, 0),
(884, 23, 0),
(885, 23, 0),
(886, 23, 0),
(887, 23, 0),
(888, 23, 0),
(889, 23, 0),
(890, 23, 0),
(891, 23, 0),
(892, 23, 0),
(893, 23, 0),
(894, 23, 0),
(895, 23, 0),
(896, 23, 0),
(897, 23, 0),
(898, 23, 0),
(899, 23, 0),
(900, 23, 0),
(901, 23, 0),
(902, 23, 0),
(903, 23, 0),
(904, 23, 0),
(905, 23, 0),
(906, 23, 0),
(907, 23, 0),
(908, 23, 0),
(909, 23, 0),
(910, 23, 0),
(911, 23, 0),
(912, 23, 0),
(913, 23, 0),
(916, 23, 0),
(917, 23, 0),
(918, 23, 0),
(919, 23, 0),
(920, 23, 0),
(921, 23, 0),
(963, 11, 0),
(964, 11, 0),
(965, 11, 0),
(966, 11, 0),
(967, 11, 0),
(968, 11, 0),
(969, 11, 0),
(970, 11, 0),
(971, 11, 0),
(1000, 27, 0);

-- --------------------------------------------------------

--
-- Table structure for table `wp_term_taxonomy`
--

CREATE TABLE `wp_term_taxonomy` (
  `term_taxonomy_id` bigint UNSIGNED NOT NULL,
  `term_id` bigint UNSIGNED NOT NULL DEFAULT '0',
  `taxonomy` varchar(32) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `description` longtext COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `parent` bigint UNSIGNED NOT NULL DEFAULT '0',
  `count` bigint NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `wp_term_taxonomy`
--

INSERT INTO `wp_term_taxonomy` (`term_taxonomy_id`, `term_id`, `taxonomy`, `description`, `parent`, `count`) VALUES
(1, 1, 'category', '', 0, 1),
(2, 2, 'wp_theme', '', 0, 2),
(3, 3, 'wp_template_part_area', '', 0, 1),
(4, 4, 'category', '', 0, 0),
(5, 5, 'category', '', 0, 0),
(6, 6, 'category', '', 0, 0),
(7, 7, 'category', '', 0, 0),
(8, 8, 'category', '', 0, 0),
(9, 9, 'category', '', 0, 0),
(10, 10, 'category', '', 0, 0),
(11, 11, 'category', '', 0, 10),
(12, 12, 'category', '', 0, 0),
(13, 13, 'post_tag', '', 0, 0),
(14, 14, 'post_tag', '', 0, 0),
(15, 15, 'post_tag', '', 0, 0),
(16, 16, 'post_tag', '', 0, 0),
(17, 17, 'post_tag', '', 0, 0),
(18, 18, 'post_tag', '', 0, 0),
(19, 19, 'post_tag', '', 0, 0),
(20, 20, 'nav_menu', '', 0, 2),
(21, 21, 'post_format', '', 0, 0),
(22, 22, 'post_format', '', 0, 0),
(23, 23, 'nav_menu', '', 0, 50),
(24, 24, 'nav_menu', '', 0, 5),
(25, 25, 'nav_menu', '', 0, 6),
(26, 26, 'post_format', '', 0, 0),
(27, 27, 'wp_theme', '', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `wp_usermeta`
--

CREATE TABLE `wp_usermeta` (
  `umeta_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL DEFAULT '0',
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_520_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `wp_usermeta`
--

INSERT INTO `wp_usermeta` (`umeta_id`, `user_id`, `meta_key`, `meta_value`) VALUES
(1, 1, 'nickname', 'webmaster'),
(2, 1, 'first_name', ''),
(3, 1, 'last_name', ''),
(4, 1, 'description', ''),
(5, 1, 'rich_editing', 'true'),
(6, 1, 'syntax_highlighting', 'true'),
(7, 1, 'comment_shortcuts', 'false'),
(8, 1, 'admin_color', 'fresh'),
(9, 1, 'use_ssl', '0'),
(10, 1, 'show_admin_bar_front', 'true'),
(11, 1, 'locale', ''),
(12, 1, 'wp_capabilities', 'a:1:{s:13:\"administrator\";b:1;}'),
(13, 1, 'wp_user_level', '10'),
(14, 1, 'dismissed_wp_pointers', 'theme_editor_notice'),
(15, 1, 'show_welcome_panel', '1'),
(16, 1, 'session_tokens', 'a:1:{s:64:\"c97dac9a2e6d3d0696e0e6f60ff63e47eab87a99f79c2681bf32f69ac44dc2c7\";a:4:{s:10:\"expiration\";i:1739805861;s:2:\"ip\";s:9:\"127.0.0.1\";s:2:\"ua\";s:111:\"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36\";s:5:\"login\";i:1739633061;}}'),
(17, 1, 'wp_dashboard_quick_press_last_post_id', '998'),
(18, 1, 'community-events-location', 'a:1:{s:2:\"ip\";s:9:\"127.0.0.0\";}'),
(19, 1, 'wp_persisted_preferences', 'a:4:{s:4:\"core\";a:1:{s:26:\"isComplementaryAreaVisible\";b:0;}s:14:\"core/edit-site\";a:1:{s:12:\"welcomeGuide\";b:0;}s:9:\"_modified\";s:24:\"2024-09-04T13:03:49.650Z\";s:14:\"core/edit-post\";a:1:{s:12:\"welcomeGuide\";b:0;}}'),
(20, 1, 'wp_user-settings', 'libraryContent=browse'),
(21, 1, 'wp_user-settings-time', '1732631837');

-- --------------------------------------------------------

--
-- Table structure for table `wp_users`
--

CREATE TABLE `wp_users` (
  `ID` bigint UNSIGNED NOT NULL,
  `user_login` varchar(60) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `user_pass` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `user_nicename` varchar(50) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `user_email` varchar(100) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `user_url` varchar(100) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `user_registered` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user_activation_key` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `user_status` int NOT NULL DEFAULT '0',
  `display_name` varchar(250) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `wp_users`
--

INSERT INTO `wp_users` (`ID`, `user_login`, `user_pass`, `user_nicename`, `user_email`, `user_url`, `user_registered`, `user_activation_key`, `user_status`, `display_name`) VALUES
(1, 'webmaster', '$P$B/Y66He9ns5a4EKfzM1/0991VrhQNB0', 'webmaster', 'hoangtiendat.20042011@gmail.com', 'http://datws.test', '2024-08-29 13:20:57', '', 0, 'webmaster');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `wp_commentmeta`
--
ALTER TABLE `wp_commentmeta`
  ADD PRIMARY KEY (`meta_id`),
  ADD KEY `comment_id` (`comment_id`),
  ADD KEY `meta_key` (`meta_key`(191));

--
-- Indexes for table `wp_comments`
--
ALTER TABLE `wp_comments`
  ADD PRIMARY KEY (`comment_ID`),
  ADD KEY `comment_post_ID` (`comment_post_ID`),
  ADD KEY `comment_approved_date_gmt` (`comment_approved`,`comment_date_gmt`),
  ADD KEY `comment_date_gmt` (`comment_date_gmt`),
  ADD KEY `comment_parent` (`comment_parent`),
  ADD KEY `comment_author_email` (`comment_author_email`(10));

--
-- Indexes for table `wp_links`
--
ALTER TABLE `wp_links`
  ADD PRIMARY KEY (`link_id`),
  ADD KEY `link_visible` (`link_visible`);

--
-- Indexes for table `wp_options`
--
ALTER TABLE `wp_options`
  ADD PRIMARY KEY (`option_id`),
  ADD UNIQUE KEY `option_name` (`option_name`),
  ADD KEY `autoload` (`autoload`);

--
-- Indexes for table `wp_postmeta`
--
ALTER TABLE `wp_postmeta`
  ADD PRIMARY KEY (`meta_id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `meta_key` (`meta_key`(191));

--
-- Indexes for table `wp_posts`
--
ALTER TABLE `wp_posts`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `post_name` (`post_name`(191)),
  ADD KEY `type_status_date` (`post_type`,`post_status`,`post_date`,`ID`),
  ADD KEY `post_parent` (`post_parent`),
  ADD KEY `post_author` (`post_author`);

--
-- Indexes for table `wp_termmeta`
--
ALTER TABLE `wp_termmeta`
  ADD PRIMARY KEY (`meta_id`),
  ADD KEY `term_id` (`term_id`),
  ADD KEY `meta_key` (`meta_key`(191));

--
-- Indexes for table `wp_terms`
--
ALTER TABLE `wp_terms`
  ADD PRIMARY KEY (`term_id`),
  ADD KEY `slug` (`slug`(191)),
  ADD KEY `name` (`name`(191));

--
-- Indexes for table `wp_term_relationships`
--
ALTER TABLE `wp_term_relationships`
  ADD PRIMARY KEY (`object_id`,`term_taxonomy_id`),
  ADD KEY `term_taxonomy_id` (`term_taxonomy_id`);

--
-- Indexes for table `wp_term_taxonomy`
--
ALTER TABLE `wp_term_taxonomy`
  ADD PRIMARY KEY (`term_taxonomy_id`),
  ADD UNIQUE KEY `term_id_taxonomy` (`term_id`,`taxonomy`),
  ADD KEY `taxonomy` (`taxonomy`);

--
-- Indexes for table `wp_usermeta`
--
ALTER TABLE `wp_usermeta`
  ADD PRIMARY KEY (`umeta_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `meta_key` (`meta_key`(191));

--
-- Indexes for table `wp_users`
--
ALTER TABLE `wp_users`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `user_login_key` (`user_login`),
  ADD KEY `user_nicename` (`user_nicename`),
  ADD KEY `user_email` (`user_email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `wp_commentmeta`
--
ALTER TABLE `wp_commentmeta`
  MODIFY `meta_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wp_comments`
--
ALTER TABLE `wp_comments`
  MODIFY `comment_ID` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `wp_links`
--
ALTER TABLE `wp_links`
  MODIFY `link_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wp_options`
--
ALTER TABLE `wp_options`
  MODIFY `option_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=478;

--
-- AUTO_INCREMENT for table `wp_postmeta`
--
ALTER TABLE `wp_postmeta`
  MODIFY `meta_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=622;

--
-- AUTO_INCREMENT for table `wp_posts`
--
ALTER TABLE `wp_posts`
  MODIFY `ID` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1002;

--
-- AUTO_INCREMENT for table `wp_termmeta`
--
ALTER TABLE `wp_termmeta`
  MODIFY `meta_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wp_terms`
--
ALTER TABLE `wp_terms`
  MODIFY `term_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `wp_term_taxonomy`
--
ALTER TABLE `wp_term_taxonomy`
  MODIFY `term_taxonomy_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `wp_usermeta`
--
ALTER TABLE `wp_usermeta`
  MODIFY `umeta_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `wp_users`
--
ALTER TABLE `wp_users`
  MODIFY `ID` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Database: `duanluyentap`
--
CREATE DATABASE IF NOT EXISTS `duanluyentap` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `duanluyentap`;

-- --------------------------------------------------------

--
-- Table structure for table `bill`
--

CREATE TABLE `bill` (
  `id` int NOT NULL,
  `bill_name` varchar(255) NOT NULL,
  `bill_address` varchar(255) NOT NULL,
  `bill_email` varchar(255) NOT NULL,
  `bill_pttt` tinyint(1) NOT NULL DEFAULT '1',
  `ngaydathang` varchar(255) DEFAULT NULL,
  `total` int NOT NULL DEFAULT '0',
  `bill_status` tinyint(1) DEFAULT NULL COMMENT 'don hang moi',
  `receive_name` varchar(255) DEFAULT NULL,
  `receive_address` varchar(255) DEFAULT NULL,
  `receive_tel` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `binhluan`
--

CREATE TABLE `binhluan` (
  `id` int NOT NULL,
  `noidung` varchar(255) NOT NULL,
  `iduser` int NOT NULL,
  `idpro` int NOT NULL,
  `ngaybinhluan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `binhluan`
--

INSERT INTO `binhluan` (`id`, `noidung`, `iduser`, `idpro`, `ngaybinhluan`) VALUES
(1, 'wfewF', 5, 26, '06:14:21am/16/02/2024'),
(2, 'đawfefe', 5, 26, '06:18:12am/16/02/2024'),
(3, 'wfewF', 5, 35, '06:25:24am/16/02/2024'),
(4, 'wfewF', 5, 35, '06:25:28am/16/02/2024'),
(5, 'wfewF', 5, 35, '06:26:29am/16/02/2024'),
(6, 'huhu', 5, 35, '06:45:42am/16/02/2024'),
(7, 'rat dep', 5, 34, '07:17:29am/16/02/2024'),
(8, 'rat thoi trang', 5, 29, '07:18:21am/16/02/2024'),
(9, 'rat thu hut', 2, 35, '07:21:16am/16/02/2024'),
(10, 'amazing good job ', 2, 35, '07:21:40am/16/02/2024'),
(11, 'wfewF', 5, 33, '02:53:03am/17/02/2024'),
(12, 'rat dep', 5, 31, '11:17:22am/17/02/2024'),
(13, 'rat thu hut', 5, 31, '11:17:28am/17/02/2024'),
(14, 'rat dep', 5, 31, '02:54:54pm/18/02/2024'),
(15, 'wfewF', 5, 35, '02:36:22am/19/02/2024'),
(16, 'huhu', 5, 35, '02:36:25am/19/02/2024'),
(17, '132143', 5, 35, '01:29:40pm/19/02/2024'),
(18, '132143', 5, 30, '02:29:57pm/19/02/2024'),
(19, '132143', 5, 34, '12:07:45pm/24/02/2024'),
(20, 'đư', 5, 34, '12:07:47pm/24/02/2024');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int NOT NULL,
  `iduser` int NOT NULL,
  `idpro` int NOT NULL,
  `img` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `price` int NOT NULL DEFAULT '0',
  `soluong` int NOT NULL,
  `thanhtien` int NOT NULL,
  `idbill` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `danhmuc`
--

CREATE TABLE `danhmuc` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `danhmuc`
--

INSERT INTO `danhmuc` (`id`, `name`) VALUES
(36, 'Đồ gia dụng'),
(38, 'Sản phẩm cá nhân'),
(40, 'Mũ'),
(41, 'laptops '),
(43, 'Điện thoại'),
(45, 'Đồng hồ'),
(50, 'Đồ cũ');

-- --------------------------------------------------------

--
-- Table structure for table `danhmuctintuc`
--

CREATE TABLE `danhmuctintuc` (
  `id_danhmuc` int NOT NULL,
  `ten_danhmuc` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `danhmuctintuc`
--

INSERT INTO `danhmuctintuc` (`id_danhmuc`, `ten_danhmuc`) VALUES
(1, 'tin cong nghe'),
(2, 'tin khuyen mai'),
(3, 'chinh sach ban hang');

-- --------------------------------------------------------

--
-- Table structure for table `sanpham`
--

CREATE TABLE `sanpham` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` double(10,2) DEFAULT '0.00',
  `img` varchar(255) DEFAULT NULL,
  `mota` text,
  `luotxem` int DEFAULT '0',
  `iddm` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `sanpham`
--

INSERT INTO `sanpham` (`id`, `name`, `price`, `img`, `mota`, `luotxem`, `iddm`) VALUES
(26, 'dong ho deo tay dep', 12000000.00, '1085.jpg', 'dep ', 1, 45),
(27, 'NOKIA', 5000000.00, '1059.jpg', 'nho gon', 2, 43),
(28, 'DELL Windows', 15000000.00, '1058.jpg', 'Ttien loi', 3, 41),
(29, 'mu thoi trang', 50000.00, '1007.jpg', 'thoi trang', 4, 40),
(30, 'vali', 1000000.00, '1073.jpg', 'de mang lai', 5, 38),
(31, 'fantasy', 20000.00, '1064.jpg', 'thom ngat', 6, 36),
(33, 'dong ho xach tay', 120000.00, '1001.jpg', 'hang ton kho', 0, 45),
(34, 'dien thoai gap', 123000.00, '1072.jpg', 'do cu', 0, 43),
(35, 'laptop cu', 30000.00, '1006.jpg', '', 0, 41);

-- --------------------------------------------------------

--
-- Table structure for table `taikhoan`
--

CREATE TABLE `taikhoan` (
  `id` int NOT NULL,
  `user` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `tel` varchar(255) DEFAULT NULL,
  `role` tinyint NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `taikhoan`
--

INSERT INTO `taikhoan` (`id`, `user`, `pass`, `email`, `address`, `tel`, `role`) VALUES
(1, 'dat', '123456', 'hoangtiendat.20042011@gmail.com', NULL, NULL, 0),
(2, 'datdz', '20112004', 'dathtph44922@fpt.edu.vn', 'Ngoc Thuy', '0397913410', 0),
(3, 'datdz', '20112004', 'dathtph44922@fpt.edu.vn', NULL, NULL, 0),
(5, 'hoang dat', '123456', 'hoangtiendat.20042011@gmail.com', 'Long Bien', '0397913410', 1),
(10, 'dat', '123456', 'hoangtiendat.20042011@gmail.com', NULL, NULL, 0),
(11, 'dat', '123456', 'hoangtiendat.20042011@gmail.com', NULL, NULL, 0),
(13, 'dat', '123456', 'hoangtiendat.20042011@gmail.com', NULL, NULL, 0),
(14, '', '', '', NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tintuc`
--

CREATE TABLE `tintuc` (
  `id` int NOT NULL,
  `tieu_de` varchar(255) NOT NULL,
  `noi_dung` varchar(1000) NOT NULL,
  `hinh_anh` varchar(255) DEFAULT NULL,
  `id_danh_muc` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tintuc`
--

INSERT INTO `tintuc` (`id`, `tieu_de`, `noi_dung`, `hinh_anh`, `id_danh_muc`) VALUES
(8, '', '', '', 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bill`
--
ALTER TABLE `bill`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `binhluan`
--
ALTER TABLE `binhluan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `binhluan_ibfk_1` (`idpro`),
  ADD KEY `binhluan_ibfk_2` (`iduser`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `binhluan_ibfk_3` (`idbill`);

--
-- Indexes for table `danhmuc`
--
ALTER TABLE `danhmuc`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `danhmuctintuc`
--
ALTER TABLE `danhmuctintuc`
  ADD PRIMARY KEY (`id_danhmuc`);

--
-- Indexes for table `sanpham`
--
ALTER TABLE `sanpham`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ik_sanpham_danhmuc` (`iddm`);

--
-- Indexes for table `taikhoan`
--
ALTER TABLE `taikhoan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tintuc`
--
ALTER TABLE `tintuc`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tintuc_danhmuc` (`id_danh_muc`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bill`
--
ALTER TABLE `bill`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `binhluan`
--
ALTER TABLE `binhluan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `danhmuc`
--
ALTER TABLE `danhmuc`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `danhmuctintuc`
--
ALTER TABLE `danhmuctintuc`
  MODIFY `id_danhmuc` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sanpham`
--
ALTER TABLE `sanpham`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `taikhoan`
--
ALTER TABLE `taikhoan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tintuc`
--
ALTER TABLE `tintuc`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `binhluan`
--
ALTER TABLE `binhluan`
  ADD CONSTRAINT `binhluan_ibfk_1` FOREIGN KEY (`idpro`) REFERENCES `sanpham` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `binhluan_ibfk_2` FOREIGN KEY (`iduser`) REFERENCES `taikhoan` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `binhluan_ibfk_3` FOREIGN KEY (`idbill`) REFERENCES `bill` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `sanpham`
--
ALTER TABLE `sanpham`
  ADD CONSTRAINT `ik_sanpham_danhmuc` FOREIGN KEY (`iddm`) REFERENCES `danhmuc` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `tintuc`
--
ALTER TABLE `tintuc`
  ADD CONSTRAINT `fk_tintuc_danhmuc` FOREIGN KEY (`id_danh_muc`) REFERENCES `danhmuctintuc` (`id_danhmuc`) ON DELETE RESTRICT ON UPDATE RESTRICT;
--
-- Database: `duanmau`
--
CREATE DATABASE IF NOT EXISTS `duanmau` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `duanmau`;

-- --------------------------------------------------------

--
-- Table structure for table `binhluan`
--

CREATE TABLE `binhluan` (
  `id` int NOT NULL,
  `noidung` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `iduser` int NOT NULL,
  `idpro` int NOT NULL,
  `ngaybinhluan` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `binhluan`
--

INSERT INTO `binhluan` (`id`, `noidung`, `iduser`, `idpro`, `ngaybinhluan`) VALUES
(1, 'Sản phẩm rất đang trải nghiệm', 2, 1, '2023-09-22'),
(2, 'Sản phẩm rất tốt', 3, 1, '2023-09-22');

-- --------------------------------------------------------

--
-- Table structure for table `danhmuc`
--

CREATE TABLE `danhmuc` (
  `id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `danhmuc`
--

INSERT INTO `danhmuc` (`id`, `name`) VALUES
(1, 'Laptop'),
(2, 'Điện Thoại');

-- --------------------------------------------------------

--
-- Table structure for table `sanpham`
--

CREATE TABLE `sanpham` (
  `id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `price` double(10,2) NOT NULL DEFAULT '0.00',
  `img` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `mota` text COLLATE utf8mb4_general_ci NOT NULL,
  `luotxem` int NOT NULL DEFAULT '0',
  `iddm` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sanpham`
--

INSERT INTO `sanpham` (`id`, `name`, `price`, `img`, `mota`, `luotxem`, `iddm`) VALUES
(1, 'Apple MacBook Air M1', 300000.00, 'Laptop1.jpg', 'Sản phẩm cấu hình cơ bản bao gồm một GPU bảy lõi, bộ nhớ lưu trữ 256GB SSD, cũng như 8GB RAM bộ nhớ. Phiên bản nâng cấp với GPU tám lõi và bộ nhớ 512GB SSD có giá khởi điểm là 1249$. Cấu hình tối đa sẽ bao gồm 16GB RAM và 2TB dung lượng lưu trữ. Máy có ba tuỳ chọn màu sắc giống sản phẩm tiền nhiệm bao gồm vàng (gold), bạc (silver) và xám không gian (Space gray)', 10, 1),
(2, 'iPhone 14 Pro Max', 140000.00, 'iPhone 14 Pro Max.jpg', 'Những dòng iPhone đến từ nhà Apple đều có sức hút đặc biệt ngay từ thời điểm ra mắt và thế hệ iPhone 14 Pro Max cũng không ngoại lệ. Có thể nói, iPhone 14 Pro Max là sự kết hợp hoàn hảo giữa các yếu tố về thiết kế, cấu hình, tính năng, hệ điều hành,... Nếu bạn tò mò về siêu phẩm này, hãy đọc ngay phần đánh giá chi tiết phiên bản cao cấp nhất trong series iPhone 14 bên dưới nhé. ', 9, 2),
(3, 'Laptop Asus VivoBook Go 14', 180000.00, 'Laptop Asus VivoBook Go 14.jpg', 'ASUS Vivobook E1404FA-NK186W thuộc dòng Vivobook Go 14, dòng laptop hiệu năng cao giá rẻ giúp bạn làm việc hiệu quả mọi lúc mọi nơi. Với bộ vi xử lý AMD 7000 series mạnh mẽ, trang bị sẵn tới 16GB RAM, 512GB SSD, Vivobook E1404FA sẽ mang đến trải nghiệm làm việc thoải mái, vô cùng mượt mà.', 9, 1),
(5, 'Laptop Lenovo Ideapad 5 Pro', 300000.00, 'Laptop Lenovo Ideapad 5 Pro.jpg', 'Lenovo Ideapad 5 Pro 16 là chiếc laptop, máy tính xách tay thời đại mới dành cho các bạn trẻ đa nhiệm, năng động với vẻ ngoài hiện đại, mỏng nhẹ nhưng bên trong lại chứa một hiệu năng cực khủng. Bên cạnh đó, chiếc laptop Lenovo - Lenovo Ideapad này cũng được tích hợp nhiều công nghệ hiện đại, tối ưu tốt cho trải nghiệm sử dụng. Chắc chắn, mẫu laptop mỏng nhẹ này sẽ khiến bạn phải bất ngờ đấy. Hãy cùng Laptop88 đánh giá ngay mẫu laptop văn phòng này dưới đây nhé!', 10, 1),
(6, 'Xiaomi Redmi Note 12 Pro', 140000.00, 'Xiaomi Redmi Note 12 Pro.jpg', 'Samsung S23 Ultra là dòng điện thoại cao cấp của Samsung, sở hữu camera độ phân giải 200MP ấn tượng, chip Snapdragon 8 Gen 2 mạnh mẽ, bộ nhớ RAM 8GB mang lại hiệu suất xử lý vượt trội cùng khung viền vuông vức sang trọng. Sản phẩm được ra mắt từ đầu năm 2023.', 9, 2),
(7, 'Macbook Air 15 inch M2 2023', 180000.00, 'Macbook Air 15 inch M2 2023.jpg', 'Vận hành doanh nghiệp trên MacBook Air M2. Siêu mạnh mẽ với chip M2 thế hệ tiếp theo, MacBook Air được thiết kế mới nay nhỏ gọn hơn bao giờ hết, kết hợp giữa hiệu năng đáng kinh ngạc và thời lượng pin lên đến 18 giờ trong vỏ nhôm mỏng đầy ấn tượng.1 Nhờ đó, tất cả các bộ phận từ kinh doanh đến tài chính đều có thể làm việc năng suất hơn dù ở bất cứ đâu.', 9, 1),
(8, 'Laptop Lenovo Ideapad 5 Pro', 300000.00, 'Laptop Lenovo Ideapad 5 Pro.jpg', 'Lenovo Ideapad 5 Pro 16 là chiếc laptop, máy tính xách tay thời đại mới dành cho các bạn trẻ đa nhiệm, năng động với vẻ ngoài hiện đại, mỏng nhẹ nhưng bên trong lại chứa một hiệu năng cực khủng. Bên cạnh đó, chiếc laptop Lenovo - Lenovo Ideapad này cũng được tích hợp nhiều công nghệ hiện đại, tối ưu tốt cho trải nghiệm sử dụng. Chắc chắn, mẫu laptop mỏng nhẹ này sẽ khiến bạn phải bất ngờ đấy. Hãy cùng Laptop88 đánh giá ngay mẫu laptop văn phòng này dưới đây nhé!', 10, 1),
(9, 'Xiaomi Redmi Note 12 Pro', 140000.00, 'Xiaomi Redmi Note 12 Pro.jpg', 'Samsung S23 Ultra là dòng điện thoại cao cấp của Samsung, sở hữu camera độ phân giải 200MP ấn tượng, chip Snapdragon 8 Gen 2 mạnh mẽ, bộ nhớ RAM 8GB mang lại hiệu suất xử lý vượt trội cùng khung viền vuông vức sang trọng. Sản phẩm được ra mắt từ đầu năm 2023.', 9, 2),
(10, 'Macbook Air 15 inch M2 2023', 180000.00, 'Macbook Air 15 inch M2 2023.jpg', 'Vận hành doanh nghiệp trên MacBook Air M2. Siêu mạnh mẽ với chip M2 thế hệ tiếp theo, MacBook Air được thiết kế mới nay nhỏ gọn hơn bao giờ hết, kết hợp giữa hiệu năng đáng kinh ngạc và thời lượng pin lên đến 18 giờ trong vỏ nhôm mỏng đầy ấn tượng.1 Nhờ đó, tất cả các bộ phận từ kinh doanh đến tài chính đều có thể làm việc năng suất hơn dù ở bất cứ đâu.', 9, 1);

-- --------------------------------------------------------

--
-- Table structure for table `taikhoan`
--

CREATE TABLE `taikhoan` (
  `id` int NOT NULL,
  `user` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `pass` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tel` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `role` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `taikhoan`
--

INSERT INTO `taikhoan` (`id`, `user`, `pass`, `email`, `address`, `tel`, `role`) VALUES
(1, 'Admin', '123456', 'admin@fpt.edu.vn', NULL, NULL, 1),
(2, 'Hoàng Long', '123456', 'longhh7@fpt.edu.vn', NULL, NULL, 2),
(3, 'Thành Trung', '1234565', 'trungnt173@fpt.edu.vn', 'Hà Nội', NULL, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `binhluan`
--
ALTER TABLE `binhluan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idpro` (`idpro`),
  ADD KEY `iduser` (`iduser`);

--
-- Indexes for table `danhmuc`
--
ALTER TABLE `danhmuc`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sanpham`
--
ALTER TABLE `sanpham`
  ADD PRIMARY KEY (`id`),
  ADD KEY `iddm` (`iddm`);

--
-- Indexes for table `taikhoan`
--
ALTER TABLE `taikhoan`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `binhluan`
--
ALTER TABLE `binhluan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `danhmuc`
--
ALTER TABLE `danhmuc`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sanpham`
--
ALTER TABLE `sanpham`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `taikhoan`
--
ALTER TABLE `taikhoan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `binhluan`
--
ALTER TABLE `binhluan`
  ADD CONSTRAINT `binhluan_ibfk_1` FOREIGN KEY (`idpro`) REFERENCES `sanpham` (`id`),
  ADD CONSTRAINT `binhluan_ibfk_2` FOREIGN KEY (`iduser`) REFERENCES `taikhoan` (`id`);

--
-- Constraints for table `sanpham`
--
ALTER TABLE `sanpham`
  ADD CONSTRAINT `sanpham_ibfk_1` FOREIGN KEY (`iddm`) REFERENCES `danhmuc` (`id`);
--
-- Database: `duphong`
--
CREATE DATABASE IF NOT EXISTS `duphong` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `duphong`;

-- --------------------------------------------------------

--
-- Table structure for table `bill`
--

CREATE TABLE `bill` (
  `id` int NOT NULL,
  `bill_name` varchar(255) NOT NULL,
  `bill_address` varchar(255) NOT NULL,
  `bill_email` varchar(255) NOT NULL,
  `bill_pttt` tinyint(1) NOT NULL DEFAULT '1',
  `ngaydathang` varchar(255) DEFAULT NULL,
  `total` int NOT NULL DEFAULT '0',
  `bill_status` tinyint(1) DEFAULT NULL COMMENT 'don hang moi',
  `receive_name` varchar(255) DEFAULT NULL,
  `receive_address` varchar(255) DEFAULT NULL,
  `receive_tel` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `binhluan`
--

CREATE TABLE `binhluan` (
  `id` int NOT NULL,
  `noidung` varchar(255) NOT NULL,
  `iduser` int NOT NULL,
  `idpro` int NOT NULL,
  `ngaybinhluan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `binhluan`
--

INSERT INTO `binhluan` (`id`, `noidung`, `iduser`, `idpro`, `ngaybinhluan`) VALUES
(1, 'wfewF', 5, 26, '06:14:21am/16/02/2024'),
(2, 'đawfefe', 5, 26, '06:18:12am/16/02/2024'),
(3, 'wfewF', 5, 35, '06:25:24am/16/02/2024'),
(4, 'wfewF', 5, 35, '06:25:28am/16/02/2024'),
(5, 'wfewF', 5, 35, '06:26:29am/16/02/2024'),
(6, 'huhu', 5, 35, '06:45:42am/16/02/2024'),
(7, 'rat dep', 5, 34, '07:17:29am/16/02/2024'),
(8, 'rat thoi trang', 5, 29, '07:18:21am/16/02/2024'),
(9, 'rat thu hut', 2, 35, '07:21:16am/16/02/2024'),
(10, 'amazing good job ', 2, 35, '07:21:40am/16/02/2024'),
(11, 'wfewF', 5, 33, '02:53:03am/17/02/2024'),
(12, 'rat dep', 5, 31, '11:17:22am/17/02/2024'),
(13, 'rat thu hut', 5, 31, '11:17:28am/17/02/2024'),
(14, 'rat dep', 5, 31, '02:54:54pm/18/02/2024'),
(15, 'wfewF', 5, 35, '02:36:22am/19/02/2024'),
(16, 'huhu', 5, 35, '02:36:25am/19/02/2024'),
(17, '132143', 5, 35, '01:29:40pm/19/02/2024'),
(18, '132143', 5, 30, '02:29:57pm/19/02/2024');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int NOT NULL,
  `iduser` int NOT NULL,
  `idpro` int NOT NULL,
  `img` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `price` int NOT NULL DEFAULT '0',
  `soluong` int NOT NULL,
  `thanhtien` int NOT NULL,
  `idbill` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `danhmuc`
--

CREATE TABLE `danhmuc` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `danhmuc`
--

INSERT INTO `danhmuc` (`id`, `name`) VALUES
(36, 'Đồ gia dụng'),
(38, 'Sản phẩm cá nhân'),
(40, 'Mũ'),
(41, 'laptops '),
(43, 'Điện thoại'),
(45, 'Đồng hồ'),
(50, 'Đồ cũ');

-- --------------------------------------------------------

--
-- Table structure for table `sanpham`
--

CREATE TABLE `sanpham` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` double(10,2) DEFAULT '0.00',
  `img` varchar(255) DEFAULT NULL,
  `mota` text,
  `luotxem` int DEFAULT '0',
  `iddm` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `sanpham`
--

INSERT INTO `sanpham` (`id`, `name`, `price`, `img`, `mota`, `luotxem`, `iddm`) VALUES
(26, 'dong ho deo tay dep', 12000000.00, '1085.jpg', 'dep ', 1, 45),
(27, 'NOKIA', 5000000.00, '1059.jpg', 'nho gon', 2, 43),
(28, 'DELL Windows', 15000000.00, '1058.jpg', 'Ttien loi', 3, 41),
(29, 'mu thoi trang', 50000.00, '1007.jpg', 'thoi trang', 4, 40),
(30, 'vali', 1000000.00, '1073.jpg', 'de mang lai', 5, 38),
(31, 'fantasy', 20000.00, '1064.jpg', 'thom ngat', 6, 36),
(33, 'dong ho xach tay', 120000.00, '1001.jpg', 'hang ton kho', 0, 45),
(34, 'dien thoai gap', 123000.00, '1072.jpg', 'do cu', 0, 43),
(35, 'laptop cu', 30000.00, '1006.jpg', '', 0, 41);

-- --------------------------------------------------------

--
-- Table structure for table `taikhoan`
--

CREATE TABLE `taikhoan` (
  `id` int NOT NULL,
  `user` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `tel` varchar(255) DEFAULT NULL,
  `role` tinyint NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `taikhoan`
--

INSERT INTO `taikhoan` (`id`, `user`, `pass`, `email`, `address`, `tel`, `role`) VALUES
(1, 'dat', '123456', 'hoangtiendat.20042011@gmail.com', NULL, NULL, 0),
(2, 'datdz', '20112004', 'dathtph44922@fpt.edu.vn', 'Ngoc Thuy', '0397913410', 0),
(3, 'datdz', '20112004', 'dathtph44922@fpt.edu.vn', NULL, NULL, 0),
(5, 'hoang dat', '123456', 'hoangtiendat.20042011@gmail.com', 'Long Bien', '0397913410', 1),
(10, 'dat', '123456', 'hoangtiendat.20042011@gmail.com', NULL, NULL, 0),
(11, 'dat', '123456', 'hoangtiendat.20042011@gmail.com', NULL, NULL, 0),
(13, 'dat', '123456', 'hoangtiendat.20042011@gmail.com', NULL, NULL, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bill`
--
ALTER TABLE `bill`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `binhluan`
--
ALTER TABLE `binhluan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `binhluan_ibfk_1` (`idpro`),
  ADD KEY `binhluan_ibfk_2` (`iduser`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `binhluan_ibfk_3` (`idbill`);

--
-- Indexes for table `danhmuc`
--
ALTER TABLE `danhmuc`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sanpham`
--
ALTER TABLE `sanpham`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ik_sanpham_danhmuc` (`iddm`);

--
-- Indexes for table `taikhoan`
--
ALTER TABLE `taikhoan`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bill`
--
ALTER TABLE `bill`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `binhluan`
--
ALTER TABLE `binhluan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `danhmuc`
--
ALTER TABLE `danhmuc`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `sanpham`
--
ALTER TABLE `sanpham`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `taikhoan`
--
ALTER TABLE `taikhoan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `binhluan`
--
ALTER TABLE `binhluan`
  ADD CONSTRAINT `binhluan_ibfk_1` FOREIGN KEY (`idpro`) REFERENCES `sanpham` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `binhluan_ibfk_2` FOREIGN KEY (`iduser`) REFERENCES `taikhoan` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `binhluan_ibfk_3` FOREIGN KEY (`idbill`) REFERENCES `bill` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `sanpham`
--
ALTER TABLE `sanpham`
  ADD CONSTRAINT `ik_sanpham_danhmuc` FOREIGN KEY (`iddm`) REFERENCES `danhmuc` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
--
-- Database: `nodejs`
--
CREATE DATABASE IF NOT EXISTS `nodejs` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `nodejs`;

-- --------------------------------------------------------

--
-- Table structure for table `list`
--

CREATE TABLE `list` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` text NOT NULL,
  `decription` varchar(255) NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `list`
--

INSERT INTO `list` (`id`, `name`, `price`, `decription`, `image`) VALUES
(7, 'Đắc Nhân Tâm ', '10', 'sách hay nhất, nổi tiếng nhất, bán chạy nhất và nó có tầm ảnh hưởng đi xa nhất mọi thời đại, Đắc Nhân Tâm của soạn giả Dale Carnegie là 1 quyển sách hay nên đọc để bạn biết về nghệ thuật thu phục lòng người và làm tất cả mọi người phải yêu mến mình.', '1721414198053-1721414160296-sach-hay-dac-nhan-tam.jpg'),
(12, 'Nhà giả kim', '20', 'là một cuốn sách hay dành cho những người đã đánh mất đi ước mơ hoặc chưa bao giờ có nó. Nếu bạn đang cần tìm những cuốn sách nên đọc để thành công thì Nhà Giả Kim rất xứng đáng. Thành công như thế nào: thành công trong trong suy nghĩ và hành động.', '1721414399408-sach-hay-nha-gia-kim.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `list`
--
ALTER TABLE `list`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `list`
--
ALTER TABLE `list`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
