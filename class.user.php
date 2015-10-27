<?php
class USER {
    private $db;

    function __construct($DB_con) {
        $this->db = $DB_con;
    }
  
    public function register ($u_fname, $u_lname, $u_email, $u_department, $u_pass){
        try {
            $options = ['cost' => 12];            
            $hashed_password = password_hash($u_pass, PASSWORD_BCRYPT, $options);

            $query = "INSERT INTO tbl_users (user_firstname, user_lastname, user_email, user_department, user_pass) VALUES (:u_fname, :u_lname, :u_email, :u_department, :u_pass)";
            $stmt = $this->db->prepare($query);    
            $result = $stmt->execute(
              array(
                'u_fname' => $u_fname,
                'u_lname' => $u_lname,
                'u_email' => $u_email,
                'u_department' => $u_department,
                'u_pass' => $hashed_password
                ));

            return $result; 

       } catch(PDOException $e) {
           echo $e->getMessage();
       }    
    }
 
    public function login ($u_email,$u_pass) {
        try {
            $query = "SELECT * FROM tbl_users WHERE user_email = :u_email LIMIT 1";
            $stmt = $this->db->prepare($query);
            $stmt->execute(array(
                ':u_email' => $u_email,
                ));

            $userRow = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($stmt->rowCount() > 0) {
                if(password_verify($u_pass, $userRow['user_pass'])) {
                    $_SESSION['user_session'] = $userRow['user_id'];

                    return true;
                } else {
                    return false;
                }
            }
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    // @TODO: Not working
    public function department_name() {
        try {
            $query = "SELECT * FROM tbl_users AS u ";
            $query .= "LEFT JOIN tbl_departments AS d ON u.user_department = d.department_id ";
            // $query .= "WHERE user_id = :user_id";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $departmentRow = $stmt->fetch(PDO::FETCH_ASSOC);

            return $departmentRow;   

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

    public function newProject($proj_name, $proj_desc, $proj_date_start, $proj_date_end) {
        try {
            $query = "INSERT INTO tbl_projects (proj_name, proj_desc, proj_date_start, proj_date_end)";
            $query .= "VALUES (:proj_name, :proj_desc, :proj_date_start, :proj_date_end)";
            
            $stmt = $this->db->prepare($query);    

            $result = $stmt->execute(
                array(
                    'proj_name' => $proj_name,
                    'proj_desc' => $proj_desc,
                    'proj_date_start' => $proj_date_start,
                    'proj_date_end' => $proj_date_end
                ));
     
            return $stmt; 
        } catch(PDOException $e) {
            echo $e->getMessage();
        }    
    } 

    public function getUrl() {
        $url  = @( $_SERVER["HTTPS"] != 'on' ) ? 'http://'.$_SERVER["SERVER_NAME"] :  'https://'.$_SERVER["SERVER_NAME"];
        $url .= ( $_SERVER["SERVER_PORT"] !== 80 ) ? ":".$_SERVER["SERVER_PORT"] : "";
        $url .= $_SERVER["REQUEST_URI"];
        
        return $url;
    }
    
    public  function curPageName() {
        return substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
    }

}
?>