var idExp = -1;
var idU = -1;
var referencia = "";
let datosVentasTemp = [];
let datosProgSemanalTemp = [];
let datosTareasTemp = [];

function llenarVentasC(idA) {
    $("#ventasTB").html("");
    let cont = 1;
    var dbRefD = firebase.database().ref('tbl_visitados');
    dbRefD.get().then((snapshot1)=>{
        if(snapshot1.exists()){
            let visitasC= snapshot1.val();
            for (const fechaAc in visitasC) {
                const visita = visitasC[fechaAc];
                if(visita != undefined){
                    for (const key in idA) {
                        const cli = idA[key];
                        let visR = visita[key];
                        if(cli[cli.length-1]["ESTADO"] && visR!=undefined){
                            let idPro = -1;
                            let monto = [];
                            for (const key1 in visR) {
                                const datos = visR[key1];
                                if(idPro != datos["PRO_ID"] && (monto.length==0 || monto[0]!=datos["VIS_VENTA"] || monto[1]!=datos["VIS_COBRANZA"] || datos["VIS_OTROS"])){
                                    idPro = datos["PRO_ID"];
                                    monto = [datos["VIS_VENTA"], datos["VIS_COBRANZA"], datos["VIS_OTROS"]];
                                    var starCountRef = firebase.database().ref(`tbl_programacion/${fechaAc}/${key}/${idPro}`);
                                    starCountRef.get().then((snapshot) => {
                                        if(snapshot.exists()){
                                            let element=snapshot.val();
                                            const dbRef3 = firebase.database().ref();
                                            dbRef3.child("tbl_clientes").child(key).get().then((snapshot3) => {
                                                if (snapshot3.exists()) {
                                                    var valores3 = snapshot3.val();
                                                    var contendor = $("#ventasTB").html();
                                                    var nuevaFila = '<tr>';
                                                    nuevaFila += '<td style="color:#000000;">' + (cont++) + '</td>';
                                                    nuevaFila += '<td style="color:#000000;">' + valores3["CLI_NOMBRE"] + '</td>';
                                                    nuevaFila += '<td style="color:#000000;">' + valores3["CLI_CODIGO"] + '</td>';
                                                    nuevaFila += '<td style="color:#000000;">' + element["PRO_FECHA"] + '</td>';
                                                    nuevaFila += '<td style="color:#000000;">' + element["PRO_HORA"] + '</td>';
                                                    nuevaFila += '<td style="color:#000000;">' + datos["VIS_VENTA"] + '</td>';
                                                    nuevaFila += '<td style="color:#000000;">' + datos["VIS_COBRANZA"] + '</td>';
                                                    nuevaFila += '<td style="color:#000000;">' + datos["VIS_OTROS"] + '</td>';
                                                    nuevaFila += '<td style="color:#000000;">' + datos["VIS_OBSERVACION"] + '</td>';
                                                    var km = getKilometros(valores3["CLI_LAT"], valores3["CLI_LON"], datos["VIS_LAT"], datos["VIS_LON"]);
                                                    if (valores3["CLI_LAT"] == "" || valores3["CLI_LON"] == "")
                                                        nuevaFila += '<td style="color:#000000;" bgcolor="#FBFF1D"> Datos incompletos</td>';
                                                    else {
                                                        if (km <= 1)
                                                            nuevaFila += '<td style="color:#FFFFFF;" bgcolor="#1DFF96"></td>';
                                                        else
                                                            nuevaFila += '<td style="color:#FFFFFF;" bgcolor="#FF1D1D">'+km+' KM</td>';
                                                    }
                                                    nuevaFila += '</tr>';
                                                    $("#ventasTB").html(contendor + "<?php echo '" + nuevaFila + "'?>");
                                                }else
                                                    alert("NO SE A CARGADO LOS DATOS RECARGUE LA PÁGINA");
                                            });    
                                        }else
                                            alert("NO SE A CARGADO LOS DATOS, INTENTE MÁS TARDE");
                                    });
                                }
                            }
                        }
                    }
                }
            }
        }else
            alert("NO SE A CARGADO LOS DATOS");
    });
}

