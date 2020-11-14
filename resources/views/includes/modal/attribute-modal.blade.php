<div class="modal fade" id="product-attribute-modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" >
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>
            @include('includes.modal-alerts')
            <div class="modal-body">
                <form id="" name="" class="form-horizontal modal-form-inputs">
                    <div class="form-group">
                        <input type="text" name="" id="" class="form-control product-attribute-inputted" placeholder="write here..." autofocus="autofocus">
                    </div>
                </form>
                <div class="col-sm-offset-2 form-group function-button">
                    <button type="button" class="btn btn-primary form-control add-attribute-btn" id="" value="">Add
                    </button>
                    <button type="button" class="btn btn-danger mt-2 form-control closeModal" id="close-product-attribute-modal" value="">Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
