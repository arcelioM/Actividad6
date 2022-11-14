$(function () {
    

    $.soap({
        url: "http://localhost/workspace-php/poo/Actividad6/controller/depot/ControllerDepot.php?wsdl",
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
        rowData += "<td>"+data.ID_DEPOT+"</td>";
        rowData +="<td>"+data.branchName+"</td>";
        rowData +="<td>"+data.location+"</td>";
        rowData +="<td>"+data.idStatus+"</td>";
        rowData +="</tr>";
        $("#tBody").append(rowData);
    }
});