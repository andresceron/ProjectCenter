<?php
class PROJECTS {
    private $db;

    function __construct($DB_con) {
        $this->db = $DB_con;
    }

  
    // Create a new project
    public function newProject($proj_name, $proj_desc, $proj_date_start, $proj_date_end, $proj_users_id, $chk, $proj_tasks) {
        try {
            $query = "INSERT INTO tbl_projects (proj_name, proj_desc, proj_date_start, proj_date_end) ";
            $query .= "VALUES (:proj_name, :proj_desc, :proj_date_start, :proj_date_end)";
            
            $stmt = $this->db->prepare($query);    
            $result = $stmt->execute(
                array(
                    'proj_name' => $proj_name,
                    'proj_desc' => $proj_desc,
                    'proj_date_start' => $proj_date_start,
                    'proj_date_end' => $proj_date_end
                ));

            $last_id = $this->db->lastInsertId();

            if (!empty($proj_users_id)) {
                foreach($proj_users_id as $proj_user_id) {  
                    $query2 = "INSERT INTO tbl_link(proj_id, user_id) ";
                    $query2 .= "VALUES (?, ?)";
                    $stmt2  = $this->db->prepare($query2);
                    $result = $stmt2->execute(
	                    array(
	                        $last_id,
	                        $proj_user_id
	                    ));            
                }
            } else {
                $query2 = "INSERT INTO tbl_link(proj_id) ";
                $query2 .= "VALUES (?) ";
                $stmt2  = $this->db->prepare($query2);
                $result = $stmt2->execute(
                    array(
                        $last_id
                    ));            
            }

            if(!empty($proj_tasks)) {
                foreach($proj_tasks as $proj_task) {
                    $query3 = "INSERT INTO tbl_todos (todo_task, proj_id) ";
                    $query3 .= "VALUES (?, ?)";
                    $stmt3 = $this->db->prepare($query3);
                    $result = $stmt3->execute(
                        array(
                            $proj_task,
                            $last_id
                        ));
                }
            }

            return true;

        } catch(PDOException $e) {
            echo $e->getMessage();
        }    
    } 

