<div class="modal fade" id="product-attribute-manage" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" >
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>
            @include('includes.modal-alerts')
            <div class="modal-body">
                <div class="form-group">
                    <div class="col-sm-offset-2">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                </tr>
                            </thead>
                            <tbody class="attribute_modal">

                            </tbody>
                        </table>
                    </div>
                </div>
                <form id="" name="" class="form-horizontal modal-form-inputs">
                    <div class="form-group">
                        <input type="text" name="" id="" class="form-control inputted" placeholder="write here..." autofocus="autofocus">
                    </div>
                </form>
                <div class="col-sm-offset-2 form-group function-button">
                    <button type="button" class="btn btn-primary form-control update" id="" value="">Update
                    </button>
                    <button type="button" class="btn btn-danger mt-2 form-control closeModal" id="closeModal" value="">Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
