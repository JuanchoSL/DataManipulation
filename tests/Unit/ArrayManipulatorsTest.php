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

        $results = $tool($data, $data);
        foreach ($results as $result) {
            $this->assertCount(5, $result);
        }

        $results = $tool(...[$data, $data]);
        foreach ($results as $result) {
            $this->assertCount(5, $result);
        }
    }
    public function testChunk()
    {
        $data = [1, 2, 3, 4, 5, 6, 7, 8, 9, 0];

        $tool = new ArrayManipulators();
        $tool->chunk(5);
        $this->assertCount(2, $tool($data));

        $results = $tool($data, $data);
        foreach ($results as $result) {
            $this->assertCount(2, $result);
        }

        $results = $tool(...[$data, $data]);
        foreach ($results as $result) {
            $this->assertCount(2, $result);
        }

    }

    public function testCombine()
    {
        $keys = ['name', 'surname'];

        $tool = new ArrayManipulators();
        $tool->combine($keys);

        $data = ['pepe', 'santos'];
        $result = $tool($data);
        foreach ($keys as $key) {
            $this->assertArrayHasKey($key, $result);
        }

        $results = $tool($data, $data);
        foreach ($results as $result) {
            foreach ($keys as $key) {
                $this->assertArrayHasKey($key, $result);
            }
        }

        $data = [['pepe', 'santos'], ['manuel', 'dominguez'], ['ana', 'caballero']];

        $results = $tool(...$data);
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

        $results = $tool($data, $data);
        foreach ($results as $result) {
            $this->assertCount(count($data), $result);
            foreach ($data as $key) {
                $this->assertArrayHasKey($key, $result);
                $this->assertIsInt($result[$key]);
                $this->assertEquals(1, $result[$key]);
            }
        }

        $results = $tool(...[$data, $data]);
        foreach ($results as $result) {
            $this->assertCount(count($data), $result);
            foreach ($data as $key) {
                $this->assertArrayHasKey($key, $result);
                $this->assertIsInt($result[$key]);
                $this->assertEquals(1, $result[$key]);
            }
        }
    }

    public function testMerge()
    {
        $data = [['name', 'surname'], ['name', 'surname'], ['name', 'surname'], ['name', 'surname']];

        $tool = new ArrayManipulators();
        $tool->merge();
        $results = $tool($data);
        $this->assertCount(8, $results);

        $results = $tool($data, $data);
        foreach ($results as $result) {
            $this->assertCount(8, $result);
        }

        $results = $tool(...[$data, $data]);
        foreach ($results as $result) {
            $this->assertCount(8, $result);
        }
    }

    public function testMergeAndUnique()
    {
        $data = [['name', 'surname'], ['name', 'surname'], ['name', 'surname'], ['name', 'surname']];

        $tool = new ArrayManipulators();
        $tool->merge()->unique();
        $results = $tool($data);
        $this->assertCount(2, $results);

        $results = $tool($data, $data);
        foreach ($results as $result) {
            $this->assertCount(2, $result);
        }

        $results = $tool(...[$data, $data]);
        foreach ($results as $result) {
            $this->assertCount(2, $result);
        }
    }
