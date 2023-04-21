DROP DATABASE IF EXISTS`oliviashop`;
CREATE DATABASE IF NOT EXISTS `oliviashop` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `oliviashop`;



CREATE TABLE `customer` (
	`customerID` int primary key AUTO_INCREMENT,
    `username` varchar(255) UNIQUE,
    `password` varchar(255),
    `fname` varchar(255),
    `lname` varchar(255),
    `gender` varchar(255),
    `age` int,
    `email` varchar(255),
    `phoneNumber` varchar(255),
    `DOB` date,
    `imageURL` varchar(255)
);

CREATE TABLE `address` (
    `address` varchar(255),
	`customerID` int,
    primary key (`customerID`, `address`),
    foreign key (`customerID`) references `customer`(`customerID`)
);

CREATE TABLE `paymentMethod` (
    `paymentMethod` varchar(255),
	`customerID` int,
    primary key (`customerID`, `paymentMethod`),
    foreign key (`customerID`) references `customer`(`customerID`)
);

CREATE TABLE `cart` (
	`cartID` int primary key AUTO_INCREMENT,
    `customerID` int,
    foreign key (`customerID`) references `customer`(`customerID`)
);

CREATE TABLE `admin` (
	`adminID` int primary key AUTO_INCREMENT
);

CREATE TABLE `coupon` (
	`couponCode` varchar(255) primary key,
    `name` varchar(255),
    `percent` int,
    `value` int,
    `adminID` int,
    foreign key (`adminID`) references `admin`(`adminID`)
);

CREATE TABLE `cartApplyCoupon` (
	`couponCode` varchar(255),
    `cartID` int,
    primary key (`couponCode`, `cartID`),
    foreign key (`couponCode`) references `coupon`(`couponCode`),
    foreign key (`cartID`) references `cart`(`cartID`)
);

CREATE TABLE `category` (
	`categoryID` int primary key AUTO_INCREMENT,
    `name` varchar(255),
    `SEOFriendlyURL` varchar(255),
    `parentCategoryID` varchar(255),
    `description` varchar(255),
	`adminID` int,
    foreign key (`adminID`) references `admin`(`adminID`)
);
CREATE TABLE `supplier` (
    `supplierID` int primary key AUTO_INCREMENT,
    `name` varchar(255),
    `personName` varchar(255),
    `personPhone` varchar(255),
    `personEmail` varchar(255),
    `address` varchar(255),
    `website` varchar(255)
);

CREATE TABLE `brand` (
    `brandID` int primary key AUTO_INCREMENT,
    `name` varchar(255),
    `description` varchar(255),
    `countryofOrigin` varchar(255),
    `website` varchar(255),
    `representativeContact` varchar(255),
    `representativeName` varchar(255),
	`supplierID` int,
    foreign key (`supplierID`) references `supplier`(`supplierID`)
);

CREATE TABLE `product` (
	`productID` int primary key AUTO_INCREMENT,
    `weight` varchar(255),
    `UPCCode` varchar(255),
    `name` varchar(255),
    `description` varchar(255),
    `cost` int,
    `price` int,
    `locationAvailable` varchar(255),
    `quantity` int,
    `reorderPoint` int,
    `status` varchar(255),
    `importedToInventoryDate` date,
    `safetyStock` varchar(255),
    `availability` varchar(255),
    `ingredient` varchar(255),
    `color` varchar(255),
    `size` varchar(255),
    `contryOfOrigin` varchar(255),
    `SKUCode` varchar(255),
    `manufactureDate` date,
    `expirationDate` date,
    `categoryID` int,
    foreign key (`categoryID`) references `category`(`categoryID`),
    `supplierID` int,
    foreign key (`supplierID`) references `supplier`(`supplierID`),
    `brandID` int,
    foreign key (`brandID`) references `brand`(`brandID`)
);

CREATE TABLE `image` (
    `imageURL` varchar(255),
    `productID` int,
    primary key (`productID`, `imageURL`),
    foreign key (`productID`) references `product`(`productID`)
);

CREATE TABLE `productAddToCart` (
    `productID` int,
    `cartID` int,
    primary key (`productID`, `cartID`),
    `quantity` int,
    foreign key (`productID`) references `product`(`productID`),
    foreign key (`cartID`) references `cart`(`cartID`)
);

CREATE TABLE `contract` (
    `contract` varchar(255) primary key,
    `supplierID` int,
    foreign key (`supplierID`) references `supplier`(`supplierID`)
);

CREATE TABLE `review` (
    `reviewID` int primary key AUTO_INCREMENT,
    `rating` int,
    `title` varchar(255),
    `text` varchar(255),
    `reviewDate` datetime,
    `status` varchar(255),
    `helpfulVotes` varchar(255),
    `unHelpfulVotes` varchar(255),
    `verifiedPurchase` varchar(255),
    `productID` int,
    foreign key (`productID`) references `product`(`productID`),
    `customerID` int,
    foreign key (`customerID`) references `customer`(`customerID`)
);

CREATE TABLE `imageVideoOfReview` (
    `imageVideoURL` varchar(255),
    `reviewID` int,
    primary key (`reviewID`, `imageVideoURL`),
    foreign key (`reviewID`) references `review`(`reviewID`)
);

CREATE TABLE `order` (
    `orderID` int primary key AUTO_INCREMENT,
    `orderDate` date,
    `shippingDate` date,
    `completeDate` date,
    `totalPrice` int,
    `shippingAddress` varchar(255),
    `paymentMethod` varchar(255),
    `paymentStatus` varchar(255),
    `shippingStatus` varchar(255),
    `orderStatus` varchar(255),
    `shippingUnit` varchar(255),
    `shippingID` varchar(255),
    `customerID` int,
    foreign key (`customerID`) references `customer`(`customerID`),
    `cartID` int,
    foreign key (`cartID`) references `cart`(`cartID`)
);

CREATE TABLE `reasonForReturn/Exchange` (
    `reasonID` int,
    `reason` varchar(255),
    `orderID` int,
    primary key (`orderID`, `reasonID`),
    foreign key (`orderID`) references `order`(`orderID`)
);

CREATE TABLE `reasonForCancellation` (
    `reasonID` int,
    `reason` varchar(255),
    `orderID` int,
    primary key (`orderID`, `reasonID`),
    foreign key (`orderID`) references `order`(`orderID`)
);


