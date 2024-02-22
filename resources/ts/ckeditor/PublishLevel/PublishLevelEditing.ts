import { Plugin } from '@ckeditor/ckeditor5-core';
import "./theme/publishLevelMembership.css";
import "./theme/publishLevelTrial.css";

export default class PublishLevelEditing extends Plugin {
    init() {
        this._defineSchema();
        this._defineConverters();
    }

    _defineSchema() {
        const schema = this.editor.model.schema;

        schema.extend( '$text', {
            allowAttributes: [ 'abbreviation' ]
        } );
    }

    _defineConverters() {
        const conversion = this.editor.conversion;

        conversion.for( 'downcast' ).attributeToElement( {
            model: 'abbreviation',
            view: ( modelAttributeValue, conversionApi ) => {
                const { writer } = conversionApi;

                return writer.createAttributeElement( 'abbr', {
                    title: modelAttributeValue
                } );
            }
        } );

        conversion.for( 'upcast' ).elementToAttribute( {
            view: {
                name: 'abbr',
                attributes: [ 'title' ]
            },
            model: {
                key: 'abbreviation',
                // Callback function provides access to the view element.
                value: ( viewElement: HTMLElement) => {
                    const title = viewElement.getAttribute( 'title' );

                    return title;
                }
            }
        } );
    }
}
