<?php

namespace App\Contracts;

interface FoodProviderInterface
{
    public function identify(string $query): ?string;
}
