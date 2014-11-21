<?php

namespace UniMapper\Mongo;

use UniMapper\Exceptions\AdapterException,
    UniMapper\Association\ManyToMany;

class Adapter implements \UniMapper\Adapter\IAdapter
{

    /** @var \MongoDB */
    private $database;

    private $defaultConfig = [
        "host" => "localhost",
        "port" => 27017,
        "username" => null,
        "password" => null,
        "database" => null,
        "options" => []
    ];

    /** @var \UniMapper\Adapter\Mapper */
    private $mapper;

    public function __construct(array $config = [])
    {
        if ($config["database"] === null) {
            throw new AdapterException("No database selected!");
        }

        $this->database = $this->_createConnection(
            $this->defaultConfig + $config
        )->selectDB($config["database"]);

        $this->mapper = new \UniMapper\Adapter\Mapper;
    }

    private function _createConnection($config)
    {
        $url = "mongodb://";
        if ($config["username"] !== null) {

            $url .= $config["username"];
            if ($config["password"] !== null) {
                $url .=":" . $config["password"];
            }
            $url .= "@";
        }
        $url .= $config["host"];
        $url .= ":" . $config["port"];

        return new \MongoClient($url, $config["options"]);
    }

    public function createDelete($resource)
    {
        throw new AdapterException("Not implemented!");
    }

    public function createFindOne($resource, $primaryName, $primaryValue)
    {
        throw new AdapterException("Not implemented!");
    }

    public function createFind($resource, array $selection = [], array $orderBy = [], $limit = 0, $offset = 0)
    {
        $query = new Query($resource, "find");

        if ($selection) {
            $query->options["projection"] = array_fill_keys($selection, true);
        }

        $query->callback = function ($result) {
            return $result["retval"];
        };

        $query->after = ".toArray()";
        return $query;
    }

    public function createCount($resource)
    {
        throw new AdapterException("Not implemented!");
    }

    public function createInsert($resource, array $values)
    {
        throw new AdapterException("Not implemented!");
    }

    public function createUpdate($resource, array $values)
    {
        throw new AdapterException("Not implemented!");
    }

    public function createUpdateOne($resource, $name, $value, array $values)
    {
        throw new AdapterException("Not implemented!");
    }

    public function createModifyManyToMany(ManyToMany $association, $primaryValue, array $keys, $action = self::ASSOC_ADD)
    {
        throw new AdapterException("Not implemented!");
    }

    public function execute(\UniMapper\Adapter\IQuery $query)
    {
        $result = $this->database->execute($query->getRaw());

        $callback = $query->callback;
        if ($callback) {
            return $callback($result);
        }

        return $result;
    }

    public function getMapper()
    {
        return $this->mapper;
    }

}