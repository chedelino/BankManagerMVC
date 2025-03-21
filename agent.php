<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="style1.css" />

    <title>Agent d'accueil</title>   

</head>


<body>
<div class="header">
    <a href="site.php">
        <img class="logo" src="images/banque.png" alt="Logo" title="Logo">
    </a>
    <h1 class="title"> Agent d'accueil</h1>
        <button class="logout-btn" onclick="logout()">Déconnexion</button>

</div>




<?php
require 'connect.php'; // Inclure le fichier de connexion


// Création de la connexion avec les constantes définies
$conn = new mysqli(SERVEUR, USER, PASSWORD, BDD);


$conn->close();
?>



 <!-- Menu du site -->

<div class="container">
    <div class="tabs">
        <button class="tab active" onclick="openTab(event, 'gestion')">Gestion des clients</button>
        <button class="tab" onclick="openTab(event, 'synthese')"> Synthèse clients </button>
        <button class="tab" onclick="openTab(event, 'operations')"> Opérations bancaires</button>
        <button class="tab" onclick="openTab(event, 'rendezvous')">Prise de rendez-vous</button>
        <button class="tab" onclick="openTab(event, 'recherche')">Recherche de clients</button>

     </div>




<!-- Modifier certaines informations du client -->
    <div id="gestion" class="tab-content active">

        <h2>Modifier certaines informations du client </h2>
        <br>

            <form id="formulaireCli" method="POST">
             <div class="form-group">
                    <label>Identifiant du client </label>
                    <input type="number" id="id_du_clients" name="id_du_clients" required>
             </div>

                <button class="btn-secondary" type="reset" name="delete_btn" id="delete_btn">Effacer</button>
                <button class="btn-primary" type="submit" id="send_btn" name="send_btn">Envoyer</button>
        </form>


<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Connexion à la base de données
    $conn = new mysqli(SERVEUR, USER, PASSWORD, BDD);
    
    if ($conn->connect_error) {
        die("Échec de la connexion : " . $conn->connect_error);
    }

    // Récupération et sécurisation des entrées
    $id_du_cli = isset($_POST['id_du_clients']) ? $_POST['id_du_clients'] : '';

    if (!empty($id_du_cli) && isset($_POST['send_btn'])) {



        // Récupération des informations du client
        $sql = "SELECT IdClient, NomCl, PrenomCl, DateN, Mail, NumTel, Adresse, SituationFam, DateInscription FROM Client WHERE IdClient = ?";   
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_du_cli);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo '<div class="form-container">';
            echo '<form method="post">';
            
            // Affichage des informations non modifiables
            echo '<label for="id">Identifiant :</label>';
            echo '<input type="number" name="id" id="id" value="'.$row['IdClient'].'" readonly> <br><br>';
            
            echo '<label for="nom">Nom complet :</label>';
            echo '<input type="text" name="nom" id="nom" value="' . $row['NomCl'] . ' ' . $row['PrenomCl'] . '" readonly> <br><br>';
            
            // Affichage des informations modifiables
            echo '<label for="date_naissance">Date de naissance :</label>';
            echo '<input type="date" name="date_naissance" id="date_naissance" value="'.$row['DateN'].'" readonly> <br><br>';
            
            echo '<label for="email">Email :</label>';
            echo '<input type="email" name="email" id="email" value="'.$row['Mail'].'"> <br><br>';
            
            echo '<label for="telephone">Téléphone :</label>';
            echo '<input type="text" name="telephone" id="telephone" value="'.$row['NumTel'].'"> <br><br>';

            echo '<label for="telephone">Adresse :</label>';
            echo '<input type="text" name="adresse" id="adresse" value="'.$row['Adresse'].'"> <br><br>';


            echo '<label for="telephone">Situation familiale :</label>';
            echo '<input type="text" name="situationF" id="situationF" value="'.$row['SituationFam'].'"> <br><br>';
            
            echo '<label for="date_inscription">Date d\'inscription :</label>';
            echo '<input type="date" name="date_inscription" id="date_inscription" value="'.$row['DateInscription'].'"> <br><br>';
            
            echo '<input type="submit" name="modify_btn" id="modify_btn"value="Modifier">';
            echo '</form>';
            echo '</div>';
        } else {
            echo "<p> <div class='form-container'><div class='NoResultat'>Aucun compte trouvé pour ce client.</p></div></div>";
        }

        $stmt->close();
    } elseif (isset($_POST['modify_btn'])) {
            // Récupération des données du formulaire de modification
            $date_naissance = $_POST['date_naissance'];
            $email = $_POST['email'];
            $telephone = $_POST['telephone'];
            $address = $_POST['adresse'];
            $Sfamiliale= $_POST['situationF'];
            $date_inscription = $_POST['date_inscription'];
            $id = $_POST['id'];

            // Préparation de la requête SQL pour mettre à jour les informations
            $sql = "UPDATE Client SET DateN = ?, Mail = ?, NumTel = ?,  Adresse = ?, DateInscription = ?, SituationFam=? WHERE IdClient = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssssi", $date_naissance, $email, $telephone, $address, $date_inscription, $Sfamiliale, $id);

            if ($stmt->execute()) {
                echo '<div class="success-message" id="modifCli"> Les informations du client ont été mises à jour avec succès! </div>
              <script>
                    setTimeout(() => {
                        document.getElementById("modifCli").style.display = "none";}, 2000);
                </script>';
            } else {

             echo "<div class='failure-message' id='modifClis'>Erreur lors de la mise à jour des informations du client.</div>
                  <script>
                    setTimeout(() => {
                        document.getElementById('modifClis').style.display = 'none';}, 2000);
                </script>";
            }

            $stmt->close();
        }

    // Fermeture de la connexion
    $conn->close();
}
?>


 </div>










