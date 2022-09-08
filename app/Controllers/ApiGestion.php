<?php
namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use \App\Models\GestionModel;
use Exception;

class ApiGestion extends ResourceController
{
    public function login()
    {
        $datos=$this->request->getJSON();
        if(!isset($datos->USU_USUARIO)){
            return $this->genericResponse(null,'USU_USUARIO NO EXISTE', 500);
        }
        if(!isset($datos->USU_PASSWORD)){
            return $this->genericResponse(null,'USU_PASSWORD NO EXISTE', 500);
        }
        if(!isset($datos->TIPO)){
            return $this->genericResponse(null,'TIPO NO EXISTE', 500);
        }
        $data=[
            "USU_USUARIO"=>$datos->USU_USUARIO,
            "USU_PASSWORD"=>$datos->USU_PASSWORD
        ];
        $model = new \App\Models\GestionModel();
        $resp=$model->login($data, $datos->TIPO);
        if($resp!=[]){
            return $this->responseDirecto([true, $resp[0]]);
        }else{
            $url = "https://api.megaprofer.com/back/login";
            $ConstructorJson = array(
                "username" => $datos->USU_USUARIO,
                "password" => $datos->USU_PASSWORD
            );
            $json = json_encode($ConstructorJson);
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
            $resp=json_decode($response);
            if($resp==NULL){
                return $this->responseDirecto([false, -1]);
            }
            return $this->responseDirecto([true, $resp->referenceId]);
            /* $seccion=explode('.', $resp->token);
            $base = base64_decode($seccion[1]);
            $jwt=json_decode($base);
            return $this->responseDirecto([true, $jwt->userId]); */
        }
    }

    public function sUsuario()
    {
        $datos=$this->request->getJSON();
        if(!isset($datos->USU_REFERENCIA)){
            return $this->genericResponse(null,'USU_REFERENCIA NO EXISTE', 500);
        }
        $model=new GestionModel();
        return $this->responseDirecto($model->sUsuario($datos->USU_REFERENCIA));
    }

    public function selectRutas()
    {
        $datos=$this->request->getJSON();
        if(!isset($datos->USU_REFERENCIA)){
            return $this->genericResponse(null,'USU_REFERENCIA NO EXISTE', 500);
        }
        $model = new \App\Models\GestionModel();
        return $this->responseDirecto($model->selectRutas($datos->USU_REFERENCIA));
    }

    public function insertCliente()
    {
        $datos=$this->request->getJSON();
        if(!isset($datos->USU_ID)){
            return $this->genericResponse(null,'USU_ID NO EXISTE', 500);
        }
        if(!isset($datos->CLI_CODIGO)){
            return $this->genericResponse(null,'CLI_CODIGO NO EXISTE', 500);
        }
        if(!isset($datos->CLI_CODIGOID)){
          return $this->genericResponse(null,'CLI_CODIGOID NO EXISTE', 500);
        }
        if(!isset($datos->CLI_NOMBRE)){
            return $this->genericResponse(null,'CLI_NOMBRE NO EXISTE', 500);
        }
        if(!isset($datos->CLI_DIRECCION)){
            return $this->genericResponse(null,'CLI_DIRECCION NO EXISTE', 500);
        }
        if(!isset($datos->CLI_EMAIL)){
            return $this->genericResponse(null,'CLI_EMAIL NO EXISTE', 500);
        }
        if(!isset($datos->CLI_FOTO)){
            return $this->genericResponse(null,'CLI_FOTO NO EXISTE', 500);
        }
        if(!isset($datos->CLI_MOBIL)){
            return $this->genericResponse(null,'CLI_MOBIL NO EXISTE', 500);
        }
        if(!isset($datos->CLI_TELEFONO)){
            return $this->genericResponse(null,'CLI_TELEFONO NO EXISTE', 500);
        }
        if(!isset($datos->CLI_HORAD)){
            return $this->genericResponse(null,'CLI_HORAD NO EXISTE', 500);
        }
        if(!isset($datos->CLI_HORAH)){
            return $this->genericResponse(null,'CLI_HORAH NO EXISTE', 500);
        }
        if(!isset($datos->CLI_LAT)){
            return $this->genericResponse(null,'CLI_LAT NO EXISTE', 500);
        }
        if(!isset($datos->CLI_LON)){
            return $this->genericResponse(null,'CLI_LON NO EXISTE', 500);
        }
        $model=new \App\Models\GestionModel();
        $data=[
            "CLI_CODIGO"=> $datos->CLI_CODIGO,
            "CLI_CODIGOID"=> $datos->CLI_CODIGOID,
            "CLI_DIRECCION"=> $datos->CLI_DIRECCION,
            "CLI_EMAIL"=>$datos->CLI_EMAIL,
            "CLI_ESTADO"=> true,
            "CLI_FOTO"=> $datos->CLI_FOTO,
            "CLI_HORAD"=> $datos->CLI_HORAD,
            "CLI_HORAH"=> $datos->CLI_HORAH,
            "CLI_LAT"=> $datos->CLI_LAT,
            "CLI_LON"=> $datos->CLI_LON,
            "CLI_MOBIL"=> $datos->CLI_MOBIL,
            "CLI_NOMBRE"=> $datos->CLI_NOMBRE,
            "CLI_TELEFONO"=> $datos->CLI_TELEFONO

        ];
        $resp=$model->insertCliente($data, $datos->CLI_CODIGOID, $datos->USU_ID);
        $data2=[
            "STO_ASIGNADO"=>0,
            "STO_DISPONIBLE"=>0,
            "STO_ESTADO"=>true
        ];
        $resp=$model->insertStock($data2, $datos->CLI_CODIGOID);
        return $this->genericResponse($resp,'',200);
    }

