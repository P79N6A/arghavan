<?php

namespace App\Http\Controllers;

use App\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function show(Teacher $teacher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function edit(Teacher $teacher)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Teacher $teacher)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function destroy(Teacher $teacher)
    {
        //
    }

     public function teacherChart()
    {
        $labels = [];
        $series = [];
        $group_id = \App\People::$GROUP_STAFFS;
        $res_all = \App\User::where('group_id', $group_id)
                            ->whereHas('people')
                            ->join('teachers', 'teachers.user_id', 'users.id')
                            ->count();
       $labels[] = "کل";
       $series[] = $res_all;

        $res_has_card = \App\User::where('group_id', $group_id)
                                ->whereHas('people')
                                ->whereHas('cards')
                                ->join('teachers', 'teachers.user_id', 'users.id')
                                ->count();
        $labels[] = "دارای کارت";
        $series[] = $res_has_card;

       $res_Dont_have_card = \App\User::where('group_id', $group_id)
                                        ->whereHas('people')
                                        ->whereDoesntHave('cards')
                                        ->join('teachers', 'teachers.user_id', 'users.id')
                                        ->count();
        $labels[] = "بدون کارت";
        $series[] = $res_Dont_have_card;

        $output = [
            'labels' => $labels,
            'series' => $series
        ];
        return $output;
    }
}