<!-- consulter la synthèse d'un client -->

    <div id="synthese" class="tab-content">
        <h2> Consulter la synthèse d'un client</h2>
        <br>


         <form id="syntheseCli" method="POST">
            <div class="form-group">
                    <label>Identifiant du Client</label>
                    <input type="text" id="id_clients" name="id_clients" required>
            </div>

            <button type="submit" class="btn" id="synthese_clients" name="synthese_clients">Rechercher</button>
            </form>


<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli(SERVEUR, USER, PASSWORD, BDD);
    
    if ($conn->connect_error) {
        die("Échec de la connexion : " . $conn->connect_error);
    }

    $identifiant = isset($_POST['id_clients']) ? intval($_POST['id_clients']) : 0;

    if (!empty($identifiant) && isset($_POST['synthese_clients'])) {
        // Connexion à la base de données
        $conn = new mysqli(SERVEUR, USER, PASSWORD, BDD);
        
        if ($conn->connect_error) {
            die("Échec de la connexion : " . $conn->connect_error);
        }

        // Recherche des informations complètes du client
        $sql = "SELECT IdClient, NomCl, PrenomCl, DateN, Adresse, NumTel, Mail, SituationFam, NomConseiller, PrenomConseiller
                FROM Client
                LEFT JOIN Conseiller ON Client.IdConseiller = Conseiller.IdConseiller
                WHERE Client.IdClient = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $identifiant);
        $stmt->execute();
        $result = $stmt->get_result();

        echo '<style>
            .resultatsCli {
                font-family: Arial, sans-serif;
                max-width: 900px;
                margin: 20px auto;
                padding: 15px;
                border: 1px solid #ddd;
                border-radius: 5px;
                background-color: #f9f9f9;
                box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
                text-align: left;
            }
            .resultatsCli h2 {
                text-align: center;
            }
            .table-container {
                width: 100%;
                border-collapse: collapse;
            }
            .table-container th, .table-container td {
                border: 1px solid #ddd;
                padding: 8px;
                text-align: left;
            }
            .table-container th {
                background-color: #e3f2fd;
                color: black;
            }
            .NoResultat {
                color: white;
                background-color: red;
                padding: 10px;
                border-radius: 5px;
                font-weight: bold;
                text-align: center;
                margin-top: 10px;
            }
        </style>';

        echo '<div class="resultatsCli">';

        if ($result->num_rows > 0) {
            echo '<h2>Informations du client</h2>';
            echo '<table class="table-container">
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Date de naissance</th>
                        <th>Adresse</th>
                        <th>Téléphone</th>
                        <th>Email</th>
                        <th>Situation familiale</th>
                        <th>Conseiller</th>
                    </tr>';

            while ($row = $result->fetch_assoc()) {
                echo '<tr>
                        <td>' . ($row['IdClient']) . '</td>
                        <td>' . ($row['NomCl']) . '</td>
                        <td>' . ($row['PrenomCl']) . '</td>
                        <td>' . ($row['DateN']) . '</td>
                        <td>' . ($row['Adresse']) . '</td>
                        <td>' . ($row['NumTel']) . '</td>
                        <td>' . ($row['Mail']) . '</td>
                        <td>' . ($row['SituationFam']) . '</td>
                        <td>' . ($row['NomConseiller']) . ' ' . ($row['PrenomConseiller']) . '</td>
                      </tr>';
            }
            echo '</table>';
        } else {
            echo '<div class="NoResultat">Aucun client trouvé avec cet identifiant.</div>';
        }

        // Requête pour récupérer les informations des comptes du client
        $sql_comptes = "SELECT IdClient, NumeroCompte, TypeCompte, DateOuverture, Solde, MontantDec
                        FROM Compte
                        INNER JOIN Appartenir ON Compte.IdCompte = Appartenir.IdCompte
                        WHERE IdClient = ?";

        $stmt_comptes = $conn->prepare($sql_comptes);
        $stmt_comptes->bind_param("i", $identifiant);
        $stmt_comptes->execute();
        $result_comptes = $stmt_comptes->get_result();

        // Affichage des informations des comptes
        if ($result_comptes->num_rows > 0) {
            echo '<h2>Comptes du client</h2>';
            echo '<table class="table-container">
                    <tr>
                        <th>ID Client</th>
                        <th>Numéro de compte</th>
                        <th>Type de compte</th>
                        <th>Date d\'ouverture</th>
                        <th>Solde</th>
                        <th>Découvert autorisé</th>
                    </tr>';

            while ($row = $result_comptes->fetch_assoc()) {
                echo '<tr>
                        <td>' . ($row['IdClient']) . '</td>
                        <td>' . ($row['NumeroCompte']) . '</td>
                        <td>' . ($row['TypeCompte']) . '</td>
                        <td>' . ($row['DateOuverture']) . '</td>
                        <td>' . ($row['Solde']) . '</td>
                        <td>' . ($row['MontantDec']) . '</td>
                      </tr>';
            }
            echo '</table>';
        }  

        // Requête pour récupérer les informations des contrats du client
        $sql_contrats = "SELECT IdClient, NumeroContrat, TypeContrat, DateDebut, TarifMensuel
                         FROM Contrat
                         INNER JOIN Detenir ON Contrat.IdContrat = Detenir.IdContrat
                         WHERE IdClient = ?";

        $stmt_contrats = $conn->prepare($sql_contrats);
        $stmt_contrats->bind_param("i", $identifiant);
        $stmt_contrats->execute();
        $result_contrats = $stmt_contrats->get_result();

        // Affichage des informations des contrats
        if ($result_contrats->num_rows > 0) {
            echo '<h2>Contrats du client</h2>';
            echo '<table class="table-container">
                    <tr>
                        <th>ID Client</th>
                        <th>Numéro de contrat</th>
                        <th>Type de contrat</th>
                        <th>Date de début</th>
                        <th>Tarif mensuel</th>
                    </tr>';

            while ($row = $result_contrats->fetch_assoc()) {
                echo '<tr>
                        <td>' . ($row['IdClient']) . '</td>
                        <td>' . ($row['NumeroContrat']) . '</td>
                        <td>' . ($row['TypeContrat']) . '</td>
                        <td>' . ($row['DateDebut']) . '</td>
                        <td>' . ($row['TarifMensuel']) . '</td>
                      </tr>';
            }
            echo '</table>';
        } 

        echo '</div>'; 

        $stmt->close();
        $stmt_comptes->close();
        $stmt_contrats->close();
        $conn->close();
    }
}
?>

 </div>











