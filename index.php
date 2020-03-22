<?php
    if ($_SERVER["SERVER_NAME"] == "rygh.no") {
        include 'rygh/index.php';
    } elseif ($_SERVER["SERVER_NAME"] == "nicolai.no") {
        include 'rygh/nicolai.php';
    } elseif ($_SERVER["SERVER_NAME"] == "www.rygh.no") {
            header( 'Location: http://rygh.no' );
    } elseif ($_SERVER["SERVER_NAME"] == "www.calx.no") {
            header( 'Location: https://calx.no' );
    } elseif ($_SERVER["SERVER_NAME"] == "www.nicolai.no") {
        header( 'Location: http://nicolai.no' );
    } else {
   //calx.no - denne siden
$calx = "";
$puser = "";
$p1 = "";
$p2 = "";
$p3 = "";
$p4 = "";
$p5 = "";
$px = "";
$php= "";
session_start();
if (isset($_SESSION['user_id'])) {
    // user logged in
} else {
    header( 'Location: https://calx.no/calxphp/index.php?user' );
}
if (empty($_GET)) {
$conn=new mysqli($_SERVER['RDS_HOSTNAME'], $_SERVER['RDS_USERNAME'], $_SERVER['RDS_PASSWORD'], $_SERVER['RDS_DB_NAME'], $_SERVER['RDS_PORT']);
    if (!mysqli_set_charset($conn, "utf8")) {
        #printf("Error loading character set utf8: %s\n", mysqli_error($link));
    }
$sql ="SELECT * FROM rygh.google_users WHERE google_id='" . $_SESSION['user_id'] ."'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
$calx = $row['calx'];
$puser = $row['RyghUser'];
$p1 = $row['p1'];
$p2 = $row['p2'];
$p3 = $row['p3'];
$p4 = $row['p4'];
$p5 = $row['p5'];
$px = $row['px'];
$php= $row['php'];
    }
if ($calx<>'') {
  #echo $_SESSION['user_id'] ;	
} else {
  #echo "logout";
#echo $_SESSION['user_id'];
header( 'Location: https://calx.no/calxphp/nybruker.php?calx=calx'.$calx ."&user=".$puser );
}
}
include 'calxphp/html.php';
echo "<b>Calx v1.0 for</b> <span class='style1'>" . $calx . "</span> | <a href='https://calx.no/login/logout.php'>logut</a> | ";
include 'calxphp/mnd.php';
echo "<table border='1' cellpadding='0' cellspacing='0'  bordercolor='#C0C0C0' width='100%' style='border-collapse: collapse' bgcolor='#FFFFFF'>";
echo  "<tr>";
echo    "<td width='8%' align='left' valign='top' bgcolor='#46AA46'><b>dato</b></td>";
echo    "<td width='20%' align='left' valign='top' bgcolor='#46AA46'>$p1</td>";
echo    "<td width='20%' align='left' valign='top' bgcolor='#46AA46'>$p2</td>";
echo    "<td width='20%' align='left' valign='top' bgcolor='#46AA46'>$px</td>";
echo    "<td width='20%' align='left' valign='top' bgcolor='#46AA46'>Felles</td>";
echo    "<td width='10%' align='left' valign='top' bgcolor='#46AA46'>Bursdag</td>";
echo  "</tr>";

if ($_SESSION['month']>0) {
  $datofra = date($_SESSION['year'] . "-" . $_SESSION['month'] . "-01");
echo $datofra;
} else {
  $datofra = date("Y-m-d");
}

$date=date_create($datofra);
date_add($date,date_interval_create_from_date_string("30 days"));
$datotil = date_format($date,"Y-m-d");
$from   = array("1", "2", "3", "4", "5", "6", "7");
$to	 = array("", "", "", "", "", "#0080C0", "#FF2828");
$x = "0";


//turnus
$fromtype   = array("x0", "x1", "x2", "x3", "x4", "x5", "x6", "x7", "x8");
$totype	 = array("", "Vakt1 09:00-17:00", "<font color='#C0C0C0'>Vakt1</font>", "Vakt2 11:00-19:00", "<font color='#C0C0C0'>Vakt2</font>", "Baktvakt 00:00-23:59", "Ferie1", "Ferie2", "Live" );
$t=1;


if ($datofra>date("2016-02-21")) {
$result2 = mysqli_query($conn,"SELECT type FROM rygh.turnus WHERE hvem='$p1' AND TURNUS=2 ORDER BY dag");
$turnusdager=35;
$turnusdageradj=14;
} else {
$result2 = mysqli_query($conn,"SELECT type FROM rygh.turnus WHERE hvem='$p1' AND TURNUS=1 ORDER BY dag");
$turnusdager=28;
$turnusdageradj=0;
}

while($row = mysqli_fetch_array($result2)) {
$type[$t] = "x" . $row['type'];
$t++;
}
#velg tabell rygh vs libe basert pÂ
$result = mysqli_query($conn,"SELECT dato,p1,p2,p3,p4,p5,f1,t1,t2,". $calx ." as bursdag FROM rygh.calx". $calx ." LEFT JOIN rygh.bursdag ON calx". $calx .".dag=bursdag.dag WHERE calx". $calx .".dato>='$datofra' AND calx". $calx .".dato<='$datotil' ORDER BY calx". $calx .".dato");
while($row = mysqli_fetch_array($result))
  {
  $d=strtotime("$datofra +$x Days");

  $wday = date('N',$d);
  $bgcolor = str_replace($from, $to, $wday);
	$datediff = (strtotime($row['dato']) - strtotime("2013-09-08"));
	$turnus = floor($datediff/(60*60*24))+$turnusdageradj;

while($turnus>$turnusdager) {
  $turnus -= $turnusdager;
}
if ($row['t1']>"0") {
  $turnustxt = str_replace($fromtype, $totype, "x".$row['t1']);
} else {
  $turnustxt = str_replace($fromtype, $totype, $type[$turnus]);
}

  echo "<tr><td align='left' valign='top' bgcolor='$bgcolor'><a href='?edit=" . $row['dato'] . "'>" . $row['dato'] . "</a> " . date('D',$d) . "<br></td>";
  echo "<td align='left' valign='top'>" . $row['p1'] . "<br>" . $turnustxt . "</td>";
  echo "<td align='left' valign='top'>" . $row['p2'] . "</td>";
  echo "<td align='left' valign='top'>". substr($p3,0,1) .":" . $row['p3'] . "<br>". substr($p4,0,1) .":" . $row['p4'] . "<br>". substr($p5,0,1) .":" . $row['p5'] . "</td>";
  echo "<td align='left' valign='top'>" . $row['f1'] . "</td>";
  echo "<td align='left' valign='top'>" . $row['bursdag'] . "</td>";
  echo "<tr>";
 $x++;
 }
mysqli_close($conn);  
    echo "</table>Calx by Rygh.no - All rights reserved";
    echo "</body></html>";
 #session_destroy(); 
 } else {
    include 'calxphp/edit.php';
}
    }
    ?>
