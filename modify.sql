DELIMITER //

DROP PROCEDURE IF EXISTS insertReg //

CREATE PROCEDURE insertReg(IN rName VARCHAR(40), IN pop INT)
BEGIN
	IF NOT EXISTS (SELECT regionName FROM Region WHERE regionName = rName) THEN
	       INSERT INTO Region(regionName, population) VALUES(rName, pop);
	       SELECT '0' empty FROM Region LIMIT 1;
	END IF;

END; //

DROP PROCEDURE IF EXISTS deleteReg //

CREATE PROCEDURE deleteReg(IN rName VARCHAR(40))
BEGIN

	IF EXISTS (SELECT regionName FROM Region WHERE regionName = rName) THEN

		DELETE FROM Region WHERE regionName = rName;
  		SELECT '0' empty FROM Region LIMIT 1;

	END IF;

END; //


/*			Country 					*/


DROP PROCEDURE IF EXISTS insertCou //

CREATE PROCEDURE insertCou(IN iso VARCHAR(2),IN cName VARCHAR(40), IN rName VARCHAR(40), IN pop INT, IN pDen INT, IN deaths DECIMAL(4), IN income INT)
BEGIN
	IF NOT EXISTS (SELECT isocode FROM Country WHERE isocode=iso) THEN

	   IF EXISTS (SELECT regionName FROM Region WHERE regionName=rName) THEN
	       INSERT INTO Country VALUES(iso, cName, rName, pop, pDen, deaths, income);
		SELECT '0' empty  FROM Country LIMIT 1;	
 	   END IF;
	END IF;

END; //

DROP PROCEDURE IF EXISTS deleteCou //

CREATE PROCEDURE deleteCou(IN iso VARCHAR(2))
BEGIN

	IF EXISTS (SELECT isocode FROM Country WHERE isocode = iso) THEN

		DELETE FROM Country WHERE isocode = iso;
		SELECT '0' empty FROM Country LIMIT 1;
	END IF;

END; //

/*			Statistic 					*/


DROP PROCEDURE IF EXISTS insertStat //

CREATE PROCEDURE insertStat(IN iso VARCHAR(2),IN deaths INT, IN tests INT, IN vacs INT, IN hosp INT, IN cases INT)
BEGIN
	IF EXISTS (SELECT isocode FROM Country WHERE isocode=iso) THEN
	   IF NOT EXISTS (SELECT isocode FROM CovidStats WHERE isocode=iso) THEN
	   
	       INSERT INTO CovidStats VALUES(iso, deaths, tests, vacs, hosp, cases);
		SELECT '0' empty  FROM Country LIMIT 1;	
 	   END IF;
	END IF;

END; //

DROP PROCEDURE IF EXISTS deleteStat //

CREATE PROCEDURE deleteStat(IN iso VARCHAR(2))
BEGIN

	IF EXISTS (SELECT isocode FROM CovidStats WHERE isocode = iso) THEN

		DELETE FROM CovidStats WHERE isocode = iso;
		SELECT '0' empty FROM Country LIMIT 1;
	END IF;

END; //


/*			Manufacturer 					*/


DROP PROCEDURE IF EXISTS insertManu //

CREATE PROCEDURE insertManu(IN name VARCHAR(40), IN amount INT)
BEGIN
	IF NOT EXISTS (SELECT manuName FROM Manufacturer WHERE manuName=name) THEN

	   
	       INSERT INTO Manufacturer VALUES(name, amount);
		SELECT '0' empty  FROM Country LIMIT 1;	
	END IF;

END; //

DROP PROCEDURE IF EXISTS deleteManu //

CREATE PROCEDURE deleteManu(IN name VARCHAR(40))
BEGIN

	IF EXISTS (SELECT manuName FROM Manufacturer WHERE manuName=name) THEN

		DELETE FROM Manufacturer WHERE manuName=name;
		SELECT '0' empty FROM Country LIMIT 1;
	END IF;

END; //

/*			Vaccine Orders 					*/


DROP PROCEDURE IF EXISTS insertOrder //

CREATE PROCEDURE insertOrder(IN name VARCHAR(40),IN iso VARCHAR(2), IN dateOrdered DATE, IN amount INT)
BEGIN
	IF EXISTS (SELECT isocode FROM Country WHERE isocode=iso) THEN
	   IF EXISTS (SELECT manuName FROM Manufacturer WHERE manuName=name) THEN
	   
	       INSERT INTO ordersVaccines (manuName, isocode, dateOrdered, amount) VALUES(name, iso, dateOrdered, amount);
		SELECT '0' empty  FROM Country LIMIT 1;	
 	   END IF;
	END IF;

END; //

DROP PROCEDURE IF EXISTS deleteOrder //

CREATE PROCEDURE deleteOrder(IN num INT)
BEGIN

	IF EXISTS (SELECT orderID FROM ordersVaccines WHERE orderID=num) THEN

		DELETE FROM ordersVaccines WHERE orderID=num;
		SELECT '0' empty FROM Country LIMIT 1;
	END IF;

END; //


DELIMITER ;
