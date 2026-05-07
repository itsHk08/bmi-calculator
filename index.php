<?php
include 'database.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

/* DELETE RECORD */

if(isset($_GET['delete'])) {

    $id = intval($_GET['delete']);

    $deleteQuery = "DELETE FROM bmi_records WHERE id=?";
    $stmt = mysqli_prepare($conn, $deleteQuery);

    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);

    header("Location: index.php");
    exit();
}

/* INSERT RECORD */

if(isset($_POST['calculate'])) {

    $firstname = htmlspecialchars(trim($_POST['firstname']));
    $lastname = htmlspecialchars(trim($_POST['lastname']));
    $age = intval($_POST['age']);
    $weight = floatval($_POST['weight']);
    $height = floatval($_POST['height']);

    /* VALIDATION */

    if(
        !empty($firstname) &&
        !empty($lastname) &&
        $age > 0 &&
        $weight > 0 &&
        $height > 0
    ) {

        $bmi = $weight / ($height * $height);
        $bmi = round($bmi, 2);

        $insertQuery = "INSERT INTO bmi_records
        (firstname, lastname, age, weight, height, bmi)
        VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($conn, $insertQuery);

        mysqli_stmt_bind_param(
            $stmt,
            "ssiddd",
            $firstname,
            $lastname,
            $age,
            $weight,
            $height,
            $bmi
        );

        mysqli_stmt_execute($stmt);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>BMI Calculator</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<div class="container">

    <div class="card">

        <h1>BMI Calculator</h1>

        <form method="POST" id="bmiForm">

            <input
                type="text"
                name="firstname"
                placeholder="First Name"
                required
                pattern="[A-Za-z]+"
                title="Letters only">

            <input
                type="text"
                name="lastname"
                placeholder="Last Name"
                required
                pattern="[A-Za-z]+"
                title="Letters only">

            <div class="row">

                <input
                    type="number"
                    name="age"
                    placeholder="Age"
                    required
                    min="1"
                    max="120">

                <input
                    type="number"
                    step="0.1"
                    name="weight"
                    placeholder="Weight (kg)"
                    required
                    min="1">

                <input
                    type="number"
                    step="0.01"
                    name="height"
                    placeholder="Height (m)"
                    required
                    min="0.5"
                    max="3">

            </div>

            <button type="submit" name="calculate">
                Calculate
            </button>

        </form>

    </div>

</div>

<!-- RECORDS -->

<div class="records">

    <h1>All BMI Records</h1>

    <table>

        <tr>

            <th>ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Age</th>
            <th>Weight</th>
            <th>Height</th>
            <th>BMI</th>
            <th>Actions</th>

        </tr>

<?php

$query = "SELECT * FROM bmi_records";
$result = mysqli_query($conn, $query);

while($row = mysqli_fetch_assoc($result)) {

?>

<tr>

    <td><?php echo $row['id']; ?></td>

    <td><?php echo htmlspecialchars($row['firstname']); ?></td>

    <td><?php echo htmlspecialchars($row['lastname']); ?></td>

    <td><?php echo $row['age']; ?></td>

    <td><?php echo $row['weight']; ?></td>

    <td><?php echo $row['height']; ?></td>

    <td><?php echo $row['bmi']; ?></td>

    <td>

        <a class="delete-btn"
           href="index.php?delete=<?php echo $row['id']; ?>"
           onclick="return confirm('Delete this record?')">

           Delete

        </a>

    </td>

</tr>

<?php
}
?>

    </table>

</div>

<script src="script.js"></script>

</body>
</html>