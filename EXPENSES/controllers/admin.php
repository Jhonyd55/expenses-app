<?php
require_once 'models/expensesmodel.php';
require_once 'models/categoriesmodel.php';
class Admin extends SessionController {
    //private $user;
    public function __construct(){
        parent::__construct();
        //$this->user = $this->getUserSessionData();
        error_log("---- Inicio de Admin ----");

    }

 function render(){
    $stats = $this->getStatistics();
    $this->view->render('admin/index',[
        'stats'=> $stats
    ]);
 }
 function createCategory(){
    $this->view->render('admin/create-category');
 }

 function newCategory(){
    if($this->existPOST(['name','color'])){
        $name = $this->getPost('name');
        $color = $this->getPost('color');

        $categoriesModel = new CategoriesModel();

        if (!$categoriesModel->exists($name)) {
            $categoriesModel->setName($name);
            $categoriesModel->setcolor($color);
            $categoriesModel->save();

            $this->redirect('admin',[]);//TODO sucess
        }else{
            $this->redirect('admin',[]);//TODO  error
        }


    }
 }

 private function getMaxAmount($expenses){
    $max = 0;

    foreach($expenses as $expense){
        $max = max($max,$expense->getAmount());
    }

    return $max;
 }

  private function getMinAmount($expenses){
    $min = $this->getMaxAmount($expenses);

    foreach($expenses as $expense){
        $min = min($min,$expense->getAmount());
    }

    return $min;
 }

 private function getAverageAmount($expenses){
    $sum = 0;

    foreach($expenses as $expense){
        $sum += $expense->getAmount();
    }
    if(count($expenses)>0) {
        $sum = $sum /count($expenses);
    }

    return $sum;
 }
 
 private function getCategoryMostUsed($expenses){
    $repeat = [];
    error_log('admin::getCategoryMostUsed count expenses '.count($expenses));
    foreach ($expenses as $expense) {
        error_log('admin::getCategoryMostUsed expense->getCategoryId() '.$expense->getCategoryId());
        if(!array_key_exists($expense->getCategoryId(),$repeat)){
            $repeat[$expense->getCategoryId()] = 0;
        }
        $repeat[$expense->getCategoryId()]++;
    }

    //$categoryMostUsed = max($repeat);

    $categoryMostUsed = 0;
    $maxCategory= max($repeat);
    error_log('admin::getCategoryMostUsed $repeat[1] '.$repeat[1]);
    error_log('admin::getCategoryMostUsed $repeat[2] '.$repeat[2]);
    error_log('admin::getCategoryMostUsed $repeat[3] '.$repeat[3]);
    error_log('admin::getCategoryMostUsed $repeat[4] '.$repeat[4]);
    error_log('admin::getCategoryMostUsed $repeat[5] '.$repeat[5]);
    error_log('admin::getCategoryMostUsed maxCategory '.$maxCategory);
    foreach ($repeat as $index => $category) {
        if ($category == $maxCategory) {
            $categoryMostUsed = $index;
        }
    }



    $categoryModel = new CategoriesModel();
    $categoryModel->get($categoryMostUsed);

    $category = $categoryModel->getName();

    return $category;
    
 }
 private function getCategoryLessUsed($expenses){
    $repeat = [];
    foreach ($expenses as $expense) {
        if(!array_key_exists($expense->getCategoryId(),$repeat)){
            $repeat[$expense->getCategoryId()] = 0;
        }
        $repeat[$expense->getCategoryId()]++;
    }

    //$categoryMostUsed = min($repeat);
    $categoryMostUsed = 0;
    $maxCategory= min($repeat);
    error_log('admin::getCategoryLessUsed count repeat '.count($repeat));
    error_log('admin::getCategoryLessUsed minCategory '.$maxCategory);
    foreach ($repeat as $index => $category) {
        if ($category == $maxCategory) {
            $categoryMostUsed = $index;
        }
    }
    $categoryModel = new CategoriesModel();
    $categoryModel->get($categoryMostUsed);

    $category = $categoryModel->getName();

    return $category;
    
 }
 function getStatistics(){
    $res = [];

    $userModel = new UserModel();
    $users  =   $userModel->getAll();
    error_log('admin::getStatistics count users '.count($users));
    $expensesModel = new ExpensesModel();
    $expenses = $expensesModel->getAll();

    $categoriesModel    =   new CategoriesModel();
    $categories = $categoriesModel->getAll();

    $res['count-users'] = count($users);
    $res['count-expenses'] = count($expenses);
    $res['max-expenses'] = $this->getMaxAmount($expenses);
    $res['min-expenses'] = $this->getMinAmount($expenses);
    $res['avg-expenses'] = $this->getAverageAmount($expenses);
    $res['count-categories'] = count($categories);
    $res['mostused-categories'] = $this->getCategoryMostUsed($expenses);
    $res['lessused-categories'] = $this->getCategoryLessUsed($expenses);
    
    return $res;


 }

}