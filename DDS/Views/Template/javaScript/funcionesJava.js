var lista_global;
Array.prototype.unique=function(a){
    return function(){return this.filter(a)}}(function(a,b,c){return c.indexOf(a,b+1)<0
});

function cargaDatos(){
    var puestos = document.getElementById("puestos");
    var lista = new Array();
    for (var i = 0; i < puestos.length; ++i) {
        var child = puestos.children[i];
        if (child.tagName === "OPTION") {
            var cadena = child.value;
            var arreglo = cadena.split(",");
            var puesto = new Array();
            puesto.push(arreglo[0]); puesto.push(arreglo[1]); puesto.push(arreglo[2]);
            var caracteristicas = listarCaracteristicas(arreglo[0]);
            puesto.push(caracteristicas);
            lista.push(puesto);
        }
    }
    lista_global = lista;
    llenarSelect();
}

function listarCaracteristicas(nom_puesto){
    var listaCaract = document.getElementById("caracteristicas");
    var lista = new Array();
    for (var i = 0; i < listaCaract.length; ++i) {
        var child = listaCaract.children[i];
        if (child.tagName === "OPTION") {
            var cadena = child.value;
            var arreglo = cadena.split(",");
            var caract = new Array();
            if((arreglo[0].indexOf(nom_puesto)) !== -1){
                caract.push(arreglo[1]); caract.push(arreglo[2]);
                lista.push(caract);
            }
        }
    }
    return lista;
}

function llenarSelect() {
    var s_puesto = document.form1.puesto;
    var listaEmp = new Array();
    for (var i = 0; i < lista_global.length; ++i) {
        var option=document.createElement("option");
        option.value = lista_global[i][0]; 
        option.text = lista_global[i][0]; 
        listaEmp.push(lista_global[i][1]);  
        s_puesto.appendChild(option);
    }

    var s_empresa = document.form1.empresa;
    var lista = listaEmp.unique();
    for (var j = 0; lista.length > j; j++){
        var option=document.createElement("option"); 
        option.value = lista[j]; 
        option.text = lista[j]; 
        s_empresa.appendChild(option);
    }
}

function seleccionoPuesto(){
    var puesto = document.getElementById("puesto").value;
    for(var i = 0; i < lista_global.length; ++i){
        if((lista_global[i][0].indexOf(puesto)) !== -1){
            document.getElementById("empresa").value = lista_global[i][1];
        }
    }
    competencias_ponderacion();
}

function seleccionoEmpresa(){
    var empresa = document.getElementById("empresa").value;
    var puestos = document.getElementById("puesto");

    if(empresa !== '0'){
        var puesto = buscarRelacion();
        for (var i = 0; i < puestos.length; ++i) {
            var child = puestos.children[i];
            if (child.tagName == "OPTION" && child.value !== '0') {
                var cadena = child.text;
                var pertenece = incluido(puesto, cadena);
                if (pertenece === -1){
                    child.style.display = "none";
                } else {
                    child.style.display = "block";
                }
            } else {
                child.selected = true;
            }
        }
    } else {
        for (var i = 0; i < puestos.length; ++i) {
            var child = puestos.children[i];
            if (child.tagName === "OPTION" && child.value !== '0') {
                child.style.display = "block";
            } else {
                child.selected = true;
            }
        }
    }
}

function incluido(lista, texto){
    var retorno = -1;
    for(var i = 0; i < lista.length; i++){
        if(lista[i].indexOf(texto) !== -1){
            retorno = 1;
        }
    }
    return retorno;
}

function buscarRelacion(){
    var empresa = document.getElementById("empresa").value;
    var retorno = new Array();
    for(var i = 0; i < lista_global.length; ++i){
        if((lista_global[i][1].indexOf(empresa)) !== -1){
            retorno.push(lista_global[i][0]);
        }
    }
    return retorno;
}

function genera_tabla(elementos, tipo) {
    var tabla   = document.getElementById("tablaCompPon");
    var tblBody = document.createElement("tbody");
    var hilera = document.createElement("tr");
    for(var i = 0; i < elementos.length; i++){
        var celda = document.createElement(tipo);
        if(tipo === "th"){
            celda.setAttribute("height", "25");
            celda.setAttribute("bgcolor","#cccccc");
            celda.setAttribute("aling","left");
        }
        var textoCelda = document.createTextNode(elementos[i]);
        celda.appendChild(textoCelda);
        hilera.appendChild(celda);
    }
    tblBody.appendChild(hilera);
    tabla.appendChild(tblBody);
}

