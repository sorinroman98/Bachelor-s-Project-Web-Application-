<?php

    class Core  {
        protected $controllerCurent = 'Pages';
        protected $metodaCurenta = 'index';
        protected $parametrii = [];

        public function __construct(){

            $adress = $this->returnURL();

            if(file_exists('../app/controllers/' . ucwords($adress[0]). '.php')){

                $this->controllerCurent = ucwords($adress[0]);

                unset($adress[0]);
            }

            require_once '../app/controllers/'. $this->controllerCurent .'.php';

            $this->controllerCurent = new $this->controllerCurent;

            if(isset($adress[1])){
                if(method_exists($this->controllerCurent,$adress[1])){
                    $this->metodaCurenta = $adress[1];
                    unset($adress[1]);
                }
            }

            $this->parametrii = $adress ? array_values($adress) : [];

           call_user_func_array([$this->controllerCurent,$this->metodaCurenta], $this->parametrii);
        }

        public function returnURL(){
            if(isset($_GET['url'])){
                $adress = rtrim($_GET['url'],'/');
                $adress = filter_var($adress, FILTER_SANITIZE_URL);
                $adress = explode('/',$adress);
                return $adress;
            }
        }
    }