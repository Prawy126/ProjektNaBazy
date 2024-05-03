CREATE TABLE "lekarze" (
  "id_lekarza" integer NOT NULL PRIMARY KEY,
  "imie" varchar2(50) NOT NULL,
  "nazwisko" varchar2(50) NOT NULL,
  "specjalizacja" varchar2(50) NOT NULL,
  "numer_licencji" varchar2(50) NOT NULL,
  "id_konta" integer NOT NULL
);


CREATE TABLE "leki" (
  "id_leku" integer NOT NULL PRIMARY KEY,
  "nazwa_leku" varchar2(100) NOT NULL,
  "instrukcja" clob NOT NULL,
  "forma_leku" varchar2(50) NOT NULL,
  "ilosc_magazyn" integer,
  "kategoria_leku" varchar2(50) NOT NULL,
  "cena" float,
  "dawka_jednostka" varchar2(50) NOT NULL
);


CREATE TABLE "pacjenci" (
  "id_pacjentka" integer NOT NULL PRIMARY KEY,
  "imie" character varying(50) NOT NULL,
  "nazwisko" character varying(50) NOT NULL,
  "id_pielegniarki" integer,
  "id_konta" integer NOT NULL,
  "Czas_pobytu(DNI)" integer NOT NULL,
  "id_Sali" integer NOT NULL
);

CREATE TABLE "pielegniarki" (
  "id_pielegniarki" integer NOT NULL PRIMARY KEY,
  "imie" character varying(50) NOT NULL,
  "nazwisko" character varying(50) NOT NULL,
  "numer_identyfikacyjny" character varying(50) NOT NULL,
  "id_konta" integer NOT NULL
);

CREATE TABLE "przypisania_leki" (
  "id_pacjenta" integer NOT NULL,
  "id_leku" integer NOT NULL,
  "dawka" integer NOT NULL,
  "data_poczatkowa" date,
  "data_koncowa" date,
  "data_waznosci" date,
  "dostepnosc_szpital" CHAR(1)
);

CREATE TABLE "rodzaje_zabiegow" (
  "id_rodzaju" integer NOT NULL PRIMARY KEY,
  "nazwa_zabiegu" varchar2(100) NOT NULL,
  "opis_zabiegu" clob NOT NULL,
  "zalecenia_przed_zabiegiem" clob,
  "zalecenia_po_zabiegu" clob
);


CREATE TABLE "sale" (
  "id_sali" integer NOT NULL PRIMARY KEY,
  "numer_sali" character varying(10),
  "lokalizacja" character varying(100) NOT NULL,
  "status" character varying(50) NOT NULL,
  "typ_sali" character varying(50),
  "miejsca" integer NOT NULL
);

CREATE TABLE "statusy" (
  "nr_statusu" integer NOT NULL PRIMARY KEY,
  "status" character varying(50) NOT NULL,
  "opis_statusu" clob NOT NULL
);

CREATE TABLE "zabiegi" (
  "id_zabiegu" integer NOT NULL PRIMARY KEY,
  "id_rodzaju_zabiegu" integer NOT NULL,
  "id_sali" integer NOT NULL,
  "data_zabiegu" timestamp NOT NULL,
  "czas_trwania" interval DAY TO SECOND NOT NULL,
  "koszt" numeric(10,2) NOT NULL,
  "status" number(1) NOT NULL
);


CREATE TABLE "zabiegi_lekarze" (
  "id_zabiegu" integer NOT NULL,
  "id_lekarza" integer NOT NULL
);

CREATE TABLE "Konta" (
  "id_konta" integer NOT NULL PRIMARY KEY,
  "login" character varying(50) NOT NULL,
  "haslo" character varying(50) NOT NULL,
  "rodzaj_Konta" character varying(50) NOT NULL
);

CREATE TABLE "Zabiegi_Pielęgniraki" (
  "id_pielęgniarki" integer NOT NULL,
  "id_zabiegu" integer NOT NULL
);

CREATE TABLE "przypisania_leki_leki" (
  "przypisania_leki_id_leku" integer,
  "leki_id_leku" integer
);

CREATE TABLE "przypisania_leki_pacjenci" (
  "przypisania_leki_id_pacjenta" integer,
  "pacjenci_id_pacjentka" integer
);

CREATE TABLE "Zabiegi_Pielęgniraki_zabiegi" (
  "Zabiegi_Pielęgniraki_id_zabiegu" integer,
  "zabiegi_id_zabiegu" integer
);

CREATE TABLE "zabiegi_lekarze_zabiegi" (
  "zabiegi_lekarze_id_zabiegu" integer,
  "zabiegi_id_zabiegu" integer
);

CREATE TABLE "zabiegi_lekarze_lekarze" (
  "zabiegi_lekarze_id_lekarza" integer,
  "lekarze_id_lekarza" integer
);

COMMENT ON COLUMN "lekarze"."id_konta" IS '
Klucz obcy z tabeli Konta
';

