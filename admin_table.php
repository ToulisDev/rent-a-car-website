<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title> Σελίδα Διαχείρισης </title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter&family=Nunito&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script src="sources/script.js" defer></script>
    <script>
        function changeTable(selectedItem){
            const filterItem = document.getElementById("nav_tableID");
            const filterTbl = document.querySelectorAll(".clients_table");
            if(selectedItem.classList.contains("table_item")){ 
                filterItem.querySelector(".active").classList.remove("active");
                selectedItem.classList.add("active"); 
                let filterName = selectedItem.getAttribute("data-name"); 
                filterTbl.forEach((table) => {
                    let filterTbls = table.getAttribute("data-name"); 
                    if((filterTbls == filterName) || (filterName == "all")){
                        table.classList.remove("hide"); 
                        table.classList.add("show");
                    }else{
                        table.classList.add("hide");
                        table.classList.remove("show");
                    }
                });
            }
        }

        function preview(element) {
            const parentTd = element.parentElement,
                parentTr = parentTd.parentElement,
                tableTheme = parentTr.querySelector('[data-label="Θέμα"]')
            const previewBox = document.querySelector(".preview_box"),
                previewMsg = previewBox.querySelector(".msg_box"),
                previewTheme = previewBox.querySelector("h3"),
                closeBox = previewBox.querySelector(".preview_box_close"),
                shadow = document.querySelector(".shadow");
            document.querySelector("body").style.overflow = "hidden";
            let selectedPrevMsg = element.getElementsByTagName('p')[0];
            previewTheme.innerHTML = tableTheme.innerHTML;
            previewMsg.innerHTML = selectedPrevMsg.innerHTML;
            previewBox.classList.add("show");
            shadow.classList.add("show");
            closeBox.onclick = () => {
                previewBox.classList.remove("show");
                shadow.classList.remove("show");
                document.querySelector("body").style.overflow = "auto";
            }
            shadow.onclick = () => {
                previewBox.classList.remove("show");
                shadow.classList.remove("show");
                document.querySelector("body").style.overflow = "auto";
            }
        }
    </script>
</head>
<body>
<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DATABASE', 'rentacardb');


$dbhost = DB_SERVER;
$dbuser = DB_USERNAME;
$dbpass = DB_PASSWORD;
$dbname = DB_DATABASE;
$dbconnection = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);
$clientsData = '';
$messagesData = '';


$sql = "SELECT * FROM clients";
mysqli_set_charset($dbconnection, "utf8");
$result = mysqli_query($dbconnection, $sql);
while($row = mysqli_fetch_assoc($result)){
    $json_array[] = $row;
}
if(isset($json_array)){
    $clientsData = $json_array;
}
$sql = "SELECT * FROM messages";
mysqli_set_charset($dbconnection, "utf8");
$resultMessages = mysqli_query($dbconnection, $sql);
while($rowMessages = mysqli_fetch_assoc($resultMessages)){
    $json_arrayMessages[] = $rowMessages;
}
if(isset($json_arrayMessages)){
    $messagesData = $json_arrayMessages;
}

