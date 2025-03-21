<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <link rel="stylesheet" href="style1.css" />

    <title> Directeur l'agence</title>
    
</head>



<body>
<div class="header">
    <a href="site.php">
        <img class="logo" src="images/banque.png" alt="Logo" title="Logo">
    </a>
    <h1 class="title"> Directeur de l'Agence</h1>

    <button class="deconnect-btn" onclick="logout()">Déconnexion</button>

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
            <button class="tab active" onclick="openTab(event, 'Newemployees')"> Nouveau Employé</button>
            <button class="tab" onclick="openTab(event, 'employees')">Gestion Employés</button>
            <button class="tab" onclick="openTab(event, 'contracts')">Gestion Contrats</button>
            <button class="tab" onclick="openTab(event, 'comptes')">Gestion Comptes</button>
            <button class="tab" onclick="openTab(event, 'documents')">Documents Requis</button>
            <button class="tab" onclick="openTab(event, 'stats')">Statistiques</button>
        </div>


        <!-- Nouveau Employés -->
        <div id="Newemployees" class="tab-content active">

            <h2>Informations Professionnelles </h2>
            <br>

            <form id="newemployeeForm" method="POST">

            <div class="form-group">
                    <label>Identifiant</label>
                    <input type="number" id="identifiantEmp" name="identifiantEmp"required>

             </div>

             <div class="form-group">
                    <label>Nom</label>
                    <input type="text" id="NomEmp" name="NomEmp"required>

             </div>

                <div class="form-group">
                    <label>Prénom </label>
                    <input type="text" id="prenomEmp" name="prenomEmp"  required>
                </div>

           <div class="form-group">
                    <label>Rôle</label>
                    <select id="roleEmploye"  name="roleEmploye" required>
                        <option value="Conseiller">Conseiller</option>
                        <option value="Agent">Agent</option>
                        <option value="Directeur">Directeur</option>

                    </select>
            </div> 
                <button type="submit" class="btn-primary" id="addEmployeee" name="addEmployeee">Créer l'employé</button>
                <button class="btn-secondary" type="reset" name="delete_btn" id="delete_btn">Effacer</button>

            </form>

        </div>



<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Connexion à la base de données
    $conn = new mysqli(SERVEUR, USER, PASSWORD, BDD);
    
    if ($conn->connect_error) {
        die("Échec de la connexion : " . $conn->connect_error);
    }

