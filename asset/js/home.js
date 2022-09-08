/* 
OPCIONES A SELECCIONAR: 
-1 : POR DEFECTO ALERTA QUE INDIQUE QUE NO HA SELECCIONADO NINGUNA OPCIÓN
1  : ACTUALIZACIÓN DE ASESORES
2  : ACTUALIZACIÓN DE ADMIN MEGAPROFER
3  : QUITAR SUPERVISOR DE TODOS LOS ASESORES
4  : CAMBIAR SUPERVISOR POR OTRO SUPERVISOR EN TODOS LOS ASESORES
5  : ACTUALIZAR CLIENTES
6  : ACTUALIZAR CLIENTES DE LOS ASESORES
7  : ACTUALIZAR CATAGOlO DE PRODUCTOS
8  : ACTUALIZAR FACTURAS
9  : CREAR UN ASESOR O ADMIN MEGAPROFER
*/
function actualiza(option) {
    
    switch (option) {
        case 1: {
            let jsonData = []; //CAMBIAR CON DATOS RESULTANTES DE API DE MEGAPROFER
            jsonData.forEach(jD => {
                if (jD.referenceId != null || jD.referenceId != "") {
                    const ref = firebase.database().ref();
                    ref.child(`tbl_usuario/asesores/${jD.referenceId}`).get().then((snapshot) => {
                        if (snapshot.exists()) {
                            var datos = snapshot.val();
                            if (datos["USU_SUPERVISOR"] != "")
                                jD.isSupervisor = datos["USU_SUPERVISOR"];
                            if (datos["USU_SUPREFERENCIA"] != "")
                                jD.supervisorId = datos["USU_SUPREFERENCIA"];
                            if (datos["USU_USUARIO"] != "")
                                jD.userName = datos["USU_USUARIO"];
                            if (datos["USU_PASSWORD"] != "")
                                jD.password = datos["USU_PASSWORD"];
                            if (datos["USU_TIPO"] != "")
                                datosAsesor("asesores", jD, datos["USU_TIPO"]);
                            else
                                datosAsesor("asesores", jD, 0);
                        } else
                            datosAsesor("asesores", jD, 0);
                        console.log("COMPLETO!");
                    });
                } else {
                    console.log(jD);
                    alert("ASESOR NO CUENTA CON REFERENCIA ID NO SE PUEDE INGRESAR, REVISE LA CONSOLA");
                }
            });
            alert("COMPLETO!!!");
        }; break;
        case 2: {
            let jsonData = []; //CAMBIAR CON DATOS RESULTANTES DE API DE MEGAPROFER
            jsonData.forEach(jD => {
                if (jD.id_usuario != null || jD.id_usuario != "") {
                    const ref = firebase.database().ref();
                    ref.child(`tbl_usuario/megaadmin/${jD.id_usuario}`).get().then((snapshot) => {
                        if (snapshot.exists()) {
                            var datos = snapshot.val();
                            if (datos["USU_SUPERVISOR"] != "")
                                jD.isSupervisor = datos["USU_SUPERVISOR"];
                            if (datos["USU_SUPREFERENCIA"] != "")
                                jD.supervisorId = datos["USU_SUPREFERENCIA"];
                            if (datos["USU_USUARIO"] != "")
                                jD.userName = datos["USU_USUARIO"];
                            if (datos["USU_PASSWORD"] != "")
                                jD.isSupervisor = datos["USU_PASSWORD"];
                            if (datos["USU_TIPO"] != "")
                                datosAdmin("megaadmin", jD, datos["USU_TIPO"]);
                            else
                                datosAdmin("megaadmin", jD, 2);
                        } else
                            datosAdmin("megaadmin", jD, 2);
                    });
                } else {
                    console.log(jD);
                    alert("ADMINISTRADOR MEGAPROFER NO CUENTA CON REFERENCIA ID NO SE PUEDE INGRESAR, REVISE LA CONSOLA");
                }
            });
            alert("COMPLETO!!!");
        }; break;
        case 3: {
            let supervisor = ""; //CAMBIAR POR REFERENCIA DE SUPERVISOR
            const ref = firebase.database().ref();
            ref.child(`tbl_usuario/asesores`).child(key).get().then((snapshot) => {
                if (snapshot.exists()) {
                    var datos = snapshot.val();
                    for (const key in datos) {
                        const element = datos[key];
                        if (element["USU_SUPREFERENCIA"] == supervisor)
                            firebase.database().ref(`tbl_usuario/asesores/${key}/USU_SUPREFERENCIA`).set("");
                        if (element["USU_SUPERVISOR"] == supervisor)
                            firebase.database().ref(`tbl_usuario/asesores/${key}/USU_SUPERVISOR`).set("");
                    }
                    alert("COMPLETO!!!");
                } else
                    alert("PROBLEMA CON LOS DATOS, INTENTE MÁS TARDE");
            });
        }; break;
        case 4: {
            let supervisor = "1000048"; //CAMBIAR POR REFERENCIA DE SUPERVISOR
            let cambio = "1000000"; //CAMBIAR POR REFERENCIA DE ASESOR PARA CAMBIO
            const ref = firebase.database().ref();
            ref.child(`tbl_usuario/asesores`).child(key).get().then((snapshot) => {
                if (snapshot.exists()) {
                    var datos = snapshot.val();
                    for (const key in datos) {
                        const element = datos[key];
                        if (element["USU_SUPREFERENCIA"] == supervisor)
                            firebase.database().ref(`tbl_usuario/asesores/${key}/USU_SUPREFERENCIA`).set(cambio);
                        if (element["USU_SUPERVISOR"] == supervisor) {
                            firebase.database().ref(`tbl_usuario/asesores/${key}/USU_SUPERVISOR`).set("");
                            firebase.database().ref(`tbl_usuario/asesores/${key}/USU_TIPO`).set(0);
                        }
                        if (element["USU_REFERENCIA"] == cambio) {
                            firebase.database().ref(`tbl_usuario/asesores/${key}/USU_SUPERVISOR`).set(cambio);
                            firebase.database().ref(`tbl_usuario/asesores/${key}/USU_TIPO`).set(1);
                        }
                    }
                    alert("COMPLETO!!!");
                } else
                    alert("PROBLEMA CON LOS DATOS, INTENTE MÁS TARDE");
            });
        }; break;
        case 5: {
            let jsonData = []; //CAMBIAR CON DATOS RESULTANTES DE API DE MEGAPROFER
            jsonData.forEach(jD => {
                try {
                    if (jD.id_cliente != null) {
                        const ref = firebase.database().ref();
                        ref.child(`tbl_clientes/${jD.id_cliente}`).get().then((snapshot) => {
                            if (snapshot.exists()) {
                                var datos = snapshot.val();
                                datosCliente(jD, [
                                    datos["CLI_FOTO"],
                                    datos["CLI_HORAD"],
                                    datos["CLI_HORAH"],
                                    datos["CLI_LAT"],
                                    datos["CLI_LON"]
                                ]);
                            } else
                                datosCliente(jD, ["", "", "", "", ""]);
                        });
                    } else {
                        console.log(datos);
                        alert("CLIENTE NO TIENE REFERENCIA ID, REVISE LA CONSOLA");
                    }
                } catch (e) {
                    console.log("ERROR 1: " + jD.id_cliente);
                }
            });
            alert("COMPLETADO!!!");
        }; break;
        case 6: {
            let jsonData = []; //CAMBIAR CON DATOS RESULTANTES DE API DE MEGAPROFER
            const ref = firebase.database().ref();
            ref.child(`tbl_usuario/asesores`).get().then((snapshot) => {
                if (snapshot.exists()) {
                    var datos = snapshot.val();
                    jsonData.forEach(element => {
                        try {
                            if (datos[element.id_asesor] != undefined) {
                                for (const key in datos) {
                                    const dk = datos[key];
                                    if (dk["USU_CLIENTES"] != undefined && element.id_asesor != key) {
                                        for (const k in dk["USU_CLIENTES"]) {
                                            const cl = dk["USU_CLIENTES"][k];
                                            if (k == element.id_cliente && cl[cl.length - 1]["ESTADO"]) {
                                                firebase.database().ref(`tbl_usuario/asesores/${key}/USU_CLIENTES/${k}/${cl.length - 1}/ESTADO`).set(false);
                                                firebase.database().ref(`tbl_usuario/asesores/${key}/USU_CLIENTES/${k}/${cl.length - 1}/FECHAH`).set(hoy(1));
                                            }
                                        }
                                    }
                                }
                                if (datos[element.id_asesor]["USU_CLIENTES"] != undefined) {
                                    let dir = datos[element.id_asesor]["USU_CLIENTES"][element.id_cliente];
                                    if (dir != undefined) {
                                        if (!dir[dir.length - 1]["ESTADO"]) {
                                            firebase.database().ref(`tbl_usuario/asesores/${element.id_asesor}/USU_CLIENTES/${element.id_cliente}/${dir.length}`).set({
                                                ESTADO: true,
                                                FECHAD: hoy(0),
                                                FECHAH: ""
                                            });
                                        }
                                    } else {
                                        firebase.database().ref(`tbl_usuario/asesores/${element.id_asesor}/USU_CLIENTES/${element.id_cliente}/0`).set({
                                            ESTADO: true,
                                            FECHAD: hoy(0),
                                            FECHAH: ""
                                        });
                                    }
                                } else {
                                    firebase.database().ref(`tbl_usuario/asesores/${element.id_asesor}/USU_CLIENTES/${element.id_cliente}/0`).set({
                                        ESTADO: true,
                                        FECHAD: hoy(0),
                                        FECHAH: ""
                                    });
                                }
                                console.log("comepleto");
                            } else {
                                console.log(`REFERENCIA ID DE ASESOR : ${element.id_asesor}`);
                                alert("NO TIENE REGISTRADO A ASESOR, REVISE LA CONSOLA");
                            }
                        } catch (e) {
                            console.log("ERROR 2: " + element.id_cliente);
                        }
                    });
                    alert("COMPLETADO!!!");
                } else
                    alert("PROBLEMAS CON LA CONEXIÓN POR FAVOR INTENTE MÁS TARDE");
            });
        }; break;
        case 7: {
            let jsonData = []; //CAMBIAR CON DATOS RESULTANTES DE API DE MEGAPROFER
            jsonData.forEach(element => {
                if (element.codigo != undefined || element.codigo != null) {
                    firebase.database().ref(`tbl_catalogo/${element.codigo}`).set({
                        CAT_CODIGO: element.codigo,
                        CAT_DESCRIPCION: element.descripcion ?? "",
                        CAT_ESTADO: element.estado ?? false,
                        CAT_FECHA: element.fecha ?? "",
                        CAT_ID: element.id,
                        CAT_NOMBRE: element.nombre ?? "",
                        CAT_PRECIOA: element.precio_lista ?? 0,                 //Precio_lista
                        CAT_PRECIOB: element.precio_asesores ?? 0,              //Precio_asesores
                        CAT_PRECIOC: element.precio_comercial ?? 0,             //Precio_comercial
                        CAT_PRECIOD: element.precio_jefatura ?? 0,              //Precio_jefatura
                        CAT_PRECIOE: element.precio_mejores_precios ?? 0,       //Precio_mejores_precios
                        CAT_PRECIOF: element.precio_autorizador ?? 0            //Precio_autorizado
                    });
                    firebase.database().ref(`tbl_catalogo_update/${element.codigo}`).set({
                        CAT_CODIGO: element.codigo,
                        CAT_DESCRIPCION: element.descripcion ?? "",
                        CAT_ESTADO: element.estado ?? false,
                        CAT_FECHA: element.fecha ?? "",
                        CAT_ID: element.id,
                        CAT_NOMBRE: element.nombre ?? "",
                        CAT_PRECIOA: element.price ?? 0,                   //Precio_lista
                        CAT_PRECIOB: element.precio_asesores ?? 0,         //Precio_asesores
                        CAT_PRECIOC: element.precio_comercial ?? 0,        //Precio_comercial
                        CAT_PRECIOD: element.precio_jefatura ?? 0,         //Precio_jefatura
                        CAT_PRECIOE: element.precio_mejores_precios ?? 0,  //Precio_mejores_precios
                        CAT_PRECIOF: element.precio_autorizador ?? 0       //Precio_autorizado
                    });
                } else {
                    console.log(element);
                    alert("PRODUCTO NO CUENTA CON REFERENCECODE, REVISE LA CONSOLA");
                }
            });
            const ref = firebase.database().ref();
            ref.child(`tbl_usuario/asesores`).get().then((snapshot) => {
                if (snapshot.exists()) {
                    var datos = snapshot.val();
                    for (const key in datos) {
                        firebase.database().ref(`tbl_actividades/${key}`).set(true);
                    }
                }
            });
            alert("COMPLETADO");
        }; break;
        case 8: {
            let jsonData = []; //CAMBIAR CON DATOS RESULTANTES DE API DE MEGAPROFER
            jsonData.forEach(element => {
                firebase.database().ref(`tbl_factura/${element.id_cliente}/${element.numero_factura}`).set({
                    FAC_DOCUMENTO: element.numero_factura ?? "",
                    FAC_ESTADO: true,
                    FAC_ESTATUS: element.status ?? "",
                    FAC_FACID: element.invoiceId ?? "",
                    FAC_FECHA: element.fecha_factura ?? "",
                    FAC_FECHAACT: element.fecha_factura ?? "",
                    FAC_KEY: element.accessKey ?? "",
                    FAC_PENDIENTE: element.valor_factura ?? 0,
                    FAC_TOTAL: element.valor_factura ?? 0,
                    FAC_VENCIMIENTO: element.valor_factura ?? ""
                });
            });
        }; break;
        case 9: {
            let nuevo = {
                USU_DIRECCION: "", //INGRESAR LA DIRECCIÓN NO OBLIGATORIO
                USU_DNI: "", //INGRESAR DNI NO OBLIGATORIO
                USU_EMAIL: "", //INGRESAR EMAIL NO OBLIGATORIO
                USU_ESTADO: true, //MANTENER COMO true OBLIGATORIO
                USU_NOMBRES: "", //INGRESAR NOMBRES DEL USUARIO NO OBLIGATORIO
                USU_PASSWORD: "", // INGRESAR CONTRASEÑA NO OBLIGATORIO
                USU_PIN: "", //INGRESAR PIN DE USUARIO OBLIGATORIO
                USU_REFERENCIA: "", //INGRESAR REFERENCIA ID OBLIGATORIO
                USU_SUPERVISOR: "", //SI ES SUPERVISOR COLOCAR EL MISMO REFERENCIA ID SINO VACIO
                USU_SUPREFERENCIA: "", //SI TIENE SUPERVISOR COLOCAR EL REFERENCIA ID DEL SUPERVISOR SINO VACIO
                USU_TELEFONO: "", //INGRESAR TELEFONO NO OBLIGATORIO
                USU_TIPO: -1, // ASESOR: 0 ; SUPERVISOR: 1 ; ADMIN MEGAPROFER: 2
                USU_USUARIO: "" //INGRESAR EL USUARIO SI COLOCÓ LA CONTRASEÑA NO OBLIGATORIO
            };
            if (nuevo.USU_TIPO != -1 && nuevo.USU_REFERENCIA != "") {
                if (nuevo.USU_TIPO == 0) {
                    const ref = firebase.database().ref();
                    ref.child(`tbl_usuario/asesores/${nuevo.USU_REFERENCIA}`).get().then((snapshot) => {
                        if (snapshot.exists())
                            alert("REFERENCIA INGRESADA YA ESTA REGISTRADO");
                        else
                            firebase.database().ref(`tbl_usuario/asesores/${nuevo.USU_REFERENCIA}`).set(nuevo);
                    });
                } else {
                    ref.child(`tbl_usuario/megaadmin/${nuevo.USU_REFERENCIA}`).get().then((snapshot) => {
                        if (snapshot.exists())
                            alert("REFERENCIA INGRESADA YA ESTA REGISTRADO");
                        else
                            firebase.database().ref(`tbl_usuario/megaadmin/${nuevo.USU_REFERENCIA}`).set(nuevo);
                    });
                }
                alert("COMPLETO!!!");
            } else
                alert("CONFIGURE BIEN EL ARREGLO DE NUEVO USUARIO");
        }; break;
        default: alert("NO HA SELECCIONADO NINGUN TIPO POR FAVOR VERIFIQUE LA DOCUMENTACIÓN Y VUELVA A INTENTAR"); break;
    }
}

