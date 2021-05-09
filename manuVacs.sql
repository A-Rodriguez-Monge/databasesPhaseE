DELIMITER //

DROP PROCEDURE IF EXISTS manuVacs //

CREATE PROCEDURE manuVacs(IN start DATE, IN end DATE)
BEGIN

	WITH t1 AS (SELECT *
	     	    FROM ordersVaccines
		    WHERE dateOrdered > start AND dateOrdered < end
		    AND (manuName LIKE 'Jan%' OR manuName LIKE 'Ox%'
		    OR manuName LIKE 'Pf%' OR manuName LIKE 'Mod%'))

	SELECT manuName, dateOrdered, SUM(amount) orders
	FROM t1
	GROUP BY dateOrdered, manuName
	ORDER BY manuName, dateOrdered;

END; //

DELIMITER ;
