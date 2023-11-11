@pushOnce('scripts')
<script src="{{ asset('/js/dashboard/form-wysiwyg.js') }}"></script>
@endPushOnce

@extends('dashboard.layout') {{-- !!! TEMPORARY --}}

@section('dashboard.content') {{-- !!! TEMPORARY --}}
<div style="width:500px;" class="card">
    <div class="d-none" id="template-elements">
        
        <div id="t-dropdown-option" class="mx-1">
            <span class="fa-solid fa-trash ms-2" role="button" onclick="options_remove(this)"></span>
            <input type="hidden">
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
                        <span>Label: </span>
                        <input type="text" name="label" class="form-control form-control-sm ms-2">
                    </div>
                </div>
            </div>
            <div id="t-number">
                <div id="field" class="flex-grow-1">
                    <label>Input field</label>
                    <input type="number" class="form-control">
                </div>
                <div id="opts">
                    <div class="mb-2 d-flex flex-row align-items-center">
                        <span>Label: </span>
                        <input type="text" name="label" class="form-control form-control-sm ms-2">
                    </div>
                </div>
            </div>
            <div id="t-select">
                <div id="field" class="flex-grow-1">
                    <label>Select one</label>
                    <select class="form-select ms-2" placeholder="Please select one..."></select>
                </div>
                <div id="opts">
                    <div class="mb-2 d-flex flex-row align-items-center">
                        <span>Label: </span>
                        <input type="text" name="label" class="form-control form-control-sm ms-2">
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="card-header">
        Form builder
    </div>
    <div class="card-body" id="editor-container" class="row gy-2">
        <div id="pad" style="height:1px;"></div>
    </div>
    <div class="card-body border-top">
        <h5>Add new field</h5>
        <div>
            <div class="mb-1 d-flex flex-row align-items-center" id="new-label">
                <span>Label: </span>
                <input type="text" class="form-control ms-2" name="label">
            </div>
            <div class="mb-1 d-flex flex-row align-items-center" id="new-type">
                <span class="text-nowrap">Input type: </span>
                <select class="form-select ms-2" id="add-element" onchange="$(this).parent().siblings('.input-option-menu').hide(); $(this).parent().siblings(`#${$(this).val()}-options`).show()">
                    <option value="text" selected>text</option>
                    <option value="number">number</option>
                    <option value="select">dropdown selector</option>
                </select>
            </div>
            <div class="input-number-menu" style="display: none;" id="select-options">
                <div class="mb-1 d-flex flex-row align-items-top">
                    <span class="mt-1">Options: </span>
                    
                </div>
            </div>
            <div class="input-option-menu" style="display: none;" id="select-options">
                <div class="mb-1 d-flex flex-row align-items-top">
                    <span class="mt-1">Options: </span>
                    <div class="ms-2 mb-1 border rounded p-2">
                        <input type="hidden" id="options-array">
                        <div id="options" class="border rounded m-2 p-1"></div>
                        <div class="input-group">
                            <input type="text" class="form-control ms-2" id="dropdown-item">
                            <button class="btn btn-primary" onclick="options_add(this)" role="button">+ Add</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mb-1 p-1 d-flex flex-row align-items-center" id="new-label">
                <input type="checkbox" class="form-check-input me-2" name="required" checked>
                <span>Required</span>
            </div>
            <button class="btn btn-primary" type="button" onclick="field_add(this)">+ Add</button>
        </div>
    </div>
</div>
@endsection  {{-- !!! TEMPORARY --}}