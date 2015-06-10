<?php

use Tres\config\ArrayToDotNotation;

class ArrayToDotNotationTest extends PHPUnit_Framework_TestCase {
    
    public function testGet() {
        $array = [
            'key_1' => 'key_1_val',
            'key_2' => [
                'sub_key' => 'sub_key_2_val',
            ],
            'key_3' => 'val_3',
            'key_4' => [
                'sub_key_4_1' => [
                    'sub_sub_key_4_1_1' => 'sub_sub_key_val_4',
                    'sub_sub_key_4_1_2' => 'sub_sub_key_val_5',
                ],
                'sub_key_4_2' => 'sub_key_4_2_val_1',
            ],
            'key_5.sub_key_5.sub_sub_key_5_1' => 'sub_sub_key_5_1_val',
            'key_5.sub_key_5' => [
                'sub_sub_key_5_1' => 'sub_sub_key_5_1_val_x',
            ],
        ];
        
        $expectedValue = [
            'key_1'                                 => 'key_1_val',
            'key_2.sub_key'                         => 'sub_key_2_val',
            'key_3'                                 => 'val_3',
            'key_4.sub_key_4_1.sub_sub_key_4_1_1'   => 'sub_sub_key_val_4',
            'key_4.sub_key_4_1.sub_sub_key_4_1_2'   => 'sub_sub_key_val_5',
            'key_4.sub_key_4_2'                     => 'sub_key_4_2_val_1',
            'key_5.sub_key_5.sub_sub_key_5_1'       => 'sub_sub_key_5_1_val',
            'key_5.sub_key_5.sub_sub_key_5_1'       => 'sub_sub_key_5_1_val_x',
        ];
        
        $arrayToDotNotation = new ArrayToDotNotation($array);
        $actualValue = $arrayToDotNotation->get();
        $this->assertSame($expectedValue, $actualValue);
    }
    
}
