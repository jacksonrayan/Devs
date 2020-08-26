<?php

$host = "sql305.epizy.com";
    $user = "epiz_26508816";
    $pass = "RaOMYYElDS";
    $db = "epiz_26508816_db1";

    $conn = mysqli_connect($host ,$user ,$pass ,$db);

$txnid = $_POST['id'];
$amount = $_POST['amount'];
$id = $_POST['rmtr_to_bene_note'];
$amt = 1;

function credit($id, $total, $wallet, $conn)
{

    switch ($total) {

        case 3:
            $payout = 100;
            break;
        case 9:
            $payout = 350;
            break;
        case 27:
            $payout = 1100;
            break;
        case 81:
            $payout = 3500;
            break;
        case 243:
            $payout = 11000;
            break;
    }
    $payout += $wallet;
    mysqli_query($conn, "UPDATE users SET wallet=$payout WHERE id=$id;");
}

function upgrade($id, $conn)
{

    for ($x = 1; $x <= 5; $x++) {

        $senior = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id=$id;"));
        $total = $senior['total'];
        $total++;
        $direct = $senior['direct'];
        $wallet = $senior['wallet'];
        if ($x == 1) {
            $direct++;
        }

        $y = array("3", "9", "27", "81", "243");

        if (in_array($total, $y)) {
            credit($id, $total, $wallet, $conn);
        }
        mysqli_query($conn, "UPDATE users SET total='$total', direct='$direct' WHERE id=$id;");
        $id = $senior['referrer'];
    }
}
if ($amount == $amt) {

    mysqli_query($conn, "UPDATE `users` SET `status`='active', `txn_id`=$txnid WHERE `id`=$id");
    upgrade($id, $conn);
}
?>
