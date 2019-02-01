<?php


/**
 * Created by PhpStorm.
 * User: sgarcia
 * Date: 1/02/19
 * Time: 10:12
 */

require_once "Controller.php";

class LoginController
{

    public function manageGetVerb(Request $request){

        $usuario = null;
        $user = null;
        $password = null;
        $response = null;
        $code = null;

        if (isset($request->getUrlElements()[2])) {
            $user = $request->getUrlElements()[2];
        }

    }

}