USE `oliviashop`;
-- customer
INSERT INTO customer(username, password, fname, lname, gender, age, email, phoneNumber, DOB) VALUES 
("leanhhuy", "12345", "Huy", "Lê Anh", "Male", 20, "huy.leanh0709@hcmut.edu.vn", "0123456789", "2002-09-07");
INSERT INTO address VALUES 
("Kí túc xá khu A", (SELECT MAX(customerID) FROM customer));
INSERT INTO paymentMethod VALUES 
("Momo", (SELECT MAX(customerID) FROM customer));

INSERT INTO customer(username, password, fname, lname, gender, age, email, phoneNumber, DOB) VALUES 
("hoangtien", "12345", "Tiên", "Hoàng", "Female", 20, "", "0246813579", "2002-12-31");
INSERT INTO address VALUES 
("Kí túc xá khu A", (SELECT MAX(customerID) FROM customer));

INSERT INTO customer(username, password, fname, lname, gender, age, email, phoneNumber, DOB) VALUES 
("nhantho", "12345", "Thọ", "Nhân", "Male", 20, "", "0369258147", "2002-01-01");
INSERT INTO address VALUES 
("Kí túc xá khu A", (SELECT MAX(customerID) FROM customer));

-- admin

INSERT INTO admin(username, password, fname, lname, gender, age, email, phoneNumber, DOB, role, accountStatus, permissionLevel) VALUES
("admin", "admin", "Harry", "Potter", "Male", 20, "harry.potter@hcmut.edu.vn", "0123456789", "2002-06-01", "Admin", "", "");

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
INSERT INTO product(name, price, categoryID, supplierID, brandID) VALUES 
("Son môi MAC", 1000, 1, 1, 1);
INSERT INTO image VALUES 
("URL", (SELECT MAX(productID) FROM product));
INSERT INTO image VALUES 
("URL2", (SELECT MAX(productID) FROM product));

INSERT INTO product(name, price, categoryID, supplierID, brandID) VALUES 
("Son môi MAC Limited", 2000, 1, 1, 1);

INSERT INTO product(name, price, categoryID, supplierID, brandID) VALUES 
("Son môi SHISHEIDO", 1500, 1, 1, 1);

INSERT INTO product(name, price, categoryID, supplierID, brandID) VALUES 
("Dầu gội Clear", 1000, 2, 1, 1);

INSERT INTO product(name, price, categoryID, supplierID, brandID) VALUES 
("Dầu gội X-men", 1200, 2, 1, 1);

INSERT INTO product(name, price, categoryID, supplierID, brandID) VALUES 
("Nước hoa", 2200, 3, 1, 1);

INSERT INTO product(name, price, categoryID, supplierID, brandID) VALUES 
("Mặt nạ dưỡng da", 2200, 1, 1, 1);












