<?php


namespace systeme\Model;

class Formulaire extends Html
{
    private $validation;
    function __construct($data = array())
    {
        $this->data = $data;
        $this->validation=true;
    }

    public function open($attribut = array())
    {
        $attribut=$this->convertTabToAttribut($attribut,"was-validated");
        echo "<form {$attribut}>";
    }

    public function close()
    {
        echo "</form>";
    }


    public function input($attribut = array())
    {
        $value="";
        $checked=false;
        if(array_key_exists("name",$attribut)){
            $name=$attribut['name'];
            if(array_key_exists($name,$this->data)){
                $v=$this->data[$name];
                $value="value='{$v}'";
                if(array_key_exists("type",$attribut)){
                    $type=$attribut['type'];
                    if($type=="checkbox"){
                        $checked=true;
                    }

                    if($type=="radio"){
                        if(array_key_exists("value",$attribut)){
                            if($v==$attribut['value']){
                                $checked=true;
                            }
                        }
                    }
                }
            }

        }

        if (array_key_exists("label", $attribut)) {
            $strInput = "
            {$this->openDiv(array("class"=>"form-group"))}
            {$this->label($attribut['label'])}
            {$this->formInput($value,$attribut)}
            {$this->closeDiv()}
            ";
        }else{
            if(array_key_exists("type",$attribut)){
                $type=$attribut['type'];
                if($type=="radio" or $type=="checkbox"){
                    $strInput="{$this->formInput($value,$attribut,$checked)}";
                }else{
                    $strInput="{$this->formInput($value,$attribut)}";
                }
            }else{
                $strInput="{$this->formInput($value,$attribut)}";
            }
        }
        echo $strInput;
    }

    public function select($attribut=array(),$options=array()){
        if (array_key_exists("label", $attribut)) {
            $strInput = "
            {$this->openDiv(['class'=>'form-group'])}
            {$this->label($attribut['label'])}
            {$this->formSelect($options,$attribut)}
            {$this->closeDiv()}
            ";
        }else{
            $strInput="{$this->formSelect($options,$attribut)}";
        }
        echo $strInput;
    }

    /**
     * @return mixed
     */
    public function getValidation()
    {
        return $this->validation;
    }

    /**
     * @param mixed $validation
     */
    public function setValidation($validation)
    {
        $this->validation = $validation;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param array $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }




}