var countryElements = document.getElementById("countries").childNodes;
var countryCount = countryElements.length;
for (var i = 0; i < countryCount; i++) {
  countryElements[i].onclick = function () {
    fetch('worldMap.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
      },
      body: "text=" + this.getAttribute("data-id")
    })
    .then(response => response.text())
    .then(data => alert(data));
  };
}

