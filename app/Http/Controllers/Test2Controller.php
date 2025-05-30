<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\subject;
use App\Models\student;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Smalot\PdfParser\Parser;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
// use App\Notifications\MyCustomNotification;
use App\Models\UserStudent;

class Test2Controller extends Controller
{
    
    public function testlist()
    {
        Session::put('CourseIDS', request()->id);

        if(Session::get('SessionIDS') == null)
        {
        Session::put('SessionIDS', request()->session);
        }

        $user = Auth::user();
        $group = array();

        $chapter = array();

        //dd(Session::get('CourseIDS'));

        $data = DB::table('tblclasstest2')->join('tblclasstest2status', 'tblclasstest2.status', 'tblclasstest2status.id')
                ->where([
                    ['tblclasstest2.classid', Session::get('CourseIDS')],
                    ['tblclasstest2.sessionid', Session::get('SessionIDS')],
                    ['tblclasstest2.addby', $user->ic],
                    ['tblclasstest2.status', '!=', 3],
                    ['tblclasstest2.date_from','!=', null]
                ])->select('tblclasstest2.*', 'tblclasstest2status.statusname')->get();

        //dd($data);

      
            foreach($data as $dt)
            {
                $group[] = DB::table('tblclasstest2_group')
                        ->join('user_subjek', 'tblclasstest2_group.groupid', 'user_subjek.id')
                        ->where('tblclasstest2_group.testid', $dt->id)->get();

                $chapter[] = DB::table('tblclasstest2_chapter')
                        ->join('material_dir', 'tblclasstest2_chapter.chapterid', 'material_dir.DrID')
                        ->where('tblclasstest2_chapter.testid', $dt->id)->get();
            }
      

        return view('lecturer.courseassessment.test3', compact('data', 'group', 'chapter'));
    }

    public function getExtendTest(Request $request)
    {

        $data['test'] = DB::table('tblclasstest2')->where('id', $request->id)->first();

        return view('lecturer.courseassessment.test3GetExtend', compact('data'));

    }

    public function updateExtendTest(Request $request)
    {

        DB::table('tblclasstest2')->where('id', $request->id)->update([
            'date_from' => $request->from,
            'date_to' => $request->to,
            'duration' => $request->duration
        ]);

        return back()->with('message', 'Success!');

    }

    public function deletetest(Request $request)
    {

        try {

            $test = DB::table('tblclasstest2')->where('id', $request->id)->first();

            if($test->status != 3)
            {
            DB::table('tblclasstest2')->where('id', $request->id)->update([
                'status' => 3
            ]);

            return true;

            }else{

                die;

            }
          
          } catch (\Exception $e) {
          
              return $e->getMessage();
          }
    }

    public function testcreate()
    {
        $user = Auth::user();

        $data['testid'] = null;

        $data['reuse'] = null;

        $courseid = Session::get('CourseID');

        $sessionid = Session::get('SessionID');

        $group = subject::join('student_subjek', 'user_subjek.id', 'student_subjek.group_id')
        ->join('subjek', 'user_subjek.course_id', 'subjek.sub_id')
        ->where([
            ['subjek.id', $courseid],
            ['user_subjek.session_id', $sessionid],
            ['user_subjek.user_ic', $user->ic]
        ])->groupBy('student_subjek.group_name')
        ->select('user_subjek.*', 'subjek.course_name', 'student_subjek.group_name')->get();

        //dd(Session::get('CourseIDS'));

        $subid = DB::table('subjek')->where('id', $courseid)->pluck('sub_id');

        $folder = DB::table('lecturer_dir')
                  ->join('subjek', 'lecturer_dir.CourseID','subjek.id')
                  ->where('subjek.sub_id', $subid)
                  ->where('Addby', $user->ic)->get();

        //dd($folder);

        if(isset(request()->testid))
        {

            $testid = request()->testid;
 
            $data['testid'] = $testid;

            $data['test'] = DB::table('tblclasstest2')->select('tblclasstest2.*')
            ->where([
                ['id', $testid]
            ])->get()->first();

            //dd($data['test']);

            $data['teststatus'] = $data['test']->status;

            if(isset(request()->REUSE))
            {
                $data['reuse'] = request()->REUSE;
            }

        }

        //dd($data);

        return view('lecturer.courseassessment.test3create', compact(['group', 'folder', 'data']));
    }

    public function getChapters(Request $request)
    {

        $subchapter = DB::table('material_dir')->where('LecturerDirID', $request->folder)->get();

        $content = "";
        $content .= '
        <div class="table-responsive" style="width:99.7%">
        <table id="table_registerstudent" class="w-100 table text-fade table-bordered table-hover display nowrap margin-top-10 w-p100">
            <thead class="thead-themed">
            <th>Sub Chapter</th>
            <th>Name</th>
            <th></th>
            </thead>
            <tbody>
        ';
        foreach($subchapter as $sub){
            //$registered = ($student->status == 'ACTIVE') ? 'checked' : '';
            $content .= '
            <tr>
                <td >
                    <label>'.$sub->ChapterNo.'</label>
                </td>
                <td >
                    <label>'.(($sub->newDrName != null) ? $sub->newDrName : $sub->DrName).'</label>
                </td>
                <td >
                    <div class="pull-right" >
                        <input type="checkbox" id="chapter_checkbox_'.$sub->DrID.'"
                            class="filled-in" name="chapter[]" value="'.$sub->DrID.'" 
                        >
                        <label for="chapter_checkbox_'.$sub->DrID.'"> </label>
                    </div>
                </td>
            </tr>
            ';
            }
            $content .= '</tbody></table>';

            return $content;

    }

    public function getStatus(Request $request)
    {

        $user = Auth::user();
            
        //dd($group);

        $test = DB::table('student_subjek')
                ->join('tblclasstest2_group', 'student_subjek.group_id', 'tblclasstest2_group.groupid')
                ->join('tblclasstest2', 'tblclasstest2_group.testid', 'tblclasstest2.id')
                ->join('students', 'student_subjek.student_ic', 'students.ic')
                ->select('student_subjek.*', 'tblclasstest2.id AS clssid', 'tblclasstest2.total_mark', 'students.no_matric', 'students.name')
                ->where([
                    ['tblclasstest2.classid', Session::get('CourseIDS')],
                    ['tblclasstest2.sessionid', Session::get('SessionIDS')],
                    ['tblclasstest2.id', $request->test],
                    ['tblclasstest2.addby', $user->ic],
                    ['tblclasstest2_group.groupid', $request->group]
                ])->get();
        
        //dd($test);

        foreach($test as $qz)
        {
            $statu[] = DB::table('tblclassstudenttest')
            ->where([
                ['testid', $qz->clssid],
                ['userid', $qz->student_ic]
            ])->get();
        }

        //dd($test);

        return view('lecturer.courseassessment.getstatustest3', compact('test', 'status'));

    }


