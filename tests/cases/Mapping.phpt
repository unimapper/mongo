<?php

use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

class MappingTest extends Tester\TestCase
{

    public function testUnmapConditions()
    {
        $mapping = new UniMapper\Mongo\Mapping;

        Assert::same(
            array(
                '$and' => array(
                    array('id' => 4),
                    array(
                        '$or' => array(
                            array(
                                array('text', '/.*yetAnotherFoo2.*/'),
                                array(
                                    '$and' => array(
                                        array(
                                            '$or' => array('text' => 'yetAnotherFoo3'),
                                            '$or' => array('text' => 'yetAnotherFoo4')
                                        )
                                    ),
                                    '$or' => array('text' => 'yetAnotherFoo5')
                                )
                            )
                        )
                    )
                )
            ),
            $mapping->unmapConditions(
                array(
                    array(
                        array('id', '=', 4, 'AND'),
                        array(
                            array(
                                array('text', 'LIKE', '%yetAnotherFoo2%', 'AND'),
                                array(
                                    array(
                                        array('text', 'LIKE', 'yetAnotherFoo3', 'OR'),
                                        array('text', 'LIKE', 'yetAnotherFoo4', 'OR'),
                                    ),
                                    'AND'
                                ),
                                array('text', 'LIKE', 'yetAnotherFoo5', 'OR')
                            ),
                            'OR'
                        )
                    ),
                    'AND'
                )
            )
        );
    }

}

$testCase = new MappingTest;
$testCase->run();