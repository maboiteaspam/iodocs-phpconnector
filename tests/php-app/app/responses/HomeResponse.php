<?php

/**
 * Class HomeResponse
 *
 * xvxcvcxv
 *
 *
 * @Serpent_Response()
 * @Serpent_ExampleModel()
 */
class HomeResponse{
    /**
     * Content of the response
     *
     * @Serpent_Property(pattern='[0-9]',source='URL')
     * @var string
     */
    public $content = '';
}