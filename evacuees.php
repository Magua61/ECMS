<?php

// <!-- create connection to database -->
/** @var $pdo \PDO */
require_once "database.php";
require_once "household_add.php";
require_once "evacuee_add.php";

// you can use exec() but not good, only to make changes on database schema
// to select                CALL addEvacuee(:First_Name, :Middle_Name, :Last_Name, :Sex, :Birthday, :Contact_No, :Household_ID);
// $statement = $pdo->prepare("CALL ViewEvacuee();");

// search function for evacuee
$search = $_GET['search'] ?? '';
if ($search) {
  $statement = $pdo->prepare('call searchEvacuee(:First_Name)');
  $statement->bindValue(':First_Name', "%$search%");
} else{
  $statement = $pdo->prepare('CALL viewEvacueeJoinHousehold');
}


// // search function for household
// $search2 = $_GET['search2'] ?? '';
// if ($search2) {
//   $statement = $pdo->prepare('call searchEvacuee(:First_Name)');
//   $statement->bindValue(':First_Name', "%$search2%");
// } else{
//   $statement = $pdo->prepare('CALL viewEvacueeJoinHousehold');
// }
$statement2 = $pdo->prepare('CALL viewHousehold');
$statement2->execute();
$statement->closeCursor();
$statement->execute();
$evacuee = $statement->fetchAll(PDO::FETCH_ASSOC);
$household = $statement2->fetchAll(PDO::FETCH_ASSOC);

// if FirstName is empty, throw error because it is required
$errors = [];
$errors2 = [];

// // Create Evacuee
// // solution when FirstName, etc is empty
// $First_Name = '';
// $Middle_Name = '';
// $Last_Name = '';
// $Sex = '';
// $Birthday = '';
// $Contact_No = '';
// $Household_ID = '';

// // show request method
// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//   $First_Name = $_POST['First_Name'];
//   $Middle_Name = $_POST['Middle_Name'];
//   $Last_Name = $_POST['Last_Name'];
//   $Sex = $_POST['Sex'];
//   $Birthday = $_POST['Birthday'];
//   $Contact_No = $_POST['Contact_No'];
//   $Household_ID = $_POST['Household_ID'];


//   // if FirstName is empty, throw error because it is required
//   if (!$First_Name) {
//     $errors[] = 'Please enter your First Name';
//   }
//   if (!$Last_Name) {
//     $errors[] = 'Please enter your Last Name';
//   }
//   if (!$Sex) {
//     $errors[] = 'Please enter your Gender';
//   }
//   if (!$Contact_No) {
//     $errors[] = 'Please enter your Contact No';
//   }

//   // Only Submit to sql when it is not empty
//   if (empty($errors)) {

//     // double quotations are used so I can use variables in strings
//     // exec() instead of prepare() should be avoided because it is unsafe
//     // I created named parameters
//     $statement = $pdo->prepare("CALL addEvacuee(:First_Name, :Middle_Name, :Last_Name, :Sex, :Birthday, :Contact_No, :Household_ID);
                                
//                   ");
//                 //   SELECT Household_ID FROM dagdaghh ORDER BY Household_ID ASC
//     $statement->bindValue(':First_Name', $First_Name);
//     $statement->bindValue(':Middle_Name', $Middle_Name);
//     $statement->bindValue(':Last_Name', $Last_Name);
//     $statement->bindValue(':Sex', $Sex);
//     $statement->bindValue(':Birthday', $Birthday);
//     $statement->bindValue(':Contact_No', $Contact_No);
//     $statement->bindValue(':Household_ID', $Household_ID);
//     $statement->execute();

//     // redirect user after creating
//     header('Location: evacuees.php');
//   }
// }

// // Create Household
// // if FirstName is empty, throw error because it is required
// $errors2 = [];
// // solution when FirstName, etc is empty
// $Address = '';
// $Family_Head = '';
// $Room_ID = '';
// $Date_Evacuated = '';

