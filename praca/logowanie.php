<?php
	session_start();
	if(!isset($_GET['opcja']))
	{
		header('Location:kolko.php');
	}
	else
	{
		$opcja=$_GET['opcja'];
		require_once "connect.php";
		$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
		
		if ($polaczenie->connect_errno!=0)
		{
			echo "Error: ".$polaczenie->connect_errno;
		}

		else
		{
			if($opcja==1)
			{
				$login=$_GET['login'];
				$haslo=$_GET['haslo'];
				$login = htmlentities($login, ENT_QUOTES, "UTF-8");
				
				$wyniki=$polaczenie->query('select * from uzytkownicy where nazwa="'.$login.'"');
				if($wyniki->num_rows>0)
				{
					$wiersz = $wyniki->fetch_assoc();
					if (password_verify($haslo, $wiersz['haslo']))
					{
						$_SESSION['zalogowany'] = true;
						$_SESSION['id'] = $wiersz['id'];
						echo "tak";
						
					}
					else echo 'nieprawidlowe haslo';
				}
				else echo "podany login nie istnieje, sprobuj ponownie";
			}
			else if($opcja==2)
			{
				
				$login=$_GET['login'];
				$haslo1=$_GET['haslo1'];
				$haslo2=$_GET['haslo2'];
				$login = htmlentities($login, ENT_QUOTES, "UTF-8");
				if (ctype_alnum($login)==false)
				{
					echo "login moze skladac sie tylko z liter(bez polskich znakow) i cyfr";
				}
				else
				{
					$wyniki=$polaczenie->query('select * from uzytkownicy where nazwa="'.$login.'"');
					if($wyniki->num_rows>0)
					{
						echo "podany nick juz istnieje, wybierz inny";
					}
					else if(strlen($login)<3 || strlen($login)>18)
					{
						echo "login musi sie skladac od 3 do 15 znakow";
					}
					
					else if(strlen($haslo1)<3 || strlen($haslo1)>20)
					{
						echo "haslo musi sie skladac od 8 do 20 znakow";
					}
					else if($haslo1!=$haslo2)
					{
						echo "podane hasla nie sa identyczne";
					}
					else
					{
						$haslo_hash = password_hash($haslo1, PASSWORD_DEFAULT);
						$polaczenie->query("INSERT INTO `uzytkownicy` VALUES (NULL, '$login', '$haslo_hash', 1)");
						$wyniki=$polaczenie->query('select * from uzytkownicy where nazwa="'.$login.'"');
						if($wyniki->num_rows>0)
						{
							$wiersz = $wyniki->fetch_assoc();
							$_SESSION['zalogowany'] = true;
							$_SESSION['id'] = $wiersz['id'];
							echo "tak";
						}
					}
				}
				
			}
		}
	}
	$polaczenie->close();
?>