<?php
if (!file_exists('data/surveyresults.json')) {
    file_put_contents('data/surveyresults.json', '[]');
}

if (isset($_GET['submit']) && isset($_POST['submit'])) {
    // This is a validator to make sure all the data, including the option button is filled.
    if (
        empty($_POST['name']) || empty($_POST['email']) || empty($_POST['dob'])
        || count($_POST['answers']) !== 4
    ) {
        echo "Sorry. All the data must be filled out\n";
        echo '<div><input type="button" value="Go back!" onclick="history.back()"></div>';
        return false;
    }
    array_pop($_POST);

    //get the user's birthday input as a variable.
    $dateOfBirth = $_POST['dob'];
    //create a formatted local time using yyyy-mm-dd
    $today = date("Y-m-d");
    //calculate the difference of the time. This will create an array.
    $difference = date_diff(date_create($dateOfBirth), date_create($today));

    //this variable will fetch the formatted year of difference from the "$difference" variable.
    // The "%" is the format sign, the "y" means year.
    $age = $difference->format('%y');

    $information = array(
        'name'       => $_POST['name'],
        'email'      => $_POST['email'],
        'age'   => $age,
        'answers'  => $_POST['answers'],
    );

    $jsondata_old = file_get_contents("data/surveyresults.json");

    // Decode the old JSON content, then append new data into the existing array,
    // then encode the data and put it into the JSON file to overwrite the old one.
    $json_old_decoded = json_decode($jsondata_old, true);
    array_push($json_old_decoded, $information);
    $new_full_json_data = json_encode($json_old_decoded);
    file_put_contents('data/surveyresults.json', $new_full_json_data);

    header('Location: results.php');
    exit();
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Lab 9 - PHP 3</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/jquery-3.4.1.slim.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col border bg-light">
                <h1 class="text-center mt-3">Survey</h1>
                <hr>
                <form action="?submit" method="post">
                    <div class="row mt-2">
                        <div class="col-md-4">
                            <label for="name">Name:</label>
                            <input type="text" id="name" name="name" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label for="dob">Birthday:</label>
                            <input type="date" id="dob" name="dob" class="form-control">
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col">
                            <p class="text-center mb-auto">1=Lowest, 5=Highest</p>
                        </div>
                    </div>


                    <?php
                    $questions = explode("\n", file_get_contents('data/questions.txt'));

                    for ($i = 0; $i < count($questions); $i++) {
                        echo <<<END

                    <hr>
                    <div class="row mt-2">
                        <div class="col-md-8">
                            <p>{$questions[$i]}</p>
                        </div>
                        <div class="col">
                            <div class="form-check-inline">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="answers[$i]" value="1">1
                                </label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-check-inline">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="answers[$i]" value="2">2
                                </label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-check-inline">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="answers[$i]" value="3">3
                                </label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-check-inline">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="answers[$i]" value="4">4
                                </label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-check-inline">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="answers[$i]" value="5">5
                                </label>
                            </div>
                        </div>
                    </div>
                    END;
                    }
                    ?>

                    <hr class="mt-auto">
                    <div class="row">
                        <div class="col text-center">
                            <input type="submit" name="submit" class="btn btn-primary">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>