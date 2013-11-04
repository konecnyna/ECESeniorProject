<?php

class log{
    function view_log($user_id, $limit, $error)
    {

        $db = new mysql();
        $view_log_sql = "SELECT log.log_date, members.username, s2.code_desc action_code, s1.code_desc response_code
                FROM log
                LEFT JOIN members ON log.user_id = members.user_id
                LEFT JOIN statusCodes s1 ON log.response_id = s1.code_id
                LEFT JOIN statusCodes s2 ON log.action_id = s2.code_id";

        if($error > 0)$view_log_sql .= " where s1.code_id <> 2 AND s2.code_id <> 2";
        $view_log_sql .= " ORDER BY  `log`.`log_date` DESC LIMIT 0 , $limit";


        //echo $view_log_sql;
        $result = mysql_query($view_log_sql, $db->con);
        $response = "<table border=1 style='border:1px solid black;'>";
        $response .= "<tr><th>Date</th><th>User</th><th>Action</th><th>Response</th></tr>";
        while($row = mysql_fetch_array($result))
        {
            $response .= "<tr><td>".$row['log_date']."</td><td>".$row['username']."</td><td>".$row['action_code']."</td><td>".$row['response_code']."</td></tr>";

        }
        $response .= "</table>";

        $this->insert_log($user_id, 104, 2);
        return $response;
    }

        function insert_log($user_id, $action_id, $response_id){
        $db = new mysql();
        $sql_insert = "INSERT INTO `log` (`user_id`, `action_id`, `response_id`) VALUES ($user_id, $action_id, $response_id);";
        mysql_query($sql_insert, $db->con);
    }
}


?>

