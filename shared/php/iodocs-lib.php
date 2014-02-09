<?php

/**
 * Returns the endpoints that class belongs too
 *
 * @param $class_name
 * @return array|bool
 */
function get_endpoint($class_name){
    $retour = false;
    $annotation = get_annotation($class_name)->getAnnotation('Domain');
    if( $annotation != null ){
        if( isset($annotation->value["title"]) ){
            $retour = $annotation->value["title"];
        }else if( isset($annotation->value[0]) ){
            $retour = $annotation->value[0];
        }else if( isset($annotation->value["name"]) ){
            $retour = $annotation->value["name"];
        }else if( isset($annotation->value[1]) ){
            $retour = $annotation->value[1];
        }
    }
    return $retour;
}

function get_all_endpoint_classes($user_classes){
    $retour = array();

    foreach( $user_classes as $class_name ){
        $end_point = get_endpoint($class_name);
        if( $end_point !== false )
            $retour[] = $class_name;
    }

    return $retour;
}

function get_all_example_classes($user_classes){
    $retour = array();

    foreach( $user_classes as $class_name ){
        $end_point = is_example_model($class_name);
        if( $end_point !== false )
            $retour[] = $class_name;
    }

    return $retour;
}
function is_example_model($class_name){
    $retour = false;
    $annotations = get_annotation($class_name)->getAllAnnotations('ExampleModel');
    if( $annotations != false ){
        $retour = true;
    }
    return $retour;
}

function get_class_method_routes($class_name,$method_name){
    $retour = array();

    $annotations = get_annotation(array($class_name,$method_name))->getAllAnnotations('Route');
    if( $annotations != false ){
        foreach($annotations as $annotation ){
            if( isset($annotation->value["route"]) )
                $retour[] = $annotation->value["route"];

            else if( is_string($annotation->value) )
                $retour[] = $annotation->value;
        }
    }

    return $retour;
}

function get_class_method_http_verbs($class_name,$method_name){
    $retour = array();

    $annotations = get_annotation(array($class_name,$method_name))->getAllAnnotations('Method');
    if( $annotations != false ){
        foreach($annotations as $annotation ){
            if( is_array($annotation->value) )
                $retour = array_merge($retour, $annotation->value);
            else
                $retour = array_merge($retour, explode(" ",$annotation->value));
        }
    }

    return $retour;
}

function get_class_method_http_parameters($class_name,$method_name){
    $retour = array();

    $annotations = get_annotation(array($class_name,$method_name))->getAllAnnotations('ParametersModel');
    if( $annotations != false ){
        foreach($annotations as $annotation ){
            if( is_array($annotation->value) ){
                $http_method = $annotation->value["method"];
                $ref_class = $annotation->value["ref"];
                $retour[ $http_method ] = $ref_class;
            }else{
                throw new \Exception("Parameters model must be an array");
            }
        }
    }

    return $retour;
}
function get_class_method_url_parameters($class_name,$method_name){

    $retour = array();

    $annotations = get_annotation(array($class_name,$method_name))->getAllAnnotations('Parameter');
    if( $annotations != false ){
        foreach($annotations as $annotation ){
            if( strpos("URL",$annotation->sources) !== false ){
                $prop = array(
                    "Description"=>"",
                    "Name"=>"",
                    "Required"=>false,
                    "Default"=>null,
                    "Pattern"=>"",
                    "Type"=>false,
                    "Location"=>"URL",
                );
                foreach( $annotation as $k=>$v){
                    if( $k === "example" ){
                        $prop["Default"] = $v;
                    }else if( isset($prop[ucfirst($k)]) ){
                        $v = $v==="true"?true:$v;
                        $v = $v==="false"?false:$v;
                        $prop[ucfirst($k)] = $v;
                    }
                }
                if( $prop["Type"] === false ){
                    $prop["Type"] = gettype($prop["Default"]);
                }
                $retour[] = $prop;
            }else{
                var_dump($annotation);
                throw new \Exception("must be an array");
            }
        }
    }

    return $retour;
}

function transform_parameters_class_to_array($verb,$class_name){
    $retour = array();

    $properties = get_property_list($class_name);
    foreach( $properties as $property_name=>$prop){
        $retour[$property_name] = new_resolve_property($verb,$class_name,$property_name,$prop["default"]);
    }
    return $retour;
}

