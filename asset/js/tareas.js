var idCliente = -1;

$("#asesor").change(function() {
    let select = $('#asesor option:selected').val();
    if(select!=-1){
        const cliSelec = document.querySelector("#cliente");
        for (let i = cliSelec.options.length; i >= 1; i--) {
            cliSelec.remove(i);
        }
        for (const key in datosAse) {
            const asesor = datosAse[key];
            if(asesor["USU_REFERENCIA"]==select){
                if(asesor["USU_CLIENTES"]==undefined){
                    alert("ASESOR NO TIENE CLIENTES REGISTRADOS");
                    break;
                }else{
                    $('#aseI').val(asesor["USU_NOMBRES"]);
                    $('#dniI').val(asesor["USU_DNI"]);
                    $('#dirI').val(asesor["USU_DIRECCION"]);
                    $('#emaI').val(asesor["USU_EMAIL"]);
                    $('#telI').val(asesor["USU_TELEFONO"]);
                    for (const u in asesor["USU_CLIENTES"]) {
                        const uc = asesor["USU_CLIENTES"][u];
                        if(uc[uc.length-1]["ESTADO"]){
                            for (const k in datosCli) {
                                const client = datosCli[k];
                                if(client["CLI_CODIGOID"]==u){
                                    const option = document.createElement('option');
                                    option.value = client["CLI_CODIGOID"];
                                    option.text = `${client["CLI_CODIGO"]}-${client["CLI_NOMBRE"]}`;
                                    cliSelec.appendChild(option);
                                }
                            }
                        }   
                    }
                    break;
                }
            }
        }
    }else{
        const cliSelec = document.querySelector("#cliente");
        if(datos != null){
        datosCli.forEach(datos => {
            const option = document.createElement('option');
            option.value = datos["CLI_CODIGOID"];
            option.text = `${datos["CLI_CODIGO"]}-${datos["CLI_NOMBRE"]}`;
            cliSelec.appendChild(option);
        });
        }
        $('#aseI').val('');
        $('#dniI').val('');
        $('#dirI').val('');
        $('#emaI').val('');
        $('#telI').val('');
        $('#cliI').val('');
        $('#dirCI').val('');
        $('#telCI').val('');
        $('#mobCI').val('');
        $('#visCI').val('');
    }
});

$("#cliente").change(function() {
    let select = $('#cliente option:selected').val();
    let res = false;
    if(select!=-1){
        for (const k in datosAse) {
            const asesor = datosAse[k];
            if(asesor["USU_CLIENTES"]!=undefined){
                for (const kcu in asesor["USU_CLIENTES"]) {
                    const lc = asesor["USU_CLIENTES"][kcu];
                    if(lc[lc.length-1]["ESTADO"] && kcu == select){
                        res = true;
                        $("#asesor").val(asesor["USU_REFERENCIA"]).trigger('change.select2');
                        for (const kc in datosCli) {
                            const client = datosCli[kc];
                            if(client["CLI_CODIGOID"]==select){
                                idCliente= client["CLI_CODIGOID"];
                                $('#aseI').val(asesor["USU_NOMBRES"]);
                                $('#dniI').val(asesor["USU_DNI"]);
                                $('#dirI').val(asesor["USU_DIRECCION"]);
                                $('#emaI').val(asesor["USU_EMAIL"]);
                                $('#telI').val(asesor["USU_TELEFONO"]);
                                $('#cliI').val(client["CLI_NOMBRE"]);
                                $('#dirCI').val(client["CLI_DIRECCION"]);
                                $('#telCI').val(client["CLI_TELEFONO"]);
                                $('#mobCI').val(client["CLI_MOBIL"]);
                                $('#visCI').val(client["CLI_HORAD"] + "/" + client["CLI_HORAH"]);
                                break;
                            }
                        }
                        break;
                    }
                }
                if(res) break;
            }
        }
    }else{
        $("#asesor").val(-1).trigger('change.select2');
        $('#aseI').val('');
        $('#dniI').val('');
        $('#dirI').val('');
        $('#emaI').val('');
        $('#telI').val('');
        $('#cliI').val('');
        $('#dirCI').val('');
        $('#telCI').val('');
        $('#mobCI').val('');
        $('#visCI').val('');
    }
});


function tareaGuardar() {
    var respuesta = true;
    if (idCliente != -1){
        if($('#cob').val() != "" &&
            $('#ven').val() != "" &&
            $('#otr').val() != "" &&
            $('#fec').val() != "") {
            if($('#cob').val() == "0" &&
            $('#ven').val() == "0" &&
            $('#otr').val() == "0"){
                respuesta = confirm('¿Estás segura de enviar todos los datos en 0?');
            }
            if(respuesta){
                try{
                    var cobrar = decimales($('#cob').val());
                    var vender = decimales($('#ven').val());
                    var otros = decimales($('#otr').val());
                    $("#guardarId").prop('disabled', true);
                    var datosCli = {
                        "id": idCliente,
                        "cobrar": cobrar,
                        "vender": vender,
                        "otros": otros,
                        "fecha": $('#fec').val(),
                        "detalle": $('#det').val()
                    };
                    $.ajax({
                        data: datosCli,
                        type: "POST",
                        url: base_url + '/insertT',
                        success: function(response) {
                            console.log(response);
                            alert('GUARDADO');
                            location.reload();
                        }
                    });
                }catch(e){
                    alert(e);
                }
            }
        }else{
            let resumen = 'Revise el/los campos: \n';
            if($('#cob').val() == "")
                resumen+='-Cobros\n';
            if($('#ven').val() == "")
                resumen+='-Ventas\n';
            if($('#otr').val() == "")
                resumen+='-Otros\n';
            if($('#fec').val() == "")
                resumen+='-Fecha';
            alert(resumen);
        }
    }else{
        alert('No ha seleccionado un asesor o un cliente');
    }
}

//Validación
cobF = document.querySelector('#cobForm');
cobF.cob.addEventListener('keypress', function (e){
	if (!numerosDecimales(this.value+''+event.key)){
  	e.preventDefault();
  }
});

venF = document.querySelector('#venForm');
venF.ven.addEventListener('keypress', function (e){
	if (!numerosDecimales(this.value+''+event.key)){
  	e.preventDefault();
  }
});

otrF = document.querySelector('#otrForm');
otrF.otr.addEventListener('keypress', function (e){
	if (!numerosDecimales(this.value+''+event.key)){
  	e.preventDefault();
  }
});

function numerosDecimales(valor){
    var datos = valor.split(',');
    if(datos.length>1){
        var numbers = datos[1].split('');
        if(numbers.length>2)
            return false;
    }
    var datos = valor.split('.');
    if(datos.length>1){
        var numbers = datos[1].split('');
        if(numbers.length>2)
            return false;
    }
    var datos = valor.split('');
    if(datos.length>8){
        return false;
    }
    return true;
}

function decimales(valor){
    console.log(valor);
    var datos = valor.split('.');
        console.log(datos);
    if(datos.length>1){
        if(datos[1]=="00"||datos[1]=="0"||datos[1]=="")
            return valor;
        return dosDecimales(valor);
    }
    datos = valor.split(',');
        console.log(datos);
    if(datos.length>1){
        if(datos[1]=="00"||datos[1]=="0"||datos[1]=="")
            return valor;
        return dosDecimales(valor);
    }
    return valor;
}

function dosDecimales(n) {
  let t=n.toString();
  let regex=/(\d*.\d{0,2})/;
  return t.match(regex)[0];
}