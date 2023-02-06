<?php
    class invalidFileException extends Exception {
        public function errorMessage() {
            return "File not found.";
        }
    }
    
    try {
        if (!isset($_GET['rqd'])) 
            throw new Exception("Internal error");

        // Should at least be '/file/[uuid]', thus 41 characters long.
        if (strlen($_GET['rqd']) < 41)
            throw new invalidFileException();
        
        $rqd = explode('/', substr($_GET['rqd'], 5));
        
        if (strlen($rqd[0]) != 36)
            throw new invalidFileException();

        $file = "uploads/$rqd[0]";
        $type = mime_content_type($file);
        $size = filesize($file);
        $time = date(DATE_RFC2822, filemtime($file));

        header("Content-Type: $type");
        header("Content-Disposition: inline;" . (sizeof($rqd) > 1 ? "filename=basename($rqd[1])" : ""));
        header("Content-Length: $size");
        readfile($file);
    } catch (invalidFileException $e) {
        http_response_code(404);
        die();
    }
    
?>