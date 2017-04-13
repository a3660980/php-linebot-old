<?php
 require "mysql.php";
    
function w2zh($w3w,$lat,$lng) {
    $db = Database::initDB();
    $w3w = explode(".",$w3w);
    $zhw3w="";
    $boo = false;
    if(count($w3w) != 3){
        return ;
    }
    for($i = 0; $i < 3; $i++){
        $select = $db->prepare("SELECT * FROM zhtw WHERE w3w = :w3w ;");
        $select->execute(array(':w3w'=>$w3w[$i]));
        
        if($select->rowCount() == 0 || $select->rowCount() > 1){
            
            $select = $db->prepare("SELECT id,w3w FROM zhtw WHERE w3w is null ORDER BY RAND()  LIMIT 1 ;");
            $select->execute(); 
            $row=$select->fetch(PDO::FETCH_ASSOC);
            $id=$row['id'];
            
            $ins = $db->prepare("UPDATE zhtw SET w3w = :w3w WHERE id = :id ");
            $ins->execute(array(':id' => $id,':w3w'=>$w3w[$i]));
            
            $boo = true;
            
            $select = $db->prepare("SELECT zhtw FROM zhtw WHERE w3w = :w3w ;");
            $select->execute(array(':w3w'=>$w3w[$i]));
            
        }
            
            $row = $select->fetch(PDO::FETCH_ASSOC);
            $zhtw = $row['zhtw'];
            if($i>0) {
            $zhw3w = $zhw3w.".". $zhtw;
            }else{
                $zhw3w=$zhtw;
            }
        }
        if($boo == true){
            $ins = $db->prepare("INSERT INTO `w3wzhtw`(`w3w`, `zhtw`, `lat`, `lng`, `id`) VALUES (:w3w,:zhtw,:lat,:lng,:id)");
            $ins->execute(array(':id' => null,':w3w'=>$w3w[0].".".$w3w[1].".".$w3w[2],':zhtw' => $zhw3w,':lat'=>$lat,':lng'=>$lng));
        }
        return $zhw3w;
}

function zh2w($w3w) {
    $word = "";
    $db = Database::initDB();
    $zh="";

        $select = $db->prepare("SELECT * FROM w3wzhtw WHERE zhtw = :zhtw ;");
        $select->execute(array(':zhtw'=>$w3w));
        
        if($select->rowCount() == 0 || $select->rowCount() > 1){
            return ;
            break;
        }else{
            $ro = $select->fetch(PDO::FETCH_ASSOC);
            $latlng = array('lat' => $ro['lat'],'lng'=>$ro['lng'],'zhtw'=>$ro['zhtw'],'w3w'=>$ro['w3w']);
        }
    
    return $latlng;
}