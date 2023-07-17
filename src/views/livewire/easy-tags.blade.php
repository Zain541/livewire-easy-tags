<div wire:ignore class="p-3">
    <div style="position:relative" wire:key='{{ $componentKey }}' x-data="{
        tagify: null,
        openDropdown: false,
        defaultColor: 'lightgray',
        activeTag: null,
        tagInput: null,
        whitelist: [],
        transformTag: function(tagData, color = '') {
            color = this.defaultColor;
            if (tagData.hasOwnProperty('color')) {
                color = tagData.color;
            }
            tagData.style = '--tag-bg:' + color;
        },
        initTagify: function() {
            return new Tagify(this.tagInput, {
                whitelist: [],
                transformTag: this.transformTag,
                dropdown: {
                    enabled: 0
                }
            });
        },
        toggle: function() {
            if (this.openDropdown) {
                return this.close()
            }
            this.openDropdown = true
        },
        changeColor: function(color) {
            const { tag: tagElm, data: tagData } = this.activeTag;
            tagData.color = color;
            tagData.style = '--tag-bg:' + tagData.color;
            this.tagify.replaceTag(tagElm, tagData);
            this.openDropdown = false;
            Livewire.emit('changeColorTagEvent', this.activeTag.data.id, color);
        },
        deleteTag: function() {
            Livewire.emit('deleteTagEvent', this.activeTag.data.id);
            this.tagify.removeTags(this.activeTag.data.value)
            this.tagify.whitelist = this.tagify.whitelist.filter(item => item.id != this.activeTag.id);
            this.openDropdown = false;
        },
        close: function() {
            if (!this.openDropdown) return
            this.openDropdown = false
        },
    
        init() {
            this.$nextTick(() => {
    
                this.tagInput = this.$refs.tagInput;
                this.tagify = this.initTagify();
                this.whitelist = [{!! $this->prepareWhitelist() !!}];
                this.tagify.whitelist = this.whitelist;
    
                let onTagEdit = (e) => {
                    var updatedValue = e.detail.data.value;
                    var updatedTagId = e.detail.data.id;
                    var oldValue = e.detail.previousData.__originalData.value;
                    this.tagify.whitelist[this.tagify.whitelist.indexOf(oldValue)] = updatedValue;
                    Livewire.emit('editTagEvent', e.detail.data);
                    this.tagify.whitelist = this.tagify.whitelist.map(item => {
                        if (item.id === updatedTagId) {
                            return { ...item, value: updatedValue };
                        }
                        return item;
                    });
    
                }
                let onTagClick = (e) => {
                    this.activeTag = e.detail;
                    this.toggle();
                }
    
                let onAddTag = (e) => {
                    Livewire.emit('addNewTagEvent', e.detail.tagify.value);
                    this.tagify.whitelist.push({ 'value': e.detail.data.value, 'color': this.defaultColor });
                }
    
                let onRemoveTag = (e) => {
                    Livewire.emit('removeTagEvent', e.detail.data);
                }
    
                this.tagify.on('add', onAddTag)
                    .on('remove', onRemoveTag)
                    .on('edit:updated', onTagEdit)
                    .on('click', onTagClick);
    
            });
        }
    }">

        <input type="text" x-ref="tagInput" value='{{ $this->getModelTags() }}'>
        <div x-ref="panel" x-show="openDropdown" x-transition.origin.top.left x-on:click.outside="close()"
            style="display: none;" class="absolute left-0 mt-2 w-40 rounded-md bg-white shadow-md">
            <!-- Added flex and flex-col classes -->
            <a x-on:click="deleteTag()"
                class="flex cursor-pointer items-center gap-2 w-full first-of-type:rounded-t-md last-of-type:rounded-b-md px-4 py-2.5 text-left text-sm hover:bg-gray-200 disabled:text-gray-500">
                Delete
            </a>
            <div class="flex pl-2 pb-2">
                <div x-on:click="changeColor('pink')" class="cursor-pointer ml-1 color-container"
                    style="background: pink; ">

                </div>
                <div x-on:click="changeColor('lightgreen')" class="cursor-pointer ml-1 color-container"
                    style="background: lightgreen;">

                </div>
            </div>

            <!-- Add more flex items here -->
        </div>
    </div>

    <style>
        .color-container {
            width: 30px;
            height: 30px;
            border-radius: 50%;
        }
    </style>
{{ $this->colors() }}

</div>
