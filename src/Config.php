<?php

namespace Tres\config {
    
    class Config {
        
        /**
         * Key-value pair config lines using the dot notation.
         * 
         * @var array
         */
        protected $_config = [];
        
        /**
         * @var array
         */
        protected $_extensionsToLookFor = [
            'php',
        ];
        
        const DELIMITER = '.';
        
        /**
         * @param string $key
         * @param mixed  $value
         */
        public function add($key, $value) {
            $this->_config[$key] = $value;
        }
        
        /**
         * @param array $config
         */
        public function addFromArray(array $config) {
            $config = $this->_arrayToDotNotation($config);
            $this->_config = array_merge($this->_config, $config);
        }
        
        /**
         * @param  array  $array
         * @return string
         */
        private function _arrayToDotNotation(array $array) {
            $arrayToDotNotation = new ArrayToDotNotation($array);
            return $arrayToDotNotation->get();
        }
        
        /**
         * @param string $file
         * @param string $prefix
         */
        public function addFromFile($file, $prefix) {
            $config = (array) include($file);
            $this->addFromArray([$prefix => $config]);
        }
        
        /**
         * @param string $directory
         */
        public function addFromDirectory($directory) {
            $files = scandir($directory);
            
            foreach($files as $file) {
                $fullFilePath = $directory.'/'.$file;
                $filename = pathinfo($file, PATHINFO_FILENAME);
                $extension = pathinfo($file, PATHINFO_EXTENSION);
                
                if(!is_file($fullFilePath)) {
                    continue;
                }
                
                if(!in_array($extension, $this->_extensionsToLookFor)) {
                    continue;
                }
                
                $this->addFromFile($fullFilePath, $filename);
            }
        }
        
        /**
         * @param  string $configKey Returns every config when empty.
         * @return mixed
         */
        public function get($configKey = null) {
            if(empty($configKey)) {
                $result = $this->_getMultidimensionalArray($this->_config);
            } else if($this->_hasExactKey($configKey)) {
                $result = $this->_config[$configKey];
            } else {
                $dotNotatedConfigs = $this->_findAllWherePartialKeyMatches($configKey);
                $result = $this->_getMultidimensionalArray($dotNotatedConfigs);
            }
            
            return $result;
        }
        
        /**
         * @return array
         */
        private function _getMultidimensionalArray($dotNotatedConfigs) {
            $fullConfigArray = [];
            
            foreach($dotNotatedConfigs as $configKey => $configValue) {
                $dotNotationToArray = new DotNotationToArray($configKey, $configValue);
                $fullConfigArray = array_merge_recursive($fullConfigArray, $dotNotationToArray->get());
            }
            
            return $fullConfigArray;
        }
        
        /**
         * @param  string $configKey
         * @return bool
         */
        private function _hasExactKey($configKey) {
            return (isset($this->_config[$configKey]));
        }
        
        /**
         * @param  string $partialConfigKey
         * @return array
         */
        private function _findAllWherePartialKeyMatches($partialConfigKey) {
            $configs = [];
            
            foreach($this->_config as $registeredConfigKey => $registeredConfigValue) {
                if(strstr($registeredConfigKey, $partialConfigKey)) {
                    $remainingPartOfKeyLength = strlen($partialConfigKey.self::DELIMITER);
                    $remainingPartOfKey = substr($registeredConfigKey, $remainingPartOfKeyLength);
                    $configs[$remainingPartOfKey] = $registeredConfigValue;
                }
            }
            
            return $configs;
        }
        
        public function addExtensionToLookFor($extension) {
            $this->_extensionsToLookFor[] = ltrim($extension, '.');
        }
        
    }
    
}
