<div class="modal fade" id="specific-days" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" >
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading">Report Paramater</h4>
            </div>
            @include('includes.modal-alerts')
            <div class="modal-body">
                <form id="form-days" name="form-days" class="form-horizontal modal-form-inputs">
                    <div class="form-group">
                        <label for="days">Expiration Value in Days</label>
                        <input type="number" name="days" id="days" class="form-control inputted" placeholder="write here..." autofocus="autofocus">
                    </div>
                </form>
                <div class="col-sm-offset-2 form-group function-button">
                    <button type="button" class="btn btn-primary form-control specific-days-get" id="ok">Ok</button>
                    <button type="button" class="btn btn-danger mt-2 form-control closeModal" id="close-report-modal" value="">Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="low-stock-modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" >
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading">Report Paramater</h4>
            </div>
            @include('includes.modal-alerts')
            <div class="modal-body">
                <form id="form-days" name="form-days" class="form-horizontal modal-form-inputs">
                    <div class="form-group">
                        <label for="days">Enter low stock value:</label>
                        <input type="number" name="stock" id="stock" class="form-control inputted" placeholder="write here..." autofocus="autofocus">
                    </div>
                </form>
                <div class="col-sm-offset-2 form-group function-button">
                    <button type="button" class="btn btn-primary form-control low-stock-get" id="low-stock-ok">Ok</button>
                    <button type="button" class="btn btn-danger mt-2 form-control closeModal" id="close-report-modal" value="">Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>