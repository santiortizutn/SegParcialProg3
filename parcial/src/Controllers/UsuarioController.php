<?php


namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\Usuario;
use App\Utils\Resp;
use App\Utils\AutentificadorJWT;
use Slim\Routing\RouteContext;

class UsuarioController {


    public function getAll(Request $request, Response $response, $args)
    {
        $rta = json_encode(Usuario::all());
        $response->getBody()->write($rta);

        return $response;
    }

    public function getId(Request $request, Response $response, $args)
    {
        $contenido = RouteContext::fromRequest($request);
        $ruta = $contenido->getRoute();
        $datoId = $ruta->getArgument('id');

        $usuario =  Usuario::find($datoId);
       
        $rta = json_encode($usuario);

        $response->getBody()->write($rta);

        return $response;
    }

    public function add(Request $request, Response $response, $args)
    {
        $array = $request->getParsedBody();

        $user = new Usuario;
        $user->nombre = $array['nombre'];
        $user->email = $array['email'];
        $user->tipo_id = $array['tipo'];
        $user->legajo = $array['legajo'];
        $user->clave = password_hash( $array['clave'], PASSWORD_BCRYPT);

        $valMail = $user->where('email',$user->email)->first();
        $valLeg = $user->where('legajo',$user->legajo)->first();
        if(empty($valMail)){
            if(empty($valLeg)){
                if($user->legajo >= 1000 && $user->legajo <= 2000){
                    if($user->tipo_id == '1' || $user->tipo_id =='2' || $user->tipo_id =='3'){
                        $user->save();
                        $rta = Resp::Respuesta(1, "Usuario ". $user->nombre ." registrado" );
                    }else {
                        $rta = Resp::Respuesta(0, "Tipo de usuario incorrecto.");
                    }
                }else {
                    $rta = Resp::Respuesta(0, "Legajo invalido (debe ser mayor a 1000 y menor que 2000).");
                }
                
            }else {
                $rta = Resp::Respuesta(0, "Legajo ya registrado.");
            }    
        }else{
          
            $rta = Resp::Respuesta(0, "Correo ya registrado.");
        }
        
        $response->getBody()->write($rta);
        return $response;
    }


    public function login(Request $request, Response $response, $args)
    {
        $req = $request->getParsedBody();
        $user = new Usuario();
        $user->email = $req['email'];
        $datoClave = $req['clave'];

        $select = $user->where('email',$user->email)->first();

        if(!empty($select)){
            $hasheo = $select->clave;
            if(password_verify($datoClave, $hasheo)){
                $obj = new Usuario();

                $obj->id = $select->id;
                $obj->email = $select->email;
                $obj->tipo_id = $select->tipo_id;
                $obj->nombre = $select->nombre;
                $obj->legajo = $select->legajo;
                $obj->clave = $select->clave;

                $rta = Resp::Respuesta(1, "Token: ". AutentificadorJWT::CrearToken($obj));

            }else{
                $rta = Resp::Respuesta(0, "Clave incorrecta.");
            }

        }
        else{
            $rta = Resp::Respuesta(0, "Correo no registrado.");
        }


        $response->getBody()->write($rta);

        return $response;
    }





















}