<!-- Effectuer des dépôts ou retraits sur le compte d'un client -->
    <div id="operations" class="tab-content">
        <h2> Effectuer des dépôts ou retraits sur le compte d'un client</h2>
        <br>


        <form id="depotretraits" method="POST">
             <div class="form-group">
                    <label>Identifiant du client </label>
                    <input type="number" id="id_du_cpt" name="id_du_cpt" required>
             </div>

                <button class="btn-secondary" type="reset" name="Effacer_btn" id="filter">Effacer</button>
                <button class="btn-primary" type="submit" id="transc" name="transc">Envoyer</button>
        </form>


<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Connexion à la base de données
    $conn = new mysqli(SERVEUR, USER, PASSWORD, BDD);
    
    if ($conn->connect_error) {
        die("Échec de la connexion : " . $conn->connect_error);
    }
        echo '<style>
            .form-container {
                font-family: Arial, sans-serif;
                max-width: 500px;
                margin: 20px auto;
                padding: 15px;
                border: 1px solid #ddd;
                border-radius: 5px;
                background-color: #f9f9f9;
                box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
                text-align: center;
            }
            select, input {
                width: 100%;
                padding: 8px;
                margin: 5px 0;
                border-radius: 3px;
                border: 1px solid #ccc;
            }
            input[type="submit"] {
                background-color: #007bff;
                color: white;
                padding: 10px;
                border: none;
                border-radius: 5px;
                cursor: pointer;
            }
            input[type="submit"]:hover {
                background-color: #0056b3;
            }

            .NoResultat {
                color: white;
                background-color: red;
                padding: 10px;
                border-radius: 5px;
                font-weight: bold;
                text-align: center;
                margin-top: 10px;
            }

        </style>';


    // Récupération et sécurisation des entrées
    $id_client = isset($_POST['id_du_cpt']) ? $_POST['id_du_cpt'] : 0;

    if (!empty($id_client) && isset($_POST['transc'])) {

        // Récupération des comptes du client
        $sql = "SELECT Appartenir.IdCompte, IdClient, TypeCompte 
                    FROM Appartenir 
                        INNER JOIN Compte ON Appartenir.IdCompte=Compte.IdCompte
                    WHERE IdClient = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_client);
        $stmt->execute();
        $result = $stmt->get_result();
 
        if ($result->num_rows > 0) {
            echo '<div class="form-container">';
            echo '<form method="post">';
            echo '<input type="hidden" name="id_du_cpt" value="' . $id_client . '">'; // Champ caché pour IdClient

            echo '<label for="compte">Sélectionnez un compte :</label>';
            echo '<select name="compte" id="compte">';
            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['IdCompte'] . "'>" . $row['TypeCompte'] . "</option>";
            }
            echo '</select><br><br>';
            
            echo '<label for="operation">Type d\'opération :</label>';
            echo '<select name="operation" id="operation">';
            echo '<option value="debit">Débit</option>';
            echo '<option value="credit">Crédit</option>';
            echo '</select><br><br>';
            
            echo '<label for="montant">Montant :</label>';
            echo '<input type="number" name="montant" id="montant" required><br><br>';
            
            echo '<button type="submit" class="btn-primary">'."Effectuer".'<button>';
            echo '</form>';
            echo '</div>';
        } else {
            echo "<p> <div class='form-container'><div class='NoResultat'>Aucun compte trouvé pour ce client.</p></div></div>";
        }

        $stmt->close();
    } 

    // Fermeture de la connexion
    $conn->close();
}

