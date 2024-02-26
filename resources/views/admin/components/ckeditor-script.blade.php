<script>
    const editor = document.querySelector('#editor');
    if (editor) {
        const watchdog = new CKSource.EditorWatchdog();

        window.watchdog = watchdog;

        watchdog.setCreator((element, config) => {
            return CKSource.Editor
                .create(element, config)
                .then(editor => {
                    return editor;
                });
        });

        watchdog.setDestructor(editor => {
            return editor.destroy();
        });

        watchdog
            .create(editor)
    }

    const editorFree = document.querySelector('#editor-free');
    if (editorFree) {
        const watchdog = new CKSource.EditorWatchdog();

        window.watchdog = watchdog;

        watchdog.setCreator((element, config) => {
            return CKSource.Editor
                .create(element, config)
                .then(editorFree => {
                    return editorFree;
                });
        });

        watchdog.setDestructor(editorFree => {
            return editorFree.destroy();
        });

        watchdog
            .create(editorFree)
    }
</script>
