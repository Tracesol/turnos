<?php
    include("pages.php");
    header('Content-Type: application/json; charset=utf-8');

    if(isset($_REQUEST["nivel"]) && $_REQUEST["nivel"] != "Admin"){        
        function filtronivel($app){
            if($app["nivel"] == $_REQUEST["nivel"] || $app["nivel"] == "Todos")
                return true;
        }
    
        $appsnivel=array_filter($apps,"filtronivel");
        echo json_encode($appsnivel);        
    }else{
        echo json_encode($apps);
    }
?>