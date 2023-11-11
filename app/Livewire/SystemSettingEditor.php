<?php

namespace App\Livewire;

use App\Models\SystemSetting;
use Livewire\Component;
use Livewire\WithFileUploads;

class SystemSettingEditor extends Component
{
    use WithFileUploads;

    public string $label;
    public string $key;
    public string $value;
    public SystemSetting $setting;
    public $image; // Only used with 'image'-type setting

    public function mount()
    {
        $this->setting = SystemSetting::where('key', $this->key)->first();
        switch ($this->setting->type) {
            case 'text':
            case 'num':
            case 'image':
                $this->value = $this->setting->value;
                break;
            case 'json':
                $this->value = json_encode(json_decode($this->setting->value), JSON_PRETTY_PRINT);
                break;
        }
    }

    public function save()
    {
        switch ($this->setting->type) {
            case 'text':
            case 'num':
                $this->setting->update(['value' => $this->value]);
                break;
            case 'json':
                // TODO add valid JSON verification
                $this->setting->update(['value' => $this->value]);
                break;
            case 'image':
                $this->validate([
                    'image' => 'image|mimes:png'
                ]);
                $this->image->storeAs('img', $this->value);
                $this->image = null;
                break;
        }
    }

    public function render()
    {
        return view('livewire.system-setting-editor');
    }
}
