<?php
namespace dsweb\mysqlidalimp;

use dsweb\dal\Row;

class MySqliRow implements Row
{

    private $row;

    public function __construct($row)
    {
        $this->row = $row;
    }

    public function get($key)
    {
        return $this->row[$key];
    }

    public function getAsMap()
    {
        $t = array();
        foreach ($this->row as $key => $value) {
            $t[$key] = $value;
        }
        return $t;
    }
}

?>