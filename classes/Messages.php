<?php
    class Messages{
        public static function setMsg($text, $type){
            if($type == 'error'){
                $_SESSION['errorMsg'] = $text;
            } else {
                $_SESSION['successMsg'] = $text;
            }
        }

        public static function display(){
            if(isset($_SESSION['errorMsg'])){
                echo '<div class="alert alert-danger">'.$_SESSION['errorMsg'].'</div>';
                unset($_SESSION['errorMsg']);
            }
            if(isset($_SESSION['succesMsg'])){
                echo '<div class="alert alert-success">'.$_SESSION['succesMsg'].'</div>';
                unset($_SESSION['succesMsg']);
            }
        }
    }