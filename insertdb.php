<head>
<meta charset='UTF-8'>
</head>
<?php
    require "mysql.php";
    $db = Database::initDB();
if(isset($_POST['button'])){
    
    $file = fopen("TSAIWORD2.TXT","r");
    if($file){
        $i = 0;
        while(!feof($file))
        {
            $str = fgets($file);
            $str = trim($str);
            
            $str = str_replace('.', '', $str); // remove dots
            $str = str_replace(' ', '', $str); // remove spaces
            $str = str_replace("\t", '', $str); // remove tabs
            $str = str_replace("\n", '', $str); // remove new lines
            $str = str_replace("\r", '', $str); // remove carriage returns
            
            if(mb_strlen($str,"utf8") == 2){
                //time_nanosleep(0,1000000);
                $select = $db->prepare("SELECT `zhtw` FROM `zhtw` WHERE `zhtw` = :zhtw ;");
                $select->execute(array(':zhtw'=>$str));
                if($select->rowCount() == 0){
                    $ins = $db->prepare("INSERT INTO `zhtw` (id, zhtw) VALUES (:id, :zhtw)");
                    $ins->execute(array(':id' => null,':zhtw'=>$str));
                    ++$i;
                    echo "$i $str ";
                }
            }else{
                continue;
            }
        }
    
        fclose($file);
    }else{
        echo "nothing";
    }
}
?>
<form method="post">
    <button type="submit" name="button">開始</button>
</form>
 