<?php


$output_path = $config->output_path;
$current_cwd_dir = getcwd();

include(__DIR__ . "/serpent_addendum.php");
include(__DIR__ . "/iodocs-lib.php");



// gets the src path of your php app
$src_path       = $config->src_path;
$api_name       = $config->api_name;
$api_config     = $config->api_config;
$output_path    = $config->output_path;
$examples_path  = $config->output_path."/examples/";



// initiate fake variable
if( isset($config->fake_var) ){
    foreach($config->fake_var as $var){
        $$var = new FakeVar();
    }
}

$system_classes    = get_declared_classes();
install_autoloading($config, $src_path);
wakeup_userclasses($src_path);
$user_classes = collect_userclasses($system_classes);






// some variables to store collected information about your project
$endpoints    = array();

$ep_classes = get_all_endpoint_classes($user_classes);
foreach( $ep_classes as $class_name ){
    $endpoint = array(
        "name"=> get_endpoint($class_name),
        "methods"=>array(),
    );
    $methods = get_reflection($class_name)->getMethods();

    foreach( $methods as $index=>$method_meta ){
        $method_name = $method_meta->name;
        $method_routes = get_class_method_routes($class_name,$method_name);
        $method_verbs = get_class_method_http_verbs($class_name,$method_name);
        $method_parameters = get_class_method_http_parameters($class_name,$method_name);
        $method_texts = new_parse_docblock_title_desc( $class_name,$method_name );

        if( count($method_routes)+count($method_routes)==0){
            //echo "OoOo";
        }else{
            //-
            foreach( $method_routes as $route ){
                foreach( $method_verbs as $verb ){
                    $ep_method = array(
                        "MethodName"=>$method_texts["title"],
                        "Synopsis"=>$method_texts["description"],
                        "HTTPMethod"=>$verb,
                        "URI"=>$route,
                        "RequiresOAuth"=>"N",
                        "parameters"=>array(),
                    );
                    if( isset($method_parameters[$verb]) ){
                        $ep_method["parameters"] = transform_parameters_class_to_array($method_parameters[$verb]);
                    }
                    $endpoint["methods"][] = $ep_method;
                }
            }
        }
    }
    $endpoints[] = $endpoint;
}





$example_classes = get_all_example_classes($user_classes);
foreach( $example_classes as $class_name ){
    // echo "Performing\t\t\t$class_name\n";
    $examples[$class_name] = transform_properties_to_example($class_name);
}



// write results
if( !is_dir($output_path) )
    mkdir($output_path,0777,true);

if( file_exists($output_path."/apiconfig.json") ){
    $api_configs = json_decode(file_get_contents($output_path."/apiconfig.json"),true);
    foreach($api_config as $k=>$v){
        $api_configs[$api_name][$k] = $v;
    }
    file_put_contents($output_path."/apiconfig.json",json_encode($api_configs,JSON_PRETTY_PRINT));
}else{
    file_put_contents($output_path."/apiconfig.json",json_encode(array($api_name=>$api_config),JSON_PRETTY_PRINT));
}
echo $output_path."/apiconfig.json\n";


if( file_exists($output_path."/$api_name.json") )
    unlink($output_path."/$api_name.json");
file_put_contents($output_path."/$api_name.json",json_encode($endpoints,JSON_PRETTY_PRINT) );

echo $output_path."/$api_name.json\n";

delTree($examples_path);
mkdir($examples_path,0777,true);
// generate the examples json files
foreach( $examples as $class_name=>$example_array ){
    $ref = clean_path($class_name);

    $ref_path = clean_dirname($ref);

    $ref_file = basename($ref);
    $ref_path = clean_path($examples_path."/".$ref_path."/");
    $ref_fp = $ref_path.$ref_file.".json";

   // echo "$ref_fp\n";
    if( is_dir($ref_path) == false ) mkdir($ref_path, 0777, true);
    file_put_contents($ref_fp, json_encode($example_array, JSON_PRETTY_PRINT));
}


// Finally return
return true;




// help functions
// ------
function collect_userclasses($system_classes){
// collect the classes and function declared by your project
    $all_classes = get_declared_classes();
    $user_classes = array();
    foreach( $all_classes as $class_name ){
        if( in_array($class_name, $system_classes) == false ){
            $user_classes[] = $class_name;
        }
    }
    return $user_classes;
}
function wakeup_userclasses($path){
// scan files to load
    $files = scanRecursive($path);
// load them within this context, we pray they won't hang :/
// ideally they are only class file, or routes declaration file
    foreach($files as $file_path=>$filename ){
        $file_path = realpath($path.$file_path);
        if( in_array($file_path, get_included_files()) == false && substr($file_path,-4) == ".php" ){
            include_once($file_path);
        }
    }
}
function install_autoloading($config,$path){

// load app bootstrap, app is responsible to initialize some variable and setup autoloader
    $use_bootstrap = false;
    if( isset($config->app_bootstrap) ){
        if( $config->app_bootstrap != "" &&
            file_exists($config->app_bootstrap) )
            $use_bootstrap = true;
    }

    if( $use_bootstrap ){
        include($config->app_bootstrap);
    }else{
        $autoload = function($className) use($path) {
            $thisClass = str_replace(__NAMESPACE__.'\\', '', __CLASS__);

            $baseDir = $path;

            if (substr($baseDir, -strlen($thisClass)) === $thisClass) {
                $baseDir = substr($baseDir, 0, -strlen($thisClass));
            }

            $className = ltrim($className, '\\');
            $fileName  = $baseDir;
            $namespace = '';
            if ($lastNsPos = strripos($className, '\\')) {
                $namespace = substr($className, 0, $lastNsPos);
                $className = substr($className, $lastNsPos + 1);
                $fileName  .= str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
            }
            $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';

            var_dump($fileName);
            if (file_exists($fileName)) {
                require $fileName;
            }
        };
        spl_autoload_register( $autoload );
    }
}

// add a faveVar class to accept any call without much damage on the fake variables created
class FakeVar{
    public function __get($p){
        return false;
    }
    public function __set($p,$v){
        return false;
    }
    public function __call($m,$n){
        return false;
    }
}