DELIMITER //

DROP PROCEDURE IF EXISTS statePol //

CREATE PROCEDURE statePol()
BEGIN
	WITH polStats AS (SELECT stateName, country, polParty, population AS totalPop, covidCases AS totalCases
        FROM StateTable)
	SELECT stateName, country, polParty, totalCases / totalPop AS covidRate
	FROM polStats;
END; //

DELIMITER ;