$identifiantEmp = isset($_POST['identifiantEmp']) ? (int)$_POST['identifiantEmp'] : 0;
$nomEmploye = isset($_POST['NomEmp']) ? $_POST['NomEmp'] : '';
$prenomEmploye = isset($_POST['prenomEmp']) ? $_POST['prenomEmp'] : '';
$roleEmployee = isset($_POST['roleEmploye']) ? $_POST['roleEmploye'] : '';


    if (isset($_POST['addEmployeee'])) {

        // Ajouter à la table Employe
        $sql = "INSERT INTO Employe (IdEmp, NomEmp, PrenomEmp, Role) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isss", $identifiantEmp, $nomEmploye, $prenomEmploye, $roleEmployee);


            if ($stmt->execute()) {
            // Vérifier le rôle et mettre à jour la table appropriée
            if ($roleEmployee === 'Directeur') {
             // Mettre à jour la table Directeur
                $sql = "INSERT INTO Directeur (IdEmp, NomDirect, PrenomDirect) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("iss", $identifiantEmp, $nomEmploye, $prenomEmploye);

            } else if ($roleEmployee === 'Agent') {
                // Mettre à jour la table Agent
                $sql = "INSERT INTO Agent (IdEmp, NomAgent, PrenomAgent) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("iss", $identifiantEmp, $nomEmploye, $prenomEmploye);

            } else if ($roleEmployee === 'Conseiller') {
                // Mettre à jour la table Conseiller
                $sql = "INSERT INTO Conseiller (IdEmp, NomConseiller, PrenomConseiller) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("iss", $identifiantEmp, $nomEmploye, $prenomEmploye);
            } else {
                exit;
            }

            // Exécuter la mise à jour de la table appropriée
            if ($stmt->execute()) {
                echo '<div class="success-message" id="msgDiv"> L\'employé a été créé avec succès !</div>
                      <script>
                          setTimeout(() => {
                              document.getElementById("msgDiv").style.display = "none";
                          }, 2000);
                      </script>';
            } else {
                echo "Erreur" . $role . ": " . $stmt->error;
            }
        } else {
            echo "Erreur : " . $stmt->error;
        }

}
$conn->close();
}
?>




         <!-- GESTION DES ÉMPLOYÉS -->

        <div id="employees" class="tab-content">

            <h2>Gestion des Employés </h2>
            <br>

            <form id="employeeForm" method="POST">

            <div class="form-group">
                    <label>Identifiant</label>
                    <input type="text" id="identifiant" name="identifiant"required>

             </div>

             <div class="form-group">
                    <label>Login</label>
                    <input type="text" id="loginEmp" name="loginEmp"required>

             </div>


                <div class="form-group">
                    <label>Mot de passe</label>
                    <input type="text" id="password" name="password"  required>
                </div>

         <!--    <div class="form-group">
                    <label>Rôle</label>
                    <select id="role"  name="role" required>
                        <option value="conseiller">Conseiller</option>
                        <option value="agent">Agent</option>
                        <option value="agent">Directeur</option>

                    </select> 


                </div> -->
                <button type="submit" class="btn" id="add" name="add">Créer</button>
                <button class="btn btn-edit" id="edit" name="edit">Modifier</button>
                <button class="btn btn-delete" id="delete" name="delete">Supprimer</button>
            </form>

        </div>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Connexion à la base de données
    $conn = new mysqli(SERVEUR, USER, PASSWORD, BDD);
    
    if ($conn->connect_error) {
        die("Échec de la connexion : " . $conn->connect_error);
    }

$identifiant = isset($_POST['identifiant']) ? (int)$_POST['identifiant'] : 0;
$login = isset($_POST['loginEmp']) ? $_POST['loginEmp'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';


if (!empty($login) && !empty($password) && !empty($identifiant)) {

    // CRÉÉR LOGIN ET MOT DE PASSE

    if (isset($_POST['add'])) {
        // Récupérer le rôle depuis la table Employe
        $sql = "SELECT Role FROM Employe WHERE IdEmp = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $identifiant);
        $stmt->execute();
        $stmt->bind_result($role);
        $stmt->fetch();
        $stmt->close();

        // Mettre à jour la table Employe
        $sql = "UPDATE Employe SET LoginEmp = ?, MdpEmp = ? WHERE IdEmp = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $login, $password, $identifiant);

        if ($stmt->execute()) {
            // Vérifier le rôle et mettre à jour la table appropriée
            if ($role === 'Directeur') {
             // Mettre à jour la table Directeur
                $sql = "UPDATE Directeur SET LoginDirect = ?, MdpDirect = ? WHERE IdEmp = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssi", $login, $password, $identifiant);

            } else if ($role === 'Agent') {
                // Mettre à jour la table Agent
                $sql = "UPDATE Agent SET LoginAgent = ?, MdpAgent = ? WHERE IdEmp = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssi", $login, $password, $identifiant);

            } else if ($role === 'Conseiller') {
                // Mettre à jour la table Conseiller
                $sql = "UPDATE Conseiller SET LoginConseiller = ?, MdpConseiller = ? WHERE IdEmp = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssi", $login, $password, $identifiant);
            } else {
                exit;
            }

            // Exécuter la mise à jour de la table appropriée
            if ($stmt->execute()) {
                echo '<div class="success-message" id="msgDiv"> Login et Password créé avec succès !</div>
                      <script>
                          setTimeout(() => {
                              document.getElementById("msgDiv").style.display = "none";
                          }, 2000);
                      </script>';
            } else {
                echo "Erreur" . $role . ": " . $stmt->error;
            }
        } else {
            echo "Erreur : " . $stmt->error;
        }

        $stmt->close();
    }
    
