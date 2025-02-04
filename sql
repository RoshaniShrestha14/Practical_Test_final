-- -- Create the database
-- CREATE DATABASE IF NOT EXISTS profile_management;

-- -- Use the database
-- USE profile_management;

-- -- Create the users table
-- CREATE TABLE IF NOT EXISTS users (
--     id INT AUTO_INCREMENT PRIMARY KEY,             -- Unique ID for each user
--     first_name VARCHAR(255) NOT NULL,              -- First name of the user
--     last_name VARCHAR(255) NOT NULL,               -- Last name of the user
--     email VARCHAR(255) NOT NULL UNIQUE,            -- Email address of the user
--     phone_number VARCHAR(15) NOT NULL,             -- Phone number of the user
--     address TEXT,                                  -- Address of the user
--     profile_photo VARCHAR(255),                    -- Path to the user's profile photo
--     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,-- Record creation timestamp
--     updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
-- );

-- -- Sample data (optional)
-- INSERT INTO users (first_name, last_name, email, phone_number, address, profile_photo)
-- VALUES 
-- ('John', 'Doe', 'john.doe@example.com', '1234567890', '123 Main Street, City, Country', 'uploads/john_doe.jpg'),
-- ('Jane', 'Smith', 'jane.smith@example.com', '0987654321', '456 Elm Street, City, Country', 'uploads/jane_smith.jpg');
-- CREATE TABLE `users1` (
--   `id` int(11) NOT NULL,
--   `name` varchar(50) NOT NULL,
--   `email` varchar(100) NOT NULL,
--   `password` varchar(200) NOT NULL
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ALTER TABLE `users1`
--   ADD PRIMARY KEY (`id`);
-- ALTER TABLE `users1`
--   MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

-- COMMIT;