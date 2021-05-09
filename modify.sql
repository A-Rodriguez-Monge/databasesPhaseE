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
	
	       INSERT INTO Country VALUES(iso, cName, rName, pop, pDen, deaths, income);
		SELECT '0' empty  FROM Country LIMIT 1;	
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

DELIMITER ;
