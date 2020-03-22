<?php
session_start();

if (isset($_COOKIE["cookiejar"])) {
    // user logged in
#echo $_COOKIE["cookiejar"];
} else {
    header( 'Location: https://calx.no/login' );
}

$con=mysqli_connect($_SERVER['RDS_HOSTNAME'], $_SERVER['RDS_USERNAME'], $_SERVER['RDS_PASSWORD'], $_SERVER['RDS_DB_NAME'], $_SERVER['RDS_PORT']);
// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

$result3 = mysqli_query($con,"SELECT * FROM rygh.Cookie WHERE tkey='" . $_COOKIE["cookiejar"] ."'");
while($row = mysqli_fetch_array($result3))
{
$_SESSION['user_id'] = $row['RyghUser'];
echo $_SESSION['user_id'];
header( 'Location: https://calx.no/' );
}

$result4 = mysqli_query($con,"SELECT * FROM rygh.google_users WHERE google_id='" . $_SESSION['user_id'] ."'");
while($row = mysqli_fetch_array($result4))
{
If ($row['Calx']<>'') {
header( 'Location: https://calx.no/' );
} else {
include 'about.php';
#header( 'Location: https://calx.no/calxphp/about.php' );
}
}
?>
