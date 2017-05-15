//global variables to be use for saving/retrieving data for php
var objCOA = { 
                coatype:"", 
                parent:"NULL", 
                accnum:"", 
                acctitle:""
            };

//main start
jQuery(document).ready(function() {
    
    // create functions for the coa-type dropdown
    $("#coa-type").ready(function() {
        $.get(
            "/ames/classes/coa.php",
            "proc=load-coa-type",
            function(data, status){
                alert("Data: " + data + "\nStatus: " + status);
                //transfer all the php return value to this select component
                $("#coa-type").html(data);
            }
        );
    });

    $("#myTable").ready(function() {
        
        $.get(
            "/ames/classes/coa.php",
            "proc=select-all-coa",
            function(data, status){
                //alert("Data: " + data + "\nStatus: " + status);
                //transfer all the php return value to this select component
                $("#myTable").append(data);
            }
        );
    });

    //this create function to the click of btnConfirm
    $("#btnConfirm").click( function(e) { 
        
        e.preventDefault();
        target = $(this).attr("href");
        
        boolConfirm = confirm('Confirm saving the following data.');
        if(boolConfirm){
            
            setObjectValues();
            var myJSON = JSON.stringify(objCOA);
            //alert("myJSON: " + myJSON);

            type = $("#modal").attr('type');
            //if(!confirm("Type: " + type))return;

            if(type == "add"){

                $.ajax({
                    url: '/ames/classes/coa.php',
                    type: 'POST',
                    data: {proc:"insert-coa",object:myJSON},
                    success: function(msg) {
                        if(confirm(msg + "\n\nOK - Exit the modal\nCancel - Go Back")){
                            clearFields();
                            document.location = target;
                        }                  
                    }                
                });

            }else if(type == "edit"){
                
                formname = $("#modal").attr('name');
                //alert("modalform name: " + formname);

                $.ajax({
                    url: '/ames/classes/coa.php',
                    type: 'POST',
                    data: {proc:"update-coa", object:myJSON, oldid:formname},
                    success: function(msg) {
                        if(confirm(msg + "\n\nOK - Exit the modal\nCancel - Go Back")){
                            clearFields();  
                            document.location = target;
                        }                   
                    }                
                });
            }            
        }//end of boolConfirm

    });//end of #btnConfirm

    $("#btnAdd").click( function() {

        $("#modalTitle").html("Adding Account");
        $("#modal").attr('type','add');
        $("#modal").attr('name','none');

    });

    $("#btnCancel").click( function(){
        clearFields();
    });

    function setObjectValues(){
        objCOA.coatype = $('select[id=coa-type]').val() 
        objCOA.accnum = $("#txtAccNum").val();
        objCOA.acctitle = $("#txtAccTitle").val();
    }

    //this resets the values in the field
    function clearFields(){
        $('select[id=coa-type]').val($("select[id=coa-type] option:first").val());
        $("#txtAccNum").val('');
        $("#txtAccTitle").val('');
    }

});//end of jQuery(document).ready()

//this create function to the click of whole row
function prepareEdit(e) { 
            
    id = $(e).attr('id');

    $("#modalTitle").html("Editting Account: " + id);
    $("#modal").attr('type','edit');
    $("#modal").attr('name',id);

    $.get(
        "/ames/classes/coa.php",
        "proc=select-one-coa&id="+id,
        function(data, status){
            //alert("Data: " + data + "\nStatus: " + status);
            returnedObject = JSON.parse(data);

            $('select[id=coa-type]').val(returnedObject[0].strCOATypeID); 
            $("#txtAccNum").val(returnedObject[0].strCOAHeaderID);
            $("#txtAccTitle").val(returnedObject[0].strCOAName);   
        }
    );

    document.location = "#modal"; 

}//end of prepareEdit(e)