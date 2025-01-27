<?php

function src($filename, $type="full"){
    $path='./images/productos/';

    if($type != 'full'){
        $path .= $type . '/';

        return $path . $fileName;
    }

}

?>