<?php

require_once('FormBuilder.php');
class SafeFormBuilder extends FormBuilder{
    public function checkGLOBAL(string $method_type, string $name) : string{
        if ($method_type == "POST" && isset($_POST[$name])){
            return $_POST[$name];
        }else if ($method_type == "GET" && isset($_GET[$name])){
            return $_GET[$name];
        }
        return "";
    }
}