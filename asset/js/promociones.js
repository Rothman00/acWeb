var idSelect = 0;
var urlSelect = "";

function pasarInfo(id, url, desde, hasta) {
    idSelect = id;
    urlSelect = url;
    $("#mostrarImg").attr("src", url);
    $("#fecDesdeM").val(desde);
    $("#fecHastaM").val(hasta);
}

function modificarImgP() {
    var conf = confirm("Estás seguro de activar?");
    if (conf) {
        var postData = {
            PRM_ESTADO: true,
            PRM_FECHAD: $("#fecDesdeM").val(),
            PRM_FECHAH: $("#fecHastaM").val(),
            PRM_ID: parseInt(idSelect, 10),
            PRM_URL: urlSelect
        };
        var updates = {};
        updates['/tbl_promociones/' + idSelect] = postData;
        firebase.database().ref().update(updates);
        console.log("MODIFICADO");
        location.reload();
    }
}

function eliminarImgP() {
    var conf = confirm("Estás seguro de inactivar?");
    if (conf) {
        var postData = {
            PRM_ESTADO: false,
            PRM_FECHAD: $("#fecDesdeM").val(),
            PRM_FECHAH: $("#fecHastaM").val(),
            PRM_ID: idSelect,
            PRM_URL: urlSelect
        };
        var updates = {};
        updates['/tbl_promociones/' + idSelect] = postData;
        firebase.database().ref().update(updates);
        /*var storage = firebase.storage();
        var storageRef = storage.ref();
        var desertRef = storageRef.child('promotions/' + promoNombre(urlSelect));
        desertRef.delete().then(function() {}).catch(function(error) {});*/
        console.log("INACTIVO");
        location.reload();
    }
}


function promoNombre(name) {
    var res = name.substring(87);
    $r = res.split("?alt=media");
    return $r[0];
}