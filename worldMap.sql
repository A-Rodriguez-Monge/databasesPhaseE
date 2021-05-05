DELIMITER //

DROP PROCEDURE IF EXISTS worldMap //

CREATE PROCEDURE worldMap(IN iso VARCHAR(2))
BEGIN
	IF EXISTS (SELECT isocode FROM CovidStats WHERE isocode = iso) THEN
		SELECT *
		FROM CovidStats
		WHERE isocode = iso;
	ELSE
		SELECT 'INVALID' AS isocode;
	END IF;
END; //

DELIMITER ;
