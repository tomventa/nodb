<?php
class storage{
    public function read_small_file($path,$debug_checktime=false){
        if ($debug_checktime){$init_time = microtime(true);}
        $content = file_get_contents($path);
        if ($debug_checktime){
            return (microtime(true)-$init_time)*10000;
        }else{
            return $content;
        }
    }
    
    public function read_large_file($path,$debug_checktime=false){
        $content = implode('',file($path));
        return $content;
    }
    
    public function write_small_file($path,$content,$only_add=false){
        $content = ($only_add)?storage::read_small_file($path).$content:$content;
        $file = fopen($path, "w");
        fwrite($file, $content);
        fclose($file);
        return true;
    }
    
    public function write_large_file($path,$content,$only_add=false){
        $content = ($only_add)?storage::read_small_file($path).$content:$content;
        $file = fopen($path, "w");
        fwrite($file, $content);
        fclose($file);
        return true;
    }
    
    public function edit_small_file($path, $text){
        if (!file_exists($path)){return "error[file_does_not_exists]";}
        write_small_file($path, $text);
    }
    
    public function get_file_size($path,$mb=true){
        /* mb/gb */
        $bytes = filesize($path);
        $megabytes = ($bytes/1024)/1024;
        if ($mb){$output = $megabytes;}else{$output = $megabytes/1024;}
        return $output;
    }
    
    public function assign_small($path){
        $width_gb = storage::get_file_size($path, false);
        $small = 2; /* GB */
        if ($width_gb >= $small){return false;}else{return true;}
    }
    
    public function get_json_file($path,$key,$large=false){
        $text = ($large)? storage::read_large_file($path) : storage::read_small_file($path);
        $text = json_decode($text, true);
        return $text[$key];
    }
    
    public function edit_json_file($path,$key,$value,$large=false,$increment_value=false,$increment_by=1){
        
        $text = ($large)? storage::read_large_file($path) : storage::read_small_file($path);
        $text = json_decode($text, true);
        
        if($increment_value){ 
            $text[$key] += $increment_by;
        }else{
            $text[$key] = $value;
        }
        
        $text = json_encode($text);
        
        if ($large){ 
            return storage::write_large_file($path, $text);
        }else{
            return storage::write_small_file($path, $text);
        }
    }
    
}

?>