// MODIFIER LOGIN ET MOT DE PASSE

    if (isset($_POST['edit'])) {
        // Récupérer le rôle depuis la table Employe
        $sql = "SELECT Role FROM Employe WHERE IdEmp = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $identifiant);
        $stmt->execute();
        $stmt->bind_result($role);
        $stmt->fetch();
        $stmt->close();

        // Mettre à jour la table Employe
        $sql = "UPDATE Employe SET LoginEmp = ?, MdpEmp = ? WHERE IdEmp = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $login, $password, $identifiant);

        if ($stmt->execute()) {
            // Vérifier le rôle et mettre à jour la table appropriée
            if ($role === 'Directeur') {
             // Mettre à jour la table Directeur
                $sql = "UPDATE Directeur SET LoginDirect = ?, MdpDirect = ? WHERE IdEmp = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssi", $login, $password, $identifiant);

            } else if ($role === 'Agent') {
                // Mettre à jour la table Agent
                $sql = "UPDATE Agent SET LoginAgent = ?, MdpAgent = ? WHERE IdEmp = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssi", $login, $password, $identifiant);

            } else if ($role === 'Conseiller') {
                // Mettre à jour la table Conseiller
                $sql = "UPDATE Conseiller SET LoginConseiller = ?, MdpConseiller = ? WHERE IdEmp = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssi", $login, $password, $identifiant);
            } else {
                exit;
            }

            // Exécuter la mise à jour de la table appropriée
            if ($stmt->execute()) {
                echo '<div class="success-message" id="msgDiv"> Login et Password mis à jour avec succès !</div>
                      <script>
                          setTimeout(() => {
                              document.getElementById("msgDiv").style.display = "none";
                          }, 2000);
                      </script>';
            } else {
                echo "Erreur" . $role . ": " . $stmt->error;
            }
        } else {
            echo "Erreur : " . $stmt->error;
        }

        $stmt->close();
    }



// DELETE LOGIN ET MOT DE PASSE

        if (isset($_POST['delete'])) {
        // Récupérer le rôle depuis la table Employe
        $sql = "SELECT Role FROM Employe WHERE IdEmp = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $identifiant);
        $stmt->execute();
        $stmt->bind_result($role);
        $stmt->fetch();
        $stmt->close();

        // Mettre à jour la table Employe
        $sql = "UPDATE Employe SET LoginEmp = NULL, MdpEmp = NULL WHERE IdEmp = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $identifiant);

        if ($stmt->execute()) {
            // Vérifier le rôle et mettre à jour la table appropriée
            if ($role === 'Directeur') {
             // Mettre à jour la table Directeur
                $sql = "UPDATE Directeur SET LoginDirect = NULL, MdpDirect = NULL WHERE IdEmp = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $identifiant);

            } else if ($role === 'Agent') {
                // Mettre à jour la table Agent
                $sql = "UPDATE Agent SET LoginAgent = NULL, MdpAgent = NULL WHERE IdEmp = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $identifiant);

            } else if ($role === 'Conseiller') {
                // Mettre à jour la table Conseiller
                $sql = "UPDATE Conseiller SET LoginConseiller = NULL, MdpConseiller = NULL WHERE IdEmp = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $identifiant);
            } else {
                exit;
            }

            // Exécuter la mise à jour de la table appropriée
            if ($stmt->execute()) {
                echo '<div class="success-message" id="msgDiv"> Login et Password supprimé avec succès !</div>
                      <script>
                          setTimeout(() => {
                              document.getElementById("msgDiv").style.display = "none";
                          }, 2000);
                      </script>';
            } else {
                echo "Erreur" . $role . ": " . $stmt->error;
            }
        } else {
            echo "Erreur : " . $stmt->error;
        }

        $stmt->close();
    }




    

 }



$conn->close();
}
?>

<!-- FIN GESTION DES ÉMPLOYÉS -->






