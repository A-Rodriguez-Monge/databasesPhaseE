DELIMITER //

DROP PROCEDURE IF EXISTS vacRate //

CREATE PROCEDURE vacRate(IN lower INT)
BEGIN

	WITH cVac AS (SELECT name, perCapitaIncome, totalVacs / population / 2 * 100 vacRate FROM CovidStats NATURAL JOIN Country)

	SELECT *
	FROM cVac
	WHERE perCapitaIncome > lower AND vacRate > 0
	ORDER BY vacRate DESC, perCapitaIncome DESC
	LIMIT 15;

END; //

DELIMITER ;
