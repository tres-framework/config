<?php

use Tres\config\DotNotationToArray;

class DotNotationToArrayTest extends PHPUnit_Framework_TestCase {
    
    public function testKeyValuePairOneDeep() {
        $dotNotationToArray = new DotNotationToArray('key123', 'value123');
        $actualValue = $dotNotationToArray->get();
        
        $expectedValue = [
            'key123' => 'value123',
        ];
        $this->assertSame($expectedValue, $actualValue);
    }
    
    public function testKeyValuePairTwoDeep() {
        $dotNotationToArray = new DotNotationToArray('key.sub_key', 'value123');
        $actualValue = $dotNotationToArray->get();
        
        $expectedValue = [
            'key' => [
                'sub_key' => 'value123',
            ],
        ];
        $this->assertSame($expectedValue, $actualValue);
    }
    
    public function testKeyValuePairThreeDeep() {
        $dotNotationToArray = new DotNotationToArray('key.sub_key.sub_sub_key', 'value123');
        $actualValue = $dotNotationToArray->get();
        
        $expectedValue = [
            'key' => [
                'sub_key' => [
                    'sub_sub_key' => 'value123',
                ],
            ],
        ];
        $this->assertSame($expectedValue, $actualValue);
    }
    
}