function datosAsesor(ruta, jD, tipo) {
    firebase.database().ref(`tbl_usuario/${ruta}/${jD.referenceId}/USU_NOMBRES`).set(jD.fullName ?? "");
    firebase.database().ref(`tbl_usuario/${ruta}/${jD.referenceId}/USU_REFERENCIA`).set(jD.referenceId ?? "");
    firebase.database().ref(`tbl_usuario/${ruta}/${jD.referenceId}/USU_DIRECCION`).set(jD.direccion ?? "");
    firebase.database().ref(`tbl_usuario/${ruta}/${jD.referenceId}/USU_DNI`).set(jD.dni ?? "");
    firebase.database().ref(`tbl_usuario/${ruta}/${jD.referenceId}/USU_EMAIL`).set(jD.email ?? "");
    firebase.database().ref(`tbl_usuario/${ruta}/${jD.referenceId}/USU_ESTADO`).set(jD.estado ?? false);
    firebase.database().ref(`tbl_usuario/${ruta}/${jD.referenceId}/USU_PASSWORD`).set(jD.password ?? "");
    firebase.database().ref(`tbl_usuario/${ruta}/${jD.referenceId}/USU_PIN`).set(jD.pin ?? "");
    firebase.database().ref(`tbl_usuario/${ruta}/${jD.referenceId}/USU_SUPERVISOR`).set(jD.isSupervisor == null || jD.isSupervisor == false ? "" : jD.referenceId);
    firebase.database().ref(`tbl_usuario/${ruta}/${jD.referenceId}/USU_SUPREFERENCIA`).set(jD.id_supervisor ?? "");
    firebase.database().ref(`tbl_usuario/${ruta}/${jD.referenceId}/USU_TELEFONO`).set(jD.telefono ?? "");
    firebase.database().ref(`tbl_usuario/${ruta}/${jD.referenceId}/USU_TIPO`).set(tipo); // ASESOR = 0; ADMIN MEGAPROFER = 2;
    firebase.database().ref(`tbl_usuario/${ruta}/${jD.referenceId}/USU_USUARIO`).set(jD.userName ?? "");
    console.log("correcto");
}

