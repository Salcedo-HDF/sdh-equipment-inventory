<?php
require_once('includes/load.php');

/*--------------------------------------------------------------*/
/* Function for find all database table rows by table name
/*--------------------------------------------------------------*/
function find_all($table) {
   global $db;
   if(tableExists($table))
   {
     return find_by_sql("SELECT * FROM ".$db->escape($table));
   }
}
function find_all_media($table, $limit = 0, $offset = 0) {
  global $db;
  if (tableExists($table)) {
      $query = "SELECT * FROM " . $db->escape($table) . " LIMIT {$limit} OFFSET {$offset}";
      return find_by_sql($query);
  }
}
function search_items($search_term) {
  global $db;
  $items_per_page = 20;
  $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
  $limit = $items_per_page;
  $offset = ($current_page - 1) * $items_per_page;

  // Escape the search term
  $search_term = $db->escape($search_term);

  // Improved SQL Query
  $sql = "SELECT p.id, p.name, p.quantity, p.description, p.status, p.action, p.where_found, ";
  $sql .= "p.checkin_by, p.checkin_date, p.checkin_room, p.checkin_location, ";
  $sql .= "p.checkin_location_barcode, p.checkin_item_barcode, p.media_id, c.name AS categorie, ";
  $sql .= "m.file_name AS image ";
  $sql .= "FROM products p ";
  $sql .= "LEFT JOIN categories c ON c.id = p.categorie_id ";
  $sql .= "LEFT JOIN media m ON m.id = p.media_id ";
  $sql .= "WHERE (p.name LIKE '%$search_term%' OR p.description LIKE '%$search_term%') ";
  $sql .= "AND p.action = 'Check In' ";
  $sql .= "ORDER BY p.id DESC ";
  $sql .= "LIMIT {$limit} OFFSET {$offset}";

  return find_by_sql($sql);
}
function count_search_items($search_term) {
  global $db;
  $search_term = $db->escape($search_term);
  
  $sql = "SELECT COUNT(*) AS total FROM products p ";
  $sql .= "WHERE (p.name LIKE '%$search_term%' OR p.description LIKE '%$search_term%') ";
  $sql .= "AND p.action = 'Check In'";
  
  $result = find_by_sql($sql);
  return $result[0];  // Return the total count
}
// Count total items with optional search
function count_items($search_term = null) {
  global $db;
  $sql = "SELECT COUNT(*) AS total FROM products p WHERE p.action = 'Check In'";
  
  if ($search_term) {
      $search_term = $db->escape($search_term);
      $sql .= " AND (p.name LIKE '%$search_term%' OR p.description LIKE '%$search_term%')";
  }
  
  $result = find_by_sql($sql);
  return $result[0]['total'];
}

