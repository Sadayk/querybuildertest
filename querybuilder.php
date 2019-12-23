<?php
abstract class query{

}
class selectclass extends query{
    protected $tablename;
    protected $fields;
    protected $condition;
    protected $limit;
    protected $group;
    function table($tableinput){
        $this->tablename=$tableinput;
        return $this;
    }
    function select($fieldsinput){
        $this->fields=$fieldsinput;
        return $this;
    }
    function where($conditioninput){
        $this->condition=$conditioninput;
        return $this;
    }
    function limit($limitinput){
        $this->limit=$limitinput;
        return $this;
    }
    function group($groupfield){
        $this->group=$groupfield;
        return $this;
    }
    function getQuery(){
        $sqlstring="SELECT ";
        if(isset($this->fields)) $sqlstring=$sqlstring.$this->fields; else $sqlstring=$sqlstring."*";
        if(isset($this->tablename)) $sqlstring=$sqlstring." FROM ".$this->tablename;
        if(isset($this->condition)) $sqlstring=$sqlstring." WHERE ".$this->condition;
        if(isset($this->group)) $sqlstring=$sqlstring." GROUP BY ".$this->group;
        if(isset($this->order)) $sqlstring=$sqlstring." ORDER BY ".$this->order;
        if(isset($this->limit)) $sqlstring=$sqlstring." LIMIT  ".$this->LIMIT;
        echo $sqlstring;
        return $sqlstring;
    }

}
class insertclass extends query{
    protected $tablename;
    protected $fields;
    protected $values;
    function table($tableinput){
        $this->tablename=$tableinput;
        return $this;
    }
    function field($fieldsinput){
        $this->fields=$fieldsinput;
        return $this;
    }
    function valuesin($valuesinput){
//        foreach ($valuesinput as $key=>$value)
//            $this->values=$this->values.$value.",";
//        $this->values=substr($this->values,0,-1);
        $this->values=$valuesinput;
        return $this;
    }
    function getQuery(){
        $sqlstring="INSERT INTO ";
        if(isset($this->tablename)) $sqlstring=$sqlstring.$this->tablename;
        if(isset($this->fields)) $sqlstring=$sqlstring."(".$this->tablename.") ";
        if(isset($this->values)) $sqlstring=$sqlstring." VALUES(".$this->values.")";
        echo $sqlstring;
        return $sqlstring;
    }
}
class deleteclass extends query{
    protected $tablename;
    protected $condition;
    function table($tableinpit){
        $this->tablename=$tableinpit;
        return $this;
    }
    function where($conditioninput){
        $this->condition=$conditioninput;
        return $this;
    }
    function getQuery(){
        $sqlstring="DELETE FROM ";
        if(isset($this->tablename)) $sqlstring=$sqlstring.$this->tablename;
        if(isset($this->condition)) $sqlstring=$sqlstring." WHERE ".$this->condition;
        echo $sqlstring;
        return $sqlstring;
    }

}
class updateclass extends query{
    protected $table;
    protected $condition;
    protected $values;
    function table($tableinput){
        $this->table=$tableinput;
        return $this;
    }
    function where($conditioninput){
        $this->condition=$conditioninput;
        return $this;
    }
    function set($valuesinput){
        $this->values=$valuesinput;
        return $this;
    }
    function getQuery(){
        $sqlstring="UPDATE ";
        if(isset($this->table)) $sqlstring=$sqlstring.$this->table;
        if(isset($this->values)) $sqlstring=$sqlstring." SET ".$this->values;
        if(isset($this->condition)) $sqlstring=$sqlstring." WHERE ".$this->condition;
        echo $sqlstring;
        return $sqlstring;
    }
}
//$query=new selectclass();
//$query->table(table1)->getQuery();
//$query=new insertclass();
//$query->table(tablename)->valuesin("value1,value2,value3")->getQuery();
//$query=new deleteclass();
//$query->table(table1)->where("Условие1=условие1")->getQuery();
$query=new updateclass();
$query->table(table1)->set("animal=cat,name=Матроскин")->where("Хозяин='Дядя Фёдор'")->getQuery();

