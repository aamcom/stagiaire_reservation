<?php
			include("config.php");
			include("menu.php");
			try
			{
				$bdd = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $login, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
			}
			catch(Exception $e)
			{
	   			die('Erreur : '.$e->getMessage());
			}
			$req = $bdd->prepare('DELETE FROM bk2020_restaurantbooking_bookings WHERE id=:id');
			$req->execute(array(
				"id" => $_GET['idligne']));
			echo 'La réservation '. $_GET['idligne'] . ' a bien été supprimée.';
			header('refresh:3;url="reservations.php"');
?>