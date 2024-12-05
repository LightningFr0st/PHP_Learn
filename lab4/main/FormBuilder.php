<?php

abstract class FormBuilder
{

    public array $allParams;
    public string $file_content;

    public string $METHOD;

    abstract public function checkGLOBAL(string $method_type, string $name): string;

    public function __construct(string $file_p, string $method, string $target, string $value = 'Submit')
    {
        $this->file_content = $file_p;
        $this->allParams['method'] = $method;
        $this->METHOD = $method;
        $this->allParams['target'] = $target;
        $this->allParams['value'] = $value;
        $this->allParams['insert'] = '';
    }

    public function generateString(string $template, array $params): string
    {
        foreach ($params as $key => $value) {
            $template = preg_replace(sprintf('/{%s}/', $key), $value, $template);
        }
        return $template;
    }

    public function addTextField(string $name, string $default): void
    {
        $params = array();
        $temp = "<input style = \"margin-bottom: 10px\" type=\"text\" name=\"{name}\" value=\"{default}\" />";
        $params['name'] = $name;
        $res = $this->checkGLOBAL($this->METHOD, $name);
        if ($res != '') {
            $params['default'] = $res;
        }else{
            $params['default'] = $default;
        }
        $this->allParams['insert'] .= "<div>";
        $this->allParams['insert'] .= $this->generateString($temp, $params);
        $this->allParams['insert'] .= "</div>";
    }

    public function addRadioGroup(string $name, array $values): void
    {
        $params = array();
        $temp = "<input type=\"radio\" name=\"{name}\" value=\"{value}\" /> <label for=\"{name}}\">{value}</label>";
        $params['name'] = $name;
        $this->allParams['insert'] .= "<div>";
        foreach ($values as $value) {
            $params['value'] = $value;
            $this->allParams['insert'] .= $this->generateString($temp, $params);
        }
        $this->allParams['insert'] .= "</div>";
    }

    public function render(): void
    {
        foreach ($this->allParams as $key => $value) {
            $this->file_content = preg_replace(sprintf('/{%s}/', $key), $value, $this->file_content);
        }
        echo $this->file_content;

    }

}