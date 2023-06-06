<div wire:ignore>
    <div wire:key='{{$componentKey}}' x-data="{
        tagify: null,
        tagInput: null,
        initTagify: function() {
            return new Tagify(this.tagInput, {
                // Tagify options
                // ...
            });
        },
        init() {
            this.$nextTick(() => {

              this.tagInput = this.$refs.tagInput;
              this.tagify = this.initTagify();
              this.tagify.on('add', onAddTag)
                .on('remove', onRemoveTag)
                .on('edit:updated', onTagEdit);


                function onAddTag(e)
                {
                    Livewire.emit('addNewTagEvent', e.detail.tagify.value);
                }

                function onRemoveTag(e)
                {
                    Livewire.emit('removeTagEvent', e.detail.data);
                }

                function onTagEdit(e)
                {
                    Livewire.emit('editTagEvent', e.detail.data);
                }
            });
        }
    }">
        <input type="text" x-ref="tagInput" value="{{ $this->getUserTags() }}">
    </div>
</div>