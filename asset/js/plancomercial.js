/*
    FileReader tiene 4 métodos de lectura:
    1.readAsArrayBuffer (archivo): lea el archivo como un ArrayBuffer.
    2.readAsBinaryString (archivo): lea el archivo como una cadena binaria
    3.readAsDataURL (archivo): lea el archivo como una URL de datos
    4.readAsText (archivo, [codificación]): lee el archivo como texto, la codificación predeterminada es 'UTF-8'
*/
var wb; // lee los datos completos
var rABS = false; // Si leer el archivo como una cadena binaria

function importf(obj) { // import
    if (!obj.files) {
        window.location.reload();
        return;
    }
    var f = obj.files[0];
    if (typeof(f) != "undefined") {
        var reader = new FileReader();
        reader.onload = function(e) {
            var data = e.target.result;
            if (rABS) {
                wb = XLSX.read(btoa(fixdata(data)), { // conversión manual
                    type: 'base64'
                });
            } else {
                wb = XLSX.read(data, {
                    type: 'binary'
                });
            }
            //wb.SheetNames[0] es el nombre de la primera hoja en Obtener hojas
            //wb.Sheets[Sheet name] Obtenga los datos de la primera Hoja
            //document.getElementById("demo").innerHTML = JSON.stringify(XLSX.utils.sheet_to_json(wb.Sheets[wb.SheetNames[1]]));
            var hoja1 = XLSX.utils.sheet_to_json(wb.Sheets[wb.SheetNames[0]]);
            /* if (hoja1.length <= 1) {
                alert('DATO FALTANTE\nRESULTADOS: NO TIENE DATOS');
                return;
            }
            var hoja2 = XLSX.utils.sheet_to_json(wb.Sheets[wb.SheetNames[1]]);
            if (hoja2.length <= 0) {
                alert('DATO FALTANTE\nCLIENTES: NO TIENE DATOS');
                return;
            } */
            //firebase.database().ref('tbl_plancomercial/').set(null);
            //firebase.database().ref('tbl_plancomercialclientes/').set(null);
            firebase.database().ref('tbl_prueba/').set(null);
            for (let index = 2; index < hoja1.length; index++) {
                const h1 = hoja1[index];
                let letras = 1;
                let l = abecedatio(letras++);
                while(l!="CX"){
                    if (validacionCampos(h1[l], l, index)) return;
                    if (!(nombre == "A" || nombre == "B" || nombre == "C" || nombre == "G"))
                        h1[l]=numberDecimal(h1[l]);
                    l = abecedatio(letras++);
                }
                firebase.database().ref('tbl_prueba/' + h1["B"]).set(h1);
            }


            /* for (let index = 1; index < hoja1.length; index++) {
                const fl = hoja1[index];
                if (validacionCampos(fl['__EMPTY'], 'A', index)) return;
                if (validacionCampos(fl['__EMPTY_1'], 'B', index)) return;
                if (validacionCampos(fl['__EMPTY_2'], 'C', index)) return;
                if (validacionCampos(fl['CUMPLIMIENTO DE CUOTA'], 'D', index)) return;
                if (validacionCampos(fl['__EMPTY_3'], 'E', index)) return;
                if (validacionCampos(fl['__EMPTY_4'], 'F', index)) return;
                if (validacionCampos(fl['__EMPTY_5'], 'G', index)) return;
                if (validacionCampos(fl['__EMPTY_6'], 'H', index)) return;
                if (validacionCampos(fl['__EMPTY_7'], 'I', index)) return;
                if (validacionCampos(fl['__EMPTY_8'], 'J', index)) return;
                if (validacionCampos(fl['ZAFIRO'], 'K', index)) return;
                if (validacionCampos(fl['__EMPTY_9'], 'L', index)) return;
                if (validacionCampos(fl['__EMPTY_10'], 'M', index)) return;
                if (validacionCampos(fl['__EMPTY_11'], 'N', index)) return;
                if (validacionCampos(fl['__EMPTY_12'], 'O', index)) return;
                if (validacionCampos(fl['BAHCO E IRIMO'], 'P', index)) return;
                if (validacionCampos(fl['__EMPTY_13'], 'Q', index)) return;
                if (validacionCampos(fl['100%'], 'R', index)) return;
                if (validacionCampos(fl['__EMPTY_14'], 'S', index)) return;
                if (validacionCampos(fl['__EMPTY_15'], 'T', index)) return;
                if (validacionCampos(fl['DEXSON'], 'U', index)) return;
                if (validacionCampos(fl['__EMPTY_16'], 'V', index)) return;
                if (validacionCampos(fl['200%'], 'W', index)) return;
                if (validacionCampos(fl['__EMPTY_17'], 'X', index)) return;
                if (validacionCampos(fl['__EMPTY_18'], 'Y', index)) return;
                if (validacionCampos(fl['FERRETERIA'], 'Z', index)) return;
                if (validacionCampos(fl['__EMPTY_19'], 'AA', index)) return;
                if (validacionCampos(fl['300%'], 'AB', index)) return;
                if (validacionCampos(fl['__EMPTY_20'], 'AC', index)) return;
                if (validacionCampos(fl['__EMPTY_21'], 'AD', index)) return;
                if (validacionCampos(fl['NORTON VARIOS'], 'AE', index)) return;
                if (validacionCampos(fl['__EMPTY_22'], 'AF', index)) return;
                if (validacionCampos(fl['400%'], 'AG', index)) return;
                if (validacionCampos(fl['__EMPTY_23'], 'AH', index)) return;
                if (validacionCampos(fl['__EMPTY_24'], 'AI', index)) return;
                if (validacionCampos(fl['IMPORTADOS'], 'AJ', index)) return;
                if (validacionCampos(fl['__EMPTY_25'], 'AK', index)) return;
                if (validacionCampos(fl['500%'], 'AL', index)) return;
                if (validacionCampos(fl['__EMPTY_26'], 'AM', index)) return;
                if (validacionCampos(fl['__EMPTY_27'], 'AN', index)) return;
                if (validacionCampos(fl['ME CABLES ANDES'], 'AO', index)) return;
                if (validacionCampos(fl['__EMPTY_28'], 'AP', index)) return;
                if (validacionCampos(fl['600%'], 'AQ', index)) return;
                if (validacionCampos(fl['__EMPTY_29'], 'AR', index)) return;
                if (validacionCampos(fl['__EMPTY_30'], 'AS', index)) return;
                if (validacionCampos(fl['MASTER'], 'AT', index)) return;
                if (validacionCampos(fl['__EMPTY_31'], 'AU', index)) return;
                if (validacionCampos(fl['700%'], 'AV', index)) return;
                if (validacionCampos(fl['__EMPTY_32'], 'AW', index)) return;
                if (validacionCampos(fl['__EMPTY_33'], 'AX', index)) return;
                if (validacionCampos(fl['SQD'], 'AY', index)) return;
                if (validacionCampos(fl['__EMPTY_34'], 'AZ', index)) return;
                if (validacionCampos(fl['800%'], 'BA', index)) return;
                if (validacionCampos(fl['__EMPTY_35'], 'BB', index)) return;
                if (validacionCampos(fl['__EMPTY_36'], 'BC', index)) return;
                if (validacionCampos(fl['REFOR'], 'BD', index)) return;
                if (validacionCampos(fl['__EMPTY_37'], 'BE', index)) return;
                if (validacionCampos(fl['900%'], 'BF', index)) return;
                if (validacionCampos(fl['__EMPTY_38'], 'BG', index)) return;
                if (validacionCampos(fl['__EMPTY_39'], 'BH', index)) return;
                if (validacionCampos(fl['CHOVA'], 'BI', index)) return;
                if (validacionCampos(fl['__EMPTY_40'], 'BJ', index)) return;
                if (validacionCampos(fl['1000%'], 'BK', index)) return;
                if (validacionCampos(fl['__EMPTY_41'], 'BL', index)) return;
                if (validacionCampos(fl['__EMPTY_42'], 'BM', index)) return;
                if (validacionCampos(fl['MEDIAS ROLAND'], 'BN', index)) return;
                if (validacionCampos(fl['__EMPTY_43'], 'BO', index)) return;
                if (validacionCampos(fl['11'], 'BP', index)) return;
                if (validacionCampos(fl['__EMPTY_44'], 'BQ', index)) return;
                if (validacionCampos(fl['__EMPTY_45'], 'BR', index)) return;
                if (validacionCampos(fl['TRAVEX'], 'BS', index)) return;
                if (validacionCampos(fl['__EMPTY_46'], 'BT', index)) return;
                if (validacionCampos(fl['12'], 'BU', index)) return;
                if (validacionCampos(fl['__EMPTY_47'], 'BV', index)) return;
                if (validacionCampos(fl['__EMPTY_48'], 'BW', index)) return;
                if (validacionCampos(fl['DHINO LED'], 'BX', index)) return;
                if (validacionCampos(fl['__EMPTY_49'], 'BY', index)) return;
                if (validacionCampos(fl['13'], 'BZ', index)) return;
                if (validacionCampos(fl['__EMPTY_50'], 'CA', index)) return;
                if (validacionCampos(fl['__EMPTY_51'], 'CB', index)) return;
                if (validacionCampos(fl['VETO'], 'CC', index)) return;
                if (validacionCampos(fl['__EMPTY_52'], 'CD', index)) return;
                if (validacionCampos(fl['14'], 'CE', index)) return;
                if (validacionCampos(fl['__EMPTY_53'], 'CF', index)) return;
                if (validacionCampos(fl['__EMPTY_54'], 'CG', index)) return;
                if (validacionCampos(fl['EMTOP'], 'CH', index)) return;
                if (validacionCampos(fl['__EMPTY_55'], 'CI', index)) return;
                if (validacionCampos(fl['15'], 'CJ', index)) return;
                if (validacionCampos(fl['__EMPTY_56'], 'CK', index)) return;
                if (validacionCampos(fl['__EMPTY_57'], 'CL', index)) return;
                if (validacionCampos(fl['PROINDUSQUIM S.A.'], 'CM', index)) return;
                if (validacionCampos(fl['__EMPTY_58'], 'CN', index)) return;
                if (validacionCampos(fl['16'], 'CO', index)) return;
                if (validacionCampos(fl['__EMPTY_59'], 'CP', index)) return;
                if (validacionCampos(fl['__EMPTY_60'], 'CQ', index)) return;
                if (validacionCampos(fl['COBERTURA DE CLIENTES'], 'CR', index)) return;
                if (validacionCampos(fl['__EMPTY_61'], 'CS', index)) return;
                if (validacionCampos(fl['__EMPTY_62'], 'CT', index)) return;
                if (validacionCampos(fl['__EMPTY_63'], 'CU', index)) return;
                if (validacionCampos(fl['__EMPTY_64'], 'CV', index)) return;
                if (validacionCampos(fl['COBRO CARTERA'], 'CW', index)) return;
                if (validacionCampos(fl['__EMPTY_65'], 'CX', index)) return;
                if (validacionCampos(fl['__EMPTY_66'], 'CY', index)) return;
                if (validacionCampos(fl['__EMPTY_67'], 'CZ', index)) return;
                if (validacionCampos(fl['__EMPTY_68'], 'DA', index)) return;
                if (validacionCampos(fl['CARTERA DE RIESGO'], 'DB', index)) return;
                if (validacionCampos(fl['__EMPTY_69'], 'DC', index)) return;
                if (validacionCampos(fl['__EMPTY_70'], 'DD', index)) return;
                if (validacionCampos(fl['__EMPTY_71'], 'DE', index)) return;
                if (validacionCampos(fl['__EMPTY_72'], 'DF', index)) return;
                if (validacionCampos(fl['Premios ultima semana'], 'DG', index)) return;
                if (validacionCampos(fl['__EMPTY_73'], 'DH', index)) return;
                if (validacionCampos(fl['__EMPTY_74'], 'DI', index)) return;
                if (validacionCampos(fl['__EMPTY_75'], 'DJ', index)) return;
                if (validacionCampos(fl['__EMPTY_76'], 'DK', index)) return;
                if (validacionCampos(fl['__EMPTY_77'], 'DL', index)) return;
                firebase.database().ref('tbl_plancomercial/' + fl["__EMPTY_1"]).set({
                    A: fl['__EMPTY'],
                    B: fl['__EMPTY_1'],
                    C: fl['__EMPTY_2'],
                    D: numberDecimal(fl['CUMPLIMIENTO DE CUOTA']),
                    E: numberDecimal(fl['__EMPTY_3']),
                    F: numberDecimal(fl['__EMPTY_4']),
                    G: fl['__EMPTY_5'],
                    H: fl['__EMPTY_6'],
                    I: numberDecimal(fl['__EMPTY_7']),
                    J: numberDecimal(fl['__EMPTY_8']),
                    K: numberDecimal(fl['ZAFIRO']),
                    L: numberDecimal(fl['__EMPTY_9']),
                    M: numberDecimal(fl['__EMPTY_10']),
                    N: numberDecimal(fl['__EMPTY_11']),
                    O: numberDecimal(fl['__EMPTY_12']),
                    P: numberDecimal(fl['BAHCO E IRIMO']),
                    Q: numberDecimal(fl['__EMPTY_13']),
                    R: numberDecimal(fl['100%']),
                    S: numberDecimal(fl['__EMPTY_14']),
                    T: numberDecimal(fl['__EMPTY_15']),
                    U: numberDecimal(fl['DEXSON']),
                    V: numberDecimal(fl['__EMPTY_16']),
                    W: numberDecimal(fl['200%']),
                    X: numberDecimal(fl['__EMPTY_17']),
                    Y: numberDecimal(fl['__EMPTY_18']),
                    Z: numberDecimal(fl['FERRETERIA']),
                    AA: numberDecimal(fl['__EMPTY_19']),
                    AB: numberDecimal(fl['300%']),
                    AC: numberDecimal(fl['__EMPTY_20']),
                    AD: numberDecimal(fl['__EMPTY_21']),
                    AE: numberDecimal(fl['NORTON VARIOS']),
                    AF: numberDecimal(fl['__EMPTY_22']),
                    AG: numberDecimal(fl['400%']),
                    AH: numberDecimal(fl['__EMPTY_23']),
                    AI: numberDecimal(fl['__EMPTY_24']),
                    AJ: numberDecimal(fl['IMPORTADOS']),
                    AK: numberDecimal(fl['__EMPTY_25']),
                    AL: numberDecimal(fl['500%']),
                    AM: numberDecimal(fl['__EMPTY_26']),
                    AN: numberDecimal(fl['__EMPTY_27']),
                    AO: numberDecimal(fl['ME CABLES ANDES']),
                    AP: numberDecimal(fl['__EMPTY_28']),
                    AQ: numberDecimal(fl['600%']),
                    AR: numberDecimal(fl['__EMPTY_29']),
                    AS: numberDecimal(fl['__EMPTY_30']),
                    AT: numberDecimal(fl['MASTER']),
                    AU: numberDecimal(fl['__EMPTY_31']),
                    AV: numberDecimal(fl['700%']),
                    AW: numberDecimal(fl['__EMPTY_32']),
                    AX: numberDecimal(fl['__EMPTY_33']),
                    AY: numberDecimal(fl['SQD']),
                    AZ: numberDecimal(fl['__EMPTY_34']),
                    BA: numberDecimal(fl['800%']),
                    BB: numberDecimal(fl['__EMPTY_35']),
                    BC: numberDecimal(fl['__EMPTY_36']),
                    BD: numberDecimal(fl['REFOR']),
                    BE: numberDecimal(fl['__EMPTY_37']),
                    BF: numberDecimal(fl['900%']),
                    BG: numberDecimal(fl['__EMPTY_38']),
                    BH: numberDecimal(fl['__EMPTY_39']),
                    BI: numberDecimal(fl['CHOVA']),
                    BJ: numberDecimal(fl['__EMPTY_40']),
                    BK: numberDecimal(fl['1000%']),
                    BL: numberDecimal(fl['__EMPTY_41']),
                    BM: numberDecimal(fl['__EMPTY_42']),
                    BN: numberDecimal(fl['MEDIAS ROLAND']),
                    BO: numberDecimal(fl['__EMPTY_43']),
                    BP: numberDecimal(fl['11']),
                    BQ: numberDecimal(fl['__EMPTY_44']),
                    BR: numberDecimal(fl['__EMPTY_45']),
                    BS: numberDecimal(fl['TRAVEX']),
                    BT: numberDecimal(fl['__EMPTY_46']),
                    BU: numberDecimal(fl['12']),
                    BV: numberDecimal(fl['__EMPTY_47']),
                    BW: numberDecimal(fl['__EMPTY_48']),
                    BX: numberDecimal(fl['DHINO LED']),
                    BY: numberDecimal(fl['__EMPTY_49']),
                    BZ: numberDecimal(fl['13']),
                    CA: numberDecimal(fl['__EMPTY_50']),
                    CB: numberDecimal(fl['__EMPTY_51']),
                    CC: numberDecimal(fl['VETO']),
                    CD: numberDecimal(fl['__EMPTY_52']),
                    CE: numberDecimal(fl['14']),
                    CF: numberDecimal(fl['__EMPTY_53']),
                    CG: numberDecimal(fl['__EMPTY_54']),
                    CH: numberDecimal(fl['EMTOP']),
                    CI: numberDecimal(fl['__EMPTY_55']),
                    CJ: numberDecimal(fl['15']),
                    CK: numberDecimal(fl['__EMPTY_56']),
                    CL: numberDecimal(fl['__EMPTY_57']),
                    CM: numberDecimal(fl['PROINDUSQUIM S.A.']),
                    CN: numberDecimal(fl['__EMPTY_58']),
                    CO: numberDecimal(fl['16']),
                    CP: numberDecimal(fl['__EMPTY_59']),
                    CQ: numberDecimal(fl['__EMPTY_60']),
                    CR: numberDecimal(fl['COBERTURA DE CLIENTES']),
                    CS: numberDecimal(fl['__EMPTY_61']),
                    CT: numberDecimal(fl['__EMPTY_62']),
                    CU: numberDecimal(fl['__EMPTY_63']),
                    CV: numberDecimal(fl['__EMPTY_64']),
                    CW: numberDecimal(fl['COBRO CARTERA']),
                    CX: numberDecimal(fl['__EMPTY_65']),
                    CY: numberDecimal(fl['__EMPTY_66']),
                    CZ: numberDecimal(fl['__EMPTY_67']),
                    DA: numberDecimal(fl['__EMPTY_68']),
                    DB: numberDecimal(fl['CARTERA DE RIESGO']),
                    DC: numberDecimal(fl['__EMPTY_69']),
                    DD: numberDecimal(fl['__EMPTY_70']),
                    DE: numberDecimal(fl['__EMPTY_71']),
                    DF: numberDecimal(fl['__EMPTY_72']),
                    DG: numberDecimal(fl['Premios ultima semana']),
                    DH: numberDecimal(fl['__EMPTY_73']),
                    DI: numberDecimal(fl['__EMPTY_74']),
                    DJ: numberDecimal(fl['__EMPTY_75']),
                    DK: numberDecimal(fl['__EMPTY_76']),
                    DL: numberDecimal(fl['__EMPTY_77'])
                }); */
                /* let indice = 0;
                for (let index = 0; index < hoja2.length; index++) {
                    const fl1 = hoja2[index];
                    if (validacionCampos1(fl1['codigovendedor'], 'A', index)) return;
                    if (validacionCampos1(fl1['nombrevendedor'], 'B', index)) return;
                    if (validacionCampos1(fl1['codigo_cliente'], 'C', index)) return;
                    if (validacionCampos1(fl1['Nombre Cliente'], 'D', index)) return;
                    if (validacionCampos1(fl1['Venta'], 'E', index)) return;
                    if (fl['__EMPTY_1'] == fl1['codigovendedor']) {
                        firebase.database().ref('tbl_plancomercialclientes/' + fl1["codigovendedor"] + '/' + indice).set({
                            A: fl1['codigovendedor'],
                            B: fl1['nombrevendedor'],
                            C: fl1['codigo_cliente'],
                            D: fl1['Nombre Cliente'],
                            E: numberDecimal(fl1['Venta'])
                        });
                        indice++;
                    }
                }
                if (index == hoja1.length - 1) {
                    alert('GUARDADO');
                    //setInterval("actualizar()", 10000);
                } 
            }*/
        }
    };
    if (rABS) {
        reader.readAsArrayBuffer(f);
    } else {
        reader.readAsBinaryString(f);
    }
}

