(function(window, document){

var chart;
var pressure_chart;
var lasttime;

function drawCurrent(data)
{
    var tempDHT, tempBMP;
    if (data.count_dht022 > 0)
    {
       lasttime = data.humidity[data.count_dht022-1][0];
       tempDHT  = data.temperature_dht022[data.count_dht022-1][1];
       document.querySelector("span#humidityDHT022").innerHTML = data.humidity[data.count_dht022-1][1];

       var date = new Date(lasttime);
       document.querySelector("span#time").innerHTML = date.toTimeString();
    }
    if (data.count_bmp180 > 0)
    {
       lasttime = data.temperature_bmp180[data.count_bmp180-1][0];
       tempBMP = data.temperature_bmp180[data.count_bmp180-1][1];
       document.querySelector("span#pressureBMP180").innerHTML = data.pressure[data.count_bmp180-1][1] + 'mm hg (' + (data.pressure[data.count_bmp180-1][1] /  7.50061561303).toFixed(2) + ' kPa)' ;

       var date = new Date(lasttime);
       document.querySelector("span#time").innerHTML = date.toTimeString();
    }

    document.querySelector("span#temperature").innerHTML = '<abbr title="BMP180 ' + tempBMP + ', DHT022 ' + tempDHT + '">' +  ((tempDHT + tempBMP)/2).toFixed(1) + '</abbr>';
    document.querySelector("span#lastupdate").innerHTML = new Date().toTimeString();
}

function requestDelta()
{
    $.ajax({
    url: 'weather_new.php?mode=delta&delta='+lasttime,
    datatype: "json",
    success: function(data)
    {
	   var i;
           if (data.count > 0) {
	   for(i=0; i<data.count_dht022;i++)
	      chart.series[0].addPoint(data.temperature_dht022[i], false, true);
           for(i=0; i<data.count_dht022;i++)
              chart.series[1].addPoint(data.humidity[i], false, true);
           for(i=0; i<data.count_bmp180;i++)
              chart.series[0].addPoint(data.temperature_bmp180[i], false, true);
           for(i=0; i<data.count_bmp180;i++)
              pressure_chart.series[0].addPoint(data.pressure[i], false, true);
           chart.redraw();
	   pressure_chart.redraw();
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
    url: 'weather_new.php?mode='+daterange,
    datatype: "json",
    success: function(data)
    {
       chart.series[0].setData(data.temperature_dht022);
       chart.series[1].setData(data.humidity);
       chart.series[2].setData(data.temperature_bmp180);
       pressure_chart.series[0].setData(data.pressure);
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
        name: 'Temperature DHT022',
        data: []
     },
     {
        name: 'Humidity',
        data: []	
     },
     {
        name: 'Temperature BMP180',
        data: []
     }]
  });

pressure_chart = new Highcharts.Chart({
     chart: {
        renderTo: 'pressure_graph',
        type: 'spline',
        events: {
            load: requestData
        }
     },
     title: {
        text: 'Pressure monitoring'
     },
    tooltip: {
      shared: true
    },
     xAxis: {
        type: 'datetime',
            maxZoom: 20 * 1000
     },
     yAxis: {
        min: 700,
        minPadding: 0.2,
        maxPadding: 0.2,
            title: {
                text: 'Pressure',
                margin: 80
            }
     },
     series: [{
        name: 'Pressure',
        data: []
     }]
  });

  $('select#daterange').change(function() {requestData();});
  });
})(window, document)
