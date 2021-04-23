Webcam.set({
    width: 640,
    height: 480,
    image_format: 'jpeg',
    jpeg_quality: 100
});
Webcam.attach('#camera');
$('#scan_code').on('change', function() {
    Webcam.snap(function(data_uri) {
        $('#scan_photo').val(data_uri);
        $('#scan_save').trigger('click');
    })
})