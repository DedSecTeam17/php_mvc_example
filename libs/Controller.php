<?php
    /**
     * Created by PhpStorm.
     * User: Mohammed Elamin
     * Date: 28/11/2018
     * Time: 00:05
     */

    require_once  'GreenValidator.php';
    require_once  'libs/messages/Message.php';

    class Controller
    {


        public function __construct($model_name = '')
        {
            $this->validator=new GreenValidator();

            $this->view = new View();

//            load model class if not it,s empty
            if ($model_name!=''){
                $modelName=$this->loadModel($model_name);
                $this->model=new $modelName();
            }
        }



        public function middleWare($user_type,  $except = array())
        {



            $url =  $_SERVER['REQUEST_URI'];


            if (!empty($except))
            {
             foreach ($except as $view)    {

                 if (!stripos($url, $view)) {
                     // string contains characters other than |
                     if ($user_type==='Auth')
                     {
                         if (!Auth::getInstance()->isAuthenticated()) {
                             Route::redirectTo(Route::to('index', 'HomeController', null, false));
                         }
                     }else if ($user_type==='quest')
                     {
                         Route::redirectTo(Route::to('index', 'HomeController', null, false));

                     }
                 }
             }


            }   else {
                if ($user_type==='Auth')
                {
                    if (!Auth::getInstance()->isAuthenticated()) {
                        Route::redirectTo(Route::to('index', 'HomeController', null, false));
                    }
                }else if ($user_type==='Quest')
                {

                    if (!empty(Auth::getInstance()->isAuthenticated())) {
                        Route::redirectTo(Route::to('index', 'HomeController', null, false));
                    }else{
                        Route::redirectTo(Route::to('index', 'HomeController', null, false));

                    }
//                    Route::redirectTo(Route::to('index', 'HomeController', null, false));

//                    Route::redirectTo(Route::to('index', 'HomeController', null, false));

                }
            }







        }


        function loadModel($model_name)
        {


            if (file_exists('models/' . $model_name . '.php') || isset($model_name)) {
                require 'models/' . $model_name . '.php';
                return $model_name;
            }else
            {
                return 'file dose not exist ';
            }
        }


        public function getPostRequestData($filed_name)
        {
            $sanitizer = new Sanitizer();
            return $sanitizer->sanitizeString($_POST[$filed_name]);
        }


        public  function  getGetRequestData($filed_name){
            $sanitizer = new Sanitizer();
            return  !empty($_GET[$filed_name]) ?  $sanitizer->sanitizeString($_GET[$filed_name]) : null;
        }


    }