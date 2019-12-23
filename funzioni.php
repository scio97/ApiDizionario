<?php
//////////CERCA//////////
function cerca(){
    global $conn;
    header("Content-Type:application/json");
    $termine=$_GET["termine"];
    $sql = "SELECT termine, significato FROM termini WHERE termine='$termine'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $risposta["significato"]=$row["significato"];
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
    if(!check_termine($termine)){
        $sql="INSERT INTO termini (termine, significato) VALUES ('$termine', '$significato')";
        $conn->query($sql);
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
    if(check_termine($termine)){
        $sql = "UPDATE termini SET significato='$significato' WHERE termine='$termine'";
        $conn->query($sql);
        $risposta["risultato"]=true;
    }else{
        $risposta["risultato"]=false;
    }
    echo $json_response = json_encode($risposta); 
}
//////////ELIMINA//////////
function elimina(){
    header("Content-Type:application/json");
    global $conn;
    $termine = $_GET["termine"];
    if(check_termine($termine)){
        $sql = "DELETE FROM termini WHERE termine='$termine'";
        $conn->query($sql);
        $risposta["risultato"]=true;
    }else{
        $risposta["risultato"]=false;
    }
    echo $json_response = json_encode($risposta);
}
//////////CHECK_TERMINE//////////
function check_termine($termine){
    global $conn;
    $sql = "SELECT termine FROM termini WHERE termine='$termine'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            return true;
        }
    }else{
        return false;
    }
}
?>