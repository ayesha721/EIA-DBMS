<?php
session_start();

if (!isset($_SESSION["user_name"])) {
    header("location: login.php");
    exit;
}

require_once "config.php";

$sql = "SELECT DISTINCT measure_type FROM mitigation_measure";
$result = $conn->query($sql);

$measureTypes = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $measureTypes[] = $row["measure_type"];
    }
}

$descriptions = [];
$costs = [];

if (isset($_GET['measure_type1']) && isset($_GET['measure_type2'])) {
    $selectedMeasure1 = $_GET['measure_type1'];
    $selectedMeasure2 = $_GET['measure_type2'];
    
    $sql = "SELECT measure_type, cost FROM mitigation_measure WHERE measure_type IN ('$selectedMeasure1', '$selectedMeasure2')";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $descriptions[] = $row["measure_type"];
            $costs[] = $row["cost"];
        }
    }
} else {
    $sql = "SELECT measure_type, cost FROM mitigation_measure";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $descriptions[] = $row["measure_type"];
            $costs[] = $row["cost"];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cost Graph</title>
    <link rel="stylesheet" href="https:
    <script src="https:
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

        .container {
            margin-top: 50px;
        }
    </style>
</head>
<body>

<div class="navbar">
    
    <<a href="#" onclick="history.back();" class="btn btn-primary">Go Back</a>

    <a href="project_owner.php" class="btn btn-danger">Go Home</a>
</div>

<div class="container">
    <h1>Cost Graph</h1>
    
    <form method="GET" class="mb-3">
        <div class="form-group">
            <label for="measure_type1">Select Measure Type 1:</label>
            <select name="measure_type1" id="measure_type1" class="form-control">
                <option value="">All</option>
                <?php foreach ($measureTypes as $type) : ?>
                    <option value="<?= $type ?>" <?= isset($_GET['measure_type1']) && $_GET['measure_type1'] === $type ? 'selected' : '' ?>>
                        <?= $type ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="measure_type2">Select Measure Type 2:</label>
            <select name="measure_type2" id="measure_type2" class="form-control">
                <option value="">All</option>
                <?php foreach ($measureTypes as $type) : ?>
                    <option value="<?= $type ?>" <?= isset($_GET['measure_type2']) && $_GET['measure_type2'] === $type ? 'selected' : '' ?>>
                        <?= $type ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Filter</button>
    </form>
    
    <div style="width: 75%; margin: auto;">
        <canvas id="myChart"></canvas>
    </div>
</div>

<script>
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($descriptions); ?>,
            datasets: [{
                label: 'Cost',
                data: <?php echo json_encode($costs); ?>,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
</script>

</body>
</html>
