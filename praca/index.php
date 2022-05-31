
<?php

	session_start();
	
	if ((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany']==true))
	{
		header('Location: panel_gry.php');
		exit();
	}

?>

<!DOSTYPE HTL>
<html lang="pl">
<html>
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta http-equiv="X-UA-Captatible" content="IE=edge,chrome=1"/>
<title>Kolko-krzyzyk online</title>

<script>
function start()
{
	var login=document.getElementById('login').value;
	var haslo=document.getElementById('haslo').value;
	$.get('logowanie.php',{opcja:1, haslo:haslo, login:login},function(zmienna)
	{
		if(zmienna=='tak')
		{			
			location.href="panel_gry.php";
		}
		else 
		{
			document.getElementById('pole').innerHTML=zmienna;
		}	
	});
}
</script>

<style>
body
{
	background-color:#5423a1;
}

#plansza
{
	width:100%;
	height:100%;
	background-color:#333333;
	max-width:500px;
	margin-left:auto;
	margin-right:auto;
}
#plansza2
{
	width:100%;
	height:100%;
	background-color:#5F9EA0;
	margin-left:auto;
	margin-right:auto;
}
#napis1
{
	padding-top:10%;
	width:100%;
	height:35%;
	text-align:center;
}

#pole1
{
	width:100%;
	height:20%;
	color:red;
}

#pole2
{
	margin-top:2%;
	width:100%;
	height:30%;
	background-color:#5F9EB0;
	text-align:center;
	float:left;
}
#wyloguj
{
	margin-top:5%;
	width:100%;
	height:10%;
	background-color:#888888;
	float:left;
	text-align:center;
	float:left;
}

#wyloguj:a
{
	color:black;
	
}

</style>
</head>

<body id="bod">
	<div id="plansza">
		
		
		<div id="plansza2">
			<div id="napis1">
		Login: <br /> <input type="text" name="login" id="login"/> <br />
		Haslo: <br /> <input type="password" name="haslo" id="haslo"/> <br /><br />
		<input type="submit" value="Zaloguj sie" onclick="start();"/>
		<div id="pole1"></div>
		</div>
			<a href="rejestracja.php"><div id="wyloguj">ZALOZ NOWE </br> KONTO </div></a>
		
		<div id="pole2"><b>ZASADY GRY</b></br>Aby rozpoczac gre nalezy wybrac przeciwnika. Aby wygrac jeden z zawodnikow na planszy 3x3 lub 4x4 musi ustawic 3 takie same znaki,
					a na planszy 5x5 ustawic 4 takie same znaki. W przypadku braku takiego ustawienia i zapelnieniu wszystkich pol nastepuje zakonczenie gry, a wynikiem jest remis </div>
		</div>
	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
</body>
</html
