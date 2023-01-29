<?php


$address = "tkachuk.olexiy@gmail.com";

if (!defined("PHP_EOL")) define("PHP_EOL", "\r\n");



$select1 = trim(strip_tags($_POST['f']['selector1']));
$select2 = trim(strip_tags($_POST['f']['selector2']));
$name = trim(strip_tags($_POST['f']['name']));
$phone = trim(strip_tags($_POST['f']['telephone']));
$question = trim(strip_tags($_POST['f']['question']));
//-----------------

    // тут производим сохранение полученных из формы данных. С этой задачей, думаю, сможете справиться самостоятельно,
    // приведу в качестве примера просто возврат принятых сервером данных:

    $req = false; // изначально переменная для "ответа" - false

    // Приведём полученную информацию в удобочитаемый вид
    ob_start();
    /*echo '<pre>';
    print_r($_POST);
    print_r($_FILES['file']);
    echo '</pre>';*/


    //echo "<div id='success_page'>";
    //echo "<div>Ваш запрос успешно отправлен!</div>";
    //echo "</div>";


    //$req = ob_get_contents();
    //ob_end_clean();
    //echo json_encode($req); // вернем полученное в ответе
    //exit;


//-----------------




if(trim($name) == '') {
    echo "<div class='error_message'>Введите Ваше имя.</div>";
    $req = ob_get_contents();
    ob_end_clean();
    echo json_encode($req); // вернем полученное в ответе
    exit();
} else if(trim($phone) == '') {
    echo '<div class="error_message">Введите Ваш телефон.</div>';
    $req = ob_get_contents();
    ob_end_clean();
    echo json_encode($req); // вернем полученное в ответе
    exit();
}
if (!empty($select1)){
    $e_service = "На чем печатаем: $select1" . PHP_EOL;
}
if (!empty($select2)){
    $e_service .= "Какой тираж: $select2" . PHP_EOL . PHP_EOL;
}
if (!empty($question)){
    $e_service .= "Вопрос: $question" . PHP_EOL . PHP_EOL;
}

$e_subject = 'Новый клиент WonderPrint - ' . $name . '.';

$e_body = "Имя: $name" . PHP_EOL;
$e_content = "Телефон: $phone" . PHP_EOL . PHP_EOL;




    if($_FILES['file']['name'] != ''){
        $test = explode('.', $_FILES['file']['name']);
        $extension = end($test);
        $name_file = rand(100,999).'.'.$extension;

        $location = 'uploads/'.$name_file;
        move_uploaded_file($_FILES['file']['tmp_name'], $location);

        $url = "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $clear_url = str_replace("mail1.php", "", $url);

        $full_link = $clear_url.''.$location;
        $e_service .= "Прикрепленный файл: ". $full_link . PHP_EOL . PHP_EOL;
    }


    $msg = wordwrap( $e_body . $e_content . $e_reply . $e_service, 70 );

    $headers .= "Reply-To: $email" . PHP_EOL;
    $headers .= "MIME-Version: 1.0" . PHP_EOL;
    $headers .= "Content-type: text/plain; charset=utf-8" . PHP_EOL;
    $headers .= "Content-Transfer-Encoding: quoted-printable" . PHP_EOL;

    if(mail($address, $e_subject, $msg, $headers)) {

        echo "<div id='success_page'>";
        echo "<div>Ваш запрос успешно отправлен!</div>";
        echo "</div>";
        $req = ob_get_contents();
        ob_end_clean();
        echo json_encode($req); // вернем полученное в ответе
        exit();

    } else {

        echo 'ERROR!';

    }
