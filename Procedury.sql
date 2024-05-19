CREATE OR REPLACE PROCEDURE ADD_DOCTOR(
    p_name IN VARCHAR2,
    p_surname IN VARCHAR2,
    p_specialization IN VARCHAR2,
    p_license_number IN VARCHAR2,
    p_user_id IN NUMBER)
IS
BEGIN
    INSERT INTO doctors (name, surname, specialization, license_number, user_id)
    VALUES (p_name, p_surname, p_specialization, p_license_number, p_user_id);
END;

CREATE OR REPLACE PROCEDURE GET_DOCTOR(
    p_doctor_id IN NUMBER,
    p_doctor OUT SYS_REFCURSOR)
IS
BEGIN
    OPEN p_doctor FOR
    SELECT * FROM doctors WHERE id = p_doctor_id;
END;


CREATE OR REPLACE PROCEDURE UPDATE_DOCTOR(
    p_doctor_id IN NUMBER,
    p_name IN VARCHAR2,
    p_surname IN VARCHAR2,
    p_specialization IN VARCHAR2,
    p_license_number IN VARCHAR2,
    p_user_id IN NUMBER)
IS
BEGIN
    UPDATE doctors
    SET name = p_name,
        surname = p_surname,
        specialization = p_specialization,
        license_number = p_license_number,
        user_id = p_user_id
    WHERE id = p_doctor_id;
END;


CREATE OR REPLACE PROCEDURE DELETE_DOCTOR(
    p_doctor_id IN NUMBER)
IS
BEGIN
    DELETE FROM doctors WHERE id = p_doctor_id;
END;

CREATE OR REPLACE PROCEDURE ADD_PATIENT(
    p_name IN VARCHAR2,
    p_surname IN VARCHAR2,
    p_nurse_id IN NUMBER,
    p_user_id IN NUMBER,
    p_time_visit IN NUMBER,
    p_room_id IN NUMBER)
IS
BEGIN
    INSERT INTO patients (name, surname, nurse_id, user_id, time_visit, room_id)
    VALUES (p_name, p_surname, p_nurse_id, p_user_id, p_time_visit, p_room_id);
END;

CREATE OR REPLACE PROCEDURE GET_PATIENT(
    p_patient_id IN NUMBER,
    p_patient OUT SYS_REFCURSOR)
IS
BEGIN
    OPEN p_patient FOR
    SELECT * FROM patients WHERE id = p_patient_id;
END;


CREATE OR REPLACE PROCEDURE UPDATE_PATIENT(
    p_patient_id IN NUMBER,
    p_name IN VARCHAR2,
    p_surname IN VARCHAR2,
    p_nurse_id IN NUMBER,
    p_user_id IN NUMBER,
    p_time_visit IN NUMBER,
    p_room_id IN NUMBER)
IS
BEGIN
    UPDATE patients
    SET name = p_name,
        surname = p_surname,
        nurse_id = p_nurse_id,
        user_id = p_user_id,
        time_visit = p_time_visit
    WHERE id = p_patient_id;
END;

CREATE OR REPLACE PROCEDURE DELETE_PATIENT(
    p_patient_id IN NUMBER)
IS
BEGIN
    DELETE FROM patients WHERE id = p_patient_id;
END;

CREATE OR REPLACE PROCEDURE ADD_NURSE(
    p_name IN VARCHAR2,
    p_surname IN VARCHAR2,
    p_number IN VARCHAR2,
    p_user_id IN NUMBER)
IS
BEGIN
    INSERT INTO NURSES (NAME, SURNAME, "NUMBER", USER_ID)
    VALUES (p_name, p_surname, p_number, p_user_id);
END;


CREATE OR REPLACE PROCEDURE GET_NURSE(
    p_nurse_id IN NUMBER,
    p_nurse OUT SYS_REFCURSOR)
IS
BEGIN
    OPEN p_nurse FOR
    SELECT * FROM nurses WHERE id = p_nurse_id;
END;


