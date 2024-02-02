<?php

namespace App\Http\Controllers;

use App\Models\MjuStudent;
use Illuminate\Http\Request;
use App\Http\Requests\StoreMjuStudentRequest;
use App\Http\Requests\UpdateMjuStudentRequest;
use App\Http\Requests\showMjuStudentRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MjuStudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Mjustudent::all();
        return $students;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validated = $request->validate([
            'student_code' => 'required|string|max:15',
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'first_name_en' => 'required|string|max:50',
            'last_name_en' => 'required|string|max:50',
            'major_id' => 'required|exists:majors,major_id',
            'idcard' => 'required||digits:13',
            'address' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|email',
        ]);
        MjuStudent::create($validated);

        return response()->json(['message' => 'Student created successfully'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function showdata()
    {
        $mjuStudent = DB::table('mju_students')->first();

        return response()->json([
            'message' => 'Successfully show data',
            'data' => $mjuStudent
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MjuStudent $mjuStudent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function updatedata(Request $request, MjuStudent $mjuStudent, $variable)
    {
    // ตรวจสอบว่ามีการใช้ || แทน | ใน 'idcard' => 'required||digits:13'
    $validated = $request->validate([
        'student_code' => 'required|string|max:15',
        'first_name' => 'required|string|max:50',
        'first_name_en' => 'required|string|max:50',
        'major_id' => 'required|exists:majors,major_id',
        'idcard' => 'required|digits:13',
        'address' => 'required|string',
        'phone' => 'required|string',
        'email' => 'required|email',
    ]);
    log::info($variable);

    $mjuStudent->update($validated);

    $updatedRows = DB::table('mju_students')
    ->where('student_code', $variable)
    ->orWhere('first_name', $variable)
    ->orWhere('first_name_en', $variable)
    ->orWhere('major_id', $variable)
    ->orWhere('idcard', $variable)
    ->orWhere('address', $variable)
    ->orWhere('phone', $variable)
    ->orWhere('email', $variable)
    ->update([
        'student_code' => $validated['student_code'],
        'first_name' => $validated['first_name'],
        'first_name_en' => $validated['first_name_en'],
        'major_id' => $validated['major_id'],
        'idcard' => $validated['idcard'],
        'address' => $validated['address'],
        'phone' => $validated['phone'],
        'email' => $validated['email'],
    ]);

// แก้ไขการใช้งาน JSON response
return response()->json(['message' => 'Student updated successfully', 'data' => $updatedRows], 200);

}


    /**
     * Remove the specified resource from storage.
     */
    public function deletedata(MjuStudent $mjuStudent, $variable)
    {
        $deleterow = DB::table('mju_students')
        ->where('student_code', $variable)
        ->orWhere('first_name', $variable)
        ->orWhere('first_name_en', $variable)
        ->orWhere('major_id', $variable)
        ->orWhere('idcard', $variable)
        ->orWhere('address', $variable)
        ->orWhere('phone', $variable)
        ->orWhere('email', $variable)
        ->delete();

    return response()->json(['message' => 'Student delete successfully', 'data' => $deleterow], 200);
    }
}
