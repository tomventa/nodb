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
    /* Check database already exists */
    if (database_exists($dbname)){return "error[database_already_exists]";}
    /* Create the DB Folder into storage */
    mkdir("storage/databases/".$dbname, 0700);
    /* Create the DB File into DB Folder */
    $handle = fopen("storage/databases/".$dbname."/database.db", 'w');
    $default_text = json_encode(array("name"=>$dbname,"tables_structure"=>"","corruption_check"=>"default","tables_number"=>0,"created_timestamp"=>"".microtime(true),"encryption_enabled"=>"$db_encrypted","encryption_password"=>"$db_encrypt_password","permit_write"=>"true","permit_read"=>"true"));
    fwrite($handle, $default_text);
    fclose($handle);
    /* Create the DB Tables file into DB Folder */
    $handle = fopen("storage/databases/".$dbname."/tables.db","w");
    $text = "{}";
    fwrite($handle, $text);
    fclose($handle);
    /* Update dabases.db configuration */
    storage::edit_json_file("storage/databases.db","database_number",false,true,1);
    /* Return true */
    return true;
    
}



/* Check if database exists*/
function database_exists($dbname){
    nodb_databases_config();
    if (file_exists("storage/databases/".$dbname)){
        return true;
    }else{
        return false;
    }
}


/* Get the array config content */
function database_main_content($dbname){
    if (!class_exists("storage")){return "error[storage_class_does_not_exists]";}
    $config_file = storage::read_small_file("storage/databases/".$dbname."/database.db");
    $config_content = json_decode($config_file);
    return $config_content;
}



/* Check write permissions */
function database_permit_write($dbname){
    if (database_exists($dbname)){
        $config = database_main_content($dbname);
        $config_permit_write = $config->permit_write;
        return $config_model;
    }else{
        return "error[db_does_not_exists]";
    }
}



/* Check read permissions */
function database_permit_read($dbname){
    if (database_exists($dbname)){
        $config = database_main_content($dbname);
        $config_permit_write = $config->permit_read;
        return $config_model;
    }else{
        return "error[db_does_not_exists]";
    }
}



/* Check if table exists */
function table_exists($dbname,$tablename){
    /* Check if database exists before checking tables */
    if (!database_exists($dbname)){return false;}
    
    /* Check if file exists */
    if (!file_exists("storage/databases/".$dbname."/table_".$tablename.".db")){
        return false;
    }
    
    /*  Check if table exists in tables list (.db) */
    $tables = storage::read_small_file("storage/databases/".$dbname."/tables.db");
    $tables = json_decode($tables, true);
    if (array_key_exists($tablename, $tables)){
        /* Check if table is not null */
        if (isset($tables[$tablename])){
            return true;
        }
    }
    
    return false;
}



/* Create new table */
function database_new_table($dbname,$tablename,$tabledescription){
    if (database_exists($dbname)){
        if (!table_exists($dbname,$tablename)){
            /* Increment tables number */
            storage::edit_json_file("storage/databases/".$dbname."/database.db","tables_number",false,true,1);
        }else{
            return "error[table_already_exists]";
        }
    }else{
        return "error[db_does_not_exists]";
    }
}


/* NoDB databases.db */
function nodb_databases_config(){
    /* databases.db config */
    if (!file_exists("storage/databases.db")){
        $towrite = json_encode(array("database_number"=>"0","database_list"=>""));
        $file = fopen("storage/databases.db", "w");
        fwrite($file, $towrite);
        fclose($file);
        return true;
    }
}
