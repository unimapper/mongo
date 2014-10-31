<?php

namespace UniMapper\Mongo;

class Query implements \UniMapper\Adapter\IQuery
{

    private $resource;
    private $command;
    public $options = [];
    public $callback;
    public $after;

    private $operators = [
        'IN' => '$in',
        'NOT IN' => '$nin',
        '>=' => '$gte',
        '<=' => '$lte',
        '=' => null,
        '<' => '$le',
        '>' => '$gt',
        'LIKE' => null,
        '!=' => '$ne',
        'COMPARE' => null
    ];

    public function __construct($resource, $command)
    {
        $this->resource = $resource;
        $this->command = $command;
    }

    public function setConditions(array $conditions)
    {
        foreach ($conditions as $condition) {
            $this->options["criteria"][] = $this->_convertCondition($condition);
        }
    }

    private function _convertCondition(array $condition)
    {
        if (is_array($condition[0])) {
            // Nested conditions

            throw new \Exception("Not implemented!");
        } else {

            list($name, $operator, $value, $joiner) = $condition;

            $operator = $this->operators[$operator];

            if ($operator) {
                return [$operator => [$name => $value]];
            } else {
                return [$name, $value];
            }
        }
    }

    public function setAssociations(array $conditions)
    {
        throw new Exception("Not implemented!");
    }

    public function getRaw()
    {
        $options = $this->options ? json_encode($this->options) : "";

        return "db." . $this->resource . "." . $this->command . "(" .  $options . ")" . $this->after;
    }

}