COMMENT ON COLUMN "pacjenci"."id_pielegniarki" IS '
Klucz obcy z tabeli pilegniarki
';

COMMENT ON COLUMN "pacjenci"."id_konta" IS '
Klucz obcy z tabeli konta
';

COMMENT ON COLUMN "pacjenci"."id_Sali" IS '
Klucz obcy z tabeli sale
';

COMMENT ON COLUMN "pielegniarki"."id_konta" IS '
Klucz obcy z tabeli konta
';

COMMENT ON COLUMN "przypisania_leki"."id_pacjenta" IS '
Klucz obcy z tabeli pacjenci
';

COMMENT ON COLUMN "przypisania_leki"."id_leku" IS '
Klucz obcy z tabeli leki
';

COMMENT ON COLUMN "zabiegi"."id_rodzaju_zabiegu" IS '
Klucz obcy z tabeli rodzaj_zabiegow
';

COMMENT ON COLUMN "zabiegi_lekarze"."id_zabiegu" IS '
Klucz obcy z tabeli zabiegi
';

COMMENT ON COLUMN "zabiegi_lekarze"."id_lekarza" IS '
Klucz obcy z tabeli lekarze
';

COMMENT ON COLUMN "Zabiegi_Pielęgniraki"."id_pielęgniarki" IS '\undefined    Klucz obcy z tabeli pielegniarki
  ';

COMMENT ON COLUMN "Zabiegi_Pielęgniraki"."id_zabiegu" IS '
Klucz obcy z tabeli zabiegi
';

ALTER TABLE "pacjenci" ADD FOREIGN KEY ("id_konta") REFERENCES "Konta" ("id_konta");

ALTER TABLE "lekarze" ADD FOREIGN KEY ("id_konta") REFERENCES "Konta" ("id_konta");

ALTER TABLE "pielegniarki" ADD FOREIGN KEY ("id_konta") REFERENCES "Konta" ("id_konta");

ALTER TABLE "przypisania_leki_leki" ADD FOREIGN KEY ("przypisania_leki_id_leku") REFERENCES "przypisania_leki" ("id_leku"); //należy sprawdzić

ALTER TABLE "przypisania_leki_leki" ADD FOREIGN KEY ("leki_id_leku") REFERENCES "leki" ("id_leku");

ALTER TABLE "przypisania_leki_pacjenci" ADD FOREIGN KEY ("przypisania_leki_id_pacjenta") REFERENCES "przypisania_leki" ("id_pacjenta"); //również do sprawdzenia

ALTER TABLE "przypisania_leki_pacjenci" ADD FOREIGN KEY ("pacjenci_id_pacjentka") REFERENCES "pacjenci" ("id_pacjentka");

ALTER TABLE "Zabiegi_Pielęgniraki" ADD FOREIGN KEY ("id_pielęgniarki") REFERENCES "pielegniarki" ("id_pielegniarki");

ALTER TABLE "Zabiegi_Pielęgniraki_zabiegi" ADD FOREIGN KEY ("Zabiegi_Pielęgniraki_id_zabiegu") REFERENCES "Zabiegi_Pielęgniraki" ("id_zabiegu"); //również do sprawdzenia

ALTER TABLE "Zabiegi_Pielęgniraki_zabiegi" ADD FOREIGN KEY ("zabiegi_id_zabiegu") REFERENCES "zabiegi" ("id_zabiegu"); // również do sprawdzenia

ALTER TABLE "zabiegi_lekarze_zabiegi" ADD FOREIGN KEY ("zabiegi_lekarze_id_zabiegu") REFERENCES "zabiegi_lekarze" ("id_zabiegu"); // również do sprawdznenia

ALTER TABLE "zabiegi_lekarze_zabiegi" ADD FOREIGN KEY ("zabiegi_id_zabiegu") REFERENCES "zabiegi" ("id_zabiegu");

ALTER TABLE "zabiegi_lekarze_lekarze" ADD FOREIGN KEY ("zabiegi_lekarze_id_lekarza") REFERENCES "zabiegi_lekarze" ("id_lekarza"); // również do sprawdzenia

ALTER TABLE "zabiegi_lekarze_lekarze" ADD FOREIGN KEY ("lekarze_id_lekarza") REFERENCES "lekarze" ("id_lekarza");

ALTER TABLE "zabiegi" ADD FOREIGN KEY ("status") REFERENCES "statusy" ("nr_statusu");

ALTER TABLE "zabiegi" ADD FOREIGN KEY ("id_rodzaju_zabiegu") REFERENCES "rodzaje_zabiegow" ("id_rodzaju");

ALTER TABLE "zabiegi" ADD FOREIGN KEY ("id_sali") REFERENCES "sale" ("id_sali");

ALTER TABLE "pacjenci" ADD FOREIGN KEY ("id_Sali") REFERENCES "sale" ("id_sali");

ALTER TABLE "pacjenci" ADD FOREIGN KEY ("id_pielegniarki") REFERENCES "pielegniarki" ("id_pielegniarki");
