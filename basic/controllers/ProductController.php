<?php


namespace app\controllers;


class ProductController extends AppController
{
    public function actionIndex(){
        return $this->render('index');
    }
    public function actionTest(){
        return $this->render('test');
    }
}