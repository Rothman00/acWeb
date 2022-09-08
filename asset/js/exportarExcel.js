function exportarClientesExcel() {
    var lista = [
        ["CODIGO","NOMBRE", "DIRECCION", "MOBIL", "TELEFONO", "VISITA","LATITUD","LONGITUD"]
    ];
    datosCli.forEach(d => {
        if (d["CLI_ESTADO"]) {
            lista.push([
                d["CLI_CODIGO"],
                d["CLI_NOMBRE"],
                d["CLI_DIRECCION"],
                d["CLI_MOBIL"],
                d["CLI_TELEFONO"],
                d["CLI_HORAD"] + "/" + d["CLI_HORAH"],
                d["CLI_LAT"],
                d["CLI_LON"]
            ]);
        }
    });
    var wb = XLSX.utils.book_new();
    wb.Props = {
        Title: "SAC",
        Subject: "SAC",
        Author: "SAC",
        CreatedDate: new Date(2021, 05, 25)
    };
    wb.SheetNames.push("SAC");
    var ws = XLSX.utils.aoa_to_sheet(lista);
    wb.Sheets["SAC"] = ws;
    var wbout = XLSX.write(wb, { bookType: 'xlsx', type: 'binary' });
    saveAs(new Blob([s2ab(wbout)], { type: "application/octet-stream" }), 'SAC_Clientes.xlsx');
}

function s2ab(s) {
    var buf = new ArrayBuffer(s.length); //convert s to arrayBuffer
    var view = new Uint8Array(buf); //create uint8array as viewer
    for (var i = 0; i < s.length; i++) view[i] = s.charCodeAt(i) & 0xFF; //convert to octet
    return buf;
}

function exportarReportesTotalExcel() {
    var table = $('#datatable-reportesData').DataTable();
    var lista = [
        ["ASESOR", "PIN", "DNI", "DIRECCIÓN ASESOR", "CLIENTE", "CÓDIGO", "DIRECCIÓN CLIENTE", "EMAIL", "FECHA", "HORA", "OBSERVACIÓN PROG. SEMANAL", "VENTA", "COBRO", "OTROS", "OBSERVACIÓN VISITA"]
    ];
    table.data().each(function(d){
        let sp0 = d[9].split(`<button onclick="informVentas(`);
        let sp1 = sp0[1].split(`);" class="btn btn-round btn-primary" data-toggle="modal" data-target="#inform"><span class="fa fa-plus"></span></button>`);
        let sp2 = sp1[0].split(`'`);
        let datosLista=[];
        for (let index = 1; index < sp2.length; index+=2) {
            const element = sp2[index];
            datosLista.push(element);
        }
        lista.push(datosLista);
    });
    var wb = XLSX.utils.book_new();
    wb.Props = {
        Title: "REPORTES",
        Subject: "REPORTES",
        Author: "REPORTES",
        CreatedDate: new Date(2021, 05, 25)
    };
    wb.SheetNames.push("REPORTES");
    var ws = XLSX.utils.aoa_to_sheet(lista);
    wb.Sheets["REPORTES"] = ws;
    var wbout = XLSX.write(wb, { bookType: 'xlsx', type: 'binary' });
    saveAs(new Blob([s2ab(wbout)], { type: "application/octet-stream" }), 'SAC_Reportes.xlsx');
}