<!DOCTYPE HTML>
<html>
	<head>
	<meta charset=UTF-8>
	<link rel='stylesheet' type='css' href='reservationsstyle.css'>
	<title>Nouvelle réservation</title>
	</head>
	<body>
		<table id='new_res_tab'>
			<form action='ajout1.php' method='post' name='new_reservation'>
			<caption>Nouvelle réservation</caption>
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
				<td><input type='text' name='nom'></td>
				<td><input type='text' name='email'></td>
				<td><input type='number' name='people' value='1' min='1'></td>
				<td><input type='number' name='montant'></td>
				<td><input type='datetime' name='datediner'></td>
				<td>
					<select name ='etat' id='etat'>
						<optgroup label='etat'>
							<option value='pending'>pending</option>
							<option value='confirmed'>confirmed</option>
							<option value='cancelled'>cancelled</option>
							<option value='enquiry'>enquiry</option>
						</optgroup>
					</select>
				</td>
				<td><input type='submit' value='Envoyer'></td>
			</tr>
			</form>
		</table>
	</body>
</html>