<?php

class Form {
    public string $name;
    public array $fields;
    public string $method;

    public function __construct(string $form_name, array $fields, string $method = 'post') {
        $this->name   = $form_name;
        $this->fields = $fields;
        $this->method = $method;
    }

    public function generate(string $target = null, string $submit = 'Submit', bool $autocomplete = false) { ?>
        <form action="<?=($target) ? $target : $_SERVER['REQUEST_URI'] ?>" method="<?=$this->method ?>" autocomplete="<?=($autocomplete) ? 'on' : 'off' ?>">
            <?php 
            $prefix = 'genform-'.$this->name.'_';
            foreach ($this->fields as $field): ?>
            <div class="mb-3">
                <label for="<?=$prefix.$field->name ?>" class="form-label"><?=$field->title ?>:</label>
                <?php switch ($field->type):
                        case 'textarea': ?>
                        <textarea class="form-control" id="<?=$prefix.$field->name ?>" name="<?=$prefix.$field->name ?>" rows="<?=$field->rows ?? 5 ?>" cols="<?=$field->cols ?? 60  ?>" placeholder="<?=$field->placeholder ?? '' ?>" value="<?=$field->default ?? '' ?>"></textarea>
                    <?php break; case 'texteditor': ?>
                        <script src="/vendor/tinymce/tinymce/tinymce.min.js" referrerpolicy="origin"></script>
                        <script>tinymce.init({selector: '#<?=$prefix.$field->name ?>',promotion:false});</script>
                        <textarea id="<?=$prefix.$field->name ?>" name="<?=$prefix.$field->name ?>"><?=$field->default ?? '' ?></textarea>
                    <?php break; default: ?>
                        <input type="<?=$field->type ?>" class="form-control" id="<?=$prefix.$field->name ?>" name="<?=$prefix.$field->name ?>" placeholder="<?=$field->placeholder ?? '' ?>" value="<?=$field->default ?? '' ?>" <?php if (isset($field->maxlength)): ?>maxlength="<?=$field->maxlength ?>"<?php endif; ?> <?=(isset($field->required) && $field->required) ? 'required' : '' ?>>
                <?php endswitch; ?>
            </div>
            <?php endforeach; ?>
            <button type="submit" class="btn btn-primary"><?=$submit ?></button>
        </form>
    <?php }

    public function extract() {
        switch ($this->method) {
            case 'get':
                $data = $_GET;
                break;
            case 'post':
                $data = $_POST;
                break;
            default:
                return null;
        }

        $prefix = 'genform-'.$this->name.'_';
        $form_data = array();

        foreach ($this->fields as $field) {
            $form_data[$field->name] = $data[$prefix.$field->name] ?? null;
        }

        return (object)$form_data;
    }

    public function verify(object $data) {
        
    }
}