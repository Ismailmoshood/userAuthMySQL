<?php
function logout(){
   if($_SESSION['username']){
    session_destroy();
    header("location:../forms/login.html?logged out");
   }
   else{
    header("location:../forms/login.html?error=You are not logged in");
   }
}

logout();
?>