    public function updateCliente()
    {
        $datos=$this->request->getJSON();
        if(!isset($datos->CLI_ID)){
            return $this->genericResponse(null,'CLI_ID NO EXISTE', 500);
        }
        if(!isset($datos->CLI_CODIGO)){
            return $this->genericResponse(null,'CLI_CODIGO NO EXISTE', 500);
        }
        if(!isset($datos->CLI_CODIGOID)){
          return $this->genericResponse(null,'CLI_CODIGOID NO EXISTE', 500);
        }
        if(!isset($datos->CLI_NOMBRE)){
            return $this->genericResponse(null,'CLI_NOMBRE NO EXISTE', 500);
        }
        if(!isset($datos->CLI_DIRECCION)){
            return $this->genericResponse(null,'CLI_DIRECCION NO EXISTE', 500);
        }
        if(!isset($datos->CLI_EMAIL)){
            return $this->genericResponse(null,'CLI_EMAIL NO EXISTE', 500);
        }
        if(!isset($datos->CLI_FOTO)){
            return $this->genericResponse(null,'CLI_FOTO NO EXISTE', 500);
        }
        if(!isset($datos->CLI_MOBIL)){
            return $this->genericResponse(null,'CLI_MOBIL NO EXISTE', 500);
        }
        if(!isset($datos->CLI_TELEFONO)){
            return $this->genericResponse(null,'CLI_TELEFONO NO EXISTE', 500);
        }
        if(!isset($datos->CLI_HORAD)){
            return $this->genericResponse(null,'CLI_HORAD NO EXISTE', 500);
        }
        if(!isset($datos->CLI_HORAH)){
            return $this->genericResponse(null,'CLI_HORAH NO EXISTE', 500);
        }
        if(!isset($datos->CLI_LAT)){
            return $this->genericResponse(null,'CLI_LAT NO EXISTE', 500);
        }
        if(!isset($datos->CLI_LON)){
            return $this->genericResponse(null,'CLI_LON NO EXISTE', 500);
        }
        $data=[
            "CLI_CODIGO"=> $datos->CLI_CODIGO,
            "CLI_CODIGOID"=> $datos->CLI_CODIGOID,
            "CLI_NOMBRE"=> $datos->CLI_NOMBRE,
            "CLI_DIRECCION"=> $datos->CLI_DIRECCION,
            "CLI_EMAIL"=> $datos->CLI_EMAIL,
            "CLI_MOBIL"=> $datos->CLI_MOBIL,
            "CLI_TELEFONO"=> $datos->CLI_TELEFONO,
            "CLI_FOTO"=> $datos->CLI_FOTO,
            "CLI_HORAD"=> $datos->CLI_HORAD,
            "CLI_HORAH"=> $datos->CLI_HORAH,
            "CLI_LAT"=> $datos->CLI_LAT,
            "CLI_LON"=> $datos->CLI_LON,
            "CLI_ESTADO"=> true
        ];
        $model=new \App\Models\GestionModel();
        $resp=$model->updateCliente($data, $datos->CLI_ID);
        return $this->genericResponse($resp,'',200);
    }

    public function deleteCliente()
    {
        $datos=$this->request->getJSON();
        if(!isset($datos->CLI_ID)){
            return $this->genericResponse(null,'CLI_ID NO EXISTE', 500);
        }
        $model=new \App\Models\GestionModel();
        $resp=$model->deleteCliente($datos->CLI_ID);
        return $this->genericResponse('ELIMINADO CORRECTO '.$datos->CLI_ID,'',200);
    }

    public function insertTareas()
    {
        $datos=$this->request->getJSON();
        if(!isset($datos->CLI_CODIGOID)){
            return $this->genericResponse(null,'CLI_CODIGOID NO EXISTE', 500);
        }
        if(!isset($datos->TAR_COBRAR)){
            return $this->genericResponse(null,'TAR_COBRAR NO EXISTE', 500);
        }
        if(!isset($datos->TAR_VENDER)){
            return $this->genericResponse(null,'TAR_VENDER NO EXISTE', 500);
        }
        if(!isset($datos->TAR_OTROS)){
            return $this->genericResponse(null,'TAR_OTROS NO EXISTE', 500);
        }
        if(!isset($datos->TAR_FECHA)){
            return $this->genericResponse(null,'TAR_FECHA NO EXISTE', 500);
        }
        if(!isset($datos->TAR_DETALLE)){
            return $this->genericResponse(null,'TAR_DETALLE NO EXISTE', 500);
        }
        $model=new \App\Models\GestionModel();
        $idNuevo=$model->ultimoId('tbl_tarea', 'TAR_ID');
        $data=[
            "TAR_ID"=> $idNuevo,
            "CLI_CODIGOID"=> $datos->CLI_CODIGOID,
            "PRO_ID"=> -1,
            "TAR_COBRAR"=> $datos->TAR_COBRAR,
            "TAR_VENDER"=> $datos->TAR_VENDER,
            "TAR_OTROS"=> $datos->TAR_OTROS,
            "TAR_FECHA"=> $datos->TAR_FECHA,
            "TAR_DETALLE"=> $datos->TAR_DETALLE,
            "TAR_ESTADO"=> 1

        ];
        $resp=$model->insertTareas($data, $idNuevo);
        return $this->genericResponse($resp,'',200);
    }
    
    public function selectPromo()
    {
        $model=new \App\Models\GestionModel();
        $resp=$model->sPromo();
        return $this->responseDirecto($resp);
    }

    public function selectRol()
    {
        $datos=$this->request->getJSON();
        if(!isset($datos->USU_REFERENCIA)){
            return $this->genericResponse(null,'USU_REFERENCIA NO EXISTE', 500);
        }
        $model = new \App\Models\GestionModel();
        return $this->responseDirecto($model->sRol($datos->USU_REFERENCIA));
    }

    public function selectRutasTotal()
    {
        $model=new \App\Models\GestionModel();
        $resp=$model->selectRuta();
        return $this->responseDirecto($resp);
    }

    public function selectRolTotal()
    {
        $model=new \App\Models\GestionModel();
        $resp=$model->selectRol();
        return $this->responseDirecto($resp);
    }

