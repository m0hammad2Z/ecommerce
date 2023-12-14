<?php

class OrderItem{
    public int $userId;
    public int $productId;
    public int $quantity;
    public float $price;
    public string $notes;

    function __construct(
        $userId,
        $productId,
        $quantity,
        $price,
        $notes
    )
    {       
        $this->userId = $userId;
        $this->productId = $productId;
        $this->quantity = $quantity;
        $this->price = $price;
        $this->notes = $notes;
    }
}

?>