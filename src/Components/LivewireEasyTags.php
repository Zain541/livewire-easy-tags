<?php

namespace LivewireEasyTags\Components;

use App\Models\User;
use Livewire\Component;
use Spatie\Tags\Tag;
use Illuminate\Support\Collection;

class LivewireEasyTags extends Component
{
    public $componentKey;

    public function mount()
    {
        $this->componentKey = rand(1, 1000000) . microtime(true);
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
        try {
            $myModel = User::find(1);
            $myModel->syncTagsWithType(array_column($tagArray, 'value'), 'firstType');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Get user tags of the first type.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getUserTags(): Collection
    {
        // Find the user with ID 1
        $user = User::findOrFail(1);

        // Retrieve the tags with the specified type
        $tags = $user->tags()->where('type', 'firstType')->get();

        // Map the tags to the desired format
        $mappedTags = $tags->map(function ($tag) {
            return [
                'id' => $tag->id,
                'value' => $tag->name,
                'color' => $tag->color
            ];
        });

        // Return the mapped tags
        return $mappedTags;
    }

    public function removeTag($tagsArray)
    {
        $myModel = User::find(1);
        $myModel->detachTag($tagsArray['value'], 'firstType');
    }

    public function editTag($oldValue, $updatedValue)
    {
        \Log::debug($oldValue);
        \Log::debug($updatedValue);
    }

    public function prepareWhitelist()
    {
        $tags = Tag::get();
        $whitelist = '';
        $whitelistArray = [];
        foreach ($tags as $tag) {
            // $whitelist .= "{id: '" . $tag->id . "' , value: '" . $tag->name . "'},";
            $whitelistArray[] = $tag->name;
        }
        // $whitelist .= "'" . implode ( "', '", $whitelistArray ) . "'";
        $whitelist .= "{'id': 25, 'value': 'working', color: 'pink', style: '--tag-bg:pink'},{'id': 29, 'value': 'great', 'color': 'yellow'}";
        return $whitelist;
    }

    public function prepareTransformTag()
    {
        $tags = Tag::get();
        $whitelist = '';
        $whitelistArray = [];
        foreach ($tags as $tag) {
            // $whitelist .= "{id: '" . $tag->id . "' , value: '" . $tag->name . "'},";
            $whitelistArray[] = $tag->name;
        }
        // $whitelist .= "'" . implode ( "', '", $whitelistArray ) . "'";
        $whitelist .= "{'value': 'working', color: 'pink', style: '--tag-bg:pink'},{'value': 'great', 'color': 'yellow'}";
        return $whitelist;
    }

    public function render()
    {
        return view('livewire-easy-tags::livewire.livewire-easy-tags');
    }
}
