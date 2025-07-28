<?php

class Format{
    public function formatDate ($data)
    {
        return date ("M d, Y", strtotime($data));
    }
    public function validation($data)
    {   
        $data = trim($data);
        $data = stripslashes($data);
        return $data;
    }

    public function textShorten($text, $limit=400){
        $text = $text. ' ';
        $text = substr($text, 0, $limit);
        $text = $text . '....';
        return $text;
    }
}

?>