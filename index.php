<?php
// index.php
require 'minimax_api.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    
    try {
        $prompt = $_POST['prompt'] ?? '';
        $outputFile = 'videos/' . uniqid() . '.mp4';
        
        ob_start();
        require 'video_generator.php';
        generateVideo($prompt, $outputFile);
        ob_end_clean();
        
        echo json_encode([
            'status' => 'success',
            'video_url' => $outputFile
        ]);
    } catch (Exception $e) {
        echo json_encode([
            'status' => 'error',
            'message' => $e->getMessage()
        ]);
    }
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Video Generator</title>
</head>
<body>
    <h1>Generate Video</h1>
    <form id="videoForm">
        <textarea name="prompt" placeholder="Enter video description..." required></textarea>
        <button type="submit">Generate Video</button>
    </form>
    <div id="result"></div>

    <script>
        document.getElementById('videoForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(e.target);
            const response = await fetch('', {
                method: 'POST',
                body: formData
            });
            
            const result = await response.json();
            const resultDiv = document.getElementById('result');
            
            if (result.status === 'success') {
                resultDiv.innerHTML = `<video controls src="${result.video_url}"></video>`;
            } else {
                resultDiv.textContent = 'Error: ' + (result.message || 'Unknown error');
            }
        });
    </script>
</body>
</html>