// Traitement de la transaction
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['compte']) && isset($_POST['operation']) && isset($_POST['montant'])) {
    $id_client = isset($_POST['id_du_cpt']) ? $_POST['id_du_cpt'] : 0;

    $compte_id = $_POST['compte'];
    $operation = $_POST['operation'];
    $montant = $_POST['montant'];

    // Connexion à la base de données
    $conn = new mysqli(SERVEUR, USER, PASSWORD, BDD);
    
    if ($conn->connect_error) {
        die("Échec de la connexion : " . $conn->connect_error);
    }

    // Récupération du solde actuel et de la limite de découvert
    $sql = "SELECT Solde, MontantDec FROM Appartenir WHERE IdClient =? AND IdCompte = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $id_client, $compte_id);
    $stmt->execute();
    $stmt->bind_result($Solde, $MontantDec);
    $stmt->fetch();
    $stmt->close();

    // Calcul du nouveau solde
    if ($operation == 'debit') {
        $nouveau_solde = $Solde - $montant;
    } else {
        $nouveau_solde = $Solde + $montant;
    }

    // Vérification de la limite de découvert
    if ($nouveau_solde < -$MontantDec) {
        echo "<div class='form-container'><div class='NoResultat'>Erreur : La transaction dépasse la limite de découvert autorisé.</div></div>";
    } else {
        // Mise à jour du solde
        $sql = "UPDATE Appartenir SET Solde = ? WHERE IdClient = ? AND IdCompte = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("dii", $nouveau_solde, $id_client, $compte_id);
        $stmt->execute();
        $stmt->close();

        echo "<div class='form-container'><div class='NoResultat' style='background-color: green;'>Transaction effectuée avec succès.</div></div>";
    }

    // Fermeture de la connexion
    $conn->close();
}
?>


 </div>









