<div wire:ignore class="p-3">
    <div style="position:relative" wire:key='{{ $componentKey }}' x-data="{
        tagify: null,
        open: false,
        toggle: function() {
            if (this.open) {
                return this.close()
            }
            this.open = true
        },
        close: function() {
            if (!this.open) return
            this.open = false
        },
        tagInput: null,
        whitelist: [],
        initTagify: function() {
            function transformTag(tagData) {
                tagData.style = '--tag-bg:' + tagData.color;
    
            }
    
            return new Tagify(this.tagInput, {
                whitelist: [],
                transformTag: transformTag,
                dropdown: {
                    enabled: 0
                }
            });
        },
        init() {
            this.$nextTick(() => {
    
    
    
                this.tagInput = this.$refs.tagInput;
                this.tagify = this.initTagify();
                this.whitelist = [{!! $this->prepareWhitelist() !!}];
                this.tagify.whitelist = this.whitelist;
                //console.log(this.tagify.tagData);
    
                //this.tagify.addTags([{value:'banana', color:'yellow'}, {value:'apple', color:'red'}, {value:'watermelon', color:'green'}])
    
    
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
    
                    this.toggle();
                }
    
                this.tagify.on('add', onAddTag)
                    .on('remove', onRemoveTag)
                    .on('edit:updated', onTagEdit)
                    .on('click', onTagClick);
    
    
    
    
                function onAddTag(e) {
                    Livewire.emit('addNewTagEvent', e.detail.tagify.value);
                }
    
                function onRemoveTag(e) {
                    Livewire.emit('removeTagEvent', e.detail.data);
                }
    
    
            });
        }
    }">

        <input type="text" x-ref="tagInput" value='{{ $this->getUserTags() }}'>
        <div x-ref="panel" x-show="open" x-transition.origin.top.left x-on:click.outside="close()"
            style="display: none;"
            class="absolute left-0 mt-2 w-40 rounded-md bg-white shadow-md">
            <a x-on:click="close()"
                class="flex cursor-pointer items-center gap-2 w-full first-of-type:rounded-t-md last-of-type:rounded-b-md px-4 py-2.5 text-left text-sm hover:bg-gray-200 disabled:text-gray-500">
                Delete
            </a>
        </div>
    </div>




</div>
