<?php

namespace App\Middlewares;

use Slim\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use App\Utils\Resp;

class ParametrosMiddleware
{

    public function valUsuario(Request $request, RequestHandler $handler): Response
    {
        try{

            $response = new Response();

            $req= $request->getParsedBody();

            if(isset($req['tipo']) && isset($req['email']) && isset($req['clave']) && isset($req['legajo'])  && isset($req['nombre'])){
                if($req['tipo'] != null && $req['email'] != null && $req['clave'] != null && $req['legajo'] != null && $req['nombre'] != null){
                    
                    $response = $handler->handle($request);
                }else {
                    $rta ="El parametro no puede estar en blanco.";
                    $response->getBody()->write( Resp::Respuesta(0,$rta));
                }
            }else {
                $rta ="Falta ingresar parametros.";
                $response->getBody()->write( Resp::Respuesta(0,$rta));
            }
            
        }
        catch(Exception $e){
            $response->getBody()->write(  Resp::Respuesta(-1,"Fallo inesperado del sistema."));
        }
        
        return $response;
    }


    public function valLogin(Request $request, RequestHandler $handler): Response
    {
        try{

            $response = new Response();

            $req= $request->getParsedBody();

            if(isset($req['email']) && isset($req['clave']) ){
                if($req['email'] != null && $req['clave'] != null){
                    $response = $handler->handle($request);
                }else {
                    $rta ="El parametro no puede estar en blanco.";
                    $response->getBody()->write( Resp::Respuesta(0, $rta));
                }
            }else {
                $rta ="Falta ingresar parametros.";
                $response->getBody()->write( Resp::Respuesta(0, $rta));
            }
            
        }
        catch(Exception $e){
            $response->getBody()->write(  Resp::Respuesta(-1,"Fallo inesperado del sistema."));
        }
        
        return $response;
    }



    public function valMateria(Request $request, RequestHandler $handler): Response
    {
        try{

            $response = new Response();

            $req= $request->getParsedBody();

            if(isset($req['materia']) && isset($req['cuatrimestre']) && isset($req['vacantes']) && isset($req['profesor'])){
                if($req['materia'] != null && $req['cuatrimestre'] != null && $req['vacantes'] != null && $req['profesor'] != null){
                    
                    $response = $handler->handle($request);
                }else {
                    $rta ="El parametro no puede estar en blanco.";
                    $response->getBody()->write( Resp::Respuesta(0,$rta));
                }
            }else {
                $rta ="Falta ingresar parametros.";
                $response->getBody()->write( Resp::Respuesta(0,$rta));
            }
            
        }
        catch(Exception $e){
            $response->getBody()->write(  Resp::Respuesta(-1,"Fallo inesperado del sistema."));
        }
        
        return $response;
    }




























}
    /*
    *
     * Example middleware invokable class
     *
     * 
     
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $response = $handler->handle($request);
        

        $array = (array) $response->getBody();
        $user = $array['usuario'] ?? null;
        $email = $array['email'] ?? null;
        $clave = $array['clave'] ?? null;
        $tipo = $array['tipo'] ?? null;

        $response = new Response();

        if ($user != null && $email != null && $clave != null && $tipo != null) {
            if ($user != " " && $email != " " && $clave != " " && $tipo != " ") {

                $response->getBody()->write($array);

            }else {
                $response->getBody()->write('No se permiten campos vacios.');
            }
        }else {
            
            
            $response->getBody()->write('Falta ingresar datos.');
        }

        return $response;
    }*/

