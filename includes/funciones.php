<?php

function debug($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa / Sanitizar el HTML
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}

function esUltimo(string $actual,string $proximo):bool{
if($actual!==$proximo ){
    return true;
}
return false;
}

//Functie care verifica daca userul este autetificat

function isAuth(): void{
session_start();
if(!isset($_SESSION["login"])){
header("Location: /");
}
}

//fuctia pentru  verifica daa este admin

function isAdmin ():void{

    if(!isset($_SESSION["admin"])){

        header("Location: /");
    }

}