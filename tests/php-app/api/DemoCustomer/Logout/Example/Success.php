<?php
namespace DemoCustomer\Shared\Example;

/**
 * @ExampleModel()
 */
class Success extends \BaseResponse{
    /**
     * @Property(pattern='/(success|failed)/i')
     * @var string
     */
    public $status = "success";
    /**
     * @Property()
     * @Items('\ItemErrorModel')
     * @var array
     */
    public $errors = array();
    /**
     * @Property()
     * @var NULL
     */
    public $data;
}
