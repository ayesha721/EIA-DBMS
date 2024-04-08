<?php
session_start();

if (!isset($_SESSION["user_name"])) {
    header("location: login.php");
    exit;
}

require_once "config.php";

$location_id = $_GET['location_id'] ?? '';

if (!empty($location_id)) {
    
    $sql_soil_data = "SELECT * FROM soil_data WHERE location_id = ?";
    if ($stmt_soil_data = $conn->prepare($sql_soil_data)) {
        $stmt_soil_data->bind_param("s", $location_id);
        $stmt_soil_data->execute();
        $result_soil_data = $stmt_soil_data->get_result();
    }

    
    $sql_updated_soil_data = "SELECT * FROM updated_soil_data WHERE location_id = ?";
    if ($stmt_updated_soil_data = $conn->prepare($sql_updated_soil_data)) {
        $stmt_updated_soil_data->bind_param("s", $location_id);
        $stmt_updated_soil_data->execute();
        $result_updated_soil_data = $stmt_updated_soil_data->get_result();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compare Soil Data</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https:
    <style>
        .navbar {
            background-color: #468847;
            color: white;
        }

        .navbar a {
            color: white;
            text-decoration: none;
        }

        .navbar a:hover {
            background-color: #6c6c6c;
        }

        .navbtns {
            float: right;
        }

        .btn {
            margin-right: 10px;
        }
    </style>
</head>
<body>

<div class="navbar">
    <a href="project_owner.php" class="btn btn-primary">Go Home</a>
    <div class="navbtns">
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>
</div>

<div class="container-fluid mt-4">
    <h1>Compare Soil Data</h1>

    <div class="row">
        <div class="col-md-6">
            <h2>Soil Data</h2>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Soil Type</th>
                    <th>Soil Moisture</th>
                    <th>Soil pH</th>
                    <th>Soil Nutrients</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if ($result_soil_data && $result_soil_data->num_rows > 0) {
                    while ($row = $result_soil_data->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["Soiltype"] . "</td>";
                echo "<td>" . $row["Soilmoisture"] . "</td>";
                echo "<td>" . $row["soilPH"] . "</td>";
                echo "<td>" . $row["SoilNutrients"] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No soil data found</td></tr>";
                }
                ?>
                </tbody>
            </table>
        </div>

        <div class="col-md-6">
            <h2>Updated Soil Data</h2>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Updated Soil Type</th>
                    <th>Updated Soil Moisture</th>
                    <th>Updated Soil pH</th>
                    <th>Updated Soil Nutrients</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if ($result_updated_soil_data && $result_updated_soil_data->num_rows > 0) {
                    while ($row = $result_updated_soil_data->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["updated_Soiltype"] . "</td>";
                        echo "<td>" . $row["updated_Soilmoisture"] . "</td>";
                        echo "<td>" . $row["updated_soilPH"] . "</td>";
                        echo "<td>" . $row["updated_SoilNutrients"] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No updated soil data found</td></tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>

    <a href="javascript:history.go(-1);" class="btn btn-primary">Go Back</a>
</div>

</body>
</html>
