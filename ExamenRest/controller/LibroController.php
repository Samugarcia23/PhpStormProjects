<?php

require_once "Controller.php";


class LibroController extends Controller
{
    public function manageGetVerb(Request $request)
    {

        $capitulo = null;
        $listaLibros = null;
        $cap = null;
        $id = null;
        $idcap = null;
        $response = null;
        $code = null;

        //if the URI refers to a libro entity, instead of the libro collection
        if (isset($request->getUrlElements()[2])) {
            $id = $request->getUrlElements()[2];
        }

        if (isset($request->getUrlElements()[4])) {
            $idcap = $request->getUrlElements()[4];
        }


        if (isset($request->getUrlElements()[3]) != null){
            $cap = $request->getUrlElements()[3];
            $capitulo = LibroHandlerModel::getCapitulo($id, $cap, $idcap);

            if ($capitulo != null) {
                $code = '200';

            } else {

                //We could send 404 in any case, but if we want more precission,
                //we can send 400 if the syntax of the entity was incorrect...
                if (LibroHandlerModel::isValid($id)) {
                    $code = '404';
                } else {
                    $code = '400';
                }
            }

            $response = new Response($code, null, $capitulo, $request->getAccept());

        }else{

            $listaLibros = LibroHandlerModel::getLibro($id, $request->getQueryString());

            if ($listaLibros != null) {
                $code = '200';

            } else {

                //We could send 404 in any case, but if we want more precission,
                //we can send 400 if the syntax of the entity was incorrect...
                if (LibroHandlerModel::isValid($id)) {
                    $code = '404';
                } else {
                    $code = '400';
                }



            }

            $response = new Response($code, null, $listaLibros, $request->getAccept());
        }

        $response->generate();

    }

    public function managePostVerb(Request $request)
    {
        $libro = null;
        $response = null;
        $code = null;

        $libro = $request->getBodyParameters();

        $filas = LibroHandlerModel::postLibro($libro);

        if ($filas == 1) {
            $code = '200';

        }else {
            $code = '404';
        }

        $response = new Response($code, null, null, $request->getAccept());
        $response->generate();
    }

    public function manageDeleteVerb(Request $request)
    {
        $filasAfectadas = 0;
        $response = null;
        $code = null;

        //if the URI refers to a libro entity, instead of the libro collection
        if (isset($request->getUrlElements()[2])) {
            $id = $request->getUrlElements()[2];
        }

        $filasAfectadas = LibroHandlerModel::deleteLibro($id);

        if ($filasAfectadas == 1) {
            $code = '200';

        }else {

            //We could send 404 in any case, but if we want more precission,
            //we can send 400 if the syntax of the entity was incorrect...
            if (LibroHandlerModel::isValid($id)) {
                $code = '404';
            } else {
                $code = '400';
            }
        }

        $response = new Response($code, null, null, $request->getAccept());
        $response->generate();
    }

    public function managePutVerb(Request $request)
    {
        $response = null;
        $code = null;
        $libro = null;
        $codigo = null;
        $numpag = null;
        $titulo = null;

        $libro = $request->getBodyParameters();

        $filasAfectadas = LibroHandlerModel::putLibro($libro);

        if ($filasAfectadas == 1){
            $code = 200;
        }else{
            $code = 404;
        }

        $response = new Response($code, null, null, $request->getAccept());

        $response->generate();

    }

}