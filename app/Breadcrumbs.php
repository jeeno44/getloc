<?php

namespace App;

class Breadcrumbs
{
    protected $crumbs = [];

    protected static $_instance;

    private function __construct(){}

    private function __clone(){}

    public static function getInstance() {
        if (null === self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    function add($link, $name)
    {
        $this->crumbs[] = [
            'name'  => $name,
            'link'  => $link,
        ];
    }

    function getCrumbs()
    {
        return $this->crumbs;
    }

}