    public function inserttest(Request $request){
        $data = $request->data;
        $classid = Session::get('CourseIDS');
        $sessionid = Session::get('SessionIDS');
        $duration = $request->duration;
        $title = $request->title;
        $from = $request->from;
        $to = $request->to;
        $questionindex = $request->questionindex;
        $status = $request->status;
        $marks = $request->marks;

        $user = Auth::user();
            
        $testid = empty($request->test) ? '' : $request->test;

        $statusReuse = empty($request->reuse) ? '' : $request->reuse;

        $groupJSON = $request->input('group');
        $chapterJSON = $request->input('chapter');

        // Decode the JSON strings into PHP arrays
        $group = json_decode($groupJSON, true);
        $chapter = json_decode($chapterJSON, true);

        if( !empty($statusReuse))
        {
            $q = DB::table('tblclasstest2')->insertGetId([
                "classid" => $classid,
                "sessionid" => $sessionid,
                "title" => $title,
                "date_from" => $from,
                "date_to" => $to,
                "content" => $data,
                "duration" => $duration,
                "questionindex" => $questionindex,
                "total_mark" => $marks,
                "addby" => $user->ic,
                "status" => $status
            ]);

            foreach($group as $grp)
            {
                $gp = explode('|', $grp);
                
                DB::table('tblclasstest2_group')->insert([
                    "groupid" => $gp[0],
                    "groupname" => $gp[1],
                    "testid" => $q
                ]);
            }

            foreach($chapter as $chp)
            {
                DB::table('tblclasstest2_chapter')->insert([
                    "chapterid" => $chp,
                    "testid" => $q
                ]);
            }
            
        }else{
            if( !empty($testid) ){
                $q = DB::table('tblclasstest2')->where('id', $testid)->update([
                    "title" => $title,
                    "date_from" => $from,
                    "date_to" => $to,
                    "content" => $data,
                    "duration" => $duration,
                    "questionindex" => $questionindex,
                    "total_mark" => $marks,
                    "addby" => $user->ic,
                    "status" => $status
                ]);

                DB::table('tblclasstest2_group')->where('testid',$testid)->delete();

                foreach($group as $grp)
                {
                    $gp = explode('|', $grp);
                    
                    DB::table('tblclasstest2_group')->insert([
                        "groupid" => $gp[0],
                        "groupname" => $gp[1],
                        "testid" => $testid
                    ]);
                }

                DB::table('tblclasstest2_chapter')->where('testid',$testid)->delete();

                foreach($chapter as $chp)
                {
                    DB::table('tblclasstest2_chapter')->insert([
                        "chapterid" => $chp,
                        "testid" => $testid
                    ]);
                }

            }else{
                $q = DB::table('tblclasstest2')->insertGetId([
                    "classid" => $classid,
                    "sessionid" => $sessionid,
                    "title" => $title,
                    "date_from" => $from,
                    "date_to" => $to,
                    "content" => $data,
                    "duration" => $duration,
                    "questionindex" => $questionindex,
                    "total_mark" => $marks,
                    "addby" => $user->ic,
                    "status" => $status
                ]);

                foreach($group as $grp)
                {
                    $gp = explode('|', $grp);
                    
                    DB::table('tblclasstest2_group')->insert([
                        "groupid" => $gp[0],
                        "groupname" => $gp[1],
                        "testid" => $q
                    ]);
                }

                foreach($chapter as $chp)
                {
                    DB::table('tblclasstest2_chapter')->insert([
                        "chapterid" => $chp,
                        "testid" => $q
                    ]);
                }
            }
        }

        // Set the directory path
        $dir = "classtest/" . Session::get('CourseID') . "/" . "testimage" . "/" . $q . "/";

        $newNames = [];

        // Set the directory path (STAGING)
        // $dir = "classtest/" . Session::get('CourseID') . "/" . "testimage" . "/";

        // Access the uploaded files
        foreach ($_FILES as $inputSubtype => $fileData) {
            // Loop through the array of files
            for ($i = 0; $i < count($fileData['name']); $i++) {
                $uploadedFile = $request->file($inputSubtype . '.' . $i);

                $file_name = $uploadedFile->getClientOriginalName();
                $file_ext = $uploadedFile->getClientOriginalExtension();
                $fileInfo = pathinfo($file_name);
                $filename = $fileInfo['filename'];
                $newname = $filename . "." . $file_ext;

                // Store the new name in the $newNames array, indexed by the "uploaded_image" key and file index
                $originalName = 'uploaded_image[' . $i . ']';
                $newNames[$originalName] = $newname;

                // Check if the file is present
                if ($uploadedFile) {
                    // Validate the file (add your own validation rules)
                    $validatedData = $request->validate([
                        $inputSubtype . '.' . $i => 'mimes:jpg,jpeg,png|max:2048', // For example: images only, max size 2MB
                    ]);

                    // Check if the directory exists in Linode Object Storage
                    if (!Storage::disk('linode')->exists($dir)) {
                        // If the directory doesn't exist, create it
                        Storage::disk('linode')->makeDirectory($dir);
                    }

                    // Store the file in Linode Object Storage with the specified path
                    $filePath = Storage::disk('linode')->putFileAs(
                        $dir,
                        $uploadedFile,
                        $newname,
                        'public'
                    );

                    // Store the file path in the database or another location as per your requirements
                    // For example, you could store the paths in a separate table, or add a column to an existing table
                    // The implementation depends on your application structure

                    // Create an img tag with the uploaded image
                    $imgTag = "<img src='" . env('LINODE_ENDPOINT') . "/" . env('LINODE_BUCKET') . "/" . $dir . $newname . "' />";

                    // Replace the corresponding image input with the img tag in the test content
                    $data = str_replace($inputSubtype . '_' . $i, $imgTag, $data);
                }
            }
        }

        
        
        // Decode the JSON content of the test into a PHP array
        $test_content = json_decode($data, true);

        // Define the Linode Object Storage base URL
        $linode_base_url = rtrim(env('LINODE_ENDPOINT'), '/') . '/' . env('LINODE_BUCKET') . '/' . $dir; // Replace this with your Linode Object Storage base URL

        // Iterate through the "formData" array and update the image URLs
        // Iterate through the "formData" array and update the image URLs
        $fileIndex = 0; // Initialize the file index
        foreach ($test_content['formData'] as $index => $item) {
            if ($item['type'] === 'file' && isset($item['name'])) {
                // Construct the original name using the file index
                $originalName2 = 'uploaded_image[' . $fileIndex . ']';

                // Check if a new name exists for this file in the $newNames array
                if (isset($newNames[$originalName2])) {
                    // Prepend the Linode Object Storage base URL to the new name
                    $test_content['formData'][$index]['name'] = $linode_base_url . $newNames[$originalName2];
                }

                $fileIndex++; // Increment the file index
            }
        }

        // Re-encode the test content to JSON format
        $updated_content = json_encode($test_content);

        // Update the content field in the database with the updated content
        DB::table('tblclasstest2')->where('id', $q)->update([
            "content" => $updated_content
        ]);

        $allUsers = collect();

        foreach($group as $grp) {
            $gp = explode('|', $grp);

            $users = UserStudent::join('student_subjek', 'students.ic', '=', 'student_subjek.student_ic')
                ->where([
                    ['student_subjek.group_id', $gp[0]],
                    ['student_subjek.group_name', $gp[1]]
                ])
                ->select('students.*')
                ->get();

            $allUsers = $allUsers->merge($users);
        }

        $message = "A new online test 2 titled " . $title . " has been created.";
        $url = url('/student/test3/' . $classid . '?session=' . $sessionid);
        $icon = "fa-puzzle-piece fa-lg";
        $iconColor = "#8803a0"; // Example: set to a bright orange

        // Notification::send($allUsers, new MyCustomNotification($message, $url, $icon, $iconColor));


        return true;

    }

