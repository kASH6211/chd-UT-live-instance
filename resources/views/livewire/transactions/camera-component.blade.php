<div class="flex flex-col justify-center items-center w-full">
<canvas id="imageCanvas" class="w-40 h-36 rounded-md bg-gray-200">No Photo</canvas>

<div class="flex py-2">
<a href="javascript:void(0)" class="cursor-pointer hover:bg-blue-200 p-2 rounded-md" wire:click="openCamera()">
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="w-6 h-6 stroke-blue-800">
  <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z" />
  <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z" />
</svg>

</a>

 
@if($capturedImage)
<a href="javascript:void(0)" class="cursor-pointer  hover:bg-lime-200 p-2 rounded-md" wire:click="sendImageToParent()">
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"  class="w-6 h-6 stroke-lime-700 hover:bg-lime-200">
  <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
</svg>
</a>
@endif


</div>



{{-- <img src="{{ $capturedImage }}" alt="Captured Image" class="w-40 h-36"/>--}}
<input type="hidden" id="hiddenbase64image" wire:model="capturedImage"/>



<x-confirmation-modal maxWidth="lg" wire:model="viewmodal">

    <x-slot name="icon">
        <svg class="h-6 w-6 stroke-white" stroke-width="1.5" fill="none" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
        </svg>
    </x-slot>


    <x-slot name="title">
      Capture Employee Image
    </x-slot>


    <x-slot name="content">
<video id="videoElement" autoplay playsinline></video>

    </x-slot>
   
    <x-slot name="footer">
        
        
        <a href="javascript:void(0)">
            <x-primary-button wire:click="captureImage()" wire:loading.attr="disabled" class="mr-2">
               Capture
            </x-primary-button>
        </a>
     
        <x-secondary-button wire:click="$toggle('viewmodal')" wire:loading.attr="disabled">
            Close
        </x-secondary-button>



    </x-slot>
</x-confirmation-modal>
 <script>
 window.addEventListener('startCamera', function (event) {
        openCamera();
    });
    window.addEventListener('capture', function (event) {
        captureImage();
    });
   async function openCamera()
   {
    const cameraFeed = document.getElementById('videoElement');
        try {
            const stream = await navigator.mediaDevices.getUserMedia({ video: true });
            cameraFeed.srcObject = stream;
        } catch (error) {
            console.error('Error accessing camera:', error);
        }
   }
   function captureImage()
   {
        const canvasElement = document.getElementById('imageCanvas');
        const videoElement = document.getElementById('videoElement');  
        const mediaStream = videoElement.srcObject; 
        const context = canvasElement.getContext('2d');

        // Capture the current frame from the video stream
        context.drawImage(videoElement, 0, 0, canvasElement.width, canvasElement.height);
        const imageDataURL = canvasElement.toDataURL('image/jpeg');
       // document.querySelector('input[type="hidden"]').value = imageDataURL;
       document.getElementById('hiddenbase64image').value = imageDataURL;
@this.set('capturedImage', imageDataURL);
       // const videoElement = document.getElementById('videoElement');   
      
        if (mediaStream) {
        
                mediaStream.getTracks().forEach((track) => {
                track.stop();
                });
                mediaStream = null;
                videoElement.srcObject = null;
        }
        
   }
  </script>
 
</div>
