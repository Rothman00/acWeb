var idC = -1;
var ruta = "";
var lat = "";
var lon = "";
var fot = "";
var aseMenu = true;
var nombre = "";
var codigo = "";

function consulta(){
    const ref = firebase.database().ref();
    ref.child(`tbl_usuario/asesores`).get().then((snapshot) => {
        if (snapshot.exists()) {
            var datos = snapshot.val();
            var resp = {};
            for (const key in datos) {
                const dato = datos[key];
                if(dato.hasOwnProperty("USU_CLIENTES")){
                    resp[key] = [];
                    let clientes = dato["USU_CLIENTES"];
                    for (const kcl in clientes) {
                        const cliente = clientes[kcl];
                        for (const kc in cliente) {
                            const clien = cliente[kc];
                            if(clien[clien.length - 1]["ESTADO"]){
                                const r = firebase.database().ref();
                                r.child(`tbl_clientes/${kc}`).get().then((snap) => {
                                    if(snap.exists()) {
                                        var data = snap.val();
                                        resp[key].add([dato["USU_NOMBRES"],data["CLI_NOMBRE"], data["CLI_CODIGO"]]);
                                    }
                                });
                            }
                        }
                    }
                }
            }
            $('#datosCOMP').val(JSON.stringify(resp));    
        } 
    });
}

function cambiarImagen(ruta) {
    if (ruta != "")
        $("#fotoC").attr("src", ruta);
    else
        $("#fotoC").attr("src", "https://aramar.com/wp-content/uploads/2017/05/aramar-suministros-para-el-vidrio-cristal-sin-imagen-disponible.jpg");
}

function llenarCliente(r, id, nom, dir, ema, tel, mob, des, has, lt, ln, f, cod) {
    llenadoAsesores();
    ruta = r;
    idC = id;
    $("#cliU").val(nom);
    nombre = nom;
    $("#codU").val(cod);
    codigo = cod;
    $("#dirU").val(dir);
    $("#emaU").val(ema);
    $("#telU").val(tel);
    $("#mobU").val(mob);
    $("#desU").val(des);
    $("#hasU").val(has);
    lat = lt;
    lon = ln;
    fot = f;
}

function eliminarCliente(r, id) {
    var conf = confirm("Estás seguro de eliminar?");
    if (conf) {
        var idC = "id=" + id;
        $.ajax({
            data: idC,
            type: "POST",
            url: r + '/deleteC',
            success: function(response) {
                console.log(response);
                alert('ELIMINADO');
                location.reload();
            }
        });
    }
}

function actualizarCliente() {
    if (validarCodigo($('#codU').val())) {
        if (validarEmail($('#emaU').val())) {
            if (validarTelefono($('#telU').val())) {
                if (validarTelefono($('#mobU').val())) {
                    if (validarHoras($('#desU').val(), $('#hasU').val())) {
                        $("#guardarCliU").prop('disabled', true);
                        if (nombre != $('#cliU').val() || codigo != $('#codU').val()) {
                            const dbRef = firebase.database().ref();
                            dbRef.child("tbl_clientes/"+idC).get().then((snapshot) => {
                                if (!snapshot.exists()) {
                                    var datosCli = {
                                        "CLI_CODIGO": $('#codU').val(),
                                        "CLI_CODIGOID": idC,
                                        "CLI_DIRECCION": $('#dirU').val(),
                                        "CLI_EMAIL": $('#emaU').val(),
                                        "CLI_ESTADO": true,
                                        "CLI_FOTO": fot,
                                        "CLI_HORAD": $('#desU').val(),
                                        "CLI_HORAH": $('#hasU').val(),
                                        "CLI_LAT": lat,
                                        "CLI_LON": lon,
                                        "CLI_MOBIL": $('#mobU').val(),
                                        "CLI_NOMBRE": $('#cliU').val(),
                                        "CLI_TELEFONO": $('#telU').val()
                                    };
                                    firebase.database().ref('tbl_clientes/' + idC).set(datosCli);
                                    alert("ACTUALIZADO");
                                    location.reload();
                                } else {
                                    alert("Error en la consulta");
                                    $("#guardarCliU").prop('disabled', false);
                                }
                            }).catch((error) => {
                                alert(error);
                                $("#guardarCliU").prop('disabled', false);
                            });
                        } else {
                            var datosCli = {
                                "id": idC,
                                "codigo": $('#codU').val(),
                                "nombre": $('#cliU').val(),
                                "direccion": $('#dirU').val(),
                                "email": $('#emaU').val(),
                                "telefono": $('#telU').val(),
                                "mobil": $('#mobU').val(),
                                "desde": $('#desU').val(),
                                "hasta": $('#hasU').val(),
                                "lat": lat,
                                "lon": lon,
                                "foto": fot
                            };
                            $.ajax({
                                data: datosCli,
                                type: "POST",
                                url: ruta + '/updateC',
                                success: function(response) {
                                    console.log(response);
                                    alert('ACTUALIZADO');
                                    location.reload();
                                }
                            });
                        }
                    } else {
                        alert('Visita desde o Visita hasta invalido');
                    }
                } else {
                    alert('Móvil invalido');
                }
            } else {
                alert('Teléfono invalido');
            }

        } else {
            alert('Email invalido');
        }
    } else {
        alert('Código invalido');
    }
}

