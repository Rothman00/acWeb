<?php

namespace App\Controllers;
use \PhpOffice\PhpSpreadsheet\Spreadsheet;
use \PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use \App\Models\AsesoresModel;

class Asesores extends BaseController
{
	protected $request,$session, $model;
	protected $listaNomres;

	public function __construct() {
		$this->request = \Config\Services::request();
		$this->session = \Config\Services::session();
		$this->model = new AsesoresModel();
	}

	public function index()
	{
		if($this->session->has('usuario'))
			return $this->login();
		else
			return view('layouts/login');
	}

	public function destruirSession()
    {
		$this->session->destroy();
		echo '<script>localStorage.clear();</script>';
		return view('layouts/login');
    }

	public function login()
	{
		if($this->session->has('usuario')){
			$resp = ["rol"=>$this->session->get("rol"), "ref"=>$this->session->get("usuario")->USU_REFERENCIA];
			$respU=["usuario"=>$this->session->get("usuario")];
			$respR=["rutas"=>$this->session->get("rutas")];
			return view("layouts/header", $respU).view("layouts/aside", $respR).view("layouts/body", $resp).view("layouts/footer");
		}
		$usuario=isset($_POST['usuario']) ? $_POST['usuario'] : "";
		$contra=isset($_POST['contra']) ? $_POST['contra'] : "";
		$dataUP = array(
            "USU_USUARIO" => $usuario,
            "USU_PASSWORD" => $contra,
			"TIPO" => true
        );
		$resp = $this->model->postEnvio("/gestion/login", $dataUP);
		if($resp!=NULL){
		    if($resp[0]){
				$ref = array("USU_REFERENCIA" => $resp[1]);
    			$usuario = $this->model->postEnvio("/gestion/su",$ref);
    			if($usuario!=null){
    			    $rutas = $this->model->postEnvio("/gestion/r",$ref);
					$rol = $this->model->postEnvio("/gestion/srol",$ref);
    				$this->session->set(["usuario"=>$usuario]);
    				$this->session->set(["rutas"=>$rutas]);
					$this->session->set(["rol"=>$rol[0]]);
					$resp = ["rol"=>$this->session->get("rol"), "ref"=>$this->session->get("usuario")->USU_REFERENCIA];
					$respU=["usuario"=>$this->session->get("usuario")];
					$respR=["rutas"=>$this->session->get("rutas")];
    				return view("layouts/header", $respU).view("layouts/aside", $respR).view("layouts/body", $resp).view("layouts/footer");
    			}
    		}
		}
		return view('layouts/login', ["error"=>true]);
	}

	public function clientes()
	{
		if($this->session->has('usuario')){
			return view("layouts/header", ["usuario"=>$this->session->get("usuario")]).view("layouts/aside", ["rutas"=>$this->session->get("rutas")]).view("layouts/clientes").view("layouts/footer");
		}
		return view('layouts/login');
	}

	public function actualizarCliente()
	{
		$id=isset($_POST['id']) ? $_POST['id'] : NULL;
		$codigo=isset($_POST['codigo']) ? $_POST['codigo'] : NULL;
		$nombre=isset($_POST['nombre']) ? $_POST['nombre'] : NULL;
		$direccion=isset($_POST['direccion']) ? $_POST['direccion'] : NULL;
		$email=isset($_POST['email']) ? $_POST['email'] : NULL;
		$telefono=isset($_POST['telefono']) ? $_POST['telefono'] : NULL;
		$mobil=isset($_POST['mobil']) ? $_POST['mobil'] : NULL;
		$desde=isset($_POST['desde']) ? $_POST['desde'] : NULL;
		$hasta=isset($_POST['hasta']) ? $_POST['hasta'] : NULL;
		$lat=isset($_POST['lat']) ? $_POST['lat'] : NULL;
		$lon=isset($_POST['lon']) ? $_POST['lon'] : NULL;
		$foto=isset($_POST['foto']) ? $_POST['foto'] : NULL;
		$datos=array(
			"CLI_ID"=>$id,
			"CLI_CODIGO"=>$codigo,
			"CLI_CODIGOID"=>$codigo,
			"CLI_NOMBRE"=>$nombre,
			"CLI_DIRECCION"=>$direccion,
			"CLI_EMAIL"=>$email,
			"CLI_TELEFONO"=>$telefono,
			"CLI_MOBIL"=>$mobil,
			"CLI_HORAD"=>$desde,
			"CLI_HORAH"=>$hasta,
			"CLI_LAT"=>$lat,
			"CLI_LON"=>$lon,
			"CLI_FOTO"=>$foto,
			"CLI_ESTADO"=>""
		);
		$resp=$this->model->updateCliente(json_encode($datos));
		return $resp;
	}

