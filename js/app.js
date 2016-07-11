$(document).foundation();

function drawChart(azureResponse, allowedFields) {
	var ctx = document.getElementById('myChart').getContext('2d');
	var fields = [];
	var values = [];
	for(var i = 0 ; i < azureResponse.Results.output1.value.ColumnNames.length ; i++) {
		var columnName = azureResponse.Results.output1.value.ColumnNames[i];
		if (allowedFields.indexOf(columnName) > -1) {
			if(columnName=="Scored Labels"){
				columnName = "~Points";
			}
			fields.push(columnName);
			values.push(parseFloat(azureResponse.Results.output1.value.Values[0][i]));
		}
	}
	console.log(fields);
	console.log(values);
	var data = {
	    labels: fields,
	    datasets: [
	        {
	            label: "",
	            backgroundColor: "rgba(255, 121, 77, 0.2)",
	            borderColor: "rgba(255, 51, 0,1)",
	            borderWidth: 1,
	            hoverBackgroundColor: "rgba(0, 43, 128, 0.4)",
	            hoverBorderColor: "rgba(0, 26, 51,1)",
	            data: values,
	        }
	    ]
	};
	var myBarChart = new Chart(ctx, {
	    type: 'bar',
	    data: data,
	    options: {
	    	legend: {
    			display: false
    		}
    	}
	});
}