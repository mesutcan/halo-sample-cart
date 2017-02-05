<?php
namespace Hautelook;

class Cart
{

    private $items = array();

    public $couponCodePercent = 0;

    public function __construct()
    {

    }

    public function subtotal()
    {
        $subtotal=0;
        foreach ($this->items as $item) {
            $subtotal += $item->price * $item->quantity;
        }
        $subtotal = $subtotal - $subtotal * $this->couponCodePercent / 100;

        return bcdiv($subtotal,100,2);
    }

    public function hasItem($name, $price){
        return array_key_exists($name, $this->items);
    }

    public function addItem( $name,  $price,  $quantity,  $lb){

        if(!array_key_exists($name, $this->items)){
            $this->items[$name]=new Item($name, $price, $quantity, $lb);
        }
        else{
            $this->items[$name]->addQuantity($quantity);
        }
    }

    public function getItemQuantity( $name){
        return $this->items[$name]->quantity;
    }



    public function total()
    {
        $total = 0;
        $subtotal = 0;
        $nbOver10lbs = 0;
        foreach ($this->items as $item) {
            $subtotal += $item->price  * $item->quantity;
            if($item->lb >= 10){
                $nbOver10lbs ++ ;
            }
        }
        $subtotal = $subtotal - $subtotal * $this->couponCodePercent / 100;
        // Under 100$
        if($subtotal < 10000){

            if ($nbOver10lbs == count($this->items)){
                $total = $subtotal + (2000 * $nbOver10lbs);
            }
            else
            {
                $total = $subtotal + 500 + (2000 * $nbOver10lbs);
            }
        }
        else{
            if($nbOver10lbs == 0){
                $total = $subtotal;
            }
            else{
                $total = $subtotal + 2000 * $nbOver10lbs;
            }
        }

        return bcdiv($total,100,2);
    }

    public function hasItems($item_count){
        return array_reduce($this->items, function($carry, $item){
            $carry += $item->quantity;
            return $carry;
        });
    }
} 
