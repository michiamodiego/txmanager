<?php
namespace dsweb\mysqlidalimp;

use Exception;
use RuntimeException;
use dsweb\dal\ResultSet;

class MySqliResultSet implements ResultSet
{

    private $i = 0;

    private $result;

    private $cursor;

    private $consumed = false;

    public function __construct($result)
    {
        $this->result = $result;
        $this->next();
    }

    public function current()
    {
        $this->consumed = true;
        return $this->cursor != null ? new MySqliRow($this->cursor) : null;
    }

    public function key()
    {
        return $this->i;
    }

    public function next()
    {
        try {
            $this->cursor = mysqli_fetch_assoc($this->result);
            $this->i ++;
        } catch (Exception $e) {
            throw new RuntimeException("Fetch error", 0, $e);
        }
    }

    public function rewind()
    {
        if ($this->consumed) {
            throw new RuntimeException("Cursor is closed");
        }
    }

    public function valid()
    {
        return $this->cursor != null;
    }
}

?>