<!DOCTYPE HTML>
<html>
	<head>
	<meta charset=UTF-8>
	<link rel="stylesheet" type="css" href="reservationsstyle.css">
	<title></title>
	</head>
	<body>
			<?php
			include('config.php');
				try
				{
					$bdd = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $login, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
				}
				catch(Exception $e)
				{
		   			die('Erreur : '.$e->getMessage());
				}
				$reponse = $bdd->prepare('SELECT dt, people, total, status, created, c_lname, c_email FROM bk2020_restaurantbooking_bookings WHERE id=:id');
				$reponse->execute(array(
					"id" => $_GET['idligne']
				));
				$donnees = $reponse->fetch();
				$reponse->closeCursor();

				?>
			<table>
				<form action="modification2.php?idligne=<?php echo $_GET['idligne'];?>" method='post' name="modif_reservation">
				<caption>Modification de la réservation <?php echo $_GET['idligne'];?></caption>
				<tr>
					<th>Date de réservation</th>
					<th><label for='nom'>Nom</label></th>
					<th><label for='email'>Email</label></th>
					<th><label for='people'>Participants</label></th>
					<th><label for='montant'>Montant</label></th>
					<th><label for='datediner'>Date du dîner<br>(aaaa-mm-jj)</label></th>
					<th><label for='etat'>Etat</label></th>
					<th></th>
				</tr>
				<tr>
					<td>X</td>
					<td><input type="text" name="nom" value="<?php echo $donnees['c_lname'];?>"></td>
					<td><input type="text" name="email" value="<?php echo $donnees['c_email'];?>"></td>
					<td><input type="number" name="people" value="<?php echo $donnees['people'];?>" min="1"></td>
					<td><input type="number" name="montant" value="<?php echo $donnees['total'];?>"></td>
					<td><input type="datetime" name="datediner" value="<?php echo $donnees['dt'];?>"></td>
					<td>
						<select name ="etat" id="etat">
							<optgroup label="etat">
							<option value="<?php echo $donnees['status'];?>"><?php echo $donnees['status'];?>(état actuel)</option>
							<option value='pending'>pending</option>
							<option value='confirmed'>confirmed</option>
							<option value='cancelled'>cancelled</option>
							<option value='enquiry'>enquiry</option>
							</optgroup>
						</select>
					</td>
					<td><input type="submit" value="Envoyer"></td>
				</tr>
				</form>
			</table>
		<a href='reservations.php'> Annuler </a>
	</body>
</html>