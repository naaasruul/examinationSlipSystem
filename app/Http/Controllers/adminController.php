<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\myclass;
use App\Models\Result;
use App\Models\User;
use App\Models\Subject;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Colors\Rgb\Channels\Red;
use PDO;

class adminController extends Controller
{
    //
    public function showAdminMain()
    {
        $user = Auth::user();
        $classes = myclass::all();
        if ($user) {
            return view('adminMain', ['user' => $user, 'program' => '', 'classes' => $classes]);
        } else {
            return redirect('');
        }
    }

    public function showAdminProgram($program)
    {
        $user = Auth::user();
        $teacher = User::all()->where('role', 3);
        if ($user) {
            return view('adminMain', ['user' => $user, 'program' => $program, 'teachers' => $teacher]);
        } else {
            return redirect('');
        }
    }

    public function showManageStudent()
    {
        $user = Auth::user();
        if ($user) {
            $students = User::all()->where('role', 1);
            return view('manageStudent', ['user' => $user, 'students' => $students, 'selectedStudent' => null]);
        } else {
            return redirect('');
        }
    }



    // ADMIN PROFILE
    public function showAdminProfile()
    {
        $user = Auth::user();
        if ($user && $user->role == 2) {
            return view('adminProfile', ['user' => $user]);
        } else {
            return redirect('');
        }
    }

    
    public function editProfileAdmin(Request $request, $adminId){
        // Find the admin by their IC (adminId)
        $admin = User::where('ic', $adminId)->first();

        $admin->name = $request->profileName;
        $admin->phone_number = $request->profilePhoneNumber;
        $admin->address = $request->profileAddress;
        // Save the changes to the database
        $admin->save();

        // Add a success message to the session
        session()->flash('success', 'Profile updated successfully.');

        if ( $admin->role == 2) {
            return redirect('adminProfile');
        }

        if ($admin->role == 1){
            return redirect("studentProfile");
        }

        if ($admin->role == 3){
            return redirect("teacherProfile");
        }

    }
    

    // CLASS
    public function showManageClass()
    {
        $user = Auth::user();
        if ($user) {
            $teachers = User::where('role', 3)->get();
            $myClasses = MyClass::all();  // Fetch all classes
            return view('manageClass', ['user' => $user, 'teachers' => $teachers, 'classes' => $myClasses]);
        } else {
            return redirect()->route('login');
        }
    }

    public function destroy($classCode)
    {
        $class = myclass::with('users')->where('classCode', $classCode)->first(); // Load students with class
    
        if ($class) {
            // Delete associated students
            $class->users()->delete();
            // Delete the class
            $class->delete();
            
            return redirect()->route('manageClass')->with('success', 'Class and associated students deleted successfully!');
        }
    
        return redirect()->route('manageClass')->with('error', 'Class not found.');
    }


    public function deleteTeacher($teacheric)
{
    // Find the teacher
    $teacher = User::where('ic', $teacheric)->first();

    if ($teacher) {
        $teacher->delete();
        return redirect()->route('manageTeacher')->with('success', 'Teacher deleted successfully');
    }

}

    
// SHOW REPORT
public function showReport(){
    return view('adminReport');
}
public function monitor(Request $request)
{
    // Fetch all years and subjects for the form
    $years = myclass::distinct()->pluck('year'); // Fetch distinct years
    $subjects = Subject::all(); // Assuming there's a Subject model

    // Check if class and subject are provided
    if ($request->has('class') && $request->has('subject')) {
        // Fetch the selected class and subject
        $selectedClass = myclass::find($request->class);
        $selectedSubject = Subject::find($request->subject);

        // Get students in the selected class
        $students = User::where('classCode', $selectedClass->id)->get();

        // Initialize an array to store success data
        $successData = [];

        // Iterate over each student
        foreach ($students as $student) {
            // Fetch the student's result for the selected subject
            $result = Result::where('ic', $student->ic)
                            ->where('subjectCode', $selectedSubject->subjectCode)
                            ->first();

            // Calculate the success rate (average of exam1, exam2, exam3)
            if ($result) {
                $averageScore = ($result->exam1 + $result->exam2 + $result->exam3) / 3;
            } else {
                $averageScore = 0; // Default to 0 if no result found
            }

            // Prepare data for the view
            $successData[] = [
                'name' => $student->name,
                'percentage' => $averageScore, // Store the average score as success rate
            ];
        }

        // Return the data to the 'adminReport' view
        return view('adminReport', compact('successData', 'selectedClass', 'selectedSubject', 'years', 'subjects'));
    }

    // If no class or subject is selected, return the view with only years and subjects
    return view('adminReport', compact('years', 'subjects'));
}


public function getClasses(Request $request)
{
    // Fetch classes based on the selected year
    $classes = MyClass::where('year', $request->year)->get();

    // Return the classes as JSON for the AJAX request
    return response()->json($classes);
}