    public function insertRoles()
    {
        $datos=$this->request->getJSON();
        if(!isset($datos->ROL_NOMBRE)){
            return $this->genericResponse(null,'ROL_NOMBRE NO EXISTE', 500);
        }
        $model=new \App\Models\GestionModel();
        $idNuevo=$model->ultimoId('tbl_rol', 'ROL_ID');
        $data=[
            "ROL_ID"=> $idNuevo,
            "ROL_NOMBRE"=> $datos->ROL_NOMBRE,
            "ROL_ESTADO"=> true

        ];
        $resp=$model->insertRol($data, $idNuevo);
        return $this->genericResponse($resp,'',200);
    }

    public function insertPrivg()
    {
        $datos=$this->request->getJSON();
        if(!isset($datos->ROL_ID)){
            return $this->genericResponse(null,'ROL_ID NO EXISTE', 500);
        }
        if(!isset($datos->USU_REFERENCIA)){
            return $this->genericResponse(null,'USU_REFERENCIA NO EXISTE', 500);
        }
        $model=new \App\Models\GestionModel();
        $idNuevo=$model->ultimoId('tbl_rolusuarios/'.$datos->USU_REFERENCIA, 'ROU_ID');
        $data=[
            "ROU_ID"=>$idNuevo,
            "ROL_ID"=>$datos->ROL_ID,
            "ROU_ESTADO"=>true
        ];
        $resp=$model->insertPrivilegioN($data, $idNuevo, $datos->USU_REFERENCIA);
        return $this->genericResponse($resp,'',200);
    }

    public function insertRolRuta()
    {
        $datos=$this->request->getJSON();
        if(!isset($datos->RUT_ID)){
            return $this->genericResponse(null,'RUT_ID NO EXISTE', 500);
        }
        $model=new \App\Models\GestionModel();
        $idNuevo=$model->ultimoId('tbl_rolruta', 'ROR_ID');
        $idROL=$model->ultimoId('tbl_rol', 'ROL_ID')-1;
        $data=[
            "ROR_ID"=> $idNuevo,
            "RUT_ID"=> intval($datos->RUT_ID),
            "ROL_ID"=> $idROL,
            "ROR_ESTADO"=> true
        ];
        $resp=$model->insertRolRuta($data, $idNuevo);
        return $this->genericResponse($resp,'',200);
    }

    public function insertSemana()
    {
        $datos=$this->request->getJSON();
        if(!isset($datos->CLI_CODIGOID)){
            return $this->genericResponse(null,'CLI_CODIGOID NO EXISTE', 500);
        }
        if(!isset($datos->PRO_FECHA)){
            return $this->genericResponse(null,'PRO_FECHA NO EXISTE', 500);
        }
        if(!isset($datos->PRO_HORA)){
            return $this->genericResponse(null,'PRO_HORA NO EXISTE', 500);
        }
        if(!isset($datos->PRO_OBSERVACION)){
            return $this->genericResponse(null,'PRO_OBSERVACION NO EXISTE', 500);
        }
        if(!isset($datos->PRO_TIPO)){
            return $this->genericResponse(null,'PRO_TIPO NO EXISTE', 500);
        }
        $model=new \App\Models\GestionModel();
        $idNuevo=$model->idCount('tbl_programacion/'.$datos->PRO_FECHA.'/'.$datos->CLI_CODIGOID);
        $data=[
            "CLI_CODIGOID"=>$datos->CLI_CODIGOID,
            "PRO_ESTADO"=>1,
            "PRO_FECHA"=>$datos->PRO_FECHA,
            "PRO_HORA"=>$datos->PRO_HORA,
            "PRO_ID"=>$idNuevo,
            "PRO_OBSERVACION"=>$datos->PRO_OBSERVACION,
            "PRO_TIPO"=>$datos->PRO_TIPO
        ];
        $resp=$model->insertSemana($data, $datos->PRO_FECHA.'/'.$datos->CLI_CODIGOID.'/'.$idNuevo);
        return $this->genericResponse($resp,'',200);
    }

    public function insertSemanaTarea()
    {
        $datos=$this->request->getJSON();
        if(!isset($datos->TAR_ID)){
            return $this->genericResponse(null,'TAR_ID NO EXISTE', 500);
        }
        if(!isset($datos->CLI_CODIGOID)){
            return $this->genericResponse(null,'CLI_CODIGOID NO EXISTE', 500);
        }
        if(!isset($datos->PRO_FECHA)){
            return $this->genericResponse(null,'PRO_FECHA NO EXISTE', 500);
        }
        if(!isset($datos->PRO_HORA)){
            return $this->genericResponse(null,'PRO_HORA NO EXISTE', 500);
        }
        if(!isset($datos->PRO_OBSERVACION)){
            return $this->genericResponse(null,'PRO_OBSERVACION NO EXISTE', 500);
        }
        $model=new \App\Models\GestionModel();
        $idNuevo=$model->idCount('tbl_programacion/'.$datos->PRO_FECHA.'/'.$datos->CLI_CODIGOID);
        $data=[
            "CLI_CODIGOID"=>$datos->CLI_CODIGOID,
            "PRO_ESTADO"=>1,
            "PRO_FECHA"=>$datos->PRO_FECHA,
            "PRO_HORA"=>$datos->PRO_HORA,
            "PRO_ID"=>$idNuevo,
            "PRO_OBSERVACION"=>$datos->PRO_OBSERVACION,
            "PRO_TIPO"=>0
        ];
        $resp=$model->insertSemanaTareas($data, $datos->PRO_FECHA.'/'.$datos->CLI_CODIGOID.'/'.$idNuevo,$idNuevo, $datos->TAR_ID);
        return $this->genericResponse($resp,'',200);
    }

