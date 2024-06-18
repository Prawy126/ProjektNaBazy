create or replace PROCEDURE ADD_ASSIGNMENT_MEDICINES (
    p_PATIENT_ID IN NUMBER,
    p_MEDICIN_ID IN NUMBER,
    p_DOSE IN NUMBER,
    p_DATE_START IN DATE,
    p_DATE_END IN DATE,
    p_EXPIRATION_DATE IN DATE,
    p_AVAILABILITY IN CHAR
) AS
BEGIN
    INSERT INTO ASSIGNMENT_MEDICINES (ID,PATIENT_ID, MEDICIN_ID, DOSE, DATE_START, DATE_END, EXPIRATION_DATE, AVAILABILITY)
    VALUES (ASSIGNMENT_MEDICINES_ID_SEQ.NEXTVAL,p_PATIENT_ID, p_MEDICIN_ID, p_DOSE, p_DATE_START, p_DATE_END, p_EXPIRATION_DATE, p_AVAILABILITY);
END;
/
create or replace PROCEDURE DELETE_ASSIGNMENT_MEDICINES (
    p_ID IN NUMBER
) AS
BEGIN
    DELETE FROM ASSIGNMENT_MEDICINES WHERE ID = p_ID;
END;
/
create or replace PROCEDURE GET_ASSIGNMENT_MEDICINES(
    p_ID IN NUMBER,
    p_RESULT OUT SYS_REFCURSOR
) AS
BEGIN
    OPEN p_RESULT FOR
    SELECT * FROM ASSIGNMENT_MEDICINES
    WHERE ID = p_ID;
END;
/
create or replace PROCEDURE UPDATE_ASSIGNMENT_MEDICINES (
    p_ID IN NUMBER,
    p_PATIENT_ID IN NUMBER,
    p_MEDICIN_ID IN NUMBER,
    p_DOSE IN NUMBER,
    p_DATE_START IN DATE,
    p_DATE_END IN DATE,
    p_EXPIRATION_DATE IN DATE,
    p_AVAILABILITY IN CHAR
) AS
BEGIN
    UPDATE ASSIGNMENT_MEDICINES
    SET MEDICIN_ID = p_MEDICIN_ID, PATIENT_ID = p_PATIENT_ID, DOSE = p_DOSE, DATE_START = p_DATE_START, DATE_END = p_DATE_END,
        EXPIRATION_DATE = p_EXPIRATION_DATE, AVAILABILITY = p_AVAILABILITY
    WHERE ID = p_ID;
END;
/