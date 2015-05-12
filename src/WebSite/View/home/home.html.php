<?php
for($i=1;$i<count(array_keys($routes));$i++)
    echo '<a href="?p='.array_keys($routes)[$i].'">'.array_keys($routes)[$i].'</a><br />';