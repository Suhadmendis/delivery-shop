<?php

session_start();


require_once ("DB_connector.php");


date_default_timezone_set('Asia/Colombo');

if ($_GET["Command"] == "generate") {
   header('Content-Type: application/json');

    $ResponseXML = "";
    $ResponseXML .= "<new>";

    $objArray = Array();

    $sql = "SELECT * FROM m_order";
    $result = $conn->query($sql);
    $row = $result->fetchAll();
    // $no = $row['store_ref'];
    // $tmpinvno = "000000" . $row["store_ref"];
    // $lenth = strlen($tmpinvno);
    // $no = trim("ST/") . substr($tmpinvno, $lenth - 7);





    $en_name = "Order";

    array_push($objArray,$row,$en_name);


    $sql = "SELECT * FROM user_mast_rider";
    $result = $conn->query($sql);
    $row = $result->fetchAll();

    array_push($objArray,$row);

    echo json_encode($objArray);

   
}



if ($_GET["Command"] == "getStores") {
   header('Content-Type: application/json');

    $ResponseXML = "";
    $ResponseXML .= "<new>";

    $sql = "SELECT loctaion_point_lat as lat, loctaion_point_lng as lng, shop_name FROM m_store";
    $result = $conn->query($sql);
    $row = $result->fetchAll();
    
    $objArray = Array();
    array_push($objArray,$row);

    echo json_encode($objArray);
}




if ($_GET["Command"] == "setRider") {
 

    
    try {
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->beginTransaction();

        
       
        
        
        
        $sql = "update m_order set rider_name = '" . $_GET['rider'] . "' where REF = '" . $_GET['ref'] . "'";
        $result = $conn->query($sql);

        $sql = "update m_order set delivery_type = 'MUL' where REF = '" . $_GET['ref'] . "'";
        $result = $conn->query($sql);

        $sql = "update m_order set status = 'DELIVERY' where REF = '" . $_GET['ref'] . "'";
        $result = $conn->query($sql);

        // $sql = "Insert into sys_log(REF, entry, operation, user, ip)values
        //                 ('" . $no1 . "' ,'entry' ,'SAVE'  ,'" . $_SESSION['UserName'] . "' ,'ip')";
        // $result = $conn->query($sql);



        $conn->commit();
        echo "Saved";
    } catch (Exception $e) {
        $conn->rollBack();
        echo $e;
    }
}






// if ($_GET["Command"] == "approve") {
 

    
//     try {
//         $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//         $conn->beginTransaction();

//        $no1 = $_GET['REF'];
//         $sql = "update m_store set approve = '1' where REF = '" . $no1 . "'";
//         $result = $conn->query($sql);

//         $sql = "Insert into sys_log(REF, entry, operation, user, ip)values
//                         ('" . $no1 . "' ,'entry' ,'Approved'  ,'" . $_SESSION['UserName'] . "' ,'ip')";
//         $result = $conn->query($sql);



//         $conn->commit();
//         echo "Approved";
//     } catch (Exception $e) {
//         $conn->rollBack();
//         echo $e;
//     }
// }



if ($_GET["Command"] == "getForm") {
    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";

    $REF = $_GET["REF"];

    $sql = "select * from m_store where REF= '" . $REF . "'";

    $sql = $conn->query($sql);
    if ($row = $sql->fetch()) {
        $ResponseXML .= "<objSup><![CDATA[" . json_encode($row) . "]]></objSup>";
    }

   $ResponseXML .= "<IDF><![CDATA[" . $_GET['IDF'] . "]]></IDF>";

    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}
