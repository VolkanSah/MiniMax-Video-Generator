<?php
// config.php
return [
    'api_key' => 'your_api_key_here',
    'group_id' => 'your_group_id_here',
    'model' => 'video-01', // Default model
    'poll_interval' => 10, // Seconds between status checks
    'max_attempts' => 30 // Max polling attempts (30 * 10s = 5 minutes)
];
