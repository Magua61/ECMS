<?php

// <!-- create connection to database -->
/** @var $pdo \PDO */
require_once "database.php";

$statement = $pdo->prepare('CALL viewVolunteers');
$statement->execute();
$vltr = $statement->fetchAll(PDO::FETCH_ASSOC);
$statement->closeCursor();
$statement2 = $pdo->prepare('CALL viewVolunteerGroup');
$statement2->execute();
$statement->closeCursor();
$vg = $statement2->fetchAll(PDO::FETCH_ASSOC);

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
                <a href="evacuees.php" class="btn-evacuees">
                    <span class="material-icons-sharp">group</span>
                    <h3>Evacuees</h3>
                </a>
                <a href="#" class="btn-volunteers active">
                    <span class="material-icons-sharp">volunteer_activism</span>
                    <h3>Volunteers</h3>
                </a>
                <a href="inventory.php" class="btn-inventory">
                    <span class="material-icons-sharp">inventory</span>
                    <h3>Inventory</h3>
                </a>
                <a href="distribution.php" class="btn-distribution">
                    <span class="material-icons-sharp">local_shipping</span>
                    <h3>Distribution</h3>
                </a>
                <a href="#" class="btn-logout">
                    <span class="material-icons-sharp">logout</span>
                    <h3>Logout</h3>
                </a>
            
            </div>
        </aside>
        <!===================== END OF ASIDE =======================!>

        <main>
            <h1>Volunteer Manager</h1>

            <div class="recent-updates">
                <h2>Volunteers</h2>
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">V_ID</th>
                        <th scope="col">V_Name</th>
                        <th scope="col">V_Birthday</th>
                        <th scope="col">V_Age</th>
                        <th scope="col">V_Sex</th>
                        <th scope="col">V_Group</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($vltr as $i => $vv) :
                    ?>
                        <tr>
                        <td scope="row"><?php echo $vv['V_ID'] ?></td>
                        <td><?php echo $vv['V_Name'];?></td>
                        <td><?php echo $vv['V_Birthday'] ?></td>
                        <td><?php echo $vv['V_Age'] ?></td>
                        <td><?php echo $vv['V_Sex'] ?></td>
                        <td><?php echo $vv['V_Group'] ?></td>

                        <td>
                            <!-- Edit button -->
                            <a href="volunteer_update.php?V_ID=<?php echo $vv['V_ID'] ?>" id="sub" class="btn btn-primary">Edit</a>

                            
                            <!-- Delete button -->
                            <form style="display:inline-block" method="post" action="volunteer_delete.php">
                            <input type="hidden" name="V_ID" value="<?php echo $vv['V_ID'] ?>">
                            <button type="submit">Delete</button>
                            
                            </form>
                        </td>

                        </tr>
                    <?php
                    endforeach;
                    ?>

                    </tbody>
                </table>
            </div>

            <!-- End of volunteers -->

            <!-- Start of Volunteer Group -->
            <div class="recent-updates">
                <h2>Volunteer Groups</h2>
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">V_Group</th>
                        <th scope="col">G_Name</th>
                        <th scope="col">Area_ID</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($vg as $j => $vg2) :
                    ?>
                        <tr>
                        <td scope="row"><?php echo $vg2['V_Group'] ?></td>
                        <td><?php echo $vg2['G_Name'];?></td>
                        <td><?php echo $vg2['Area_ID'] ?></td>

                        <td>
                            <!-- Edit button -->
                            <a href="vgroup_update.php?V_Group=<?php echo $vg2['V_Group'] ?>" id="sub" class="btn btn-primary">Edit</a>

                            
                            <!-- Delete button -->
                            <form style="display:inline-block" method="post" action="vgroup_delete.php">
                            <input type="hidden" name="V_Group" value="<?php echo $vg2['V_Group'] ?>">
                            <button type="submit">Delete</button>
                            
                            </form>
                        </td>

                        </tr>
                    <?php
                    endforeach;
                    ?>

                    </tbody>
                </table>
            </div>

            <!-- End of Volunteer Group -->

            

            <div class="recent-updates">
                <h2>Volunteer Groups</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Group ID</th>
                            <th>Group Name</th>
                            <th>Area</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>VG_1123</td>
                            <td>Med Group 1</td>
                            <td>Medical Area 1</td>
                            <td><button>Edit</button><button>Delete</button></td>
                        </tr>
                        <tr>
                            <td>VG_1123</td>
                            <td>Evac Group 2</td>
                            <td>Evacuation Area 1</td>
                            <td><button>Edit</button><button>Delete</button></td>
                        </tr>
                        <tr>
                            <td>VG_1123</td>
                            <td>Rel Ops Group 3</td>
                            <td>Relief Operations Area 1</td>
                            <td><button>Edit</button><button>Delete</button></td>
                        </tr>
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
                <h2>Add Volunteer</h2>
                <div class="announcements">
                    
                        <div class="add-items-form">
                            <div class="itemname">
                            <input type="text" name="name" class="text-box" placeholder="Name">
                            <h3 class="text-muted">Name</h3>
                            </div>
                            <div class="expiry">
                                <input type="date" name="birthday" class="text-box">
                                <h3 class="text-muted">Birthday</h3>
                            </div>
                            <div class="itemqty">
                                <input type="number" name="age" class="text-box" placeholder="Age">
                                <h3 class="text-muted">Age</h3>
                            </div>
                            <div class="itemname">
                                <input type="text" name="sex" class="text-box" placeholder="Sex">
                                <h3 class="text-muted">Sex</h3>
                                </div>
                            
                                <div class="item-field">
                                    <datalist id="item-suggestions" >
                                        <option>Medical Group 1</option>
                                        <option>Evacuation Group 1</option>
                                        <option>Relief Operations Group 1</option>
                                    </datalist>
                                    <input  autoComplete="on" list="item-suggestions" class="txt-item"/> 
                                    <h3 class="text-muted">Volunteer Group</h3>
                                </div>
                            <div class="add-items-row-3">
                                <button>Submit</button>
                                <button>Clear</button>
                            </div>
    
                        </div>
                    
                </div>
            </div>
            <! ---------------- End of Announcements ---------------- !>
            <div class="recent-announcements">
                <h2>Add Group</h2>
                <div class="announcements">
                    
                        <div class="relief-packing-form">

                                <div class="item-field">
                                    <datalist id="item-suggestions" >
                                        <option>Medical Area 1</option>
                                        <option>Evacuation Area 1</option>
                                        <option>Relief Operation 1</option>
                                    </datalist>
                                    <input  autoComplete="on" list="item-suggestions" class="txt-item"/> 
                                    <h3 class="text-muted">Area</h3>
                                </div>

                                <div class="itemqty">
                                <input type="text" name="name" class="text-box" >
                                <h3 class="text-muted">Group Name</h3>
                                </div>

                            <button>Submit</button>
                            <button>Clear</button>

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