    public function insertVisitado()
    {
        $datos=$this->request->getJSON();
        if(!isset($datos->CLI_CODIGOID)){
            return $this->genericResponse(null,'CLI_CODIGOID NO EXISTE', 500);
        }
        if(!isset($datos->PRO_ID)){
            return $this->genericResponse(null,'PRO_ID NO EXISTE', 500);
        }
        if(!isset($datos->PRO_FECHA)){
            return $this->genericResponse(null,'PRO_FECHA NO EXISTE', 500);
        }
        if(!isset($datos->VIS_VENTA)){
            return $this->genericResponse(null,'VIS_VENTA NO EXISTE', 500);
        }
        if(!isset($datos->VIS_COBRANZA)){
            return $this->genericResponse(null,'VIS_COBRANZA NO EXISTE', 500);
        }
        if(!isset($datos->VIS_OTROS)){
            return $this->genericResponse(null,'VIS_OTROS NO EXISTE', 500);
        }
        if(!isset($datos->VIS_OBSERVACION)){
            return $this->genericResponse(null,'VIS_OBSERVACION NO EXISTE', 500);
        }
        if(!isset($datos->VIS_LAT)){
            return $this->genericResponse(null,'VIS_LAT NO EXISTE', 500);
        }
        if(!isset($datos->VIS_LON)){
            return $this->genericResponse(null,'VIS_LON NO EXISTE', 500);
        }
        $model=new \App\Models\GestionModel();
        $idNuevo=$model->idCount('tbl_visitados/'.$datos->PRO_FECHA.'/'.$datos->CLI_CODIGOID);
        $data=[
            "PRO_ID"=>$datos->PRO_ID,
            "VIS_COBRANZA"=>$datos->VIS_COBRANZA,
            "VIS_ESTADO"=>1,
            "VIS_ID"=>$idNuevo,
            "VIS_LAT"=>$datos->VIS_LAT,
            "VIS_LON"=>$datos->VIS_LON,
            "VIS_OBSERVACION"=>$datos->VIS_OBSERVACION,
            "VIS_OTROS"=>$datos->VIS_OTROS,
            "VIS_VENTA"=>$datos->VIS_VENTA
        ];
        $resp=$model->insertVisitado($data, $datos->PRO_FECHA.'/'.$datos->CLI_CODIGOID.'/', $idNuevo, $datos->PRO_ID);
        return $this->genericResponse($resp,'',200);
    }






































    public function index()
    {
        $datos=$this->request->getJSON();
        $model = new \App\Models\GestionModel();
        if(!isset($datos->USU_USUARIO)){
            return $this->genericResponse(null,'USU_USUARIO NO EXISTE', 500);
        }
        if(!isset($datos->USU_PASSWORD)){
            return $this->genericResponse(null,'USU_PASSWORD NO EXISTE', 500);
        }
        $data=[
            "USU_USUARIO"=>$datos->USU_USUARIO,
            "USU_PASSWORD"=>$datos->USU_PASSWORD
        ];
        $usuario=$model->selectUsuario($data);
        $clientes=$model->selectClientes($usuario["USU_ID"]);
        $comercio=[];
        $semana=[];
        $stock=[];
        $tareas=[];
        $visitado=[];
        foreach ($clientes as $cli => $c) {
            $co=$model->selectComercial($c['USC_ID']);
            $se=$model->selectSemana($c['USC_ID']);
            $st=$model->selectStock($c['USC_ID']);
            $ta=$model->selectTareas($c['USC_ID']);
            $vi=$model->selectVisitado($c['USC_ID']);
            $comercio+=[$c['USC_ID']=>$co];      
            $semana+=[$c['USC_ID']=>$se];
            $stock+=[$c['USC_ID']=>$st];
            $tareas+=[$c['USC_ID']=>$ta];
            $visitado+=[$c['USC_ID']=>$vi];
        }
        $datosFull=[
            "usuario"=>$usuario,
            "clientes"=>$clientes,
            "stock"=>$stock,
            "semana"=>$semana,
            "comercial"=>$comercio,
            "tareas"=>$tareas,
            "visitado"=>$visitado
        ];
        return $this->responseDirecto($datosFull);
    }
    
    public function selectUsuario()
    {
        $datos=$this->request->getJSON();
        $model = new \App\Models\GestionModel();
        if(!isset($datos->USU_USUARIO)){
            return $this->genericResponse(null,'USU_USUARIO NO EXISTE', 500);
        }
        if(!isset($datos->USU_PASSWORD)){
            return $this->genericResponse(null,'USU_PASSWORD NO EXISTE', 500);
        }
        $data=[
            "USU_USUARIO"=>$datos->USU_USUARIO,
            "USU_PASSWORD"=>$datos->USU_PASSWORD
        ];
        $usuario=$model->selectUsuario($data);
        $datosFull=[
            "usuario"=>$usuario
        ];
        return $this->responseDirecto($datosFull);
    }

    public function sUsuarios()
    {
        $model=new \App\Models\GestionModel();
        return $this->responseDirecto($model->sUsuarios());
    }

    public function selectClientes()
    {
        $datos=$this->request->getJSON();
        $model = new \App\Models\GestionModel();
        if(!isset($datos->USU_USUARIO)){
            return $this->genericResponse(null,'USU_USUARIO NO EXISTE', 500);
        }
        if(!isset($datos->USU_PASSWORD)){
            return $this->genericResponse(null,'USU_PASSWORD NO EXISTE', 500);
        }
        $data=[
            "USU_USUARIO"=>$datos->USU_USUARIO,
            "USU_PASSWORD"=>$datos->USU_PASSWORD
        ];
        $usuario=$model->selectUsuario($data);
        $clientes=$model->selectClientes($usuario["USU_ID"]);
        $datosFull=[
            "clientes"=>$clientes,
        ];
        return $this->responseDirecto($datosFull);
    }

    public function sClientes()
    {
        $model=new \App\Models\GestionModel();
        return $this->responseDirecto($model->sClientes());
    }

    public function sClientesU()
    {
        $datos=$this->request->getJSON();
        if(!isset($datos->CLI_ID)){
            return $this->genericResponse(null,'CLI_ID NO EXISTE', 500);
        }
        if(!isset($datos->USU_ID)){
            return $this->genericResponse(null,'USU_ID NO EXISTE', 500);
        }
        $model=new \App\Models\GestionModel();
        if($datos->USU_ID!="-1"){
            return $this->responseDirecto($model->sUsuarioClientes($datos->USU_ID));
        }else{
            return $this->responseDirecto($model->sClienteUsuario($datos->CLI_ID));
        }
    }

