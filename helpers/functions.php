<?php 
// function qui débug les tableaux
    function debug_array($arr)
    {
        echo "<pre>";
        print_r($arr);
        echo "</pre>";
    }


function clear_xss($var) {
    return trim(htmlspecialchars($var));

}