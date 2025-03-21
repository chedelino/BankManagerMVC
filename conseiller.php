<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style1.css" />

    <title>Conseillers clients</title>
    

</head>
<body>
<div class="header">
    <a href="site.php">
        <img class="logo" src="images/banque.png" alt="Logo" title="Logo">
    </a>
    <h1 class="title"> Conseillers des clients</h1>
    <button class="logout-btn" onclick="logout()">Déconnexion</button>

</div>

     <!-- Navigation -->

    <div class="container">
        <div class="tabs">
            <button class="tab active" onclick="openTab(event, 'planning')">Planning des conseillers</button>
            <button class="tab" onclick="openTab(event, 'inscription')"> Inscription de clients</button>
            <button class="tab" onclick="openTab(event, 'ventes')"> Vente de contrats</button>
            <button class="tab" onclick="openTab(event, 'ouverture')">Ouverture de comptes</button>
            <button class="tab" onclick="openTab(event, 'decouvert')">Modification de découverts</button>
            <button class="tab" onclick="openTab(event, 'resiliercontrat')">Résiliation de contrats</button>
             <button class="tab" onclick="openTab(event, 'resiliercompte')">Résiliation de comptes</button>



        </div>


 <?php
require 'connect.php'; // Inclure le fichier de connexion


// Création de la connexion avec les constantes définies
$conn = new mysqli(SERVEUR, USER, PASSWORD, BDD);


$conn->close();
?>



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




        <!-- Planning -->
        <div id="planning" class="tab-content active">

            <h2>Visualiser le planning  </h2>
            <br>

         <!-- Section de recherche et filtres -->
                    <section class="search-section">
                         <form id="conseillerPlanning" method="POST" class="search-form">
                                 <div class="form-group">
                                        <label>Identifiant du Conseiller : </label>
                                         <input type="number" id="id_du_conseiller" name="id_du_conseiller" required>

                                 </div>

                        <div class="form-group">
                                <label for="semaine">Date :</label>
                                <input type="date" id="date111" name="date111" required>

                        </div>

                        <button type="submit" name="envoyerPlanningConseil" id="envoyerPlanningConseil" class="btn-primary">Afficher</button>
                        </form>

                    </section>



         <!--  le planning -->
