<?php//Sadayk
abstract class querybuiler
{
    public function select($table)
    {
        return "SELECT * FROM ".$table;
    }
}

class query extends querybuiler
{
    public function select($table,$columns,$condition,$group)
    {
        if ($columns=="") $columns="*";
        if(($condition=="")&&($group=="")){
        return "SELECT " . $columns . " from " . $table;
        }elseif(($condition!="")&&($group=="")){
            return "SELECT " . $columns . " from " . $table." WHERE ".$condition;
        }elseif(($condition=="")&&($group!="")){
            return "SELECT " . $columns . " from " . $table." GROUP BY ".$group;
        }else{
            return "SELECT " . $columns . " from " . $table." WHERE ".$condition." GROUP BY ".$group;
        }
    }

    public function selectm($table1,$table2,$columns,$key1,$key2,$condition,$group)
    {
        if(($condition=="")&&($group=="")) {
            return "SELECT " . $columns . " FROM " . $table1 . " INNER JOIN " . $table2 . " ON " . $table1 . "." . $key1 . "=" . $table2 . "." . $key2;
        }elseif(($condition!="")&&($group=="")) {
            return "SELECT " . $columns . " FROM " . $table1 . " INNER JOIN " . $table2 . " ON " . $table1 . "." . $key1 . "=" . $table2 . "." . $key2." WHERE ".$condition;
        }elseif(($condition=="")&&($group!="")){
            return "SELECT " . $columns . " FROM " . $table1 . " INNER JOIN " . $table2 . " ON " . $table1 . "." . $key1 . "=" . $table2 . "." . $key2." GROUP BY ".$group;
        }else{
            return "SELECT " . $columns . " FROM " . $table1 . " INNER JOIN " . $table2 . " ON " . $table1 . "." . $key1 . "=" . $table2 . "." . $key2." WHERE ".$condition." GROUP BY ".$group;
        }
    }
    public function insert($table,$fields,$values){
        return "INSERT INTO ".$table."(".$fields.") VALUES(".$values.");";
    }
    public function update($table,$fields,$values,$condition){
        $fieldsarray=mb_split(",",$fields);
        $valuesarray=mb_split(",",$values);
        $sql="UPDATE ".$table." SET ";
        if(count($fieldsarray)==count($valuesarray)){
            foreach ($fieldsarray as $key=>$value){
                $sql=$sql.$fieldsarray[$key]."=".$valuesarray[$key].",";
            }
            $sql = substr($sql,0,-1);
            $sql=$sql." WHERE ".$condition;
            return $sql;
        }else {
            echo "Несовпадение количества полей";
            echo "В полях: ".count($fieldsarray)." в значениях: ".count($valuesarray);
        }
    }
    public function delete($table,$condition){
        return "DELETE FROM ".$table." WHERE ".$condition;
    }
}

    $classquery=new query;
    if(mb_strtolower($_POST['function'])=="select")
    {
        if(($_POST['table1']!="")&&($_POST['table2']=="")){
            $sqltext=$classquery->select($_POST['table1'],$_POST['fields'],$_POST['condition'],$_POST['group']);
            //echo $sqltext;
        }elseif (($_POST['table1']!="")&&($_POST['table2']!="")&&($_POST['fields']!="")&&($_POST['key1']!="")&&($_POST['key2']!=""))
        {
            $sqltext=$classquery->selectm($_POST['table1'],$_POST['table2'],$_POST['fields'],$_POST['key1'],$_POST['key2'],$_POST['condition'],$_POST['group']);
           // echo $sqltext;
        }else{
            echo "Неверный ввод данных!";
        }
    }elseif(mb_strtolower($_POST['function'])=="insert"){
        if (($_POST['table1']!="")&&($_POST['fields']!="")&&($_POST['insert']!="")){
            $sqltext=$classquery->insert($_POST['table1'],$_POST['fields'],$_POST['insert']);
           // echo $sqltext;
        }
    }elseif (mb_strtolower($_POST['function'])=="update"){
        if (($_POST['table1']!="")&&($_POST['fields']!="")&&($_POST['insert']!="")&&($_POST['condition']!="")){
            $sqltext=$classquery->update($_POST['table1'],$_POST['fields'],$_POST['insert'],$_POST['condition']);
            //echo $sqltext;
        }
    }elseif(mb_strtolower($_POST['function'])=="delete"){
        if(($_POST['table1']!="")&&($_POST['condition']!="")){
            $sqltext=$classquery->delete($_POST['table1'],$_POST['condition']);
            //echo $sqltext;
        }
    }else echo "Ошибка ввода";
    if($sqltext!=""){
        try {
            echo $sqltext;
            $dbh = new PDO("TEST.DB","user","password");
            //$result=$dbh->query($sqltext);
        } catch (PDOException $e) {
           // die('Подключение не удалось: ' . $e->getMessage());
        }
    }
//    $sqltext=$classquery->select($_POST['table1'],$_POST['fields']);