    public function lecturerteststatus()
    {
        $user = Auth::user();

        $group = DB::table('user_subjek')
                ->join('tblclasstest2_group', 'user_subjek.id', 'tblclasstest2_group.groupid')
                ->join('tblclasstest2', 'tblclasstest2_group.testid', 'tblclasstest2.id')
                ->where([
                    ['tblclasstest2.classid', Session::get('CourseIDS')],
                    ['tblclasstest2.sessionid', Session::get('SessionIDS')],
                    ['user_subjek.user_ic', $user->ic],
                    ['tblclasstest2.id', request()->test]
                ])->get();
                
            
        //dd($group);

        $test = DB::table('student_subjek')
                ->join('tblclasstest2_group', function($join){
                    $join->on('student_subjek.group_id', 'tblclasstest2_group.groupid');
                    $join->on('student_subjek.group_name', 'tblclasstest2_group.groupname');
                })
                ->join('tblclasstest2', 'tblclasstest2_group.testid', 'tblclasstest2.id')
                ->join('students', 'student_subjek.student_ic', 'students.ic')
                ->join('tblprogramme', 'students.program', 'tblprogramme.id')
                ->select('tblprogramme.progcode', 'student_subjek.*', 'tblclasstest2.id AS clssid', 'tblclasstest2.total_mark', 'tblclasstest2.date_from', 'tblclasstest2.date_to', 'students.no_matric', 'students.name')
                ->where([
                    ['tblclasstest2.classid', Session::get('CourseIDS')],
                    ['tblclasstest2.sessionid', Session::get('SessionIDS')],
                    ['tblclasstest2.id', request()->test],
                    ['tblclasstest2.addby', $user->ic]
                ])->whereNotIn('students.status', [4,5,6,7,16])->orderBy('students.program')->get();
        
        
        
        //dd($test);

        foreach($test as $qz)
        {
            $status[] = DB::table('tblclassstudenttest')
            ->where([
                ['testid', $qz->clssid],
                ['userid', $qz->student_ic]
            ])->get();
        }

        //dd($test);

        return view('lecturer.courseassessment.test3status', compact('test', 'status', 'group'));

    }

    public function testGetGroup(Request $request)
    {

        $user = Auth::user();

        $gp = explode('|', $request->group);

        $test = DB::table('student_subjek')
                ->join('tblclasstest2_group', function($join){
                    $join->on('student_subjek.group_id', 'tblclasstest2_group.groupid');
                    $join->on('student_subjek.group_name', 'tblclasstest2_group.groupname');
                })
                ->join('tblclasstest2', 'tblclasstest2_group.testid', 'tblclasstest2.id')
                ->join('students', 'student_subjek.student_ic', 'students.ic')
                ->join('tblprogramme', 'students.program', 'tblprogramme.id')
                ->select('tblprogramme.progcode', 'student_subjek.*', 'tblclasstest2.id AS clssid', 'tblclasstest2.total_mark', 'tblclasstest2.date_from', 'tblclasstest2.date_to', 'students.no_matric', 'students.name')
                ->where([
                    ['tblclasstest2.classid', Session::get('CourseIDS')],
                    ['tblclasstest2.sessionid', Session::get('SessionIDS')],
                    ['tblclasstest2.id', request()->test],
                    ['tblclasstest2.addby', $user->ic],
                    ['student_subjek.group_id', $gp[0]],
                    ['student_subjek.group_name', $gp[1]]
                ])->whereNotIn('students.status', [4,5,6,7,16])->orderBy('students.program')->get();
        
        foreach($test as $qz)
        {
            $status[] = DB::table('tblclassstudenttest')
            ->where([
                ['testid', $qz->clssid],
                ['userid', $qz->student_ic]
            ])->get();
        }

        $content = "";
        $content .= '<thead>
                        <tr>
                            <th style="width: 1%">No.</th>
                            <th style="width: 15%">Name</th>
                            <th style="width: 5%">Matric No.</th>
                            <th style="width: 5%">Program</th>
                            <th style="width: 20%">Submission Date</th>
                            <th style="width: 10%">Status</th>
                            <th style="width: 5%">Marks</th>
                            <th style="width: 20%"></th>
                        </tr>
                    </thead>
                    <tbody>';

        foreach ($test as $key => $qz) {
            $alert = (count($status[$key]) > 0) ? 'badge bg-success' : 'badge bg-danger';

            $content .= '
                <tr>
                    <td style="width: 1%">' . ($key + 1) . '</td>
                    <td style="width: 15%">
                        <span class="' . $alert . '">' . $qz->name . '</span>
                    </td>
                    <td style="width: 5%">
                        <span>' . $qz->no_matric . '</span>
                    </td>
                    <td style="width: 5%">
                        <span>' . $qz->progcode . '</span>
                    </td>';
            
            if (count($status[$key]) > 0) {
                foreach ($status[$key] as $keys => $sts) {
                    $content .= '
                        <td style="width: 20%">' . (empty($sts) ? '-' : $sts->submittime) . '</td>
                        <td>' . (empty($sts) ? '-' : $sts->status) . '</td>
                        <td>' . (empty($sts) ? '-' : $sts->final_mark) . ' / ' . $qz->total_mark . '</td>
                        <td class="project-actions text-center">
                            <a class="btn btn-success btn-sm mr-2" href="/lecturer/test3/' . request()->test . '/' . $sts->userid . '/result">
                                <i class="ti-pencil-alt"></i> Answer
                            </a>';
                    if (date('Y-m-d H:i:s') >= $qz->date_from && date('Y-m-d H:i:s') <= $qz->date_to) {
                        $content .= '
                            <a class="btn btn-danger btn-sm mr-2" onclick="deleteStdTest(\'' . $sts->id . '\')">
                                <i class="ti-trash"></i> Delete
                            </a>';
                    }
                    $content .= '
                        </td>';
                }
            } else {
                $content .= '
                    <td style="width: 20%">-</td>
                    <td>-</td>
                    <td>-</td>
                    <td></td>';
            }

            $content .= '
                </tr>';
        }

        $content .= '</tbody>';


        return response()->json(['message' => 'success', 'content' => $content]);


    }

    public function deleteteststatus(Request $request)
    {

        DB::table('tblclassstudenttest')->where('id', $request->id)->delete();

        return true;
        
    }