	public function eliminarCliente()
	{
		$id=isset($_POST['id']) ? $_POST['id'] : NULL;
		$datos=array(
			"CLI_ID"=>$id
		);
		$resp=$this->model->deleteCliente(json_encode($datos));
		var_dump($resp);
		return $resp;
	}

	public function insertCliente()
	{
		$idA=isset($_POST['idA']) ? $_POST['idA'] : NULL;
		$codigo=isset($_POST['codigo']) ? $_POST['codigo'] : NULL;
		$nombre=isset($_POST['nombre']) ? $_POST['nombre'] : NULL;
		$direccion=isset($_POST['direccion']) ? $_POST['direccion'] : NULL;
		$email=isset($_POST['email']) ? $_POST['email'] : NULL;
		$telefono=isset($_POST['telefono']) ? $_POST['telefono'] : NULL;
		$mobil=isset($_POST['mobil']) ? $_POST['mobil'] : NULL;
		$desde=isset($_POST['desde']) ? $_POST['desde'] : NULL;
		$hasta=isset($_POST['hasta']) ? $_POST['hasta'] : NULL;
		$datos=array(
			"USU_ID"=>$idA,
			"CLI_CODIGO"=>$codigo,
			"CLI_CODIGOID"=>$codigo,
			"CLI_NOMBRE"=>$nombre,
			"CLI_DIRECCION"=>$direccion,
			"CLI_EMAIL"=>$email,
			"CLI_TELEFONO"=>$telefono,
			"CLI_MOBIL"=>$mobil,
			"CLI_HORAD"=>$desde,
			"CLI_HORAH"=>$hasta,
			"CLI_LAT"=>"",
			"CLI_LON"=>"",
			"CLI_FOTO"=>"",
			"CLI_ESTADO"=>""
		);
		$resp=$this->model->insertCliente(json_encode($datos));
		var_dump($resp);
		return $resp;
	}

	public function actividad()
	{
		if($this->session->has('usuario')){
			$datos=array("USU_REFERENCIA"=>$this->session->get("usuario")->USU_REFERENCIA);
			$rol = $this->model->rol(json_encode($datos));
			$resp=[
				"rol"=>$rol[0],
				"ref"=>$this->session->get("usuario")->USU_REFERENCIA,
			];
			return view("layouts/header", ["usuario"=>$this->session->get("usuario")]).view("layouts/aside", ["rutas"=>$this->session->get("rutas")]).view("layouts/actividad", $resp).view("layouts/footer");
		}
		return view('layouts/login');
	}

	public function historiales()
	{
		if($this->session->has('usuario')){
			$datos=array("USU_REFERENCIA"=>$this->session->get("usuario")->USU_REFERENCIA);
			$rol = $this->model->rol(json_encode($datos));
			$resp=[
				"rol"=>$rol[0],
				"ref"=>$this->session->get("usuario")->USU_REFERENCIA,	
			];
			return view("layouts/header", ["usuario"=>$this->session->get("usuario")]).view("layouts/aside", ["rutas"=>$this->session->get("rutas")]).view("layouts/historiales", $resp).view("layouts/footer");
		}
		return view('layouts/login');
	}

	public function planComercial()
	{
		if($this->session->has('usuario')){
			return view("layouts/header", ["usuario"=>$this->session->get("usuario")]).view("layouts/aside", ["rutas"=>$this->session->get("rutas")]).view("layouts/plancomercial").view("layouts/footer");
		}
		return view('layouts/login');
	}

	public function tareas()
	{
		if($this->session->has('usuario')){
		    return view("layouts/header", ["usuario"=>$this->session->get("usuario")]).view("layouts/aside", ["rutas"=>$this->session->get("rutas")]).view("layouts/tareas").view("layouts/footer");
		}
		return view('layouts/login');
	}