    // EDIT CLASS
    public function editClass(Request $request, $classCode)
    {
        $user = Auth::user();
        $selectedClass = myclass::where('id', $classCode)->first();
        if (!$selectedClass) {
            return 'error';
        }
        // Update student information
        $selectedClass->className = $request->className;
        // Save the student
        $selectedClass->save();
        return redirect('manageClass');
    }

    public function showStudentOfClass($classid)
    {
        $selectedClass = myclass::find($classid); // Assuming 'ClassModel' is your class model
        $students = User::where('classCode', $classid)->where('role', 1)->with('studentClass')->get();
        return view('studentOfClass_admin', ['students' => $students, 'class'=>$selectedClass]);
    }
// DELETE STUDENT
public function deleteStudent($studentIc)
{
    // Get the currently authenticated user
    $user = Auth::user();
    if (!$user) {
        return redirect('')->with('error', 'User not authenticated.');
    }

    // Find the student by IC
    $student = User::where('ic', $studentIc)->first();

    // Check if the student exists
    if (!$student) {
        return redirect()->route('manageStudent')->with('error', 'Student not found.');
    }

    // Delete associated results
    Result::where('ic', $studentIc)->delete();

    // Delete the student
    $student->delete();

    // Redirect back to manage students page with a success message
    return redirect()->route('manageStudent')->with('success', 'Student deleted successfully.');
}

    // ADD STUDENT
    public function addStudent(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect('');
        }

        $request->validate([
            'newStudentName' => 'required',
            'newStudentYear' => 'required',
            'newStudentClass' => 'required',
            'newStudentIc' => 'required',
            'newStudentPassword' => 'required',
        ]);

        // First, find the class record based on the year and classCode
        $class = myclass::where('year', $request->newStudentYear)
            ->where('classCode', $request->newStudentClass)
            ->first();

        $addUser = User::create([
            'ic' => $request->newStudentIc,
            'name' => $request->newStudentName,
            'password' => Hash::make($request->newStudentPassword),
            'role' => 1,
            'year' => $request->newStudentYear,
            'classCode' => $class->id,
            'newStudentIc' => $request->newStudentIc,
            'phone_number' => $request->newStudentPhoneNumber,
            'address' => $request->newStudentAddress
        ]);

        $listOfSubject = Subject::all();

        foreach ($listOfSubject as $subject) {
            Result::create([
                'ic' => $request->newStudentIc,   // Student IC
                'subjectCode' => $subject->subjectCode  // Assuming `subjectCode` is a field in your `Subject` model
            ]);
        }



