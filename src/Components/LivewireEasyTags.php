<?php

namespace LivewireEasyTags\Components;

use Livewire\Component;
use Spatie\Tags\Tag;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;
use Illuminate\Http\JsonResponse;

class LivewireEasyTags extends Component
{
    public $componentKey;
    public $modelClass;
    public $modelId;
    public $modelCollection;

    public function mount()
    {
        $modelObject = new $this->modelClass;
        $this->modelCollection = $modelObject->find($this->modelId);
        $this->componentKey = rand(1, 1000000) . microtime(true);
    }

    protected function getListeners()
    {
        return [
            'addNewTagEvent' => 'addNewTag',
            'removeTagEvent' => 'removeTag',
            'editTagEvent' => 'editTag',
            'deleteTagEvent' => 'deleteTag',
            'changeColorTagEvent' => 'changeColorTag'
        ];
    }

    public function parentConfigurations() : array
    {

        $configurationKeys = ['colors', 'default_color'];
        $configurations = $this->configurations();
        $prepareFinalConfigurations = [];
        foreach($configurationKeys as $configurationKey)
        {
            if(isset($configurations[$configurationKey]) && $configurations[$configurationKey] != '' && $configurations[$configurationKey] != null)
            {
                if($configurationKey == 'colors')
                {
                    if(is_array($configurations[$configurationKey]) && count($configurations[$configurationKey]) > 0)
                    {

                        $prepareFinalConfigurations[$configurationKey] = $configurations[$configurationKey];
                    }
                }
                else
                {
                    $prepareFinalConfigurations[$configurationKey] = $configurations[$configurationKey];
                }
            }
            else
            {
                $prepareFinalConfigurations[$configurationKey] = config('livewire-easy-tags')[$configurationKey];
            }
        }
        return $prepareFinalConfigurations;
    }

    protected function configurations(): array
    {
       return [];
    }


    public function addNewTag($tagArray)
    {
        $this->modelCollection->syncTagsWithType(array_column($tagArray, 'value'), 'firstType');
    }

    public function changeColorTag($tag, $tagType, $color) : void
    {
        Tag::where(['type' => $tagType, 'name->en' => $tag])->update(['color' => $color]);
    }

    public function deleteTag($tagId)
    {
        Tag::whereId($tagId)->delete();
    }

    /**
     * Get model tags of the first type.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getModelTags(): Collection
    {
        // Retrieve the tags with the specified type
        $tags = $this->modelCollection->tags()->where('type', 'firstType')->get();

        // Map the tags to the desired format
        $mappedTags = $tags->map(function ($tag) {
            return [
                'id' => $tag->id,
                'value' => $tag->name,
                'type' => $tag->type,
                'color' => $tag->color == null ? 'lightgray' : $tag->color,
            ];
        });

        // Return the mapped tags
        return $mappedTags;
    }

    public function removeTag($tagsArray) : void
    {
        $this->modelCollection->detachTag($tagsArray['value'], 'firstType');
    }


    /**
     * Edit a tag.
     *
     * @param  array  $objectToBeArray The array containing the tag data.
     * @return void
     */
    public function editTag(array $objectToBeArray): void
    {
        // Find the tag by ID and type
        $record = Tag::whereType('firstType')->whereId($objectToBeArray['id'])->first();

        // Update the tag
        $record->name = $objectToBeArray['value'];
        $record->save();
    }
    public function prepareWhitelist()
    {

        // Retrieve the tags with the specified type
        $tags = Tag::where('type', 'firstType')->get();

        $mappedTags = $tags->map(function ($tag) {
            return [
                'id' => $tag->id,
                'value' => $tag->name,
                'type' => $tag->type,
                'color' => $tag->color
            ];
        });

        $data = json_decode($mappedTags, true);
        $convertedArray = array_map(function ($item) {
            $tagColor = $item['color'] == null ? 'lightgray' : $item['color'];
            return "{'id': {$item['id']}, 'value': '{$item['value']}', 'color': '{$tagColor}'}";
        }, $data);
        $result = implode(',', $convertedArray);
        return $result;
    }

    public function prepareTransformTag()
    {
        $tags = Tag::get();
        $whitelist = '';
        $whitelistArray = [];
        foreach ($tags as $tag) {
            $whitelistArray[] = $tag->name;
        }
        $whitelist .= "{'value': 'working', color: 'pink', style: '--tag-bg:pink'},{'value': 'great', 'color': 'yellow'}";
        return $whitelist;
    }

    public function render()
    {
        return view('livewire-easy-tags::livewire.livewire-easy-tags');
    }
}
