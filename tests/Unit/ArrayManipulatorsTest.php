<?php

namespace JuanchoSL\DataManipulation\Tests\Unit;

use JuanchoSL\DataManipulation\Manipulators\Arrays\ArrayManipulators;
use PHPUnit\Framework\TestCase;

class ArrayManipulatorsTest extends TestCase
{
    public function testSlice()
    {
        $data = [1, 2, 3, 4, 5, 6, 7, 8, 9, 0];

        $tool = new ArrayManipulators();
        $tool->slice(5);
        $this->assertCount(5, $tool($data));
    }
    public function testChunk()
    {
        $data = [1, 2, 3, 4, 5, 6, 7, 8, 9, 0];

        $tool = new ArrayManipulators();
        $tool->chunk(5);
        $this->assertCount(2, $tool($data));

    }

    public function testCombine()
    {
        $this->markTestSkipped();
        $keys = ['name', 'surname'];
        $data = ['pepe', 'santos'];
        //$data = [['pepe', 'santos'], ['manuel', 'dominguez'], ['ana', 'caballero']];

        $tool = new ArrayManipulators();
        $tool->combine($keys);
        $results = $tool($data);
        //echo "<pre>" . print_r($results, true);exit;

        foreach ($results as $result) {
            foreach ($keys as $key) {
                $this->assertArrayHasKey($key, $result);
            }
        }
    }

    public function testCountValuesRepetitions()
    {
        $data = ['pepe', 'santos', 'manuel', 'dominguez', 'ana', 'caballero'];

        $tool = new ArrayManipulators();
        $tool->countValuesRepetitions();
        $results = $tool($data);

        $this->assertCount(count($data), $results);
        foreach ($data as $key) {
            $this->assertArrayHasKey($key, $results);
            $this->assertIsInt($results[$key]);
            $this->assertEquals(1, $results[$key]);
        }
    }

    public function testMerge()
    {
        $data = [['name', 'surname'], ['name', 'surname'], ['name', 'surname'], ['name', 'surname']];

        $tool = new ArrayManipulators();
        $tool->merge();
        $results = $tool(...$data);
        $this->assertCount(8, $results);
    }

    public function testMergeAndUnique()
    {
        $data = [['name', 'surname'], ['name', 'surname'], ['name', 'surname'], ['name', 'surname']];

        $tool = new ArrayManipulators();
        $tool->merge()->unique();
        $results = $tool(...$data);
        $this->assertCount(2, $results);
    }
    /*    
    public function testFillByKey()
    {
        $data = [['name', 'surname']];

        $tool = new ArrayMapManipulators();
        $tool->fill('');
        $results = $tool(...$data);

        foreach ($results as $result) {
            foreach (['name', 'surname'] as $key) {
                $this->assertArrayHasKey($key, $result);
            }
        }

    }
    public function testFilter()
    {
        $data = [['pepe' => 'name', 'santos' => 'surname'], ['manuel' => 'name', 'dominguez' => 'surname'], ['ana' => 'name', 'caballero' => 'surname']];

        $tool = new ArrayManipulators();
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
        $this->markTestSkipped();
        $data = [['pepe' => 'name', 'santos' => 'surname'], ['manuel' => 'name', 'dominguez' => 'surname'], ['ana' => 'name', 'caballero' => 'surname']];

        $tool = new ArrayManipulators();
        $tool->flip();
        $results = $tool(...$data);

        //echo "<pre>" . print_r($results, true);exit;

        foreach ($results as $result) {
            foreach (['name', 'surname'] as $key) {
                $this->assertArrayHasKey($key, $result);
            }
        }
    }
    public function testColumn()
    {
        $data = [['name' => 'pepe', 'surname' => 'santos'], ['name' => 'manuel', 'surname' => 'dominguez'], ['name' => 'ana', 'surname' => 'caballero']];

        $tool = new ArrayManipulators();
        $tool->column('surname', 'name');
        $results = $tool($data);

        foreach ($results as $result) {
            $this->assertIsNotArray($result);
        }
    }
    public function testKeyCase()
    {
        $data = ['name' => 'pepe', 'surname' => 'santos'];

        $tool = new ArrayManipulators();
        $tool->keyToCase(CASE_UPPER);
        $results = $tool($data);
        $this->assertArrayHasKey('NAME', $results);
        $this->assertArrayNotHasKey('name', $results);
    }
    public function testUnique()
    {

        $data = ['pepe', 'santos', 'pepe', 'dominguez', 'ana', 'caballero'];

        $tool = new ArrayManipulators();
        $tool->unique();
        $results = $tool($data);
        $this->assertLessThan(count($data), count($results));
    }

    public function testSum()
    {
        $data = [1, 2, 3, 4];

        $tool = new ArrayManipulators();
        $tool->sum();
        $results = $tool($data);
        $this->assertEquals(10, $results);
    }

    public function testProd()
    {
        $data = [1, 2, 3, 4];

        $tool = new ArrayManipulators();
        $tool->product();
        $results = $tool($data);
        $this->assertEquals(24, $results);
    }

}