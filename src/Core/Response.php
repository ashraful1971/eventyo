<?php

namespace App\Core;

class Response {

    public function __construct(string $url = null)
    {
        if($url){
            header('Location: ' . url($url));
        }

        exit;
    }
    
    /**
     * Send json response to the client
     *
     * @param array $data
     * @return self
     */
    public static function json(array $data, int $code = 200): self
    {
        header('Content-Type: application/json');
        http_response_code($code);
        
        echo json_encode($data);
        return new self();
    }
    
    /**
     * Send the html view file as a response
     *
     * @param string $file
     * @param array $data
     * @return self
     */
    public static function view(string $file, array $data=[]): self
    {
        header('Content-Type: text/html');
        require_once VIEW_PATH.'/'.$file.'.php';
        return new self();
    }
    
    /**
     * Redirect the user to the specified link
     *
     * @param string $url
     * @return self
     */
    public static function redirect(string $url): self
    {
        return new static($url);
    }
}