document.addEventListener("DOMContentLoaded",function(){

iniciarApp()
});


 function iniciarApp(){

    buscarPorFecha()
}

function buscarPorFecha(){
const fechaInput=    document.querySelector("#fecha")

fechaInput.addEventListener("input",function(e){

    const fechaSelecionada= e.target.value;

    //iar asa trimite userul la rezervele facut pe data respectiva
    window.location=`?fecha=${fechaSelecionada}`
})

}
