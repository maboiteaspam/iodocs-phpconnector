<?php

// internally we use addendum to do the whole annotations parsing job
include(__DIR__ . "/addendum/annotations.php");
// addendum related stuff, they are the annotation you may declare
class Serpent_Domain extends Annotation {}
class Serpent_Service extends Annotation {}
class Serpent_Route extends Annotation {}
class Serpent_Method extends Annotation {}
class Serpent_Response extends Annotation {}
class Serpent_Parameter extends Annotation {
    public $description;
    public $name;
    public $pattern;
    public $example;
    public $sources;
}
class Serpent_Property extends Annotation {
    public $title;
    public $description;
    public $type;
    public $pattern;
    public $required;
    public $default;
}
class Serpent_ResponseModel extends Annotation {}
class Serpent_ExampleModel extends Annotation {}
class Serpent_Items extends Annotation {}
class Serpent_Example extends Annotation {}
class ParametersModel extends Annotation {}