<!-- prendre un rdv pour un client avec son conseiller< -->
        <div id="rendezvous" class="tab-content">
            <h2> Prendre un rdv pour un client avec son conseiller</h2>
            <br>


                    <section class="search-section">
                         <form id="agendaPlanning" method="POST" class="search-form">
                                 <div class="form-group">
                                        <label>Rechercher un chargé client : </label>
                                         <input type="number" id="id_du_cli" name="id_du_cli" required>

                                 </div>

                        <div class="form-group">
                                <label for="semaine">Semaine :</label>
                                <input type="date" id="semaine1" name="semaine1" required>

                        </div>

                        <button type="submit" name="envoyerPlanning" id="envoyerPlanning" class="btn-primary">Afficher</button>
                        </form>

                    </section>




<!-- Liste des motifs en php pour le modal-->
<?php

    // Connexion à la base de données
    $conn = new mysqli(SERVEUR, USER, PASSWORD, BDD);
    
    if ($conn->connect_error) {
        die("Échec de la connexion : " . $conn->connect_error);
    }

$sql = "SELECT IdMotif, NomMotif FROM Motif";
$result = $conn->query($sql);

$motifs = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $motifs[] = $row; // Stocker chaque motif dans un tableau
    }
}

$conn->close();


?>



<!-- Liste des Agents en php pour le modal-->


<?php
    // Connexion à la base de données
    $conn = new mysqli(SERVEUR, USER, PASSWORD, BDD);
    
    if ($conn->connect_error) {
        die("Échec de la connexion : " . $conn->connect_error);
    }

    // Requête SQL pour récupérer la liste des agents
    $sql = "SELECT IdAgent, NomAgent, PrenomAgent FROM Agent";
    $result = $conn->query($sql);

    $agents = []; // Tableau pour stocker les agents
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $agents[] = $row; // Stocker chaque agent dans le tableau
        }
    }

    $conn->close(); // Fermer la connexion
?>



<!-- Liste des clients en php pour le modal-->


<?php
    // Connexion à la base de données
    $conn = new mysqli(SERVEUR, USER, PASSWORD, BDD);
    
    if ($conn->connect_error) {
        die("Échec de la connexion : " . $conn->connect_error);
    }

    // Requête SQL pour récupérer la liste des clients
    $sql = "SELECT IdClient, NomCl, PrenomCl FROM Client";
    $result = $conn->query($sql);

    $clients = []; // Tableau pour stocker les clients
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $clients[] = $row; // Stocker chaque client dans le tableau
        }
    }

    $conn->close(); // Fermer la connexion
?>







<!-- Section pour afficher le planning -->
    <section id="planning-section" class="planning-section">


<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Connexion à la base de données
    $conn = new mysqli(SERVEUR, USER, PASSWORD, BDD);
    
    if ($conn->connect_error) {
        die("Échec de la connexion : " . $conn->connect_error);
    }






