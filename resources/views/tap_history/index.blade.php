@extends('layouts.admin')
@section('page-title')
    {{ __('NFC History') }}
@endsection
@section('title')
    {{ __('NFC History') }}
@endsection

@section('content')
    <div class="col-sm-12 col-lg-12 col-xl-12 col-md-12">
       
    </div>
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body table-border-style ">
                <h5></h5>
                <div class="table-responsive">
                    <table class="table" id="">
                        <thead>
                            <th>#</th>
                            <th>{{__('Business Card')}} </th>
                           
							<th>{{__('OS Name')}} </th>
                            <th>{{__('Browser')}} </th>
							<th>{{__('Date')}} </th>
                            
                           
                          
                        </thead>
                        <tbody>
                        @foreach ($userlogdetail->reverse() as $userlogs)
                        
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ $userlogs->url }}</td>
                               
                                <td>{{ $userlogs->platform }}</td>
                                <td>{{ $userlogs->browser }}</td>
                                <td>{{ $userlogs->created_at }}</td>
                                
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('script-page')


@endpush