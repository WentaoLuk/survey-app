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
            <div class="col bg-dark">
                <h1 class="text-center text-white mt-3">Survey Results</h1>
                <hr><?php

                    $questions = explode("\n", file_get_contents('data/questions.txt')); //This will get all the questions as an array.
                    // Create code that will load data from the data/surveyresults.json file and print the data with the same structure as the HTML example below.
                    // Do not edit above this line.

                    //Create a variable to get the contents from the json file 
                    $jsondata = file_get_contents("data/surveyresults.json");



                    // $data = json_decode($jsondata, true);
                    // echo count($data);
                    // echo count($data[0]);

                    $output = '';

                    // the $jasondata variavle needs to be formatted. So we use the decode function,
                    // so that the json information will become an ordered array for users to fetch needed info.
                    $json = json_decode($jsondata, true);

                    for ($j = 0; $j < count($json); $j++) {


                        // Set up an $output variable to contain all the information that needed to be displayed on the result page.
                        $output .= "<div class='card mb-3'>";
                        $output .= '<h5 class="card-header">' . $json[$j]['name'] . '</h5>';
                        $output .= '<div class="card-body">';
                        $output .= '<p class="card-text">Age: ' . $json[$j]['age'] . '</p>';
                        $output .= '<p class="card-text">Email: ' . $json[$j]['email'] . '</p>';
                        $output .= '<table class="table"><tbody>';

                        // break the questions by seperated lines to make the text become an ordered array.
                        $questions = explode("\n", file_get_contents('data/questions.txt'));

                        // This will loop the four questions.
                        for ($i = 0; $i < count($questions); $i++) {
                            $output .= '<tr>';
                            $output .= '<th>' . $questions[$i] . '</th>';
                            $output .= '<td>' . $json[$j]['answers'][$i] . '</td>';
                            $output .= '</tr>';
                        }
                        $output .= '</tbody></table></div></div>';
                    }
                    //End of for loop


                    // print out the formated information.
                    echo $output;

                    // Do not edit below this line.
                    ?>


            </div>
        </div>
    </div>
</body>

</html>