<?php

// <!-- create connection to database -->
/** @var $pdo \PDO */
/** @var $conn \PDO */
require_once "database.php";

// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "db_evac_management_syss";
// // Create connection
// $conn = mysqli_connect($servername, $username, $password, $dbname);
// // Check connection
// if (!$conn) {
//     die("Connection failed: " . mysqli_connect_error());
// }

$sql = "CALL viewEvacuationCenter";
// $sql = "CALL evacuation_center";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

// $sql2 = "SELECT * FROM room";
// $result2 = mysqli_query($conn, $sql2);
// $row2 = mysqli_fetch_assoc($result2);



// $Evacuee_ID = 1;
// if (!$Evacuee_ID) {
//   header('Location: center.php');
//   exit;
// }


// you can use exec() but not good, only to make changes on database schema
// to select
// $statement = $pdo->prepare('SELECT * FROM evacuation_center LIMIT 1; SELECT * FROM room');
$statement = $pdo->prepare('CALL viewEvacuationCenter');

$statement->execute();
$center = $statement->fetchAll(PDO::FETCH_ASSOC);
$statement = $pdo->prepare('SELECT * FROM room');
$statement->execute();
$center2 = $statement->fetchAll(PDO::FETCH_ASSOC);

// if Name is empty, throw error because it is required
$errors = [];

// solution when Name etch is empty
$C_Name = $row['C_Name'];
$C_Address = $row['C_Address'];
// $C_Total_Capacity = $row['C_Total_Capacity'];

/////////////////////////////////////////////////////////////////////////////////////////

// show request method
// echo $_SERVER['REQUEST_METHOD']. '<br>';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $C_Name = $_POST['C_Name'];
  $C_Address = $_POST['C_Address'];
//   $C_Total_Capacity = $_POST['C_Total_Capacity'];

  // if Name is empty, throw error because it is required
  if (!$C_Name) {
    $errors[] = 'Please Enter Center Name';
  }
  if (!$C_Address) {
    $errors[] = 'Please Enter Address';
  }
//   if (!$C_Total_Capacity) {
//     $errors[] = 'Please Enter Total Capacity';
//   }

  // Only Submit to sql when it is not empty
  if (empty($errors)) {
                                // C_Total_Capacity = :C_Total_Capacity
    $statement = $pdo->prepare("
                                UPDATE evacuation_center SET C_Name = :C_Name, 
                                C_Address = :C_Address WHERE Center_ID = 'EC-0001'");
    $statement->bindValue(':C_Name', $C_Name);
    $statement->bindValue(':C_Address', $C_Address);
    // $statement->bindValue(':C_Total_Capacity', $C_Total_Capacity);
    $statement->execute();

    // redirect user after creating
    header('Location: center.php');
  }
}


?>

<!DOCTYPE html>
<head>
    <link href="https://fonts.googleapis.com/css2?family=Material+Icons+Sharp"
      rel="stylesheet">
   <link rel="stylesheet" href="style.css">
   </head>
