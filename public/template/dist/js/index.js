//delete button data
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
                        text: response.message,
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false,
                        timerProgressBar: true
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


$(document).ready(function() {
    //table data users 
    $('#table_users').DataTable({
        processing: true,
        serverSide: true,
        searching: true,
        stateSave: true,
        ajax: {
            url: "/users",
            type: "GET"
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            {
                data: 'name',
                name: 'name',
            },
            {
                data: 'email',
                name: 'email'
            },
            {
                data: 'role',
                name: 'role',
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
        ]
    });
    
    //table data role
    $('#table_role').DataTable({
        processing: true,
        serverSide: true,
        searching: true,
        stateSave: true,
        ajax: {
            url: "/roles",
            type: "GET"
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            {
                data: 'name',
                name: 'Name'
            },
            {
                data: 'guard_name',
                name: 'Guard Name'
            },
            {
                data: 'permission',
                name: 'Permission'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
        ]
    });
    //table data permission
    $('#table_permission').DataTable({
        processing: true,
        serverSide: true,
        searching: true,
        stateSave: true,
        ajax: {
            url: "/permission",
            type: "GET"
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            {
                data: 'name',
                name: 'Name'
            },
            {
                data: 'guard_name',
                name: 'Guard Name'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
        ]
    });




    //getDataRoleInUser

    $('.allRole').select2({
        ajax: {
            url: '/roles/getDataRole', 
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    search: params.term 
                };
            },
            processResults: function (data) {
                return {
                    results: data.map(function (role) {
                        return {
                            id: role.name,
                            text: role.name
                        };
                    })
                };
            },
            cache: true
        }
    });
});


//setup filepond input photo profile 
$(document).ready(function () {
    $('#photo').filePond();
    // Aktivasi plugin FilePond
    // FilePond.registerPlugin(
    //     FilePondPluginFileValidateType,
    //     FilePondPluginImagePreview
    // );

    // // Inisialisasi FilePond pada input
    // const pond = FilePond.create(document.querySelector('#photo'), {
    //     acceptedFileTypes: ['image/*'], // Hanya gambar yang diterima
    //     labelFileTypeNotAllowed: 'Hanya file gambar yang diizinkan',
    //     imagePreviewHeight: 150,
    //     stylePanelAspectRatio: 1,
    //     styleLoadIndicatorPosition: 'center bottom',
    //     styleProgressIndicatorPosition: 'center bottom',
    // });

    // // Atur URL upload (contoh menggunakan Laravel route)
    // pond.setOptions({
    //     server: {
    //         url: '/users/store', // Ganti dengan endpoint upload server Anda
    //         process: {
    //             method: 'POST',
    //             headers: {
    //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'), // Jika menggunakan Laravel
    //             },
    //         },
    //     },
    // });
});