/**
 * for data consistency
 *
 * @param $class_name
 * @param $method_name
 * @return array
 */
function new_parse_docblock_title_desc ($class_name,$method_name){
    $texts = parse_docblock_title_desc(array($class_name,$method_name));
    return array(
        "title"=> isset($texts["title"])?$texts["title"]:"",
        "description"=>isset($texts["description"])?$texts["description"]:"",
    );
}

function new_resolve_property($verb,$class_name,$property_name,$default_value=null){

    $type = parse_docblock_annot(array($class_name,$property_name), "var");
    if( $type === false && $default_value !== null ){
        $type = gettype($default_value);
    }

    $docblock_text = new_parse_docblock_title_desc($class_name,$property_name);

    $prop = array(
        "Description"=>$docblock_text["title"],
        "Name"=>$property_name,
        "Required"=>false,
        "Default"=>$default_value,
        "Pattern"=>"",
        "Type"=>$type,
        "Location"=>$verb,
    );

    $annotation = get_annotation( array($class_name,$property_name) )->getAnnotation('Property');
    if( $annotation != false ){
        if(is_array($annotation->value) ){
            foreach( $annotation->value as $k=>$v){
                if( isset($prop[ucfirst($k)]) ){
                    $v = $v==="true"?true:$v;
                    $v = $v==="false"?false:$v;
                    $prop[ucfirst($k)] = $v;
                }
            }
        }else if($annotation->value !== NULL ){
            var_dump($class_name,$property_name);
            var_dump($annotation->value);
            throw new \Exception("must be an array");
        }
    }

    return $prop;
}


// backported helpers
// ---------

