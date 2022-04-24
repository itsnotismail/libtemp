@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row" style="margin-bottom:0;margin-top:20px;">
        <div class="col-xl-10">
            <h3>Users</h3>
        </div>
    </div>
    <div class="row" style="margin-top:15px;">
        <div class="col">
            <div class="table-responsive">
                <table id="tbl" class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Staff ID</th>
                            <th>Phone Number</th>
                            <th>Username</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $data)
                        <tr data-id="{{$data->id}}" data-name="{{$data->name}}" data-staffid="{{$data->staff_id}}" data-phonenumber="{{$data->phone_number}}" data-username="{{$data->username}}">
                            <td>{{$data->name}}</td>
                            <td>{{$data->staff_id}}</td>
                            <td>{{$data->phone_number}}</td>
                            <td>{{$data->username}}</td>
                            <td>
                                <button class="btnDelete btn btn-danger btn-sm float-right" type="button" style="margin-left:5px;">Delete</button>
                                <button class="btnUpdate btn btn-secondary btn-sm float-right" type="button">Update</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="updateDataModal">
        <div class="modal-dialog">
            <form id="updateDataForm">
          <div class="modal-content">

                <div class="modal-header">
                <h4 class="modal-title">New Book</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" id="updateDataID" name="id"/>
                    <div class="row">
                        <div class="col"><label class="col-form-label d-table-row">Name</label>
                            <input class="form-control" type="text" id="udateName" name="Name"></div>
                    </div>
                    <div class="row">
                        <div class="col"><label class="col-form-label d-table-row">Staff ID</label>
                            <input class="form-control" value="" type="text" id="udateStaffId" name="StaffID"></div>
                    </div>
                    <div class="row">
                        <div class="col"><label class="col-form-label d-table-row">Phone Number</label>
                            <input class="form-control" type="text" id="updatePhoneNumber" name="PhoneNumber" required=""></div>
                    </div>
                    <div class="row">
                        <div class="col"><label class="col-form-label d-table-row">User Name</label>
                            <input class="form-control" type="text" id="updateUserName" name="Username" required=""></div>
                    </div>
                    <div class="row">
                        <div class="col"><label class="col-form-label d-table-row">Password</label>
                            <input class="form-control" type="password" id="updatePassword" name="Password" required=""></div>
                    </div>
                    <div class="row">
                        <div class="col"><label class="col-form-label d-table-row">Confirm Password</label>
                            <input class="form-control" type="password" id="updatePasswordConfirm" name="password_confirmation" required=""></div>
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


    $(".btnUpdate").click(function(){
            var tr = $(this).closest('tr');
            $("#updateDataID").val(tr.data('id'));
            $("#udateName").val(tr.data('name'));
            $("#udateStaffId").val(tr.data('staffid'));
            $("#updatePhoneNumber").val(tr.data('phonenumber'));
            $("#updateUserName").val(tr.data('username'));
            $("#updateDataModal").modal('show');
    });

        $("#updateDataForm").submit(function(e){
        e.preventDefault();
        var form = $('#updateDataForm')[0];
        var data = new FormData(form);
        data.append('_token', $("meta[name='csrf-token']").attr('content'));
        
        $.ajax({
            type: "POST",
            url: "{{URL::to('/')}}/users/update",
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            success: function (data) {
                if (data.error) {
                    swal(data.error, "", "error")
                } else {
                    swal("User Details Updated!", "", "success").then((value) => {
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
            url: "{{URL::to('/')}}/users/delete",
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            success: function (data) {
                if (data.error) {
                    swal(data.error, "", "error")
                } else {
                    swal("User Deleted!", "", "success").then((value) => {
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