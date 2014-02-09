<?php
namespace DemoCustomer\Shared\Model;

/**
 * Class Customer Model
 */
class Customer{
    /**
     * General Customer ID
     *
     * @Property(pattern='/CL[0-9]{13}/i')
     * @var string
     */
    public $customer_id;
    /**
     * An Unix timestamp representing the
     * last udpdate date
     *
     *
     * @Property(pattern='/[0-9]+/i')
     * @var int
     */
    public $last_update_time;

    /**
     * @Property(pattern='/(0|1|2)/i')
     * @var string
     */
    public $gender;

    /**
     * An email string representing
     * the customer's login
     *
     * @Property(pattern='/[a-z]+@[a-z]+\.[a-z]+/i')
     * @var string
     */
    public $login;

    /**
     * @Property(pattern='/.+/i')
     * @var string
     */
    public $name;

    /**
     * @Property(pattern='/.+/i')
     * @var string
     */
    public $surname;


    /**
     * @Property(pattern='/[0-9+-]+/i')
     * @var string
     */
    public $mobile;
    /**
     * @Property(pattern='/[0-9+-]+/i')
     * @var string
     */
    public $landline;

    /**
     * A date formatted such Y-m-d
     *
     * @Property(pattern='/[0-9]{4}-[0-9]{2}-[0-9]{2}/i')
     * @var string
     */
    public $birthdate;


    /**
     * A true/false value to
     * allow/disallow customer's optin
     *
     * @Property(pattern='/(0|1)/i')
     * @var string
     */
    public $subscribe_nlt;
    /**
     * A true/false value to
     * allow/disallow customer's optin to partners
     *
     * @Property(pattern='/(0|1)/i')
     * @var string
     */
    public $subscribe_affiliation;
    /**
     * A long term life token to identify a customer
     * send this value to autologin service to login
     * the customer account
     *
     * @Property(pattern='/[a-z0-9]+/i')
     * @var string
     */
    public $token;
}