// Fetch paginated products with optional search
function get_paginated_products($items_per_page, $offset, $search_term = null) {
  global $db;
  
  $sql = "SELECT p.id, p.name, p.quantity, p.description, p.status, p.where_found, 
                 p.checkin_by, p.checkin_date, p.checkin_room, p.checkin_location, 
                 p.checkin_location_barcode, p.checkin_item_barcode, p.media_id, c.name AS categorie, m.file_name AS image 
          FROM products p
          LEFT JOIN categories c ON c.id = p.categorie_id 
          LEFT JOIN media m ON m.id = p.media_id 
          WHERE p.action = 'Check In'";
  
  if ($search_term) {
      $search_term = $db->escape($search_term);
      $sql .= " AND (p.name LIKE '%$search_term%' OR p.description LIKE '%$search_term%')";
  }
  
  $sql .= " ORDER BY p.id DESC LIMIT {$items_per_page} OFFSET {$offset}";
  
  return find_by_sql($sql);
}
function search_checkout_items($search_term) {
  global $db;
  $items_per_page = 10;
  $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
  $limit = $items_per_page;
  $offset = ($current_page - 1) * $items_per_page;
  $search_term = $db->escape($search_term);  // Ensure search term is escaped
  
  $sql  = "SELECT p.id, p.name, p.description, p.status, p.where_found, p.checkin_by, ";
  $sql .= "p.checkin_date, p.checkin_room, p.checkin_location, p.checkin_location_barcode, ";
  $sql .= "p.checkin_item_barcode, p.comments, p.media_id, p.date, ";
  $sql .= "c.checkout_by, c.checkout_date, c.quantity, c.due_back_date, c.comments, ";
  $sql .= "q.name AS categorie, m.file_name AS image ";
  $sql .= "FROM check_out c ";
  $sql .= "LEFT JOIN products p ON c.item_id = p.id ";
  $sql .= "LEFT JOIN categories q ON q.id = p.categorie_id ";
  $sql .= "LEFT JOIN media m ON m.id = p.media_id ";
  $sql .= "WHERE p.name LIKE '%{$search_term}%' OR c.checkout_by LIKE '%{$search_term}%' ";
  $sql .= "ORDER BY p.id DESC ";
  $sql .= "LIMIT {$limit} OFFSET {$offset}";
  
  return find_by_sql($sql);
}
function search_user($search_term, $items_per_page = 2, $current_page = 1) {
  global $db;
  $search_term = $db->escape($search_term);
  $offset = ($current_page - 1) * $items_per_page;
  
  $sql  = "SELECT name, user_level, image, last_login ";
  $sql .= "FROM users ";
  $sql .= "WHERE (name LIKE '%$search_term%') "; 
  $sql .= "ORDER BY last_login DESC ";
  $sql .= "LIMIT $items_per_page OFFSET $offset";  // Apply LIMIT and OFFSET for pagination
  
  return find_by_sql($sql);
}
function search_logs($search_term) {
  global $db;
  $items_per_page = 20;
  $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
  $limit = $items_per_page;
  $offset = ($current_page - 1) * $items_per_page;

  // Escape the search term to prevent SQL injection
  $search_term = $db->escape($search_term);

  $sql  = "SELECT l.id, l.action, l.user, l.quantity, l.action_date, p.name, p.media_id, ";
  $sql .= "m.file_name AS image ";
  $sql .= "FROM logs l ";
  $sql .= "LEFT JOIN products p ON l.item_id = p.id ";
  $sql .= "LEFT JOIN media m ON m.id = p.media_id ";
  $sql .= "WHERE p.name LIKE '%{$search_term}%' OR l.user LIKE '%{$search_term}%' ";
  $sql .= "ORDER BY l.action_date DESC ";  // Add a space before the next clause
  $sql .= "LIMIT {$limit} OFFSET {$offset}";

  return find_by_sql($sql);
}
/*--------------------------------------------------------------*/
/* Function for Perform queries
/*--------------------------------------------------------------*/
function find_by_sql($sql)
{
  global $db;
  $result = $db->query($sql);
  $result_set = $db->while_loop($result);
 return $result_set;
}
/*--------------------------------------------------------------*/
/*  Function for Find data from table by id
/*--------------------------------------------------------------*/
function find_by_id($table,$id)
{    
  global $db;
  $id = (int)$id;
    if(tableExists($table)){
          $sql = $db->query("SELECT * FROM {$db->escape($table)} WHERE id='{$db->escape($id)}' LIMIT 1");
          if($result = $db->fetch_assoc($sql))
            return $result;
          else
            return null;
     }
}
/*--------------------------------------------------------------*/
/* Function for Delete data from table by id
/*--------------------------------------------------------------*/
function delete_by_id($table,$id)
{
  global $db;
  if(tableExists($table))
   {
    $sql = "DELETE FROM ".$db->escape($table);
    $sql .= " WHERE id=". $db->escape($id);
    $sql .= " LIMIT 1";
    $db->query($sql);
    return ($db->affected_rows() === 1) ? true : false;
   }
}
/*--------------------------------------------------------------*/
/* Function for Count id  By table name
/*--------------------------------------------------------------*/

