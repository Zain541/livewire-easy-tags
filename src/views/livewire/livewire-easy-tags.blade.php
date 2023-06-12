<div wire:ignore>
    <div wire:key='{{ $componentKey }}' x-data="{
        tagify: null,
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
    
    
                this.tagify.on('add', onAddTag)
                    .on('remove', onRemoveTag)
                    .on('edit:updated', onTagEdit);
    
    
    
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
    </div>

</div>
