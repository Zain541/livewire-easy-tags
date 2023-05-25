<div>
    <div x-data="{
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
            })
        }
    }">
        <input type="text" x-ref="tagInput">
    </div>
</div>