function count_by_id($table){
  global $db;
  if(tableExists($table))
  {
    $sql    = "SELECT COUNT(id) AS total FROM ".$db->escape($table);
    $result = $db->query($sql);
     return($db->fetch_assoc($result));
  }
}
/*--------------------------------------------------------------*/
/* Determine if database table exists
/*--------------------------------------------------------------*/
function tableExists($table){
  global $db;
  $table_exit = $db->query('SHOW TABLES FROM '.DB_NAME.' LIKE "'.$db->escape($table).'"');
      if($table_exit) {
        if($db->num_rows($table_exit) > 0)
              return true;
         else
              return false;
      }
  }
 /*--------------------------------------------------------------*/
 /* Login with the data provided in $_POST,
 /* coming from the login form.
/*--------------------------------------------------------------*/
  function authenticate($username='', $password='') {
    global $db;
    $username = $db->escape($username);
    $password = $db->escape($password);
    $sql  = sprintf("SELECT id,username,password,user_level FROM users WHERE username ='%s' LIMIT 1", $username);
    $result = $db->query($sql);
    if($db->num_rows($result)){
      $user = $db->fetch_assoc($result);
      $password_request = sha1($password);
      if($password_request === $user['password'] ){
        return $user['id'];
      }
    }
   return false;
  }
  /*--------------------------------------------------------------*/
  /* Login with the data provided in $_POST,
  /* coming from the login_v2.php form.
  /* If you used this method then remove authenticate function.
 /*--------------------------------------------------------------*/
   function authenticate_v2($username='', $password='') {
     global $db;
     $username = $db->escape($username);
     $password = $db->escape($password);
     $sql  = sprintf("SELECT id,username,password,user_level FROM users WHERE username ='%s' LIMIT 1", $username);
     $result = $db->query($sql);
     if($db->num_rows($result)){
       $user = $db->fetch_assoc($result);
       $password_request = sha1($password);
       if($password_request === $user['password'] ){
         return $user;
       }
     }
    return false;
   }


  /*--------------------------------------------------------------*/
  /* Find current log in user by session id
  /*--------------------------------------------------------------*/
  function current_user(){
      static $current_user;
      global $db;
      if(!$current_user){
         if(isset($_SESSION['user_id'])):
             $user_id = intval($_SESSION['user_id']);
             $current_user = find_by_id('users',$user_id);
        endif;
      }
    return $current_user;
  }
  /*--------------------------------------------------------------*/
  /* Find all user by
  /* Joining users table and user gropus table
  /*--------------------------------------------------------------*/
  function find_all_user(){
      global $db;
      $results = array();
      $sql = "SELECT u.id,u.name,u.username,u.user_level,u.status,u.last_login,";
      $sql .="g.group_name ";
      $sql .="FROM users u ";
      $sql .="LEFT JOIN user_groups g ";
      $sql .="ON g.group_level=u.user_level ORDER BY u.name ASC";
      $result = find_by_sql($sql);
      return $result;
  }
  /*--------------------------------------------------------------*/
  /* Function to update the last log in of a user
  /*--------------------------------------------------------------*/

 function updateLastLogIn($user_id)
	{
		global $db;
    $date = make_date();
    $sql = "UPDATE users SET last_login='{$date}' WHERE id ='{$user_id}' LIMIT 1";
    $result = $db->query($sql);
    return ($result && $db->affected_rows() === 1 ? true : false);
	}

  /*--------------------------------------------------------------*/
  /* Find all Group name
  /*--------------------------------------------------------------*/
  function find_by_groupName($val)
  {
    global $db;
    $sql = "SELECT group_name FROM user_groups WHERE group_name = '{$db->escape($val)}' LIMIT 1 ";
    $result = $db->query($sql);
    return($db->num_rows($result) === 0 ? true : false);
  }
  /*--------------------------------------------------------------*/
  /* Find group level and return group status
  /*--------------------------------------------------------------*/
  function find_by_groupLevel($level)
  {
      global $db;
      $sql = "SELECT group_status FROM user_groups WHERE group_level = '{$db->escape($level)}' LIMIT 1";
      $result = $db->query($sql);
      // Ensure we fetch the result if it exists
      return $db->fetch_assoc($result);
  }

  /*--------------------------------------------------------------*/
  /* Function for checking which user level has access to page    */
  /*--------------------------------------------------------------*/
  function page_require_level($require_level) {
    global $session;

    // Check if user is logged in
    if (!$session->isUserLoggedIn(true)) {
        $session->msg('d', 'Please login...');
        redirect('index.php', false);
    }

    // If logged in, retrieve current user and login level
    $current_user = current_user();
    $login_level = find_by_groupLevel($current_user['user_level']);

    // Check if group status is inactive (banned)
    if ($login_level['group_status'] === '0') {
        $session->msg('d', 'This level user has been banned!');
        redirect('home.php', false);
    }

    // Check if logged-in user's level is less than or equal to required level
    if ($current_user['user_level'] <= (int)$require_level) {
        return true;
    } else {
        $session->msg("d", "Sorry! You don't have permission to view the page.");
        redirect('home.php', false);
    }
  }
   /*--------------------------------------------------------------*/
   /* Function for Finding all product name
   /* JOIN with categorie  and media database table
   /*--------------------------------------------------------------*/
   function join_product_table() {
      global $db;
      $items_per_page = 20;
      $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
      $limit = $items_per_page;
      $offset = ($current_page - 1) * $items_per_page;

      $sql  = "SELECT p.id, p.name, p.quantity, p.description, p.status, p.where_found, 
                      p.checkin_by, p.checkin_date, p.checkin_room, p.checkin_location, 
                      p.checkin_location_barcode, p.checkin_item_barcode, p.comments, 
                      p.media_id, p.date, c.name AS categorie, m.file_name AS image ";
      $sql .= "FROM products p ";
      $sql .= "LEFT JOIN categories c ON c.id = p.categorie_id ";
      $sql .= "LEFT JOIN media m ON m.id = p.media_id ";
      $sql .= "WHERE p.action = 'Check In' ";
      $sql .= "ORDER BY p.id DESC ";
      $sql .= "LIMIT {$limit} OFFSET {$offset}";

      return find_by_sql($sql);
  }
  function count_checkout($search_term = null) {
    global $db;
    $sql = "SELECT COUNT(*) AS total FROM check_out c ";
    if ($search_term) {
      $search_term = $db->escape($search_term);
      $sql .= "WHERE c.checkout_by LIKE '%{$search_term}%' ";
    }
    $result = find_by_sql($sql);
    return $result[0]['total'];  // Return the total count
  }
  function join_checkout_table($items_per_page, $offset, $search_term = null) {
      global $db;
      
      $sql = "SELECT p.id, p.name, p.description, p.status, p.where_found, 
                    p.checkin_by, p.checkin_date, p.checkin_room, p.checkin_location, 
                    p.checkin_location_barcode, p.checkin_item_barcode, p.comments, 
                    p.media_id, p.date, 
                    c.checkout_by, c.checkout_date, c.quantity, c.due_back_date, c.comments, 
                    q.name AS categorie, m.file_name AS image 
              FROM check_out c 
              LEFT JOIN products p ON c.item_id = p.id 
              LEFT JOIN categories q ON q.id = p.categorie_id 
              LEFT JOIN media m ON m.id = p.media_id";
      
      if ($search_term) {
          $search_term = $db->escape($search_term);
          $sql .= " WHERE p.name LIKE '%$search_term%' OR c.checkout_by LIKE '%$search_term%'";
      }
    
      $sql .= " ORDER BY c.checkout_date DESC LIMIT {$items_per_page} OFFSET {$offset}";
      
      return find_by_sql($sql);
  }  
  function user_table($items_per_page = 10, $current_page = 1) {
      global $db;
      $offset = ($current_page - 1) * $items_per_page;

      $sql  = "SELECT name, user_level, image, last_login ";
      $sql .= "FROM users ";
      $sql .= "ORDER BY last_login DESC ";
      $sql .= "LIMIT $items_per_page OFFSET $offset";  // Apply LIMIT and OFFSET for pagination

      return find_by_sql($sql);
  }
  function count_logs($search_term) {
    global $db;
    $search_term = $db->escape($search_term);
  
    $sql  = "SELECT COUNT(*) AS total ";
    $sql .= "FROM logs l ";
    $sql .= "LEFT JOIN products p ON l.item_id = p.id ";
    $sql .= "WHERE p.name LIKE '%{$search_term}%' OR l.user LIKE '%{$search_term}%'";
  
    $result = find_by_sql($sql);
    return $result[0]; // Return the total count from the query result
  }
  function count_log($search_term = null) {
    global $db;
    $sql = "SELECT COUNT(*) AS total FROM logs l LEFT JOIN products p ON l.item_id = p.id";
    
    if ($search_term) {
        $search_term = $db->escape($search_term);
        $sql .= " WHERE (p.name LIKE '%$search_term%' OR l.user LIKE '%$search_term%')";
    }
    
    $result = find_by_sql($sql);
    return $result[0]['total'];
  }
  function join_logs_table($items_per_page, $offset, $search_term = null) {
    global $db;
    
    $sql  = "SELECT l.id, l.action, l.user, l.quantity, l.action_date, l.comments, p.name, p.description, p.media_id, ";
    $sql .= "m.file_name AS image ";
    $sql .= "FROM logs l ";
    $sql .= "LEFT JOIN products p ON l.item_id = p.id ";
    $sql .= "LEFT JOIN media m ON m.id = p.media_id ";
    
    if ($search_term) {
        $search_term = $db->escape($search_term);
        $sql .= " WHERE (p.name LIKE '%$search_term%' OR l.user LIKE '%$search_term%')";
    }
    
    $sql .= " ORDER BY l.action_date DESC LIMIT {$items_per_page} OFFSET {$offset}";
    
    return find_by_sql($sql);
  }
  /*--------------------------------------------------------------*/
  /* Function for Finding all product name
  /* Request coming from ajax.php for auto suggest
  /*--------------------------------------------------------------*/

   function find_product_by_title($product_name){
     global $db;
     $p_name = remove_junk($db->escape($product_name));
     $sql = "SELECT name FROM products WHERE name like '%$p_name%' LIMIT 5";
     $result = find_by_sql($sql);
     return $result;
   }

  /*--------------------------------------------------------------*/
  /* Function for Finding all product info by product title
  /* Request coming from ajax.php
  /*--------------------------------------------------------------*/
  function find_all_product_info_by_title($title){
    global $db;
    $sql  = "SELECT * FROM products ";
    $sql .= " WHERE name ='{$title}'";
    $sql .=" LIMIT 1";
    return find_by_sql($sql);
  }

  /*--------------------------------------------------------------*/
  /* Function for Update product quantity
  /*--------------------------------------------------------------*/
  function update_product_qty($qty,$p_id){
    global $db;
    $qty = (int) $qty;
    $id  = (int)$p_id;
    $sql = "UPDATE products SET quantity=quantity -'{$qty}' WHERE id = '{$id}'";
    $result = $db->query($sql);
    return($db->affected_rows() === 1 ? true : false);

  }
  /*--------------------------------------------------------------*/
  /* Function for Display Recent product Added
  /*--------------------------------------------------------------*/
 function find_recent_product_added($limit){
   global $db;
   $sql   = " SELECT p.id,p.name,p.media_id,c.name AS categorie,";
   $sql  .= "m.file_name AS image FROM products p";
   $sql  .= " LEFT JOIN categories c ON c.id = p.categorie_id";
   $sql  .= " LEFT JOIN media m ON m.id = p.media_id";
   $sql  .= " ORDER BY p.id DESC LIMIT ".$db->escape((int)$limit);
   return find_by_sql($sql);
 }
 // Fetch paginated requests with optional search
