<?php
class Dashboard extends SessionController
{
    private $user;
    function __construct()
    {
        parent::__construct();
        $this->user = $this->getUserSessionData();
        error_log("---- Inicio de Dashboard ----");
    }

    function render()
    {
        error_log("Dashboard::render -> carga view de Dashboard.");
        $expensesModel = new ExpensesModel();
        $expenses = $this->getExpenses(5);
        $totalThisMonth = $expensesModel->getTotalAmountThisMonth($this->user->getId());
        $maxExpensesThisMonth = $expensesModel->getMaxExpensesThisMonth($this->user->getId());
        $categories = $this->getCategories();
        $this->view->render('Dashboard/index',[
            'user' => $this->user,
            'expenses' => $expenses,
            'totalThisMonth'        =>  $totalThisMonth,
            'maxExpensesThisMonth'  =>$maxExpensesThisMonth,
            'categories'            =>$categories
        ]);
    }

    public function getExpenses($n = 0)
    {
        if($n< 0){
            return NULL;
        }
        
        $expensesModel = new ExpensesModel();
        return $expensesModel ->getAllByUserIdAndLimit($this->user->getId(), $n);
    

    }

    public function getCategories()
    {
        $res = [];
        $categoriesModel = new CategoriesModel();
        $expensesModel   = new ExpensesModel();

        $categories      = $categoriesModel->getAll();
        foreach ($categories as $category) {
            $categoryArray = [];

            $total = $expensesModel->getTotalByCategoryThisMonth($category->getId(), $this->user->getId());
            $numberOfExpenses = $expensesModel->getNumberOfExpensesByCategoryThisMonth($category->getId(), $this->user->getId());
            error_log('Dashboard::getCategories numberOfExpenses : '.$numberOfExpenses);
            if($numberOfExpenses > 0){
                $categoryArray['total'] =  $total;
            $categoryArray['count'] =  $numberOfExpenses;
            $categoryArray['category'] =  $category;
            array_push($res,$categoryArray);
            }
        }
        return $res;


    }
}
