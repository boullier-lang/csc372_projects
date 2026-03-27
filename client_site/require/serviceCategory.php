<!--Mathew Boullier-->
<!--03/08/26-->
<!--PHP class declaration for service categories; this contains logic to get the category, items, etc.-->
<!--Requires class 'ServiceItem' to use.-->

<?php

require_once __DIR__ . '/serviceItem.php';

class ServiceCategory {
    private string $category;
    private array $items;

    public function __construct(string $category, array $items) {
        $this->category = $category;
        $this->items    = array_map(
            fn($item) => new ServiceItem($item['name'], $item['price']),
            $items
        );
    }

    public function getCategory(): string {
        return htmlspecialchars($this->category);
    }

    public function getItems(): array {
        return $this->items;
    }
}