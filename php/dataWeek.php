    <?php
    session_start();
    header('Content-Type:text/event-stream');
    header('Cache-Control:no-cache');
    $lotname = $_SESSION['userId'];
    $mysqli = new MySQLi('182.254.159.229', 'root', 'sdjzu123', 'body_building');
    $mysqli->set_charset('utf8');
    $stmt = $mysqli->prepare('SELECT DATE_FORMAT(startingTime,\'%Y%U\') weeks,SUM(`trainingDuration`)AS "trainTime",SUM(`totalWeight`)AS"totalWeight",SUM(`calorie`)AS "calorie",SUM(`times`)AS "times"FROM `business` WHERE `openId`= ? GROUP BY weeks');
    $stmt->bind_param('s', $lotname);
    $stmt->execute();
    $result = $stmt->get_result();
    $i = 0;
    while ($row = $result->fetch_assoc()) {
        $weeks = $row['weeks'];
        $trainingDuration = $row['trainTime'];
        $totalWeight = $row['totalWeight'];
        $calorie = $row['calorie'];
        $times = $row['times'];
        $arr = array('weeks' => $weeks, 'trainTime' => $trainingDuration, 'totalWeight' => $totalWeight, 'calorie' => $calorie, 'times' => $times);
        if ($i === 0) {
            $i = 1;
        } else {
            echo "\n";
        }
        echo json_encode($arr);
    }

