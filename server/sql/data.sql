USE `oliviashop`;
-- customer
INSERT INTO customer(username, password, fname, lname, gender, age, email, phoneNumber, DOB, imageURL) VALUES 
("leanhhuy", "12345", "Huy", "Lê Anh", "Male", 20, "huy.leanh0709@hcmut.edu.vn", "0123456789", "2002-09-07", "https://randomuser.me/api/portraits/men/4.jpg");
INSERT INTO customer(username, password, fname, lname, gender, age, email, phoneNumber, DOB, imageURL) VALUES 
("ngoclan", "12345", "Lan", "Ngọc", "Female", 25, "lan.ngoc@example.com", "0123456789", "1998-01-01", "https://randomuser.me/api/portraits/women/1.jpg"),
("thanhtruc", "12345", "Trúc", "Thanh", "Female", 30, "thanh.truc@example.com", "0123456789", "1993-05-20", "https://randomuser.me/api/portraits/women/2.jpg"),
("thanhthao", "12345", "Thảo", "Thanh", "Female", 22, "thao.thanh@example.com", "0123456789", "2001-02-14", "https://randomuser.me/api/portraits/women/3.jpg"),
("hongnhung", "12345", "Nhung", "Hồng", "Female", 27, "nhung.hong@example.com", "0123456789", "1996-08-15", "https://randomuser.me/api/portraits/women/4.jpg"),
("huyentrang", "12345", "Trang", "Huyền", "Female", 18, "trang.huyen@example.com", "0123456789", "2005-11-22", "https://randomuser.me/api/portraits/women/5.jpg"),
("thuytrang", "12345", "Trang", "Thuỳ", "Female", 33, "trang.thuy@example.com", "0123456789", "1988-03-10", "https://randomuser.me/api/portraits/women/6.jpg"),
("khabanh", "12345", "Bảnh", "Khá", "Male", 29, "banh.kha@example.com", "0123456789", "1992-06-08", "https://randomuser.me/api/portraits/men/1.jpg"),
("quangtrung", "12345", "Trung", "Quang", "Male", 21, "trung.quang@example.com", "0123456789", "2000-04-11", "https://randomuser.me/api/portraits/men/2.jpg"),
("hongquang", "12345", "Quang", "Lê Hồng", "Male", 23, "quang.hong@example.com", "0123456789", "1998-12-31", "https://randomuser.me/api/portraits/men/3.jpg");

INSERT INTO address(address, customerID) VALUES ("Kí túc xá khu A", 1);
INSERT INTO address(address, customerID) VALUES ("Đại học Sư phạm Kỹ thuật Tp. HCM", 2);
INSERT INTO address(address, customerID) VALUES ("Khu phố 6, phường Linh Trung, quận Thủ Đức", 3);
INSERT INTO address(address, customerID) VALUES ("Kí túc xá khu B", 4);
INSERT INTO address(address, customerID) VALUES ("Đại học Ngoại thương Tp. HCM", 5);
INSERT INTO address(address, customerID) VALUES ("Kí túc xá khu C", 6);
INSERT INTO address(address, customerID) VALUES ("Khu phố 4, phường Hiệp Bình Chánh, quận Thủ Đức", 7);
INSERT INTO address(address, customerID) VALUES ("Đại học Kinh tế Tp. HCM", 8);
INSERT INTO address(address, customerID) VALUES ("Khu phố 2, phường Linh Trung, quận Thủ Đức", 9);
INSERT INTO address(address, customerID) VALUES ("Kí túc xá khu D", 10);

INSERT INTO cart(customerID) VALUES (1), (2), (3), (4), (5), (6), (7), (8), (9), (10);

-- product
INSERT INTO supplier(name, personName, personPhone, personEmail, address, website) VALUES
("Chanel", "Olivier Polge", "0123456789", "olivier@chanel.com", "Pháp", "chanel.com");
INSERT INTO brand(name, website, supplierID) VALUES 
("Chanel", "chanel.com", 1);

INSERT INTO category(name) VALUES ("Skincare");
INSERT INTO category(name) VALUES ("Haircare");
INSERT INTO category(name) VALUES ("Make-up");

-- Dạng cơ bản khi insert product, image phải ở ngay sau sản phẩm thêm vào
INSERT INTO product(productID, name, price, categoryID, supplierID, brandID, description) VALUES
(1, "Avene Moisturizing Cream", 200000, 1, 1, 1, "Avene Moisturizing Cream moisturizes and protects the skin from sun damage, making it soft and smooth." );

