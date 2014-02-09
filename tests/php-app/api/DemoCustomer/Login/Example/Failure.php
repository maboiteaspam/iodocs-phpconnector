<?php
namespace DemoCustomer\Login\Example;

/**
 * @ExampleModel()
 */
class Failure extends \BaseResponse{
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
            "code"=>"authentication.failed",
            "text"=>"Wrong password or login provided.",
        ),
    );
    /**
     * @Property()
     * @var NULL
     */
    public $data;
}