    public function testresult(Request $request){
        
        $id = $request->testid;
        $userid = $request->userid;
        $count = 1;

        //dd($id);

        $test = DB::table('tblclassstudenttest')
            ->join('tblclasstest2', 'tblclassstudenttest.testid', 'tblclasstest2.id')
            ->leftJoin('students', 'tblclassstudenttest.userid', 'students.ic')
            ->select('tblclassstudenttest.*', 'tblclassstudenttest.testid', 'tblclasstest2.title',  
                DB::raw('tblclasstest2.content as original_content'), 
                'tblclasstest2.questionindex',
                'tblclassstudenttest.userid',
                'tblclassstudenttest.submittime',
                DB::raw('tblclassstudenttest.status as studentteststatus'),
                'tblclasstest2.duration','students.name',
                'tblclasstest2.total_mark')
            ->where('tblclassstudenttest.testid', $id)
            ->where('tblclassstudenttest.userid', $userid)->get()->first();
       
        $testformdata = json_decode($test->content)->formData;
        $original_testformdata = json_decode($test->original_content)->formData;
        

        $gain_mark = false;
        $correct_label = " <i style='font-size:1.5em' class='fa fa-check text-success'></i>";
        $incorrect_label = " <i style='font-size:1.5em' class='fa fa-close text-danger'></i>";

        foreach($original_testformdata as $index => $q){

        //$radio = "radio-question".$count+1;
        //dd($radio);

            if(!empty($original_testformdata[$index]->name) ){

                if($original_testformdata[$index]->name == "radio-question".$count){
                    $i =0;
                    $correct_answer = $original_testformdata[$index + 1]->label;
                    $correct_answer = preg_replace('/\s+/', '', $correct_answer );
                    $correct_answer = explode(",", $correct_answer);
                    
                    foreach($testformdata[$index]->values as $v){
                        
                        if(in_array($v->value, $correct_answer)){
                            $testformdata[$index]->values[$i]->label = $original_testformdata[$index]->values[$i]->label . $correct_label;
                        }else{
                            $testformdata[$index]->values[$i]->label = $original_testformdata[$index]->values[$i]->label . $incorrect_label;
                        }
                        $i++;
                    }

                    $userData = !empty($testformdata[$index]->userData[0]) ? $testformdata[$index]->userData[0] : null;

                    if(in_array($userData, $correct_answer)){
                        $gain_mark = true;
                    }
                    $count++;
                    
                }
                
                if($original_testformdata[$index]->name == "checkbox-question".$count){
                    $i =0;
                    $correct_answer = $original_testformdata[$index + 1]->label;
                    $correct_answer = preg_replace('/\s+/', '', $correct_answer );
                    $correct_answer = explode(",", $correct_answer);
                    
                    foreach($testformdata[$index]->values as $v){
                        if(in_array($v->value, $correct_answer)){
                            $testformdata[$index]->values[$i]->label = $original_testformdata[$index]->values[$i]->label . $correct_label;
                        }else{
                            $testformdata[$index]->values[$i]->label = $original_testformdata[$index]->values[$i]->label . $incorrect_label;
                        }
                        $i++;
                    }
                    
                    $userData = !empty($testformdata[$index]->userData) ? $testformdata[$index]->userData : null;

                    if( count( array_diff_assoc($correct_answer, $userData) )  == 0){
                        $gain_mark = true;
                    }
                    $count++;
                
                }
            }

            if(!empty($original_testformdata[$index]->className) ){
                
                if(str_contains($original_testformdata[$index]->className, "feedback-text")){
                    $testformdata[$index] = $q;
                  
                    $testformdata[$index]->type = "paragraph";

                    if(!empty($q->userData[0])){
                        $testformdata[$index]->label = $q->userData[0];
                    }else{
                        $testformdata[$index]->label = " ";
                    }
                    $testformdata[$index]->className = "bg-red mb-4 text-danger";
                }

                if(str_contains($original_testformdata[$index]->className, "inputmark")){
                    $testformdata[$index]->type = "number";

                    if(!empty($q->userData[0])){
                        $testformdata[$index]->label = $q->userData[0];
                    }else{
                        $testformdata[$index]->label = " ";
                    }

                    $testformdata[$index]->className = "inputmark form-control";
                }

                if(str_contains($original_testformdata[$index]->className, "collected-marks")){

                    $mark_label           = $original_testformdata[$index]->values[0]->label;
                    $mark                 = $original_testformdata[$index]->values[0]->value;
                    
                    //if result is published then use graded data
                    if($test->studentteststatus == 3){
                        $graded_data = empty($testformdata[$index]->userData[0]) ? "" : $testformdata[$index]->userData[0];

                        if($graded_data == $mark){
                            $testformdata[$index]->values[0]->selected = true;
                        }else{
                            $testformdata[$index]->values[0]->selected = false;
                        }
                    }else{
                        //auto correct answer on mcq by matching user answer with original answer
                        $testformdata[$index] = $original_testformdata[$index];

                        if($gain_mark){
                            $testformdata[$index]->values[0]->selected = true;
                        }else{
                            $testformdata[$index]->values[0]->selected = false;
                        }
                        
                        $gain_mark = false;
                    }
                }
            }
        }

       
        $data['test'] = $testformdata;
        $data['comments'] = $test->comments;
        $data['totalmark'] = $test->total_mark;
        $data['testid'] = $test->testid;
        $data['testtitle'] = $test->title;
        $data['testduration'] = $test->duration;
        $data['testuserid'] = $test->userid;
        $data['fullname'] = $test->name;
        $data['created_at'] = $test->created_at;
        $data['updated_at'] = $test->updated_at;
        $data['submittime'] = $test->submittime;
        $data['questionindex'] = $test->questionindex;
        $data['studentteststatus'] = $test->studentteststatus;

        return view('lecturer.courseassessment.test3result', compact('data'));
    }

    public function updatetestresult(Request $request){
        $test = $request->test;
        $participant = $request->participant;
        $final_mark = $request->final_mark;
        $comments = $request->comments;
        //$total_mark = $request->total_mark;
        $data = $request->data;

      
        $q = \DB::table('tblclassstudenttest')
            ->where('testid', $test)
            ->where("userid", $participant)
            ->update([
                "content" => $data,
                "final_mark" => $final_mark,
                //"total_mark" => $total_mark,
                "comments" => $comments,
                "status" => 3
            ]);

        $message = "Lecturer has marked your test.";
        $url = url('/student/test3/' . $test . '/' . $participant . '/result');
        $icon = "fa-check fa-lg";
        $iconColor = "#2b74f3"; // Example: set to a bright orange

        $participant = UserStudent::where('ic', $participant)->first();

        // Notification::send($participant, new MyCustomNotification($message, $url, $icon, $iconColor));
    
        
        return true;
    }




    //This is Student test Controller//

    public function studenttestlist()
    {
        $chapter = [];

        Session::put('CourseIDS', request()->id);

        if(Session::get('SessionIDS') == null)
        {
        Session::put('SessionIDS', request()->session);
        }

        $student = auth()->guard('student')->user();

        Session::put('StudInfos', $student);

        $courseid = DB::table('subjek')->where('id', request()->id)->value('sub_id');

        $group = DB::table('user_subjek')
                ->join('student_subjek', 'user_subjek.id', 'student_subjek.group_id')
                ->join('users', 'user_subjek.user_ic', 'users.ic')
                ->where([
                    ['student_subjek.student_ic', $student->ic],
                    ['student_subjek.courseid', $courseid],
                    ['student_subjek.sessionid', request()->session]
                    ])
                ->select('user_subjek.id')
                ->first();

        //dd($student->ic);

        $data = DB::table('tblclasstest2')
                ->join('users', 'tblclasstest2.addby', 'users.ic')
                ->join('tblclasstest2_group', 'tblclasstest2.id', 'tblclasstest2_group.testid')
                ->join('student_subjek', function($join){
                    $join->on('tblclasstest2_group.groupid', 'student_subjek.group_id');
                    $join->on('tblclasstest2_group.groupname', 'student_subjek.group_name');
                })
                ->join('user_subjek', 'tblclasstest2_group.groupid', 'user_subjek.id')
                ->select('tblclasstest2.*', 'tblclasstest2_group.groupname', 'users.name AS addby')
                ->where([
                    ['user_subjek.id', $group->id],
                    ['tblclasstest2.sessionid', Session::get('SessionIDS')],
                    ['student_subjek.student_ic', $student->ic],
                    ['tblclasstest2.content','!=', null],
                    ['tblclasstest2.status','!=', 3],
                    ['tblclasstest2.date_from','!=', null]
                ])->get();

        //dd($data);

        foreach($data as $dt)
        {
            $chapter[] = DB::table('tblclasstest2_chapter')
                      ->join('material_dir', 'tblclasstest2_chapter.chapterid', 'material_dir.DrID')
                      ->where('tblclasstest2_chapter.testid', $dt->id)->get();
        }

        return view('student.courseassessment.test3', compact('data', 'chapter'));

    }