<section id="planning-section" class="planning-section">
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Connexion à la base de données
        $conn = new mysqli(SERVEUR, USER, PASSWORD, BDD);

        if ($conn->connect_error) {
            die("Échec de la connexion : " . $conn->connect_error);
        }

        echo '<style>
            .calendar-container {
                display: flex;
                justify-content: center;
                align-items: center;
                width: 80%; /* Ajustez la largeur selon vos besoins */
                margin: 0 auto; /* Centre le conteneur horizontalement */
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

            .NoResultat {
                color: white;
                background-color: red;
                padding: 10px;
                border-radius: 5px;
                font-weight: bold;
                text-align: center;
                margin-top: 10px;
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

        // Vérifier si les données du formulaire sont envoyées
        if (isset($_POST['id_du_conseiller']) && isset($_POST['envoyerPlanningConseil']) && isset($_POST['date111'])) {
            $id_conseiller = $_POST['id_du_conseiller'];
            $date = date('Y-m-d', strtotime($_POST['date111']));

            // Vérifier si le conseiller existe dans la base de données
        $sql_check_conseiller = "SELECT IdConseiller FROM Conseiller WHERE IdConseiller = ?";
        $stmt_check = $conn->prepare($sql_check_conseiller);
        $stmt_check->bind_param("i", $id_conseiller);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();

            if ($result_check->num_rows > 0) {
                // Le conseiller existe, récupérer les rendez-vous

                 $sql = "SELECT * 
                            FROM Rendezvous r
                                LEFT JOIN Client c ON r.IdClient = c.IdClient
                                LEFT JOIN Motif m ON r.IdMotif = m.IdMotif
                                LEFT JOIN Conseiller co ON r.IdConseiller = co.IdConseiller OR c.IdConseiller = co.IdConseiller
                                LEFT JOIN Employe e ON co.IdEmp = e.IdEmp
                            WHERE e.Role = 'Conseiller' 
                            AND co.IdConseiller = ? 
                            AND r.DateRdv = ? 
                            ORDER BY r.HeureRdv";

                $stmt = $conn->prepare($sql);
                $stmt->bind_param("is", $id_conseiller, $date);
                $stmt->execute();
                $result = $stmt->get_result();

                // Organiser les rendez-vous par heure
                $planning = [];
                if ($result->num_rows > 0) {
                    while ($rdv = $result->fetch_assoc()) {
                        $heure = date('H:i', strtotime($rdv['HeureRdv'])); // Assure un formatage correct de l'heure
                        $planning[$heure] = $rdv['NomMotif'];
                    }
                }

                // Définir les heures de travail
                $heures = ['09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00'];

                // Afficher le planning
                echo '<div class="calendar-container">'; 
                echo '<table class="calendar">';
                echo '<thead>';
                echo '<tr>';
                echo '<th>Heure</th>';
                echo '<th>Planning</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody id="calendar-body">';
                foreach ($heures as $heure) {
                    echo '<tr>';
                    echo '<th>' . $heure . '</th>';
                    if (isset($planning[$heure])) {
                        echo '<td class="hour-slot occupied" data-date="' . $date . '" data-time="' . $heure . '">' . $planning[$heure] . '</td>';
                    } else {
                        echo '<td class="hour-slot free" data-date="' . $date . '" data-time="' . $heure . '" onclick="openModal(this)"></td>';
                    }
                    echo '</tr>';
                }
                echo '</tbody>';
                echo '</table>';
                echo '</div>'; 

                // Ajout du formulaire en modal
                echo '<div id="modal" class="modal">
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
                                                                     echo '<option value="' . $motif['IdMotif'] . '">' . $motif['NomMotif'] . 
                                                    '</option>';
                                                      }
                                echo ' </select>
                                </div>
                                <input type="hidden" name="id_conseiller" value="' . $id_conseiller . '">
                                <button type="submit" name="bouton_rdv" id="bouton_rdv">Enregistrer</button>
                            </form>
                        </div>
                    </div>';

                // Ajout du script pour gérer le modal
                echo '<script>
                    function openModal(element) {
                        document.getElementById("modal").style.display = "block";
                        document.getElementById("dateRdv").value = element.getAttribute("data-date");
                        document.getElementById("HeureRv").value = element.getAttribute("data-time");

                    }

                    function closeModal() {
                        document.getElementById("modal").style.display = "none";
                    }
                </script>';
            } else {
                // Le conseiller n'existe pas
                echo "<p> <div class='form-container'><div class='NoResultat'>Aucun conseiller trouvé.</p></div></div>";
            }
        }
    }
    ?>

<?php
// Code PHP pour ajouter un rendez-vous dans la base de données
if (isset($_POST['bouton_rdv']) && isset($_POST['dateRdv']) && isset($_POST['HeureRv']) && isset($_POST['motifName'])) {
    $date = $_POST['dateRdv'];
    $time = $_POST['HeureRv'];
    $motif = $_POST['motifName'];
    $id_conseiller = $_POST['id_conseiller'];

    $conn = new mysqli(SERVEUR, USER, PASSWORD, BDD);
    if ($conn->connect_error) {
        die("Échec de la connexion : " . $conn->connect_error);
    }
    $sql = "INSERT INTO Rendezvous (DateRdv, HeureRdv,IdMotif, IdConseiller) VALUES (?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $date, $time, $motif, $id_conseiller); 
    if ($stmt->execute()) {
        echo '<div class="success-message" id="msgRdv"> Rendez-vous ajouté avec succès ! </div>
              <script>
                    setTimeout(() => {
                        document.getElementById("msgRdv").style.display = "none";}, 2000);
                </script>';
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


<!-- Liste des conseillers -->


<?php
    // Connexion à la base de données
    $conn = new mysqli(SERVEUR, USER, PASSWORD, BDD);
    
    if ($conn->connect_error) {
        die("Échec de la connexion : " . $conn->connect_error);
    }

    // Requête SQL pour récupérer la liste des clients
    $sql = "SELECT IdConseiller, NomConseiller, PrenomConseiller FROM Conseiller";
    $result = $conn->query($sql);

    $conseillers = []; // Tableau pour stocker les clients
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $conseillers[] = $row; // Stocker chaque les clients dans le tableau
        }
    }

    $conn->close(); // Fermer la connexion
