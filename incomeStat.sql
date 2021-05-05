DELIMITER //

DROP PROCEDURE IF EXISTS incomeStat //

CREATE PROCEDURE incomeStat(IN low INT, IN up INT)
BEGIN

	WITH t1 AS (SELECT isocode, name, totalCases / population AS infRate			FROM Country NATURAL JOIN CovidStats
	     	    WHERE perCapitaIncome > low AND perCapitaIncome < up)

	SELECT avg(infRate) * 100 AS avgRate
	FROM t1;

END; //

DELIMITER ;
