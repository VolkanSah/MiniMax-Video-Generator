<?php
// minimax_api.php
require 'config.php';

function createVideoTask($prompt, $firstFrameImage = null) {
    $config = include('config.php');
    $url = "https://api.minimaxi.chat/v1/video_generation";
    
    $data = [
        'model' => $config['model'],
        'prompt' => $prompt,
        'prompt_optimizer' => true
    ];
    
    if ($firstFrameImage) {
        $data['first_frame_image'] = $firstFrameImage;
    }
    
    $headers = [
        'Authorization: Bearer ' . $config['api_key'],
        'Content-Type: application/json'
    ];
    
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_POST => true,
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_RETURNTRANSFER => true
    ]);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    return [
        'status' => $httpCode == 200 ? 'success' : 'error',
        'data' => json_decode($response, true)
    ];
}

function queryTaskStatus($taskId) {
    $config = include('config.php');
    $url = "https://api.minimaxi.chat/v1/query/video_generation?task_id=" . urlencode($taskId);
    
    $headers = [
        'Authorization: Bearer ' . $config['api_key']
    ];
    
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_RETURNTRANSFER => true
    ]);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    return [
        'status' => $httpCode == 200 ? 'success' : 'error',
        'data' => json_decode($response, true)
    ];
}

function retrieveVideoFile($fileId) {
    $config = include('config.php');
    $url = "https://api.minimaxi.chat/v1/files/retrieve?" . http_build_query([
        'GroupId' => $config['group_id'],
        'file_id' => $fileId
    ]);
    
    $headers = [
        'Authorization: Bearer ' . $config['api_key']
    ];
    
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_RETURNTRANSFER => true
    ]);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    return [
        'status' => $httpCode == 200 ? 'success' : 'error',
        'data' => json_decode($response, true)
    ];
}
