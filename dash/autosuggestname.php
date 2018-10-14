<?php
include_once '../controllers/authcontroller.php';
include_once '../app_config/pdocon.php';
include_once 'utilities.php';


if(isset($_POST['queryString'])) {
    $queryString = clean($_POST['queryString']);
    
    if(strlen($queryString) >0) {
        
        $query = $db->query("SELECT customer_phone FROM customer WHERE customer_phone LIKE '$queryString%' LIMIT 10");
        if($query) {
            echo '<ul>';
            while ($result = $query ->fetch()) {
                echo '<li onClick="fill(\''.addslashes($result['customer_phone']).'\');">'.$result['customer_phone'].'</li>';
            }
            echo '</ul>';
            
        } else {
            echo 'OOPS we had a problem :(';
        }
    } else {
        // do nothing
    }
}elseif (isset($_GET['phrase']) && isset($_GET['format'])){
    $queryString = clean($_GET['phrase']);
    
    if($_GET['format']=='json'){
       $namearr=array();
        $query = $db->query("SELECT customer_phone FROM customer WHERE customer_phone LIKE '$queryString%' LIMIT 10");
        if($query) {
            while ($result = $query ->fetch()) {
                $name=array();
                $name['name']=$result['customer_phone'];
              array_push($namearr,$name)  ;
            }
        }
        
        echo json_encode($namearr);
        
    }
}
else {
    echo 'There should be no direct access to this script!';
}

?>