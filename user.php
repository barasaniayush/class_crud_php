<?php
    include('config.php');
    class Student{
        public $id;
        public $name;
        public $email;
        public $address;
        public $phone;
        public $gender;

        function __construct($id=null, $name=null, $email=null, $address=null, $phone=null, $gender=null) {
            $this->id = $id;
            $this->name = $name;
            $this->email = $email;
            $this->address = $address;
            $this->phone = $phone;
            $this->gender = $gender;
        }
    
        public function insertRecord() {
            /**
             * This function inserts record in table name `students` after the user submits the form
             * success message is shown in homepage after the data is successfully inserted by user
             */
            if (empty($this->name) || empty($this->email) || empty($this->address)
            || empty($this->phone) || empty($this->gender)
        ) {
            $_SESSION['all'] = "Please fill all the field";
            return false;
        }

        if (filter_var($this->email, FILTER_VALIDATE_EMAIL) == FALSE) {
            $_SESSION['all'] = "Invalid email";
            return false;
        }
    
        if (!preg_match("/^[a-zA-z ]*$/", $this->name)) {
            $_SESSION['all'] = "Name is invalid. Please enter alphabets only";
            return false;
        }
    
        if (!preg_match('/^[0-9]{10}+$/', $this->phone)) {
            $_SESSION['all'] = "Phone number should be numeric and of 10 digit only";
            return false;
        }
    
        if (!preg_match("/^[a-zA-z ,]*$/", $this->address)) {
            $_SESSION['all'] = "Address is invalid. Please enter alphabets only";
            return false;
        }
        $sql1 = "SELECT * FROM `students` WHERE email='$this->email'";
        $result1 = mysqli_query($GLOBALS['conn'], $sql1);
        if(mysqli_num_rows($result1) > 0) {
            $_SESSION['all'] = "Email address already exists.";
            return false;
        }
        $sql1 = "SELECT * FROM `students` WHERE phone='$this->phone'";
        $result1 = mysqli_query($GLOBALS['conn'], $sql1);
        if(mysqli_num_rows($result1) > 0) {
            $_SESSION['all'] = "Phone number already exists.";
            return false;
        }
        else {
            $sql = "INSERT INTO `students` (id, name, email, address, phone, gender) VALUES (null,'$this->name', '$this->email', '$this->address', '$this->phone', '$this->gender')";
            if ($GLOBALS['conn']->query($sql) == TRUE) 
            {
                $_SESSION['msg'] = "Data inserted successfully";
                header('location:index.php');
            } else {
                throw new Exception(mysqli_error($GLOBALS['conn']));
            }
        }
        }
    
        public function listAll() {
            /**
             * This will list all the data from the database table `students`
             * If any error occurs then it will not display the data 
             * It throw errors if any fault is there in the code
             */
            try {
                $data = array();
                $sql = "SELECT * FROM `students`";
                $result = $GLOBALS['conn']->query($sql);
                if($result->num_rows > 0) {
                    while($row = mysqli_fetch_object($result)) {
                        $std = new Student();
                        $std->id = $row->id;
                        $std->name = $row->name;
                        $std->email = $row->email;
                        $std ->address = $row->address;
                        $std->phone = $row->phone;
                        $std->gender = $row->gender;
                        array_unshift($data, $std);
                    };
                    return $data;
                } else {
                    throw new Exception(mysqli_error($GLOBALS['conn']));
                }
            } catch(Exception $e) {
                echo $e->getMessage();
            }
        }

        public function viewRecordById() {
            /**
             * This will show the record of the selected data from the table
             * The data will be shown on update form 
             * The user will get information of only selected item from the table
            */
            try {
                
                $sql = "SELECT * FROM `students` WHERE id='$this->id'";
                $result = $GLOBALS['conn']->query($sql);
                if($result->num_rows == 1) {
                    $row = mysqli_fetch_object($result);
                    $this->id = $row->id;
                    $this->name = $row->name;
                    $this->email = $row->email;
                    $this->address = $row->address;
                    $this->phone = $row->phone;
                    $this->gender = $row->gender;
                } else {
                    throw new Exception(mysqli_error($GLOBALS['conn']));
                }
            }catch(Exception $e) {
                echo $e->getMessage();
            }
        }

        public function editRecord() {
            /**
             * This will edit the record in the edit form
             * The validation is done in the function 
             * The validation stops user from providing invalid information
             * This will then return to homepage if update is successful with success message
             */
        try {
            if (empty($this->name) || empty($this->email) || empty($this->address)
            || empty($this->phone) || empty($this->gender)
        ) {
            $_SESSION['update'] = "All field required";
            return false;
        }
    
        if (filter_var($this->email, FILTER_VALIDATE_EMAIL) == FALSE) {
            $_SESSION['update'] = "Email format is invalid";
            return false;
        }
    
        if(!preg_match('/^[0-9]{10}+$/', $this->phone)) {
            $_SESSION['update'] = "Phone number should only contain numeric value";
            return false;
        }
    
        if (!preg_match("/^[a-zA-Z ]*$/", $this->name)) {
            $_SESSION['update'] = "Name is invalid";
            return false;  
        }
    
        if (!preg_match("/^[a-zA-z ,]*$/", $this->address)) {
            $_SESSION['update'] = "Address is invalid";
            return false;
        } else {
            $sql = "UPDATE `students` SET name='$this->name', email='$this->email', address='$this->address', phone='$this->phone', gender='$this->gender' WHERE id='$this->id'";
            $result = mysqli_query($GLOBALS['conn'], $sql);
            if ($result) {
                $_SESSION['status'] = "Data updated successfully";
                header('location:index.php');
            } else {
                throw new Exception(mysqli_error($GLOBALS['conn']));
            }
        }
        } catch(Exception $e) {
            echo $e->getMessage();
        }
    }

    public function deleteRecord($deleteid) {
        /**
        * This will delete the record from database
        * If id is not found then it will throw error and not let user delete record
        */
        try {
            $sql = "DELETE FROM `students` WHERE id='$deleteid'";
            $result = $GLOBALS['conn']->query($sql);
            if($result) {
                header('location:index.php');
            } else {
                throw new Exception(mysqli_error($GLOBALS['conn']));
            }
        } catch(Exception $e) {
            echo $e->getMessage();
        }
    }
}