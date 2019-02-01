<?php

/**
 * Created by PhpStorm.
 * User: sgarcia
 * Date: 1/02/19
 * Time: 10:46
 */

require_once "Controller.php";

class SignUpController extends Controller
{

    public function managePostVerb(Request $request)
    {
        $usuario = null;
        $response = null;
        $code = null;

        $usuario = $request->getBodyParameters();
        $filas = SignUpHandlerModel::postNuevoUsuario($usuario);

        if ($filas == 1) {
            $code = '200';

        }else {
            $code = '404';
        }

        $response = new Response($code, null, null, $request->getAccept());
        $response->generate();

    }

}