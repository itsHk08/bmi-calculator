<?php
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

    if ($height > 0) {

        $bmi = $weight / ($height * $height);
        $bmi = round($bmi, 2);

        $status = "";

        if ($bmi < 18.5) {
            $status = "Underweight";
        } elseif ($bmi <= 24.9) {
            $status = "Normal Weight";
        } elseif ($bmi <= 29.9) {
            $status = "Overweight";
        } else {
            $status = "Obese";
        }

        echo "
        <div class='result-card'>

            <h1>Results</h1>

            <div class='result-box'>

                <p><strong>First Name:</strong> $firstname</p>

                <p><strong>Last Name:</strong> $lastname</p>

                <p><strong>Age:</strong> $age</p>

                <p><strong>BMI:</strong> $bmi</p>

                <p><strong>Status:</strong> $status</p>

            </div>

        </div>
        ";
    }
}

?>

</div>

</body>
</html>