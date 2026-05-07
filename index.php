<?php
include 'database.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BMI Calculator</title>

    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="container">

    <div class="card">

        <h1>BMI Calculator</h1>

        <form method="POST">

            <input type="text" name="firstname" placeholder="First Name" required>

            <input type="text" name="lastname" placeholder="Last Name" required>

            <div class="row">

                <input type="number" name="age" placeholder="Age" required>

                <input type="number" step="0.1" name="weight" placeholder="Weight (kg)" required>

                <input type="number" step="0.01" name="height" placeholder="Height (m)" required>

            </div>

            <button type="submit" name="calculate">
                Calculate
            </button>

        </form>

    </div>

<?php

if (isset($_POST['calculate'])) {

    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $age = $_POST['age'];
    $weight = $_POST['weight'];
    $height = $_POST['height'];

    $bmi = $weight / ($height * $height);
    $bmi = round($bmi, 2);

    $sql = "INSERT INTO bmi_records(firstname, lastname, age, weight, height, bmi)
            VALUES('$firstname', '$lastname', '$age', '$weight', '$height', '$bmi')";

    mysqli_query($conn, $sql);

    echo "
    <div class='result-card'>

        <h1>Latest Result</h1>

        <div class='result-box'>

            <p><strong>Name:</strong> $firstname $lastname</p>

            <p><strong>Age:</strong> $age</p>

            <p><strong>BMI:</strong> $bmi</p>

        </div>

    </div>
    ";
}

?>

</div>

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
        </tr>

<?php

$query = "SELECT * FROM bmi_records";
$result = mysqli_query($conn, $query);

while($row = mysqli_fetch_assoc($result)) {

    echo "
    <tr>
        <td>{$row['id']}</td>
        <td>{$row['firstname']}</td>
        <td>{$row['lastname']}</td>
        <td>{$row['age']}</td>
        <td>{$row['weight']}</td>
        <td>{$row['height']}</td>
        <td>{$row['bmi']}</td>
    </tr>
    ";
}

?>

    </table>

</div>

</body>
</html>