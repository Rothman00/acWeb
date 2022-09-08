function privilegiosGuardar1() {
    if(confirm('ESTÁS SEGUROD DE CREAR ESTE PRIVILEGIO')){
        let rol = $("#rolI").val();
        if (rol != "") {
            if ($('input[name="nuvrol"]:checked').length != 0) {
                const dbRef = firebase.database().ref();
                dbRef.child("tbl_rol").get().then((snapshot) => {
                    if (snapshot.exists()) {
                        var datos = snapshot.val();
                        for(let d=0; d<datos.length;d++){
                            if(datos[d]["ROL_NOMBRE"]==rol && datos[d]["ROL_ESTADO"]){
                                alert("NOMBRE DE ROL YA EXISTE");
                                return;
                            }
                        }
                        var nombre = "nombre=" + rol;
                        $.ajax({
                            data: nombre,
                            type: "POST",
                            url: base_url + '/insertR',
                            success: function(response) {
                                $('input[name="nuvrol"]:checked').each((index, element) => {
                                    var idR = "idR=" + $(element).attr('id');
                                    $.ajax({
                                        data: idR,
                                        type: "POST",
                                        url: base_url + '/insertRR',
                                        success: function(response) {
                                            console.log(response);
                                        }
                                    });
                                });
                                alert('GUARDADO');
                            }
                        });
                    } else {
                        alert("ERROR EN LA CONSULTA, INTENTE MÁS TARDE");
                    }
                }).catch((error) => {
                    alert(error);
                });
            } else {
                alert("DEBE SELECCIONAR ALGUN MÓDULO");
            }
        } else {
            alert("DEBE DE INGRESAR UN NOMBRE DE ROL");
        }
    }
}

function privilegiosGuardar2() {
    var idA = parseInt($('#rolPro option:selected').val());
    var idU = $('#asesorPr option:selected').val();
    if (idA != -1) {
        if(idU != -1){
            if(confirm("ESTAS SEGURO DE DAR ESTE PRIVILEGIO")){
                const dbRef = firebase.database().ref();
                dbRef.child(`tbl_rolusuarios/${idU}`).get().then((snapshot) => {
                    if (snapshot.exists()) {
                        let opt = false;
                        var datos = snapshot.val();
                        for (const key in datos) {
                            const element = datos[key];
                            if(element["ROL_ID"]==idA){
                                alert("ADMIN MEGAPROFER YA TIENE ESTE PRIVILEGIO");
                                opt = true;
                                break;
                            }
                        }
                        if(!opt){
                            var datos = {
                                "idA": idA,
                                "idU": idU
                            };
                            $.ajax({
                                data: datos,
                                type: "POST",
                                url: base_url + '/insertPri',
                                success: function(response) {
                                    console.log(response);
                                    alert('GUARDADO');
                                    location.reload();
                                }
                            });
                        }
                    } else {
                        alert("ERROR EN LA CONSULTA, INTENTE MÁS TARDE");
                    }
                }).catch((error) => {
                    alert(error);
                });
            }
        }else
            alert("No ha escogido ningun asesor");
    } else 
        alert("No ha escogido ningun privilegio");
}

function privilegiosEliminar1() {
    var rolDel = parseInt($('#rolProDel option:selected').val());
    if(confirm("Estás seguro de eliminar este rol?")){
        firebase.database().ref('tbl_rol/' + rolDel + '/ROL_ESTADO').set(false);
        alert("Eliminado");
        location.reload();
    }
}

$("#asesorPrDel").change(function() {
    var asesorDel = $('#asesorPrDel option:selected').val();
    bloquearDesbloquear(true);
    if(asesorDel!=-1){
        const dbRef = firebase.database().ref();
        dbRef.child(`tbl_rolusuarios/${asesorDel}`).get().then((snapshot) => {
            if (snapshot.exists()) {
                var datos = snapshot.val();
                for (const key in datos) {
                    const element = datos[key];
                    if(element["ROU_ESTADO"]){
                        let valor = "del"+element["ROL_ID"];
                        $(`#${valor}`).prop('disabled', false);
                        $(`#${valor}`).prop('checked', true);
                    }   
                }
                return;
            } else {
                alert("ADMIN MEGAPROFER NO TIENE PRIVILEGIOS");
            }
        }).catch((error) => {
            alert(error);
        });
    }
});

