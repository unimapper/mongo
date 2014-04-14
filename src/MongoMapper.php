<?php

namespace UniMapper\Mapper;

use UniMapper\Query,
    UniMapper\Exception\MapperException;

class MongoMapper extends \UniMapper\Mapper
{

    /** @var \MongoDB */
    private $database;

    private $defaultConfig = [
        host => "localhost",
        port => "27017",
        username => null,
        password => null,
        database => null,
        options => []
    ];

    public function __construct(array $config, $name)
    {
        parent::__construct($name);
        if ($config["database"] === null) {
            throw new MapperException("No database selected!");
        }
        $this->database = $this->createConnection($this->defaultConfig + $config)->selectDB($config["database"]);
    }

    private function createConnection($config)
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

    public function custom(Query\Custom $query)
    {
        throw new MapperException("Not implemented!");
    }

    public function delete(Query\Delete $query)
    {
        throw new MapperException("Not implemented!");
    }

    public function findOne(Query\FindOne $query)
    {
        throw new MapperException("Not implemented!");
    }

    public function findAll(Query\FindAll $query)
    {
        throw new MapperException("Not implemented!");
    }

    public function count(Query\Count $query)
    {
        throw new MapperException("Not implemented!");
    }

    public function insert(Query\Insert $query)
    {
        throw new MapperException("Not implemented!");
    }

    public function update(Query\Update $query)
    {
        throw new MapperException("Not implemented!");
    }

}