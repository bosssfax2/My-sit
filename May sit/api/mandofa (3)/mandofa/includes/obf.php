<?php
class TextObfuscator {
    private static $instance = null;
    private $wordsToObfuscate = [];
    
    // Singleton pattern to ensure we only have one instance
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new TextObfuscator();
        }
        return self::$instance;
    }
    
    public function isSpace($ltr){
        return preg_match('/\s+/', $ltr);
    }
    
    public function isValidLetter($ltr){
        return preg_match('/^[\w\.]+$/', $ltr);
    }
    
    public function getCrypt(){
        return '<span style="padding:0 !important; margin:0 !important; display:inline-block !important; width:0 !important; height:0 !important; font-size:0 !important;">'.substr(md5(uniqid()),0,1).'</span>';
    }
    
    public function obf($str){
        $text = "";
        $str = str_replace("|", "", $str);
        $strarr = str_split($str);
        foreach($strarr as $letter){
            if($this->isSpace($letter)){
                $text .= " ";
            }
            if($this->isValidLetter($letter)){
                $text .= $this->getCrypt().$letter.$this->getCrypt();
            }else{
                $text .= $letter;
            }
        }
        return $text;
    }
    
    // Add words you want to obfuscate
    public function addWord($word) {
        $this->wordsToObfuscate[] = $word;
        return $this;
    }
    
    // Add multiple words at once
    public function addWords($words) {
        if (is_array($words)) {
            $this->wordsToObfuscate = array_merge($this->wordsToObfuscate, $words);
        }
        return $this;
    }
    
    // Process content and obfuscate all added words
    public function process($content) {
        foreach ($this->wordsToObfuscate as $word) {
            $obfuscated = $this->obf($word);
            $content = str_replace($word, $obfuscated, $content);
        }
        return $content;
    }
    
    // Output buffer callback to process entire page
    public static function obfuscateOutput($buffer) {
        return self::getInstance()->process($buffer);
    }
}
$obfuscator = TextObfuscator::getInstance();
$obfuscator->addWords(["spotify", "Spotify", "Personal details"]);
?>