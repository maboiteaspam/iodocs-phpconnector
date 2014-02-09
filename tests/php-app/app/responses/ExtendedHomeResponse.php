<?php
/**
 * Class ExtendedHomeResponse
 *
 * xvxcvcxv
 *
 *
 * @Serpent_Response()
 * @Serpent_ExampleModel()
 */
class ExtendedHomeResponse extends HomeResponse{
    /**
     * Content of the extended response
     *
     * @Serpent_Property(pattern='[0-9]',source='URL')
     * @var int
     */
    public $another_stuff_to_hold = 8;
}