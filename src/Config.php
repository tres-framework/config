<?php

namespace Tres\config {
    
    class Config {
        
        /**
         * @var array
         */
        protected $_config = [];
        
        /**
         * @var string
         */
        protected $_prefixDelimiter = '.';
        
        /**
         * @param string|int       $key
         * @param string|int|array $value
         * @param string           $prefix
         */
        public function add($key, $value, $prefix = null) {
            //
        }
        
        /**
         * @param array  $configArray
         * @param string $prefix
         */
        public function addFromArray($configArray, $prefix = null) {
            //
        }
        
        /**
         * @param string $file
         * @param string $prefix
         */
        public function addFromFile($file, $prefix = null) {
            //
        }
        
        
        /**
         * @param string $prefixDelimiter
         */
        public function setPrefixDelimiter($prefixDelimiter) {
            //
        }
        
        /**
         * @return string
         */
        public function getPrefixDelimiter() {
            return $this->_prefixDelimiter;
        }
        
        /**
         * @param string $directory
         * @param bool   $autoPrefix
         */
        public function addFromDirectory($directory, $autoPrefix = true) {
            //
        }
        
        /**
         * @param  string           $config Returns every config if empty.
         * @param  string           $prefix
         * @return string|int|array
         */
        public function get($config = null, $prefix = null) {
            //
        }
        
    }
    
}
