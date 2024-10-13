<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\myclass;
use App\Models\Result;
use App\Models\User;
use App\Models\Subject;
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
        return redirect('adminProfile');

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
            
            return redirect()->back()->with('success', 'Class and associated students deleted successfully!');
        }
    
        return redirect()->back()->with('error', 'Class not found.');
    }
    

    public function deleteTeacher($teacheric)
{
    // Find the teacher
    $teacher = User::where('ic', $teacheric)->first();

    if ($teacher) {
        $teacher->delete();
        return redirect()->back()->with('success', 'Teacher deleted successfully');
    }

}



    // EDIT CLASS
    public function editClass(Request $request, $classCode)
    {
        $user = Auth::user();
        $selectedClass = myclass::where('classCode', $classCode)->first();
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
        $students = User::where('classCode', $classid)->where('role', 1)->with('studentClass')->get();
        return view('studentOfClass_admin', ['students' => $students]);
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
        return redirect('manageStudent')->with('error', 'Student not found.');
    }

    // Delete associated results
    Result::where('ic', $studentIc)->delete();

    // Delete the student
    $student->delete();

    // Redirect back to manage students page with a success message
    return redirect('manageStudent')->with('success', 'Student deleted successfully.');
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
