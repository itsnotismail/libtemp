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
                                <button class="btnUpdate btn btn-info btn-sm float-right" type="button">Pay</button></td>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" id="updateDataModal">
        <div class="modal-dialog">
            <form id="updateDataForm">
            <div class="modal-content">
    
                <div class="modal-header">
                <h4 class="modal-title">Update Late Fine</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="updateDataID" name="id"/>
                    <div class="row">
                        <div class="col"><label class="col-form-label d-table-row">Payment Type</label>
                            <select class="form-select" aria-label="Default select example" id="updateType" name="PaymentType">
                                <option value="Cash">Cash</option>
                                <option value="Card">Card</option>
                                <option value="Transfer">Transfer</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-info btn-sm" type="submit">Pay</button>
                </div>
            </div>
            </form>
        </div>
    </div>
    
</div>

@endsection
@push('scripts')
<script>
$( document ).ready(function() {
$('#tbl').DataTable();


$(".btnUpdate").click(function(){
    var tr = $(this).closest('tr');
    $("#updateDataID").val(tr.data('id'));
    $("#updateType").val(tr.data('book'));
    $("#updateDataModal").modal('show');
});

$("#updateDataForm").submit(function(e){
        e.preventDefault();
        var form = $('#updateDataForm')[0];
        var data = new FormData(form);
        data.append('_token', $("meta[name='csrf-token']").attr('content'));
        $.ajax({
            type: "POST",
            url: "{{URL::to('/')}}/lateReturns/update",
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            success: function (data) {
                    if (data.error) {
                        swal(data.error, "", "error")
                    } else {
                        swal("Late Fine Updated!", "", "success").then((value) => {
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