?>



        <!-- inscription des clients -->
<div id="inscription" class="tab-content">
 <h2> Inscrire un nouveau client à la banque</h2>
  <br>



<form id="nouveauClient" method="post">

    <div class="form-group" style="display: flex; gap: 10px;">
        <div style="flex: 1;">
            <label for="identifiant">Identifiant</label>
            <input type="number" id="identifiant" name="identifiant" required>
        </div>
        <div style="flex: 1;">
            <label for="prenom">Date d'Inscription</label>
            <input type="date" id="dateInsc" name="dateInsc" required>
        </div>
    </div>


    <div class="form-group" style="display: flex; gap: 10px;">
        <div style="flex: 1;">
            <label for="nom">Nom</label>
            <input type="text" id="nom" name="nom" required>
        </div>
        <div style="flex: 1;">
            <label for="prenom">Prénom</label>
            <input type="text" id="prenom" name="prenom" required>
        </div>
    </div>


    <div class="form-group" style="display: flex; gap: 10px;">
        <div style="flex: 1;">
            <label for="telephone">Téléphone</label>
            <input type="text" id="telephone" name="telephone"  required>
        </div>
        <div style="flex: 1;">
            <label for="email">Email</label>
            <input type="email" id="email" name="email">
        </div>
    </div>


        <div class="form-group" style="display: flex; gap: 10px;">

        <div style="flex: 1;">
            <label>Conseiller</label>
            <select id="conseiller" name="conseiller" required>
                <option value="">Choisir un Conseiller</option>
                <?php foreach ($conseillers as $conseiller): ?>
                    <option value="<?php echo $conseiller['IdConseiller']; ?>">
                        <?php echo ($conseiller['NomConseiller'] . ' ' . $conseiller['PrenomConseiller']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

            <div style="flex: 1;">
                     <label for="situationF">Situation Familiale</label>
                     <select id="situationF" name="situationF" required>
                             <option value="">Choisir votre situation familiale</option>
                              <option value="celibataire">Célibataire</option>
                                 <option value="marie">Marié(e)</option>
                                <option value="divorce">Divorcé(e)</option>
                                 <option value="veuf">Veuf/Veuve</option>
                        </select>
                </div>
        </div>



    <div class="form-group" style="display: flex; gap: 10px;">
        <div style="flex: 1;">
            <label for="adresse">Adresse</label>
            <input type="text" id="adresse" name="adresse" required>
        </div>
        <div style="flex: 1;">
            <label for="dateNaiss">Date de Naissance</label>
            <input type="date" id="dateNaiss" name="dateNaiss" required>
        </div>
    </div>

    <div class="form-actions">
        <button type="submit" id="newClientB" name="newClientB" class="btn-primary">Enregistrer</button>
        <button type="reset" class="btn-secondary">Annuler</button>
    </div>
</form>

</div>


<!-- php pour inscrire le nouveau client -->


<?php
if (isset($_POST['newClientB']) && isset($_POST['identifiant']) && isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['telephone']) && isset($_POST['email']) && isset($_POST['adresse']) && isset($_POST['dateNaiss'])){

    $idClient = intval($_POST['identifiant']); 
    $nom = $_POST['nom']; 
    $prenom = $_POST['prenom']; 
    $tel = $_POST['telephone']; 
    $mail = $_POST['email']; 
    $adresse = $_POST['adresse'];
    $dateN = date('Y-m-d', strtotime($_POST['dateNaiss']));
    $dateInsc = date('Y-m-d', strtotime($_POST['dateInsc']));
    $situationF = $_POST['situationF'];
    $conseillerCli = $_POST['conseiller']; 


    $conn = new mysqli(SERVEUR, USER, PASSWORD, BDD);
    if ($conn->connect_error) {
        die("Échec de la connexion : " . $conn->connect_error);
    }

    $sql_update = "INSERT INTO Client (IdClient, IdConseiller, NomCl, PrenomCl, DateN, Adresse, NumTel, Mail, SituationFam, DateInscription) VALUES(?,?,?,?,?,?,?,?,?,?)";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("iissssssss", $idClient, $conseillerCli,$nom,$prenom,$dateN,$adresse,$tel,$mail,$situationF,$dateInsc);

    if ($stmt_update->execute()) {
        echo '<div class="success-message" id="msgRdv"> Le client a été créé avec succès ! </div>
              <script>
                    setTimeout(() => {
                        document.getElementById("msgRdv").style.display = "none";}, 5000);
              </script>';
    } else {
        echo '<div class="failure-message" id="msgRdv">Erreur SQL : ' . ($stmt_update->error) . '</div>
              <script>
                    setTimeout(() => {
                        document.getElementById("msgRdv").style.display = "none";}, 5000);
              </script>';
    }

    $stmt_update->close();
    $conn->close();

}
?> 



