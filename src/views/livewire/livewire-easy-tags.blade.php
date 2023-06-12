<div wire:ignore>
    <div wire:key='{{$componentKey}}' x-data="{
        tagify: null,
        tagInput: null,
        whitelist: [],
        initTagify: function() {
            function transformTag( tagData ){
               console.log(tagData);
               tagData.style = '--tag-bg:' + tagData.color;
                
            }
            
            return new Tagify(this.tagInput, {
                whitelist: [],
                transformTag: transformTag,
                dropdown : {
                    enabled : 0
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
                    var oldValue = e.detail.previousData.__originalData.value;
                    console.log(this.tagify.whitelist);
                    this.tagify.whitelist[this.tagify.whitelist.indexOf(oldValue)] = updatedValue;
                    console.log(this.tagify.whitelist);
                    Livewire.emit('editTagEvent', oldValue, updatedValue);
                }

              
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

                
            });
        }
    }">
        <input type="text" x-ref="tagInput" value='{{ $this->getUserTags() }}'>
    </div>

</div>