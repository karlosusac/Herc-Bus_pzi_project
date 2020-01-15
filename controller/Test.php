<?php
    class Test extends Controller{

        public function index(){
            var_dump($_POST["editAutobusLineStops"]);
            var_dump($_POST["listOfSchedules"]);
        }
    }
?>