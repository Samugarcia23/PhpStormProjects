<?php

/**
 * Created by PhpStorm.
 * User: sgarcia
 * Date: 30/11/18
 * Time: 10:56
 */

require_once "Controller.php";

class CapController extends Controller
{
    public function manageGetVerb(Request $request)
    {
        $capitulo = null;
        $id = null;
        $response = null;
        $code = null;

        if (isset($request->getUrlElements()[2])) {
            $id = $request->getUrlElements()[2];
        }
        if (isset($request->getUrlElements()[3])) {
            $capitulo = $request->getUrlElements()[3];
        }

        $capitulo = LibroHandlerModel::getCapitulo($id, $capitulo);

        if ($capitulo != null) {
            $code = '200';

        } else {

            if (CapitulosHandlerModel::isValid($id)) {
                $code = '404';
            } else {
                $code = '400';
            }

        }

        $response = new Response($code, null, $capitulo, $request->getAccept());
        $response->generate();
    }
}