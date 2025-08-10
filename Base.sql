CREATE SCHEMA IF NOT EXISTS "public";

CREATE  TABLE "public"."admin" (
	id                   serial  NOT NULL  ,
	email                varchar  NOT NULL  ,
	pwd                  varchar    ,
	CONSTRAINT pk_tbl PRIMARY KEY ( id )
 );

CREATE TABLE  "public".promotions (
	idpromotion          serial  NOT NULL,
	nom                  varchar  NOT NULL,
	datefin              timestamp  NOT NULL DEFAULT 0,
	datedebut            timestamp  NOT NULL DEFAULT 0,
	created_at           timestamp,
	updated_at           timestamp,
	CONSTRAINT pk_promotions PRIMARY KEY (idpromotion)
);

ALTER TABLE "public".promotions
ALTER COLUMN datefin SET DEFAULT null;

ALTER TABLE "public".promotions
ALTER COLUMN datedebut SET DEFAULT null;

CREATE  TABLE "public".semestres (
	idsemestre           serial  NOT NULL  ,
	nom                  varchar    ,
	created_at           timestamp    ,
	updated_at           timestamp    ,
	CONSTRAINT pk_semestres PRIMARY KEY ( idsemestre )
 );

CREATE  TABLE "public".etudiants (
	idetudiant           serial  NOT NULL  ,
	idpromotion          integer    ,
	nom                  varchar  NOT NULL  ,
	prenom               varchar  NOT NULL  ,
	dtn                  date  NOT NULL DEFAULT 0 ,
	numetu               varchar  NOT NULL  ,
	created_at           timestamp    ,
	updated_at           timestamp    ,
	CONSTRAINT pk_etudiants PRIMARY KEY ( idetudiant )
 );

 CREATE TABLE "public".categories (
    id serial NOT NULL,
    nom varchar NOT NULL,
    idsemestre integer NOT NULL,
    created_at timestamp,
    updated_at timestamp,
    CONSTRAINT pk_categories PRIMARY KEY (id),
    CONSTRAINT fk_categories_semestre FOREIGN KEY (idsemestre) REFERENCES "public".semestres (idsemestre)
);


 ALTER TABLE "public".etudiants
ALTER COLUMN dtn SET DEFAULT null;

CREATE  TABLE "public".etudiantsemestre (
	id                   serial  NOT NULL  ,
	idetudiant           integer  NOT NULL  ,
	idsemestre           integer  NOT NULL  ,
	"date"               date  NOT NULL  ,
	created_at           timestamp    ,
	updated_at           timestamp    ,
	CONSTRAINT pk_etudiantsemestre PRIMARY KEY ( id )
 );
  ALTER TABLE "public".etudiantsemestre
ALTER COLUMN date SET DEFAULT null;

CREATE  TABLE "public".matieres (
	idmatiere            serial  NOT NULL  ,
	reference            varchar  NOT NULL  ,
	nom                  varchar  NOT NULL  ,
	coefficient          integer  NOT NULL  ,
	idsemestre           integer  NOT NULL  ,
	created_at           timestamp    ,
	updated_at           timestamp    ,
	CONSTRAINT pk_matieres PRIMARY KEY ( idmatiere )
 );

CREATE  TABLE "public".notes (
	idnote               serial  NOT NULL  ,
	idetudiant           integer  NOT NULL  ,
	idmatiere            integer  NOT NULL  ,
	idsemestre           integer  NOT NULL  ,
	note                 numeric  NOT NULL  ,
	created_at           timestamp    ,
	updated_at           timestamp    ,
	CONSTRAINT pk_notes PRIMARY KEY ( idnote )
 );

 ALTER TABLE "public".notes
ALTER COLUMN note TYPE numeric;


ALTER TABLE "public".etudiants ADD CONSTRAINT fk_etudiants_promotions FOREIGN KEY ( idpromotion ) REFERENCES "public".promotions( idpromotion );

ALTER TABLE "public".etudiantsemestre ADD CONSTRAINT fk_etudiantsemestre_semestres FOREIGN KEY ( idsemestre ) REFERENCES "public".semestres( idsemestre );

ALTER TABLE "public".etudiantsemestre ADD CONSTRAINT fk_etudiantsemestre_etudiants FOREIGN KEY ( idetudiant ) REFERENCES "public".etudiants( idetudiant );

ALTER TABLE "public".matieres ADD CONSTRAINT fk_matieres_semestres FOREIGN KEY ( idsemestre ) REFERENCES "public".semestres( idsemestre );

ALTER TABLE "public".notes ADD CONSTRAINT fk_notes_matieres FOREIGN KEY ( idmatiere ) REFERENCES "public".matieres( idmatiere );

