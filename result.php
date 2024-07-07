<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PG</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <form class="filters" action="result.php" method="post">
        <a href="index.html" class="icon">
            <img src="./assets/images/home.png" alt="home-icon" />
        </a>
        <div class="locality">
            <label for="locality">Locality:</label>
            <input type="text" id="locality" class="filter" name="locality">
        </div>

        <div class="ac">
            <label for="ac">AC:</label>
            <select id="ac" class="filter" name="ac">
                <option value="yes">Yes</option>
                <option value="no">No</option>
            </select>
        </div>

        <div class="wifi">
            <label for="wifi">WiFi:</label>
            <select id="wifi" class="filter" name="wifi">
                <option value="yes">Yes</option>
                <option value="no">No</option>
            </select>
        </div>

        <div class="capacity">
            <label for="capacity">Capacity:</label>
            <input type="number" id="capacity" class="filter" name="capacity">
        </div>

        <div class="min-rent">
            <label for="min-rent">Min Rent:</label>
            <input type="number" id="min-rent" class="filter" name="rent_min">
        </div>

        <div class="max-rent">
            <label for="max-rent">Max Rent:</label>
            <input type="number" id="max-rent" class="filter" name="rent_max">
        </div>

        <input type="submit" value="Apply Filters">
    </form>

    <div class="container">
        <h1>Here are the PG's according to your filters</h1>

        <div class='grid'>
            <!-- <div class='card'>
                <div class='image-and-name'>
                    <img src="./assets/images/PG-example-2.png" alt="PG room">
                    <h2 class='PG-name'> Krishna PG </h2>
                </div>
                <div class='other-details'>
                    <p class="address">F-567 NW Bobcat Lane, Dwarka Mor, New Delhi</p>
                    <div class="owner-details">
                        <h2>Owner Details:</h2>
                        <p class="owner-name">Ramesh Gaonkar</p>
                        <p class="owner-phone-number">+911234567890</p>
                        <p class="owner-email">ramesh_gaonkar@gmail.com</p>
                    </div>
                    <p class="capacity"><span class="capacity-amount"> Capacity: 2 </span></p>
                    <p class="AC-wifi">AC, Wifi</p>
                    <p class="rent">Rent: <span class="rent-amount">₹5000</span></p>
                    
                </div>
            </div>
        
            <div class='card'>
                <div class='image-and-name'>
                    <img src="./assets/images/PG-example-3.png" alt="PG room">
                    <h2 class='PG-name'> Krishna PG </h2>
                </div>
                <div class='other-details'>
                    <p class="address">F-567 NW Bobcat Lane, Dwarka Mor, New Delhi</p>
                    <div class="owner-details">
                        <h2>Owner Details:</h2>
                        <p class="owner-name">Ramesh Gaonkar</p>
                        <p class="owner-phone-number">+911234567890</p>
                        <p class="owner-email">ramesh_gaonkar@gmail.com</p>
                    </div>
                    <p class="capacity"><span class="capacity-amount"> Capacity: 2 </span></p>
                    <p class="AC-wifi">AC, Wifi</p>
                    <p class="rent">Rent: <span class="rent-amount">₹5000</span></p>
                    
                </div>
            </div>
        
            <div class='card'>
                <div class='image-and-name'>
                    <img src="./assets/images/PG-example-4.png" alt="PG room">
                    <h2 class='PG-name'> Krishna PG </h2>
                </div>
                <div class='other-details'>
                    <p class="address">F-567 NW Bobcat Lane, Dwarka Mor, New Delhi</p>
                    <div class="owner-details">
                        <h2>Owner Details:</h2>
                        <p class="owner-name">Ramesh Gaonkar</p>
                        <p class="owner-phone-number">+911234567890</p>
                        <p class="owner-email">ramesh_gaonkar@gmail.com</p>
                    </div>
                    <p class="capacity"><span class="capacity-amount"> Capacity: 2 </span></p>
                    <p class="AC-wifi">AC, Wifi</p>
                    <p class="rent">Rent: <span class="rent-amount">₹5000</span></p>
                    
                </div>
            </div> -->
        
            <?php
            // Database connection
            $servername = "localhost"; // Change it if your MySQL server is on a different host
            $username = "root"; // Your MySQL username
            $password = ""; // Your MySQL password
            $dbname = "PGFINDER"; // Your database name

            $conn = new mysqli($servername, $username, $password, $dbname);

            // Check connection
            if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
            }

            // Storing data received from POST method in variables
            $locality = trim($_POST['locality']);
            $ac = $_POST['ac'];
            $wifi = $_POST['wifi'];
            $capacity = $_POST['capacity'];
            $rent_min = $_POST['rent_min'];
            $rent_max = $_POST['rent_max'];

            // Building the SQL query
            $query = "SELECT * FROM OWNER natural join PG natural join ROOM WHERE ";
            
            // Conditions for AC and Wifi
            $query = $query . "ac = ";
            if ($ac == 'yes'){
                $query = $query . 'TRUE';
            }
            else{
                $query = $query . 'FALSE';
            }
            $query = $query . " and wifi = ";
            if ($wifi == 'yes'){
                $query = $query . 'TRUE';
            }
            else{
                $query = $query . 'FALSE';
            }

            // Condition for locality
            if (trim($locality) != ""){
                $query = $query . " and locality = '$locality'";
            }
            
            // Condition for capacity
            if ($capacity != ""){
                $query = $query . " and capacity = $capacity";
            }
            
            // Condition for minimum rent
            if ($rent_min != ""){
                $query = $query . " and $rent_min <= rent_per_month";
            }
            
            // Condition for maximum rent
            if ($rent_max != ""){
                $query = $query . " and rent_per_month <= $rent_max";
            }

            $query = $query . ';';
            

            // Uncomment to peek at the query which will be executed
            // echo $query;
            
            // Retrieving and storing data from database
            $data = [];

            $result = $conn->query($query);
            $row = $result->fetch_assoc();
            for ($i=0; $i < $result->num_rows; $i++) { 
                $currentPGData = array();
                $currentPGData['owner_name'] = $row['first_name'] . " " . $row['last_name'];
                $currentPGData['pg_name'] = $row['pg_name'];
                $currentPGData['address'] = $row['house_number'] . " " . $row['street'] . ", " . $row['locality'] . ", " . $row['city'];
                $currentPGData['room_id'] = $row['room_id'];
                $currentPGData['rent_per_month'] = $row['rent_per_month'];
                $currentPGData['capacity'] = $row['capacity'];
                $currentPGData['ac'] = $row['ac'];
                $currentPGData['wifi'] = $row['wifi'];

                // Getting phone numbers
                $phone_numbers = array();
                $phoneResult = $conn->query("SELECT * FROM OWNER_PHONE_NUMBER WHERE owner_id = " . $row['owner_id']);
                $phoneRow = $phoneResult->fetch_assoc();
                for ($j=0; $j < $phoneResult->num_rows; $j++) { 
                    array_push($phone_numbers, $phoneRow['phone_number']);
                    $phoneRow = $phoneResult->fetch_assoc();
                }
                $currentPGData['phone_numbers'] = $phone_numbers;

                // Getting email ids
                $email_ids = array();
                $emailResult = $conn->query("SELECT * FROM OWNER_EMAIL_ID WHERE owner_id = " . $row['owner_id']);
                $emailRow = $emailResult->fetch_assoc();
                for ($j=0; $j < $emailResult->num_rows; $j++) {
                    array_push($email_ids, $emailRow['email_id']);
                    $emailRow = $emailResult->fetch_assoc();
                }
                $currentPGData['email_ids'] = $email_ids;


                array_push($data, $currentPGData);
                $row = $result->fetch_assoc();
            }

            // // Use this for displaying array in raw form
            // echo "<br><br><br>";
            // foreach ($data as $key => $value) {
            //     print_r($value);
            //     echo "<br><br><br>";
            // }

            // Building all the cards
            foreach ($data as $key => $currentData) {
                $htmlCodeForCurrentCard = '
                <div class="card">
                    <div class="image-and-name">
                        <img src="./assets/images/room' . $currentData['room_id'] . '.png" alt="PG room">
                        <h2 class="PG-name">' . $currentData['pg_name'] . '</h2>
                    </div>
                    <div class="other-details">
                        <p class="address">' . $currentData['address'] . '</p>
                        <div class="owner-details">
                            <h2>Owner Details:</h2>
                            <p class="owner-name">' . $currentData['owner_name'] . '</p>
                            <p class="owner-phone-number">';
                
                $htmlCodeForCurrentCard = $htmlCodeForCurrentCard . $currentData['phone_numbers'][0];
                for ($i=1; $i < sizeof($currentData['phone_numbers']); $i++) { 
                    $htmlCodeForCurrentCard = $htmlCodeForCurrentCard . '<br>' . $currentData['phone_numbers'][$i];
                }
                            
                $htmlCodeForCurrentCard = $htmlCodeForCurrentCard . '
                            </p>
                            <p class="owner-email">
                ';
                
                $htmlCodeForCurrentCard = $htmlCodeForCurrentCard . $currentData['email_ids'][0];
                for ($i=1; $i < sizeof($currentData['email_ids']); $i++) { 
                    $htmlCodeForCurrentCard = $htmlCodeForCurrentCard . '<br>' . $currentData['email_ids'][$i];
                }
                            
                $htmlCodeForCurrentCard = $htmlCodeForCurrentCard . '
                            </p>
                        </div>
                        <p class="capacity"><span class="capacity-amount"> Capacity:' . $currentData['capacity'] . '</span></p>
                        <p class="AC-wifi">';

                if ($currentData['ac'] == 1){
                    $htmlCodeForCurrentCard = $htmlCodeForCurrentCard . "AC, ";
                }
                else{
                    $htmlCodeForCurrentCard = $htmlCodeForCurrentCard . "No AC, ";
                }

                if ($currentData['wifi'] == 1){
                    $htmlCodeForCurrentCard = $htmlCodeForCurrentCard . "Wifi";
                }
                else{
                    $htmlCodeForCurrentCard = $htmlCodeForCurrentCard . "No Wifi";
                }
                
                $htmlCodeForCurrentCard = $htmlCodeForCurrentCard . '
                        </p>
                        <p class="rent">Rent: <span class="rent-amount">₹' . $currentData['rent_per_month'] . '</span></p>
                        
                    </div>
                </div>
                ';
                
                echo $htmlCodeForCurrentCard;
            }

            ?>
        </div>
    </div>
</body>
</html>

    