function datosAdmin(ruta, jD, tipo) {
    firebase.database().ref(`tbl_usuario/${ruta}/${jD.id_usuario}/USU_NOMBRES`).set(jD.full_name ?? "");
    firebase.database().ref(`tbl_usuario/${ruta}/${jD.id_usuario}/USU_REFERENCIA`).set(jD.id_usuario ?? "");
    firebase.database().ref(`tbl_usuario/${ruta}/${jD.id_usuario}/USU_DIRECCION`).set(jD.direccion ?? "");
    firebase.database().ref(`tbl_usuario/${ruta}/${jD.id_usuario}/USU_DNI`).set(jD.dni ?? "");
    firebase.database().ref(`tbl_usuario/${ruta}/${jD.id_usuario}/USU_EMAIL`).set(jD.email ?? "");
    firebase.database().ref(`tbl_usuario/${ruta}/${jD.id_usuario}/USU_ESTADO`).set(jD.estado ?? false);
    firebase.database().ref(`tbl_usuario/${ruta}/${jD.id_usuario}/USU_PASSWORD`).set(jD.password ?? "");
    firebase.database().ref(`tbl_usuario/${ruta}/${jD.id_usuario}/USU_PIN`).set(jD.pin ?? "");
    firebase.database().ref(`tbl_usuario/${ruta}/${jD.id_usuario}/USU_SUPERVISOR`).set(jD.isSupervisor == null || jD.isSupervisor == false ? "" : jD.id_usuario);
    firebase.database().ref(`tbl_usuario/${ruta}/${jD.id_usuario}/USU_SUPREFERENCIA`).set(jD.id_supervisor ?? "");
    firebase.database().ref(`tbl_usuario/${ruta}/${jD.id_usuario}/USU_TELEFONO`).set(jD.telefono ?? "");
    firebase.database().ref(`tbl_usuario/${ruta}/${jD.id_usuario}/USU_TIPO`).set(tipo); // ASESOR = 0; ADMIN MEGAPROFER = 2;
    firebase.database().ref(`tbl_usuario/${ruta}/${jD.id_usuario}/USU_USUARIO`).set(jD.userName ?? "");
    console.log("correcto");
}

