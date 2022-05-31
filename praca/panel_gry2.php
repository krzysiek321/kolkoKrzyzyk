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
				$wyniki=$polaczenie->query("select 
											nazwa,
											sum(if(wynik='$id' and tryb=1, ile,0)) w3,
											sum(if(wynik=0 and tryb=1, ile,0)) r3,
											sum(if(wynik=id and tryb=1 ,ile,0))l3,
											sum(if(wynik='$id' and tryb=2, ile,0)) w4,
											sum(if(wynik=0 and tryb=2, ile,0)) r4,
											sum(if(wynik=id and tryb=2 ,ile,0))l4,
											sum(if(wynik='$id' and tryb=3, ile,0)) w5,
											sum(if(wynik=0 and tryb=3, ile,0)) r5,
											sum(if(wynik=id and tryb=3 ,ile,0))l5,
											max(ost) mdata
											from (SELECT u.nazwa nazwa, u.id id, z.tryb tryb, z.wynik wynik, count(id_gry) ile, max(z.data) ost 
											FROM uzytkownicy u, pary p, zak_gry z WHERE z.id_pary=p.id_pary and u.id=p.id_zawodnika 
											and z.id_pary in (select id_pary from pary WHERE id_zawodnika='$id') and id!='$id' and wynik!=-1
											GROUP by u.nazwa ,u.id , z.tryb, z.wynik) t
											group by nazwa
											order by mdata desc");
				
				$zmienna=$wyniki->num_rows.';';
				for($i=0; $i<$wyniki->num_rows; $i++)
				{
					$wiersz=$wyniki->fetch_assoc();
					$zmienna=$zmienna.$wiersz['nazwa'].','.$wiersz['w3'].','.$wiersz['r3'].','.$wiersz['l3'].','.$wiersz['w4'].','.$wiersz['r4'].','.$wiersz['l4'].',';
					$zmienna=$zmienna.$wiersz['w5'].','.$wiersz['r5'].','.$wiersz['l5'].';';
				}
				$zmienna=$zmienna.'-;-;-;-;-; ';
				echo $zmienna;
				
			}
			else if($opcja==2)
			{
				$fraza=$_GET['fraza'];
				$wyniki=$polaczenie->query('SELECT nazwa FROM `uzytkownicy` WHERE nazwa like "%'.$fraza.'%"and id!='.$id.' order by nazwa');
				$zmienna=$wyniki->num_rows.',';
				for($i=0; $i<$wyniki->num_rows; $i++)
				{
					$wiersz=$wyniki->fetch_assoc();
					$zmienna=$zmienna.$wiersz['nazwa'].',';
					
				}
				$zmienna=$zmienna.',,,,,,,,,,,';
				echo $zmienna;
				
			}
			else if($opcja==3)
			{
				$gracz=$_GET['gracz'];
				
				$polaczenie->query('INSERT INTO pary
									select (select max(id_pary) from pary) +1, id
									from uzytkownicy where (id='.$id.' or id in (select id from uzytkownicy where nazwa="'.$gracz.'") )
									and not EXISTS (select * from pary where id_zawodnika='.$id.' and id_pary in 
									(SELECT id_pary FROM pary where id_zawodnika in (select id from uzytkownicy where nazwa="'.$gracz.'") ))');
				$wyniki=$polaczenie->query('SELECT id_pary from pary where id_pary in (select id_pary from pary where 
										id_zawodnika in (select id from uzytkownicy where nazwa="'.$gracz.'")) 
										and id_pary in (select id_pary from pary where id_zawodnika='.$id.')');
				$wiersz=$wyniki->fetch_assoc();
				$_SESSION['id_pary']=$wiersz['id_pary'];
				$nr_pary=$_SESSION['id_pary'];
			
				$data=date('Y-m-d H:i:s');
				$polaczenie->query("insert into gra select null, '$nr_pary',2,-1,1,'$id', '0,0,0,0,0,0,0,0,0,','','$data' 
											where not exists ( select * from gra where id_pary ='$nr_pary' and status=2 and tryb=1)");
				$wyniki=$polaczenie->query("select * from gra where id_pary ='$nr_pary'and status=2 and tryb=1");
				if($wyniki->num_rows>0)
				{
					$wiersz=$wyniki->fetch_assoc();
					$_SESSION['nr_gry']=$wiersz['id_gry'];
					$_SESSION['id_pary']=$wiersz['id_pary'];
				}
			
									
			}
			else if($opcja==4)
			{
				unset($_SESSION['nr_gry']);
				unset($_SESSION['id_pary']);
			}
			else if($opcja==5)
			{
				$wyniki=$polaczenie->query('select nazwa,g.tryb,id_gry, "twoj ruch" kol,g.data data1 from uzytkownicy u , pary p, gra g 
										where p.id_pary=g.id_pary and id=id_zawodnika and ruch='.$id.' and id!='.$id.' 
										union select nazwa,g.tryb,id_gry, "ruch przeciwnika" kol, g.data data1 from uzytkownicy u , pary p, gra g 
										where p.id_pary=g.id_pary and id=id_zawodnika and ruch!='.$id.' 
										and g.id_pary in (SELECT id_pary from pary where id_zawodnika='.$id.') and id!='.$id.' and status=2 order by kol desc, data1 desc ');
				$zmienna=($wyniki->num_rows).',';
				for($i=0; $i<$wyniki->num_rows; $i++)
				{
					$wiersz=$wyniki->fetch_assoc();
					$zmienna=$zmienna.$wiersz['nazwa'].';'.$wiersz['tryb'].';'.$wiersz['id_gry'].';'.$wiersz['kol'].',';
					
				}			
				$zmienna=$zmienna.' , , , , , , , , , , , , ,';
				echo $zmienna;
			}
			else if($opcja==6)
			{
				$wyniki=$polaczenie->query("select tryb from uzytkownicy where id='$id'");
				$wiersz=$wyniki->fetch_assoc();
				echo $wiersz['tryb'];
				
			}
			else if($opcja==7)
			{
				$tryb=$_GET['tryb'];
				$polaczenie->query("update uzytkownicy set tryb='$tryb' where id='$id'");
				
			}
			else if($opcja==8)
			{
				$gracz=$_GET['gracz'];
				
				$polaczenie->query('INSERT INTO pary
									select (select max(id_pary) from pary) +1, id
									from uzytkownicy where (id='.$id.' or id in (select id from uzytkownicy where nazwa="'.$gracz.'") )
									and not EXISTS (select * from pary where id_zawodnika='.$id.' and id_pary in 
									(SELECT id_pary FROM pary where id_zawodnika in (select id from uzytkownicy where nazwa="'.$gracz.'") ))');
				$wyniki=$polaczenie->query('SELECT id_pary from pary where id_pary in (select id_pary from pary where 
										id_zawodnika in (select id from uzytkownicy where nazwa="'.$gracz.'")) and id_pary in (select id_pary from pary where id_zawodnika='.$id.')');
				$wiersz=$wyniki->fetch_assoc();
				$_SESSION['id_pary']=$wiersz['id_pary'];
				$nr_pary=$_SESSION['id_pary'];
			
				$data=date('Y-m-d H:i:s');
				$polaczenie->query("insert into gra select null, '$nr_pary',2,-1,2,'$id', '0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,','','$data' 
											where not exists ( select * from gra where id_pary ='$nr_pary' and status=2 and tryb=2 )");
				$wyniki=$polaczenie->query("select * from gra where id_pary ='$nr_pary'and status=2 and tryb=2");
				if($wyniki->num_rows>0)
				{
					$wiersz=$wyniki->fetch_assoc();
					$_SESSION['nr_gry']=$wiersz['id_gry'];
					$_SESSION['id_pary']=$wiersz['id_pary'];
				}
				
			}
			else if($opcja==9)
			{
				$nr_gry=$_GET['gracz'];
				$wyniki=$polaczenie->query("select * from gra where id_gry='$nr_gry'");
				$wiersz=$wyniki->fetch_assoc();
				$_SESSION['nr_gry']=$wiersz['id_gry'];
				$_SESSION['id_pary']=$wiersz['id_pary'];
				
			}
			
			else if($opcja==10)
			{
				$gracz=$_GET['gracz'];
				
				$polaczenie->query('INSERT INTO pary
									select (select max(id_pary) from pary) +1, id
									from uzytkownicy where (id='.$id.' or id in (select id from uzytkownicy where nazwa="'.$gracz.'") )
									and not EXISTS (select * from pary where id_zawodnika='.$id.' and id_pary in 
									(SELECT id_pary FROM pary where id_zawodnika in (select id from uzytkownicy where nazwa="'.$gracz.'") ))');
				$wyniki=$polaczenie->query('SELECT id_pary from pary where id_pary in (select id_pary from pary where 
										id_zawodnika in (select id from uzytkownicy where nazwa="'.$gracz.'")) and id_pary in (select id_pary from pary where id_zawodnika='.$id.')');
				$wiersz=$wyniki->fetch_assoc();
				$_SESSION['id_pary']=$wiersz['id_pary'];
				$nr_pary=$_SESSION['id_pary'];
			
				$data=date('Y-m-d H:i:s');
				$polaczenie->query("insert into gra select null, '$nr_pary',2,-1,3,'$id', '0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,','','$data' 
											where not exists ( select * from gra where id_pary ='$nr_pary' and status=2 and tryb=3)");
				$wyniki=$polaczenie->query("select * from gra where id_pary ='$nr_pary'and status=2 and tryb=3");
				if($wyniki->num_rows>0)
				{
					$wiersz=$wyniki->fetch_assoc();
					$_SESSION['nr_gry']=$wiersz['id_gry'];
					$_SESSION['id_pary']=$wiersz['id_pary'];
				}
				
				
			}
			else if($opcja==11)
			{
				$id2=$id*(-1);
				$data2=date('Y-m-d H:i',strtotime("-30 seconds"));
				$polaczenie->query("DELETE from gra where (status=1 and data<'$data2') or id_pary='$id2'");
				$polaczenie->query("DELETE from czekaj_gry where (status=1 and data<'$data2') or id_pary='$id2'");
				$polaczenie->query("UPDATE czekaj_gry set ruch='$id' where tryb=1 and status=1 and ruch=0 and 
									id_pary*(-1) not in (SELECT id_zawodnika from pary where id_pary in 
									(select id_pary from gra where STATUS=2 and tryb=1) and 
									id_pary in(select id_pary from pary where id_zawodnika='$id'))");
				$wyniki=$polaczenie->query("SELECT * from czekaj_gry where status=1 and ruch='$id' and tryb=1");
				if($wyniki->num_rows>0)
				{
					$wiersz=$wyniki->fetch_assoc();
					$gracz=$wiersz['id_pary'];
					$gracz=$gracz*(-1);
					$nr_gry=$wiersz['id_gry'];
					$polaczenie->query("UPDATE gra set ruch=(SELECT ruch from czekaj_gry where id_gry='$nr_gry') where id_gry='$nr_gry'");
					$polaczenie->query('INSERT INTO pary
									select (select max(id_pary) from pary) +1, id
									from uzytkownicy where (id='.$id.' or id='.$gracz.') 
									and not EXISTS (select * from pary where id_zawodnika='.$id.' and id_pary in 
									(SELECT id_pary FROM pary where id_zawodnika in (select id from uzytkownicy where id='.$gracz.') ))');
					$wyniki=$polaczenie->query('SELECT id_pary from pary where id_pary in (select id_pary from pary where 
											id_zawodnika in (select id from uzytkownicy where id='.$gracz.')) 
											and id_pary in (select id_pary from pary where id_zawodnika='.$id.')');
					$wiersz2=$wyniki->fetch_assoc();
					$_SESSION['id_pary']=$wiersz2['id_pary'];
					$nr_pary=$_SESSION['id_pary'];
					$polaczenie->query("UPDATE  gra set id_pary='$nr_pary', status=2  where id_gry='$nr_gry'");
					$polaczenie->query("DELETE from  czekaj_gry  where id_gry='$nr_gry'");
					$_SESSION['nr_gry']=$nr_gry;
					echo "tak";
				}
				else 
				{
				$data=date('Y-m-d H:i:s');
				$polaczenie->query("INSERT INTO gra values(NULL, '$id2',1,-1,1,0,'0,0,0,0,0,0,0,0,0,','','$data')");
				$wyniki=$polaczenie->query("SELECT * from gra where id_pary='$id2'");
				$wiersz=$wyniki->fetch_assoc();
				$_SESSION['nr_gry']=$wiersz['id_gry'];
				$gra=$wiersz['id_gry'];
				$polaczenie->query("INSERT INTO czekaj_gry select id_gry,id_pary, status,tryb,ruch,data from gra where id_gry='$gra'");
				
				echo "nie";
				}
				
			}
			else if($opcja==12)
			{
				$id2=$id*(-1);
				$data2=date('Y-m-d H:i',strtotime("-30 seconds"));
				$polaczenie->query("DELETE from gra where (status=1 and data<'$data2') or id_pary='$id2'");
				$polaczenie->query("DELETE from czekaj_gry where (status=1 and data<'$data2') or id_pary='$id2'");
				$polaczenie->query("UPDATE czekaj_gry set ruch='$id' where tryb=2 and status=1 and ruch=0 and 
									id_pary*(-1) not in (SELECT id_zawodnika from pary where id_pary in 
									(select id_pary from gra where STATUS=2 and tryb=2) and 
									id_pary in(select id_pary from pary where id_zawodnika='$id'))");
				$wyniki=$polaczenie->query("SELECT * from czekaj_gry where status=1 and ruch='$id' and tryb=2");
				$polaczenie->query("DELETE from  czekaj_gry  where id_gry='$nr_gry'");
				if($wyniki->num_rows>0)
				{
					$wiersz=$wyniki->fetch_assoc();
					$gracz=$wiersz['id_pary'];
					$gracz=$gracz*(-1);
					$nr_gry=$wiersz['id_gry'];
					$polaczenie->query("UPDATE gra set ruch=(SELECT ruch from czekaj_gry where id_gry='$nr_gry') where id_gry='$nr_gry'");
					$polaczenie->query('INSERT INTO pary
									select (select max(id_pary) from pary) +1, id
									from uzytkownicy where (id='.$id.' or id='.$gracz.') 
									and not EXISTS (select * from pary where id_zawodnika='.$id.' and id_pary in 
									(SELECT id_pary FROM pary where id_zawodnika in (select id from uzytkownicy where id='.$gracz.') ))');
					$wyniki=$polaczenie->query('SELECT id_pary from pary where id_pary in (select id_pary from pary where 
											id_zawodnika in (select id from uzytkownicy where id='.$gracz.')) and id_pary in (select id_pary from pary where id_zawodnika='.$id.')');
					$wiersz2=$wyniki->fetch_assoc();
					$_SESSION['id_pary']=$wiersz2['id_pary'];
					$nr_pary=$_SESSION['id_pary'];
					$polaczenie->query("UPDATE  gra set id_pary='$nr_pary', status=2  where id_gry='$nr_gry'");
					$polaczenie->query("DELETE from  czekaj_gry  where id_gry='$nr_gry'");
					$_SESSION['nr_gry']=$nr_gry;
					echo "tak";
				}
				else 
				{
				$data=date('Y-m-d H:i:s');
				$polaczenie->query("INSERT INTO gra values(NULL, '$id2',1,-1,2,0,'0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,','','$data')");
				$wyniki=$polaczenie->query("SELECT * from gra where id_pary='$id2'");
				$wiersz=$wyniki->fetch_assoc();
				$_SESSION['nr_gry']=$wiersz['id_gry'];
				$gra=$wiersz['id_gry'];
				$polaczenie->query("INSERT INTO czekaj_gry select id_gry,id_pary, status,tryb,ruch,data from gra where id_gry='$gra'");
				
				echo "nie";
				}
				
			}
			else if($opcja==13)
			{
				$id2=$id*(-1);
				$data2=date('Y-m-d H:i',strtotime("-30 seconds"));
				$polaczenie->query("DELETE from gra where (status=1 and data<'$data2') or id_pary='$id2'");
				$polaczenie->query("DELETE from czekaj_gry where (status=1 and data<'$data2') or id_pary='$id2'");
				$polaczenie->query("UPDATE czekaj_gry set ruch= '$id'  where tryb=3 and status=1 and ruch=0 and 
									id_pary*(-1) not in (SELECT id_zawodnika from pary where id_pary in 
									(select id_pary from gra where STATUS=2 and tryb=3) and 
									id_pary in(select id_pary from pary where id_zawodnika='$id'))");
				$wyniki=$polaczenie->query("SELECT * from czekaj_gry where status=1 and ruch='$id' and tryb=3");
				if($wyniki->num_rows>0)
				{
					$wiersz=$wyniki->fetch_assoc();
					$gracz=$wiersz['id_pary'];
					$gracz=$gracz*(-1);
					$nr_gry=$wiersz['id_gry'];
					$polaczenie->query("UPDATE gra set ruch=(SELECT ruch from czekaj_gry where id_gry='$nr_gry') where id_gry='$nr_gry'");
					$polaczenie->query('INSERT INTO pary
									select (select max(id_pary) from pary) +1, id
									from uzytkownicy where (id='.$id.' or id='.$gracz.') 
									and not EXISTS (select * from pary where id_zawodnika='.$id.' and id_pary in 
									(SELECT id_pary FROM pary where id_zawodnika in (select id from uzytkownicy where id='.$gracz.') ))');
					$wyniki=$polaczenie->query('SELECT id_pary from pary where id_pary in (select id_pary from pary where 
											id_zawodnika in (select id from uzytkownicy where id='.$gracz.')) and id_pary in (select id_pary from pary where id_zawodnika='.$id.')');
					$wiersz2=$wyniki->fetch_assoc();
					$_SESSION['id_pary']=$wiersz2['id_pary'];
					$nr_pary=$_SESSION['id_pary'];
					$polaczenie->query("UPDATE  gra set id_pary='$nr_pary', status=2  where id_gry='$nr_gry'");
					$polaczenie->query("DELETE from  czekaj_gry  where id_gry='$nr_gry'");
					$_SESSION['nr_gry']=$nr_gry;
					echo "tak";
				}
				else 
				{
				$data=date('Y-m-d H:i:s');
				$polaczenie->query("INSERT INTO gra values(NULL, '$id2',1,-1,3,0,'0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,','','$data')");
				$wyniki=$polaczenie->query("SELECT * from gra where id_pary='$id2'");
				$wiersz=$wyniki->fetch_assoc();
				$_SESSION['nr_gry']=$wiersz['id_gry'];
				$gra=$wiersz['id_gry'];
				$polaczenie->query("INSERT INTO czekaj_gry select id_gry,id_pary, status,tryb,ruch,data from gra where id_gry='$gra'");
				
				echo "nie";
				}
				
			}
			else if($opcja==14)
			{
				$nr_gry=$_SESSION['nr_gry'];
				$data=date('Y-m-d H:i:s');
				$wyniki=$polaczenie->query("Select id_pary, second(TIMEDIFF(NOW(),data)) as time1 from gra where id_gry='$nr_gry'");
				if($wyniki->num_rows>0)
				{
					$wiersz=$wyniki->fetch_assoc();
					if($wiersz['id_pary']>0)
					{
						$_SESSION['id_pary']=$wiersz['id_pary'];
						echo "tak";
					}
					else 
					{
						$zmienna=$wiersz['time1'];
						if($zmienna>=30)
						{
							$polaczenie->query("DELETE from gra where  id_gry='$nr_gry' and status=1 and ruch=0");
							$polaczenie->query("DELETE from czekaj_gry where  id_gry='$nr_gry' and status=1 and ruch=0");
						}
						echo $zmienna;
					}
				}
				else
				{
					echo "nie";
				}
			}
			else if($opcja==15)
			{
				$nr_gry=$_SESSION['nr_gry'];
				$polaczenie->query("DELETE from gra where  id_gry='$nr_gry' and status=1 and ruch=0");
				$polaczenie->query("DELETE from czekaj_gry where  id_gry='$nr_gry' and status=1 and ruch=0");
				echo "tak".$nr_gry;
			}
			else if($opcja==16)
			{
				$wyniki=$polaczenie->query("select nazwa from uzytkownicy where id='$id'");
				$wiersz=$wyniki->fetch_assoc();
				
				echo $wiersz['nazwa'];
			}
		}

		
	}
	$polaczenie->close();
?>