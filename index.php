
<HTML>
<HEADER>
<!--<link rel="stylesheet" type="text/css" href="/style.css" /> -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</HEADER>
<BODY class="p-3 mb-2 bg-secondary text-white">


<?php
$Utilisateur = $MotDePasse = "";
?>


<div class="container p-3 mb-2 bg-secondary text-white">
	<H1 class="display-3 text-center text-uppercase"> Formulaire de connexion </H1><BR><BR>
	<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		<div class="form-group">
			<label for="Utilisateur">Utilisateur :</label>
			<input type="text" class="form-control" name="Utilisateur" id="Utilisateur" placeholder="Ex : robert" size="30" maxlength="10" />
		</div>
		<div class="form-group">
			<label for="MotDePasse">Mot de passe :</label>
			<input type="password" class="form-control" name="MotDePasse" id="MotDePasse" placeholder="Ex : mon mot de passe" size="30" maxlength="10" />
			<BR>
			<input type="submit" class="btn btn-primary btn-lg btn-block" value="Connexion" />
		</div>
	</form>
</div>

<?php
	echo $_POST["Utilisateur"];
	echo "<BR>".$_POST["MotDePasse"];
    try{
		$db = new PDO('sqlite:'.dirname(__FILE__).'/DB/sqlite_connexion'); 
		$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // ERRMODE_WARNING | ERRMODE_EXCEPTION | ERRMODE_SILENT		
		$stmt = $db->prepare("select * from connexion where name= :nom and password= :pwd and actif=1 limit 1");
		$stmt->execute(array(':nom' => $_POST["Utilisateur"], ':pwd' => $_POST["MotDePasse"]));
		$result = $stmt->fetchAll();
		if ($result==NULL) {
			echo "PAS D'ENREGISTREMENT";
			// Code pour retourner sur la page d'identification
			header("Location: http://212.83.191.218/index.php");
		} else {
			// Code pour effectuer la redirection vers l'url
			foreach ($result as $row) {
				$redirectionURL=$row['url'];
				echo "<BR> URL : ".$redirectionURL;
				header("Status: 301 Moved Permanently", false, 301);
				//header("Location: http://www.free.fr");
				header("Location: ".$redirectionURL);
				exit();
		}
		}
		
	} catch(Exception $e) {
		echo "Impossible d'accéder à la base de données SQLite : ".$e->getMessage();
		die();
	}

		
?>

</BODY>
</HTML>

