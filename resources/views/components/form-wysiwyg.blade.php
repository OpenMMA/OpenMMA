@pushOnce('scripts')
<script src="{{ asset('/js/dashboard/form-wysiwyg.js') }}"></script>
@endPushOnce

<div>
    <input type="hidden" name="form-content" value='[]'>
    <div>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#form-wysiwyg-modal" onclick="form_load(this)">Edit this form</button>      
        <button type="button" class="btn btn-secondary">Edit form JSON (advanced)</button>          
    </div>
    <div class="modal fade" id="form-wysiwyg-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
        <div class="modal-dialog">
            <div class="d-none" id="template-elements">
                
                <div id="t-dropdown-option" class="mx-1">
                    <span class="fa-solid fa-trash ms-2" role="button" onclick="options_remove(this)"></span>
                    <input type="hidden" name="key">
                    <input type="hidden" name="label">
                </div>
                
                <div id="t-field-card" class="card my-2 p-0">
                    <div class="card-body d-flex flex-row p-0">
                        <div class="border-end flex-shrink-1 drag-handler px-2 d-flex align-items-center">
                            <span role="button" class="fa-solid fa-bars"></span>
                        </div>
                        <div class="p-1 flex-grow-1">
                            <div class="d-flex flex-row" id="field-field"> 
                                <div class="ps-3 pe-2  d-flex align-items-center">
                                    <span role="button" class="fa-solid fa-gear" onclick="$(this).parents(':eq(1)').siblings('#field-opts').toggleClass('d-none')"></span>
                                </div>
                            </div>
                            <div class="m-2 pt-2 border-top d-none" id="field-opts"></div>
                        </div>
                    </div>
                </div>
                <div id="t-field-card-opts">
                    <div id="t-text">
                        <div id="field" class="flex-grow-1">
                            <label>Input field</label>
                            <input type="text" class="form-control">
                        </div>
                        <div id="opts">
                            <div class="mb-2 d-flex flex-row align-items-center">
                                <span class="w-50">Label: </span>
                                <input type="text" name="label" class="form-control form-control-sm ms-2" oninput="update_label(this)">
                            </div>
                            <div class="mb-1 p-1 d-flex flex-row align-items-center">
                                <input type="checkbox" class="form-check-input me-2" name="required">
                                <span>Required</span>
                            </div>
                            <div class="mb-2 d-flex flex-row align-items-center">
                                <span class="w-50">Default value: </span>
                                <input type="text" name="default" class="form-control form-control-sm ms-2">
                            </div>
                            <input type="hidden" name="name">
                            <input type="hidden" name="type">
                            <button class="btn btn-danger px-1 py-0 mt-2" type="button" onclick="$(this).parents(':eq(4)').remove()">Remove element</button>
                        </div>
                    </div>
                    <div id="t-number">
                        <div id="field" class="flex-grow-1">
                            <label>Input field</label>
                            <input type="number" class="form-control">
                        </div>
                        <div id="opts">
                            <div class="mb-2 d-flex flex-row align-items-center">
                                <span class="w-50">Label: </span>
                                <input type="text" name="label" class="form-control form-control-sm ms-2" onchange="update_label(this)">
                            </div>
                            <div class="mb-1 p-1 d-flex flex-row align-items-center">
                                <input type="checkbox" class="form-check-input me-2" name="required">
                                <span>Required</span>
                            </div>
                            <div class="mb-2 d-flex flex-row align-items-center">
                                <span class="w-100">Minimum value<br>(empty for no minimum): </span>
                                <input type="number" name="min" class="form-control form-control-sm ms-2">
                            </div>
                            <div class="mb-2 d-flex flex-row align-items-center">
                                <span class="w-100">Maximum value<br>(empty for no maximum): </span>
                                <input type="number" name="max" class="form-control form-control-sm ms-2">
                            </div>
                            <div class="mb-2 d-flex flex-row align-items-center">
                                <span class="w-50">Default value: </span>
                                <input type="number" name="default" class="form-control form-control-sm ms-2">
                            </div>
                            <input type="hidden" name="name">
                            <input type="hidden" name="type">
                            <button class="btn btn-danger px-1 py-0 mt-2" type="button" onclick="$(this).parents(':eq(4)').remove()">Remove element</button>
                        </div>
                    </div>
                    <div id="t-select">
                        <div id="field" class="flex-grow-1">
                            <label>Select one</label>
                            <select class="form-select ms-2" placeholder="Please select one..."></select>
                        </div>
                        <div id="opts">
                            <div class="mb-2 d-flex flex-row align-items-center">
                                <span class="w-50">Label: </span>
                                <input type="text" name="label" class="form-control form-control-sm ms-2" onchange="update_label(this)">
                            </div>
                            <div class="mb-1 p-1 d-flex flex-row align-items-center">
                                <input type="checkbox" class="form-check-input me-2" name="required">
                                <span>Required</span>
                            </div>
                            <div class="mb-2 d-flex flex-row align-items-center">
                                <span class="mt-1">Options: </span>
                                <div class="ms-2 mb-1 border rounded p-2">
                                    <input type="hidden" name="options-array" id="options-array">
                                    <div id="options" class="border rounded m-2 p-1"></div>
                                    <div class="input-group">
                                        <input type="text" class="form-control ms-2" id="dropdown-item">
                                        <button class="btn btn-primary" onclick="options_add(this)" role="button">+ Add</button>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-1 p-1 d-flex flex-row align-items-center">
                                <input type="checkbox" class="form-check-input me-2" name="multiple">
                                <span>Allow selection of multiple options</span>
                            </div>
                            <input type="hidden" name="name">
                            <input type="hidden" name="type">
                            <button class="btn btn-danger px-1 py-0 mt-2" type="button" onclick="$(this).parents(':eq(4)').remove()">Remove element</button>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="fw-semibold">Form builder</h4>
                </div>
                <div class="modal-body" id="editor-container" class="row gy-2">
                    <div id="pad" style="height:1px;"></div>
                </div>
                <div class="modal-body border-top">
                    <h5>Add new field</h5>
                    <div>
                        <div class="mb-1 d-flex flex-row align-items-center" id="new-label">
                            <span>Label: </span>
                            <input type="text" class="form-control ms-2" name="label" required>
                        </div>
                        <div class="invalid-feedback mb-2">Please provide a label.</div>
                        <div class="mb-1 d-flex flex-row align-items-center" id="new-type">
                            <span class="text-nowrap">Input type: </span>
                            <select class="form-select ms-2" id="add-element" onchange="$(this).parent().siblings('.input-option-menu').hide(); $(this).parent().siblings(`#${$(this).val()}-options`).show()">
                                <option value="text" selected>text</option>
                                <option value="number">number</option>
                                <option value="select">dropdown selector</option>
                            </select>
                        </div>
                        <div class="input-option-menu" style="display: none;" id="select-options">
                            <div class="mb-1 d-flex flex-row align-items-top">
                                <span class="mt-1">Options: </span>
                                <div class="ms-2 mb-1 border rounded p-2">
                                    <input type="hidden" name="options-array" id="options-array">
                                    <div id="options" class="border rounded m-2 p-1"></div>
                                    <div class="input-group">
                                        <input type="text" class="form-control ms-2" id="dropdown-item">
                                        <button class="btn btn-primary" onclick="options_add(this)" role="button">+ Add</button>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-1 p-1 d-flex flex-row align-items-center" id="new-multiple">
                                <input type="checkbox" class="form-check-input me-2" name="multiple">
                                <span>Allow selection of multiple options</span>
                            </div>
                        </div>
                        <div class="input-option-menu" style="display: none;" id="number-options">
                            <div class="mb-2 d-flex flex-row align-items-center" id="new-min">
                                <span class="w-100">Minimum value<br>(empty for no minimum): </span>
                                <input type="number" name="min" class="form-control form-control-sm ms-2">
                            </div>
                            <div class="mb-2 d-flex flex-row align-items-center" id="new-max">
                                <span class="w-100">Maximum value<br>(empty for no maximum): </span>
                                <input type="number" name="max" class="form-control form-control-sm ms-2">
                            </div>
                        </div>
                        <div class="mb-1 p-1 d-flex flex-row align-items-center" id="new-required">
                            <input type="checkbox" class="form-check-input me-2" name="required" checked>
                            <span>Required</span>
                        </div>
                        <button class="btn btn-primary" type="button" onclick="field_add(this)">+ Add</button>
                    </div>
                </div>
                <div class="modal-footer border-top" class="row gy-2">
                    <button class="btn btn-success w-100" type="button" onclick="form_save(this)" data-bs-dismiss="modal">Save form</button>
                    <button class="btn btn-secondary w-100" type="button" data-bs-dismiss="modal">Exit without saving (discard changes)</button>
                </div>
            </div>
        </div>
    </div>

</div>
