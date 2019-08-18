<?php
/********************************************************************
~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ 
@Author			John Hoddy <john.hoddy@iconic-publishing.com>
@Website		https://www.iconic-publishing.com
@Created		Monday, 2nd April, 2018

© Copyright 2014 - 2018 Iconic Publishing Co Ltd. All Rights Reserved
~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~
Change Request ID: 

~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~
*********************************************************************/

namespace Base\Validation\Forms\Auth;

use Respect\Validation\Validator as v;
use Base\Helpers\Input;

class AuthForm {
	
    public static function registerRules() {
        return [
            'email_address' => v::noWhitespace()->notEmpty()->email()->emailAvailable(),
            'first_name' => v::notEmpty()->alpha(),
            'last_name' => v::notEmpty()->alpha(),
            'mobile_number' => v::notEmpty()->phone(),
            'password' => v::noWhitespace()->notEmpty()->alnum('!"@£#$%^&*(){}[]+')->length(10, 20),
            'confirm_password' => v::noWhitespace()->notEmpty()->alnum('!"@£#$%^&*(){}[]+')->length(10, 20)->identical(Input::get('password'))
        ];
    }
	
    public static function loginRules() {
        return [
            'email_or_username' => v::noWhitespace()->notEmpty(),
            'password' => v::noWhitespace()->notEmpty()
        ];
    }
	
    public static function recoverPasswordRules() {
        return [
            'email_address' => v::noWhitespace()->notEmpty()->email()
        ];
    }
	
    public static function resetPasswordRules() {
        return [
            'password' => v::noWhitespace()->notEmpty()->alnum('!"@£#$%^&*(){}[]+')->length(10, 20)
        ];
    }
	
}
