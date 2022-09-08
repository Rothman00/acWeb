<?php

function datosGet($url)
{
    $opciones = array('http' =>
        array(
            'method'  => 'GET',
            'header'  => array(
                'Content-type: application/x-www-form-urlencoded',
                'Authorization: rapidito-int;N4RaVsn|&BaXLTIk]1',
            ),
            'timeout' => 96000
        )
    );
    $contexto = stream_context_create($opciones);
    $resultado = file_get_contents($url, false, $contexto);
    $resultado=json_decode($resultado,true);
    return $resultado;
}

