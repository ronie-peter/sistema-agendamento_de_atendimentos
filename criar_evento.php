<?php
    session_start();

    include_once 'conexao.php';

    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    $data_start = str_replace('/', '-', $dados['start']);
    $data_start_conv = date("Y-m-d H:i:s", strtotime($data_start));

    $data_end = str_replace('/', '-', $dados['end']);
    $data_end_conv = date("Y-m-d H:i:s", strtotime($data_end));

    $query_event = "INSERT INTO events (title, color, start, end, dataCadastro) VALUES (:title, :color, :start, :end, now())";

    $insert_event = $conn->prepare($query_event);
    $insert_event->bindParam(':title', $dados['title']);
    $insert_event->bindParam(':color', $dados['color']);
    $insert_event->bindParam(':start', $data_start_conv);
    $insert_event->bindParam(':end', $data_end_conv);

    if ($insert_event->execute()) {
        $retorna = ['sit' => true, 'msg' => '<div class="alert alert-success" role="alert">Evento salvo com sucesso!</div>'];
        $_SESSION['msg'] = '<div class="alert alert-success" role="alert">Evento salvo com sucesso!</div>';
    } else {
        $retorna = ['sit' => false, 'msg' => '<div class="alert alert-danger" role="alert">Erro: Evento não foi cadastrado!</div>'];
    }

    header('Content-Type: application/json');
    echo json_encode($retorna);

/*  
    //em andamento
    require_once "db.php";

    $title = isset($_POST['title']) ? $_POST['title'] : "";
    $start = isset($_POST['start']) ? $_POST['start'] : "";
    $end = isset($_POST['end']) ? $_POST['end'] : "";

    $sqlInsert = "INSERT INTO tbl_events (title,start,end) VALUES ('".$title."','".$start."','".$end ."')";

    $result = mysqli_query($conn, $sqlInsert);

    if (! $result) {
        $result = mysqli_error($conn);
    }
*/

?>