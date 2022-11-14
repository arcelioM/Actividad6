

$(function () {
    
    $("#btn").on("click", function () {
        $.soap({
            url: "http://localhost/workspace-php/poo/Actividad6/controller/depotProduct/ControllerDepotProduct.php?wsdl",
            method: 'getById',
            
            data: {
                "id":1
            },
            
            success: function (soapResponse) {
                data = soapResponse.toJSON().Body.getByIdResponse.return;
                
                data = JSON.parse(data);
                console.log(data["values"]["idProduct"]);

                $("#result").html(data["values"]["idProduct"]);
            },
            error: function (SOAPResponse) {
                $("#result").html(SOAPResponse);
            }
        });
 
        
    });
});