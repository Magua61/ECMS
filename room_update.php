<?php

// <!-- create connection to database -->
/** @var $pdo \PDO */
/** @var $conn \PDO */
require_once "database.php";

$Room_ID = $_GET['Room_ID'] ?? null;
if (!$Room_ID) {
  header('Location: center.php');
  exit;
}

$statement = $pdo->prepare('SELECT * FROM room WHERE Room_ID = :Room_ID;');
$statement->bindValue(':Room_ID', $Room_ID);
$statement->execute();
$croom = $statement->fetch(PDO::FETCH_ASSOC);

// if Name is empty, throw error because it is required
$errors = [];

// solution when Name etch is empty
$Room_ID = $croom['Room_ID'];
$R_Name = $croom['R_Name'];
$Area_ID = $croom['Area_ID'];
$R_Total_Capacity = $croom['R_Total_Capacity'];

// show request method
// echo $_SERVER['REQUEST_METHOD']. '<br>';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//   $Room_ID = $_POST['Room_ID'];
  $R_Name = $_POST['R_Name'];
//   $Area_ID = $_POST['Area_ID'];
  $R_Total_Capacity = $_POST['R_Total_Capacity'];

  // if Name is empty, throw error because it is required
  if (!$R_Name) {
    $errors[] = 'Please Enter R_Name';
  }
  if (!$Area_ID) {
    $errors[] = 'Please Enter Area_ID';
  }
  if (!$R_Total_Capacity) {
    $errors[] = 'Please Enter R_Total_Capacity';
  }

  // Only Submit to sql when it is not empty
  if (empty($errors)) {
    $statement = $pdo->prepare("CALL updateRoom(:Room_ID, R_Name:, Area_ID:, R_Total_Capacity:)");
    // UPDATE room SET Room_ID = :Room_ID, 
    //                             R_Name = :R_Name, 
    //                             Area_ID = :Area_ID,
    //                             R_Total_Capacity = :R_Total_Capacity WHERE Room_ID = :Room_ID
    // CALL updateRoom(:Room_ID, R_Name:, Area_ID:, R_Total_Capacity:)
    // CALL updateEvacuee(:Evacuee_ID, :First_Name, :Middle_Name, :Last_Name, :Sex, :Birthday, :Contact_No, :Household_ID, :Evacuation_Status)
    $statement->bindValue(':Room_ID', $Room_ID);
    $statement->bindValue(':R_Name', $R_Name);
    $statement->bindValue(':Area_ID', $Area_ID);
    $statement->bindValue(':R_Total_Capacity', $R_Total_Capacity);
    $statement->execute();

    // redirect user after creating
    header('Location: center.php');
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

            <h1>Room Manager -> Update</h1>
            <div class="add-evacuees">
                <h2>---Update Room <?php echo $R_Name?></h2>
                <form action="" method="post" enctype="multipart/form-data">
                <div class="add-evacuees-form">
                    <div class="add-evacuees-row-1">

                                <div class="Room_ID">
                                <input type="text" name="Room_ID" class="text-box" value="<?php echo $Room_ID ?>" readonly>
                                <h3 class="text-muted">Room ID</h3>
                                </div>
                        <div class="firstname">
                        <input type="text" name="R_Name" class="text-box" placeholder="Enter Room Name" value="<?php echo $R_Name ?>">
                        <h3 class="text-muted">Room Name</h3>
                        </div>

                        <div class="Area_ID-field">
                        <select name="Area_ID" value="<?php echo $Area_ID ?>"><br>
                            <option value="none" selected disabled hidden>Select an Option</option>
                            <option value="A-0001">A-0001</option>
                            <option value="A-0002">A-0002</option>
                        </select>
                        <h3 class="text-muted">Area ID</h3>
                        </div>
                    </div>
                    <div class="add-evacuees-row-2">
                        <div class="roomcapacity">
                        <input type="numer" name="R_Total_Capacity" class="text-box" placeholder="Enter Room Name" value="<?php echo $R_Total_Capacity ?>">
                        <h3 class="text-muted">Room_Total_Capacity</h3>
                        </div>
                        
                    
                    </div>
                    <div class="add-evacuees-row-3"></div>
                    <br>
                        <button type="submit" id="sub" class="btn btn-primary">Submit</button>
                        <a href="center.php">Back</a>
                    </div>
                </form>
                </div>
            </div>
        </main>
        <!  ------------------- END OF MAIN -----------------------  !>



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