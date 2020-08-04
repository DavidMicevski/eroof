<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
use App\User;
use PDF;

class MapController extends Controller
{
       /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/map';

         /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::paginate(5);

        return view('map/index', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('map/create');
    }

    public function google(Request $request)
    {
        $address = $request->input('address');
        return view('map/real', ['address' => $address]);
    }

    /**
     * Show the form for uploading a new image.
     *
     * @return \Illuminate\Http\Response
     */
    public function upload()
    {
        return view('map/upload');
    }

    public function pitch(Request $request)
    {
        $lat = $request['lat'];
        $lng = $request['lng'];
        return view('map/pitch', ['lat' => $lat, 'lng' => $lng]);
    }

    public function uploadImage(Request $request) 
    {
        $image_data = $request['imagedata'];
        $imagename = $request['imagename'];
        list($type, $image_data) = explode(';', $image_data);
        list(, $image_data)      = explode(',', $image_data);
        $image_data = base64_decode($image_data);

        file_put_contents('bower_components/AdminLTE/dist/img/image/'.$imagename, $image_data);

        echo json_encode("success");
    }

    /**
     * Show the form for actioning a new image.
     *
     * @return \Illuminate\Http\Response
     */

    public function real(Request $request)
    {
        $coordinate = $request['coordinate'];
        $lat = explode(",", $coordinate)[0];
        $lng = explode(",", $coordinate)[1];
        $zoom = explode(",", $coordinate)[2];
        $pixel = explode(",", $coordinate)[3];
        $distance = explode(",", $coordinate)[4];
        $distance_num = explode(" ", $distance)[0];
        $unit = explode(" ", $distance)[1];
        $address = $request['address'];
        $type = $request['type'];
        return view('map/real', ['lat' => $lat, 'lng' => $lng, 'zoom' => $zoom - 1, 'pixel' => $pixel, 'distance' => $distance_num, 'unit' => $unit, 'type' => $type, 'address' => $address]);
    }

