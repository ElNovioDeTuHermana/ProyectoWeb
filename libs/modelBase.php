<?php
class ModelBase {

    protected $db;

    function __construct()
    {
        $this->db = new Database();
    }
}
?>