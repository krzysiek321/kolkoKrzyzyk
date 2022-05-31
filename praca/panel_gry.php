<?php
	session_start();
	
	if (!isset($_SESSION['zalogowany']))
	{
		header('Location: index.php');
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
var los=0;
var kolor1="#429D22";
var kolor2="#FFD700";
var gracze;
function start()
{
	$.get('panel_gry2.php',{opcja:4});
	var a= document.getElementById('plansza1');
	a.innerHTML= '<div id="losowy"></div><div id="szukaj"></div><div id="aktualne"></div><div id="ostatnie"></div><div id=ostatnie1></div><div id=ostatnie2></div><div id=ostatnie3></div>';
	document.getElementById('losowy').style.background="#e69951";
	document.getElementById('losowy').style.width="100%";
	document.getElementById('losowy').style.height="15%";
	document.getElementById('losowy').style.margin="0%";
	document.getElementById('losowy').style.textAlign="center";
	document.getElementById('losowy').innerHTML="<b>LOSOWY PRZECIWNIK</b>";
	document.getElementById('losowy').style.paddingTop="5%";
	document.getElementById('losowy').style.cursor="pointer";
	document.getElementById('szukaj').style.background="#f6ac67";
	document.getElementById('szukaj').style.width="100%";
	document.getElementById('szukaj').style.height="15%";
	document.getElementById('szukaj').style.margin="0%";
	document.getElementById('szukaj').style.textAlign="center";
	document.getElementById('szukaj').style.cursor="pointer";
	document.getElementById('szukaj').style.paddingTop="5%";
	document.getElementById('szukaj').innerHTML="<b>SZUKAJ ZNAJOMEGO</b>";
	document.getElementById('aktualne').style.background="#f6b579";
	document.getElementById('aktualne').style.width="100%";
	document.getElementById('aktualne').style.height="15%";
	document.getElementById('aktualne').style.margin="0%";
	document.getElementById('aktualne').style.textAlign="center";
	document.getElementById('aktualne').style.cursor="pointer";
	document.getElementById('aktualne').style.paddingTop="5%";
	document.getElementById('aktualne').innerHTML="<b>ROZPOCZETE GRY</b>";
	document.getElementById('ostatnie').style.background="#b4a049";
	document.getElementById('ostatnie').style.width="100%";
	document.getElementById('ostatnie').style.height="11%";
	document.getElementById('ostatnie').style.margin="0%";
	document.getElementById('ostatnie').style.textAlign="center";
	document.getElementById('ostatnie').style.paddingTop="4%";
	document.getElementById('ostatnie').style.cursor="pointer";
	document.getElementById('ostatnie').innerHTML="<b>OSTATNI PRZECIWNICY</b>";
	document.getElementById('ostatnie1').style.background="#bfe258";
	document.getElementById('ostatnie1').style.width="33%";
	document.getElementById('ostatnie1').style.height="30%";
	document.getElementById('ostatnie1').style.margin="0%";
	document.getElementById('ostatnie1').style.textAlign="center";
	document.getElementById('ostatnie1').style.paddingTop="4%";
	document.getElementById('ostatnie1').style.float="left";
	document.getElementById('ostatnie2').style.background="#a1bc52";
	document.getElementById('ostatnie2').style.width="33%";
	document.getElementById('ostatnie2').style.height="30%";
	document.getElementById('ostatnie2').style.margin="0%";
	document.getElementById('ostatnie2').style.textAlign="center";
	document.getElementById('ostatnie2').style.paddingTop="4%";
	document.getElementById('ostatnie2').style.float="left";
	document.getElementById('ostatnie3').style.background="#bfe258";
	document.getElementById('ostatnie3').style.width="34%";
	document.getElementById('ostatnie3').style.height="30%";
	document.getElementById('ostatnie3').style.margin="0%";
	document.getElementById('ostatnie3').style.textAlign="center";
	document.getElementById('ostatnie3').style.paddingTop="4%";	
	document.getElementById('ostatnie3').style.float="left";
	
	$.get('panel_gry2.php',{opcja:1}, function(zmienna)
	{
		gracze='';
		gracze=zmienna.split(';');
		for(var i=1;i<=gracze[0]; i++)
		{
			gracze[i]=gracze[i].split(',');
		}
		
		document.getElementById('ostatnie1').innerHTML="<b>"+gracze[1][0]+"</b>";
		if(gracze[1][0]!="-")
		{
			document.getElementById('ostatnie1').style.cursor="pointer";
			document.getElementById('ostatnie1').innerHTML+="</br>win: "+(Number(gracze[1][1])+Number(gracze[1][4])+Number(gracze[1][7]));
			document.getElementById('ostatnie1').innerHTML+="</br>draw: "+(Number(gracze[1][2])+Number(gracze[1][5])+Number(gracze[1][8]));
			document.getElementById('ostatnie1').innerHTML+="</br>loss: "+(Number(gracze[1][3])+Number(gracze[1][6])+Number(gracze[1][9]));
		}
		document.getElementById('ostatnie2').innerHTML="<b>"+gracze[2][0]+"</b>";
		if(gracze[2][0]!="-")
		{
			document.getElementById('ostatnie2').style.cursor="pointer";
			document.getElementById('ostatnie2').innerHTML+="</br>win: "+(Number(gracze[2][1])+Number(gracze[2][4])+Number(gracze[2][7]));
			document.getElementById('ostatnie2').innerHTML+="</br>draw: "+(Number(gracze[2][2])+Number(gracze[2][5])+Number(gracze[2][8]));
			document.getElementById('ostatnie2').innerHTML+="</br>loss: "+(Number(gracze[2][3])+Number(gracze[2][6])+Number(gracze[2][9]));
		}
		document.getElementById('ostatnie3').innerHTML="<b>"+gracze[3][0]+"</b>";
		if(gracze[3][0]!="-")
		{
			document.getElementById('ostatnie3').style.cursor="pointer";
			document.getElementById('ostatnie3').innerHTML+="</br>win: "+(Number(gracze[3][1])+Number(gracze[3][4])+Number(gracze[3][7]));
			document.getElementById('ostatnie3').innerHTML+="</br>draw: "+(Number(gracze[3][2])+Number(gracze[3][5])+Number(gracze[3][8]));
			document.getElementById('ostatnie3').innerHTML+="</br>loss: "+(Number(gracze[3][3])+Number(gracze[3][6])+Number(gracze[3][9]));
		}
		var b=document.getElementById("szukaj");
		b.addEventListener('click',function(event){
			szukaj();
		
		
		});
		var c = document.getElementById('aktualne');
		c.addEventListener('click',function(event){
			wyswietl();
		
		});
		var e = document.getElementById('losowy');
		e.addEventListener('click',function(event){
			losuj();
		
		});
		
		var f=document.getElementById('ostatnie');
		f.addEventListener('click',function(event){
			ostatnie();
		
		});
		var d1=document.getElementById('ostatnie1');
		d1.addEventListener('click',function(event){
			$.get('panel_gry2.php',{opcja:6},function(zmienna){
				var pom_tryb=zmienna;
				if(pom_tryb==1)
				{
				$.get('panel_gry2.php',{opcja:3,gracz:gracze[1][0]},function(zmienna){
							location.href="plansza1.php";
				});
				}
				else if(pom_tryb==2)
				{
					$.get('panel_gry2.php',{opcja:8,gracz:gracze[1][0]},function(zmienna){
								location.href="plansza2.php";
					});
				}
				else if(pom_tryb==3)
				{
					$.get('panel_gry2.php',{opcja:10,gracz:gracze[1][0]},function(zmienna){
								location.href="plansza3.php";
					});
				}
			});
		});
		var d2=document.getElementById('ostatnie2');
		d2.addEventListener('click',function(event){
			$.get('panel_gry2.php',{opcja:6},function(zmienna){
				var pom_tryb=zmienna;
				if(pom_tryb==1)
				{
					$.get('panel_gry2.php',{opcja:3,gracz:gracze[2][0]},function(zmienna){
								location.href="plansza1.php";
					});
				}
				else if(pom_tryb==2)
				{
					$.get('panel_gry2.php',{opcja:8,gracz:gracze[2][0]},function(zmienna){
								location.href="plansza2.php";
					});
				}
				else if(pom_tryb==3)
				{
					$.get('panel_gry2.php',{opcja:10,gracz:gracze[2][0]},function(zmienna){
								location.href="plansza3.php";
					});
				}
				
			});
		});
		var d3=document.getElementById('ostatnie3');
		d3.addEventListener('click',function(event){
			$.get('panel_gry2.php',{opcja:6},function(zmienna){
				var pom_tryb=zmienna;
				if(pom_tryb==1)
				{
					$.get('panel_gry2.php',{opcja:3,gracz:gracze[3][0]},function(zmienna){
								location.href="plansza1.php";
					});
				}
				else if(pom_tryb==2)
				{
					$.get('panel_gry2.php',{opcja:8,gracz:gracze[3][0]},function(zmienna){
								location.href="plansza2.php";
					});
				}
				else if(pom_tryb==3)
				{
					$.get('panel_gry2.php',{opcja:10,gracz:gracze[3][0]},function(zmienna){
								location.href="plansza3.php";
					});
				}
			});
		});
	});
	
}

function ostatnie()
{
	document.getElementById("plansza1").innerHTML='<div id="wyszukiwarka"></div><div id="pole"></div><div id="powrot"></div>';
	document.getElementById("wyszukiwarka").style.background="#3ec311";
	document.getElementById("wyszukiwarka").style.height="8%";
	document.getElementById("wyszukiwarka").style.width="100%";
	document.getElementById("wyszukiwarka").style.textAlign="center";
	document.getElementById("wyszukiwarka").style.paddingTop="3%";
	document.getElementById("wyszukiwarka").innerHTML='<b>PRZECIWNICY</b>';
	document.getElementById("pole").style.background="#bfe258";
	document.getElementById("pole").style.height="80%";
	document.getElementById("pole").style.width="100%";
	document.getElementById("pole").style.textAlign="center";
	document.getElementById("pole").innerHTML="";
	document.getElementById("pole").style.overflow="scroll";
	document.getElementById("powrot").style.background="#777777";
	document.getElementById("powrot").style.height="10%";
	document.getElementById("powrot").style.width="100%";
	document.getElementById("powrot").innerHTML="<b>COFNIJ</b>";
	document.getElementById("powrot").style.textAlign="center";
	document.getElementById('powrot').style.cursor="pointer";
	document.getElementById('powrot').style.position="relative";
	
	$.get('panel_gry2.php',{opcja:1},function(zmienna)
	{
		gracze=zmienna.split(';');
		for(var i=1; i<=gracze[0]; i++)
		{
			gracze[i]=gracze[i].split(',');
		}
		for(var i=1; (i<=gracze[0] || i<=5)&&i<=8; i++)
		{
			
			document.getElementById("pole").innerHTML+='<div id="pole'+i+'"></div>';
			document.getElementById("pole"+i+"").style.width="100%";
			document.getElementById("pole"+i+"").style.height="20%";
			document.getElementById("pole"+i+"").style.textAlign="center";
			if(gracze[i]!='-')
			{
				document.getElementById("pole"+i+"").style.cursor="pointer";
			}
			if(i%2==1)
			{
				document.getElementById("pole"+i+"").style.background="#bfe258";
			}
			else
			{
				document.getElementById("pole"+i+"").style.background="#a1bc52";
			}
			
			document.getElementById("pole"+i+"").innerHTML="<b>"+gracze[i][0]+'</b>';
			if(gracze[i][0]!='-')
			{
				document.getElementById("pole"+i+"").innerHTML+="</br>3x3: "+gracze[i][1]+"-"+gracze[i][2]+"-"+gracze[i][3];
				document.getElementById("pole"+i+"").innerHTML+="</br>4x4: "+gracze[i][4]+"-"+gracze[i][5]+"-"+gracze[i][6];
				document.getElementById("pole"+i+"").innerHTML+="</br>5x5: "+gracze[i][7]+"-"+gracze[i][8]+"-"+gracze[i][9];
		
			}
		}
		var b=document.getElementById("pole");
		var h=document.getElementById("powrot").offsetTop - b.offsetTop;
		var h1=h/5;
		b.addEventListener('click',function(event){		
			var mouseX = event.pageX - b.offsetLeft;
			var mouseY = event.pageY - b.offsetTop;
			var nr=Math.floor((mouseY+b.scrollTop)/h1);
			if(gracze[nr+1][0]!='-')
			{
				$.get('panel_gry2.php',{opcja:6},function(zmienna){
				var pom_tryb=zmienna;
				if(pom_tryb==1)
				{
						
					$.get('panel_gry2.php',{opcja:3,gracz:gracze[nr+1][0]},function(zmienna){
						location.href="plansza1.php";
					});
				}
				
				else if(pom_tryb==2)
				{
						
					$.get('panel_gry2.php',{opcja:8,gracz:gracze[nr+1][0]},function(zmienna){
						location.href="plansza2.php";
					});
				}
				else if(pom_tryb==3)
				{
						
					$.get('panel_gry2.php',{opcja:10,gracz:gracze[nr+1][0]},function(zmienna){
						location.href="plansza3.php";
					});
				}
				});
			
			}
		});
	});
	var p1=document.getElementById("powrot");
	p1.addEventListener('click',function(event){
		start();
	});
}
function wyswietl()
{
	document.getElementById("plansza1").innerHTML='<div id="wyszukiwarka"></div><div id="pole"></div><div id="powrot"></div>';
	document.getElementById("wyszukiwarka").style.background="#3ec311";
	document.getElementById("wyszukiwarka").style.height="8%";
	document.getElementById("wyszukiwarka").style.width="100%";
	document.getElementById("wyszukiwarka").style.textAlign="center";
	document.getElementById("wyszukiwarka").style.paddingTop="3%";
	document.getElementById("wyszukiwarka").innerHTML='<b>ROZPOCZETE GRY</b>';
	document.getElementById("pole").style.background="#bfe258";
	document.getElementById("pole").style.height="80%";
	document.getElementById("pole").style.width="100%";
	document.getElementById("pole").style.textAlign="center";
	document.getElementById("pole").innerHTML="";
	document.getElementById("pole").style.overflow="scroll";
	document.getElementById("powrot").style.background="#777777";
	document.getElementById("powrot").style.height="10%";
	document.getElementById("powrot").style.width="100%";
	document.getElementById("powrot").innerHTML="<b>COFNIJ</b>";
	document.getElementById("powrot").style.textAlign="center";
	document.getElementById('powrot').style.cursor="pointer";
	
	$.get('panel_gry2.php',{opcja:5},function(zmienna)
	{
		gracze='';
		gracze=zmienna.split(',');
		for(var i=1; (i<=gracze[0] || i<=10) && i<=16; i++)
		{
			gracze[i]=gracze[i].split(';');

		}
		for(var i=1; (i<=gracze[0] || i<=10) && i<=16; i++)
		{
			document.getElementById("pole").innerHTML+='<div id="pole'+i+'"></div>';
			document.getElementById("pole"+i+"").style.width="100%";
			document.getElementById("pole"+i+"").style.height="10%";
			document.getElementById("pole"+i+"").style.minHeight="10%";
			document.getElementById("pole"+i+"").style.textAlign="center";
			document.getElementById("pole"+i+"").style.float="left";
			if(gracze[i][0]!=' ')
			{
				document.getElementById("pole"+i+"").style.cursor="pointer";
			}
			if(i%2==1)
			{
				document.getElementById("pole"+i+"").style.background="#bfe258";
			}
			else
			{
				document.getElementById("pole"+i+"").style.background="#a1bc52";
			}
			
			document.getElementById("pole"+i+"").innerHTML=gracze[i][0];
			if(gracze[i][1]==1)
			{
				document.getElementById("pole"+i+"").innerHTML+="    -3x3<br/>"+gracze[i][3];
			}
			else if(gracze[i][1]==2)
			{
				document.getElementById("pole"+i+"").innerHTML+="    -4x4<br/>"+gracze[i][3];
			}
			else if(gracze[i][1]==3)
			{
				document.getElementById("pole"+i+"").innerHTML+="    -5x5<br/>"+gracze[i][3];
			}
		}
		var b=document.getElementById("pole");
			var h=document.getElementById("powrot").offsetTop - b.offsetTop;
			var h1=h/10;
			b.addEventListener('click',function(event){
			
				var mouseX = event.pageX - b.offsetLeft;
				var mouseY = event.pageY - b.offsetTop;
				var nr=Math.floor((mouseY+b.scrollTop)/h1);
				if(gracze[nr][0]!=' ')
				{
					$.get('panel_gry2.php',{opcja:9,gracz:gracze[nr+1][2]},function(zmienna){
						if(gracze[nr+1][1]==1)
						{
							location.href="plansza1.php";
						}
						else if(gracze[nr+1][1]==2)
						{
							location.href="plansza2.php";
						}
						else if(gracze[nr+1][1]==3)
						{
							location.href="plansza3.php";
						}
					});
				
				}
			});
	});
	var p1=document.getElementById("powrot");
	p1.addEventListener('click',function(event){
		start();
	});
}

function szukaj()
{
	document.getElementById("plansza1").innerHTML='<div id="wyszukiwarka"></div><div id="pole"></div><div id="powrot"></div>';
	document.getElementById("wyszukiwarka").style.background="#3ec311";
	document.getElementById("wyszukiwarka").style.height="10%";
	document.getElementById("wyszukiwarka").style.width="100%";
	document.getElementById("wyszukiwarka").style.textAlign="center";
	document.getElementById("wyszukiwarka").innerHTML='Nazwa: <input type="text" id="fraza" value=""/><br/><input type="submit" value="szukaj" onclick="sprawdz()"/>';
	document.getElementById("pole").style.background="#a1bc52";
	document.getElementById("pole").style.height="80%";
	document.getElementById("pole").style.width="100%";
	document.getElementById("pole").style.textAlign="center";
	document.getElementById("pole").innerHTML="";
	document.getElementById("pole").style.overflow="scroll";
	document.getElementById("powrot").style.background="#777777";
	document.getElementById("powrot").style.height="10%";
	document.getElementById("powrot").style.width="100%";
	document.getElementById("powrot").innerHTML="<b>COFNIJ</b>";
	document.getElementById("powrot").style.textAlign="center";
	document.getElementById('powrot').style.cursor="pointer";
	
	
	var p1=document.getElementById("powrot");
	p1.addEventListener('click',function(event){
		start();
	});
}

function sprawdz()
{
	var a=document.getElementById("fraza").value;
	document.getElementById("pole").innerHTML="";
	$.get('panel_gry2.php',{opcja:2, fraza:a}, function(zmienna){
		gracze="";
		gracze=zmienna.split(',');
		for(var i=1;(i<=10 ||i<=gracze[0])&& i<=32; i++)
		{
			document.getElementById("pole").innerHTML+='<div id="pole'+i+'"></div>';
			document.getElementById("pole"+i+"").style.width="100%";
			document.getElementById("pole"+i+"").style.height="10%";
			document.getElementById("pole"+i+"").style.textAlign="center";
			if(gracze[i]!='')
			{
				document.getElementById("pole"+i+"").style.cursor="pointer";
			}
			document.getElementById("pole"+i+"").innerHTML=gracze[i];
			if(i%2==1)
			{
				document.getElementById("pole"+i+"").style.background="#bfe258";
			}
			else
			{
				document.getElementById("pole"+i+"").style.background="#a1bc52";
			}
			
		}
		var b=document.getElementById("pole");
		var h=document.getElementById("powrot").offsetTop - b.offsetTop;
		var h1=h/10;
		b.addEventListener('click',function(event){
		
			var mouseX = event.pageX - b.offsetLeft;
			var mouseY = event.pageY - b.offsetTop;
			var nr=Math.floor((mouseY+b.scrollTop)/h1);
			if(gracze[nr+1]!='')
			{
				
				$.get('panel_gry2.php',{opcja:6},function(zmienna){
				var pom_tryb=zmienna;
				if(pom_tryb==1)
				{					
					$.get('panel_gry2.php',{opcja:3,gracz:gracze[nr+1]},function(zmienna){
						location.href="plansza1.php";
					});
				}
				
				else if(pom_tryb==2)
				{
						
					$.get('panel_gry2.php',{opcja:8,gracz:gracze[nr+1]},function(zmienna){
						location.href="plansza2.php";
					});
				}
				else if(pom_tryb==3)
				{
						
					$.get('panel_gry2.php',{opcja:10,gracz:gracze[nr+1]},function(zmienna){
						location.href="plansza3.php";
					});
				}
				});

			}
			
		});
	});
	var p1=document.getElementById("powrot");
	p1.addEventListener('click',function(event){
		start();
	});
}

function tryb_gry()
{

	document.getElementById("tryb").innerHTML='<div id="tryb1"></div><div id="tryb2"></div><div id="tryb3"></div>';
	var a=document.getElementById("tryb1");
	var b=document.getElementById("tryb2");
	var c=document.getElementById("tryb3");
	a.innerHTML="<b>3x3</b>";
	a.style.background=kolor2;
	a.style.width="32%";
	a.style.height="97%";
	a.style.marginLeft="1%";
	a.style.float="left";
	a.style.paddingTop="3%";
	a.style.textAlign="center";
	a.style.cursor="pointer";
	b.innerHTML="<b>4x4</b>";
	b.style.background=kolor2;
	b.style.width="32%";
	b.style.height="97%";
	b.style.marginLeft="1%";
	b.style.float="left";
	b.style.paddingTop="3%";
	b.style.textAlign="center";
	b.style.cursor="pointer";
	c.innerHTML="<b>5x5</b>";
	c.style.background=kolor2;
	c.style.width="32%";
	c.style.height="97%";
	c.style.marginLeft="1%";
	c.style.float="left";
	c.style.paddingTop="3%";
	c.style.textAlign="center";
	c.style.cursor="pointer";
	
	$.get('panel_gry2.php',{opcja:6},function(zmienna){
		var pom_tryb=zmienna;
		if(pom_tryb==1)
		{
			a.style.background=kolor1;
		}
		else if(pom_tryb==2)
		{
			b.style.background=kolor1;
		}
		else if(pom_tryb==3)
		{
			c.style.background=kolor1;
		}
		a.addEventListener('click',function(event){
			if(los==0)
			{
				a.style.background=kolor1;
				b.style.background=kolor2;
				c.style.background=kolor2;
				$.get('panel_gry2.php',{opcja:7,tryb:1});
			}
		});
		b.addEventListener('click',function(event){
			if(los==0)
			{
				a.style.background=kolor2;
				b.style.background=kolor1;
				c.style.background=kolor2;
				$.get('panel_gry2.php',{opcja:7,tryb:2});
			}
		});
		c.addEventListener('click',function(event){
			if(los==0)
			{
				a.style.background=kolor2;
				b.style.background=kolor2;
				c.style.background=kolor1;
				$.get('panel_gry2.php',{opcja:7,tryb:3});
			}
		});
	});
	
}

function losuj()
{
	document.getElementById("plansza1").innerHTML='<div id="wyszukiwarka"></div><div id="pole"></div><div id="powrot"></div>';
	document.getElementById("wyszukiwarka").style.background="#32a40c";
	document.getElementById("wyszukiwarka").style.height="7%";
	document.getElementById("wyszukiwarka").style.width="100%";
	document.getElementById("wyszukiwarka").style.textAlign="center";
	document.getElementById("wyszukiwarka").style.paddingTop="3%";
	document.getElementById("wyszukiwarka").innerHTML='<b>Szukanie przeciwnika</b>';
	document.getElementById("pole").style.background="#3ec311";
	document.getElementById("pole").style.height="70%";
	document.getElementById("pole").style.width="100%";
	document.getElementById("pole").style.textAlign="center";
	document.getElementById("pole").style.paddingTop="5%";
	document.getElementById("pole").innerHTML="";
	document.getElementById("powrot").style.background="#e45757";
	document.getElementById("powrot").style.height="17%";
	document.getElementById("powrot").style.width="100%";
	document.getElementById("powrot").innerHTML="<b>ANULUJ</b>";
	document.getElementById("powrot").style.textAlign="center";
	document.getElementById("powrot").style.paddingTop="3%";
	document.getElementById('powrot').style.cursor="pointer";
	
	$.get('panel_gry2.php',{opcja:6},function(zmienna){
			var pom_tryb=zmienna;
			if(pom_tryb==1)
			{
				$.get('panel_gry2.php',{opcja:11},function(zmienna2){
					if(zmienna2=="nie")
					{
						los=1;
						trwa_los();
					}
					else if(zmienna2=="tak")
					{
					location.href="plansza1.php";
					}
					
				});
			}
			else if(pom_tryb==2)
			{
				$.get('panel_gry2.php',{opcja:12},function(zmienna2){
					if(zmienna2=="nie")
					{
						los=1;
						trwa_los();
					}
					else if(zmienna2=="tak")
					{
						location.href="plansza2.php";
					}
					
				});
			}
			else if(pom_tryb==3)
			{
				$.get('panel_gry2.php',{opcja:13},function(zmienna2){
					if(zmienna2=="nie")
					{
						los=1;
						trwa_los();
					}
					else if(zmienna2=="tak")
					{
						location.href="plansza3.php";
					}
					
				});
			}
			
		});
		
	var p1=document.getElementById("powrot");
	p1.addEventListener('click',function(event){
		
		$.get("panel_gry2.php",{opcja:15},function(zmienna)
		{
			start();
		});
	});
}

function trwa_los()
{
	if(los==1)
	{
		$.get("panel_gry2.php",{opcja:14},function(zmienna)
		{
			if(zmienna=="tak")
			{
				
				los=0;
				$.get('panel_gry2.php',{opcja:6},function(zmienna2){
					var pom_tryb=zmienna2;
					if(pom_tryb==1)
					{
						location.href="plansza1.php";
					}
					else if(pom_tryb==2)
					{
						location.href="plansza2.php";
					}
					else if(pom_tryb==3)
					{
						location.href="plansza3.php";
					}
				});
				
			}
			else if(zmienna=="nie")
			{
				los=0;
				setTimeout(start,1500);
				
			}
			else
			{
				if(zmienna<30)
				{
					
					document.getElementById("pole").innerHTML="czekaj</br>"+zmienna;
				}
				if(zmienna==30)
				{
					
					document.getElementById("pole").innerHTML="NIE ZNALEZIONO PRZECIWNIKA";
				}
				
			}
		});
		var p1=document.getElementById("powrot");
		p1.addEventListener('click',function(event){
			$.get("panel_gry2.php",{opcja:15},function(zmienna)
			{
				los=0;
				start()
			});
		});
	}
}
setInterval(trwa_los,1000);

window.addEventListener('load',function(event){
	start();
	tryb_gry();
});
</script>


<style>
body
{
	background-color:#E8E07C;
}

#plansza
{
	width:100%;
	height:100%;
	background-color:#E8E07C;
	max-width:500px;
	margin-left:auto;
	margin-right:auto;
	line-height:100%;
	display: table;
	Line-height
}
#tryb
{
	width:100%;
	height:10%;
	margin-left:auto;
	margin-right:auto;
	padding:0px;
	float:left;
	
}
#plansza1
{
	width:100%;
	height:80%;
	max-height:80%;
	background-color:#E8E07C;
	margin-left:auto;
	margin-right:auto;
	padding:0px;
	float:left;
}

#wyloguj
{
	width:100%;
	height:7%;
	background-color:#666666;
	text-align:center;
	padding-top:3%;
	float:left;
	vertical-align: middle;
	
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
		<div id="tryb"></div>
		<div id="plansza1"></div>
			

		<a href="logout.php"><div id="wyloguj"><b>WYLOGUJ</b></div></a>

	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
</body>
</html
