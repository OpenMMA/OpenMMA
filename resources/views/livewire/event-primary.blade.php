@pushOnce('scripts')
    <script src="{{ asset('js/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>
@endPushOnce

<div>
    {{-- @if(Session::has('status') && Session::get('status') == 'updated')
    <div class="alert alert-success alert-dismissible fade show position-absolute z-3" role="alert">
        Event updated successfully!
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif --}}
    <form wire:submit.prevent="submit">
        {{-- @include('components.form.form-fields.text', ['field' => (object)array('name' => 'title', 'required' => true, 'value' => $event->title)]) --}}
        <div class="mb-3">
            <input class="form-control" type="text" wire:model="title">
        </div>
        <div class="row">
            <div class="col-6">
                <div class="mb-3">
                    <label class="form-label" for="start">Start time</label>
                    <input class="form-control" type="datetime-local" wire:model="start" name="start">
                </div>
                {{-- @include('components.form.form-fields.date', ['field' => (object)array('name' => 'start', 'required' => true, 'label' => 'Start time', 'value' => Carbon::parse($event->start)->format('Y-m-d\TH:i'))]) --}}
            </div>
            <div class="col-6">
                <div class="mb-3">
                    <label class="form-label" for="end">End time</label>
                    <input class="form-control" type="datetime-local" wire:model="end" name="end">
                </div>
                {{-- @include('components.form.form-fields.date', ['field' => (object)array('name' => 'end', 'required' => true, 'label' => 'End time', 'value' => Carbon::parse($event->end)->format('Y-m-d\TH:i'))]) --}}
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label" for="description">Description (short)</label>
            <textarea class="form-control" rows="5" wire:model="description" name="description"></textarea>
        </div>
        <div class="mb-3" wire:ignore>
            <textarea class="form-control" rows="5" wire:model="body" id="event-body"></textarea>
        </div>

        <script>
            tinymce.init({
                selector: 'textarea#event-body',
                plugins: 'code table lists',
                toolbar: 'undo redo | formatselect| bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | code | table',
                promotion: false,
                setup: function (editor) {
                    editor.on('init change', function () {
                        editor.save();
                    });
                    editor.on('change', function (e) {
                        @this.set('body', editor.getContent());
                    });
                }
            });
        </script>
        {{-- @include('components.form.form-fields.textarea', ['field' => (object)array('name' => 'description', 'required' => true, 'rows' => 5, 'label' => 'Description (short)', 'value' => $event->description)]) --}}
        {{-- @include('components.form.form-fields.tinymce', ['field' => (object)array('name' => 'body', 'required' => true, 'value' => $event->body)]) --}}
        <button type="submit" class="btn btn-primary">Save changes</button>
    </form>
</div>
