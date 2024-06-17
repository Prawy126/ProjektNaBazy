create or replace PROCEDURE CREATE_USER (
    p_LOGIN IN VARCHAR2,
    p_PASSWORD IN VARCHAR2,
    p_ACCOUNT_TYPE IN NUMBER
) AS
BEGIN
    INSERT INTO USERS (ID, LOGIN, PASSWORD, ACCOUNT_TYPE)
    VALUES (USERS_ID_SEQ.NEXTVAL, p_LOGIN, p_PASSWORD, p_ACCOUNT_TYPE);
END;

create or replace PROCEDURE GET_USER (
    p_ID IN NUMBER,
    p_LOGIN OUT VARCHAR2,
    p_ACCOUNT_TYPE OUT NUMBER
) AS
BEGIN
    SELECT LOGIN, ACCOUNT_TYPE
    INTO p_LOGIN, p_ACCOUNT_TYPE
    FROM USERS
    WHERE ID = p_ID;
END;

create or replace PROCEDURE DELETE_USER (
    p_ID IN NUMBER
) AS
BEGIN
    DELETE FROM USERS WHERE ID = p_ID;
END;

create or replace PROCEDURE UPDATE_USER (
    p_ID IN NUMBER,
    p_LOGIN IN VARCHAR2,
    p_PASSWORD IN VARCHAR2,
    p_ACCOUNT_TYPE IN NUMBER
) AS
BEGIN
    UPDATE USERS
    SET LOGIN = p_LOGIN, PASSWORD = p_PASSWORD, ACCOUNT_TYPE = p_ACCOUNT_TYPE
    WHERE ID = p_ID;
END;