function borrarTabla() {
    var table = document.getElementById("tablaCompPon");
    var rowCount = table.rows.length;
    for(var i=0; i<rowCount; i++) {
        table.deleteRow(i);
        rowCount--;
        i--;
    }
}

function competencias_ponderacion(){
    borrarTabla();
    var elementos = new Array();
    elementos.push("Competencia"); elementos.push("Ponderación");
    genera_tabla(elementos, "th");
    // Obtenemos el valor por el id
    var puesto = document.getElementById("puesto").value;
    for(var i = 0; lista_global.length; i++){
        if((lista_global[i][0].indexOf(puesto)) !== -1){
            var caract = lista_global[i][3];
            for(var j = 0; j < caract.length; j++){
                elementos = new Array();
                elementos.push(caract[j][0]); elementos.push(caract[j][1]);
                genera_tabla(elementos, "td");
            }
        }
    }
}

function agregar() {
    var agregar = document.getElementById('competenciasDes');
    var agregadoID = agregar.options[agregar.selectedIndex].id;
    var agregado = agregar.options[agregar.selectedIndex].text;
    var option = document.createElement("option");
    option.value=agregadoID;
    option.id=agregadoID;
    option.text=agregado;
    var s=document.getElementById('competenciasSel');
    s.appendChild(option);
    agregar.removeChild(agregar.options[agregar.selectedIndex]);  
    armar();
}
function quitar() {
    var agregar = document.getElementById('competenciasSel');
    var agregadoID = agregar.options[agregar.selectedIndex].id;
    var agregado = agregar.options[agregar.selectedIndex].text;
    var option = document.createElement("option");
    option.value=agregado;
    option.id=agregadoID;
    option.text=agregado;
    var s=document.getElementById('competenciasDes');
    s.appendChild(option);
    agregar.removeChild(agregar.options[agregar.selectedIndex]);    
}
function armar() {
	var sel = document.getElementById("competenciasSel");
        for (var i = 0; i < sel.children.length; ++i) {
            var child = sel.children[i];
            if (child.tagName == "OPTION") {child.selected =true;}
        }
        return true;
}
  
function mostrar(){
    document.getElementById('oculto').style.display = 'block';}
function ocultar(){
    document.getElementById('oculto').style.display = 'none';}

function keydownFunction() {
    d = document.getElementById("descripcion");
    if((d.value.length >= 150) == true){ document.getElementById('oculto').style.display = 'block'; } 
}
function keyupFunction() {
    d = document.getElementById("descripcion");
    if((d.value.length <= 150) == true){ document.getElementById('oculto').style.display = 'none'; }
}

function deseleccionar_todo(){ 
  var id_click = elemento(event);
  var ele = document.getElementById(id_click);
  if (ele.checked) 
    {for (i=0;i<document.form2.elements.length;i++) 
      if(document.form2.elements[i].type == "checkbox")
        if (document.form2.elements[i].id!==id_click)
          document.form2.elements[i].disabled='disabled'; }
        else 
            {for (i=0;i<document.form2.elements.length;i++)
              if(document.form2.elements[i].type == "checkbox")
                if (document.form2.elements[i].id!==id_click)
                  document.form2.elements[i].disabled=!document.form2.elements[i].disabled;
                }
}
function elemento(e){
  if (e.srcElement)
    tag = e.srcElement.id;
  else if (e.target)
      tag = e.target.id;
 return (tag);
}

function respuestas(indice) {
var opcion = document.getElementsByName(indice);
for (x=0; x < opcion.length; x++) {
	if (opcion.item(x).checked) {
            return opcion.item(x).value;}
	}
}
function verificar_check(indice) {
var opcion = document.getElementsByName(indice);
for (x=0; x < opcion.length; x++) {
	if (opcion.item(x).checked) {
		return false;}
	}
return true;
}

