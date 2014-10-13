<?php
namespace Aura\SqlMapper_Bundle;

/**
 * Test class for MapperLocator.
 * Generated by PHPUnit on 2012-09-27 at 23:05:48.
 */
class MapperLocatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var MapperLocator
     */
    protected $mappers;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        parent::setUp();
        $registry = [
            'posts' => function() {
                $mapper = (object) ['type' => 'post'];
                return $mapper;
            },
            'comments' => function() {
                $mapper = (object) ['type' => 'comment'];
                return $mapper;
            },
            'authors' => function() {
                $mapper = (object) ['type' => 'author'];
                return $mapper;
            },
        ];

        $this->mappers = new MapperLocator($registry);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @covers Aura\Sql\MapperLocator::set
     * @todo Implement testSet().
     */
    public function testSetAndGet()
    {
        $this->mappers->set('tags', function () {
            $mapper = (object) ['type' => 'tag'];
            return $mapper;
        });

        $mapper = $this->mappers->get('tags');
        $this->assertTrue($mapper->type == 'tag');
    }

    public function testGet_noSuchGateway()
    {
        $this->setExpectedException('Aura\SqlMapper_Bundle\Exception\NoSuchMapper');
        $mapper = $this->mappers->get('no-such-mapper');
    }

    public function test_iterator()
    {
        $expect = ['post', 'comment', 'author'];
        foreach ($this->mappers as $mapper) {
            $actual[] = $mapper->type;
        }
        $this->assertSame($expect, $actual);
    }
}
