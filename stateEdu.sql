DELIMITER //

DROP PROCEDURE IF EXISTS stateEdu //

CREATE PROCEDURE stateEdu(IN input VARCHAR(40))
BEGIN
	WITH stateEdu AS (SELECT stateName, covidCases / population AS covidRate, CASE WHEN input = "college" THEN `college`
		WHEN input = "someCollege" THEN `someCollege` WHEN input = "HS" THEN `HS` ELSE `someHS` END AS percent
        FROM StateTable)
	SELECT *
	FROM stateEdu;
END; //

DELIMITER ;
