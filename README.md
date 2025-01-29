# Minimax Video Generation PHP minimal Application (Beta) 

A PHP application for generating videos using the Minimax API, supporting both text-to-video and image-to-video generation.

## Features
- 🎥 Create video generation tasks via Minimax API
- 🔄 Automatic polling for task status updates
- 📥 Video download with expiration handling
- 🖼️ Support for both text prompts and initial frame images
- 🕹️ CLI and Web interface options

## Prerequisites
- PHP 7.4 or higher
- cURL extension enabled
- Valid Minimax API credentials:
  - API Key
  - Group ID

## Installation
1. Clone the repository:



2. Edit `config.php` with your credentials:
```php
return [
    'api_key' => 'your-api-key-here',
    'group_id' => 'your-group-id-here',
    // ... other settings
];
```

3. Create writable directory for videos:
```bash
mkdir videos
chmod 755 videos
```

## Usage

### Command Line Interface
```bash
php video_generator.php
```

Example output:
```
Task created successfully. Task ID: 116916112212032
Status check 1: Preparing
Status check 2: Processing...
Video generated successfully. File ID: 205258526306433
Downloading video...
Video saved to: generated_video.mp4
```

### Web Interface
1. Start PHP web server:
```bash
php -S localhost:8000
```

2. Open in browser:  
`http://localhost:8000`

3. Submit video prompt through web form

## Configuration Options
```php
return [
    'api_key' => '',       // Required API key
    'group_id' => '',      // Required group ID
    'model' => 'video-01', // Model version
    'poll_interval' => 10, // Seconds between status checks
    'max_attempts' => 30   // Max polling attempts (5 minutes)
];
```

## Security Considerations
- 🔒 Keep API credentials secure
- 🛡️ Validate all user inputs
- ⏳ Handle URL expiration (9 hours)
- 🗑️ Clean up old files regularly

## Troubleshooting
Common issues:
- API Errors: Verify credentials in config.php
- Permission Errors: Ensure `videos` directory is writable
- Timeouts: Increase `max_attempts` in config
- cURL Errors: Verify PHP cURL extension is installed

## License
MIT License

---

**Note**: This is a basic implementation. For production use:
- Implement proper user authentication
- Add rate limiting
- Use database for task tracking
- Implement proper error logging

For API documentation, see:  
[Minimax API Docs](https://minimaxi.com)