// // show request method
// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//   $Address = $_POST['Address'];
//   $Family_Head = $_POST['Family_Head'];
//   $Room_ID = $_POST['Room_ID'];
//   $Date_Evacuated = $_POST['Date_Evacuated'];
  

//   // if FirstName is empty, throw error because it is required
//   if (!$Address) {
//     $errors[] = 'Please enter Address';
//   }
//   if (!$Date_Evacuated) {
//     $errors[] = 'Please enter Date_Evacuated';
//   }
//   if (!$Room_ID) {
//     $errors[] = 'Please enter Room_ID';
//   }


//   // Only Submit to sql when it is not empty
//   if (empty($errors2)) {

//     // double quotations are used so I can use variables in strings
//     // exec() instead of prepare() should be avoided because it is unsafe
//     // I created named parameters
//     // CALL addHousehold('Dolores', NULL, 'RM-002', '2023-02-14');
//     $statement2 = $pdo->prepare("CALL addEvacuee(:Address, :Family_Head, :Room_ID, :Date_Evacuated);
//                   ");

//     $statement2->bindValue(':Address', $Address);
//     $statement2->bindValue(':Family_Head', $Family_Head);
//     $statement2->bindValue(':Room_ID', $Room_ID);
//     $statement2->bindValue(':Date_Evacuated', $Date_Evacuated);
//     $statement2->execute();

