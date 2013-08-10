<?php
namespace app\extensions\action;
use app\models\Points;

class Pivot_Callback extends \lithium\action\Controller {

    private $_cbk = null;
    private $_key = null;
    function __construct($key, $cbk)
    {
        $this->_cbk = $cbk;
        $this->_key = $key;
    }
   
    public function getKey()
    {
        return $this->_key;
    }

    public function cbk()
    {
        return call_user_func_array($this->_cbk, func_get_args());
    }
}
?>