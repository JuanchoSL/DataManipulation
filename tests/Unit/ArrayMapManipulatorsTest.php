<?php

namespace JuanchoSL\DataManipulation\Tests\Unit;


use JuanchoSL\DataManipulation\Manipulators\Arrays\ArrayMapManipulators;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertLessThan;

class ArrayMapManipulatorsTest extends TestCase
{


    /*
    public function testCombineSingle()
    {
        $keys = ['name', 'surname'];
        $data = [['pepe', 'santos']];

        $tool = new ArrayMapManipulators();
        $tool->combine($keys);
        $results = $tool(...$data);

        foreach ($results as $result) {
            foreach ($keys as $key) {
                $this->assertArrayHasKey($key, $result);
            }
        }
    }
    */
    public function testCombine()
    {
        $keys = ['name', 'surname'];
        $data = [['pepe', 'santos'], ['manuel', 'dominguez'], ['ana', 'caballero']];

        $tool = new ArrayMapManipulators();
        $tool->combine($keys);
        $results = $tool(...$data);

        foreach ($results as $result) {
            foreach ($keys as $key) {
                $this->assertArrayHasKey($key, $result);
            }
        }
    }
    /*
        public function testFilter()
        {
            $data = [['pepe' => 'name', 'santos' => 'surname'], ['manuel' => 'name', 'dominguez' => 'surname'], ['ana' => 'name', 'caballero' => 'surname']];

            $tool = new ArrayMapManipulators();
            $tool->flip();
            $results = $tool(...$data);

            foreach ($results as $result) {
                foreach (['name', 'surname'] as $key) {
                    $this->assertArrayHasKey($key, $result);
                }
            }
        }
    */
    public function testFlip()
    {
        $data = [['pepe' => 'name', 'santos' => 'surname'], ['manuel' => 'name', 'dominguez' => 'surname'], ['ana' => 'name', 'caballero' => 'surname']];

        $tool = new ArrayMapManipulators();
        $tool->flip();
        $results = $tool(...$data);

        foreach ($results as $result) {
            foreach (['name', 'surname'] as $key) {
                $this->assertArrayHasKey($key, $result);
            }
        }
    }


}