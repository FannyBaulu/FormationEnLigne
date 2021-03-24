<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Episode;
use App\Models\User;
use App\Youtube\YoutubeServices;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;

class CourseController extends Controller
{
    /**
     * Listing courses, integrating informations regarding episodes, course's author,
     * duration of the courses, number of participants
     * 
     */
    public function index(){
        $courses= Course::with('user')
        ->select('courses.*',DB::raw(
            '(SELECT COUNT(DISTINCT(user_id))
            FROM completions
            INNER JOIN episodes ON completions.episode_id = episodes.id
            WHERE episodes.course_id =courses.id
            ) AS participants'
        ))->addSelect(DB::raw(
            '( SELECT SUM(duration)
            FROM episodes
            WHERE episodes.course_id = courses.id
             ) AS total_duration'
        ))
        ->withCount('episodes')->latest()->paginate(9);
        
        return Inertia::render('Courses/Index',[
            'courses'=> $courses,
        ]);
    }

    /**
     * Showing detailed informations regarding one course, including it's episodes,
     * taking into account which episodes have been watched by the authenticated user.
     *
     * @param [type] $id
     * 
     */
    public function show($id){
        $course = Course::where('id',$id)->with('episodes')->first();
        $watched =auth()->user()->episodes;
        return Inertia::render('Courses/Show',[
            'course'=> $course,
            'watched' => $watched,
        ]);
    }

    /**
     * Receiving and using request informations to create a course in the database
     * via the model Course. Also using the service YoutubeServices to calculate the duration
     * of the course and insert it in the database.
     *
     * @param Request $request
     * @param YoutubeServices $ytb
     */
    public function store(Request $request, YoutubeServices $ytb){

        $request->validate([
            'title'=> 'required',
            'description'=> 'required',
            'episodes'=> ['array','required'],
            'episodes.*.title'=> 'required',
            'episodes.*.description'=> 'required',
            'episodes.*.video_url'=> 'required',
        ]);

        $course = Course::create($request->all());

        foreach ($request->input('episodes')as $episode){
            $episode['course_id']=$course->id;
            $episode['duration']=$ytb->handleYoutubeVideoDuration($episode['video_url']);

            Episode::create($episode);
        }

        return Redirect::route('dashboard')->with('success','Félicitation, la formation a bien été mise en ligne');
    }

    public function edit($id){
        $course = Course::where('id',$id)->with('episodes')->first();
        $this->authorize('update',$course);
        return Inertia::render('Courses/Edit',[
            'course'=> $course
        ]);

    }

    /**
     * Updating every parameters of the course, including the episodes linked to it,
     * and the duration of the course.
     *
     * @param Request $request
     * @param YoutubeServices $ytb
     */
    public function update(Request $request,YoutubeServices $ytb){
        
        $course = Course::where('id',$request->id)->with('episodes')->first();
        $this->authorize('update',$course);
        $course->update($request->all());
        $course->episodes()->delete();

        foreach ($request->episodes as $episode){
            $episode['course_id']=$course->id;
            $episode['duration']=$ytb->handleYoutubeVideoDuration($episode['video_url']);
            Episode::create($episode);
        }

        return Redirect::route('courses')->with('success','Félicitation, la formation a bien été mise à jour');
    }

    /**
     * Stock/unstock the episode selected by the user in the completion table in the database the toggle method.
     * Allowing it to keep track of watched episodes.
     *
     * @param Request $request
     */
    public function toggleProgress(Request $request){
        $id= $request->input('episodeId');
        $user = Auth::user();
        $user->episodes()->toggle($id);
        return $user->episodes;
    }
}
