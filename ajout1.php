<?php
include('config.php');
if (isset($_POST['nom']) AND ($_POST['email']) AND ($_POST['people']) AND ($_POST['montant']) AND ($_POST['datediner']) AND ($_POST['etat']))
{
	$c_email = htmlspecialchars($_POST['email']);

	if (preg_match("#^[a-z0-9.-_]+@[a-z0-9.-_]{2,}\.[a-z]{2,4}$#", $c_email))
	{
		$dt = htmlspecialchars($_POST['datediner']);
		$dt_prep = new DateTime($dt);
		$timeToAdd = 2;
		$dt_prep->add(new DateInterval("PT{$timeToAdd}H"));
		$dt_to = $dt_prep->format('Y-m-d H:i:s');
		$people = htmlspecialchars($_POST['people']);
		$total = htmlspecialchars($_POST['montant']);
		$etat = $_POST['etat'];
		$c_lname = htmlspecialchars($_POST['nom']);
		$now = date_create("Europe/Paris");
		$created = date_format($now, "Y-m-d H:i:s");
		//echo "dt : $dt <br>dt_to : $dt_to <br>people : $people <br>total : $total <br>etat : $etat <br>lname : $c_lname <br>email : $c_email <br>created on : $created <br>";
		try
		{
			$bdd = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $login, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		}
		catch(Exception $e)
		{
	   		die('Erreur : '.$e->getMessage());
		}
		$req = $bdd->prepare('INSERT INTO bk2020_restaurantbooking_bookings VALUES (NULL, NULL, NULL, :dt, :dt_to, :people, NULL, :total, "00.00", NULL, "stripe", "F", :status, NULL, NULL, :created, NULL, NULL, "Nicolas", :c_lname, "0781726273", :c_email, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, "0", "0", "0", "0", "0", "0", "0", "2021-12-31 00:00:00")');
		//echo "test";
		$req->execute(array(
			'dt' => $dt,
			'dt_to' => $dt_to,
			'people' => $people,
			'total' => $total,
			'status' => $etat,
			'created' => $created,
			'c_lname' => $c_lname,
			'c_email' => $c_email
			));
		echo "La réservation a bien été ajoutée.";
		header('Refresh:3;url="reservations.php"');
	}
	else
	{
		echo 'Email non valide.';
		header('Refresh:3;url="ajout.php"');
	}
}
else
{
 	echo 'Tout les champs n\'ont pas été remplis.';
 	header('Refresh:3;url="ajout.php"');
}
?>