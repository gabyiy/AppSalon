
//definim pasi din citas
let paso =1;
//paso astia ii stabilim deja pentru  ai folosi la paginador

const pasoInicial= 1
const pasoFinal = 3;

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

        //iar asa adaugam in div parafurile
        servicioDiv.appendChild(nombreServicio)
        servicioDiv.appendChild(precioServicio)

        //iar asa adaugam dinvul asta in alt dinv cu id servicios
        document.querySelector("#servicios").appendChild(servicioDiv)
    })
}
