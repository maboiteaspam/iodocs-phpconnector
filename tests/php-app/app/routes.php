<?php

/**
 * sfsfddf
 *
 * sdfs dfs dfsdfsdf
 * sdfsd fsdfsd fsdf
 * sdf fsd df
 *
 * @Serpent_Domain({'Common', "Gives you access to common personalized data", name="common"})
 * @Serpent_Service({'Homepage', "Let you access the private offer information for homepage",name="common/homepage"})
 *
 * @Serpent_Route('/home')
 * @Serpent_Method('GET')
 * @Serpent_Parameter(description='Id of the stuff to read',name='id',pattern='[0-9]',example='2',sources='URL')
 *
 * @Serpent_Response('\Responses\ExtendedHomeResponse')
 * @Serpent_ExampleModel({'\Examples\ExtendedHomeResponse','\Examples\HomeResponseExample','\Examples\HomeResponseExample2'})
 */
function home(){

}

/**
 * Personal account
 *
 * Some description about the
 * personal account service
 *
 * @Serpent_Domain({'Customer Account', "Gives you access to Customer's personal information such as order history, addresses book, opt-in/out", name="customer"})
 * @Serpent_Service({"Customer's Session", "Let you access current logged in customer",name="customer/session"})
 *
 * @Serpent_Route('/customer/logged_in')
 * @Serpent_Method('GET')
 *
 * @Serpent_Response('\Responses\ExtendedHomeResponse')
 * @Serpent_ExampleModel(description='Ok response 1',title='',ref='\Examples\ExtendedHomeResponse')
 * @Serpent_ExampleModel(description='Ok response 2',title='',ref='\Examples\HomeResponseExample')
 * @Serpent_ExampleModel(description='Ok response 3',title='',ref='\Examples\HomeResponseExample2')
 */
function logged_in(){

}

/**
 * Log out current user
 *
 * @Serpent_Domain({name="customer"})
 * @Serpent_Service({name="customer/session"})
 *
 * @Serpent_Route('/customer/logout')
 * @Serpent_Method('GET')
 *
 * @Serpent_Response('\Responses\ExtendedHomeResponse')
 * @Serpent_ExampleModel({description='Ok response 1',title='',ref='\Examples\ExtendedHomeResponse'})
 * @Serpent_ExampleModel({description='Ok response 2',title='',ref='\Examples\HomeResponseExample'})
 * @Serpent_ExampleModel({description='Ok response 3',title='',ref='\Examples\HomeResponseExample2'})
 */
function logout(){

}

/**
 * Authenticate an user and put it in session if succeed
 *
 * @Serpent_Domain({name="customer"})
 * @Serpent_Service({name="customer/session"})
 *
 * @Serpent_Route('/customer/login')
 * @Serpent_Method('GET')
 *
 * @Serpent_Response('\Responses\ExtendedHomeResponse')
 * @Serpent_ExampleModel({description='Ok response 1',title='',ref='\Examples\ExtendedHomeResponse'})
 * @Serpent_ExampleModel({description='Ok response 2',title='',ref='\Examples\HomeResponseExample'})
 * @Serpent_ExampleModel({description='Ok response 3',title='',ref='\Examples\HomeResponseExample2'})
 */
function login(){

}

/**
 * Personal account
 *
 * Some description about the
 * personal account service
 *
 *
 * @Serpent_Domain({name="customer"})
 * @Serpent_Service({"Customer s Addresses Book", "Let you access customer s addresses book",name="customer/addresses_book"})
 *
 * @Serpent_Route('/customer/addresses')
 * @Serpent_Route('/customer/addresses/:limit')
 * @Serpent_Parameter(  name='limit', description='Offset limit of the list such as (page-length)', pattern='[0-9]+(-[0-9]+)?', example='2', sources='URL')
 * @Serpent_Method('GET')
 *
 * @Serpent_Response('\Responses\ExtendedHomeResponse')
 * @Serpent_ExampleModel({description='Ok response 1',title='',ref='\Examples\ExtendedHomeResponse'})
 * @Serpent_ExampleModel({description='Ok response 2',title='',ref='\Examples\HomeResponseExample'})
 * @Serpent_ExampleModel({description='Ok response 3',title='',ref='\Examples\HomeResponseExample2'})
 *
 */
function addresses(){

}

/**
 * Personal account
 *
 * Some description about the
 * personal account service
 *
 * @Serpent_Domain({name="customer"})
 * @Serpent_Service({"Customer's Order history", "Let you access customer's order history",name="customer/order_history"})
 *
 * @Serpent_Route('/customer/orders_history')
 * @Serpent_Route('/customer/orders_history/:limit')
 * @Serpent_Route('/customer/orders_history/since/:limit_date')
 * @Serpent_Route('/customer/orders_history/since/:limit_date/:limit')
 * @Serpent_Route('/customer/orders_history/until/:limit_date')
 * @Serpent_Route('/customer/orders_history/until/:limit_date/:limit')
 * @Serpent_Parameter(  name='limit', description='Offset limit of the list such as (page-length)', pattern='[0-9]+(-[0-9]+)?', example='1-5', sources='URL')
 * @Serpent_Parameter(  name='limit_date', description='Limit date to select items', pattern='[0-9]{4}-[0-9]{2}-[0-9]{2}( [0-9]{2}:[0-9]{2}:[0-9]{2})?', example='1984-20-10', sources='URL')
 * @Serpent_Parameter(  name='birth_date', description='_____ems', pattern='[0-9]{4}-[0-9]{2}-[0-9]{2}( [0-9]{2}:[0-9]{2}:[0-9]{2})?', example='1984-20-10', sources='POST')
 * @Serpent_Method('GET POST')
 *
 * @Serpent_Response('\Customer\CustomerResponse')
 * @Serpent_Response('\Responses\ExtendedHomeResponse')
 * @Serpent_ExampleModel({description='Ok response',ref='\Customer\CustomerResponse'})
 * @Serpent_ExampleModel({description='Ok response',ref='ExtendedHomeResponse'})
 */
function orders(){

}


