<!DOCTYPE html>
<html>
<head>
    <title>Video Upload App</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h1>Video Upload App</h1>
    <input type="file" id="videoFile" accept="video/*">
    <button id="uploadButton">Upload Video</button>
    <progress id="uploadProgress" max="100" value="0"></progress>
    <div id="uploadMessage"></div>

    <script>
        $(document).ready(function() {
            $("#uploadButton").click(function() {
                uploadVideo();
            });
        });

        function uploadVideo() {
            const videoFile = $("#videoFile")[0].files[0];
            if (!videoFile) {
                $("#uploadMessage").text("Please select a video file.");
                return;
            }

            const formData = new FormData();
            formData.append("video", videoFile);

            $.ajax({
                url: "/upload-video",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                xhr: function() {
                    const xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener("progress", function(evt) {
                        if (evt.lengthComputable) {
                            const percentComplete = (evt.loaded / evt.total) * 100;
                            $("#uploadProgress").val(percentComplete);
                        }
                    }, false);
                    return xhr;
                },
                success: function(response) {
                    $("#uploadMessage").text("Upload successful!");
                },
                error: function(xhr, status, error) {
                    $("#uploadMessage").text("Error: " + error);
                }
            });
        }
    </script>
</body>
</html>
