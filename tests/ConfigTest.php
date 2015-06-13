<?php

use Tres\config\Config;

class ConfigTest extends PHPUnit_Framework_TestCase {
    
    private $_config1ValueFromFile = [
        'abc' => 'def',
        'ghi' => 123,
    ];
    
    private $_config2ValueFromFile = [
        'uvw' => 'xyz',
        'abc' => [
            'true' => true,
            'false' => false,
            'string' => [
                'true' => true,
                'klmnop' => 'q',
            ],
        ],
    ];
    
    // This must be a property, because PHP does not have constant expression 
    // support up to version 5.6.0.
    private $_configDir;
    
    protected function setUp() {
        $this->_configDir = __DIR__.'/inc/config';
    }
    
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
    
    public function testAddFromFile() {
        $config = new Config();
        $config->addFromFile($this->_configDir.'/config1.php', 'prefix123');
        
        $actualValue = $config->get();
        $expectedValue = ['prefix123' => $this->_config1ValueFromFile];
        
        $this->assertSame($expectedValue, $actualValue);
    }
    
    public function testAddFromDirectoryConfig1() {
        $config = new Config();
        $config->addFromDirectory($this->_configDir);
        
        $expectedValue = $this->_config1ValueFromFile;
        $actualValue = $config->get('config1');
        
        $this->assertSame($expectedValue, $actualValue);
    }
    
    public function testAddFromDirectoryConfig2() {
        $config = new Config();
        $config->addFromDirectory($this->_configDir);
        
        $expectedValue = $this->_config2ValueFromFile;
        $actualValue = $config->get('config2');
        
        $this->assertSame($expectedValue, $actualValue);
    }
    
    public function testAddFromDirectoryConfig1AndConfig2() {
        $config = new Config();
        $config->addFromDirectory($this->_configDir);
        
        $config1 = ['config1' => $this->_config1ValueFromFile];
        $config2 = ['config2' => $this->_config2ValueFromFile];
        
        $expectedValue = array_merge($config1, $config2);
        $actualValue = $config->get();
        
        $this->assertSame($expectedValue, $actualValue);
    }
    
}
