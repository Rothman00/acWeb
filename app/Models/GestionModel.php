<?php namespace App\Models;
use CodeIgniter\Model;
require_once FCPATH .'vendor/autoload.php';
require_once FCPATH . '/vendor/kreait/firebase-php/src/Firebase/Factory.php';
use kreait\Firebase\Factory;

class GestionModel extends Model
{
    protected $db;
    protected $factory;

    public function __construct() {
        parent::__construct();
        $this->factory =  (new Factory())-> withDatabaseUri('https://asesorcomercial-default-rtdb.firebaseio.com/'); 
        $this->db = $this->factory->createDatabase();
    }

    public function login($data, $tipo)
    {
        if($tipo)
            $datos=$this->db->getReference('tbl_usuario')
            ->getChild('megaadmin')
            ->getSnapshot()
            ->getValue();
        else
            $datos=$this->db->getReference('tbl_usuario')
            ->getChild('asesores')
            ->getSnapshot()
            ->getValue();
        $d=[];
        foreach ($datos as $key => $value) {
            if($value!=null){
                if(isset($value['USU_USUARIO'])&&isset($value['USU_PASSWORD'])){
                    if($value['USU_ESTADO'] && $value['USU_USUARIO']==$data['USU_USUARIO'] && $value['USU_PASSWORD']==$data['USU_PASSWORD']){
                        array_push($d,$value["USU_REFERENCIA"]);
                    }
                }
            }
        }
        return ($d!=[])?$d:[];
    }
    
    public function prueba(){
        return "SI INGRESO";
    }

    public function ultimoId($tabla, $nomCol)
    {
        if($this->db->getReference($tabla)->getValue()!=[]){
            $ultimo=$this->db->getReference($tabla)
            ->getValue();
            $valU=count($ultimo)-1;
            return $ultimo[$valU][$nomCol]+1;
        }
        return 0;
    }
    
    public function idCount($tabla)
    {
        if($this->db->getReference($tabla)->getValue()!=[]){
            $ultimo=$this->db->getReference($tabla)
            ->getValue();
            $valU=count($ultimo);
            return $valU;
        }
        return 0;
    }

    //tbl_rutas
    public function selectRutas($idU)
    {
        $datos=$this->db->getReference('tbl_rolusuarios')
        ->getChild($idU)
        ->getSnapshot()
        ->getValue();
        $d=[];
        if($datos==null) return $d;
        foreach ($datos as $key => $value) {
            if($value["ROU_ESTADO"]){
                $datos1=$this->db->getReference('tbl_rolruta')
                ->getSnapshot()
                ->getValue();
                foreach ($datos1 as $key1 => $value1) {
                    if($value1["ROR_ESTADO"]&&$value1["ROL_ID"]==$value["ROL_ID"]){
                        $datos2=$this->db->getReference('tbl_ruta')
                        ->getChild($value1["RUT_ID"])
                        ->getSnapshot()
                        ->getValue();
                        $opc = true;
                        foreach ($d as $key2 => $value2) {
                            if($value2["RUT_ID"]==$datos2["RUT_ID"])
                                $opc=false;
                        }
                        if($opc){
                            array_push($d,$datos2); 
                        }
                    }
                }
            }
        }
        return $d;
    }

    public function sRol($idU)
    {
        $datos=$this->db->getReference('tbl_rolusuarios')
        ->getChild($idU)
        ->getSnapshot()
        ->getValue();
        $d=[];
        if($datos==null) return $d;
        foreach ($datos as $key => $value) {
            if($value["ROU_ESTADO"]){
                $datos1=$this->db->getReference('tbl_rol')
                ->getSnapshot()
                ->getValue();
                foreach ($datos1 as $key1 => $value1) {
                    if($value1["ROL_ESTADO"]==true&&$value1["ROL_ID"]==$value["ROL_ID"]){
                        array_push($d, $value1["ROL_NOMBRE"]);
                    }
                }
            }
        }
        return $d;
    }

    //tbl_asesores
    public function insertAsesores($data, $idN)
    {
        $postRef = $this->db->getReference('tbl_asesores/'.$idN)->set($data);
        return $postRef;
    }

