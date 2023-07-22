<?php
require_once ('libs/model.php');
class ExpensesModel extends Model implements IModel{
    
    private $id;
    private $title;
    private $amount;
    private $categoryid;
    private $date;
    private $userid;
    
    
    public function setId($id){ $this-> id = $id;}
    public function setTitle($title){ $this-> title = $title;}
    public function setAmount($amount){ $this-> amount = $amount;}
    public function setCategoryId($categoryid){ $this-> categoryid = $categoryid;}
    public function setDate($date){ $this-> date = $date;}
    public function setUserId($userid){ $this-> userid = $userid;}

    public function getId() {return $this->id;}
    public function getTitle() {return $this->title;}
    public function getAmount() {return $this->amount;}
    public function getCategoryId() {return $this->categoryid;}
    public function getDate() {return $this->date;}
    public function getUserId() {return $this->userid;}

    function __construct()
    {   parent::__construct();
        
    }
    public function save(){
        try{error_log('ExpensesModel::save -> ingresando datos tittle: '.$this->title.' amount: '.$this->amount.' category_id: '.$this->categoryid.' date: '.$this->date.' userid: '.$this->userid);
            $query = $this->prepare('INSERT INTO expenses (title, amount, category_id, date, id_user) VALUES (:title, :amount, :category_id, :d, :user)');
            $query->execute([
                'title' => $this->title,
                'amount' => $this->amount,
                'category_id' => $this->categoryid,
                'd' => $this->date,
                'user' => $this->userid
            ]);
            if($query->rowCount()){
                error_log('ExpensesModel::save -> datos guardados correctamente');
                return true;
            }else{
                error_log('ExpensesModel::save -> no se guardaron los datos');
                return false;
            }

        }
        catch(PDOException $e){
            error_log('ExpensesModel::save -> error al intentar guardar '.$e);
            return false;
        }
    }
    public function getAll(){
        $items=[];
        try{error_log('ExpensesModel::getAll -> consultando datos');
            $query = $this->query('SELECT * FROM expenses');
            
            while($p = $query->fetch(PDO::FETCH_ASSOC)){
                $item = new ExpensesModel();
                $item-> from($p);
                
                array_push($items, $item);

            }
            return $items;

        }
        catch(PDOException $e){
            error_log('ExpensesModel::getAll -> error al consultar datos '.$e);
            return NULL;
        }
    }
    public function get($id){
        try{error_log('ExpensesModel::get -> consultando id');
            $query = $this->prepare('SELECT * FROM expenses WHERE id = :id');
            $query->execute([
                'id'=> $id
            ]);
            $expense = $query->fetch(PDO::FETCH_ASSOC);
            $this-> from($expense);
               
            return $this;

        }
        catch(PDOException $e){
            error_log('ExpensesModel::get -> error consultando id '.$e);
            return false;
        }
    }
    public function delete($id){
        try{error_log('ExpensesModel::delete -> eliminando id '.$id);
            $query = $this->prepare('DELETE FROM expenses WHERE id =:id');
            $query->execute([
                'id'=> $id
            ]);
            
            return true;

        }
        catch(PDOException $e){
            error_log('ExpensesModel::delete -> error al intentar eliminar '.$e);
            return false;
        }
    }
    public function update(){
        try{error_log('ExpensesModel::update -> actualizando datos');
            $query = $this->prepare('UPDATE expenses title = :title, amount = :amount, category_id = :categoryid, date = :d, id_user = userid) WHERE id = :id');
            $query->execute([
                'title' => $this->title,
                'amount' => $this->amount,
                'category_id' => $this->categoryid,
                'd' => $this->date,
                'user' => $this->userid,
                'id' => $this->id
            ]);
            if($query->rowCount()){
                error_log('ExpensesModel::update -> datos actualizados correctamente');
                return true;
            }else{
                error_log('ExpensesModel::update -> no se actualizaron los datos');
                return false;
            }

        }
        catch(PDOException $e){
            error_log('ExpensesModel::update -> error al intentar actualizar '.$e);
            return false;
        }
    }
    public function from($array){
        $this->id = $array['id'];
        $this->title = $array['title'];
        $this->amount = $array['amount'];
        $this->categoryid = $array['category_id'];
        $this->date = $array['date'];
        $this->userid = $array['id'];

    }  
    public function getAllByUserId($userid){
        $items = [];
        try{error_log('ExpensesModel::getAllByUserId -> consultando userid');
            $query = $this->prepare('SELECT * FROM expenses WHERE id_user = :userid');
            $query->execute([
                'userid'=> $userid
            ]);
            
            while($p = $query->fetch(PDO::FETCH_ASSOC)){
                $item = new ExpensesModel();
                $item-> from($p);
                array_push($items, $item);

            }
            return $items;

        }
        catch(PDOException $e){
            error_log('ExpensesModel::getAllByUserId -> error al realizar la consulta '.$e);
            return [];
        }
    }     
    public function getAllByUserIdAndLimit($userid,$n){
        $items = [];
        try{error_log('ExpensesModel::getAllByUserIdAndLimit -> consultando userid');
            $query = $this->prepare('SELECT * FROM expenses WHERE id_user = :userid ORDER BY expenses.date DESC LIMIT 0,:n');
            $query->execute([
                'userid'=> $userid,
                'n'     => $n
            ]);
            
            while($p = $query->fetch(PDO::FETCH_ASSOC)){
                $item = new ExpensesModel();
                $item-> from($p);
                array_push($items, $item);

            }
            return $items;

        }
        catch(PDOException $e){
            error_log('ExpensesModel::getAllByUserIdAndLimit -> error al realizar la consulta '.$e);
            return [];
        }
    } 
    
