<div wire:ignore class="p-3">
    @php
        $configuration = $this->prepareConfigurations();
    @endphp
    <div style="position:relative" wire:key='{{ $componentKey }}' x-data="{
        tagify: null,
        openDropdown: false,
        defaultColor: '{{ $configuration['default_color'] }}',
        activeTag: null,
        tagInput: null,
        whitelist: [],

        initTagify: function() {

            let transformTag = (tagData) => {
                var color = this.defaultColor;
                if (tagData.hasOwnProperty('color')) {
                    color = tagData.color;
                }
                tagData.style = '--tag-bg:' + color;

            }
            return new Tagify(this.tagInput, {
                whitelist: [],
                transformTag: transformTag,
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
            Livewire.emit('changeColorTagEvent', this.activeTag.data.value, this.activeTag.data.type, color);
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
        <div x-ref="panel" class="tagify__dropdown tagify__dropdown--text absolute left-0 mt-2 px-2 rounded-md" x-show="openDropdown" x-transition.origin.top.left x-on:click.outside="close()"
            style="display: none; !important;" class="">
            <!-- Added flex and flex-col classes -->
            <div class="tagify__dropdown__item flex cursor-pointer px-4 py-2.5 my-1 text-left text-sm hover:bg-gray-200 disabled:text-gray-500 items-center">
                <a x-on:click="deleteTag()"
                    class="gap-2 w-full first-of-type:rounded-t-md last-of-type:rounded-b-md mb-2">
                    Delete
                </a>
            </div>

            <div class="flex pl-2 pb-2 my-3" style="flex-wrap: wrap; margin-bottom: 10px">
                @foreach ($configuration['colors'] as $color)
                    <div x-on:click="changeColor('{{ $color }}')" class="cursor-pointer ml-1 mb-1 color-container"
                    style="background: {{ $color }};"></div>
                @endforeach
            </div>


            <!-- Add more flex items here -->
        </div>
    </div>

    <style>
        .color-container {
            width: 35px;
            height: 35px;
            border-radius: 50%;
        }
        .tagify__dropdown{
            background-color: #ffffff;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
        }
    </style>


</div>

