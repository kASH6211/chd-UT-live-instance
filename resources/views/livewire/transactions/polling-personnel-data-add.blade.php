<div>
    <x-loading-indicator />
    <div class="flex border bg-blue-900/5 border-dashed border-blue-900/30 p-4 rounded-md justify-between items-center mb-4">

        <h1 class="text-l text-blue-900"><span class="font-semibold">Department -</span> {{ $deptname}}</h1>
        <h1 class="text-l text-blue-900"><span class="font-semibold">Office -</span> {{ $officename }}</h1>


    </div>
    <div class="p-2 bg-blue-900/20 rounded-t-md text-blue-900 ">Personal Details</div>
    <div class="rounded-b-md mb-4 bg-blue-900/5 border-blue-900/30  border border-t-0 border-dashed ">
        <div class="grid grid-cols-3 p-4 py-8 gap-2">
            <div class="w-full">

                <div class="flex">
                    <x-label for="empcode" value="{{ __('Name')}}" />
                    <span class="text-red-500 ml-1">*</span>
                </div>


                <x-input wire:model.defer="object.Name" class="block w-full" type="text" :value="old('Name')" required />
            </div>
            <div class="w-full">

                <div class="flex">
                    <x-label for="empcode" value="{{ __('Father\\Husband Name')}}" />
                    <span class="text-red-500 ml-1">*</span>
                </div>

                <x-input wire:model.defer="object.FName" class="block w-full" type="text" :value="old('FName')" required />
            </div>

            <div class="w-full">
                <div class="flex">
                    <x-label for="empcode" value="{{ __('Sex')}}" />
                    <span class="text-red-500 ml-1">*</span>
                </div>

                <x-select wire:model.defer="object.sex " type="text" class="block w-full" :ddlist="$sexlist" idfield="code" textfield="description" />

            </div>

            <div class="w-full">

                <div class="flex">
                    <x-label for="empcode" value="{{ __('Mobile No.')}}" />
                    <span class="text-red-500 ml-1">*</span>
                </div>

                <x-input wire:model.defer="object.mobileno" minlength="10" maxlength="10" class="block w-full" type="text" :value="old('office')" required />
            </div>
            <div class="w-full">

                <x-label for="empcode" value="{{ __('Email Id') }}" />
                <x-input wire:model.defer="object.emailid" class="block w-full" type="text" :value="old('office')" required />
            </div>

            <div class="w-full">

                <div class="flex">
                    <x-label for="empcode" value="{{ __('Date of Birth')}}" />
                    <span class="text-red-500 ml-1">*</span>
                </div>

                <x-input wire:model.defer="object.dob" class="block w-full" type="date" :value="old('dob')" required />
            </div>
            <div class="w-full">

                <div class="flex">
                    <x-label for="empcode" value="{{ __('Date of Retirement')}}" />
                    <span class="text-red-500 ml-1">*</span>
                </div>

                <x-input wire:model.defer="object.retiredt" class="block w-full" type="date" :value="old('retiredt')" required />
            </div>
        </div>
    </div>

    <div class="p-2 bg-blue-900/20 rounded-t-md text-blue-900 ">Designation & Salary</div>
    <div class="rounded-b-md mb-4 bg-blue-900/5 border-blue-900/30  border border-t-0 border-dashed ">
        <div class="grid grid-cols-3 p-4 py-8 gap-2">
            <div class="w-full">
                <div class="flex">
                    <x-label for="empcode" value="{{ __('Designation')}}" />
                    <span class="text-red-500 ml-1">*</span>
                </div>

                <x-select wire:model.defer="object.DesigCode" wire:change="getsuggestion('desg')" type="text" class="block w-full" :ddlist="$desiglist" idfield="DesigCode" textfield="Designation" />

            </div>


            <div class="w-full">
                <div class="flex">
                    <x-label for="empcode" value="{{ __('Employee Type')}}" />
                    <span class="text-red-500 ml-1">*</span>
                </div>

                <x-select wire:model.defer="object.EmpTypeId" type="text" class="block w-full" :ddlist="$emptypelist" idfield="EmpTypeId" textfield="EmpTypeName" />

            </div>


            <div class="w-full">
                <div class="flex">
                    <x-label for="empcode" value="{{ __('Class (A\\B\\C)')}}" />
                    <span class="text-red-500 ml-1">*</span>
                </div>

                <x-select wire:model.defer="object.category " type="text" class="block w-full" :ddlist="$classlist" idfield="code" textfield="description" />

            </div>
            <div class="w-full">
                <div class="flex">
                    <x-label for="empcode" value="{{ __('Pay Scale')}}" />
                    <span class="text-red-500 ml-1">*</span>
                </div>

                 <x-select wire:model.defer="object.PayScaleCode" wire:change="getsuggestion('pay')" type="text" class="block w-full" :ddlist="$pslist" idfield="PayScaleCode" textfield="PayScale" />

            </div>
            <div class="w-full">

                <div class="flex">
                    <x-label for="empcode" value="{{ __('Basic Pay')}}" />
                    <span class="text-red-500 ml-1">*</span>
                </div>

                <x-input wire:model.defer="object.basicPay" class="block w-full" type="text" :value="old('basicPay')" required />
            </div>
            <div class="w-full">

                <x-label for="empcode" value="{{ __('DDO Code') }}" />
                <x-input wire:model.defer="object.ddocode" class="block w-full" type="text" :value="old('ddocode')" required />
            </div>
            <div class="w-full">

                <x-label for="empcode" value="{{ __('HRMS Code') }}" />
                <x-input wire:model.defer="object.hrmscode" class="block w-full" type="text" :value="old('ddocode')" required />
            </div>
            <div class="w-full">

                <x-label for="empcode" value="{{ __('IFMS Payee Code') }}" />
                <x-input wire:model.defer="object.ifmscode" class="block w-full" type="text" :value="old('ddocode')" required />
            </div>

        </div>
    </div>

    <div class="p-2 bg-blue-900/20 rounded-t-md text-blue-900 ">Office & Home Address</div>
    <div class="rounded-b-md mb-4 bg-blue-900/5 border-blue-900/30  border border-t-0 border-dashed ">
        <div class="grid grid-cols-3 p-4 py-8 gap-2">
            <div class="w-full">
                <div class="flex">
                    <x-label for="empcode" value="{{ __('Native Assembly Segment')}}" />
                    <span class="text-red-500 ml-1">*</span>
                </div>

                {{-- <x-select wire:model.defer="object.nativecon" type="text" class="" :ddlist="$conslist" idfield="AC_NO" textfield="AC_NAME" /> --}}
                <select wire:model.defer="object.nativecon" type="text" class="border-0 focus:ring-0 w-full form-select block w-full text-gray-500 focus:border-blue-100 focus:ring focus:ring-blue-100 focus:ring-opacity-50 rounded-sm shadow-sm">
                    <option value="-1">Select Option</option>
                    @foreach ($conslist as $item)
                    <option class="border-0 border-purple-100 leading-loose" value={{$item['AC_NO']}}>{{$item['AC_NAME']}}</option>
                    @endforeach
                    <!-- <option value="0">Others</option> -->
                </select>

            </div>
            <div class="w-full">
                <div class="flex">
                    <x-label for="empcode" value="{{ __('Residence Assembly Segment')}}" />
                    <span class="text-red-500 ml-1">*</span>
                </div>

                {{-- <x-select wire:model.defer="object.HomeCons" type="text" class="block w-full" :ddlist="$conslist" idfield="AC_NO" textfield="AC_NAME" /> --}}
                <select wire:model.defer="object.HomeCons" type="text" class="border-0 focus:ring-0 w-full form-select block w-full text-gray-500 focus:border-blue-100 focus:ring focus:ring-blue-100 focus:ring-opacity-50 rounded-sm shadow-sm">
                    <option value="-1">Select Option</option>
                    @foreach ($conslist as $item)
                    <option class="border-0 border-purple-100 leading-loose" value={{$item['AC_NO']}}>{{$item['AC_NAME']}}</option>
                    @endforeach
                    <!-- <option value="0">Others</option> -->
                </select>
            </div>

            <div class="w-full">
                <div class="flex">
                    <x-label for="empcode" value="{{ __('Place of Posting under which Assembly Segment')}}" />
                    <span class="text-red-500 ml-1">*</span>
                </div>
                
                {{-- <x-select wire:model.defer="object.cons" type="text" class="block w-full" :ddlist="$conslist" idfield="AC_NO" textfield="AC_NAME" /> --}}
                @if($officecons!=null && $object['cons']&& $object['cons'] != -1 )
                <div class="bg-gray-50 border cursor-not-allowed border-gray-200 px-2 py-1 h-10 rounded-sm  text-gray-400">
                    {{ $officeconsname}}
                </div>
                @else
                <select wire:model.defer="object.cons" type="text" class="border-0 focus:ring-0  form-select block w-full text-gray-500 focus:border-blue-100  focus:ring-blue-100 focus:ring-opacity-50 rounded-sm shadow-sm">

                    <option value="-1">Select Option</option>
                    @foreach ($conslist as $item)
                    <option   class="border-0 border-purple-100 leading-loose" value={{$item['AC_NO']}}>{{$item['AC_NAME']}}</option>
                    @endforeach
                    <!-- <option value="0">Others</option> -->
                </select>
                @endif


            </div>

            <div class="w-full">

                <div class="flex">
                    <x-label for="empcode" value="{{ __('Office Name and Address')}}" />
                    <span class="text-red-500 ml-1">*</span>
                </div>

                <x-input wire:model.defer="object.office" class="block w-full" type="text" :value="old('office')" required />
            </div>

            <div class="w-full">

                <div class="flex">
                    <x-label for="empcode" value="{{ __('Home Resd. Address and Phone No.')}}" />
                    <span class="text-red-500 ml-1">*</span>
                </div>

                <x-input wire:model.defer="object.rAddress" class="block w-full" type="text" :value="old('office')" required />
            </div>

            <div class="w-full">

                <div class="flex">
                    <x-label for="epic" value="{{ __('Epic No.')}}" />
                   
                </div>

                <x-input wire:model.defer="object.epicno" class="block w-full" type="text" :value="old('epicno')" required />
            </div>

            <div class="w-full">
                <div class="flex">
                    <x-label for="empcode" value="{{ __('Vote Registered at AC')}}" />
                   
                </div>

                {{-- <x-select wire:model.defer="object.HomeCons" type="text" class="block w-full" :ddlist="$conslist" idfield="AC_NO" textfield="AC_NAME" /> --}}
                <select wire:model.defer="object.RegdVoterCons" type="text" class="border-0 focus:ring-0 w-full form-select block w-full text-gray-500 focus:border-blue-100 focus:ring focus:ring-blue-100 focus:ring-opacity-50 rounded-sm shadow-sm">
                    <option value="-1">Select Option</option>
                    @foreach ($conslist as $item)
                    <option class="border-0 border-purple-100 leading-loose" value={{$item['AC_NO']}}>{{$item['AC_NAME']}}</option>
                    @endforeach
                    <!-- <option value="0">Others</option> -->
                </select>
            </div>
            <div class="w-full">

                <div class="flex">
                    <x-label for="epic" value="{{ __('Part No.')}}" />
                   
                </div>

                <x-input wire:model.defer="object.partno" class="block w-full" type="text" :value="old('partno')" required />
            </div>

            <div class="w-full">

                <div class="flex">
                    <x-label for="epic" value="{{ __('Serial No. in Part No.')}}" />
                   
                </div>

                <x-input wire:model.defer="object.serialno" class="block w-full" type="text" :value="old('serialno')" required />
            </div>
            {{-- <div class="w-full">
                <x-label for="name" value="{{ __('Class') }}" />
            <x-select wire:model.defer="object.class " type="text" class="block w-full" :ddlist="$classlist" idfield="code" textfield="description" />

        </div>
        <div class="w-full">
            <x-label for="name" value="{{ __('Pay Scale') }}" />
            <x-select wire:model.defer="object.PayScaleCode" type="text" class="block w-full" :ddlist="$pslist" idfield="PayScaleCode" textfield="PayScale" />

        </div>
        <div class="w-full">

            <x-label for="empcode" value="{{ __('Basic Pay') }}" />
            <x-input wire:model.defer="object.basicPay" class="block w-full" type="text" :value="old('basicPay')" required />
        </div>--}}

    </div>
