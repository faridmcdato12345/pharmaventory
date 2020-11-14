<script type="text/javascript">
    $(document).ready(function(){
        let idAttribute;
        $('body').on('click','.add-attribute',function(e){
            e.preventDefault();
            idAttribute = $(this).attr('id');
            $('#product-attribute-modal label').attr("for",idAttribute)
            $('#product-attribute-modal form').attr({id:idAttribute,name:idAttribute})
            $('#product-attribute-modal .modal-title').html("Add " + idAttribute.toUpperCase())
            $('#product-attribute-modal form input[type="text"]').attr({name: idAttribute,id: idAttribute})
            $('#product-attribute-modal .function-button button.update').attr("id",idAttribute)
            $('#product-attribute-modal').modal('show');
        })
        $('body').on('click','.add-attribute-btn',function(e){
            e.preventDefault();
            let route = "{{route('types.store')}}"
            let routes = route.replace('types',idAttribute);
            $.ajax({
                data:{name: $('.product-attribute-inputted').val()},
                url: routes,
                type: "POST",
                dataType: "json",
                success:function(data){
                    $('#product-attribute-modal').find('form')[0].reset()
                    $('#product-attribute-modal').modal('hide')
                    location.reload()
                },
                error: function(err){
                    $('.modal-succes-error').show('show');
                    $('.modal-success-alert').html('Something went wrong!');
                }
            })
        })
        $('body').on('click','#close-product-attribute-modal',function(e){
            e.preventDefault();
            $('#product-attribute-modal').find('form')[0].reset()
            $('#product-attribute-modal').modal('hide')
        })
    })
</script>