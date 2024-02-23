
//definim pasi din citas
let paso =1;
//paso astia ii stabilim deja pentru  ai folosi la paginador

const pasoInicial= 1
const pasoFinal = 3;


//obiectu unde salvam toate citele
const cita={
id:"",
nombre : "",
fecha:"",
hora:"",
servicios:[]
}
//initializam js in pagina

document.addEventListener("DOMContentLoaded",function(){
    iniciarApp();
});

function iniciarApp(){
    //adaugam functia asta aici ca sa ne incarce pe default servicios
 monstrarSeccion();//Adauga sau scoate anumite clase ,care ascund sau dezvaluie sectiuni
    tabs();//Schimba sectiunea cand dam click pe tabs
    botonesPaginador(); //Adauga sau da remeove la butoanele paginador

    //aici creem doua functi pentru butonul siguente si anterior
    paginaSiguente()
    paginaAnterior()

    consultarAPI()// Consulteaza api in backend php
    nombreCliente() //adaugam numele clientului la obiectul cita
    idCliente()
    selecionarFecha() //adaugam data la obiectul cita
    selecionarHora() //Adauga ora in obiectul cita
    mostrarResumen()//Ne arata resumele citei
}
function monstrarSeccion(){
//Adaugam ocultar la clasa monstrar asa o sa dispara clasa mostrar in caz ca apasam pe alt buton
let seccionAnterior = document.querySelector(".mostrar");

//iar cu if asta spunem daca section aterior are clasa mostrar atunci sa o scoata
if(seccionAnterior){
    
    seccionAnterior.classList.remove("mostrar");
}


//Selectionar la seccion con el paso
const pasoSelector = `#paso-${paso}`;

const seccion = document.querySelector(pasoSelector);
//odata clicat in selector ne adauga clasa monstrar
seccion.classList.add("mostrar");


//Scoatem clasa actual la tabul anterior

let botonAterior =document.querySelector(".actual")

if(botonAterior){
    botonAterior.classList.remove("actual")
}

//Pune in evidenta butonu actual, cu ajutorul selectorului de atribur

let tab = document.querySelector(`[data-paso="${paso}"]`);

tab.classList.add("actual")

}

function tabs (){
//asignam cele trei butoane
 const botones =document.querySelectorAll(".tabs button");

//si cum avem 3 butoane nu putem adauga un event listener asa fac iteram cu un for each

botones.forEach( button=> {
    //si acum putem accesa fiecare buton cu ajutorul eventului si datesetului savat in index cita

    button.addEventListener('click',function(e){
         paso = parseInt( e.target.dataset.paso );
   
      monstrarSeccion();

      //o adaugam si aici pentra ca butoanele sa se ascund cand accesam taburile nu numai cand initiaza aplicatia
      botonesPaginador();

  
    });
});
}
function botonesPaginador(){

    const botonAterior = document.querySelector("#anterior");
    const botonSiguente = document.querySelector("#siguente");
    
    
    if(paso === 1){
        botonAterior.classList.add("ocultar")
        botonSiguente.classList.remove("oculatar")
    }else if(paso===3){
        botonSiguente.classList.add("ocultar");
        botonAterior.classList.remove("ocultar")
        //folosim functia asta ca in caz ca ajungem la resumen sa ne apara resumeul citei
        mostrarResumen()
    }else{
        botonAterior.classList.remove("ocultar");
        botonSiguente.classList.remove("ocultar")
    } 

    monstrarSeccion()
    
}
function paginaSiguente(){

    const botonSiguente = document.getElementById("siguente")

    botonSiguente.addEventListener("click",function(){

        if(paso>=pasoInicial && paso <pasoFinal)

        paso ++
    
            //instantiem si functa botones paginador pentru a schimba viewu de forma dinamica
            botonesPaginador()

       
    })
}

function paginaAnterior(){
    const botonSiguente = document.getElementById("anterior")

    botonSiguente.addEventListener("click",function(){

        if(paso<=pasoInicial && paso >pasoFinal)
            return
            paso --
            botonesPaginador()
        
       
    })
}

async function consultarAPI(){

    try {
        //url de unde o sa isi ia datele
        const url ="http://localhost:3000/api/servicios";
        //si cu await spunem sa asptepte pana ia toate datele de la url
        const resultado = await fetch(url)
        const servicios = await resultado.json()
        monstrarServicios(servicios)

    } catch (error) {
        console.log(error)
    }
}

