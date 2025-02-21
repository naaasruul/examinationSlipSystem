<?php

namespace App\Http\Controllers;


use App\Models\myclass;
use App\Models\User;
use App\Models\Subject;
use App\Models\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class teacherController extends Controller
{
    //
    public function showTeacherMain()
    {
        $user = Auth::user();
        if ($user) {
            $myClass = myclass::where('classCode', $user->classCode)->first();
            $classes = myclass::all();
            return view('teacherMain', ['user' => $user, 'class' => $myClass, 'classes' => $classes]);
        }
    }
    public function showTeacherProfile(){
        $user = Auth::user();
        if($user){
            $studentClass = myclass::where('id', $user->classCode)->first();
            // Directly retrieve subjects via raw query for debugging
        $subjects = DB::table('subject_user')
        ->join('subjects', 'subject_user.subjectCode', '=', 'subjects.subjectCode')
        ->where('subject_user.ic', $user->id)
        ->select('subjects.*')
        ->get();

    // dd($subjects); // Check if this shows any data

            return view('teacherProfile',['user'=>$user,'class' => $studentClass,'subjects' => $subjects]);
        }else{
            return redirect('');
        }
    }

    public function showStudentOfClass($classid){
        $students = User::where('classCode',$classid)->where('role',1)->with('studentClass')->get();
        // Retrieve the class information
    $selectedClass = myclass::find($classid); // Assuming 'ClassModel' is your class model
        
        return view('studentOfClass',['students'=>$students,'class'=>$selectedClass]);
    }
    
    public function showTeacherMarks()
    {
        $user = Auth::user();

        // Check if the user is authenticated and has a role of 3 (assuming role 3 is for teachers)
        if ($user && $user->role == 3) {
            $myClasses = myclass::all()->groupBy('className');
            
            $students = User::all();
            $subjects = Subject::all();
            // Pass the list of classes to the view
            return view('teacherMarks', ['myClasses' => $myClasses, 'students' => $students, 'subjects' => $subjects, 'selectedStudent' => '']);
        } else {
            // If the user is not a teacher, redirect to another page (e.g., home)
            return redirect('');
        }
    }

    public function selectMarkStudent($studentId)
    {
        // / Retrieve student details using the studentId (IC)
        $student = User::where('ic', $studentId)->first();

        if (!$student) {
            return response()->json(['error' => 'Student not found'], 404);
        }

        // Retrieve the student's marks grouped by subject and exam type
        $results = Result::where('ic', $studentId)->get();
        foreach ($results as $result) {
            $marks[] = [
                'subjectCode' => $result->subjectCode,
                'exam1' => $result->exam1,
                'exam2' => $result->exam2,
                'exam3' => $result->exam3,
            ];
        }
        // Prepare the response with student information and marks
        $response = [
            'name' => $student->name,
            'ic' => $student->ic,
            'marks' => $marks,    // The formatted marks array
        ];


        // Return the student data and their marks as a JSON response
        return response()->json($response);
    }

    public function submitMark(Request $request,$subjectCode)
    {
        $result = Result::where('ic', $request->studentIc)->where('subjectCode',$subjectCode)->first();

        // Check if the result exists
        if (!$result) {
            return response()->json(['error' => 'Result not found'], 404);
        }

        // Update the fields exam1, exam2, and exam3 with the request data
        $result->exam1 = $request->input($request->subjectCode . '_exam1');
        $result->exam2 = $request->input($request->subjectCode . '_exam2');
        $result->exam3 = $request->input($request->subjectCode . '_exam3');

        // Save the updated result to the database
        $result->save();

        return redirect('marks');
    }
    // public function showMarking($year, $classCode, $subjectCode)
    // {
    //     $user = Auth::user();
    //     $className = myclass::where('classCode',$classCode)->first();
    //     if ($user && $user->role == 3) {
    //         // Get the subject details (assuming only one subject is retrieved)
    //         $subject = Subject::where('subjectCode', $subjectCode)->first();
    //         $students = User::with('studentClass') // Eager load the studentClass relationship
    //             ->where('year', $year)
    //             ->where('classCode', $classCode)
    //             ->where('role', 1) // Assuming role 1 represents students
    //             ->get();

    //         return view('markSubject', ['subject' => $subject, 'students' => $students,'year'=>$year,'className'=>$className    ]); // Pass students and subject to the view
    //     } else {
    //         return redirect('');
    //     }
    // }
}