    public function studentteststatus()
    {
        $courseid = DB::table('subjek')->where('id', Session::get('CourseIDS'))->value('sub_id');

        $group = DB::table('user_subjek')
                ->join('student_subjek', 'user_subjek.id', 'student_subjek.group_id')
                ->join('users', 'user_subjek.user_ic', 'users.ic')
                ->where([
                    ['student_subjek.student_ic', Session::get('StudInfos')->ic],
                    ['student_subjek.courseid', $courseid],
                    ['student_subjek.sessionid', Session::get('SessionIDS')]
                    ])
                ->select('user_subjek.id')
                ->first();

        $test = DB::table('student_subjek')
                ->join('tblclasstest2_group', function($join){
                    $join->on('student_subjek.group_id', 'tblclasstest2_group.groupid');
                    $join->on('student_subjek.group_name', 'tblclasstest2_group.groupname');
                })
                ->join('tblclasstest2', 'tblclasstest2_group.testid', 'tblclasstest2.id')
                ->where([
                    ['student_subjek.group_id', $group->id],
                    ['tblclasstest2.sessionid', Session::get('SessionIDS')],
                    ['tblclasstest2.id', request()->test],
                    ['student_subjek.student_ic', Session::get('StudInfos')->ic]
                ])->get();

        //dd(Session::get('StudInfos')->ic);

        foreach($test as $qz)
        {
            $status[] = DB::table('tblclassstudenttest')
            ->where([
                ['testid', $qz->id],
                ['userid', Session::get('StudInfos')->ic]
            ])->first();
        }

        //dd($status);

        return view('student.courseassessment.test3status', compact('test', 'status'));
    }

    public function testview(Request $request){

        //dd(str_replace('"', '', Session::get('StudInfos')->ic));

        //dd(Session::get('StudInfo')->ic)

        $id = $request->test;

        if(DB::table('tblclassstudenttest')
        ->where([
            ['userid', Session::get('StudInfo')->ic],
            ['testid', $id]
         ])->exists()) {

            $test = DB::table('tblclasstest2')
            ->leftjoin('tblclassstudenttest', function($join) 
            {
                $join->on('tblclasstest2.id', '=', 'tblclassstudenttest.testid');
            })
            ->where('tblclassstudenttest.userid',  '=', Session::get('StudInfo')->ic);

         }else{


            $test = DB::table('tblclasstest2')
            ->leftjoin('tblclassstudenttest', function($join) 
            {
                $join->on('tblclasstest2.id', '=', 'tblclassstudenttest.testid');
                $join->on('tblclassstudenttest.userid',  '=', DB::raw('1234'));
            });

         }

         $test = $test->leftJoin('students', 'tblclassstudenttest.userid', 'students.ic')
         ->leftJoin('tblclasstest2status', 'tblclasstest2.status', 'tblclasstest2status.id')
         ->select('tblclasstest2.*', 'tblclassstudenttest.userid', 'tblclassstudenttest.testid','students.name', 
             DB::raw('tblclasstest2.status as classteststatus'),
             DB::raw('tblclassstudenttest.status as studentteststatus'), 'tblclassstudenttest.endtime', 'tblclassstudenttest.starttime' , 
             DB::raw('TIMESTAMPDIFF(SECOND, now(), endtime) as timeleft'),
             DB::raw('tblclassstudenttest.content as studenttestcontent')
         )
         ->where('tblclasstest2.id', $id)
         ->get()->first();

        

        //dd($test);

        $testformdata = json_decode($test->content)->formData;

        if(!empty($test->studenttestcontent)){
            $testformdata = json_decode($test->studenttestcontent)->formData;
        }

        foreach($testformdata as $index => $v){

            if(!empty($testformdata[$index]->className) ){
                if ($v->type === 'file') {
                    $testformdata[$index]->disabled = true;
                    $testformdata[$index]->label = null;
                    $testformdata[$index]->description = null;
                }

                if(str_contains($testformdata[$index]->className, "collected-marks")){
                    $testformdata[$index]->type = "paragraph";
                    $testformdata[$index]->label = $testformdata[$index]->values[0]->label;
                }

                if(str_contains($testformdata[$index]->className, "correct-answer")){
                    $testformdata[$index]->className = "correct-answer d-none";
                    unset($testformdata[$index]->label);
                }

                if(str_contains($testformdata[$index]->className, "feedback-text")){
                    $testformdata[$index]->className = "feedback-text d-none";
                    unset($testformdata[$index]->label);
                }

                if(str_contains($testformdata[$index]->className, "inputmark")){
                    $testformdata[$index]->className = "inputmark d-none";
                    unset($testformdata[$index]->label);
                }
            }
        }

        if($test->classteststatus == 2){
            if($test->studentteststatus == 2 || $test->studentteststatus == 3){
                //completed test
                return redirect('/academics/test/'.$test->testid.'/result');
            }else{
                $data['test'] = json_encode($testformdata );
                $data['testid'] = $test->id;
                $data['testtitle'] = $test->title;
                $data['testduration'] = $test->duration;
                $data['testendduration'] = $test->date_to;
                $data['fullname'] = $test->name;
                $data['created_at'] = $test->created_at;
                $data['updated_at'] = $test->updated_at;
                $data['teststarttime'] = $test->starttime;
                $data['testendtime'] = $test->endtime;
                $data['testtimeleft'] = $test->timeleft;
        
                return view('student.courseassessment.test3answer', compact('data'));
            }
        }else{
            return "Test is not published yet";
        }
    }

    public function starttest(Request $request){

        $test = $request->test;
        $data = $request->data;
        
        $testduration = DB::table('tblclasstest2')->select('duration')->where('id', $test)->first()->duration;
        
        try{
            DB::beginTransaction();
            $q =  DB::table('tblclassstudenttest')->insert([
                "userid" =>  Session::get('StudInfos')->ic,
                "testid" => $test,
                "content" => $data,
                "starttime" =>  DB::raw('now()'),
                "endtime" => DB::raw('now() + INTERVAL '.$testduration.' MINUTE'),
                "status" => 1
            ]);
            DB::commit();
        }catch(QueryException $ex){
            if($ex->getCode() == 23000){
            }else{
                \Log::debug($ex);
            }
        }
    }

    public function savetest(Request $request){

        $data = $request->data;
        $testid = $request->test;


        $q = DB::table('tblclassstudenttest')->where('status', 1)->where('testid',$testid)->where('userid', Session::get('StudInfos')->ic)->update([
            "content" => $data
        ]);

        $q = ($q == 1) ? true : false;

        return $q;
     
    }

    public function submittest(Request $request){
        $data = $request->data;
        $id = $request->id;

        // Decode the JSON data
        $decodedData = json_decode($data, true);

        // Iterate over formData and update checkbox groups
        foreach ($decodedData['formData'] as &$item) {
            if ($item['type'] == 'checkbox-group') {
                if (empty($item['userData']) || !isset($item['userData'])) {
                    $item['userData'] = [" "];
                }
            }
        }

        // Encode the data back to JSON
        $data = json_encode($decodedData);

        $test = DB::table('tblclasstest2')
            ->leftjoin('tblclassstudenttest', function($join) 
            {
                $join->on('tblclasstest2.id', '=', 'tblclassstudenttest.testid');
                $join->on('tblclassstudenttest.userid',  '=', DB::raw('12345'));
            })
            ->select('tblclasstest2.*', 'tblclassstudenttest.userid', DB::raw('tblclassstudenttest.status as studentteststatus'),
             'tblclassstudenttest.testid')
            ->where('tblclasstest2.id', $id)
            ->get()->first();

        if($test->studentteststatus == 2 || $test->studentteststatus == 3){
            return ["status"=>false, "message" =>"Sorry, you have completed the test before."];
        }

        $q = DB::table('tblclassstudenttest')->upsert([
            "userid" => Session::get('StudInfos')->ic,
            "testid" => $id,
            "submittime" => DB::raw('now()'),
            "content" => $data,
            "status" => 2
        ],['userid', 'testid']);

        return ["status"=>true, "message" =>$data];
     
    }

