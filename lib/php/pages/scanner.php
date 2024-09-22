<video id="preview" style="background: black; height:80vh; width: 100%;"></video>
<input type="text" name="qrData" id="qrData" >
<script>
    const args = {
        video: document.getElementById('preview')
    };

    window.URL.createObjectURL = (stream) => {
        args.video.srcObject = stream;
        return stream;
    };

    const scanner = new Instascan.Scanner(args);
    Instascan.Camera.getCameras().then(cameras => {
        if (cameras.length > 0) {
            scanner.start(cameras[0]);
        } else {

            console.error("Please enable Camera!");
        }
    });

    scanner.addListener('scan',function (c) {
        document.getElementById('qrData').value=c;

    })
</script>