CREATE OR REPLACE PROCEDURE UPDATE_NURSE(
    p_nurse_id IN NUMBER,
    p_name IN VARCHAR2,
    p_surname IN VARCHAR2,
    p_number IN VARCHAR2,
    p_user_id IN NUMBER)
IS
BEGIN
    UPDATE nurses
    SET name = p_name,
        surname = p_surname,
        "NUMBER" = p_number,
        user_id = p_user_id
    WHERE id = p_nurse_id;
END;

CREATE OR REPLACE PROCEDURE DELETE_NURSE(
    p_nurse_id IN NUMBER)
IS
BEGIN
    DELETE FROM nurses WHERE id = p_nurse_id;
END;

CREATE OR REPLACE PROCEDURE ADD_MEDICIN(
    p_name IN VARCHAR2,
    p_instruction IN CLOB,
    p_warehouse_quantity IN NUMBER,
    p_drug_category IN VARCHAR2,
    p_price IN NUMBER,
    p_dose_unit IN VARCHAR2)
IS
BEGIN
    INSERT INTO NURSES (NAME, SURNAME, "NUMBER", USER_ID)
    VALUES (p_name, p_surname, p_number, p_user_id);
END;


CREATE OR REPLACE PROCEDURE GET_MEDICIN(
    p_medicin_id IN NUMBER,
    p_medicin OUT SYS_REFCURSOR)
IS
BEGIN
    OPEN p_medicin FOR
    SELECT * FROM medicins WHERE id = p_medicin_id;
END;


CREATE OR REPLACE PROCEDURE UPDATE_MEDICIN(
    p_medicin_id IN NUMBER,
    p_name IN VARCHAR2,
    p_instruction IN CLOB,
    p_warehouse_quantity IN NUMBER,
    p_drug_category IN VARCHAR2,
    p_price IN NUMBER,
    p_dose_unit IN VARCHAR2)
IS
BEGIN
    UPDATE medicins
    SET name = p_name,
        instruction = p_instruction,
        warehouse_quantity = p_warehouse_quantity,
        drug_category = p_drug_category,
        price = p_price,
        dose_unit = p_dose_unit
    WHERE id = p_medicin_id;
END;

CREATE OR REPLACE PROCEDURE DELETE_MEDICIN(
    p_medicin_id IN NUMBER)
IS
BEGIN
    DELETE FROM medicins WHERE id = p_medicin_id;
END;


-- sekwencja dla room 
CREATE SEQUENCE room_seq
START WITH 1
INCREMENT BY 1
NOCACHE;

CREATE OR REPLACE PROCEDURE ADD_ROOM(
    p_rnumber IN VARCHAR2,
    p_rlocation IN VARCHAR2,
    p_status IN VARCHAR2,
    p_type_room IN VARCHAR2)
IS
BEGIN
    INSERT INTO rooms (id, rnumber, rlocation, status, type_room)
    VALUES (room_seq.NEXTVAL, p_rnumber, p_rlocation, p_status, p_type_room);
END;




CREATE OR REPLACE PROCEDURE GET_ROOM(
    p_room_id IN NUMBER,
    p_room OUT SYS_REFCURSOR)
IS
BEGIN
    OPEN p_room FOR
    SELECT * FROM rooms WHERE id = p_room_id;
END;


CREATE OR REPLACE PROCEDURE UPDATE_ROOM(
    p_room_id IN NUMBER,
    p_rnumber IN VARCHAR2,
    p_rlocation IN VARCHAR2,
    p_status IN VARCHAR2,
    p_type_room IN VARCHAR2)
IS
BEGIN
    UPDATE rooms
    SET rnumber = p_rnumber,
        rlocation = p_rlocation,
        status = p_status,
        type_room = p_type_room
    WHERE id = p_room_id;
END;


CREATE OR REPLACE PROCEDURE DELETE_ROOM(
    p_room_id IN NUMBER)
IS
BEGIN
    DELETE FROM rooms WHERE id = p_room_id;
END;



