<!--Start::Modal Credential-->
<div class="modal fade" tabindex="-1" id="modal_{{ $module }}">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nova Credencial</h5>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ki-duotone ki-cross fs-2x"><span class="path1"></span><span class="path2"></span></i>
                </div>
            </div>

            <form id="formCredential">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-1 col-12">
                            <label class="form-label">Id:</label>
                            <input type="text" class="form-control form-control-solid" name="id" required readonly />
                        </div>
                        
                        <div class="col-md-6 col-12">
                            <label class="form-label">Usuário:</label>
                            <input type="text" class="form-control form-control-solid" name="username" required />
                        </div>

                        <div class="col-md-1 col-12">
                            <label class="form-label">Master:</label>
                            <select class="form-select select2 form-select-solid" name="is_master" required>
                                <option value="0" chequed >Não</option>
                                <option value="1">Sim</option>
                            </select>
                        </div>

                        <div class="col-md-2 col-12">
                            <label class="form-label">Expiração:</label>
                            <input type="date" class="form-control form-control-solid" id="dt_expiration" name="dt_expiration" required />
                        </div>

                        <div class="col-md-2 col-12">
                            <label class="form-label">Limite de Acesso:</label>
                            <input type="date" class="form-control form-control-solid" id="dt_limit_access" name="dt_limit_access" required readonly />
                        </div>
                    </div>
                </div>

                <div class="modal-footer d-flex justify-content-between align-items-center">
                    <div class="form-check form-switch form-check-custom form-check-solid">
                        <input class="form-check-input h-20px w-30px" type="checkbox" name="active" id="switch_active" value="1" checked>
                        <label class="form-check-label" for="switch_active" id="label_active">Público</label>
                    </div>
                
                    <div>
                        <button type="button" class="btn btn-sm btn-light-danger" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-sm btn-light-primary">Salvar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!--End::Modal Credential-->