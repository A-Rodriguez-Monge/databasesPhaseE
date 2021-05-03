DELIMITER //

DROP PROCEDURE IF EXISTS vacsTime //

CREATE PROCEDURE vacsTime(IN iso VARCHAR(2))
BEGIN

	IF EXISTS (SELECT isocode FROM ordersVaccines WHERE isocode = iso) THEN
	   SELECT SUM(amount) OVER (ORDER BY dateOrdered) AS amount, dateOrdered
	   FROM ordersVaccines
	   WHERE isocode = iso
	   GROUP BY dateOrdered
	   ORDER BY dateOrdered;
	   
	ELSE
	   SELECT 'INVALID' AS manuName;
	END IF;
END; //

DELIMITER ;