<!-- GESTION DES CONTRATS -->

        <div id="contracts" class="tab-content">
            <h2>Gestion des Contrats</h2>
             <br>


        <form id="contractForm" method="POST">
                <div class="form-group">
                    <label>ID du Contrat</label>
                    <input type="text" id="idcontrat" name="idcontrat" required>
                </div>

                <div class="form-group">
                    <label>Nom du Contrat</label>
                    <input type="text" id="contractName" name="contractName"  required>
                </div>
                <button type="submit" class="btn" id="addContrat" name="addContrat">Ajouter Contrat</button>
                <button class="btn btn-edit" id="modifContrat" name="modifContrat">Modifier</button>
                <button class="btn btn-delete" id="deleteContrat" name="deleteContrat">Supprimer</button>
            </form>

        </div>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Connexion à la base de données
    $conn = new mysqli(SERVEUR, USER, PASSWORD, BDD);
    
    if ($conn->connect_error) {
        die("Échec de la connexion : " . $conn->connect_error);
    }


// AJOUTER CONTRAT

// Récupérer les données du formulaire
$idContrat = isset($_POST['idcontrat']) ? (int) $_POST['idcontrat'] : 0;
$nomContrat = isset($_POST['contractName']) ? $_POST['contractName'] : '';    

if (!empty($idContrat) && !empty($nomContrat)) {

    // Vérifier que les données ne sont pas vides
    if (isset($_POST['addContrat'])) {
        // Ajouter un contrat
        $sql = "INSERT INTO Contrat (IdContrat, TypeContrat) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $idContrat, $nomContrat); 

        // Si l'insertion dans Compte réussit, ajouter le motif correspondant dans la table Motif
        $sqlMotif = "INSERT INTO Motif (NomMotif) VALUES (?)";
        $stmtMotif = $conn->prepare($sqlMotif);
        $stmtMotif->bind_param("s", $nomContrat);


        if ($stmt->execute()&& $stmtMotif->execute()) {
            echo '<div class="success-message" id="contratDiv"> Contrat ajouté avec succès ! </div>
                  <script>
                      setTimeout(() => {
                          document.getElementById("contratDiv").style.display = "none";
                      }, 2000);
                  </script>';
        } else {
            echo '<div class="failure-message" id="contratDiv" > Erreur: ' . $stmt->error.'</div>
                <script>
                      setTimeout(() => {
                          document.getElementById("contratDiv").style.display = "none";
                      }, 2000);
                  </script>';
        }

        $stmt->close();
    }


        // MODIFIER CONTRAT
    if (isset($_POST['modifContrat'])) {

    // 1 : Récupérer l'ancien TypeCompte
    $sqlAncienType = "SELECT TypeContrat FROM Contrat WHERE IdContrat = ?";
    $stmtAncienType = $conn->prepare($sqlAncienType);
    $stmtAncienType->bind_param("i", $idContrat);
    $stmtAncienType->execute();
    $stmtAncienType->bind_result($ancienTypeCompte);
    $stmtAncienType->fetch();
    $stmtAncienType->close();

    // 2 Modifier un contrat
    $sql = "UPDATE Contrat SET TypeContrat = ? WHERE IdContrat = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $nomContrat, $idContrat); 

    // 3 : Mettre à jour le motif correspondant
    $sqlUpdateMotif = "UPDATE Motif SET NomMotif = ? WHERE NomMotif = ?";
    $stmtUpdateMotif = $conn->prepare($sqlUpdateMotif);
    $stmtUpdateMotif->bind_param("ss", $nomContrat, $ancienTypeCompte);
 

        if ($stmt->execute() && $stmtUpdateMotif->execute()) {
            echo '<div class="success-message" id="contratDiv"> Contrat modifié avec succès ! </div>
                  <script>
                      setTimeout(() => {
                          document.getElementById("contratDiv").style.display = "none";
                      }, 2000);
                  </script>';
        } else {
            echo '<div class="failure-message" id="contratDiv" > Erreur: ' . $stmt->error.'</div>
                <script>
                      setTimeout(() => {
                          document.getElementById("contratDiv").style.display = "none";
                      }, 2000);
                  </script>';
        }

        $stmt->close();
    }




        // DELETE CONTRAT
    if (isset($_POST['deleteContrat'])) {

        $sql = "DELETE FROM Contrat WHERE IdContrat = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $idContrat);

        // Supprimer dans la table Motif
        $sqlMotif = "DELETE FROM Motif WHERE NomMotif=? ";
        $stmtMotif = $conn->prepare($sqlMotif);
        $stmtMotif->bind_param("s", $nomContrat); 

        if ($stmt->execute() && $stmtMotif->execute()) {
            echo '<div class="success-message" id="contratDiv"> Contrat supprimé avec succès ! </div>
                  <script>
                      setTimeout(() => {
                          document.getElementById("contratDiv").style.display = "none";
                      }, 2000);
                  </script>';
        } else {
            echo '<div class="failure-message" id="contratDiv" > Erreur: ' . $stmt->error.'</div>
                <script>
                      setTimeout(() => {
                          document.getElementById("contratDiv").style.display = "none";
                      }, 2000);
                  </script>';
        }

        $stmt->close();
    }




}

