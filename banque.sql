-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Mar 21, 2025 at 08:43 AM
-- Server version: 5.7.39
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `banque`
--

-- --------------------------------------------------------

--
-- Table structure for table `Agent`
--

CREATE TABLE `Agent` (
  `IdAgent` int(11) NOT NULL,
  `IdEmp` int(11) DEFAULT NULL,
  `NomAgent` varchar(32) NOT NULL,
  `PrenomAgent` varchar(32) NOT NULL,
  `LoginAgent` varchar(32) DEFAULT NULL,
  `MdpAgent` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Agent`
--

INSERT INTO `Agent` (`IdAgent`, `IdEmp`, `NomAgent`, `PrenomAgent`, `LoginAgent`, `MdpAgent`) VALUES
(301, 102, 'Martin', 'Sophie', 'smartin', 'pass456'),
(302, 104, 'Moreau', 'Alice', 'amoreau', 'pass101'),
(303, 106, 'Petit', 'Julie', 'jpetit', 'pass131'),
(304, 108, 'Richard', 'Nathalie', 'nrichard', 'pass161'),
(305, 110, 'Laurent', 'Caroline', 'claurent', 'pass192'),
(306, 112, 'Paul', 'Lake', NULL, NULL),
(307, 187, 'Jean', 'Louise', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `Appartenir`
--

CREATE TABLE `Appartenir` (
  `IdCompte` int(11) NOT NULL,
  `IdClient` int(11) NOT NULL,
  `NumeroCompte` int(11) NOT NULL,
  `DateOuverture` date NOT NULL,
  `Solde` int(11) NOT NULL DEFAULT '0',
  `MontantDec` int(11) NOT NULL DEFAULT '100'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Appartenir`
--

INSERT INTO `Appartenir` (`IdCompte`, `IdClient`, `NumeroCompte`, `DateOuverture`, `Solde`, `MontantDec`) VALUES
(601, 501, 1001, '2020-01-15', 51000, 615),
(601, 504, 1004, '2018-07-22', 2000, 700),
(601, 507, 1007, '2019-09-12', 2500, 800),
(601, 510, 1010, '2017-12-10', 4500, 510),
(602, 502, 1002, '2019-05-20', 3000, 1000),
(602, 505, 1005, '2022-02-18', 4000, 1500),
(602, 508, 1008, '2021-06-25', 3500, 1200),
(603, 501, 986544, '2025-03-19', 200, 100),
(603, 503, 1003, '2021-03-10', 500, 203),
(603, 506, 1006, '2020-11-30', 1000, 300),
(604, 510, 9822, '2025-03-13', 120, 100);

-- --------------------------------------------------------

--
-- Table structure for table `Client`
--

CREATE TABLE `Client` (
  `IdClient` int(11) NOT NULL,
  `IdConseiller` int(11) DEFAULT NULL,
  `NomCl` varchar(32) NOT NULL,
  `PrenomCl` varchar(32) NOT NULL,
  `DateN` date NOT NULL,
  `Adresse` varchar(32) NOT NULL,
  `NumTel` varchar(32) NOT NULL,
  `Mail` varchar(32) NOT NULL,
  `SituationFam` varchar(32) DEFAULT NULL,
  `DateInscription` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Client`
--

INSERT INTO `Client` (`IdClient`, `IdConseiller`, `NomCl`, `PrenomCl`, `DateN`, `Adresse`, `NumTel`, `Mail`, `SituationFam`, `DateInscription`) VALUES
(501, 401, 'Dubois', 'Marie', '1985-05-12', '12 Rue de Pariss', '0612345678', 'marie.dubois@mail.com', 'Divorcé', '2023-01-01'),
(502, 402, 'Lambert', 'Paul', '1990-08-25', '34 Avenue Lyon', '0623456789', 'paul.lambert@mail.com', 'Marié', '2023-02-15'),
(503, 403, 'Roux', 'Lucie', '1982-11-30', '56 Boulevard Bordeaux', '0634567890', 'lucie.roux@mail.com', 'Divorcé', '2023-03-10'),
(504, 404, 'Blanc', 'Julien', '1975-03-17', '78 Rue Marseille', '0645678901', 'julien.blanc@mail.com', 'Célibataire', '2023-04-22'),
(505, 401, 'Noir', 'Sophie', '1995-07-22', '90 Avenue Nice', '0656789012', 'sophie.noir@mail.com', 'Marié', '2023-05-05'),
(506, 402, 'Vidal', 'Marc', '1988-09-14', '11 Rue Toulouse', '0667890123', 'marc.vidal@mail.com', 'Célibataire', '2023-06-18'),
(507, 403, 'Girard', 'Laura', '1992-12-05', '22 Boulevard Lille', '0678901234', 'laura.girard@mail.com', 'Marié', '2023-07-30'),
(508, 404, 'Perrot', 'Eric', '1980-04-19', '33 Rue Strasbourg', '0689012345', 'eric.perrot@mail.com', 'Divorcé', '2023-08-12'),
(509, 401, 'Lemoine', 'Chloé', '1998-01-28', '44 Avenue Nantes', '0690123456', 'chloe.lemoine@mail.com', 'Célibataire', '2023-09-25'),
(510, 402, 'Marchal', 'Antoine', '1970-06-15', '55 Rue Rennes', '0601234567', 'antoine.marchal@mail.com', 'Marié', '2023-10-08'),
(512, 401, 'kJahe', 'Vrskrisal', '2025-03-07', '12 Rue de Pariss', '043484532', 'Vrskrisal@site.com', 'marie', '2025-03-03'),
(517, 402, 'Pop', 'Prisal', '2025-03-03', '12 Rue de Orléans', '093484532', 'pop@site.com', 'celibataire', '2025-03-19');

-- --------------------------------------------------------

--
-- Table structure for table `Compte`
--

CREATE TABLE `Compte` (
  `IdCompte` int(11) NOT NULL,
  `TypeCompte` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Compte`
--

INSERT INTO `Compte` (`IdCompte`, `TypeCompte`) VALUES
(601, 'Compte Courant'),
(602, 'Épargne'),
(603, 'Professionnel'),
(604, 'Joint');

-- --------------------------------------------------------

--
-- Table structure for table `Conseiller`
--

CREATE TABLE `Conseiller` (
  `IdConseiller` int(11) NOT NULL,
  `IdEmp` int(11) DEFAULT NULL,
  `NomConseiller` varchar(32) NOT NULL,
  `PrenomConseiller` varchar(32) NOT NULL,
  `LoginConseiller` varchar(32) DEFAULT NULL,
  `MdpConseiller` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Conseiller`
--

INSERT INTO `Conseiller` (`IdConseiller`, `IdEmp`, `NomConseiller`, `PrenomConseiller`, `LoginConseiller`, `MdpConseiller`) VALUES
(401, 103, 'Leroy', 'Pierre', 'pleroy', 'pass789'),
(402, 105, 'Bernard', 'Luc', 'lbernard', 'pass112'),
(403, 107, 'Robert', 'Michel', 'mrobert', 'pass415'),
(404, 109, 'Durand', 'Thomas', 'tdurand', 'pass718');

-- --------------------------------------------------------

--
-- Table structure for table `Contrat`
--

CREATE TABLE `Contrat` (
  `IdContrat` int(11) NOT NULL,
  `TypeContrat` varchar(32) NOT NULL,
  `TarifMensuel` int(11) NOT NULL DEFAULT '100'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Contrat`
--

INSERT INTO `Contrat` (`IdContrat`, `TypeContrat`, `TarifMensuel`) VALUES
(321, 'Assurance H', 100),
(701, 'Assurance viee', 50),
(702, 'Prêt Immobilier', 200),
(703, 'Épargne Retraite', 100),
(704, 'Assurance auto', 100);

-- --------------------------------------------------------

--
-- Table structure for table `Detenir`
--

CREATE TABLE `Detenir` (
  `IdContrat` int(11) NOT NULL,
  `IdClient` int(11) NOT NULL,
  `NumeroContrat` varchar(32) NOT NULL,
  `DateDebut` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Detenir`
--

INSERT INTO `Detenir` (`IdContrat`, `IdClient`, `NumeroContrat`, `DateDebut`) VALUES
(321, 505, '5431', '2025-03-11'),
(321, 505, '9875', '2025-03-18'),
(321, 507, '8722', '2025-03-10'),
(701, 501, 'C1001', '2020-02-01'),
(701, 504, 'C1004', '2018-08-01'),
(701, 507, 'C1007', '2019-10-01'),
(701, 510, 'C1010', '2018-01-01'),
(702, 502, 'C1002', '2019-06-01'),
(702, 505, 'C1005', '2022-03-01'),
(702, 508, 'C1008', '2021-07-01'),
(703, 503, 'C1003', '2021-04-01'),
(703, 506, 'C1006', '2020-12-01');

-- --------------------------------------------------------

--
-- Table structure for table `Directeur`
--

CREATE TABLE `Directeur` (
  `IdDirecteur` int(11) NOT NULL,
  `IdEmp` int(11) DEFAULT NULL,
  `NomDirect` varchar(32) NOT NULL,
  `PrenomDirect` varchar(32) NOT NULL,
  `LoginDirect` varchar(32) DEFAULT NULL,
  `MdpDirect` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Directeur`
--

INSERT INTO `Directeur` (`IdDirecteur`, `IdEmp`, `NomDirect`, `PrenomDirect`, `LoginDirect`, `MdpDirect`) VALUES
(201, 101, 'Dupont', 'Jean', 'jdupont', 'pass123'),
(202, 111, 'Delino', 'Chérubin', 'Del345', 'pass456'),
(203, 123, 'Pop', 'Karl', 'pop123', 'pass456'),
(204, 132, 'May', 'Djune', 'May12345', 'pass456');

-- --------------------------------------------------------

--
-- Table structure for table `Employe`
--

CREATE TABLE `Employe` (
  `IdEmp` int(11) NOT NULL,
  `NomEmp` varchar(32) NOT NULL,
  `PrenomEmp` varchar(32) NOT NULL,
  `LoginEmp` varchar(32) DEFAULT NULL,
  `MdpEmp` varchar(32) DEFAULT NULL,
  `Role` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Employe`
--

INSERT INTO `Employe` (`IdEmp`, `NomEmp`, `PrenomEmp`, `LoginEmp`, `MdpEmp`, `Role`) VALUES
(101, 'Dupont', 'Jean', 'jdupont', 'pass123', 'Directeur'),
(102, 'Martin', 'Sophie', 'smartin', 'pass456', 'Agent'),
(103, 'Leroy', 'Pierre', 'pleroy', 'pass789', 'Conseiller'),
(104, 'Moreau', 'Alice', 'amoreau', 'pass101', 'Agent'),
(105, 'Bernard', 'Luc', 'lbernard', 'pass112', 'Conseiller'),
(106, 'Petit', 'Julie', 'jpetit', 'pass131', 'Agent'),
(107, 'Robert', 'Michel', 'mrobert', 'pass415', 'Conseiller'),
(108, 'Richard', 'Nathalie', 'nrichard', 'pass161', 'Agent'),
(109, 'Durand', 'Thomas', 'tdurand', 'pass718', 'Conseiller'),
(110, 'Laurent', 'Caroline', 'claurent', 'pass192', 'Agent'),
(111, 'Delino', 'Chérubin', 'Del345', 'pass456', 'Directeur'),
(112, 'Paul', 'Lake', NULL, NULL, 'Agent'),
(119, 'Jeans', 'Loike', 'jlo11', '12345', 'conseiller'),
(123, 'Pop', 'Karl', 'pop123', 'pass456', 'Directeur'),
(132, 'May', 'Djune', 'May12345', 'pass456', 'Directeur'),
(187, 'Jean', 'Louise', NULL, NULL, 'Agent');

-- --------------------------------------------------------

--
-- Table structure for table `Motif`
--

CREATE TABLE `Motif` (
  `IdMotif` int(11) NOT NULL,
  `NomMotif` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Motif`
--

INSERT INTO `Motif` (`IdMotif`, `NomMotif`) VALUES
(801, 'Compte Courant'),
(802, 'Épargne'),
(803, 'Professionnel'),
(804, 'Assurance Vie'),
(805, 'Prêt Immobilier'),
(806, 'Épargne Retraite'),
(810, 'Assurance H'),
(811, 'Assurance auto'),
(812, 'Joint'),
(813, 'Taches administratives'),
(814, 'Autres');

-- --------------------------------------------------------

--
-- Table structure for table `Piece`
--

CREATE TABLE `Piece` (
  `IdPiece` int(11) NOT NULL,
  `NomPiece` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Piece`
--

INSERT INTO `Piece` (`IdPiece`, `NomPiece`) VALUES
(1001, 'Pièce Identité'),
(1002, 'Justificatif Domicile'),
(1003, 'Avis Imposition'),
(1101, 'Titre de sejour');

-- --------------------------------------------------------

--
-- Table structure for table `Rendezvous`
--

CREATE TABLE `Rendezvous` (
  `IdRdv` int(11) NOT NULL,
  `IdAgent` int(11) DEFAULT NULL,
  `IdClient` int(11) DEFAULT NULL,
  `DateRdv` date NOT NULL,
  `HeureRdv` varchar(32) NOT NULL,
  `IdMotif` int(11) DEFAULT NULL,
  `IdConseiller` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Rendezvous`
--

INSERT INTO `Rendezvous` (`IdRdv`, `IdAgent`, `IdClient`, `DateRdv`, `HeureRdv`, `IdMotif`, `IdConseiller`) VALUES
(901, 301, 501, '2025-03-03', '10:00', 801, NULL),
(902, 302, 502, '2025-03-04', '11:00', 802, NULL),
(903, 303, 503, '2025-03-05', '14:00', 803, NULL),
(904, 304, 504, '2025-03-06', '15:00', 801, NULL),
(905, 305, 505, '2025-03-07', '16:00', 802, NULL),
(906, 301, 506, '2025-03-10', '09:00', 803, NULL),
(907, 302, 507, '2025-03-11', '10:00', 801, NULL),
(908, 303, 508, '2025-03-12', '11:00', 802, NULL),
(909, 304, 509, '2025-03-13', '13:00', 803, NULL),
(910, 305, 510, '2025-03-14', '14:00', 801, NULL),
(911, 302, 506, '2025-03-17', '12:00', 802, NULL),
(912, 303, 508, '2025-03-18', '09:00', 801, NULL),
(913, 302, 509, '2025-03-19', '10:00', 801, NULL),
(914, 303, 512, '2025-03-20', '12:00', 802, NULL),
(915, 303, 517, '2025-03-21', '09:00', 812, NULL),
(916, NULL, NULL, '2025-03-24', '10:00', 813, 401),
(917, NULL, NULL, '2025-03-25', '11:00', 814, 401),
(918, NULL, NULL, '2025-03-20', '14:00', 813, 401);

-- --------------------------------------------------------

--
-- Table structure for table `Requerir`
--

CREATE TABLE `Requerir` (
  `IdRequis` int(11) NOT NULL,
  `IdPiece` int(11) DEFAULT NULL,
  `IdMotif` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Requerir`
--

INSERT INTO `Requerir` (`IdRequis`, `IdPiece`, `IdMotif`) VALUES
(1101, 1001, 801),
(1102, 1002, 801),
(1103, 1003, 802),
(1104, 1001, 803),
(1105, 1002, 803),
(1107, 1101, 812);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Agent`
--
ALTER TABLE `Agent`
  ADD PRIMARY KEY (`IdAgent`),
  ADD KEY `fk_Agent_Employe` (`IdEmp`);

--
-- Indexes for table `Appartenir`
--
ALTER TABLE `Appartenir`
  ADD PRIMARY KEY (`IdCompte`,`IdClient`,`NumeroCompte`),
  ADD KEY `fk_Appartenir_Client` (`IdClient`);

--
-- Indexes for table `Client`
--
ALTER TABLE `Client`
  ADD PRIMARY KEY (`IdClient`),
  ADD KEY `fk_Client_Conseiller` (`IdConseiller`);

--
-- Indexes for table `Compte`
--
ALTER TABLE `Compte`
  ADD PRIMARY KEY (`IdCompte`);

--
-- Indexes for table `Conseiller`
--
ALTER TABLE `Conseiller`
  ADD PRIMARY KEY (`IdConseiller`),
  ADD KEY `fk_Conseiller_Employe` (`IdEmp`);

--
-- Indexes for table `Contrat`
--
ALTER TABLE `Contrat`
  ADD PRIMARY KEY (`IdContrat`);

--
-- Indexes for table `Detenir`
--
ALTER TABLE `Detenir`
  ADD PRIMARY KEY (`IdContrat`,`IdClient`,`NumeroContrat`),
  ADD KEY `fk_Detenir_Client` (`IdClient`);

--
-- Indexes for table `Directeur`
--
ALTER TABLE `Directeur`
  ADD PRIMARY KEY (`IdDirecteur`),
  ADD KEY `fk_Directeur_Employe` (`IdEmp`);

--
-- Indexes for table `Employe`
--
ALTER TABLE `Employe`
  ADD PRIMARY KEY (`IdEmp`);

--
-- Indexes for table `Motif`
--
ALTER TABLE `Motif`
  ADD PRIMARY KEY (`IdMotif`);

--
-- Indexes for table `Piece`
--
ALTER TABLE `Piece`
  ADD PRIMARY KEY (`IdPiece`);

--
-- Indexes for table `Rendezvous`
--
ALTER TABLE `Rendezvous`
  ADD PRIMARY KEY (`IdRdv`),
  ADD KEY `fk_Rendezvous_Agents` (`IdAgent`),
  ADD KEY `fk_Rendezvous_Client` (`IdClient`),
  ADD KEY `fk_Rendezvous_Motif` (`IdMotif`),
  ADD KEY `fk_Rendezvous_Conseiller` (`IdConseiller`);

--
-- Indexes for table `Requerir`
--
ALTER TABLE `Requerir`
  ADD PRIMARY KEY (`IdRequis`),
  ADD KEY `fk_Requerir_Piece` (`IdPiece`),
  ADD KEY `fk_Requerir_Motif` (`IdMotif`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Agent`
--
ALTER TABLE `Agent`
  MODIFY `IdAgent` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=308;

--
-- AUTO_INCREMENT for table `Client`
--
ALTER TABLE `Client`
  MODIFY `IdClient` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=518;

--
-- AUTO_INCREMENT for table `Compte`
--
ALTER TABLE `Compte`
  MODIFY `IdCompte` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=605;

--
-- AUTO_INCREMENT for table `Conseiller`
--
ALTER TABLE `Conseiller`
  MODIFY `IdConseiller` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=405;

--
-- AUTO_INCREMENT for table `Contrat`
--
ALTER TABLE `Contrat`
  MODIFY `IdContrat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=705;

--
-- AUTO_INCREMENT for table `Directeur`
--
ALTER TABLE `Directeur`
  MODIFY `IdDirecteur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=205;

--
-- AUTO_INCREMENT for table `Employe`
--
ALTER TABLE `Employe`
  MODIFY `IdEmp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=188;

--
-- AUTO_INCREMENT for table `Motif`
--
ALTER TABLE `Motif`
  MODIFY `IdMotif` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=815;

--
-- AUTO_INCREMENT for table `Piece`
--
ALTER TABLE `Piece`
  MODIFY `IdPiece` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1102;

--
-- AUTO_INCREMENT for table `Rendezvous`
--
ALTER TABLE `Rendezvous`
  MODIFY `IdRdv` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=919;

--
-- AUTO_INCREMENT for table `Requerir`
--
ALTER TABLE `Requerir`
  MODIFY `IdRequis` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1108;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Agent`
--
ALTER TABLE `Agent`
  ADD CONSTRAINT `fk_Agent_Employe` FOREIGN KEY (`IdEmp`) REFERENCES `Employe` (`IdEmp`);

--
-- Constraints for table `Appartenir`
--
ALTER TABLE `Appartenir`
  ADD CONSTRAINT `fk_Appartenir_Client` FOREIGN KEY (`IdClient`) REFERENCES `Client` (`IdClient`),
  ADD CONSTRAINT `fk_Appartenir_Compte` FOREIGN KEY (`IdCompte`) REFERENCES `Compte` (`IdCompte`);

--
-- Constraints for table `Client`
--
ALTER TABLE `Client`
  ADD CONSTRAINT `fk_Client_Conseiller` FOREIGN KEY (`IdConseiller`) REFERENCES `Conseiller` (`IdConseiller`);

--
-- Constraints for table `Conseiller`
--
ALTER TABLE `Conseiller`
  ADD CONSTRAINT `fk_Conseiller_Employe` FOREIGN KEY (`IdEmp`) REFERENCES `Employe` (`IdEmp`);

--
-- Constraints for table `Detenir`
--
ALTER TABLE `Detenir`
  ADD CONSTRAINT `fk_Detenir_Client` FOREIGN KEY (`IdClient`) REFERENCES `Client` (`IdClient`),
  ADD CONSTRAINT `fk_Detenir_Contrat` FOREIGN KEY (`IdContrat`) REFERENCES `Contrat` (`IdContrat`);

--
-- Constraints for table `Directeur`
--
ALTER TABLE `Directeur`
  ADD CONSTRAINT `fk_Directeur_Employe` FOREIGN KEY (`IdEmp`) REFERENCES `Employe` (`IdEmp`);

--
-- Constraints for table `Rendezvous`
--
ALTER TABLE `Rendezvous`
  ADD CONSTRAINT `fk_Rendezvous_Agents` FOREIGN KEY (`IdAgent`) REFERENCES `Agent` (`IdAgent`),
  ADD CONSTRAINT `fk_Rendezvous_Client` FOREIGN KEY (`IdClient`) REFERENCES `Client` (`IdClient`),
  ADD CONSTRAINT `fk_Rendezvous_Conseiller` FOREIGN KEY (`IdConseiller`) REFERENCES `Conseiller` (`IdConseiller`),
  ADD CONSTRAINT `fk_Rendezvous_Motif` FOREIGN KEY (`IdMotif`) REFERENCES `Motif` (`IdMotif`);

--
-- Constraints for table `Requerir`
--
ALTER TABLE `Requerir`
  ADD CONSTRAINT `fk_Requerir_Motif` FOREIGN KEY (`IdMotif`) REFERENCES `Motif` (`IdMotif`),
  ADD CONSTRAINT `fk_Requerir_Piece` FOREIGN KEY (`IdPiece`) REFERENCES `Piece` (`IdPiece`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
