import { Plugin } from '@ckeditor/ckeditor5-core';
import { ButtonView } from '@ckeditor/ckeditor5-ui';

export default class PublishLevelUI extends Plugin {
    customPluginName = 'PublishLevel';
    buttonLabel = '会員限定';
    buttonIcon = '';
	abbrTitle = 'publish-level';
	init() {
		const editor = this.editor;

        // Register the button in the editor's UI component factory.
		editor.ui.componentFactory.add( this.customPluginName, () => {
			const button = new ButtonView();

			button.label = this.buttonLabel;
            button.icon = this.buttonIcon;
			button.tooltip = true;
			button.withText = true;

			this.listenTo( button, 'execute', () => {
				const title = this.abbrTitle;

				// Change the model to insert the abbreviation.
				editor.model.change( writer => {
					editor.model.insertContent(
						// Create a text node with the abbreviation attribute.
						writer.createText( '-', { abbreviation: title } )
					);
				} );
			} );

			return button;
		} );
	}
}
