<?php

class TemplateGenerator{
    public function __construct(private string $templatesBaseDir= '')
    {
    }

    public function render(string $template, array $params){
        $path =$this->getFullPath($template);

        if(file_exists($path)){
            $content =file_get_contents($path);

            foreach($params as $key => $value){
                $content =preg_replace(sprintf('/{%s}/',$key),$value,$content);
            }
            echo $content;
        }

    }

    private function getFullPath(string $template){
        return $this->templatesBaseDir.$template;
    }
}