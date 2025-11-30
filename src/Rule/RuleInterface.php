<?php

namespace App\Rule;

interface RuleInterface
{
    public function getField(): string;

    public function getGlueOperator(): string;

    public function getComparisonOperator(): string;

    public function getRawValue(): string;
}