function numberDecimal(valor) {
    if((valor+"").indexOf('.')!=-1){
        var data = (valor+"").split('.');
        if (data.length > 1) {
            return Math.round(valor * 100) / 100;
        }
    }
    if((valor+"").indexOf(',')!=-1){
        var data = (valor+"").split(',');
        if (data.length > 1) {
            return Math.round(valor * 100) / 100;
        }
    }
    return valor;
}

function validacionCampos(campo, nombre, fila) {
    //VALIDACIÓN CAMPO VACIO
    if (typeof(campo) == "undefined") {
        alert('ERROR REVISE:\nHOJA RESULTADOS: COLUMNA ' + nombre + ' FILA ' + (fila + 2));
        window.location.reload();
        return true;
    }
    //VALIDACIÓN CAMPO TIPO NUMERICO
    if (!(nombre == "A" || nombre == "B" || nombre == "C" || nombre == "G")) {
        try {
            let dato = parseFloat(campo);
            if ((dato + "") == "NaN") {
                alert('ERROR REVISE:\nHOJA RESULTADOS: COLUMNA ' + nombre + ' FILA ' + (fila + 2));
                window.location.reload();
                return true;
            }
        } catch (e) {
            alert('ERROR REVISE:\nHOJA RESULTADOS: COLUMNA ' + nombre + ' FILA ' + (fila + 2));
            window.location.reload();
            return true;
        }
    } else {
        //VALIDACIÓN TEXTO NO CONTENGA NUMEROS
        if (nombre == "A" || nombre == "C" || nombre == "G") {
            if(campo==""){
                alert('ERROR REVISE:\nHOJA RESULTADOS: COLUMNA ' + nombre + ' FILA ' + (fila + 2));
                window.location.reload();
                return true;
            }
            var datos = (campo + "").split('');
            for (let index = 0; index < datos.length; index++) {
                const element = datos[index];
                switch (element) {
                    case "0":
                    case "1":
                    case "2":
                    case "3":
                    case "4":
                    case "5":
                    case "6":
                    case "7":
                    case "8":
                    case "9":
                        alert('ERROR REVISE:\nHOJA RESULTADOS: COLUMNA ' + nombre + ' FILA ' + (fila + 2));
                        window.location.reload();
                        return true;
                }
            }
        }
    }
    return false;
}

