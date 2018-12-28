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
        $content = ($only_add)?read_small_file($path).$content:$content;
        $file = fopen($path, "w");
        fwrite($file, $content);
        fclose($file);
    }
    
    public function write_large_file($path,$content,$only_add=false){
        $content = ($only_add)?read_small_file($path).$content:$content;
        $file = fopen($path, "w");
        fwrite($file, $content);
        fclose($file);
    }
    
}

?>