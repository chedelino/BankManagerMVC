INSERT INTO Employe (IdEmp, NomEmp, PrenomEmp, LoginEmp, MdpEmp, Role) VALUES
(101, 'Dupont', 'Jean', 'jdupont', 'pass123', 'Directeur'),
(102, 'Martin', 'Sophie', 'smartin', 'pass456', 'Agent'),
(103, 'Leroy', 'Pierre', 'pleroy', 'pass789', 'Conseiller'),
(104, 'Moreau', 'Alice', 'amoreau', 'pass101', 'Agent'),
(105, 'Bernard', 'Luc', 'lbernard', 'pass112', 'Conseiller'),
(106, 'Petit', 'Julie', 'jpetit', 'pass131', 'Agent'),
(107, 'Robert', 'Michel', 'mrobert', 'pass415', 'Conseiller'),
(108, 'Richard', 'Nathalie', 'nrichard', 'pass161', 'Agent'),
(109, 'Durand', 'Thomas', 'tdurand', 'pass718', 'Conseiller'),
(110, 'Laurent', 'Caroline', 'claurent', 'pass192', 'Agent');

INSERT INTO Directeur (IdDirecteur, IdEmp, NomDirect, PrenomDirect, LoginDirect, MdpDirect) VALUES
(201, 101, 'Dupont', 'Jean', 'jdupont', 'pass123');

INSERT INTO Agent (IdAgent, IdEmp, NomAgent, PrenomAgent, LoginAgent, MdpAgent) VALUES
(301, 102, 'Martin', 'Sophie', 'smartin', 'pass456'),
(302, 104, 'Moreau', 'Alice', 'amoreau', 'pass101'),
(303, 106, 'Petit', 'Julie', 'jpetit', 'pass131'),
(304, 108, 'Richard', 'Nathalie', 'nrichard', 'pass161'),
(305, 110, 'Laurent', 'Caroline', 'claurent', 'pass192');

INSERT INTO Conseiller (IdConseiller, IdEmp, NomConseiller, PrenomConseiller, LoginConseiller, MdpConseiller) VALUES
(401, 103, 'Leroy', 'Pierre', 'pleroy', 'pass789'),
(402, 105, 'Bernard', 'Luc', 'lbernard', 'pass112'),
(403, 107, 'Robert', 'Michel', 'mrobert', 'pass415'),
(404, 109, 'Durand', 'Thomas', 'tdurand', 'pass718');

INSERT INTO Client (IdClient, IdConseiller, NomCl, PrenomCl, DateN, Adresse, NumTel, Mail, SituationFam) VALUES
(501, 401, 'Dubois', 'Marie', '1985-05-12', '12 Rue de Paris', '0612345678', 'marie.dubois@mail.com', 'Célibataire'),
(502, 402, 'Lambert', 'Paul', '1990-08-25', '34 Avenue Lyon', '0623456789', 'paul.lambert@mail.com', 'Marié'),
(503, 403, 'Roux', 'Lucie', '1982-11-30', '56 Boulevard Bordeaux', '0634567890', 'lucie.roux@mail.com', 'Divorcé'),
(504, 404, 'Blanc', 'Julien', '1975-03-17', '78 Rue Marseille', '0645678901', 'julien.blanc@mail.com', 'Célibataire'),
(505, 401, 'Noir', 'Sophie', '1995-07-22', '90 Avenue Nice', '0656789012', 'sophie.noir@mail.com', 'Marié'),
(506, 402, 'Vidal', 'Marc', '1988-09-14', '11 Rue Toulouse', '0667890123', 'marc.vidal@mail.com', 'Célibataire'),
(507, 403, 'Girard', 'Laura', '1992-12-05', '22 Boulevard Lille', '0678901234', 'laura.girard@mail.com', 'Marié'),
(508, 404, 'Perrot', 'Eric', '1980-04-19', '33 Rue Strasbourg', '0689012345', 'eric.perrot@mail.com', 'Divorcé'),
(509, 401, 'Lemoine', 'Chloé', '1998-01-28', '44 Avenue Nantes', '0690123456', 'chloe.lemoine@mail.com', 'Célibataire'),
(510, 402, 'Marchal', 'Antoine', '1970-06-15', '55 Rue Rennes', '0601234567', 'antoine.marchal@mail.com', 'Marié');

INSERT INTO Compte (IdCompte, TypeCompte) VALUES
(601, 'Courant'),
(602, 'Épargne'),
(603, 'Professionnel');

INSERT INTO Appartenir (IdCompte, IdClient, NumeroCompte, DateOuverture, Solde, MontantDec) VALUES
(601, 501, 1001, '2020-01-15', 1500, 500),
(602, 502, 1002, '2019-05-20', 3000, 1000),
(603, 503, 1003, '2021-03-10', 500, 200),
(601, 504, 1004, '2018-07-22', 2000, 700),
(602, 505, 1005, '2022-02-18', 4000, 1500),
(603, 506, 1006, '2020-11-30', 1000, 300),
(601, 507, 1007, '2019-09-12', 2500, 800),
(602, 508, 1008, '2021-06-25', 3500, 1200),
(603, 509, 1009, '2023-04-05', 700, 100),
(601, 510, 1010, '2017-12-10', 4500, 2000);

INSERT INTO Contrat (IdContrat, TypeContrat, TarifMensuel) VALUES
(701, 'Assurance Vie', 50),
(702, 'Prêt Immobilier', 200),
(703, 'Épargne Retraite', 100);

INSERT INTO Detenir (IdContrat, IdClient, NumeroContrat, DateDebut) VALUES
(701, 501, 'C1001', '2020-02-01'),
(702, 502, 'C1002', '2019-06-01'),
(703, 503, 'C1003', '2021-04-01'),
(701, 504, 'C1004', '2018-08-01'),
(702, 505, 'C1005', '2022-03-01'),
(703, 506, 'C1006', '2020-12-01'),
(701, 507, 'C1007', '2019-10-01'),
(702, 508, 'C1008', '2021-07-01'),
(703, 509, 'C1009', '2023-05-01'),
(701, 510, 'C1010', '2018-01-01');

INSERT INTO Motif (IdMotif, NomMotif) VALUES
(801, 'Ouverture Compte'),
(802, 'Demande Prêt'),
(803, 'Conseil Financier');

INSERT INTO Rendezvous (IdRdv, IdAgent, IdClient, DateRdv, HeureRdv, IdMotif) VALUES
(901, 301, 501, '2023-10-01', '10:00', 801),
(902, 302, 502, '2023-10-02', '11:00', 802),
(903, 303, 503, '2023-10-03', '14:00', 803),
(904, 304, 504, '2023-10-04', '15:00', 801),
(905, 305, 505, '2023-10-05', '16:00', 802),
(906, 301, 506, '2023-10-06', '09:00', 803),
(907, 302, 507, '2023-10-07', '10:30', 801),
(908, 303, 508, '2023-10-08', '11:30', 802),
(909, 304, 509, '2023-10-09', '13:00', 803),
(910, 305, 510, '2023-10-10', '14:30', 801);

INSERT INTO Piece (IdPiece, NomPiece) VALUES
(1001, 'Pièce Identité'),
(1002, 'Justificatif Domicile'),
(1003, 'Avis Imposition');


INSERT INTO Requerir (IdRequis, IdPiece, IdMotif) VALUES
(1101, 1001, 801),
(1102, 1002, 801),
(1103, 1003, 802),
(1104, 1001, 803),
(1105, 1002, 803);