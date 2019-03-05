<?php
namespace dsweb\dal;

interface Row
{

    function get($key);

    function getAsMap();
}

?>