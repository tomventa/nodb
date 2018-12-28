<?php

function create_database($dbname,$db_model,$db_user=0,$db_encrypted=false,$db_encrypt_password=0){
    /* 
    * "default": Default DB Model, single file .db, data corruption=total loss
    * "tablesplit": Speed DB model, create as many files ad the tables
    * "columnsplit": Speed DB Model, create as many files as the columns, it requires a lot of disk space
    * "dbsplit": Large DB Model, split the DB in many parts, it requires a lot of reading speed and a lot of ram
    */ 
    
    /* String sanitization */
    $dbname = preg_replace('/[^a-zA-Z0-9\-\_]/', '', $dbname);
    
    if ($db_model==="default" or $db_model=="1"){
        /* Create the DB Folder into storage */
        mkdir("storage/databases/".$dbname, 0700);
        /* Create the DB File into DB Folder */
        $handle = fopen("storage/databases/".$dbname."/database.db", 'w');
        $default_text = json_encode(array("tables_structure","corruption_check"=>"default"));
        fwrite($handle, $default_text);
        fclose($handle);
        /* Create the DB Settings file into DB Folder */
        $handle = fopen("storage/databases/".$dbname."/settings.conf","w");
        $text = json_encode(array("name"=>$dbname,"created_timestamp"=>"".microtime(true)."","model"=>"default","encryption_enabled"=>"$db_encrypted","encryption_password"=>"$db_encrypt_password","permit_write"=>"true","permit_read"=>"true"));
        fwrite($handle, $text);
        fclose($handle);
        /* Todo: cache files */
        /* Return true */
        return true;
        
    }elseif($db_model==="tablesplit" or $db_model=="2"){
        /* Create the DB Folder into storage */
        mkdir("storage/databases/".$dbname);
        /* Create the DB Settings file into DB Folder */
        $handle = fopen("storage/databases/".$dbname."/settings.conf","w");
        $text = json_encode(array("name"=>$dbname,"created_timestamp"=>"".microtime(true)."","model"=>"tablesplit","encryption_enabled"=>"$db_encrypted","encryption_password"=>"$db_encrypt_password","permit_write"=>"true","permit_read"=>"true"));
        fwrite($handle, $text);
        fclose($handle);
        /* Todo: cache files */
        /* Return true */
        return true;
        
    }elseif($db_model==="columnsplit" or $db_model=="3"){
        /* Create the DB Folder into storage */
        mkdir("storage/databases/".$dbname);
        /* Create the DB Settings file into DB Folder */
        $handle = fopen("storage/databases/".$dbname."/settings.conf","w");
        $text = json_encode(array("name"=>$dbname,"created_timestamp"=>"".microtime(true)."","model"=>"tablesplit","encryption_enabled"=>"$db_encrypted","encryption_password"=>"$db_encrypt_password","permit_write"=>"true","permit_read"=>"true"));
        fwrite($handle, $text);
        fclose($handle);
        /* Todo: cache files */
        /* Return true */
        return true;
        
    }elseif($db_model==="dbsplit" or $db_model=="4"){
        /* Create the DB Folder into storage */
        mkdir("storage/databases/".$dbname);
        /* Create the DB Settings file into DB Folder */
        $handle = fopen("storage/databases/".$dbname."/settings.conf","w");
        $text = json_encode(array("name"=>$dbname,"created_timestamp"=>"".microtime(true)."","model"=>"tablesplit","encryption_enabled"=>"$db_encrypted","encryption_password"=>"$db_encrypt_password","permit_write"=>"true","permit_read"=>"true"));
        fwrite($handle, $text);
        fclose($handle);
        /* Todo: cache files */
        /* Return true */
        return true;
    }else{
        return "error[model]";
    }
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
    $config_file = storage::read_small_file("storage/databases/".$dbname."/settings.conf");
    $config_content = json_decode($config_file);
    return $config_content;
}



/* Get the model of a DB */
function database_model($dbname){
    if (database_exists($dbname)){
        $config = database_config_content($dbname);
        $config_model = $config->model;
        return $config_model;
    }else{
        return "error[db_does_not_exists]";
    }
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