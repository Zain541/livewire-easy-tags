<?php

namespace LivewireEasyTags\Components;

use App\Models\User;
use Livewire\Component;
use Spatie\Tags\Tag;
use Illuminate\Support\Facades\Hash;

class LivewireEasyTags extends Component
{
    public $componentKey;

    public function mount()
    {
        $this->componentKey = rand(1,1000000) . microtime(true);
    }

    protected function getListeners()
    {
        return [
            'addNewTagEvent' => 'addNewTag',
            'removeTagEvent' => 'removeTag',
            'editTagEvent' => 'editTag'
        ];
    }

    public function addNewTag($tagArray)
    {
        try{
            $myModel = User::find(1);
            $myModel->syncTagsWithType(array_column($tagArray, 'value'), 'firstType');
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getUserTags()
    {
        $myModel = User::find(1);
        $modelTags = $myModel->tagsWithType('firstType');
        foreach($modelTags as $tag){
            $commaContainingModelTags[] = $tag->name;
        }
        if(isset($commaContainingModelTags) && count($commaContainingModelTags) > 0)
        {
            echo implode(",", $commaContainingModelTags);
        }
        echo '';
    }

    public function removeTag($tagsArray)
    {
        $myModel = User::find(1);
        $myModel->detachTag($tagsArray['value'], 'firstType');
    }

    public function editTag($tagsArray)
    {
    \Log::debug($tagsArray);
    }

    public function render()
    {
        return view('livewire-easy-tags::livewire.livewire-easy-tags');
    }
}
