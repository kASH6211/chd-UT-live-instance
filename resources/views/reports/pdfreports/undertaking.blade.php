<html>
<head>
<style>
div.my-alert {
  width: 85%;
  margin: 70px auto;
   }

div.my-alert > div.my-alert__unique1 {
  text-align: center;
  font-weight:bold;
  font-weight: var(--tw-font-weight-bold);
  font-size: var(--tw-font-size-lg);
  line-height: var(--tw-line-height-7);
  margin: 40px auto;
}

div.my-alert > div.my-alert__unique2 {
  text-align: justify;
  line-height: 2.5rem;
}

div.my-alert > div.my-alert__unique3 {
  text-align: justify;
  line-height: 2.5rem;
}

div.my-alert > div.my-alert__unique4 {
  margin-top: 70px;
  display:flex;

}

div.my-alert > div > div.my-alert__unique5 {

  width:50%;
   float:left;
}
div.my-alert > div > div.my-alert__unique6{

  width:50%;
  float:left;
}

div.my-alert > div.my-alert__unique7 {
  margin-top: 70px;
}

div.my-alert > div > div.my-alert__unique8 {
  width:50%;

  margin: 70px auto;
}
.badge{
  padding-top: 0.125rem;
padding-bottom: 0.125rem; 
padding-left: 0.625rem;
padding-right: 0.625rem; 
margin-right: 0.5rem; 
border-radius: 0.25rem; 
font-weight: 700; 
color: #1F2937; 
text-decoration: underline; 
background-color: #DBEAFE; 

}
</style>
</head>
<body>
 <div class="my-alert">
        <div class="my-alert__unique1"><b>CERTIFICATE</b></div>
        <div class="my-alert__unique2">
             It is certified that the data is accurate and complete in all respects and no employee other than the class 4 (peon/helpers) has been left out. The total employees in this office except class 4 employees are ,<span class="badge">{{$tot}}</span>, total Regular employees entered in the software are <span class="badge">{{$emptype["regular"]}}</span>, total Contractual employees entered in the software are <span class="badge">{{$emptype["contractual"]}}</span> .
       </div>
        <div class="my-alert__unique3">
            Further it is certified that the data submitted in the online NextGenDISE software and checklist report generated after feeding the data is correct and we are responsible for any wrong data entered.
       </div>
        <div class="my-alert__unique4">
            <div class="my-alert__unique5">
                <div> Signature of Data Entered</div>
                <div>Name:</div>
                <div>Designation:</div>
                <div>Contact No:</div>
            </div>
            <div class="my-alert__unique6">
                <div> Signature of Office Superintendent</div>
                <div>Name:</div>
                <div>Designation:</div>
                <div>Contact No:</div>
            </div>

        </div>
        <div class="my-alert__unique7">
            <div class="my-alert__unique8">
                <div>Signature of Head of Office</div>
                <div>Name:</div>
                <div>Designation:</div>
                <div>Contact No:</div>
                <div>Stamp of Office:</div>
            </div>
        </div>
    </div>
</body>
</html>