<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Mail;
use App\Mail\notifyviaemail;
use App\Models\PortalConfiguration;

class Emailcomponent extends Component
{
    public function render()
    {
        return view('livewire.emailcomponent');
    }

    public function getEmailConnection()
    {
    
        $username = PortalConfiguration::where('name','email_username')->first();
        $password = PortalConfiguration::where('name','email_password')->first();      
        $port = PortalConfiguration::where('name','email_port')->first();
        $encryption = PortalConfiguration::where('name','email_encryption')->first();    
        $transport = PortalConfiguration::where('name','email_transport')->first();    
        $host = PortalConfiguration::where('name','email_host')->first();    
        if ($username && $password) {
    
            $dynamicConnectionConfig = [
                'transport' => $transport->value,
                'host' => $host->value,
                'port' => intval($port->value),
                'username' => $username->value,
                'password' =>$password->value,//'tpobmoiamysenrlu',
                'encryption' => $encryption->value,
                'from' => [
                    'address' => 'nextgen-dise@nic.in',
                    'name' => 'Next Gen Dise',
                ],
                // ... other configuration options
            ];
            // $dynamicConnectionConfig = [
            //     'transport' => 'smtp',
            //     'host' => 'relay.nic.in',
            //     'port' => 25,
            //     'username' => 'nextgen-dise@nic.in',
            //     'password' =>'Nextgendise@2023',//'tpobmoiamysenrlu',
            //     'encryption' => 'TLS',
            //     'from' => [
            //         'address' => 'nextgen-dise@nic.in',
            //         'name' => 'Next Gen Dise',
            //     ],
            //     // ... other configuration options
            // ];
    
            
    
    
    
            try {
                // Create a dynamic database connection
                $dynamicConnectionName = $username  . 'email'; // Change this to a unique name
                config(["mailers.connections.$dynamicConnectionName" => $dynamicConnectionConfig]);
                
                if ($dynamicConnectionConfig) {
                    return [$dynamicConnectionConfig];
                } else {
                    return [];
                }
            } catch (\Exception $e) {
    
                return null;
            }
        }
    
        return [];
    }
public function sendemail($to,$reason,$body){
    //function to send email arugments are positional
    /*
    1. Header Image: Link
    2. Subject : Subject of Email Alert
    3. Reason : reason of revert back or login details
    4. Body: Body is pre formated (line breaks allowed)
    5. Footer text
    */
    $subject ='Testing Subject';
    $ceo = 'Test CEO';
    $headerimage= 'demo.png';
    
    
    $dynamicConnectionName =  'emailsmtp'; // Change this to a unique name
    config(["mailers.connections.$dynamicConnectionName" => $this->getEmailConnection()[0]]);
    config(['mail.mailers.smtp' =>$this->getEmailConnection()[0]]);
    
    Mail::to($to)->send(new notifyviaemail(
        $headerimage,
        $subject,
        $reason,
        $body,
        $ceo,
    ));
}

    public function dotask(){
       
        try{
            $reason= "New office User Added to Next Gen Dise";
            $orgpwd="12345678";
            $body="
            The account has been configured with the necessary access permissions and privileges accordingly . Additionally, the login credentials has been informed of our security and password policies.

            UserName: Test User
            Password: ".$orgpwd."          
                     
            Kindly Change your password after first login.";
           
            //sending email
        $this->sendemail("punman@nic.in",$reason,$body);  
        
        $this->dispatchBrowserEvent('banner-message', [
            'style' => 'success',
            'message' => 'Email Sent successfully to Office'
        ]); 
        $this->emit('close-banner');
       
        }
        catch (\Exception $e) {
            dd($e);
            $this->dispatchBrowserEvent('banner-message', [
                'style' => 'danger',
                'message' => 'Could not Send Email. Check portal Configuation'
            ]);
          
            $this->emit('close-banner');
           
        }
    }
}