?>
    <div id="header">
        <nav>
            <input type="checkbox" id="check" class="nav_checkbox" />
            <label for="check" class="checknav" onclick="changeBar(this)">
                <div class="bar1"></div>
                <div class="bar2"></div>
                <div class="bar3"></div>
            </label>
            <label class="logo_container">
                My <span>Rentacar</span> Store
            </label>
            <ul class="navigation">
                <li><a href="index.html">Αρχικη Σελιδα</a></li>
                <li><a href="profile.html">Προφιλ</a></li>
                <li><a href="fleet.html">Στολος</a></li>
                <li><a href="calcuCost.html">Υπολογισμος Κοστους</a></li>
                <li><a href="contact.html">Επικοινωνια</a></li>
                <li><a class="active" href="admin.html">Σελιδα Διαχειρισης</a></li>
            </ul>

        </nav>
    </div>
    <div class="content">
        <div class="content_table">
            <nav class="nav_table">
                <div id="nav_tableID" class="table_items">
                    <span onclick="changeTable(this)" class="table_item active" data-name="tb_clients">Πελάτες</span>
                    <span onclick="changeTable(this)" class="table_item" data-name="tb_messages">Μηνύματα</span>
                </div>
            </nav>
            <div class="table_container">
                <table class="clients_table" data-name="tb_clients">
                    <thead>
                        <tr>
                            <th>Όνομα Χρήστη</th>
                            <th>Όνομα</th>
                            <th>E-Mail</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if($clientsData != ''){
                            foreach($clientsData as $client){
                                echo '
                                <tr>
                                <td data-label="Όνομα Χρήστη">'.$client['username'].'</td>
                                <td data-label="Όνομα">'.$client['name'].'</td>
                                <td data-label="E-Mail">'.$client['email'].'</td>
                                </tr>';
                            }
                        } else{
                            echo '
                            <tr>
                            <td>Δεν υπάρχουν Πελάτες στη βάση δεδομένων</td>
                            </tr>';
                        }
                        ?>
                    </tbody>
                </table>
                <table class="clients_table hide" data-name="tb_messages">
                    <thead>
                        <tr>
                            <th>Όνομα</th>
                            <th>Τηλέφωνο</th>
                            <th>E-Mail</th>
                            <th>Θέμα</th>
                            <th>Μήνυμα</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if($messagesData != ''){
                            foreach($messagesData as $message){
                                echo '
                                <tr>
                                <td data-label="Όνομα">'.$message["name"].'</td>
                                <td data-label="Τηλέφωνο">'.$message["phone_number"].'</td>
                                <td data-label="E-Mail">'.$message["email"].'</td>
                                <td data-label="Θέμα">'.$message["subject"].'</td>
                                <td data-label="Μήνυμα"><a onclick="preview(this)" class="tb_showMsg_btn">Δείξε Μήνυμα<p style="display:none;">'.$message["message"].'</p></a></td>
                                </tr>';
                            }
                        }else{
                            echo '
                            <tr>
                            <td>Δεν υπάρχουν μηνύματα στη βάση δεδομένων</td>
                            </tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="preview_box">
            <div class="details">
                <a class="preview_box_close">X</a>
            </div>
            <h3></h3>
            <div class="msg_box"><p></p></div>
        </div>
        <div class="shadow"></div>
    </div>
    <div id="footer" class="footer">
        <div class="inner_footer">
            <div class="left box">
                <h2>Φορμα Εγγραφης στο Newsletter</h2>
                <div class="ftr_content">
                    <form id="newsletter">
                        <div class="nlr_fld">
                            <div class="ftr_text">Username</div>
                            <input maxlength="20" type="text" name="username" required>
                        </div>
                        <div class="nlr_fld">
                            <div class="ftr_text">Όνομα</div>
                            <input maxlength="20" type="text" name="name" required>
                        </div>
                        <div class="nlr_fld">
                            <div class="ftr_text">E-Mail</div>
                            <input maxlength="50" type="email" name="email" required>
                        </div>
                        <div class="nlr_btn">
                            <button type="submit">Εγγραφή</button>
                            <span id="statusNewsletter"></span>
                        </div>
                    </form>
                </div>
            </div>
            <div class="center box">
                <h2>Στοιχεια Επικοινωνιας</h2>
                <div class="ftr_content">
                    <div class="ftr_contact">
                        <h3>Διεύθυνση</h3>
                        <span class="ftr_text">Καραολή και Δημητρίου 80, Πειραιάς 185 34</span>
                    </div>
                    <div class="ftr_contact">
                        <h3>Τηλέφωνο</h3>
                        <a href="tel:2104142000">+30210-4142000</a>
                    </div>
                    <div class="ftr_contact">
                        <h3>E-Mail</h3>
                        <a href="mailto:aggelos_sachtouris@hotmail.com">aggelos_sachtouris@hotmail.com</a>
                    </div>
                </div>
            </div>
            <div class="right box">
                <h2>Χαρτης</h2>
                <div class="ftr_content">
                    <iframe class="googleMap" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3146.525339924713!2d23.650679415490245!3d37.94151791032132!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14a1bbe5bb8515a1%3A0x3e0dce8e58812705!2zzqDOsc69zrXPgM65z4PPhM6uzrzOuc6_IM6gzrXOuc-BzrHOuc-Oz4I!5e0!3m2!1sel!2sgr!4v1655292751448!5m2!1sel!2sgr"
                            width="200" height="300" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
        <div class="bottom_footer">
            <p>Copyright © My Rentacar Store, Aggelos Sachtouris - E19247. All rights reserved.</p>
        </div>
    </div>
</body>
</html>

