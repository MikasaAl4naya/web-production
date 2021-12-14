<?php
require_once "BaseTwigController.php"; 

class MainController extends BaseTwigController{
    public $template = "main.twig";
    public $title = "Главная";

    public function getContext(): array
    {
        $context = parent::getContext();
        
        if (isset($_GET['type'])){
            $query = $this->pdo->prepare("SELECT * FROM bands WHERE type = :type");
            $query->bindValue("type", $_GET['type']);
            $query->execute();
        } else {
            $query = $this->pdo->query("SELECT * FROM bands");
        }

        $context['bands'] = $query->fetchAll();
        $context['history_list'] = array_reverse($_SESSION['history_list']);

        return $context;
    }

}