function llenarTareasC(idA) {
    $("#tareaTB").html("");
    let cont = 1;
    const dbRef = firebase.database().ref();
    dbRef.child("tbl_tarea").get().then((snapshot) => {
        if (snapshot.exists()) {
            var valores = snapshot.val();
            valores.forEach(element => {
                for (const key in idA) {
                    const e = idA[key];
                    if(e[e.length-1]["ESTADO"]){
                        if (element["CLI_CODIGOID"] == key) {
                            const dbRef2 = firebase.database().ref();
                            dbRef2.child("tbl_clientes").child(key).get().then((snapshot2) => {
                                if (snapshot2.exists()) {
                                    var valores2 = snapshot2.val();
                                    var contendor = $("#tareaTB").html();
                                    var nuevaFila = '<tr>';
                                    nuevaFila += '<td style="color:#000000;">' + (cont++) + '</td>';
                                    nuevaFila += '<td style="color:#000000;">' + valores2["CLI_NOMBRE"] + '</td>';
                                    nuevaFila += '<td style="color:#000000;">' + valores2["CLI_CODIGO"] + '</td>';
                                    nuevaFila += '<td style="color:#000000;">' + element["TAR_FECHA"] + '</td>';
                                    nuevaFila += '<td style="color:#000000;">' + element["TAR_VENDER"] + '</td>';
                                    nuevaFila += '<td style="color:#000000;">' + element["TAR_COBRAR"] + '</td>';
                                    nuevaFila += '<td style="color:#000000;">' + element["TAR_OTROS"] + '</td>';
                                    nuevaFila += '<td style="color:#000000;">' + element["TAR_DETALLE"] + '</td>';
                                    if (element["PRO_ID"] != -1)
                                        nuevaFila += '<td style="color:#000000;" bgcolor="#25ff1d"></td>';
                                    else {
                                        var fechaM = Date.parse(element["TAR_FECHA"]);
                                        var fechaA = Date.now();
                                        if (fechaA > fechaM) {
                                            nuevaFila += '<td bgcolor="#FF1D1D" style="color: #FFFFFF;">Tiempo excedido</td>';
                                        } else {
                                            nuevaFila += '<td bgcolor="#FBFF1D" style="color:#000000;"></td>';
                                        }
                                    }
                                    nuevaFila += '</tr>';
                                    $("#tareaTB").html(contendor + nuevaFila);
                                } else {
                                    console.log("Datos con problemas");
                                }
                            }).catch((error) => {
                                console.error(error);
                            });
                        }
                    }
                }
            });
        } else {
            console.log("No hay visitados");
        }
    }).catch((error) => {
        console.error(error);
    });
}

function llenarClientesC(idA) {
    $("#clientesTB").html("");
    var contendor = $("#clientesTB").html();
    let cont = 1;
    for (const key in idA) {
        const c = idA[key];
        if(c[c.length-1]["ESTADO"]){
            const dbRef1 = firebase.database().ref();
            dbRef1.child("tbl_clientes").child(key).get().then((snapshot1) => {
                if (snapshot1.exists()) {
                    var valores1 = snapshot1.val();
                    contendor = $("#clientesTB").html();
                    var nuevaFila = '<tr>';
                    nuevaFila += '<td style="color:#000000;">' + (cont++) + '</td>';
                    nuevaFila += '<td style="color:#000000;">' + valores1["CLI_NOMBRE"] + '</td>';
                    nuevaFila += '<td style="color:#000000;">' + valores1["CLI_CODIGO"] + '</td>';
                    nuevaFila += '<td style="color:#000000;">' + valores1["CLI_DIRECCION"] + '</td>';
                    nuevaFila += '<td style="color:#000000;">' + valores1["CLI_TELEFONO"] + '</td>';
                    nuevaFila += '<td style="color:#000000;">' + valores1["CLI_MOBIL"] + '</td>';
                    nuevaFila += '<td style="color:#000000;">' + valores1["CLI_HORAD"] + '/' + valores1["CLI_HORAH"] + '</td>';
                    nuevaFila += '</tr>';
                    $("#clientesTB").html(contendor + nuevaFila);
                } else {
                    console.log("Error en datos");
                }
            }).catch((error) => {
                console.error(error);
            }); 
        }   
    }
}

