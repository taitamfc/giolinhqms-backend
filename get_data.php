<?php
$data = [
    ['id' => 1, 'text' => 'Alabama'],
    ['id' => 2, 'text' => 'Alaska'],
    ['id' => 3, 'text' => 'Arizona'],
];

header('Content-Type: application/json');
echo json_encode($data);
?>
