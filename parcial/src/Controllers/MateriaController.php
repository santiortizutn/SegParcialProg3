<?php


namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\Materia;
use App\Models\Usuario;
use App\Utils\Resp;
use App\Utils\AutentificadorJWT;
use Slim\Routing\RouteContext;

class MateriaController {


    public function getAll(Request $request, Response $response, $args)
    {
        $rta = json_encode(Materia::all());
        $response->getBody()->write($rta);

        return $response;
    }

    public function getId(Request $request, Response $response, $args)
    {
        $contenido = RouteContext::fromRequest($request);
        $ruta = $contenido->getRoute();
        $datoId = $ruta->getArgument('id');
        $data = new Usuario();
        
       
        $token =  $request->getHeader('token');
        $stringToken = $token[0]; 
        $data = AutentificadorJWT::ObtenerData($stringToken);
        if ($data->tipo_id == '1') {
            $materia =  Materia::find($datoId);
            $rta = json_encode($materia);
        }else {
            $materia =  Materia::find($datoId);
            $rta = json_encode($materia);
        }
        

        $response->getBody()->write($rta);

        return $response;
    }

    public function getIdProf(Request $request, Response $response, $args)
    {
        $contenido = RouteContext::fromRequest($request);
        $ruta = $contenido->getRoute();
        $datoId = $ruta->getArgument('id');
        $datoProf = $ruta->getArgument('profesor');
        $mat = new Materia;

        $ok = $mat->where('id', $datoId)->update(['profesor_id' => $datoProf]);

        if(!empty($ok)){

            $rta = Resp::Respuesta(1, "Materia actualizada." );
        }else {
            $rta = Resp::Respuesta(0, "Problema al actualizar." );
        }
        
       

        $response->getBody()->write($rta);

        return $response;
    }

    public function add(Request $request, Response $response, $args)
    {
        $array = $request->getParsedBody();
        $prof = new Usuario;
        $mat = new Materia;
        $mat->materia = $array['materia'];
        $mat->cuatrimestre = $array['cuatrimestre'];
        $mat->vacantes = $array['vacantes'];
        $mat->profesor_id = $array['profesor'];

        $valMate = $mat->where('materia', $mat->materia)->first();
        $valProf = $prof->where('id', $mat->profesor_id)
            ->where('tipo_id', '2')
            ->first();

        if(empty($valMate)){
            if(!empty($valProf)){
                $mat->save();
                $rta = Resp::Respuesta(1, "Materia registrada." );
            }else {
                $rta = Resp::Respuesta(0, "El Id de profesor no existe.");
            }
        }else{
          
            $rta = Resp::Respuesta(0, "Materia ya registrada.");
        }
        
        $response->getBody()->write($rta);
        return $response;
    }






}