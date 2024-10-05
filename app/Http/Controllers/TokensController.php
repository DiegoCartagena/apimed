<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

class TokensController extends Controller
{
    
    public function __construct()
    {
        $this->secret = env('JWT_SECRET');
        
    }

   public function base64UrlEncode($data) {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }
    
    public function generateJwt($header, $payload) {
        // Codificar el header y el payload
        $base64UrlHeader = $this->base64UrlEncode(json_encode($header));
        $base64UrlPayload = $this->base64UrlEncode(json_encode($payload));
    
        // Crear la firma
        $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, $this->secret, true);
        $base64UrlSignature = $this->base64UrlEncode($signature);
    
        // Generar el JWT
        $jwt = $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;
        
        // Limitar el token a 100 caracteres
       /* if (strlen($jwt) > 100) {
            $jwt = substr($jwt, 0, 100);
        }*/
        
        return $jwt;
    }
    public function verifyJwt($jwt) {
        // Separar las partes del JWT
        $parts = explode('.', $jwt);
        if(count($parts) !== 3) {
            return false; // Token inválido
        }
    
        // Codificar header y payload
        $base64UrlHeader = $parts[0];
        $base64UrlPayload = $parts[1];
        $signatureProvided = $parts[2];
    //var_dump(rtrim(strtr(base64_decode($parts[2]), '+/', '-_'), '='));
        // Volver a generar la firma
        $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, $this->secret, true);
        $base64UrlSignature = $this->base64UrlEncode($signature);
    
        // Verificar si las firmas coinciden
        return hash_equals($base64UrlSignature, $signatureProvided);
    }
    
  
    

    
    
  
}