    // Setting the Status of the Project
    public function updateProj($proj_name, $proj_desc, $proj_date_start, $proj_date_end, $proj_id) {
        try {
            $query = "UPDATE tbl_projects ";
            $query .= "SET proj_name = ?, "; 
            $query .= "proj_desc = ?, "; 
            $query .= "proj_date_start = ?, "; 
            $query .= "proj_date_end = ? "; 
            $query .= "WHERE proj_id = ?";
            
            $stmt = $this->db->prepare($query);
            $stmt->execute(
                array(
                    $proj_name,
                    $proj_desc,
                    $proj_date_start,
                    $proj_date_end,
                    $proj_id
                ));

            return true;

        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    // Deleting the project
    public function deleteProj($proj_id) {
        try{
            $query  = "DELETE FROM tbl_projects ";
            $query .= "WHERE proj_id = ?";

            $stmt = $this->db->prepare($query);                     
            $result = $stmt->execute(array($proj_id));       
            
            return $result;

        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    // Setting the Status of the Project
    public function updateProjStatus($btnStatus, $proj_id) {
        try {
            $query = "UPDATE tbl_projects SET proj_state = ? WHERE proj_id = ?";
            $stmt = $this->db->prepare($query);
            $stmt->execute(
                array(
                    $btnStatus,
                    $proj_id
                ));

            return true;

        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    // Fetch a specifik project
    public function singleProject($proj_id) {
        try {
            $query = 'SELECT * FROM tbl_projects WHERE proj_id = :proj_id';
            $stmt = $this->db->prepare($query);
            $stmt->execute(array('proj_id' => $proj_id));
            $singleProjectsRow = $stmt->fetch(PDO::FETCH_ASSOC);

            return $singleProjectsRow;

        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    // Fetch all projects
    public function allProjects() {
        try {
            $query = 'SELECT * FROM tbl_projects ';
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $allProjectsRow = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if(!empty($allProjectsRow)) {
                return $allProjectsRow;
            } else {
                return false;
            }

        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    // Fetch users all projects
    public function userProjects($user_id) {
        try {
            $query = "SELECT * FROM tbl_link as l ";
            $query .= "LEFT JOIN tbl_projects as p on l.proj_id = p.proj_id ";
            $query .= "WHERE user_id = ? ";
            $query .= "ORDER BY proj_date_start ASC";  
            $stmt = $this->db->prepare($query);
            $stmt->execute(array($user_id));
            $projRows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if(!empty($projRows)) {
                return $projRows;
            } else {
                return false;
            }

        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    // Fetch all users on detailed project
    public function allUsersProj($proj_id) {
        try {
            $query = "SELECT * FROM tbl_link as l ";
            $query .= "LEFT JOIN tbl_users as p on l.user_id = p.user_id ";
            $query .= "LEFT JOIN tbl_avatars as a on p.user_avatar = a.avatar_id ";
            $query .= "WHERE proj_id = ?";
            $stmt = $this->db->prepare($query);
            $stmt->execute(array($proj_id));
            $projRows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if(!empty($projRows)) {
                return $projRows;
            } else {
                return false;
            }

        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    // Fetch projects with date upcoming
    public function upcomingProjects($user_id) {
        try {
            $query = "SELECT * FROM tbl_link as l ";
            $query .= "LEFT JOIN tbl_projects as p on l.proj_id = p.proj_id ";
            $query .= "WHERE user_id = ? AND proj_state = 0 AND proj_date_start > current_date() + interval 1 day ";
            $query .= "ORDER BY proj_date_start ASC";  
            $stmt = $this->db->prepare($query);
            $stmt->execute(array($user_id));
            $projRows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if(!empty($projRows)) {
                return $projRows;
            } else {
                return false;
            }

        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    // Fetch projects that are active
    public function activeProjects($user_id) {
        try {
            $query = "SELECT * FROM tbl_link as l ";
            $query .= "LEFT JOIN tbl_projects as p on l.proj_id = p.proj_id ";
            $query .= "WHERE user_id = ? AND proj_state = 1 ";  
            $query .= "ORDER BY proj_date_end ASC";  
            $stmt = $this->db->prepare($query);
            $stmt->execute(array($user_id));
            $projRows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if(!empty($projRows)) {
                return $projRows;
            } else {
                return false;
            }

        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    // Fetch projects with date previous
    public function previousProjects($user_id) {
        try {
            $query = "SELECT * FROM tbl_link as l ";
            $query .= "LEFT JOIN tbl_projects as p on l.proj_id = p.proj_id ";
            $query .= "WHERE user_id = ? AND proj_state = 2 ";
            $query .= "ORDER BY proj_date_end DESC";  
            $stmt = $this->db->prepare($query);
            $stmt->execute(array($user_id));
            $projRows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if(!empty($projRows)) {
                return $projRows;
            } else {
                return false; 
            }

        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    // Deleting member from the project
    public function deleteMember($proj_id, $team_member) {
        try{
            $query  = "DELETE FROM tbl_link ";
            $query .= "WHERE proj_id = ? AND user_id = ?";

            $stmt = $this->db->prepare($query);                     
            $result = $stmt->execute(array($proj_id, $team_member));       
            
            return $result;

        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }
    // Adding tasks to the project
    public function addTasks($new_task, $proj_id) {
        try{
            $query  = "INSERT INTO tbl_todos(todo_task, proj_id) ";
            $query .= "VALUES (?, ?)";
            $stmt  = $this->db->prepare($query);                   
            $result = $stmt->execute(array($new_task, $proj_id));       
            return $result;

        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    // Fetch tasks for the project
    public function singleProjectTasks($proj_id) {
        try {
            $query = "SELECT * FROM tbl_todos ";
            $query .= "WHERE proj_id = ?";
            $stmt = $this->db->prepare($query);
            $stmt->execute(array($proj_id));
            $todosList = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if(!empty($todosList)) {
                return $todosList;
            } else {
                return false;
            }


        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    // Tasks that are unchecked
    public function tasksUnchecked($proj_id) {
        try {
            $query = "SELECT * FROM tbl_todos ";
            $query .= "WHERE proj_id = ? AND todo_state = 0"; 
            $stmt  = $this->db->prepare($query);
            $stmt->execute(array($proj_id));
            $tasksUnchecked = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            if (!empty($tasksUnchecked)) {
               return $tasksUnchecked;
            } else {
                return false;
            }

        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    // Tasks that are checked
    public function tasksChecked($proj_id) {
        try {
            $query = "SELECT * FROM tbl_todos ";
            $query .= "WHERE proj_id = ? AND todo_state = 1"; 
            $stmt  = $this->db->prepare($query);
            $stmt->execute(array($proj_id));
            $tasksChecked = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            if (!empty($tasksChecked)) {
               return $tasksChecked;
            } else {
                return false;
            }

        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    //TODO !!! CHECKED TASKS
    public function checkTasks($task_id) {
        try {

            if (!empty($task_id)) {
                foreach ($task_id as $task_id) {
                    $query = "UPDATE tbl_todos ";
                    $query .= "SET todo_state = 1 "; 
                    $query .= "WHERE todo_id = ?"; 
                    $stmt  = $this->db->prepare($query);
                    $result = $stmt->execute(array($task_id)); 
                }
            }
            return true;


        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    // Deleting task from the project
    public function delTasks($del_task) {
        try{
            $query  = "DELETE FROM tbl_todos ";
            $query .= "WHERE todo_id = ?";
            $stmt  = $this->db->prepare($query);                   
            $result = $stmt->execute(array($del_task));       
            
            return $result;

        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    // // Adding member to the project @TODO
    // public function addMember($proj_id, $team_member) {
    //     try{
    //         $query  = "INSERT INTO tbl_link ";
    //         $query .= "(proj_id, user_id) ";
    //         $query .= "VALUES (?, ?)";
    //         $stmt = $this->db->prepare($query);                     
    //         $result = $stmt->execute(array($proj_id, $team_member));       
            
    //         return $result;

    //     } catch(PDOException $e) {
    //         echo $e->getMessage();
    //     }
    // }


}
?>