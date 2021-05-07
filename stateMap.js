google.load('visualization', '1', {
    'packages': ['geochart', 'table']
});
google.setOnLoadCallback(drawRegionsMap);

var res;

fetch('stateMap.php', {
  method: 'POST',
  headers: {
    'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
  }})
  .then(response => response.text())
  .then(data => res = data);

function drawRegionsMap() {
    var regionDataArray = [
        ['Region', 'State', 'Cases'],
        ['US-NY',  'New York', 300]
    ];

    var data = google.visualization.arrayToDataTable(regionDataArray);
    var view = new google.visualization.DataView(data);
    view.setColumns([1, 2]);

    var geoChart = new google.visualization.GeoChart(document.getElementById('chart'));

    var options = {
        region: 'US',
        resolution: 'provinces',
        legend: 'none',
        backgroundColor: '#8d8d8d'
    };

    geoChart.draw(view, options);

};