ALTER TABLE "public".notes ADD CONSTRAINT fk_notes_semestres FOREIGN KEY ( idsemestre ) REFERENCES "public".semestres( idsemestre );

ALTER TABLE "public".notes ADD CONSTRAINT fk_notes_etudiants FOREIGN KEY ( idetudiant ) REFERENCES "public".etudiants( idetudiant );

//VieW//
CREATE VIEW "public".v_maxnotes AS
SELECT n.idmatiere, n.idetudiant, n.note, n.idsemestre
FROM "public".notes n
WHERE n.note = (
    SELECT MAX(note)
    FROM "public".notes
    WHERE idmatiere = n.idmatiere
);
CREATE OR REPLACE VIEW "public".v_maxnotes AS
SELECT
n.idsemestre,
e.idetudiant,
e.numetu,
m.idmatiere, m.reference, m.nom,
MAX(n.note),
e.nom
FROM
notes n
JOIN matieres m ON
m.idmatiere = n.idmatiere
JOIN etudiants e ON
e.idetudiant = n.idetudiant
GROUP BY n.idetudiant, m.idmatiere, n.idsemestre, e.idetudiant
ORDER BY n.idsemestre, e.idetudiant


SELECT
    n.idsemestre AS idsemestre,
    e.idetudiant,
    e.numetu,
    m.idmatiere,
    m.coefficient,
    m.reference,
    m.nom AS matiere,
    COALESCE(MAX(n.note), 0) AS note,
    e.nom AS etudiant
FROM
    etudiants e
CROSS JOIN
    matieres m
LEFT JOIN
    notes n ON e.idetudiant = n.idetudiant AND m.idmatiere = n.idmatiere
GROUP BY m.idmatiere, e.idetudiant, n.idsemestre
ORDER BY
    n.idsemestre,e.idetudiant, m.idmatiere;


CREATE OR REPLACE VIEW public.v_maxnotes AS
SELECT
    m.idsemestre AS idsemestre,
    e.idetudiant,
    e.numetu,
    m.idmatiere,
    m.coefficient,
    m.reference,
    m.nom AS matiere,
    COALESCE(MAX(n.note), 0) AS note,
    e.nom AS etudiant
FROM
    etudiants e
CROSS JOIN
    matieres m
LEFT JOIN
    notes n ON e.idetudiant = n.idetudiant AND m.idmatiere = n.idmatiere
GROUP BY
    m.idmatiere, e.idetudiant, m.idsemestre
ORDER BY
    m.idsemestre, e.idetudiant, m.idmatiere;


CREATE OR REPLACE VIEW public.v_notezero AS
SELECT
    e.idetudiant,
    m.idmatiere,
    0 AS note
FROM
    matieres m,
    etudiants e;
    /////VVVVVVVVVVVVVVVVVVVVVVV



CREATE OR REPLACE VIEW public.v_notewithnotezro AS
SELECT
    idetudiant,
    idmatiere,
    note
FROM
    public.notes
UNION
SELECT
    idetudiant,
    idmatiere,
    note
FROM
    public.v_notezero;


/////////////////////AVERAGE NOTE/////////////VIEW TENA MIASA BE BE EEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEE///////////
CREATE OR REPLACE VIEW public.v_avgnotes AS
WITH avgnotes AS (
    SELECT
        m.idsemestre AS idsemestre,
        m.idmatiere AS idmatiere,
        m.coefficient,
        m.reference,
        m.nom AS matiere,
        m.etat AS etat,
        e.idetudiant,
        e.numetu,
        e.nom AS etudiant,
        e.prenom AS prenometudiant,
        mo.groupe AS groupe,
        ROUND(AVG(n.note), 2) AS note,  -- Calculer la moyenne et arrondir à 2 décimales
        s.nom AS semestre
    FROM
        etudiants e
        JOIN v_notewithnotezro n ON e.idetudiant = n.idetudiant
        JOIN matieres m ON n.idmatiere = m.idmatiere
        JOIN semestres s ON m.idsemestre = s.idsemestre
        LEFT JOIN matieroption mo ON m.reference = mo.codematiere
    GROUP BY
        e.idetudiant,
        m.idsemestre,
        m.idmatiere,
        m.coefficient,
        m.reference,
        m.nom,
        m.etat,
        s.nom,
        mo.groupe
)
SELECT
    idsemestre,
    semestre,
    idetudiant,
    etudiant,
    prenometudiant,
    numetu,
    idmatiere,
    matiere,
    coefficient,
    note,  -- La note est déjà arrondie ici
    reference,
    etat,
    groupe
FROM
    avgnotes
