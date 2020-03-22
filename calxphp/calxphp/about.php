<?php
session_start();
include 'html.php';
echo "<b>RyghCalx</b><br>Du er logget inn men det har skjedd en feil ved innlastning av din kalender.<br>Hvis dette gjentar seg ta kontakt med admin - pr¯v pÂ nytt <a href='logout.php'>her</a><br>";
echo $_COOKIE["cookiejar"];
?>