    public function selectComercial()
    {
        $datos=$this->request->getJSON();
        $model = new \App\Models\GestionModel();
        if(!isset($datos->USU_USUARIO)){
            return $this->genericResponse(null,'USU_USUARIO NO EXISTE', 500);
        }
        if(!isset($datos->USU_PASSWORD)){
            return $this->genericResponse(null,'USU_PASSWORD NO EXISTE', 500);
        }
        $data=[
            "USU_USUARIO"=>$datos->USU_USUARIO,
            "USU_PASSWORD"=>$datos->USU_PASSWORD
        ];
        $usuario=$model->selectUsuario($data);
        $clientes=$model->selectClientes($usuario["USU_ID"]);
        $comercio=[];
        foreach ($clientes as $cli => $c) {
            $co=$model->selectComercial($c['USC_ID']);
            $comercio+=[$c['USC_ID']=>$co];
        }
        $datosFull=[
            "comercial"=>$comercio
        ];
        return $this->responseDirecto($datosFull);
    }

    public function selectSemana()
    {
        $datos=$this->request->getJSON();
        $model = new \App\Models\GestionModel();
        if(!isset($datos->USU_USUARIO)){
            return $this->genericResponse(null,'USU_USUARIO NO EXISTE', 500);
        }
        if(!isset($datos->USU_PASSWORD)){
            return $this->genericResponse(null,'USU_PASSWORD NO EXISTE', 500);
        }
        $data=[
            "USU_USUARIO"=>$datos->USU_USUARIO,
            "USU_PASSWORD"=>$datos->USU_PASSWORD
        ];
        $usuario=$model->selectUsuario($data);
        $clientes=$model->selectClientes($usuario["USU_ID"]);
        $semana=[];
        foreach ($clientes as $cli => $c) {
            $se=$model->selectSemana($c['USC_ID']);      
            $semana+=[$c['USC_ID']=>$se];
        }
        $datosFull=[
            "semana"=>$semana
        ];
        return $this->responseDirecto($datosFull);
    }

    public function selectStock()
    {
        $datos=$this->request->getJSON();
        $model = new \App\Models\GestionModel();
        if(!isset($datos->USU_USUARIO)){
            return $this->genericResponse(null,'USU_USUARIO NO EXISTE', 500);
        }
        if(!isset($datos->USU_PASSWORD)){
            return $this->genericResponse(null,'USU_PASSWORD NO EXISTE', 500);
        }
        $data=[
            "USU_USUARIO"=>$datos->USU_USUARIO,
            "USU_PASSWORD"=>$datos->USU_PASSWORD
        ];
        $usuario=$model->selectUsuario($data);
        $clientes=$model->selectClientes($usuario["USU_ID"]);
        $stock=[];
        foreach ($clientes as $cli => $c) {
            $st=$model->selectStock($c['USC_ID']);
            $stock+=[$c['USC_ID']=>$st];
        }
        $datosFull=[
            "stock"=>$stock    
        ];
        return $this->responseDirecto($datosFull);
    }

    public function selectTareas()
    {
        $datos=$this->request->getJSON();
        $model = new \App\Models\GestionModel();
        if(!isset($datos->USU_USUARIO)){
            return $this->genericResponse(null,'USU_USUARIO NO EXISTE', 500);
        }
        if(!isset($datos->USU_PASSWORD)){
            return $this->genericResponse(null,'USU_PASSWORD NO EXISTE', 500);
        }
        $data=[
            "USU_USUARIO"=>$datos->USU_USUARIO,
            "USU_PASSWORD"=>$datos->USU_PASSWORD
        ];
        $usuario=$model->selectUsuario($data);
        $clientes=$model->selectClientes($usuario["USU_ID"]);
        $tareas=[];
        foreach ($clientes as $cli => $c) {
            $ta=$model->selectTareas($c['USC_ID']);
            $tareas+=[$c['USC_ID']=>$ta];
        }
        $datosFull=[
            "tareas"=>$tareas
        ];
        return $this->responseDirecto($datosFull);
    }

    public function selectVisitados()
    {
        $datos=$this->request->getJSON();
        $model = new \App\Models\GestionModel();
        if(!isset($datos->USU_USUARIO)){
            return $this->genericResponse(null,'USU_USUARIO NO EXISTE', 500);
        }
        if(!isset($datos->USU_PASSWORD)){
            return $this->genericResponse(null,'USU_PASSWORD NO EXISTE', 500);
        }
        $data=[
            "USU_USUARIO"=>$datos->USU_USUARIO,
            "USU_PASSWORD"=>$datos->USU_PASSWORD
        ];
        $usuario=$model->selectUsuario($data);
        $clientes=$model->selectClientes($usuario["USU_ID"]);
        $visitado=[];
        foreach ($clientes as $cli => $c) {
            $vi=$model->selectVisitado($c['USC_ID']);
            $visitado+=[$c['USC_ID']=>$vi];
        }
        $datosFull=[
            "visitado"=>$visitado
        ];
        return $this->responseDirecto($datosFull);
    }

    public function insertAsesores()
    {
        $datos=$this->request->getJSON();
        if(!isset($datos->ASE_NOMBRES)){
            return $this->genericResponse(null,'ASE_NOMBRES NO EXISTE', 500);
        }
        if(!isset($datos->ASE_PROVINCIA)){
            return $this->genericResponse(null,'ASE_PROVINCIA NO EXISTE', 500);
        }
        if(!isset($datos->ASE_ZONA)){
            return $this->genericResponse(null,'ASE_ZONA NO EXISTE', 500);
        }
        $model=new \App\Models\GestionModel();
        $idNuevo=$model->ultimoId('tbl_asesores', 'ASE_ID');
        $data=[
            "ASE_ID"=>$idNuevo,
            "ASE_NOMBRES"=>$datos->ASE_NOMBRES,
            "ASE_PROVINCIA"=>$datos->ASE_PROVINCIA,
            "ASE_ZONA"=>$datos->ASE_ZONA,
            "ASE_ESTADO"=>1
        ];
        $resp=$model->insertAsesores($data, $idNuevo);
        return $this->genericResponse($resp,'',200);
    }

