<?php

namespace App\Controllers;

use Config\Services;

class Encripcion extends BaseController
{
    public static function encodeData($id)
    {
        // Instanciamos el Servicio Hashids
        $hashids = Services::hashids();

        // Codificar el ID recibido como parámetro
        $encoded = $hashids->encode($id);
		 return (string)$encoded;
    }

    public static function decodeData($encoded)
    {
        // Obtén una instancia de Hashids
        $hashids = Services::hashids();
		// Decodificar el ID codificado recibido como parámetro
		$decoded = implode('', $hashids->decode($encoded));
		return (string)$decoded;
    }
}
