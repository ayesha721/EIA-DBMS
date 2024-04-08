<?php
session_start();

if (!isset($_SESSION["user_name"])) {
    header("location: login.php");
    exit;
}

require_once "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['confirm_delete'])) {
        $project_id = $_POST["project_id"];
        
        $sql = "DELETE FROM project WHERE project_id=?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("s", $project_id);
            if ($stmt->execute()) {
                header("location: project_owner.php");
                exit;
            } else {
                echo "Something went wrong. Please try again later.";
            }
            $stmt->close();
        }
    }
}


if (isset($_GET['project_id'])) {
    $project_id = $_GET['project_id'];
    $sql = "SELECT * FROM project WHERE project_id=?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $project_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            
            $project_name = $row["Name"];
        } else {
            echo "Project not found.";
            exit;
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Project</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https:
    <style>
        .container {
            margin-top: 50px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Delete Project</h2>
    <p>Are you sure you want to delete the project "<?php echo $project_name; ?>"?</p>
    <form action="" method="post">
        <input type="hidden" name="project_id" value="<?php echo $project_id; ?>">
        <button type="submit" name="confirm_delete" class="btn btn-danger">Confirm Delete</button>
        <a href="project_owner.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

</body>
</html>