function nuevoCliente() {
    var idA = parseInt($('#asesorN option:selected').val());
    if (idA != -1 && $('#cliN').val() != "" && $('#codN').val() != "") {
        if (validarCodigo($('#codN').val())) {
            if (validarEmail($('#emaN').val())) {
                if (validarTelefono($('#telN').val())) {
                    if (validarTelefono($('#mobN').val())) {
                        if (validarHoras($('#desN').val(), $('#hasN').val())) {
                            $("#guardarCliN").prop('disabled', true);
                            const dbRef = firebase.database().ref();
                            dbRef.child(`tbl_clientes/${$('#codN').val()}`).get().then((snapshot) => {
                                if (!snapshot.exists()) {
                                    var datosCli = {
                                        "idA": idA,
                                        "codigo": $('#codN').val(),
                                        "nombre": $('#cliN').val(),
                                        "direccion": $('#dirN').val(),
                                        "email": $('#emaN').val(),
                                        "telefono": $('#telN').val(),
                                        "mobil": $('#mobN').val(),
                                        "desde": $('#desN').val(),
                                        "hasta": $('#hasN').val()
                                    };
                                    $.ajax({
                                        data: datosCli,
                                        type: "POST",
                                        url: base_url + '/insertC',
                                        success: function(response) {
                                            console.log(response);
                                            alert('GUARDADO');
                                            location.reload();
                                        }
                                    });
                                    $("#guardarCliN").prop('disabled', false);
                                }else{
                                    alert("CODIGO EXISTENTE");
                                    $("#guardarCliN").prop('disabled', false);    
                                }
                            }).catch((error) => {
                                alert(error);
                                $("#guardarCliN").prop('disabled', false);
                            });
                        } else {
                            alert('Visita desde o Visita hasta invalido');
                        }
                    } else {
                        alert('Móvil invalido');
                    }
                } else {
                    alert('Teléfono invalido');
                }
            } else {
                alert('Email invalido');
            }
        } else {
            alert('Código invalido');
        }
    } else {
        alert("NO A SELECCIONADO A UN ASESOR O NO A INGRESADO EL NOMBRE DEL CLIENTE O CÓDIGO");
    }
}

//CLIENTE NUEVO
cliNV = document.querySelector('#cliNuevo');
cliNV.cliN.addEventListener('keypress', function(e) {
    if (!soloLetras(this.value + '' + event.key, event)) {
        e.preventDefault();
    }
});

codNV = document.querySelector('#codNuevo');
codNV.codN.addEventListener('keypress', function(e) {
    if (!sinEspacios(this.value + '' + event.key, event)) {
        e.preventDefault();
    }
});

telNV = document.querySelector('#telNuevo');
telNV.telN.addEventListener('keypress', function(e) {
    if (!soloNumeros(event)) {
        e.preventDefault();
    }
});

mobNV = document.querySelector('#mobNuevo');
mobNV.mobN.addEventListener('keypress', function(e) {
    if (!soloNumeros(event)) {
        e.preventDefault();
    }
});

//CLIENTE ACTUALIZAR
cliUP = document.querySelector('#cliUpdate');
cliUP.cliU.addEventListener('keypress', function(e) {
    if (!soloLetras(event)) {
        e.preventDefault();
    }
});

codUP = document.querySelector('#codUpdate');
codUP.codU.addEventListener('keypress', function(e) {
    if (!sinEspacios(this.value + '' + event.key, event)) {
        e.preventDefault();
    }
});

telUP = document.querySelector('#telUpdate');
telUP.telU.addEventListener('keypress', function(e) {
    if (!soloNumeros(event)) {
        e.preventDefault();
    }
});

mobUP = document.querySelector('#mobUpdate');
mobUP.mobU.addEventListener('keypress', function(e) {
    if (!soloNumeros(event)) {
        e.preventDefault();
    }
});

function soloLetras(valor, e) {
    var key = e.charCode;
    return (key >= 65 && key <= 90) || (key >= 97 && key <= 122) || key == 32;
}

function sinEspacios(valor, e) {
    var datos = valor.split('');
    if (datos.length > 10) {
        return false;
    }
    var key = e.charCode;
    return key != 32;
}

function soloNumeros(e) {
    var key = e.charCode;
    return key >= 48 && key <= 57;
}

function validarCodigo(valor) {
    return valor.split(' ').length == 1;
}

function validarEmail(valor) {
    if (valor != "")
        return /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(valor);
    return true;
}

function validarTelefono(valor) {
    if (valor != "")
        return /^[0-9]{9,10}$/.test(valor);
    return true;
}

function validarHoras(hora1, hora2) {
    if (hora1 != "" && hora2 != "") {
        if (hora1 == "" || hora2 == "") return false;
        var horaA1 = hora1.split(':'); //18:30
        var horaA2 = hora2.split(':'); //18:30
        if (horaA1[0] < horaA2[0]) return true;
        if (horaA1[0] > horaA2[0]) return false;
        if (horaA1[0] == horaA2[0]) {
            if (horaA1[1] <= horaA2[1]) return true;
            else return false;
        }
    } else {
        return true;
    }
}

function llenadoAsesores() {
    if (aseMenu) {
        if (datosAse != null || datosCli != null) {
            const select = document.querySelector("#asesorN");
            datosAse.forEach(d => {
                const option = document.createElement('option');
                option.value = d["USU_REFERENCIA"];
                option.text = d["USU_NOMBRES"];
                select.appendChild(option);
            });
            const listCli = document.querySelector("#listaClientes");
            const listCod = document.querySelector("#listaCodigos");
            datosCli.forEach(c => {
                const option = document.createElement('option');
                option.value = c["CLI_NOMBRE"];
                const option1 = document.createElement('option');
                option1.value = c["CLI_CODIGOID"];
                listCli.appendChild(option);
                listCod.appendChild(option1);
            });
            aseMenu = false;
        } else {
            console.log("No data available");
        }
    }
}