<body>

        <div class="container">
            <!===================== START OF ASIDE =======================!>
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
                    <a href="#" class = "btn-center active">
                        <span class="material-icons-sharp">apartment</span>
                        <h3>Center</h3>
                    </a>
                    <a href="evacuees.php" class="btn-evacuees">
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
            <!===================== START OF MAIN ========================!>
            <main>
                <h1>EVACUATION CENTER MANAGER</h1>
                
            <! ----------------- EVAC CENTER INFO ------------!>
                <div class="evacinfo">
                    
                    <div class="evaccenter-top">
                        <div class="evaccenter-header">
                        <span class= "material-icons-sharp">night_shelter</span>
                        <h2 id="evac-name"><?php echo $row['C_Name'];?></h2>
                        </div>
                        <button data-modal-target="#modal-evac-info" class="edit-btn">
                            <span class= "material-icons-sharp">edit</span>
                        </button>
                          <div class="modal" id="modal-evac-info">
                            <div class="modal-header">
                                
                              <div class="title"><span class= "material-icons-sharp">edit</span><?php echo $row['C_Name'];?> Information</div>
                              <button data-close-button class="close-button"><span class="material-icons-sharp">close</span></button>
                            </div>
                            <div class="modal-body">
                                <div class="modal-body-input">

                                <form action="" method="post" enctype="multipart/form-data">

                                    
                                        <h3>Center Name</h3>
                                        <!-- In case CName is not indicated, reshow the CName -->
                                        <input type="text" name="C_Name" class="text-box" value="<?php echo $C_Name ?>" text-align="center">
                                    
                                    
                                        <h3>Center Address</h3>
                                        <!-- In case cpNumber is not indicated, reshow the Name -->
                                        <input type="text" name="C_Address" class="text-box" value="<?php echo $C_Address ?>">
                                    
                                    
                                        <!-- <h3>Total Capacity</h3>
                                        <!-- In case cpNumber is not indicated, reshow the Name -->
                                        <!-- <input type="number" name="C_Total_Capacity" class="text-box" value="<?php //echo $C_Total_Capacity ?>"> -->
                                        <br><br><br> -->
                                    

                                    <a href="index.php" id="back" class="btn btn-sm btn-danger">Back</a>   
                                    <button type="submit" id="sub" class="btn btn-primary">Submit</button>
                                </form>
                                </div>
                            </div>
                          </div>
                          <div id="overlay"></div>
                    </div>
                    <div class="evaccenter-body">
                        <div class="evac-address">
                            <span class= "material-icons-sharp">map</span>
                            <h3 class="text-muted"><?php echo $row['C_Address'];?></h3>
                        </div>
                        <div class="evac-capacity">
                            <span class= "material-icons-sharp">group</span>
                            <h2><?php echo $row['C_Current_Capacity'];?></h2>
                            <h3 class="text-muted">/</h3>
                            <h3 class="text-muted"><?php echo $row['C_Total_Capacity'];?></h3>
                        </div>
                    </div>
                </div>
            
             <div class="rooms">
                <h2>Room Manager</h2>
                <div class="room-manager">
                <?php foreach ($center2 as $i => $croom) :?>
                    <div class="room-card">
                        <div class="room-head">
                            <div class="room-head-name">
                            <h3 id="room-name" ><?php echo $croom['R_Name'] ?></h3>
                            <h4 id="room-id" class="text-muted"><?php echo $croom['Room_ID'] ?></h4>
                            </div>
                            <button data-modal-target="#modal-room-info" class="edit-btn edit-123456">
                            <span class= "material-icons-sharp">edit</span>
                            </button>
                        </div>
                        <div class="room-body">
                            <div class="room-capacity">
                            <span class= "material-icons-sharp">group</span>
                            <h3>27</h3>
                            <h4 class="text-muted">/</h4>
                            <h4 class="text-muted"><?php echo $croom['R_Total_Capacity'] ?></h4>
                            </div>
                            <h4 class="room-detail"><a href="room_update.php?Room_ID=<?php echo $croom['Room_ID'] ?>" id="sub" class="btn btn-primary">Details</a></h4>
                        </div>
                    </div>
                    <div class="modal" id="modal-room-info">
                            <div class="modal-header">
                                
                              <div class="title"><span class= "material-icons-sharp">edit</span>
                                <h2>Edit Room</h2>
                                <h3 class="text-muted" id="room-id-edit"><?php echo $croom['Room_ID']?></h3>
                              <!-- title -->
                              </div>
                              <button data-close-button class="close-button"><span class="material-icons-sharp">close</span></button>
                            <!-- modal-header -->
                            </div>
                            <div class="modal-body">
                                <div class="modal-body-input">
                                <h3>Room Name</h3>
                                <input type="text" name="name" placeholder="<?php echo $croom['Room_ID']?>" class="text-box">
                                <h3>Location</h3>
                                <input type="text" name="address" placeholder="Enter Address" class="text-box">
                                <h3>Total Capacity</h3>
                                <input type="number" name="capacity" placeholder="Enter Capacity" class="text-box">
                                <!-- modal-body-input -->
                                </div>
                                <div class="modal-buttons">
                                    <button class="submit">Submit</button>
                                    <button class="cancel">Cancel</button>
                                <!-- modal buttons -->
                                </div>
                            <!-- modal-body -->
                            </div>
                          <!-- modal -->
                    </div>
                <?php endforeach;?>
                <a href="room_add.php">
                    <div class="room-card-add">
                        <span class= "material-icons-sharp">add</span>
                        <h3>Add a Room</h3>
                    </div>
                </a>
                </div>
                
                
                          <div class="recent-updates">
                <h2>Room Manager</h2>
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">Room_ID</th>
                        <th scope="col">R_Name</th>
                        <th scope="col">Area_ID</th>
                        <th scope="col">R_Total_Capacity</th>
                        <!-- <th scope="col">R_Current_Capacity</th> -->
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($center2 as $i => $evacuee2) :
                    ?>
                        <tr>
                        <td scope="row"><?php echo $evacuee2['Room_ID'] ?></td>
                        <td><?php echo $evacuee2['R_Name'] ?></td>
                        <td><?php echo $evacuee2['Area_ID'] ?></td>
                        <td><?php echo $evacuee2['R_Total_Capacity'] ?></td>
                        <!-- <td><?php //echo $evacuee2['R_Current_Capacity'] ?></td> -->

                        <td>
                            <!-- Edit button -->
                            <a href="room_update.php?Room_ID=<?php echo $evacuee2['Room_ID'] ?>" id="sub" class="btn btn-primary">Edit</a>

                            
                            <!-- Delete button -->
                            <form style="display:inline-block" method="post" action="room_delete.php">
                            <input type="hidden" name="Room_ID" value="<?php echo $evacuee2['Room_ID'] ?>">
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
            </div>

            
            </main>
            
            <!===================== END OF MAIN =======================!>
            <!===================== START OF RIGHT =======================!>
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
                <div class="room-details-section">
                    <h2>Details</h2>
                    <div class="room-details">
                        <h3>Room 1</h3>
                        <table>
                        <thead>
                            <tr>
                                <th>Household ID</th>
                                <th>Household Name</th>
                                <th><span class= "material-icons-sharp">group</span></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>123456</td>
                                <td>Santiago</td>
                                <td>8</td>
                                <td>See more</td>
                            </tr>
                            <tr>
                                <td>123457</td>
                                <td>Dela Cruz</td>
                                <td>12</td>
                                <td>See more</td>
                            </tr>
                            <tr>
                                <td>123458</td>
                                <td>Manansala</td>
                                <td>4</td>
                                <td>See more</td>
                            </tr>
                        </tbody>
                    </table>
                    </div>
                </div>
                <! ---------------- End of Announcements ---------------- !>
                    <div class="room-details-section">
                    <h2>Volunteers</h2>
                    <div class="room-details">
                        <h3>Information</h3>
                        <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Age</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>123456</td>
                                <td>Carlos Santiago</td>
                                <td>18</td>
                                <td>See more</td>
                            </tr>
                            <tr>
                                <td>123457</td>
                                <td>Jane Dela Cruz</td>
                                <td>25</td>
                                <td>See more</td>
                            </tr>
                            <tr>
                                <td>123458</td>
                                <td>Cristof Lee</td>
                                <td>34</td>
                                <td>See more</td>
                            </tr>
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
            <!===================== END OF RIGHT =======================!>
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

        // fill table
        /* Updates.forEach(update =>{
            const tr = document.createElement('tr');
            const trContent = ' <td>${update.Name}</td><td>${update.Address}</td><td>${update.Age}</td><td>${update.Sex}</td><td>${update.Room}</td><td class="${update.Status === 'Evacuated' ? 'success' : update.Status === 'Departed' ? 'danger' : 'primary'}">${update.Status}</td>';

            tr.innerHTML = trContent;
            document.querySelector('table tbody').appendChild(tr);
        }) */

        //POP UP EDIT EVAC INFO FORM
        var body = document.getElementsByTagName('body')[0];

        const openModalButtons = document.querySelectorAll('[data-modal-target]');
        const closeModalButtons = document.querySelectorAll('[data-close-button]');
        const overlay = document.getElementById('overlay');

        openModalButtons.forEach(button => {
          button.addEventListener('click', () => {
            const modal = document.querySelector(button.dataset.modalTarget);
            openModal(modal);
          });
        });

        overlay.addEventListener('click', () => {
          const modals = document.querySelectorAll('.modal.active');
          modals.forEach(modal => {
            closeModal(modal);
          });
        });

        closeModalButtons.forEach(button => {
          button.addEventListener('click', () => {
            const modal = button.closest('.modal');
            closeModal(modal);
          });
        });

        function openModal(modal) {
          if (modal == null) return
          modal.classList.add('active');
          overlay.classList.add('active');
        }

        function closeModal(modal) {
          if (modal == null) return
          modal.classList.remove('active');
          overlay.classList.remove('active');
        }
        
        //Room Edit Button Setting Room ID
        const editBtn = document.querySelectorAll(".edit-123456");
        let editId = document.getelementByID("room-id-edit");
        editBtn.addEventListener('click', () =>{
            editId.innerHTML = "123456";
        });
        </script>
   
</body>
</html>