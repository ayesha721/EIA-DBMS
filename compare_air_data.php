<?php
session_start();

if (!isset($_SESSION["user_name"])) {
    header("location: login.php");
    exit;
}

require_once "config.php";


$result_air_data = null;
$result_updated_air_data = null;


if(isset($_GET['location_id'])) {
    $location_id = $_GET['location_id'];
    
  
    $sql_air_data = "SELECT * FROM air_data WHERE location_id = ?";
    if ($stmt = $conn->prepare($sql_air_data)) {
        $stmt->bind_param("s", $location_id);
        $stmt->execute();
        $result_air_data = $stmt->get_result();
    }
    
    $sql_updated_air_data = "SELECT * FROM updated_air_data WHERE location_id = ?";
    if ($stmt = $conn->prepare($sql_updated_air_data)) {
        $stmt->bind_param("s", $location_id);
        $stmt->execute();
        $result_updated_air_data = $stmt->get_result();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compare Air Data</title>
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
    <h1>Compare Air Data</h1>

    <div class="row">
        <div class="col-md-6">
            <h2>Air Data</h2>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Air Quality</th>
                    <th>Air Temperature (°C)</th>
                    <th>Humidity (%)</th>
                    <th>Wind Speed (km/h)</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if ($result_air_data && $result_air_data->num_rows > 0) {
                    while ($row = $result_air_data->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["air_quality"] . "</td>";
                        echo "<td>" . $row["air_temperature"] . "</td>";
                        echo "<td>" . $row["Humidity"] . "</td>";
                        echo "<td>" . $row["wind_speed"] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No air data found</td></tr>";
                }
                ?>
                </tbody>
            </table>
        </div>

        <div class="col-md-6">
            <h2>Updated Air Data</h2>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Updated Air Quality</th>
                    <th>Updated Air Temperature (°C)</th>
                    <th>Updated Humidity (%)</th>
                    <th>Updated Wind Speed (km/h)</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if ($result_updated_air_data && $result_updated_air_data->num_rows > 0) {
                    while ($row = $result_updated_air_data->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["updated_air_quality"] . "</td>";
                        echo "<td>" . $row["updated_air_temperature"] . "</td>";
                        echo "<td>" . $row["updated_Humidity"] . "</td>";
                        echo "<td>" . $row["updated_wind_speed"] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No updated air data found</td></tr>";
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
