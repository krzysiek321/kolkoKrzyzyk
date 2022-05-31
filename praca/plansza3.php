<?php

	session_start();
	
	if (!isset($_SESSION['zalogowany']))
	{
		header('Location: index.php');
		exit();
	}
	else if(!isset($_SESSION['id_pary']) || !isset($_SESSION['nr_gry']))
	{
		header('Location:panel_gry.php');
		exit();
	}
	
?>
<!DOSTYPE HTML>
<html lang="pl">
<html>
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta http-equiv="X-UA-Captatible" content="IE=edge,chrome=1"/>
<title>Kolko-krzyzyk online</title>

<script >

var i,j, pom,pom1;
var x=5;
var y=5;
	var tab=[];
var ile=0;
var time=setInterval(rywal,50)
var ruch;
var nazwa;
var win=0;remis=0;
var ja=0,przeciwnik=0;
var pola;
var koniec="";
var kon_gry=0;
var kolko='<img src="kolko.png" width="100%" height="100%"/>';
var krzyzyk='<img src="krzyzyk1.png" width="100%" height="100%"/>';
var kolko2='<img src="kolko2.png" width="100%" height="100%"/>';
var krzyzyk2='<img src="krzyzyk2.png" width="100%" height="100%"/>';

function glowna()
{
	var a=document.getElementById("plansza_gra");

	for(i=0; i<y; i++)
	{
		tab[i]=[];
	}
	for(i=0; i<y; i++)
	{
		for(j=0; j<x; j++)
		{
			
			document.getElementById("pole"+i+"."+j+"").style.width="18%";
			document.getElementById("pole"+i+"."+j+"").style.height="18%";
			document.getElementById("pole"+i+"."+j+"").style.margin="1%";
			document.getElementById("pole"+i+"."+j+"").style.textAlign="center";
			document.getElementById("pole"+i+"."+j+"").style.float="left";
			document.getElementById("pole"+i+"."+j+"").style.background="#FFEBC7";
			document.getElementById("pole"+i+"."+j+"").style.cursor="pointer";
			tab[i][j]==0;
		}
	}
	$.get('plansza.php',{opcja:1},function(zmienna){
		var pom_zmienna=zmienna.split(',');
		 przeciwnik=pom_zmienna[0];
		ja=pom_zmienna[1];
		
		umieszczanie();
	});
	
}

function umieszczanie(){
	$.get('plansza.php',{opcja:2}, function(zmienna)
	{	
		pola=zmienna.split(',');
		for(i=0; i<y; i++)
		{
			for(j=0; j<x; j++)
			{
				pom=pola[i*y+j];
				if(pom==ja)
				{
					document.getElementById("pole"+i+"."+j+"").innerHTML=kolko;
					document.getElementById("pole"+i+"."+j+"").style.cursor="auto";
					ile++;
				}
				else if(pom==przeciwnik)
				{
					document.getElementById("pole"+i+"."+j+"").innerHTML=krzyzyk;
					document.getElementById("pole"+i+"."+j+"").style.cursor="auto";
					ile++;
				}
			}
		}	
	wybor();
		
	});
}
function wybor()
{
	$.get('plansza.php',{opcja:3},function(zmienna){
		ruch=zmienna;
		document.getElementById('czas').innerHTML="";
		if(ruch==ja)
		{
			moja();
		}
		else if(ruch==przeciwnik)
		{
			rywal();
		}
		else if (ruch==0)
		{
			$.get('plansza.php',{opcja:7}, function(zmienna)
			{
				if(zmienna==przeciwnik)
				{
					loss();
				}
				else if(zmienna==0)
				{
					draw();
				}
				else if(zmienna==ja)
				{
					winner();
				}	
				else if(zmienna==-1)
				{
					gra_anulowana();
				}
			});
		}

	
	});
}