function join_request($items_per_page, $offset, $search_term = null) {
  global $db;
  
  $sql = "SELECT r.id, r.item_id, r.request_by, r.quantity, r.dueback_date, r.comments, r.date_request,
                 p.name, p.media_id, m.file_name AS image
          FROM requests r
          LEFT JOIN products p ON p.id = r.item_id  
          LEFT JOIN media m ON m.id = p.media_id
          WHERE r.action = 'Request'";
  
  if ($search_term) {
      $search_term = $db->escape($search_term);
      $sql .= " AND (p.name LIKE '%$search_term%' OR r.request_by LIKE '%$search_term%')";
  }
  
  $sql .= " ORDER BY r.date_request DESC LIMIT {$items_per_page} OFFSET {$offset}";
  
  return find_by_sql($sql);
}
// Count total request with optional search
function count_request($search_term = null) {
  global $db;
  $sql = "SELECT COUNT(*) AS total FROM requests r LEFT JOIN products p ON p.id = r.item_id
          WHERE r.action = 'Request'";
  
  if ($search_term) {
      $search_term = $db->escape($search_term);
      $sql .= " AND (p.name LIKE '%$search_term%' OR r.request_by LIKE '%$search_term%')";
  }
  
  $result = find_by_sql($sql);
  return $result[0]['total'];
}
function join_requests_log($items_per_page, $offset, $search_term = null) {
  global $db;
  
  $sql  = "SELECT r.id, r.item_id, r.action, r.request_by, r.quantity, r.date_request, p.name, p.media_id, ";
  $sql .= "m.file_name AS image ";
  $sql .= "FROM requests_log r ";
  $sql .= "LEFT JOIN products p ON r.item_id = p.id ";
  $sql .= "LEFT JOIN media m ON m.id = p.media_id ";
  
  if ($search_term) {
      $search_term = $db->escape($search_term);
      $sql .= " WHERE (p.name LIKE '%$search_term%' OR r.request_by LIKE '%$search_term%')";
  }
  
  $sql .= " ORDER BY r.date_request DESC LIMIT {$items_per_page} OFFSET {$offset}";
  
  return find_by_sql($sql);
}
function count_requests_log($search_term = null) {
  global $db;
  $sql = "SELECT COUNT(*) AS total FROM requests_log r LEFT JOIN products p ON r.item_id = p.id";
  
  if ($search_term) {
      $search_term = $db->escape($search_term);
      $sql .= " WHERE (p.name LIKE '%$search_term%' OR r.request_by LIKE '%$search_term%')";
  }
  
  $result = find_by_sql($sql);
  return $result[0]['total'];
}
// Count total in & out
function count_inOut($search_term = null) {
  global $db;
  $sql = "SELECT COUNT(*) AS total FROM inout_logs i LEFT JOIN users u ON i.user_id = u.id";
  
  if ($search_term) {
      $search_term = $db->escape($search_term);
      $sql .= " WHERE (u.name LIKE '%$search_term%' OR i.action LIKE '%$search_term%')";
  }
  
  $result = find_by_sql($sql);
  return $result[0]['total'];
}
function join_inOutlogs($items_per_page, $offset, $search_term = null) {
  global $db;
  
  $sql = "SELECT i.id, i.date, i.action, u.name, u.image 
          FROM inout_logs i
          LEFT JOIN users u ON u.id = i.user_id";
  
  if ($search_term) {
      $search_term = $db->escape($search_term);
      $sql .= " WHERE (u.name LIKE '%$search_term%' OR i.action LIKE '%$search_term%')";
  }
  
  $sql .= " ORDER BY i.date DESC LIMIT {$items_per_page} OFFSET {$offset}";
  
  return find_by_sql($sql);
}
function count_total_users($search_term = '') {
  global $db;

  // Escape only if there is a search term
  if ($search_term !== '') {
      $search_term = $db->escape($search_term);
  }

  // Build SQL query based on search term
  $sql = "SELECT COUNT(*) as total FROM users";
  if ($search_term !== '') {
      $sql .= " WHERE name LIKE '%$search_term%'";
  }

  $result = find_by_sql($sql);
  return $result[0]['total'];
}
function get_paginated_employee($items_per_page, $offset, $search_term = null) {
  global $db;
  
  $sql = "SELECT * FROM employee";
  
  if ($search_term) {
      $search_term = $db->escape($search_term);
      $sql .= " WHERE (name LIKE '%$search_term%')";
  }
  
  $sql .= " ORDER BY id DESC LIMIT {$items_per_page} OFFSET {$offset}";
  
  return find_by_sql($sql);
}
function count_employee($search_term = null) {
  global $db;
  $sql = "SELECT COUNT(*) AS total FROM employee";
  
  if ($search_term) {
      $search_term = $db->escape($search_term);
      $sql .= " WHERE (name LIKE '%$search_term%')";
  }
  
  $result = find_by_sql($sql);
  return $result[0]['total'];
}
?>
