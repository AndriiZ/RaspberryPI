<html>
<head>
  <title>Weather</title>
  <script src="/js/jquery-2.1.1.min.js"></script>
  <script src="/js/highcharts.js"></script>
  <script src="/js/chart.js"></script>
</head>
<body>
  <div id="all">
    <div id="current" style="float:left;width:20%">
      Temperature  <span id="temperature"></span><br />
      Humidity <span id="humidity"></span><br />
      Time  <span id="time"></span>

  <div>
  Select time range
   <select id="daterange"">
     <option value="today">Today</option>
     <option value="dbn">Last day</option>
     <option value="wtn">Last week</option>
     <option value="week">This week</option>
     <option value="Month">This Month</option>
     <option value="year">This year</option>
     <option value="all">All</option>
   </select>
 </div>


    </div>
    <div id="graph" style="width:70%;"></div>
  </div>
 <div id="footer">
   <span id="lastupdate"></span>
 </div>
</body>

