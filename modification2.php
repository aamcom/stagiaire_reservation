<?php
include('config.php');
if (isset($_POST['nom']) AND ($_POST['email']) AND ($_POST['people']) AND ($_POST['montant']) AND ($_POST['datediner']) AND ($_POST['etat']))
{
	$c_email = htmlspecialchars($_POST['email']);

	if (preg_match("#^[a-z0-9.-_]+@[a-z0-9.-_]{2,}\.[a-z]{2,4}$#", $c_email))
	{
		$date = htmlspecialchars($_POST['datediner']);
		$time = htmlspecialchars($_POST['heurediner']);
		$dt = date('Y-m-d H:i:s', strtotime("$date $time"));
		
		$dt_to_prep = new DateTime($dt);
		$timeToAdd = 2;
		$dt_to_prep->add(new DateInterval("PT{$timeToAdd}H"));
		$dt_to = $dt_to_prep->format('Y-m-d H:i:s');
		
		$people = htmlspecialchars($_POST['people']);
		$total = htmlspecialchars($_POST['montant']);
		$etat = $_POST['etat'];
		$c_lname = htmlspecialchars($_POST['nom']);
		
		$idligne = $_GET['idligne'];
		//echo "dt : $dt <br>dt_to : $dt_to <br>people : $people <br>total : $total <br>etat : $etat <br>lname : $c_lname <br>email : $c_email <br>";
		try
		{
			$bdd = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $login, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		}
		catch(Exception $e)
		{
		  	die('Erreur : '.$e->getMessage());
		}
		$reponse = $bdd->prepare('UPDATE bk2020_restaurantbooking_bookings SET dt = :dt, dt_to = :dt_to, people = :people, total = :total, status = :status, c_lname = :c_lname, c_email = :c_email WHERE id = :id');
		$reponse->execute(array(
			"dt" => $dt,
			"dt_to" => $dt_to,
			"people" => $people,
			"total" => $total,
			"status" => $etat,
			"c_lname" => $c_lname,
			"c_email" => $c_email,
			"id" => $_GET['idligne']
		));
		echo 'Réservation modifiée.';
		header('Refresh:2;url="reservations.php"');
	}
	else
	{
		echo 'Email non valide.';
		?><br><a href="modification.php?idligne=<?php echo $_GET['idligne'];?>">Retour</a><?php
		//header('Refresh:3;url="modification.php?idligne="' .echo $idligne;);
	}
}
else
{
	echo 'Tout les champs n\'ont pas été remplis.';
	?><br><a href="modification.php?idligne=<?php echo $_GET['idligne'];?>">Retour</a><?php
 	//header("Refresh:3;url=$lienret");
}
?>