    public function insertCatalogo()
    {
        $datos=$this->request->getJSON();
        if(!isset($datos->CAT_CODIGO)){
            return $this->genericResponse(null,'CAT_CODIGO NO EXISTE', 500);
        }
        if(!isset($datos->CAT_NOMBRE)){
            return $this->genericResponse(null,'CAT_NOMBRE NO EXISTE', 500);
        }
        if(!isset($datos->CAT_DESCRIPCION)){
            return $this->genericResponse(null,'CAT_DESCRIPCION NO EXISTE', 500);
        }
        if(!isset($datos->CAT_PRECIOA)){  //Precio_lista
            return $this->genericResponse(null,'CAT_PRECIOA NO EXISTE', 500);
        }
        if(!isset($datos->CAT_PRECIOB)){  //Precio_asesores
            return $this->genericResponse(null,'CAT_PRECIOB NO EXISTE', 500);
        }
        if(!isset($datos->CAT_PRECIOC)){  //Precio_comercial
            return $this->genericResponse(null,'CAT_PRECIOC NO EXISTE', 500);
        }
        if(!isset($datos->CAT_PRECIOD)){  //Precio_jefatura
            return $this->genericResponse(null,'CAT_PRECIOD NO EXISTE', 500);
        }
        if(!isset($datos->CAT_PRECIOE)){  //Precio_mejores_precios
            return $this->genericResponse(null,'CAT_PRECIOE NO EXISTE', 500);
        }
        if(!isset($datos->CAT_PRECIOF)){  //Precio_autorizado
            return $this->genericResponse(null,'CAT_PRECIOF NO EXISTE', 500);
        }
        if(!isset($datos->CAT_FECHA)){
            return $this->genericResponse(null,'CAT_FECHA NO EXISTE', 500);
        }
        $model=new \App\Models\GestionModel();
        $idNuevo=$model->ultimoId('tbl_catalogo', 'CAT_ID');
        $data=[
            "CAT_ID"=> $idNuevo,
            "CAT_CODIGO"=> $datos->CAT_CODIGO,
            "CAT_NOMBRE"=> $datos->CAT_NOMBRE,
            "CAT_DESCRIPCION"=> $datos->CAT_DESCRIPCION,
            "CAT_PRECIOA"=> $datos->CAT_PRECIOA,  //Precio_lista
            "CAT_PRECIOB"=> $datos->CAT_PRECIOB,  //Precio_asesores
            "CAT_PRECIOC"=> $datos->CAT_PRECIOC,  //Precio_comercial
            "CAT_PRECIOD"=> $datos->CAT_PRECIOD,  //Precio_jefatura
            "CAT_PRECIOE"=> $datos->CAT_PRECIOE,  //Precio_mejores_precios
            "CAT_PRECIOF"=> $datos->CAT_PRECIOF,  //Precio_autorizado
            "CAT_FECHA"=> $datos->CAT_FECHA,
            "CAT_ESTADO"=> 1
        ];
        $resp=$model->insertCatalogo($data, $idNuevo);
        return $this->genericResponse($resp,'',200);
    }

    public function selectCatalogo()
    {
        $model=new \App\Models\GestionModel();
        $resp=$model->selectCatalogo();
        return $this->responseDirecto($resp);
    }

    public function selectVentas()
    {
        $model=new \App\Models\GestionModel();
        $resp=$model->selectVentas();
        return $this->responseDirecto($resp);
    }

    public function selectSemanaUsuario()
    {
        $model=new \App\Models\GestionModel();
        $resp=$model->asesoresSemana();
        return $this->responseDirecto($resp);
    }

