CREATE DATABASE fictional_market;
USE fictional_market;

CREATE TABLE product (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    effect VARCHAR(100) NOT NULL,
    price INT(20) NOT NULL DEFAULT 0,
    stock INT NOT NULL DEFAULT 0
);

CREATE TABLE voucher (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description VARCHAR(100) UNIQUE,
    discount int(2)
);

CREATE TABLE transaction (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    voucher_id INT NOT NULL,
    buying_date DATETIME NOT NULL,
    total_price INT NOT NULL,
    FOREIGN KEY (product_id) REFERENCES product(id),
    FOREIGN KEY (voucher_id) REFERENCES voucher(id)
);

INSERT INTO product (name, effect, price, stock) VALUES
('Heal potion I', 'Heal 20% of HP', 500, 20),
('Mana potion I', 'Restore 15% of MP', 600, 15),
('Repel potion I', 'Repel monsters for 5 minutes', 800, 10),
('Speed potion I', 'Increase Speed by 10 points', 1000, 12),
('Intelligence potion I', 'Increase Intelligence by 7 points', 1000, 9),
('Dexterity potion I', 'Increase Dexterity by 8 points', 1000, 14),
('Stamina potion I', 'Increase Stamina by 10 points', 1000, 10),
('Strength potion I', 'Increase Strength by 5 points', 1000, 5),
('Defense potion I', 'Increase Defense by 5 points', 1000, 8);


INSERT INTO voucher (name, description, discount) VALUES
('Apprentice Voucher', 'Discount only for Apprentice Adventurer', 20),
('Moon Festival Voucher', 'This voucher only can be used on Blood Mon Night', 15),
('Guild Member Voucher', 'Exclusive discount for Guild Members', 25),
('Seasonal Sale Voucher', 'Special discount during seasonal sales', 10),
('Loyalty Voucher', 'Reward for loyal customers', 30);