$conn->close();
}
?>


<!--  FIN GESTION DES CONTRATS -->






 <!--   GESTION DES COMPTES -->

        <div id="comptes" class="tab-content">
            <h2>Gestion des Comptes</h2>
             <br>


        <form id="contractForm" method="POST">
                <div class="form-group">
                    <label>ID du Compte</label>
                    <input type="text" id="idcomptes" name="idcomptes" required>
                </div>

                <div class="form-group">
                    <label>Nom du Compte</label>
                    <input type="text" id="comptesName" name="comptesName"  required>
                </div>
                <button type="submit" class="btn" id="addcomptes" name="addcomptes">Ajouter Compte</button>
                <button class="btn btn-edit" id="modifcomptes" name="modifcomptes">Modifier</button>
                <button class="btn btn-delete" id="deletecomptes" name="deletecomptes">Supprimer</button>
            </form>

        </div>




<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Connexion à la base de données
    $conn = new mysqli(SERVEUR, USER, PASSWORD, BDD);
    
    if ($conn->connect_error) {
        die("Échec de la connexion : " . $conn->connect_error);
    }


// AJOUTER COMPTE

// Récupérer les données du formulaire
$idCompte = isset($_POST['idcomptes']) ? (int) $_POST['idcomptes'] : 0;
$nomCompte = isset($_POST['comptesName']) ? $_POST['comptesName'] : '';    

