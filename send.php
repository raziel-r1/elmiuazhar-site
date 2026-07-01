<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // для тестов. Потом лучше ограничить доменом

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Только POST']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
if (!$input) {
    http_response_code(400);
    echo json_encode(['error' => 'Неверные данные']);
    exit;
}

// --- ВСТАВЛЯТЬ ТОЛЬКО ЗДЕСЬ ---
$token = '8337243635:AAHjshtQE6WuDBk9cfV9hHf6qEE1yDutYhQ';
$chat_id = '1758163539';
// -----------------------------

$name = htmlspecialchars($input['name'] ?? '');
$contact = htmlspecialchars($input['contact'] ?? '');
$description = htmlspecialchars($input['description'] ?? '');

if (!$name || !$contact || !$description) {
    http_response_code(400);
    echo json_encode(['error' => 'Заполните все поля']);
    exit;
}

$message = "📩 Новый заказ!\n\n" .
           "Имя/ник: $name\n" .
           "Контакт: $contact\n" .
           "Описание:\n$description\n" .
           "\n💵 Платные правки: 10 € за штуку (первые 2 бесплатно).";

$url = "https://api.telegram.org/bot$token/sendMessage";
$data = http_build_query([
    'chat_id' => $chat_id,
    'text' => $message,
    'parse_mode' => 'HTML'
]);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
curl_close($ch);

http_response_code(200);
echo json_encode(['status' => 'ok']);
?>
