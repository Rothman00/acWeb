function iniciarF() {
    // Your web app's Firebase configuration
    // For Firebase JS SDK v7.20.0 and later, measurementId is optional
    var firebaseConfig = {
        apiKey: "AIzaSyCjaTgtp6MvVMiks_NvgRvmBz8V0-TTj_g",
        authDomain: "asesorcomercial.firebaseapp.com",
        databaseURL: "https://asesorcomercial-default-rtdb.firebaseio.com",
        projectId: "asesorcomercial",
        storageBucket: "asesorcomercial.appspot.com",
        messagingSenderId: "665144118715",
        appId: "1:665144118715:web:38d2448e1552a871e1089e",
        measurementId: "G-ZQMNREYKQD"
    };
    // Initialize Firebase
    firebase.initializeApp(firebaseConfig);
    firebase.analytics();
    var database = firebase.database();
    var storage = firebase.storage();
}