    public function selectAsesores($idA)
    {
        $datos=$this->db->getReference('tbl_asesores')
        ->getSnapshot()
        ->getValue();
        $d=[];
        foreach ($datos as $key => $value) {
            if($value!=null)
                if($value['ASE_ESTADO']==1 && $value['ASE_ID']==$idA)
                    array_push($d,$value);
        }
        return ($d!=[])?$d:[];
    }

    //tbl_catalogo
    public function insertCatalogo($data, $idN)
    {
        $postRef = $this->db->getReference('tbl_catalogo_update/'.$idN)->set($data);
        $postRef = $this->db->getReference('tbl_catalogo/'.$idN)->set($data);
        return $postRef;
    }

    public function activacionDesactivarCatalogo($estado)
    {
        $usuarios = $this->db->getReference('tbl_usuario')
        ->getSnapshot()
        ->getValue();
        foreach ($usuarios as $key => $value) {
            if($value!=null){
                if($value["USU_TIPO"]==0){
                    $idN = $this->ultimoId('tbl_actividad', 'ACT_ID');
                    $data =[
                        "ACT_ID"=>$idN,
                        "USU_ID"=>$value["USU_ID"],
                        "ACT_ESTADO"=>$estado
                    ];
                    $this->db->getReference('tbl_actividad/'.$idN)->set($data);
                }
            }
        }
        return true;
    }

    public function selectCatalogo()
    {
        $datos=$this->db->getReference('tbl_catalogo')
        ->getSnapshot()
        ->getValue();
        $d=[];
        foreach ($datos as $key => $value) {
            if($value!=null)
                if($value['CAT_ESTADO']==1)
                    array_push($d,$value);
        }
        return ($d!=[])?$d:[];
    }
    
    public function eliminar($ruta){
        $this->db->getReference($ruta)->set(null);
        return true;
    }

    //tbl_factura
    public function insertFactura($data, $idN){
        $this->db->getReference('tbl_factura/'.$idN)->set($data);
        return true;
    }

    //tbl_clientes
    public function insertCliente($data, $idN, $idU)
    {
        $idNuevo=$this->idCount('tbl_usuario/asesores/'.$idU.'/USU_CLIENTES/'.$idN);
        $dataUC=[
            "ESTADO"=>true,
            "FECHAD"=> date("Y-m-d"),
            "FECHAH"=>""
        ];
        $this->db->getReference('tbl_usuario/asesores/'.$idU.'/USU_CLIENTES/'.$idN.'/'.$idNuevo)->set($dataUC);
        $this->db->getReference('tbl_clientes/'.$idN)->set($data);
        return $idNuevo;
    }

    private function selectCliente($idC)
    {
        $datos=$this->db->getReference('tbl_clientes')
        ->getSnapshot()
        ->getValue();
        $d=[];
        foreach ($datos as $key => $value) {
            if($value!=null)
                if($value['CLI_ESTADO']==true && $value['CLI_ID']==$idC)
                    array_push($d,$value);
        }
        return ($d!=[])?$d:[];
    }

    public function selectClientes($idU)
    {
        $datos=$this->db->getReference('tbl_usuariocliente')
        ->getSnapshot()
        ->getValue();
        $d=[];
        foreach ($datos as $key => $value) {
            if($value!=null){
                if($value['USC_ESTADO']==1 && $value['USU_ID']==$idU){
                    $cliente=$this->selectCliente($value['CLI_ID']);
                    $v=[
                        "USC_ID"=>$value['USC_ID'],
                        "CLI_ID"=>$cliente[0]["CLI_ID"],
                        "CLI_NOMBRE"=>$cliente[0]["CLI_NOMBRE"],
                        "CLI_DESCRIPCION"=>$cliente[0]["CLI_DESCRIPCION"],
                        "CLI_FOTO"=>$cliente[0]["CLI_FOTO"],
                        "CLI_LAT"=>$cliente[0]["CLI_LAT"],
                        "CLI_LON"=>$cliente[0]["CLI_LON"],
                        "CLI_ESTADO"=>$cliente[0]["CLI_ESTADO"]
                    ];
                    array_push($d,$v);
                }
            }
        }
        return ($d!=[])?$d:[];
    }

    public function sClientes()
    {
        $datos=$this->db->getReference('tbl_clientes')
        ->getSnapshot()
        ->getValue();
        return $datos;
    }

