<?php

/**
 * Default strucutre for any JSON response
 *
 */
class BaseResponse{
    /**
     * @Property(pattern='/(success|failed)/i')
     * @var string
     */
    public $status;
    /**
     * @Property()
     * @var array
     */
    public $data;
    /**
     * @Property()
     * @Items('\ErrorModel')
     * @var array
     */
    public $errors;
}