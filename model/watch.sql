USE `oliviashop`;

SELECT * FROM CUSTOMER;
SELECT * FROM admin;
select * from supplier;
select * from category;
select * from product left join image on product.productID = image.productID;