function moja()
{
	if(ruch==ja)
	{	
		document.getElementById("czas").innerHTML="<b>"+nazwa+"</br>"+"TWOJ </br> RUCH</b>";
		var a=document.getElementById("plansza_gra");
		var w=document.getElementById("pasek").offsetLeft-a.offsetLeft;
		var h=document.getElementById("czas").offsetTop - a.offsetTop;
		var wx=w/x;
		var hy=h/y;
		
		a.addEventListener('click',function(event){
		if(ruch==ja)
			{
				var mouseX = event.pageX - a.offsetLeft;
				var mouseY = event.pageY - a.offsetTop;
				x1=Math.floor((mouseX)/wx);
				y1=Math.floor((mouseY)/hy);
				var pom2=y1*y+x1;
				pom='';
				if(pola[pom2]==0)
				{
					ruch=-1;
					document.getElementById("pole"+y1+"."+x1+"").innerHTML=kolko;
					document.getElementById("pole"+y1+"."+x1+"").style.cursor="auto";
					for(i=0;i<y;i++)
					{
						for(j=0;j<x;j++)
						{
							pom1=i*y+j;
							if(pom1==pom2)
							{
								pola[pom2]=ja;
								pom=pom+ja+',';
							}
							else
							{
								pom=pom+pola[pom1]+',';
							}
							
						}
					}

						ile++;
						sprawdz();

				}
			}
		});
	
	}	
}
function sprawdz()
{
	
	remis=0;
	for(i=0; i<y; i++)
	{
		for(j=0; j<x; j++)
		{
			tab[i][j]=pola[i*y+j];
		}
	}

	for(i=0; i<y; i++)
	{
		if(tab[i][0]==ja && tab[i][1]==ja && tab[i][2]==ja && tab[i][3]==ja)
		{
			win++;
			koniec=(i*y)+","+(i*y+1)+","+(i*y+2)+","+(i*y+3)+",";
		}
		if(tab[0][i]==ja && tab[1][i]==ja && tab[2][i]==ja && tab[3][i]==ja)
		{
			win++;
			koniec=i+","+(y+i)+","+(y*2+i)+","+(y*3+i)+",";
		}
		if(tab[i][1]==ja && tab[i][2]==ja && tab[i][3]==ja && tab[i][4]==ja)
		{
			win++;
			koniec=(i*y+1)+","+(i*y+2)+","+(i*y+3)+","+(i*y+4)+",";
		}
		if(tab[1][i]==ja && tab[2][i]==ja && tab[3][i]==ja && tab[4][i]==ja)
		{
			win++;
			koniec=(y+i)+","+(y*2+i)+","+(y*3+i)+","+(y*4+i)+",";
		}
	}
	if(tab[0][0]==ja && tab[1][1]==ja && tab[2][2]==ja && tab[3][3]==ja)
	{
		win++;
		koniec="0,6,12,18,";
	}
	else if(tab[1][1]==ja && tab[2][2]==ja && tab[3][3]==ja && tab[4][4]==ja)
	{
		win++;
		koniec="6,12,18,24,";
	}
	else if(tab[0][1]==ja && tab[1][2]==ja && tab[2][3]==ja && tab[3][4]==ja)
	{
		win++;
		koniec="1,7,13,19,";
	}
	else if(tab[1][0]==ja && tab[2][1]==ja && tab[3][2]==ja && tab[4][3]==ja)
	{
		win++;
		koniec="5,11,17,23,";
	}
	else if(tab[3][0]==ja && tab[2][1]==ja && tab[1][2]==ja && tab[0][3]==ja)
	{
		win++;
		koniec="15,11,7,3,";
	}
	else if(tab[4][0]==ja && tab[3][1]==ja && tab[2][2]==ja && tab[1][3]==ja)
	{
		win++;
		koniec="20,16,12,8,";
	}
	else if(tab[3][1]==ja && tab[2][2]==ja && tab[1][3]==ja && tab[0][4]==ja)
	{
		win++;
		koniec="16,12,8,4,";
	}
	else if(tab[4][1]==ja && tab[3][2]==ja && tab[2][3]==ja && tab[1][4]==ja)
	{
		win++;
		koniec="21,17,13,9,";
	}
	
	for(i=0; i<y; i++)
	{
		for(j=0; j<x; j++)
		{
			if(tab[i][j]!=0)
			{
				remis++;
			}
			
		}
	}
	if(remis==2)
	{
		document.getElementById("anuluj").innerHTML="<b>PODDAJ</br>SIE</b>";
	}
	if(win>0)
	{
		$.get('plansza.php',{opcja:5, wynik:koniec, pola:pom});
		winner();
	}
	else if(remis==25)
	{
		$.get('plansza.php',{opcja:6, pola:pom});
		draw();
	}
	else
	{
		$.get('plansza.php',{opcja:4, pola:pom, ruch:przeciwnik}, function(zmienna)
		{
			ruch=przeciwnik;
			rywal();
		});
	}
}


