<?php

namespace Database\Seeders;
use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OfficeMasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('office_masters')->delete();
        $office_masters = array(
array('distcode'=>3,'deptcode'=>"0002",'officecode'=>"0021",'office'=>"CHIEF AGRICULTURE OFFICER TTN",'address'=>"PHARWAHI BAZAR TTN 01679231166",'sno'=>"0",'subdeptcode'=>"0001",'officecodekey'=>"0300020021",'subdeptcodekey'=>"0300020001",'distcode_from'=>0),
array('distcode'=>3,'deptcode'=>"0002",'officecode'=>"0018",'office'=>"BLOCK AGRICULTURE OFFICER",'address'=>"CHINTU PARK ROAD INSIDE VET HOSPITAL TTN 9872449779",'sno'=>"0",'subdeptcode'=>"0001",'officecodekey'=>"0300020018",'subdeptcodekey'=>"0300020001",'distcode_from'=>0)
,array('distcode'=>3,'deptcode'=>"0002",'officecode'=>"0019",'office'=>"BLOCK AGRICULTURE OFFICER SEHNA",'address'=>"TTN BAJAKHANA ROAD NEAR POLICE STATION SEHNA 9814822665",'sno'=>"0",'subdeptcode'=>"0001",'officecodekey'=>"0300020019",'subdeptcodekey'=>"0300020001",'distcode_from'=>0)
,array('distcode'=>3,'deptcode'=>"0002",'officecode'=>"0020",'office'=>"BLOCK AGRICULTURE OFFICER MEHAL KALAN",'address'=>"NEAR TELEPHONE EXCHANGE MEHAL KALAN 9464964733",'sno'=>"0",'subdeptcode'=>"0001",'officecodekey'=>"0300020020",'subdeptcodekey'=>"0300020001",'distcode_from'=>0)
,array('distcode'=>3,'deptcode'=>"0003",'officecode'=>"0001",'office'=>"CIVIL VETERINARY HOSPITAL",'address'=>"TTN",'sno'=>"0",'subdeptcode'=>"0001",'officecodekey'=>"0300030001",'subdeptcodekey'=>"0300030001",'distcode_from'=>0),
array('distcode'=>3,'deptcode'=>"0004",'officecode'=>"0002",'office'=>"AYURVEDIC",'address'=>"TTN",'sno'=>"0",'subdeptcode'=>"0001",'officecodekey'=>"0300040002",'subdeptcodekey'=>"0300040001",'distcode_from'=>0),
array('distcode'=>3,'deptcode'=>"0009",'officecode'=>"0003",'office'=>"CORPORATION BANK TTN",'address'=>"TTN",'sno'=>"0",'subdeptcode'=>"0001",'officecodekey'=>"0300090003",'subdeptcodekey'=>"0300090001",'distcode_from'=>0),
array('distcode'=>3,'deptcode'=>"0010",'officecode'=>"0004",'office'=>"DEPUTY REGISTRAR COOPERATIVE SOCIETIES",'address'=>"PHARWAHI BAZAR NEAR THULIWAL DHARMSALA 01679232380",'sno'=>"0",'subdeptcode'=>"0001",'officecodekey'=>"0300100004",'subdeptcodekey'=>"0300100001",'distcode_from'=>0),
array('distcode'=>3,'deptcode'=>"0010",'officecode'=>"0005",'office'=>"ASSISTANT REGISTRAR COOPERATIVE SOCIETIES",'address'=>"PHARWAHI BAZAR NEAR THULIWAL DHARMSALA 01679232380",'sno'=>"0",'subdeptcode'=>"0001",'officecodekey'=>"0300100005",'subdeptcodekey'=>"0300020001",'distcode_from'=>0)
,array('distcode'=>3,'deptcode'=>"0010",'officecode'=>"0006",'office'=>"ASSISTANT REGISTRAR COOPERATIVE SOCIETIES TAPA",'address'=>"SHOP NO 61 OLD GRAIN MARKET TAPA",'sno'=>"0",'subdeptcode'=>"0001",'officecodekey'=>"0300100006",'subdeptcodekey'=>"0300020001",'distcode_from'=>0)
,array('distcode'=>3,'deptcode'=>"0015",'officecode'=>"0007",'office'=>"DAIRY DEVELOPMENT OFFICE",'address'=>"TTN",'sno'=>"0",'subdeptcode'=>"0001",'officecodekey'=>"0300150007",'subdeptcodekey'=>"0300150001",'distcode_from'=>0),
array('distcode'=>3,'deptcode'=>"0017",'officecode'=>"0008",'office'=>"S D COLLEGE TTN",'address'=>"TTN",'sno'=>"0",'subdeptcode'=>"0001",'officecodekey'=>"0300170008",'subdeptcodekey'=>"0300170001",'distcode_from'=>0),
array('distcode'=>3,'deptcode'=>"0017",'officecode'=>"0009",'office'=>"LBS COLLEGE TTN",'address'=>"TTN",'sno'=>"0",'subdeptcode'=>"0001",'officecodekey'=>"0300170009",'subdeptcodekey'=>"0300170001",'distcode_from'=>0),
array('distcode'=>3,'deptcode'=>"0017",'officecode'=>"0010",'office'=>"SD COLLEGE OF EDUCATION",'address'=>"TTN",'sno'=>"0",'subdeptcode'=>"0001",'officecodekey'=>"0300170010",'subdeptcodekey'=>"0300170001",'distcode_from'=>0),
array('distcode'=>3,'deptcode'=>"0017",'officecode'=>"0011",'office'=>"SD COLLEGE OF B PHARMACY",'address'=>"TTN",'sno'=>"0",'subdeptcode'=>"0001",'officecodekey'=>"0300170011",'subdeptcodekey'=>"0300170001",'distcode_from'=>0),
array('distcode'=>3,'deptcode'=>"0017",'officecode'=>"0012",'office'=>"GURU GOBIND SINGH COLLEGE SANGHERA",'address'=>"SANGHERA",'sno'=>"0",'subdeptcode'=>"0001",'officecodekey'=>"0300170012",'subdeptcodekey'=>"0300170001",'distcode_from'=>0),
array('distcode'=>3,'deptcode'=>"0017",'officecode'=>"0013",'office'=>"UNIVERSITY COLLEGE DHILWAN TTN",'address'=>"TTN",'sno'=>"0",'subdeptcode'=>"0001",'officecodekey'=>"0300170013",'subdeptcodekey'=>"0300170001",'distcode_from'=>0),
array('distcode'=>3,'deptcode'=>"0017",'officecode'=>"0014",'office'=>"UNIVERSITY COLLEGE SANGHERA ROAD TTN",'address'=>"SANGHERA ROAD TTN",'sno'=>"0",'subdeptcode'=>"0001",'officecodekey'=>"0300170014",'subdeptcodekey'=>"0300170001",'distcode_from'=>0),
array('distcode'=>3,'deptcode'=>"0017",'officecode'=>"0015",'office'=>"GOVT POLYTECHNIC COLLEGE BADBAR",'address'=>"BADBAR TTN 01679268011",'sno'=>"0",'subdeptcode'=>"0001",'officecodekey'=>"0300170015",'subdeptcodekey'=>"0300170001",'distcode_from'=>0),
array('distcode'=>3,'deptcode'=>"0018",'officecode'=>"0016",'office'=>"GHS BADRA",'address'=>"VPO BADRA",'sno'=>"0",'subdeptcode'=>"0001",'officecodekey'=>"0300180016",'subdeptcodekey'=>"0300180016",'distcode_from'=>0),
// array('distcode'=>3,'deptcode'=>"0002",'officecode'=>"0001",'office'=>"AGRICULTURE OFFICE TTN",'address'=>"TTN",'sno'=>"90",'subdeptcode'=>"0001",'officecodekey'=>"0300020001",'subdeptcodekey'=>"0300020001",'distcode_from'=>0),

array('distcode'=>19,'deptcode'=>"0003",'officecode'=>"0002",'office'=>"VETERINARY dispensary",'address'=>"Tapa",'sno'=>"0",'subdeptcode'=>"0001",'officecodekey'=>"0300030001",'subdeptcodekey'=>"0300030001",'distcode_from'=>0),
array('distcode'=>19,'deptcode'=>"0002",'officecode'=>"0021",'office'=>"CHIEF AGRICULTURE OFFICER BARNALA",'address'=>"PHARWAHI BAZAR BARNALA 01679231166",'sno'=>"0",'subdeptcode'=>"0001",'officecodekey'=>"1900020001",'subdeptcodekey'=>"1900020001",'distcode_from'=>0),
array('distcode'=>19,'deptcode'=>"0002",'officecode'=>"0018",'office'=>"BLOCK AGRICULTURE OFFICER",'address'=>"CHINTU PARK ROAD INSIDE VET HOSPITAL BARNALA 9872449779",'sno'=>"0",'subdeptcode'=>"0001",'officecodekey'=>"1900020018",'subdeptcodekey'=>"1900020001",'distcode_from'=>0)
,array('distcode'=>19,'deptcode'=>"0002",'officecode'=>"0019",'office'=>"BLOCK AGRICULTURE OFFICER SEHNA",'address'=>"BARNALA BAJAKHANA ROAD NEAR POLICE STATION SEHNA 9814822665",'sno'=>"0",'subdeptcode'=>"0001",'officecodekey'=>"1900020019",'subdeptcodekey'=>"1900020001",'distcode_from'=>0)
,array('distcode'=>19,'deptcode'=>"0002",'officecode'=>"0020",'office'=>"BLOCK AGRICULTURE OFFICER MEHAL KALAN",'address'=>"NEAR TELEPHONE EXCHANGE MEHAL KALAN 9464964733",'sno'=>"0",'subdeptcode'=>"0001",'officecodekey'=>"1900020020",'subdeptcodekey'=>"1900020001",'distcode_from'=>0)
,array('distcode'=>19,'deptcode'=>"0003",'officecode'=>"0001",'office'=>"CIVIL VETERINARY HOSPITAL",'address'=>"BARNALA",'sno'=>"0",'subdeptcode'=>"0001",'officecodekey'=>"1900030001",'subdeptcodekey'=>"1900030001",'distcode_from'=>0),
array('distcode'=>19,'deptcode'=>"0004",'officecode'=>"0002",'office'=>"AYURVEDIC",'address'=>"BARNALA",'sno'=>"0",'subdeptcode'=>"0001",'officecodekey'=>"1900040001",'subdeptcodekey'=>"1900040001",'distcode_from'=>0),
array('distcode'=>19,'deptcode'=>"0009",'officecode'=>"0003",'office'=>"CORPORATION BANK BARNALA",'address'=>"BARNALA",'sno'=>"0",'subdeptcode'=>"0001",'officecodekey'=>"1900090001",'subdeptcodekey'=>"1900090001",'distcode_from'=>0),
array('distcode'=>19,'deptcode'=>"0010",'officecode'=>"0004",'office'=>"DEPUTY REGISTRAR COOPERATIVE SOCIETIES",'address'=>"PHARWAHI BAZAR NEAR THULIWAL DHARMSALA 01679232380",'sno'=>"0",'subdeptcode'=>"0001",'officecodekey'=>"1900100001",'subdeptcodekey'=>"1900100001",'distcode_from'=>0),
array('distcode'=>19,'deptcode'=>"0010",'officecode'=>"0005",'office'=>"ASSISTANT REGISTRAR COOPERATIVE SOCIETIES",'address'=>"PHARWAHI BAZAR NEAR THULIWAL DHARMSALA 01679232380",'sno'=>"0",'subdeptcode'=>"0001",'officecodekey'=>"1900100005",'subdeptcodekey'=>"1900020001",'distcode_from'=>0)
,array('distcode'=>19,'deptcode'=>"0010",'officecode'=>"0006",'office'=>"ASSISTANT REGISTRAR COOPERATIVE SOCIETIES TAPA",'address'=>"SHOP NO 61 OLD GRAIN MARKET TAPA",'sno'=>"0",'subdeptcode'=>"0001",'officecodekey'=>"1900100006",'subdeptcodekey'=>"1900020001",'distcode_from'=>0)
,array('distcode'=>19,'deptcode'=>"0015",'officecode'=>"0007",'office'=>"DAIRY DEVELOPMENT OFFICE",'address'=>"BARNALA",'sno'=>"0",'subdeptcode'=>"0001",'officecodekey'=>"1900150001",'subdeptcodekey'=>"1900150001",'distcode_from'=>0),
array('distcode'=>19,'deptcode'=>"0017",'officecode'=>"0008",'office'=>"S D COLLEGE BARNALA",'address'=>"BARNALA",'sno'=>"0",'subdeptcode'=>"0001",'officecodekey'=>"1900170001",'subdeptcodekey'=>"1900170001",'distcode_from'=>0),
array('distcode'=>19,'deptcode'=>"0017",'officecode'=>"0009",'office'=>"LBS COLLEGE BARNALA",'address'=>"BARNALA",'sno'=>"0",'subdeptcode'=>"0001",'officecodekey'=>"1900170002",'subdeptcodekey'=>"1900170001",'distcode_from'=>0),
array('distcode'=>19,'deptcode'=>"0017",'officecode'=>"0010",'office'=>"SD COLLEGE OF EDUCATION",'address'=>"BARNALA",'sno'=>"0",'subdeptcode'=>"0001",'officecodekey'=>"1900170004",'subdeptcodekey'=>"1900170001",'distcode_from'=>0),
array('distcode'=>19,'deptcode'=>"0017",'officecode'=>"0011",'office'=>"SD COLLEGE OF B PHARMACY",'address'=>"BARNALA",'sno'=>"0",'subdeptcode'=>"0001",'officecodekey'=>"1900170005",'subdeptcodekey'=>"1900170001",'distcode_from'=>0),
array('distcode'=>19,'deptcode'=>"0017",'officecode'=>"0012",'office'=>"GURU GOBIND SINGH COLLEGE SANGHERA",'address'=>"SANGHERA",'sno'=>"0",'subdeptcode'=>"0001",'officecodekey'=>"1900170007",'subdeptcodekey'=>"1900170001",'distcode_from'=>0),
array('distcode'=>19,'deptcode'=>"0017",'officecode'=>"0013",'office'=>"UNIVERSITY COLLEGE DHILWAN BARNALA",'address'=>"BARNALA",'sno'=>"0",'subdeptcode'=>"0001",'officecodekey'=>"1900170009",'subdeptcodekey'=>"1900170001",'distcode_from'=>0),
array('distcode'=>19,'deptcode'=>"0017",'officecode'=>"0014",'office'=>"UNIVERSITY COLLEGE SANGHERA ROAD BARNALA",'address'=>"SANGHERA ROAD BARNALA",'sno'=>"0",'subdeptcode'=>"0001",'officecodekey'=>"1900170010",'subdeptcodekey'=>"1900170001",'distcode_from'=>0),
array('distcode'=>19,'deptcode'=>"0017",'officecode'=>"0015",'office'=>"GOVT POLYTECHNIC COLLEGE BADBAR",'address'=>"BADBAR BARNALA 01679268011",'sno'=>"0",'subdeptcode'=>"0001",'officecodekey'=>"1900170011",'subdeptcodekey'=>"1900170001",'distcode_from'=>0),
array('distcode'=>19,'deptcode'=>"0018",'officecode'=>"0016",'office'=>"GHS BADRA",'address'=>"VPO BADRA",'sno'=>"0",'subdeptcode'=>"0001",'officecodekey'=>"1900180001",'subdeptcodekey'=>"1900180001",'distcode_from'=>0),
array('distcode'=>3,'deptcode'=>"0002",'officecode'=>"0001",'office'=>"AGRICULTURE OFFICE TARN TARAN",'address'=>"TARN TARAN",'sno'=>"90",'subdeptcode'=>"0001",'officecodekey'=>"0300020001",'subdeptcodekey'=>"0300020001",'distcode_from'=>0),



);
        DB::table('office_masters')->insert($office_masters); 
    }
}