if (!empty($idCompte) && !empty($nomCompte)) {

    // Vérifier que les données ne sont pas vides
    if (isset($_POST['addcomptes'])) {
        // Ajouter un compte
        $sql = "INSERT INTO Compte (IdCompte, TypeCompte) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $idCompte, $nomCompte); 


        // Si l'insertion dans Compte réussit, ajouter le motif correspondant dans la table Motif
        $sqlMotif = "INSERT INTO Motif (NomMotif) VALUES (?)";
        $stmtMotif = $conn->prepare($sqlMotif);
        $stmtMotif->bind_param("s", $nomCompte);

        if ($stmt->execute() && $stmtMotif->execute()) {
            echo '<div class="success-message" id="compteDiv"> Compte ajouté avec succès ! </div>
                  <script>
                      setTimeout(() => {
                          document.getElementById("compteDiv").style.display = "none";
                      }, 2000);
                  </script>';
        } else {
            echo '<div class="failure-message" id="compteDiv" > Erreur: ' . $stmt->error.'</div>
                <script>
                      setTimeout(() => {
                          document.getElementById("compteDiv").style.display = "none";
                      }, 2000);
                  </script>';
        }

        $stmt->close();
    }


        // MODIFIER COMPTE
    if (isset($_POST['modifcomptes'])) {

    // 1 : Récupérer l'ancien TypeCompte
    $sqlAncienType = "SELECT TypeCompte FROM Compte WHERE IdCompte = ?";
    $stmtAncienType = $conn->prepare($sqlAncienType);
    $stmtAncienType->bind_param("i", $idCompte);
    $stmtAncienType->execute();
    $stmtAncienType->bind_result($ancienTypeCompte);
    $stmtAncienType->fetch();
    $stmtAncienType->close();

    // 2 : Mettre à jour le compte
    $sqlUpdateCompte = "UPDATE Compte SET TypeCompte = ? WHERE IdCompte = ?";
    $stmtUpdateCompte = $conn->prepare($sqlUpdateCompte);
    $stmtUpdateCompte->bind_param("si", $nomCompte, $idCompte);

    // 3 : Mettre à jour le motif correspondant
    $sqlUpdateMotif = "UPDATE Motif SET NomMotif = ? WHERE NomMotif = ?";
    $stmtUpdateMotif = $conn->prepare($sqlUpdateMotif);
    $stmtUpdateMotif->bind_param("ss", $nomCompte, $ancienTypeCompte);



        if ($stmtUpdateCompte->execute() && $stmtUpdateMotif->execute()) {
            echo '<div class="success-message" id="contratDiv"> Compte modifié avec succès ! </div>
                  <script>
                      setTimeout(() => {
                          document.getElementById("contratDiv").style.display = "none";
                      }, 2000);
                  </script>';
        } else {
            echo '<div class="failure-message" id="contratDiv" > Erreur: ' . $stmtUpdateCompte->error.'</div>
                <script>
                      setTimeout(() => {
                          document.getElementById("contratDiv").style.display = "none";
                      }, 2000);
                  </script>';
        }

        $stmtUpdateCompte->close();
    }




        // DELETE Compte
    if (isset($_POST['deletecomptes'])) {

        $sql = "DELETE FROM Compte WHERE IdCompte = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $idCompte);


        // Supprimer dans la table Motif
        $sqlMotif = "DELETE FROM Motif WHERE NomMotif=? ";
        $stmtMotif = $conn->prepare($sqlMotif);
        $stmtMotif->bind_param("s", $nomCompte); 

        if ($stmt->execute() && $stmtMotif->execute()) {
            echo '<div class="success-message" id="contratDiv"> Compte supprimé avec succès ! </div>
                  <script>
                      setTimeout(() => {
                          document.getElementById("contratDiv").style.display = "none";
                      }, 2000);
                  </script>';
        } else {
            echo '<div class="failure-message" id="contratDiv" > Erreur: ' . $stmt->error.'</div>
                <script>
                      setTimeout(() => {
                          document.getElementById("contratDiv").style.display = "none";
                      }, 2000);
                  </script>';
        }

        $stmt->close();
    }




}

$conn->close();
}
?>




<!--  FIN GESTION DES COMPTES -->















<!-- Liste des motifs en php pour le formulaire-->
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

        <!-- DOCUMENTS REQUIS --> 




        <div id="documents" class="tab-content">
            <h2>Gestion des Documents Requis</h2>
             <br>

            <form id="documentForm" method="POST">
                <div class="form-group">
                    <label>Identifiant Doc</label>
                    <input type="text" id="documentID" name="documentID" required>
                </div>

                <div class="form-group">
                    <label>Nom du Document</label>
                    <input type="text" name="documentName" id="documentName" required>
                </div>

                <div class="form-group">
                       <label>Motif</label>
                       <select id="motifName" name="motifName" required>
                             <option value="">Sélectionnez un motif</option>
                                <?php foreach ($motifs as $motif) : ?>
                            <option value="<?php echo $motif['IdMotif']; ?>">
                                <?php echo ($motif['NomMotif']); ?>
                            </option>
                            <?php endforeach; ?>
                    </select>
        </div>


                <button type="submit" class="btn" id="addDocuments" name="addDocuments">Ajouter Documents</button>
                <button class="btn btn-edit" id="modifDocuments" name="modifDocuments">Modifier</button>
                <button class="btn btn-delete"  id="delDocuments" name="delDocuments">Supprimer</button>            
            </form>

        </div>





