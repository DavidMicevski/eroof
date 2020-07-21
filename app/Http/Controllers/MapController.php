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

    public function user_upload(Request $request)
    {
        $coordinate = $request['coordinate'];
        $lat = explode(",", $coordinate)[0];
        $lng = explode(",", $coordinate)[1];

        $address = $request['address'];

        return view('map/user_upload', ['lat' => $lat, 'lng' => $lng, 'address' => $address]);
    }

    /**
     * Show the form for actioning a new image.
     *
     * @return \Illuminate\Http\Response
     */
    public function action()
    {
        return view('map/action');
    }

    public function measure_google(Request $request)
    {
        $coordinate = $request['coordinate1'];
        $lat = explode(",", $coordinate)[0];
        $lng = explode(",", $coordinate)[1];
        $zoom = explode(",", $coordinate)[2];
        return view('map/measure_google', ['lat' => $lat, 'lng' => $lng, 'zoom' => $zoom]);
    }

    public function measure_near(Request $request)
    {
        $coordinate = $request['coordinate2'];
        $lat = explode(",", $coordinate)[0];
        $lng = explode(",", $coordinate)[1];
        $zoom = explode(",", $coordinate)[2];
        return view('map/measure_near', ['lat' => $lat, 'lng' => $lng, 'zoom' => $zoom]);
    }

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
        $image = $request['image'];
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
        
        if ($type == 'csv') {
            $filename = $address.'.csv';
            $handle = fopen($filename, 'w+');
            $columns = array('Address', 'Total Area', 'Low Slope', 'Two Story', 'Two Layer', 'Eaves', 'Valleyes', 'Hips', 'Ridges', 'Rakes', 'Wall Flashing', 'Step Flashing', 'Unspecified', '0/12', '12-Jan', '12-Feb', 
                    '12-Mar', '12-Apr', '12-May', '12-Jun', '12-Jul', '12-Aug', '12-Sep', '12-Oct', '12-Nov', '12-Dec');

            for ($i = 13; $i <= 100; $i ++) {
                array_push($columns, $i . "/12");
            }
            fputcsv($handle, $columns);

            fputcsv($handle, array($address, $totalArea, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, $zero_twel, $one_twel, $two_twel, $three_twel, $four_twel, $five_twel, $six_twel, $seven_twel, $eight_twel, $nine_twel, $ten_twel, 0, 0));

            fclose($handle);

            $headers = array(
                'Content-Type' => 'text/csv',
            );

            return Response::download($filename, $filename, $headers);
        } else if ($type == 'pdf') {
            $data = ['address' => $address, 'totalArea' => $totalArea, 'image' => $image];
            $pdf = PDF::loadView('map/pdfview', array('data' => $data));
            $pdf->setPaper([0,0,5000,660], 'landscape');
            return $pdf->download($address.'.pdf');
        }
        // return view('map/pdfview');
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