function monstrarServicios(servicios){

    servicios.forEach(servicio=>{
        //facem un destructre pentru a numai fi noie sa folosim servicio.nombre de ex
        const {id,nombre,precio}= servicio

        const nombreServicio = document.createElement('p')
        nombreServicio.classList.add("nombre-servicio")
        nombreServicio.textContent= nombre

        const precioServicio = document.createElement('p')
        precioServicio.classList.add("precio-servicio")
        precioServicio.textContent=`$${precio}`

        const servicioDiv = document.createElement("div")
        servicioDiv.classList.add("servicio")
        //asa ii creem un id personalizat divului
        servicioDiv.dataset.idServicio= id

        //aici facem un colback cand dam click pe servicio div si activam functia cu 
        //toate serviciile
        servicioDiv.onclick=function(){
            selectionarServicio(servicio)
        }
        //iar asa adaugam in div parafurile
        servicioDiv.appendChild(nombreServicio)
        servicioDiv.appendChild(precioServicio)

        //iar asa adaugam dinvul asta in alt dinv cu id servicios
        document.querySelector("#servicios").appendChild(servicioDiv)
    })
}

function selectionarServicio(servicio){
    const {id} = servicio
    //extrangem serviciile din cita
    const {servicios}=cita


    //identificam de forma dinamica elementul caruia ii dam click
const divServicio = document.querySelector(`[data-id-servicio="${id}"]`)

//vedem daca un serviiu a fost adaugat

if(servicios.some(agregado =>agregado.id=== id)){

    cita.servicios=     servicios.filter(agregado=>agregado.id !==id)
    divServicio.classList.remove("selecionado")
}
else{
    
    //face o copie la servici si adaugam serviciul urmator
  cita.servicios= [...servicios,servicio]

  //folosim am sa adaugam o clasa la serviciu care a fost deja selectionat adaugandoui o clasa
  divServicio.classList.add("selecionado")
}
  
}

function idCliente(){
    const idCliente = document.querySelector("#id")
    cita.id= idCliente.value
}
function nombreCliente(){
    const nombre = document.querySelector("#nombre")
    cita.nombre= nombre.value


}

function selecionarFecha(){
    const inputFecha = document.querySelector("#fecha")
    
//activam listeneru si scoate valuare dati
    inputFecha.addEventListener("input",function(e){

        //selectam datili in finctie de zilele saptamani
    const dia = new Date(e.target.value).getUTCDay()
        //iar asa specificam ca nu pot face cite in wekkend
        if([6,0].includes(dia)){
            //spunem ca sa fie un string gol ca sa nu il salveze in obiect
            e.target.value=""
            monstrarAlerta("fines de semana nepermitido", "error",".formulario")
        }
        cita.fecha= e.target.value
    })
}
function selecionarHora(){
    const inputHora = document.querySelector("#hora")
    inputHora.addEventListener("input",function(e){
        const horaCita = e.target.value
        //iar asa facem si alegem doar ora nu si minutele
        const hora = horaCita.split(":")[0]
        if(hora <10 || hora >17){
            e.target.value=""
            monstrarAlerta("No puede pedir una cita apartir de las 17", "error",".formulario")
        }else{
            cita.hora = e.target.value
        }
    })
}
//avem mai multi paremtri cum ar fi mesajul  de ce tip de ex error etc ,elementul find de ex divul selecionat
//si desaparece pentru ca mesajul de erroare sa dispara doar in anumite conditi
 function monstrarAlerta(mensaje ,tipo,elemento,desparece=true){
    //asta facem ca sa nu ne aparam mai mule alerte
    const alertaPrevia =    document.querySelector(".alertas")
    //in caz ca avem o alta alerta care nu a disparut vrem sa o scoatem pentru a genera altele 
    if(alertaPrevia) {

        alertaPrevia.remove()
    }

    //Script pentru crearea alertei
const alerta = document.createElement("div")
alerta.textContent=mensaje
alerta.classList.add("alertas")
alerta.classList.add(tipo)
const referencia = document.querySelector(elemento)
referencia.appendChild(alerta)

//si aici spunem ca dupa 3 secunde sa dispara alerta
if(desparece){
    setTimeout(() => {
        alerta.remove()
    }, 3000);
}

}


