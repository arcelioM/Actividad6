$(function () {
    

    $.soap({
        url: "http://localhost/workspace-php/poo/Actividad6/controller/typeProduct/ControllerTypeProduct.php?wsdl",
        method: 'getAll',
        
        data: {
        },
        
        success: getData,
        error: function (SOAPResponse) {
            $("#result").html(SOAPResponse);
        }
    });


    function getData(response) {
        $("#tBody").html("");
        data = response.toJSON().Body.getAllResponse.return;
        data = JSON.parse(data);
        data = data["values"]
        let rowData ="";
        for(let i=0; i<data.length;i++){
            showData(data[i],rowData);
        }

        console.log(data[1]["idProduct"]);

    }

    function showData(data) {
        
        rowData ="<tr>";
        rowData += "<td>"+data.ID_TYPE_PRODUCT+"</td>";
        rowData +="<td>"+data.name+"</td>";
        rowData +="<td>"+data.idStatus+"</td>";
        rowData +="<td>"+data.creationDate+"</td>";
        rowData +="</tr>";
        $("#tBody").append(rowData);
    }
});