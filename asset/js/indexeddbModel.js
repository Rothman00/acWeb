// This works on all devices/browsers, and uses IndexedDBShim as a final fallback 
var indexedDB = window.indexedDB || window.mozIndexedDB || window.webkitIndexedDB || window.msIndexedDB || window.shimIndexedDB;

// Open (or create) the database
var open = indexedDB.open("SAC", 1);

//VARIABLES DE DATOS COMPLETOS
let datosCat;
let datosAse;
let datosAdm;
let datosCli;
let datosReportesTotal = [];

// Create the schema
open.onupgradeneeded = function() {
    var db = open.result;
    if (!db.objectStoreNames.contains('clientes')) {
        const box1 = db.createObjectStore("clientes", { keyPath: "CLI_CODIGOID" });
    }
    if (!db.objectStoreNames.contains('catalogo')) {
        const box2 = db.createObjectStore("catalogo", { keyPath: "CAT_CODIGO" });
    }
    if (!db.objectStoreNames.contains('admin')) {
        const box3 = db.createObjectStore("admin", { keyPath: "USU_REFERENCIA" });
    }
    if (!db.objectStoreNames.contains('asesor')) {
        const box4 = db.createObjectStore("asesor", { keyPath: "USU_REFERENCIA" });
    }
};

open.onsuccess = function() {
    // Start a new transaction
    var db = open.result;
    //ADMIN
    var admin = db.transaction("admin", "readwrite");
    var storeAdm = admin.objectStore("admin");
    //ASESORES
    var asesor = db.transaction("asesor", "readwrite");
    var storeAse = asesor.objectStore("asesor");
    //CATALOGO
    var catalogo = db.transaction("catalogo", "readwrite");
    var storeCat = catalogo.objectStore("catalogo");
    //CLIENTES
    var cliente = db.transaction("clientes", "readwrite");
    var storeCli = cliente.objectStore("clientes");

    //CONSULTA TODOS LOS DATOS
    var allAdmin = storeAdm.getAll();
    var allCatalogo = storeCat.getAll();
    var allCliente = storeCli.getAll();
    var allAsesor = storeAse.getAll();

    //ALL QUERY ADMINISTRADORES
    allAdmin.onsuccess = function() {
        datosAdm=allAdmin.result;
        if (allAdmin.result.length == 0) {
            $.ajax({
                type: "GET",
                url: "https://asesorcomercial-default-rtdb.firebaseio.com/tbl_usuario/megaadmin.json",
                cache: false,
                success: function(response) {
                    var admin = db.transaction("admin", "readwrite");
                    var storeAdm = admin.objectStore("admin");
                    for (const r in response) {
                        if (Object.hasOwnProperty.call(response, r)) {
                            const element = response[r];
                            storeAdm.put(element);
                        }
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert("PROBLEMAS DE CONEXIÓN, INTENTE MÁS TARDE");
                    location.reload();
                }
            });
        }else{
            if($('#tablaAsesores').length > 0){
                setTimeout(function(){
                    var lunes = fechaLunes();
                    var starCountRef = firebase.database().ref('tbl_programacion').limitToLast(14);
                    starCountRef.get().then((snapshot) => {
                        let dato = snapshot.val();
                        for (let index = 0; index < 7; index++) {
                            var dia = new Date(lunes.getFullYear(), lunes.getMonth(), lunes.getDate());
                            dia.setDate(lunes.getDate() + index);
                            let datos = dato[`${dia.toISOString().split('T')[0]}`];
                            if(datos!=undefined){
                                datosAse.forEach(e => {
                                    if(e["USU_CLIENTES"]==undefined)
                                        e["ACTIVO"]=false;
                                    else
                                        if(e["ACTIVO"]==undefined || !e["ACTIVO"]){
                                            e["ACTIVO"]=false;
                                            for (const key in e["USU_CLIENTES"]) {
                                                if(datos[key] != undefined){
                                                    e["ACTIVO"]=true;
                                                    break;
                                                }
                                            }
                                        }
                                });
                            }
                        }
                        $('#tablaAsesores').html(generarTablaAsesoresManual(datosAse, datosAdm));
                        $('#datatable-asesoresData').DataTable();
                        $(".select2-A").select2({
                            placeholder: "Select a state",
                            allowClear: true
                        });
                    });
                }, 1500);
            }
        }
    }

    //ALL QUERY ASESORES
    allAsesor.onsuccess = function() {
        datosAse=allAsesor.result;
        if (allAsesor.result.length == 0) {
            $.ajax({
                type: "GET",
                url: "https://asesorcomercial-default-rtdb.firebaseio.com/tbl_usuario/asesores.json",
                cache: false,
                success: function(response) {
                    var asesor = db.transaction("asesor", "readwrite");
                    var storeAse = asesor.objectStore("asesor");
                    for (const r in response) {
                        if (Object.hasOwnProperty.call(response, r)) {
                            const element = response[r];
                            storeAse.put(element);
                        }
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert("PROBLEMAS DE CONEXIÓN, INTENTE MÁS TARDE");
                    location.reload();
                }
            });
        }else{
            if ($('#historialTable').length > 0) {
                $('#historialTable').html(generarTablaHistorialManual(datosAse));
                $('#datatable-historialData').DataTable();
            }
        }
    }

    //ALL QUERY CATALOGO
    allCatalogo.onsuccess = function() {
        datosCat=allCatalogo.result;
        if (allCatalogo.result.length == 0) {
            $.ajax({
                type: "GET",
                url: "https://asesorcomercial-default-rtdb.firebaseio.com/tbl_catalogo.json",
                cache: false,
                success: function(response) {
                    var catalogo = db.transaction("catalogo", "readwrite");
                    var storeCat = catalogo.objectStore("catalogo");
                    for (const r in response) {
                        if (Object.hasOwnProperty.call(response, r)) {
                            const element = response[r];
                            if (element["CAT_ESTADO"])
                                storeCat.put(element);
                        }
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert("PROBLEMAS DE CONEXIÓN, INTENTE MÁS TARDE");
                    location.reload();
                }
            });
        } else {
            if ($('#catalogoDiv').length > 0) {
                $('#catalogoDiv').html(generarTablaCatalogoManual(allCatalogo.result));
                $('#datatable-catalogoData').DataTable();
            }
        }
    }

    //ALL QUERY CLIENTES
    allCliente.onsuccess = function() {
        datosCli=allCliente.result;
        if (allCliente.result.length == 0) {
            $.ajax({
                type: "GET",
                url: "https://asesorcomercial-default-rtdb.firebaseio.com/tbl_clientes.json",
                cache: false,
                success: function(response) {
                    var cliente = db.transaction("clientes", "readwrite");
                    var storeCli = cliente.objectStore("clientes");
                    for (const r in response) {
                        if (Object.hasOwnProperty.call(response, r)) {
                            const element = response[r];
                            storeCli.put(element);
                        }
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert("PROBLEMAS DE CONEXIÓN, INTENTE MÁS TARDE");
                    location.reload();
                }
            });
        } else {
            if ($('#tableClientes').length > 0) {
                setTimeout(function(){
                    $('#tableClientes').html(generarTablaClientesManual(datosCli, datosAse));
                    $('#datatable-clientesData').DataTable();
                }, 250);
            }
            //TRAIDA DE DATOS REPORTES
            if($('#reportesTable').length > 0){
                $.ajax({
                    type: "GET",
                    url: "https://asesorcomercial-default-rtdb.firebaseio.com/tbl_visitados.json",
                    cache: false,
                    timeout: 300000,
                    success: function (response) {
                        $.ajax({
                            type: "GET",
                            url: "https://asesorcomercial-default-rtdb.firebaseio.com/tbl_programacion.json",
                            cache: false,
                            timeout: 300000,
                            success: function (response1) {
                                for (const key in response) {
                                    const element = response[key];
                                    for (const key1 in element) {
                                        const vis = element[key1];
                                        let idV=-1;
                                        vis.forEach(d => {
                                            let num = datosReportesTotal.length;
                                            if(idV!=d["PRO_ID"]){
                                                idV= d["PRO_ID"];
                                                let pro = response1[key][key1][idV];
                                                for (const kc in datosCli) {
                                                    const clien = datosCli[kc];
                                                    if(clien["CLI_CODIGOID"]==key1){
                                                        for (const ka in datosAse) {
                                                            const ase = datosAse[ka];
                                                            if(ase["USU_CLIENTES"]!=undefined){
                                                                for (const kac in ase["USU_CLIENTES"]) {
                                                                    if(kac==key1){
                                                                        datosReportesTotal.push([
                                                                            pro["PRO_TIPO"],
                                                                            ase["USU_NOMBRES"],
                                                                            ase["USU_PIN"],
                                                                            ase["USU_DNI"],
                                                                            ase["USU_DIRECCION"],
                                                                            clien["CLI_NOMBRE"],
                                                                            clien["CLI_CODIGO"],
                                                                            clien["CLI_DIRECCION"],
                                                                            clien["CLI_EMAIL"],
                                                                            pro["PRO_FECHA"],
                                                                            pro["PRO_HORA"],
                                                                            pro["PRO_OBSERVACION"],
                                                                            d["VIS_VENTA"],
                                                                            d["VIS_COBRANZA"],
                                                                            d["VIS_OTROS"],
                                                                            d["VIS_OBSERVACION"],
                                                                            clien["CLI_LAT"],
                                                                            clien["CLI_LON"],
                                                                            d["VIS_LAT"],
                                                                            d["VIS_LON"],
                                                                            ase["USU_REFERENCIA"]
                                                                        ]);   
                                                                        break;
                                                                    }
                                                                }
                                                            }
                                                            if(datosReportesTotal.length!=num) break;
                                                        }
                                                    }
                                                    if(datosReportesTotal.length!=num) break;
                                                }
                                            }
                                        });
                                    }
                                }
                                setTimeout(function(){
                                    $('#reportesTable').html(generarTablaReportesManual(datosReportesTotal));
                                    $('#datatable-reportesData').DataTable();
                                }, 500);  
                            }
                        });
                    }
                });
            } 
        }
    }
};

let j = 1;
//GENERACIÓN DE TABLA ACTIVIDAD - ASESORES
function generarTablaAsesoresManual(data, admi) {
    j=1;
    let tabla = '<table id="datatable-asesoresData" class="table table-bordered" width="100%" cellspacing="0"><thead><tr><th>Asesor</th><th>Clientes</th><th>P. Comercial</th><th>P. Semanal</th><th>Tareas</th><th>Ventas</th>';
    if(rol=="SUPER ADMINISTRADOR"||rol=="ADMINISTRADOR")
        tabla+='<th>Rol</th>';
    tabla += '<th>Permisos</th><th>Estado</th></tr></thead><tbody>';
    tabla+=contenidoTablaAsesoresManual(data);
    tabla+=contenidoTablaAsesoresManual(admi);
    tabla += '</tbody></table>';
    return tabla;
}

function contenidoTablaAsesoresManual(data) {
    let tabla='';
    for (const key in data) {
        j++;
        const e = data[key];
        const x = e["ACTIVO"];
        if (e.USU_ESTADO) {
            if(e.USU_SUPERVISOR!="" && $(`#asesRegistr option[value='${e.USU_REFERENCIA}']`).length == 0)
                $('#asesRegistr').append($('<option />', {
                    text: `${e.USU_NOMBRES}`,
                    value: `${e.USU_REFERENCIA}`,
                }));
            let estado = false;
            let color='bgcolor="#FFFFFF"';
            if(rol=="SUPER ADMINISTRADOR"){//|| rol=="ADMINISTRADOR"){
                if(e.USU_TIPO == 0 && e.USU_SUPERVISOR==""){
                    estado=true;
                }else{
                    if(e.USU_SUPERVISOR!=""){
                        color='bgcolor="#8FD8FF"';
                        estado=true;
                    }else{
                        if(e.USU_TIPO==2){
                            color='bgcolor="#FFF157"';
                            estado=true;
                        }
                    }
                }
            }else{
                if(rol == "ADMINISTRADOR"){
                    if(e.USU_TIPO == 0 && e.USU_SUPERVISOR == ""){
                        estado = true;
                    }
                }else{
                    if(ref==e.USU_SUPREFERENCIA && (e.USU_TIPO==0 && e.USU_SUPERVISOR==""))
                        estado=true;
                }
            }
            
            if(estado){
                let client = JSON.stringify(e.USU_CLIENTES);
                if(client==undefined) client = -1;
                tabla += '<tr>';
                tabla += `<td style="color:#000000;" ${color}>${e.USU_NOMBRES}</td>`;
                tabla += `<td style="color:#000000;" ${color}><button onclick='llenarClientes(${client})' class="btn btn-round btn-primary" data-toggle="modal" data-target="#clientes"><span class="fa fa-users"></span></button></td>`;
                tabla += `<td style="color:#000000;" ${color}><button onclick="llenarPlanC('${e.USU_PIN}');" class="btn btn-round btn-primary" data-toggle="modal" data-target="#planC"><span class="icons icon-doc"></span></button></td>`;
                tabla += `<td style="color:#000000;" ${color}><button onclick='llenarSemana(${client});' class="btn btn-round btn-primary" data-toggle="modal" data-target="#semana"><span class="fa fa-calendar-o"></span></button></td>`;
                tabla += `<td style="color:#000000;" ${color}><button onclick='llenarTareas(${client});' class="btn btn-round btn-primary" data-toggle="modal" data-target="#tareas"><span class="fa fa-check-square-o"></span></button></td>`;
                tabla += `<td style="color:#000000;" ${color}><button onclick='llenarVentas(${client});' class="btn btn-round btn-primary" data-toggle="modal" data-target="#ventas"><span class="icons icon-bag"></span></button></td>`;
                if(rol=="SUPER ADMINISTRADOR"||rol=="ADMINISTRADOR")
                    tabla += `<td style="width:80px;color:#000000; ${color}"><button class="btn ripple-infinite btn-round btn-warning" onclick="llenarAsesorDatos('${e.USU_SUPERVISOR}','${e.USU_SUPREFERENCIA}','${e.USU_REFERENCIA}')" data-toggle="modal" data-target="#privilegio"><i class="icons icon-star"></i></button></td>`;
                
                tabla += `<td style="width:80px;color:#000000;">`;
                tabla += `<div class="mini-onoffswitch onoffswitch-info">`;
                if(x)
                    tabla += `<input type="checkbox" name="onoffswitch1${j}" class="onoffswitch-checkbox" id="myonoffswitch1${j}" checked disabled>`;
                else
                    tabla += `<input onchange='changeCheckbox("myonoffswitch1${j}", "${e.USU_REFERENCIA}", ${client})' type="checkbox" name="onoffswitch1${j}" class="onoffswitch-checkbox" id="myonoffswitch1${j}">`;
                tabla += `<label class="onoffswitch-label" for="myonoffswitch1${j}"></label>`;
                if(x)
                    tabla += `<td bgcolor="#5CFF6F" style="width:80px;color:#000000;">`;
                else
                    tabla += `<td bgcolor="#FF5C5C" style="width:80px;color:#000000;">`;
                tabla += '</div></td></tr>';
            }
        }
    }
    return tabla;
}

function generarTablaReportesManual(data) {
    let tabla = '<table id="datatable-reportesData" class="table table-bordered" width="100%" cellspacing="0"><thead><tr><th>Asesor</th><th>PIN</th><th>Cliente</th><th>Código</th><th>Fecha</th><th>Hora</th><th>Venta</th><th>Cobro</th><th>Otros</th><th>Información</th></tr></thead>';
    for (const key in data) {
        const e = data[key];
        if(e[0]==0)
            tabla += '<tr bgcolor="#ADA7AF">'; //TAREAS
        if(e[0]==1)
            tabla += '<tr bgcolor="#CBE6CB">'; //PROGRAMADOS
        if(e[0]==2)
            tabla += '<tr bgcolor="#C6FCFC">'; //NO PROGRAMADOS
        if(e[0]==3)
            tabla += '<tr bgcolor="#F0B7BC">'; //REPROGRAMADOS
        tabla += `<td style="color:#000000;">${e[1]}</td>`;
        tabla += `<td style="color:#000000;">${e[2]}</td>`;
        tabla += `<td style="color:#000000;">${e[5]}</td>`;
        tabla += `<td style="color:#000000;">${e[6]}</td>`;
        tabla += `<td style="color:#000000;">${e[9]}</td>`;
        tabla += `<td style="color:#000000;">${e[10]}</td>`;
        tabla += `<td style="color:#000000;">${decDos(e[12])}</td>`;
        tabla += `<td style="color:#000000;">${decDos(e[13])}</td>`;
        tabla += `<td style="color:#000000;">${decDos(e[14])}</td>`;
        tabla += `<td style="color:#000000;"><button onclick="informVentas('${e[1]}','${e[2]}','${e[3]}','${e[4]}','${e[5]}','${e[6]}','${e[7]}','${e[8]}','${e[9]}','${e[10]}','${e[11]}','${decDos(e[12])}','${decDos(e[13])}','${decDos(e[14])}','${e[15]}');" class="btn btn-round btn-primary" data-toggle="modal" data-target="#inform"><span class="fa fa-plus"></span></button></td>`;
        tabla += '</tr>';
    }
    tabla += '</tbody></table>';
    return tabla;
}

function generarTablaHistorialManual(data) {
    let tabla = '<table id="datatable-historialData" class="table table-striped table-bordered" width="100%" cellspacing="0"><thead><tr><th>Asesor</th><th>Clientes</th><th>P. Semanal</th><th>Tareas</th><th>Ventas</th></tr></thead><tbody>';
    for (const key in data) {
        const e = data[key];
        if (e.USU_ESTADO) {
            let comp = false;
            if(ref==e.USU_SUPREFERENCIA || e.USU_SUPREFERENCIA==""){
                if(e.USU_TIPO == 0 && e.USU_SUPERVISOR==""){
                    comp = true;
                }
            }
            if(rol=="SUPER ADMINISTRADOR" && e.USU_TIPO == 0){
                comp = true;
            }
            if(comp){
                let client = JSON.stringify(e.USU_CLIENTES);
                if(client==undefined) client = -1;
                tabla += '<tr>';
                tabla += `<td style="color:#000000;">${e.USU_NOMBRES}</td>`;
                tabla += `<td style="color:#000000;"><button onclick='llenarClientesC(${client})' class="btn btn-round btn-primary" data-toggle="modal" data-target="#clientes"><span class="fa fa-users"></span></td>`;
                tabla += `<td style="color:#000000;"><button onclick='llenarSemanaC(${client});' class="btn btn-round btn-primary" data-toggle="modal" data-target="#semana"><span class="fa fa-calendar-o"></span></button></td>`;
                tabla += `<td style="color:#000000;"><button onclick='llenarTareasC(${client});' class="btn btn-round btn-primary" data-toggle="modal" data-target="#tareas"><span class="fa fa-check-square-o"></span></button></td>`;
                tabla += `<td style="color:#000000;"><button onclick='llenarVentasC(${client});' class="btn btn-round btn-primary" data-toggle="modal" data-target="#ventas"><span class="icons icon-bag"></span></button></td>`;
                tabla += '</tr>';
            }
        }
    }
    tabla += '</tbody></table>';
    return tabla;
}

function generarTablaCatalogoManual(data) {
    let tabla = '<table id="datatable-catalogoData" class="table table-striped table-bordered" width="100%" cellspacing="0"><thead><tr><th>Producto</th><th>Código</th><th>Descrip.</th><th>P. Lista</th><th>P.Asesores</th><th>P. Comercial</th><th>P.Jefatura</th><th>P. Mejores</th><th>P.Autorizado</th></tr></thead><tbody>';
    for (const key in data) {
        const e = data[key];
        if (e.CAT_ESTADO) {
            tabla += '<tr>';
            tabla += `<td style="width:250px;color:#000000;">${e.CAT_NOMBRE}</td>`;
            tabla += `<td style="width:100px;color:#000000;">${e.CAT_CODIGO}</td>`;
            tabla += `<td style="width:200px;color:#000000;">${e.CAT_DESCRIPCION}</td>`;
            tabla += `<td style="color:#000000;">${decDos(e.CAT_PRECIOA)}</td>`;
            tabla += `<td style="color:#000000;">${decDos(e.CAT_PRECIOB)}</td>`;
            tabla += `<td style="color:#000000;">${decDos(e.CAT_PRECIOC)}</td>`;
            tabla += `<td style="color:#000000;">${decDos(e.CAT_PRECIOD)}</td>`;
            tabla += `<td style="color:#000000;">${decDos(e.CAT_PRECIOE)}</td>`;
            tabla += `<td style="color:#000000;">${decDos(e.CAT_PRECIOF)}</td>`;
            tabla += '</tr>';
        }
    }
    tabla += '</tbody></table>';
    return tabla;
}

function generarTablaClientesManual(data, usuario) {
    let tabla = '<table id="datatable-clientesData" class="table table-striped table-bordered" width="100%" cellspacing="0"><thead><tr><th>Cliente</th><th>Asesor</th><th>Código</th><th>Dirección</th><th>Teléfono</th><th>Móvil</th><th>Atención</th><th>Latitud</th><th>Longitud</th><th>Foto</th><th>Acciones</th></tr></thead><tbody>';
    usuario.forEach(u => {
        if(u["USU_CLIENTES"]!=null){
            for (const k in u["USU_CLIENTES"]) {
                const element = u["USU_CLIENTES"][k];
                if(element[element.length-1]["FECHAH"]==""){
                    let cli = busquedaBinaria(data, k);
                    if(cli.CLI_ESTADO){
                        tabla += '<tr>';
                        tabla += `<td style="width:250px;color:#000000;">${cli.CLI_NOMBRE}</td>`;
                        tabla += `<td style="width:250px;color:#000000;">${u["USU_NOMBRES"]??''}</td>`;
                        tabla += `<td style="width:100px;color:#000000;">${cli.CLI_CODIGO}</td>`;
                        tabla += `<td style="width:200px;color:#000000;">${cli.CLI_DIRECCION}</td>`;
                        tabla += `<td style="color:#000000;">${cli.CLI_TELEFONO}</td>`;
                        tabla += `<td style="color:#000000;">${cli.CLI_MOBIL}</td>`;
                        tabla += `<td style="color:#000000;">${cli.CLI_HORAD}/${cli.CLI_HORAH}</td>`;
                        tabla += `<td style="color:#000000;">${cli.CLI_LAT}</td>`;
                        tabla += `<td style="color:#000000;">${cli.CLI_LON}</td>`;
                        tabla += `<td style="color:#000000;"><button class="btn btn-round btn-primary" data-toggle="modal" data-target="#foto" onclick="cambiarImagen('${cli.CLI_FOTO}');"><span class="icons icon-picture"></span></button></td>`;
                        tabla += `<td style="width:150px;color:#000000;"><button class="btn btn-round btn-warning" data-toggle="modal" data-target="#config" onclick="llenarCliente('${base_url}', '${cli.CLI_CODIGOID}', '${cli.CLI_NOMBRE}', '${cli.CLI_DIRECCION}', '${cli.CLI_EMAIL}', '${cli.CLI_TELEFONO}', '${cli.CLI_MOBIL}', '${cli.CLI_HORAD}', '${cli.CLI_HORAH}', '${cli.CLI_LAT}', '${cli.CLI_LON}', '${cli.CLI_FOTO}', '${cli.CLI_CODIGO}');"><span class="icons icon-settings"></span></button><button class="btn btn-round btn-danger" onclick="eliminarCliente('${base_url}', '${cli.CLI_CODIGOID}');"><span class="icons icon-trash"></span></button></td>`;
                        tabla += '</tr>';
                    }
                }
            }
        }
    });
    tabla += '</tbody></table>';
    return tabla;
}

function busquedaBinaria(list, busq) {
    if(!isNaN(busq)){
        let first = 0;
        let last = list.length - 1;
        let position = {};
        let found = false;
        let middle;
        while (found === false && first <= last) {
            middle = Math.floor((first + last)/2);
            if (list[middle]["CLI_CODIGOID"] == busq) {
                found = true;
                position = list[middle];
            } else if (list[middle]["CLI_CODIGOID"] > busq) {
                last = middle - 1;
            } else {
                first = middle + 1;
            }
        }
        return position;
    }else{
        let position = {};
        for (let index = list.length - 1; index >= 0; index--) {
            const element = list[index];
            if(element["CLI_CODIGOID"] == busq){
                position = element;
                break;
            }
        }
        return position;
    }
}