arregloCodigos;
function validarformulario_cuestionario(){
    var bandera = "0";
    for(var j = 0; arregloCodigos.length > j; j++){
        var hola = document.getElementById("e"+j);
        hola.style.visibility="hidden";
    }

    for(var i = 0; arregloCodigos.length > i; i++){
        if (verificar_check(i)) {
                var hola = document.getElementById("e"+i);
                hola.style.visibility="visible";
                bandera = "1";
        }
    }

    if (bandera=="0") { 
        //ARREGLO DE RESPUESTA
        var nuevo = new Array();
        for (var x=0; arregloCodigos.length > x; x++){
            var a = new Array();
            a.push(arregloCodigos[x], respuestas(x));
            nuevo.push(a);
        }

        document.getElementById('arreglo').value = nuevo;
        return true;
    } else {
        return false;
    }
}
function Validar_autenticar(user,pwd){
    user=document.getElementById(user);
    pwd=document.getElementById(pwd);
    if(user.value=="" || pwd.value=="")
    {
        alert("Debe ingresar TODOS los campos requeridos");
        user.focus();
        return false;
    }
    else {
        return true;
    }
}
function Validar_autenticar2(f){
    if(f.documento.value == "" || f.clave2.value == "" || f.tipo.value == '0')
    {
        alert("Debe ingresar TODOS los campos requeridos");
        f.documento.focus();
        return false;
    }
    else {
        return true;
    }
}
function validarformulario_gestionarPuesto(f){ 
    var valido=false; 
    for(a=0; a<f.elements.length; a++){ 
        if(f[a].type=="radio" && f[a].checked==true){ 
            valido=true; 
            break 
        } 
    } 
    if(!valido){ 
        alert("Debe una seleccionar un puesto para poder continuar!");
        return false;
    } 
}  
function validarformulario_modificarPuesto(f) { 
    var retorno = true;
    if(f.puesto.value == '') {
        document.getElementById('oculto3').style.display = 'block'; 
        retorno = false;
    } else { 
        document.getElementById('oculto3').style.display = 'none'; }
    if (f.empresa.value == "valorpordefecto" ) { 
        document.getElementById('oculto4').style.display = 'block'; 
        retorno = false;
    } else { 
        document.getElementById('oculto4').style.display = 'none'; }
    if (document.forms['form1']['competenciasSel[]'].length == 0 ) { 
        document.getElementById('oculto5').style.display = 'block'; 
        retorno = false;
    } else { 
        document.getElementById('oculto5').style.display = 'none'; }
    
    if(retorno == true){ 
        retorno = armar(); }
    
    return retorno;
}
function validarformulario_altaPuesto(f) { 
    var retorno = true;
    if (f.codigo.value   == '') { 
        document.getElementById('oculto2').style.display = 'block'; 
        retorno = false;
    } else { 
        document.getElementById('oculto2').style.display = 'none'; }
    if (f.codigo.value % 1 != 0) { 
        document.getElementById('oculto2codigo').style.display = 'block'; 
        retorno = false;
    } else { 
        document.getElementById('oculto2codigo').style.display = 'none'; }
    
    if(f.puesto.value  == '') {
        document.getElementById('oculto3').style.display = 'block'; 
        retorno = false;
    } else { 
        document.getElementById('oculto3').style.display = 'none'; }
    if (f.empresa.value == "valorpordefecto" ) { 
        document.getElementById('oculto4').style.display = 'block'; 
        retorno = false;
    } else { 
        document.getElementById('oculto4').style.display = 'none'; }
    if (document.forms['form1']['competenciasSel[]'].length == 0 ) { 
        document.getElementById('oculto5').style.display = 'block'; 
        retorno = false;
    } else { 
        document.getElementById('oculto5').style.display = 'none'; }
    
    if(retorno == true){ 
        retorno = armar(); }
    
    return retorno;
}
function validarPonderaciones(){
    var bandera = 0;
        for(var key = 0; document.getElementById("cantidad").value > key ; key++){
            var ponderacion = parseInt(document.getElementById(key).value);
            if(ponderacion > 10 || ponderacion <= 0){
                bandera = 1;
            }
            if (document.getElementById(key).value == '') { 
                bandera = 1;
            } 
            if (ponderacion % 1 != 0) { 
                    bandera = 1;
            }
        }
        
        if(bandera == 0){
            return true;
        }
        else {
            alert('Las ponderaciones SOLO pueden tomar valores del 0 al 10 puntos');
            return false;
        }
}
function validarformulario_evaluar() { 
    var retorno = true;
    if (document.forms['form1']['competenciasSel[]'].length == 0 ) { 
        document.getElementById('oculto').style.display = 'block'; 
        retorno = false;
    } else { 
        document.getElementById('oculto').style.display = 'none'; }
    
    if(retorno === true){ 
        retorno = armar(); }
    
    return retorno;
}
function validarformulario_Evaluar2() { 
    var retorno = true;
    var puesto = document.getElementById('puesto').value;
    if (puesto === '0' ) { 
        document.getElementById('oculto').style.display = 'block'; 
        retorno = false;
    } else {
        var codigo;
        for(var i = 0; i < lista_global.length; ++i){
            if((lista_global[i][0].indexOf(puesto)) !== -1){
                codigo = lista_global[i][2];
            }
        }
        document.getElementById('codigoPuesto').value = codigo;
        document.getElementById('oculto').style.display = 'none'; 
    }

    return retorno;
}
function validar_ordenMerito1(f){
    var valido=false; 
    for(a=0; a<f.elements.length; a++){ 
        if(f[a].type=="radio" && f[a].checked==true){ 
            valido=true; 
            break 
        } 
    } 
    if(!valido){ 
        alert("Debe una seleccionar un puesto para poder continuar!");
        return false;
    }
}