<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Connexion à la base de données
    $conn = new mysqli(SERVEUR, USER, PASSWORD, BDD);
    
    if ($conn->connect_error) {
        die("Échec de la connexion : " . $conn->connect_error);
    }


    // Récupérer les données du formulaire -- Ajouter un document 

    $documentID = isset($_POST['documentID']) ? (int) $_POST['documentID'] : 0;
    $documentNom = isset($_POST['documentName']) ? $_POST['documentName'] : '';
    $idMotif = isset($_POST['motifName']) ? (int) $_POST['motifName'] : 0;

    if (!empty($documentID) && !empty($documentNom) && !empty($idMotif)) {
        if (isset($_POST['addDocuments'])) {
            // Insérer la pièce dans la table Piece
            $sqlInsertPiece = "INSERT INTO Piece (IdPiece,NomPiece) VALUES (?,?)";
            $stmtInsertPiece = $conn->prepare($sqlInsertPiece);
            $stmtInsertPiece->bind_param("is", $documentID, $documentNom);

            if ($stmtInsertPiece->execute()) {
                // Lier la pièce au motif dans la table Requerir
                $sqlInsertRequerir = "INSERT INTO Requerir (IdPiece, IdMotif) VALUES (?, ?)";
                $stmtInsertRequerir = $conn->prepare($sqlInsertRequerir);
                $stmtInsertRequerir->bind_param("ii", $documentID, $idMotif);

                if ($stmtInsertRequerir->execute()) {
                    echo '<div class="success-message" id="testDiv">Pièce ajoutée et liée au motif avec succès !</div>
                            <script>
                                setTimeout(() => {
                                        document.getElementById("testDiv").style.display = "none";
                                        }, 2000);
                                 </script>';
                } else {
                    echo '<div class="failure-message" id="testDiv">Erreur lors de la liaison de la pièce au motif : ' . $stmtInsertRequerir->error . '</div>
                                 <script>
                                setTimeout(() => {
                                        document.getElementById("testDiv").style.display = "none";
                                        }, 2000);
                                 </script>';
                }

                $stmtInsertRequerir->close();
            } else {
                echo '<div class="failure-message" id="testDiv">Erreur lors de l\'ajout de la pièce : ' . $stmtInsertPiece->error . '</div>
                        <script>
                                setTimeout(() => {
                                        document.getElementById("testDiv").style.display = "none";
                                        }, 2000);
                        </script>';
            }

            $stmtInsertPiece->close();
        }


     // Modification d'un document existant
        if (isset($_POST['modifDocuments'])) {
            // Mettre à jour le nom de la pièce
            $sqlUpdatePiece = "UPDATE Piece SET NomPiece = ? WHERE IdPiece = ?";
            $stmtUpdatePiece = $conn->prepare($sqlUpdatePiece);
            $stmtUpdatePiece->bind_param("si", $documentNom, $documentID);

            if ($stmtUpdatePiece->execute()) {
                // Mettre à jour le motif associé
                $sqlUpdateRequerir = "UPDATE Requerir SET IdMotif = ? WHERE IdPiece = ?";
                $stmtUpdateRequerir = $conn->prepare($sqlUpdateRequerir);
                $stmtUpdateRequerir->bind_param("ii", $idMotif, $documentID);

                if ($stmtUpdateRequerir->execute()) {
                    echo '<div class="success-message" id="testDiv">Document modifié avec succès !</div>
                            <script>
                                setTimeout(() => {
                                        document.getElementById("testDiv").style.display = "none";
                                        }, 2000);
                                 </script>';
                } else {
                    echo '<div class="failure-message" id="testDiv">Erreur lors de la mise à jour du motif : ' . $stmtUpdateRequerir->error . '</div>
                                 <script>
                                setTimeout(() => {
                                        document.getElementById("testDiv").style.display = "none";
                                        }, 2000);
                                 </script>';
                }

                $stmtUpdateRequerir->close();
            } else {
                echo '<div class="failure-message" id="testDiv">Erreur lors de la mise à jour du document : ' . $stmtUpdatePiece->error . '</div>
                        <script>
                                setTimeout(() => {
                                        document.getElementById("testDiv").style.display = "none";
                                        }, 2000);
                        </script>';
            }

            $stmtUpdatePiece->close();
        }


 // Supprimer un document
        if (isset($_POST['delDocuments'])) {
            // D'abord supprimer les relations dans la table Requerir
            $sqlDeleteRequerir = "DELETE FROM Requerir WHERE IdPiece = ?";
            $stmtDeleteRequerir = $conn->prepare($sqlDeleteRequerir);
            $stmtDeleteRequerir->bind_param("i", $documentID);
            
            if ($stmtDeleteRequerir->execute()) {
                // Ensuite supprimer la pièce
                $sqlDeletePiece = "DELETE FROM Piece WHERE IdPiece = ?";
                $stmtDeletePiece = $conn->prepare($sqlDeletePiece);
                $stmtDeletePiece->bind_param("i", $documentID);
                
                if ($stmtDeletePiece->execute()) {
                    echo '<div class="success-message" id="testDiv">Document supprimé avec succès !</div>
                            <script>
                                setTimeout(() => {
                                        document.getElementById("testDiv").style.display = "none";
                                        }, 2000);
                                 </script>';
                } else {
                    echo '<div class="failure-message" id="testDiv">Erreur lors de la suppression du document : ' . $stmtDeletePiece->error . '</div>
                            <script>
                                setTimeout(() => {
                                        document.getElementById("testDiv").style.display = "none";
                                        }, 2000);
                            </script>';
                }
                
                $stmtDeletePiece->close();
            } else {
                echo '<div class="failure-message" id="testDiv">Erreur lors de la suppression des relations : ' . $stmtDeleteRequerir->error . '</div>
                        <script>
                            setTimeout(() => {
                                    document.getElementById("testDiv").style.display = "none";
                                    }, 2000);
                        </script>';
            }
            
            $stmtDeleteRequerir->close();
        }



    }
    
    $conn->close();
}
?>



