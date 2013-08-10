<?php
namespace app\extensions\action;
use app\models\Points;

class Pivot_Count extends \lithium\action\Controller {
    private $_key = null;
    function __construct($key)
    {
        $this->_key = $key;
    }
   
    public function getKey()
    {
        return $this->_key;
    }
}
?>