$("#rolPro").change(function(){
    var rolPro = parseInt($('#rolPro option:selected').val());
    if(rolPro!=-1){
        const ref1=firebase.database().ref();
        ref1.child("tbl_ruta/"+ruta).get().then((snapshot1)=>{
            if(snapshot1.exists()){
                let data = snapshot1.val();
                const ref=firebase.database().ref();
                ref.child("tbl_rolruta").get().then((snapshot)=>{
                    if(snapshot.exists()){
                        var datos = snapshot.val();
                        let resultado="";
                        for(let d=0;d<datos.length;d++){
                            if(datos[d]["ROR_ESTADO"]&&datos[d]["ROL_ID"]==rolPro){
                                let ruta = datos[d]["RUT_ID"];
                                resultado+="- "+data[ruta]["RUT_NOMBRE"]+" ";
                            }
                        }
                        $('#textoRol').text(resultado);
                    }else{
                        alert("ERROR EN LA CONSULTA, INTENTE MÁS TARDE");
                    }
                });
            }else{
                alert("ERROR EN LA CONSULTA, INTENTE MÁS TARDE");
            }
        });
    }else{
        $('#textoRol').text("");
    }
});

$("#rolMenu").change(function(){
    var rolPro = parseInt($('#rolMenu option:selected').val());
    $('input[name="rolM"]:checked').each((index, element) => {
        var ruta = $(element).attr('id');
        $(`#${ruta}`).prop("checked", false);
    });
    if(rolPro!=-1){
        const ref1=firebase.database().ref();
        ref1.child("tbl_ruta/"+ruta).get().then((snapshot1)=>{
            if(snapshot1.exists()){
                let data = snapshot1.val();
                const ref=firebase.database().ref();
                ref.child("tbl_rolruta").get().then((snapshot)=>{
                    if(snapshot.exists()){
                        var datos = snapshot.val();
                        for(let d=0;d<datos.length;d++){
                            if(datos[d]["ROR_ESTADO"]&&datos[d]["ROL_ID"]==rolPro){
                                let ruta = datos[d]["RUT_ID"];
                                $(`#${ruta}`).prop("checked", true);
                            }
                        }
                    }else{
                        alert("ERROR EN LA CONSULTA, INTENTE MÁS TARDE");
                    }
                });
            }else{
                alert("ERROR EN LA CONSULTA, INTENTE MÁS TARDE");
            }
        });
    }
});

function bloquearDesbloquear(valor){
    const dbRef = firebase.database().ref();
    dbRef.child("tbl_rol").get().then((snapshot) => {
        if (snapshot.exists()) {
            var datos = snapshot.val();
            for(let d=0; d<datos.length;d++){
                if(datos[d]["ROL_ESTADO"]){
                    let valor1 = "del"+datos[d]["ROL_ID"];
                    $(`#${valor1}`).prop('disabled', valor);
                    $(`#${valor1}`).prop('checked', !valor);
                }
            }
            return;
        } else {
            alert("ERROR EN LA CONSULTA, INTENTE MÁS TARDE");
        }
    }).catch((error) => {
        alert(error);
    });
}

function privilegiosEliminar2() {
    if(confirm("Estás seguro de eliminar los privilegios del Admin MegaProfer?")){
        var asesorDel = $('#asesorPrDel option:selected').val();
        if(asesorDel!=-1){
            const dbRef = firebase.database().ref();
            dbRef.child(`tbl_rolusuarios/${asesorDel}`).get().then((snapshot) => {
                if (snapshot.exists()) {
                    var datos = snapshot.val();
                    let respuesta = false;
                    $('input[name="quipri"]:not(:checked)').each((index, element) => {
                        var rolConDel = $(element).attr('id');
                        var rolArr = rolConDel.split('del');
                        console.log(rolArr);
                        var rolDel = rolArr[1];
                        for (const key in datos) {
                            const element = datos[key];
                            if(element["ROU_ESTADO"] && element["ROL_ID"] == rolDel){
                                firebase.database().ref(`tbl_rolusuarios/${asesorDel}/${key}/ROU_ESTADO`).set(false);
                                respuesta=true;
                                break;
                            }   
                        }
                    });
                    if(!respuesta)
                        alert("NO SE HA QUITADO NINGUN PRIVILEGIO");
                    else{
                        alert("ELIMINADO");
                        location.reload();
                    }
                    return;
                } else {
                    alert("ERROR EN LA CONSULTA, INTENTE MÁS TARDE");
                }
            }).catch((error) => {
                alert(error);
            });
        }else{
            alert("DEBE DE SELECCIONAR UN ADMIN MEGAPROFER");
        }
    }
}