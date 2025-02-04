CREATE TABLE statistics (
    user_id INT PRIMARY KEY,
    total_minutes INT DEFAULT 0,
    FOREIGN KEY (user_id) REFERENCES users(id)
);
