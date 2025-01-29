<?php
// video_generator.php
require 'minimax_api.php';

function generateVideo($prompt, $outputFile) {
    // Step 1: Create video task
    $creationResponse = createVideoTask($prompt);
    
    if ($creationResponse['status'] !== 'success' || 
        $creationResponse['data']['base_resp']['status_code'] !== 0) {
        throw new Exception("Task creation failed: " . 
            ($creationResponse['data']['base_resp']['status_msg'] ?? 'Unknown error'));
    }
    
    $taskId = $creationResponse['data']['task_id'];
    echo "Task created successfully. Task ID: $taskId\n";
    
    // Step 2: Poll for status
    $config = include('config.php');
    $attempts = 0;
    
    while ($attempts < $config['max_attempts']) {
        $attempts++;
        sleep($config['poll_interval']);
        
        $statusResponse = queryTaskStatus($taskId);
        if ($statusResponse['status'] !== 'success') {
            throw new Exception("Failed to query task status");
        }
        
        $statusData = $statusResponse['data'];
        $currentStatus = $statusData['status'] ?? 'unknown';
        
        echo "Status check $attempts: $currentStatus\n";
        
        if ($currentStatus === 'Success') {
            $fileId = $statusData['file_id'];
            echo "Generation successful. File ID: $fileId\n";
            
            // Step 3: Retrieve and download video
            $retrieveResponse = retrieveVideoFile($fileId);
            if ($retrieveResponse['status'] !== 'success' || 
                !isset($retrieveResponse['data']['file']['download_url'])) {
                throw new Exception("Failed to retrieve download URL");
            }
            
            $downloadUrl = $retrieveResponse['data']['file']['download_url'];
            echo "Downloading video from: $downloadUrl\n";
            
            // Download and save the video
            $videoContent = file_get_contents($downloadUrl);
            if ($videoContent === false) {
                throw new Exception("Failed to download video content");
            }
            
            $bytesWritten = file_put_contents($outputFile, $videoContent);
            if ($bytesWritten === false) {
                throw new Exception("Failed to write video file");
            }
            
            echo "Video successfully saved to: $outputFile\n";
            return true;
        } elseif ($currentStatus === 'Fail') {
            throw new Exception("Video generation failed");
        }
    }
    
    throw new Exception("Max polling attempts reached without completion");
}

// Example usage
try {
    generateVideo(
        "On a distant planet, there is a MiniMax.",
        'generated_video.mp4'
    );
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    exit(1);
}
