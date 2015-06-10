<?php

namespace Tres\config {
    
    use RecursiveArrayIterator;
    use RecursiveIteratorIterator;
    
    class ArrayToDotNotation {
        
        /**
         * @var \RecursiveIteratorIterator
         */
        private $_iterator;
        
        /**
         * @var array
         */
        private $_result = [];
        
        const DELIMITER = '.';
        
        /**
         * @param array $arrayToConvert
         */
        public function __construct(array $arrayToConvert){
            $this->_iterator = new RecursiveIteratorIterator(
                new RecursiveArrayIterator($arrayToConvert)
            );
            
            $this->_convertToDotNotation();
        }
        
        private function _convertToDotNotation() {
            foreach($this->_iterator as $leafValue) {
                $keys = [];
                
                foreach(range(0, $this->_iterator->getDepth()) as $depth) {
                    $keys[] = $this->_iterator->getSubIterator($depth)->key();
                }
                
                $key = join(self::DELIMITER, $keys);
                $this->_result[$key] = $leafValue;
            }
        }
        
        public function get() {
            return $this->_result;
        }
        
    }
    
}
