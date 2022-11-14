$(function () {
    

    $.soap({
        url: "http://localhost/workspace-php/poo/Actividad6/controller/status/ControllerStatus.php?wsdl",
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
        rowData += "<td>"+data.ID_STATUS+"</td>";
        rowData +="<td>"+data["name"]+"</td>";
        rowData +="</tr>";
        $("#tBody").append(rowData);
    }
});