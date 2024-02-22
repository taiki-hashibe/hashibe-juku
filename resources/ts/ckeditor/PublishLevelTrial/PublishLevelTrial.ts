import Plugin from '@ckeditor/ckeditor5-core/src/plugin';
import PublishLevelEditing from '../PublishLevel/PublishLevelEditing';
import PublishLevelUI from '../PublishLevel/PublishLevelUI';
import { Editor } from '@ckeditor/ckeditor5-core';

class PublishLevelTrialUI extends PublishLevelUI {
    constructor( editor: Editor ) {
        super( editor );
        this.customPluginName = 'PublishLevelTrial';
        this.buttonLabel = '会員限定';
        this.buttonIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0Zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4Zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10Z"/></svg>';
        this.abbrTitle = 'publish-level:trial';
    }
}

export class PublishLevelTrial extends Plugin {
    static get requires() {
        return [ PublishLevelEditing, PublishLevelTrialUI ];
    }
}