    public function insertarPlanComercial()
    {
		ini_set('max_execution_time', 216000);
        $datos=$this->request->getJSON();
        $resultados=(isset($datos[0])) ? $datos[0] : [];
        $clientes=(isset($datos[1])) ? $datos[1] : [];
        $model=new \App\Models\GestionModel();
        $data=[
            "A"=>(isset($resultados->A)) ? $resultados->A : "",
            "B"=>(isset($resultados->B)) ? $resultados->B : "",
            "C"=>(isset($resultados->C)) ? $resultados->C : "",
            "D"=>(isset($resultados->D)) ? $resultados->D : "",
            "E"=>(isset($resultados->E)) ? $resultados->E : "",
            "F"=>(isset($resultados->F)) ? $resultados->F : "",
            "G"=>(isset($resultados->G)) ? $resultados->G : "",
            "H"=>(isset($resultados->H)) ? $resultados->H : "",
            "I"=>(isset($resultados->I)) ? $resultados->I : "",
            "J"=>(isset($resultados->J)) ? $resultados->J : "",
            "K"=>(isset($resultados->K)) ? $resultados->K : "",
            "L"=>(isset($resultados->L)) ? $resultados->L : "",
            "M"=>(isset($resultados->M)) ? $resultados->M : "",
            "N"=>(isset($resultados->N)) ? $resultados->N : "",
            "O"=>(isset($resultados->O)) ? $resultados->O : "",
            "P"=>(isset($resultados->P)) ? $resultados->P : "",
            "Q"=>(isset($resultados->Q)) ? $resultados->Q : "",
            "R"=>(isset($resultados->R)) ? $resultados->R : "",
            "S"=>(isset($resultados->S)) ? $resultados->S : "",
            "T"=>(isset($resultados->T)) ? $resultados->T : "",
            "U"=>(isset($resultados->U)) ? $resultados->U : "",
            "V"=>(isset($resultados->V)) ? $resultados->V : "",
            "W"=>(isset($resultados->W)) ? $resultados->W : "",
            "X"=>(isset($resultados->X)) ? $resultados->X : "",
            "Y"=>(isset($resultados->Y)) ? $resultados->Y : "",
            "Z"=>(isset($resultados->Z)) ? $resultados->Z : "",
            "AA"=>(isset($resultados->AA)) ? $resultados->AA : "",
            "AB"=>(isset($resultados->AB)) ? $resultados->AB : "",
            "AC"=>(isset($resultados->AC)) ? $resultados->AC : "",
            "AD"=>(isset($resultados->AD)) ? $resultados->AD : "",
            "AE"=>(isset($resultados->AE)) ? $resultados->AE : "",
            "AF"=>(isset($resultados->AF)) ? $resultados->AF : "",
            "AG"=>(isset($resultados->AG)) ? $resultados->AG : "",
            "AH"=>(isset($resultados->AH)) ? $resultados->AH : "",
            "AI"=>(isset($resultados->AI)) ? $resultados->AI : "",
            "AJ"=>(isset($resultados->AJ)) ? $resultados->AJ : "",
            "AK"=>(isset($resultados->AK)) ? $resultados->AK : "",
            "AL"=>(isset($resultados->AL)) ? $resultados->AL : "",
            "AM"=>(isset($resultados->AM)) ? $resultados->AM : "",
            "AN"=>(isset($resultados->AN)) ? $resultados->AN : "",
            "AO"=>(isset($resultados->AO)) ? $resultados->AO : "",
            "AP"=>(isset($resultados->AP)) ? $resultados->AP : "",
            "AQ"=>(isset($resultados->AQ)) ? $resultados->AQ : "",
            "AR"=>(isset($resultados->AR)) ? $resultados->AR : "",
            "AS"=>(isset($resultados->AS)) ? $resultados->AS : "",
            "AT"=>(isset($resultados->AT)) ? $resultados->AT : "",
            "AU"=>(isset($resultados->AU)) ? $resultados->AU : "",
            "AV"=>(isset($resultados->AV)) ? $resultados->AV : "",
            "AW"=>(isset($resultados->AW)) ? $resultados->AW : "",
            "AX"=>(isset($resultados->AX)) ? $resultados->AX : "",
            "AY"=>(isset($resultados->AY)) ? $resultados->AY : "",
            "AZ"=>(isset($resultados->AZ)) ? $resultados->AZ : "",
            "BA"=>(isset($resultados->BA)) ? $resultados->BA : "",
            "BB"=>(isset($resultados->BB)) ? $resultados->BB : "",
            "BC"=>(isset($resultados->BC)) ? $resultados->BC : "",
            "BD"=>(isset($resultados->BD)) ? $resultados->BD : "",
            "BE"=>(isset($resultados->BE)) ? $resultados->BE : "",
            "BF"=>(isset($resultados->BF)) ? $resultados->BF : "",
            "BG"=>(isset($resultados->BG)) ? $resultados->BG : "",
            "BH"=>(isset($resultados->BH)) ? $resultados->BH : "",
            "BI"=>(isset($resultados->BI)) ? $resultados->BI : "",
            "BJ"=>(isset($resultados->BJ)) ? $resultados->BJ : "",
            "BK"=>(isset($resultados->BK)) ? $resultados->BK : "",
            "BL"=>(isset($resultados->BL)) ? $resultados->BL : "",
            "BM"=>(isset($resultados->BM)) ? $resultados->BM : "",
            "BN"=>(isset($resultados->BN)) ? $resultados->BN : "",
            "BO"=>(isset($resultados->BO)) ? $resultados->BO : "",
            "BP"=>(isset($resultados->BP)) ? $resultados->BP : "",
            "BQ"=>(isset($resultados->BQ)) ? $resultados->BQ : "",
            "BR"=>(isset($resultados->BR)) ? $resultados->BR : "",
            "BS"=>(isset($resultados->BS)) ? $resultados->BS : "",
            "BT"=>(isset($resultados->BT)) ? $resultados->BT : "",
            "BU"=>(isset($resultados->BU)) ? $resultados->BU : "",
            "BV"=>(isset($resultados->BV)) ? $resultados->BV : "",
            "BW"=>(isset($resultados->BW)) ? $resultados->BW : "",
            "BX"=>(isset($resultados->BX)) ? $resultados->BX : "",
            "BY"=>(isset($resultados->BY)) ? $resultados->BY : "",
            "BZ"=>(isset($resultados->BZ)) ? $resultados->BZ : "",
            "CA"=>(isset($resultados->CA)) ? $resultados->CA : "",
            "CB"=>(isset($resultados->CB)) ? $resultados->CB : "",
            "CC"=>(isset($resultados->CC)) ? $resultados->CC : "",
            "CD"=>(isset($resultados->CD)) ? $resultados->CD : "",
            "CE"=>(isset($resultados->CE)) ? $resultados->CE : "",
            "CF"=>(isset($resultados->CF)) ? $resultados->CF : "",
            "CG"=>(isset($resultados->CG)) ? $resultados->CG : "",
            "CH"=>(isset($resultados->CH)) ? $resultados->CH : "",
            "CI"=>(isset($resultados->CI)) ? $resultados->CI : "",
            "CJ"=>(isset($resultados->CJ)) ? $resultados->CJ : "",
            "CK"=>(isset($resultados->CK)) ? $resultados->CK : "",
            "CL"=>(isset($resultados->CL)) ? $resultados->CL : "",
            "CM"=>(isset($resultados->CM)) ? $resultados->CM : "",
            "CN"=>(isset($resultados->CN)) ? $resultados->CN : "",
            "CO"=>(isset($resultados->CO)) ? $resultados->CO : "",
            "CP"=>(isset($resultados->CP)) ? $resultados->CP : "",
            "CQ"=>(isset($resultados->CQ)) ? $resultados->CQ : "",
            "CR"=>(isset($resultados->CR)) ? $resultados->CR : "",
            "CS"=>(isset($resultados->CS)) ? $resultados->CS : "",
            "CT"=>(isset($resultados->CT)) ? $resultados->CT : "",
            "CU"=>(isset($resultados->CU)) ? $resultados->CU : "",
            "CV"=>(isset($resultados->CV)) ? $resultados->CV : "",
            "CW"=>(isset($resultados->CW)) ? $resultados->CW : "",
            "CX"=>(isset($resultados->CX)) ? $resultados->CX : "",
            "CY"=>(isset($resultados->CY)) ? $resultados->CY : "",
            "CZ"=>(isset($resultados->CZ)) ? $resultados->CZ : "",
            "DA"=>(isset($resultados->DA)) ? $resultados->DA : "",
            "DB"=>(isset($resultados->DB)) ? $resultados->DB : "",
            "DC"=>(isset($resultados->DC)) ? $resultados->DC : "",
            "DD"=>(isset($resultados->DD)) ? $resultados->DD : "",
            "DE"=>(isset($resultados->DE)) ? $resultados->DE : "",
            "DF"=>(isset($resultados->DF)) ? $resultados->DF : "",
            "DG"=>(isset($resultados->DG)) ? $resultados->DG : "",
            "DH"=>(isset($resultados->DH)) ? $resultados->DH : "",
            "DI"=>(isset($resultados->DI)) ? $resultados->DI : "",
            "DJ"=>(isset($resultados->DJ)) ? $resultados->DJ : "",
            "DK"=>(isset($resultados->DK)) ? $resultados->DK : "",
            "DL"=>(isset($resultados->DL)) ? $resultados->DL : ""
        ];
        if(isset($resultados->B))
            $resp=$model->insertComercial($data, $resultados->B);
        else
            return $this->genericResponse("FALLO", "NO EXISTE ID PARA COLOCAR VALORES ASESOR", 500);
        $resp=$model->eliminarClientesComercial($resultados->B);
        for ($i=0; $i < count($clientes); $i++) { 
            $datos=[
                "A"=>(isset($clientes[$i]->A)) ? $clientes[$i]->A : "",
                "B"=>(isset($clientes[$i]->B)) ? $clientes[$i]->B : "",
                "C"=>(isset($clientes[$i]->C)) ? $clientes[$i]->C : "",
                "D"=>(isset($clientes[$i]->D)) ? $clientes[$i]->D : "",
                "E"=>(isset($clientes[$i]->E)) ? $clientes[$i]->E : ""
            ];
            if(isset($clientes[$i]->A))
                $resp=$model->insertarClientesComercial($datos, $clientes[$i]->A, $i);
            else
                return $this->genericResponse("FALLO", "NO EXISTE ID PARA COLOCAR VALORES CLIENTES", 500);
        }
        return $this->genericResponse('EXITO EN CARGAR DATOS','',200);
    }

