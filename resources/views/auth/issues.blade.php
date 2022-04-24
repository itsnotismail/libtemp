@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row" style="margin-bottom:0;margin-top:20px;">
        <div class="col-xl-10">
            <h3>Book Issue</h3>
        </div>
        <div class="col"><button class="btn btn-info float-right" type="button" id="btnNew" data-bs-toggle="modal" data-bs-target="#new">New</button></div>
    </div>
    
    <div class="row" style="margin-top:15px;">
        <div class="col">
            <div class="table-responsive">
                <table id="tbl" class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th>Book Name</th>
                            <th>Borrower Name</th>
                            <th>Issued Date</th>
                            <th>Due Date</th>
                            <th>Return Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $data)
                        <tr data-id="{{$data->id}}" data-book="{{$data->book->id}}" data-borrower="{{$data->borrower->id}}" data-issuedate="{{\Carbon\Carbon::parse($data->issue_date)->format('Y-m-d')}}" data-duedate="{{\Carbon\Carbon::parse($data->due_date)->format('Y-m-d')}}">
                            <td>{{$data->book->title}}</td>
                            <td>{{$data->borrower->name}}</td>
                            <td>{{\Carbon\Carbon::parse($data->issue_date)->format('d-M-y')}}</td>
                            <td>{{\Carbon\Carbon::parse($data->due_date)->format('d-M-y')}}</td>
                            <td>{{$data->return_date ? \Carbon\Carbon::parse($data->return_date)->format('d-M-y') : "-"}}</td>
                            <td><button class="btnDelete btn btn-danger btn-sm float-right" type="button" style="margin-left:5px;">Delete</button>
                                <button class="btnUpdate btn btn-secondary btn-sm float-right" type="button">Update</button></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" id="new">
        <div class="modal-dialog">
            <form id="newDataForm">
            <div class="modal-content">
    
                <div class="modal-header">
                <h4 class="modal-title">News Book Issue Record</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col"><label class="col-form-label d-table-row">Book Name</label>
                            <select class="form-select" aria-label="Default select example" name="Book">
                                <option selected>Select a Book</option>
                                @foreach($books as $book)
                                    <option value={{$book->id}}>{{$book->title}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col"><label class="col-form-label d-table-row">Borrower Name</label>
                            <select class="form-select" aria-label="Default select example" name="Borrower">
                                <option selected>Select a Borrower</option>
                                @foreach($borrowers as $borrower)
                                    <option value={{$borrower->id}}>{{$borrower->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col"><label class="col-form-label d-table-row">Issue Date</label>
                            <input class="form-control" type="date" name="IssueDate" ></div>
                    </div>
                    <div class="row">
                        <div class="col"><label class="col-form-label d-table-row">Due Date</label>
                            <input class="form-control" type="date" name="DueDate" ></div>
                    </div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-info btn-sm" type="submit">Save</button>
                </div>
            </div>
            </form>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" id="updateDataModal">
        <div class="modal-dialog">
            <form id="updateDataForm">
            <div class="modal-content">
    
                <div class="modal-header">
                <h4 class="modal-title">Update Book Issue</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="updateDataID" name="id"/>
                    <div class="row">
                        <div class="col"><label class="col-form-label d-table-row">Book Name</label>
                            <select class="form-select" aria-label="Default select example" id="updateBook" name="Book">
                                <option selected>Select a Book</option>
                                @foreach($books as $book)
                                    <option value={{$book->id}}>{{$book->title}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col"><label class="col-form-label d-table-row">Borrower Name</label>
                            <select class="form-select" aria-label="Default select example" id="updateBorrower" name="Borrower">
                                <option selected>Select a Borrower</option>
                                @foreach($borrowers as $borrower)
                                    <option value={{$borrower->id}}>{{$borrower->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col"><label class="col-form-label d-table-row">Issue Date</label>
                            <input class="form-control" type="date" id="updateIssueDate" name="IssueDate" ></div>
                    </div>
                    <div class="row">
                        <div class="col"><label class="col-form-label d-table-row">Due Date</label>
                            <input class="form-control" type="date" id="updateDueDate" name="DueDate" ></div>
                    </div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-info btn-sm" type="submit">Save</button>
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

$("#newDataForm").submit(function(e){
    e.preventDefault();
    var form = $('#newDataForm')[0];
    var data = new FormData(form);
    data.append('_token', $("meta[name='csrf-token']").attr('content')); //csrf token appending from layout blade
    $.ajax({
        type: "POST",
        url: "{{URL::to('/')}}/borrows/create",
        data: data,
        processData: false,
        contentType: false,
        cache: false,
        success: function (data) {
            if (data.error) {
                swal(data.error, "", "error")
            } else {
                swal("New Books Issued!", "", "success").then((value) => {
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

$(".btnUpdate").click(function(){
    var tr = $(this).closest('tr');
    $("#updateDataID").val(tr.data('id'));
    $("#updateBook").val(tr.data('book'));
    $("#updateBorrower").val(tr.data('borrower'));
    $("#updateIssueDate").val(tr.data('issuedate'));
    $("#updateDueDate").val(tr.data('duedate'));
    $("#updateDataModal").modal('show');
});


$("#updateDataForm").submit(function(e){
        e.preventDefault();
        var form = $('#updateDataForm')[0];
        var data = new FormData(form);
        data.append('_token', $("meta[name='csrf-token']").attr('content'));
        
        $.ajax({
            type: "POST",
            url: "{{URL::to('/')}}/borrows/update",
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            success: function (data) {
                    if (data.error) {
                        swal(data.error, "", "error")
                    } else {
                        swal("Borrower Updated!", "", "success").then((value) => {
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



$(".btnDelete").click(function(){
        var id = $(this).closest('tr').data('id');
        var data = new FormData();
        data.append('_token', $("meta[name='csrf-token']").attr('content'));
        data.append('id', id);
        $.ajax({
            type: "POST",
            url: "{{URL::to('/')}}/borrows/delete",
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