    public function testresultstd(Request $request){
        
        $id = $request->testid;
        $userid = $request->userid;
        $count = 1;

        //dd($id);

        $test = DB::table('tblclassstudenttest')
            ->join('tblclasstest2', 'tblclassstudenttest.testid', 'tblclasstest2.id')
            ->leftJoin('students', 'tblclassstudenttest.userid', 'students.ic')
            ->select('tblclassstudenttest.*', 'tblclassstudenttest.testid', 'tblclasstest2.title',  
                DB::raw('tblclasstest2.content as original_content'), 
                'tblclasstest2.questionindex',
                'tblclassstudenttest.userid',
                'tblclassstudenttest.submittime',
                DB::raw('tblclassstudenttest.status as studentteststatus'),
                'tblclasstest2.duration','students.name')
            ->where('tblclassstudenttest.testid', $id)
            ->where('tblclassstudenttest.userid', $userid)->get()->first();

        //dd($test);
       
        $testformdata = json_decode($test->content)->formData;
        $original_testformdata = json_decode($test->original_content)->formData;

        $gain_mark = false;
        $correct_label = " <i style='font-size:1.5em' class='fa fa-check text-success'></i>";
        $incorrect_label = " <i style='font-size:1.5em' class='fa fa-close text-danger'></i>";

        foreach($original_testformdata as $index => $q){

        //$radio = "radio-question".$count+1;
        //dd($radio);

            if(!empty($original_testformdata[$index]->name) ){

                if($original_testformdata[$index]->name == "radio-question".$count){
                    $i =0;
                    $correct_answer = $original_testformdata[$index + 1]->label;
                    $correct_answer = preg_replace('/\s+/', '', $correct_answer );
                    $correct_answer = explode(",", $correct_answer);
                    
                    foreach($testformdata[$index]->values as $v){
                        
                        if(in_array($v->value, $correct_answer)){
                            $testformdata[$index]->values[$i]->label = $original_testformdata[$index]->values[$i]->label . $correct_label;
                        }else{
                            $testformdata[$index]->values[$i]->label = $original_testformdata[$index]->values[$i]->label . $incorrect_label;
                        }
                        $i++;
                    }

                    $userData = !empty($testformdata[$index]->userData[0]) ? $testformdata[$index]->userData[0] : null;

                    if(in_array($userData, $correct_answer)){
                        $gain_mark = true;
                    }
                    $count++;
                    
                }
                
                if($original_testformdata[$index]->name == "checkbox-question".$count){
                    $i =0;
                    $correct_answer = $original_testformdata[$index + 1]->label;
                    $correct_answer = preg_replace('/\s+/', '', $correct_answer );
                    $correct_answer = explode(",", $correct_answer);
                    
                    foreach($testformdata[$index]->values as $v){
                        if(in_array($v->value, $correct_answer)){
                            $testformdata[$index]->values[$i]->label = $original_testformdata[$index]->values[$i]->label . $correct_label;
                        }else{
                            $testformdata[$index]->values[$i]->label = $original_testformdata[$index]->values[$i]->label . $incorrect_label;
                        }
                        $i++;
                    }
                    
                    $userData = !empty($testformdata[$index]->userData) ? $testformdata[$index]->userData : null;

                    if( count( array_diff_assoc($correct_answer, $userData) )  == 0){
                        $gain_mark = true;
                    }
                    $count++;
                
                }
            }

            if(!empty($original_testformdata[$index]->className) ){
                
                if(str_contains($original_testformdata[$index]->className, "feedback-text")){
                    $testformdata[$index] = $q;
                  
                    $testformdata[$index]->type = "paragraph";

                    if(!empty($q->userData[0])){
                        $testformdata[$index]->label = $q->userData[0];
                    }else{
                        $testformdata[$index]->label = " ";
                    }
                    $testformdata[$index]->className = "bg-red mb-4 text-danger";
                }

                if(str_contains($original_testformdata[$index]->className, "inputmark")){
                    $testformdata[$index]->type = "number";

                    if(!empty($q->userData[0])){
                        $testformdata[$index]->label = $q->userData[0];
                    }else{
                        $testformdata[$index]->label = " ";
                    }
                    $testformdata[$index]->className = "inputmark form-control";

                    //dd($testformdata[$index]);
                }

                if(str_contains($original_testformdata[$index]->className, "collected-marks")){

                    $mark_label           = $original_testformdata[$index]->values[0]->label;
                    $mark                 = $original_testformdata[$index]->values[0]->value;
                    
                    //if result is published then use graded data
                    if($test->studentteststatus == 3){
                        $graded_data = empty($testformdata[$index]->userData[0]) ? "" : $testformdata[$index]->userData[0];

                        if($graded_data == $mark){
                            $testformdata[$index]->values[0]->selected = true;
                        }else{
                            $testformdata[$index]->values[0]->selected = false;
                        }
                    }else{
                        //auto correct answer on mcq by matching user answer with original answer
                        $testformdata[$index] = $original_testformdata[$index];

                        if($gain_mark){
                            $testformdata[$index]->values[0]->selected = true;
                        }else{
                            $testformdata[$index]->values[0]->selected = false;
                        }
                        
                        $gain_mark = false;
                    }
                }
            }
        }

       
        $data['test'] = $testformdata;
        $data['comments'] = $test->comments;
        $data['testid'] = $test->testid;
        $data['testtitle'] = $test->title;
        $data['testduration'] = $test->duration;
        $data['testuserid'] = $test->userid;
        $data['fullname'] = $test->name;
        $data['created_at'] = $test->created_at;
        $data['updated_at'] = $test->updated_at;
        $data['submittime'] = $test->submittime;
        $data['questionindex'] = $test->questionindex;
        $data['studentteststatus'] = $test->studentteststatus;

        //dd($data);

        return view('student.courseassessment.test3result', compact('data'));
    }



    //THIS IS test PART 2


    public function test2list()
    {
        Session::put('CourseIDS', request()->id);

        if(Session::get('SessionIDS') == null)
        {
        Session::put('SessionIDS', request()->session);
        }

        $user = Auth::user();
        $group = array();

        $chapter = array();

        //dd(Session::get('CourseIDS'));

        $data = DB::table('tblclasstest2')
                ->join('users', 'tblclasstest2.addby', 'users.ic')
                ->join('tblclasstest2status', 'tblclasstest2.status', 'tblclasstest2status.id')
                ->where([
                    ['tblclasstest2.classid', Session::get('CourseIDS')],
                    ['tblclasstest2.sessionid', Session::get('SessionIDS')],
                    ['tblclasstest2.addby', $user->ic],
                    ['tblclasstest2.date_from', null],
                    ['tblclasstest2.status', '!=', 3]
                ])
                ->select('tblclasstest2.*', 'users.name AS addby', 'tblclasstest2status.statusname')->get();

        //dd($data);

      
            foreach($data as $dt)
            {
                $group[] = DB::table('tblclasstest2_group')
                        ->join('user_subjek', 'tblclasstest2_group.groupid', 'user_subjek.id')
                        ->where('tblclasstest2_group.testid', $dt->id)->get();

                $chapter[] = DB::table('tblclasstest2_chapter')
                        ->join('material_dir', 'tblclasstest2_chapter.chapterid', 'material_dir.DrID')
                        ->where('tblclasstest2_chapter.testid', $dt->id)->get();
            }
      

        return view('lecturer.courseassessment.test4', compact('data', 'group', 'chapter'));
    }

