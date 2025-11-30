<?php

namespace App\Config;

use App\Rule\RuleInterface;

interface RuleConfigInterface
{

    public function getRules(): iterable;
}
