<?php

namespace Tres\config {
    
    class DotNotationToArray {
        
        /**
         * @var array
         */
        private $_result;
        
        const DELMITER = '.';
        
        /**
         * @param string $key
         * @param mixed  $value
         */
        public function __construct($key, $value) {
            $this->_convertToMultidimensionalArray($key, $value);
        }
        
        /**
         * @param  string $key
         * @param  mixed  $value
         * @return array
         */
        private function _convertToMultidimensionalArray($key, $value) {
            $this->_result = $value;
            
            $keys = explode(self::DELMITER, $key);
            
            foreach(array_reverse($keys) as $key) {
                $this->_result = [$key => $this->_result];
            }
        }
        
        /**
         * @return array
         */
        public function get() {
            return $this->_result;
        }
        
    }
    
}