function rywal()
{	
	if(ruch==przeciwnik && kon_gry==0)
	{
		document.getElementById("czas").innerHTML="<b>"+nazwa+"</br>RUCH </br> PRZECIWNIKA</b>";
		$.get('plansza.php',{opcja:3}, function(zmienna)
		{
			if(zmienna!=przeciwnik)
			{
				var licznik=0;
				$.get('plansza.php',{opcja:2}, function(zmienna2)
				{	if(kon_gry==0)
					{
						pola=zmienna2.split(',');
						for(i=0; i<y; i++)
						{
							for(j=0; j<y; j++)
							{
								pom=pola[i*y+j];
								if(pom==ja)
								{
									licznik++;
									document.getElementById("pole"+i+"."+j+"").innerHTML=kolko;
									document.getElementById("pole"+i+"."+j+"").style.cursor="auto";
								}
								else if(pom==przeciwnik)
								{
									licznik++;
									document.getElementById("pole"+i+"."+j+"").innerHTML=krzyzyk;
									document.getElementById("pole"+i+"."+j+"").style.cursor="auto";
								}
							}
						}
					}
					if(licznik==2)
					{
						document.getElementById("anuluj").innerHTML="<b>PODDAJ</br>SIE</b>";
					}
					if(licznik>ile)
					{
						ile++;
					}
					if(zmienna==ja)
					{
						ruch=ja;
						moja();
						
					}
					else
					{
							
						$.get('plansza.php',{opcja:7}, function(zmienna)
						{
							ruch=0;
							if(zmienna==przeciwnik)
							{
								loss();
							}
							else if(zmienna==0)
							{
								draw();
							}
							else if(zmienna==ja)
							{
								winner();
							}	
							else if(zmienna==-1)
							{
								gra_anulowana();
							}		
						});
		
					}
					
					

				});
				
			}
		});
	
	}
	
}
function gra_anulowana()
{
	document.getElementById("czas").innerHTML="<b>GRA </br>ANULOWANA</b>";
	document.getElementById("czas").style.color="blue";
	document.getElementById("czas").style.fontWeight="900";
	document.getElementById("czas").style.width="49%";
	document.getElementById("anuluj").style.width="0%";
	document.getElementById("restart").style.width="50%";
	ruch=0;
	kon_gry=1;
}


function winner()
{
	document.getElementById("czas").innerHTML="<b>WYGRANA</b>";
	document.getElementById("czas").style.color="green";
	document.getElementById("czas").style.fontWeight="900";
	document.getElementById("czas").style.width="49%";
	document.getElementById("anuluj").style.width="0%";
	document.getElementById("restart").style.width="50%";
	clearInterval(time);
	ruch=0;
	kon_gry=1;
	$.get('plansza.php',{opcja:9},function(zmienna){
	
		var kolka=zmienna.split(',');
		for(i=0; i<y; i++)
		{
			if(kolka[i]!='')
			{
				x1=kolka[i]%y;
				y1=(kolka[i]-x1)/y;
				document.getElementById('pole'+y1+'.'+x1+'').innerHTML=kolko2;
			}
		}
	});
}
function draw()
{
	document.getElementById("czas").innerHTML="<b>REMIS</b>";
	document.getElementById("czas").style.color="blue";
	document.getElementById("czas").style.fontWeight="900";
	ruch=0;
	kon_gry=1;
	clearInterval(time);
	document.getElementById("czas").style.width="49%";
	document.getElementById("anuluj").style.width="0%";
	document.getElementById("restart").style.width="50%";
}
function loss()
{
	clearInterval(time);
	document.getElementById("czas").innerHTML="<b>PRZEGRANA</b>";
	document.getElementById("czas").style.color="red";
	document.getElementById("czas").style.fontWeight="900";
	document.getElementById("czas").style.width="49%";
	document.getElementById("anuluj").style.width="0%";
	document.getElementById("restart").style.width="50%";
	ruch=0;
	kon_gry=1;
	$.get('plansza.php',{opcja:9},function(zmienna){
	
		var kolka=zmienna.split(',');
		for(i=0; i<y; i++)
		{
			if(kolka[i]!='')
			{
				x1=kolka[i]%y;
				y1=(kolka[i]-x1)/y;
				document.getElementById('pole'+y1+'.'+x1+'').innerHTML=krzyzyk2;
			}
		}
	});
	
}


function nazwa_przeciwnika()
{
	$.get('plansza.php',{opcja:8},function(zmienna)
	{
		nazwa=zmienna;
	});
}

