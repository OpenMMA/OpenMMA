<?php

namespace App\Livewire;

use App\Models\SystemSetting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;

class SystemSettingEditor extends Component
{
    use WithFileUploads;

    public string $label;
    #[Locked]
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
            case 'form':
                $this->value = $this->setting->value;
                break;
            case 'json':
                $this->value = json_encode(json_decode($this->setting->value), JSON_PRETTY_PRINT);
                break;
        }
    }

    #[On('updated')]
    public function save()
    {
        if (!Auth::user()->can('global_setting.system'))
            return;

        $old_value = SystemSetting::where('key', $this->key)->first();

        switch ($this->setting->type) {
            case 'text':
            case 'num':
                $this->setting->update(['value' => $this->value]);
                break;
            case 'form':
            case 'json':
                // TODO add valid JSON verification
                $this->setting->update(['value' => $this->value]);
                $this->skipRender();
                break;
            case 'image':
                $this->validate([
                    'image' => 'image|mimes:png'
                ]);
                $this->image->storeAs('img', $this->value);
                $this->image = null;
                break;
        }

        Cache::forget('settings');

        switch ($this->setting->type) {
            case 'account.custom_fields':
                \App\Models\User::syncCustomFields($old_value, $this->setting->value);
                break;
        }
    }

    public function render()
    {
        // TODO auth check?
        return view('livewire.system-setting-editor');
    }
}
