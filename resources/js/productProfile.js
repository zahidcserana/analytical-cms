window.ProductProfile = function () {
    $(document).ready(function() {
        let columns = [
            {
                "title": "Name",
                "data": 'name',
                "name": "name",
                "className": "product-profile-name"
            },
            {
                "title": "",
                "data": function (data) {
                    return '<a href="' + data.edit + '" class="btn btn-sm btn-primary">Edit</a><a href="' + data.delete + '" class="btn btn-sm btn-danger delete-product-profile">Delete</a>'
                },
                "name": "",
            }
        ];

        $('#product-profiles-table').DataTable(
            {
                serverSide: true,
                ajax: '/product_profiles/data_table',
                responsive: true,
                pagingType: "simple_numbers",
                scrollX: true,
                ordering: false,
                pageLength: 20,
                order: [[0, 'desc']],
                sDom: '<"top">rt<"bottom"<"col col-12"p>>',
                "language": {
                    "paginate": {
                        "previous": "<",
                        "next": ">"
                    }
                },
                columns: columns,

                createdRow: function( row, data, dataIndex ) {
                    $(row).attr( 'data-id', data['id'] );
                },
        });

        $('.create-product-profile').on('click', function (event) {
            event.preventDefault();

            let name = $('input[name="name"]');
            let customerId = $('select[name="customer_id"]');

            if (name.val()) {
                $.ajax({
                    method:'POST',
                    url: $(this).attr('href'),
                    data: {
                        name: name.val(),
                        customer_id: customerId.val()
                    },
                    success: function (results)
                    {
                        $('#product-profiles-table').DataTable().draw()
                        ajaxMessageBox(results, true)
                        name.val('')
                    },
                    error: function (xhr)
                    {
                        ajaxMessageBox(xhr.responseJSON.message, false)
                    }
                })
            } else {
                ajaxMessageBox(errorInputEmpty, false)
            }
        })

        $(document).on('click', '.delete-product-profile', function (event) {
            event.preventDefault();

            $.ajax({
                method:'DELETE',
                url: $(this).attr('href'),
                success: function (results) {
                    $('#product-profiles-table').DataTable().draw()
                    ajaxMessageBox(results, true)
                },
                error: function (xhr) {
                    ajaxMessageBox(xhr.responseJSON.message, false)
                }
            })
        })

        $(document).on('click', 'td.product-profile-name', function(){
            let productProfileId = $(this).closest('tr').attr('data-id')

            $.ajax({
                method:'GET',
                url: '/product_profiles/'+productProfileId+'/product_list',
                success: function (results) {
                    $('#product-modal').modal('show')
                    $('.product-list').replaceWith(results)

                    let columns = [
                        {
                            "title": "",
                            "data": function(data) {
                                let isChecked = data.product_profile_id == productProfileId ? 'checked' : ''

                                return '<input class="product-checkbox" type="checkbox" ' + isChecked + ' value="' + data.id + '" />'
                            },
                            "name": "",
                        },
                        {
                            "title": "Product",
                            "data": 'name',
                            "name": "name",
                        },
                        {
                            "title": "Profile",
                            "data": 'product_profile',
                            "name": "product_profile",
                        },
                    ];

                    let addProducts = []
                    let removeProducts = []
                    let productTable =  $('#product-table')

                    productTable.DataTable(
                    {
                        serverSide: true,
                        ajax: '/product_profiles/product_data_table/' + productProfileId,
                        responsive: true,
                        pagingType: "simple_numbers",
                        scrollX: true,
                        ordering: false,
                        pageLength: 20,
                        order: [[0, 'desc']],
                        sDom: '<"top">rt<"bottom"<"col col-12"p>>',
                        "language": {
                            "paginate": {
                                "previous": "<",
                                "next": ">"
                            }
                        },
                        createdRow: function( row, data, dataIndex ) {
                            $(row).find('.product-checkbox').on('click', function (event){
                                if (!$(this).is(':checked')) {
                                    if(!removeProducts.includes($(this).val())) {
                                        removeProducts.push($(this).val())
                                        addProducts.splice(addProducts.indexOf($(this).val()), 1)
                                    }
                                } else {
                                    if(!addProducts.includes($(this).val())) {
                                        addProducts.push($(this).val())
                                        removeProducts.splice(removeProducts.indexOf($(this).val()), 1)
                                    }
                                }
                            });
                        },
                        columns: columns,
                    });

                    productTable.on('draw.dt', function () {
                        productTable.find('.product-checkbox').each(function () {
                            if (addProducts.includes($(this).val())) {
                                $(this).prop('checked', true)
                            }

                            if (removeProducts.includes($(this).val())) {
                                $(this).prop('checked', false)
                            }
                        })
                    })

                    $('.save').on('click', function (){
                        $.ajax({
                            method: 'POST',
                            url: '/product_profiles/'+productProfileId+'/save_product_selection',
                            data: {
                                addProducts,
                                removeProducts
                            },
                            success: function (results) {
                                ajaxMessageBox(results, true)
                            },
                            error: function (xhr) {ajaxMessageBox(xhr.responseJSON.message, false)}

                        })


                    })


                },
                error: function (xhr) {
                    ajaxMessageBox(xhr.responseJSON.message, false)
                }
            })

        })
    });
};
