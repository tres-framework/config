<?php

use Tres\config\Config;

class ConfigTest extends PHPUnit_Framework_TestCase {
    
    const CONFIG_DIR = '../inc/config';
    
    public function testAdd() {
        $config = new Config();
        
        $key = 'key';
        $value = 'value123';
        
        $config->add($key, $value);
        
        $expectedValue = $value;
        $actualValue = $config->get($key);
        
        $this->assertSame($expectedValue, $actualValue);
    }
    
    public function testAddWithPrefix() {
        $config = new Config();
        
        $prefix = 'prefix-';
        $key = 'key';
        $value = 'value123';
        
        $config->add($key, $value, $prefix);
        
        $expectedValue = $value;
        
        $actualValue = $config->get($key, $prefix);
        $this->assertSame($expectedValue, $actualValue);
        
        $actualValue = $config->get($prefix.$key);
        $this->assertSame($expectedValue, $actualValue);
    }
    
    public function testAddFromArray() {
        $config = new Config();
        
        $value = [
            'abc.def' => 17,
            'efg',
            'hij' => [
                'klm',
                'nop' => 'qrst',
            ],
        ];
        
        $config->addFromArray($value);
        
        $expectedValue = $value;
        $actualValue = $config->get();
        $this->assertSame($expectedValue, $actualValue);
    }
    
    public function testAddFromArrayWithPrefix() {
        $config = new Config();
        
        $prefix = 'prefix.';
        $value = [
            'abc.def' => 17,
            'efg',
            'hij' => [
                'klm',
                'nop' => 'qrst',
            ],
        ];
        $config->addFromArray($value, $prefix);
        
        $expectedValue = $value;
        
        $actualValue = $config->get(null, $prefix);
        $this->assertSame($expectedValue, $actualValue);
        
        $actualValue = $config->get($prefix);
        $this->assertSame($expectedValue, $actualValue);
        
        $actualValue = $config->get();
        $this->assertSame($expectedValue, [$actualValue]);
    }
    
    public function testAddFromFile() {
        $config = new Config();
        
        $expectedValue = [
            'abc' => 'def',
            'ghi' => 123,
            'jk' => [
                'lmnop',
                14 => 'qrst',
            ],
        ];
        
        $config->addFromFile(self::CONFIG_DIR.'/config1.php');
        
        $actualValue = $config->get();
        $this->assertSame($expectedValue, $actualValue);
    }
    
    public function testAddFromFileWithPrefix() {
        $config = new Config();
        $prefix = 'prefix_';
        
        $expectedValue = [
            'abc' => 'def',
            'ghi' => 123,
            'jk' => [
                'lmnop',
                14 => 'qrst',
            ],
        ];
        
        $config->addFromFile(self::CONFIG_DIR.'/config1.php', $prefix);
        
        $actualValue = $config->get(null, $prefix);
        $this->assertSame($expectedValue, $actualValue);
        
        $actualValue = $config->get($prefix);
        $this->assertSame($expectedValue, $actualValue);
        
        $actualValue = $config->get();
        $this->assertSame($expectedValue, [$actualValue]);
    }
    
    public function testAddFromDirectory() {
        $config = new Config();
        
        $expectedValue1 = [
            'abc' => 'def',
            'ghi' => 123,
            'jk' => [
                'lmnop',
                14 => 'qrst',
            ],
        ];
        
        $config->addFromDirectory(self::CONFIG_DIR);
        
        $actualValue = $config->get(null, 'config1');
        $this->assertSame($expectedValue1, $actualValue);
        
        $actualValue = $config->get('config1');
        $this->assertSame($expectedValue1, $actualValue);
        
        $expectedValue2 = [
            'uvw' => 'xyz',
            0 => null,
            null,
            10,
            'abc.true' => true,
            'abc.false' => false,
            'abc.string.true' => true,
            'abc.string' => [
                'def',
                'ghi',
                'klmnop' => 'q',
            ],
        ];
        
        $actualValue = $config->get(null, 'config2');
        $this->assertSame($expectedValue2, $actualValue);
        
        $expectedValue = array_merge($expectedValue1, $expectedValue2);
        $actualValue = $config->get(null);
        $this->assertSame($expectedValue, $actualValue);
    }
    
    public function testPrefixDelimiter() {
        $config = new Config();
        
        $prefixDelimiter = '-';
        $config->setPrefixDelimiter($prefixDelimiter);
        
        $expectedPrefixDelimiter = $prefixDelimiter;
        $actualPrefixDelimiter = $config->getPrefixDelimiter();
        $this->assertSame($expectedPrefixDelimiter, $actualPrefixDelimiter);
    }
    
    public function testInvalidPrefixDelimiterDataType() {
        $config = new Config();
        $config->setPrefixDelimiter(['abc']);
        $config->setPrefixDelimiter(123);
        
        $this->setExpectedException('Tres\config\ConfigException');
    }
    
    public function testAddFromDirectoryWithPrefix() {
        $config = new Config();
        
        $expectedValue = [
            'abc' => 'def',
            'ghi' => 123,
            'jk' => [
                'lmnop',
                14 => 'qrst',
            ],
            'uvw' => 'xyz',
            0 => null,
            null,
            10,
            'abc.true' => true,
            'abc.false' => false,
            'abc.string.true' => true,
            'abc.string' => [
                'def',
                'ghi',
                'klmnop' => 'q',
            ],
        ];
        
        $config->addFromDirectory(self::CONFIG_DIR, true);
        
        $actualValue = $config->get();
        $this->assertSame($expectedValue, $actualValue);
    }
    
    public function testGet() {
        $config = new Config();
        
        $value = [
            'abc.def' => 17,
            'efg',
            'hij' => [
                'klm',
                'nop' => 'qrst',
            ],
        ];
        
        $expectedValue = $value['abc.def'];
        
        $actualValue = $config->get()['abc.def'];
        $this->assertSame($expectedValue, $actualValue);
        
        $actualValue = $config->get('abc.def');
        $this->assertSame($expectedValue, $actualValue);
    }
    
}
