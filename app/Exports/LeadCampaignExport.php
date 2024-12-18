<?php

namespace App\Exports;

use App\Models\LeadContact;
use App\Models\LeadGeneration;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithMapping;


class LeadCampaignExport implements FromCollection,WithHeadings, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
	
		protected $id;
		function __construct($id){
			$this->id = $id;
		}
    	public function headings():array{
        return[
		
            'Campaign Title',
            'Name',
            'Email',
			'Phone',
			'Message',
            'Created_at',
            
        ];
    }
    public function collection()
    {
				if (session()->has('impersonate')) {
					$getOwner = session()->get('impersonate');
					$cardOwner = User::find($getOwner)->id;
					$leads_contacts = LeadContact::where('campaign_id', $this->id)->where('user_id',$cardOwner)->get();
				}else{
					$leads_contacts = LeadContact::where('campaign_id', $this->id)->where('user_id',\Auth::user()->id)->get();
				}
		
                foreach ($leads_contacts  as $k => $contact) {
					$newdate               = $contact->created_at->format('Y-m-d');
					unset($contact->created_by,$contact->id,$contact->campaign_id,$contact->business_id,$contact->updated_at,$contact->status, $contact->note, $contact->user_id );
					
                    //$business_name = Business::where('id',$value->business_id)->pluck('title')->first();
                    //$contact->business_name = $business_name;
					$leads_contacts[$k]["campaign_title"]                = $contact->campaign_title;
					$leads_contacts[$k]["name"]                = $contact->name;
					$leads_contacts[$k]["email"]                = $contact->email;
					$leads_contacts[$k]["phone"]                = $contact->phone . " ";
					$leads_contacts[$k]["message"]                = $contact->message;
					//$leads_contacts[$k]["status"]                = $contact->status;
					//$leads_contacts[$k]["note"]                = $contact->note;
					$leads_contacts[$k]["date"]                = $newdate;
                }
        return $leads_contacts;
    }
	
	public function columnFormats(): array
    {
        return [
            
            'F' => NumberFormat::FORMAT_DATE_DDMMYYYY,

        ];
    }
	
	public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
   
                $event->sheet->getDelegate()->getRowDimension('1')->setRowHeight(20);
                $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(25);
				
                $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(25);
				
                $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(35);
				
                $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(25);
				
                $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(35);
				
                $event->sheet->getDelegate()->getColumnDimension('F')->setWidth(25);
				$event->sheet->getDelegate()->getStyle('A1:F1')->getFont()->setBold(true);
     
            },
        ];
    }
}
