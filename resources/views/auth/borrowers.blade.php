@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row" style="margin-bottom:0;margin-top:20px;">
        <div class="col-xl-10">
            <h3>Borrowers</h3>
        </div>
        <div class="col"><button class="btn btn-info float-right" type="button" id="btnNew" data-bs-toggle="modal" data-bs-target="#new">New</button></div>
    </div>

    <div class="row" style="margin-top:15px;">
        <div class="col">
            <div class="table-responsive">
                <table id="tbl"  class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>IC</th>
                            <th>Phone Number</th>
                            <th>Address</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $data)
                        <tr data-id="{{$data->id}}" data-name="{{$data->name}}" data-ic="{{$data->ic}}" data-phone="{{$data->phone_number}}" data-address="{{$data->address}}">
                            <td>{{$data->name}}</td>
                            <td>{{$data->ic}}</td>
                            <td>{{$data->phone_number}}</td>
                            <td>{{$data->address}}
                            <td><button class="btnDelete btn btn-danger btn-sm float-right" type="button" style="margin-left:5px;">Delete</button>
                                <button class="btnUpdate btn btn-secondary btn-sm float-right" type="button">Update</button></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<div class="modal fade" id="new">
    <div class="modal-dialog">
        <form id="newDataForm">
      <div class="modal-content">

            <div class="modal-header">
            <h4 class="modal-title">New Borrower</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                
                <div class="row">
                    <div class="col"><label class="col-form-label d-table-row">Name</label>
                        <input class="form-control" type="text" name="Name" required=""></div>
                </div>
                <div class="row">
                    <div class="col"><label class="col-form-label d-table-row">IC</label>
                        <input class="form-control" value="" type="text" name="IC"></div>
                </div>
                <div class="row">
                    <div class="col"><label class="col-form-label d-table-row">Phone Number</label>
                        <input class="form-control" type="text" name="PhoneNumber" required=""></div>
                </div>
                <div class="row">
                    <div class="col"><label class="col-form-label d-table-row">Address</label>
                        <input class="form-control" type="text" name="Address" required=""></div>
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

  <div class="modal fade" id="updateDataModal">
    <div class="modal-dialog">
        <form id="updateDataForm">
      <div class="modal-content">

            <div class="modal-header">
            <h4 class="modal-title">New Borrower</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <input type="hidden" id="updateDataID" name="id"/>
                <div class="row">
                    <div class="col"><label class="col-form-label d-table-row">Name</label>
                        <input class="form-control" type="text" id="updateName" name="Name" required=""></div>
                </div>
                <div class="row">
                    <div class="col"><label class="col-form-label d-table-row">IC</label>
                        <input class="form-control" value="" type="text" id="updateIC" name="IC"></div>
                </div>
                <div class="row">
                    <div class="col"><label class="col-form-label d-table-row">Phone Number</label>
                        <input class="form-control" type="text" id="updatePhoneNumber" name="PhoneNumber" ></div>
                </div>
                <div class="row">
                    <div class="col"><label class="col-form-label d-table-row">Address</label>
                        <input class="form-control" type="text" id="updateAddress" name="Address" ></div>
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
                url: "{{URL::to('/')}}/borrowers/create",
                data: data,
                processData: false,
                contentType: false,
                cache: false,
                success: function (data) {
                    if (data.error) {
                        swal(data.error, "", "error")
                    } else {
                        swal("Borrower Created!", "", "success").then((value) => {
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
            $("#updateName").val(tr.data('name'));
            $("#updateIC").val(tr.data('ic'));
            $("#updatePhoneNumber").val(tr.data('phone'));
            $("#updateAddress").val(tr.data('address'));
            $("#updateDataModal").modal('show');
        });


        $("#updateDataForm").submit(function(e){
        e.preventDefault();
        var form = $('#updateDataForm')[0];
        var data = new FormData(form);
        data.append('_token', $("meta[name='csrf-token']").attr('content'));
        
        $.ajax({
            type: "POST",
            url: "{{URL::to('/')}}/borrowers/update",
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
            url: "{{URL::to('/')}}/borrowers/delete",
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            success: function (data) {
                    if (data.error) {
                        swal(data.error, "", "error")
                    } else {
                        swal("Borrower Deleted!", "", "success").then((value) => {
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