</div>

<div class="p-2 bg-blue-900/20 rounded-t-md text-blue-900 ">Election Duty</div>
<div class="rounded-b-md mb-4 bg-blue-900/5 border-blue-900/30  border border-t-0 border-dashed ">
    <div class="grid grid-cols-3 p-4 py-8 gap-2">

        <div class="w-full">
            <x-label for="name" value="{{ __('Already Exercised Election Duty(if Yes Select)') }}" />
            <x-select wire:model.defer="object.excercisedElectionDuty" type="text" class="block w-full" :ddlist="$classlist2" idfield="description" textfield="description" />

        </div>

        <div class="w-full">
            <div class="flex">
                <x-label for="empcode" value="{{ __('Select As')}}" />
                <span class="text-red-500 ml-1">*</span>
            </div>

             <x-select wire:model="object.class" type="text" data-tooltip-target="tooltip-imported" class="block w-full" :ddlist="$classlist2" idfield="class" textfield="description" />
                @if($sugg1 || $sugg2)
                <div id="tooltip-imported" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-600 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                    @if($sugg1)
                    <div>{{$sugg1}}</div>
                     @endif
                      @if($sugg2)
                    <div>{{$sugg2}}</div>
                     @endif
                    <div class="tooltip-arrow" data-popper-arrow></div>  
                </div>
                @else
                <div id="tooltip-imported"></div>
                @endif
        </div>
        @if ($object->class==11)
        <div class="w-full">
            <div class="flex">
                <x-label for="empcode" value="{{ __('BLO in which asembly segment')}}" />
                <span class="text-red-500 ml-1">*</span>
            </div>

            <x-select wire:model="bloconscode" wire:change="getBoothList" type="text" class="block w-full" :ddlist="$consdistlist" idfield="ac_no" textfield="ac_name" />

        </div>

        <div class="w-full">
            <div class="flex">
                <x-label for="empcode" value="{{ __('BLO on which Booth')}}" />
                <span class="text-red-500 ml-1">*</span>
            </div>
            <x-select wire:model="bloboothno" type="text" class="block w-full" :ddlist="$boothlist" idfield="BOOTHNO" textfield="VILLAGE" />

            
        </div>

            
        @endif


        <div class="w-full flex">

            <div class="ml-12">

                <x-label for="name" value="{{ __('Differently Abled') }}" />
                <x-checkbox wire:model.defer="object.handicap" />
            </div>
            <div class="ml-12">
                <x-label for="name" value="{{ __('On Long Leave') }}" />
                <x-checkbox wire:model.defer="object.longLeave" />

            </div>


        </div>


        <div class="w-full">
            <x-label for="name" value="{{ __('Remarks') }}" />
            <x-input wire:model.defer="object.Remarks" class="block w-full" type="text" :value="old('Remarks')" required />

        </div>

    </div>