// Récupérer les rendez-vous pour une semaine donnée
if (isset($_POST['id_du_cli']) && isset($_POST['envoyerPlanning']) && isset($_POST['semaine1'])) {
    $id_charge_client = $_POST['id_du_cli'];

    $date_entree = date('Y-m-d', strtotime($_POST['semaine1']));

    $date_debut = date('Y-m-d', strtotime('monday this week', strtotime($date_entree)));

    $date_fin = date('Y-m-d', strtotime('friday this week', strtotime($date_entree)));


     // Vérifier si le conseiller existe dans la base de données
        $sql_check_conseiller = "SELECT IdConseiller FROM Conseiller WHERE IdConseiller = ?";
        $stmt_check = $conn->prepare($sql_check_conseiller);
        $stmt_check->bind_param("i", $id_charge_client);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();


        if ($result_check->num_rows > 0) {

                 $sql = "SELECT * 
                            FROM Rendezvous r
                                LEFT JOIN Client c ON r.IdClient = c.IdClient
                                LEFT JOIN Motif m ON r.IdMotif = m.IdMotif
                                LEFT JOIN Conseiller co ON r.IdConseiller = co.IdConseiller OR c.IdConseiller = co.IdConseiller
                                LEFT JOIN Employe e ON co.IdEmp = e.IdEmp
                            WHERE e.Role = 'Conseiller' 
                            AND co.IdConseiller = ? 
                            AND r.DateRdv BETWEEN ? AND ? 
                            ORDER BY r.DateRdv, r.HeureRdv";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $id_charge_client, $date_debut, $date_fin);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $rendezvous = [];
    while ($rdv = $result->fetch_assoc()) {
        $rendezvous[] = $rdv;
    }

    // Organiser les rendez-vous par jour et par heure
    $planning = [];
    foreach ($rendezvous as $rdv) {
        $jour = date('N', strtotime($rdv['DateRdv'])); // 1 (Lundi) à 7 (Dimanche)
        $heure = date('H:i', strtotime($rdv['HeureRdv'])); // Assure un formatage correct de l'heure
        $planning[$jour][$heure] = $rdv['NomMotif'];
    }

    // Définir les jours de la semaine et les heures de travail
    $jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi'];
    $heures = ['09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00'];

    echo '<style>
    .calendar-container {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 80%; /* Ajustez la largeur selon vos besoins */
        margin: 0 auto; /* Centre le conteneur horizontalement */
    }

     .NoResultat {
     color: white;
     background-color: red;
     padding: 10px;
     border-radius: 5px;
     font-weight: bold;
     text-align: center;
     margin-top: 10px;
     }

    .form-container {
    font-family: Arial, sans-serif;
    max-width: 400px;
    margin: 20px auto;
    padding: 15px;
    border: 1px solid #ddd;
    border-radius: 5px;
    background-color: #f9f9f9;
    box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
    text-align: center;
    }


    .calendar {
        width: 100%; 
        border-collapse: collapse;
    }
    .calendar th, .calendar td {
        border: 1px solid #ddd;
        padding: 10px;
        text-align: center;
    }
    .calendar th {
        background-color: #ecf0f1;
        font-weight: 600;
        color: black;
        font-weight: bold;
    }
    .hour-slot {
        height: 60px;
        color: black;
    }
    .free {
        background-color: #d5f5e3;
        cursor: pointer;
    }
    .occupied {
        background-color: #fadbd8;
    }

            .modal {
                display: none;
                position: fixed;
                z-index: 1;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                overflow: auto;
                background-color: rgba(0,0,0,0.5);
            }

            .modal-content {
                background-color: #fefefe;
                margin: 15% auto;
                padding: 20px;
                border: 1px solid #888;
                width: 80%;
                max-width: 500px;
                border-radius: 10px;
            }

            .close {
                color: #aaa;
                float: right;
                font-size: 28px;
                font-weight: bold;
            }

            .close:hover,
            .close:focus {
                color: black;
                text-decoration: none;
                cursor: pointer;
            }    
    </style>';

    echo '<div class="calendar-container">'; 
    echo '<table class="calendar">';
    echo '<thead>';
    echo '<tr>';
    echo '<th>Heure</th>';
    foreach ($jours as $jour) {
        echo '<th>' . $jour . '</th>';
    }
    echo '</tr>';
    echo '</thead>';
    echo '<tbody id="calendar-body">';
    foreach ($heures as $heure) {
        echo '<tr>';
        echo '<th>' . $heure . '</th>';

    for ($i = 1; $i <= 5; $i++) { // 1 = Lundi, 5 = Vendredi
    $date_rdv = date('Y-m-d', strtotime($date_debut . " + " . ($i - 1) . " days"));
    
    if (isset($planning[$i][$heure])) {
        echo '<td class="hour-slot occupied" data-date="' . $date_rdv . '" data-time="' . $heure . '">' . ($planning[$i][$heure]) . '</td>';
    } else {
        echo '<td class="hour-slot free" data-date="' . $date_rdv . '" data-time="' . $heure . '" onclick="openModal(this)"></td>';
    }
}
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';
    echo '</div>'; 



// Ajout du formulaire en modal
echo '
<div id="modal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2>Ajouter un rendez-vous</h2>
        <form id="appointmentForm" method="POST">
            <input type="hidden" name="dateRdv" id="dateRdv">
            <input type="hidden" name="HeureRv" id="HeureRv">

            <div class="form-group">
                <label>Motif</label>
                <select id="motifName" name="motifName" required>
                    <option value="">Sélectionnez un motif</option>';
                    foreach ($motifs as $motif) {
                        echo '<option value="' . $motif['IdMotif'] . '">' . $motif['NomMotif'] . '</option>';
                    }
echo '
                </select>
            </div>

            <div class="form-group">
                <label>Agent</label>
                <select id="agentName" name="agentName" required>
                    <option value="">Sélectionnez un agent</option>';
                    foreach ($agents as $agent) {
                        echo '<option value="' . $agent['IdAgent'] . '">' . $agent['NomAgent'] . ' ' . $agent['PrenomAgent'] . '</option>';
                    }
echo '
                </select>
            </div>

            <div class="form-group">
                <label>Client</label>
                <select id="clientName" name="clientName" required>
                    <option value="">Sélectionnez un client</option>';
                    foreach ($clients as $client) {
                        echo '<option value="' . $client['IdClient'] . '">' . $client['NomCl'] . ' ' . $client['PrenomCl'] . '</option>';
                    }
echo '
                </select>
            </div>

            <button type="submit" name="bouton_rdv" id="bouton_rdv">Enregistrer</button>
        </form>
    </div>
</div>';

// Ajout du script pour gérer le modal
echo '
<script>
    function openModal(element) {
        document.getElementById("modal").style.display = "block";
        document.getElementById("dateRdv").value = element.getAttribute("data-date");
        document.getElementById("HeureRv").value = element.getAttribute("data-time");
    }

    function closeModal() {
        document.getElementById("modal").style.display = "none";
    }
</script>';

}

else {
                // Le conseiller n'existe pas
                echo "<p> <div class='form-container'><div class='NoResultat'>Aucun conseiller trouvé.</p></div></div>";
            }

}
}

