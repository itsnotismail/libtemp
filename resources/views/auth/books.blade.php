@extends('layouts.app')
@section('content')
<section>
    <div class="container">
        <div class="row" style="margin-bottom:0;margin-top:20px;">
            <div class="col-xl-10">
                <h3>Books</h3>
            </div>
            <div class="col"><button class="btn btn-info float-right" type="button" id="btnNew" data-bs-toggle="modal" data-bs-target="#new">New</button></div>
        </div>

        <div class="row" style="margin-top:15px;">
            <div class="col">
                <div class="table-responsive">
                    <table id="tbl" class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th>ISBN</th>
                                <th>Year</th>
                                <th>Title</th>
                                <th>Author</th>
                                <th>Publisher Name</th>
                                <th>Category</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $data)
                            <tr data-id="{{$data->id}}" data-isbn="{{$data->isbn}}" data-year="{{$data->year_of_publication}}" data-title="{{$data->title}}" data-author="{{$data->author}}" data-publisher="{{$data->publisher_name}}"data-category="{{$data->category}}" >
                                <td>{{$data->isbn}}</td>
                                <td>{{$data->year_of_publication}}</td>
                                <td>{{$data->title}}</td>
                                <td>{{$data->author}}</td>
                                <td>{{$data->publisher_name}}</td>
                                <td>{{$data->category}}</td>
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
                <h4 class="modal-title">New Book</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col"><label class="col-form-label d-table-row">ISBN</label>
                            <input class="form-control" type="text" name="ISBN" required=""></div>
                    </div>
                    <div class="row">
                        <div class="col"><label class="col-form-label d-table-row">Year</label>
                            <input class="form-control" value="" type="text" name="Year"></div>
                    </div>
                    <div class="row">
                        <div class="col"><label class="col-form-label d-table-row">Title</label>
                            <input class="form-control" type="text" name="Title" required=""></div>
                    </div>
                    <div class="row">
                        <div class="col"><label class="col-form-label d-table-row">Author</label>
                            <input class="form-control" type="text" name="Author" required=""></div>
                    </div>
                    <div class="row">
                        <div class="col"><label class="col-form-label d-table-row">Publisher Name</label>
                            <input class="form-control" type="text" name="PublisherName" required=""></div>
                    </div>
                    <div class="row">
                        <div class="col"><label class="col-form-label d-table-row">Category</label>
                            <input class="form-control" type="text" name="Category" required=""></div>
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
                <h4 class="modal-title">New Book</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" id="updateDataID" name="id"/>
                    <div class="row">
                        <div class="col"><label class="col-form-label d-table-row">ISBN</label>
                            <input class="form-control" type="text" id="udateIsbn" name="ISBN"></div>
                    </div>
                    <div class="row">
                        <div class="col"><label class="col-form-label d-table-row">Year</label>
                            <input class="form-control" value="" type="text" id="udateYear" name="Year"></div>
                    </div>
                    <div class="row">
                        <div class="col"><label class="col-form-label d-table-row">Title</label>
                            <input class="form-control" type="text" id="updateTitle" name="Title" required=""></div>
                    </div>
                    <div class="row">
                        <div class="col"><label class="col-form-label d-table-row">Author</label>
                            <input class="form-control" type="text" id="updateAuthor" name="Author" required=""></div>
                    </div>
                    <div class="row">
                        <div class="col"><label class="col-form-label d-table-row">Publisher Name</label>
                            <input class="form-control" type="text" id="updatePublisherName" name="PublisherName" required=""></div>
                    </div>
                    <div class="row">
                        <div class="col"><label class="col-form-label d-table-row">Category</label>
                            <input class="form-control" type="text" id="updateCategory" name="Category" required=""></div>
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
   
    
</section>

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
                url: "{{URL::to('/')}}/books/create",
                data: data,
                processData: false,
                contentType: false,
                cache: false,
                success: function (data) {
                    if (data.error) {
                        swal(data.error, "", "error")
                    } else {
                        swal("Book Updated!", "", "success").then((value) => {
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
            $("#udateIsbn").val(tr.data('isbn'));
            $("#udateYear").val(tr.data('year'));
            $("#updateTitle").val(tr.data('title'));
            $("#updateAuthor").val(tr.data('author'));
            $("#updatePublisherName").val(tr.data('publisher'));
            $("#updateCategory").val(tr.data('category'));
            $("#updateDataModal").modal('show');
        });


    $("#updateDataForm").submit(function(e){
        e.preventDefault();
        var form = $('#updateDataForm')[0];
        var data = new FormData(form);
        data.append('_token', $("meta[name='csrf-token']").attr('content'));
        
        $.ajax({
            type: "POST",
            url: "{{URL::to('/')}}/books/update",
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            success: function (data) {
                if (data.error) {
                    swal(data.error, "", "error")
                } else {
                    swal("Book Updated!", "", "success").then((value) => {
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
            url: "{{URL::to('/')}}/books/delete",
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            success: function (data) {
                if (data.error) {
                    swal(data.error, "", "error")
                } else {
                    swal("Book Updated!", "", "success").then((value) => {
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