function datosCliente(jD, adic) {
    try {
        firebase.database().ref(`tbl_clientes/${jD.id_cliente}/CLI_CODIGO`).set(jD.id_cliente ?? "");
        firebase.database().ref(`tbl_clientes/${jD.id_cliente}/CLI_CODIGOID`).set(jD.id_cliente ?? "");
        firebase.database().ref(`tbl_clientes/${jD.id_cliente}/CLI_DIRECCION`).set(jD.direccion[0].direccion ?? "");
        firebase.database().ref(`tbl_clientes/${jD.id_cliente}/CLI_EMAIL`).set(jD.email ?? "");
        firebase.database().ref(`tbl_clientes/${jD.id_cliente}/CLI_ESTADO`).set(jD.estado ?? false);
        firebase.database().ref(`tbl_clientes/${jD.id_cliente}/CLI_FOTO`).set(adic[0] ?? "");
        firebase.database().ref(`tbl_clientes/${jD.id_cliente}/CLI_HORAD`).set(adic[1] ?? "");
        firebase.database().ref(`tbl_clientes/${jD.id_cliente}/CLI_HORAH`).set(adic[2] ?? "");
        firebase.database().ref(`tbl_clientes/${jD.id_cliente}/CLI_LAT`).set(adic[3] ?? "");
        firebase.database().ref(`tbl_clientes/${jD.id_cliente}/CLI_LON`).set(adic[4] ?? "");
        firebase.database().ref(`tbl_clientes/${jD.id_cliente}/CLI_MOBIL`).set(jD.contacto ?? "");
        firebase.database().ref(`tbl_clientes/${jD.id_cliente}/CLI_NOMBRE`).set(jD.nombre ?? "");
        firebase.database().ref(`tbl_clientes/${jD.id_cliente}/CLI_TELEFONO`).set(jD.telefono ?? "");
        console.log("correcto");
        firebase.database().ref(`tbl_stocks/${jD.id_cliente}`).set({
            STO_ASIGNADO: jD.cupo_asignado ?? 0,
            STO_DISPONIBLE: jD.cupo_disponible ?? 0,
            STO_ESTADO: true
        });
    } catch (e) {
        console.log(jD.id_cliente);
        console.log(e);
    }
}

function hoy(con) {
    var fecha = new Date();
    return fecha.getFullYear().toString() + "-" + (fecha.getMonth() + 1).toString() + "-" + (fecha.getDate() - con).toString();
}