?>


<?php
// Code PHP pour ajouter un rendez-vous dans la base de données
if (isset($_POST['bouton_rdv']) && isset($_POST['dateRdv']) && isset($_POST['HeureRv']) && isset($_POST['motifName']) && isset($_POST['agentName']) && isset($_POST['clientName'])) {
    $date = $_POST['dateRdv'];
    $time = $_POST['HeureRv'];
    $id_motif = $_POST['motifName'];
    $id_Agent = $_POST['agentName'];
    $id_Client = $_POST['clientName'];


    $conn = new mysqli(SERVEUR, USER, PASSWORD, BDD);
    if ($conn->connect_error) {
        die("Échec de la connexion : " . $conn->connect_error);
    }

    $sql = "INSERT INTO Rendezvous (IdAgent, IdClient, DateRdv, HeureRdv,IdMotif) VALUES (?, ?, ?, ?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iissi", $id_Agent, $id_Client, $date, $time, $id_motif); 
    if ($stmt->execute()) {
        echo '<div class="success-message" id="msgRdv"> Rendez-vous ajouté avec succès ! </div>
              <script>
                    setTimeout(() => {
                        document.getElementById("msgRdv").style.display = "none";}, 2000);
                </script>';


        // Récupérer les pièces requises pour le motif du rendez-vous
        $sql_pieces = " SELECT NomPiece FROM Piece 
                               INNER JOIN Requerir ON Piece.IdPiece=Requerir.IdPiece
                         WHERE IdMotif= ?";

        $stmt_pieces = $conn->prepare($sql_pieces);
        $stmt_pieces->bind_param("i", $id_motif);
        $stmt_pieces->execute();
        $result_pieces = $stmt_pieces->get_result();

echo '<style>
 .pieces-requises {
    margin: 20px auto;
    padding: 20px;
    font-family: Arial, sans-serif;

    max-width: 600px;
    background-color: #f9f9f9;
    border-radius: 8px;
    text-align: center;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    font-family: Arial, sans-serif;
}


.pieces-requises h3 {
    margin-top: 0;
    font-size: 20px;
    color: #333;
    border-bottom: 2px solid #007bff;
    padding-bottom: 10px;
}

.pieces-requises ul {
    list-style-type: none;
    padding: 0;
    margin: 0;
}

.pieces-requises ul li {
    padding: 10px;
    margin: 5px 0;
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 16px;
    color: #555;
    transition: background-color 0.3s ease;
}

.pieces-requises ul li:hover {
    background-color: #f1f1f1;
}

.pieces-requises p {
    font-size: 16px;
    color: #666;
    text-align: center;
    margin: 0;
}

</style>';


        // Afficher les pièces requises
        if ($result_pieces->num_rows > 0) {
            echo '<div class="pieces-requises">';
            echo '<h3>Pièces requises pour ce rendez-vous :</h3>';
            echo '<ul>';
            while ($row = $result_pieces->fetch_assoc()) {
                echo '<li>' . ($row['NomPiece']) . '</li>';
            }
            echo '</ul>';
            echo '</div>';
        } else {
            echo '<div class="pieces-requises">';
            echo '<p>Aucune pièce requise pour ce motif de rendez-vous.</p>';
            echo '</div>';
        }

        $stmt_pieces->close(); 



    } else {
    echo "<div class='failure-message' id='msgRdv'>alert('Erreur SQL : " . addslashes($stmt->error) . "');</div>
                  <script>
                    setTimeout(() => {
                        document.getElementById('msgRdv1').style.display = 'none';}, 2000);
                </script>";
    }
    $stmt->close();
    $conn->close();
}
?>

    </section>

    </div>














 <!-- Retrouver l'id d'un client< -->
        <div id="recherche" class="tab-content">
            <h2> Retrouver l'ID d'un client</h2>
            <br>

        <form id="clientsForm" method="POST">
                <div class="form-group">
                    <label>Nom du Client</label>
                    <input type="text" id="nom_clients" name="nom_clients" required>
                </div>

                <div class="form-group">
                    <label>Date de naissance</label>
                    <input type="date" id="date_naissance" name="date_naissance"  required>
                </div>
                <button type="submit" class="btn" id="recherche_clients" name="recherche_clients">Rechercher</button>
            </form>




