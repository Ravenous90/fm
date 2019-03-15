<?php
$flags1 = ['id'];
$flags2 = ['id', 'name'];

$values1 = [25];
$values2 = [25, 'bolt'];

if (count($flags) == count($values)) {
    for ($i = 0; $i <= count($flags1); $i++) {
        if ($i < (count($flags1))) {
            $conditions .= $flags2[$i] . " = " . $values2[$i] . " AND ";

        } else {
            $conditions .= $flags2[$i] . " = '" . $values2[$i] ."'";
        }
    }
}

var_dump(count($flags1));
echo "<br>";
var_dump($conditions);