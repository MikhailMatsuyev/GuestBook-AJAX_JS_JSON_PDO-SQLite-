<?php
/*
** Скрипт возвращает последние записи в гостевой книге
*/

// Читаем данные, переданные в POST
$rawPost = file_get_contents('php://input');

// Заголовки ответа
header('Content-type: text/plain; charset=utf-8');
header('Cache-Control: no-store, no-cache');
header('Expires: ' . date('r'));

// Если данные были переданы...
if ($rawPost) {
	// Разбор пакета JSON
	$record = json_decode($rawPost);
    try
    {
        // Открытие БД
        $db = new PDO('sqlite:gbook.db');
        //$db = new SQLite3('gbook.db');

        // Подготовка данных
        $author = htmlspecialchars($record->author);
        $email = htmlspecialchars($record->email);
        $message = htmlspecialchars($record->message);
        $date = time();

        // Запрос
        $query=$db->prepare("INSERT INTO gbook (author, email, message, date) VALUES (?, ?, ?, ?)");

        $query->bindParam(1, $author);
        $query->bindParam(2, $email);
        $query->bindParam(3, $message);
        $query->bindParam(4, $date);

        $query->execute();
        // VALUES ('$author', '$email', '$message', $date)");
       // $sql = "INSERT INTO gbook (author, email, message, date)
         //   VALUES ('$author', '$email', '$message', $date)";
        //$db->query($sql);
    }catch(PDOException $e){
        echo $e->getMessage();
    }
	// Возврат результата
	echo json_encode(
		array
		(
			'result'          => 'OK',
			'lastInsertRowId' => $db->lastInsertRowID()
		)
	);
} else {
	// Данные не переданы
	echo json_encode(
		array
		(
			'result' => 'No data'
		)
	);
}
?>