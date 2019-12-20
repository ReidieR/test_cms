<?php

for ($i=1;$i<5;$i++) {
    $res = 1;
    for ($j=1;$j<=$i;$j++) {
        $res += $res*$j;
    }
}
echo $res;
