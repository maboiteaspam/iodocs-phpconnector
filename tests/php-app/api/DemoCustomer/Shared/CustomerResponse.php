<?php
namespace DemoCustomer\Shared;

/**
 * @Response()
 */
class CustomerResponse extends \BaseResponse{

    /**
     * @Property()
     * @var \DemoCustomer\Shared\\ModelCustomer
     */
    public $data;
}