  <html lang="en"><head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
        
       
</style>
    </head>
    <body>
        <div class="header-top text-center">
            <img src="https://app.pvcinterior.in/admin/images/logo/logo.png" class="w-25">
        </div>
        <div class="main">
            <div>
                <h2><i class="fa fa-id-card-o" aria-hidden="true"></i> Member Tree View</h2>
            </div>
        </div>
        <div class="bt-div text-end mr-3">
            <a href="user-list" class="btn btn-danger"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Back</a>
            <a href="user-list" class="btn btn-primary"><i class="fa fa-print" aria-hidden="true"></i> Print</a>
        </div>
        

        <?php
// Database connection parameters
$servername = "localhost";
$username = "mehndipvc_u439213217_mehndi_pro2";
$password = "Mehndi@2023$#";
$dbname = "mehndipvc_u439213217_mehndi_pro";

// Create a database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to generate the tree structure recursively
function generateTree($parent_id = 0) {
    global $conn;

    // Fetch data from the database
    $sql = "SELECT * FROM users WHERE parent_id = $parent_id ORDER BY name ASC";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo '<ul>';
       
        while ($row = $result->fetch_assoc()) {
            $user_type = $row['user_type'];
            
            echo '<li><button>' . htmlspecialchars($row['name']) . '</button><small> (' . $user_type . ')</small>
            
            ';
            generateTree($row['id']); // Recursive call
            echo '</li>';
        }
        echo '</ul>';
    }
}

// Start the tree generation

?>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <style>
        /* Add your CSS here */
        .tree {
            margin: 0;
            padding: 0;
            list-style: none;
        }
        .tree ul {
            margin: 0;
            padding: 0;
            list-style: none;
            margin-left: 1em;
            position: relative;
        }
        .tree ul ul {
            margin-left: 0.5em;
        }
        .tree ul:before {
            content: "";
            display: block;
            width: 0;
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            border-left: 1px solid;
        }
        .tree ul li:before {
            content: "";
            display: block;
            width: 10px;
            height: 0;
            border-top: 1px solid;
            margin-top: -1px;
            position: absolute;
            top: 1em;
            left: 0;
        }
        .tree ul li:last-child:before {
            height: auto;
            top: 1em;
            bottom: 0;
        }
        .tree li {
            margin: 0;
            padding: 0 1em;
            line-height: 2em;
            color: #369;
            font-weight: 700;
            position: relative;
        }
        .tree li .expand {
            display: block;
        }
        .tree li .collapse {
            display: none;
        }
        .tree li a {
            text-decoration: none;
            color: #369;
        }
        .tree li button {
            text-decoration: none;
            color: #369;
            border: none;
            background: transparent;
            margin: 0;
            padding: 0;
            outline: 0;
        }
        .tree li button:active,
        .tree li button:focus {
            text-decoration: none;
            color: #369;
            border: none;
            background: transparent;
            margin: 0;
            padding: 0;
            outline: 0;
        }
        .indicator {
            margin-right: 5px;
        }
    </style>

    <ul id="tree1" class="tree">
        <?php
       generateTree();
        ?>
    </ul>
        
        
    </body></html>
    
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        var tree = document.getElementById("tree1");
        if (tree) {
            tree.querySelectorAll("ul").forEach(function(el) {
                var parent = el.parentNode;
                parent.classList.add("branch");
                var indicator = document.createElement("i");
                indicator.classList.add("indicator");
                indicator.classList.add("bi-folder-plus");
                parent.insertBefore(indicator, parent.firstChild);
                el.classList.add("collapse");

                var lastClickTime = 0; // Ensure this variable is defined outside the function scope if it's not already

                parent.addEventListener("click", function(event) {
                    // Ensure this variable is defined outside the function scope if it's not already
                    var currentTime = new Date().getTime();
                
                    // Check if the click is on the correct element
                    if (parent === event.target || parent === event.target.parentNode) {
                        if (el.classList.contains('collapse')) {
                            el.classList.remove("collapse");
                            el.classList.add("expand");
                            indicator.classList.remove("bi-folder-plus");
                            indicator.classList.add("bi-folder-minus");
                        } else {
                            el.classList.remove("expand");
                            el.classList.add("collapse");
                            indicator.classList.remove("bi-folder-minus");
                            indicator.classList.add("bi-folder-plus");
                        }
                    }
                
                    // Update the lastClickTime with the current click time
                    lastClickTime = currentTime;
                });

            });
        }
    });
</script>