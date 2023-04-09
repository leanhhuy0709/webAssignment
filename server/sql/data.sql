USE `oliviashop`;
-- customer
INSERT INTO customer(username, password, fname, lname, gender, age, email, phoneNumber, DOB, imageURL) VALUES 
("leanhhuy", "12345", "Huy", "Lê Anh", "Male", 20, "huy.leanh0709@hcmut.edu.vn", "0123456789", "2002-09-07", "https://genk.mediacdn.vn/k:thumb_w/640/2016/photo-1-1473821552147/top6suthatcucsocvepikachu.jpg");
INSERT INTO address VALUES 
("Kí túc xá khu A", (SELECT MAX(customerID) FROM customer));
INSERT INTO paymentMethod VALUES 
("Momo", (SELECT MAX(customerID) FROM customer));

INSERT INTO customer(username, password, fname, lname, gender, age, email, phoneNumber, DOB, imageURL) VALUES 
("hoangtien", "12345", "Tiên", "Hoàng", "Female", 20, "", "0246813579", "2002-12-31", "https://upload.wikimedia.org/wikipedia/commons/thumb/f/f0/HCMCUT.svg/1200px-HCMCUT.svg.png");
INSERT INTO address VALUES 
("Kí túc xá khu A", (SELECT MAX(customerID) FROM customer));

INSERT INTO customer(username, password, fname, lname, gender, age, email, phoneNumber, DOB, imageURL) VALUES 
("nhantho", "12345", "Thọ", "Nhân", "Male", 20, "", "0369258147", "2002-01-01", "https://upload.wikimedia.org/wikipedia/commons/thumb/f/f0/HCMCUT.svg/1200px-HCMCUT.svg.png");
INSERT INTO address VALUES 
("Kí túc xá khu A", (SELECT MAX(customerID) FROM customer));

-- product
INSERT INTO supplier(name, personName, personPhone, personEmail, address, website) VALUES
("Chanel", "Olivier Polge", "0123456789", "olivier@chanel.com", "Pháp", "chanel.com");
INSERT INTO brand(name, website, supplierID) VALUES 
("Chanel", "chanel.com", 1);

INSERT INTO category(name) VALUES 
("Skincare");
INSERT INTO category(name) VALUES 
("Haircare");
INSERT INTO category(name) VALUES 
("Make-up");

-- Dạng cơ bản khi insert product, image phải ở ngay sau sản phẩm thêm vào
INSERT INTO product(name, price, categoryID, supplierID, brandID, description) VALUES 
("Son môi MAC", 1000, 3, 1, 1, "Some quick example text to build on the card title and make up the bulk of the card's content.");
INSERT INTO image VALUES 
("product1.webp", (SELECT MAX(productID) FROM product));

INSERT INTO product(name, price, categoryID, supplierID, brandID, description) VALUES 
("Son môi MAC Limited", 2000, 3, 1, 1, "Some quick example text.");
INSERT INTO image VALUES 
("product2.webp", (SELECT MAX(productID) FROM product));

INSERT INTO product(name, price, categoryID, supplierID, brandID, description) VALUES 
("Son môi MAC 2.0", 1500, 3, 1, 1, "Some quick example text to build on the card title and make up the bulk of the card's content.");
INSERT INTO image VALUES 
("product3.webp", (SELECT MAX(productID) FROM product));

INSERT INTO product(name, price, categoryID, supplierID, brandID, description) VALUES 
("Nước hoa Chanel", 2200, 3, 1, 1, "Some quick example text to build on the card title and make up the bulk of the card's content.");
INSERT INTO image VALUES 
("chanel1.webp", (SELECT MAX(productID) FROM product));

INSERT INTO product(name, price, categoryID, supplierID, brandID, description) VALUES 
("Mặt nạ dưỡng da Naruko", 2200, 1, 1, 1, "Some quick example text.");
INSERT INTO image VALUES 
("naruko1.jpg", (SELECT MAX(productID) FROM product));

INSERT INTO product(name, price, categoryID, supplierID, brandID, description) VALUES 
("Mặt nạ dưỡng da Vichy", 2200, 1, 1, 1, "Some quick example text.");
INSERT INTO image VALUES 
("vichy1.png", (SELECT MAX(productID) FROM product));

INSERT INTO cart(customerID) VALUES (1); -- Huy
INSERT INTO cart(customerID) VALUES (2);
INSERT INTO cart(customerID) VALUES (3);

INSERT INTO productAddToCart(productID, cartID, quantity) VALUES (1, 1, 1);
INSERT INTO productAddToCart(productID, cartID, quantity) VALUES (3, 1, 3);


CALL Comment(2, 1, 1, "Bad", "Sản phẩm rất tệ!");
CALL Comment(3, 1, 2, "Good", "Sản phẩm rất tốt đó!");
CALL Comment(2, 1, 5, "Good", "Không có gì!");
CALL Comment(1, 1, 5, "Good", "Sản phẩm rất tốt!");