function validacionCampos1(campo, nombre, fila) {
    if (typeof(campo) == "undefined") {
        alert('ERROR REVISE:\nHOJA CLIENTES: COLUMNA ' + nombre + ' FILA ' + (fila + 2));
        window.location.reload();
        return true;
    }
    if (nombre == "E") {
        try {
            let dato = parseFloat(campo);
            if ((dato + "") == "NaN") {
                alert('ERROR REVISE:\nHOJA CLIENTES: COLUMNA ' + nombre + ' FILA ' + (fila + 2));
                window.location.reload();
                return true;
            }
        } catch (e) {
            alert('ERROR REVISE:\nHOJA CLIENTES: COLUMNA ' + nombre + ' FILA ' + (fila + 2));
            window.location.reload();
            return true;
        }
    } else {
        if (nombre == "B") {
            var datos = (campo + "").split('');
            for (let index = 0; index < datos.length; index++) {
                const element = datos[index];
                switch (element) {
                    case "0":
                    case "1":
                    case "2":
                    case "3":
                    case "4":
                    case "5":
                    case "6":
                    case "7":
                    case "8":
                    case "9":
                        alert('ERROR REVISE:\nHOJA CLIENTES: COLUMNA ' + nombre + ' FILA ' + (fila + 2));
                        window.location.reload();
                        return true;
                }
            }
        }
    }
    return false;
}

