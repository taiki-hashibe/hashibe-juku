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
            .create(editor, {
                codeBlock: {
                    languages: [{
                            language: 'plaintext',
                            label: 'Plain text'
                        },
                        {
                            language: 'c',
                            label: 'C'
                        },
                        {
                            language: 'cs',
                            label: 'C#'
                        },
                        {
                            language: 'cpp',
                            label: 'C++'
                        },
                        {
                            language: 'css',
                            label: 'CSS',
                            class: 'css'
                        },
                        {
                            language: 'diff',
                            label: 'Diff'
                        },
                        {
                            language: 'html',
                            label: 'HTML',
                            class: 'html'
                        },
                        {
                            language: 'blade',
                            label: 'Blade',
                            class: 'blade laravel-blade'
                        },
                        {
                            language: 'java',
                            label: 'Java'
                        },
                        {
                            language: 'javascript',
                            label: 'JavaScript',
                            class: 'javascript js'
                        },
                        {
                            language: 'php',
                            label: 'PHP',
                            class: 'php'
                        },
                        {
                            language: 'python',
                            label: 'Python'
                        },
                        {
                            language: 'ruby',
                            label: 'Ruby'
                        },
                        {
                            language: 'typescript',
                            label: 'TypeScript',
                            class: 'typescript ts'
                        },
                        {
                            language: 'xml',
                            label: 'XML'
                        },
                    ]
                }
            })
    }
</script>
