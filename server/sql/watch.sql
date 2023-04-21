USE `oliviashop`;

SELECT * FROM CUSTOMER;
SELECT * FROM admin;
select * from supplier;
select * from category;
select name, price, imageURL, description from product left join image on product.productID = image.productID;

select * from customer where username = 'leanhhuy' and password = '12345';

select product.name as name, price, imageURL, product.description, category.name as category from (product left join image on product.productID = image.productID) join category on category.categoryID = product.categoryID where category.name like "%%" and product.name like "%%";

select product.name AS name, price, imageURL, product.description, productAddToCart.quantity
from cart 
join productAddToCart on cart.cartID = productAddToCart.cartID 
join product on productAddToCart.productID = product.productID
left join image on product.productID = image.productID
where customerID = 1;

SELECT * FROM productAddToCart WHERE cartID = 1 AND productID = 1;
-- UPDATE productAddToCart SET quantity = quantity + 10 WHERE cartID = 1 AND productID = 1;

SELECT username, fname, lname, gender, age, DOB, email, phoneNumber, address 
FROM customer 
JOIN address ON  customer.customerID = address.customerID
WHERE customer.customerID = 1;

SELECT MAX(cartID) FROM cart WHERE customerID = 1;

SELECT productID, name, price, description, price FROM product WHERE productID = 1;

SELECT imageURL FROM image WHERE productID = 1;

SELECT * FROM review WHERE productID = 1;


SELECT cart.cartID, product.productID, product.name AS name, price, imageURL, product.description, productAddToCart.quantity
                        FROM cart
                        JOIN productAddToCart ON cart.cartID = productAddToCart.cartID
                        JOIN product ON productAddToCart.productID = product.productID
                        LEFT JOIN image ON product.productID = image.productID
                        WHERE customerID = 1;
                        
                        
CALL Payment(1, 6, "Momo");

SELECT orderDate, shippingDate, completeDate, totalPrice, shippingAddress, paymentMethod, orderStatus 
FROM `order`
WHERE customerID = 1;

SELECT `cartID`
FROM `order`
WHERE customerID = 1;

SELECT product.productID, product.name AS name, price, imageURL, product.description, productAddToCart.quantity
                            FROM cart
                            JOIN productAddToCart ON cart.cartID = productAddToCart.cartID
                            JOIN product ON productAddToCart.productID = product.productID
                            LEFT JOIN image ON product.productID = image.productID
                            WHERE customerID = 1 AND cart.cartID = 1;
		
SELECT * from Customer;
SELECT username, fname, lname, gender, age, DOB, email, phoneNumber, imageURL 
                        FROM customer 
                        WHERE customer.customerID = 2;
                        
select * from customer;
select * from cart;
select * from address;
INSERT INTO cart(customerID) VALUES ((SELECT MAX(customerID) FROM Customer));

SELECT * from customer;