<!-- Liste des Contrats -->


<?php
    // Connexion à la base de données
    $conn = new mysqli(SERVEUR, USER, PASSWORD, BDD);
    
    if ($conn->connect_error) {
        die("Échec de la connexion : " . $conn->connect_error);
    }

    // Requête SQL pour récupérer la liste des clients
    $sql = "SELECT IdContrat, TypeContrat FROM Contrat";
    $result = $conn->query($sql);

    $comptes = []; // Tableau pour stocker les clients
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $contrats[] = $row; // Stocker chaque les comptes dans le tableau
        }
    }

    $conn->close(); // Fermer la connexion
?>




<!-- Liste des clients -->


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
            $clients[] = $row; // Stocker chaque les clients dans le tableau
        }
    }

    $conn->close(); // Fermer la connexion
?>



        <!-- Vente de contrat  -->
        <div id="ventes" class="tab-content">
            <h2> Vendre un contrat à un client</h2>
             <br>


<form id="ouverturecontrat" method="POST">
    <!--  Nom du client et Type de contrat -->

    <div class="form-group" style="display: flex; gap: 10px;">
        <div style="flex: 1;">
            <label>Nom Complet du client</label>
            <select id="identif_du_client" name="identif_du_client" required>
                <option value="">Sélectionnez un client</option>
                <?php foreach ($clients as $client): ?>
                    <option value="<?php echo $client['IdClient']; ?>">
                        <?php echo ($client['NomCl'] . ' ' . $client['PrenomCl']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div style="flex: 1;">
            <label>Type de Contrat</label>
            <select id="id_du_contrat_client" name="id_du_contrat_client" required>
                <option value="">Sélectionnez un contrat</option>
                <?php foreach ($contrats as $contrat): ?>
                    <option value="<?php echo $contrat['IdContrat']; ?>">
                        <?php echo ($contrat['TypeContrat']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <!-- Numéro du contrat et Date de début -->
    <div class="form-group" style="display: flex; gap: 10px;">
        <div style="flex: 1;">
            <label>Numéro du Contrat</label>
            <input type="number" id="numero_du_contrat" name="numero_du_contrat" required>
        </div>
        <div style="flex: 1;">
            <label>Date de début</label>
            <input type="date" id="dateDebut" name="dateDebut" required>
        </div>
    </div>

    <!-- Boutons -->
    <div class="form-actions">
        <button class="btn-primary" type="submit" id="ouverture_contrat_btn" name="ouverture_contrat_btn">Vendre le contrat</button>
        <button class="btn-secondary" type="reset" name="Effacer_btn" id="Effacer_btn">Effacer</button>
    </div>
</form>


        </div>


<?php
if (isset($_POST['ouverture_contrat_btn']) && isset($_POST['identif_du_client']) && isset($_POST['id_du_contrat_client'])) {
    $idClient = intval($_POST['identif_du_client']); 
    $idContrat = intval($_POST['id_du_contrat_client']); 
    $numeroContrat = intval($_POST['numero_du_contrat']); 
    $dateDebut = date('Y-m-d', strtotime($_POST['dateDebut']));

    $conn = new mysqli(SERVEUR, USER, PASSWORD, BDD);
    if ($conn->connect_error) {
        die("Échec de la connexion : " . $conn->connect_error);
    }

    $sql_update = "INSERT INTO Detenir (IdContrat, IdClient, NumeroContrat, DateDebut) VALUES(?,?,?,?)";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("iiis", $idContrat, $idClient,$numeroContrat, $dateDebut);

    if ($stmt_update->execute()) {
        echo '<div class="success-message" id="msgRdv"> Votre contrat a été créé avec succès ! </div>
              <script>
                    setTimeout(() => {
                        document.getElementById("msgRdv").style.display = "none";}, 2000);
              </script>';
    } else {
        echo '<div class="failure-message" id="msgRdv">Erreur SQL : ' . ($stmt_update->error) . '</div>
              <script>
                    setTimeout(() => {
                        document.getElementById("msgRdv").style.display = "none";}, 2000);
              </script>';
    }

    $stmt_update->close();
    $conn->close();

}
?> 














<!-- Liste des Contrats -->


<?php
    // Connexion à la base de données
    $conn = new mysqli(SERVEUR, USER, PASSWORD, BDD);
    
    if ($conn->connect_error) {
        die("Échec de la connexion : " . $conn->connect_error);
    }

    // Requête SQL pour récupérer la liste des clients
    $sql = "SELECT IdContrat, TypeContrat FROM Contrat";
    $result = $conn->query($sql);

    $comptes = []; // Tableau pour stocker les clients
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $contrats[] = $row; // Stocker chaque les comptes dans le tableau
        }
    }

    $conn->close(); // Fermer la connexion
