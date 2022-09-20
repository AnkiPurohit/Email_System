@extends('../layouts/page')

@section('content')
<div class="container p-3 ">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">Email Templates</div>


                <div class="card-body">

                    @if (session()->has('message'))

                    <div class="alert alert-success">

                        {{ session('message') }}

                    </div>

                    @endif

                    <a class="btn btn-secondary create-btn" style="float: right" href="{{route('email-templates.create')}}"><i class="fa fa-plus"></i> Create</a>
                    <table class="table table-stripped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Subject</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($emailTemplates as $item)
                            <tr>
                                <td>{{$item->id}}</td>
                                <td>{{$item->name}}</td>
                                <td>{{$item->subject}}</td>
                                <td>
                                    <a href="{{url('email-templates/edit/'. $item->id)}}" class="btn btn-sm btn-outline-info btn-edit"><i class="fa fa-edit"></i> Edit</a>
                                </td>
                                <td>
                                    <form method="post" action="{{url('email-templates/delete/'. $item->id)}}" wire:submit.prevent="{{url('email-templates/delete/'. $item->id)}}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('are you sure?')"><i class="fa fa-remove"></i> Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4">No mail templates</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>


                </div>
            </div>
        </div>
    </div>

</div>



@endsection