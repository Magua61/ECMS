<?php

// <!-- create connection to database -->
/** @var $pdo \PDO */
require_once "database.php";

$Household_ID = $_GET['Household_ID'] ?? null;
if (!$Household_ID) {
  header('Location: evacuees.php');
  exit;
}

$statement = $pdo->prepare('SELECT * FROM household WHERE Household_ID = :Household_ID');
$statement->bindValue(':Household_ID', $Household_ID);
$statement->execute();
$household2 = $statement->fetch(PDO::FETCH_ASSOC);

// if Name is empty, throw error because it is required
$errors = [];

// solution when Name etch is empty
$Household_ID = $household2['Household_ID'];
$Address = $household2['Address'];
$Family_Head = $household2['Family_Head'];
$Room_ID = $household2['Room_ID'];
$Date_Evacuated = $household2['Date_Evacuated'];

// show request method
// echo $_SERVER['REQUEST_METHOD']. '<br>';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//   $Household_ID = $_POST['Household_ID'];
  $Address = $_POST['Address'];
  $Family_Head = $_POST['Family_Head'];
  $Room_ID = $_POST['Room_ID'];
  $Date_Evacuated = $_POST['Date_Evacuated'];

  // if Name is empty, throw error because it is required
  if (!$Family_Head) {
    $errors[] = 'Please Enter Family_Head';
  }
  if (!$Room_ID) {
    $errors[] = 'Please Enter Room_ID';
  }
  if (!$Date_Evacuated) {
    $errors[] = 'Please Enter Date_Evacuated';
  }

  // Only Submit to sql when it is not empty
  if (empty($errors)) {
            $statement = $pdo->prepare("CALL updateHousehold(:Household_ID, :Address, :Family_Head, :Room_ID, :Date_Evacuated)");

    $statement->bindValue(':Household_ID', $Household_ID);
    $statement->bindValue(':Address', $Address);
    $statement->bindValue(':Family_Head', $Family_Head);
    $statement->bindValue(':Room_ID', $Room_ID);
    $statement->bindValue(':Date_Evacuated', $Date_Evacuated);
    $statement->execute();

    // redirect user after creating
    header('Location: evacuees.php');
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
                                <!-- // $Address = '';
                                // $Family_Head = '';
                                // $Room_ID = '';
                                // $Date_Evacuated = '';
                                // Household_ID -->
                <h2>---Update Household <?php echo $Household_ID?></h2>
                <form action="" method="post" enctype="multipart/form-data">
                <div class="add-evacuees-form">
                    <div class="add-evacuees-row-1">
                        <div class="Address">
                            <input type="text" name="Address" class="text-box" placeholder="Enter Address" value="<?php echo $Address ?>">
                            <h3 class="text-muted">Address</h3>
                        </div>

                        <div class="Family_Head">
                        <input type="text" name="Family_Head" class="text-box" placeholder="Enter Family_Head" value="<?php echo $Family_Head ?>">
                        <h3 class="text-muted">Family_Head</h3>
                        </div>

                        <div class="Room_ID">
                            <select name="Room_ID" value="<?php echo $Room_ID ?>"><br>
                                <option value="<?php echo $Room_ID ?>" selected="<?php echo $Room_ID ?>"><?php echo $Room_ID ?></option>
                                <option value="RM-001">RM-001</option>
                                <option value="RM-002">RM-002</option>
                                <option value="RM-003">RM-003</option>
                                <option value="RM-004">RM-004</option>
                                <option value="RM-005">RM-005</option>
                                <option value="RM-006">RM-006</option>
                                <option value="RM-007">RM-007</option>
                                <option value="RM-008">RM-008</option>
                                <option value="RM-009">RM-009</option>
                            </select>
                            <h3 class="text-muted">Room ID</h3>
                        </div>
                    </div>
                    <div class="add-evacuees-row-2">
                        <div>
                            <input type="date" name="Date_Evacuated" class="text-box" value="<?php echo $Date_Evacuated ?>">
                            <h3 class="text-muted">Date_Evacuated</h3>
                        </div>
                    </div>
                    <div class="add-evacuees-row-3">
                    </div>
                    <br>
                        <button type="submit" id="sub" class="btn btn-primary">Submit</button>
                        <a href="evacuees.php">Back</a>
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