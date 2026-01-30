<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

// Carrega mensagens existentes
$mensagens = file_exists('mensagens.json') 
    ? json_decode(file_get_contents('mensagens.json'), true) 
    : [];

// Se recebeu uma nova mensagem via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (isset($input['mensagem']) && !empty($input['mensagem'])) {
        // Adiciona nova mensagem
        $mensagens[] = [
            'texto' => $input['mensagem'],
            'data' => date('Y-m-d H:i:s'),
            'id' => count($mensagens) + 1
        ];
        
        // Salva no JSON
        file_put_contents('mensagens.json', json_encode($mensagens, JSON_PRETTY_PRINT));
        
        echo json_encode([
            'sucesso' => true,
            'mensagem' => 'Mensagem salva com sucesso!',
            'total' => count($mensagens)
        ]);
    } else {
        echo json_encode([
            'sucesso' => false,
            'mensagem' => 'Mensagem vazia'
        ]);
    }
}

// Se for GET, retorna todas as mensagens
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    echo json_encode([
        'sucesso' => true,
        'mensagens' => $mensagens,
        'total' => count($mensagens)
    ]);
}
?>