function tryb()
{
	var licznik=0;
	var pola2;
	$.get('plansza.php',{opcja:2}, function(zmienna)
	{	
		pola2=zmienna.split(',');
		for(i=0;i<y*y; i++)
		{
			if(pola2[i]!=0)
			{
				licznik++;
			}
		}
		if(licznik<2)
		{
			document.getElementById("anuluj").innerHTML="<b>ANULUJ</br>GRE</b>";
		}
		else if(licznik>=2)
		{
			document.getElementById("anuluj").innerHTML="<b>PODDAJ</br>SIE</b>";
		}
		
		
	});
	var b= document.getElementById("anuluj");
	b.addEventListener('click',function(event){
		$.get('plansza.php',{opcja:2}, function(zmienna)
		{	
		
			pola2=zmienna.split(',');
			licznik=0;
			for(i=0;i<y*y; i++)
			{
				if(pola2[i]!=0)
				{
					licznik++;	
				}
				
			}
			if(licznik<2)
			{
				$.get('plansza.php',{opcja:10}, function(zmienna)
				{
					document.getElementById("czas").innerHTML="<b>GRA</br>ANULOWANA</b>";
					document.getElementById("czas").style.color="red";
					document.getElementById("czas").style.fontWeight="900";
					document.getElementById("czas").style.width="49%";
					document.getElementById("anuluj").style.width="0%";
					document.getElementById("restart").style.width="50%";
					ruch=0;
				});
				
			}
			else if(licznik>=2)
			{
				$.get('plansza.php',{opcja:11, rywal:przeciwnik}, function(zmienna)
				{
					document.getElementById("czas").innerHTML="<b>PRZEGRANA</b>";
					document.getElementById("czas").style.color="red";
					document.getElementById("czas").style.fontWeight="900";
					document.getElementById("czas").style.width="49%";
					document.getElementById("anuluj").style.width="0%";
					document.getElementById("restart").style.width="50%";
					ruch=0;
				});
				
			}
		});
	});
}
function spr_koniec()
{
	if(ruch==ja)
	{
		$.get('plansza.php',{opcja:12},function(zmienna)
		{
			if(zmienna==3)
			{			
				wybor();
			}
		});
	}
}
setInterval(spr_koniec,100);


window.addEventListener('load',function(event){
	glowna();
	nazwa_przeciwnika();
	tryb();
	spr_koniec();
});


</script>


<style>
body
{
	background-color:	#F0E68C;
}

#plansza
{
	width:100%;
	height:100%;
	max-width:500px;
	margin-left:auto;
	margin-right:auto;
}
#plansza1
{
	width:100%;
	height:100%;

	
	margin-left:auto;
	margin-right:auto;
}


#plansza_gra
{
	width:99%;
	height:90%;
	background-color:#888877;
	float:left;
	
}

#czas
{
	width:39%;
	height:10%;
	background-color:white;
	float:left;
	text-Align:center;
}



#restart
{
	width:30%;
	height:10%;
	background-color:	#FAEBD7;
	float:left;
	text-Align:center;
	cursor:pointer;
}
#anuluj
{
	width:30%;
	height:10%;
	background-color: #D6DBD7;
	float:left;
	text-Align:center;
	cursor:pointer;
}
#pasek
{
	width:1%;
	height:90%;

	float:left;
}
a
{
	text-decoration: none;
	color:#000000;
}
</style>

</head>

<body id="bod">
	<div id="plansza">
		<div id="plansza1">
			<div id="plansza_gra">
			<div id="pole0.0"></div>
			<div id="pole0.1"></div>
			<div id="pole0.2"></div>
			<div id="pole0.3"></div>
			<div id="pole0.4"></div>
			<div id="pole1.0"></div>
			<div id="pole1.1"></div>
			<div id="pole1.2"></div>
			<div id="pole1.3"></div>
			<div id="pole1.4"></div>
			<div id="pole2.0"></div>
			<div id="pole2.1"></div>
			<div id="pole2.2"></div>
			<div id="pole2.3"></div>
			<div id="pole2.4"></div>
			<div id="pole3.0"></div>
			<div id="pole3.1"></div>
			<div id="pole3.2"></div>
			<div id="pole3.3"></div>
			<div id="pole3.4"></div>
			<div id="pole4.0"></div>
			<div id="pole4.1"></div>
			<div id="pole4.2"></div>
			<div id="pole4.3"></div>
			<div id="pole4.4"></div>
			</div>
			<div id="pasek"></div>
			<div id="czas"></div>
			<div id="anuluj"></div>
			<a href="panel_gry.php"><div id="restart"><b>POWROT</b></div></a>
		</div>
		

	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
</body>
</html
