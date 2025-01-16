@extends('layouts.layout')
@section('content')
    <div class="p-3">

    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="d-flex justify-content-between align-items-center px-3 mt-4">

                            <div>
                                <h3 class="card-title align-items-center">Data Post</h3>
                            </div>
                            <div>
                                <a href="{{ route('post.create') }}" class="btn btn-primary">Create</a>

                            </div>
                        </div>
                        <div class="card-body">
                            <table id="table_post" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Ttile</th>
                                        <th>Content</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('#table_post').DataTable({
                processing: true,
                serverSide: true,
                searching: true,
                stateSave: true,

                ajax: {
                    url: "/post",
                    type: "GET"
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    {
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'content',
                        name: 'content'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });
        })

        $(document).on('click', '.delete-button', function(e) {
            e.preventDefault();
            let id = $(this).data('id');
            let section = $(this).data('section');

            let url = `/${section}/delete/${id}`;
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            _method: 'DELETE',
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            Swal.fire({
                                title: "Deleted!",
                                text: "Your file has been deleted.",
                                icon: "success"
                            }).then(() => {
                                location.reload();
                            });
                        },
                        error: function() {
                            Swal.fire("Error!", "There was a problem deleting the item.",
                                "error");
                        }
                    });
                }
            });
        });
    </script>
@endsection
