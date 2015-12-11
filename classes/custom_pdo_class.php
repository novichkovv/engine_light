<?php
/**
 * Created by PhpStorm.
 * User: novichkov
 * Date: 15.03.15
 * Time: 17:25
 */
class custom_pdo_class extends PDO {
    public function __construct($dsn, $username = null, $password = null, $driver_options = array())
    {
        parent::__construct($dsn, $username, $password, $driver_options);
        $this->setAttribute(PDO::ATTR_STATEMENT_CLASS, array('custom_pdo_statement_class', array($this)));
    }
}
