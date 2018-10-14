<?php
require_once '../app_config/config.php';
require_once '../app_config/mysqlcon.php';
require_once '../dash/utilities.php';
//Start session
session_start();

//Array to store validation errors
$errmsg_arr = array();

//Validation error flag
$errflag = false;
$homename='';
$taxenabled=false;
//Function to sanitize values received from the form. Prevents SQL injection


//Sanitize the POST values
$login = clean($_POST['inusn']);
$password = clean($_POST['inpass']);

print_r($_SERVER);

//Input Validations
if($login == '') {
    $errmsg_arr[] = 'Username missing';
    $errflag = true;
}
if($password == '') {
    $errmsg_arr[] = 'Password missing';
    $errflag = true;
}

//If there are input validations, redirect back to the login form
if($errflag) {
    $_SESSION['ERRMSG_ARR'] = $errmsg_arr;
    session_write_close();
    header("location: ../index.php");
    exit();
}
if(isset($_POST['loginSubmit'])){
    
 
//Create query
$qry="SELECT * FROM person WHERE username='$login' AND password='$password'";
$result=mysqli_query($link,$qry);

//Check whether the query was successful or not
if($result) {
    if(mysqli_num_rows($result) > 0) {
        $member = mysqli_fetch_assoc($result);
        
        if($member['is_locked']==1){
            //Account is locked
            $errmsg_arr[] = 'Account is locked';
            $_SESSION['ERRMSG_ARR'] = $errmsg_arr;
            header("location: ../index.php");
            exit();
        }
        else{
        //Login Successful
        session_regenerate_id();
        $_SESSION['SESS_MEMBER_ID'] = $member['person_id'];
        $_SESSION['SESS_FIRST_NAME'] = $member['person_name'];
        $_SESSION['SESS_MEMBER_ROLE'] = $member['person_role'];
        $_SESSION['SESS_HOME_NAME']=$homename;
        $_SESSION['SESS_HOME_TAX']=$taxenabled;
        session_write_close();
        $link->close();
        header("location: ../dash/index.php");
        exit();
        }
    }else {
        //Login failed
        $errmsg_arr[] = 'Invalid username or password';
        $_SESSION['ERRMSG_ARR'] = $errmsg_arr;
        header("location: ../index.php");
        exit();
    }
}else {
    $errmsg_arr[] = 'Unable to process your request. Please contact System Administrator';
    $_SESSION['ERRMSG_ARR'] = $errmsg_arr;
    die("Query failed - db connection error");
}
}else {
    $errmsg_arr[] = 'Invalid access. Please contact System Administrator';
    $_SESSION['ERRMSG_ARR'] = $errmsg_arr;
}
?>
