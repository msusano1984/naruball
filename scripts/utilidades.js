
function cargaHTML(contendor, url, name, callback){

  var rand = Math.floor((Math.random() * 10000000) + 1); 
  $(contendor).attr("name",name);
  $(contendor).load( url+"?rand="+rand, callback);
}

f
function getUrlVars() {
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for (var i = 0; i < hashes.length; i++) {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars;
}


function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
} 


function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
} 

function checkCookie() {
    debugger;
    var rememberme = getCookie("escuderia-rememberme");
    if (rememberme != "") {
        postrequest("usuarios/rememberme", {"claveapi" : rememberme  }, function(data) {

        if (data.valido) {

          
          sessionStorage.setItem('nombre', data["nombre"] + " " + data["appaterno"] + " " + data["apmaterno"]);
          sessionStorage.setItem('correo', data["correo"]);
          sessionStorage.setItem('publico', data["publico"]);
          sessionStorage.setItem('es_admin', data["esadmin"]);
          sessionStorage.setItem('claveapi', data["claveapi"]);
          setCookie("escuderia-rememberme", data["claveapi"], true);
          
          window.location.href = "main.php";

        } else {
          alert("Error de usuario o contraseña");
        }

      });

    } 
} 