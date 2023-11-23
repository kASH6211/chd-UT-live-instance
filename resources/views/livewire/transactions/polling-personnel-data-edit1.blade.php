<div>
    <div class="flex border bg-blue-900/5 border-dashed border-blue-900/30 p-4 rounded-md justify-between items-center mb-4">

        <h1 class="text-l text-blue-900"><span class="font-semibold">Department -</span> {{ $deptname}}</h1>
        <h1 class="text-l text-blue-900"><span class="font-semibold">Office -</span> {{ $officename }}</h1>


    </div>
    <x-validation-errors class="mb-4" />
    <div class="p-2 bg-blue-900/20 rounded-t-md text-blue-900 ">Personal Details</div>
    <div class="rounded-b-md mb-4 bg-blue-900/5 border-blue-900/30  border border-t-0 border-dashed ">
        <div class="grid grid-cols-3 p-4 py-8 gap-4">
            <div class="w-full">

                <x-label for="empcode" value="{{ __('Name') }}" />
                <x-input wire:model="object.Name" class="block w-full" type="text" :value="old('Name')" required />
            </div>
            <div class="w-full">

                <x-label for="empcode" value="{{ __('Father\\Husband Name') }}" />
                <x-input wire:model="object.FName" class="block w-full" type="text" :value="old('FName')" required />
            </div>

            <div class="w-full">
                <x-label for="name" value="{{ __('Sex') }}" />
                <x-select wire:model="object.sex " type="text" class="block w-full" :ddlist="$sexlist" idfield="code" textfield="description" />

            </div>

            <div class="w-full">

                <x-label for="empcode" value="{{ __('Mobile No.') }}" />
                <x-input wire:model="object.mobileno" class="block w-full" type="text" :value="old('office')" required />
            </div>
            <div class="w-full">

                <x-label for="empcode" value="{{ __('Email Id') }}" />
                <x-input wire:model="object.emailid" class="block w-full" type="text" :value="old('office')" required />
            </div>

            <div class="w-full">

                <x-label for="empcode" value="{{ __('Date of Birth') }}" />
                <x-input wire:model="object.dob" class="block w-full" type="date" :value="old('dob')" required />
            </div>
            <div class="w-full">

                <x-label for="empcode" value="{{ __('Date of Retirement') }}" />
                <x-input wire:model="object.retiredt"  class="block w-full" type="date" :value="old('retiredt')" required />
            </div>
        </div>
    </div>

    <div class="p-2 bg-blue-900/20 rounded-t-md text-blue-900 ">Designation & Salary</div>
    <div class="rounded-b-md mb-4 bg-blue-900/5 border-blue-900/30  border border-t-0 border-dashed ">
        <div class="grid grid-cols-3 p-4 py-8 gap-4">
            <div class="w-full">
                <x-label for="name" value="{{ __('Designation') }}" />
                <x-select wire:model="object.DesigCode" type="text" class="block w-full" :ddlist="$desiglist" idfield="DesigCode" textfield="Designation" />

            </div>

            <div class="w-full">
                <x-label for="name" value="{{ __('Employee Type') }}" />
                <x-select wire:model="object.EmpTypeId" type="text" class="block w-full" :ddlist="$emptypelist" idfield="EmpTypeId" textfield="EmpTypeName" />

            </div>


            <div class="w-full">
                <x-label for="name" value="{{ __('Class') }}" />
                <x-select wire:model="object.category " type="text" class="block w-full" :ddlist="$classlist" idfield="code" textfield="description" />

            </div>
            <div class="w-full">
                <x-label for="name" value="{{ __('Pay Scale') }}" />
                <x-select wire:model="object.PayScaleCode" type="text" class="block w-full" :ddlist="$pslist" idfield="PayScaleCode" textfield="PayScale" />

            </div>
            <div class="w-full">

                <x-label for="empcode" value="{{ __('Basic Pay') }}" />
                <x-input wire:model="object.basicPay" class="block w-full" type="text" :value="old('basicPay')" required />
            </div>
            <div class="w-full">

                <x-label for="empcode" value="{{ __('DDO Code') }}" />
                <x-input wire:model="object.ddocode" class="block w-full" type="text" :value="old('ddocode')" required />
            </div>
            <div class="w-full">

                <x-label for="empcode" value="{{ __('HRMS Code') }}" />
                <x-input wire:model="object.hrmscode" class="block w-full" type="text" :value="old('ddocode')" required />
            </div>
            <div class="w-full">

                <x-label for="empcode" value="{{ __('IFMS Payee Code') }}" />
                <x-input wire:model="object.ifmscode" class="block w-full" type="text" :value="old('ddocode')" required />
            </div>

        </div>
    </div>

    <div class="p-2 bg-blue-900/20 rounded-t-md text-blue-900 ">Office & Home Address</div>
    <div class="rounded-b-md mb-4 bg-blue-900/5 border-blue-900/30  border border-t-0 border-dashed ">
        <div class="grid grid-cols-3 p-4 py-8 gap-4">
            <div class="w-full">
                <x-label for="name" value="{{ __('Native Assembly Segment') }}" />
                <x-select wire:model="object.nativecon" type="text" class="block w-full" :ddlist="$conslist" idfield="AC_NO" textfield="AC_NAME" />

            </div>
            <div class="w-full">
                <x-label for="name" value="{{ __('Residence Assembly Segment') }}" />
                <x-select wire:model="object.HomeCons" type="text" class="block w-full" :ddlist="$conslist" idfield="AC_NO" textfield="AC_NAME" />

            </div>

            <div class="w-full">
                <x-label for="name" value="{{ __('Place of Posting under which Assembly Segment') }}" />
                <x-select wire:model="object.cons" type="text" class="block w-full" :ddlist="$conslist" idfield="AC_NO" textfield="AC_NAME" />

            </div>

            <div class="w-full">

                <x-label for="empcode" value="{{ __('Office Name & Address') }}" />
                <x-input wire:model="object.office" class="block w-full" type="text" :value="old('office')" required />
            </div>

            <div class="w-full">

                <x-label for="empcode" value="{{ __('Home Resd. Addres & Phone No.') }}" />
                <x-input wire:model="object.rAddress" class="block w-full" type="text" :value="old('office')" required />
            </div>


            {{-- <div class="w-full">
                <x-label for="name" value="{{ __('Class') }}" />
                <x-select wire:model="object.class " type="text" class="block w-full" :ddlist="$classlist" idfield="code" textfield="description" />

            </div>
            <div class="w-full">
                <x-label for="name" value="{{ __('Pay Scale') }}" />
                <x-select wire:model="object.PayScaleCode" type="text" class="block w-full" :ddlist="$pslist" idfield="PayScaleCode" textfield="PayScale" />

            </div>
            <div class="w-full">

                <x-label for="empcode" value="{{ __('Basic Pay') }}" />
                <x-input wire:model="object.basicPay" class="block w-full" type="text" :value="old('basicPay')" required />
            </div>--}}

        </div> 
    </div>
    <div class="p-2 bg-blue-900/20 rounded-t-md text-blue-900 ">Election Duty</div>
    <div class="rounded-b-md mb-4 bg-blue-900/5 border-blue-900/30  border border-t-0 border-dashed ">
        <div class="grid grid-cols-3 p-4 py-8 gap-4">
            
            <div class="w-full">
                <x-label for="name" value="{{ __('Already Exercised Election Duty(if Yes Select)') }}" />
                <x-select wire:model="object.excercisedElectionDuty" type="text" class="block w-full" :ddlist="$classlist2" idfield="description" textfield="description" />

            </div>

            <div class="w-full">
                <x-label for="name" value="{{ __('Select As') }}" />
                <x-select wire:model="object.class" type="text" class="block w-full" :ddlist="$classlist2" idfield="class" textfield="description" />

            </div>

            @if ($object->class==11)
        <div class="w-full">
            <div class="flex">
                <x-label for="empcode" value="{{ __('BLO in which asembly segment')}}" />
                <span class="text-red-500 ml-1">*</span>
            </div>

            <x-select wire:model.lazy="bloconscode" wire:change="getBoothList" type="text" class="block w-full" :ddlist="$consdistlist" idfield="ac_no" textfield="ac_name" />

        </div>

        <div class="w-full">
            <div class="flex">
                <x-label for="empcode" value="{{ __('BLO on which Booth')}}" />
                <span class="text-red-500 ml-1">*</span>
            </div>
            <x-select wire:model.lazy="bloboothno" type="text" class="block w-full" :ddlist="$boothlist" idfield="BOOTHNO" textfield="VILLAGE" />

            
        </div>

            
        @endif

            <div class="w-full">
                <x-label for="name" value="{{ __('Handicap') }}" />
                <x-checkbox wire:model="object.handicap"    />

            </div>
            <div class="w-full">
                <x-label for="name" value="{{ __('On Long Leave') }}" />
                <x-checkbox wire:model="object.longLeave"    />

            </div>

            <div class="w-full">
                <x-label for="name" value="{{ __('Remarks') }}" />
                <x-input wire:model="object.Remarks" class="block w-full" type="text" :value="old('Remarks')" required />
            
            </div>
            
        </div>
    </div>

    <div class="p-2 bg-blue-900/20 rounded-t-md text-blue-900 ">Bank Details</div>
    <div class="rounded-b-md mb-4 bg-blue-900/5 border-blue-900/30  border border-t-0 border-dashed ">
        <div class="grid grid-cols-3 p-4 py-8 gap-4">
            
            <div class="w-full">
                <x-label for="name" value="{{ __('Bank Name') }}" />
                <x-select wire:model="object.BankId" type="text" class="block w-full" :ddlist="$banklist" idfield="BankId" textfield="BankName" />

            </div>

            <div class="w-full">
                <x-label for="name" value="{{ __('Bank A/c No.') }}" />
                <x-input wire:model="object.BankAcNo" class="block w-full" type="text" :value="old('BankAcNo')" required />
            
            </div>
            <div class="w-full">
                <x-label for="name" value="{{ __('IFSC Code') }}" />
                <x-input wire:model="object.IfscCode" class="block w-full" type="text" :value="old('IfscCode')" required />
            
            </div>
            <div>
                <x-primary-button wire:click="addobject()">
                    
    
    
                    Update</x-primary-button>
                   
            </div>
            
            
        </div>
    </div>


</div>
