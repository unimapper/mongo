<?php

namespace UniMapper\Mongo;

use UniMapper\Exceptions\AdapterException;

class Adapter extends \UniMapper\Adapter
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

    public function __construct($name, array $config = [])
    {
        parent::__construct($name, new Mapping);

        if ($config["database"] === null) {
            throw new AdapterException("No database selected!");
        }

        $this->database = $this->_createConnection(
            $this->defaultConfig + $config
        )->selectDB($config["database"]);
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

    public function delete($resource, $conditions)
    {
        throw new AdapterException("Not implemented!");
    }

    public function findOne($resource, $primaryName, $primaryValue,
        array $associations = [])
    {
        throw new AdapterException("Not implemented!");
    }

    public function find($resource, $selection = null, $conditions = null,
        $orderBy = null, $limit = 0, $offset = 0, array $associations = [])
    {
        $collection = $this->database->{$resource};
        if (!$collection) {
            throw new AdapterException(
                "Collection with name " . $resource . " not found!"
            );
        }

        $result = $collection->find(
            $conditions,
            array_fill_keys($selection, true)
        )->limit($limit)->skip($offset);

        if (!$result) {
            return false;
        }

        return iterator_to_array($result);
    }

    public function count($resource, $conditions)
    {
        throw new AdapterException("Not implemented!");
    }

    public function insert($resource, array $values)
    {
        $collection = $this->database->{$resource};
        if (!$collection) {
            throw new AdapterException("Collection with name " . $resource . " not found!");
        }

        $result = $collection->insert($values);
        if ($result["err"] !== null) {
            throw new AdapterException($result["err"]);
        }

        return $values["_id"];
    }

    public function update($resource, array $values, $conditions = null)
    {
        throw new AdapterException("Not implemented!");
    }

    public function updateOne($resource, $primaryName, $primaryValue,
        array $values
    ) {
        throw new AdapterException("Not implemented!");
    }

}