        if ($addUser) {
            return redirect('manageStudent');
        }
    }

    // ADD TEACHER
    public function addTeacher(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect(''); // Redirect to a suitable location if user is not authenticated
        }

         // First, find the class record based on the year and classCode
         $class = myclass::where('year', $request->newYear)
         ->where('classCode', $request->newTeacherClass)
         ->first();


         $teacher = User::create([
            'ic' => $request->newTeacherIc,
            'name' => $request->newTeacherName,
            'password' => Hash::make($request->newTeacherPassword),
            'role' => 3, // Assuming 3 is for teachers
            'year' => $request->newYear,
            'classCode' => $class->id,
            'phone_number' => $request->newTeacherPhone,
            'address' => $request->newTeacherAddress
        ]);

                 

            // Attach selected subjects
            $teacher->subjects()->attach($request->newTeacherSubjects);
            return redirect()->route('manageTeacher')->with('success', 'Teacher added successfully!');
    }


    public function editStudent($studentIc)
    {
        $user = Auth::user();
        $students = User::all()->where('role', 1);
        if (!$user) {
            return redirect('');
        }
        $selectedStudent = User::where('ic', $studentIc)->first();
        $selectedClass = myclass::where('id',$selectedStudent->classCode)->first();
        return view('manageStudent', ['user' => $user, 'students' => $students, 'selectedStudent' => $selectedStudent, 'selectedClass' => $selectedClass]);
    }
    public function updateStudent(Request $request, $studentIc)
    {
        $student = User::where('ic', $studentIc)->first();
        if (!$student) {
            return 'error';
        }

        $class = myclass::where('year', $request->editStudentYear)
            ->where('classCode', $request->editStudentClass)
            ->first();
        // Update student information
        $student->name = $request->editStudentName;
        $student->year = $request->editStudentYear;
        $student->classCode = $class->id;
        $student->ic = $request->editStudentIc;
        $student->phone_number = $request->editStudentPhoneNumber;
        $student->address = $request->editStudentAddress;

        // Save the student
        $student->save();

        // Redirect to the edit page
        return redirect()->route('edit-student', ['studentIc' => $studentIc]);
    }

    public function showManageTeacher()
    {
        $user = Auth::user();
        if ($user) {
            $teachers = User::all()->where('role', 3);
            $subjects = Subject::all();
            return view('manageTeacher', ['user' => $user, 'teachers' => $teachers, 'subjects' => $subjects,'selectedTeacher' => null]);
        } else {
            return redirect('');
        }
    }
    public function editTeacher($teacheric)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect(''); // Redirect if user is not authenticated
        }
    
        // Retrieve all teachers with role 3
        $teachers = User::where('role', 3)->get();
        
        // Find the selected teacher by IC
        $selectedTeacher = User::with('subjects')->where('ic', $teacheric)->first();
        if (!$selectedTeacher) {
            return redirect()->back()->with('error', 'Teacher not found.'); // Handle if teacher not found
        }
        
        // Get the class associated with the selected teacher
        $selectedClass = myclass::where('id', $selectedTeacher->classCode)->first();
        
        // Get all available subjects
        $subjects = Subject::all();
        
        // Pass data to the view
        return view('manageTeacher', [
            'user' => $user,
            'teachers' => $teachers,
            'selectedTeacher' => $selectedTeacher,
            'selectedClass' => $selectedClass,
            'subjects' => $subjects,
        ]);
    }
    

    public function updateTeacher(Request $request, $teacheric)
    {
        $teacher = User::where('ic', $teacheric)->first();
        if (!$teacher) {
            return 'error';
        }

        

        $class = myclass::where('year', $request->editStudentYear)
            ->where('classCode', $request->editStudentClass)
            ->first();
        // Update student information
        $teacher->name = $request->editStudentName;
        $teacher->year = $request->editStudentYear;
        $teacher->classCode = $class->id;
        $teacher->ic = $request->editStudentIc;
        $teacher->phone_number = $request->editStudentPhoneNumber;
        $teacher->address = $request->editStudentAddress;

        // Save the student
        $teacher->save();

        // Detach old subjects
        $teacher->subjects()->detach();

        // Attach new subjects
        $teacher->subjects()->attach($request->editTeacherSubjects);

        // Redirect to the edit page
        return redirect()->route('edit-teacher', ['teacheric' => $teacheric]);
    }

    
}
