<?php
namespace Customer\Example;

use \Customer\Customer as CustomerModel;

/**
 * Class JohnDoe
 * @package Customer\Example
 * @Serpent_ExampleModel()
 */
class JohnDoe extends CustomerModel{

    public $surname = "John";
    public $first_name = "Doe";
    /**
     * @Example("sdfdsf sd fs")
     * @var string
     */
    public $tomate;
}