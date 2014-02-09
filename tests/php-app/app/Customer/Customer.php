<?php
namespace Customer;
/**
 * Class Customer
 * @package Customer
 * @Serpent_Response()
 */
class Customer {
    /**
     *
     * @Property(pattern='/[a-z]+/i')
     * @var string
     */
    public $surname;
    /**
     *
     * @Property(pattern='/[a-z]+/i')
     * @var string
     */
    public $first_name;
    /**
     *
     * @Property(pattern='/[0-9]{4}[0-9]{2}[0-9]{2}/i')
     * @var string
     */
    public $birth_date;
}

/**
 * Class CustomerResponse
 * @package Customer
 * @Serpent_Response()
 * @Serpent_ExampleModel()
 */
class CustomerResponse{
    /**
     * @Items('\Customer\Customer')
     * @Example('\Customer\Example\JohnDoe')
     * @var array
     */
    public $items;
    /**
     * @Example('\Customer\Example\JohnDoe')
     * @var \Customer\Customer
     */
    public $test;
}