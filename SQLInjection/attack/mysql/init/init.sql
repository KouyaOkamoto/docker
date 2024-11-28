-- Initialize database schema
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100),
    role VARCHAR(20) DEFAULT 'user'
);

CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2),
    category VARCHAR(50)
);

CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    total_amount DECIMAL(10, 2),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Insert sample data
INSERT INTO users (username, password, email, role) VALUES
('admin', '5f4dcc3b5aa765d61d8327deb882cf99', 'admin@example.com', 'admin'),
('user1', '5f4dcc3b5aa765d61d8327deb882cf99', 'user1@example.com', 'user'),
('user2', '5f4dcc3b5aa765d61d8327deb882cf99', 'user2@example.com', 'user');

INSERT INTO products (name, description, price, category) VALUES
('Laptop', 'High performance laptop', 999.99, 'Electronics'),
('Smartphone', 'Latest model smartphone', 599.99, 'Electronics'),
('Headphones', 'Wireless headphones', 199.99, 'Electronics');