<!-- FIN DOCUMENTS REQUIS -->




<!-- Statistiques php -->
<?php

$contracts = 0;
$rdv = 0;
$clients = 0;
$balance = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $conn = new mysqli(SERVEUR, USER, PASSWORD, BDD);

    if (isset($_POST['filter'])) {
        $start_date = $_POST['startDate'] ?? date('Y-m-d');
        $end_date = $_POST['endDate'] ?? date('Y-m-d');

        // Récupérer le nombre de contrats souscrits
        $result = $conn->query("SELECT COUNT(*) as count FROM Detenir WHERE DateDebut BETWEEN '$start_date' AND '$end_date'");
        $contracts = $result->fetch_assoc()['count'];

        // Récupérer le nombre de rendez-vous pris
        $result = $conn->query("SELECT COUNT(*) as count FROM Rendezvous WHERE DateRdv BETWEEN '$start_date' AND '$end_date'");
        $rdv = $result->fetch_assoc()['count'];

        // Récupérer le nombre total de clients
        $result = $conn->query("SELECT COUNT(*) as count FROM Client WHERE DateInscription BETWEEN '$start_date' AND '$end_date'");
        $clients = $result->fetch_assoc()['count'];

        // Récupérer le solde total de la banque
        $result = $conn->query("SELECT SUM(Solde) as total FROM Appartenir WHERE DateOuverture BETWEEN '$start_date' AND '$end_date'");
        $balance = $result->fetch_assoc()['total'];
    }

    $conn->close();
    
}

?>



 <!-- Statistiques -->
        <div id="stats" class="tab-content" >
            <h2>Statistiques de l'Agence</h2>
            <br>

         <div class="date-filter">
            <form method="POST" class="filters" action="#stats">
                <label>Date de début :</label>
                <input type="date" id="startDate" name="startDate">
                <label>Date de fin :</label>
                <input type="date" id="endDate" name="endDate">
                <button class="btn" type="submit" name="filter" id="filter">Filtrer</button>
            </form>

            </div>

             <br>

        <section class="stats">
            <div class="card">
                <h3>Contrats Souscrits</h3>
                <p><?= $contracts ?></p>
            </div>
            <div class="card">
                <h3>RDV Pris</h3>
                <p><?= $rdv ?></p>
            </div>
            <div class="card">
                <h3>Total Clients</h3>
                <p><?= $clients ?></p>
            </div>
            <div class="card">
                <h3>Solde Total</h3>
                <p><?= number_format($balance, 2, ',', ' ') ?> €</p>
            </div>
        </section>

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

</div>

    <footer>
        <p>&copy; 2025 Ma Banque. Tous droits réservés.</p>
    </footer>
</body>
</html>