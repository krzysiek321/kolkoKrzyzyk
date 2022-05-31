<?php
	session_start();
	if(!isset($_GET['opcja']))
	{
		header('Location:kolko.php');
	}
	else
	{
		$opcja=$_GET['opcja'];
		$id=$_SESSION['id'];
		require_once "connect.php";
		$pom;
		$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
		
		if ($polaczenie->connect_errno!=0)
		{
			echo "Error: ".$polaczenie->connect_errno;
		}

		else
		{
			if($opcja==1)
			{
				$para=$_SESSION['id_pary'];
				$wyniki=$polaczenie->query("Select * from pary where id_pary='$para' and id_zawodnika!='$id'");
				$wiersz=$wyniki->fetch_assoc();
				echo $wiersz['id_zawodnika'].",".$id;
			}
			else if($opcja==2)
			{
				$gra=$_SESSION['nr_gry'];
				$wyniki=$polaczenie->query("Select plansza from gra where id_gry='$gra'");
				if($wyniki->num_rows>0)
				{
					$wiersz=$wyniki->fetch_assoc();
					echo $wiersz['plansza'];
				}
				else
				{
					$wyniki=$polaczenie->query("Select plansza from zak_gry where id_gry='$gra'");
					$wiersz=$wyniki->fetch_assoc();
					echo $wiersz['plansza'];
				}
			}
			else if($opcja==3)
			{
				$gra=$_SESSION['nr_gry'];
				$wyniki=$polaczenie->query("Select * from gra where id_gry='$gra'");
				if($wyniki->num_rows>0)
				{
					$wiersz=$wyniki->fetch_assoc();
					echo $wiersz['ruch'];
				}
				else echo 0;
			}
			else if($opcja==4)
			{
				$data=date('Y-m-d H:i:s');
				$gra=$_SESSION['nr_gry'];
				$plansza=$_GET['pola'];
				$przeciwnik=$_GET['ruch'];
				$polaczenie->query("Update gra set plansza='$plansza', ruch='$przeciwnik', data='$data' where id_gry='$gra' and ruch='$id'");

				
			}
			else if($opcja==5)
			{
				$data=date('Y-m-d H:i:s');
				$gra=$_SESSION['nr_gry'];
				$koniec=$_GET['wynik'];
				$plansza=$_GET['pola'];
				$polaczenie->query("Update gra set status=3, wynik='$id',ruch=0, koniec='$koniec',
									plansza='$plansza',data='$data' where id_gry='$gra' and ruch='$id'");
				$polaczenie->query("INSERT INTO zak_gry select id_gry,id_pary,tryb,wynik,koniec,plansza,
									data from gra where id_gry='$gra'");
				$polaczenie->query("DELETE from gra  where id_gry='$gra'");
			}
			else if($opcja==6)
			{
				$data=date('Y-m-d H:i:s');
				$gra=$_SESSION['nr_gry'];
				$plansza=$_GET['pola'];
				$polaczenie->query("Update gra set status=3, plansza='$plansza', wynik=0,ruch=0,data='$data' 
									where id_gry='$gra' and ruch ='$id'");
				$polaczenie->query("INSERT INTO zak_gry select id_gry,id_pary,tryb,wynik,koniec,
									plansza,data from gra where id_gry='$gra'");
				$polaczenie->query("DELETE from gra where id_gry='$gra'");
			}
			else if($opcja==7)
			{
				$gra=$_SESSION['nr_gry'];
				$wyniki=$polaczenie->query("Select * from zak_gry where id_gry='$gra'");
				if($wyniki->num_rows>0)
				{
					$wiersz=$wyniki->fetch_assoc();
					echo $wiersz['wynik'];
				}
				else
				{
					$wyniki=$polaczenie->query("Select * from gra where id_gry='$gra'");
					$wiersz=$wyniki->fetch_assoc();
					echo $wiersz['wynik'];
				}
			}
			else if($opcja==8)
			{
				$para=$_SESSION['id_pary'];
				$wyniki=$polaczenie->query("select nazwa from uzytkownicy where id in (Select id_zawodnika from pary where id_pary='$para' and id_zawodnika!='$id')");
				$wiersz=$wyniki->fetch_assoc();
				echo $wiersz['nazwa'];
			}
			
			else if($opcja==9)
			{
				$gra=$_SESSION['nr_gry'];
				$wyniki=$polaczenie->query("select koniec from zak_gry where id_gry='$gra'");
				if($wyniki->num_rows>0)
				{
					$wiersz=$wyniki->fetch_assoc();
					echo $wiersz['koniec'];
				}
				else
				{
					$wyniki=$polaczenie->query("Select koniec from gra where id_gry='$gra'");
					$wiersz=$wyniki->fetch_assoc();
					echo $wiersz['koniec'];
				}
			}
			else if($opcja==10)
			{
				$data=date('Y-m-d H:i:s');
				$gra=$_SESSION['nr_gry'];
				$polaczenie->query("Update gra set status=3,  wynik=-1,ruch=0,data='$data' where id_gry='$gra'");
				$polaczenie->query("INSERT INTO zak_gry select id_gry,id_pary,tryb,wynik,koniec,plansza,data from gra where id_gry='$gra'");
				$polaczenie->query("DELETE from gra where id_gry='$gra'");
				
			}
			else if($opcja==11)
			{
				$data=date('Y-m-d H:i:s');
				$gra=$_SESSION['nr_gry'];
				$przeciwnik=$_GET['rywal'];
				$polaczenie->query("Update gra set status=3,  wynik='$przeciwnik',ruch=0,data='$data' where id_gry='$gra' ");
				$polaczenie->query("INSERT INTO zak_gry select id_gry,id_pary,tryb,wynik,koniec,plansza,data from gra where id_gry='$gra'");
				$polaczenie->query("DELETE from gra  where id_gry='$gra'");
			}
			else if($opcja==12)
			{
				$gra=$_SESSION['nr_gry'];
				$wyniki=$polaczenie->query("select status from gra where id_gry='$gra'");
				if($wyniki->num_rows>0)
				{
					$wiersz=$wyniki->fetch_assoc();
					echo $wiersz['status'];
				}
				else
				{
					echo 3;
				}
			}
		}
	}
	$polaczenie->close();
?>