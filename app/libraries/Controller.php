<?php

    class Controller{

        public function returnmodel($instantaModel){
        require_once '../app/models/' .$instantaModel . '.php';

            return new $instantaModel();
        }

        public function returnview($nameView, $data = []){
            if(file_exists('../app/views/' . $nameView . '.php')){
                require_once '../app/views/' . $nameView . '.php';
            } else {
                die('Nu exista view-ul');
            }
        }


    }