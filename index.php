<?php
$youtubeURL = $videoTitle = $videoQuality = $videoFormat = $videoFileName = $downloadURL = $status = $statusMsg = '';
$isVideo = 0;
if(isset($_POST['submitURL'])){
	// Load and initialize downloader class
    include_once 'YouTubeDownloader.class.php';
    $handler = new YouTubeDownloader();
	
	// Youtube video url
    $youtubeURL = $_POST['youtubeURL'];
    
	// Check whether the url is valid
    if(!empty($youtubeURL) && !filter_var($youtubeURL, FILTER_VALIDATE_URL) === false){
        // Get the downloader object
        $downloader = $handler->getDownloader($youtubeURL);
		
		// Set the url
        $downloader->setUrl($youtubeURL);
        
		// Validate the youtube video url
        if($downloader->hasVideo()){
			// Get the video download link info
            $videoDownloadLink = $downloader->getVideoDownloadLink();
			
            $videoTitle = $videoDownloadLink[1]['title'];
            $videoQuality = $videoDownloadLink[1]['qualityLabel'];
            $videoFormat = $videoDownloadLink[1]['format'];
            $videoFileName = strtolower(str_replace(' ', '_', $videoTitle)).'.'.$videoFormat;
            $downloadURL = $videoDownloadLink[1]['url'];
            
            $isVideo = 1;
			
        }else{
            $statusMsg = "Video is not found, please check YouTube URL and submit again.";
            $status = 'error';
        }
    }else{
        $statusMsg = "Please enter valid YouTube URL.";
        $status = 'error';
    }
}
?>
<!DOCTYPE html>
<html lang="en-US">
<head>
<title>YouTube Video Downloader using PHP</title>
<meta charset="utf-8">

<!-- Custom stylesheet -->
<link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container">
	<h2>YouTube Video Downloader</h2>
	<?php if(!empty($statusMsg)){ ?>
	<div class="col-lg-12">
		<p class="status <?php echo !empty($status)?$status:''; ?>"><?php echo !empty($statusMsg)?$statusMsg:''; ?></p>
	</div>
	<?php } ?>
	<div class="col-lg-12">
		<form method="post" action="">
			<div class="form-group">
				<label>YouTube URL:</label>
				<input type="text" name="youtubeURL" class="form-control" value="<?php echo !empty($youtubeURL)?$youtubeURL:''; ?>" placeholder="e.g. https://www.youtube.com/watch?v=f7wcKoEbUSA" required="">
				<input type="submit" name="submitURL" value="GET VIDEO"/>
			</div>
		</form>
	</div>
	<?php if(!empty($isVideo) && $isVideo == 1){ ?>
	<div class="col-lg-12">
		<div class="callout callout-success">
			<h3>YouTube Video Details</h3>
			<div class="download-btn">
				<form action="download.php" method="post">
					<input type="hidden" name="file" value="<?php echo $videoFileName; ?>"/>
					<input type="hidden" name="url" value="<?php echo $downloadURL; ?>"/>
					<input type="submit" value="DOWNLOAD"/>
				</form>
			</div>
			<p><b>Title:</b> <?php echo $videoTitle; ?></p>
			<p><b>Quality:</b> <?php echo strtoupper($videoQuality); ?></p>
			<p><b>Format:</b> <?php echo $videoFormat; ?></p>
		</div>
	</div>
	<?php } ?>
</div>
</body>
</html>