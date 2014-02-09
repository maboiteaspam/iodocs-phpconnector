<?php
namespace DemoCustomer\Login;

/**
 * @ParametersModel()
 */
class Parameters {
    /**
     * An email string representing
     * the customer's login
     *
     * @Property(pattern='/[a-z]+@[a-z]+\.[a-z]+/i')
     * @var string
     */
    public $login = "john@doe.com";
    /**
     * Personal customer's login
     *
     * @Property(pattern='/.{6,}/i')
     * @var string
     */
    public $password = "123456";
}
