import { Editor } from '@tiptap/core'
import StarterKit from '@tiptap/starter-kit'
import Link from '@tiptap/extension-link'


window.setupEditor = function() {
    return {
        editor: null,
        updatedAt: Date.now(),
        init(element) {
            this.editor = new Editor({
                element: element,
                extensions: [
                    StarterKit,
                    Link.configure({
                        openOnClick: false,
                        autolink: false,
                    }),
                ],
                content: this.content,
                onUpdate: ({ editor }) => {
                    this.content = editor.getHTML()
                    this.updatedAt = Date.now()
                },
                onSelectionUpdate: () => {
                    this.updatedAt = Date.now()
                }
            })
        },
    }
}
