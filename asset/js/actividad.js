var idExp = -1;
var idU = -1;
var referencia = "";

function changeCheckbox(idCheck, idU, idAs) {
    var opcion = confirm("¿Estás seguro de darle permiso a este usuario?");
    if (opcion) {
        if(idAs==-1){
            alert("NO TIENE CLIENTES ASIGNADOS");
            document.getElementById(idCheck).disabled = false;
            $("#" + idCheck).prop("checked", false);
        }else{
            let fechaAct = fechaActual();
            var data = {
                CLI_CODIGOID: Object.keys(idAs)[0],
                PRO_ESTADO: 1,
                PRO_FECHA: fechaAct,
                PRO_HORA: "",
                PRO_ID: 0,
                PRO_OBSERVACION: "",
                PRO_TIPO: 1
            }
            firebase.database().ref(`tbl_programacion/${fechaAct}/${Object.keys(idAs)[0]}/0`).set(data);
            alert("PERMISO CONCEDIDO");
            document.getElementById(idCheck).disabled = true;
            $("#" + idCheck).prop("checked", true);
        }
    } else {
        document.getElementById(idCheck).disabled = false;
        $("#" + idCheck).prop("checked", false);
    }
}

function llenarAsesorDatos(sup, ref,rf) {
    if(sup!="")
        $("#supRadi").prop("checked", true);
    else
        if(ref!=""){
            $("#aseRadi").prop("checked", true);
            $("#elementSuper").css("display", "block");
            $("#asesRegistr").val(ref).trigger('change.select2');
        }
    idU = rf;
    referencia=rf;
}

$('#radioForm input').on('change', function() {
    var res=$('input[name=rolAsig]:checked', '#radioForm').val();
    if(res=="asesor"){
        $("#elementSuper").css("display", "block");
    }else{
        $("#elementSuper").css("display", "none");
    } 
 });

 function nuevoPrivilegio() {
    var res=$('input[name=rolAsig]:checked', '#radioForm').val();
    var idA = "";
    var tip = 1;
    if(res=="asesor"){
        idA = $('#asesRegistr option:selected').val();
        if(idA==-1){
            alert("No ha escogido ningun supervisor");
            return;
        }
        referencia="";
        tip = 0;
    }
    firebase.database().ref(`tbl_usuario/megaadmin/${idU}/USU_SUPERVISOR`).set(referencia);//.catch((error) => {alert(error);});
    firebase.database().ref(`tbl_usuario/asesores/${idU}/USU_SUPERVISOR`).set(referencia);//.catch((error) => {alert(error);});
    firebase.database().ref(`tbl_usuario/asesores/${idU}/USU_USU_TIPO`).set(tip);//.catch((error) => {alert(error);});
    firebase.database().ref(`tbl_usuario/asesores/${idU}/USU_SUPREFERENCIA`).set(idA);//.catch((error) => {alert(error);});
    alert("GUARDADO");
    location.reload();
}

function fechaActual() {
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
    var yyyy = today.getFullYear();
    return yyyy + "-" + mm + "-" + dd;
}

