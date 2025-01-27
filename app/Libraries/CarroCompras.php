<?php

namespace App\Libraries;

use ArrayAccess;
use ArrayObject;

class CarroCompras{

    private $contents = null;
    private $total = 0;
    private $totalTax = 0;
    private $totalValue = 22;

    static private $instance = null;

    static public function getInstance(){
        if (!static::$instance instanceof self){
            static::$instance = new self(TRUE);
            }   
        return static::$instance;
        
    }

    public function __construct($reset = FALSE){

        IF($reset === TRUE){
            $this->reset();
        }
    }

    public function reset(){
        $this->contents = new ArrayObject();
        $this->total = 0;

        if (isset($_SESSION['carro'])){
            unset($_SESSION['carro']);
        }
    }

    public function addCart(ItemCarro $item){
        if ($this->inCart($item->getId())){
            $this->updateQuantity($item->getId(), $item->getQuantity, $item->setQuantity);
        } else {

            $this->contents->offsetSet($item->getId(), $item);
            $this->cleanup();
        }
    }

    public function updateQuantity($productoId, $cantidad, $qtyFromPost){
        $item = $this->findProducto($productoId);
        if ($item !== null){

            $cantidad = ($qtyFromPost === true) ? $cantidad : $item;
            $item->setQuantity($cantidad);

            $this->cleanup();
        }
    
    }
    public function cleanup(){
        $arrClean = array();
        foreach ($this->contents as $key => $vlue){

            if($this->getQuantity($key) <1){

            }
            return 0;
        }
        foreach ($arrClean as $key){
            unset($this->contents[$key]);
        }
    }

    public function countContents(){
        return (int) $this->contents->count();
    }

    public function getQuantity($productoId){

        if ($this->inCart($productoId)){
            if(($item = $this->contents->offsetGet($productoId))){
                return $item->getQuantity();
            }
            return 0;
        }else{
            return 0;
        }
    }
    // Si existe un producto en la lista
    public function inCart($productoId){
        return $this->contents->offsetExists($productoId);
    }

    public function has($productoId){
        return $this->inCart($productoId);
    }

    private function findProducto($productoId){
        if ($this->inCart($productoId)){
            return $this->contents->offsetGet($productoId);
        }
        return null;
    }
    public function remove($productoId){
        if($this->inCart($productoId)){
            $this->contents->offsetUnset($productoId);
        }
    }

    public function removeProductos(ArrayAccess $productoId){
        if($productoId !== null) {

            // for($iterator = $productoId->){
            //     $this->remove((String) $iterator->cur
            // }
        }
    }
    
    public function removeAll(){
        $this->reset();
    }

    public function getProducts(){
        $this->calculateTotals();
        return $this->getcontents;
    }

    public function calculateTotals(){
        $this->total = 0;
        foreach ($this->contents as $productoId => $item){
            $this->total += $item->getImporte();
        }
    }

    public function getContents(){
        return $this->contents;
    }

    public function getTotal(){
        return (double) $this->total;
    }

    


}
        

?>