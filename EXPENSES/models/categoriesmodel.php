<?php
class CategoriesModel extends Model implements IModel {

    private $id;
    private $name;
    private $color;

    public function __construct()
    {
      parent::__construct();  
    }
    public function save(){

        try{error_log('CategoriesModel::save -> ingresando datos');
            $query = $this->prepare('INSERT INTO categories (name, color) VALUES (:name, :color)');
            $query->execute([
                'name' => $this->name,
                'color' => $this->color
            ]);
            if($query->rowCount()){
                error_log('CategoriesModel::save -> datos guardados correctamente');
                return true;
            }else{
                error_log('CategoriesModel::save -> no se guardaron los datos');
                return false;
            }
        }
        catch(PDOException $e){
            error_log('CategoriesModel::save -> error al intentar guardar '.$e);
            return false;
        }
    
    }
    public function getAll(){
        $items=[];
        try{error_log('CategoriesModel::getAll -> consultando datos');
            $query = $this->query('SELECT * FROM categories');
            
            while($p = $query->fetch(PDO::FETCH_ASSOC)){
                $item = new CategoriesModel();
                $item-> from($p);
                array_push($items, $item);

            }
            return $items;

        }
        catch(PDOException $e){
            error_log('CategoriesModel::getAll -> error al consultar datos '.$e);
            return NULL;
        }
    }
    public function get($id){
        try{error_log('CategoriesModel::get -> consultando id');
            $query = $this->prepare('SELECT * FROM categories WHERE id = :id');
            $query->execute([
                'id'=> $id
            ]);
            $categories = $query->fetch(PDO::FETCH_ASSOC);
            $this-> from($categories);
               
            return $this;

        }
        catch(PDOException $e){
            error_log('CategoriesModel::get -> error consultando id '.$e);
            return NULL;
        }
    }
    
    public function delete($id){
        try{error_log('CategoriesModel::delete -> eliminando id');
            $query = $this->prepare('DELETE * FROM categories WHERE id = :id');
            $query->execute([
                'id'=> $id
            ]);
            
            return true;

        }
        catch(PDOException $e){
            error_log('CategoriesModel::getAll -> error al intentar eliminar '.$e);
            return false;
        }
    }

    public function update(){
        
        try{error_log('CategoriesModel::update -> actualizando datos');
            $query = $this->prepare('UPDATE categories name = :name, color = :color) WHERE id = :id');
            $query->execute([
                'name' => $this->name,
                'color' => $this->color,
                'id' => $this->id
            ]);
            if($query->rowCount()){
                error_log('CategoriesModel::update -> datos actualizados correctamente');
                return true;
            }else{
                error_log('CategoriesModel::update -> no se actualizaron los datos');
                return false;
            }

        }
        catch(PDOException $e){
            error_log('CategoriesModel::update -> error al intentar actualizar '.$e);
            return false;
        }
    }
    function from($array){
        $this->id = $array['id'];
        $this->name = $array['name'];
        $this->color = $array['color'];
    }

    public function exists($name){
        try {
            $query = $this->prepare('SELECT name FROM categories WHERE name = :name');
            $query->execute(['name' => $name]);
            if($query->rowCount()>0){ /// si cuenta que hay mas de 0 filas el usuario existe
                return true;
            }else{
                return false;
            }
        }catch(PDOException $e){
            error_log('CategoriesModel:: exist->PDOException ' . $e);
            return false;
        }

    }

    public function setId($id)		        {   $this->id	    =	$id;}
    public function setName($name)	        {   $this->name	    =	$name;}
    public function setcolor($color)	    {   $this->color	=	$color;}

    public function getId()	            {	return $this->id;}
    public function getName()	    {	return $this->name;}
    public function getcolor()	    {	return $this->color;}
        
         

}
?>