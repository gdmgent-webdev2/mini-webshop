<?php

namespace App\Services;


class CartCollection
{
    public $items;

    public function __construct()
    {
        $this->items = [];
    }

    public function add($data)
    {
        $currentItems = $this->items;

        $exists = false;

        foreach ($currentItems as $item)
        {
            if ($item->id === $data['id']) {
                $item->quantity += $data['quantity'];
                $exists = true;
            }
        }

        if (!$exists) {
            array_push($currentItems, new CartItem($data));
        }

        $this->items = $currentItems;
    }

    public function hasItems()
    {
        return count($this->items) > 0;
    }

    public function getTotal()
    {
        $total = 0;
        foreach ($this->items as $item)
        {
            $total += $item->getTotal();
        }
        return $total;
    }

}
