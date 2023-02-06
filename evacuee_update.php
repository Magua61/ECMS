<?php

// <!-- create connection to database -->
/** @var $pdo \PDO */
require_once "database.php";

$Evacuee_ID = $_GET['Evacuee_ID'] ?? null;
if (!$Evacuee_ID) {
  header('Location: index.php');
  exit;
}

$statement = $pdo->prepare('SELECT * FROM evacuee WHERE Evacuee_ID = :Evacuee_ID');
$statement->bindValue(':Evacuee_ID', $Evacuee_ID);
$statement->execute();
$evacuee2 = $statement->fetch(PDO::FETCH_ASSOC);

// if Name is empty, throw error because it is required
$errors = [];

// solution when Name etch is empty
$First_Name = $evacuee2['First_Name'];
$Middle_Name = $evacuee2['Middle_Name'];
$Last_Name = $evacuee2['Last_Name'];
$Sex = $evacuee2['Sex'];
$Birthday = $evacuee2['Birthday'];
$Contact_No = $evacuee2['Contact_No'];
$Evacuation_Status = $evacuee2['Evacuation_Status'];
$Household_ID = $evacuee2['Household_ID'];

// show request method
// echo $_SERVER['REQUEST_METHOD']. '<br>';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $First_Name = $_POST['First_Name'];
  $Last_Name = $_POST['Last_Name'];
  $Sex = $_POST['Sex'];
  $Birthday = $_POST['Birthday'];
  $Contact_No = $_POST['Contact_No'];
  $Evacuation_Status = $_POST['Evacuation_Status'];
  $Household_ID = $_POST['Household_ID'];

  // if Name is empty, throw error because it is required
  if (!$First_Name) {
    $errors[] = 'Please Enter First Name';
  }
  if (!$Last_Name) {
    $errors[] = 'Please Enter Last Name';
  }
  if (!$Sex) {
    $errors[] = 'Please Enter Gender';
  }
  if (!$Birthday) {
    $errors[] = 'Please Enter Birthday';
  }
  if (!$Contact_No) {
    $errors[] = 'Please Enter Contact No';
  }
  if (!$Evacuation_Status) {
    $errors[] = 'Please Enter Evacuation Status';
  }
  if (!$Household_ID) {
    $errors[] = 'Please Enter Household_ID';
  }

  // Only Submit to sql when it is not empty
  if (empty($errors)) {

    $statement = $pdo->prepare("CALL updateEvacuee(:Evacuee_ID, :First_Name, :Middle_Name, :Last_Name, :Sex, :Birthday, :Contact_No, :Household_ID, :Evacuation_Status);");
    $statement->bindValue(':Evacuee_ID', $Evacuee_ID);
    $statement->bindValue(':First_Name', $First_Name);
    $statement->bindValue(':Middle_Name', $Middle_Name);
    $statement->bindValue(':Last_Name', $Last_Name);
    $statement->bindValue(':Sex', $Sex);
    $statement->bindValue(':Birthday', $Birthday);
    $statement->bindValue(':Contact_No', $Contact_No);
    $statement->bindValue(':Household_ID', $Household_ID);
    $statement->bindValue(':Evacuation_Status', $Evacuation_Status);
    $statement->execute();

    // redirect user after creating
    header('Location: index.php');
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ECMS</title>
    <link href="https://fonts.googleapis.com/css2?family=Material+Icons+Sharp"
      rel="stylesheet">
   <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <aside>
            <div class="top">
                <div class ="logo">
                    <img src="assets/logo.png">
                    <h2>ECMS</h2>
                </div>
                <div class="close" id="close-btn">
                    <span class="material-icons-sharp">close</span>
                </div>
            </div>

            <div class ="sidebar">
                <a href="index.php" class="btn-dashboard">
                    <span class="material-icons-sharp">grid_view</span>
                    <h3>Dashboard</h3>
                </a>
                <a href="center.php" class = "btn-center">
                    <span class="material-icons-sharp">apartment</span>
                    <h3>Center</h3>
                </a>
                <a href="#" class="btn-evacuees active">
                    <span class="material-icons-sharp">group</span>
                    <h3>Evacuees</h3>
                </a>
                <a href="inventory.php" class="btn-inventory">
                    <span class="material-icons-sharp">inventory</span>
                    <h3>Inventory</h3>
                </a>
                <a href="#" class="btn-settings">
                    <span class="material-icons-sharp">settings</span>
                    <h3>Settings</h3>
                </a>

                <a href="#" class="btn-logout">
                    <span class="material-icons-sharp">logout</span>
                    <h3>Logout</h3>
                </a>
            </div>
        </aside>
        <!===================== END OF ASIDE =======================!>

        <main>

            <h1>Evacuee Manager -> Update</h1>
            <div class="add-evacuees">
                <h2>---Update Evacuee <?php echo $First_Name. ' '. $Middle_Name. ' '. $Last_Name?></h2>
                <form action="evacuees.php" method="post" enctype="multipart/form-data">
                <div class="add-evacuees-form">
                    <div class="add-evacuees-row-1">
                        <div class="firstname">
                        <input type="text" name="First_Name" class="text-box" placeholder="Enter First Name" value="<?php echo $First_Name ?>">
                        <h3 class="text-muted">First Name</h3>
                        </div>

                        <div class="middlename">
                        <input type="text" name="Middle_Name" class="text-box" placeholder="Enter Middle Name" value="<?php echo $Middle_Name ?>">
                        <h3 class="text-muted">Middle Name</h3>
                        </div>

                        <div class="lastname">
                        <input type="text" name="Last_Name" class="text-box" placeholder="Enter Last Name" value="<?php echo $Last_Name ?>">
                        <h3 class="text-muted">Last Name</h3>
                        </div>
                    </div>
                    <div class="add-evacuees-row-2">
                        <div>
                        <input type="date" name="Birthday" class="text-box" value="<?php echo $Birthday ?>">
                        <h3 class="text-muted">Birthday</h3>
                        </div>
                        
                        <div>
                        <select name="Sex" value="<?php echo $Sex ?>">
                            <option value="M">Male</option>
                            <option value="F">Female</option>
                        </select>
                        <h3 class="text-muted">Sex</h3>
                        </div>
                        <div>
                        <input type="text" name="Contact_No" class="text-box" placeholder="Enter Contact" value="<?php echo $Contact_No ?>">
                        <h3 class="text-muted">Contact No</h3>
                        </div>
                        <div class="household-field">
                        <select name="Household_ID" value="<?php echo $Household_ID ?>"><br>
                            <option value="HHOLD-0001">HHOLD-0001</option>
                            <option value="HHOLD-0002">HHOLD-0002</option>
                            <option value="HHOLD-0003">HHOLD-0004</option>
                            <option value="HHOLD-0004">HHOLD-0005</option>
                            <option value="HHOLD-0005">HHOLD-0006</option>
                            <option value="HHOLD-0006">HHOLD-0006</option>
                            <option value="HHOLD-0007">HHOLD-0007</option>
                            <option value="HHOLD-0008">HHOLD-0008</option>
                            <option value="HHOLD-0009">HHOLD-0009</option>
                        </select>
                        <h3 class="text-muted">Household ID</h3>
                        </div>
                    </div>
                    <div class="add-evacuees-row-3">
                        <div class="household-field">
                            <select name="Household_ID" value="<?php echo $Evacuation_Status ?>"><br>
                                <option value="EVACUATED">EVACUATED</option>
                                <option value="DEPARTED">DEPARTED</option>
                                <option value="DIED">DIED</option>
                            </select>
                            <h3 class="text-muted">Evacuation Status</h3>
                        </div></div>
                    <br>
                        <button type="submit" id="sub" class="btn btn-primary">Submit</button>
                        <a href="evacuees.php">Back</a>
                    </div>
                </form>
                </div>
            </div>
        </main>
        <!  ------------------- END OF MAIN -----------------------  !>

        <div class="right">
            <div class="top">
                <button id="menu-btn">
                    <span class= "material-icons-sharp">menu</span>
                </button>
                <div class="theme-toggler">
                    <span class= "material-icons-sharp active">light_mode</span>
                    <span class= "material-icons-sharp">dark_mode</span>
                </div>
                <div class="profile">
                    <div class="info">
                        <p>Hey, <b>Daniel</b></p>
                        <small class="text-muted">Admin</small>
                    </div>
                    <div class="profile-photo">
                        <img src="assets/profile-1.jpg">
                    </div>
                </div>

            </div>
            <! ---------------- End of Top ---------------- !>
            <div class="recent-announcements">
                <h2>Announcements</h2>
                <div class="announcements">
                    <div class="announcement">
                        <div class="profile-photo">
                            <img src="assets/profile-2.jpg">
                        </div>
                        <div class="message">
                            <p><b>NDRRMC</b> Alert Level 3 in Metro Manila and surrounding regions.</p>
                            <small class="text-muted">4 Minutes Ago</small>
                        </div>
                    </div>

                    <div class="announcement">
                        <div class="profile-photo">
                            <img src="assets/profile-2.jpg">
                        </div>
                        <div class="message">
                            <p><b>NDRRMC</b> Alert Level 4 in North Luzon and Central Luzon regions.</p>
                            <small class="text-muted">6 Minutes Ago</small>
                        </div>
                    </div>

                    <div class="announcement">
                        <div class="profile-photo">
                            <img src="assets/profile-2.jpg">
                        </div>
                        <div class="message">
                            <p><b>NDRRMC</b> Alert Level 2 in South Luzon and Northern Visayas regions.</p>
                            <small class="text-muted">11 Minutes Ago</small>
                        </div>
                    </div>
                </div>
            </div>
            <! ---------------- End of Announcements ---------------- !>
                <div class="evac-analytics">
                    <h2>Analytics</h2>
                    <div class="evacuee analysis">
                        <div class="icon">
                            <span class= "material-icons-sharp">groups</span>
                        </div>
                        <div class="right">
                            <div class="info">
                                <h3>EVACUEES</h3>
                                <small class="text-muted">Last 24 Hours</small>
                            </div>
                            <h5 class="success">+26%</h5>
                            <h3>854</h3>
                        </div>
                    </div>

                    <div class="volunteer analysis">
                        <div class="icon">
                            <span class="material-icons-sharp">volunteer_activism</span>
                        </div>
                        <div class="right">
                            <div class="info">
                                <h3>VOLUNTEERS</h3>
                                <small class="text-muted">Last 24 Hours</small>
                            </div>
                            <h5 class="danger">-15%</h5>
                            <h3>23</h3>
                        </div>
                    </div>

                    <div class="inventory analysis">
                        <div class="icon">
                            <span class= "material-icons-sharp">set_meal</span>
                        </div>
                        <div class="right">
                            <div class="info">
                                <h3>RELIEF GOODS</h3>
                                <small class="text-muted">Last 24 Hours</small>
                            </div>
                            <h5 class="warning">+0.7%</h5>
                            <h3>1,523</h3>
                        </div>
                    </div>

                </div>

        </div>
    </div>

    

    <script>
    const sideMenu = document.querySelector("aside");
    const menuBtn = document.querySelector("#menu-btn");
    const closeBtn = document.querySelector("#close-btn");
    const themeToggler = document.querySelector(".theme-toggler");


    // open sidebar
    menuBtn.addEventListener('click', () =>{
        sideMenu.style.display = 'block';
    })

    // close sidebar
    closeBtn.addEventListener('click', () =>{
        sideMenu.style.display = 'none';
    })

    // change theme
    themeToggler.addEventListener('click', () =>{
        document.body.classList.toggle('dark-theme-variables');

        themeToggler.querySelector('span:nth-child(1)').classList.toggle('active');
        themeToggler.querySelector('span:nth-child(2)').classList.toggle('active');
    })

</script>
</body>
</html>