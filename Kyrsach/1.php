<?
$lenght=$_POST['numb1']; //отримуємо к-сть комірок

$vhx=$_POST['mass1'];	//отримуємо набір точок
$vhy=$_POST['mass2'];

$serializegr1=serialize($vhx); //для передачі масиву в скрипт побудови графіка
$serializegr2=serialize($vhy);

$rizn=array($rizn1=array(), $rizn2=array()); //матриця різниць
$n=$lenght; //допоміжна змінна

for($i=0; $i<$n; $i++) //обнуляємо матрицю різниць
{
    for($j=0; $j<$n-2; $j++)
    {
        $rizn[$i][$j]=0;
    }
}

$krok=$vhx[1]-$vhx[0]; //ширина кроку по х

for($i=0; $i<$n-1; $i++)  //обчислюємо різниці першого порядку
{
    $rizn[$i][0]=$vhy[$i+1]-$vhy[$i];
}

for($j=1; $j<$n-3; $j++)    //знаходимо значення різниць ще двох порядків
{
    for($i=0; $i<=$n-$j-2; $i++)   //кількість різниць з кожним порядком зменшуватиметься на 1
    {
        $rizn[$i][$j]=$rizn[$i+1][$j-1]-$rizn[$i][$j-1];
        if ($rizn[4][2]) break;
    }
}

////перша формула Гауса - інтерполяція вперед

$x=$vhx[0]; //x-координата точки, по якій інтерполюють
$tx=array(); //для зберігання координат точок за першою формулою
$ty=array();

for($ix=0; $ix<($lenght*2)+1; $ix++)
{
    if ($ix!=0)
    {
        $x=$x+0.01;
    }

    $i=0;
    while($vhx[$i]<$x)
    {
        $i++; //знаходимо індекс елемента зліва від х
    }
    //обчислюємо частини поліному
    $p=($x-$vhx[$i])/$krok;
    $y1=$p*$rizn[$i][0];
    $y2=$p*($p-1)*$rizn[$i-1][1]/2;
    $y3=$p*($p-1)*($p+1)*$rizn[$i-1][2]/6;
    $y4=$p*($p-1)*($p+1)*($p-2)*$rizn[$i-2][3]/24;
    $yp=$vhy[$i]+$y1+$y2+$y3+$y4;

    $tx[$ix]=round($x, 4); //записуємо значення в масив з чотирма знаками після коми
    $ty[$ix]=round($yp, 4);
}

////друга формула Гауса - інтерполяція назад

$x=$vhx[$lenght-1]; //x-координата точки, по якій інтерполюють
$tx1=array(); //для зберігання координат точок за другою формулою
$ty1=array();

for($ix=0; $ix<($lenght*2)+1; $ix++)
{
    if ($ix!=0)
    {
        $x=$x-0.01;
    }

    $i=0;
    do{
        $i++; //знаходимо індекс елемента справа від х
    } while($vhx[$i]<$x);

    //обчислюємо частини поліному
    $p=($x-$vhx[$i])/$krok;
    $y1=$p*$rizn[$i-1][0];
    $y2=$p*($p-1)*$rizn[$i-1][1]/2;
    $y3=$p*($p-1)*($p+1)*$rizn[$i-2][2]/6;
    $y4=$p*($p-1)*($p+1)*($p-2)*$rizn[$i-2][3]/24;
    $yp=$vhy[$i]+$y1+$y2+$y3+$y4;

    $tx1[$ix]=round($x, 4); //записуємо значення в масив з чотирма знаками після коми
    $ty1[$ix]=round($yp, 4);
}

////виводимо таблиці

////таблиця із вхідними даними
echo "
		<!DOCTYPE html>
		<html>
			<head>
				<META content ='text/html; charset=utf-8' http-equiv='Content-Type'>
				<link rel='stylesheet' type='text/css' href='../css/main.css'>
				<title>Курсова робота</title>
	</head>
		<body>
		<h3 align='center' style='margin-top:1%';>Вхідні дані</h3>
		<table align='center' class='table_blur'>
		<tr><th>X</th>";
for($i=0; $i<$lenght; $i++)
{
    echo "<td>$vhx[$i]</td>";
}
echo "</tr>
		<tr><th>Y</th>";
for($i=0; $i<$lenght; $i++)
{
    echo "<td>$vhy[$i]</td>";
}
echo "</tr></table>";

////таблиця з вихідними даними за першою формулою
echo "
		<table style='margin-left: 65px;' align='left' class='table_blur'>
		<caption><h3>Вихідні дані за першою формулою</h3></caption>
		<tr><th><b>X</th>
			<th><b>Y</th>				
	</tr>";
for($i=0; $i<($lenght*2)+1; $i++)
{
    echo "<tr><td>$tx[$i]</td>
				  <td>$ty[$i]</td>				
		</tr>";
}
echo "</table>";

////таблиця з вихідними даними за другою формулою
echo "
		<table style='margin-right: 65px;' align=right class='table_blur'>
		<caption><h3>Вихідні дані за другою формулою</h3></caption>
		<tr><th><b>X</th>
			<th><b>Y</th>				
	</tr>";
for($i=0; $i<($lenght*2)+1; $i++)
{
    echo "<tr><td>$tx1[$i]</td>
				  <td>$ty1[$i]</td>				
		</tr>";
}
echo "</table>
		<br><br><br><br><big><h3 align='center'>Графік отриманої функції</h3></big>
		<p align='center'><img alt='Графік функції' src='graph.php?numbgr=".$lenght."&mass1gr=".$serializegr1."&mass2gr=".$serializegr2."'>
	
		<a href='../index.html' class='button1'>На головну</a>

	</body>
	</html>";
?>