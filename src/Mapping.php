<?php

namespace UniMapper\Mongo;

use UniMapper\Reflection;

class Mapping extends \UniMapper\Mapping
{

    private $operators = [
        'IN' => '$in',
        '>=' => '$gte',
        '<=' => '$lte',
        '=' => null,
        '<' => '$le',
        '>' => '$gt',
        'LIKE' => null,
        '!=' => '$ne',
        'COMPARE' => null
    ];

    public function unmapConditions(
        array $conditions,
        Reflection\Entity $entityReflection = null
    ) {
        $converted = [];
        foreach (parent::unmapConditions($conditions, $entityReflection) as $condition) {
            $converted[] = $this->_convertCondition($condition);
        }
        return $converted;
    }

    private function _convertCondition($condition)
    {
        if (is_array($condition[0])) {
            // Nested conditions

            list($nestedConditions, $joiner) = $condition;
        } else {

        }
    }

    public function unmapSelection(
        array $selection,
        Reflection\Entity $entityReflection = null
    ) {
        return array_fill_keys(
            parent::unmapSelection($selection, $entityReflection),
            true
        );
    }
}
