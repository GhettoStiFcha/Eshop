<?php

namespace Controllers\Sessions;

interface CartInterface
{
    public function addItem(int $id, int $size): int;
    public function removeItem(int $id): int;
    public function getItem(int $id): array;
    public function getAllItems(): array;
}