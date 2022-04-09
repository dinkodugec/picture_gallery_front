<?php

class Db_object
{
    protected static $db_table = "users";

    public $upload_errors_arrays = array(

        UPLOAD_ERR_OK => "There is no error.",
        UPLOAD_ERR_INI_SIZE => "The upload file exceeds the upload_max_filesize directive.",
        UPLOAD_ERR_FORM_SIZE => "The upload file exceeds the upload_max_filesize directive.",
        UPLOAD_ERR_PARTIAL => "The upload file was only partially loaded",
        UPLOAD_ERR_NO_FILE => "No file was uploaded.",
        UPLOAD_ERR_NO_TMP_DIR => "Missing temporary folder.",
        UPLOAD_ERR_CANT_WRITE => "Failed to write file to disk.",
        UPLOAD_ERR_EXTENSION => "A PHP extension stopped the file upload."
    );

    public function set_file($file)
    //basename() Return user_image from the specified path:
  {
       if(empty($file) || !$file || !is_array($file)){
           $this->errors[] = "There was not file uploaded here";
           return false;
       }elseif($file['error'] !=0){
           $this->errors[] = $this->upload_errors_array[$file['error']];
          return false;
       }else{
          $this->user_image = basename($file['name']);
          $this->tmp_path = $file['tmp_name'];
          $this->type = $file['type'];
          $this->size = $file['size'];
       }

  }


    public static function find_all()
   
    {
       return static::find_by_query("SELECT * From "  . static::$db_table . " ");
    }

   
   
    public static function find_by_id($id)
   
    {
        global $database;
        /* $result_set = $database->query("SELECT * FROM users WHERE id = $id"); */
        $the_result_array = static::find_by_query("SELECT * From "  . static::$db_table . " WHERE id = $id");

        return !empty($the_result_array) ? array_shift($the_result_array) : false;   

    }

    
    public static function find_by_query($sql)
    {
        global $database;
        $result_set = $database->query($sql);
        $the_object_array = array(); /*   put empty array to get objects in there */
        while($row = mysqli_fetch_array($result_set)){
            $the_object_array[] = static::instantation($row);
        }
        return $the_object_array;
    }


    public static function instantation($the_record) // the record from database
    {
         $calling_class = get_called_class();

         $the_object= new $calling_class;
         /*
        $the_object->id = $found_user['id'];
        $the_object->username = $found_user['username'];
        $the_object->password = $found_user['password'];
        $the_object->first_name = $found_user['first_name'];
        $the_object->last_name = $found_user['last_name'];
 */
     foreach($the_record as $the_attribute=>$value){                 /* loops through this table, we get key and value out */
         if($the_object->has_the_attribute($the_attribute)){
            $the_object->$the_attribute = $value;
         }
     }
     return $the_object;
    }

    private function has_the_attribute($the_attribute)
    {
        $object_properties =  get_object_vars($this);   /*  get_object_vars - built-in function used to get properties of given object */
        return array_key_exists($the_attribute, $object_properties);  /* The array_key_exists() function checks an array for a specified key, and returns true if the key exists and false if the key does not exist. */
    }

    public function properties()
     {
        /* return get_object_vars($this); */  //give us back all object properties
        $properties = array();
        foreach(static::$db_table_fields as $db_field){
            if(property_exists($this,$db_field)){
                $properties[$db_field] = $this->$db_field;
            }
        } return $properties;
     }

    protected function clean_properties()
     {
        global $database;

        $clean_properties = array();

        foreach($this->properties() as $key=>$value){
            $clean_properties[$key] = $database->escape_string($value);
        }
          return $clean_properties;
     }

    
    
    public function save()
    {
         
       return isset($this->id) ? $this->update() : $this->create();

    }


    public function create()
    {
        global $database;

        $properties = $this->clean_properties();
       
        $sql = "INSERT INTO " .static::$db_table . "(" . implode(",",array_keys($properties))           . ")";
        $sql .= "VALUES('" .  implode("','",array_values($properties)) . "')";


        if($database->query($sql)){
   
                 $this->id = $database->the_insert_id();
                return true;
        }else{
               return false;
        }
        
    } /* finish create method here */


    public function update()
    {
        global $database;
        
        $properties = $this->clean_properties();
        $properties_pairs = array();
        foreach($properties as $key => $value){
            $properties_pairs[] = "{$key}='{$value}'";
        }

        $sql = "UPDATE " .static::$db_table . " SET ";
        $sql .= implode(", ", $properties_pairs);
        $sql .= " WHERE id= " . $database->escape_string($this->id);

        $database->query($sql);

        return (mysqli_affected_rows($database->connection) ==1) ? true : false;
    }    //end update method
    

    
    public function delete()
    {
        global $database;

        $sql = "DELETE FROM " .static::$db_table . " ";
        $sql .= "WHERE id=" . $database->escape_string($this->id);
        $sql .= " LIMIT 1";

        $database->query($sql);

        return (mysqli_affected_rows($database->connection) ==1) ? true : false;

    }

    public static function count_all()
    {
        global $database;

       $sql = "SELECT count(*) FROM " . static::$db_table;
       $result_set = $database->query($sql);
       $row = mysqli_fetch_array( $result_set);

       return array_shift($row);
    }

    



}  




    
    









?>