<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Connexion à la base de données
    $conn = new mysqli(SERVEUR, USER, PASSWORD, BDD);
    
    if ($conn->connect_error) {
        die("Échec de la connexion : " . $conn->connect_error);
    }

    // Récupération et sécurisation des entrées
    $nom = isset($_POST['nom_clients']) ? $_POST['nom_clients'] : '';
    $date_naissance = isset($_POST['date_naissance']) ? $_POST['date_naissance'] : '';

    if (!empty($nom) && !empty($date_naissance) && isset($_POST['recherche_clients'])) {
        // Recherche du client
        $sql = "SELECT IdClient, NomCl, PrenomCl FROM Client WHERE NomCl = '$nom' AND DateN = '$date_naissance'";
        $result = $conn->query($sql);

        echo '<style>
            .resultatsCli {
                font-family: Arial, sans-serif;
                max-width: 400px;
                margin: 20px auto;
                padding: 15px;
                border: 1px solid #ddd;
                border-radius: 5px;
                background-color: #f9f9f9;
                box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
                text-align: center;
            }
            .resultats_list {
                padding: 8px;
                margin: 5px 0;
                background-color: #e3f2fd;
                border-radius: 3px;
            }
            .NoResultat {
                color: white;
                background-color: red;
                padding: 10px;
                border-radius: 5px;
                font-weight: bold;
                margin-top: 10px;
            }
        </style>';

        echo '<div class="resultatsCli">';

        if ($result->num_rows > 0) {
            echo '<h2>Résultats :</h2>';
            while ($row = $result->fetch_assoc()) {
                echo "<div class='resultats_list'>Identifiant : " . ($row['IdClient']) . " - " . ($row['PrenomCl']) . " " . ($row['NomCl']) . "</div>";
            }
        } else {
            echo '<div class="NoResultat">Aucun client trouvé.</div>';
        }

        echo '</div>';
    }

    // Fermeture de la connexion
    $conn->close();
}
?>


</div>













 </div>




<script>
        // Fonction pour ouvrir un onglet
        function openTab(evt, tabName) {
            const tabContents = document.getElementsByClassName("tab-content");
            for (let content of tabContents) {
                content.classList.remove("active");
            }

            const tabs = document.getElementsByClassName("tab");
            for (let tab of tabs) {
                tab.classList.remove("active");
            }

            document.getElementById(tabName).classList.add("active");
            evt.currentTarget.classList.add("active");
            
            // Sauvegarder l'onglet actif dans localStorage
            localStorage.setItem('activeTab', tabName);
        }

        // Fonction pour restaurer l'onglet actif au chargement de la page
        function restoreActiveTab() {
            const activeTab = localStorage.getItem('activeTab');
            if (activeTab) {
                // Simuler un clic sur l'onglet
                const tabButton = document.querySelector(`button.tab[onclick="openTab(event, '${activeTab}')"]`);
                if (tabButton) {
                    // Créer un événement factice
                    const evt = { currentTarget: tabButton };
                    openTab(evt, activeTab);
                }
            }
        }

    // Fonction pour la déconnexion
    function logout() {
        window.location.href = "site.php"; // Redirection vers la page d'accueil
    }

        // Ajouter l'écouteur d'événement pour le chargement de la page
        window.addEventListener('load', restoreActiveTab);
    </script>




    <footer>
        <p>&copy; 2025 Ma Banque. Tous droits réservés.</p>
    </footer>
</body>
</html>