function llenarSemanaC(idA) {
    $("#semanaTB").html("");
    let cont = 1;
    var starCountRef = firebase.database().ref('tbl_programacion');
    starCountRef.get().then((snapshot) => {
        if (snapshot.exists()) {
            let dato = snapshot.val();
            for (const index in dato) {
                const datos = dato[index];
                if(datos != undefined){
                    for (const key in idA) {
                        const e = idA[key];
                        if(e[e.length-1]["ESTADO"] && datos[key] != undefined){
                            var dbref = firebase.database().ref(`tbl_clientes/${key}`);
                            dbref.get().then((snapshot1) => {
                                if(snapshot1.exists()){
                                    let valores2 = snapshot1.val();
                                    var contendor = $("#semanaTB").html();
                                    if (datos[key][datos[key].length-1]["PRO_TIPO"] == 0)
                                        var nuevaFila = '<tr bgcolor="#A98BB3">';
                                    if (datos[key][datos[key].length-1]["PRO_TIPO"] == 1)
                                        var nuevaFila = '<tr bgcolor="#A9FCFC">';
                                    if (datos[key][datos[key].length-1]["PRO_TIPO"] == 2)
                                        var nuevaFila = '<tr bgcolor="#96FF96">';
                                    if (datos[key][datos[key].length-1]["PRO_TIPO"] == 3)
                                        var nuevaFila = '<tr bgcolor="#F39199">';
                                    nuevaFila += '<td style="color:#000000;">' + (cont++) + '</td>';
                                    nuevaFila += '<td style="color:#000000;">' + valores2["CLI_NOMBRE"] + '</td>';
                                    nuevaFila += '<td style="color:#000000;">' + valores2["CLI_CODIGO"] + '</td>';
                                    nuevaFila += '<td style="color:#000000;">' + datos[key][datos[key].length-1]["PRO_FECHA"] + '</td>';
                                    nuevaFila += '<td style="color:#000000;">' + datos[key][datos[key].length-1]["PRO_HORA"] + '</td>';
                                    nuevaFila += '<td style="color:#000000;">' + datos[key][datos[key].length-1]["PRO_OBSERVACION"] + '</td>';
                                    if (datos[key][datos[key].length-1]["PRO_ESTADO"] == 0)
                                        nuevaFila += '<td style="color:#000000;" bgcolor="#1DFF96"></td>';
                                    else {
                                        var fecha1 = Date.parse(datos[key][datos[key].length-1]["PRO_FECHA"]);
                                        var fechaP = new Date();
                                        fechaP.setDate(fechaP.getDate() - 1);
                                        if (fechaP <= fecha1)
                                            nuevaFila += '<td style="color:#000000;" bgcolor="#FFF01D"></td>';
                                        else
                                            nuevaFila += '<td style="color:#FFFFFF;" bgcolor="#FF1D1D">Fuera de tiempo</td>';
                                    }
                                    nuevaFila += '</tr>';
                                    $("#semanaTB").html(contendor + nuevaFila);
                                }else{
                                    alert('MALA CONEXIÓN A INTERENT INTENTE MÁS TARDE');
                                }
                            });
                        }
                    }
                }
            }
        }else{
            alert('MALA CONEXIÓN A INTERENT INTENTE MÁS TARDE');
        }
    });
}