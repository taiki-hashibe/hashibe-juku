/**
 * @license Copyright (c) 2014-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

import { ClassicEditor } from "@ckeditor/ckeditor5-editor-classic";

import { Alignment } from "@ckeditor/ckeditor5-alignment";
import { Autoformat } from "@ckeditor/ckeditor5-autoformat";
import { Autosave } from "@ckeditor/ckeditor5-autosave";
import {
    Bold,
    Code,
    Italic,
    Strikethrough,
    Subscript,
    Superscript,
} from "@ckeditor/ckeditor5-basic-styles";
import { BlockQuote } from "@ckeditor/ckeditor5-block-quote";
import { CodeBlock } from "@ckeditor/ckeditor5-code-block";
import type { EditorConfig } from "@ckeditor/ckeditor5-core";
import { Essentials } from "@ckeditor/ckeditor5-essentials";
import {
    FontBackgroundColor,
    FontColor,
    FontSize,
} from "@ckeditor/ckeditor5-font";
import { Heading } from "@ckeditor/ckeditor5-heading";
import { Highlight } from "@ckeditor/ckeditor5-highlight";
import { HorizontalLine } from "@ckeditor/ckeditor5-horizontal-line";
import { HtmlEmbed } from "@ckeditor/ckeditor5-html-embed";
import {
    DataFilter,
    DataSchema,
    GeneralHtmlSupport,
    HtmlComment,
} from "@ckeditor/ckeditor5-html-support";
import {
    Image,
    ImageCaption,
    ImageInsert,
    ImageResize,
    ImageStyle,
    ImageToolbar,
} from "@ckeditor/ckeditor5-image";
import { TextPartLanguage } from "@ckeditor/ckeditor5-language";
import { AutoLink, Link, LinkImage } from "@ckeditor/ckeditor5-link";
import { List, ListProperties } from "@ckeditor/ckeditor5-list";
import { MediaEmbed, MediaEmbedToolbar } from "@ckeditor/ckeditor5-media-embed";
import { Paragraph } from "@ckeditor/ckeditor5-paragraph";
import { RemoveFormat } from "@ckeditor/ckeditor5-remove-format";
import { SelectAll } from "@ckeditor/ckeditor5-select-all";
import { ShowBlocks } from "@ckeditor/ckeditor5-show-blocks";
import {
    Table,
    TableCaption,
    TableCellProperties,
    TableColumnResize,
    TableProperties,
    TableToolbar,
} from "@ckeditor/ckeditor5-table";
import { TextTransformation } from "@ckeditor/ckeditor5-typing";
import { Undo } from "@ckeditor/ckeditor5-undo";
import { Base64UploadAdapter } from "@ckeditor/ckeditor5-upload";
import { EditorWatchdog } from "@ckeditor/ckeditor5-watchdog";
import { PublishLevelTrial } from "./ckeditor/PublishLevelTrial/PublishLevelTrial";
import { PublishLevelMembership } from "./ckeditor/PublishLevelMembership/PublishLevelMembership";

// You can read more about extending the build with additional plugins in the "Installing plugins" guide.
// See https://ckeditor.com/docs/ckeditor5/latest/installation/plugins/installing-plugins.html for details.
class Editor extends ClassicEditor {
    public static override builtinPlugins = [
        Alignment,
        AutoLink,
        Autoformat,
        Autosave,
        Base64UploadAdapter,
        BlockQuote,
        Bold,
        Code,
        CodeBlock,
        DataFilter,
        DataSchema,
        Essentials,
        FontBackgroundColor,
        FontColor,
        FontSize,
        GeneralHtmlSupport,
        Heading,
        Highlight,
        HorizontalLine,
        HtmlComment,
        HtmlEmbed,
        Image,
        ImageCaption,
        ImageInsert,
        ImageResize,
        ImageStyle,
        ImageToolbar,
        Italic,
        Link,
        LinkImage,
        List,
        ListProperties,
        MediaEmbed,
        MediaEmbedToolbar,
        Paragraph,
        PublishLevelTrial,
        PublishLevelMembership,
        RemoveFormat,
        SelectAll,
        ShowBlocks,
        Strikethrough,
        Subscript,
        Superscript,
        Table,
        TableCaption,
        TableCellProperties,
        TableColumnResize,
        TableProperties,
        TableToolbar,
        TextPartLanguage,
        TextTransformation,
        Undo,
    ];

    public static override defaultConfig: EditorConfig = {
        toolbar: {
            items: [
                "heading",
                "|",
                "bold",
                "italic",
                "link",
                "bulletedList",
                "numberedList",
                "|",
                "outdent",
                "indent",
                "|",
                "blockQuote",
                "insertTable",
                "mediaEmbed",
                "undo",
                "redo",
                "alignment",
                "code",
                "codeBlock",
                "findAndReplace",
                "fontBackgroundColor",
                "fontColor",
                "fontSize",
                "highlight",
                "horizontalLine",
                "imageInsert",
                "removeFormat",
                "selectAll",
                "showBlocks",
                "style",
                "strikethrough",
                "subscript",
                "superscript",
                "PublishLevel",
                "PublishLevelTrial",
                "publishLevelMembership"
            ],
        },
        language: "ja",
        image: {
            toolbar: [
                "imageTextAlternative",
                "toggleImageCaption",
                "imageStyle:inline",
                "imageStyle:block",
                "imageStyle:side",
                "linkImage",
            ],
        },
        table: {
            contentToolbar: [
                "tableColumn",
                "tableRow",
                "mergeTableCells",
                "tableCellProperties",
                "tableProperties",
            ],
        },
    };
}

export default { Editor, EditorWatchdog };
