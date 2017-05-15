<?php
include("displayerror.php");
include("dbintegrator.php");

$proc = $_REQUEST['proc'];
//echo "<script> alert('".$proc."')</script>";

switch ($proc) {
    case "load-coa-type":
        loadCoaType();
        break;

    case "insert-coa":
        insertCoa();
        break;

    case "select-all-coa":
        selectAllCOA();
        break;

    case "select-one-coa":
        selectOneCoa();
        break;

    case "update-coa":
        updateCoa();
        break;

    default:
        echo "Unknown Procedure!";
}

//load all coa type to be place on select component
function loadCoaType(){
    $db = new dbintegrator();

    $sql = "SELECT * FROM `tblcoatype`";
    $result = $db->select($sql);

    foreach ($result as $row) {
        echo '<option value="'.$row["strCOATypeID"].'">'.$row["strCOATypeDescription"].'</option>';
    }
}

function insertCoa(){
    $objcoa = json_decode($_POST['object']);

    $db = new dbintegrator();

    $sql= "INSERT INTO `tblcoaheader` (`strCOAHeaderID`, `strCOAParent`, `strCOAName`, `strCOATypeID`) VALUES ('".$objcoa->accnum."',".$objcoa->parent.",'".$objcoa->acctitle."','".$objcoa->coatype."');";
    
    $db->execute($sql);
}

function selectAllCOA(){

    $db = new dbintegrator();

    $sql = "SELECT `strCOAHeaderID`, `strCOAName`, `strCOATypeDescription` FROM tblcoaheader, tblcoatype WHERE `tblcoaheader`.`strCOATypeID` = `tblcoatype`.strCOATypeID "; 
    $result = $db->select($sql);

    echo "<tbody>";
    
    //echo "<script>alert('Result count: ' + '".count($result)."')</script>";
    if(count($result) > 0){

        foreach ($result as $row) {
            echo "<tr id='".$row['strCOAHeaderID']."' onclick='prepareEdit(this)'>"; 

            echo "<td>". $row['strCOAHeaderID']."</td>";
            echo "<td>". $row['strCOAName']. "</td>";
            echo "<td>". $row['strCOATypeDescription']. "</td>";

            echo "</tr>";
        }//end of loop

    }
    else {
        echo "<tr>";
        echo "<td>No Data Available!</td>";
        echo "<td></td>";
        echo "<td></td>";
        echo "<td></td>";
        echo "</tr>";
    }

    echo "</tbody>";
}

function selectOneCoa(){
    $coaId = $_GET['id'];

    $db = new dbintegrator();

    $sql = "SELECT * FROM tblcoaheader WHERE strCOAHeaderID = '$coaId'";
    $result = $db->select($sql);

    echo json_encode($result);
}

function updateCoa(){
    $coaId = $_POST['oldid'];
    $objcoa = json_decode($_POST['object']);
    
    $db = new dbintegrator();

    $sql = "UPDATE `tblcoaheader` SET `strCOAHeaderID`= '$objcoa->accnum',`strCOAName` = '$objcoa->acctitle', `strCOATypeID` = '$objcoa->coatype' WHERE `tblcoaheader`.`strCOAHeaderID` = '$coaId'";
    
    $db->execute($sql);
}

//end of the php code
?>