DELIMITER //

DROP PROCEDURE IF EXISTS countryVac //

CREATE PROCEDURE countryVac(IN input VARCHAR(40))
BEGIN
	SELECT SUM(AMOUNT) AS total, isocode, manuName
	FROM ordersVaccines
	WHERE manuName = input
	GROUP BY isocode, manuName;
END; //

DELIMITER ;
