<!DOCTYPE HTML>
<html>

<head>
  <title>ESP8266 WITH MYSQL DATABASE</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  <link rel="icon" href="data:,">
  <style>
    html {
      font-family: Arial;
      display: inline-block;
      text-align: center;
    }

    p {
      font-size: 1.2rem;
    }

    h4 {
      font-size: 0.8rem;
    }

    body {
      margin: 0;
    }

    .topnav {
      overflow: hidden;
      background-color: #0c6980;
      color: white;
      font-size: 1.2rem;
    }

    .content {
      padding: 5px;
    }

    .card {
      background-color: white;
      box-shadow: 0px 0px 10px 1px rgba(140, 140, 140, .5);
      border: 1px solid #0c6980;
      border-radius: 15px;
    }

    .card.header {
      background-color: #0c6980;
      color: white;
      border-bottom-right-radius: 0px;
      border-bottom-left-radius: 0px;
      border-top-right-radius: 12px;
      border-top-left-radius: 12px;
    }

    .cards {
      max-width: 700px;
      margin: 0 auto;
      display: grid;
      grid-gap: 2rem;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    }

    .reading {
      font-size: 1.3rem;
    }

    .packet {
      color: #bebebe;
    }

    .temperatureColor {
      color: #fd7e14;
    }

    .humidityColor {
      color: #1b78e2;
    }

    .statusreadColor {
      color: #702963;
      font-size: 12px;
    }

    .LEDColor {
      color: #183153;
    }

    /* ----------------------------------- Toggle Switch */
    .switch {
      position: relative;
      display: inline-block;
      width: 50px;
      height: 24px;
    }

    .switch input {
      display: none;
    }

    .sliderTS {
      position: absolute;
      cursor: pointer;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-color: #D3D3D3;
      -webkit-transition: .4s;
      transition: .4s;
      border-radius: 34px;
    }

    .sliderTS:before {
      position: absolute;
      content: "";
      height: 16px;
      width: 16px;
      left: 4px;
      bottom: 4px;
      background-color: #f7f7f7;
      -webkit-transition: .4s;
      transition: .4s;
      border-radius: 50%;
    }

    input:checked+.sliderTS {
      background-color: #00878F;
    }

    input:focus+.sliderTS {
      box-shadow: 0 0 1px #2196F3;
    }

    input:checked+.sliderTS:before {
      -webkit-transform: translateX(26px);
      -ms-transform: translateX(26px);
      transform: translateX(26px);
    }

    .sliderTS:after {
      content: 'OFF';
      color: white;
      display: block;
      position: absolute;
      transform: translate(-50%, -50%);
      top: 50%;
      left: 70%;
      font-size: 10px;
      font-family: Verdana, sans-serif;
    }

    input:checked+.sliderTS:after {
      left: 25%;
      content: 'ON';
    }

    input:disabled+.sliderTS {
      opacity: 0.3;
      cursor: not-allowed;
      pointer-events: none;
    }

    /* ----------------------------------- */
  </style>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


</head>