function ordenarDes(){
    with (document.forms["form1"]["competenciasDes"])	{
            for (var i = 0; i < options.length - 1; i ++)
                    if (options[i].text >= options[i + 1].text)	{
                            temptext = options[i].text;
                            tempvalue = options[i].value;
                            options[i].text = options[i + 1].text;
                            options[i].value = options[i + 1].value;
                            options[i + 1].text = temptext;
                            options[i + 1].value = tempvalue;
                    }
    }
}
function ordenarSel(){
    with (document.forms["form1"]["competenciasSel"])	{
            for (var i = 0; i < options.length - 1; i ++)
                    if (options[i].text >= options[i + 1].text)	{
                            temptext = options[i].text;
                            tempvalue = options[i].value;
                            options[i].text = options[i + 1].text;
                            options[i].value = options[i + 1].value;
                            options[i + 1].text = temptext;
                            options[i + 1].value = tempvalue;
                    }
    }
}

function mostrarTodos(){
    var sel = document.getElementById("competenciasDes");
    for (var i = 0; i < sel.length; ++i) {
        var child = sel.children[i];
        if (child.tagName == "OPTION") {
            child.style.display = "block";
        }
    }
}
function filtar(){
    var apellido = capturaApe();
    var nombre = capturaNom();
    var numero = capturaNum();
    mostrarTodos();
    if(apellido !== ""){ recorrerApe(); }
    if(nombre !== ""){ recorrerNom(); }
    if(numero !== ""){ recorrerNum(); }
}
function capturaApe() {
    var tecla = document.getElementById("apellido").value;
    return (tecla);
}
function capturaNom() {
    var tecla = document.getElementById("nombre").value;
    return (tecla);
}
function capturaNum() {
    var tecla = document.getElementById("nCandidato").value;
    return (tecla);
}
function recorrerNum(){
    var texto = capturaNum();
    texto = texto.toString();
    var sel = document.getElementById("competenciasDes");
    for (var i = 0; i < sel.length; ++i) {
        var child = sel.children[i];
        if (child.tagName === "OPTION" && child.style.display !== "none") {
            var cadena = child.text;
            var arreglo = cadena.split(" ");
            if (arreglo[0].indexOf(texto) === -1){
                child.style.display = "none";
            }  
        }
    }
}
function recorrerApe(){
    var texto = capturaApe();
    var sel = document.getElementById("competenciasDes");
    for (var i = 0; i < sel.length; ++i) {
        var child = sel.children[i];
        if (child.tagName == "OPTION" && child.style.display !== "none") {
            var cadena = child.text;
            var arreglo = cadena.split(" ");
            if (arreglo[1].indexOf(texto) === -1){
                child.style.display = "none";
            } 
        }
    }
}
function recorrerNom(){
    var texto = capturaNom();
    var sel = document.getElementById("competenciasDes");
    for (var i = 0; i < sel.length; ++i) {
        var child = sel.children[i];
        if (child.tagName == "OPTION" && child.style.display !== "none") {
            var cadena = child.text;
            var arreglo = cadena.split(" ");
            if (arreglo[2].indexOf(texto) === -1){
                child.style.display = "none";
            } 
        }
    }
}

function ocultar_evaluar(){
    document.getElementById('si').style.display='none';
    document.getElementById('no').style.display='none';
    document.getElementById('parrafo1').style.display='none';
    document.getElementById('salir').style.display='block';
    document.getElementById('parrafo2').style.display='block';
    return true;
}