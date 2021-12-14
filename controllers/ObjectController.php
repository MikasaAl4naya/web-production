<?php
require_once "BaseTwigController.php";
class ObjectController extends BaseTwigController{
    public $template = "object.twig";
    public $title = "";
    public function getContext(): array
    {
        $context = parent::getContext();
        
        
        $query = $this->pdo->prepare("SELECT id,title,image, desciption,info FROM bands WHERE id= :my_id");
        
        // стягиваем одну строчку из базы
        $query->bindValue("my_id", $this->params['id']);
        $query->execute();
        $data = $query->fetch();
    
        $context['desciption'] = $data['desciption'];
        $context['id'] = $data['id'];

        if (isset($_GET['show'])){
            if(($_GET['show'])=="image"){
                $context['is_image'] = true;
                $context['image'] = $data['image'];
                
            }
            if(($_GET['show'])=="info"){
                $context['is_info'] = true;
                $context['info'] = $data['info'];
            }
        }
        $context['history_list'] = array_reverse($_SESSION['history_list']);


        

        return $context;
    }
}