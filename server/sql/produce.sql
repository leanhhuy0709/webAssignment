USE `oliviashop`;
DROP PROCEDURE IF EXISTS Payment;
DELIMITER //
CREATE PROCEDURE Payment(IN cusID INT, IN caID INT, IN paMethod VARCHAR(255))
BEGIN
	DECLARE rowCount INT;
	DECLARE couponPercent INT;
    DECLARE couponValue INT;
    SET couponPercent = 0;
	SET couponValue = 0;
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
    
    SELECT COUNT(*) INTO rowCount
	FROM cart
	JOIN cartApplyCoupon ON cart.cartID = cartApplyCoupon.cartID
	JOIN Coupon ON cartApplyCoupon.couponCode = Coupon.couponCode
	WHERE cart.cartID = caID;
    
    IF rowCount > 0 THEN
    	SELECT percent INTO couponPercent
		FROM cart
		JOIN cartApplyCoupon ON cart.cartID = cartApplyCoupon.cartID
		JOIN Coupon ON cartApplyCoupon.couponCode = Coupon.couponCode
		WHERE cart.cartID = caID;
        
        SELECT value INTO couponValue
		FROM cart
		JOIN cartApplyCoupon ON cart.cartID = cartApplyCoupon.cartID
		JOIN Coupon ON cartApplyCoupon.couponCode = Coupon.couponCode
		WHERE cart.cartID = caID;
	END IF;
    
        
    SELECT MAX(orderID) FROM `order` INTO @maxOrderID;
    -- Update total price to max orderID
    UPDATE `order` SET totalPrice = (@total + 5) * (100 - couponPercent) / 100 - couponValue WHERE orderID = @maxOrderID;
    -- Update shippingAddress
    SELECT address INTO @address FROM customer WHERE customerID = cusID;
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

DROP PROCEDURE IF EXISTS ApplyCoupon;
DELIMITER //

CREATE PROCEDURE ApplyCoupon(IN cpCode VARCHAR(255), IN cID INT)
BEGIN
	DECLARE rowCount INT;
    DECLARE cpCount INT;

	-- Check coupon is exist
    SELECT COUNT(*) INTO rowCount
	FROM cart
	JOIN cartApplyCoupon ON cart.cartID = cartApplyCoupon.cartID
	JOIN Coupon ON cartApplyCoupon.couponCode = Coupon.couponCode
	WHERE cart.cartID = cID;

    IF rowCount > 0 THEN
    	DELETE FROM cartApplyCoupon WHERE cartID = cID;
	END IF;
    
    SELECT COUNT(*) INTO cpCount
    FROM coupon WHERE couponCode = cpCode;
    
    IF cpCount = 0 THEN
    	SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Coupon is not exist!';
	END IF;
    
    INSERT INTO cartApplyCoupon VALUES (cpCode, cID);
END //

DELIMITER ;

DROP PROCEDURE IF EXISTS DeleteUser;
DELIMITER //
CREATE PROCEDURE DeleteUser(IN cusID INT)
BEGIN
	DELETE FROM `order` WHERE customerID = cusID;
	DELETE FROM productAddToCart WHERE cartID IN (SELECT cartID FROM cart WHERE customerID = cusID);
	DELETE FROM `cart` WHERE customerID = cusID;
	DELETE FROM `Customer` WHERE customerID = cusID;
END //
DELIMITER ;

-- CALL ApplyCoupon("welcomef2", 1);

-- CALL Comment(1, 1, 1, "Good", "Sản phẩm tốt hơn bạn nghĩ!");
-- CALL Comment(2, 1, 1, "Bad", "Sản phẩm tệ hơn bạn nghĩ!");

-- CALL Comment(1, 1, 5, "test title", "test title");






