DELIMITER //

DROP PROCEDURE IF EXISTS Hospitalizations //

CREATE PROCEDURE Hospitalizations()
BEGIN
	WITH totPat AS (SELECT COUNT(patientID) tot FROM Patient WHERE hospitalStatus = 'Yes')

	SELECT COUNT(patientID) / tot * 100 Percent, Patient.raceEthnicity
	FROM Patient, totPat
	WHERE hospitalStatus = 'Yes'
	GROUP BY raceEthnicity;

END; //

DROP PROCEDURE IF EXISTS Deaths //

CREATE PROCEDURE Deaths()
BEGIN
        WITH totPat AS (SELECT COUNT(patientID) tot FROM Patient WHERE deathStatus = 'Yes')

        SELECT COUNT(patientID) / tot * 100 Percent, Patient.raceEthnicity
        FROM Patient, totPat
        WHERE deathStatus = 'Yes'
        GROUP BY raceEthnicity;

END; //

DROP PROCEDURE IF EXISTS Infections //

CREATE PROCEDURE Infections()
BEGIN
        WITH totPat AS (SELECT COUNT(patientID) tot FROM Patient)

        SELECT COUNT(patientID) / tot * 100 Percent, Patient.raceEthnicity
        FROM Patient, totPat
        GROUP BY raceEthnicity;

END; //


DELIMITER ;
