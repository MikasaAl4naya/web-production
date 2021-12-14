<?php
require_once "../framework/BaseMiddleware.php";
class LoginRequiredMiddleware extends BaseMiddleware{
    public function apply(BaseController $controller, array $context)
    {

    $query = $controller->pdo->prepare("SELECT username, password, id FROM users Where password = :my_password and username = :my_username");
        
        // берем значения которые введет пользователь
       $query->bindValue("my_password",isset($_SERVER['PHP_AUTH_USER']) ? $_SERVER['PHP_AUTH_USER'] : '' )  ;
       $query->bindValue("my_username",isset($_SERVER['PHP_AUTH_PW']) ? $_SERVER['PHP_AUTH_PW'] : '' )  ;
       $query->execute();
       $data = $query->fetch();
        
        // сверяем с корректными
        if (!$data) {
            // если не совпали, надо указать такой заголовок
            // именно по нему браузер поймет что надо показать окно для ввода юзера/пароля
            header('WWW-Authenticate: Basic realm="bands"');
            http_response_code(401); // ну и статус 401 -- Unauthorized, то есть неавторизован
            exit; // прерываем выполнение скрипта
        }
    }

}