<body>
  <div class="topnav">
    <h3>Farm Monitoring System</h3>
    <!--  <ul class="flex ">
            <Li class="flex-1"> <a href="#">Home</a> </Li>
            <Li> <a href="#">About Us</a> </Li>
            <Li> <a href="#">Contact Us</a> </Li>
            <Li> <a href="#">login</a> </Li>
          </ul> -->
  </div>

  <br>

  <!-- __ DISPLAYS MONITORING AND CONTROLLING ____________________________________________________________________________________________ -->
  <div class="content">
    <div class="cards">




      <!-- == MONITORING ======================================================================================== -->
      <div class="card">
        <div class="card header">
          <h3 style="font-size: 1rem;">MONITORING</h3>

        </div>

        <!-- Displays the humidity and temperature values received from ESP8266. *** -->
        <h4 class="temperatureColor"><i class="fas fa-thermometer-half"></i> TEMPERATURE</h4>
        <p class="temperatureColor"><span class="reading"><span id="ESP8266_01_Temp"></span> &deg;C</span></p>
        <h4 class="humidityColor"><i class="fas fa-tint"></i> HUMIDITY</h4>
        <p class="humidityColor"><span class="reading"><span id="ESP8266_01_Humd"></span> &percnt;</span></p>
        <h4 class="moistureColor"><i class="fas fa-tint"></i> Moistuire</h4>
        <p class="moistureColor"><span class="reading"><span id="ESP8266_01_Humd"></span> &percnt;</span></p>
        <!-- *********************************************************************** -->

        <p class="statusreadColor"><span>Status Read Sensor DHT11 : </span><span id="ESP8266_01_Status_Read_DHT11"></span></p>
      </div>
      <!-- ======================================================================================================= -->

      <!-- == CONTROLLING ======================================================================================== -->
      <div class="card">
        <div class="card header">
          <h3 style="font-size: 1rem;">CONTROLLING</h3>
        </div>

        <!-- Buttons for controlling the LEDs on Slave 2. ************************** -->
        <h4 class="pump"><i class="fas fa-lightbulb"></i> PUMP</h4>
        <label class="switch">
          <input type="checkbox" id="ESP8266_01_TogLED_01" onclick="GetTogBtnLEDState('ESP8266_01_TogLED_01')">
          <div class="sliderTS"></div>
        </label>
        <!-- <h4 class="LEDColor"><i class="fas fa-lightbulb"></i>relay</h4>
          <label class="switch">
            <input type="checkbox" id="ESP8266_01_TogLED_02" onclick="GetTogBtnLEDState('ESP8266_01_TogLED_02')">
            <div class="sliderTS"></div>
          </label> -->
        <!-- *********************************************************************** -->
      </div>
      <!-- ======================================================================================================= -->
      <div class="card">
        <div class="card header">
          <h3 class="fonrt-size: 0.5rem">Chart for Temperature</h3>
        </div>

        <canvas id="myChart" width="400" height="200"></canvas>

        <script>
          // Your PHP code to fetch data from the server and pass it to JavaScript
          <?php
          // Assume you have an array of data from your PHP logic
          $data = [10, 20, 30, 40, 50];
          ?>

          // JavaScript code to create a bar chart using Chart.js
          var ctx = document.getElementById('myChart').getContext('2d');
          var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
              labels: ['day 1', 'day 2', 'day 3', 'day 4', 'day 5'],
              datasets: [{
                label: 'Temperature Data',
                data: <?php echo json_encode($data); ?>,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
              }]
            },
            options: {
              scales: {
                y: {
                  beginAtZero: true
                }
              }
            }
          });
        </script>

      </div>
      <!-- 
     card for humidity chart -->

      <div class="card">
        <div class="card header">
          <h3 class="fonrt-size: 0.5rem">Chart for Humidty</h3>
        </div>
        <?php
        // Sample data for humidity and time in days
        $humidityData = [0,10,15,20,25,30,35,40,45,50,55, 60,65, 70,75, 80,85,90,95, 100];
        $timeInDays = [1, 2, 3, 4, 5,6,7];
        ?>

        <!-- Create a canvas element to render the chart -->
        <canvas id="humidityChart" width="400" height="200"></canvas>

        <script>
          // Get the data from PHP variables
          var humidityData = <?php echo json_encode($humidityData); ?>;
          var timeInDays = <?php echo json_encode($timeInDays); ?>;

          // Create a context for the chart canvas
          var ctx = document.getElementById('humidityChart').getContext('2d');

          // Create a chart using Chart.js
          var myChart = new Chart(ctx, {
            type: 'line',
            data: {
              labels: timeInDays,
              datasets: [{
                label: 'Humidity',
                data: humidityData,
                backgroundColor: 'rgba(75, 192, 192, 0.2)', // Background color
                borderColor: 'rgba(75, 192, 192, 1)', // Border color
                borderWidth: 1
              }]
            },
            options: {
              scales: {
                x: [{
                  type: 'linear',
                  position: 'bottom',
                  scaleLabel: {
                    display: true,
                    /* labelString: 'Time (Days)' */
                    text: 'Time(Days)'
                  }
                }],
                y: [{
                  type: 'linear',
                  position: 'left',
                  scaleLabel: {
                    display: true,
                    /* labelString: 'Humidity (%)' */
                    text: 'Humidity'
                  }
                }]
              }
            }
          });
        </script>

      </div>


      <!--  card content for soil moisture  -->
      <div class="card">
        <div class="card header">
          <h3 class="fonrt-size: 0.5rem">Chart for Moisture</h3>
        </div>
        <div style="width: 80%; margin: auto;">
          <canvas id="moistureChart"></canvas>
        </div>

        <script>
          // Sample data
          var moistureData = [0,10, 20, 30, 40, 50, 60, 70, 80, 90, 100]; // Example moisture values
          var timeData = [1, 2, 3, 4, 5, 6, 7]; // Example time in days

          // Get the chart canvas
          var ctx = document.getElementById('moistureChart').getContext('2d');

          // Create the chart
          var moistureChart = new Chart(ctx, {
            type: 'line',
            data: {
              labels: timeData,
              datasets: [{
                label: 'Moisture vs Time',
                data: moistureData,
                borderColor: 'blue',
                borderWidth: 2,
                fill: false
              }]
            },
            options: {
              scales: {
                x: {
                  type: 'linear',
                  position: 'bottom',
                  title: {
                    display: true,
                    text: 'Time (Days)'
                  }
                },
                y: {
                  title: {
                    display: true,
                    text: 'Moisture'
                  }
                }
              }
            }
          });
        </script>







      </div>







      <br>

      <div class="content">
        <div class="cards">
          <div class="card header" style="border-radius: 15px;">
            <h3 style="font-size: 0.7rem;">LAST TIME RECEIVED DATA FROM ESP8266 [ <span id="ESP8266_01_LTRD"></span> ]</h3>
            <button onclick="window.open('recordtable.php', '_blank');">Open Record Table</button>
            <h3 style="font-size: 0.7rem;"></h3>
          </div>
        </div>
      </div>
      <!-- ___________________________________________________________________________________________________________________________________ -->

      <script>
        //------------------------------------------------------------
        document.getElementById("ESP8266_01_Temp").innerHTML = "NN";
        document.getElementById("ESP8266_01_Humd").innerHTML = "NN";
        document.getElementById("ESP8266_01_Status_Read_DHT11").innerHTML = "NN";
        document.getElementById("ESP8266_01_LTRD").innerHTML = "NN";
        //------------------------------------------------------------

        Get_Data("ESP8266_01");

        setInterval(myTimer, 5000);

        //------------------------------------------------------------
        function myTimer() {
          Get_Data("ESP8266_01");
        }
        //------------------------------------------------------------

        //------------------------------------------------------------
        function Get_Data(id) {
          if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
          } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
          }
          xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
              const myObj = JSON.parse(this.responseText);
              if (myObj.id == "ESP8266_01") {
                document.getElementById("ESP8266_01_Temp").innerHTML = myObj.temperature;
                document.getElementById("ESP8266_01_Humd").innerHTML = myObj.humidity;
                document.getElementById("ESP8266_01_Status_Read_DHT11").innerHTML = myObj.status_read_sensor_dht11;
                document.getElementById("ESP8266_01_LTRD").innerHTML = "Time : " + myObj.ls_time + " | Date : " + myObj.ls_date + " (dd-mm-yyyy)";
                if (myObj.LED_01 == "ON") {
                  document.getElementById("ESP8266_01_TogLED_01").checked = true;
                } else if (myObj.LED_01 == "OFF") {
                  document.getElementById("ESP8266_01_TogLED_01").checked = false;
                }
                if (myObj.LED_02 == "ON") {
                  document.getElementById("ESP8266_01_TogLED_02").checked = true;
                } else if (myObj.LED_02 == "OFF") {
                  document.getElementById("ESP8266_01_TogLED_02").checked = false;
                }
              }
            }
          };
          xmlhttp.open("POST", "getdata.php", true);
          xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
          xmlhttp.send("id=" + id);
        }
        //------------------------------------------------------------

        //------------------------------------------------------------
        function GetTogBtnLEDState(togbtnid) {
          if (togbtnid == "ESP8266_01_TogLED_01") {
            var togbtnchecked = document.getElementById(togbtnid).checked;
            var togbtncheckedsend = "";
            if (togbtnchecked == true) togbtncheckedsend = "ON";
            if (togbtnchecked == false) togbtncheckedsend = "OFF";
            Update_LEDs("ESP8266_01", "LED_01", togbtncheckedsend);
          }
          if (togbtnid == "ESP8266_01_TogLED_02") {
            var togbtnchecked = document.getElementById(togbtnid).checked;
            var togbtncheckedsend = "";
            if (togbtnchecked == true) togbtncheckedsend = "ON";
            if (togbtnchecked == false) togbtncheckedsend = "OFF";
            Update_LEDs("ESP8266_01", "LED_02", togbtncheckedsend);
          }
        }
        //------------------------------------------------------------

        //------------------------------------------------------------
        function Update_LEDs(id, lednum, ledstate) {
          if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
          } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
          }
          xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
              //document.getElementById("demo").innerHTML = this.responseText;
            }
          }
          xmlhttp.open("POST", "updateLEDs.php", true);
          xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
          xmlhttp.send("id=" + id + "&lednum=" + lednum + "&ledstate=" + ledstate);
        }
        //------------------------------------------------------------
      </script>
</body>

</html>