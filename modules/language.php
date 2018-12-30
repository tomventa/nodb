<?php
function error_check($text,$get_msg=false){
    /* String lenght check */
    if (strlen($text)<7){return false;}
    if (strlen($text)>128){return false;}
    /* word "error" check */
    $err = mb_substr($text, 0, 5);
    if ($err !== "error"){return false;}
    /* character "[" check */
    $first_bracket = mb_substr($text, 5, 1);
    if ($first_bracket !== "["){return false;}
    /* last character "]" check */
    $last_char = mb_substr($text, -1);
    if ($last_char !== "]"){return false;}
    /* get string into brackets */
    if ($get_msg){
        $msg = mb_substr($text, 6, strlen($text)-6-1);
        return $msg;
    }else{
        return true;
    }
}



function create_database($dbname,$db_user=0,$db_encrypted=false,$db_encrypt_password=0){
    
    /* Create the DB Folder into storage */
    mkdir("storage/databases/".$dbname, 0700);
    /* Create the DB File into DB Folder */
    $handle = fopen("storage/databases/".$dbname."/database.db", 'w');
    $default_text = json_encode(array("tables_structure"=>"","corruption_check"=>"default"));
    fwrite($handle, $default_text);
    fclose($handle);
    /* Create the DB Settings file into DB Folder */
    $handle = fopen("storage/databases/".$dbname."/settings.conf","w");
    $text = json_encode(array("name"=>$dbname,"created_timestamp"=>"".microtime(true),"encryption_enabled"=>"$db_encrypted","encryption_password"=>"$db_encrypt_password","permit_write"=>"true","permit_read"=>"true"));
    fwrite($handle, $text);
    fclose($handle);
    /* Create the DB Tables file into DB Folder */
    $handle = fopen("storage/databases/".$dbname."/tables.db","w");
    $text = json_encode(array("number"=>"0"));
    fwrite($handle, $text);
    fclose($handle);
    /* Todo: cache files */
    /* Return true */
    return true;
    
}



/* Check if database exists*/
function database_exists($dbname){
    if (file_exists("storage/databases/".$dbname)){
        return true;
    }else{
        return false;
    }
}


/* Get the array config content */
function database_config_content($dbname){
    if (!class_exists("storage")){return "error[storage_class_does_not_exists]";}
    $config_file = storage::read_small_file("storage/databases/".$dbname."/settings.conf");
    $config_content = json_decode($config_file);
    return $config_content;
}



/* Check write permissions */
function database_permit_write($dbname){
    if (database_exists($dbname)){
        $config = database_config_content($dbname);
        $config_permit_write = $config->permit_write;
        return $config_model;
    }else{
        return "error[db_does_not_exists]";
    }
}



/* Check read permissions */
function database_permit_read($dbname){
    if (database_exists($dbname)){
        $config = database_config_content($dbname);
        $config_permit_write = $config->permit_read;
        return $config_model;
    }else{
        return "error[db_does_not_exists]";
    }
}



/* Get tables number */
function database_get_table_number($dbname){
    if (database_exists($dbname)){
        $tables_structure = storage::read_small_file("storage/databases/$dbname/tables.db");
        
    }else{
        return "error[db_does_not_exists]";
    }
}



/* Create new table */
function database_new_table($dbname,$tablename,$tabledescription){
    if (database_exists($dbname)){
        
    }else{
        return "error[db_does_not_exists]";
    }
}



