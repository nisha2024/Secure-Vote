<?php 

$mobile = $_POST['mobile'];
function sendPostRequest($url, $postData) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
}
$flag = 0;
// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
        $url = 'http://127.0.0.1:5000/detect-face';
        // $postData = array(
        //     'id' => $mobile
        // );
    
        // $response = sendPostRequest($flaskServerUrl,$postData);
        // $responseData = json_decode($response, true);
        // $flag=$responseData['message'];

        $json = json_encode(array('id' => $mobile));
        
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER,array('Content-Type:application/json')); 
        $response = curl_exec($ch);
        curl_close($ch);
        $responseData = json_decode($response, true);
        $flag=$responseData['message'];
        echo "Hello, this is printed to the console\n";
        print "This is also printed to the console\n";
      
    }
// }




$connect = mysqli_connect("localhost", "root", "", "voting") or die("connection failed");
session_start();
// include("connect.php");
//$mobile = $_POST['mobile'];
$password = $_POST['password'];
$role= $_POST['role'];


$check=mysqli_query($connect,"SELECT* FROM users WHERE mobile='$mobile' AND password= '$password' AND role='$role'");

if(mysqli_num_rows($check)> 0 && $flag==1){
    $userdata=mysqli_fetch_array($check);
    $groups=mysqli_query($connect,"SELECT* FROM users WHERE role=2");
    $groupdata=mysqli_fetch_all($groups,MYSQLI_ASSOC);

    $_SESSION['userdata']= $userdata;
    $_SESSION['groupdata']=$groupdata;

    echo'
    <script>
    alert("sucessfully login");
    window.location="dashboard.php";
    </script>';
}

else{
    echo'
    <script>
    alert("Invalid Credentials");
    window.location="index.html";
    </script>';
}
