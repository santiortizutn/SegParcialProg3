<?php
namespace App\Middlewares;

use Slim\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use App\Utils\AutentificadorJWT;
use App\Utils\Resp;
use App\Models\Usuario;
use Exception;

class  ValidaTokenMiddle{

    public function validaAdmin(Request $request, RequestHandler $handler): Response
    {

        try{
            
            $response = new Response();
            $token =  $request->getHeader('token');

            if(!empty($token) ){
                $stringToken = $token[0]; 
                $msg ="";
                $data = new Usuario();
                AutentificadorJWT::VerificarToken($stringToken);
                $data = AutentificadorJWT::ObtenerData($stringToken);

                if($data->tipo_id == "3"){
        
                    $response = $handler->handle($request);
        
                }else{
                    $rta ="Solo el un admin puede acceder.";
                    $response->getBody()->write( Resp::Respuesta(0,$rta));
                }
            }
            else{
                $rta = "Debe ingresar un token";
                 $response->getBody()->write(Resp::Respuesta(0,$rta));
            }
        }catch(Exception $e){
            $response->getBody()->write(Resp::Respuesta(-1,"Token invalido") );
        }
        
        return $response;
    }



    public function validaSoloToken(Request $request, RequestHandler $handler): Response
    {

        try{
            
            $response = new Response();
            $token =  $request->getHeader('token');

            if(!empty ($token) ){
                $stringToken = $token[0]; 
              
                $data = new Usuario();
                AutentificadorJWT::VerificarToken($stringToken);
                $data = AutentificadorJWT::ObtenerData($stringToken);

                if($data->tipo_id == "1" || $data->tipo_id == "2" || $data->tipo_id == "3"){
        
                  
                    $response = $handler->handle($request);
        
                }else{
                    $rta ="Tipo de usuario incorrecto.";
                    $response->getBody()->write(Resp::Respuesta(0,$rta));
                }
            }
            else{
                $rta ="Debe ingresar el token";
                 $response->getBody()->write(Resp::Respuesta(0,$rta));
            }
        }catch(Exception $e){
            $response->getBody()->write( Resp::Respuesta(-1,"Token invalido"));
        }
        
        return $response;
    }

}