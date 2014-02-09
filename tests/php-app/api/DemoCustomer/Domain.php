<?php
namespace DemoCustomer;

/**
 * Gives access to personal customer data,
 * provides ability to login / logout ect
 *
 * @Domain({'Customer'})
 * @Service({'Customer Authentication'})
 *
 */
class Domain extends \BaseDomain{

    /**
     * Get logged customer's data
     *
     *
     * If the customer is not logged, it fails with a nice error message
     *
     *
     * @Route('/customer/logged')
     * @Method('GET')
     *
     * @Response('DemoCustomer\Shared\CustomerResponse')
     * @ExampleModel({description='Ok response',ref='DemoCustomer\Shared\Example\JohnDoe'})
     * @ExampleModel({description='Failed to authenticate',ref='DemoCustomer\Logged\Example\NotLogged'})
     */
    public function logged(){
        // create the responder
        $response = $this->getResponder();

        // load current customer in session
        $Customer = array("name"=>"","login"=>"","logged"=>false);

        $response->set_data( $Customer );
        $this->app->response->headers->set('Content-Type', 'application/json');
        $this->app->response->write($response);
    }


    /**
     * Logout customer
     *
     *
     * If the customer is not logged, it fails with a nice error message
     *
     *
     * @Route('/customer/logout')
     * @Method('POST')
     *
     * @Response('BaseResponse')
     * @ExampleModel({description='Ok response',ref='DemoCustomer\Logout\Example\Success'})
     * @ExampleModel({description='Failed to logout',ref='DemoCustomer\Logged\Example\NotLogged'})
     */
    public function logout(){
        // create the responder
        $response = $this->getResponder();
        $response->set_data( array("done"=>true) );
        $this->app->response->headers->set('Content-Type', 'application/json');
        $this->app->response->write($response);
    }

    /**
     * Authenticate a Customer given his login/password
     *
     * @Route('/customer/login')
     * @Method('POST')
     * @ParametersModel({method='POST', ref='DemoCustomer\Login\Parameters'})
     *
     * @Response('DemoCustomer\Shared\CustomerResponse')
     * @ExampleModel({description='Authentication successful',ref='DemoCustomer\Shared\Example\JohnDoe'})
     * @ExampleModel({description='Failed to authenticate',ref='DemoCustomer\Login\Example\Failure'})
     */
    public function login(){
        // create the responder
        $response = $this->getResponder();

        // check for input data first
        $login      = isset($_POST["login"])?$_POST["login"]:"";
        $password   = isset($_POST["password"])?$_POST["password"]:"";

        if( $login == "" ){
            $response->add_error("login.parameter_is_missing");
        }
        if( $password == "" ){
            $response->add_error("password.parameter_is_missing");
        }

        // check for blocking errors
        if( $response->isFailed() == false ){
            $Customer = array("name"=>"","login"=>"","logged"=>false);
            $response->set_data($Customer);
        }

        $this->app->response->headers->set('Content-Type', 'application/json');
        $this->app->response->write($response);
    }


}
