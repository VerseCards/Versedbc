<?php

namespace App\Exports;

use App\Models\Contacts;
use App\Models\Business;
use App\Models\User;
use App\Models\ActivityLog;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Carbon\Carbon;


class ActivityExport implements FromCollection,WithHeadings, WithEvents, WithColumnFormatting
{
    /**
    * @return \Illuminate\Support\Collection
    */
    	public function headings():array{
        return[
		

            'Action',
            'Remark',
            'Date',
        ];
    }
    public function collection()
    {
				if (session()->has('impersonate')) {
					$getOwner = session()->get('impersonate');
					$cardOwner = User::find($getOwner)->id;
					$leads_contacts =  ActivityLog::orderBy('created_at', 'DESC')->get();
				}else{
					$leads_contacts =  ActivityLog::orderBy('created_at', 'DESC')->get();
				}
		
                foreach ($leads_contacts  as $k => $contact) {
					//dd($contact);
					$newdate               = $contact->created_at->format('Y-m-d');
					unset($contact->created_by,$contact->id,$contact->business_id,$contact->updated_at,$contact->status, $contact->note, $contact->user_id , $contact->created_at,);
					
                    //$business_name = Business::where('id',$value->business_id)->pluck('title')->first();
                    //$contact->business_name = $business_name;
					$leads_contacts[$k]["joined"]                = $newdate;
					$leads_contacts[$k]["name"]                = $contact->name;
					$leads_contacts[$k]["remark"]                = $contact->remark;
					

			
                }
        return $leads_contacts;
    }
	
	public function columnFormats(): array
    {
        return [
            
            'H' => NumberFormat::FORMAT_TEXT,
            
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
