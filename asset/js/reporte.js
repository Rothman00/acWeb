function informVentas(d1, d2, d3, d4, d5, d6, d7, d8, d9, d10, d11, d12, d13, d14, d15) {
    $("#aseV").val(d1);
    $("#pinV").val(d2);
    $("#dniV").val(d3);
    $("#dirAV").val(d4);
    $("#cliV").val(d5);
    $("#codV").val(d6);
    $("#dirCV").val(d7);
    $("#emaV").val(d8);
    $("#fecV").val(d9);
    $("#horV").val(d10);
    $("#obsPV").val(d11);
    $("#ventV").val(d12);
    $("#cobV").val(d13);
    $("#otrV").val(d14);
    $("#obsVV").val(d15);
}

$('#fDesdeR').change(function () { 
    $( "#fHastaR" ).prop( "disabled", false);
 });

function busquedaFechas() {
    if(datosReportesTotal.length!=0){
        let desde = $('#fDesdeR').val();
        let hasta = $('#fHastaR').val();
        if(desde!=""){
            if(hasta=="")
                hasta = new Date();
            let data = [];
            let fDesde = Date.parse(desde);
            let fHasta = Date.parse(hasta);
            if(fDesde<=fHasta){
                datosReportesTotal.forEach(element => {
                    let fAccion = Date.parse(element[9]);
                    if(fAccion>=fDesde && fAccion<=fHasta)
                        data.push(element);
                });
                $('#reportesTable').html(generarTablaReportesManual(data));
                $('#datatable-reportesData').DataTable();
            }else{
                alert("Fecha hasta ingresada incorrecta");
            }
        }else{
            alert("No ha seleccionado una fecha desde para hacer la busqueda");
        }
    }else{
        alert("Tabla de datos aun no tiene datos, espere");
    }
}