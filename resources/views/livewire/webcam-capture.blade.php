<!-- resources/views/livewire/webcam-capture.blade.php -->

<div>
    @if ($x==1)
        {{--  <img src="" alt="Captured Photo"> --}}
       {{ $x }}
    @else
   
        <div >
            <video id="webcam" autoplay></video>
            <button wire:click="capturePhoto()">Capture Photo</button>
        </div>
    @endif


<script>
    document.addEventListener('livewire:load', function () {
        const webcamElement = document.getElementById('webcam');

        navigator.mediaDevices.getUserMedia({ video: true })
            .then(function (stream) {
                webcamElement.srcObject = stream;
            })
            .catch(function (error) {
                console.error('Error accessing webcam:', error);
            });
    });
</script>

</div>
