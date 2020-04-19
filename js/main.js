$(document).ready( function () {
    $('#main-table').DataTable( {
        "order": [[ 1, "desc" ]]
    }
    );
    // $("body").on("click", "#main-table td", function () {
    //     $country = $(this).text();
    //     $.ajax({
    //         type: "POST",
    //         url: 'getChartDetails.php',
    //         data: {country: $country},
    //         success: function(data){
    //             alert(data);
    //         }
    //     });
    // });
    $.getJSON('getChartDetails.php', function(data){
        var notification = "";
        $.each(data, function(index, notificationobj){
            console.log(notificationobj[index])
            // getting notification as per the type comment or like
            // if (notificationobj.comment == null){
            //     notification += "<div class='card bg-dark text-white'><div class='card-body'>" + notificationobj.first_name + " liked your \"" +
            //     notificationobj.title + "\" recipe on " + notificationobj.posted_date + "</div></div>";
            // }
            // else {
            //     notification += "<div class='card bg-secondary text-white'><div class='card-body'>" + notificationobj.first_name + " commented \"" +
            //     notificationobj.comment + "\" on your recipe \"" + notificationobj.title + "\" on "+ notificationobj.posted_date + "</div></div>";
            // }
        })
        // if (notification !== ""){
        //     $('#modal-body').html(notification);
        //     $("#myModal").modal();
        // }
    })
    var chart = new ApexCharts(document.querySelector("#chartContainer"), options);
    chart.render()
} );


var options = {
    series: [{
      name: "Desktops",
      data: [10, 41, 35, 51, 49, 62, 69, 91, 148]
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
    text: 'Product Trends by Month',
    align: 'left'
  },
  grid: {
    row: {
      colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
      opacity: 0.5
    },
  },
  xaxis: {
    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep'],
  }
  };

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

