const cont=document.querySelector("#cont");
isLogged();


function isLogged(){
    let sessdata=localStorage.getItem("sessdata");
    if(sessdata != null){
        let ls=JSON.parse(sessdata);
        let d=new Date();
        console.log("ls");
        console.log(ls);
        if((d.getTime() - ls.timestamp) < 7*24*3600*1000 ){
            let cad='';
            fetch("jsonnav.php?nivel="+ls.nivel)
            .then((resp)=>{return resp.json();})
            .then((jsonnav)=>{
                for(let i in jsonnav){
                    let s=jsonnav[i].nombre;
                    if(jsonnav[i].menu != "No")
                        cad+='<li class="nav-item"><a class="nav-link" href="index.html?p='+s.toLowerCase()+'">'+s+'</a></li>';
                }
                let navbar=`<ul class="navbar-nav mr-auto">`+cad+`</ul>
                <div class="float-right text-primary" id="logout" onclick="logout()"><span class="fa fa-user "></span>&nbsp;<span id="usuario">--</span></div>`;
                document.querySelector("#navbarSupportedContent").innerHTML=navbar;
                document.querySelector("#usuario").innerHTML=ls.nombre;
            });
            viewContent();
            return;
        }else{
            localStorage.clear();
        }
    }
    fetch("jsonnav.php?nivel=Todos")
    .then((resp)=>{return resp.json();})
    .then((jsonnav)=>{
        let cad='';
        for(let i in jsonnav){
            let s=jsonnav[i].nombre;
            if(jsonnav[i].menu != "No")
                cad+='<li class="nav-item"><a class="nav-link" href="index.html?p='+s.toLowerCase()+'">'+s+'</a></li>';
        }
        let navbar=`<ul class="navbar-nav mr-auto">`+cad+`</ul>
            <div class="float-right text-primary" id="logout" onclick="logout()"><span class="fa fa-user "></span>&nbsp;<span id="usuario">Ingresar</span></div>`;
        document.querySelector("#navbarSupportedContent").innerHTML=navbar;
        viewContent();
    });

}




function viewContent(){
    let objurl=getUrlVars();
    let sessdata=localStorage.getItem('sessdata');
    if(sessdata == null)
        sessdata='{"nivel":"Todos"}';
    if(typeof objurl.p !== "undefined"){
        $(".nav-item").each(function(){
            var u=$(this).find(".nav-link").attr("href").split("=");
            if(objurl.p == u[1])
                $(this).addClass("active");
            else
                $(this).removeClass("active");
        });
    }
    fetch('content.php?content=' + objurl.p + "&sessdata=" + sessdata)
    .then((resp)=>{
        return resp.json();
    })
    .then((json)=>{
        if(json.rta == "OK"){
            $("#cont").empty().off().append(json.msg);
        }else{
            cont.innerHTML='';
            location.assign("index.html?p=turnos");
        }
    })
}


function logout(){
    localStorage.clear();
    location.assign("index.html?p=login");
}


function alerta(titu,msg){
    $("#modaltitu").html(titu);
    $("#modalbody").html(msg);
    $("#modal").modal("toggle");
}


function getUrlVars() {
    var vars = {};
    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
        vars[key] = decodeURIComponent((value + '').replace(/\+/g, '%20'));
    });
    return vars;
}



$(document).ajaxStart(function () {
    $('#loading').show();
}).ajaxStop(function () {
    $('#loading').hide();
});
