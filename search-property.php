<?php
session_start();
isset($_SESSION["email"]);
include("navbar.php");
include("config/config.php");

// Store search results in session
if (isset($_POST['search_property']) && !empty($_POST['search_property'])) {
    $q_string = mysqli_real_escape_string($db, $_POST['search_property']);
    $sql = "SELECT * FROM add_property WHERE CONCAT(zone, district, province, city, tole, property_type, country) LIKE ?";
    $stmt = mysqli_prepare($db, $sql);
    $search_term = "%{$q_string}%";
    mysqli_stmt_bind_param($stmt, 's', $search_term);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $_SESSION['search_results'] = $result->fetch_all(MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);
}

// Retrieve search results from session
$search_results = isset($_SESSION['search_results']) ? $_SESSION['search_results'] : array();
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
body {
  font-family: Arial, sans-serif;
  line-height: 1.6;
  color: #333;
  padding: 20px;
  background-color: #f0e9d8;
}

.container {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-around;
  gap: 20px;
}

.card {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
  border-radius: 12px;
  overflow: hidden;
  background-color: #fff;
  transition: box-shadow 0.3s ease;
  width: 100%;
  max-width: 400px;
  min-height: 500px;
  padding: 10px;
  display: flex;
  flex-direction: column;
  align-items: center;
}

.card-content {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: space-between;
  width: 100%;
}

.card-title {
  font-size: 28px;
  color: #444;
  margin-bottom: 10px;
}

.card-location {
  color: #777;
  margin-bottom: 10px;
}

.card-image {
  width: 100%;
  height: 250px;
  object-fit: cover;
  border-bottom: 1px solid #eee;
}

.btn {
  padding: 12px 20px;
  background-color: #818dd6;
  color: black;
  text-align: center;
  text-decoration: none;
  border: none;
  border-radius: 5px;
  transition: background-color 0.3s ease;
  margin-top: 10px;
  display: inline-block;
}

.btn:hover {
  background-color: #5b6ac2;
  cursor: pointer;
}

.btn:active {
  background-color: #555;
}

@media (max-width: 768px) {
  .container {
    flex-direction: column;
  }

  .card {
    max-width: 100%;
    padding: 10px;
  }

  .card-title {
    font-size: 22px;
  }

  .card-location {
    font-size: 14px;
  }

  .btn {
    padding: 8px 0;
    font-size: 14px;
  }
}
</style>
    <script>
        window.addEventListener('pageshow', function(event) {
            if (event.persisted || window.performance && window.performance.navigation.type === 2) {
                // This page is being loaded from the browser's cache or the user is navigating back
                // Prevent the form resubmission prompt
                event.preventDefault();
            }
        });

        function goBack() {
            window.history.back();
        }
    </script>
</head>
<body>
    <div class="container">
        <?php
        if (!empty($search_results)) {
            foreach ($search_results as $row) {
                $property_id = $row['property_id'];
                ?>
                <div class="card">
                    <?php
                    $sql2 = "SELECT * FROM property_photo WHERE property_id = ?";
                    $stmt2 = mysqli_prepare($db, $sql2);
                    mysqli_stmt_bind_param($stmt2, 's', $property_id);
                    mysqli_stmt_execute($stmt2);
                    $result2 = mysqli_stmt_get_result($stmt2);

                    if (mysqli_num_rows($result2) > 0) {
                        $photo_row = mysqli_fetch_assoc($result2);
                        $photo = $photo_row['p_photo'];
                        echo '<img class="card-image" src="owner/' . $photo . '">';
                    }
                    ?>
                    <h4 class="card-title"><b><?php echo htmlspecialchars($row['property_type']); ?></b></h4>
                    <p class="card-location"><?php echo htmlspecialchars($row['city'] . ', ' . $row['district']); ?></p>
                    <a href="view-property.php?property_id=<?php echo $row['property_id']; ?>" class="btn btn-primary btn-block" target="_blank">View Property</a>
                </div>
                <?php
            }
        } else {
            echo "<center><h3>No search results found.</h3></center>";
        }
        ?>
    </div>
    <button onclick="goBack()">Back</button>
</body>
</html>
