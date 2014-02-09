<?php
namespace DemoCustomer\Logged\Example;

/**
 * @ExampleModel()
 */
class NotLogged extends \BaseResponse{
    /**
     * @Property(pattern='/(success|failed)/i')
     * @var string
     */
    public $status = "failed";
    /**
     * @Property()
     * @Items('\ItemErrorModel')
     * @var array
     */
    public $errors = array(
        array(
            "code"=>"customer.not_logged",
            "text"=>"Your session has expired or you did not login before.",
        ),
    );
    /**
     * @Property()
     * @var NULL
     */
    public $data;
}