?>




<!-- Liste des clients -->


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
            $clients[] = $row; // Stocker chaque les clients dans le tableau
        }
    }

    $conn->close(); // Fermer la connexion
?>



<!-- Liste des comptes -->


<?php
    // Connexion à la base de données
    $conn = new mysqli(SERVEUR, USER, PASSWORD, BDD);
    
    if ($conn->connect_error) {
        die("Échec de la connexion : " . $conn->connect_error);
    }

    // Requête SQL pour récupérer la liste des clients
    $sql = "SELECT IdCompte, TypeCompte FROM Compte";
    $result = $conn->query($sql);

    $comptes = []; // Tableau pour stocker les clients
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $comptes[] = $row; // Stocker chaque les comptes dans le tableau
        }
    }

    $conn->close(); // Fermer la connexion
?>




        <!-- ouverture de comptes -->
        <div id="ouverture" class="tab-content">
            <h2> Ouvrir un ou plusieurs comptes</h2>
            <br>


<form id="ouverturecompte" method="POST">

    <!--  Nom du client et Type de compte -->
    <div class="form-group" style="display: flex; gap: 10px;">
        <div style="flex: 1;">
            <label>Nom Complet du client</label>
            <select id="identi_du_client" name="identi_du_client" required>
                <option value="">Sélectionnez un client</option>
                <?php foreach ($clients as $client): ?>
                    <option value="<?php echo $client['IdClient']; ?>">
                        <?php echo ($client['NomCl'] . ' ' . $client['PrenomCl']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div style="flex: 1;">
            <label>Type de Compte</label>
            <select id="id_du_compte_client" name="id_du_compte_client" required>
                <option value="">Sélectionnez un compte</option>
                <?php foreach ($comptes as $compte): ?>
                    <option value="<?php echo $compte['IdCompte']; ?>">
                        <?php echo ($compte['TypeCompte']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <!-- Numéro du compte et Date d'ouverture -->
    <div class="form-group" style="display: flex; gap: 10px;">
        <div style="flex: 1;">
            <label>Numéro du Compte</label>
            <input type="number" id="numero_du_compte" name="numero_du_compte" required>
        </div>
        <div style="flex: 1;">
            <label>Date d'Ouverture</label>
            <input type="date" id="dateOuverture" name="dateOuverture" required>
        </div>
    </div>

    <!-- Boutons -->
    <div class="form-actions">
        <button class="btn-primary" type="submit" id="ouverture_compte_btn" name="ouverture_compte_btn">Ouvrir le compte</button>
        <button class="btn-secondary" type="reset" name="Effacer_btn" id="Effacer_btn">Effacer</button>
    </div>
</form>




        </div>


<?php
if (isset($_POST['ouverture_compte_btn']) && isset($_POST['identi_du_client']) && isset($_POST['id_du_compte_client'])) {
    $idClient = intval($_POST['identi_du_client']); 
    $idCompte = intval($_POST['id_du_compte_client']); 
    $numeroCompte = intval($_POST['numero_du_compte']); 
    $dOuverture = date('Y-m-d', strtotime($_POST['dateOuverture']));

    $conn = new mysqli(SERVEUR, USER, PASSWORD, BDD);
    if ($conn->connect_error) {
        die("Échec de la connexion : " . $conn->connect_error);
    }

    $sql_update = "INSERT INTO Appartenir (IdCompte, IdClient, NumeroCompte, DateOuverture) VALUES(?,?,?,?)";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("iiis", $idCompte, $idClient,$numeroCompte, $dOuverture);

    if ($stmt_update->execute()) {
        echo '<div class="success-message" id="msgRdv"> Votre compte a été créé avec succès ! </div>
              <script>
                    setTimeout(() => {
                        document.getElementById("msgRdv").style.display = "none";}, 2000);
              </script>';
    } else {
        echo '<div class="failure-message" id="msgRdv">Erreur SQL : ' . ($stmt_update->error) . '</div>
              <script>
                    setTimeout(() => {
                        document.getElementById("msgRdv").style.display = "none";}, 2000);
              </script>';
    }

    $stmt_update->close();
    $conn->close();

}
?>  











         <!--découvert-->
        <div id="decouvert" class="tab-content">
            <h2> Modifier la valeur d'un découvert</h2>
            <br>

            <form id="modifierDecouvert" method="POST">
             <div class="form-group">
                    <label>Identifiant du client </label>
                    <input type="text" id="id_du_client" name="id_du_client" required>
             </div>

            <div class="form-group">
                    <label>Identifiant du Compte </label>
                    <input type="text" id="id_du_compte" name="id_du_compte" required>
             </div>


                <div class="form-group">
                    <label> Valeur du découvert (€) </label>
                    <input type="text" id="valeurDecouvert" name="valeurDecouvert"  required>
                </div>
                <button class="btn-secondary" type="reset" name="Effacer_btn" id="Effacer_btn">Effacer</button>
                <button class="btn-primary" type="submit" id="modifier_btn_decouv" name="modifier_btn_decouv">Modifier</button>
            </form>


        </div>


<?php
// Code PHP pour modifier un découvert
if (isset($_POST['modifier_btn_decouv']) && isset($_POST['id_du_client']) && isset($_POST['valeurDecouvert']) && isset($_POST['id_du_compte'])) {
    $idClient = intval($_POST['id_du_client']); 
    $idCompte = intval($_POST['id_du_compte']); 
    $decouvert = intval($_POST['valeurDecouvert']); 

    $conn = new mysqli(SERVEUR, USER, PASSWORD, BDD);
    if ($conn->connect_error) {
        die("Échec de la connexion : " . $conn->connect_error);
    }

    // Vérifier si l'idClient et l'idCompte existent et correspondent
    $sql_check = "SELECT COUNT(*) AS count FROM Appartenir WHERE idCompte = ? AND idClient = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("ii", $idCompte, $idClient);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();
    $row_check = $result_check->fetch_assoc();

    if ($row_check['count'] == 0) {
        // Si l'idClient et l'idCompte ne correspondent pas ou n'existent pas
        echo '<div class="failure-message" id="msgRdv">Erreur : Le compte et le client ne correspondent pas ou n\'existent pas.</div>
              <script>
                    setTimeout(() => {
                        document.getElementById("msgRdv").style.display = "none";}, 2000);
              </script>';
        $stmt_check->close();
        $conn->close();
    }

    // Si la vérification est réussie, procéder à la mise à jour
    
    else{
    $sql_update = "UPDATE Appartenir SET MontantDec = ? WHERE idCompte = ? AND idClient = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("iii", $decouvert, $idCompte, $idClient); 

    if ($stmt_update->execute()) {
        echo '<div class="success-message" id="msgRdv"> Valeur du découvert (€) modifié avec succès ! </div>
              <script>
                    setTimeout(() => {
                        document.getElementById("msgRdv").style.display = "none";}, 2000);
              </script>';
    } else {
        echo '<div class="failure-message" id="msgRdv">Erreur SQL : ' . ($stmt_update->error) . '</div>
              <script>
                    setTimeout(() => {
                        document.getElementById("msgRdv").style.display = "none";}, 2000);
              </script>';
    }

    $stmt_update->close();
    $conn->close();
}
}
?>    




         <!--Résilier un contrat-->
        <div id="resiliercontrat" class="tab-content">
            <h2> Résilier un contrat d'un client </h2>
            <br>

            <form id="ResilierForm" method="POST">
             <div class="form-group">
                    <label>Identifiant du client </label>
                    <input type="text" id="id_du_client_contrat" name="id_du_client_contrat" required>
             </div>


                <div class="form-group">
                    <label>ID du contrat </label>
                    <input type="text" id="id_du_contrat_client" name="id_du_contrat_client"  required>
                </div>



                 <button class="btn-secondary" type="reset" name="Effacer_btn" id="filter">Effacer</button>
                <button class="btn-primary" type="submit" id="resilier_btn_contrat" name="resilier_btn_contrat">Résilier</button>
            </form>




        </div>




<?php
if (isset($_POST['resilier_btn_contrat']) && isset($_POST['id_du_client_contrat']) && isset($_POST['id_du_contrat_client'])) {
    $idClient = intval($_POST['id_du_client_contrat']); 
    $idContrat = intval($_POST['id_du_contrat_client']); 

    $conn = new mysqli(SERVEUR, USER, PASSWORD, BDD);
    if ($conn->connect_error) {
        die("Échec de la connexion : " . $conn->connect_error);
    }

    // Vérifier si l'idClient et l'idCompte existent et correspondent
    $sql_check = "SELECT COUNT(*) AS count FROM Detenir WHERE IdContrat = ? AND IdClient = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("ii", $idContrat, $idClient);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();
    $row_check = $result_check->fetch_assoc();

    if ($row_check['count'] == 0) {
        // Si l'idClient et l'idCompte ne correspondent pas ou n'existent pas
        echo '<div class="failure-message" id="msgRdv">Erreur : Le contrat et le client ne correspondent pas ou n\'existent pas.</div>
              <script>
                    setTimeout(() => {
                        document.getElementById("msgRdv").style.display = "none";}, 2000);
              </script>';
        $stmt_check->close();
        $conn->close();
    }

    // Si la vérification est réussie, procéder à la Suppression
    
    else{
    $sql_update = "DELETE FROM Detenir WHERE IdContrat = ? AND IdClient = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("ii", $idContrat, $idClient);

    if ($stmt_update->execute()) {
        echo '<div class="success-message" id="msgRdv"> Contrat résilié avec succès ! </div>
              <script>
                    setTimeout(() => {
                        document.getElementById("msgRdv").style.display = "none";}, 2000);
              </script>';
    } else {
        echo '<div class="failure-message" id="msgRdv">Erreur SQL : ' . ($stmt_update->error) . '</div>
              <script>
                    setTimeout(() => {
                        document.getElementById("msgRdv").style.display = "none";}, 2000);
              </script>';
    }

    $stmt_update->close();
    $conn->close();
}
}
?>         



         <!--Résilier un compte-->
        <div id="resiliercompte" class="tab-content">
            <h2> Résilier un compte d'un client </h2>
            <br>

            <form id="ResilierForm" method="POST">
             <div class="form-group">
                    <label>Identifiant du client </label>
                    <input type="text" id="id_du_client_compte" name="id_du_client_compte" required>
             </div>

                <div class="form-group">
                    <label>ID du compte </label>
                    <input type="text" id="id_du_compte_client" name="id_du_compte_client"  required>
                </div>



                 <button class="btn-secondary" type="reset" name="Effacer_btn" id="Effacer_btn">Effacer</button>
                <button class="btn-primary" type="submit" id="resilier_btn_compte" name="resilier_btn_compte">Résilier</button>
            </form>


        </div>


    </div>


<?php
if (isset($_POST['resilier_btn_compte']) && isset($_POST['id_du_client_compte']) && isset($_POST['id_du_compte_client'])) {
    $idClient = intval($_POST['id_du_client_compte']); 
    $idCompte = intval($_POST['id_du_compte_client']); 

    $conn = new mysqli(SERVEUR, USER, PASSWORD, BDD);
    if ($conn->connect_error) {
        die("Échec de la connexion : " . $conn->connect_error);
    }

    // Vérifier si l'idClient et l'idCompte existent et correspondent
    $sql_check = "SELECT COUNT(*) AS count FROM Appartenir WHERE idCompte = ? AND idClient = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("ii", $idCompte, $idClient);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();
    $row_check = $result_check->fetch_assoc();

    if ($row_check['count'] == 0) {
        // Si l'idClient et l'idCompte ne correspondent pas ou n'existent pas
        echo '<div class="failure-message" id="msgRdv">Erreur : Le compte et le client ne correspondent pas ou n\'existent pas.</div>
              <script>
                    setTimeout(() => {
                        document.getElementById("msgRdv").style.display = "none";}, 2000);
              </script>';
        $stmt_check->close();
        $conn->close();
    }

    // Si la vérification est réussie, procéder à la Suppression
    
    else{
    $sql_update = "DELETE FROM Appartenir WHERE IdCompte = ? AND IdClient = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("ii", $idCompte, $idClient);

    if ($stmt_update->execute()) {
        echo '<div class="success-message" id="msgRdv"> Compte résilié avec succès ! </div>
              <script>
                    setTimeout(() => {
                        document.getElementById("msgRdv").style.display = "none";}, 2000);
              </script>';
    } else {
        echo '<div class="failure-message" id="msgRdv">Erreur SQL : ' . ($stmt_update->error) . '</div>
              <script>
                    setTimeout(() => {
                        document.getElementById("msgRdv").style.display = "none";}, 2000);
              </script>';
    }

    $stmt_update->close();
    $conn->close();
}
}
?>  




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