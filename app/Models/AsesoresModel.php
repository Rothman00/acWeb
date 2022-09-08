<?php namespace App\Models;

use CodeIgniter\Model;

class AsesoresModel extends Model
{
    protected $base;
    
    public function __construct()
    {
        $this->base = "https://megaprofer.serviciosrapidito.com/ac";   
        //$this->base = "http://localhost/ac";
    }

    public function postEnvio($url, $datos)
    {
        $json = json_encode($datos);
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->base.$url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $json,
            CURLOPT_HTTPHEADER => array(
              'Accept: application/json',
              'Content-Type: application/json',
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response);
    }

    public function postSinEnvio($url)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->base.$url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_HTTPHEADER => array(
              'Accept: application/json',
              'Content-Type: application/json',
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response);
    }

    public function autenticacion($usuario,$contra)
    {
        $url = $this->base."/gestion/login";
        $ConstructorJson = array(
            "USU_USUARIO" => $usuario,
            "USU_PASSWORD" => $contra
        );
        return $this->postEnvio($url,$ConstructorJson);
    }

    public function autenticacion1($usuario,$contra)
    {
        $url = $this->base."/gestion/auth";
        $ConstructorJson = array(
            "USU_USUARIO" => $usuario,
            "USU_PASSWORD" => $contra
        );
        return $this->postEnvio($url,$ConstructorJson);
    }

    public function usuario($refe)
    {
        $url = $this->base."/gestion/su";
        $ConstructorJson = array(
            "USU_REFERENCIA" => $refe
        );
        return $this->postEnvio($url,$ConstructorJson);
    }

    public function usuarios()
    {
        $url = $this->base."/gestion/sus";
        return $this->postSinEnvio($url);
    }

    public function clientes()
    {
        $url = $this->base."/gestion/sc";
        return $this->postSinEnvio($url);
    }

    public function updateCliente($json)
    {
        $url = $this->base."/gestion/uc";
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $json,
            CURLOPT_HTTPHEADER => array(
              'Accept: application/json',
              'Content-Type: application/json',
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response);
    }

    public function deleteCliente($json)
    {
        $url = $this->base."/gestion/dc";
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $json,
            CURLOPT_HTTPHEADER => array(
              'Accept: application/json',
              'Content-Type: application/json',
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response);
    }

    public function selectUsuarioCliente($json)
    {
        $url = $this->base."/gestion/scu";
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $json,
            CURLOPT_HTTPHEADER => array(
              'Accept: application/json',
              'Content-Type: application/json',
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response);
    }

    public function insertTarea($json)
    {
        $url = $this->base."/gestion/itareas";
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $json,
            CURLOPT_HTTPHEADER => array(
              'Accept: application/json',
              'Content-Type: application/json',
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response);
    }

    public function insertCliente($json)
    {
        $url = $this->base."/gestion/ic";
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $json,
            CURLOPT_HTTPHEADER => array(
              'Accept: application/json',
              'Content-Type: application/json',
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response);
    }

    public function insertRo($json)
    {
        $url = $this->base."/gestion/insRol";
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $json,
            CURLOPT_HTTPHEADER => array(
              'Accept: application/json',
              'Content-Type: application/json',
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response);
    }

    public function insertRuta($json)
    {
        $url = $this->base."/gestion/insRut";
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $json,
            CURLOPT_HTTPHEADER => array(
              'Accept: application/json',
              'Content-Type: application/json',
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response);
    }
    
    public function rutas($json)
    {
        $url = $this->base."/gestion/r";
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $json,
            CURLOPT_HTTPHEADER => array(
              'Accept: application/json',
              'Content-Type: application/json',
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response);
    }
    
    private function promo()
    {
        $url = $this->base."/gestion/promo";
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_HTTPHEADER => array(
              'Accept: application/json',
              'Content-Type: application/json',
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response);
    }

    public function cargaData($url, $tipo)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => $tipo,
            CURLOPT_HTTPHEADER => array(
              'Accept: application/json',
              'Content-Type: application/json',
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response);
    }

    public function selectRutas()
    {
        $url = $this->base."/gestion/sr";
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_HTTPHEADER => array(
              'Accept: application/json',
              'Content-Type: application/json',
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response);
    }

    public function selectRoles()
    {
        $url = $this->base."/gestion/srl";
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_HTTPHEADER => array(
              'Accept: application/json',
              'Content-Type: application/json',
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response);
    }

    public function promociones()
    {
        $resp=$this->promo();
        $activas=[];
        $inactivas=[];
        foreach ($resp as $key => $value) {
            $hora = date("H:i:00");
            $fecha = date("d-m-Y");
            $actual = strtotime($fecha." ".$hora);
            $desde = strtotime($value->PRM_FECHAD." ".$hora);
            $hasta = strtotime($value->PRM_FECHAH." ".$hora);
            if($desde<=$actual && $hasta>=$actual && $value->PRM_ESTADO){
                array_push($activas,$value);
            }else{
                array_push($inactivas,$value);
            }
        }
        return ["activo"=> $activas,"inactivo"=>$inactivas];
    }

    public function actividadesAsesores()
    {
        $url = $this->base."/gestion/usuSema";
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_HTTPHEADER => array(
              'Accept: application/json',
              'Content-Type: application/json',
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response);
    }

    public function insertPlanCom($json)
    {
        ini_set('max_execution_time', 216000);
        $url = $this->base."/gestion/ipc";
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $json,
            CURLOPT_HTTPHEADER => array(
              'Accept: application/json',
              'Content-Type: application/json',
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response);
    }

    public function rol($json)
    {
        $url = $this->base."/gestion/srol";
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $json,
            CURLOPT_HTTPHEADER => array(
              'Accept: application/json',
              'Content-Type: application/json',
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response);
    }

    public function insertPriv($json)
    {
        $url = $this->base."/gestion/ipriv";
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $json,
            CURLOPT_HTTPHEADER => array(
              'Accept: application/json',
              'Content-Type: application/json',
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response);
    }

    public function catalogo()
    {
        $url = $this->base."/gestion/catalogo";
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
              'Accept: application/json',
              'Content-Type: application/json',
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response);
    }

    public function reporteV()
    {
        $url = $this->base."/gestion/sventas";
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_HTTPHEADER => array(
              'Accept: application/json',
              'Content-Type: application/json',
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response);
    }
    
    public function actualizarCat(){
        $url = $this->base."/gestion/cat";
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
              'Accept: application/json',
              'Content-Type: application/json',
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response);
    }
}