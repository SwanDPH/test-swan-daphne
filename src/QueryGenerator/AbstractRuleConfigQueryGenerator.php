<?php

namespace App\QueryGenerator;

use App\Config\RuleConfigInterface;
use App\Rule\RuleInterface;
use App\Query\QueryBuilder;
use App\Query\QueryInterface;

abstract class AbstractRuleConfigQueryGenerator
{
    private const VALUE_SEPARATOR = ' OU ';

    public function __construct(
        protected readonly QueryBuilder $builder,
    ) {}

    public function generate(RuleConfigInterface $config): QueryInterface
    {
        $this->builder->reset();
        $rules = $config->getRules();
        foreach ($rules as $rule) {
            if ($rule instanceof RuleInterface == false) {
                continue;
            }

            $this->processRule($rule);
        }

        return $this->builder->buildQuery();
    }

    private function processRule(RuleInterface $rule): void
    {
        $values = $this->parseRuleValues($rule);
        if (count($values) > 1) {
            $this->buildMultiValueQuery($rule, $values);
        } else {
            if (count($values) == 0) {
                return;
            }

            $this->buildSingleValueQuery($rule, $values[0]);
        }
    }

    private function parseRuleValues(RuleInterface $rule): array
    {
        return explode(self::VALUE_SEPARATOR, (string) $rule->getRawValue());
    }

    private function buildMultiValueQuery(RuleInterface $rule, array $values): void
    {
        $glueOperator       = $rule->getGlueOperator();
        $comparisonOperator = $rule->getComparisonOperator();
        $field              = $rule->getField();

        $this->builder->$glueOperator(
            $this->builder->or(
                function () use ($comparisonOperator, $field, $values): void {
                    foreach ($values as $value) {
                        $this->builder->$comparisonOperator($field, $value);
                    }
                }
            )
        );
    }

    private function buildSingleValueQuery(RuleInterface $rule, string $value): void
    {
        $glueOperator       = $rule->getGlueOperator();
        $comparisonOperator = $rule->getComparisonOperator();
        $field              = $rule->getField();

        $this->builder->$glueOperator(
            $this->builder->$comparisonOperator($field, $value)
        );
    }
}