function mostrarResumen(){
const resumen = document.querySelector(".contenido-resumen")
//Curatam continutul resumelui
while(resumen.firstChild){
    resumen.removeChild(resumen.firstChild)
}

//cu if asta verificam daca in obiectul cita avem toate datele introduse corect si nu avem vrun loc gol
//si  dupa verificam daca am selectionat vrun produs cu lenght , si folosim false ca nu vrem sa ne dispara alerta
if(Object.values(cita).includes("") || cita.servicios.length===0){
monstrarAlerta("No has selecionada nigun serivicio o hacen falta datos", "error",".contenido-resumen",false)
return
}
//Headin pentru servicioResumen

const headingServicios= document.createElement("h3")
headingServicios.textContent= "Los servicios que estas solicitando :"
resumen.appendChild(headingServicios)


//Formatam divu resumen
const {nombre, fecha,hora ,servicios}= cita
const nombreCliente = document.createElement("p")
nombreCliente.innerHTML= `<span>Nombre: </span> ${nombre}`



//Formatam data in spaniol
const fechaObj = new Date(fecha)
const mess = fechaObj.getMonth()
//punem plus doi din cauza ca folosim new date de doua ori si de fiecare data cand o folsim scade cate o zi
const dia = fechaObj.getDay() +2;
const year = fechaObj.getFullYear()

const fechaUTC = new Date(Date.UTC(year,mess,dia))
//cu opciones specificam ca dorim sa ne arate in forma de nume luni,marti etc
const opciones ={weekday:"long",year:"numeric",month:"long",day:"numeric"}
const fechaFormateada = fechaUTC.toLocaleDateString("es-es",opciones)


const fechaCita = document.createElement("p")
fechaCita.innerHTML= `<span>Nombre: </span> ${fechaFormateada}`

const horaCita = document.createElement("p")
horaCita.innerHTML= `<span>Nombre: </span> ${hora} Horas `

//buton pentru a trimite cita catre backend
const botonReservar = document.createElement("button")
botonReservar.classList.add("boton")
botonReservar.textContent="Reservar cita"
botonReservar.onclick=reservarCita

//servicios cum sunt un array trebuie sa iteram

servicios.forEach(servicio=> {
    const {id,precio,nombre}= servicio
    const contenedorServicio = document.createElement("div")

    contenedorServicio.classList.add("contenedor-servicios")
   

    textoServico=document.createElement("p")
    textoServico.textContent=nombre
   
    precioServicio=document.createElement("p")
    precioServicio.innerHTML=`<span> Precio: </span> ${precio}`
       
        contenedorServicio.appendChild(textoServico)
        contenedorServicio.appendChild(precioServicio)
     
        resumen.appendChild(contenedorServicio)
})

const footerServicios = document.createElement("h3")
footerServicios.textContent= "Resumen de cita"
resumen.appendChild(footerServicios)

resumen.appendChild(fechaCita)
resumen.appendChild(horaCita)
resumen.appendChild(botonReservar)
}

async function reservarCita(){
    //scoate nobre etc din cita
    const {id,fecha,hora,servicios}= cita

    const idServicios= servicios.map(servicio=>servicio.id)
    
    //creem variabila pentru a adauga datele
    const datos = new FormData()

//adaugam datele 
datos.append("usuarioId",id)
datos.append("fecha",fecha)
datos.append("hora",hora)
datos.append("servicios",idServicios)

    //Facem petitie la api
try{
    const url = "http://localhost:3000/api/citas"

    //primul parametru care il adaugam la fetch este url care dorim sa il accesam iar al doilea
    //este methoda in care este construit url
    const respuesta = await fetch(url,{
        method:"POST",
        body:datos
    })

    //iar aici primim resultadul din respesta

    const resultado = await respuesta.json( )
    console.log(resultado)
    if(resultado.resultado){
Swal.fire({
  icon: "success",
  title: "Cita creada",
  text: "Tu cita fue creada corectamente",
  button:"OK"
  //iar dupa folosim then ca sa reincarce pagina si sa ne duca la meniu initial
}).then(()=>{
    setTimeout(()=>{
        window.location.reload()

    },3000)
});
    }
}catch(error){

    Swal.fire({
      icon: "error",
      title: "Error.",
      text: "Ha habido un error al guardar la cita"
    });
}

}