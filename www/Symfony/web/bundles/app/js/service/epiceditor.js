var opts = {
    container: 'epiceditor',
    textarea: 'article_article_extend_markdown',
    basePath: '',
    clientSideStorage: false,
    localStorageName: 'epiceditor',
    useNativeFullscreen: true,
    parser: marked,
    file: {
        name: 'epiceditor',
        defaultContent: '',
        autoSave: false
    },
    theme: {
        base: '/web/bundles/vendor/bower_components/EpicEditor/epiceditor/themes/base/epiceditor.css',
        preview: '/web/bundles/app/css/services/epiceditor/preview.css',
        editor: '/web/bundles/app/css/services/epiceditor/epic-dark.css'
    },
    button: {
        preview: true,
        fullscreen: true,
        bar: "show"
    },
    focusOnLoad: false,
    shortcut: {
        modifier: 18,
        fullscreen: 70,
        preview: 80
    },
    string: {
        togglePreview: epicEditor.togglePreview,
        toggleEdit: epicEditor.toggleEdit,
        toggleFullscreen: epicEditor.toggleFullscreen
    },
    autogrow: false
}

var editor;

$(document).ready(function() { editor = new EpicEditor(opts).load() });
