<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LeadContact;
use App\Models\LeadGeneration;
use App\Models\Business;
use App\Models\User;
use App\Models\Utility;
use App\Exports\LeadContactExport;
use App\Exports\LeadCampaignExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\LeadContactRequest;

class LeadContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id="")
    {
		
        $user=\Auth::user();
        $business_id=$user->current_business;
      
            if($business_id=="" || $business_id=="0"){
				if(\Auth::user()->type == 'company' && \Auth::user()->admin_status == 0){
					$contacts_deatails = LeadContact::where('created_by',\Auth::user()->creatorId())->get();
				}else{
					if (session()->has('impersonate')) {
						$getOwner = session()->get('impersonate');
						$cardOwner = User::find($getOwner)->id;
						$contacts_deatails = LeadContact::where('user_id',$cardOwner)->where('business_id',$business_id)->get();
					}else{
						$contacts_deatails = LeadContact::where('user_id',\Auth::user()->id)->where('business_id',$business_id)->get();
					}
					
				}
                foreach ($contacts_deatails as $key => $value) {
                    $business_name = Business::where('id',$value->business_id)->pluck('title')->first();
                    $value->business_name = $business_name;
                }
            }else{
				if(\Auth::user()->type == 'company' && \Auth::user()->admin_status == 0){
					$contacts_deatails = LeadContact::where('created_by',\Auth::user()->creatorId())->get();
				}else{
					if (session()->has('impersonate')) {
						$getOwner = session()->get('impersonate');
						$cardOwner = User::find($getOwner)->id;
						$contacts_deatails = LeadContact::where('user_id',$cardOwner)->where('business_id',$business_id)->get();
					}else{
						$contacts_deatails = LeadContact::where('user_id',\Auth::user()->id)->where('business_id',$business_id)->get();
					}
					
				}
				
				
                foreach ($contacts_deatails as $key => $value) {
                    $business_name = Business::where('id',$value->business_id)->pluck('title')->first();
                    $value->business_name = $business_name;
					
					//dd($value->created_at->format('d-m-Y'));
                }
            }
            return view('leadcontact.index',compact('contacts_deatails'));
        
    }
	
	
	public function campaign($id="")
    {
		
        $user=\Auth::user();
        $business_id=$user->current_business;
        
            if($business_id=="" || $business_id=="0"){
				//dd(1);
				if(\Auth::user()->type == 'company' && \Auth::user()->admin_status == 0){
					$contacts_deatails = LeadGeneration::where('created_by',\Auth::user()->creatorId())->get();
					$leadGenerations = LeadGeneration::where('created_by',\Auth::user()->creatorId())->get();
					//dd($contacts_deatails, $leadGenerations);
				}else{
					
					if (session()->has('impersonate')) {
						$getOwner = session()->get('impersonate');
						$cardOwner = User::find($getOwner)->id;
						
						$contacts_deatails = LeadGeneration::where('user_id',$cardOwner)->get();
						$leadGenerations = LeadGeneration::where('user_id',$cardOwner)->get();
						
					}else{
						$contacts_deatails = LeadGeneration::where('user_id',\Auth::user()->id)->get();
						$leadGenerations = LeadGeneration::where('user_id',\Auth::user()->id)->get();
					}
					
				}
				
				/*
				$leadGeneration_content = [];
					if (!empty($leadGenerations)) {
						
						foreach ($leadGenerations as $leadGeneration) {
							$reversed_content = array_reverse(json_decode($leadGeneration->content, true)); // true to decode as array
							$leadGeneration_content = array_merge($leadGeneration_content, $reversed_content);
						}
					}

				*/
				
				$leadGeneration_content = [];
				if (!empty($leadGenerations)) {
					foreach ($leadGenerations as $leadGeneration) {
						$content = json_decode($leadGeneration->content, true); // Decode content to an associative array
						foreach ($content as &$item) {
							$item['business_id'] = $leadGeneration->business_id; // Add business_id to each item
							$item['campaign_id'] = $leadGeneration->id; 
						}
						$reversed_content = array_reverse($content); // Reverse the content array
						$leadGeneration_content = array_merge($leadGeneration_content, $reversed_content); // Merge the reversed content into the main array
					}
					
					
				}

				
				//dd($leadGeneration_content);
                foreach ($contacts_deatails as $key => $value) {
                    $business_name = Business::where('id',$value->business_id)->pluck('title')->first();
					//dd($value);
                    $value->business_name = $business_name;
                }
            }else{
				//dd(2);
				if(\Auth::user()->type == 'company' && \Auth::user()->admin_status == 0){
					$contacts_deatails = LeadGeneration::where('created_by',\Auth::user()->creatorId())->get();
					$leadGenerations = LeadGeneration::where('created_by',\Auth::user()->creatorId())->get();
				}else{
					
					if (session()->has('impersonate')) {
						$getOwner = session()->get('impersonate');
						$cardOwner = User::find($getOwner)->id;
						
						$contacts_deatails = LeadGeneration::where('user_id',$cardOwner)->get();
						$leadGenerations = LeadGeneration::where('user_id',$cardOwner)->get();
						
					}else{
						$contacts_deatails = LeadGeneration::where('user_id',\Auth::user()->id)->get();
						$leadGenerations = LeadGeneration::where('user_id',\Auth::user()->id)->get();
					}
				}
			
				$leadGeneration_content = [];

				if (!empty($leadGenerations)) {
					foreach ($leadGenerations as $leadGeneration) {
						
						// Decode JSON content and handle possible errors
						$content = json_decode($leadGeneration->content, true); 
						
						if (json_last_error() === JSON_ERROR_NONE && is_array($content)) {
							foreach ($content as &$item) { // Use reference to modify the original item
								$item['business_id'] = $leadGeneration->business_id; // Add business_id to each item
								$item['campaign_id'] = $leadGeneration->id; // Add campaign_id to each item
							}
							
							$reversed_content = array_reverse($content); // Reverse the content array
							$leadGeneration_content = array_merge($leadGeneration_content, $reversed_content); // Merge the reversed content into the main array
						} else {
							// Handle the error case
							
							error_log("JSON decoding failed or content is not an array for lead generation ID: " . $leadGeneration->id);
						}
					}
				}
				

            }
            return view('leadcontact.campaign',compact('contacts_deatails', 'leadGeneration_content'));
}
	
	
	public function campaignByLead($id="", $business_id_key = '')
    {
		
        $user=\Auth::user();
        $business_id=$user->current_business;
		$leadGeneration = LeadGeneration::where('business_id',$business_id_key)->first();
		if ($leadGeneration) {
            // Decode the JSON content
            $content = json_decode($leadGeneration->content, true);

            // Check if JSON decoding was successful and $content is an array
            if (json_last_error() === JSON_ERROR_NONE && is_array($content)) {
                // Iterate over the array to find the item with the specified id
                foreach ($content as $item) {
                    if (isset($item['id']) && $item['id'] == $id) {
                        $campaign_name = $item['title'];
						//return response()->json($item);
                    }
                }
            }
        }
				//dd($item['title']);
            
				if(\Auth::user()->type == 'company' && \Auth::user()->admin_status == 0){
					$contacts_deatails = LeadContact::where('created_by',\Auth::user()->creatorId())->where('business_id', $business_id_key)->where('campaign_id',$id)->get();
					
				}else{
					if (session()->has('impersonate')) {
						$getOwner = session()->get('impersonate');
						$cardOwner = User::find($getOwner)->id;
						
						$contacts_deatails = LeadContact::where('user_id',$cardOwner)->where('business_id', $business_id_key)->where('campaign_id',$id)->get();
						
						
					}else{
						$contacts_deatails = LeadContact::where('user_id',\Auth::user()->id)->where('business_id', $business_id_key)->where('campaign_id',$id)->get();
						
					}
					
					
				}
				
                foreach ($contacts_deatails as $key => $value) {
                    $business_name = Business::where('id',$value->business_id)->pluck('title')->first();
                    $value->business_name = $business_name;
                }
           
            return view('leadcontact.campaign_lead',compact('contacts_deatails', 'id', 'campaign_name'));
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
		
        $business_id = $request->business_id;
        $business = Business::where('id',$business_id)->first();
//        $user = User::where('id',$business->created_by)->first();

        $contact = LeadContact::create([
            'business_id' => $request->business_id,
			'user_id' => $business->user_id,
			'campaign_title' => $request->campaign_name,
			'campaign_id' => $request->campaign_id,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'message' => $request->message,
            'created_by' => $business->created_by
        ]);
        return redirect()->back()->with('success',__('Sent Successfully.'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Appointment_deatail  $appointment_deatail
     * @return \Illuminate\Http\Response
     */
    public function edit(Contacts $Contacts,$id)
    {
        $Contacts = LeadContact::where('id',$id)->first();
        return view('contacts.edit',compact('Contacts'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Appointment_deatail  $appointment_deatail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contacts $Contacts,$id)
    {
        $validator = \Validator::make(
            $request->all(), [
                                'name' => 'required',
								'campaign_name' => 'required',
                                'email' => 'required',
                                'phone' => 'required|numeric',
                                'message' => 'required',
                            ]
        );
        if($validator->fails())
        {
            $messages = $validator->getMessageBag();

            return redirect()->back()->with('error', $messages->first());
        }
        $Contacts = LeadContact::where('id',$id)->first();
        $Contacts->name     = $request->name;
		$Contacts->campaign_name     = $request->campaign_name;
        $Contacts->email = $request->email;
        $Contacts->phone    = $request->phone;
        $Contacts->message  = $request->message;
        $Contacts->save();

        return redirect()->route('leadcontact.index')->with('success', __('Lead Successfully Updated.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Appointment_deatail  $appointment_deatail
     * @return \Illuminate\Http\Response
     */
    public function destroy(LeadContact $LeadContact,$id)
    {
        
            $contact = LeadContact::find($id);
			
            if($contact){
                $contact->delete();
                return redirect()->back()->with('success', __('Lead successfully deleted.'));
            }
            return redirect()->back()->with('error', __('Lead not found.'));
        

    }
    public function getCalenderAllData($id=null){

        $objUser          = \Auth::user();
        if($id== null){
            $appointents = Appointment_deatail::get();
        }else{
            $appointents = Appointment_deatail::where('business_id',$id)->get();
        }
        $arrayJson = [];
        foreach($appointents as $appointent)
        {
            $time = explode('-',$appointent->time);
            $stime = isset($time[0])?trim($time[0]).':00':'00:00:00';
            $etime = isset($time[1])?trim($time[1]).':00':'00:00:00';
            $start_date = date("Y-m-d",strtotime($appointent->date)).' '.$stime;
            $end_date = date("Y-m-d",strtotime($appointent->date)).' '.$etime;

            $arrayJson[] = [
                "title" =>'('.$stime .' - '. $etime.') '.$appointent->name .'-'. $appointent->getBussinessName(),
                "start" => $start_date,
                "end" => $end_date ,
                "app_id" => $appointent->id,
                "url" => route('appointment.details',$appointent->id),
                "className" =>  'bg-info',
                "allDay" => true,
            ];
        }
        return view('appointments.calender',compact('arrayJson'));

    }
    public function getAppointmentDetails($id){
        $ad = Appointment_deatail::find($id);
        return view('appointments.calender-modal',compact('ad'));
    }
    public function add_note($id){
        
        $contact= LeadContact::where('id',$id)->first();
        return view('leadcontact.add_note',compact('contact'));
    }
    public function note_store($id,Request $request){

            $contacts = LeadContact::where('id',$id)->first();
            $contacts->status = $request->status;
            $contacts->note = $request->note;
            $contacts->save();

            return redirect()->back()->with('Success', __('Remark added successfully.'));

    }
	
	public function get_lead_data()
    {
        return Excel::download(new LeadContactExport, 'leads.xlsx');
    }
	
	public function get_lead_data_campaign(Request $request)
    {
        return Excel::download(new LeadCampaignExport($request->id), 'leads.xlsx');
    }
}
