<?php
class JoinExpensesCategoriesModel extends Model{

    private $expenseId;
    private $title;
    private $amount;
    private $categoryId;
    private $date;
    private $userId;
    private $nameCategory;
    private $color;

    public function __construct()
    {
       parent::__construct();

    }
    public function getAll($userId){
        $items=[];
        try{error_log('JoinExpensesCategoriesModel::getAll -> consultando datos');
            $query = $this->prepare('SELECT expenses.id as expense_id, title, category_id, amount, date, id_user, categories.id, name, color FROM expenses INNER JOIN categories WHERE expenses.category_id = categories.id AND expenses.id_user = :userId ORDER BY  date');
            $query->execute([
                'userId'=> $userId
            ]);
            
            while($p = $query->fetch(PDO::FETCH_ASSOC)){
                $item = new JoinExpensesCategoriesModel();
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


    function from($array){
        $this->expenseId    =   $array['expense_id'];
        $this->title        =   $array['title'];
        $this->amount       =   $array['amount'];
        $this->categoryId   =   $array['category_id'];
        $this->date         =   $array['date'];
        $this->userId       =   $array['id_user'];
        $this->nameCategory =   $array['name'];
        $this->color        =   $array['color'];
        
    }

    function toArray(){
           $array = [];
           $array['id']             = $this->expenseId ;
           $array['title']          = $this->title     ;
           $array['amount']         = $this->amount    ;
           $array['category_id']    = $this->categoryId;
           $array['date']           = $this->date;
           $array['id_user']        = $this->userId ;
           $array['name']           = $this->nameCategory;
           $array['color']          = $this->color     ;

           return $array;
        
    }
    public function getexpenseId()      {return $this->expenseId ;}
    public function gettitle()          {return $this->title     ;}
    public function getamount()         {return $this->amount    ;}
    public function getcategoryId()     {return $this->categoryId;}
    public function getdate()           {return $this->date;}
    public function getuserId()         {return $this->userId ;}
    public function getnameCategory()   {return $this->nameCategory;}
    public function getcolor()          {return $this->color     ;}

}
