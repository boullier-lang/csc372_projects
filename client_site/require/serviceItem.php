<!--Mathew Boullier-->
<!--03/08/26-->
<!--PHP class declaration for ServiceItems. Used in ServiceCategories.-->


<?php

class ServiceItem {
    private string $name;
    private string $price;

    public function __construct(string $name, string $price) {
        $this->name  = $name;
        $this->price = $price;
    }

    public function getName(): string {
        return htmlspecialchars($this->name);
    }

    public function getPrice(): string {
        return htmlspecialchars($this->price);
    }
}