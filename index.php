<?php
//code for changing the date
$datevalue = '2020-04-18';
$selectedcountry = 'Canada';
$date = $country = $getcountries = false;
if(isset($_POST['dateChange'])){
    $date =  $_POST['dateValue'];
    $datevalue = $_POST['dateValue'];
    $country = $_POST['country'];
    $selectedcountry = $_POST['country'];
    echo "<script type='text/javascript'>chartRenderApex($country);</script>";
;
}
if (isset($_POST['viewall'])){
    $date = false;
    $country = false;
}
if(isset($_GET['country'])){
    $dates = ['2020-03-25', '2020-03-30', '2020-04-05', '2020-04-10', '2020-04-15'];
    $values = [];
    $counter = 0;
    $history = [];
    foreach ($dates as $adate){
        foreach (getData($adate, $_GET['country'], false) as $key => $value){
            $counter += 1;
            // $values = [];
            if ($counter > 1)
            { 
            //    $details = [$value['cases']['total'], $adate];
            //    $values = [$value['cases']['total']];
               $history[$adate] = $value['cases']['total'];
            }
        }
    }
    echo json_encode($history);
    die;
}

$continents = ['All', 'Europe', 'North-america', 'Asia', 'Africa', 'North-america', 'South-america'];
//this method has three parameters
//if the method is called with date & country it will fetch the history
//if the method is called with getcountries it will fetch the countries which is affected with CORONA virus.
//if the method is called with no paramters it fetches the current updates for all affected countries
//api ref: https://rapidapi.com/api-sports/api/covid-193
function getData($date=false, $country=false, $getcountries=false){
    $curl = curl_init();
    if ($date && $country){
        $url = "https://covid-193.p.rapidapi.com/history?day=$date&country=$country";
    }
    else if ($getcountries){
        $url = "https://covid-193.p.rapidapi.com/countries";
    }
    else {
        $url = "https://covid-193.p.rapidapi.com/statistics?";
    }
    curl_setopt_array($curl, array(
	CURLOPT_URL => $url,
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_FOLLOWLOCATION => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 30,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "GET",
	CURLOPT_HTTPHEADER => array(
		"x-rapidapi-host: covid-193.p.rapidapi.com",
		"x-rapidapi-key: 0983bcff25msh9df47a985b40bb5p12da9ejsn71aa761e7f77"
	),
));
    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);
    $result = false;
    if ($err) {
        return "cURL Error #:" . $err;
    } else {
        $response = json_decode($response, true);
        return $response['response'];
    }

}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="utf-8">
    <meta name="google-signin-scope" content="profile email">
    <meta name="google-signin-client_id" content="758045501364-o30v76lc7lsk9dp3fg8h7toonhnvbpka.apps.googleusercontent.com">

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap 4 CSS -->
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- for sorting -->
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    </head>
    <body>
        <header>
            <div class="jumbotron text-center mb-0">
                <h1>Covid 19 Stats</h1>
                <p>Live status of Covid19 Cases, subscribe us for the updates!</p> 
                <!-- code ref: https://developers.google.com/identity/sign-in/web/sign-in-->
                <div class="g-signin2" id="signinbutton" data-onsuccess="onSignIn" data-theme="dark"></div>
                <!-- google sign in actually doesn't sign out the user completely-->
                <!-- <div id="logoutbutton" style="display:none;">
                    <div class="g-signin2" style="display:none;" data-cookiepolicy='single_host_origin' data-onsuccess="onSignIn"></div>
                    <button class="btn btn-danger" onclick="logOut()">Sign out</button>
                </div> -->
            </div>
            <!-- to be implemented -->
            <!-- <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="myprofile.html">My Profile</a>
                    </li>
                </ul>
            </nav> -->
        </header>
        <main>
        <div class="container">
            <form action="index.php" method="post">
                <div class="form-group mt-3">
                    <label for="country">Select Country</label>
                    <select id="country" name="country" value="<?=$selectedcountry?>">
                        <?php
                            $countries = getData(false, false, true);
                            foreach ($countries as $key => $value){
                        ?>
                            <option value="<?=$value?>"><?=$value?></option>
                        <?php
                            }
                        ?>
                    </select>
                    <label for="date">Select Date</label>
                    <input type="date" id="start" name="dateValue" value=<?=$datevalue?>>
                    <button type="submit" name="dateChange" class="btn btn-primary">Change</button>
                </div>
            </form>
            <form action="index.php" mehod="post">
                <button type="submit" name="viewall" class="btn btn-success">View all country data (Recent)</button> 
            </form>
            <div id="email-subscription" class="mt-3">
                <form action="email.php" method="post">
                    <input type="hidden" id="email" name="email">
                    <input type="hidden" id="username" name="username">
                    <button type="submit" name="emailuser" class="btn btn-warning">Email Subscription for Updates</button> 
                </form>
            </div>
        </div>
        <!-- chart future implementation -->
        <div id="selectedCountry" class="alert alert-danger container mt-3">
            <strong>Info!</strong> Select any country in the below table to view its Chart.
        </div>
        <div class="container" id="chartContainer"></div>
        <div class="container">
            <h2>Coronavirus world stats</h2>
            <table id="main-table" class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th>Country</th>
                    <th>Total Cases</th>
                    <th>New Cases</th>
                    <th>Active</th>
                    <th>Critical</th>
                    <th>Recovered</th>
                    <th>Deaths</th>
                    <th>New Deaths</th>
                </tr>
                </thead>
                <tbody>
                    <?php
                        $count = 0;
                        //counting as the api returns two values for single history call. Preventing with the count condition so it dosen't display two items for one
                        foreach (getData($date, $country, false) as $key => $value){
                            $count += 1;
                            if ((in_array($value['country'], $continents)) || ($count > 1 && $country))
                            { 
                                break;
                            }
                    ?>
                    <tr>
                        <td><a href="#chartContainer"><?=$value['country']?></a></td>
                        <td><?=$value['cases']['total']?></td>
                        <td class="bg-warning"><?=$value['cases']['new']?></td>
                        <td><?=$value['cases']['active']?></td>
                        <td><?=$value['cases']['critical']?></td>
                        <td><?=$value['cases']['recovered']?></td>
                        <td><?=$value['deaths']['total']?></td>
                        <td class="bg-danger"><?=$value['deaths']['new']?></td>
                    </tr>
                    <?php
                        }
                    ?>
                </tbody>
            </table>
            </div>
        </main>
        <div id="getStats">
        </div>
        <footer>
        <div class="jumbotron text-center mb-0">
            <strong>Covid-19 Stats</strong>
            <p>Copyright Yash Pathak</p>
        </div>
        </footer>
        <script src="https://apis.google.com/js/platform.js" async defer></script>
        <script src="https://code.jquery.com/jquery-3.5.0.min.js" integrity="sha256-xNzN2a4ltkB44Mc/Jz3pT4iU1cmeR0FkXs4pru/JxaQ=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <!-- Script for sorting -->
        <script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
        <script src="js/main.js"></script>
        <!-- chart -->
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    </body>
</html>