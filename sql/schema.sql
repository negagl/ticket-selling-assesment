DROP DATABASE IF EXISTS ticket_fairy;

CREATE DATABASE IF NOT EXISTS ticket_fairy;

USE ticket_fairy;

CREATE TABLE IF NOT EXISTS events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    status INT DEFAULT 1 COMMENT "0: CLOSED, 1: OPEN"
);

CREATE TABLE IF NOT EXISTS tickets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    event_id INT,
    type VARCHAR(50),
    price DECIMAL(10, 2),
    total_tickets INT,
    remaining_tickets INT,
    FOREIGN KEY (event_id) REFERENCES events(id)
);

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(50),
    name VARCHAR(50),
    password VARCHAR(50) DEFAULT ''
);

CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    ticket_id INT,
    quantity INT,
    total_price DECIMAL(10, 2),
    created_at DATETIME DEFAULT NOW(),
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (ticket_id) REFERENCES tickets(id)
);

INSERT INTO events (name, status) VALUES
    ('Coachella 2026', 1),
    ('Ultra Music Festival 2026', 1),
    ('Stereo Picnic 2026', 0),
    ('Tomorrowland', 1),
    ('Iron City', 0);

INSERT INTO tickets (event_id, type, price, total_tickets, remaining_tickets) VALUES
    (1, 'VIP', 150.00, 100, 100),
    (1, 'General Admission', 50.00, 500, 500),
    (2, 'Balcony', 75.00, 200, 200),
    (2, 'Floor', 100.00, 300, 300),
    (3, 'Standard', 40.00, 400, 400),
    (3, 'Premium', 80.00, 150, 150),
    (4, 'Early Bird', 30.00, 250, 250),
    (4, 'Regular', 60.00, 350, 350),
    (5, 'Front Row', 200.00, 50, 10),
    (5, 'General', 70.00, 450, 0);

INSERT INTO users (email, name) VALUES
    ("test1@user.com", "Test User 1"),
    ("test2@user.com", "Test User 2"),
    ("test3@user.com", "Test User 3");