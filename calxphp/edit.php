<?php
    include 'calxphp/html.php';
    $fromtype   = array("x0", "x1", "x2", "x3", "x4", "x5", "x6", "x7", "x8");
    $totype	 = array("default", "Vakt1 09:00-17:00", "<font color='#C0C0C0'>Vakt1</font>", "Vakt2 11:00-19:00", "<font color='#C0C0C0'>Vakt2</font>", "Baktvakt 00:00-23:59", "Ferie1", "Ferie2", "Live");
    ?>
<b>Calx v1.0 (edit)</b> -
<a href="https://calx.no/">calx</a><form method='POST' action='/calxphp/post.php'>
<table border="1" cellpadding="0" cellspacing="0"  bordercolor="#F4F4F4" width="100%" style="border-collapse: collapse" bgcolor="#FFFFFF">
<?php
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
        echo  "<tr>";
        echo    "<td width='8%' align='left' valign='top' bgcolor='#46AA46'><b>dato</b></td>";
        echo    "<td width='10%' align='left' valign='top' bgcolor='#46AA46'>$p1</td>";
        echo    "<td width='10%' align='left' valign='top' bgcolor='#46AA46'>$p2</td>";
        echo    "<td width='10%' align='left' valign='top' bgcolor='#46AA46'>$p3</td>";
        echo    "<td width='10%' align='left' valign='top' bgcolor='#46AA46'>$p4</td>";
        echo    "<td width='10%' align='left' valign='top' bgcolor='#46AA46'>$p5</td>";
        echo    "<td width='10%' align='left' valign='top' bgcolor='#46AA46'>Felles</td>";
        echo    "<td width='10%' align='left' valign='top' bgcolor='#46AA46'>Bursdag</td>";
        echo  "</tr>";
        $datofra=$_GET['edit'];
        
        #$result = mysqli_query($con,"SELECT * FROM rygh.calx".$calx." WHERE dato='$datofra' ORDER BY dato");
        $result = mysqli_query($conn,"SELECT dato,p1,p2,p3,p4,p5,f1,t1,t2,". $calx ." as bursdag FROM rygh.calx". $calx ." LEFT JOIN rygh.bursdag ON calx". $calx .".dag=bursdag.dag WHERE calx". $calx .".dato='$datofra'");
        while($row = mysqli_fetch_array($result))
        {
            echo  "<tr>";
            echo    "<td width='8%' align='left' valign='top'>" . $row['dato'] . "</td>";
            echo    "<td align='left' valign='top'><textarea rows='10' name='field1' cols='20' class='tttextarea'>" . $row['p1'] . "</textarea></td>";
            echo    "<td align='left' valign='top'><textarea rows='10' name='field2' cols='20' class='tttextarea'>" . $row['p2'] . "</textarea></td>";
            echo    "<td align='left' valign='top'><textarea rows='10' name='field3' cols='20' class='tttextarea'>" . $row['p3'] . "</textarea></td>";
            echo    "<td align='left' valign='top'><textarea rows='10' name='field4' cols='20' class='tttextarea'>" . $row['p4'] . "</textarea></td>";
            echo    "<td align='left' valign='top'><textarea rows='10' name='field5' cols='20' class='tttextarea'>" . $row['p5'] . "</textarea></td>";
            echo    "<td align='left' valign='top'><textarea rows='10' name='field6' cols='20' class='tttextarea'>" . $row['f1'] . "</textarea></td>";
            echo    "<td align='left' valign='top'><textarea rows='10' name='bursdag' cols='20' class='tttextarea'>" . $row['bursdag'] . "</textarea></td>";
            echo  "</tr>";
            echo  "<tr>";
            echo    "<td>&nbsp;</td>";
            echo    "<td align='right' valign='top'><select name='turnus'>";
            echo	"<option value='0' SELECTED>(Default)</option>";
            echo	"<option value='" . $row['t1'] . "' SELECTED>" . str_replace($fromtype, $totype, "x".$row['t1']) . "</option>";
            
            $x=1;
            while($x<=8) {
                echo	"<option value='" . $x . "'>" . str_replace($fromtype, $totype, "x".$x) . "</option>";
                $x++;
            }
            echo	"</td>";
            echo    "<td><input type='hidden' name='dato' value='" . $row['dato'] . "'>&nbsp;</td>";
            echo    "<td><input type='hidden' name='calx' value='" . $calx . "'>&nbsp;</td>";
            echo    "<td>&nbsp;</td>";
            echo  "</tr>";
            mysqli_close($conn);
            }
        }
    ?>  
<tr>
<td align="center"><input type='submit' value='Submit' name='B1' class='ttfoot'></td>
<td align="right" valign="top">&nbsp;</td>
<td align="right" valign="top">&nbsp;</td>
<td align="left" valign="top">&nbsp;</td>
<td align="left" valign="top">&nbsp;</td>
<td align="left" valign="top">&nbsp;</td>
</tr>

</table>
&nbsp;</form>
