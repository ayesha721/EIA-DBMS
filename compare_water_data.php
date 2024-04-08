<?php
session_start();

if (!isset($_SESSION["user_name"])) {
    header("location: login.php");
    exit;
}

require_once "config.php";

$location_id = $_GET['location_id'] ?? '';

if (!empty($location_id)) {
    
    $sql_water_data = "SELECT * FROM water_data WHERE location_id = ?";
    if ($stmt_water_data = $conn->prepare($sql_water_data)) {
        $stmt_water_data->bind_param("s", $location_id);
        $stmt_water_data->execute();
        $result_water_data = $stmt_water_data->get_result();
    }

    
    $sql_updated_water_data = "SELECT * FROM updated_water_data WHERE location_id = ?";
    if ($stmt_updated_water_data = $conn->prepare($sql_updated_water_data)) {
        $stmt_updated_water_data->bind_param("s", $location_id);
        $stmt_updated_water_data->execute();
        $result_updated_water_data = $stmt_updated_water_data->get_result();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compare Water Data</title>
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
    <h1>Compare Water Data</h1>

    <div class="row">
        <div class="col-md-6">
            <h2>Water Data</h2>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Water pH</th>
                    <th>Water Temperature (°C)</th>
                    <th>Water Turbidity</th>
                    <th>Water Level</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if ($result_water_data && $result_water_data->num_rows > 0) {
                    while ($row = $result_water_data->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["water_quality"] . "</td>";
                        echo "<td>" . $row["water_ph"] . "</td>";
                        echo "<td>" . $row["water_temperature"] . "°C</td>";
                        echo "<td>" . $row["water_level"] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No water data found</td></tr>";
                }
                ?>
                </tbody>
            </table>
        </div>

        <div class="col-md-6">
            <h2>Updated Water Data</h2>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Updated Water pH</th>
                    <th>Updated Water Temperature (°C)</th>
                    <th>Updated Water Turbidity</th>
                    <th>Updated Water Level</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if ($result_updated_water_data && $result_updated_water_data->num_rows > 0) {
                    while ($row = $result_updated_water_data->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["updated_water_quality"] . "</td>";
                        echo "<td>" . $row["updated_water_ph"] . "</td>";
                        echo "<td>" . $row["updated_water_temperature"] . "</td>";
                        echo "<td>" . $row["updated_water_level"] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No updated water data found</td></tr>";
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
