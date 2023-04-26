USE `oliviashop`;
-- customer
INSERT INTO customer(username, password, fname, lname, gender, age, email, phoneNumber, DOB, imageURL, address) VALUES 
("leanhhuy", "6ddd29a8fbcc70b82613c31c57bfed43", "Huy", "Lê Anh", "Male", 20, "huy.leanh0709@hcmut.edu.vn", "0123456789", "2002-09-07", "https://randomuser.me/api/portraits/men/4.jpg", "160 Pasteur, Phường 6, Quận 3, Thành phố Hồ Chí Minh");
INSERT INTO customer(username, password, fname, lname, gender, age, email, phoneNumber, DOB, imageURL, address) VALUES 
("ngoclan", "6ddd29a8fbcc70b82613c31c57bfed43", "Lan", "Ngọc", "Female", 25, "lan.ngoc@example.com", "0123456789", "1998-01-01", "https://randomuser.me/api/portraits/women/1.jpg", "54A Nguyễn Chí Thanh, Đống Đa, Hà Nội"),
("thanhtruc", "6ddd29a8fbcc70b82613c31c57bfed43", "Trúc", "Thanh", "Female", 30, "thanh.truc@example.com", "0964827382", "1993-05-20", "https://randomuser.me/api/portraits/women/2.jpg", "43 Tây Sơn, Đống Đa, Hà Nội"),
("thanhthao", "6ddd29a8fbcc70b82613c31c57bfed43", "Thảo", "Thanh", "Female", 22, "thao.thanh@example.com", "0124356129", "2001-02-14", "https://randomuser.me/api/portraits/women/3.jpg", "36 Tràng Tiền, Hoàn Kiếm, Hà Nội"),
("hongnhung", "6ddd29a8fbcc70b82613c31c57bfed43", "Nhung", "Hồng", "Female", 27, "nhung.hong@example.com", "0938172635", "1996-08-15", "https://randomuser.me/api/portraits/women/4.jpg", "216 Nguyễn Thị Minh Khai, Phường 6, Quận 3, Thành phố Hồ Chí Minh"),
("huyentrang", "8ef978e36bcaaee8e862495c679d57d7", "Trang", "Huyền", "Female", 18, "trang.huyen@example.com", "0964347382", "2005-11-22", "https://randomuser.me/api/portraits/women/5.jpg", "Tòa nhà Keangnam, Phạm Hùng, Nam Từ Liêm, Hà Nội"),
("thuytrang", "8ef978e36bcaaee8e862495c679d57d7", "Trang", "Thuỳ", "Female", 33, "trang.thuy@example.com", "0123452289", "1988-03-10", "https://randomuser.me/api/portraits/women/6.jpg", "108 Lò Đúc, Hai Bà Trưng, Hà Nội"),
("khabanh", "8ef978e36bcaaee8e862495c679d57d7", "Bảnh", "Khá", "Male", 29, "banh.kha@example.com", "0938172635", "1992-06-08", "https://randomuser.me/api/portraits/men/1.jpg", "63 Trần Hưng Đạo, Hoàn Kiếm, Hà Nội"),
("quangtrung", "8ef978e36bcaaee8e862495c679d57d7", "Trung", "Quang", "Male", 21, "trung.quang@example.com", "0964827222", "2000-04-11", "https://randomuser.me/api/portraits/men/2.jpg", "60 Lý Thường Kiệt, Hoàn Kiếm, Hà Nội"),
("hongquang", "8ef978e36bcaaee8e862495c679d57d7", "Quang", "Lê Hồng", "Male", 23, "quang.hong@example.com", "0128126789", "1998-12-31", "https://randomuser.me/api/portraits/men/3.jpg", "63 Trần Hưng Đạo, Hoàn Kiếm, Hà Nội");

INSERT INTO cart(customerID) VALUES (1), (2), (3), (4), (5), (6), (7), (8), (9), (10);

-- product
INSERT INTO supplier(name, personName, personPhone, personEmail, address, website) VALUES
("Chanel", "Olivier Polge", "0123456789", "olivier@chanel.com", "France", "chanel.com");
INSERT INTO brand(name, website, supplierID) VALUES 
("Chanel", "chanel.com", 1);

INSERT INTO category(name) VALUES ("Skincare");
INSERT INTO category(name) VALUES ("Haircare");
INSERT INTO category(name) VALUES ("Make-up");

-- Dạng cơ bản khi insert product, image phải ở ngay sau sản phẩm thêm vào
INSERT INTO product(productID, name, price, categoryID, supplierID, brandID, description) VALUES
(1, "Avene Moisturizing Cream", 35, 1, 1, 1, "Avene Moisturizing Cream moisturizes and protects the skin from sun damage, making it soft and smooth." );