//     // redirect user after creating
//     header('Location: evacuees.php');
//   }
// }
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

            <h1>Evacuee Manager</h1>
            <div class="add-evacuees">
                <h2>---Add Evacuees</h2>
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
                            <option value="HHOLD-0003">HHOLD-0003</option>
                            <option value="HHOLD-0004">HHOLD-0004</option>
                            <option value="HHOLD-0005">HHOLD-0005</option>
                            <option value="HHOLD-0006">HHOLD-0006</option>
                            <option value="HHOLD-0007">HHOLD-0007</option>
                            <option value="HHOLD-0008">HHOLD-0008</option>
                            <option value="HHOLD-0009">HHOLD-0009</option>
                        </select>
                        <h3 class="text-muted">Household ID</h3>
                        </div>
                    </div>
                    <div class="add-evacuees-row-3">
                        
                        <button type="submit" id="sub" class="btn btn-primary">Submit</button>
                        <a href="evacuees.php">Clear</a>
                    </div>
                </form>
                </div>
            </div>

            <!-- Start of household -->
            <div class="recent-updates">
                <h2>Household Information</h2>
                    <form>
                    <div class="input-group mb-3">
                        <!-- Search household -->
                        <!-- <input type="text" class="form-control" 
                                placeholder="Search for Household" 
                                name="search2" value="<?php //echo $search2 ?>"> -->
                        <div class="input-group-append">
                        <!-- <button class="btn btn-outline-secondary" type="submit">Search</button> -->
                        <!-- <button class="btn btn-outline-secondary" type="submit" style="float: right;">View By Household</button> -->
                        </div>
                    </div>
                    </form>
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Number of Members</th>
                        <th scope="col">Address</th>
                        <th scope="col">Family_Head</th>
                        <!-- <th scope="col">Contact_No</th> -->
                        <th scope="col">Room_ID</th>
                        <th scope="col">Date_Evacuated</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($household as $j => $hh) :
                    ?>
                        <tr>
                        <td scope="row"><?php echo $hh['Household_ID'] ?></td>
                        <td><?php echo $hh['Number_of_Members'];?></td>
                        <td><?php echo $hh['Address'] ?></td>
                        <td><?php echo $hh['Family_Head'] ?></td>
                        <td><?php echo $hh['Room_ID'] ?></td>
                        <td><?php echo $hh['Date_Evacuated'] ?></td>

                        <td>
                            <!-- Edit button -->
                            <a href="household_update.php?Household_ID=<?php echo $hh['Household_ID'] ?>" id="sub" class="btn btn-primary">Edit</a>

                            
                            <!-- Delete button -->
                            <form style="display:inline-block" method="post" action="household_delete.php">
                            <input type="hidden" name="Household_ID" value="<?php echo $hh['Household_ID'] ?>">
                            <button type="submit">Delete</button>
                            
                            </form>
                        </td>

                        </tr>
                    <?php
                    endforeach;
                    ?>

                    </tbody>
                </table>
                <a href="#">Show All</a>
            <!-- End of Household -->
            </div>

            <div class="recent-updates">
                <h2>Evacuees' Information</h2>
                    <form>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" 
                                placeholder="Search for Evacuee Full Name" 
                                name="search" value="<?php echo $search ?>">
                        <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="submit">Search</button>
                        <!-- <button class="btn btn-outline-secondary" type="submit" style="float: right;">View By Household</button> -->
                        </div>
                    </div>
                    </form>
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Full Name</th>
                        <th scope="col">Sex</th>
                        <th scope="col">Age</th>
                        <!-- <th scope="col">Contact_No</th> -->
                        <th scope="col">Status</th>
                        <th scope="col">Household_ID</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($evacuee as $i => $evacuee2) :
                    ?>
                        <tr>
                        <td scope="row"><?php echo $evacuee2['Evacuee_ID'] ?></td>
                        <td><?php echo $evacuee2['Full_Name'];?></td>
                        <td><?php echo $evacuee2['Sex'] ?></td>
                        <td><?php echo $evacuee2['Age'] ?></td>
                        <!-- <td><?php echo $evacuee2['Contact_No'] ?></td> -->
                        <td><?php echo $evacuee2['Evacuation_Status'] ?></td>
                        <td><?php echo $evacuee2['Household_ID'] ?></td>

                        <td>
                            <!-- Edit button -->
                            <a href="evacuee_update.php?Evacuee_ID=<?php echo $evacuee2['Evacuee_ID'] ?>" id="sub" class="btn btn-primary">Edit</a>

                            
                            <!-- Delete button -->
                            <form style="display:inline-block" method="post" action="evacuee_delete.php">
                            <input type="hidden" name="Evacuee_ID" value="<?php echo $evacuee2['Evacuee_ID'] ?>">
                            <button type="submit">Delete</button>
                            
                            </form>
                        </td>

                        </tr>
                    <?php
                    endforeach;
                    ?>

                    </tbody>
                </table>
                <a href="#">Show All</a>
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
                <h2>Add Evacuees</h2>
                <div class="announcements">
                    <form action="evacuee_add.php" method="post" enctype="multipart/form-data">
                    <div class="add-evacuees-form">
                            <div class="firstname">
                                <input type="text" name="First_Name" class="text-box" placeholder="Enter First Name" value="<?php echo $First_Name ?>">
                                <h3 class="text-muted">First Name</h3><br>
                            </div>
    
                            <div class="middlename">
                            <input type="text" name="Middle_Name" class="text-box" placeholder="Enter Middle Name" value="<?php echo $Middle_Name ?>">
                                <h3 class="text-muted">Middle Name</h3><br>
                            </div>
    
                            <div class="lastname">
                            <input type="text" name="Last_Name" class="text-box" placeholder="Enter Last Name" value="<?php echo $Last_Name ?>">
                                <h3 class="text-muted">Last Name</h3>
                            </div>

                        <div class="add-evacuees-row">
                            
                            <div>
                                <select name="Sex" value="<?php echo $Sex ?>">
                                    <option value="M">Male</option>
                                    <option value="F">Female</option>
                                </select>
                                <h3 class="text-muted">Sex</h3>
                            </div>
                        <!-- Close row -->
                        </div>
                            <div>
                                <input type="date" name="Birthday" class="text-box" value="<?php echo $Birthday ?>">
                                <h3 class="text-muted">Birthday</h3>
                            </div>

                            <div>
                            <input type="text" name="Contact_No" class="text-box" placeholder="Enter Contact Number" value="<?php echo $Contact_No ?>">
                                <h3 class="text-muted">Contact No</h3>
                            </div>
                        
                        <div class="add-evacuees-row-3">
                            <div class="household-field">
                                <select name="Household_ID" value="<?php echo $Household_ID ?>"><br>
                                    <option value="HHOLD-0001">HHOLD-0001</option>
                                    <option value="HHOLD-0002">HHOLD-0002</option>
                                    <option value="HHOLD-0003">HHOLD-0003</option>
                                    <option value="HHOLD-0004">HHOLD-0004</option>
                                    <option value="HHOLD-0005">HHOLD-0005</option>
                                    <option value="HHOLD-0006">HHOLD-0006</option>
                                    <option value="HHOLD-0007">HHOLD-0007</option>
                                    <option value="HHOLD-0008">HHOLD-0008</option>
                                    <option value="HHOLD-0009">HHOLD-0009</option>
                                </select>
                                <h3 class="text-muted">Household</h3>
                            <!-- Close household-field -->
                            </div>
                            <!-- Buttons -->
                            <button type="submit" id="sub" class="btn btn-primary">Submit</button>
                            <a href="evacuees.php">Clear</a>
                        <!-- close add-evacuees-row-3 -->
                        </div>
                    </div>
                    </form>
                <!-- Close Announcements -->
                </div>
            <!-- Close recent Announcements -->
            </div>
            <! ------------------ End of Add Evacuees ---------------- !>
            <! ---------------- End of Announcements ---------------- !>
            <div class="recent-announcements">
            <!-- CALL addHousehold('Dolores', NULL, 'RM-002', '2023-02-14'); -->
            <form action="household_add.php" method="post" enctype="multipart/form-data">
                <h2>Add Household</h2>
                <div class="announcements">
                    <div class="add-household-form">
                            <div class="Address">
                                <input type="text" name="Address" class="text-box" placeholder="Enter Address" value="<?php echo $Address ?>">
                                <h3 class="text-muted">Address</h3>
                            </div>

                            <div class="Family_Head">
                                <input type="text" name="Family_Head" class="text-box" placeholder="Enter Family_Head" value="<?php echo $Family_Head ?>">
                                <h3 class="text-muted">Family Head</h3>
                            </div>

                            <div class="Room_ID-field">
                                <select name="Room_ID" value="<?php echo $Room_ID ?>" ><br>
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

                            <div>
                                <input type="date" name="Date_Evacuated" class="text-box" value="<?php echo $Date_Evacuated ?>">
                                <h3 class="text-muted">Date Evacuated</h3>
                            </div>

                        <button type="submit" id="sub" class="btn btn-primary">Submit</button>
                        <a href="evacuees.php">Clear</a>
                    </div>
            </form>
                </div> 
                <div class="modal" id="modal-create-head">
                    <div class="modal-header">
                        
                      <div class="title"><span class= "material-icons-sharp">person_add</span>
                        <h2>Create Head</h2>
                        <h3 class="text-muted" id="room-id-edit"> </h3>
                    </div>
                      <button data-close-button class="close-button"><span class="material-icons-sharp">close</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="modal-body-input">
                            <input type="text" name="name" class="text-box" placeholder="First Name">
                            <h3 class="text-muted">First Name</h3>

                            <input type="text" name="name" class="text-box" placeholder="Middle Name">
                            <h3 class="text-muted">Middle Name</h3>

                            <input type="text" name="name" class="text-box" placeholder="Last Name">
                            <h3 class="text-muted">Last Name</h3>

                            <input type="number" name="age" class="text-box" placeholder="Age">
                            <h3 class="text-muted">Age</h3>

                            <input type="text" name="sex" class="text-box" placeholder="Sex">
                            <h3 class="text-muted">Sex</h3>

                            <input type="date" name="birthday" class="text-box">
                            <h3 class="text-muted">Birthday</h3>

                            <input type="text" name="contact" class="text-box" placeholder="Contact">
                            <h3 class="text-muted">Contact No</h3>

                            <input type="text" name="address" class="text-box" placeholder="Address">
                            <h3 class="text-muted">Address</h3>

                            <div class="modal-buttons">
                                <button class="submit">Submit</button>
                                <button class="cancel">Cancel</button>
                            </div>
                        </div>
                    </div>
                    
                    </div>
                    <div id="overlay"></div>
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