<?php
class Flash{
    public static function setMessage($text, $type){
        if($type == 'error'){
            $_SESSION['errorMsg'] = $text;
        } elseif ($type == 'info') {
            $_SESSION['infoMsg'] = $text;
        } elseif ($type == 'success'){
            $_SESSION['successMsg'] = $text;
        }
    }

    public static function display(){
        if (isset($_SESSION['errorMsg'])) {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">' . $_SESSION['errorMsg'] . 
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span></button></div>';
            unset($_SESSION['errorMsg']);
        }
        if (isset($_SESSION['infoMsg'])) {
            echo '<div class="alert alert-info alert-dismissible fade show" role="alert">' . $_SESSION['infoMsg'] . 
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span></button></div>';
            unset($_SESSION['infoMsg']);
        }
        if (isset($_SESSION['successMsg'])) {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">' . $_SESSION['successMsg'] . 
            '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button></div>';
            unset($_SESSION['successMsg']);
        }
    }
}