<?php
abstract class abstractquery{
    public $connection;
    protected $table;
    protected $fields;
    function table($tableinput){
        $this->table=(mysqli_real_escape_string($this->connection,$tableinput));
        return $this;
    }
    function fields($fieldsinput){
        $this->fields=mysqli_real_escape_string($this->connection,$fieldsinput);
        return $this;
    }
}
class query extends abstractquery
{
    protected $condition;
    protected $limit;
    protected $group;
    protected $id;
    protected $values;
    function where($conditioninput)
    {
        $this->condition = mysqli_real_escape_string($this->connection,$conditioninput);
        return $this;
    }

    function id($idinput){
        $this->id=mysqli_real_escape_string($this->connection,$idinput);
        return $this;
    }
    function limit($limitinput)
    {
        $this->limit = mysqli_real_escape_string($this->connection,$limitinput);
        return $this;
    }

    function values(array $valuesinput){
        $this->values=$valuesinput;
        return $this;
    }

    function group($groupfield)
    {
        $this->group = mysqli_real_escape_string($this->connection,$groupfield);
        return $this;
    }
    function getselectQuery(){
        $sqlstring="SELECT ";

        if(isset($this->fields)) {
            $sqlstring .=$this->fields;
        }else {
            $sqlstring.="*";
        }
        if(isset($this->table)) {
            $sqlstring.=" FROM ".$this->table;
        }
        if(isset($this->condition)) {
            $sqlstring.=" WHERE ".$this->condition;
        }
        if(isset($this->group)) {
            $sqlstring.=" GROUP BY ".$this->group;
        }
        if(isset($this->order)) {
            $sqlstring.=" ORDER BY ".$this->order;
        }
        if(isset($this->limit)) {
            $sqlstring.=" LIMIT  ".$this->limit;
        }
        return $sqlstring;
    }

    function getinsertQuery(){
        if(isset($this->id)){
            $sqlstring="UPDATE ";
            if(isset($this->table)) {
                $sqlstring.=$this->table;
            }
            if(isset($this->values)) {
                $sqlstring.=" SET ";
                foreach($this->values as $key=>$value){
                    $sqlstring.=mysqli_real_escape_string($this->connection,$key)."='".mysqli_real_escape_string($this->connection,$value)."',";
                }
                $sqlstring=substr($sqlstring,0,-1)." ";
            }
            if(isset($this->id)) {
                $sqlstring.=" WHERE id=".$this->id;
            }
            return $sqlstring;
        }
        else
        {
            $sqlstring="INSERT INTO ";
            if(isset($this->table)) {
                $sqlstring.=$this->table;
            }
            if(isset($this->values)) {
                $sqlstring.=" VALUES(";
                foreach($this->values as $key=>$value){
                    $sqlstring.="'".mysqli_real_escape_string($this->connection,$value)."',";
                }
                $sqlstring=substr($sqlstring,0,-1).") ";
            }
            return $sqlstring;
        }
    }

    function getdeleteQuery(){
        $sqlstring="DELETE FROM ";
        if(isset($this->tablename)) {
            $sqlstring.=$this->table;
        }
        if(isset($this->id)) {
            $sqlstring.=" WHERE id=".$this->id;
        }
        return $sqlstring;

    }


}
require_once("connection.php");
$mysqli=new mysqli($host,$login,$password,'librarysadayk');
$myquery=new query();
$myquery->connection=$mysqli;
$sqlstring= $myquery->table(book)->values(["Name"=>"SCP Containment Breach","Author"=>"jiri'n'o'v\ski","Lists"=>250,"Price"=>10,"Category"=>"Fantasy"])->id(6)->getinsertQuery();
echo $sqlstring;
if($mysqli->query($sqlstring)===TRUE){
    print_r("Запись добавлена!");
}
else{
    print_r("Ошибка добавления");
}