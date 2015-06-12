<?php

use Tres\config\Config;

class ConfigTest extends PHPUnit_Framework_TestCase {
    
    private $_config1ValueFromFile = [
        'abc' => 'def',
        'ghi' => 123,
        'jk' => [
            'lmnop',
            14 => 'qrst',
        ],
    ];
    
    private $_config2ValueFromFile = [
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
    
    const CONFIG_DIR = '../inc/config';
    
    public function testGet() {
        $config = new Config();
        
        $value = [
            'abc.def' => 17,
            'efg',
            'hij' => [
                'klm',
                'nop' => 'qrst',
            ],
            'hij.nop.deeply.nested.array.with.null' => null,
            'hij.nop.deeply.nested.array.with.false' => false,
        ];
        $config->addFromArray($value);
        
        $expectedValue = $value['abc.def'];
        
        $actualValue = $config->get('abc.def');
        $this->assertSame($expectedValue, $actualValue);
        
        $actualValue = $config->get('abc')['def'];
        $this->assertSame($expectedValue, $actualValue);
        
        $actualValue = $config->get()['abc']['def'];
        $this->assertSame($expectedValue, $actualValue);
        
        $expectedValue = $value[0];
        $actualValue = $config->get(0);
        $this->assertSame($expectedValue, $actualValue);
        
        $expectedValue = $value['hij.0'];
        $actualValue = $config->get('hij.0');
        $this->assertSame($expectedValue, $actualValue);
        
        $expectedValue = $value['hij.nop'];
        $actualValue = $config->get('hij.nop');
        $this->assertSame($expectedValue, $actualValue);
        
        $expectedValue = [
            'array' => [
                'with' => [
                    'null' => null,
                    'false' => false,
                ],
            ],
        ];
        $actualValue = $config->get('hij.nop.deeply.nested');
        $this->assertSame($expectedValue, $actualValue);
    }
    
    public function testAdd() {
        $config = new Config();
        $config->add('key123', 'value123');
        
        $expectedValue = 'value123';
        $actualValue = $config->get('key123');
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
        
        $expectedValue = ['def' => 17];
        $actualValue = $config->get('abc');
        $this->assertSame($expectedValue, $actualValue);
    }
    
    public function testAddFromFile() {
        $config = new Config();
        
        $expectedValue = ['prefix123' => $this->_config1ValueFromFile];
        
        $config->addFromFile(self::CONFIG_DIR.'/config1.php', 'prefix123');
        
        $actualValue = $config->get('prefix123');
        $this->assertSame($expectedValue, $actualValue);
    }
    
    public function testAddFromDirectoryConfig1() {
        $config = new Config();
        $config->addFromDirectory(self::CONFIG_DIR);
        
        $expectedValue = $this->_config1ValueFromFile;
        $actualValue = $config->get('config1');
        
        $this->assertSame($expectedValue, $actualValue);
    }
    
    public function testAddFromDirectoryConfig2() {
        $config = new Config();
        $config->addFromDirectory(self::CONFIG_DIR);
        
        $expectedValue = $this->_config2ValueFromFile;
        $actualValue = $config->get('config2');
        
        $this->assertSame($expectedValue, $actualValue);
    }
    
    public function testAddFromDirectoryConfig1AndConfig2() {
        $config = new Config();
        $config->addFromDirectory(self::CONFIG_DIR);
        
        $expectedValue = array_merge($this->_config1ValueFromFile, $this->_config2ValueFromFile);
        $actualValue = $config->get();
        
        $this->assertSame($expectedValue, $actualValue);
    }
    
}
