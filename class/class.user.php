<?php
class USER {
    private $db;

    function __construct($DB_con) {
        $this->db = $DB_con;
    }
  
    public function register ($u_fname, $u_lname, $u_email, $u_phone, $u_department, $u_pass, $u_type, $u_avatar) {
        try {
            $options = ['cost' => 12];            
            $hashed_password = password_hash($u_pass, PASSWORD_BCRYPT, $options);

            $query = "INSERT INTO tbl_users (user_firstname, user_lastname, user_email, user_phone, user_department, user_pass, user_usertype, user_avatar) VALUES (:u_fname, :u_lname, :u_email, :u_phone, :u_department, :u_pass, :u_type, :u_avatar)";
            $stmt = $this->db->prepare($query);    
            $result = $stmt->execute(
              array(
                'u_fname' => $u_fname,
                'u_lname' => $u_lname,
                'u_email' => $u_email,
                'u_phone' => $u_phone,
                'u_department' => $u_department,
                'u_pass' => $hashed_password,
                'u_type' => $u_type,
                'u_avatar' => $u_avatar
                ));

            return $result; 

       } catch(PDOException $e) {
           echo $e->getMessage();
       }    
    }
 
    public function login ($u_email,$u_pass) {
        try {
            $query = "SELECT * FROM tbl_users WHERE user_email = ? LIMIT 1";
            $stmt = $this->db->prepare($query);
            $stmt->execute(array(
                $u_email
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
            $query = "SELECT user_id, user_firstname, user_lastname, user_department, department_name, avatar_url FROM tbl_users AS u ";
            $query .= "LEFT JOIN tbl_departments AS d ON u.user_department = d.department_id ";
            $query .= "LEFT JOIN tbl_avatars AS a ON u.user_avatar = a.avatar_id";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $departmentRow = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $departmentRow; 

        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function update_user($update_firstname, $update_lastname, $update_email, $update_phone, $update_avatar, $user_id) {
        try {
            $query = "UPDATE tbl_users ";
            $query .= "SET user_firstname = ?, user_lastname = ?, user_email = ?, user_phone = ?, user_avatar = ? ";
            $query .= "WHERE user_id = ?";
            $stmt = $this->db->prepare($query);
            $stmt->execute(
                array(
                    $update_firstname,
                    $update_lastname,
                    $update_email,
                    $update_phone,
                    $update_avatar,
                    $user_id
                ));

            return $stmt;

        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function delete_user($user_id_edit) {
        try{
            $query  = "DELETE FROM tbl_users ";
            $query .= "WHERE user_id = ?";

            $stmt = $this->db->prepare($query);                     
            $result = $stmt->execute(
                array(
                    $user_id_edit
                ));       
            
            return $result;

        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function display_avatars() {
        try {   
            $query = "SELECT * FROM tbl_avatars";
            $stmt = $this->db->prepare($query); 
            $stmt->execute();
            $avatarRow = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $avatarRow; 

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

    // Fetch ALL users
    public function allUsers() {
        try {
            $query = "SELECT * FROM tbl_users AS u ";
            $query .= "LEFT JOIN tbl_departments AS d ON u.user_department = d.department_id ";
            $query .= "LEFT JOIN tbl_avatars AS a ON u.user_avatar = a.avatar_id ";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $userRow = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $userRow;

        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }
    // Fetch users information with database
    public function userData($user_id) {
        try {
            $query = "SELECT * FROM tbl_users AS u ";
            $query .= "LEFT JOIN tbl_departments AS d ON u.user_department = d.department_id ";
            $query .= "LEFT JOIN tbl_avatars AS a ON u.user_avatar = a.avatar_id ";
            $query .= "WHERE user_id = ?";
            $stmt = $this->db->prepare($query);
            $stmt->execute(array($user_id));
            $userRow = $stmt->fetch(PDO::FETCH_ASSOC);

            return $userRow;

        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function simpleData($get_id) {
        try {
            $query = "SELECT user_firstname FROM tbl_users ";
            $query .= "WHERE user_id = ?";
            $stmt = $this->db->prepare($query);
            $stmt->execute(array($get_id));
            $userRow = $stmt->fetch(PDO::FETCH_ASSOC); 

            return $userRow;
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    // Naming the user/admin/etc...
    public function usertype($user_id) {
        try {
            $query = "SELECT user_usertype FROM tbl_users ";
            $query .= "WHERE user_id = ?";
            $stmt = $this->db->prepare($query);
            $stmt->execute(array($user_id));
            $usertype = $stmt->fetch(PDO::FETCH_ASSOC);
            $usertype = $usertype['user_usertype'];

            return $usertype;

        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    // Naming the user/admin/etc...
    public function usertypeName($user_id) {
        try {
            $query = "SELECT user_usertype FROM tbl_users ";
            $query .= "WHERE user_id = ?";
            $stmt = $this->db->prepare($query);
            $stmt->execute(array($user_id));
            $usertype = $stmt->fetch(PDO::FETCH_ASSOC);
            $usertype = $usertype['user_usertype'];

            if ($usertype == "1") {
                $usertype = "Admin";
                return $usertype;
            } 
            elseif ($usertype == "2") {
                $usertype = "User"; 
                return $usertype;
            } 
            else {
                $usertype = "Not assigned yet";
                return $usertype;
            }

        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function userDepartments($department_id) {
        try {
            $query = "SELECT * FROM tbl_users AS u ";
            $query .= "LEFT JOIN tbl_departments AS d ON u.user_department = d.department_id ";
            $query .= "WHERE user_department = ?";
            $stmt = $this->db->prepare($query);
            $stmt->execute(array($department_id));
            $userDepartments = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $userDepartments;

        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }
}
?>