<?php

namespace App\Http\Controllers;

use App\Models\Course;

class CourseDetailController extends Controller
{
    public function show(Course $course)
    {
        // Carrega a unidade orgânica, as linhas de pesquisa do curso e os docentes de cada linha
        $course->load(['organicUnit', 'researchLines.researchers']);

        return view('courses.show', compact('course'));
    }
}