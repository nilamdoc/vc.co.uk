<?php

recurse(".");

function recurse($path){
    foreach(scandir($path) as $o){
        if($o != "." && $o != ".."){
            $full = $path . "/" . $o;
            if(is_dir($full)){
                if(!file_exists($full . "/index.php")){
                    file_put_contents($full . "/index.php", "");
                }
                recurse($full);
            }
        }
    }
}
?>