</div>

<div class="p-2 bg-blue-900/20 rounded-t-md text-blue-900 ">Bank Details</div>
<div class="rounded-b-md mb-4 bg-blue-900/5 border-blue-900/30  border border-t-0 border-dashed ">
    <div class="grid grid-cols-3 p-4 py-8 gap-2">

        <div class="w-full">
            <x-label for="name" value="{{ __('Bank Name') }}" />
            <x-select wire:model.defer="object.BankId" type="text" class="block w-full" :ddlist="$banklist" idfield="BankId" textfield="BankName" />

        </div>

        <div class="w-full">
            <x-label for="name" value="{{ __('Bank A/c No.') }}" />
            <x-input wire:model.defer="object.BankAcNo" class="block w-full" type="text" :value="old('BankAcNo')" required />

        </div>
        <div class="w-full">
            <x-label for="name" value="{{ __('IFSC Code') }}" />
            <x-input wire:model.defer="object.IfscCode" class="block w-full" type="text" :value="old('IfscCode')" required />

        </div>

    </div>
</div>

<div class="p-2 bg-blue-900/20 rounded-t-md text-blue-900 ">Upload Employee Photo</div>
<div class="rounded-b-md mb-4 bg-blue-900/5 border-blue-900/30  border border-t-0 border-dashed ">
    <div class="flex justify-between p-4 py-8">
        <div class="relative">
            <div class="flex">
                <x-label for="empcode" value="{{ __('Upload employee photo')}}" />
                <span class="text-red-500 ml-1">*</span>
            </div>
            <div class="py-2 rounded-md my-2" >
                <label class="mr-6 text-sm">
                    <input type="radio" wire:model="selectedOption" value="computer" > Upload from Computer
                </label>
                <label class="text-sm">
                    <input type="radio" wire:model="selectedOption" value="camera"> Capture from Camera
                </label>
            </div>
            <script>
                function loadTemporaryPic()
                {   
                    const fileInput = document.getElementById('fileInput');
                    const canvas = document.getElementById('imageCanvas');
                    const context = canvas.getContext('2d');
                    // Add an event listener to the file input for when a file is selected
                    const file = fileInput.files[0];
                    if (file) {
                        // Create a FileReader to read the selected file as a data URL
                        const reader = new FileReader();
                        reader.onload = function (e) {
                            // When the file is loaded, set the canvas's image source to the data URL
                            const img = new Image();
                            img.src = e.target.result;
                            // Ensure the image is loaded before drawing it on the canvas
                            img.onload = function () {
                                // Clear the canvas
                                context.clearRect(0, 0, canvas.width, canvas.height);
                                // Draw the image on the canvas
                                context.drawImage(img, 0, 0, canvas.width, canvas.height);
                            };
                        };
                        // Read the selected file as a data URL
                        reader.readAsDataURL(file);
                    }
                }
            </script>
            <div class="mt-4 bg-white py-6   p-6 rounded-md">
                @if ($selectedOption === 'computer')
                    <x-input id="fileInput" onChange="loadTemporaryPic()" wire:model="employeepic" type="file" class="!h-9 !text-gray-800 !bg-blue-00" />
                    <canvas id="imageCanvas" class="w-32 h-32 rounded-md mt-2"></canvas>
                @elseif ($selectedOption === 'camera')
                    @livewire('transactions.camera-component')
                @endif
            </div>
            @if($employeepic!='')
                @error('employeepic') <span class="error">{{ $message }}</span> @enderror
            @endif
            <div><span class="text-xs text-gray-600"> Image must be in  .jpg format with size less than 512kb</span></div>

        </div>
       
    </div>
    <x-validation-errors class="mb-4" />


<div class="flex justify-center items-center p-4 rounded-md ">

@if($this->employeepic)
    <x-primary-button wire:click="addobject()">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
        </svg>




        Add Employee Details</x-primary-button>
    @endif

</div>


</div>