INSERT INTO product(name, price, categoryID, supplierID, brandID, description) VALUES
("Kerastase Hair Essence", 30, 2, 1, 1, "Kerastase Hair Essence helps to nourish hair, reduce breakage and repair damaged hair."),
("Innisfree Powder", 10, 3, 1, 1, "Innisfree Powder has a smooth texture that covers skin imperfections well, making the skin look brighter and smoother."),
("Laneige Cleanser", 20, 1, 1, 1, "Laneige Facial Cleanser helps to clear skin, tighten pores, and brighten skin."),
("The Saem Concealer", 7, 3, 1, 1, "The Saem Concealer helps cover skin imperfections such as acne, dark spots, freckles,..."),
("Neutrogena Moisturizing Cream", 25, 1, 1, 1, "Neutrogena Moisturizing Cream deeply hydrates the skin, making it softer and smoother."),
("Pantene shampoo", 18, 2, 1, 1, "Pantene shampoo cleans hair, nourishes hair and makes hair stronger."),
("Maybelline Mascara", 15, 3, 1, 1, "Maybelline Mascara thickens, curls, and makes them look longer."),
("Lancome perfume", 55, 3, 1, 1, "Lancome perfume has a gentle, luxurious fragrance that makes you confident and seductive."),
("Kiehl's Acne Serum", 30, 1, 1, 1, "Kiehl's Acne Serum helps clear up acne and helps prevent it from coming back."),
("Dove Shower Gel", 15, 2, 1, 1, "Dove Body Wash helps to clean, nourish, and soften skin."),
("Klairs Supple Preparation Facial Toner", 12, 1, 1, 1, "A toner for all skin types that helps balance the skin's pH and provides moisture."),
("The Ordinary Niacinamide 10% + Zinc 1%", 12, 1, 1, 1, "The skin essence helps to tighten pores, fade dark spots and control oil for the skin."),
("Cerave Foaming Facial Cleanser", 28, 1, 1, 1, "Cerave Foaming Facial Cleanser gently removes dirt and impurities from the skin, while adding ingredients to help moisturize the skin.") ;

INSERT INTO image VALUES 
("https://cdn.chanhtuoi.com/uploads/2021/07/kem-duong-am-phuc-hoi-da-avene-cicalfate-repair-cream-40ml-1-1.jpg", 1),
("https://myphamtocnhapkhau.com/upload/products/2022-11-04-12-05-05/tinhdaukerastase100ml-1.jpg", 2),
("https://mint07.com/wp-content/uploads/2020/03/phan-phu-innisfree-dang-bot-no-sebum-mineral-powder1.jpg", 3),
("https://cdn.chanhtuoi.com/uploads/2020/05/sua-rua-mat-laneige-00.jpg", 4),
("https://product.hstatic.net/1000379579/product/61reyrdk8-l_001521a6db0f474f85852ae9c87170be_master.jpg", 5),
("https://bizweb.dktcdn.net/thumb/1024x1024/100/382/633/products/kem-duong-am-neutrogena-hydro-boost-water-gel-50g.jpg?v=1643008556300", 6),
("https://product.hstatic.net/200000067158/product/pantene-hair-fall-control-shampoo-pdp_f12810c2b18c4c8085c623be24e02a0c.jpg", 7),
("https://product.hstatic.net/1000006063/product/114_c186ba72d893459a88bf79fdf41d06d8_1024x1024.jpg", 8),
("https://theperfume.vn/wp-content/uploads/2021/07/nuoc-hoa-lancome-2.jpg", 9),
("https://shopmebebau.com/image/cache/catalog/%20X%E1%BB%8AT%20KHU%20MUI%20NIVEA/T07.22/e93ca3ae-1000x1000.jpg", 10),
("https://u-shop.vn/images/thumbs/0012666_tang-khan-sua-tam-dove-duong-am-chuyen-sau-500g_510.png", 11),
("https://product.hstatic.net/200000312421/product/toner-klair_be0faf06fa5f40f39b9cbe1f17e63ba3_grande.jpg", 12),
("https://cf.shopee.vn/file/7ba53df7faf7fa3bbb7138bf9da6c874", 13),
("https://bizweb.dktcdn.net/100/345/186/files/sua-rua-mat-cerave-foaming-3.jpg?v=1621325346102", 14);

INSERT INTO admin VALUES (1); -- Huy is admin
INSERT INTO coupon VALUES ("welcome", "Welcome to Olivia", 0, 5, 1);
INSERT INTO coupon VALUES ("welcome2", "Welcome to Olivia", 10, 0, 1);
INSERT INTO coupon VALUES ("olivia", "Olivia Big sale", 30, 0, 1);