WHERE
    etat = 0
    OR (etat = 1 AND (
        groupe IS NULL OR
        idmatiere = (
            SELECT MIN(idmatiere)
            FROM avgnotes an
            WHERE an.groupe = avgnotes.groupe
            AND an.note = avgnotes.note
            AND an.numetu = avgnotes.numetu
        )
    ))
ORDER BY
    idetudiant,
    idsemestre,
    idmatiere ASC;

//////////////////////////////////////////////////////////////////////MAKA MAX NOTE///////////////////////
CREATE OR REPLACE VIEW public.v_newmaxnotes AS
WITH avgnotes AS (
    SELECT
        m.idsemestre AS idsemestre,
        m.idmatiere AS idmatiere,
        m.coefficient,
        m.reference,
        m.nom AS matiere,
        m.etat AS etat,
        e.idetudiant,
        e.numetu,
        e.nom AS etudiant,
        e.prenom AS prenometudiant,
        mo.groupe AS groupe,
        MAX(n.note) as note,
        s.nom AS semestre
    FROM
        etudiants e
        JOIN v_notewithnotezro n ON e.idetudiant = n.idetudiant
        JOIN matieres m ON n.idmatiere = m.idmatiere
        JOIN semestres s ON m.idsemestre = s.idsemestre
        LEFT JOIN matieroption mo ON m.reference = mo.codematiere
    GROUP BY
        e.idetudiant,
        m.idsemestre,
        m.idmatiere,
        m.coefficient,
        m.reference,
        m.nom,
        m.etat,
        s.nom,
        mo.groupe
)
SELECT
    idsemestre,
    semestre,
    idetudiant,
    etudiant,
    prenometudiant,
    numetu,
    idmatiere,
    matiere,
    coefficient,
    note,  -- La note est déjà arrondie ici
    reference,
    etat,
    groupe
FROM
    avgnotes
WHERE
    etat = 0
    OR (etat = 1 AND (
        groupe IS NULL OR
        idmatiere = (
            SELECT MIN(idmatiere)
            FROM avgnotes an
            WHERE an.groupe = avgnotes.groupe
            AND an.note = avgnotes.note
            AND an.numetu = avgnotes.numetu
        )
    ))
ORDER BY
    idetudiant,
    idsemestre,
    idmatiere ASC;

/////////////////////////////////New View////////////////////////

CREATE OR REPLACE VIEW public.v_ensembletable AS
SELECT
    et.idetudiant,
    et.nom AS nom,
    et.prenom AS prenom,
    et.numetu AS etu,
    et.genre,
    et.idpromotion,
    s.idsemestre,
    s.nom AS semestre,
    m.idmatiere,
    m.reference AS reference,
    m.nom AS matiere,
    m.coefficient AS coefficient,
    m.etat AS etat,
    p.nom AS promotion,
    MAX(n.note) AS note,
    c.idcategorie,
    c.nom AS categorie
FROM
    etudiants et
    JOIN etudiantsemestre es ON et.idetudiant = es.idetudiant
    JOIN semestres s ON es.idsemestre = s.idsemestre
    JOIN categories c ON c.idsemestre = s.idsemestre
    JOIN matieres m ON m.idsemestre = s.idsemestre
    JOIN v_notewithnotezro n ON et.idetudiant = n.idetudiant AND m.idmatiere = n.idmatiere
    JOIN matieroption mo ON m.reference = mo.codematiere
    JOIN promotions p ON et.idpromotion = p.idpromotion
GROUP BY
    et.idetudiant,
    et.nom,
    et.prenom,
    et.numetu,
    et.genre,
    et.idpromotion,
    s.idsemestre,
    s.nom,
    m.idmatiere,
    m.reference,
    m.nom,
    m.coefficient,
    m.etat,
    p.idpromotion,
    p.nom,
	c.idcategorie,
    c.nom
ORDER BY
    et.idetudiant,
    s.idsemestre,
	c.idcategorie,
    m.idmatiere;

////////////////////////////////////////////////////////////////////////////////////////////
CREATE OR REPLACE VIEW public.v_note AS
SELECT
    e.idetudiant,
    e.nom AS nom,
    e.prenom AS prenom,
    e.numetu,
    m.idmatiere,
    m.nom AS matiere_nom,
    m.reference,
    m.coefficient,
    s.idsemestre,
    s.nom AS semestre_nom,
    n.note
FROM
    public.etudiants e
JOIN
    public.v_notewithnotezro n ON e.idetudiant = n.idetudiant
JOIN
    public.matieres m ON n.idmatiere = m.idmatiere
JOIN
    public.semestres s ON m.idsemestre = s.idsemestre
ORDER BY
    e.idetudiant,
    s.idsemestre,
    m.idmatiere;

SELECT * from v_note WHERE numetu = 'ETU000110' AND idsemestre = 4;






