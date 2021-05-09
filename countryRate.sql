DELIMITER //

DROP PROCEDURE IF EXISTS testingDeathRate //

CREATE PROCEDURE testingDeathRate()
BEGIN
	SELECT (SELECT name FROM Country WHERE Country.isocode = CovidStats.isocode) AS country, testsAdministered / totalDeaths AS testingDeathRatio
	FROM CovidStats
	GROUP BY isocode;
END; //

DROP PROCEDURE IF EXISTS nrdRate //

CREATE PROCEDURE nrdRate()
BEGIN
	SELECT name AS country, normalAnnualDeaths * population / 1000 AS normalDeaths, (SELECT totalDeaths FROM CovidStats WHERE CovidStats.isocode = Country.isocode) AS covidDeaths
	FROM Country
	GROUP BY name;
END; //

DELIMITER ;