    public function sUsuarioClientes($idU)
    {
        $datos=$this->db->getReference('tbl_usuariocliente')
        ->getSnapshot()
        ->getValue();
        $d=[];
        $usuario=[];
        $rep=true;
        foreach ($datos as $key => $value) {
            if($value!=null){
                if($value['USC_ESTADO']==1 && $value['USU_ID']==$idU){
                    $cliente=$this->selectCliente($value['CLI_ID']);
                    if($rep){
                        $da= $this->sUsuarioId($idU);
                        array_push($usuario,(array) $da);
                        $rep=false;
                    }
                    array_push($d,(array) $cliente);
                }
            }
        }
        return ["usuario"=>$usuario, "clientes"=>$d];
    }

    public function sClienteUsuario($idC)
    {
        $datos=$this->db->getReference('tbl_usuariocliente')
        ->getSnapshot()
        ->getValue();
        $d=[];
        $usuario=[];
        foreach ($datos as $key => $value) {
            if($value!=null){
                if($value['USC_ESTADO']==1 && $value['CLI_ID']==$idC){
                    $usuario=$this->sUsuarioId($value['USU_ID']);
                    $cliente=$this->selectCliente($idC);
                    $v=[
                        "USC_ID"=>$value['USC_ID'],
                        "CLI_ID"=>$cliente[0]["CLI_ID"],
                        "CLI_NOMBRE"=>$cliente[0]["CLI_NOMBRE"],
                        "CLI_DESCRIPCION"=>$cliente[0]["CLI_DESCRIPCION"],
                        "CLI_FOTO"=>$cliente[0]["CLI_FOTO"],
                        "CLI_LAT"=>$cliente[0]["CLI_LAT"],
                        "CLI_LON"=>$cliente[0]["CLI_LON"],
                        "CLI_ESTADO"=>$cliente[0]["CLI_ESTADO"]
                    ];
                    array_push($d,$v);
                    return ["usuario"=>$usuario, "clientes"=>$d];   
                }
            }
        }
    }

    public function updateCliente($data,$idC)
    {
        $postRef = $this->db->getReference('tbl_clientes/'.$idC)->update($data);
        return $postRef;
    }

    public function deleteCliente($idC)
    {
        $postRef = $this->db->getReference('tbl_clientes/'.$idC.'/CLI_ESTADO')->set(false);
        return $postRef;
    }

    //tbl_plancomercial
    public function insertComercial($data, $idP)
    {
        $this->db->getReference('tbl_plancomercial/'.$idP)->set(null);
        $postRef = $this->db->getReference('tbl_plancomercial/'.$idP)->set($data);
        return $postRef;
    }

    public function insertarClientesComercial($data, $idCC, $i)
    {
        $postRef = $this->db->getReference('tbl_plancomercialclientes/'.$idCC.'/'.$i)->set($data);
        return $postRef;
    }

    public function eliminarClientesComercial($idCC)
    {
        $postRef = $this->db->getReference('tbl_plancomercialclientes/'.$idCC)->set(null);
        return $postRef;
    }

