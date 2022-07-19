<?php
    include('config.php');
    class Student {
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
        else {
            $sql = "INSERT INTO `students` (id, name, email, address, phone, gender) VALUES (null,'$this->name', '$this->email', '$this->address', '$this->phone', '$this->gender')";
            if ($GLOBALS['conn']->query($sql) == TRUE) 
            {
                $_SESSION['msg'] = "Data inserted successfully";
                header('location:index.php');
            } else {
                echo mysqli_error($GLOBALS['conn']);
            }
        }
        }

        public function viewRecord() {
            $sql = "SELECT * FROM `students`";
            $result = $GLOBALS['conn']->query($sql);
            if($result->num_rows > 0) {
                while($row = mysqli_fetch_object($result)) {
                    $data[] = array(
                        'id'=>$row->id,
                        'name'=>$row->name,
                        'email'=>$row->email,
                        'address'=>$row->address,
                        'phone'=>$row->phone,
                        'gender'=>$row->gender
                    );
                };
                return $data;
            }
        }

        public function viewRecordById() {
            $sql = "SELECT * FROM `students` WHERE id='$this->id'";
            $result = $GLOBALS['conn']->query($sql);
            if($result->num_rows==1) {
                $row = mysqli_fetch_object($result);
                $data = array(
                    'id'=>$row->id,
                    'name'=>$row->name,
                    'email'=>$row->email,
                    'address'=>$row->address,
                    'phone'=>$row->phone,
                    'gender'=>$row->gender
                );
                return $data;
            } else {
                die(mysqli_error($GLOBALS['conn']));
            }
        }

        public function updateRecord() {
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
                echo mysqli_error($GLOBALS['conn']);
            }
        }
    }

        public function deleteRecord($deleteid) {
            $sql = "DELETE FROM `students` WHERE id='$deleteid'";
            $result = $GLOBALS['conn']->query($sql);
            if($result) {
                header('location:index.php');
            } else {
                echo mysqli_error($GLOBALS['conn']);
            }
        }
    }
