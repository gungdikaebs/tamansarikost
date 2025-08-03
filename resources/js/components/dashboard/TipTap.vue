<script setup>
import { defineProps, ref, watch, onBeforeUnmount } from 'vue'
import { useEditor, EditorContent } from '@tiptap/vue-3'
import StarterKit from '@tiptap/starter-kit'
import Underline from '@tiptap/extension-underline'

import BoldIcon from 'vue-material-design-icons/FormatBold.vue'
import ItalicIcon from 'vue-material-design-icons/FormatItalic.vue'
import UnderlineIcon from 'vue-material-design-icons/FormatUnderline.vue'
import Header1 from 'vue-material-design-icons/FormatHeader1.vue'
import Header2 from 'vue-material-design-icons/FormatHeader2.vue'
import Header3 from 'vue-material-design-icons/FormatHeader3.vue'
import OrderedList from 'vue-material-design-icons/FormatListNumbered.vue'
import BulletList from 'vue-material-design-icons/FormatListBulleted.vue'

const props = defineProps({
    modelValue: String
})
const emit = defineEmits(['update:modelValue'])

const content = ref(props.modelValue)

const editor = useEditor({
    editorProps: {
        attributes: {
            class: 'border border-gray-400 p-4 min-h-[12rem] max-h-[12rem] outline-none max-w-none prose overflow-y-auto prose-sm prose-gray prose-p:my-2 prose-p:leading-relaxed prose-pre:bg-gray-100 prose-pre:p-2 prose-pre:rounded-lg',
        },
    },
    content: content.value,
    extensions: [
        StarterKit,
        Underline,
    ],
    onUpdate: ({ editor }) => {
        content.value = editor.getHTML()
        emit('update:modelValue', content.value)
    }
})

// Optional: bersihkan editor saat komponen diunmount
onBeforeUnmount(() => {
    if (editor) {
        editor.destroy()
    }
})

watch(() => props.modelValue, (value) => {
    if (value !== content.value) {
        content.value = value
        editor?.commands.setContent(value, false)
    }
})
</script>

<template>
    <section v-if="editor" class="container mx-auto p-4">
        <div class="control-group mb-4">
            <div class="button-group flex flex-wrap gap-4 border border-gray-400 rounded p-3 items-center">
                <button @click="editor.chain().focus().toggleBold().run()"
                    :disabled="!editor.can().chain().focus().toggleBold().run()"
                    :class="['p-2 rounded transition-colors duration-150', editor.isActive('bold') ? 'bg-blue-600 text-white' : 'hover:bg-gray-200']"
                    title="Bold">
                    <BoldIcon class="w-5 h-5" />
                </button>

                <button @click="editor.chain().focus().toggleItalic().run()"
                    :disabled="!editor.can().chain().focus().toggleItalic().run()"
                    :class="['p-2 rounded transition-colors duration-150', editor.isActive('italic') ? 'bg-blue-600 text-white' : 'hover:bg-gray-200']"
                    title="Italic">
                    <ItalicIcon class="w-5 h-5" />
                </button>

                <button @click="editor.chain().focus().toggleUnderline().run()"
                    :disabled="!editor.can().chain().focus().toggleUnderline().run()"
                    :class="['p-2 rounded transition-colors duration-150', editor.isActive('underline') ? 'bg-blue-600 text-white' : 'hover:bg-gray-200']"
                    title="Underline">
                    <UnderlineIcon class="w-5 h-5" />
                </button>

                <button type="button" @click="editor.chain().focus().toggleHeading({ level: 1 }).run()"
                    :class="['p-2 rounded transition-colors duration-150', editor.isActive('heading', { level: 1 }) ? 'bg-blue-600 text-white' : 'hover:bg-gray-200']"
                    title="Heading 1">
                    <Header1 class="w-5 h-5" />
                </button>

                <button type="button" @click="editor.chain().focus().toggleHeading({ level: 2 }).run()"
                    :class="['p-2 rounded transition-colors duration-150', editor.isActive('heading', { level: 2 }) ? 'bg-blue-600 text-white' : 'hover:bg-gray-200']"
                    title="Heading 2">
                    <Header2 class="w-5 h-5" />
                </button>

                <button type="button" @click="editor.chain().focus().toggleHeading({ level: 3 }).run()"
                    :class="['p-2 rounded transition-colors duration-150', editor.isActive('heading', { level: 3 }) ? 'bg-blue-600 text-white' : 'hover:bg-gray-200']"
                    title="Heading 3">
                    <Header3 class="w-5 h-5" />
                </button>

                <button @click="editor.chain().focus().toggleBulletList().run()"
                    :class="['p-2 rounded transition-colors duration-150', editor.isActive('bulletList') ? 'bg-blue-600 text-white' : 'hover:bg-gray-200']"
                    title="Bullet List">
                    <BulletList class="w-5 h-5" />
                </button>

                <button @click="editor.chain().focus().toggleOrderedList().run()"
                    :class="['p-2 rounded transition-colors duration-150', editor.isActive('orderedList') ? 'bg-blue-600 text-white' : 'hover:bg-gray-200']"
                    title="Ordered List">
                    <OrderedList class="w-5 h-5" />
                </button>
            </div>
        </div>

        <EditorContent :editor="editor" />

        <!-- Contoh menampilkan konten HTML yang sedang ditulis -->
        <textarea class="mt-4 w-full h-24 border p-2" readonly :value="content"></textarea>
    </section>
</template>