    public function getTotalAmountThisMonth($userid){
        
        try{error_log('ExpensesModel::getTotalAmountThisMonth -> consultando userid');
            
            $year = date('Y');
            $month = date('m');
            $query = $this->prepare('SELECT SUM(amount) as  total FROM expenses WHERE YEAR(date) = :year and MONTH(date) = :month AND id_user = :userid ');
            $query->execute([
                'userid'=> $userid,
                'year'  => $year,
                'month' => $month
            ]);
            
            $total = $query->fetch(PDO::FETCH_ASSOC)['total'];

            if($total == NULL){$total = 0;}
            
            return $total;
        }
        catch(PDOException $e){
            error_log('ExpensesModel::getAllByUserIdAndLimit -> error al realizar la consulta '.$e);
            return NULL;
        }
    } 

    public function getMaxExpensesThisMonth($userid){
        
        try{error_log('ExpensesModel::getMaxExpensesThisMonth -> consultando userid');
            
            $year = date('Y');
            $month = date('m');
            $query = $this->prepare('SELECT MAX(amount) as  total FROM expenses WHERE YEAR(date) = :year and MONTH(date) =:month AND id_user = :userid');
            $query->execute([
                'userid'=> $userid,
                'year'  => $year,
                'month' => $month
            ]);
            
            $total = $query->fetch(PDO::FETCH_ASSOC)['total'];

            if($total == NULL){$total = 0;}
            
            return $total;
        }
        catch(PDOException $e){
            error_log('ExpensesModel::getMaxExpensesThisMonth -> error al realizar la consulta '.$e);
            return NULL;
        }
    } 

    public function getTotalByCategoryThisMonth($categoryid,$userid){
        
        try{error_log('ExpensesModel::getTotalByCAtegoryThisMonth -> consultando userid');
            $total = 0;
            $year = date('Y');
            $month = date('m');
            $query = $this->prepare('SELECT SUM(amount) as  total FROM expenses  WHERE category_id= :categoryid  AND YEAR(date) = :year and MONTH(date) =:month AND id_user = :userid');
            $query->execute([
                'categoryid' => $categoryid,
                'userid'=> $userid,
                'year'  => $year,
                'month' => $month
            ]);
            
            $total = $query->fetch(PDO::FETCH_ASSOC)['total'];

            if($total == NULL){$total = 0;}
            
            return $total;
        }
        catch(PDOException $e){
            error_log('ExpensesModel::getTotalByCAtegoryThisMonth -> error al realizar la consulta '.$e);
            return NULL;
        }
    } 
    public function getNumberOfExpensesByCategoryThisMonth($categoryid,$userid){
        
        try{
            $total = 0;
            $year = date('Y');
            $month = date('m');
            error_log('ExpensesModel::getNumberOfExpensesByCategoryThisMonth -> total: '.$total.' year:'.$year.' month: '.$month.' categoryid: '.$categoryid.' userid:'.$userid);
            
            $query = $this->prepare('SELECT COUNT(amount) as  total FROM expenses  WHERE category_id= :categoryid  AND YEAR(date) = :year AND MONTH(date) =:month AND id_user =:userid');
            $query->execute([
                'categoryid' => $categoryid,
                'userid'=> $userid,
                'year'  => $year,
                'month' => $month
            ]);
            
            $total = $query->fetch(PDO::FETCH_ASSOC)['total'];
            error_log('ExpensesModel::getNumberOfExpensesByCategoryThisMonth -> consultando userid: '.$userid.' categoryid: '.$categoryid.' total:'.$total);
            
            if($total == NULL){$total = 0;}
            
            return $total;
        }
        catch(PDOException $e){
            error_log('ExpensesModel::getNumberOfExpensesByCategoryThisMonth -> error al realizar la consulta '.$e);
            return NULL;
        }
    } 

    
    public function getTotalByMonthAndCategory($date,$category_id, $iduser)
    {
        try{$total  = 0;
            $year   = substr($date, 0, 4);
            $month  = substr($date, 5, 7);
            
            
            error_log('JoinExpensesCategoriesModel::getTotalByMonthAndCategory -> consultando datos');
            $query = $this->prepare('SELECT SUM(amount) AS total FROM expenses WHERE category_id =:category_id AND id_user=:iduser AND YEAR(date) =:year AND MONTH(date) =:month ');
            $query->execute([
                'category_id'=> $category_id,
                'iduser'    => $iduser,
                'year'      => $year,
                'month'     => $month                    
            ]);
            
            if($query->rowCount() >0){
                $total = $query->fetch(PDO::FETCH_ASSOC)['total'];
            }
            
            return $total;

        }
        catch(PDOException $e){
            error_log('CategoriesModel::getAll -> error al consultar datos '.$e);
            return NULL;
        }
    }
}

?>