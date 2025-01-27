<?php

namespace App\Libraries;

class ItemCarro
{
    //$product viene de una consulta a la base de datos
    private $product = null;
    private $quantity = 0;
    private $subTotal = null;

    public function __construct($product = null, $qty = null){
        if($product != null && $qty != null){
            $this->product = $product;
            $this->quantity = (int) $qty;
            $this->calculateImporte();
        }
    }

    public function setProduct($product){
        $this->product = $product;
        $this->calculateImporte();

    }
    
    public function getId(){
        return $this->product->id;
    }

    public function getName(){
        return $this->product->nombre;
    }

    public function getPrice(){
        return $this->product->precio;
    }

    public function getQuantity(){
        return $this->subTotal;
    }
    
    public function setQuantity($value){
        $this->quantity = (int) $value;
        $this->calculateImporte();
    }
    
    private function calculateImporte(){
        $this->getSubTotal();
    }
    public function getSubTotal(){
        if ($this->getPrice() != 0  && null !== $this->getPrice()){
            $this->setSubTotal($this->getQuantity() * $this->getPrice());
            return $this->subTotal;
        }
        return 0;
    }
    public function setSubTotal($value){
        $this->subTotal = (double) $value;
    }
    

}
