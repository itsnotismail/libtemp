@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row" style="margin-bottom:0;margin-top:20px;">
        <div class="col-xl-10">
            <h3>Book Return</h3>
        </div>
    </div>
    <div class="row" style="margin-top:15px;">
        <div class="col">
            <div class="table-responsive">
                <table id="tbl" class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th>Borrower Name</th>
                            <th>Book Name</th>
                            <th>Issued Date</th>
                            <th>Due Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $data)
                        <tr data-id="{{$data->id}}" data-book="{{$data->book->id}}" data-borrower="{{$data->borrower->id}}" data-issueDate="{{$data->issue_date}}" data-dueDate="{{$data->due_date}}">
                            <td>{{$data->borrower->name}}</td>
                            <td>{{$data->book->title}}</td>
                            <td>{{\Carbon\Carbon::parse($data->issue_date)->format('d-M-y')}}</td>
                            <td>{{\Carbon\Carbon::parse($data->due_date)->format('d-M-y')}}</td>
                            <td>
                                <button class="btnDelete btn btn-info btn-sm float-right" type="button" style="margin-left:5px;">Return</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection


@push('scripts')
<script>
$( document ).ready(function() {
    
$('#tbl').DataTable();



    $(".btnDelete").click(function(){
        var id = $(this).closest('tr').data('id');
        var data = new FormData();
        data.append('_token', $("meta[name='csrf-token']").attr('content'));
        data.append('id', id);
        $.ajax({
            type: "POST",
            url: "{{URL::to('/')}}/bookReturns/update",
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            success: function (data) {
            if (data.error) {
                swal(data.error, "", "error")
            } else {
                swal("Book Issued Deleted!", "", "success").then((value) => {
                    window.location.reload();
                });
            }
            },
            error: function (error) {
                if(error.responseJSON?.message){
                    swal(error.responseJSON.message, "", "error");   
                } else {
                    swal("Something went wrong!", "", "error");
                }
            }
        });
    });

});

</script>
@endpush