function llenarVentas(idA) {
    $("#ventasTB").html("");
    let cont = 1;
    var lunes = fechaLunes();
    var dbRefD = firebase.database().ref('tbl_visitados').limitToLast(14);
    dbRefD.get().then((snapshot1)=>{
        if(snapshot1.exists()){
            let visitasC= snapshot1.val();
            for (let index = 0; index < 7; index++) {
                var dia = new Date(lunes.getFullYear(), lunes.getMonth(), lunes.getDate());
                dia.setDate(lunes.getDate() + index);
                let fechaAc = dia.toISOString().split('T')[0];
                let visita = visitasC[`${fechaAc}`];
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

function llenarTareas(idA) {
    $("#tareaTB").html("");
    let cont = 1;
    var lunes = fechaLunes();
    var domingo = new Date(lunes.getFullYear(), lunes.getMonth(), lunes.getDate());
    domingo.setDate(lunes.getDate() + 6);
    const dbRef = firebase.database().ref();
    dbRef.child("tbl_tarea").get().then((snapshot) => {
        if (snapshot.exists()) {
            var valores = snapshot.val();
            valores.forEach(element => {
                for (const key in idA) {
                    const e = idA[key];
                    if(e[e.length-1]["ESTADO"]){
                        var fecha = Date.parse(element["TAR_FECHA"]);
                        if (element["CLI_CODIGOID"] == key && fecha >= lunes && fecha <= domingo) {
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

function llenarClientes(idA) {
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

function llenarSemana(idA) {
    $("#semanaTB").html("");
    let cont = 1;
    var lunes = fechaLunes();
    var starCountRef = firebase.database().ref('tbl_programacion').limitToLast(14);
    starCountRef.get().then((snapshot) => {
        if (snapshot.exists()) {
            let dato = snapshot.val();
            for (let index = 0; index < 7; index++) {
                var dia = new Date(lunes.getFullYear(), lunes.getMonth(), lunes.getDate());
                dia.setDate(lunes.getDate() + index);
                let datos = dato[`${dia.toISOString().split('T')[0]}`];
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

//VERSIÓN ANTIGUA DE PLAN COMERCIAL SI REQUIERE EL NUEVO MODELO SE DEBE DE DESCARGAR DEL YA SUBIDO
function llenarPlanC(pin) {
    $("#DK").text("");
    $("#B").text("");
    $("#C").text("");
    $("#H").text("");
    $("#G").text("");
    $("#DL").text("");
    $("#D").text("");
    $("#E").text("");
    $("#F").text("");
    $("#I").text("");
    $("#J").text("");
    $("#K").text("");
    $("#L").text("");
    $("#M").text("");
    $("#N").text("");
    $("#O").text("");
    $("#sumaPremio").text("");
    $("#sumaPremioTotal").text("");
    $("#P").text("");
    $("#Q").text("");
    $("#R").text("");
    $("#S").text("");
    $("#T").text("");
    $("#U").text("");
    $("#V").text("");
    $("#W").text("");
    $("#X").text("");
    $("#Y").text("");
    $("#Z").text("");
    $("#AA").text("");
    $("#AB").text("");
    $("#AC").text("");
    $("#AD").text("");
    $("#AE").text("");
    $("#AF").text("");
    $("#AG").text("");
    $("#AH").text("");
    $("#AI").text("");
    $("#AJ").text("");
    $("#AK").text("");
    $("#AL").text("");
    $("#AM").text("");
    $("#AN").text("");
    $("#AO").text("");
    $("#AP").text("");
    $("#AQ").text("");
    $("#AR").text("");
    $("#AS").text("");
    $("#AT").text("");
    $("#AU").text("");
    $("#AV").text("");
    $("#AW").text("");
    $("#AX").text("");
    $("#AY").text("");
    $("#AZ").text("");
    $("#BA").text("");
    $("#BB").text("");
    $("#BC").text("");
    $("#BD").text("");
    $("#BE").text("");
    $("#BF").text("");
    $("#BG").text("");
    $("#BH").text("");
    $("#BI").text("");
    $("#BJ").text("");
    $("#BK").text("");
    $("#BL").text("");
    $("#BM").text("");
    $("#BN").text("");
    $("#BO").text("");
    $("#BP").text("");
    $("#BQ").text("");
    $("#BR").text("");
    $("#BS").text("");
    $("#BT").text("");
    $("#BU").text("");
    $("#BV").text("");
    $("#BW").text("");
    $("#BX").text("");
    $("#BY").text("");
    $("#BZ").text("");
    $("#CA").text("");
    $("#CB").text("");
    $("#CC").text("");
    $("#CD").text("");
    $("#CE").text("");
    $("#CF").text("");
    $("#CG").text("");
    $("#CH").text("");
    $("#CI").text("");
    $("#CJ").text("");
    $("#CK").text("");
    $("#CL").text("");
    $("#CM").text("");
    $("#CN").text("");
    $("#CO").text("");
    $("#CP").text("");
    $("#CQ").text("");
    $("#CW").text("");
    $("#CX").text("");
    $("#CY").text("");
    $("#CZ").text("");
    $("#DA").text("");
    $("#DB").text("");
    $("#DC").text("");
    $("#DD").text("");
    $("#DE").text("");
    $("#DF").text("");
    $("#CR").text("");
    $("#CS").text("");
    $("#CU").text("");
    $("#CV").text("");
    $("#CT").text("");
    $("#conteo").text("");
    $("#conteo1").text("");
    $("#conteo2").text("");
    $("#conteo3").text("");
    $("#porcent").text("");
    $("#porcent1").text("");
    $("#porcent2").text("");
    $("#tbl8TB").html("");
    const dbRef = firebase.database().ref();
    dbRef.child("tbl_plancomercial").child(pin).get().then((snapshot) => {
        if (snapshot.exists()) {
            var valores = snapshot.val();
            dbRef.child("tbl_plancomercialclientes").child(pin).get().then((snapshot1) => {
                if (snapshot1.exists()) {
                    var valores1 = snapshot1.val();
                    var sumaPremio = cambioFloat(valores["S"]) +
                        cambioFloat(valores["X"]) +
                        cambioFloat(valores["AC"]) +
                        cambioFloat(valores["AH"]) +
                        cambioFloat(valores["AM"]) +
                        cambioFloat(valores["AR"]) +
                        cambioFloat(valores["AW"]) +
                        cambioFloat(valores["BB"]) +
                        cambioFloat(valores["BG"]) +
                        cambioFloat(valores["BL"]) +
                        cambioFloat(valores["BQ"]) +
                        cambioFloat(valores["BV"]) +
                        cambioFloat(valores["CA"]) +
                        cambioFloat(valores["CF"]) +
                        cambioFloat(valores["CK"]) +
                        cambioFloat(valores["CP"]);
                    var sumaPremioTotal = cambioFloat(valores["T"]) +
                        cambioFloat(valores["Y"]) +
                        cambioFloat(valores["AD"]) +
                        cambioFloat(valores["AI"]) +
                        cambioFloat(valores["AN"]) +
                        cambioFloat(valores["AS"]) +
                        cambioFloat(valores["AX"]) +
                        cambioFloat(valores["BC"]) +
                        cambioFloat(valores["BH"]) +
                        cambioFloat(valores["BM"]) +
                        cambioFloat(valores["BR"]) +
                        cambioFloat(valores["BW"]) +
                        cambioFloat(valores["CB"]) +
                        cambioFloat(valores["CG"]) +
                        cambioFloat(valores["CL"]) +
                        cambioFloat(valores["CQ"]);
                    $("#DK").text(valores["DK"]);
                    $("#B").text(valores["B"]);
                    $("#C").text(valores["C"]);
                    $("#H").text(valores["H"]);
                    $("#G").text(valores["G"]);
                    $("#DL").text(valores["DL"]);
                    $("#D").text(valores["D"]);
                    $("#E").text(valores["E"]);
                    $("#F").text(numberDecimal((valores["F"]*100))+"%");
                    $("#I").text(valores["I"]);
                    $("#J").text(valores["J"]);
                    $("#K").text(valores["K"]);
                    $("#L").text(valores["L"]);
                    $("#M").text(numberDecimal((valores["M"]*100))+"%");
                    $("#N").text(valores["N"]);
                    $("#O").text(valores["O"]);
                    $("#sumaPremio").text(sumaPremio);
                    $("#sumaPremioTotal").text(sumaPremioTotal);
                    $("#P").text(valores["P"]);
                    $("#Q").text(valores["Q"]);
                    $("#R").text(numberDecimal((valores["R"]*100))+"%");
                    $("#S").text(valores["S"]);
                    $("#T").text(valores["T"]);
                    $("#U").text(valores["U"]);
                    $("#V").text(valores["V"]);
                    $("#W").text(numberDecimal((valores["W"]*100))+"%");
                    $("#X").text(valores["X"]);
                    $("#Y").text(valores["Y"]);
                    $("#Z").text(valores["Z"]);
                    $("#AA").text(valores["AA"]);
                    $("#AB").text(numberDecimal((valores["AB"]*100))+"%");
                    $("#AC").text(valores["AC"]);
                    $("#AD").text(valores["AD"]);
                    $("#AE").text(valores["AE"]);
                    $("#AF").text(valores["AF"]);
                    $("#AG").text(numberDecimal((valores["AG"]*100))+"%");
                    $("#AH").text(valores["AH"]);
                    $("#AI").text(valores["AI"]);
                    $("#AJ").text(valores["AJ"]);
                    $("#AK").text(valores["AK"]);
                    $("#AL").text(numberDecimal((valores["AL"]*100))+"%");
                    $("#AM").text(valores["AM"]);
                    $("#AN").text(valores["AN"]);
                    $("#AO").text(valores["AO"]);
                    $("#AP").text(valores["AP"]);
                    $("#AQ").text(numberDecimal((valores["AQ"]*100))+"%");
                    $("#AR").text(valores["AR"]);
                    $("#AS").text(valores["AS"]);
                    $("#AT").text(valores["AT"]);
                    $("#AU").text(valores["AU"]);
                    $("#AV").text(numberDecimal((valores["AV"]*100))+"%");
                    $("#AW").text(valores["AW"]);
                    $("#AX").text(valores["AX"]);
                    $("#AY").text(valores["AY"]);
                    $("#AZ").text(valores["AZ"]);
                    $("#BA").text(numberDecimal((valores["BA"]*100))+"%");
                    $("#BB").text(valores["BB"]);
                    $("#BC").text(valores["BC"]);
                    $("#BD").text(valores["BD"]);
                    $("#BE").text(valores["BE"]);
                    $("#BF").text(numberDecimal((valores["BF"]*100))+"%");
                    $("#BG").text(valores["BG"]);
                    $("#BH").text(valores["BH"]);
                    $("#BI").text(valores["BI"]);
                    $("#BJ").text(valores["BJ"]);
                    $("#BK").text(numberDecimal((valores["BK"]*100))+"%");
                    $("#BL").text(valores["BL"]);
                    $("#BM").text(valores["BM"]);
                    $("#BN").text(valores["BN"]);
                    $("#BO").text(valores["BO"]);
                    $("#BP").text(numberDecimal((valores["BP"]*100))+"%");
                    $("#BQ").text(valores["BQ"]);
                    $("#BR").text(valores["BR"]);
                    $("#BS").text(valores["BS"]);
                    $("#BT").text(valores["BT"]);
                    $("#BU").text(numberDecimal((valores["BU"]*100))+"%");
                    $("#BV").text(valores["BV"]);
                    $("#BW").text(valores["BW"]);
                    $("#BX").text(valores["BX"]);
                    $("#BY").text(valores["BY"]);
                    $("#BZ").text(numberDecimal((valores["BZ"]*100))+"%");
                    $("#CA").text(valores["CA"]);
                    $("#CB").text(valores["CB"]);
                    $("#CC").text(valores["CC"]);
                    $("#CD").text(valores["CD"]);
                    $("#CE").text(numberDecimal((valores["CE"]*100))+"%");
                    $("#CF").text(valores["CF"]);
                    $("#CG").text(valores["CG"]);
                    $("#CH").text(valores["CH"]);
                    $("#CI").text(valores["CI"]);
                    $("#CJ").text(numberDecimal((valores["CJ"]*100))+"%");
                    $("#CK").text(valores["CK"]);
                    $("#CL").text(valores["CL"]);
                    $("#CM").text(valores["CM"]);
                    $("#CN").text(valores["CN"]);
                    $("#CO").text(numberDecimal((valores["CO"]*100))+"%");
                    $("#CP").text(valores["CP"]);
                    $("#CQ").text(valores["CQ"]);
                    $("#CW").text(valores["CW"]);
                    $("#CX").text(valores["CX"]);
                    $("#CY").text(numberDecimal((valores["CY"]*100))+"%");
                    $("#CZ").text(valores["CZ"]);
                    $("#DA").text(valores["DA"]);
                    $("#DB").text(valores["DB"]);
                    $("#DC").text(valores["DC"]);
                    $("#DD").text(numberDecimal((valores["DD"]*100))+"%");
                    $("#DE").text(valores["DE"]);
                    $("#DF").text(valores["DF"]);
                    $("#CR").text(valores["CR"]);
                    $("#CS").text(valores["CS"]);
                    $("#CU").text(valores["CU"]);
                    $("#CV").text(valores["CV"]);
                    $("#CT").text(numberDecimal((valores["CT"]*100))+"%");
                    //PORCENTAJE : 532
                    var contendor = $("#tbl8TB").html();
                    var nuevaFila = "";
                    var el = burbuja(valores1);
                    var cont1 = 0;
                    var cont2 = 0;
                    var cont3 = 0;
                    var cont4 = 0;
                    el.forEach(element => {
                        nuevaFila += "<tr>";
                        nuevaFila += '<th bgcolor="#FFFFFF" style="color: #0E1057; width: 80px; border-color:#2604FF;">' + element["C"] + '</th>';
                        nuevaFila += '<th bgcolor="#FFFFFF" style="color: #0E1057; width: 250px; border-color:#2604FF;">' + element["D"] + '</th>';
                        nuevaFila += '<th bgcolor="#FFFFFF" style="color: #0E1057; width: 110px; border-color:#2604FF;">' + element["E"] + '</th>';
                        if (element["E"] < 500) {
                            if (element["E"] <= 0) {
                                cont4++;
                            } else {
                                cont3++;
                            }
                            nuevaFila += '<th colspan="2" bgcolor="#FF3838" style="color: #0E1057; width: 80px; border-color:#2604FF;"></th>';
                            nuevaFila += '<th colspan="2" bgcolor="#FFFFFF" style="color: #0E1057; width: 80px; border-color:#2604FF;"> < 500</th>';
                        } else {
                            if (element["E"] < 1000) {
                                cont2++;
                                nuevaFila += '<th colspan="2" bgcolor="#FCF534" style="color: #0E1057; width: 80px; border-color:#2604FF;"></th>';
                                nuevaFila += '<th colspan="2" bgcolor="#FFFFFF" style="color: #0E1057; width: 80px; border-color:#2604FF;"> Entre 500 y 999</th>';
                            } else {
                                cont1++;
                                nuevaFila += '<th colspan="2" bgcolor="#2FFF40" style="color: #0E1057; width: 80px; border-color:#2604FF;"></th>';
                                nuevaFila += '<th colspan="2" bgcolor="#FFFFFF" style="color: #0E1057; width: 80px; border-color:#2604FF;"> > a $1000</th>';
                            }
                        }
                        nuevaFila += "</tr>";
                    });
                    $("#tbl8TB").html(contendor + nuevaFila);
                    $("#conteo").text(cont1);
                    $("#conteo1").text(cont2);
                    $("#conteo2").text(cont3);
                    $("#conteo3").text(cont4);
                    $("#porcent").text((numberDecimal((cont1 * 100) / parseFloat(valores["CR"]))) + "%");
                    $("#porcent1").text((numberDecimal((cont2 * 100) / parseFloat(valores["CR"]))) + "%");
                    $("#porcent2").text((numberDecimal(((cont3 + cont4) * 100) / parseFloat(valores["CR"]))) + "%");
                } else {
                    alert("No tiene datos registrado");
                }
            });
        } else {
            alert("No tiene datos registrado");
        }
    });
}

function cambioFloat(valor) {
    var num = valor;
    var n = parseFloat(num);
    return n;
}

function burbuja(lista) {
    var n, i, k, aux;
    n = lista.length;
    for (k = 1; k < n; k++) {
        for (i = 0; i < (n - k); i++) {
            if (parseFloat(lista[i]["E"]) > parseFloat(lista[i + 1]["E"])) {
                aux = lista[i];
                lista[i] = lista[i + 1];
                lista[i + 1] = aux;
            }
        }
    }
    return lista;
}

function fechaLunes() {
    var fechaH = new Date();
    var fechaA = new Date();
    var cont = 0;
    var fechaComoCadena = fechaA.getFullYear().toString() + "-" + (fechaA.getMonth() + 1).toString() + "-" + (fechaA.getDate() - cont).toString() + " 00: 00: 00 ";
    var numeroDia = new Date(fechaComoCadena).getDay();
    for (let index = 0; index < 7; index++) {
        if (numeroDia != 1) {
            fechaA.setDate((fechaA.getDate() - 1));
            var fechaComoCadena = fechaA.getFullYear().toString() + "-" + (fechaA.getMonth() + 1).toString() + "-" + (fechaA.getDate() - cont).toString() + " 00: 00: 00 ";
            numeroDia = new Date(fechaComoCadena).getDay();
        }
    }
    return new Date(fechaComoCadena);
}

getKilometros = function(lat1, lon1, lat2, lon2) {
    rad = function(x) { return x * Math.PI / 180; }
    var R = 6378.137; //Radio de la tierra en km
    var dLat = rad(lat2 - lat1);
    var dLong = rad(lon2 - lon1);
    var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) + Math.cos(rad(lat1)) * Math.cos(rad(lat2)) * Math.sin(dLong / 2) * Math.sin(dLong / 2);
    var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    var d = R * c;
    return d.toFixed(3); //Retorna tres decimales
}