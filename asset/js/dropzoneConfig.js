var listaImagenes = {};
Dropzone.autoDiscover = false;
$(".dropzone").dropzone({
    dictDefaultMessage: 'Selecciona tus archivos..',
    dictRemoveFile: "Eliminar",
    dictCancelUpload: "Cancelar",
    maxFilesize: 2,
    addRemoveLinks: true,
    removedfile: function(file) {
        var _ref;
        var storage = firebase.storage();
        var storageRef = storage.ref();
        try {
            var desertRef = storageRef.child('promotions/' + listaImagenes[file.name][1]);
            desertRef.delete().then(function() {}).catch(function(error) {});
        } catch (e) {
            console.log(e);
        }
        delete listaImagenes[file.name];
        return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
    },
    processing: function(file) {
        var nuevoName = getFormattedTime(file.name);
        listaImagenes[file.name] = [file, nuevoName];
        file.name = nuevoName;
        var storage = firebase.storage();
        var storageRef = storage.ref();
        var metadata = {
            contentType: file.type,
        };
        storageRef.child('promotions/' + nuevoName).put(file, metadata);
    }
});

function getFormattedTime(nombre) {
    var today = new Date();
    var y = today.getFullYear();
    var m = today.getMonth() + 1;
    var d = today.getDate();
    var h = today.getHours();
    var mi = today.getMinutes();
    var s = today.getSeconds();
    return y + "_" + m + "_" + d + "_" + h + "_" + mi + "_" + s + "__" + nombre;
}

function guardarDatos() {
    var fD = $("#fecDesde").val();
    var fH = $("#fecHasta").val();
    if (fD == "" || fH == "" || Object.values(listaImagenes).length == 0) {
        alert("Advertencia: Datos incompletos");
    } else {
        var idP = -1;
        const dbRef = firebase.database().ref();
        dbRef.child("tbl_promociones").get().then((snapshot) => {
            if (snapshot.exists()) {
                var datos = snapshot.val();
                idP = datos[datos.length - 1]["PRM_ID"];
            } else {
                idP = -1;
            }
            for (var key in listaImagenes) {
                var storage = firebase.storage();
                var storageRef2 = storage.ref();
                //var file = listaImagenes[key][0];
                storageRef2.child('promotions/' + listaImagenes[key][1]).getDownloadURL().then(function(url) {
                    idP++;
                    firebase.database().ref('tbl_promociones/' + idP).set({
                        PRM_ESTADO: true,
                        PRM_FECHAD: fD,
                        PRM_FECHAH: fH,
                        PRM_ID: idP,
                        PRM_URL: url
                    });
                }).catch(function(error) {
                    console.log(error);
                    alert("Advertencia no se ha guardado las imagenes, por favor vuelva a intentar");
                });
            }
            location.reload();
            listaImagenes = {};
        }).catch((error) => {
            console.error(error);
            alert("Error en la base de datos");
        });
    }
}