function abecedatio(index) {
    let rango = index/26 | 0;
    let rt = index%26 | 0;
    if(rango==0)
        return letrasAbc(index);
    else if(rt==0)
        return letrasAbc(rango-1)+letrasAbc(26);
    else
        return letrasAbc(rango)+letrasAbc(rt);
}

function letrasAbc(index) {
    switch (index) {
        case 0: return "";
        case 1: return "A";
        case 2: return "B";
        case 3: return "C";
        case 4: return "D";
        case 5: return "E";
        case 6: return "F";
        case 7: return "G";
        case 8: return "H";
        case 9: return "I";
        case 10: return "J";
        case 11: return "K";
        case 12: return "L";
        case 13: return "M";
        case 14: return "N";
        case 15: return "O";
        case 16: return "P";
        case 17: return "Q";
        case 18: return "R";
        case 19: return "S";
        case 20: return "T";
        case 21: return "U";
        case 22: return "V";
        case 23: return "W";
        case 24: return "X";
        case 25: return "Y";
        case 26: return "Z";
    }
}

function fixdata(data) { // Transferencia de archivos BinaryString
    var o = "",
        l = 0,
        w = 10240;
    for (; l < data.byteLength / w; ++l) o += String.fromCharCode.apply(null, new Uint8Array(data.slice(l * w, l * w + w)));
    o += String.fromCharCode.apply(null, new Uint8Array(data.slice(l * w)));
    return o;
}