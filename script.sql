-- Insertion des matières pour Semestre 1
INSERT INTO public.matieres (reference, nom, coefficient, idsemestre , etat) VALUES
('INF101', 'Programmation procédurale', 7, 1 , 0),
('INF104', 'HTML et Introduction au Web', 5, 1 , 0),
('INF107', 'Informatique de Base', 4, 1 , 0),
('MTH101', 'Arithmétique et nombres', 4, 1 , 0),
('MTH102', 'Analyse mathématique', 6, 1 , 0),
('ORG101', 'Techniques de communication', 4, 1 , 0);


-- Insertion des matières pour Semestre 2
INSERT INTO public.matieres(reference, nom, coefficient, idsemestre , etat) VALUES
('INF102', 'Bases de données relationnelles', 5, 2 , 0),
('INF103', 'Bases de l’administration système', 5, 2 , 0),
('INF105', 'Maintenance matériel et logiciel', 4, 2 , 0),
('INF106', 'Compléments de programmation', 6, 2 , 0),
('MTH103', 'Calcul Vectoriel et Matriciel', 6, 2 , 0),
('MTH105', 'Probabilité et Statistique', 4, 2 , 0);

-- Insertion des matières pour Semestre 3
INSERT INTO public.matieres (reference, nom, coefficient, idsemestre , etat) VALUES
('INF201', 'Programmation orientée objet', 6, 3 , 0),
('INF202', 'Bases de données objets', 6, 3 , 0),
('INF203', 'Programmation système', 4, 3 , 0),
('INF208', 'Réseaux informatiques', 6, 3 , 0),
('MTH201', 'Méthodes numériques', 4, 3 , 0),
('ORG201', 'Bases de gestion', 4, 3 , 0);



-- Insertion des matières pour Semestre 4
INSERT INTO public.matieres (reference, nom, coefficient, idsemestre , etat) VALUES
('INF204', 'Système d’information géographique', 6, 4 , 1),
('INF205', 'Système d’information', 6, 4 , 1),
('INF206', 'Interface Homme/Machine', 6, 4 , 1),
('INF207', 'Eléments d’algorithmique', 6, 4 , 0),
('INF210', 'Mini-projet de développement', 10, 4 , 0),
('MTH204', 'Géométrie', 4, 4 , 1),
('MTH205', 'Equations différentielles', 4, 4 , 1),
('MTH206', 'Optimisation', 4, 4 , 1),
('MTH203', 'MAO', 4, 4 , 0);

-- Insertion des matières pour Semestre 5
INSERT INTO public.matieres (reference, nom, coefficient, idsemestre , etat) VALUES
('INF301', 'Architecture logicielle', 6, 5 , 0),
('INF304', 'Développement pour mobiles', 6, 5 , 0),
('INF307', 'Conception en modèle orienté objet', 6, 5, 0),
('ORG301', 'Gestion d’entreprise', 5, 5, 0),
('ORG302', 'Gestion de projets', 4, 5, 0),
('ORG303', 'Anglais pour les affaires', 3, 5, 0);


-- Insertion des matières pour Semestre 6
INSERT INTO public.matieres (reference, nom, coefficient, idsemestre , etat) VALUES
('INF310', 'Codage', 4, 6 , 0),
('INF313', 'Programmation avancée, frameworks', 6, 6 , 0),
('INF302', 'Technologies d’accès aux réseaux', 6, 6 , 1),
('INF303', 'Multimédia', 6, 6 , 1),
('INF316', 'Projet de développement', 10, 6 , 0),
('ORG304', 'Communication d’entreprise', 4, 6 , 0);
