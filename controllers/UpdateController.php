<?php
require_once "UpdateController.php";

class UpdateController extends ObjectController {
    public $template = "update.twig";
    public $title = "Редактирование записи";
    
    public function getContext(): array
    {
        $context = parent::getContext();
        $context['history_list'] = array_reverse($_SESSION['history_list']);
        return $context;
    }
    public function get(array $context)
    {
    $id = $this->params['id'];

        $sql =<<<EOL
            SELECT * FROM bands WHERE id = :id
        EOL; 
        $query = $this->pdo->prepare($sql);
        $query->bindValue("id", $id);
        $query->execute();

        $data = $query->fetch();

        $context['object'] = $data;
        parent::get($context);

    }
    public function post(array $context) { 
        $id = $_POST['id'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        $info = $_POST['info'];
        $type = $_POST['type'];
        $tmp_name = $_FILES['image']['tmp_name'];
        $name =  $_FILES['image']['name'];
        move_uploaded_file($tmp_name, "../public/media/$name");
        $image_url = "/media/$name"; 

        if (empty($name)) {
            $sql = <<<EOL
                UPDATE bands
                SET title = :title, desciption = :description, info = :info, type = :type
                WHERE id = :id
            EOL;
            $query = $this->pdo->prepare($sql);
            $query->bindValue("id", $id);
            $query->bindValue("title", $title);
            $query->bindValue("description", $description);
            $query->bindValue("info", $info);
            $query->bindValue("type", $type);
        }else{
            $sql = <<<EOL
                UPDATE bands 
                SET title = :title, desciption = :description, info = :info, type = :type,  images = :image_url
                WHERE id = :id
            EOL; 
            $query = $this->pdo->prepare($sql);
            $query->bindValue("id", $id);
            $query->bindValue("title", $title);
            $query->bindValue("description", $description);
            $query->bindValue("info", $info);
            $query->bindValue("type", $type);



            $query->bindValue("image_url", $image_url);
        }      
        $query->execute();
        $context['message'] = 'Вы успешно отредактировали объект'; 
        $context['id'] = $id; 
        
        $this->get($context);
    }
}