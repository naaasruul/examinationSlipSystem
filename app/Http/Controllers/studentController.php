<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\myclass;
use App\Models\Result;
use App\Models\User;
use Illuminate\Auth\Middleware\AuthenticateWithBasicAuth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage; // Include Storage facade if needed

class studentController extends Controller
{
    //

    public function showStudentMain(){
        $user=Auth::user();
        $studentClass = myclass::where('id',$user->classCode)->first();
        $teachers = User::where('classCode',$user->classCode)->where('role',3)->get();

        $allStudent = User::where('classCode',$studentClass->id)->where('role',1)->get();
        if($user){
            return view('studentMain',[
                'user'=>$user,
                'allStudent'=>$allStudent,
                'class'=>$studentClass,
                'program'=>'',
                'teachers'=>$teachers
            ]);
        }else{
            return redirect('');
        }
    }

    
    public function editProfile(Request $request)
    {
        $user = Auth::user();  // Get the currently authenticated user
        if (!$user) {
            return redirect()->back()->with('error', 'User not authenticated.');
        }
        
        // Validate that the uploaded file is an image
        $request->validate([
            'profilePicture' => 'nullable|mimes:jpeg,jpg,png|max:2048', // Max size of 2MB
        ]);
    
        // Fetch the current user instance
        $currUser = User::where('ic', $user->ic)->first();
    
        // Check if the user has an existing profile picture
        if ($currUser->profilePicture) {
            $existingFilePath = public_path('assets/profile_pictures/' . $currUser->profilePicture);
            
            // Delete the existing profile picture if it exists
            if (file_exists($existingFilePath)) {
                unlink($existingFilePath); // Delete the file
            }
        }
        
        if ($request->hasFile('profilePicture')) {
            $profilePicture = $request->file('profilePicture');
            
            // Generate a unique filename for the uploaded image
            $filename = $user->ic . '_' . Str::random(5) . '_' . time() . '.' . $profilePicture->getClientOriginalExtension();
            
            // Move the uploaded file to the 'public/assets/profile_pictures' directory
            $profilePicture->move(public_path('assets/profile_pictures'), $filename);
            
            // Save the filename in the user's profilePicture field
            $currUser->profilePicture = $filename;
        }
        
        // Save the updated user data
        $currUser->save();
        
        // Redirect back to the profile page with a success message
        return redirect()->back()->with('success', 'Profile updated successfully.');
    }
    
    


    public function showStudentResult(){
        $user = Auth::user();
        $studentClass = myclass::where('id', $user->classCode)->first();
        if($user && $user->role == 1){

        }
        return view('studentResult',['user'=>$user,'class'=>$studentClass]);
    }

    public function result($studentId, $examType)
{
    // Authenticate the logged-in user
    $user = Auth::user();

    // Check if the user exists
    if ($user) {
        // Get the class information for the student based on their classCode
        $studentClass = MyClass::where('id', $user->classCode)->first();
        
        // Fetch the results and join the Subject table to get subject names
        $results = Result::where('ic', $user->ic)
            ->join('subjects', 'subjects.subjectCode', '=', 'results.subjectCode') // Join with Subject table
            ->select('results.*', 'subjects.subjectName') // Select all results and subjectName
            ->get();
        
        // If results exist
        if ($results) {
            // Initialize variables for calculations
            $totalMarks = 0;
            $totalSubjects = count($results);
            $passedSubjects = 0;

            // Calculate total marks, and count passed subjects
            foreach ($results as $result) {
                $marks = $result->{'exam' . $examType}; // Fetch the marks based on exam type
                $totalMarks += $marks;
                if ($marks >= 50) {
                    $passedSubjects++;
                }
            }

            // Calculate percentage
            $percentage = $totalMarks / ($totalSubjects * 100) * 100;

            // Pass summary data to the view
            return view('result', [
                'results' => $results, 
                'user' => $user, 
                'class' => $studentClass, 
                'examType' => $examType,
                'totalMarks' => $totalMarks,
                'totalSubjects' => $totalSubjects,
                'percentage' => $percentage,
                'passedSubjects' => $passedSubjects
            ]);
        }
    }

    // If no user is found, redirect to some default page or login page
    return redirect('/login')->with('error', 'Please log in to view your results.');
}


    public function showProgram($program)
{
    $user = Auth::user();
    $studentClass = myclass::where('id',$user->classCode)->first();
    $teachers = User::where('classCode',$user->classCode)->where('role',3)->get();

    $allStudent = User::where('classCode',$studentClass->id)->where('role',1)->get();
    if ($user) {
        // Return the full view for regular requests
        return view('studentMain', [
            'user' => $user, 
            'allStudent'=>$allStudent,
            'class' => $studentClass, 
            'program' => $program,
            'teachers'=>$teachers
        ]);
    } else {
        return redirect('');
    }
}

public function showStudentProfile(){
    $user = Auth::user();
    if($user){
        $studentClass = myclass::where('id', $user->classCode)->first();
        return view('studentProfile',['user'=>$user,'class' => $studentClass]);
    }else{
        return redirect('');
    }
}

}
