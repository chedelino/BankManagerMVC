CREATE TABLE Employe (
    IdEmp INT AUTO_INCREMENT,
    NomEmp VARCHAR(32) NOT NULL,
    PrenomEmp VARCHAR(32) NOT NULL,
    LoginEmp VARCHAR(32) NOT NULL,
    MdpEmp VARCHAR(32) NOT NULL,
    Role VARCHAR(32) NOT NULL,
    CONSTRAINT pk_Employe PRIMARY KEY (IdEmp)
);

CREATE TABLE Directeur (
    IdDirecteur INT AUTO_INCREMENT,
    IdEmp INT,
    NomDirect VARCHAR(32) NOT NULL,
    PrenomDirect VARCHAR(32) NOT NULL,
    LoginDirect VARCHAR(32) NOT NULL,
    MdpDirect VARCHAR(32) NOT NULL,
    CONSTRAINT pk_Directeur PRIMARY KEY (IdDirecteur),
    CONSTRAINT fk_Directeur_Employe FOREIGN KEY (IdEmp) REFERENCES Employe(IdEmp)
);

CREATE TABLE Agent (
    IdAgent INT AUTO_INCREMENT,
    IdEmp INT,
    NomAgent VARCHAR(32) NOT NULL,
    PrenomAgent VARCHAR(32) NOT NULL,
    LoginAgent VARCHAR(32) NOT NULL,
    MdpAgent VARCHAR(32) NOT NULL,
    CONSTRAINT pk_Agent PRIMARY KEY (IdAgent),
    CONSTRAINT fk_Agent_Employe FOREIGN KEY (IdEmp) REFERENCES Employe(IdEmp)
);

CREATE TABLE Conseiller (
    IdConseiller INT AUTO_INCREMENT,
    IdEmp INT,
    NomConseiller VARCHAR(32) NOT NULL,
    PrenomConseiller VARCHAR(32) NOT NULL,
    LoginConseiller VARCHAR(32) NOT NULL,
    MdpConseiller VARCHAR(32) NOT NULL,
    CONSTRAINT pk_Conseiller PRIMARY KEY (IdConseiller),
    CONSTRAINT fk_Conseiller_Employe FOREIGN KEY (IdEmp) REFERENCES Employe(IdEmp)
);

CREATE TABLE Client (
    IdClient INT AUTO_INCREMENT,
    IdConseiller INT,
    NomCl VARCHAR(32) NOT NULL,
    PrenomCl VARCHAR(32) NOT NULL,
    DateN DATE NOT NULL,
    DateInscription DATE NOT NULL;
    Adresse VARCHAR(32) NOT NULL,
    NumTel VARCHAR(32) NOT NULL,
    Mail VARCHAR(32) NOT NULL,
    SituationFam VARCHAR(32) NOT NULL,
    CONSTRAINT pk_Client PRIMARY KEY (IdClient),
    CONSTRAINT fk_Client_Conseiller FOREIGN KEY (IdConseiller) REFERENCES Conseiller(IdConseiller)
);

CREATE TABLE Compte (
    IdCompte INT AUTO_INCREMENT,
    TypeCompte VARCHAR(32) NOT NULL,
    CONSTRAINT pk_Compte PRIMARY KEY (IdCompte)
);

CREATE TABLE Appartenir (
    IdCompte INT,
    IdClient INT,
    NumeroCompte INT,
    DateOuverture DATE NOT NULL,
    Solde INT NOT NULL,
    MontantDec INT NOT NULL,
    CONSTRAINT fk_Appartenir_Client FOREIGN KEY (IdClient) REFERENCES Client(IdClient),
    CONSTRAINT fk_Appartenir_Compte FOREIGN KEY (IdCompte) REFERENCES Compte(IdCompte),
    CONSTRAINT pk_Appartenir PRIMARY KEY (IdCompte, IdClient, NumeroCompte)
);

CREATE TABLE Contrat (
    IdContrat INT AUTO_INCREMENT,
    TypeContrat VARCHAR(32) NOT NULL,
    TarifMensuel INT NOT NULL,
    CONSTRAINT pk_Contrat PRIMARY KEY (IdContrat)
);

CREATE TABLE Detenir (
    IdContrat INT,
    IdClient INT,
    NumeroContrat VARCHAR(32) NOT NULL,
    DateDebut DATE NOT NULL,
    CONSTRAINT pk_Detenir PRIMARY KEY (IdContrat, IdClient, NumeroContrat),
    CONSTRAINT fk_Detenir_Contrat FOREIGN KEY (IdContrat) REFERENCES Contrat(IdContrat),
    CONSTRAINT fk_Detenir_Client FOREIGN KEY (IdClient) REFERENCES Client(IdClient)
);

CREATE TABLE Motif (
    IdMotif INT AUTO_INCREMENT,
    NomMotif VARCHAR(32) NOT NULL,
    CONSTRAINT pk_Motif PRIMARY KEY (IdMotif)
);

CREATE TABLE Rendezvous (
    IdRdv INT AUTO_INCREMENT,
    IdAgent INT,
    IdClient INT,
    DateRdv DATE NOT NULL,
    HeureRdv VARCHAR(32) NOT NULL,
    IdMotif INT,
    CONSTRAINT pk_Rendezvous PRIMARY KEY (IdRdv),
    CONSTRAINT fk_Rendezvous_Agents FOREIGN KEY (IdAgent) REFERENCES Agent(IdAgent),
    CONSTRAINT fk_Rendezvous_Client FOREIGN KEY (IdClient) REFERENCES Client(IdClient),
    CONSTRAINT fk_Rendezvous_Motif FOREIGN KEY (IdMotif) REFERENCES Motif(IdMotif)
);

CREATE TABLE Piece (
    IdPiece INT AUTO_INCREMENT,
    NomPiece VARCHAR(32) NOT NULL,
    CONSTRAINT pk_Piece PRIMARY KEY (IdPiece)
);

CREATE TABLE Requerir (
    IdRequis INT AUTO_INCREMENT,
    IdPiece INT,
    IdMotif INT,
    CONSTRAINT pk_Requerir PRIMARY KEY (IdRequis),
    CONSTRAINT fk_Requerir_Piece FOREIGN KEY (IdPiece) REFERENCES Piece(IdPiece),
    CONSTRAINT fk_Requerir_Motif FOREIGN KEY (IdMotif) REFERENCES Motif(IdMotif)
);