    public function download(Request $request)
    {
        $type = $request['type'];
        $address = $request['address'];
        $totalArea = $request['total-area'];
        $lsArea = $request['lsArea'];
        $tsArea = $request['tsArea'];
        $tlArea = $request['tlArea'];

        $zero_twel = $request['zero_twel'];
        $one_twel = $request['one_twel'];
        $two_twel = $request['two_twel'];
        $three_twel = $request['three_twel'];
        $four_twel = $request['four_twel'];
        $five_twel = $request['five_twel'];
        $six_twel = $request['six_twel'];
        $seven_twel = $request['seven_twel'];
        $eight_twel = $request['eight_twel'];
        $nine_twel = $request['nine_twel'];
        $ten_twel = $request['ten_twel'];
        $ele_twel = $request['ele_twel'];
        $twel_twel = $request['twel_twel'];
        $thirteen_twel = $request['thirteen_twel'];
        $fourteen_twel = $request['fourteen_twel'];
        $fifteen_twel = $request['fifteen_twel'];
        $sixteen_twel = $request['sixteen_twel'];
        $seventeen_twel = $request['seventeen_twel'];
        $eighteen_twel = $request['eighteen_twel'];
        $nineteen_twel = $request['nineteen_twel'];
        $twenty_twel = $request['twenty_twel'];
        $twentyone_twel = $request['twentyone_twel'];
        $twentytwo_twel = $request['twentytwo_twel'];
        $twentythree_twel = $request['twentythree_twel'];
        $twentyfour_twel = $request['twentyfour_twel'];
        $twentyfive_twel = $request['twentyfive_twel'];
        $twentysix_twel = $request['twentysix_twel'];
        $twentyseven_twel = $request['twentyseven_twel'];
        $twentyeight_twel = $request['twentyeight_twel'];
        $twentynine_twel = $request['twentynine_twel'];
        $thirty_twel = $request['thirty_twel'];
        $thirtyone_twel = $request['thirtyone_twel'];
        $thirtytwo_twel = $request['thirtytwo_twel'];
        $thirtythree_twel = $request['thirtythree_twel'];
        $thirtyfour_twel = $request['thirtyfour_twel'];
        $thirtyfive_twel = $request['thirtyfive_twel'];
        $thirtysix_twel = $request['thirtysix_twel'];
        $thirtyseven_twel = $request['thirtyseven_twel'];
        $thirtyeight_twel = $request['thirtyeight_twel'];
        $thirtynine_twel = $request['thirtynine_twel'];
        $fourty_twel = $request['fourty_twel'];
        $fourtyone_twel = $request['fourtyone_twel'];
        $fourtytwo_twel = $request['fourtytwo_twel'];
        $fourtythree_twel = $request['fourtythree_twel'];
        $fourtyfour_twel = $request['fourtyfour_twel'];
        $fourtyfive_twel = $request['fourtyfive_twel'];
        $fourtysix_twel = $request['fourtysix_twel'];
        $fourtyseven_twel = $request['fourtyseven_twel'];
        $fourtyeigth_twel = $request['fourtyeigth_twel'];
        $fourtynine_twel = $request['fourtynine_twel'];
        $fifty_twel = $request['fifty_twel'];
        $fiftyone_twel = $request['fiftyone_twel'];
        $fiftytwo_twel = $request['fiftytwo_twel'];
        $fiftythree_twel = $request['fiftythree_twel'];
        $fiftyfour_twel = $request['fiftyfour_twel'];
        $fiftyfive_twel = $request['fiftyfive_twel'];
        $fiftysix_twel = $request['fiftysix_twel'];
        $fiftyseven_twel = $request['fiftyseven_twel'];
        $fiftyeight_twel = $request['fiftyeight_twel'];
        $fiftynine_twel = $request['fiftynine_twel'];
        $sixty_twel = $request['sixty_twel'];
        $sixtyone_twel = $request['sixtyone_twel'];
        $sixtytwo_twel = $request['sixtytwo_twel'];
        $sixtythree_twel = $request['sixtythree_twel'];
        $sixtyfour_twel = $request['sixtyfour_twel'];
        $sixtyfive_twel = $request['sixtyfive_twel'];
        $sixtysix_twel = $request['sixtysix_twel'];
        $sixtyseven_twel = $request['sixtyseven_twel'];
        $sixtyeight_twel = $request['sixtyeight_twel'];
        $sixtynine_twel = $request['sixtynine_twel'];
        $seventy_twel = $request['seventy_twel'];
        $seventyone_twel = $request['seventyone_twel'];
        $seventytwo_twel = $request['seventytwo_twel'];
        $seventythree_twel = $request['seventythree_twel'];
        $seventyfour_twel = $request['seventyfour_twel'];
        $seventyfive_twel = $request['seventyfive_twel'];
        $seventysix_twel = $request['seventysix_twel'];
        $seventyseven_twel = $request['seventyseven_twel'];
        $seventyeight_twel = $request['seventyeight_twel'];
        $seventynine_twel = $request['seventynine_twel'];
        $eighty_twel = $request['eighty_twel'];
        $eightyone_twel = $request['eightyone_twel'];
        $eightytwo_twel = $request['eightytwo_twel'];
        $eightythree_twel = $request['eightythree_twel'];
        $eightyfour_twel = $request['eightyfour_twel'];
        $eightyfive_twel = $request['eightyfive_twel'];
        $eightysix_twel = $request['eightysix_twel'];
        $eightyseven_twel = $request['eightyseven_twel'];
        $eightyeight_twel = $request['eightyeight_twel'];
        $eightynine_twel = $request['eightynine_twel'];
        $ninety_twel = $request['ninety_twel'];
        $ninetyone_twel = $request['ninetyone_twel'];
        $ninetytwo_twel = $request['ninetytwo_twel'];
        $ninetythree_twel = $request['ninetythree_twel'];
        $ninetyfour_twel = $request['ninetyfour_twel'];
        $ninetyfive_twel = $request['ninetyfive_twel'];
        $ninetysix_twel = $request['ninetysix_twel'];
        $ninetyseven_twel = $request['ninetyseven_twel'];
        $ninetyeight_twel = $request['ninetyeight_twel'];
        $ninetynine_twel = $request['ninetynine_twel'];
        $hundred_twel = $request['hundred_twel'];

        $eaves = $request['eaves'];
        $valleys = $request['valleys'];
        $hips = $request['hips'];
        $ridges = $request['ridges'];
        $rakes = $request['rakes'];
        $wall_flashing = $request['wall_flashing'];
        $step_flahsing = $request['step_flahsing'];
        $unspecified = $request['unspecified'];

        $polygonAreas = $request['polygonAreas'];
        $polygonAreas = explode(',', $polygonAreas[0]);

        $day = date('d');
        $month = date("F",strtotime(date('d-m-Y')));
        $year = date('Y');
        $date = array($day, $month, $year);
        $top_image = $request['top_image'];

        if ($type == 'csv') {
            $filename = $address.'.csv';
            $handle = fopen($filename, 'w+');
            $columns = array('Address', 'Total Area', 'Low Slope', 'Two Story', 'Two Layer', 'Eaves', 'Valleyes', 'Hips', 'Ridges', 'Rakes', 'Wall Flashing', 'Step Flashing', 'Unspecified', '0/12', '12-Jan', '12-Feb', 
                    '12-Mar', '12-Apr', '12-May', '12-Jun', '12-Jul', '12-Aug', '12-Sep', '12-Oct', '12-Nov', '12-Dec');

            for ($i = 13; $i <= 100; $i ++) {
                array_push($columns, $i . "/12");
            }
            fputcsv($handle, $columns);

            fputcsv($handle, array($address, $totalArea, $lsArea, $tsArea, $tlArea, $eaves, $valleys, $hips, $ridges, $rakes, $wall_flashing, $step_flahsing, $unspecified, $zero_twel, $one_twel, $two_twel, $three_twel, $four_twel, $five_twel, $six_twel, $seven_twel, $eight_twel, $nine_twel, $ten_twel, $ele_twel, $twel_twel, $thirteen_twel, $fourteen_twel, $fifteen_twel, $sixteen_twel, $seventeen_twel, $eighteen_twel, $nineteen_twel, $twenty_twel, $twentyone_twel, $twentytwo_twel, $twentythree_twel, $twentyfour_twel, $twentyfive_twel, $twentysix_twel, $twentyseven_twel, $twentyeight_twel, $twentynine_twel, $thirty_twel, $thirtyone_twel, $thirtytwo_twel, $thirtythree_twel, $thirtyfour_twel, $thirtyfive_twel, $thirtysix_twel, $thirtyseven_twel, $thirtyeight_twel, $thirtynine_twel, $fourty_twel, $fourtyone_twel, $fourtytwo_twel, $fourtythree_twel, $fourtyfour_twel, $fourtyfive_twel, $fourtysix_twel, $fourtyseven_twel, $fourtyeigth_twel, $fourtynine_twel, $fifty_twel, $fiftyone_twel, $fiftytwo_twel, $fiftythree_twel, $fiftyfour_twel, $fiftyfive_twel, $fiftysix_twel, $fiftyseven_twel, $fiftyeight_twel, $fiftynine_twel, $sixty_twel, $sixtyone_twel, $sixtytwo_twel, $sixtythree_twel, $sixtyfour_twel, $sixtyfive_twel, $sixtysix_twel, $sixtyseven_twel, $sixtyeight_twel, $sixtynine_twel, $seventy_twel, $seventyone_twel, $seventytwo_twel, $seventythree_twel, $seventyfour_twel, $seventyfive_twel, $seventysix_twel, $seventyseven_twel, $seventyeight_twel, $seventynine_twel, $eighty_twel, $eightyone_twel, $eightytwo_twel, $eightythree_twel, $eightyfour_twel, $eightyfive_twel, $eightysix_twel, $eightyseven_twel, $eightyeight_twel, $eightynine_twel, $ninety_twel, $ninetyone_twel, $ninetytwo_twel, $ninetythree_twel, $ninetyfour_twel, $ninetyfive_twel, $ninetysix_twel, $ninetyseven_twel, $ninetyeight_twel, $ninetynine_twel, $hundred_twel));

            fclose($handle);

            $headers = array(
                'Content-Type' => 'text/csv',
            );

            return Response::download($filename, $filename, $headers);
        } else if ($type == 'pdf') {
            $rootPath = base_path();
            $data = ['address' => $address, 'totalArea' => $totalArea, 'rootPath' => $rootPath, 'date' => $date[0].'-'.$date[1].'-'.$date[2], 'top_image' => $top_image, 'eaves' => $eaves, 'ridges' => $ridges, 'rakes' => $rakes, 'hips' => $hips, 'valleys' => $valleys, 'wall_flashing' => $wall_flashing, 'step_flahsing' => $step_flahsing, 'unspecified' => $unspecified, 'polygonAreas' => $polygonAreas];
            $pdf = PDF::loadView('map/pdfview', array('data' => $data));
            $pdf->setPaper([0,0,4000,660], 'landscape');
            return $pdf->download($address.'.pdf');
            // return view('map/pdfview', array('data' => $data));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validateInput($request);
         User::create([
            'username' => $request['username'],
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
            'firstname' => $request['firstname'],
            'lastname' => $request['lastname']
        ]);

        return redirect()->intended('/map');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        // Redirect to user list if updating user wasn't existed
        if ($user == null || count($user) == 0) {
            return redirect()->intended('/map');
        }

        return view('map/edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $constraints = [
            'username' => 'required|max:20',
            'firstname'=> 'required|max:60',
            'lastname' => 'required|max:60'
            ];
        $input = [
            'username' => $request['username'],
            'firstname' => $request['firstname'],
            'lastname' => $request['lastname']
        ];
        if ($request['password'] != null && strlen($request['password']) > 0) {
            $constraints['password'] = 'required|min:6|confirmed';
            $input['password'] =  bcrypt($request['password']);
        }
        $this->validate($request, $constraints);
        User::where('id', $id)
            ->update($input);
        
        return redirect()->intended('/map');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::where('id', $id)->delete();
         return redirect()->intended('/map');
    }

    /**
     * Search user from database base on some specific constraints
     *
     * @param  \Illuminate\Http\Request  $request
     *  @return \Illuminate\Http\Response
     */
    public function search(Request $request) {
        $constraints = [
            'username' => $request['username'],
            'firstname' => $request['firstname'],
            'lastname' => $request['lastname'],
            'department' => $request['department']
            ];

       $users = $this->doSearchingQuery($constraints);
       return view('map/index', ['users' => $users, 'searchingVals' => $constraints]);
    }

    private function doSearchingQuery($constraints) {
        $query = User::query();
        $fields = array_keys($constraints);
        $index = 0;
        foreach ($constraints as $constraint) {
            if ($constraint != null) {
                $query = $query->where( $fields[$index], 'like', '%'.$constraint.'%');
            }

            $index++;
        }
        return $query->paginate(5);
    }
    
    private function validateInput($request) {
        $this->validate($request, [
        'username' => 'required|max:20',
        'email' => 'required|email|max:255|unique:users',
        'password' => 'required|min:6|confirmed',
        'firstname' => 'required|max:60',
        'lastname' => 'required|max:60'
    ]);
    }
}