	public function insertTarea()
	{
		$id=isset($_POST['id']) ? $_POST['id'] : NULL;
		$cobrar=isset($_POST['cobrar']) ? $_POST['cobrar'] : NULL;
		$vender=isset($_POST['vender']) ? $_POST['vender'] : NULL;
		$otros=isset($_POST['otros']) ? $_POST['otros'] : NULL;
		$fecha=isset($_POST['fecha']) ? $_POST['fecha'] : NULL;
		$detalle=isset($_POST['detalle']) ? $_POST['detalle'] : NULL;
		$datos=array(
			"CLI_CODIGOID"=>$id,
			"TAR_COBRAR"=>floatval($cobrar),
			"TAR_VENDER"=>floatval($vender),
			"TAR_OTROS"=>floatval($otros),
			"TAR_FECHA"=>$fecha,
			"TAR_DETALLE"=>$detalle
		);
		$resp= $this->model->insertTarea(json_encode($datos));
		var_dump($resp);
		return $resp;
	}

	public function promociones()
	{
		if($this->session->has('usuario')){
		    $resp=[
				"promo"=>$this->model->promociones()
			];
			if(isset($resp["promo"]->code))
				if($resp["promo"]->code != 200)
					$resp["promo"]=[];
			return view("layouts/header", ["usuario"=>$this->session->get("usuario")]).view("layouts/aside", ["rutas"=>$this->session->get("rutas")]).view("layouts/promociones", $resp).view("layouts/footer");
		}
		return view('layouts/login');
	}
	
	public function insertDropzone()
	{
	    $image = $this->request->getFile('file');
        $imageName = $image->getName();
        $newName = $image->getRandomName();
        return json_encode(array(
			"status" => 1,
			"filename" => $newName,
			"file" => $image
		));
	}

	public function catalogoProd()
	{
		if($this->session->has('usuario')){
			return view("layouts/header", ["usuario"=>$this->session->get("usuario")]).view("layouts/aside", ["rutas"=>$this->session->get("rutas")]).view("layouts/asignacion").view("layouts/footer");
		}
		return view('layouts/login');
	}

	public function ventasReporte()
	{
		if($this->session->has('usuario')){
			return view("layouts/header", ["usuario"=>$this->session->get("usuario")]).view("layouts/aside", ["rutas"=>$this->session->get("rutas")]).view("layouts/reportes").view("layouts/footer");
		}
		return view('layouts/login');
	}

	public function privilegios()
	{
		if($this->session->has('usuario')){
			$datos=array("USU_REFERENCIA"=>$this->session->get("usuario")->USU_REFERENCIA);
			$rol = $this->model->rol(json_encode($datos));
			$resp=[
				"rutas"=>$this->model->selectRutas(),
				"rol"=>$this->model->selectRoles(),
				"mirol"=>$rol[0]
			];
			return view("layouts/header", ["usuario"=>$this->session->get("usuario")]).view("layouts/aside", ["rutas"=>$this->session->get("rutas")]).view("layouts/privilegios", $resp).view("layouts/footer");
		}
		return view('layouts/login');
	}

	public function insertarROL()
	{
		$nombre=isset($_POST['nombre']) ? $_POST['nombre'] : NULL;
		$datos=array(
			"ROL_NOMBRE"=>$nombre
		);
		$resp=$this->model->insertRo(json_encode($datos));
		var_dump($resp);
		return $resp;
	}

	public function insertPrivilegio()
	{
		$idA=isset($_POST['idA']) ? $_POST['idA'] : NULL;
		$idU=isset($_POST['idU']) ? $_POST['idU'] : NULL;
		$datos=array(
			"ROL_ID"=>intval($idA),
			"USU_REFERENCIA"=>$idU
		);
		$resp=$this->model->insertPriv(json_encode($datos));
		var_dump($resp);
		return $resp;
	}

	public function insertarROLRUTA()
	{
		$idR=isset($_POST['idR']) ? $_POST['idR'] : NULL;
		$datos=array(
			"RUT_ID"=>$idR
		);
		$resp=$this->model->insertRuta(json_encode($datos));
		var_dump($resp);
		return $resp;
	}
}
