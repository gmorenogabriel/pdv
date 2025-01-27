<?php

namespace App\Libraries;

class Pdv{
    public $producto;
    public $precio;

    public function info(){

        return "Producto: $this->producto | Precio: $this->precio $";
    }
    public function hash(){
        $chars = "abcdefghijklmnopqrABCDEFGHIJK";
        return substr(str_shuffle($chars),0,10);

    }

}


?>
