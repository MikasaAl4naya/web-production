<?php

class SetWelcomeController extends BaseController {
    public function get(array $context) {
        $_SESSION['welcome_message'] = $_GET['message']; // добавил
        
        $url = $_SERVER['HTTP_REFERER'];
        header("Location: $url");
        exit;
    }
}