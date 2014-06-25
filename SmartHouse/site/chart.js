(function(window, document){

var chart;
var lasttime;

function drawCurrent(data)
{
    if (data.count > 0)
    {
       lasttime = data.humidity[data.count-1][0];
       document.querySelector("span#temperature").innerHTML = data.temperature[0][1];
       document.querySelector("span#humidity").innerHTML = data.humidity[0][1];
       var date = new Date(lasttime);
       document.querySelector("span#time").innerHTML = date.toTimeString();
    }
    document.querySelector("span#lastupdate").innerHTML = new Date().toTimeString();
}

function requestDelta()
{
    $.ajax({
    url: 'weather.php?mode=delta&delta='+lasttime,
    datatype: "json",
    success: function(data)
    {
	   var i;
           if (data.count > 0) {
	   for(i=0; i<data.count;i++)
	      chart.series[0].addPoint(data.temperature[i], false, true);
           for(i=0; i<data.count;i++)
              chart.series[1].addPoint(data.humidity[i], false, true);
           chart.redraw();
	  }
	  drawCurrent(data);
          
    }
    });

}

function requestData()
{
    var daterange = document.querySelector("select#daterange").value;
    if (!daterange)
	daterange = "today";
    $.ajax({
    url: 'weather.php?mode='+daterange,
    datatype: "json",
    success: function(data)
    {
           chart.series[0].setData(data.temperature);
           chart.series[1].setData(data.humidity);
           drawCurrent(data);
	   setInterval(requestDelta, 5 * 60 *  1000);  
    }
    });
}
$(document).ready(function() {

    Highcharts.setOptions({
        global: {
            useUTC: false
        }
    });
chart = new Highcharts.Chart({
     chart: {
        renderTo: 'graph',
        type: 'spline',
        events: {
            load: requestData
        }
     },
     title: {
        text: 'Monitoring'
     },
    tooltip: {
      shared: true
    },
     xAxis: {
        type: 'datetime',
            maxZoom: 20 * 1000
     },
     yAxis: {
	min: 10,
        minPadding: 0.2,
            maxPadding: 0.2,
            title: {
                text: 'Temperature/Humidity',
                margin: 80
            }
     },
     series: [{
        name: 'Temperature',
        data: []
     },
     {
        name: 'Humidity',
        data: []	
     }]
  });
  });
})(window, document)
