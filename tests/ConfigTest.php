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
    
    public function testGetByFullKey() {
        $config = new Config();
        
        $config->addFromArray([
            'cookie.lifetime_in_hours' => 48,
            'database' => [
                'mysql.host' => '127.0.0.1',
                'mysql.user' => 'bob',
            ],
            'deeply.nested.array.with.zero' => 0,
            'deeply.nested.array.with.a.null' => null,
            'deeply.nested.array.with.a.false' => false,
        ]);
        
        $actualValue = $config->get('cookie.lifetime_in_hours');
        $expectedValue = 48;
        
        $this->assertSame($expectedValue, $actualValue);
    }
    
    public function testGetByFullKeyFromArray() {
        $config = new Config();
        
        $config->addFromArray([
            'cookie.lifetime_in_hours' => 48,
            'database' => [
                'mysql.host' => '127.0.0.1',
                'mysql.user' => 'bob',
            ],
            'deeply.nested.array.with.zero' => 0,
            'deeply.nested.array.with.a.null' => null,
            'deeply.nested.array.with.a.false' => false,
        ]);
        
        $actualValue = $config->get('database.mysql');
        $expectedValue = [
            'host' => '127.0.0.1',
            'user' => 'bob',
        ];
        
        $this->assertSame($expectedValue, $actualValue);
    }
    
    public function testGetByPartialKeyFromArray() {
        $config = new Config();
        
        $config->addFromArray([
            'cookie.lifetime_in_hours' => 48,
            'database' => [
                'mysql.host' => '127.0.0.1',
                'mysql.user' => 'bob',
            ],
            'deeply.nested.array.with.zero' => 0,
            'deeply.nested.array.with.a.null' => null,
            'deeply.nested.array.with.a.false' => false,
        ]);
        
        $actualValue = $config->get('deeply.nested.array');
        $expectedValue = [
            'with' => [
                'zero' => 0,
                'a' => [
                    'null' => null,
                    'false' => false,
                ],
            ],
        ];
        
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
