CREATE TABLE `users` (
  `user_id` int PRIMARY KEY AUTO_INCREMENT,
  `username` varchar(50) UNIQUE,
  `phone` varchar(15),
  `image` varchar(255),
  `email` varchar(100) UNIQUE,
  `password_hash` varchar(255),
  `role_id` int,
  `is_promoted` boolean DEFAULT false,
  `violation_count` int DEFAULT 0,
  `banned_until` timestamp,
  `created_at` timestamp DEFAULT (CURRENT_TIMESTAMP)
);

CREATE TABLE `roles` (
  `role_id` int PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(50) UNIQUE,
  `description` text
);

CREATE TABLE `articles` (
  `article_id` int PRIMARY KEY AUTO_INCREMENT,
  `title` varchar(255),
  `slug` varchar(255) UNIQUE,
  `content` text,
  `preview_content` text,
  `contains_sensitive_content` boolean DEFAULT false,
  `author_id` int,
  `category_id` int,
  `thumbnail_url` varchar(255),
  `status` enum(draft,pending,published,archived) DEFAULT 'draft',
  `views` int DEFAULT 0,
  `approved_by` int,
  `created_at` timestamp DEFAULT (CURRENT_TIMESTAMP),
  `updated_at` timestamp DEFAULT (CURRENT_TIMESTAMP)
);

CREATE TABLE `articlehistory` (
  `history_id` int PRIMARY KEY AUTO_INCREMENT,
  `article_id` int,
  `content` text,
  `edited_by` int,
  `edited_at` timestamp DEFAULT (CURRENT_TIMESTAMP)
);

CREATE TABLE `approvals` (
  `approval_id` int PRIMARY KEY AUTO_INCREMENT,
  `article_id` int,
  `approved_by` int,
  `status` enum(pending,approved,rejected) DEFAULT 'pending',
  `auto_reviewed` boolean DEFAULT false,
  `remarks` text,
  `created_at` timestamp DEFAULT (CURRENT_TIMESTAMP)
);

CREATE TABLE `categories` (
  `category_id` int PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(100) UNIQUE,
  `slug` varchar(255) UNIQUE,
  `is_active` boolean DEFAULT true,
  `created_at` timestamp DEFAULT (CURRENT_TIMESTAMP),
  `updated_at` timestamp DEFAULT (CURRENT_TIMESTAMP)
);

CREATE TABLE `comments` (
  `comment_id` int PRIMARY KEY AUTO_INCREMENT,
  `article_id` int,
  `user_id` int,
  `content` text,
  `likes` int DEFAULT 0,
  `dislikes` int DEFAULT 0,
  `status` enum(draft,approved,rejected) DEFAULT 'draft',
  `parent_id` int,
  `depth` int DEFAULT 0,
  `created_at` timestamp DEFAULT (CURRENT_TIMESTAMP),
  `updated_at` timestamp DEFAULT (CURRENT_TIMESTAMP)
);

CREATE TABLE `comment_reactions` (
  `reaction_id` int PRIMARY KEY AUTO_INCREMENT,
  `comment_id` int,
  `user_id` int,
  `is_like` boolean DEFAULT true,
  `reacted_at` timestamp DEFAULT (CURRENT_TIMESTAMP)
);

CREATE TABLE `prohibited_words` (
  `word_id` int PRIMARY KEY AUTO_INCREMENT,
  `word` varchar(50) UNIQUE,
  `description` text,
  `created_at` timestamp DEFAULT (CURRENT_TIMESTAMP)
);

CREATE TABLE `violations` (
  `violation_id` int PRIMARY KEY AUTO_INCREMENT,
  `type` varchar(20),
  `reference_id` int,
  `detected_word` varchar(50),
  `detected_at` timestamp DEFAULT (CURRENT_TIMESTAMP),
  `handled_by` int,
  `status` enum(pending,resolved) DEFAULT 'pending',
  `warning_sent` boolean DEFAULT false
);

CREATE TABLE `articleviews` (
  `view_id` int PRIMARY KEY AUTO_INCREMENT,
  `anonymous` varchar(255),
  `article_id` int,
  `user_id` int,
  `viewed_at` timestamp DEFAULT (CURRENT_TIMESTAMP)
);

CREATE TABLE `article_likes` (
  `like_id` int PRIMARY KEY AUTO_INCREMENT,
  `article_id` int,
  `user_id` int,
  `liked_at` timestamp DEFAULT (CURRENT_TIMESTAMP)
);

CREATE TABLE `tags` (
  `tag_id` int PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(50) UNIQUE,
  `description` text
);

CREATE TABLE `articletags` (
  `article_id` int,
  `tag_id` int,
  PRIMARY KEY (`article_id`, `tag_id`)
);

CREATE TABLE `article_media` (
  `media_id` int PRIMARY KEY AUTO_INCREMENT,
  `article_id` int,
  `media_type` enum(image,video,link),
  `media_url` varchar(255),
  `caption` text,
  `position` int,
  `created_at` timestamp DEFAULT (CURRENT_TIMESTAMP)
);

ALTER TABLE `users` ADD FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`);

ALTER TABLE `articles` ADD FOREIGN KEY (`author_id`) REFERENCES `users` (`user_id`);

ALTER TABLE `articles` ADD FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`);

ALTER TABLE `articles` ADD FOREIGN KEY (`approved_by`) REFERENCES `users` (`user_id`);

ALTER TABLE `articlehistory` ADD FOREIGN KEY (`article_id`) REFERENCES `articles` (`article_id`);

ALTER TABLE `articlehistory` ADD FOREIGN KEY (`edited_by`) REFERENCES `users` (`user_id`);

ALTER TABLE `approvals` ADD FOREIGN KEY (`article_id`) REFERENCES `articles` (`article_id`);

ALTER TABLE `approvals` ADD FOREIGN KEY (`approved_by`) REFERENCES `users` (`user_id`);

ALTER TABLE `comments` ADD FOREIGN KEY (`article_id`) REFERENCES `articles` (`article_id`);

ALTER TABLE `comments` ADD FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

ALTER TABLE `comments` ADD FOREIGN KEY (`parent_id`) REFERENCES `comments` (`comment_id`);

ALTER TABLE `comment_reactions` ADD FOREIGN KEY (`comment_id`) REFERENCES `comments` (`comment_id`);

ALTER TABLE `comment_reactions` ADD FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

ALTER TABLE `violations` ADD FOREIGN KEY (`handled_by`) REFERENCES `users` (`user_id`);

ALTER TABLE `articleviews` ADD FOREIGN KEY (`article_id`) REFERENCES `articles` (`article_id`);

ALTER TABLE `articleviews` ADD FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

ALTER TABLE `article_likes` ADD FOREIGN KEY (`article_id`) REFERENCES `articles` (`article_id`);

ALTER TABLE `article_likes` ADD FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

ALTER TABLE `articletags` ADD FOREIGN KEY (`article_id`) REFERENCES `articles` (`article_id`);

ALTER TABLE `articletags` ADD FOREIGN KEY (`tag_id`) REFERENCES `tags` (`tag_id`);

ALTER TABLE `article_media` ADD FOREIGN KEY (`article_id`) REFERENCES `articles` (`article_id`);