INSERT INTO product(name, price, categoryID, supplierID, brandID, description) VALUES
("Kerastase Hair Essence", 500000, 2, 1, 1, "Kerastase Hair Essence helps to nourish hair, reduce breakage and repair damaged hair."),
("Innisfree Powder", 300000, 3, 1, 1, "Innisfree Powder has a smooth texture that covers skin imperfections well, making the skin look brighter and smoother."),
("Laneige Cleanser", 250000, 1, 1, 1, "Laneige Facial Cleanser helps to clear skin, tighten pores, and brighten skin."),
("The Saem Concealer", 150000, 3, 1, 1, "The Saem Concealer helps cover skin imperfections such as acne, dark spots, freckles,..."),
("Neutrogena Moisturizing Cream", 200000, 1, 1, 1, "Neutrogena Moisturizing Cream deeply hydrates the skin, making it softer and smoother."),
("Pantene shampoo", 120000, 2, 1, 1, "Pantene shampoo cleans hair, nourishes hair and makes hair stronger."),
("Maybelline Mascara", 150000, 3, 1, 1, "Maybelline Mascara thickens, curls, and makes them look longer."),
("Lancome perfume", 2500000, 3, 1, 1, "Lancome perfume has a gentle, luxurious fragrance that makes you confident and seductive."),
("Kiehl's Acne Serum", 300000, 1, 1, 1, "Kiehl's Acne Serum helps clear up acne and helps prevent it from coming back."),
("Dove Shower Gel", 80000, 2, 1, 1, "Dove Body Wash helps to clean, nourish, and soften skin."),
("Klairs Supple Preparation Facial Toner", 300000, 1, 1, 1, "A toner for all skin types that helps balance the skin's pH and provides moisture."),
("The Ordinary Niacinamide 10% + Zinc 1%", 250000, 1, 1, 1, "The skin essence helps to tighten pores, fade dark spots and control oil for the skin."),
("Cerave Foaming Facial Cleanser", 250000, 1, 1, 1, "Cerave Foaming Facial Cleanser gently removes dirt and impurities from the skin, while adding ingredients to help moisturize the skin.") ;

INSERT INTO image VALUES 
("https://cdn.chanhtuoi.com/uploads/2021/07/kem-duong-am-phuc-hoi-da-avene-cicalfate-repair-cream-40ml-1-1.jpg", 1),
("https://myphamtocnhapkhau.com/upload/products/2022-11-04-12-05-05/tinhdaukerastase100ml-1.jpg", 2),
("https://mint07.com/wp-content/uploads/2020/03/phan-phu-innisfree-dang-bot-no-sebum-mineral-powder1.jpg", 3),
("https://cdn.chanhtuoi.com/uploads/2020/05/sua-rua-mat-laneige-00.jpg", 4),
("https://product.hstatic.net/1000296801/product/bang-mau-kem-che-khuyet-diem-the-saem_e1c1d5978b7c4c4abed1d586a5043281.jpg", 5),
("https://bizweb.dktcdn.net/thumb/1024x1024/100/382/633/products/kem-duong-am-neutrogena-hydro-boost-water-gel-50g.jpg?v=1643008556300", 6),
("https://product.hstatic.net/200000067158/product/pantene-hair-fall-control-shampoo-pdp_f12810c2b18c4c8085c623be24e02a0c.jpg", 7),
("https://www.maybelline.vn/~/media/mny/vi_vn/2%20eyes/mascara/1%20volum%20express%20the%20magnum%20mascara/maybelline-eyes-mascara-colossal-waterproof-mascara-black-primary3.jpg", 8),
("https://theperfume.vn/wp-content/uploads/2021/07/nuoc-hoa-lancome-2.jpg", 9),
("https://shopmebebau.com/image/cache/catalog/%20X%E1%BB%8AT%20KHU%20MUI%20NIVEA/T07.22/e93ca3ae-1000x1000.jpg", 10),
("https://u-shop.vn/images/thumbs/0012666_tang-khan-sua-tam-dove-duong-am-chuyen-sau-500g_510.png", 11),
("https://bloganchoi.com/wp-content/uploads/2019/04/nuoc-hoa-hong.jpg", 12),
("https://cdn.chiaki.vn/unsafe/0x800/left/top/smart/filters:quality(75)/https://chiaki.vn/upload/product/2023/01/serum-the-ordinary-niacinamide-10-zinc-1-chong-viem-63c4b06bd97d1-16012023090323.jpg", 13),
("https://bizweb.dktcdn.net/100/345/186/files/sua-rua-mat-cerave-foaming-3.jpg?v=1621325346102", 14);