    public function insertStock()
    {
        $datos=$this->request->getJSON();
        if(!isset($datos->USC_ID)){
            return $this->genericResponse(null,'USC_ID NO EXISTE', 500);
        }
        if(!isset($datos->STO_COBRAR)){
            return $this->genericResponse(null,'STO_COBRAR NO EXISTE', 500);
        }
        if(!isset($datos->STO_VENDER)){
            return $this->genericResponse(null,'STO_VENDER NO EXISTE', 500);
        }
        if(!isset($datos->STO_ASIGNADO)){
            return $this->genericResponse(null,'STO_ASIGNADO NO EXISTE', 500);
        }
        if(!isset($datos->STO_DISPONIBLE)){
            return $this->genericResponse(null,'STO_DISPONIBLE NO EXISTE', 500);
        }
        $model=new \App\Models\GestionModel();
        $idNuevo=$model->ultimoId('tbl_stock', 'STO_ID');
        $data=[
            "STO_ID"=>$idNuevo,
            "USC_ID"=>$datos->USC_ID,
            "STO_COBRAR"=>$datos->STO_COBRAR,
            "STO_VENDER"=>$datos->STO_VENDER,
            "STO_ASIGNADO"=>$datos->STO_ASIGNADO,
            "STO_DISPONIBLE"=>$datos->STO_DISPONIBLE,
            "STO_ESTADO"=>1
        ];
        $resp=$model->insertStock($data, $idNuevo);
        return $this->genericResponse($resp,'',200);
    }

    public function inserUsuario()
    {
        $datos=$this->request->getJSON();
        if(!isset($datos->ASE_ID)){
            return $this->genericResponse(null,'ASE_ID NO EXISTE', 500);
        }
        if(!isset($datos->USU_USUARIO)){
            return $this->genericResponse(null,'USU_USUARIO NO EXISTE', 500);
        }
        if(!isset($datos->USU_PASSWORD)){
            return $this->genericResponse(null,'USU_PASSWORD NO EXISTE', 500);
        }
        $model=new \App\Models\GestionModel();
        $idNuevo=$model->ultimoId('tbl_usuarios', 'USU_ID');
        $data=[
            "USU_ID"=>$idNuevo,
            "ASE_ID"=>$datos->ASE_ID,
            "USU_USUARIO"=>$datos->USU_USUARIO,
            "USU_PASSWORD"=>$datos->USU_PASSWORD,
            "USU_ESTADO"=>1
        ];
        $resp=$model->insertUsuario($data, $idNuevo);
        return $this->genericResponse($resp,'',200);
    }

    //FUNCIONES PARA ENVIO
    private function genericResponse($data, $msj, $code)
    {
        if ($code == 200) {
            return $this->responseDirecto(array(
                "data" => $data,
                "code" => $code
            )); //, 404, "No hay nada"
        } else {
            return $this->responseDirecto(array(
                "msj" => $msj,
                "code" => $code
            ));
        }
    }

    private function responseDirecto($datos){
        $this->response->setHeader('Access-Control-Allow-Origin', '*');
        $this->response->setHeader('Access-Control-Allow-Methods', 'GET, POST');
        return $this->respond($datos);
    }
}