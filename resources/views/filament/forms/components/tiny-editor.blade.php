<x-dynamic-component :component="$getFieldWrapperView()" :id="$getId()" :label="$getLabel()" :label-sr-only="$isLabelHidden()" :helper-text="$getHelperText()"
    :hint="$getHint()" :hint-action="$getHintAction()" :hint-color="$getHintColor()" :hint-icon="$getHintIcon()" :required="$isRequired()" :state-path="$getStatePath()">
    <div wire:ignore x-data="{
        state: $wire.entangle('{{ $getStatePath() }}'),
        setup() {
            const options = {
                    selector: '#tiny-editor-{{ $getId() }}',
                    height: 500,
                    menubar: true,
                    plugins: [
                        '{{ $getPlugins() }}'
                    ],
                    toolbar: '{{ $getToolbarButtonsString() }}',
                    file_picker_types: 'image',
                    automatic_uploads: true,
                    images_upload_handler: (blobInfo, progress) => new Promise((resolve, reject) => {
                                const xhr = new XMLHttpRequest();
                                xhr.withCredentials = false;
                                xhr.open('POST', '{{ route('tinymce.upload') }}');
                                xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content')); xhr.upload.onprogress=(e)=> {
        progress(e.loaded / e.total * 100);
        };

        xhr.onload = () => {
        if (xhr.status === 403) {
        reject({ message: 'HTTP Error: ' + xhr.status, remove: true });
        return;
        }

        if (xhr.status < 200 || xhr.status>= 300) {
            reject('HTTP Error: ' + xhr.status);
            return;
            }

            const json = JSON.parse(xhr.responseText);

            if (!json || typeof json.location != 'string') {
            reject('Invalid JSON: ' + xhr.responseText);
            return;
            }

            resolve(json.location);
            };

            xhr.onerror = () => {
            reject('Image upload failed due to a XHR Transport error. Code: ' + xhr.status);
            };

            const formData = new FormData();
            formData.append('file', blobInfo.blob(), blobInfo.filename());

            xhr.send(formData);
            }),
            setup: function(editor) {
            editor.on('init', function(e) {
            editor.setContent(state);
            });
            editor.on('change', function(e) {
            state = editor.getContent();
            });
            editor.on('blur', function(e) {
            state = editor.getContent();
            });
            }
            };

            tinymce.init(Object.assign(options, {{ $getOptionsString() }}));
            }
            }"
            x-init="setup()"
            {{ $getExtraInputAttributeBag()->class(['block w-full transition duration-75 rounded-lg shadow-sm focus:border-primary-500 focus:ring-1 focus:ring-inset focus:ring-primary-500 disabled:opacity-70']) }}
            >
            <textarea id="tiny-editor-{{ $getId() }}" placeholder="{{ $getPlaceholder() }}" {{ $getExtraInputAttributeBag() }}
                {{ $applyStateBindingModifiers('wire:model') }}="{{ $getStatePath() }}"></textarea>
    </div>
</x-dynamic-component>
