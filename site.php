<!DOCTYPE html>
<html lang="fr">
    <head>
      <title>Ma page</title>
      <meta charset="utf-8">
      <link rel="stylesheet" href="style.css" />
	  
	  
    </head>
    
	<body>	
	  
	  <header>
	  	
	  	<div class="logo"> <img src="images/banque.png" alt="logo" title="logo"/> </div>

	  	<nav>
	  		     <ul>
                <li><a href="site.php">Accueil</a></li>
                <li><a href="comptes.html">Comptes et Services</a></li>
                <li><a href="banque-en-ligne.html">Banque en Ligne</a></li>
                <li><a href="tarifs.html">Tarifs & Simulations</a></li>
                <li><a href="contact.html">Contact</a></li>
                <li><a href="a-propos.html">À propos de Nous</a></li>
            </ul>
	  	</nav>



	  </header>

<?php
try {
    require_once('connect.php');
    $connexion = new PDO('mysql:host=' . SERVEUR . ';dbname=' . BDD, USER, PASSWORD);
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_POST['connecter'])) {
        $identifiant = $_POST['identifiant'];
        $password = $_POST['password'];

        $requete = "SELECT LoginEmp, MdpEmp, Role FROM Employe WHERE LoginEmp = :identifiant";
        $stmt = $connexion->prepare($requete);
        $stmt->bindParam(':identifiant', $identifiant, PDO::PARAM_STR);
        $stmt->execute();

        $resultat = $stmt->fetch(PDO::FETCH_OBJ);

        if ($resultat && $password === $resultat->MdpEmp) {
            switch ($resultat->Role) {
                case 'Directeur':
                    header('Location: directeur.php');
                    exit;
                case 'Agent':
                    header('Location: agent.php');
                    exit;
                case 'Conseiller':
                    header('Location: conseiller.php');
                    exit;
            }
        } else {
            echo "<script>alert('Identifiant ou mot de passe incorrect.');</script>";
        }
    }
} catch (Exception $e) {
    $msg = 'ERREUR dans ' . $e->getFile() . ' Ligne ' . $e->getLine() . ' : ' . $e->getMessage();
    exit($msg);
}
?>






	  <aside> 

	  	<article class="bulle"> 
	  			<h5> ALERTE SMS ! </h5>
	  			<div class="image"> <img src="images/sms.jpg" alt="mac" title="mac"> </div>
	  			<p> Recevez partout et à tout moment les informations clés de vos comptes directement sur votre mobile. </p>

	  	</article>

	  	<article class="bulle">
	  		<h5> ACHETER ET VENDRE DES DEVISES </h5>
	  		<div class="image"> <img src="images/euro.jpg" alt="dd" title="dd"> </div>
	  		<p>Préparer votre séjour, découvrez comment acheter ou vendre des devises. </p>
	  	</article>


	  	<article class="bulle">
	  		<h5> ÉPARGNE </h5>
	  		<div class="image"> <img src="images/saving.png" alt="cle" title="cle"> </div>
	  		<p>  Un service d'épargne personnalisable qui vous permet d'alimenter un ou plusieurs comptes d'épargne, ouverts dans la même agence. </p>
	  	</article>

	  	<article class="bulle">
	  		<h5> DÉMÉNAGER </h5>
	  		<div class="image"> <img src="images/demenager.png" align="sd" title="sd"> </div>
	  		<p>  Découvrir nos solutions pour simplifier votre déménagement : transfert de comptes, formalités bancaires. </p>
	  	</article>

	  </aside>


	  <div class="centrale">

	  	<form method="post" action="site.php"> 


			<fieldset>
					<legend>Connexion à votre compte</legend> 

				<p>
						<label for="pseudo">Identifiant: </label>
						<input type="text" name="identifiant" id="identifiant" placeholder="Votre identifiant" required/>
			  </p>

			  <p>
						<label for="pseudo">Mot de passe : </label>
						<input type="text" name="password" id="password" placeholder="Votre mot-de-passe"required/>
			  </p>


				</fieldset>


					<p> <label class="pas_de_style"> &nbsp;</label><input type="reset" value="Effacer"/>  <input type="submit" name ="connecter" value="Se connecter"/> </p> 

</form> 

	  </div>

	    <footer>
        <p>&copy; 2025 Ma Banque. Tous droits réservés.</p>
    </footer>
    </body>

</html>