/*
    public function testFillByKey()
    {
        $this->markTestSkipped();
        $data = [['name', 'surname', 'value']];
        $tool = new ArrayManipulators();
        $tool->fillKeys('filled');
        $results = $tool(...$data);

        foreach ($results as $result) {
            foreach (['name' => 'filled', 'surname' => 'filled', 'value' => ''] as $key => $value) {
                $this->assertArrayHasKey($key, $result);
                $this->assertEquals($value, $result[$key]);
            }
        }
    }
*/

    public function testFilter()
    {
        $datas = [];
        $datas[] = [''];
        $datas[] = ['', '1'];
        $datas[] = ['', '1', '2'];
        $tool = new ArrayManipulators();
        $tool->filter();
        $results = $tool(...$datas);

        foreach ($results as $i => $result) {
            $this->assertCount($i, $result);
        }

        $results = $tool($datas[2]);
        $this->assertCount(count($datas[2]) - 1, $results);
    }

    public function testFilterWithCallback()
    {
        $datas = [];
        $datas[] = [''];
        $datas[] = ['', '1'];
        $datas[] = ['', '1', '1'];
        $tool = new ArrayManipulators();
        $tool->filter(function ($var) {
            return $var == 1;
        });
        $results = $tool(...$datas);

        foreach ($results as $i => $result) {
            $this->assertCount($i, $result);
        }

        $results = $tool($datas[2]);
        $this->assertCount(count($datas[2]) - 1, $results);
    }

    public function testFlip()
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

        $results = $tool($data[0], $data[1]);
        foreach ($results as $result) {
            foreach (['name', 'surname'] as $key) {
                $this->assertArrayHasKey($key, $result);
            }
        }
        $results = $tool(current($data));
        foreach (['name', 'surname'] as $key) {
            $this->assertArrayHasKey($key, $result);
        }

    }
    public function testColumn()
    {
        $data = [['name' => 'pepe', 'surname' => 'santos'], ['name' => 'manuel', 'surname' => 'dominguez'], ['name' => 'ana', 'surname' => 'caballero']];

        $tool = new ArrayManipulators();
        $tool->column('surname', 'name');

        $results = $tool($data);
        $i = 0;
        foreach ($results as $key => $result) {
            $this->assertIsNotNumeric($key);
            $this->assertIsNotArray($result);
            $this->assertEquals($data[$i]['name'], $key);
            $this->assertEquals($data[$i]['surname'], $result);
            $i++;
        }

        $tool->column('surname');
        $results = $tool($data);
        $i = 0;
        foreach ($results as $key => $result) {
            $this->assertIsNumeric($key);
            $this->assertIsNotArray($result);
            $this->assertEquals($i, $key);
            $this->assertEquals($data[$i]['surname'], $result);
            $i++;
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

        $results = $tool($data, $data);
        foreach ($results as $result) {
            $this->assertArrayHasKey('NAME', $result);
            $this->assertArrayNotHasKey('name', $result);
        }

        $results = $tool(...[$data, $data]);
        foreach ($results as $result) {
            $this->assertArrayHasKey('NAME', $result);
            $this->assertArrayNotHasKey('name', $result);
        }
    }
    public function testUnique()
    {

        $data = ['pepe', 'santos', 'pepe', 'dominguez', 'ana', 'caballero'];

        $tool = new ArrayManipulators();
        $tool->unique();
        $results = $tool($data);
        $this->assertLessThan(count($data), count($results));

        $results = $tool($data, $data);
        foreach ($results as $result) {
            $this->assertLessThan(count($data), count($result));
        }

        $results = $tool(...[$data, $data]);
        foreach ($results as $result) {
            $this->assertLessThan(count($data), count($result));
        }
    }

    public function testSum()
    {
        $data = [1, 2, 3, 4];

        $tool = new ArrayManipulators();
        $tool->sum();
        $results = $tool($data);
        $this->assertEquals(10, $results);

        $results = $tool($data, $data);
        foreach ($results as $result) {
            $this->assertEquals(10, $result);
        }

        $results = $tool(...[$data, $data]);
        foreach ($results as $result) {
            $this->assertEquals(10, $result);
        }
    }

    public function testProd()
    {
        $data = [1, 2, 3, 4];

        $tool = new ArrayManipulators();
        $tool->product();
        $results = $tool($data);
        $this->assertEquals(24, $results);

        $results = $tool($data, $data);
        foreach ($results as $result) {
            $this->assertEquals(24, $result);
        }

        $results = $tool(...[$data, $data]);
        foreach ($results as $result) {
            $this->assertEquals(24, $result);
        }
    }
    public function testGetMin()
    {
        $calc = new ArrayManipulators();
        $calc = $calc->min();
        $this->assertEquals(1.55, $calc([1.55, 2]));

        $calc = new ArrayManipulators();
        $calc = $calc->min();
        $this->assertEquals(1, $calc([1.55, 2, 1, 5, 1.56]));
    }

    public function testGetMax()
    {
        $calc = new ArrayManipulators();
        $calc = $calc->max();
        $this->assertEquals(2, $calc([1.55, 2]));

        $calc = new ArrayManipulators();
        $calc = $calc->max();
        $this->assertEquals(5, $calc([1.55, 2, 1, 5, 1.56]));
    }

    public function testMap()
    {
        $calc = new ArrayManipulators();
        $calc = $calc->map(function ($var) {
            return $var + 1;
        });
        $results = $calc([0, 1, 2, 3, 4]);
        //echo print_r($results,true);exit;
        foreach ($results as $index => $result) {
            $this->assertEquals($index + 1, $result);
        }
    }

}