// fs helpers
// ----------
function scanRecursive($path, $baseDir="") {
    $retour = array();
    $baseDir=$baseDir==""?$path:$baseDir;
    $dh = opendir($path);
    if( $dh == false ){
        throw new \Exception("$path does not exists");
    }
    while (($file = readdir($dh)) !== false) {
        if (substr($file, 0, 1) == '.') continue;
        $rfile = "{$path}/{$file}";
        if (is_dir($rfile)) {
            $retour = array_merge($retour, scanRecursive($rfile, $baseDir));
        } else {
            $retour[substr($rfile,strlen($baseDir))] = $file;
        }
    }
    closedir($dh);
    return $retour;
}
function delTree($dir) {
    if( is_dir($dir) == false ) return true;
    $files = array_diff(scandir($dir), array('.','..'));
    foreach ($files as $file) {
        (is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file");
    }
    return rmdir($dir);
}
function clean_path($path){
    $path = str_replace("\\","/",$path);
    $path = str_replace("\\","/",$path);
    $path = str_replace("\\","/",$path);
    $path = str_replace("//","/",$path);
    $path = str_replace("//","/",$path);
    $path = str_replace("//","/",$path);
    return $path;
}
function clean_dirname($path){
    $path = dirname($path);
    $path = $path == "."?"":$path;
    $path =$path == "/"?"":$path;
    $path =$path == "\\"?"":$path;
    return $path;
}

// reflection helpers
// ---------
function get_reflection($item){
    $reflection = $item;
    if( is_string($item) && function_exists($item) ){
        $reflection = new ReflectionFunction($item);
    }else if( is_string($item) && class_exists($item)){
        $reflection = new ReflectionClass($item);
    }else if( is_array($item) && method_exists($item[0],$item[1])){
        $reflection = new ReflectionMethod($item[0],$item[1]);
    }else if( is_array($item) && property_exists($item[0],$item[1])){
        $reflection = new ReflectionProperty($item[0],$item[1]);
    }
    return $reflection;
}
function get_property_list($class, $visibility=null){
    $retour = array();
    $visibility=$visibility===NULL?ReflectionProperty::IS_PUBLIC:$visibility;
    $ref = new ReflectionClass($class);
    $default = $ref->getDefaultProperties();
    foreach( $ref->getProperties($visibility) as $property ){
        $name = $property->getName();
        $retour[$name] = array('default'=>$default[$name]);
    }
    return $retour;
}


// annotation helpers
// ---------
function get_annotation($item){
    $reflection = false;
    if( is_string($item) && function_exists($item) ){
        $reflection = new ReflectionAnnotatedFunction($item);
    }else if( is_string($item) && class_exists($item)){
        $reflection = new ReflectionAnnotatedClass($item);
    }else if( is_array($item) && method_exists($item[0],$item[1])){
        $reflection = new ReflectionAnnotatedMethod($item[0],$item[1]);
    }else if( is_array($item) && property_exists($item[0],$item[1])){
        $reflection = new ReflectionAnnotatedProperty($item[0],$item[1]);
    }else if( $item instanceof ReflectionMethod ){
        $reflection = new ReflectionAnnotatedMethod($item->class,$item->name);
    }else if( $item instanceof ReflectionClass ){
        $reflection = new ReflectionAnnotatedClass($item->class);
    }else{
        var_dump($item);
        throw new \Exception("xwc");
    }
    return $reflection;
}
function parse_docblock_annot ($item, $annot_name){
    $retour = false;
    $ref    = get_reflection($item);
    $text   = $ref->getDocComment();
    $text   = substr($text, 3, -2);
    if( preg_match("/^\s*\*\s*@".$annot_name."\s+(.+)$/im",$text, $matches) > 0 ){
        $retour = trim($matches[1]);
    }
    return $retour;
}
function parse_docblock_text($item){
    $retour = "";
    $ref = get_reflection($item);
    $retour = $ref->getDocComment();
    $retour = substr($retour, 3, -2);
    $retour = preg_replace("/^\s*\*\s*@.+$/m","",$retour);
    $retour = preg_replace("/^\s*\*/m","",$retour);
    return trim($retour);
}
function parse_text_title_desc ($text){
    $retour = array();

    $eol = strpos($text,"\n\n") > -1 ? "\n" : "\r\n";

    if( strpos($text,"$eol$eol") > -1 ){
        $retour["title"] = substr($text,0,strpos($text, "$eol$eol"));
        $text = substr($text,strlen($retour["title"]));
        $text = ltrim($text);
        if( trim($text)!="" ){
            $retour["description"] = trim($text);
        }
        if( isset($retour["description"]) ) $retour["description"] = trim($retour["description"]);
        if( isset($retour["title"]) ) $retour["title"] = trim($retour["title"]);

        if( $retour["description"] == "" ) unset($retour["description"]);
        if( $retour["title"] == "" ) unset($retour["title"]);
    }elseif( count(explode("$eol$eol", $text)) == 1 ){
        $retour["title"] = trim($text);
    }
    return $retour;
}
function parse_docblock_title_desc ($item){
    $text = parse_docblock_text ($item);
    return parse_text_title_desc ($text);
}

// transformers
// ----------
function transform_properties_to_example($item, $stack=array()){
    $stack[] = $item;
    $retour = array();
    $ref = new ReflectionClass($item);
    $default = $ref->getDefaultProperties();
    foreach( $ref->getProperties(ReflectionProperty::IS_PUBLIC) as $property ){

        $name = $property->getName();
        $def_val = $default[$name];

        $var_type = parse_docblock_annot(array($item,$name), "var");

        if( $var_type == "NULL" ){
            $retour[$name] = NULL;
        }else if( $var_type !== false && class_exists($var_type) ){
            if( in_array($var_type, $stack) ){
                $retour[$name] = "*recursion of $var_type*";
            }else{
                $retour[$name] = transform_properties_to_example($var_type, $stack);
            }
        }else if( $def_val !== NULL ){
            if( is_string( $def_val ) ) $retour[$name] = htmlentities($def_val);
            else $retour[$name] = $def_val;
        }elseif($var_type == "array"){
            $values = array();
            $annotations = get_annotation(array($item,$name))->getAllAnnotations("Example");
            foreach( $annotations as $annotation ){
                $value = $annotation->value;
                if( class_exists($annotation->value) ){
                    $value = transform_properties_to_example($annotation->value, $stack);
                }
                $values[] = $value;
            }
            $retour[$name] = $values;
        }else{
            $annotation = get_annotation(array($item,$name))->getAnnotation("Example");
            if( $annotation != false ){
                $value = $annotation->value;
                if( class_exists($annotation->value) ){
                    $value = transform_properties_to_example($annotation->value, $stack);
                }
                $retour[$name] = $value;
            }
        }
    }
    array_pop ( $stack );
    return $retour;
}