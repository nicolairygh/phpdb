<?php
$calx = $_POST['calx'];
$p1 = $_POST['field1'];
$p2 = $_POST['field2'];
$p3 = $_POST['field3'];
$p4 = $_POST['field4'];
$p5 = $_POST['field5'];
$f1 = $_POST['field6'];
$bd = $_POST['bursdag'];
$t1 = $_POST['turnus'];
$dato = $_POST['dato'];
$dag = substr($dato, 5, 6);

$conn=new mysqli($_SERVER['RDS_HOSTNAME'], $_SERVER['RDS_USERNAME'], $_SERVER['RDS_PASSWORD'], $_SERVER['RDS_DB_NAME'], $_SERVER['RDS_PORT']);
    if (!mysqli_set_charset($conn, "utf8")) {
        #printf("Error loading character set utf8: %s\n", mysqli_error($link));
    }
$sql ="UPDATE rygh.calx".$calx." SET p1='$p1', p2='$p2', p3='$p3', p4='$p4', p5='$p5', f1='$f1', t1='$t1' WHERE dato='$dato'";

    #echo $sql;
    $result = $conn->query($sql);
    mysqli_close($conn);
    header( 'Location: https://calx.no' );
?>
