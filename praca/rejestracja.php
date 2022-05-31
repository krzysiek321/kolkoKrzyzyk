
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
	var haslo1=document.getElementById('haslo1').value;
	var haslo2=document.getElementById('haslo2').value;
	$.get('logowanie.php',{opcja:2, haslo1:haslo1, haslo2:haslo2, login:login},function(zmienna)
	{
		if(zmienna=='tak')
		{			
			location.href="panel_gry.php";
		}
		else 
		{
			document.getElementById('pole1').innerHTML=zmienna;
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
	height:40%;
	text-align:center;
}

#pole1
{
	color:red;
}
#pole2
{
	color:red;
}

#wyloguj
{
	margin-top:3%;
	width:100%;
	height:10%;
	background-color:#888888;
	float:left;
	text-align:center;
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
			<div id="pole1"></div>
		Login: <br /> <input type="text" name="login" id="login"/> <br />

		Haslo: <br /> <input type="password" name="haslo" id="haslo1"/> <br/>
		powtorz Haslo: <br /> <input type="password" name="haslo2" id="haslo2"/> <br><br />
		<input type="submit" value="Zarejstruj sie" onclick="start();"/>
		
		</div>
			<a href="index.php"><div id="wyloguj">POWROT DO STRONY </br> LOGOWANIA </div></a>
		</div>
	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
</body>
</html
