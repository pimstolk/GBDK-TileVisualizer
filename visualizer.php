<?php
require_once('data.inc.php');

$hexSet = explode(",", $data);
$hexSetMap = explode(",", $mapdata);
$tiles = array();
$t = 0;


function d2b($dec, $n = 8) {
    return str_pad(decbin($dec), $n, "0", STR_PAD_LEFT);
}

for ($n=0; $n < count($hexSet); $n = $n+2) {
    if ($t == 0) {
        $data = '<table cellspacing="0" cellpadding="0" border=0>';
    }

    $byte1 = $hexSet[$n];
    $byte2 = $hexSet[$n+1];

    $data .= "<tr>";
    $pixel1 = d2b(hexdec($byte1));
    $pixel2 = d2b(hexdec($byte2));

    for ($i=0; $i < 8; $i++) {

        if ($pixel1{$i} == 1 && $pixel2{$i} == 1) {
            $bgcolor = "#000000";
        } else if ($pixel1{$i} == 0 && $pixel2{$i} == 1) {
            $bgcolor = "#CCCCCC";
        } else if ($pixel1{$i} == 1 && $pixel2{$i} == 0) {
            $bgcolor = "#666666";
        } else if ($pixel1{$i} == 0 && $pixel2{$i} == 0) {
            $bgcolor = "#e7fbcb";
        }
        $data .= "<td width='4' height='4' bgcolor='".$bgcolor."'> </td>";
    }
    $data .= "</tr>";

    if ($t == 7) {
        $data .= "</table>";

        array_push($tiles, $data) ;
        $t=0;
    } else {
        $t++;
    }
}



echo '<table cellspacing="0" cellpadding="0" border=1>';
$x = 0;
for ($n=0; $n < count($hexSetMap); $n++) {
    $tile = hexdec($hexSetMap[$n]);
    if ($x == 0) {
        echo "<tr>";
    }
    echo "<td width='30' height='4'>".$tiles[$tile]." </td>";

    if ($x == ($mapWidth - 1)){
        echo "</tr>";
        $x=0;
    } else {
        $x++;
    }
}
echo '</table>';


print_r($tiles);

?>