    public function selectComercial($idUC)
    {
        $datos=$this->db->getReference('tbl_plancomercial')
        ->getSnapshot()
        ->getValue();
        $visitado=$this->db->getReference('tbl_visitados')
        ->getSnapshot()
        ->getValue();
        $semana=$this->db->getReference('tbl_programacion')
        ->getSnapshot()
        ->getValue();
        $d=[];
        foreach ($semana as $keyS => $valueS) {
            if($valueS!=null){
                if($valueS['USC_ID']==$idUC){
                    foreach ($visitado as $keyV => $valueV) {
                        if($valueV!=null){
                            if($valueV['PRO_ID']==$valueS['PRO_ID']){
                                foreach ($datos as $key => $value) {
                                    if($value!=null){
                                        if($value['PLA_ESTADO']==1 && $value['VIS_ID']==$valueV['VIS_ID'])
                                        array_push($d,[
                                            "PLA_ID"=>$value["PLA_ID"],
                                            "PLA_COLOR"=>$value["PLA_COLOR"],
                                            "PLA_ESTADO"=>$value["PLA_ESTADO"],
                                            "VIS_ID"=>$valueV["VIS_ID"],
                                            "VIS_VENTA"=>$valueV["VIS_VENTA"],
                                            "VIS_COBRANZA"=>$valueV["VIS_COBRANZA"],
                                            "VIS_OTROS"=>$valueV["VIS_OTROS"],
                                            "VIS_LAT"=>$valueV["VIS_LAT"],
                                            "VIS_LON"=>$valueV["VIS_LON"],
                                            "VIS_OBSERVACION"=>$valueV["VIS_OBSERVACION"],
                                            "VIS_ESTADO"=>$valueV["VIS_ESTADO"],
                                            "PRO_ID"=>$valueS["PRO_ID"],
                                            "USC_ID"=>$valueS["USC_ID"],
                                            "PRO_FECHA"=>$valueS["PRO_FECHA"],
                                            "PRO_HORA"=>$valueS["PRO_HORA"],
                                            "PRO_OBSERVACION"=>$valueS["PRO_OBSERVACION"],
                                            "PRO_TIPO"=>$valueS["PRO_TIPO"],
                                            "PRO_ESTADO"=>$valueS["PRO_ESTADO"]
                                        ]);                            
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        return ($d!=[])?$d:[];
    }

    //tbl_programacion
    public function insertSemana($data, $idN)
    {
        $postRef = $this->db->getReference('tbl_programacion/'.$idN)->set($data);
        return $postRef;
    }

    public function selectSemana($idUC)
    {
        $datos=$this->db->getReference('tbl_programacion')
        ->getSnapshot()
        ->getValue();
        $d=[];
        for ($i=count($datos)-1; $i >= 0; $i--) { 
            if($datos[$i]!=null)
                if($datos[$i]['USC_ID']==$idUC){
                    array_push($d,$datos[$i]);
                    break;
                }
        }
        return ($d!=[])?$d:[];
    }

    public function asesoresSemana()
    {
        $usuarios=$this->db->getReference('tbl_usuario')
        ->getSnapshot()
        ->getValue();
        $semana=$this->db->getReference('tbl_programacion')
        ->getSnapshot()
        ->getValue();
        $d=[];
        foreach ($semana as $key => $value) {
            if(isset($value["PRO_FECHA"])){
                if($this->comparacionFecha($value["PRO_FECHA"])){
                    $usuCli=$this->db->getReference('tbl_usuariocliente')
                    ->getChild($value["USC_ID"])
                    ->getSnapshot()
                    ->getValue();
                    $usu=$this->db->getReference('tbl_usuario')
                    ->getChild($usuCli["USU_ID"])
                    ->getSnapshot()
                    ->getValue();
                    array_push($d,$usu);
                }
            }
        }
        $res=[];
        foreach ($usuarios as $key => $value) {
            $opc=false;
            foreach ($d as $keyD => $valueD) {
                if($valueD["USU_ID"]==$value["USU_ID"])
                    $opc=true;
            }
            array_push($res,[$opc, $value]);
        }
        return $res;
    }

    private function comparacionFecha($fecha)
    {
        $hoyDiaS = date("D");
        $actual = date("Y-m-d");
        $i=0;
        for ($i; $i <= 7; $i++) { 
            $hoyDiaS = date("D",strtotime($actual."- ".$i." days"));
            if($hoyDiaS=="Mon"){
                break;
            }
        }
        $hora = date("H:i:00");
        $lunes = date("Y-m-d", strtotime($actual."- ".$i." days"));
        $domingo = date("Y-m-d", strtotime($lunes."+ 6 days"));
        $f = strtotime($fecha." ".$hora);
        $desde = strtotime($lunes." ".$hora);
        $hasta = strtotime($domingo." ".$hora);
        return $desde<=$f && $hasta>=$f;
    }

    //tbl_stocks
    public function insertStock($data, $idN)
    {
        $postRef = $this->db->getReference('tbl_stocks/'.$idN)->set($data);
        return $postRef;
    }

    public function selectStock($idUC)
    {
        $datos=$this->db->getReference('tbl_stocks')
        ->getSnapshot()
        ->getValue();
        $d=[];
        for ($i=count($datos)-1; $i >= 0; $i--) { 
            if($datos[$i]!=null)
                if($datos[$i]['STO_ESTADO']==1 && $datos[$i]['USC_ID']==$idUC){
                    array_push($d,$datos[$i]);
                    break;
                }
        }
        return ($d!=[])?$d:[];
    }

    //tbl_tareas
    public function insertTareas($data, $idN)
    {
        $postRef = $this->db->getReference('tbl_tarea/'.$idN)->set($data);
        return $postRef;
    }

    public function insertSemanaTareas($data, $ruta, $idN, $idT)
    {
        $this->insertSemana($data,$ruta);
        $updateData=[
            'tbl_tarea/'.$idT.'/PRO_ID'=>$idN,
            'tbl_tarea/'.$idT.'/TAR_ESTADO'=>0
        ];
        $postRef = $this->db->getReference()->update($updateData);
        return $postRef;
    }

    public function selectTareas($idUC)
    {
        $datos=$this->db->getReference('tbl_tareas')
        ->getSnapshot()
        ->getValue();
        $d=[];
        for ($i=count($datos)-1; $i >= 0; $i--) { 
            if($datos[$i]!=null){
                if($datos[$i]['TAR_ESTADO']==1 && $datos[$i]['USC_ID']==$idUC){
                    array_push($d,$datos[$i]);
                    break;
                }
            }
        }
        return ($d!=[])?$d:[];
    }

    //tbl_usuario
    public function insertUsuario($data, $idN)
    {
        $postRef = $this->db->getReference('tbl_usuario/'.$idN)->set($data);
        return $postRef;
    }

    public function selectUsuario($data)
    {
        $datos=$this->db->getReference('tbl_usuario')
        ->getSnapshot()
        ->getValue();
        $d=[];
        foreach ($datos as $key => $value) {
            if($value!=null)
                if($value['USU_ESTADO']==1 && $value['USU_USUARIO']==$data['USU_USUARIO'] && $value['USU_PASSWORD']==$data['USU_PASSWORD']){
                    array_push($d,$value);
                    break;
                }
        }
        $asesor=$this->selectAsesores($d[0]['ASE_ID']);
        return [
            "USU_ID"=>$d[0]['USU_ID'],
            "ASE_ID"=> $asesor[0]["ASE_ID"],
            "ASE_NOMBRES"=> $asesor[0]["ASE_NOMBRES"],
            "ASE_PROVINCIA"=> $asesor[0]["ASE_PROVINCIA"],
            "ASE_ZONA"=> $asesor[0]["ASE_ZONA"],
            "ASE_ESTADO"=> $asesor[0]["ASE_ESTADO"]
        ];
    }

    public function sUsuario($refe)
    {
        $datos=$this->db->getReference('tbl_usuario')
        ->getChild('megaadmin')
        ->getChild($refe)
        ->getSnapshot()
        ->getValue();
        return $datos;
    }

    public function sUsuarioId($id)
    {
        $datos=$this->db->getReference('tbl_usuario')
        ->getSnapshot()
        ->getValue();
        foreach ($datos as $key => $value) {
            if($value!=null)
                if($value['USU_ESTADO'] == true&&$value['USU_ID'] == $id){
                    return $value;
                }
        }
        return null;
    }

    public function sUsuarios()
    {
        $datos=$this->db->getReference('tbl_usuario')
        ->getSnapshot()
        ->getValue();
        return $datos;
    }

    //tbl_visitados
    public function insertVisitado($data, $ruta, $idN, $idP)
    {
        $this->db->getReference('tbl_visitados/'.$ruta.$idN)->set($data);
        $dataS=[
            'tbl_programacion/'.$ruta.$idP.'/PRO_ESTADO'=>0
        ];
        $postRef = $this->db->getReference()->update($dataS);
        return $postRef;
    }

    public function selectVisitado($idUC)
    {
        $semana=$this->selectSemana($idUC);
        if($semana==[])return [];
        $datos=$this->db->getReference('tbl_visitados')
        ->getSnapshot()
        ->getValue();
        $d=[];
        for ($i=count($datos)-1; $i >= 0; $i--) { 
            if($datos[$i]!=null){
                if($datos[$i]['VIS_ESTADO']==1 && $semana[0]['PRO_ID']==$datos[$i]['PRO_ID']){
                    array_push($d,$datos[$i]);
                    break;
                }
            }
        }
        return ($d!=[])?$d:[];
    }
    
    //tbl_promociones
    public function sPromo()
    {
        $datos=$this->db->getReference('tbl_promociones')
        ->getSnapshot()
        ->getValue();
        $d=[];
        for ($i=count($datos)-1; $i >= 0; $i--) { 
            if($datos[$i]!=null)
                //if($datos[$i]['PRM_ESTADO']){
                    if(!$this->repetidos($d,$datos[$i])){
                        array_push($d,$datos[$i]);
                    }
                //}
        }
        return $d;
    }

    private function repetidos($lista, $nuevo)
    {
        foreach ($lista as $key => $value) {
            if($this->promoNombre($value["PRM_URL"])==$this->promoNombre($nuevo["PRM_URL"]))
                return true;
        }
        return false;
    }

    private function promoNombre($name)
    {
        $res=substr($name,87);
        $r=explode("?alt=media",$res);
        return $r[0];
    }

    public function insertPrivilegioN($data, $idN, $idR)
    {
        $postRef = $this->db->getReference('tbl_rolusuarios/'.$idR.'/'.$idN)->set($data);
        return $postRef;
    }

    public function insertRol($data, $idN)
    {
        $postRef = $this->db->getReference('tbl_rol/'.$idN)->set($data);
        return $postRef;
    }

    public function insertRolRuta($data, $idN)
    {
        $postRef = $this->db->getReference('tbl_rolruta/'.$idN)->set($data);
        return $postRef;
    }

    public function selectVentas()
    {
        $datos=$this->db->getReference('tbl_visitados')
        ->getSnapshot()
        ->getValue();
        $d=[];
        if($datos!=null){
            foreach ($datos as $key => $value) {
                if($value!=null){
                    $datos1=$this->db->getReference('tbl_programacion')
                    ->getChild($value["PRO_ID"])
                    ->getSnapshot()
                    ->getValue();
                    $datos2=$this->db->getReference('tbl_usuariocliente')
                    ->getChild($datos1["USC_ID"])
                    ->getSnapshot()
                    ->getValue();
                    $datos3=$this->db->getReference('tbl_usuario')
                    ->getChild($datos2["USU_ID"])
                    ->getSnapshot()
                    ->getValue();
                    $datos4=$this->db->getReference('tbl_clientes')
                    ->getChild($datos2["CLI_ID"])
                    ->getSnapshot()
                    ->getValue();
                    array_push($d, [
                        $datos1["PRO_TIPO"],
                        $datos3["USU_NOMBRES"],
                        $datos3["USU_PIN"],
                        $datos3["USU_DNI"],
                        $datos3["USU_DIRECCION"],
                        $datos4["CLI_NOMBRE"],
                        $datos4["CLI_CODIGO"],
                        $datos4["CLI_DIRECCION"],
                        $datos4["CLI_EMAIL"],
                        $datos1["PRO_FECHA"],
                        $datos1["PRO_HORA"],
                        $datos1["PRO_OBSERVACION"],
                        $value["VIS_VENTA"],
                        $value["VIS_COBRANZA"],
                        $value["VIS_OTROS"],
                        $value["VIS_OBSERVACION"],
                        $datos4["CLI_LAT"],
                        $datos4["CLI_LON"],
                        $value["VIS_LAT"],
                        $value["VIS_LON"],
                        $datos3["USU_ID"]
                    ]);
                }
            }
        }
        return ($d!=[])?$d:[];
    }

    public function selectRuta()
    {
        $datos=$this->db->getReference('tbl_ruta')
        ->getSnapshot()
        ->getValue();
        $d=[];
        foreach ($datos as $key => $value) {
            if($value!=null)
                array_push($d, [$value["RUT_ID"], $value["RUT_NOMBRE"]]);
        }
        return ($d!=[])?$d:[];   
    }

    public function selectRol()
    {
        $datos=$this->db->getReference('tbl_rol')
        ->getSnapshot()
        ->getValue();
        $d=[];
        foreach ($datos as $key => $value) {
            if($value!=null)
                if($value["ROL_ESTADO"])
                    array_push($d, [$value["ROL_ID"], $value["ROL_NOMBRE"]]);
        }
        return ($d!=[])?$d:[];   
    }
}