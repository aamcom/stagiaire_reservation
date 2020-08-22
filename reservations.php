<?php include("config.php");?>
<!DOCTYPE HTML>
<html>
	<head>
	<meta charset=UTF-8>
	<link rel="stylesheet" type="css" href="reservationsstyle.css">
	<title>Réservations</title>
	</head>
	<body>
		<?php include("menu.php");?>
		<nav class="content">
			<form method='post' name='date_pre' id='datepreform'>
				<select name ='date_pre'>
					<optgroup label="Réservations datant de">
						<option value='aujd'>Aujourd'hui</option>
						<option value='hier'>Hier</option>
						<option value='lastw'>7 derniers jours</option>
						<option value='currentm'>Mois en cours</option>
						<option value='lastm'>Mois dernier</option>
						<?/*<option value='annee'>Cette année</option>*/?>
					</optgroup>
					<input type="submit" name="Valider">
				</select>
			</form>

			<form method='post' name='date' id="dateform">
				<label for='date1'>Réservations entre le</label>
					<input type="date" name="date1">
				<label for='date2'> et le</label>
					<input type="date" name="date2">
					<input type="submit" name="Valider">
			</form>

			<?php
			$date=date_create("Europe/Paris");
			//date_time_set($date,23,59,59);
			//date_sub($date,date_interval_create_from_date_string("1 month"));
			echo date_format($date, "Y-m-d H:i:s");
			?>

			<table>

				<caption>Réservations</caption>
				<tr>
					<th>Date de réservation</th>
					<th>Nom</th>
					<th>Email</th>
					<th>Participants</th>
					<th>Montant</th>
					<th>Date du dîner</th>
					<th>Etat</th>
				</tr>

				<?php
				if (isset($_POST["date_pre"]))
				{
					if ($_POST["date_pre"]=="aujd")
					{
						$date_pre1=date_create("Europe/Paris");
						date_time_set($date_pre1,00,00,00);
						$date_pre1=date_format($date_pre1, "Y-m-d H:i:s");
						$date_pre2=date_create("Europe/Paris");
						date_time_set($date_pre2,23,59,59);
						$date_pre2=date_format($date_pre2, "Y-m-d H:i:s");
					}
					elseif ($_POST["date_pre"]=="hier")
					{
						$date_pre1=date_create("Europe/Paris");
						$date_pre2=date_create("Europe/Paris");
						date_time_set($date_pre1,00,00,00);
						date_time_set($date_pre2,23,59,59);
						date_modify($date_pre1,"-1 day");
						date_modify($date_pre2,"-1 day");
						$date_pre1=date_format($date_pre1, "Y-m-d H:i:s");
						$date_pre2=date_format($date_pre2, "Y-m-d H:i:s");
					}
					elseif ($_POST["date_pre"]=="lastw")
					{
						$date_pre1=date_create("Europe/Paris");
						$date_pre2=date_create("Europe/Paris");
						date_time_set($date_pre1,00,00,00);
						date_time_set($date_pre2,23,59,59);
						date_modify($date_pre1,"-7 day");
						date_modify($date_pre2,"-1 days");
						$date_pre1=date_format($date_pre1, "Y-m-d H:i:s");
						$date_pre2=date_format($date_pre2, "Y-m-d H:i:s");
					}
					elseif ($_POST["date_pre"]=="currentm")
					{
						$date_pre1=date("Y-m-d H:i:s", strtotime("first day of this month, 1AM"));
						$date_pre2=date_create("Europe/Paris");
						date_time_set($date_pre2,23,59,59);
						$date_pre2=date_format($date_pre2, "Y-m-d H:i:s");
					}
					elseif ($_POST["date_pre"]=="lastm")
					{
						$date_pre1=date("Y-m-d H:i:s", strtotime("first day of last month, 1AM"));
						$date_pre2=date("Y-m-d H:i:s", strtotime("first day of this month 1AM"));
					}
					/*elseif ($_POST["date_pre"]=="annee")
					{
						$date_pre1=date("Y-m-d H:i:s", strtotime("first day of january " . date("Y") . ", 1AM"));
						$date_pre2=date("Y-m-d H:i:s", strtotime("last day of the december " . date("Y") . ", 1AM"));
					}*/
					try
					{
						$bdd = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $login, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
					}
					catch(Exception $e)
					{
			   			die('Erreur : '.$e->getMessage());
					}
					$reponse = $bdd->prepare('SELECT id, dt, people, total, status, created, c_lname, c_email FROM bk2020_restaurantbooking_bookings WHERE dt BETWEEN :d1 AND :d2 ORDER BY id');
					$reponse->execute(array(
						'd1' => $date_pre1,
						'd2' => $date_pre2
					));
					$somme=0;
					while ($donnees = $reponse->fetch())
					{
						echo 	'<tr> <td>' . $donnees['created'] . '</td><td>' . $donnees['c_lname'] . '</td><td>' . $donnees['c_email'] . '</td><td>' . $donnees['people'] . '</td><td>' . $donnees['total'] . '</td><td>' . $donnees['dt'] . '</td><td>' . $donnees['status'] . '</td> <td> <a href="modification.php?idligne='.$donnees['id'].'">Modifier</a></td><td> <a href="suppression.php?idligne='.$donnees['id'].'">Supprimer</a></td></tr>';
						if ($donnees['status']=='confirmed')
						{
							$somme=$somme+$donnees['total'];
						}
					}
					$reponse->closeCursor();
				}
				else
				{
					try
					{
						$bdd = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $login, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
					}
					catch(Exception $e)
					{
			   			die('Erreur : '.$e->getMessage());
					}
					$reponse = $bdd->prepare('SELECT id, dt, people, total, status, created, c_lname, c_email FROM bk2020_restaurantbooking_bookings WHERE dt BETWEEN :d1 AND :d2 ORDER BY id');
					$reponse->execute(array(
						'd1' => $_POST["date1"],
						'd2' => $_POST["date2"]
					));
					$somme=0;
					while ($donnees = $reponse->fetch())
					{
						echo 	'<tr> <td>' . $donnees['created'] . '</td><td>' . $donnees['c_lname'] . '</td><td>' . $donnees['c_email'] . '</td><td>' . $donnees['people'] . '</td><td>' . $donnees['total'] . '</td><td>' . $donnees['dt'] . '</td><td>' . $donnees['status'] . '</td> <td> <a href="modification.php?idligne='.$donnees['id'].'">Modifier</a></td><td> <a href="suppression.php?idligne='.$donnees['id'].'">Supprimer</a></td></tr>';
						if ($donnees['status']=='confirmed')
						{
							$somme=$somme+$donnees['total'];
						}
					}
					$reponse->closeCursor();
				}
				?>
				<tr>
					<th colspan="7" id='somme'>Somme des montants : <?php echo $somme;?></th>
					<td colspan="2"></td>
				</tr>
			</table>
		</nav>
	</body>
</html>