    public function test2create()
    {
        $user = Auth::user();

        $courseid = Session::get('CourseIDS');

        $sessionid = Session::get('SessionIDS');

        $data['test'] = null;

        $data['folder'] = null;

        $data['chapter'] = null;

        //$totalpercent = 0;

        $group = subject::join('student_subjek', 'user_subjek.id', 'student_subjek.group_id')
        ->join('subjek', 'user_subjek.course_id', 'subjek.sub_id')
        ->where([
            ['subjek.id', $courseid],
            ['user_subjek.session_id', $sessionid],
            ['user_subjek.user_ic', $user->ic]
        ])->groupBy('student_subjek.group_name')
        ->select('user_subjek.*', 'subjek.course_name', 'student_subjek.group_name')->get();

        //dd(Session::get('CourseIDS'));

        $subid = DB::table('subjek')->where('id', $courseid)->pluck('sub_id');

        $folder = DB::table('lecturer_dir')
                  ->join('subjek', 'lecturer_dir.CourseID','subjek.id')
                  ->where('subjek.sub_id', $subid)
                  ->where('Addby', $user->ic)->get();

        if(isset(request()->testid))
        {

            $data['test'] = DB::table('tblclasstest2')->where('id', request()->testid)->first();

            //dd($data['folder']);
            
        }

     

        return view('lecturer.courseassessment.test4create', compact(['group', 'folder', 'data']));
    }


    public function inserttest2(Request $request){
        //$data = $request->data;
        $classid = Session::get('CourseIDS');
        $sessionid = Session::get('SessionIDS');
        $title = $request->title;
        $group = $request->group;
        $chapter = $request->chapter;
        $marks = $request->marks;

        $data = $request->validate([
            'myPdf' => 'required', 'mimes:pdf'
        ]);

        $user = Auth::user();

        $dir = "classtest2/" .  $classid . "/" . $user->name . "/" . $title;
        $classtest2  = Storage::disk('linode')->makeDirectory($dir);
        $file = $request->file('myPdf');
            
        $testid = empty($request->test) ? '' : $request->test;

        if($group != null && $chapter != null)
        {
        
            if( !empty($testid) ){
                
                $test = DB::table('tblclasstest2')->where('id', $testid)->first();

                Storage::disk('linode')->delete($test->content);

                DB::table('tblclasstest2_group')->where('testid', $testid)->delete();

                DB::table('tblclasstest2_chapter')->where('testid', $testid)->delete();

                $file_name = $file->getClientOriginalName();
                $file_ext = $file->getClientOriginalExtension();
                $fileInfo = pathinfo($file_name);
                $filename = $fileInfo['filename'];
                $newname = $filename . "." . $file_ext;
                $newpath = "classtest2/" .  $classid . "/" . $user->name . "/" . $title . "/" . $newname;

                if(!file_exists($newname)){
                    Storage::disk('linode')->putFileAs(
                        $dir,
                        $file,
                        $newname,
                        'public'
                    );

                    $q = DB::table('tblclasstest2')->where('id', $testid)->update([
                        "title" => $title,
                        'content' => $newpath,
                        "total_mark" => $marks,
                        "status" => 2
                    ]);

                    foreach($request->group as $grp)
                    {
                        $gp = explode('|', $grp);

                        DB::table('tblclasstest2_group')->insert([
                            "groupid" => $gp[0],
                            "groupname" => $gp[1],
                            "testid" => $testid
                        ]);
                    }

                    foreach($request->chapter as $chp)
                    {
                        DB::table('tblclasstest2_chapter')->insert([
                            "chapterid" => $chp,
                            "testid" => $testid
                        ]);
                    }

                }

            }else{
                $file_name = $file->getClientOriginalName();
                $file_ext = $file->getClientOriginalExtension();
                $fileInfo = pathinfo($file_name);
                $filename = $fileInfo['filename'];
                $newname = $filename . "." . $file_ext;
                $newpath = "classtest2/" .  $classid . "/" . $user->name . "/" . $title . "/" . $newname;

                if(!file_exists($newname)){
                    Storage::disk('linode')->putFileAs(
                        $dir,
                        $file,
                        $newname,
                        'public'
                    );

                    $q = DB::table('tblclasstest2')->insertGetId([
                        "classid" => $classid,
                        "sessionid" => $sessionid,
                        "title" => $title,
                        'content' => $newpath,
                        "total_mark" => $marks,
                        "addby" => $user->ic,
                        "status" => 2
                    ]);

                    foreach($request->group as $grp)
                    {
                        $gp = explode('|', $grp);

                        DB::table('tblclasstest2_group')->insert([
                            "groupid" => $gp[0],
                            "groupname" => $gp[1],
                            "testid" => $q
                        ]);
                    }

                    foreach($request->chapter as $chp)
                    {
                        DB::table('tblclasstest2_chapter')->insert([
                            "chapterid" => $chp,
                            "testid" => $q
                        ]);
                    }

                }

            }

            $allUsers = collect();

            foreach($request->group as $grp) {
                $gp = explode('|', $grp);

                $users = UserStudent::join('student_subjek', 'students.ic', '=', 'student_subjek.student_ic')
                    ->where([
                        ['student_subjek.group_id', $gp[0]],
                        ['student_subjek.group_name', $gp[1]]
                    ])
                    ->select('students.*')
                    ->get();

                $allUsers = $allUsers->merge($users);
            }

            //dd($allUsers);

            $message = "A new offline test 2 titled " . $title . " has been created.";
            $url = url('/student/test4/' . $classid . '?session=' . $sessionid);
            $icon = "fa-puzzle-piece fa-lg";
            $iconColor = "#8803a0"; // Example: set to a bright orange

            // Notification::send($allUsers, new MyCustomNotification($message, $url, $icon, $iconColor));


        }else{

            return redirect()->back()->withErrors(['Please fill in the group and sub-chapter checkbox !']);

        }
        
        
        return redirect(route('lecturer.test4', ['id' => $classid]));
    }

    public function lecturertest2status()
    {
        $user = Auth::user();

        $group = DB::table('user_subjek')
                ->join('tblclasstest2_group', 'user_subjek.id', 'tblclasstest2_group.groupid')
                ->join('tblclasstest2', 'tblclasstest2_group.testid', 'tblclasstest2.id')
                ->where([
                    ['tblclasstest2.classid', Session::get('CourseIDS')],
                    ['tblclasstest2.sessionid', Session::get('SessionIDS')],
                    ['user_subjek.user_ic', $user->ic],
                    ['tblclasstest2.id', request()->test]
                ])->get();
                
            
        //dd($group);

        $test = DB::table('student_subjek')
                ->join('tblclasstest2_group', function($join){
                    $join->on('student_subjek.group_id', 'tblclasstest2_group.groupid');
                    $join->on('student_subjek.group_name', 'tblclasstest2_group.groupname');
                })
                ->join('tblclasstest2', 'tblclasstest2_group.testid', 'tblclasstest2.id')
                ->join('students', 'student_subjek.student_ic', 'students.ic')
                ->join('tblprogramme', 'students.program', 'tblprogramme.id')
                ->select('tblprogramme.progcode', 'student_subjek.*', 'tblclasstest2.id AS clssid', 'tblclasstest2.total_mark', 'students.no_matric', 'students.name')
                ->where([
                    ['tblclasstest2.classid', Session::get('CourseIDS')],
                    ['tblclasstest2.sessionid', Session::get('SessionIDS')],
                    ['tblclasstest2.id', request()->test],
                    ['tblclasstest2.addby', $user->ic]
                ])->whereNotIn('students.status', [4,5,6,7,16])->orderBy('students.program')->get();
        
        
        
        //dd($test);

        foreach($test as $qz)
        {
            //$status[] = DB::table('tblclassstudenttest')
            //->where([
               // ['testid', $qz->clssid],
               // ['userid', $qz->student_ic]
           // ])->get();

           if(!DB::table('tblclassstudenttest')->where([['testid', $qz->clssid],['userid', $qz->student_ic]])->exists()){

                DB::table('tblclassstudenttest')->insert([
                    'testid' => $qz->clssid,
                    'userid' => $qz->student_ic
                ]);

           }

            $status[] = DB::table('tblclassstudenttest')
            ->where([
                ['testid', $qz->clssid],
                ['userid', $qz->student_ic]
            ])->first();
        }

        //dd($status);

        return view('lecturer.courseassessment.test4status', compact('test', 'status', 'group'));

    }

