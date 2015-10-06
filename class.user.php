<?php
    class USER {
        private $db;

        function __construct($DB_con) {
            $this->db = $DB_con;
        }

        public function register($fname,$lname,$uname,$umail,$upass) {
            try {
                $options = ['cost' => 12];            
                $new_password = password_hash($upass, PASSWORD_BCRYPT, $options);
                
                $query = "INSERT INTO tbl_users (user_name,user_email,user_pass)";
                $query .= "VALUES (:uname, :umail, :upass)";
                
                $stmt = $this->db->prepare($query);    

                $result = $stmt->execute(
                  array(
                    'uname' => $uname,
                    'umail' => $umail,
                    'upass' => $new_password
                    ));
                $stmt->bindparam(":uname", $uname);
                $stmt->bindparam(":umail", $umail);
                $stmt->bindparam(":upass", $new_password);            
                $stmt->execute(); 
         
                return $stmt; 
            } catch(PDOException $e) {
                echo $e->getMessage();
            }    
        }   
        
        public function login($uname,$umail,$upass) {
            try {
                $stmt = $this->db->prepare("SELECT * FROM tbl_users WHERE user_name=:uname OR user_email=:umail LIMIT 1");
                $stmt->execute(array(':uname'=>$uname, ':umail'=>$umail));
                $userRow=$stmt->fetch(PDO::FETCH_ASSOC);
                
                if($stmt->rowCount() > 0) {
                    if(password_verify($upass, $userRow['user_pass'])) {
                        $_SESSION['user_session'] = $userRow['user_id'];
                        $_SESSION['loggedin_time'] = time(); 
                        return true; 
                    } else {
                        return false;
                   }
                }
            } catch(PDOException $e) {
                echo $e->getMessage();
            }
        }
       
        public function is_loggedin() {
            if(isset($_SESSION['user_session'])) {
                return true;
            }
        }
       
        public function redirect($url) {
            header("Location: $url");
        }
       
        public function logout() {
            session_destroy();
            unset($_SESSION['user_session']);
            return true;
        }

        public function timestamp() {
            $login_session_duration = 10; 
            $current_time = time(); 
            if(isset($_SESSION['loggedin_time']) and isset($_SESSION["user_id"])){  
                if((time() - $_SESSION['loggedin_time']) > $login_session_duration){ 
                    return true; 
                } 
            }
            return false;
        }

        // public function timestamp() { 
        //     $idletime = 10;
        //     if (time()-$_SESSION['timestamp'] > $idletime) {
        //         session_destroy();
        //         session_unset();
        //     } else {
        //         $_SESSION['timestamp']=time();
        //     }
        // }
    }
?>