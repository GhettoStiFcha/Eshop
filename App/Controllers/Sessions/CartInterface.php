<?php

namespace Controllers\Sessions;

interface CartInterface
{
    public function addItem(int $id, ?int $size): int;
    public function removeItem(int $id, ?int $size): int;
    public function deleteItem(int $id, ?int $size);
    public function getAllItems(): array;
    public function getItemsIDs(): array;
}