    public function test2GetGroup(Request $request)
    {

        $user = Auth::user();

        $gp = explode('|', $request->group);

        $test = DB::table('student_subjek')
                ->join('tblclasstest2_group', function($join){
                    $join->on('student_subjek.group_id', 'tblclasstest2_group.groupid');
                    $join->on('student_subjek.group_name', 'tblclasstest2_group.groupname');
                })
                ->join('tblclasstest2', 'tblclasstest2_group.testid', 'tblclasstest2.id')
                ->join('students', 'student_subjek.student_ic', 'students.ic')
                ->join('tblprogramme', 'students.program', 'tblprogramme.id')
                ->select('tblprogramme.progcode', 'student_subjek.*', 'tblclasstest2.id AS clssid', 'tblclasstest2.total_mark', 'students.no_matric', 'students.name')
                ->where([
                    ['tblclasstest2.classid', Session::get('CourseIDS')],
                    ['tblclasstest2.sessionid', Session::get('SessionIDS')],
                    ['tblclasstest2.id', request()->test],
                    ['tblclasstest2.addby', $user->ic],
                    ['student_subjek.group_id', $gp[0]],
                    ['student_subjek.group_name', $gp[1]]
                ])->whereNotIn('students.status', [4,5,6,7,16])->orderBy('students.program')->get();

        foreach($test as $qz)
        {

           if(!DB::table('tblclassstudenttest')->where([['testid', $qz->clssid],['userid', $qz->student_ic]])->exists()){

                DB::table('tblclassstudenttest')->insert([
                    'testid' => $qz->clssid,
                    'userid' => $qz->student_ic
                ]);

           }

            $status[] = DB::table('tblclassstudenttest')
            ->where([
                ['testid', $qz->clssid],
                ['userid', $qz->student_ic]
            ])->first();
        }

        $content = "";
        $content .= '<thead>
                        <tr>
                            <th style="width: 1%">
                                No.
                            </th>
                            <th>
                                Name
                            </th>
                            <th>
                                Matric No.
                            </th>
                            <th>
                                Program
                            </th>
                            <th>
                                Submission Date
                            </th>
                            <th>
                                Marks
                            </th>
                        </tr>
                    </thead>
                    <tbody id="table">';
                            
        foreach ($test as $key => $qz) {
            $alert = ($status[$key]->final_mark != 0) ? 'badge bg-success' : 'badge bg-danger';

            $content .= '
                <tr>
                    <td style="width: 1%">
                        ' . ($key + 1) . '
                    </td>
                    <td>
                        <span class="' . $alert . '">' . $qz->name . '</span>
                    </td>
                    <td>
                        <span>' . $qz->no_matric . '</span>
                    </td>
                    <td>
                        <span>' . $qz->progcode . '</span>
                    </td>';
            
            if ($status[$key]->final_mark != 0) {
                $content .= '
                    <td>
                        ' . $status[$key]->submittime . '
                    </td>';
            } else {
                $content .= '
                    <td>
                        -
                    </td>';
            }
            
            $content .= '
                    <td>
                        <div class="form-inline col-md-6 d-flex">
                            <input type="number" class="form-control" name="marks[]" max="' . $qz->total_mark . '" value="' . $status[$key]->final_mark . '">
                            <input type="text" name="ic[]" value="' . $qz->student_ic . '" hidden>
                            <span>' . $status[$key]->final_mark . ' / ' . $qz->total_mark . '</span>
                        </div>
                    </td>
                </tr>';
        }

        $content .= '</tbody>';

        return response()->json(['message' => 'success', 'content' => $content]);


    }

    public function updatetest2(Request $request)
    {
        $user = Auth::user();

        $marks = json_decode($request->marks);

        $ics = json_decode($request->ics);

        $testid = json_decode($request->testid);

        $limitpercen = DB::table('tblclasstest2')->where('id', $testid)->first();

        foreach($marks as $key => $mrk)
        {

            if($mrk > $limitpercen->total_mark)
            {
                return ["message"=>"Field Error", "id" => $ics];
            }

        }

       
        $upsert = [];
        foreach($marks as $key => $mrk){
            $existingMark = DB::table('tblclassstudenttest')
            ->where('userid', $ics[$key])
            ->where('testid', $testid)
            ->value('final_mark');

            array_push($upsert, [
            'userid' => $ics[$key],
            'testid' => $testid,
            'submittime' => date("Y-m-d H:i:s"),
            'final_mark' => $mrk,
            'status' => 1
            ]);

            if ($mrk != 0 && $mrk != $existingMark) {
            $message = "Lecturer has marked your offline test 2.";
            $url = url('/student/test4/' . $limitpercen->classid . '?session=' . $limitpercen->sessionid);
            $icon = "fa-check fa-lg";
            $iconColor = "#2b74f3"; // Example: set to a bright orange

            $participant = UserStudent::where('ic', $ics[$key])->first();

            // Notification::send($participant, new MyCustomNotification($message, $url, $icon, $iconColor));
            }
        }

        DB::table('tblclassstudenttest')->upsert($upsert, ['userid', 'testid']);

        return ["message"=>"Success", "id" => $ics];

    }


    //This is test 2 Student Controller


    public function studenttest2list()
    {
        $chapter = [];

        $marks = [];

        Session::put('CourseIDS', request()->id);

        if(Session::get('SessionIDS') == null)
        {
        Session::put('SessionIDS', request()->session);
        }

        $student = auth()->guard('student')->user();

        Session::put('StudInfos', $student);

        //dd($student->ic);

        $courseid = DB::table('subjek')->where('id', request()->id)->value('sub_id');

        $group = DB::table('user_subjek')
                ->join('student_subjek', 'user_subjek.id', 'student_subjek.group_id')
                ->join('users', 'user_subjek.user_ic', 'users.ic')
                ->where([
                    ['student_subjek.student_ic', Session::get('StudInfos')->ic],
                    ['student_subjek.courseid', $courseid],
                    ['student_subjek.sessionid', Session::get('SessionIDS')]
                    ])
                ->select('user_subjek.id')
                ->first();

        $data = DB::table('tblclasstest2')
                ->join('tblclasstest2_group', 'tblclasstest2.id', 'tblclasstest2_group.testid')
                ->join('tblclasstest2status', 'tblclasstest2.status', 'tblclasstest2status.id')
                ->join('student_subjek', function($join){
                    $join->on('tblclasstest2_group.groupid', 'student_subjek.group_id');
                    $join->on('tblclasstest2_group.groupname', 'student_subjek.group_name');
                })
                ->join('user_subjek', 'tblclasstest2_group.groupid', 'user_subjek.id')
                ->select('tblclasstest2.*', 'tblclasstest2_group.groupname','tblclasstest2status.statusname')
                ->where([
                    ['user_subjek.id', $group->id],
                    ['tblclasstest2.sessionid', Session::get('SessionIDS')],
                    ['student_subjek.student_ic', $student->ic],
                    ['tblclasstest2.date_from', null],
                    ['tblclasstest2.status','!=', 3]
                ])->get();

        //dd($data);

        foreach($data as $dt)
        {
            $chapter[] = DB::table('tblclasstest2_chapter')
                      ->join('material_dir', 'tblclasstest2_chapter.chapterid', 'material_dir.DrID')
                      ->where('tblclasstest2_chapter.testid', $dt->id)->get();

            $marks[] = DB::table('tblclassstudenttest')
                      ->where([
                        ['testid', $dt->id],
                        ['userid', $student->ic]
                      ])->get();
        }

        //dd($marks);

        return view('student.courseassessment.test4', compact('data', 'chapter', 'marks'));

    }
}
