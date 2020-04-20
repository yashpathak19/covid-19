$(document).ready( function () {
    $('#main-table').DataTable( {
        "order": [[ 1, "desc" ]]
    }
    );
    $("body").on("click", "#main-table td", function () {
        document.getElementById("selectedCountry").innerText = $(this).text();
        chartRenderApex($(this).text());
    });
    // var chart = new ApexCharts(document.querySelector("#chartContainer"), options);
    // chart.render()
} );

var options = {
    series: [{
      name: "Affected People",
      data: [],
  }],
    chart: {
    height: 350,
    type: 'line',
    zoom: {
      enabled: false
    }
  },
  dataLabels: {
    enabled: false
  },
  stroke: {
    curve: 'straight'
  },
  title: {
    text: 'Line Chart',
    align: 'left'
  },
  grid: {
    row: {
      colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
      opacity: 0.5
    },
  },
  xaxis: {
    categories: [],
  }
  };
function chartRenderApex(country="Canada") {
  $.ajax({
    url: "index.php?country=" + country,
    type: "GET",
    success: function(data){
        options.series[0]['data'] = []; 
        options.xaxis.categories = [];
        $.each(JSON.parse(data), function(dateVal, caseVal){
            options.series[0]['data'].push(caseVal); 
            options.xaxis.categories.push(dateVal);
        })
    }
    });
    debugger
    // options.series[0]['data'] = dates;
    // options.xaxis.categories = totalCases;
    document.getElementById("chartContainer").innerText = "";
    var chart = new ApexCharts(document.querySelector("#chartContainer"), options);
    chart.render()
}
chartRenderApex();

function onSignIn(googleUser) {
    // getting user details
    var profile = googleUser.getBasicProfile();
    // setting values
    document.getElementById("email").value = profile.getEmail();
    document.getElementById("username").value = profile.getName();
}

//log out button
// function logOut() {
//     var user = gapi.auth2.getAuthInstance();
//     user.signOut();
//     //hiding the fields of name, email and image
//     document.getElementById("logoutbutton").style.display = "none";
// }

