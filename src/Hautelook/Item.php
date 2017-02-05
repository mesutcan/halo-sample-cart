<?php
namespace Hautelook;

class Item
{

    public $name;

    public $price;

    public $quantity;

    public $lb;

    public function __construct( $name,  $price,  $quantity,  $lb)
    {
        $this->name = $name;
        // price * 100 as integer for decimal precision
        $this->price = $price*100;
        $this->quantity = $quantity;
        $this->lb = $lb;
    }

    public function addQuantity($quantity){
        $this->quantity += $quantity;
    }

}
