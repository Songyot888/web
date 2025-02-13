<?php
    class Student{
        public $id;
        public $prefix;
        public $fname;
        public $lname;
        public $year;
        public $birthday;
        public $gpa;

        function __construct($id, $prefix, $fname, $lname, $year, $birthday, $gpa){
            $this->id = $id;
            $this->prefix = $prefix;
            $this->fname = $fname;
            $this->lname = $lname;
            $this->year = $year;
            $this->birthday = $birthday;
            $this->gpa = $gpa;
        }

    }

    class Account{
        public $Username;
        public $Email;
        public $Password;

        function __construct($Username, $Email, $Password){
            $this->Username = $Username;
            $this->Email = $Email;
            $this->Password = $Password;
        }
    }
?>