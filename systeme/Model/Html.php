<?php


namespace systeme\Model;
#[\AllowDynamicProperties]

class Html
{
    public $data;
    function convertTabToAttribut($tab,$autre_classe="")
    {
        if (is_array($tab)) {
            $str = "";
            if (count($tab) > 0) {
                foreach ($tab as $key => $value) {
                    if($key!="label") {
                        if($key=="class" and $autre_classe!=""){
                            $str .= " {$key}='{$value} $autre_classe'";
                        }else{
                            $str .= " {$key}='{$value}'";
                        }
                    }
                }
                if(!array_key_exists("class",$tab)){
                    $str.=" class='{$autre_classe}'";
                }
                return $str;
            } else {
                return "";
            }
        }
        return "";
    }

    public function br(){
        echo "<br>";
    }

    public function hr(){
        echo "<hr>";
    }

    public function openDiv($atribut=array()){
        echo "<div {$this->convertTabToAttribut($atribut)} >";
    }

    public function label($titre,$attribut=array()){
        echo "<label {$this->convertTabToAttribut($attribut)}>{$titre}</label>";
    }

    public function formSelect($options,$attribut){
        $this->openSelect($attribut,$options);
        $this->closeSelect();
    }

    private function getFormOptions($options=array(),$attribut=array()){

        $opt="";
        if(array_key_exists("name",$attribut)){
            $name=$attribut['name'];
            if(array_key_exists($name,$this->data)){
                $v=$this->data[$name];
                foreach ($options as $key=>$option){
                    if($option['value']==$v){
                        $op=$options[$key];
                        $opt.="<option value='{$op['value']}'>{$op['label']}</option>";
                    }
                }
            }
        }

        if(count($options)>0){
            foreach ($options as $option){
                $opt.="<option value='{$option['value']}'>{$option['label']}</option>";
            }
        }

        return $opt;
    }

    public function openSelect($attribut=array(),$options=array()){
        echo "<select {$this->convertTabToAttribut($attribut)}>{$this->getFormOptions($options,$attribut)}";
    }

    public function closeSelect(){
        echo "</select>";
    }

    public function openOption($value,$label){
        echo "<option value='{$value}'>{$label}";
    }
    public function closeOption(){
        echo "</option>";
    }

    public function formOption($label,$value){
        $this->openOption($value,$label);
        $this->closeOption();
    }

    public function closeDiv(){
        echo "</div>";
    }

    public function formInput($value,$attribut=array(),$checked=false){
        if($checked){
            echo "<input checked='checked' {$value} {$this->convertTabToAttribut($attribut)}>";
        }else{
            echo "<input {$value} {$this->convertTabToAttribut($attribut)}>";
        }

    }

}