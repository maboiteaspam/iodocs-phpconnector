<?php
namespace DemoCustomer\Shared\Example;

/**
 * @ExampleModel()
 */
class JohnDoe extends \BaseResponse{
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
     * @var \DemoCustomer\Shared\Fixture\JohnDoe
     */
    public $data;
}
