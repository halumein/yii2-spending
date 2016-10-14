<?php

namespace halumein\spending\interfaces;

interface Spending
{
    public function add($name, $cost, $category, $cashboxId, $params);
}
