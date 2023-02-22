<?php 

// <!-- create connection to database -->
/** @var $pdo \PDO */
require_once "database.php";
include('session.php');

$statement = $pdo->prepare('CALL viewEvacuationCenter;');
$statement->execute();
$center = $statement->fetchAll(PDO::FETCH_ASSOC);
$statement->closeCursor();

$statement2 = $pdo->prepare('CALL analyticsEvacuee;');
$statement2->execute();
$evacanal = $statement2->fetchAll(PDO::FETCH_ASSOC);
$statement2->closeCursor();

$statement3 = $pdo->prepare('CALL analyticsReliefGoods;');
$statement3->execute();
$rganal = $statement3->fetchAll(PDO::FETCH_ASSOC);
$statement3->closeCursor();

$statement4 = $pdo->prepare('CALL analyticsVolunteers;');
$statement4->execute();
$vltranal = $statement4->fetchAll(PDO::FETCH_ASSOC);
$statement4->closeCursor();

// export
$connect = mysqli_connect("localhost", "root", "", "evac_management_system");
$sql = "CALL viewEvacuee";  
$result = mysqli_query($connect, $sql);
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
                    <a href="index.php" class="btn-index">
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
                    <a href="volunteers.php" class="btn-volunteers">
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
                    <a href="analytics.php" class="btn-inventory active">
                        <span class="material-icons-sharp">analytics</span>
                        <h3>Analytics</h3>
                    </a>
                    <a href="#" class="btn-settings">
                        <span class="material-icons-sharp">settings</span>
                        <h3>Settings</h3>
                    </a>

                    <a href = "session_logout.php" class="btn-logout">
                        <span class="material-icons-sharp">logout</span>
                        <h3>Logout</h3>
                    </a>
            </div>
        </aside>
        <!===================== END OF ASIDE =======================!>
        <!===================== START OF MAIN ========================!>
        <main>
            <h1>Analytics and Reports</h1>
            
        <! ----------------- EVAC CENTER INFO ------------!>
            <div class="analytics-reports">
                <div class="evacuation-report">
                    <div class="report-header">
                        <?php foreach ($center as $c => $cc) : ?>
                            <h3><?php echo $cc['C_Name'] ?></h3>
                            <h3><?php echo $cc['C_Address'] ?></h3>
                            <h3>Daily Relief Operation Status Report</h3>
                        <?php endforeach; ?>
                    </div>
                    <div class="report-table">
                    <table>
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>No of Families Evacuated</th>
                                <th>No of People Evacuated</th>
                                <th>Total No of Families</th>
                                <th>Total No of Evacuees</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>01/02/2022</td>
                                <td>12</td>
                                <td>79</td>
                                <td>46</td>
                                <td>243</td>
                            </tr>
                            <tr>
                                <td>01/03/2022</td>
                                <td>6</td>
                                <td>38</td>
                                <td>52</td>
                                <td>274</td>
                            </tr>
                            <tr>
                                <td>01/04/2022</td>
                                <td>5</td>
                                <td>25</td>
                                <td>56</td>
                                <td>316</td>
                            </tr>
                            <tr>
                                <td>01/05/2022</td>
                                <td>9</td>
                                <td>51</td>
                                <td>64</td>
                                <td>353</td>
                            </tr>
                            <tr>
                                <td>01/05/2022</td>
                                <td>9</td>
                                <td>51</td>
                                <td>64</td>
                                <td>353</td>
                            </tr>
                            <tr>
                                <td>01/05/2022</td>
                                <td>9</td>
                                <td>51</td>
                                <td>64</td>
                                <td>353</td>
                            </tr>
                            <tr>
                                <td>01/05/2022</td>
                                <td>9</td>
                                <td>51</td>
                                <td>64</td>
                                <td>353</td>
                            </tr>                    
                        </tbody>
                    </table>
                    </div>
                    <div class="report-footer">
                        <form method="post" action="export.php">
                            <button type="submit" name="export" class="color-danger" value="Export">Export</button>
                            <!-- <input type="submit" name="export" class="btn btn-success" value="Export" /> -->
                        </form>
                    </div>
                </div>

                <div class="evacuation-report">
                    <div class="report-header">
                        <?php foreach ($center as $c => $cc) : ?>
                            <h3><?php echo $cc['C_Name'] ?></h3>
                            <h3><?php echo $cc['C_Address'] ?></h3>
                            <h3>Daily Relief Operation Status Report</h3>
                        <?php endforeach; ?>
                    </div>
                    <div class="report-table">
                    <table>
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Donors</th>
                                <th>Item</th>
                                <th>Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>01/02/2022</td>
                                <td>Red Cross</td>
                                <td>Noodles</td>
                                <td>300</td>
                            </tr>
                            <tr>
                                <td>01/03/2022</td>
                                <td>DSWD</td>
                                <td>Rice</td>
                                <td>200</td>
                            </tr>
                            <tr>
                                <td>01/03/2022</td>
                                <td>Angat Buhay</td>
                                <td>Sardines</td>
                                <td>400</td>
                            </tr>
                            <tr>
                                <td>01/03/2022</td>
                                <td>Angat Buhay</td>
                                <td>Alaska</td>
                                <td>580</td>
                            </tr>
                            <tr>
                                <td>01/03/2022</td>
                                <td>Angat Buhay</td>
                                <td>Meat Loaf</td>
                                <td>320</td>
                            </tr>
                                                
                        </tbody>
                    </table>
                    </div>
                    <div class="report-footer">
                        <button>Export</button>
                    </div>
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
            <div class="evac-analytics">
                        <a href="Analytics.php"><h2>Analytics</h2></a>
                        <div class="evacuee analysis">
                            <div class="icon">
                                <span class= "material-icons-sharp">groups</span>
                            </div>
                            <div class="right">
                                <div class="info">
                                    <h3>EVACUEES</h3>
                                    <small class="text-muted">Last 24 Hours</small>
                                </div>
                                <?php foreach ($evacanal as $i => $vv) : ?>
                                <h5 class="success">+
                                    <?php echo $vv['@percentage'] ?> 
                                    <?php //echo $row2['@percentEVAC'];?>
                                    <?php //echo $percentEVAC.$countEVAC;?>
                                    <?php //echo $percentEVAC;?>
                                 </h5>
                                <h3><?php echo $vv['@currentCount'] ?> </h3>
                                <?php endforeach;?>
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
                                <?php foreach ($rganal as $i => $vv) : ?>
                                    <h5 class="success">+<?php echo $vv['@percentage'] ?> </h5>
                                    <h3><?php echo $vv['@currentCount'] ?></h3>
                                <?php endforeach;?>
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
                                <?php foreach ($vltranal as $i => $vv) : ?>
                                    <h5 class="success">+<?php echo $vv['@percentage'] ?></h5>
                                    <h3><?php echo $vv['@currentCount'] ?></h3>
                                <?php endforeach;?>
                            </div>
                        </div>

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
    

    </script>

</body>
</html>