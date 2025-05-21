<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\ShiftSent;
use App\Models\Event;
use App\Models\Task;
use App\Models\Shift;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;


class AjaxController extends Controller
{
	public function shiftSubmit(Request $request) {
	
	    
		
		$data = request()->validate([
            'user_id' => 'required',
           	'shift_id' => 'required',
        ]);
        
        $shift = Shift::where('id',$data['shift_id'])
        			->update([
        			'user_id'=>$data['user_id'],
        			'is_sent' => 1,
        			
        			]);
        $user = User::where('id',$data['user_id'])->first();
        
        		
        			
        Mail::to($user->email)->send(new ShiftSent());
    
    	return response()->json(['success'=>'Got Simple Ajax Request.']);
       /* return redirect()->route('home')
                        ->with('success','Shift created successfully.');
		*/
		}
	
    public function sorting(Request $request)
    {
    	$position = $request->post('position');
	    $i=1;
    	// Update Orting Data 
		foreach($position as $k=>$v)
		{
			 $task = Task::where('id',$v)->update(['position'=> $i]); 
  
			 $i++;

   		 }
	}

}
    
    
    
    
    
	

