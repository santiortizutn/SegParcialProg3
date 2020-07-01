<?php
namespace App\Utils;
class Resp
{
    public static function Respuesta($tipoid, $mensaje)
    {
        $status = "";
        $retorno =new \stdClass();
        switch ($tipoid) {
            case 1:
                $status = "Realizado:";
                break;
            case -1:
                $status = "Fallo:";
                break;
            case 0:
                $status = "Error:";
                break;
            default:
                break;
        }
        $retorno->status = $status;
        $retorno->message = $mensaje;
        return json_encode($retorno);
    }
}
