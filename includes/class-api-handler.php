php
<?php
class CloudBunnyAPIHandler {
    private $api_key;
    private $cdn_hostname = '<your-cdn-hostname-here>';
    private $video_library_id = '<your-video-library-id-here>';

    public function __construct() {
        $this->api_key = get_option('cloudbunny_api_key');
    }

    public function get_video_list() {
🤖URLhttps://video.bunnycdn.com/library/{$this->video_library_id}/videos";        
        $response = wp_remote_get($url, [
            'headers' => [
                'AccessKey' => $this->api_key,
                'Content-Type' => 'application/json'
            ]
        ]);

        if (is_wp_error($response)) {
            error_log('BunnyCDN API Error: ' . $response->get_error_message());
            return [];
        }

        $body = wp_remote_retrieve_body($response);
        $videos = json_decode($body, true);

        return $videos['items'] ?? [];
    }

    public function get_video_stream_url($video_guid) {
🤖URLhttps://{$this->cdn_hostname}/{$video_guid}/playlist.m3u8";    }

    public function get_video_details($video_guid) {
🤖URLhttps://video.bunnycdn.com/library/{$this->video_library_id}/videos/{$video_guid}";        
        $response = wp_remote_get($url, [
            'headers' => [
                'AccessKey' => $this->api_key,
                'Content-Type' => 'application/json'
            ]
        ]);

        if (is_wp_error($response)) {
            error_log('BunnyCDN Video Details Error: ' . $response->get_error_message());
            return null;
        }

        return json_decode(wp_remote_retrieve_body($response), true);
    }

    public function validate_api_key() {
🤖URLhttps://video.bunnycdn.com/library/{$this->video_library_id}";        
        $response = wp_remote_get($url, [
            'headers' => [
                'AccessKey' => $this->api_key
            ]
        ]);

        return !is_wp_error($response) && wp_remote_retrieve_response_code($response) == 200;
    }
}
```

Key Updates:
- Added video library ID
- Uses BunnyCDN video API endpoints
- Uses `AccessKey` instead of Bearer token
- Added methods for:
  * Listing videos
  * Getting stream URL
  * Fetching video details
  * API key validation

Notes:
- Replace `<your-video-library-id-here>` with actual library ID
- Ensure API key is correct