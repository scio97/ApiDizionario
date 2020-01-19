<?php
//////////CERCA//////////
function cerca(){
    global $conn;
    header("Content-Type:application/json");
    $termine=$_GET["termine"];
    $result = $conn->query("SELECT termine, significato, utente FROM termini WHERE termine='$termine'");
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $risposta["significato"]=$row["significato"];
            $risposta["utente"]=$row["utente"];
        }
    }else{
        $risposta["significato"]=null;
    }
    echo $json_response = json_encode($risposta);
}
//////////AGGIUNGI//////////
function aggiungi(){
    header("Content-Type:application/json");
    global $conn;
    $termine = $_GET["termine"];
    $significato = $_GET["significato"];
    $utente = strtoupper($_GET["utente"]);
    if(check_termine($termine,"ADMIN")==2){
        $conn->query("INSERT INTO termini (termine, significato,utente) VALUES ('$termine', '$significato','$utente')");
        $risposta["risultato"]=true;
    }else{
        $risposta["risultato"]=false;
    }
    echo $json_response = json_encode($risposta);
}
//////////MODIFICA//////////
function modifica(){
    header("Content-Type:application/json");
    global $conn;
    $termine = $_GET["termine"];
    $significato = $_GET["significato"];
    $utente= strtoupper($_GET["utente"]);
    $check=check_termine($termine,$utente);
    if($check==0){
        $conn->query("UPDATE termini SET significato='$significato' WHERE termine='$termine'");
        $risposta["risultato"]=0;
    }else{
        if($check==1){
            $risposta["risultato"]=1;
        }else{
            $risposta["risultato"]=2;
        }
    }
    echo $json_response = json_encode($risposta); 
}
//////////ELIMINA//////////
function elimina(){
    header("Content-Type:application/json");
    global $conn;
    $termine = $_GET["termine"];
    $utente= strtoupper($_GET["utente"]);
    $check=check_termine($termine,$utente);
    if($check==0){
        $conn->query("DELETE FROM termini WHERE termine='$termine'");
        $risposta["risultato"]=0;
    }else{
        if($check==1){
            $risposta["risultato"]=1;
        }else{
            $risposta["risultato"]=2;
        }
    }
    echo $json_response = json_encode($risposta);
}
//////////LOGIN//////////
function login(){
    header("Content-Type:application/json");
    global $conn;
    $user = $_GET["user"];
    $password = $_GET["password"];
    $result = $conn->query("SELECT user, password, tipo FROM utenti WHERE user='$user'");
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if($row["password"]==$password){
            $risposta["risultato"]="ok";
            $risposta["tipo"]=$row["tipo"];
        }else{
            $risposta["risultato"]="passworderr";
        }
    }else{
        $risposta["risultato"]="usererr";
    }
    echo $json_response = json_encode($risposta);
}
//////////REGISTRA//////////
function registra(){
    header("Content-Type:application/json");
    global $conn;
    $user = $_GET["user"];
    $password = $_GET["password"];
    if(!check_utente($user)){
        $conn->query("INSERT INTO utenti (user, password, tipo) VALUES ('$user', '$password', 'ospite')");
        $risposta["risultato"]=true;
    }else{
        $risposta["risultato"]=false;
    }
    echo $json_response = json_encode($risposta);
}
//////////CHECK_UTENTE//////////
function check_utente($user){
    global $conn;
    $result = $conn->query("SELECT user FROM utenti WHERE user='$user'");
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            return true;
        }
    }else{
        return false;
    }
}
//////////CHECK_TERMINE//////////
function check_termine($termine,$utente){
    global $conn;
    $result = $conn->query("SELECT termine,utente FROM termini WHERE termine='$termine'");
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if($row["utente"]==$utente||$utente=="ADMIN"){
            return 0;
        }else{
            return 1;
        }
    }else{
        return 2;
    }
}
?>