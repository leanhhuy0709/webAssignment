USE `oliviashop`;
DROP PROCEDURE IF EXISTS Payment;
DELIMITER //
CREATE PROCEDURE Payment(IN cusID INT, IN caID INT, IN paMethod VARCHAR(255))
BEGIN
    -- Check if cart have product
    SELECT COUNT(*) INTO @count FROM productAddToCart WHERE cartID = caID;
    IF @count = 0 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Cart is empty';
    END IF;
    -- Create new order
	INSERT INTO `order`(customerID, cartID) VALUES (cusID, caID);
    -- Caculate total price
    SELECT SUM(price * productAddToCart.quantity) INTO @total 
    FROM productAddToCart 
    JOIN product ON productAddToCart.productID = product.productID 
    WHERE cartID = caID;
    
    SELECT MAX(orderID) FROM `order` INTO @maxOrderID;
    -- Update total price to max orderID
    UPDATE `order` SET totalPrice = @total WHERE orderID = @maxOrderID;
    -- Update shippingAddress
    SELECT address INTO @address FROM address WHERE customerID = cusID;
    UPDATE `order` SET shippingAddress = @address WHERE orderID = @maxOrderID;
    -- Update paymentMethod
    UPDATE `order` SET paymentMethod = paMethod WHERE orderID = @maxOrderID;
    -- Update orderStatus
    UPDATE `order` SET orderStatus = 'Processing' WHERE orderID = @maxOrderID;
    -- Update orderDate
    UPDATE `order` SET orderDate = NOW() WHERE orderID = @maxOrderID;
    -- Update deliveryDate
    UPDATE `order` SET shippingDate = NOW() + INTERVAL 3 DAY WHERE orderID = @maxOrderID;
    -- Create new cart for customer
    INSERT INTO `cart`(customerID) VALUES (cusID);
END //
DELIMITER ;

-- CALL Payment(1, 1, "Momo");

DROP PROCEDURE IF EXISTS Comment;
DELIMITER //
CREATE PROCEDURE Comment(IN cusID INT, IN pdID INT, IN numStar INT, IN tt VARCHAR(255), IN cmt VARCHAR(255))
BEGIN
    INSERT INTO review(customerID, productID) VALUES (cusID, pdID);
    SELECT MAX(reviewID) FROM review INTO @maxReviewID;
    UPDATE review SET text = cmt WHERE reviewID = @maxReviewID;
    UPDATE review SET reviewDate = CURRENT_TIMESTAMP WHERE reviewID = @maxReviewID;
    UPDATE review SET title = tt WHERE reviewID = @maxReviewID;
    UPDATE review SET status = 'Pending' WHERE reviewID = @maxReviewID;
    UPDATE review SET helpfulVotes = 0 WHERE reviewID = @maxReviewID;
    UPDATE review SET unHelpfulVotes = 0 WHERE reviewID = @maxReviewID;
    UPDATE review SET verifiedPurchase = 'Yes' WHERE reviewID = @maxReviewID;
    UPDATE review SET rating = numStar WHERE reviewID = @maxReviewID;
END //
DELIMITER ;


-- CALL Comment(1, 1, 1, "Good", "Sản phẩm tốt hơn bạn nghĩ!");
-- CALL Comment(2, 1, 1, "Bad", "Sản phẩm tệ hơn bạn nghĩ!");

-- CALL Comment(1, 1, 5, "test title", "test title");






